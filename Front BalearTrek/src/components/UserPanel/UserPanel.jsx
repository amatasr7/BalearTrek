import "./UserPanel.css";

export default function UserPanel({ onSelect }) {
  const menuItems = [
    { id: "encuentros", label: "Mis comentarios" },
    { id: "comentarios", label: "Comentarios" },
    { id: "opcion3", label: "Mis quedadas" },
    { id: "opcion4", label: "Quedadas" },
  ];

  const sidebarStyle = {
    display: "flex",
    flexDirection: "column",
    width: "fit-content", // El ancho se ajusta al botón más largo
    minWidth: "160px", // Un ancho mínimo para que no se vea colapsado
    padding: "20px",
    backgroundColor: "#fff",
    borderRadius: "8px", // Opcional: para que combine con tus cards de abajo
    boxShadow: "0 2px 10px rgba(0,0,0,0.05)", // Un toque de sombra para separarlo del fondo
    gap: "15px",
    alignSelf: "flex-start", // Importante: evita que se estire verticalmente si el padre es Flex
  };

  const buttonContainerStyle = {
    display: "flex",
    flexDirection: "column",
    gap: "10px",
  };

  const buttonStyle = {
    padding: "10px 20px",
    backgroundColor: "#f8f9fa",
    border: "1px solid #e0e0e0",
    borderRadius: "5px",
    cursor: "pointer",
    textAlign: "center", // Alineado a la izquierda para estilo lista
    fontSize: "0.9rem",
    transition: "background-color 0.2s",
  };

  return (
    <aside className="user-panel" style={sidebarStyle}>
      <h2 style={{ marginBottom: "5px", fontSize: "1.1rem", color: "#003366" }}>
        Panel de Usuario
      </h2>
      <div className="user-grid" style={buttonContainerStyle}>
        {menuItems.map((item) => (
          <button
            key={item.id}
            onClick={() => onSelect(item.id)}
            style={buttonStyle}
            onMouseOver={(e) => (e.target.style.backgroundColor = "#e9ecef")}
            onMouseOut={(e) => (e.target.style.backgroundColor = "#f8f9fa")}
          >
            {item.label}
          </button>
        ))}
      </div>
    </aside>
  );
}
