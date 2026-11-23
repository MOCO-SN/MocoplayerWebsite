import React from "react";
import { Edit, GripVertical, Trash2, Power, Loader2 } from "lucide-react";

export default function SliderCard({
  slider,
  index,
  isToggling = false,
  onEdit,
  onDelete,
  onToggle,
  onMove
}) {
  const isActive = Boolean(slider.active);

  return (
    <article className={`slider-card ${isActive ? "" : "disabled"}`}>
      <div className="drag-handle">
        <GripVertical size={19} />
        <span>{index + 1}</span>
      </div>

      <img src={slider.imageUrl} alt={slider.title || "Slider"} />

      <div className="slider-info">
        <div className="slider-title-row">
          <h3>{slider.title || "Untitled banner"}</h3>
          <span className={isActive ? "status on" : "status off"}>
            {isActive ? "Active" : "Disabled"}
          </span>
        </div>
        <p>{slider.description || "No description"}</p>
        <small>
          Position {slider.position} · {slider.imageWidth || "?"}×{slider.imageHeight || "?"}
        </small>
      </div>

      <div className="card-actions">
        <button
          type="button"
          title="Move up"
          disabled={index === 0}
          onClick={() => onMove(index, -1)}
        >
          ↑
        </button>
        <button
          type="button"
          title="Move down"
          onClick={() => onMove(index, 1)}
        >
          ↓
        </button>
        <button
          type="button"
          title={isToggling ? "Updating..." : isActive ? "Click to disable banner" : "Click to enable banner"}
          disabled={isToggling}
          onClick={() => onToggle(slider)}
          style={{ opacity: isToggling ? 0.5 : 1, cursor: isToggling ? "wait" : "pointer" }}
        >
          {isToggling ? (
            <Loader2 size={17} className="spin-icon" style={{ animation: "spin 1s linear infinite" }} />
          ) : (
            <Power size={17} color={isActive ? "#16a34a" : "#94a3b8"} />
          )}
        </button>
        <button
          type="button"
          title="Edit"
          onClick={() => onEdit(slider)}
        >
          <Edit size={17} />
        </button>
        <button
          type="button"
          className="danger"
          title="Delete"
          onClick={() => onDelete(slider)}
        >
          <Trash2 size={17} />
        </button>
      </div>
    </article>
  );
}
