import React, { useMemo, useState } from "react";

import {
  Plus,
  Search,
  RefreshCw,
} from "lucide-react";

import UpdateCard from "../components/UpdateCard";
import UpdateForm from "../components/UpdateForm";

import {
  createUpdate,
  deleteUpdate,
  updateAppUpdate,
  toggleUpdateActive,
} from "../firebase/updates";

export default function Updates({ updates = [] }) {
  const [query, setQuery] = useState("");
  const [editing, setEditing] = useState(null);
  const [formOpen, setFormOpen] = useState(false);

  const filtered = useMemo(() => {
    const q = query.toLowerCase().trim();

    if (!q) {
      return updates;
    }

    return updates.filter((update) =>
      [
        update.title,
        update.subtitle,
        update.version,
        update.changes,
        update.patchNotes,
      ]
        .filter(Boolean)
        .join(" ")
        .toLowerCase()
        .includes(q)
    );
  }, [updates, query]);

  const openCreate = () => {
    setEditing(null);
    setFormOpen(true);
  };

  const openEdit = (update) => {
    setEditing(update);
    setFormOpen(true);
  };

  const closeForm = () => {
    setEditing(null);
    setFormOpen(false);
  };

  const save = async (data) => {
    if (editing) {
      await updateAppUpdate(editing.id, data);
    } else {
      await createUpdate(data);
    }

    closeForm();
  };

  const remove = async (update) => {
    const title = update.title || "this update";

    if (!window.confirm(`Delete "${title}"?`)) {
      return;
    }

    try {
      await deleteUpdate(update.id);
    } catch (error) {
      console.error(error);
      alert("Failed to delete update.");
    }
  };

  const toggle = async (update) => {
    try {
      // If update.active is undefined, it defaults to true, so we toggle to false.
      const currentActive = update.active !== false;
      await toggleUpdateActive(update.id, !currentActive);
    } catch (error) {
      console.error("Failed to toggle update:", error);
      alert("Failed to update status.");
    }
  };

  return (
    <>
      <div className="page-heading">
        <div>
          <span className="eyebrow">
            APP RELEASES
          </span>

          <h1>
            Update Manager
          </h1>

          <p>
            Manage Moco Player app updates and
            release information.
          </p>
        </div>

        <button
          type="button"
          className="primary add-button"
          onClick={openCreate}
        >
          <Plus size={18} />
          <span>Add update</span>
        </button>
      </div>

      {formOpen && (
        <UpdateForm
          editing={editing}
          onSave={save}
          onCancel={closeForm}
        />
      )}

      <div className="toolbar">
        <div className="search-box">
          <Search size={18} />

          <input
            type="text"
            value={query}
            onChange={(event) =>
              setQuery(event.target.value)
            }
            placeholder="Search updates..."
          />
        </div>

        <span className="count-pill">
          {filtered.length}{" "}
          {filtered.length === 1
            ? "update"
            : "updates"}
        </span>
      </div>

      <div className="updates-list">
        {filtered.map((update) => (
          <UpdateCard
            key={update.id}
            update={update}
            onEdit={openEdit}
            onDelete={remove}
            onToggle={toggle}
          />
        ))}

        {filtered.length === 0 && (
          <div className="empty-state large">
            <RefreshCw size={32} />

            <h3>
              {query
                ? "No updates found"
                : "No updates yet"}
            </h3>

            <p>
              {query
                ? "Try another search."
                : "Create your first Moco Player update."}
            </p>

            {!query && (
              <button
                type="button"
                className="primary"
                onClick={openCreate}
              >
                <Plus size={18} />
                Add first update
              </button>
            )}
          </div>
        )}
      </div>
    </>
  );
}