import React from "react";

import {
  Image,
  LayoutDashboard,
  LogOut,
  Settings,
  RefreshCw,
} from "lucide-react";

export default function Sidebar({ page, setPage, onLogout }) {
  const items = [
    {
      id: "dashboard",
      label: "Dashboard",
      icon: LayoutDashboard,
    },
    {
      id: "sliders",
      label: "Sliders",
      icon: Image,
    },
    {
      id: "updates",
      label: "Updates",
      icon: RefreshCw,
    },
    {
      id: "settings",
      label: "Settings",
      icon: Settings,
    },
  ];

  return (
    <aside className="sidebar">
      <div className="brand">
        <div className="brand-mark">M</div>

        <div>
          <strong>Moco Player</strong>
          <span>Manager</span>
        </div>
      </div>

      <nav>
        {items.map(({ id, label, icon: Icon }) => (
          <button
            key={id}
            type="button"
            className={
              page === id
                ? "nav-item active"
                : "nav-item"
            }
            onClick={() => setPage(id)}
          >
            <Icon size={19} />
            <span>{label}</span>
          </button>
        ))}
      </nav>

      <button
        type="button"
        className="nav-item logout"
        onClick={onLogout}
      >
        <LogOut size={19} />
        <span>Logout</span>
      </button>
    </aside>
  );
}