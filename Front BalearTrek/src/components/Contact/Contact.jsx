import React from "react";
import "./Contact.css";

const Contact = () => {
  const handleSubmit = (e) => {
    e.preventDefault();
    alert("¡Mensaje enviado!");
  };

  return (
    <section className="contact-container">
      <div className="contact-info">
        <h2>Contact us</h2>
        <p>
          If you have any questions, suggestions, or want to collaborate with
          us, feel free to reach out! We are here to help you plan your perfect
          trek in the Balearic Islands.
        </p>

        <div className="info-item">
          <strong>📍 Location:</strong> Palma, Balearic Islands
        </div>
        <div className="info-item">
          <strong>📧 Email:</strong> contact@balertrek.com
        </div>
        <div className="info-item">
          <strong>📞 Phone:</strong> +34 123 456 789
        </div>
      </div>

      <div className="contact-form-card">
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Name</label>
            <input type="text" placeholder="Your name" required />
          </div>
          <div className="form-group">
            <label>Email</label>
            <input type="email" placeholder="your@email.com" required />
          </div>
          <div className="form-group">
            <label>Message</label>
            <textarea
              rows="5"
              placeholder="Write your message here..."
              required
            ></textarea>
          </div>
          <button type="submit" className="login-btn">
            Send message
          </button>
        </form>
      </div>
    </section>
  );
};

export default Contact;
