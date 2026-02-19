import { useState } from "react";

export default function RegisterForm({ onRegisterSuccess }) {
  const [formData, setFormData] = useState({
    name: "",
    lastname: "",
    dni: "",
    phone: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const apiUrl = `${import.meta.env.VITE_API_URL || "http://localhost:8000"}/api/register-api`;
      const response = await fetch(apiUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (response.ok) {
        localStorage.setItem("token", data.access_token); // Guardamos la "llave"
        alert("¡Registro exitoso! Ya puedes ver el contenido protegido.");
        onRegisterSuccess(data.access_token); // Pasamos el token al callback
      } else {
        alert("Error: " + JSON.stringify(data.errors));
      }
    } catch (error) {
      console.error("Error de conexión:", error);
    }
  };

  return (
    <div className="user-panel" style={{ maxWidth: "500px", margin: "0 auto" }}>
      <h2>Create new user</h2>
      <form
        onSubmit={handleSubmit}
        style={{ display: "flex", flexDirection: "column", gap: "10px" }}
      >
        <input
          type="text"
          placeholder="First Name"
          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
          required
        />
        <input
          type="text"
          placeholder="Last Name"
          onChange={(e) =>
            setFormData({ ...formData, lastname: e.target.value })
          }
          required
        />
        <input
          type="text"
          placeholder="DNI"
          onChange={(e) => setFormData({ ...formData, dni: e.target.value })}
          required
        />
        <input
          type="tel"
          placeholder="Phone number"
          onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
          required
        />
        <input
          type="email"
          placeholder="Email"
          onChange={(e) => setFormData({ ...formData, email: e.target.value })}
          required
        />
        <input
          type="password"
          placeholder="Password"
          onChange={(e) =>
            setFormData({ ...formData, password: e.target.value })
          }
          required
        />
        <input
          type="password"
          placeholder="Confirm Password"
          onChange={(e) =>
            setFormData({ ...formData, password_confirmation: e.target.value })
          }
          required
        />
        <button
          type="submit"
          className="login-btn"
          style={{
            background: "var(--secondary)",
            color: "var(--primary)",
            padding: "10px",
          }}
        >
          Register
        </button>
      </form>
    </div>
  );
}
