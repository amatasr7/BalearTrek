import "./MeetingCard.css";

export default function MeetingCard({ title, date }) {
  return (
    <article className="meeting-card">
      <h3>
        Quedada: {title} {date}
      </h3>
      <button>¡Apúntate!</button>
    </article>
  );
}
