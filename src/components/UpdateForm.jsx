import React, { useEffect, useState, useCallback } from "react";
import { X, Save } from "lucide-react";
import CloudinaryUploader from "./CloudinaryUploader";

const emptyForm = {
  title: "",
  subtitle: "",
  version: "",
  changes: "",
  patchNotes: "",
  downloadUrl: "",
  releaseDate: "",
  fileSize: "",
  imageUrl: "",
  active: true,
};

export default function UpdateForm({
  editing,
  onSave,
  onCancel,
}) {
  const [form, setForm] = useState(emptyForm);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    if (editing) {
      setForm({
        title: editing.title || "",
        subtitle: editing.subtitle || "",
        version: editing.version || "",
        changes: editing.changes || "",
        patchNotes: editing.patchNotes || "",
        downloadUrl: editing.downloadUrl || "",
        releaseDate: editing.releaseDate || "",
        fileSize: editing.fileSize || "",
        imageUrl: editing.imageUrl || "",
        active: editing.active ?? true,
      });
    } else {
      setForm(emptyForm);
    }
  }, [editing]);

  const change = (event) => {
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
    }));
  }, []);

  const submit = async (event) => {
    event.preventDefault();

    if (!form.title.trim()) {
      alert("Enter update title.");
      return;
    }

    if (!form.version.trim()) {
      alert("Enter version.");
      return;
    }

    if (!form.downloadUrl.trim()) {
      alert("Enter download URL.");
      return;
    }

    try {
      setSaving(true);

      await onSave({
        ...form,
        active: Boolean(form.active),
        updatedAt: Date.now(),
      });
    } catch (error) {
      console.error("Update save failed:", error);
      alert("Failed to save update.");
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="modal-overlay">
      <div className="update-form modal-card">
        <div className="modal-header">
          <div>
            <span className="eyebrow">
              {editing ? "EDIT UPDATE" : "NEW UPDATE"}
            </span>

            <h2>
              {editing
                ? "Edit App Update"
                : "Create App Update"}
            </h2>
          </div>

          <button
            type="button"
            className="icon-button"
            onClick={onCancel}
          >
            <X size={20} />
          </button>
        </div>

        <form onSubmit={submit}>
          <div className="form-grid">
            <label>
              <span>Title</span>

              <input
                name="title"
                value={form.title}
                onChange={change}
                placeholder="Moco Player"
              />
            </label>

            <label>
              <span>Subtitle</span>

              <input
                name="subtitle"
                value={form.subtitle}
                onChange={change}
                placeholder="Latest version"
              />
            </label>

            <label>
              <span>Version</span>

              <input
                name="version"
                value={form.version}
                onChange={change}
                placeholder="8.3.0"
              />
            </label>

            <label>
              <span>File size</span>

              <input
                name="fileSize"
                value={form.fileSize}
                onChange={change}
                placeholder="25 MB"
              />
            </label>

            <label>
              <span>Release date</span>

              <input
                type="date"
                name="releaseDate"
                value={form.releaseDate}
                onChange={change}
              />
            </label>

            <label>
              <span>Download URL</span>

              <input
                type="url"
                name="downloadUrl"
                value={form.downloadUrl}
                onChange={change}
                placeholder="https://..."
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
                onChange={change}
                placeholder="https://..."
              />
            </label>

            {form.imageUrl && (
              <div className="image-preview full-width">
                <img
                  src={form.imageUrl}
                  alt="Update preview"
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
                onChange={change}
              />

              <span>
                Active update (show on public website release log)
              </span>
            </label>

            <label className="full-width">
              <span>Changes</span>

              <textarea
                name="changes"
                value={form.changes}
                onChange={change}
                rows="3"
                placeholder="What's new in this version?"
              />
            </label>

            <label className="full-width">
              <span>Patch notes</span>

              <textarea
                name="patchNotes"
                value={form.patchNotes}
                onChange={change}
                rows="5"
                placeholder="Detailed patch notes..."
              />
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
                  ? "Update"
                  : "Create Update"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}