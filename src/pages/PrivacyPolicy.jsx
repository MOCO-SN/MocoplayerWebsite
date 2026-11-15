import React, { useEffect, useState } from "react";
import {
  Shield,
  ArrowLeft,
  Lock,
  HardDrive,
  Wifi,
  Radio,
  Tv,
  CheckCircle2,
  Mail,
  FileText,
  Menu,
  X,
  Smartphone,
  Sliders as SlidersIcon,
  Download,
  RefreshCw,
} from "lucide-react";
import "./Home.css";

export default function PrivacyPolicy({ user, setPage }) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  }, []);

  const navigateToHomeSection = (sectionId) => {
    setMobileMenuOpen(false);
    setPage("home");
    setTimeout(() => {
      if (sectionId === "home") {
        window.scrollTo({ top: 0, behavior: "smooth" });
      } else {
        const element = document.getElementById(sectionId);
        if (element) {
          element.scrollIntoView({ behavior: "smooth" });
        }
      }
    }, 60);
  };

  return (
    <div className="home-container">
      {/* BACKGROUND DECORATIONS */}
      <div className="bg-glow bg-glow-1" />
      <div className="bg-glow bg-glow-2" />
      <div className="bg-glow bg-glow-3" />

      {/* =====================================================
          FIXED HEADER (DOCK)
      ===================================================== */}
      <header className="home-header">
        <div
          className="header-logo"
          onClick={() => navigateToHomeSection("home")}
          style={{ cursor: "pointer" }}
        >
          <img src="/mocoplayer.png" alt="Moco Player" className="logo-box" />
          <span className="brand-name">Moco Player</span>
        </div>

        <nav className="header-nav">
          <button
            type="button"
            className="nav-link-btn"
            onClick={() => navigateToHomeSection("home")}
          >
            Home
          </button>
          <button
            type="button"
            className="nav-link-btn"
            onClick={() => navigateToHomeSection("features")}
          >
            Features
          </button>
          <button
            type="button"
            className="nav-link-btn"
            onClick={() => navigateToHomeSection("download")}
          >
            Download
          </button>
          <button
            type="button"
            className="nav-link-btn"
            onClick={() => navigateToHomeSection("changelog")}
          >
            Updates
          </button>
          <button
            type="button"
            className="nav-link-btn active"
            style={{ color: "var(--color-primary)", fontWeight: 700 }}
          >
            Privacy Policy
          </button>
        </nav>

        <div className="header-actions">
          {user ? (
            <button
              onClick={() => setPage("dashboard")}
              className="glass-btn primary"
            >
              Dashboard
            </button>
          ) : (
            <button
              onClick={() => setPage("login")}
              className="glass-btn primary"
            >
              <Lock size={14} />
              <span>Admin Login</span>
            </button>
          )}
          {/* MOBILE MENU TOGGLE */}
          <button
            type="button"
            className="mobile-menu-toggle"
            onClick={() => setMobileMenuOpen((prev) => !prev)}
            aria-label="Toggle navigation menu"
          >
            {mobileMenuOpen ? <X size={18} /> : <Menu size={18} />}
          </button>
        </div>
      </header>

      {/* MOBILE DROPDOWN DOCK MENU */}
      {mobileMenuOpen && (
        <div
          className="mobile-dock-overlay"
          onClick={() => setMobileMenuOpen(false)}
        >
          <div
            className="mobile-dock-dropdown"
            onClick={(e) => e.stopPropagation()}
          >
            <button
              type="button"
              className="mobile-nav-item"
              onClick={() => navigateToHomeSection("home")}
            >
              <Smartphone size={16} />
              <span>Home</span>
            </button>
            <button
              type="button"
              className="mobile-nav-item"
              onClick={() => navigateToHomeSection("features")}
            >
              <SlidersIcon size={16} />
              <span>Features</span>
            </button>
            <button
              type="button"
              className="mobile-nav-item"
              onClick={() => navigateToHomeSection("download")}
            >
              <Download size={16} />
              <span>Download</span>
            </button>
            <button
              type="button"
              className="mobile-nav-item"
              onClick={() => navigateToHomeSection("changelog")}
            >
              <RefreshCw size={16} />
              <span>Updates</span>
            </button>
            <button
              type="button"
              className="mobile-nav-item active"
              onClick={() => setMobileMenuOpen(false)}
            >
              <Shield size={16} />
              <span>Privacy Policy</span>
            </button>

            <div className="mobile-nav-divider" />

            {user ? (
              <button
                type="button"
                className="mobile-nav-item"
                onClick={() => {
                  setMobileMenuOpen(false);
                  setPage("dashboard");
                }}
              >
                <Lock size={16} />
                <span>Dashboard</span>
              </button>
            ) : (
              <button
                type="button"
                className="mobile-nav-item"
                onClick={() => {
                  setMobileMenuOpen(false);
                  setPage("login");
                }}
              >
                <Lock size={16} />
                <span>Admin Login</span>
              </button>
            )}
          </div>
        </div>
      )}

      {/* =====================================================
          PRIVACY POLICY CONTENT
      ===================================================== */}
      <main className="privacy-page">
        <div className="privacy-top-actions">
          <button
            type="button"
            onClick={() => setPage("home")}
            className="glass-btn secondary"
          >
            <ArrowLeft size={16} />
            <span>Back to Home</span>
          </button>
          <span className="privacy-badge">
            <Shield size={14} />
            <span>Official Policy · Effective: November 2026</span>
          </span>
        </div>

        <article className="privacy-card">
          <header className="privacy-title-area">
            <h1>Privacy Policy</h1>
            <p className="privacy-subtitle">
              Your privacy is fundamental to our mission. Learn how Moco Player and our services handle permissions and protect your data.
            </p>
          </header>

          {/* QUICK HIGHLIGHTS */}
          <div className="privacy-highlights">
            <div className="highlight-item">
              <CheckCircle2 size={18} className="highlight-icon" />
              <div>
                <strong>Zero Personal Tracking</strong>
                <p>We do not collect names, phone numbers, or personal profiles.</p>
              </div>
            </div>
            <div className="highlight-item">
              <CheckCircle2 size={18} className="highlight-icon" />
              <div>
                <strong>Local-First Playback</strong>
                <p>Your video and audio files stay on your device and are never uploaded.</p>
              </div>
            </div>
            <div className="highlight-item">
              <CheckCircle2 size={18} className="highlight-icon" />
              <div>
                <strong>No Ad Network Profiling</strong>
                <p>No behavioral ad tracking SDKs or cross-app analytics scripts.</p>
              </div>
            </div>
          </div>

          <hr className="privacy-divider" />

          {/* SECTION 1 */}
          <section className="policy-section">
            <h2>1. Introduction & Scope</h2>
            <p>
              This Privacy Policy explains the privacy practices for the <strong>Moco Player</strong> Android Application and the <strong>Moco Player Website & Management Portal</strong> (collectively referred to as the &quot;Service&quot;).
            </p>
            <p>
              By installing or using Moco Player or visiting our website, you agree to the terms described in this policy. If you do not agree with any part of this document, please discontinue use of the application.
            </p>
          </section>

          {/* SECTION 2 */}
          <section className="policy-section">
            <h2>2. Information We Do NOT Collect</h2>
            <p>
              Moco Player is built as a standalone high-performance media player. For regular users of the Android application:
            </p>
            <ul>
              <li>We do <strong>not</strong> collect your name, email address, phone number, or physical location.</li>
              <li>We do <strong>not</strong> read, copy, upload, or transmit the contents of your local video or audio files.</li>
              <li>We do <strong>not</strong> record your local media playback history or store it on any remote server.</li>
              <li>We do <strong>not</strong> sell, rent, or trade user data to advertisers or data brokers.</li>
            </ul>
          </section>

          {/* SECTION 3 */}
          <section className="policy-section">
            <h2>3. Android App Permissions & Why They Are Needed</h2>
            <p>
              To deliver smooth 4K playback, subtitle loading, and background audio streaming, Moco Player requires specific Android system permissions:
            </p>

            <div className="permissions-grid">
              <div className="permission-item">
                <div className="perm-header">
                  <HardDrive size={18} />
                  <strong>Storage & Media Access</strong>
                </div>
                <code>READ_MEDIA_VIDEO / READ_MEDIA_AUDIO</code>
                <p>
                  Allows the player to index and play local media files stored on your device or SD card. Files are processed locally on your hardware.
                </p>
              </div>

              <div className="permission-item">
                <div className="perm-header">
                  <Wifi size={18} />
                  <strong>Internet & Network State</strong>
                </div>
                <code>INTERNET / ACCESS_NETWORK_STATE</code>
                <p>
                  Used to check for official application updates, stream network media URLs specified by you, and fetch announcement banners.
                </p>
              </div>

              <div className="permission-item">
                <div className="perm-header">
                  <Radio size={18} />
                  <strong>Foreground Service</strong>
                </div>
                <code>FOREGROUND_SERVICE_MEDIA_PLAYBACK</code>
                <p>
                  Keeps audio playing uninterrupted when your phone screen is turned off or when switching between applications.
                </p>
              </div>

              <div className="permission-item">
                <div className="perm-header">
                  <Tv size={18} />
                  <strong>Picture-in-Picture & Display</strong>
                </div>
                <code>SYSTEM_ALERT_WINDOW / PIP</code>
                <p>
                  Allows seamless mini floating video window playback while browsing other apps on supported devices.
                </p>
              </div>
            </div>
          </section>

          {/* SECTION 4 */}
          <section className="policy-section">
            <h2>4. Remote Content & Third-Party Infrastructure</h2>
            <p>
              The Service utilizes trusted cloud infrastructure to deliver remote updates and banners:
            </p>
            <ul>
              <li>
                <strong>Google Firebase Realtime Database:</strong> Used by the application to read the latest published app version, release notes, and banner configuration. No personally identifiable data from viewers is logged.
              </li>
              <li>
                <strong>Cloudinary CDN:</strong> Used to host and deliver optimized banner graphics and promotional posters.
              </li>
              <li>
                <strong>Firebase Authentication:</strong> Used exclusively for authorized administrators logging into the content management system.
              </li>
            </ul>
          </section>

          {/* SECTION 5 */}
          <section className="policy-section">
            <h2>5. Data Security</h2>
            <p>
              We implement industry-standard encryption protocols (TLS/HTTPS) for all network communication between the app and remote servers. Our database rules enforce strict role-based access to safeguard management operations.
            </p>
          </section>

          {/* SECTION 6 */}
          <section className="policy-section">
            <h2>6. Children&apos;s Privacy</h2>
            <p>
              Moco Player does not target or knowingly collect information from children under the age of 13. The media player functions offline and does not solicit personal identities.
            </p>
          </section>

          {/* SECTION 7 */}
          <section className="policy-section">
            <h2>7. Changes to This Policy</h2>
            <p>
              We may update this Privacy Policy periodically to reflect new features or regulatory requirements. Any modifications will be posted here with an updated effective date.
            </p>
          </section>

          {/* SECTION 8 */}
          <section className="policy-section contact-section">
            <h2>8. Contact Us</h2>
            <p>
              If you have any questions, suggestions, or concerns regarding this Privacy Policy or your data, please contact us:
            </p>
            <div className="contact-card">
              <Mail size={18} />
              <div>
                <strong>Support & Inquiries</strong>
                <p>Email: <a href="mailto:mocoplayer@mocosn.in">mocoplayer@mocosn.in</a></p>
              </div>
            </div>
          </section>
        </article>
      </main>

      {/* =====================================================
          FOOTER
      ===================================================== */}
      <footer className="home-footer">
        <div className="footer-content">
          <div
            className="footer-brand"
            onClick={() => setPage("home")}
            style={{ cursor: "pointer" }}
          >
            <img src="/mocoplayer.png" alt="Moco Player" className="logo-box" />
            <span>Moco Player</span>
          </div>

          <p className="footer-copyright">
            © {new Date().getFullYear()} Moco Player. Made for high quality streaming.
          </p>

          <div className="footer-links">
            <button
              type="button"
              className="admin-footer-link"
              onClick={() => setPage("home")}
            >
              Home
            </button>
            <button
              type="button"
              className="admin-footer-link"
              onClick={() => navigateToHomeSection("features")}
            >
              Features
            </button>
            <button
              type="button"
              className="admin-footer-link"
              onClick={() => navigateToHomeSection("download")}
            >
              Download
            </button>
            <button
              type="button"
              className="admin-footer-link"
              onClick={() => setPage("login")}
            >
              Admin Access
            </button>
          </div>
        </div>
      </footer>
    </div>
  );
}
