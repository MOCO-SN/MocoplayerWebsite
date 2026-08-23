import React, { useState, useEffect } from "react";
import {
  Play,
  Download,
  Cpu,
  Sliders as SlidersIcon,
  Tv,
  Shield,
  ChevronLeft,
  ChevronRight,
  Info,
  ExternalLink,
  Lock,
  RefreshCw,
  Zap,
  Smartphone,
} from "lucide-react";
import "./Home.css";

export default function Home({ user, setPage, sliders = [], updates = [] }) {
  const activeSliders = sliders.filter((s) => s.active);
  const activeUpdates = updates.filter((u) => u.active !== false);
  const latestRelease = activeUpdates[0];
  const previousReleases = activeUpdates.slice(1);

  /* =========================================================
     SLIDER CAROUSEL STATE
  ========================================================= */

  const [currentSlide, setCurrentSlide] = useState(0);

  useEffect(() => {
    if (currentSlide >= activeSliders.length && activeSliders.length > 0) {
      setCurrentSlide(0);
    }
  }, [activeSliders.length, currentSlide]);

  useEffect(() => {
    if (activeSliders.length <= 1) return;

    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % activeSliders.length);
    }, 6000);

    return () => clearInterval(interval);
  }, [activeSliders]);

  const prevSlide = () => {
    if (activeSliders.length === 0) return;
    setCurrentSlide((prev) => (prev - 1 + activeSliders.length) % activeSliders.length);
  };

  const nextSlide = () => {
    if (activeSliders.length === 0) return;
    setCurrentSlide((prev) => (prev + 1) % activeSliders.length);
  };

  return (
    <div className="home-container">
      {/* BACKGROUND DECORATIONS */}
      <div className="bg-glow bg-glow-1" />
      <div className="bg-glow bg-glow-2" />
      <div className="bg-glow bg-glow-3" />

      {/* =====================================================
          HEADER
      ===================================================== */}
      <header className="home-header">
        <div className="header-logo">
          <img src="/mocoplayer.png" alt="Moco Player" className="logo-box" />
          <span className="brand-name">Moco Player</span>
        </div>

        <nav className="header-nav">
          <a href="#features">Features</a>
          <a href="#download">Download</a>
          {activeUpdates.length > 0 && <a href="#changelog">Updates</a>}
        </nav>

        <div className="header-actions">
          {user ? (
            <>
              <button
                onClick={() => setPage("dashboard")}
                className="glass-btn primary"
              >
                Dashboard
              </button>
              <button
                onClick={() => {
                  import("../firebase/auth").then(({ logout }) => {
                    logout().then(() => setPage("home"));
                  });
                }}
                className="glass-btn secondary logout-btn"
              >
                Logout
              </button>
            </>
          ) : (
            <button
              onClick={() => setPage("login")}
              className="glass-btn primary"
            >
              <Lock size={14} />
              <span>Admin Login</span>
            </button>
          )}
        </div>
      </header>

      {/* =====================================================
          HERO & SLIDER SECTION
      ===================================================== */}
      <section className="home-hero">
        <div className="hero-content">
          <h1>
            The Next Generation<br />
            <span>Media Player</span>
          </h1>
          <p className="hero-sub">
            Experience smooth 4K hardware accelerated media playback on Android with live updates and dynamic remote configurations.
          </p>

          <div className="hero-actions">
            {latestRelease?.downloadUrl ? (
              <a href={latestRelease.downloadUrl} className="glass-btn primary cta">
                <Download size={18} />
                <span>Download APK ({latestRelease.fileSize || "Latest"})</span>
              </a>
            ) : (
              <a href="#download" className="glass-btn primary cta">
                <Smartphone size={18} />
                <span>Get Moco Player</span>
              </a>
            )}
            <a href="#features" className="glass-btn secondary cta">
              Learn More
            </a>
          </div>
        </div>

        {/* HERO IMAGE SLIDER / FALLBACK */}
        <div className="hero-slider-container">
          {activeSliders.length > 0 ? (
            <div className="slider-wrapper">
              <div
                className="slider-track"
                style={{ transform: `translateX(-${currentSlide * 100}%)` }}
              >
                {activeSliders.map((slider) => (
                  <div className="slide-item" key={slider.id}>
                    <img src={slider.imageUrl} alt={slider.title} />
                    <div className="slide-overlay">
                      <h3>{slider.title || "Featured banner"}</h3>
                      <p>{slider.description || "Active remote content slider"}</p>
                    </div>
                  </div>
                ))}
              </div>

              {activeSliders.length > 1 && (
                <>
                  <button className="slider-arrow prev" onClick={prevSlide}>
                    <ChevronLeft size={20} />
                  </button>
                  <button className="slider-arrow next" onClick={nextSlide}>
                    <ChevronRight size={20} />
                  </button>

                  <div className="slider-dots">
                    {activeSliders.map((_, i) => (
                      <span
                        key={i}
                        className={`slider-dot ${i === currentSlide ? "active" : ""}`}
                        onClick={() => setCurrentSlide(i)}
                      />
                    ))}
                  </div>
                </>
              )}
            </div>
          ) : (
            <div className="slider-fallback">
              <div className="fallback-inner">
                <span className="fallback-badge">
                  <Play size={20} />
                </span>
                <h3>Moco Player Live</h3>
                <p>Add active sliders in the administration manager to display dynamic remote banners here.</p>
              </div>
            </div>
          )}
        </div>
      </section>

      {/* =====================================================
          FEATURES SECTION
      ===================================================== */}
      <section id="features" className="home-features">
        <div className="section-header">
          <span className="eyebrow">FEATURES</span>
          <h2>Designed for Android</h2>
          <p>Moco Player offers lightweight, high-performance playback with a modern iOS-inspired glass look.</p>
        </div>

        <div className="features-grid">
          <div className="feature-card">
            <div className="feature-icon"><Cpu size={24} /></div>
            <h3>Hardware Acceleration</h3>
            <p>Utilizes advanced HW+ decoding to render high bitrate full HD and 4K media smoothly without battery drain.</p>
          </div>

          <div className="feature-card">
            <div className="feature-icon"><SlidersIcon size={24} /></div>
            <h3>Remote Content Sliders</h3>
            <p>Synchronize sliders and display active marketing banners or content links dynamically using Firebase.</p>
          </div>

          <div className="feature-card">
            <div className="feature-icon"><Tv size={24} /></div>
            <h3>Sleek Cast Support</h3>
            <p>Cast local files directly to compatible TV screen devices. Support for background audio and multi-audio tracks.</p>
          </div>

          <div className="feature-card">
            <div className="feature-icon"><Shield size={24} /></div>
            <h3>Clean & Secured</h3>
            <p>100% open, private, and secured. No invasive permissions or tracking code. Just pure entertainment.</p>
          </div>
        </div>
      </section>

      {/* =====================================================
          DOWNLOAD SECTION
      ===================================================== */}
      <section id="download" className="home-download">
        <div className="section-header">
          <span className="eyebrow">RELEASES</span>
          <h2>Download Latest Version</h2>
        </div>

        {latestRelease ? (
          <div className="download-showcase">
            <div className="download-glass-card">
              <div className="release-badge">LATEST RELEASE</div>
              <div className="release-title-row">
                <div>
                  <h3>{latestRelease.title || "Moco Player Mobile"}</h3>
                  <p className="subtitle">{latestRelease.subtitle || "Official Android App"}</p>
                </div>
                <span className="version-pill">v{latestRelease.version}</span>
              </div>

              {latestRelease.imageUrl && (
                <div className="release-media">
                  <img src={latestRelease.imageUrl} alt="Release feature" />
                </div>
              )}

              {latestRelease.changes && (
                <div className="release-changes">
                  <h4>What's New</h4>
                  <p>{latestRelease.changes}</p>
                </div>
              )}

              {latestRelease.patchNotes && (
                <div className="release-patch-notes">
                  <h4>Patch Notes</h4>
                  <pre>{latestRelease.patchNotes}</pre>
                </div>
              )}

              <div className="release-meta-row">
                <div className="meta-item">
                  <span className="meta-label">Release Date</span>
                  <span className="meta-val">{latestRelease.releaseDate || "Today"}</span>
                </div>
                <div className="meta-item">
                  <span className="meta-label">File Size</span>
                  <span className="meta-val">{latestRelease.fileSize || "25 MB"}</span>
                </div>
              </div>

              {latestRelease.downloadUrl && (
                <a
                  href={latestRelease.downloadUrl}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="glass-btn primary download-action"
                >
                  <Download size={20} />
                  <span>Download APK Now</span>
                </a>
              )}
            </div>
          </div>
        ) : (
          <div className="download-fallback">
            <div className="fallback-inner">
              <RefreshCw className="spin" size={32} />
              <h3>Fetching releases...</h3>
              <p>No active updates registered. Login to the admin manager and create your first update.</p>
            </div>
          </div>
        )}
      </section>

      {/* =====================================================
          RELEASE LOGS HISTORY
      ===================================================== */}
      {previousReleases.length > 0 && (
        <section id="changelog" className="home-changelog">
          <div className="section-header">
            <span className="eyebrow">HISTORY</span>
            <h2>Version History</h2>
          </div>

          <div className="changelog-timeline">
            {previousReleases.map((release) => (
              <div className="timeline-item" key={release.id}>
                <div className="timeline-dot" />
                <div className="timeline-glass-card">
                  <div className="timeline-header">
                    <div>
                      <h4>{release.title || "Moco Player Update"}</h4>
                      <span className="timeline-date">{release.releaseDate} · {release.fileSize}</span>
                    </div>
                    <span className="timeline-version">v{release.version}</span>
                  </div>

                  <p className="timeline-changes">{release.changes}</p>

                  {release.downloadUrl && (
                    <a
                      href={release.downloadUrl}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="timeline-download"
                    >
                      <Download size={14} />
                      <span>Download v{release.version}</span>
                    </a>
                  )}
                </div>
              </div>
            ))}
          </div>
        </section>
      )}

      {/* =====================================================
          FOOTER
      ===================================================== */}
      <footer className="home-footer">
        <div className="footer-content">
          <div className="footer-brand">
            <img src="/mocoplayer.png" alt="Moco Player" className="logo-box" />
            <span>Moco Player</span>
          </div>

          <p className="footer-copyright">
            © {new Date().getFullYear()} Moco Player. Made for high quality streaming.
          </p>

          <div className="footer-links">
            <a href="#features">Features</a>
            <a href="#download">Download</a>
            <button onClick={() => setPage("login")} className="admin-footer-link">
              Admin Access
            </button>
          </div>
        </div>
      </footer>
    </div>
  );
}
