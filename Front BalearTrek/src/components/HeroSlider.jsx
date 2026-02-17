import { useState, useEffect } from "react";

const images = [
  {
    url: "/images/banyalbufar.jpg",
    title: "Sierra de Tramuntana",
    desc: "Descubre los senderos más espectaculares de Mallorca.",
  },
  {
    url: "/images/formentor.jpg",
    title: "Calas de Mallorca",
    desc: "Rutas por el Camí de Cavalls y aguas turquesas.",
  },
  {
    url: "/images/tramuntana.jpg",
    title: "Ibiza Natural",
    desc: "Explora la isla más allá de las fiestas, con rutas secretas.",
  },
];

export default function HeroSlider() {
  const [currentIndex, setCurrentIndex] = useState(0);

  const nextSlide = () => {
    setCurrentIndex((prevIndex) =>
      prevIndex === images.length - 1 ? 0 : prevIndex + 1,
    );
  };

  const prevSlide = () => {
    setCurrentIndex((prevIndex) =>
      prevIndex === 0 ? images.length - 1 : prevIndex - 1,
    );
  };

  // --- LÓGICA DE CAMBIO AUTOMÁTICO ---
  useEffect(() => {
    // Crea un intervalo que llama a nextSlide cada 5 segundos (5000ms)
    const interval = setInterval(() => {
      nextSlide();
    }, 5000);

    // Limpia el intervalo cuando el componente se destruye o cambia
    // para evitar que la web se vuelva lenta o falle.
    return () => clearInterval(interval);
  }, [currentIndex]); // Se reinicia cada vez que cambia la imagen

  return (
    <section className="hero-slider">
      <button className="slider-btn prev" onClick={prevSlide}>
        ❮
      </button>
      <button className="slider-btn next" onClick={nextSlide}>
        ❯
      </button>

      <img
        src={images[currentIndex].url}
        alt={images[currentIndex].title}
        className="slider-image"
      />

      <div className="slider-overlay">
        <h2>{images[currentIndex].title}</h2>
        <p>{images[currentIndex].desc}</p>
      </div>
    </section>
  );
}
