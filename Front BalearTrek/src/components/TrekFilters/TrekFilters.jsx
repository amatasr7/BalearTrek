import { useState, useEffect } from "react";
import { useApp } from "../../context/useApp";
import "./TrekFilters.css";

export function TrekFilters() {
  const { activeView, filters, updateFilters } = useApp();
  const [localFilters, setLocalFilters] = useState(filters);

  useEffect(() => {
    setLocalFilters(filters);
  }, [filters]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setLocalFilters({ ...localFilters, [name]: value });
  };

  const handleApplyFilters = (e) => {
    e.preventDefault();
    updateFilters(localFilters);
  };

  const handleReset = () => {
    setLocalFilters({});
    updateFilters({});
  };

  // Diferentes filtros según la vista
  const renderFilters = () => {
    if (activeView === "treks") {
      return (
        <>
          <div className="filter-group">
            <label>Isla</label>
            <input
              type="text"
              name="isla"
              placeholder="Ej: Mallorca"
              value={localFilters.isla || ""}
              onChange={handleInputChange}
            />
          </div>
          <div className="filter-group">
            <label>Municipio</label>
            <input
              type="text"
              name="municipio"
              placeholder="Ej: Palma"
              value={localFilters.municipio || ""}
              onChange={handleInputChange}
            />
          </div>
        </>
      );
    }

    if (activeView === "meetings") {
      return (
        <div className="filter-group">
          <label>ID de Trek</label>
          <input
            type="number"
            name="trek_id"
            placeholder="ID del trek"
            value={localFilters.trek_id || ""}
            onChange={handleInputChange}
          />
        </div>
      );
    }

    if (activeView === "interesting-places") {
      return (
        <div className="filter-group">
          <label>Tipo de Lugar</label>
          <input
            type="text"
            name="tipo"
            placeholder="Ej: Viewpoint"
            value={localFilters.tipo || ""}
            onChange={handleInputChange}
          />
        </div>
      );
    }

    return null;
  };

  return (
    <form className="trek-filters" onSubmit={handleApplyFilters}>
      <h3>Filtros</h3>
      <div className="filters-container">
        {renderFilters()}

        <div className="filter-group">
          <label>Ordenar por</label>
          <select
            name="orden"
            value={localFilters.orden || "name"}
            onChange={handleInputChange}
          >
            <option value="name">Nombre</option>
            {activeView === "treks" && (
              <>
                <option value="regNumber">Número de Registro</option>
                <option value="totalScore">Puntuación</option>
              </>
            )}
            <option value="created_at">Más Reciente</option>
          </select>
        </div>

        <div className="filter-group">
          <label>Orden</label>
          <select
            name="direccion"
            value={localFilters.direccion || "asc"}
            onChange={handleInputChange}
          >
            <option value="asc">Ascendente</option>
            <option value="desc">Descendente</option>
          </select>
        </div>
      </div>

      <div className="filter-actions">
        <button type="submit" className="btn-apply">
          Aplicar Filtros
        </button>
        <button type="button" className="btn-reset" onClick={handleReset}>
          Limpiar
        </button>
      </div>
    </form>
  );
}
