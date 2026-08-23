import React from "react";
import {
  Image,
  CheckCircle2,
  Radio,
  Eye,
  RefreshCw,
  Download,
  Info,
} from "lucide-react";

export default function Dashboard({ sliders = [], updates = [] }) {
  const activeSliders = sliders.filter((s) => s.active).length;
  const totalUpdates = updates.length;
  const activeUpdates = updates.filter((u) => u.active !== false).length;
  const latestVersion = updates.length > 0 ? updates[0].version : "—";

  return (
    <>
      <div className="page-heading">
        <div>
          <span className="eyebrow">MOCO PLAYER</span>
          <h1>Dashboard</h1>
          <p>Overview of your remote content and app updates.</p>
        </div>
      </div>

      <div className="stats-grid">
        <div className="stat-card">
          <Image />
          <span>Total sliders</span>
          <strong>{sliders.length}</strong>
        </div>
        <div className="stat-card">
          <CheckCircle2 />
          <span>Active sliders</span>
          <strong>{activeSliders}</strong>
        </div>
        <div className="stat-card">
          <RefreshCw />
          <span>App Updates</span>
          <strong>{totalUpdates} ({activeUpdates} Active)</strong>
        </div>
        <div className="stat-card">
          <Eye />
          <span>Latest Release</span>
          <strong>v{latestVersion}</strong>
        </div>
      </div>

      <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "20px", marginTop: "20px" }} className="dashboard-grid-two-col">
        {/* SLIDER PREVIEW */}
        <div className="dashboard-preview" style={{ marginTop: 0 }}>
          <div className="section-title">
            <div>
              <h2>Live slider preview</h2>
              <p>These are the banners currently marked active.</p>
            </div>
          </div>

          <div className="preview-grid" style={{ gridTemplateColumns: "1fr", marginTop: "15px" }}>
            {sliders.filter(s => s.active).map((slider) => (
              <div className="preview-item" key={slider.id}>
                <img src={slider.imageUrl} alt={slider.title} />
                <div>
                  <strong>{slider.title || "Untitled"}</strong>
                  <span>Position {slider.position}</span>
                </div>
              </div>
            ))}
            {!activeSliders && <div className="empty-state">No active sliders.</div>}
          </div>
        </div>

        {/* UPDATES SUMMARY */}
        <div className="dashboard-preview" style={{ marginTop: 0 }}>
          <div className="section-title">
            <div>
              <h2>Recent releases</h2>
              <p>The latest updates registered in the database.</p>
            </div>
          </div>

          <div style={{ display: "grid", gap: "12px", marginTop: "15px" }}>
            {updates.slice(0, 5).map((update) => (
              <div key={update.id} style={{
                display: "flex",
                alignItems: "center",
                justifyContent: "space-between",
                padding: "12px",
                borderRadius: "10px",
                border: "1px solid #242529",
                background: "#ffffff"
              }}>
                <div>
                  <div style={{ display: "flex", alignItems: "center", gap: "6px" }}>
                    <strong style={{ fontSize: "13px" }}>{update.title || "Moco Player"}</strong>
                    <span className="version-pill" style={{ padding: "2px 6px", fontSize: "10px" }}>v{update.version}</span>
                  </div>
                  <span style={{ fontSize: "11px", color: "#70727a", display: "block", marginTop: "3px" }}>
                    Released: {update.releaseDate || "No date"} · Size: {update.fileSize || "Unknown"}
                  </span>
                </div>
                <span className={update.active !== false ? "status on" : "status off"}>
                  {update.active !== false ? "Active" : "Disabled"}
                </span>
              </div>
            ))}
            {totalUpdates === 0 && <div className="empty-state">No updates found.</div>}
          </div>
        </div>
      </div>
    </>
  );
}
