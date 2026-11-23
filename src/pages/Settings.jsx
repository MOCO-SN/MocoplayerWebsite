import React, { useState } from "react";
import {
  Shield,
  Copy,
  Check,
  CheckCircle2,
  XCircle,
  Loader2,
  Database,
  Cloud,
  FileCode,
  AlertTriangle
} from "lucide-react";
import { get, ref, update } from "firebase/database";
import { db } from "../firebase/firebase";

export default function Settings({ user }) {
  const [copied, setCopied] = useState(false);
  const [testing, setTesting] = useState(false);
  const [testResult, setTestResult] = useState(null);

  const copyUid = () => {
    if (user?.uid) {
      navigator.clipboard.writeText(user.uid);
      setCopied(true);
      setTimeout(() => setCopied(false), 2000);
    }
  };

  const testWritePermission = async () => {
    if (!user) {
      setTestResult({
        success: false,
        message: "You are not logged in. Please log in first."
      });
      return;
    }

    setTesting(true);
    setTestResult(null);

    try {
      // 1. Check if user's UID exists under /admins/{uid} as required by your rules
      const adminRef = ref(db, `admins/${user.uid}`);
      const adminSnapshot = await get(adminRef);
      const adminData = adminSnapshot.val();

      if (!adminData || adminData.role !== "admin") {
        setTestResult({
          success: false,
          message:
            `Missing Admin Role: Your rules require 'root.child("admins").child(auth.uid).child("role").val() == "admin"'. ` +
            `However, '/admins/${user.uid}' does not exist or its role is not 'admin'. ` +
            `Please copy your UID above, go to Firebase Console > Realtime Database > Data tab, create a node 'admins/${user.uid}', and add { "role": "admin" }.`
        });
        return;
      }

      setTestResult({
        success: true,
        message: `Verified! Your account has role: "admin" under '/admins/${user.uid}', and is fully authorized to update sliders and releases.`
      });
    } catch (error) {
      console.error("Test write error:", error);
      const isPermissionDenied =
        error?.code === "PERMISSION_DENIED" ||
        (error?.message || "").toLowerCase().includes("permission_denied") ||
        (error?.message || "").toLowerCase().includes("permission denied");

      if (isPermissionDenied) {
        setTestResult({
          success: false,
          message:
            "Permission Denied: Firebase Realtime Database rules blocked the request. Please check your rules in the Firebase Console (Realtime Database > Rules tab)."
        });
      } else {
        setTestResult({
          success: false,
          message: `Error: ${error?.message || "Unable to check database permissions."}`
        });
      }
    } finally {
      setTesting(false);
    }
  };

  return (
    <>
      <div className="page-heading">
        <div>
          <span className="eyebrow">CONFIGURATION</span>
          <h1>Settings & Diagnostics</h1>
          <p>Account diagnostics, permissions, and service configuration for Moco Player Manager.</p>
        </div>
      </div>

      {/* AUTH STATUS & UID */}
      <div className="settings-card">
        <h2>
          <Shield size={20} style={{ verticalAlign: "middle", marginRight: "8px", color: "var(--color-primary)" }} />
          Administrator Account
        </h2>

        <div className="setting-row">
          <div>
            <strong>Signed-in Email</strong>
            <span>{user?.email || "Not signed in"}</span>
          </div>
          <b className={user ? "status on" : "status off"}>
            {user ? "Authenticated" : "Unauthenticated"}
          </b>
        </div>

        <div className="setting-row">
          <div>
            <strong>Firebase User UID</strong>
            <span style={{ fontFamily: "monospace", fontSize: "12px", userSelect: "all" }}>
              {user?.uid || "—"}
            </span>
          </div>
          {user?.uid && (
            <button
              type="button"
              className="secondary"
              onClick={copyUid}
              style={{ display: "inline-flex", alignItems: "center", gap: "6px", fontSize: "12px", padding: "6px 12px" }}
            >
              {copied ? <Check size={14} color="#16a34a" /> : <Copy size={14} />}
              <span>{copied ? "Copied UID!" : "Copy UID"}</span>
            </button>
          )}
        </div>

        <div className="setting-row">
          <div>
            <strong>Admin Permission Verification</strong>
            <span>Verify whether this account has the &apos;admin&apos; role in Firebase Realtime Database.</span>
          </div>
          <button
            type="button"
            className="primary"
            onClick={testWritePermission}
            disabled={testing || !user}
            style={{ display: "inline-flex", alignItems: "center", gap: "6px", fontSize: "12px", padding: "8px 14px" }}
          >
            {testing ? <Loader2 size={14} style={{ animation: "spin 1s linear infinite" }} /> : <Database size={14} />}
            <span>{testing ? "Checking..." : "Verify Admin Access"}</span>
          </button>
        </div>

        {testResult && (
          <div style={{
            marginTop: "16px",
            padding: "14px 18px",
            borderRadius: "14px",
            display: "flex",
            alignItems: "flex-start",
            gap: "10px",
            background: testResult.success ? "rgba(34, 197, 94, 0.1)" : "rgba(239, 68, 68, 0.1)",
            border: `1px solid ${testResult.success ? "rgba(34, 197, 94, 0.25)" : "rgba(239, 68, 68, 0.25)"}`,
            color: testResult.success ? "#15803d" : "#b91c1c",
            fontSize: "13px",
            lineHeight: "1.5"
          }}>
            {testResult.success ? <CheckCircle2 size={20} style={{ flexShrink: 0, marginTop: "2px" }} /> : <XCircle size={20} style={{ flexShrink: 0, marginTop: "2px" }} />}
            <div>{testResult.message}</div>
          </div>
        )}
      </div>

      {/* CONNECTED SERVICES */}
      <div className="settings-card">
        <h2>
          <Cloud size={20} style={{ verticalAlign: "middle", marginRight: "8px", color: "var(--color-primary)" }} />
          Connected Services
        </h2>

        <div className="setting-row">
          <div>
            <strong>Firebase Realtime Database</strong>
            <span>Stores slider metadata, updates, and synchronizes banners in real time.</span>
          </div>
          <b className="status on">Connected</b>
        </div>

        <div className="setting-row">
          <div>
            <strong>Cloudinary</strong>
            <span>Stores and delivers responsive banner images for Android.</span>
          </div>
          <b className="status on">Configured</b>
        </div>

        <div className="settings-note">
          Never put your Cloudinary API Secret in this React application. Use an unsigned upload preset for direct browser uploads, or move signing/deletion operations to a trusted backend.
        </div>
      </div>

      {/* DATABASE RULES GUIDE */}
      <div className="settings-card">
        <h2>
          <FileCode size={20} style={{ verticalAlign: "middle", marginRight: "8px", color: "var(--color-primary)" }} />
          Active Firebase Database Rules
        </h2>
        <p style={{ fontSize: "13px", color: "var(--color-text-muted)", margin: "8px 0 16px" }}>
          Your Realtime Database rules require authenticated users with <code>role: &quot;admin&quot;</code> under <code>/admins/&lt;uid&gt;</code> to modify sliders and updates:
        </p>

        <pre style={{
          background: "#0f172a",
          color: "#f8fafc",
          padding: "16px",
          borderRadius: "14px",
          fontSize: "12px",
          lineHeight: "1.6",
          overflowX: "auto",
          fontFamily: "monospace"
        }}>
{`{
  "rules": {
    "sliders": {
      ".read": true,
      ".write": "auth != null && root.child('admins').child(auth.uid).child('role').val() == 'admin'",
      "$sliderId": {
        ".validate": "newData.hasChildren(['imageUrl', 'active', 'position'])",
        "imageUrl": {
          ".validate": "newData.isString()"
        },
        "active": {
          ".validate": "newData.isBoolean()"
        },
        "position": {
          ".validate": "newData.isNumber()"
        }
      }
    },
    "updates": {
      ".read": true,
      ".write": "auth != null && root.child('admins').child(auth.uid).child('role').val() == 'admin'"
    },
    "admins": {
      "$uid": {
        ".read": "auth != null && auth.uid == $uid",
        ".write": false
      }
    },
    "apps": {
      ".read": true,
      ".write": true
    }
  }
}`}
        </pre>
      </div>
    </>
  );
}
