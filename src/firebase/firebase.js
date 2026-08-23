import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getDatabase } from "firebase/database";

// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyDp7k_es-_fG1NW8qqfXfQIL9U1FKWRBLA",
  authDomain: "moco-player-f396a.firebaseapp.com",
  databaseURL: "https://moco-player-f396a-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "moco-player-f396a",
  storageBucket: "moco-player-f396a.appspot.com",
  messagingSenderId: "96132308835",
  appId: "1:96132308835:web:ff51df5ca7c6b49bdbbd56",
  measurementId: "G-VV9J83V8D3"
};

const app = initializeApp(
  firebaseConfig
);

export const auth = getAuth(app);
export const db = getDatabase(app);