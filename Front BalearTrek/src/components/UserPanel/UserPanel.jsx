import { useApp } from "../../context/useApp";
import "./UserPanel.css";

export default function UserPanel() {
  const { changeView } = useApp();

  const menuItems = [
    { id: "encuentros", label: "Mis comentarios" },
    { id: "comentarios", label: "Comentarios" },
    { id: "opcion3", label: "Mis quedadas" },
    { id: "opcion4", label: "Quedadas" },
  ];

  const sidebarStyle = {
    display: "flex",
    flexDirection: "column",
    width: "fit-content",
    minWidth: "160px",
    padding: "20px",
    backgroundColor: "#fff",
    borderRadius: "8px",
    boxShadow: "0 2px 10px rgba(0,0,0,0.05)",
    gap: "15px",
    alignSelf: "flex-start",
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
    textAlign: "center",
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
            onClick={() => changeView(item.id)}
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
