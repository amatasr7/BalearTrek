export default function MeetingCard({ title, date }) {
  return (
    <article className="meeting-card">
      <h3>
        Meeting: {title} {date}
      </h3>
      <button>Join now!</button>
    </article>
  );
}
