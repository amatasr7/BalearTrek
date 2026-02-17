import { useState, useEffect } from "react";
import HeroSlider from "./components/HeroSlider";
import Navbar from "./components/Navbar";
import MeetingCard from "./components/MeetingCard";
import UserPanel from "./components/UserPanel";
import Footer from "./components/Footer";
import "./App.css";

function App() {
  const [activeView, setActiveView] = useState("home");
  const [data, setData] = useState([]); // Estado para los datos del backend
  const [loading, setLoading] = useState(false);

  // 1. Efecto para cargar datos cada vez que cambie la vista
  useEffect(() => {
    if (activeView === "home") {
      setData([]); // Limpiar datos si volvemos a home
      return;
    }

    setLoading(true);
    // Cambia 'balertrek.test' por tu URL local de Laragon
    fetch(`http://balertrek.test/api/${activeView}`)
      .then((res) => res.json())
      .then((json) => {
        setData(json);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error cargando datos:", err);
        setLoading(false);
      });
  }, [activeView]);

  const renderMainContent = () => {
    // VISTA HOME (Punto 2: Carrusel y destacados)
    if (activeView === "home") {
      return (
        <>
          <HeroSlider />
          <div className="meetings-grid">
            <MeetingCard title="Paseo por la Tramuntana" date="14/01" />
            <MeetingCard title="Un día en el Aquarium" date="20/02" />
            <MeetingCard title="Torrada en Lluc" date="15/02" />
          </div>
        </>
      );
    }

    // VISTA DINÁMICA (Puntos 3, 5 y 6: Catálogos filtrados)
    return (
      <section className="dynamic-view">
        <button onClick={() => setActiveView("home")} className="back-btn">
          ← Volver al inicio
        </button>
        <h2>Sección: {activeView.replace("-", " ").toUpperCase()}</h2>

        {loading ? (
          <p>Cargando datos de Laravel...</p>
        ) : (
          <div className="meetings-grid">
            {data.length > 0 ? (
              data.map((item) => (
                <MeetingCard
                  key={item.id}
                  title={item.nombre || item.title}
                  date={item.fecha || item.municipio}
                />
              ))
            ) : (
              <p>No hay elementos disponibles en esta categoría.</p>
            )}
          </div>
        )}
      </section>
    );
  };

  return (
    <>
      <header className="app-header">
        <div className="container">
          {/* PASAMOS onSelect al Navbar para que los botones funcionen */}
          <Navbar onSelect={(viewId) => setActiveView(viewId)} />
        </div>
      </header>

      <main className="main-container">
        <div className="container content-layout">
          <aside className="sidebar-container">
            <UserPanel onSelect={(viewId) => setActiveView(viewId)} />
          </aside>

          <section className="main-content">{renderMainContent()}</section>
        </div>
      </main>

      <footer className="app-footer">
        <div className="container">
          <Footer />
        </div>
      </footer>
    </>
  );
}

export default App;
