import React from "react";
import "./TrekDetail.css";

function safeText(value) {
  if (value === null || value === undefined) return "";
  if (typeof value === "string" || typeof value === "number")
    return String(value);
  if (typeof value === "object") {
    if (value.name) return String(value.name);
    if (value.nom) return String(value.nom);
    if (value.title) return String(value.title);
    if (value.registre) return String(value.registre);
    try {
      return JSON.stringify(value);
    } catch (e) {
      return String(value);
    }
  }
  return String(value);
}

export default function TrekDetail({ trek }) {
  if (!trek) return null;

  const average = trek.countScore
    ? (trek.totalScore / trek.countScore).toFixed(1)
    : "—";

  return (
    <article className="trek-detail">
      <header className="trek-header">
        <h1 className="trek-title">{safeText(trek.name)}</h1>
        <div
          className={`trek-status ${trek.status === "active" ? "active" : "inactive"}`}
        >
          {trek.status === "active" ? "Activa" : "Inactiva"}
        </div>
      </header>

      <section className="trek-meta">
        <div>
          <strong>Nº registro:</strong> {safeText(trek.regNumber)}
        </div>
        <div>
          <strong>Municipio:</strong>{" "}
          {safeText(trek.municipality?.name || trek.municipality) || "—"}
        </div>
        <div>
          <strong>Valoración:</strong> {average} ({trek.countScore || 0}{" "}
          opiniones)
        </div>
      </section>

      <section className="trek-description">
        <h2>Descripción</h2>
        <p>{safeText(trek.description) || "No hay descripción disponible."}</p>
      </section>

      <section className="trek-places">
        <h2>Lugares remarcables</h2>
        {Array.isArray(trek.interestingPlaces) &&
        trek.interestingPlaces.length ? (
          <ol>
            {trek.interestingPlaces.map((place) => (
              <li key={place.id || safeText(place)} className="place-item">
                <strong>{safeText(place.name || place.nom || place)}</strong>
                <div className="place-type">
                  {safeText(place.placeType?.name || place.placeType)}
                </div>
                <div className="place-gps">{safeText(place.gps)}</div>
              </li>
            ))}
          </ol>
        ) : (
          <p>No hay lugares asociados.</p>
        )}
      </section>

      <section className="trek-meetings">
        <h2>Quedadas</h2>
        {Array.isArray(trek.meetings) && trek.meetings.length ? (
          <ul>
            {trek.meetings.map((m) => (
              <li key={m.id} className="meeting-item">
                <div className="meeting-date">{safeText(m.date)}</div>
                <div className="meeting-info">
                  Guia: {safeText(m.guide) || "—"} — Estado:{" "}
                  {safeText(m.status) || "—"}
                </div>
              </li>
            ))}
          </ul>
        ) : (
          <p>No hay quedadas disponibles.</p>
        )}
      </section>
    </article>
  );
}
