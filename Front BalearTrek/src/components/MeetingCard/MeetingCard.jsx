import "./MeetingCard.css";
import { useApp } from "../../context/useApp";

export default function MeetingCard({ title, date, item = null }) {
  const { activeView } = useApp();

  // Si se pasa un item completo, extraer información
  let displayTitle = title;
  let displaySubtitle = date;
  let additionalInfo = null;

  if (item) {
    displayTitle = item.name || item.title || "Sin título";

    if (activeView === "treks") {
      displaySubtitle = item.dificultat || item.distance || "Excursión";
      additionalInfo = {
        municipality: item.municipality?.name,
        island: item.municipality?.island?.name,
        score: item.totalScore,
      };
    } else if (activeView === "meetings") {
      displaySubtitle = item.date || item.fecha || "Próximamente";
      additionalInfo = {
        guide: item.guide?.name,
        availableSpots: item.available_spots,
        comments: item.comments?.length || 0,
      };
    } else if (activeView === "interesting-places") {
      displaySubtitle = item.place_type?.name || "Lugar de interés";
      additionalInfo = {
        type: item.place_type?.name,
        location: item.gps,
      };
    }
  }

  return (
    <article className="meeting-card">
      <div className="card-header">
        <h3>{displayTitle}</h3>
        <span className="card-subtitle">{displaySubtitle}</span>
      </div>

      {additionalInfo && (
        <div className="card-details">
          {additionalInfo.municipality && (
            <p className="detail-item">
              <span className="label">Municipio:</span>{" "}
              {additionalInfo.municipality}
            </p>
          )}
          {additionalInfo.island && (
            <p className="detail-item">
              <span className="label">Isla:</span> {additionalInfo.island}
            </p>
          )}
          {additionalInfo.score && (
            <p className="detail-item">
              <span className="label">Puntuación:</span> {additionalInfo.score}
              /5
            </p>
          )}
          {additionalInfo.guide && (
            <p className="detail-item">
              <span className="label">Guía:</span> {additionalInfo.guide}
            </p>
          )}
          {additionalInfo.availableSpots !== undefined && (
            <p className="detail-item">
              <span className="label">Plazas disponibles:</span>{" "}
              {additionalInfo.availableSpots}
            </p>
          )}
          {additionalInfo.comments !== undefined && (
            <p className="detail-item">
              <span className="label">Comentarios:</span>{" "}
              {additionalInfo.comments}
            </p>
          )}
          {additionalInfo.location && (
            <p className="detail-item">
              <span className="label">GPS:</span> {additionalInfo.location}
            </p>
          )}
        </div>
      )}

      <button className="card-button">¡Apúntate!</button>
    </article>
  );
}
