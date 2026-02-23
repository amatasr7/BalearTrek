import React from "react";
import "./MeetingDetail.css";

export default function MeetingDetail({ meeting }) {
  if (!meeting) return null;

  const trekName = meeting.trek?.name || meeting.trek?.nom || "—";
  const date = meeting.date || meeting.day || meeting.appDateInit || "—";
  const time = meeting.time || "—";
  const guide =
    typeof meeting.guide === "string"
      ? meeting.guide
      : meeting.guide?.name || "—";
  // Plazas: puede venir como available_spots, max_participants, o calcularse desde users.length
  const max =
    meeting.available_spots ??
    meeting.max_participants ??
    meeting.maxParticipants ??
    null;
  const usersCount = Array.isArray(meeting.users)
    ? meeting.users.length
    : (meeting.user_count ?? meeting.users_count ?? 0);
  let spots;
  if (max !== null && !isNaN(Number(max))) {
    const remaining = Number(max) - Number(usersCount || 0);
    spots = remaining >= 0 ? remaining : 0;
  } else {
    spots = meeting.available_spots ?? meeting.max_participants ?? "—";
  }

  // Estado (inscripciones): usar campos appDateIni/appDateEnd si existen
  const now = new Date();
  let status = meeting.status || null;
  try {
    const start =
      meeting.appDateIni ||
      meeting.appDateInit ||
      meeting.app_date_start ||
      null;
    const end = meeting.appDateEnd || meeting.app_date_end || null;
    if (!status && (start || end)) {
      const s = start ? new Date(start) : null;
      const e = end ? new Date(end) : null;
      if (s && e) {
        status = now >= s && now <= e ? "Abierta" : "Cerrada";
      } else if (s && !e) {
        status = now >= s ? "Abierta" : "Cerrada";
      } else if (!s && e) {
        status = now <= e ? "Abierta" : "Cerrada";
      }
    }
  } catch (err) {
    // ignore parse errors
  }

  return (
    <article className="meeting-detail">
      <header className="meeting-header">
        <h1 className="meeting-title">{trekName}</h1>
        <div className="meeting-meta">
          <span className="meeting-date">{date}</span>
          <span className="meeting-time">{time}</span>
        </div>
      </header>

      <section className="meeting-info">
        <p>
          <strong>Guía:</strong> {guide}
        </p>
        <p>
          <strong>Plazas:</strong> {spots}
        </p>
        <p>
          <strong>Estado:</strong> {status || "—"}
        </p>
      </section>

      <section className="meeting-comments">
        <h2>Comentarios ({meeting.comments?.length || 0})</h2>
        {meeting.comments && meeting.comments.length ? (
          <ul>
            {meeting.comments.map((c) => (
              <li
                key={c.id || `${c.user_id}-${Math.random()}`}
                className="comment-item"
              >
                <div className="comment-meta">
                  {c.user?.name || c.user?.nom || c.user_name || "Usuario"} —{" "}
                  {c.score ?? c.score_value ?? "—"}/5
                </div>
                <div className="comment-text">
                  {c.comment || c.comment_text || c.text || "—"}
                </div>
              </li>
            ))}
          </ul>
        ) : (
          <p>No hay comentarios.</p>
        )}
      </section>
    </article>
  );
}
