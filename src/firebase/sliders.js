import {
  onValue,
  push,
  ref,
  remove,
  set,
  update,
} from "firebase/database";

import { db } from "./firebase";

/* =========================================================
   SLIDERS REFERENCE
========================================================= */

const slidersRef = ref(db, "sliders");

/* =========================================================
   SUBSCRIBE TO SLIDERS
========================================================= */

export function subscribeSliders(callback) {
  return onValue(
    slidersRef,
    (snapshot) => {
      const data = snapshot.val() || {};

      const list = Object.entries(data).map(
        ([id, value]) => ({
          id,
          ...value,
        })
      );

      list.sort((a, b) => {
        return (
          Number(a.position || 0) -
          Number(b.position || 0)
        );
      });

      callback(list);
    },
    (error) => {
      console.error(
        "Firebase slider subscription error:",
        error
      );

      callback([]);
    }
  );
}

/* =========================================================
   CREATE SLIDER
========================================================= */

export async function createSlider(data) {
  try {
    const newSliderRef = push(slidersRef);

    const sliderData = {
      title: data.title || "",
      description: data.description || "",
      imageUrl: data.imageUrl || "",

      position:
        Number(data.position) || 1,

      active:
        data.active !== false,

      createdAt: Date.now(),
      updatedAt: Date.now(),
    };

    console.log(
      "Creating slider:",
      sliderData
    );

    await set(
      newSliderRef,
      sliderData
    );

    console.log(
      "Slider created:",
      newSliderRef.key
    );

    return {
      id: newSliderRef.key,
      ...sliderData,
    };
  } catch (error) {
    console.error(
      "Firebase createSlider error:",
      error
    );

    throw error;
  }
}

/* =========================================================
   UPDATE SLIDER
========================================================= */

export async function updateSlider(
  id,
  data
) {
  if (!id) {
    throw new Error(
      "Slider ID is missing."
    );
  }

  try {
    const sliderRef = ref(
      db,
      `sliders/${id}`
    );

    await update(sliderRef, {
      ...data,
      updatedAt: Date.now(),
    });
  } catch (error) {
    console.error(
      "Firebase updateSlider error:",
      error
    );

    throw error;
  }
}

/* =========================================================
   DELETE SLIDER
========================================================= */

export async function deleteSlider(id) {
  if (!id) {
    throw new Error(
      "Slider ID is missing."
    );
  }

  try {
    const sliderRef = ref(
      db,
      `sliders/${id}`
    );

    await remove(sliderRef);
  } catch (error) {
    console.error(
      "Firebase deleteSlider error:",
      error
    );

    throw error;
  }
}

/* =========================================================
   REORDER SLIDERS
========================================================= */

export async function reorderSliders(
  sliders
) {
  try {
    const updates = {};

    sliders.forEach(
      (slider, index) => {
        updates[
          `sliders/${slider.id}/position`
        ] = index + 1;

        updates[
          `sliders/${slider.id}/updatedAt`
        ] = Date.now();
      }
    );

    if (Object.keys(updates).length === 0) {
      return;
    }

    await update(
      ref(db),
      updates
    );
  } catch (error) {
    console.error(
      "Firebase reorderSliders error:",
      error
    );

    throw error;
  }
}