import { useState } from "react";
import UserPanel from "./UserPanel/UserPanel";
import Navbar from "./Navbar/Navbar";

export default function HomePage() {
  // Estado para saber qué estamos viendo
  const [view, setView] = useState("home");

  // Función para renderizar el contenido central dinámicamente
  const renderContent = () => {
    switch (view) {
      case "encuentros":
        return (
          <div>
            <h2>Tus próximos encuentros en Baleares...</h2>
          </div>
        );
      case "comentarios":
        return (
          <div>
            <h2>Tus comentarios recientes...</h2>
          </div>
        );
      default:
        // Por defecto mostramos el carrusel y las tarjetas del boceto
        return (
          <>
            <section className="hero-slider">Imágenes de fondo</section>
            <div className="meetings-grid">
              {/* Aquí irían tus MeetingCards */}
              <p>Tarjetas de encuentros...</p>
            </div>
          </>
        );
    }
  };

  return (
    <div className="page-wrapper">
      <Navbar />

      <div className="main-layout" style={{ display: "flex" }}>
        <div className="sidebar-container" style={{ width: "250px" }}>
          {/* Le pasamos la función para cambiar el estado */}
          <UserPanel onSelect={(id) => setView(id)} />
        </div>

        <main className="content-container" style={{ flex: 1 }}>
          {renderContent()}
        </main>
      </div>
    </div>
  );
}
