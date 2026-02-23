import React from "react";
import "./PlaceDetail.css";

export default function PlaceDetail({ place }) {
  if (!place) return null;

  return (
    <article className="place-detail">
      <header className="place-header">
        <h1 className="place-title">{place.name}</h1>
        <div className="place-type">{place.placeType?.name || ""}</div>
      </header>

      <section className="place-content">
        <div className="place-gps">
          <strong>Coordenadas:</strong> {place.gps || "—"}
        </div>
        <div className="place-description">
          <h2>Descripció</h2>
          <p>{place.description || "No hay descripción disponible."}</p>
        </div>

        <div className="place-treks">
          <h2>Excursions que lo incluyen</h2>
          {place.treks?.length ? (
            <ul>
              {place.treks.map((t) => (
                <li key={t.id} className="trek-linked">
                  {t.name}
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
