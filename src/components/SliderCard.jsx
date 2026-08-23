import React from "react";
import { Edit, GripVertical, Trash2, Power } from "lucide-react";

export default function SliderCard({
  slider,
  index,
  onEdit,
  onDelete,
  onToggle,
  onMove
}) {
  return (
    <article className={`slider-card ${slider.active ? "" : "disabled"}`}>
      <div className="drag-handle">
        <GripVertical size={19} />
        <span>{index + 1}</span>
      </div>

      <img src={slider.imageUrl} alt={slider.title || "Slider"} />

      <div className="slider-info">
        <div className="slider-title-row">
          <h3>{slider.title || "Untitled banner"}</h3>
          <span className={slider.active ? "status on" : "status off"}>
            {slider.active ? "Active" : "Disabled"}
          </span>
        </div>
        <p>{slider.description || "No description"}</p>
        <small>
          Position {slider.position} · {slider.imageWidth || "?"}×{slider.imageHeight || "?"}
        </small>
      </div>

      <div className="card-actions">
        <button title="Move up" disabled={index === 0} onClick={() => onMove(index, -1)}>↑</button>
        <button title="Move down" onClick={() => onMove(index, 1)}>↓</button>
        <button title="Enable / disable" onClick={() => onToggle(slider)}>
          <Power size={17} />
        </button>
        <button title="Edit" onClick={() => onEdit(slider)}>
          <Edit size={17} />
        </button>
        <button className="danger" title="Delete" onClick={() => onDelete(slider)}>
          <Trash2 size={17} />
        </button>
      </div>
    </article>
  );
}
