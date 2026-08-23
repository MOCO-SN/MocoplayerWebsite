import React, { useEffect, useState, useCallback } from "react";
import { X, Save } from "lucide-react";
import CloudinaryUploader from "./CloudinaryUploader";

const emptyForm = {
  title: "",
  description: "",
  imageUrl: "",
  publicId: "",
  imageWidth: "",
  imageHeight: "",
  position: "",
  active: true,
};

export default function SliderForm({
  editing,
  nextPosition,
  onSave,
  onCancel,
}) {
  const [form, setForm] = useState(emptyForm);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    if (editing) {
      setForm({
        title: editing.title || "",
        description: editing.description || "",
        imageUrl: editing.imageUrl || "",
        publicId: editing.publicId || "",
        imageWidth: editing.imageWidth || "",
        imageHeight: editing.imageHeight || "",
        position: editing.position ?? nextPosition,
        active: editing.active ?? true,
      });
    } else {
      setForm({
        ...emptyForm,
        position: nextPosition,
      });
    }
  }, [editing, nextPosition]);

  const handleChange = (event) => {
    const { name, value, type, checked } = event.target;

    setForm((previous) => ({
      ...previous,
      [name]: type === "checkbox" ? checked : value,
    }));
  };

  const handleUploaded = useCallback((info) => {
    setForm((previous) => ({
      ...previous,
      imageUrl: info.imageUrl,
      publicId: info.publicId,
      imageWidth: info.width,
      imageHeight: info.height,
    }));
  }, []);

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (!form.title.trim()) {
      alert("Please enter a slider title.");
      return;
    }

    if (!form.imageUrl.trim()) {
      alert("Please enter or upload an image.");
      return;
    }

    try {
      setSaving(true);

      await onSave({
        ...form,
        position: Number(form.position) || nextPosition,
        active: Boolean(form.active),
        updatedAt: Date.now(),
      });
    } catch (error) {
      console.error("Slider save error:", error);
      alert("Failed to save slider.");
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="modal-overlay">
      <div className="modal-card slider-form">
        <div className="modal-header">
          <div>
            <span className="eyebrow">
              {editing ? "EDIT SLIDER" : "NEW SLIDER"}
            </span>

            <h2>
              {editing ? "Edit Slider" : "Add Slider"}
            </h2>

            <p>
              Configure the banner displayed in Moco Player.
            </p>
          </div>

          <button
            type="button"
            className="icon-button"
            onClick={onCancel}
          >
            <X size={20} />
          </button>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="form-grid">
            <label>
              <span>Title</span>

              <input
                type="text"
                name="title"
                value={form.title}
                onChange={handleChange}
                placeholder="Summer Collection"
              />
            </label>

            <label>
              <span>Position</span>

              <input
                type="number"
                name="position"
                min="1"
                value={form.position}
                onChange={handleChange}
              />
            </label>

            <label className="full-width">
              <span>Description</span>

              <input
                type="text"
                name="description"
                value={form.description}
                onChange={handleChange}
                placeholder="Short description"
              />
            </label>

            <label className="full-width">
              <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                <span>Image URL</span>
                <CloudinaryUploader onUploaded={handleUploaded} />
              </div>

              <input
                type="url"
                name="imageUrl"
                value={form.imageUrl}
                onChange={handleChange}
                placeholder="https://example.com/banner.jpg"
              />
            </label>

            {form.imageUrl && (
              <div className="image-preview full-width">
                <img
                  src={form.imageUrl}
                  alt="Slider preview"
                  onError={(event) => {
                    event.currentTarget.style.display = "none";
                  }}
                />
              </div>
            )}

            <label className="checkbox-field full-width">
              <input
                type="checkbox"
                name="active"
                checked={form.active}
                onChange={handleChange}
              />

              <span>
                Active slider
              </span>
            </label>
          </div>

          <div className="form-actions">
            <button
              type="button"
              className="secondary"
              onClick={onCancel}
              disabled={saving}
            >
              Cancel
            </button>

            <button
              type="submit"
              className="primary"
              disabled={saving}
            >
              <Save size={18} />

              {saving
                ? "Saving..."
                : editing
                  ? "Save changes"
                  : "Add slider"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}