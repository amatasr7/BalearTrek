import React, { useEffect, useState, useContext } from "react";
import axios from "axios";
import "./CommentSection.css";
import { AppContext } from "../../context/AppContext";

const CommentSection = () => {
  const [data, setData] = useState({ data: [], links: [] });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const { token } = useContext(AppContext);

  const API_URL = import.meta.env.VITE_API_URL || "http://localhost:8000";

  const fetchComments = async (url = `${API_URL}/api/comments`) => {
    setLoading(true);
    setError(null);
    try {
      const headers = {
        Accept: "application/json",
        "Content-Type": "application/json",
      };

      if (token) headers["Authorization"] = `Bearer ${token}`;

      const response = await axios.get(url, {
        headers,
        withCredentials: true,
      });

      setData(response.data);
    } catch (err) {
      console.error("Error cargando comentarios", err);
      const resp = err.response;
      if (resp) {
        setError(
          resp.data?.message || `Error ${resp.status}: ${resp.statusText}`,
        );
      } else {
        setError(err.message || "No se pudieron cargar los comentarios.");
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchComments();
  }, []);

  const comments = Array.isArray(data?.data)
    ? data.data
    : Array.isArray(data)
      ? data
      : [];
  const links = Array.isArray(data?.links) ? data.links : [];

  return (
    <div className="balear-comments">
      {/* Contenedor blanco redondeado para consistencia visual */}
      <div className="comments-container-white">
        <div className="flex justify-between items-center mb-6 border-b pb-4">
          <h2 className="text-2xl font-bold text-slate-800">
            Section: <span className="uppercase text-sky-700">Comentarios</span>
          </h2>
        </div>

        {loading ? (
          <div className="text-center py-12">Cargando comentarios...</div>
        ) : error ? (
          <div className="text-center text-red-500 py-12">{error}</div>
        ) : comments.length === 0 ? (
          <div className="text-center text-gray-500 py-12">
            No hay comentarios disponibles en este momento.
          </div>
        ) : (
          <>
            <div className="grid">
              {comments.map((comment) => {
                const userName = comment?.user?.name ?? "Anónimo";
                const trekName = comment?.meeting?.trek?.nombre ?? "Excursión";
                const score = Number(comment?.score ?? 5);
                const created = comment?.created_at
                  ? new Date(comment.created_at).toLocaleDateString()
                  : "";

                return (
                  <div
                    key={comment.id ?? `${userName}-${Math.random()}`}
                    className="comment-card"
                  >
                    <div className="card-header">
                      <div className="flex items-center gap-3 mb-2">
                        <div className="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center font-bold text-sky-700 uppercase text-xs border border-sky-200"></div>
                        <div>
                          <p className="font-bold text-slate-800 m-0">
                            {userName}
                          </p>
                          <span className="card-subtitle">{trekName}</span>
                        </div>
                      </div>
                    </div>

                    <div className="card-details">
                      <div className="text-amber-400 text-sm mb-2">
                        {"★".repeat(
                          Math.max(0, Math.min(5, Math.round(score))),
                        )}
                        {"☆".repeat(
                          5 - Math.max(0, Math.min(5, Math.round(score))),
                        )}
                      </div>

                      <p className="text-gray-600 text-sm italic leading-relaxed">
                        "{comment?.text ?? comment?.comment ?? ""}"
                      </p>
                    </div>

                    {comment?.images?.length > 0 && comment.images[0]?.path && (
                      <div className="rounded-lg overflow-hidden border mb-4">
                        <img
                          src={`${API_URL}/storage/${comment.images[0].path}`}
                          alt="Ruta"
                          className="w-full h-32 object-cover"
                        />
                      </div>
                    )}

                    <div className="detail-item mt-auto pt-2">
                      <span className="label text-[11px] uppercase tracking-wider">
                        Fecha
                      </span>
                      <span className="text-[11px] font-bold text-sky-600">
                        {created}
                      </span>
                    </div>
                  </div>
                );
              })}
            </div>

            {/* Paginación estilo BalearTrek */}
            <div className="flex justify-center mt-12 gap-2">
              {links.map((link, index) => (
                <button
                  key={index}
                  onClick={() => link.url && fetchComments(link.url)}
                  disabled={!link.url || link.active}
                  className={`px-4 py-2 rounded-md border font-bold transition-all ${
                    link.active
                      ? "bg-sky-600 text-white border-sky-600"
                      : "bg-white text-sky-700 hover:bg-sky-50"
                  } ${!link.url ? "opacity-30 cursor-not-allowed" : ""}`}
                  dangerouslySetInnerHTML={{ __html: link.label }}
                />
              ))}
            </div>
          </>
        )}
      </div>
    </div>
  );
};

export default CommentSection;
