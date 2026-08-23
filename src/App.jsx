import React, { useEffect, useState } from "react";

import { onAuthStateChanged } from "firebase/auth";
import { onValue, ref } from "firebase/database";

import { auth } from "./firebase/firebase";
import { db } from "./firebase/firebase";

import { logout } from "./firebase/auth";
import { subscribeSliders } from "./firebase/sliders";

import Home from "./pages/Home";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import Sliders from "./pages/Sliders";
import Updates from "./pages/Updates";
import Settings from "./pages/Settings";

import Sidebar from "./components/Sidebar";

import "./App.css";

export default function App() {
  /* =========================================================
     AUTH
  ========================================================= */

  const [user, setUser] = useState(undefined);

  /* =========================================================
     NAVIGATION
  ========================================================= */

  const [page, setPage] = useState("home");

  /* =========================================================
     SLIDERS
  ========================================================= */

  const [sliders, setSliders] = useState([]);

  /* =========================================================
     UPDATES
  ========================================================= */

  const [updates, setUpdates] = useState([]);

  /* =========================================================
     AUTH STATE
  ========================================================= */

  useEffect(() => {
    const unsubscribe = onAuthStateChanged(
      auth,
      (currentUser) => {
        setUser(currentUser);
      }
    );

    return unsubscribe;
  }, []);

  /* =========================================================
     SLIDER REALTIME SUBSCRIPTION (Publicly accessible)
  ========================================================= */

  useEffect(() => {
    const unsubscribe = subscribeSliders(
      setSliders
    );

    return unsubscribe;
  }, []);

  /* =========================================================
     UPDATE REALTIME SUBSCRIPTION (Publicly accessible)
  ========================================================= */

  useEffect(() => {
    const updatesRef = ref(db, "updates");

    const unsubscribe = onValue(
      updatesRef,
      (snapshot) => {
        const data = snapshot.val() || {};

        const list = Object.entries(data).map(
          ([id, value]) => ({
            id,
            ...value,
          })
        );

        /*
         * Latest updated items first
         */
        list.sort((a, b) => {
          return (
            (b.updatedAt || b.createdAt || 0) -
            (a.updatedAt || a.createdAt || 0)
          );
        });

        setUpdates(list);
      },
      (error) => {
        console.error(
          "Failed to subscribe to updates:",
          error
        );

        setUpdates([]);
      }
    );

    return unsubscribe;
  }, []);
  /* =========================================================
     ROUTING REDIRECT EFFECT
  ========================================================= */

  useEffect(() => {
    if (user) {
      if (page === "login") {
        setPage("dashboard");
      }
    } else {
      if (page !== "home" && page !== "login") {
        setPage("login");
      }
    }
  }, [user, page]);

  /* =========================================================
     LOADING
  ========================================================= */

  if (user === undefined) {
    return (
      <div className="loading-screen">
        <div className="loading-content">
          <div className="loading-logo">
            M
          </div>

          <span>
            Loading Moco Player...
          </span>
        </div>
      </div>
    );
  }

  /* =========================================================
     ROUTING & LAYOUT
  ========================================================= */

  // Public Home Page (accessible to everyone)
  if (page === "home") {
    return (
      <Home
        user={user}
        setPage={setPage}
        sliders={sliders}
        updates={updates}
      />
    );
  }

  // Public Login Page
  if (page === "login") {
    return <Login onBackToHome={() => setPage("home")} />;
  }

  // Admin pages (requires authentication)
  if (!user) {
    return <Login onBackToHome={() => setPage("home")} />;
  }

  return (
    <div className="app-shell">
      {/* =====================================================
          SIDEBAR
      ===================================================== */}

      <Sidebar
        page={page}
        setPage={setPage}
        onLogout={() => {
          logout();
          setPage("home");
        }}
      />

      {/* =====================================================
          MAIN
      ===================================================== */}

      <main className="main">
        {/* ===================================================
            TOP BAR
        =================================================== */}

        <header className="topbar">
          <div className="mobile-brand">
            <img src="/mocoplayer.png" alt="Moco Player" className="mobile-logo" />
            <span>Moco Manager</span>
          </div>

          <div style={{ display: "flex", gap: "15px", alignItems: "center" }}>
            <button
              onClick={() => setPage("home")}
              className="secondary"
              style={{ padding: "6px 12px", minHeight: "auto", fontSize: "12px", borderRadius: "8px" }}
            >
              View Home Page
            </button>
            <div className="connection">
              <span className="connection-dot" />
              Firebase realtime
            </div>
          </div>
        </header>

        {/* ===================================================
            CONTENT
        =================================================== */}

        <section className="content">
          {/* DASHBOARD */}

          {page === "dashboard" && (
            <Dashboard
              sliders={sliders}
              updates={updates}
            />
          )}

          {/* SLIDERS */}

          {page === "sliders" && (
            <Sliders
              sliders={sliders}
            />
          )}

          {/* UPDATES */}

          {page === "updates" && (
            <Updates
              updates={updates}
            />
          )}

          {/* SETTINGS */}

          {page === "settings" && (
            <Settings />
          )}
        </section>
      </main>
    </div>
  );
}