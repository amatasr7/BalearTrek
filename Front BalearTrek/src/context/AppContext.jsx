import { createContext, useState, useEffect, useCallback } from "react";

export const AppContext = createContext();

const API_URL = import.meta.env.VITE_API_URL || "http://localhost:8000";

export function AppProvider({ children }) {
  const [activeView, setActiveView] = useState("home");
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(false);
  const [token, setToken] = useState(localStorage.getItem("token") || null);
  const [error, setError] = useState(null);

  // Filtros y paginación
  const [filters, setFilters] = useState({});
  const [pagination, setPagination] = useState({
    pagina_actual: 1,
    total_paginas: 1,
    total_items: 0,
    items_por_pagina: 10,
  });

  // Función para actualizar la vista
  const changeView = useCallback((viewId) => {
    setActiveView(viewId);
    setError(null);
    setFilters({}); // Reset filters al cambiar de vista
    setPagination({
      pagina_actual: 1,
      total_paginas: 1,
      total_items: 0,
      items_por_pagina: 10,
    });
  }, []);

  // Función para actualizar filtros
  const updateFilters = useCallback(
    (newFilters) => {
      setFilters(newFilters);
      setPagination({ ...pagination, pagina_actual: 1 }); // Reset a página 1
    },
    [pagination],
  );

  // Función para cambiar de página
  const changePage = useCallback(
    (newPage) => {
      setPagination({ ...pagination, pagina_actual: newPage });
    },
    [pagination],
  );

  // Función para hacer logout
  const logout = useCallback(() => {
    setToken(null);
    localStorage.removeItem("token");
    setActiveView("home");
    setData([]);
  }, []);

  // Función para hacer login (después del registro)
  const setUserToken = useCallback((newToken) => {
    setToken(newToken);
    localStorage.setItem("token", newToken);
  }, []);

  // Efecto para cargar datos quando cambia la vista, filtros o página
  useEffect(() => {
    // Si estamos en home, auth o contacto, no pedimos datos de la API
    if (
      activeView === "home" ||
      activeView === "auth" ||
      activeView === "contact" ||
      activeView === "more-info"
    ) {
      setData([]);
      return;
    }

    const fetchData = async () => {
      setLoading(true);
      setError(null);

      try {
        const headers = {
          Accept: "application/json",
          "Content-Type": "application/json",
        };

        if (token) {
          headers["Authorization"] = `Bearer ${token}`;
        }

        // Construir URL con parámetros
        const params = new URLSearchParams();
        Object.keys(filters).forEach((key) => {
          if (filters[key]) {
            params.append(key, filters[key]);
          }
        });
        params.append("pagina", pagination.pagina_actual);
        params.append("limite", pagination.items_por_pagina);

        const apiUrl = `${API_URL}/api/${activeView}?${params.toString()}`;
        const response = await fetch(apiUrl, { headers });

        if (response.status === 401) {
          throw new Error("No autorizado. Por favor, regístrate.");
        }

        if (!response.ok) {
          throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        const json = await response.json();
        const items = json.data || json;
        setData(Array.isArray(items) ? items : []);

        // Actualizar info de paginación si existe
        if (json.pagination) {
          setPagination(json.pagination);
        }
      } catch (err) {
        console.error("Error cargando datos:", err);
        setError(err.message);
        setData([]);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [activeView, token, filters, pagination.pagina_actual]);

  const value = {
    // Estado
    activeView,
    data,
    loading,
    token,
    error,
    isAuthenticated: !!token,
    filters,
    pagination,

    // Acciones
    changeView,
    logout,
    setUserToken,
    updateFilters,
    changePage,
  };

  return <AppContext.Provider value={value}>{children}</AppContext.Provider>;
}
