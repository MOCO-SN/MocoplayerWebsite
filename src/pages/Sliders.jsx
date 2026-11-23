import React, { useMemo, useState } from "react";

import {
  Plus,
  Search,
  Image as ImageIcon,
  AlertTriangle,
} from "lucide-react";

import SliderCard from "../components/SliderCard";
import SliderForm from "../components/SliderForm";

import {
  createSlider,
  deleteSlider,
  reorderSliders,
  updateSlider,
} from "../firebase/sliders";

function getFirebaseErrorMessage(error, defaultMsg) {
  const errMsg = (error?.message || "").toLowerCase();
  const errCode = (error?.code || "").toLowerCase();

  if (
    errCode === "permission_denied" ||
    errMsg.includes("permission_denied") ||
    errMsg.includes("permission denied")
  ) {
    return (
      "Permission denied by Firebase Realtime Database.\n\n" +
      "Your Firebase account does not have write access to sliders. Please ensure that:\n" +
      "1. You are properly signed in with your administrator account.\n" +
      "2. Your Firebase Realtime Database rules allow write access to authenticated users (see 'firebase.rules.json').\n" +
      "3. If using role-based rules, your User UID must be added under '/admins' in the Firebase Console."
    );
  }

  if (error?.message) {
    return `${defaultMsg}\n\nDetails: ${error.message}`;
  }

  return defaultMsg;
}

export default function Sliders({ sliders = [], user }) {
  const [query, setQuery] = useState("");
  const [editing, setEditing] = useState(null);
  const [formOpen, setFormOpen] = useState(false);
  const [togglingId, setTogglingId] = useState(null);

  /* =========================================================
     FILTER SLIDERS
  ========================================================= */

  const filtered = useMemo(() => {
    const q = query.toLowerCase().trim();

    if (!q) {
      return sliders;
    }

    return sliders.filter((slider) => {
      const title = slider.title || "";
      const description = slider.description || "";

      return `${title} ${description}`
        .toLowerCase()
        .includes(q);
    });
  }, [sliders, query]);

  /* =========================================================
     OPEN ADD FORM
  ========================================================= */

  const openAddForm = () => {
    setEditing(null);
    setFormOpen(true);
  };

  /* =========================================================
     OPEN EDIT FORM
  ========================================================= */

  const edit = (slider) => {
    setEditing(slider);
    setFormOpen(true);
  };

  /* =========================================================
     CLOSE FORM
  ========================================================= */

  const closeForm = () => {
    setEditing(null);
    setFormOpen(false);
  };

  /* =========================================================
     SAVE SLIDER
  ========================================================= */

  const save = async (data) => {
    try {
      if (editing) {
        await updateSlider(editing.id, {
          ...data,
          updatedAt: Date.now(),
        });
      } else {
        await createSlider({
          ...data,
          position: sliders.length + 1,
          active: data.active ?? true,
          createdAt: Date.now(),
          updatedAt: Date.now(),
        });
      }

      closeForm();
    } catch (error) {
      console.error("Failed to save slider:", error);
      alert(getFirebaseErrorMessage(error, "Failed to save slider. Please try again."));
    }
  };

  /* =========================================================
     DELETE SLIDER
  ========================================================= */

  const remove = async (slider) => {
    const title = slider.title || "this slider";

    const confirmed = window.confirm(
      `Delete "${title}"?`
    );

    if (!confirmed) {
      return;
    }

    try {
      await deleteSlider(slider.id);
    } catch (error) {
      console.error("Failed to delete slider:", error);
      alert(getFirebaseErrorMessage(error, "Failed to delete slider. Please try again."));
    }
  };

  /* =========================================================
     TOGGLE ACTIVE STATUS
  ========================================================= */

  const toggle = async (slider) => {
    if (!slider || !slider.id) {
      alert("Failed to update slider: Slider ID is missing.");
      return;
    }

    const nextActive = !slider.active;

    try {
      setTogglingId(slider.id);
      await updateSlider(slider.id, {
        active: nextActive,
        updatedAt: Date.now(),
      });
    } catch (error) {
      console.error("Failed to update slider:", error);
      alert(getFirebaseErrorMessage(error, `Failed to update slider "${slider.title || 'banner'}".`));
    } finally {
      setTogglingId(null);
    }
  };

  /* =========================================================
     REORDER SLIDERS
  ========================================================= */

  const move = async (index, direction) => {
    const next = [...sliders];

    const target = index + direction;

    if (target < 0 || target >= next.length) {
      return;
    }

    [
      next[index],
      next[target],
    ] = [
      next[target],
      next[index],
    ];

    try {
      await reorderSliders(next);
    } catch (error) {
      console.error("Failed to reorder sliders:", error);
      alert(getFirebaseErrorMessage(error, "Failed to reorder sliders."));
    }
  };

  /* =========================================================
     RENDER
  ========================================================= */

  return (
    <>
      {/* =====================================================
          PAGE HEADER
      ===================================================== */}

      <div className="page-heading">
        <div>
          <span className="eyebrow">
            CONTENT
          </span>

          <h1>
            Slider Manager
          </h1>

          <p>
            Control the banners shown by your Android app.
          </p>
        </div>

        <button
          type="button"
          className="primary add-button"
          onClick={openAddForm}
        >
          <Plus size={18} />
          <span>Add slider</span>
        </button>
      </div>

      {!user && (
        <div style={{
          display: "flex",
          alignItems: "center",
          gap: "10px",
          padding: "12px 16px",
          marginBottom: "16px",
          borderRadius: "12px",
          background: "rgba(234, 88, 12, 0.1)",
          border: "1px solid rgba(234, 88, 12, 0.25)",
          color: "#ea580c",
          fontSize: "13px"
        }}>
          <AlertTriangle size={18} />
          <span>You are not signed in. Any slider updates or changes will be rejected by Firebase.</span>
        </div>
      )}

      {/* =====================================================
          SLIDER FORM
      ===================================================== */}

      {formOpen && (
        <SliderForm
          editing={editing}
          nextPosition={sliders.length + 1}
          onSave={save}
          onCancel={closeForm}
        />
      )}

      {/* =====================================================
          TOOLBAR
      ===================================================== */}

      <div className="toolbar">
        <div className="search-box">
          <Search size={18} />

          <input
            type="text"
            value={query}
            onChange={(event) =>
              setQuery(event.target.value)
            }
            placeholder="Search banners..."
          />
        </div>

        <span className="count-pill">
          {filtered.length}{" "}
          {filtered.length === 1
            ? "banner"
            : "banners"}
        </span>
      </div>

      {/* =====================================================
          SLIDER LIST
      ===================================================== */}

      <div className="slider-list">
        {filtered.map((slider, index) => (
          <SliderCard
            key={slider.id}
            slider={slider}
            index={index}
            isToggling={togglingId === slider.id}
            onEdit={edit}
            onDelete={remove}
            onToggle={toggle}
            onMove={move}
          />
        ))}

        {/* ===================================================
            EMPTY STATE
        =================================================== */}

        {filtered.length === 0 && (
          <div className="empty-state large">
            <ImageIcon size={32} />

            <h3>
              {query
                ? "No sliders found"
                : "No sliders yet"}
            </h3>

            <p>
              {query
                ? "Try a different search term."
                : "Add your first Cloudinary banner to get started."}
            </p>

            {!query && (
              <button
                type="button"
                className="primary"
                onClick={openAddForm}
              >
                <Plus size={18} />
                Add your first slider
              </button>
            )}
          </div>
        )}
      </div>
    </>
  );
}
