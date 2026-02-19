import { useState, useEffect } from "react";
import Navbar from "./components/Navbar/Navbar";
import HeroSlider from "./components/HeroSlider/HeroSlider";
import UserPanel from "./components/UserPanel/UserPanel";
import MeetingCard from "./components/MeetingCard/MeetingCard";
import Contact from "./components/Contact/Contact";
import Footer from "./components/Footer";
import RegisterForm from "./components/RegisterForm";
import HomePage from "./components/HomePage";
import MoreInfo from "./components/MoreInfo/MoreInfo";
import "./App.css";
import "./index.css";

function App() {
  const [activeView, setActiveView] = useState("home");
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(false);

  // Guardamos el token en el estado para que React sepa que estamos logueados
  const [token, setToken] = useState(localStorage.getItem("token") || null);

  useEffect(() => {
    // Si estamos en home o en registro, no pedimos datos de la API de Treks
    if (activeView === "home" || activeView === "register") {
      setData([]);
      return;
    }

    setLoading(true);

    // Configuramos las cabeceras. Si tenemos token, lo enviamos.
    const headers = {
      Accept: "application/json",
      "Content-Type": "application/json",
    };

    if (token) {
      headers["Authorization"] = `Bearer ${token}`;
    }

    const apiUrl = `${import.meta.env.VITE_API_URL || 'http://localhost:8000'}/api/${activeView}`;
    fetch(apiUrl, { headers })
      .then((res) => {
        if (res.status === 401) {
          throw new Error("No autorizado. Por favor, regístrate.");
        }
        return res.json();
      })
      .then((json) => {
        // Laravel paginate devuelve los datos dentro de .data
        setData(json.data || json);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error cargando datos:", err);
        setData([]); // Limpiamos datos para mostrar el mensaje de error
        setLoading(false);
      });
  }, [activeView, token]);

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

    // 2. VISTA DE REGISTRO (Punto 9)
    if (activeView === "register") {
      return (
        <RegisterForm
          onRegisterSuccess={(newToken) => {
            setToken(newToken);
            setActiveView("home");
          }}
        />
      );
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
    return (
      <section className="dynamic-view">
        <button onClick={() => setActiveView("home")} className="back-btn">
          ← Back to Home
        </button>
        <h2>Section: {activeView.replace("-", " ").toUpperCase()}</h2>

        {loading ? (
          <p>Loading data...</p>
        ) : (
          <div className="meetings-grid">
            {data.length > 0 ? (
              data.map((item) => (
                <MeetingCard
                  key={item.id}
                  title={item.nombre || item.title}
                  date={item.fecha || item.municipio || item.dificultat}
                />
              ))
            ) : (
              <div style={{ textAlign: "center", padding: "20px" }}>
                <p>You don't have access to this content.</p>
                {!token && (
                  <button
                    onClick={() => setActiveView("register")}
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
        )}
      </section>
    );
  };

  return (
    <>
      <header className="app-header">
        <div className="container">
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
