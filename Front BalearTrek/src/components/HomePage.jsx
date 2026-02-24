import { useState, useEffect } from "react";
import UserPanel from "./UserPanel/UserPanel";
import Navbar from "./Navbar/Navbar";

export default function HomePage() {
  const [view, setView] = useState("home");
  const [featured, setFeatured] = useState([]); //

  // Carga las excursiones destacadas al entrar en la web
  useEffect(() => {
    fetch("http://localhost:8000/api/featured-treks")
      .then((res) => res.json())
      .then((json) => setFeatured(json.data))
      .catch((err) => console.error("Error cargando destacadas", err));
  }, []);

  const renderContent = () => {
    switch (view) {
      case "encuentros":
        return (
          <div>
            <h2>Tus próximos encuentros...</h2>
          </div>
        );
      default:
        return (
          <>
            {/* Carrusel Dinámico */}
            <section className="hero-slider">
              {featured.length > 0 ? (
                <div className="carousel-wrapper">
                  {featured.map((trek, index) => (
                    <div key={trek.id} className="slide-item">
                      <img src={trek.image_url} alt={trek.name} />
                      <div className="info-overlay">
                        <h3>{trek.name}</h3>
                        <p>⭐ {trek.rating} / 5</p>
                        {/* El criterio aparece aquí visualmente */}
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <p>Cargando excursiones destacadas...</p>
              )}
            </section>

            <div className="meetings-grid">
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
          <UserPanel onSelect={(id) => setView(id)} /> {/* */}
        </div>
        <main className="content-container" style={{ flex: 1 }}>
          {renderContent()} {/* */}
        </main>
      </div>
    </div>
  );
}
