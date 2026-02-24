import { useState } from "react";
import { useApp } from "../../context/useApp";
import "./Navbar.css";

export default function Navbar() {
  const { changeView, isAuthenticated, logout } = useApp();
  const [searchTerm, setSearchTerm] = useState("");

  const handleSearch = (e) => {
    e.preventDefault();
    console.log("Buscando:", searchTerm);
  };

  return (
    <nav className="navbar">
      <div className="navbar-logo">
        <h1>BalearTrek</h1>
      </div>

      <div className="nav-links">
        <button onClick={() => changeView("home")}>Home</button>
        <button onClick={() => changeView("meetings")}>Quedadas</button>
        <button onClick={() => changeView("treks")}>Excursiones</button>
        <button onClick={() => changeView("interesting-places")}>
          Lugares
        </button>
        <button onClick={() => changeView("comments")}>Comentarios</button>
        <button onClick={() => changeView("more-info")}>FAQ</button>
        <button onClick={() => changeView("contact")}>Contacto</button>
      </div>

      <div className="navbar-actions">
        {isAuthenticated ? (
          <button
            className="login-btn"
            onClick={() => logout()}
            title="Cerrar sesión"
          >
            Cerrar sesión
          </button>
        ) : (
          <button
            className="login-btn"
            onClick={() => changeView("auth")}
            title="Login / Register"
          >
            Inicia sesión
          </button>
        )}
      </div>
    </nav>
  );
}
