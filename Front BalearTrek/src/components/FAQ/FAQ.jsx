import React, { useState } from "react";
import "./FAQ.css";

const MoreInfo = () => {
  const [expandedIds, setExpandedIds] = useState(new Set([0])); // Por defecto expande la primera pregunta

  const faqs = [
    {
      id: 1,
      question: "Reglas de inscripción:",
      answer:
        "Los usuarios pueden inscribirse a una quedada desde un mes antes hasta una semana antes de la fecha de la quedada.",
    },
    {
      id: 2,
      question: "Significado de la puntuación:",
      answer:
        "La puntuación de 0 a 5 representa una media de la valoración de los usuarios en sus comentarios.",
    },
    {
      id: 3,
      question: "Normas de publicación de comentarios:",
      answer:
        "Los comentarios deben ser respetuosos y relevantes a la excursión. No se permiten comentarios ofensivos, spam o información falsa. Cada usuario puede publicar un comentario por excursión.",
    },
  ];

  const toggleExpand = (id) => {
    const newExpanded = new Set(expandedIds);
    if (newExpanded.has(id)) {
      newExpanded.delete(id);
    } else {
      newExpanded.add(id);
    }
    setExpandedIds(newExpanded);
  };

  return (
    <div className="dynamic-view">
      <div className="faq-header">
        <h2>Preguntas Frecuentes (FAQ)</h2>
        <p>Encuentra respuestas a las preguntas más comunes sobre BalearTrek</p>
      </div>

      <div className="faq-container">
        {faqs.map((faq) => (
          <div key={faq.id} className="faq-item">
            <button
              className={`faq-question ${
                expandedIds.has(faq.id) ? "active" : ""
              }`}
              onClick={() => toggleExpand(faq.id)}
            >
              <span className="faq-text">{faq.question}</span>
              <span className="faq-icon">+</span>
            </button>
            {expandedIds.has(faq.id) && (
              <div className="faq-answer">
                <p>{faq.answer}</p>
              </div>
            )}
          </div>
        ))}
      </div>

      <div className="faq-footer">
        <h3>¿No encontraste lo que buscas?</h3>
        <p>
          Contacta con nuestro equipo usando el formulario de contacto. Estamos
          aquí para ayudarte.
        </p>
      </div>
    </div>
  );
};

export default MoreInfo;
