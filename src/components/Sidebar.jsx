import React from "react";

import {
  Home,
  Image,
  LayoutDashboard,
  LogOut,
  Settings,
  RefreshCw,
  Shield,
} from "lucide-react";

export default function Sidebar({ page, setPage, onLogout }) {
  const items = [
    {
      id: "home",
      label: "Home Page",
      icon: Home,
    },
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
    {
      id: "privacy",
      label: "Privacy Policy",
      icon: Shield,
    },
  ];

  return (
    <aside className="sidebar">
      <div className="brand">
        <img src="/mocoplayer.png" alt="Moco Player" className="brand-mark" />

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