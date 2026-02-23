import { createContext, useState, useEffect, useCallback } from "react";

export const AppContext = createContext();

const API_URL = import.meta.env.VITE_API_URL || "http://localhost:8000";

export function AppProvider({ children }) {
  const [activeView, setActiveView] = useState("home");
  const [data, setData] = useState([]);
  const [selectedItem, setSelectedItem] = useState(null);
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
    setSelectedItem(null);
  }, []);

  // Navegar a una vista detalle (p. ej. viewDetail('treks', 12) -> activeView = 'treks/12')
  const viewDetail = useCallback((view, id) => {
    setActiveView(`${view}/${id}`);
    setError(null);
    setFilters({});
    setPagination((p) => ({ ...p, pagina_actual: 1 }));
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
        const rawItems = json.data || json;

        // Normalizar items según la vista para que los componentes reciban una forma consistente
        const normalize = (raw, view) => {
          const get = (obj, ...keys) => {
            for (const k of keys) if (obj?.[k] !== undefined) return obj[k];
            return undefined;
          };

          const id = get(raw, "id", "identificador");
          const name = get(raw, "name", "nom", "title");
          const regNumber = get(raw, "regNumber", "registre");

          // Municipio puede venir como string ('municipi') o como objeto ('municipality')
          const municipalityRaw = get(raw, "municipality", "municipi");
          const municipality =
            typeof municipalityRaw === "string"
              ? { name: municipalityRaw }
              : municipalityRaw || null;

          // Interesing places
          const rawPlaces =
            get(raw, "interestingPlaces", "llocsInteressants", "places") || [];
          const interestingPlaces = Array.isArray(rawPlaces)
            ? rawPlaces.map((p) => ({
                id: get(p, "id", "identificador"),
                name: get(p, "name", "nom"),
                gps: get(p, "gps", "gps_location"),
                placeType: get(p, "place_type")
                  ? { name: p.place_type }
                  : p.placeType || null,
              }))
            : [];

          // Meetings / reunions
          const rawMeetings = get(raw, "meetings", "reunions") || [];
          const meetings = Array.isArray(rawMeetings)
            ? rawMeetings.map((m) => ({
                id: get(m, "id", "identificador"),
                date: get(m, "date", "day", "appDateInit"),
                time: get(m, "time"),
                guide:
                  get(m, "guide")?.name ||
                  get(m, "user")?.name ||
                  get(m, "user")?.nom ||
                  null,
                status: get(m, "status"),
                available_spots: get(m, "available_spots"),
                totalScore: get(m, "totalScore"),
                countScore: get(m, "countScore", "vots"),
              }))
            : [];

          // Añadir campos más directos según la vista para compatibilidad
          const base = {
            id,
            name,
            regNumber,
            municipality,
            interestingPlaces,
            meetings,
            // Propiedades adicionales pasadas tal cual cuando existan
            ...raw,
          };

          if (view === "interesting-places") {
            base.gps = get(raw, "gps", "gps_location");
            base.placeType = get(raw, "placeType")
              ? { name: raw.placeType }
              : get(raw, "place_type")
                ? { name: raw.place_type }
                : raw.placeType || null;
          }

          if (view === "meetings") {
            base.date = get(raw, "date", "day", "appDateInit");
            base.time = get(raw, "time");
            base.guide =
              get(raw, "guide")?.name ||
              get(raw, "user")?.name ||
              get(raw, "user")?.nom ||
              null;
          }

          return base;
        };

        // Si la API devuelve un array -> lista; si devuelve objeto -> detalle
        if (Array.isArray(rawItems)) {
          const items = rawItems.map((it) => normalize(it, activeView));
          setData(items);
          setSelectedItem(null);
        } else if (rawItems && typeof rawItems === 'object') {
          const item = normalize(rawItems, activeView.split('/')[0]);
          setSelectedItem(item);
          setData([]);
        } else {
          setData([]);
          setSelectedItem(null);
        }

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
    selectedItem,
    loading,
    token,
    error,
    isAuthenticated: !!token,
    filters,
    pagination,

    // Acciones
    changeView,
    viewDetail,
    logout,
    setUserToken,
    updateFilters,
    changePage,
  };

  return <AppContext.Provider value={value}>{children}</AppContext.Provider>;
}
