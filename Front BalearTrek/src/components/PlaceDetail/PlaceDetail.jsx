import React from "react";
import "./PlaceDetail.css";

function safeText(value) {
  if (value === null || value === undefined) return "";
  if (typeof value === "string" || typeof value === "number")
    return String(value);
  if (typeof value === "object") {
    if (value.name) return String(value.name);
    if (value.nom) return String(value.nom);
    if (value.title) return String(value.title);
    if (value.registre) return String(value.registre);
    // fallback: try toJSON or toString
    try {
      return JSON.stringify(value);
    } catch (e) {
      return String(value);
    }
  }
  return String(value);
}

export default function PlaceDetail({ place }) {
  if (!place) return null;

  return (
    <article className="place-detail">
      <header className="place-header">
        <h1 className="place-title">{safeText(place.name)}</h1>
        <div className="place-type">
          {safeText(place.placeType?.name || place.placeType)}
        </div>
      </header>

      <section className="place-content">
        <div className="place-gps">
          <strong>Coordenadas:</strong> {safeText(place.gps) || "—"}
        </div>
        <div className="place-description">
          <h2>Descripció</h2>
          <p>
            {safeText(place.description) || "No hay descripción disponible."}
          </p>
        </div>

        <div className="place-treks">
          <h2>Excursions que lo incluyen</h2>
          {Array.isArray(place.treks) && place.treks.length ? (
            <ul>
              {place.treks.map((t) => (
                <li key={t.id || safeText(t)} className="trek-linked">
                  {safeText(t.name || t.nom || t.title || t.registre || t)}
                </li>
              ))}
            </ul>
          ) : (
            <p>No s'ha trobat cap excursió que contingui aquest lloc.</p>
          )}
        </div>
      </section>
    </article>
  );
}
