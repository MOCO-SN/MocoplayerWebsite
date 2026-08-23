import React from "react";

import {
  Calendar,
  Download,
  Edit,
  FileText,
  Trash2,
  Power,
} from "lucide-react";

export default function UpdateCard({
  update,
  onEdit,
  onDelete,
  onToggle,
}) {
  return (
    <div className={`update-card ${update.active !== false ? "" : "disabled"}`}>
      <div className="update-image">
        {update.imageUrl ? (
          <img
            src={update.imageUrl}
            alt={update.title || "Update"}
          />
        ) : (
          <FileText size={32} />
        )}
      </div>

      <div className="update-content">
        <div className="update-top">
          <div>
            <span className="eyebrow">
              VERSION {update.version || "—"}
            </span>

            <h3 style={{ display: "flex", alignItems: "center", gap: "8px", flexWrap: "wrap" }}>
              {update.title || "Untitled update"}
              <span className={update.active !== false ? "status on" : "status off"} style={{ fontSize: "9px" }}>
                {update.active !== false ? "Active" : "Disabled"}
              </span>
            </h3>

            <p>
              {update.subtitle || "No subtitle"}
            </p>
          </div>

          <span className="version-pill">
            v{update.version || "—"}
          </span>
        </div>

        {update.changes && (
          <div className="update-changes">
            {update.changes}
          </div>
        )}

        <div className="update-meta">
          <span>
            <Calendar size={15} />
            {update.releaseDate || "No date"}
          </span>

          <span>
            <Download size={15} />
            {update.fileSize || "Unknown size"}
          </span>
        </div>

        <div className="update-actions">
          {update.downloadUrl && (
            <a
              href={update.downloadUrl}
              target="_blank"
              rel="noopener noreferrer"
              className="secondary"
            >
              <Download size={16} />
              Download
            </a>
          )}

          <button
            type="button"
            className="secondary"
            onClick={() => onToggle(update)}
          >
            <Power size={16} />
            {update.active !== false ? "Disable" : "Enable"}
          </button>

          <button
            type="button"
            className="secondary"
            onClick={() => onEdit(update)}
          >
            <Edit size={16} />
            Edit
          </button>

          <button
            type="button"
            className="danger"
            onClick={() => onDelete(update)}
          >
            <Trash2 size={16} />
            Delete
          </button>
        </div>
      </div>
    </div>
  );
}