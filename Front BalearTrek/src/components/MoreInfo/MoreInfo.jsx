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

      {/* Contenedor principal en rejilla */}
      <div className="info-grid">
        {/* CARD 1: EQUIPAMIENTO */}
        <div className="info-card">
          <h3>🎒 Equipamiento</h3>
          <div className="equipment-mini-list">
            {equipmentData.map((item) => (
              <div key={item.id} className="equipment-mini-item">
                <img
                  src={item.image}
                  alt={item.name}
                  className="equipment-mini-img"
                />
                <div>
                  <strong>{item.name}:</strong>
                  <span className="mini-desc"> {item.description}</span>
                </div>
              </div>
            ))}
          </div>
        </div>

        <br />
        {/* CARD 2: NIVELES */}
        <div className="info-card">
          <h3>⛰️ Niveles de Dificultad</h3>
          <p>
            <strong>Bajo:</strong> Paseos relajados por senderos llanos.
          </p>
          <p>
            <strong>Medio:</strong> Requiere buena forma física y calzado
            adecuado.
          </p>
          <p>
            <strong>Alto:</strong> Solo para montañeros experimentados.
          </p>
        </div>

        {/* CARD 3: SOSTENIBILIDAD */}
        <div className="info-card">
          <h3>🌍 Sostenibilidad</h3>
          <p>
            Cuida el entorno: mantente en los senderos marcados, llévate toda tu
            basura y respeta la flora y fauna local de nuestras islas.
          </p>
        </div>
      </div>
    </div>
  );
};

export default MoreInfo;
