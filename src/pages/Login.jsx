import React, { useState } from "react";
import { LockKeyhole, Mail, ShieldCheck } from "lucide-react";
import { login } from "../firebase/auth";

export default function Login({ onBackToHome }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [busy, setBusy] = useState(false);
  const [error, setError] = useState("");

  async function submit(e) {
    e.preventDefault();
    setError("");
    setBusy(true);
    try {
      await login(email, password);
    } catch (err) {
      setError(err.code?.replace("auth/", "").replaceAll("-", " ") || "Login failed");
    } finally {
      setBusy(false);
    }
  }

  return (
    <main className="login-page">
      <div className="login-glow glow-one" />
      <div className="login-glow glow-two" />

      <form className="login-card" onSubmit={submit}>
        <img src="/mocoplayer.png" alt="Moco Player" className="login-logo" />
        <span className="eyebrow"><ShieldCheck size={14} /> ADMIN ACCESS</span>
        <h1>Moco Player<br /><span>Manager</span></h1>
        <p>Manage banners and remote content for your Moco Player app.</p>

        <label>
          <Mail size={17} />
          <input value={email} onChange={(e) => setEmail(e.target.value)} type="email" placeholder="Admin email" required />
        </label>

        <label>
          <LockKeyhole size={17} />
          <input value={password} onChange={(e) => setPassword(e.target.value)} type="password" placeholder="Password" required />
        </label>

        {error && <div className="error-box">{error}</div>}

        <button className="primary login-button" disabled={busy}>
          {busy ? "Signing in..." : "Sign in"}
        </button>

        {onBackToHome && (
          <button
            type="button"
            className="secondary"
            onClick={onBackToHome}
            style={{ width: "100%", marginTop: "12px" }}
          >
            Back to Home
          </button>
        )}
      </form>
    </main>
  );
}
