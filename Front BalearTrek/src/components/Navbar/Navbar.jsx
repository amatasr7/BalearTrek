import { useState } from "react";
import "./Navbar.css";

// Recibimos onSelect como prop para comunicar con App.jsx
export default function Navbar({ onSelect }) {
  const [searchTerm, setSearchTerm] = useState("");

  const handleSearch = (e) => {
    e.preventDefault();
    console.log("Buscando:", searchTerm);
    // Aquí puedes llamar a una función de búsqueda si la implementas en App.jsx
  };

  return (
    <nav className="navbar">
      <div className="navbar-logo">
        <h1>BalearTrek</h1>
      </div>

      <div className="nav-links">
        {/* Usamos onSelect que viene de las props */}
        <button onClick={() => onSelect("home")}>Home</button>
        <button onClick={() => onSelect("treks")}>Excursiones</button>
        <button onClick={() => onSelect("more-info")}>Más información</button>
        <button onClick={() => onSelect("interesting-places")}>Lugares</button>
        <button onClick={() => onSelect("meetings")}>Quedadas</button>
        <button onClick={() => onSelect("contact")}>Contacto</button>
      </div>

      <div className="navbar-actions">
        {/* Barra de Búsqueda */}
        <form onSubmit={handleSearch} className="search-bar">
          <input
            type="text"
            placeholder="Busca excursiones..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
          <button type="submit">🔍</button>
        </form>

        {/* Botón de Registro/Login (Punto 9) */}
        <button
          className="login-btn"
          onClick={() => onSelect("register")}
          title="Login / Register"
        >
          Inicia sesión
        </button>
      </div>
    </nav>
  );
}
