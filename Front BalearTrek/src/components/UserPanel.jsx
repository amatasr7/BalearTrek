export default function UserPanel({ onSelect }) {
  const menuItems = [
    { id: "encuentros", label: "My comments" },
    { id: "comentarios", label: "Comments" },
    { id: "opcion3", label: "My meetings" },
    { id: "opcion4", label: "Meetings" },
    { id: "opcion5", label: "..." },
    { id: "opcion6", label: "..." },
  ];

  return (
    <aside className="user-panel">
      <h2>User Panel</h2>
      <div
        className="user-grid"
        style={{
          display: "grid",
          gridTemplateColumns: "1fr 1fr", // Esto crea las 2 columnas iguales
          gap: "10px", // Espacio entre botones
        }}
      >
        {menuItems.map((item) => (
          <button key={item.id} onClick={() => onSelect(item.id)}>
            {item.label}
          </button>
        ))}
      </div>
    </aside>
  );
}
