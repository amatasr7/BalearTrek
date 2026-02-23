import React from "react";
import "./TrekDetail.css";

export default function TrekDetail({ trek }) {
  if (!trek) return null;

  const average = trek.countScore
    ? (trek.totalScore / trek.countScore).toFixed(1)
    : "—";

  return (
    <article className="trek-detail">
      <header className="trek-header">
        <h1 className="trek-title">{trek.name}</h1>
        <div
          className={`trek-status ${trek.status === "active" ? "active" : "inactive"}`}
        >
          {trek.status === "active" ? "Activa" : "Inactiva"}
        </div>
      </header>

      <section className="trek-meta">
        <div>
          <strong>Nº registro:</strong> {trek.regNumber}
        </div>
        <div>
          <strong>Municipio:</strong> {trek.municipality?.name || "—"}
        </div>
        <div>
          <strong>Valoración:</strong> {average} ({trek.countScore || 0}{" "}
          opiniones)
        </div>
      </section>

      <section className="trek-description">
        <h2>Descripción</h2>
        <p>{trek.description || "No hay descripción disponible."}</p>
      </section>

      <section className="trek-places">
        <h2>Lugares remarcables</h2>
        {trek.interestingPlaces?.length ? (
          <ol>
            {trek.interestingPlaces.map((place) => (
              <li key={place.id} className="place-item">
                <strong>{place.name}</strong>
                <div className="place-type">{place.placeType?.name || ""}</div>
                <div className="place-gps">{place.gps || ""}</div>
              </li>
            ))}
          </ol>
        ) : (
          <p>No hay lugares asociados.</p>
        )}
      </section>

      <section className="trek-meetings">
        <h2>Quedadas</h2>
        {trek.meetings?.length ? (
          <ul>
            {trek.meetings.map((m) => (
              <li key={m.id} className="meeting-item">
                <div className="meeting-date">{m.date}</div>
                <div className="meeting-info">
                  Guia: {m.guide || "—"} — Estado: {m.status}
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
