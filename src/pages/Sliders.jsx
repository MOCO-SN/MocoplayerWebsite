import React, { useMemo, useState } from "react";

import {
  Plus,
  Search,
  Image as ImageIcon,
} from "lucide-react";

import SliderCard from "../components/SliderCard";
import SliderForm from "../components/SliderForm";

import {
  createSlider,
  deleteSlider,
  reorderSliders,
  updateSlider,
} from "../firebase/sliders";

export default function Sliders({ sliders = [] }) {
  const [query, setQuery] = useState("");
  const [editing, setEditing] = useState(null);
  const [formOpen, setFormOpen] = useState(false);

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
      alert("Failed to save slider. Please try again.");
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
      alert("Failed to delete slider. Please try again.");
    }
  };

  /* =========================================================
     TOGGLE ACTIVE STATUS
  ========================================================= */

  const toggle = async (slider) => {
    try {
      await updateSlider(slider.id, {
        active: !slider.active,
        updatedAt: Date.now(),
      });
    } catch (error) {
      console.error("Failed to update slider:", error);
      alert("Failed to update slider.");
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
      alert("Failed to reorder sliders.");
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