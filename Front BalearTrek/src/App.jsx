import { useApp } from "./context/useApp";
import Navbar from "./components/Navbar/Navbar";
import HeroSlider from "./components/HeroSlider/HeroSlider";
import UserPanel from "./components/UserPanel/UserPanel";
import MeetingCard from "./components/MeetingCard/MeetingCard";
import Contact from "./components/Contact/Contact";
import Footer from "./components/Footer";
import AuthPage from "./components/AuthPage/AuthPage";
import HomePage from "./components/HomePage";
import MoreInfo from "./components/FAQ/FAQ";
import TrekDetail from "./components/TrekDetail/TrekDetail";
import PlaceDetail from "./components/PlaceDetail/PlaceDetail";
import { TrekFilters } from "./components/TrekFilters/TrekFilters";
import { Pagination } from "./components/Pagination/Pagination";
import "./App.css";
import "./index.css";

function App() {
  const { activeView, changeView, data, loading, token, selectedItem } = useApp();

  const renderMainContent = () => {
    // 1. VISTA HOME
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

    // 2. VISTA DE AUTENTICACIÓN (Login/Register - Punto 9)
    if (activeView === "auth") {
      return <AuthPage />;
    }

    // 3. VISTA DE CONTACTO
    if (activeView === "contact") {
      return <Contact />;
    }

    // 4. VISTA DE MÁS INFORMACIÓN
    if (activeView === "more-info") {
      return <MoreInfo />;
    }

    // 5. VISTA DINÁMICA (Treks, Meetings, etc.)
    // Si la vista incluye "/" asumimos que es una ruta detalle: e.g. "treks/12"
    if (activeView.includes("/")) {
      const [base] = activeView.split("/");
      // Si hay un selectedItem, renderizar el componente de detalle correspondiente
      if (selectedItem) {
        if (base === "treks") return (
          <section className="dynamic-view">
            <button onClick={() => changeView("treks")} className="back-btn">← Volver a Excursions</button>
            <TrekDetail trek={selectedItem} />
          </section>
        );

        if (base === "interesting-places") return (
          <section className="dynamic-view">
            <button onClick={() => changeView("interesting-places")} className="back-btn">← Volver a Llocs</button>
            <PlaceDetail place={selectedItem} />
          </section>
        );
      }
      // mientras carga o no hay seleccionado, seguir al render dinámico normal
    }

    return (
      <section className="dynamic-view">
        <button onClick={() => changeView("home")} className="back-btn">
          ← Back to Home
        </button>
        <h2>Section: {activeView.replace("-", " ").toUpperCase()}</h2>

        {/* Mostrar filtros solo para vistas que lo permiten */}
        {(activeView === "treks" ||
          activeView === "meetings" ||
          activeView === "interesting-places") && <TrekFilters />}

        {loading ? (
          <p>Loading data...</p>
        ) : (
          <>
            <div className="meetings-grid">
              {data.length > 0 ? (
                data.map((item) => <MeetingCard key={item.id} item={item} />)
              ) : (
                <div style={{ textAlign: "center", padding: "20px" }}>
                  <p>You don't have access to this content.</p>
                  {!token && (
                    <button
                      onClick={() => changeView("auth")}
                      style={{
                        marginTop: "10px",
                        color: "var(--secondary)",
                        cursor: "pointer",
                        background: "none",
                        border: "none",
                        fontWeight: "bold",
                      }}
                    >
                      Click here to register and view the content.
                    </button>
                  )}
                </div>
              )}
            </div>

            {/* Mostrar paginación solo si hay datos */}
            {data.length > 0 && <Pagination />}
          </>
        )}
      </section>
    );
  };

  return (
    <>
      <header className="app-header">
        <div className="container">
          <Navbar />
        </div>
      </header>

      <main className="main-container">
        <div className="container content-layout">
          <aside className="sidebar-container">
            <UserPanel />
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
