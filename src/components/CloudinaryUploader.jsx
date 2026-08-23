import React, { useEffect, useRef } from "react";

export default function CloudinaryUploader({ onUploaded }) {
  const widgetRef = useRef(null);
  const onUploadedRef = useRef(onUploaded);

  // Keep the callback ref updated without triggering the effect rerun
  useEffect(() => {
    onUploadedRef.current = onUploaded;
  }, [onUploaded]);

  useEffect(() => {
    const cloudName = import.meta.env.VITE_CLOUDINARY_CLOUD_NAME;
    const uploadPreset = import.meta.env.VITE_CLOUDINARY_UPLOAD_PRESET;

    if (!cloudName || !uploadPreset || !window.cloudinary) return;

    widgetRef.current = window.cloudinary.createUploadWidget(
      {
        cloudName,
        uploadPreset,
        multiple: false,
        maxFiles: 1,
        resourceType: "image",
        clientAllowedFormats: ["png", "jpg", "jpeg", "webp"],
        maxFileSize: 10000000,
        cropping: true,
        croppingAspectRatio: 16 / 9,
        folder: "moco-player/sliders",
        showAdvancedOptions: false,
        showUploadMoreButton: false,
        singleUploadAutoClose: true
      },
      (error, result) => {
        if (error) {
          console.error("Cloudinary upload error:", error);
          return;
        }

        if (result?.event === "success" && onUploadedRef.current) {
          onUploadedRef.current({
            imageUrl: result.info.secure_url,
            publicId: result.info.public_id,
            width: result.info.width,
            height: result.info.height
          });
        }
      }
    );

    return () => {
      widgetRef.current = null;
    };
  }, []); // Run only once on mount to avoid infinite widget recreation

  const open = () => {
    if (!widgetRef.current) {
      alert("Cloudinary is not configured. Add the Cloudinary values to .env.");
      return;
    }
    widgetRef.current.open();
  };

  return (
    <button type="button" className="upload-button" onClick={open}>
      Upload from Cloudinary
    </button>
  );
}
