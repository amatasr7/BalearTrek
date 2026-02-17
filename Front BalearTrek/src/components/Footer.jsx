export default function Footer() {
  return (
    <footer
      className="app-footer"
      style={{ marginTop: "auto", padding: "2rem 0" }}
    >
      <hr />{" "}
      {/* Línea divisoria opcional para separar del contenido principal */}
      <div
        className="footer-container"
        style={{
          display: "flex",
          justifyContent: "space-around",
          alignItems: "flex-start",
          flexWrap: "wrap",
          gap: "20px",
        }}
      >
        {/* Columna 1: Branding / Info rápida */}
        <div className="footer-info">
          <h3>BalearTrek</h3>
          <p>
            Explorando los rincones más <br /> bellos de las Islas Baleares.
          </p>
        </div>

        {/* Columna 2: Enlaces útiles */}
        <div className="footer-links">
          <h4>Navegación</h4>
          <ul style={{ listStyle: "none", padding: 0 }}>
            <li>
              <a href="/about">Sobre nosotros</a>
            </li>
            <li>
              <a href="/legal">Aviso Legal</a>
            </li>
            <li>
              <a href="/privacy">Privacidad</a>
            </li>
          </ul>
        </div>

        {/* Columna 3: Redes Sociales / Contacto */}
        <div className="footer-social">
          <h4>Síguenos</h4>
          <div style={{ display: "flex", gap: "15px", fontSize: "1.2rem" }}>
            <a href="#" title="Instagram">
              📸
            </a>
            <a href="#" title="Facebook">
              👥
            </a>
            <a href="#" title="Twitter">
              🐦
            </a>
          </div>
          <p style={{ marginTop: "10px" }}>contacto@baleartrek.com</p>
        </div>
      </div>
      {/* Copyright inferior */}
      <div
        className="footer-bottom"
        style={{ textAlign: "center", marginTop: "2rem" }}
      >
        <p>
          &copy; {new Date().getFullYear()} BalearTrek. Todos los derechos
          reservados.
        </p>
      </div>
    </footer>
  );
}
