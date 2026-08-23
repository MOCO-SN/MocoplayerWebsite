import {
  push,
  ref,
  remove,
  set,
  update,
} from "firebase/database";

import { db } from "./firebase";

/* =========================================================
   UPDATES DATABASE REFERENCE
========================================================= */

const updatesRef = ref(db, "updates");

/* =========================================================
   CREATE UPDATE
========================================================= */

export async function createUpdate(data) {
  const newUpdateRef = push(updatesRef);

  const updateData = {
    title: data.title || "",
    subtitle: data.subtitle || "",
    version: data.version || "",
    changes: data.changes || "",
    patchNotes: data.patchNotes || "",
    downloadUrl: data.downloadUrl || "",
    releaseDate: data.releaseDate || "",
    fileSize: data.fileSize || "",
    imageUrl: data.imageUrl || "",

    // Manager fields
    active: data.active ?? true,
    createdAt: Date.now(),
    updatedAt: Date.now(),
  };

  await set(newUpdateRef, updateData);

  return {
    id: newUpdateRef.key,
    ...updateData,
  };
}

/* =========================================================
   UPDATE EXISTING UPDATE
========================================================= */

export async function updateAppUpdate(id, data) {
  if (!id) {
    throw new Error("Update ID is required.");
  }

  const updateRef = ref(db, `updates/${id}`);

  await update(updateRef, {
    ...data,
    updatedAt: Date.now(),
  });
}

/* =========================================================
   DELETE UPDATE
========================================================= */

export async function deleteUpdate(id) {
  if (!id) {
    throw new Error("Update ID is required.");
  }

  const updateRef = ref(db, `updates/${id}`);

  await remove(updateRef);
}

/* =========================================================
   TOGGLE UPDATE ACTIVE STATUS
========================================================= */

export async function toggleUpdateActive(
  id,
  active
) {
  if (!id) {
    throw new Error("Update ID is required.");
  }

  const updateRef = ref(db, `updates/${id}`);

  await update(updateRef, {
    active: Boolean(active),
    updatedAt: Date.now(),
  });
}