import React from "react";
import "./MoreInfo.css";
import equipmentData from "./equipment.json";

const MoreInfo = () => {
  return (
    <div className="dynamic-view">
      <div className="info-header">
        <h2>Guía del Senderista</h2>
        <p>Prepárate correctamente para disfrutar de las Baleares.</p>
      </div>

      <div className="info-grid">
        {/* CARD 1: EQUIPAMIENTO - Ocupa todo el ancho superior */}
        <div className="info-card equipment-card full-width">
          <h3>🎒 Equipamiento Recomendado</h3>
          <div className="equipment-mini-list">
            {equipmentData.map((item) => (
              <div key={item.id} className="equipment-mini-item">
                <div className="img-container">
                  <img
                    src={item.image}
                    alt={item.name}
                    className="equipment-mini-img"
                  />
                </div>
                <div className="equipment-mini-text">
                  <strong>{item.name}</strong>
                  <p className="mini-desc">{item.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* CARD 2: NIVELES - Ocupa el 50% inferior izquierdo */}
        <div className="info-card">
          <h3>⛰️ Niveles de Dificultad</h3>
          <div className="levels-content">
            <p>
              <strong>Bajo:</strong> Paseos relajados por senderos llanos.
            </p>
            <p>
              <strong>Medio:</strong> Requiere buena forma física y calzado
              adecuado.
            </p>
            <p>
              <strong>Alto:</strong> Solo para montañeros experimentados y rutas
              técnicas.
            </p>
          </div>
        </div>

        {/* CARD 3: SOSTENIBILIDAD - Ocupa el 50% inferior derecho */}
        <div className="info-card">
          <h3>🌍 Sostenibilidad</h3>
          <p>
            Cuida el entorno: mantente en los senderos marcados, llévate toda tu
            basura y respeta la flora y fauna local de nuestras islas para que
            todos podamos seguir disfrutándolas.
          </p>
        </div>
      </div>
    </div>
  );
};

export default MoreInfo;
