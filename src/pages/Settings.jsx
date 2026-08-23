import React from "react";
import {
  Settings as SettingsIcon,
  Save,
} from "lucide-react";

export default function Settings() {
  return (
    <>
      <div className="page-heading">
        <div>
          <span className="eyebrow">CONFIGURATION</span>
          <h1>Settings</h1>
          <p>Environment information for the Moco Player Manager.</p>
        </div>
      </div>

      <div className="settings-card">
        <h2>Connected services</h2>
        <div className="setting-row">
          <div>
            <strong>Firebase Realtime Database</strong>
            <span>Stores slider metadata and synchronizes changes.</span>
          </div>
          <b className="status on">Connected</b>
        </div>
        <div className="setting-row">
          <div>
            <strong>Cloudinary</strong>
            <span>Stores and delivers the slider images.</span>
          </div>
          <b className="status on">Configured</b>
        </div>
        <div className="settings-note">
          Never put your Cloudinary API Secret in this React application. Use an unsigned upload preset for direct browser uploads, or move signing/deletion operations to a trusted backend.
        </div>
      </div>
    </>
  );
}
