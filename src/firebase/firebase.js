import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getDatabase } from "firebase/database";

// Configuration with Vite environment variables support and production fallback
const firebaseConfig = {
  apiKey: import.meta.env.VITE_FIREBASE_API_KEY || "AIzaSyDp7k_es-_fG1NW8qqfXfQIL9U1FKWRBLA",
  authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN || "moco-player-f396a.firebaseapp.com",
  databaseURL: import.meta.env.VITE_FIREBASE_DATABASE_URL || "https://moco-player-f396a-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID || "moco-player-f396a",
  storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET || "moco-player-f396a.appspot.com",
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID || "96132308835",
  appId: import.meta.env.VITE_FIREBASE_APP_ID || "1:96132308835:web:ff51df5ca7c6b49bdbbd56",
  measurementId: import.meta.env.VITE_FIREBASE_MEASUREMENT_ID || "G-VV9J83V8D3",
};

const app = initializeApp(firebaseConfig);

export const auth = getAuth(app);
export const db = getDatabase(app);
