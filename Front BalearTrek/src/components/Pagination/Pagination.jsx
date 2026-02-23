import { useApp } from "../../context/useApp";
import "./Pagination.css";

export function Pagination() {
  const { pagination, changePage } = useApp();

  if (!pagination || pagination.total_paginas <= 1) {
    return null; // No mostrar paginación si solo hay una página
  }

  const pages = [];
  const { pagina_actual, total_paginas } = pagination;

  // Mostrar primeras páginas + actuales + últimas
  const start = Math.max(1, pagina_actual - 1);
  const end = Math.min(total_paginas, pagina_actual + 1);

  if (start > 1) {
    pages.push(1);
    if (start > 2) pages.push("...");
  }

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  if (end < total_paginas) {
    if (end < total_paginas - 1) pages.push("...");
    pages.push(total_paginas);
  }

  return (
    <div className="pagination">
      <button
        className="pagination-btn"
        onClick={() => changePage(pagina_actual - 1)}
        disabled={pagina_actual === 1}
      >
        ← Anterior
      </button>

      <div className="pagination-pages">
        {pages.map((page, idx) => (
          <button
            key={idx}
            className={`pagination-number ${
              page === pagina_actual ? "active" : ""
            } ${page === "..." ? "dots" : ""}`}
            onClick={() => typeof page === "number" && changePage(page)}
            disabled={page === "..."}
          >
            {page}
          </button>
        ))}
      </div>

      <button
        className="pagination-btn"
        onClick={() => changePage(pagina_actual + 1)}
        disabled={pagina_actual === total_paginas}
      >
        Siguiente →
      </button>

      <span className="pagination-info">
        Página {pagina_actual} de {total_paginas} (Total:{" "}
        {pagination.total_items} items)
      </span>
    </div>
  );
}
