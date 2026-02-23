import { useState } from "react";
import { useApp } from "../../context/useApp";
import "./AuthPage.css";

export default function AuthPage() {
  const { setUserToken, changeView } = useApp();
  const [activeTab, setActiveTab] = useState("login"); // "login" o "register"
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  // Estado para Login
  const [loginData, setLoginData] = useState({
    email: "",
    password: "",
  });

  // Estado para Register
  const [registerData, setRegisterData] = useState({
    name: "",
    lastname: "",
    dni: "",
    phone: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const API_URL = import.meta.env.VITE_API_URL || "http://localhost:8000";

  // Manejar Login
  const handleLoginSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");

    try {
      const response = await fetch(`${API_URL}/api/login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(loginData),
      });

      const data = await response.json();

      if (response.ok) {
        setUserToken(data.access_token);
        alert("¡Inicio de sesión exitoso!");
        changeView("home");
      } else {
        setError(
          data.message || "Error al iniciar sesión. Verifica tus credenciales.",
        );
      }
    } catch (error) {
      console.error("Error de conexión:", error);
      setError("Error de conexión. Intenta más tarde.");
    } finally {
      setLoading(false);
    }
  };

  // Manejar Register
  const handleRegisterSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");

    try {
      const response = await fetch(`${API_URL}/api/register-api`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(registerData),
      });

      const data = await response.json();

      if (response.ok) {
        setUserToken(data.access_token);
        alert("¡Registro exitoso! Bienvenido a BalearTrek.");
        changeView("home");
      } else {
        const errorMessages = Object.values(data.errors || {})
          .flat()
          .join(", ");
        setError(errorMessages || "Error en el registro.");
      }
    } catch (error) {
      console.error("Error de conexión:", error);
      setError("Error de conexión. Intenta más tarde.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="auth-page">
      <div className="auth-container">
        <div className="auth-header">
          <h2>BalearTrek</h2>
          <p>Accede a tu cuenta o crea una nueva</p>
        </div>

        {/* Tabs */}
        <div className="auth-tabs">
          <button
            className={`auth-tab ${activeTab === "login" ? "active" : ""}`}
            onClick={() => {
              setActiveTab("login");
              setError("");
            }}
          >
            Iniciar Sesión
          </button>
          <button
            className={`auth-tab ${activeTab === "register" ? "active" : ""}`}
            onClick={() => {
              setActiveTab("register");
              setError("");
            }}
          >
            Registrarse
          </button>
        </div>

        {/* Error Message */}
        {error && <div className="auth-error">{error}</div>}

        {/* LOGIN FORM */}
        {activeTab === "login" && (
          <form onSubmit={handleLoginSubmit} className="auth-form">
            <div className="form-group">
              <label htmlFor="login-email">Correo Electrónico</label>
              <input
                id="login-email"
                type="email"
                placeholder="tu@email.com"
                value={loginData.email}
                onChange={(e) =>
                  setLoginData({ ...loginData, email: e.target.value })
                }
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="login-password">Contraseña</label>
              <input
                id="login-password"
                type="password"
                placeholder="Tu contraseña"
                value={loginData.password}
                onChange={(e) =>
                  setLoginData({ ...loginData, password: e.target.value })
                }
                required
              />
            </div>

            <button
              type="submit"
              className="auth-submit-btn"
              disabled={loading}
            >
              {loading ? "Iniciando sesión..." : "Iniciar Sesión"}
            </button>

            <p className="auth-help-text">
              ¿No tienes cuenta? Haz clic en "Registrarse" para crear una.
            </p>
          </form>
        )}

        {/* REGISTER FORM */}
        {activeTab === "register" && (
          <form onSubmit={handleRegisterSubmit} className="auth-form">
            <div className="form-row">
              <div className="form-group">
                <label htmlFor="reg-name">Nombre</label>
                <input
                  id="reg-name"
                  type="text"
                  placeholder="Tu nombre"
                  value={registerData.name}
                  onChange={(e) =>
                    setRegisterData({ ...registerData, name: e.target.value })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label htmlFor="reg-lastname">Apellido</label>
                <input
                  id="reg-lastname"
                  type="text"
                  placeholder="Tu apellido"
                  value={registerData.lastname}
                  onChange={(e) =>
                    setRegisterData({
                      ...registerData,
                      lastname: e.target.value,
                    })
                  }
                  required
                />
              </div>
            </div>

            <div className="form-row">
              <div className="form-group">
                <label htmlFor="reg-dni">DNI</label>
                <input
                  id="reg-dni"
                  type="text"
                  placeholder="Ej: 12345678X"
                  value={registerData.dni}
                  onChange={(e) =>
                    setRegisterData({ ...registerData, dni: e.target.value })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label htmlFor="reg-phone">Teléfono</label>
                <input
                  id="reg-phone"
                  type="tel"
                  placeholder="+34 600 000 000"
                  value={registerData.phone}
                  onChange={(e) =>
                    setRegisterData({ ...registerData, phone: e.target.value })
                  }
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label htmlFor="reg-email">Correo Electrónico</label>
              <input
                id="reg-email"
                type="email"
                placeholder="tu@email.com"
                value={registerData.email}
                onChange={(e) =>
                  setRegisterData({ ...registerData, email: e.target.value })
                }
                required
              />
            </div>

            <div className="form-row">
              <div className="form-group">
                <label htmlFor="reg-password">Contraseña</label>
                <input
                  id="reg-password"
                  type="password"
                  placeholder="Mínimo 8 caracteres"
                  value={registerData.password}
                  onChange={(e) =>
                    setRegisterData({
                      ...registerData,
                      password: e.target.value,
                    })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label htmlFor="reg-confirm">Confirmar Contraseña</label>
                <input
                  id="reg-confirm"
                  type="password"
                  placeholder="Repite tu contraseña"
                  value={registerData.password_confirmation}
                  onChange={(e) =>
                    setRegisterData({
                      ...registerData,
                      password_confirmation: e.target.value,
                    })
                  }
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              className="auth-submit-btn"
              disabled={loading}
            >
              {loading ? "Registrando..." : "Registrarse"}
            </button>

            <p className="auth-help-text">
              ¿Ya tienes cuenta? Haz clic en "Iniciar Sesión" para entrar.
            </p>
          </form>
        )}
      </div>
    </div>
  );
}
