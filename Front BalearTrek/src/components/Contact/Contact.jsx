import React from "react";
import "./Contact.css";

const Contact = () => {
  const handleSubmit = (e) => {
    e.preventDefault();
    alert("¡Mensaje enviado!");
  };

  return (
    <section className="contact-container">
      <div className="contact-info">
        <h2>Contáctanos</h2>
        <p>
          Si tienes alguna pregunta, sugerencia o quieres colaborar con
          nosotros, ¡no dudes en ponerte en contacto! Estamos aquí para ayudarte
          a planear tu excursión perfecta en las Islas Baleares.
        </p>

        <div className="info-item">
          <strong>📍 Nos encontramos en:</strong> Palma, Islas Baleares
        </div>
        <div className="info-item">
          <strong>📧 Correo electrónico:</strong> contact@balertrek.com
        </div>
        <div className="info-item">
          <strong>📞 Teléfono:</strong> +34 123 456 789
        </div>
      </div>

      <div className="contact-form-card">
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Nombre</label>
            <input type="text" placeholder="Escribe tu nombre" required />
          </div>
          <div className="form-group">
            <label>Email</label>
            <input type="email" placeholder="tucorreo@email.com" required />
          </div>
          <div className="form-group">
            <label>Mensaje</label>
            <textarea
              rows="5"
              placeholder="Escribe tu mensaje aquí..."
              required
            ></textarea>
          </div>
          <button type="submit" className="login-btn">
            Enviar mensaje
          </button>
        </form>
      </div>
    </section>
  );
};

export default Contact;
