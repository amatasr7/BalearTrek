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

  // Soportar distintas formas de respuesta: { data: [...] } o directamente un array
  const comments = Array.isArray(data?.data)
    ? data.data
    : Array.isArray(data)
      ? data
      : [];
  const links = Array.isArray(data?.links) ? data.links : [];

  return (
    <div className="balear-comments bg-white p-6 rounded-lg shadow-sm min-h-screen">
      <div className="flex justify-between items-center mb-6 border-b pb-2">
        <h2 className="text-2xl font-bold text-slate-800">
          Section: <span className="uppercase text-sky-700">Comentarios</span>
        </h2>
        <button className="border border-gray-300 px-3 py-1 rounded text-sm hover:bg-gray-100">
          ← Vuelve al Home
        </button>
      </div>

      {loading ? (
        <div className="text-center py-12">Cargando comentarios...</div>
      ) : error ? (
        <div className="text-center text-red-500 py-12">{error}</div>
      ) : comments.length === 0 ? (
        <div className="text-center text-gray-500 py-12">
          No hay comentarios.
        </div>
      ) : (
        <>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {comments.map((comment) => {
              const initials = comment?.user?.name
                ? comment.user.name.substring(0, 2)
                : "--";
              const userName = comment?.user?.name ?? "Anónimo";
              const trekName = comment?.meeting?.trek?.nombre ?? "";
              const score =
                typeof comment?.score === "number"
                  ? comment.score
                  : comment?.score
                    ? Number(comment.score)
                    : 5;
              const created = comment?.created_at
                ? new Date(comment.created_at).toLocaleDateString()
                : "";

              return (
                <div
                  key={comment.id ?? `${userName}-${Math.random()}`}
                  className="comment-card border-t-4 border-sky-500 rounded-xl shadow-lg p-5 bg-white flex flex-col justify-between hover:scale-[1.02] transition-transform"
                >
                  <div>
                    <div className="flex items-center gap-3 mb-4">
                      <div className="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center font-bold text-sky-700 uppercase">
                        {initials}
                      </div>
                      <div>
                        <p className="font-bold text-slate-800 leading-tight">
                          {userName}
                        </p>
                        <p className="text-[10px] text-gray-400 uppercase tracking-wider">
                          {trekName}
                        </p>
                      </div>
                    </div>

                    <div className="text-amber-400 text-sm mb-3">
                      {"★".repeat(Math.max(0, Math.min(5, Math.round(score))))}
                      {"☆".repeat(
                        5 - Math.max(0, Math.min(5, Math.round(score))),
                      )}
                    </div>

                    <p className="text-gray-600 text-sm italic leading-relaxed mb-4">
                      "{comment?.text ?? comment?.comment ?? ""}"
                    </p>

                    {comment?.images?.length > 0 && comment.images[0]?.path && (
                      <div className="rounded-lg overflow-hidden border">
                        <img
                          src={`/storage/${comment.images[0].path}`}
                          alt="Ruta"
                          className="w-full h-32 object-cover"
                        />
                      </div>
                    )}
                  </div>

                  <div className="flex justify-between items-center mt-6 pt-3 border-t text-[11px] font-bold text-sky-600 uppercase">
                    <span>{created}</span>
                    <div className="flex gap-3"></div>
                  </div>
                </div>
              );
            })}
          </div>

          <div className="flex justify-center mt-12 gap-2">
            {links.map((link, index) => (
              <button
                key={index}
                onClick={() => link.url && fetchComments(link.url)}
                disabled={!link.url || link.active}
                className={`px-4 py-2 rounded-md border transition-colors ${
                  link.active
                    ? "bg-sky-600 text-white border-sky-600"
                    : "bg-white text-gray-600 hover:bg-sky-50"
                } ${!link.url ? "opacity-30 cursor-not-allowed" : ""}`}
                dangerouslySetInnerHTML={{ __html: link.label }}
              />
            ))}
          </div>
        </>
      )}
    </div>
  );
};

export default CommentSection;
