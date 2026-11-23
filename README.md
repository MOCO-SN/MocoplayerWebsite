# Moco Player Manager

React/Vite admin manager for controlling the Moco Player Android slider.

## Stack

- React + Vite
- Firebase Authentication
- Firebase Realtime Database
- Cloudinary Upload Widget

The manager stores banner metadata in Firebase and the actual banner image in Cloudinary.

## 1. Firebase setup

Create/choose a Firebase project.

Enable:

1. Authentication
2. Email/Password provider
3. Realtime Database

Create your admin user in Firebase Authentication (Users tab).

Then, go to Firebase Console -> **Realtime Database** -> **Rules** tab, and paste the rules from `firebase.rules.json`:

```json
{
  "rules": {
    "sliders": {
      ".read": true,
      ".write": "auth != null"
    },
    "updates": {
      ".read": true,
      ".write": "auth != null"
    },
    "admins": {
      ".read": "auth != null",
      ".write": "auth != null"
    }
  }
}
```

The `sliders` and `updates` nodes are readable without authentication so the Android app and website can fetch banners and updates. Writes are restricted to authenticated administrator accounts (`auth != null`).

If you prefer strict role-based access, add your admin UID under `/admins/{YOUR_UID}` with `{"role": "admin"}`. You can easily view and copy your UID from the **Settings** page inside the manager.

## 2. Cloudinary setup

Create a Cloudinary account.

Create an unsigned upload preset:

- folder: `moco-player/sliders`
- resource type: Image
- restrict formats to JPG/JPEG/PNG/WebP
- optionally set a maximum file size

Copy the cloud name and upload preset into `.env`.

Do NOT put the Cloudinary API secret in `.env` or React code.

## 3. Configure environment

Copy:

```bash
cp .env.example .env
```

Fill all Firebase and Cloudinary values.

## 4. Install and run

```bash
npm install
npm run dev
```

## 5. Build

```bash
npm run build
```

## 6. Android migration

See `ANDROID_MIGRATION.java`.

Replace the old `loadImageSlider()` PHP method with the Firebase implementation.

Old endpoint:

`https://mocoplayer.interiorsita.com/get_slider.php`

is no longer required for slider data.

## Data model

```text
sliders
  sliderId
    title
    description
    imageUrl
    publicId
    buttonText
    buttonUrl
    active
    position
    imageWidth
    imageHeight
    createdAt
    updatedAt
```

## Notes

Cloudinary deletion is deliberately not implemented from the browser because a Cloudinary API secret must never be exposed in frontend JavaScript. If you want automatic asset deletion, add a trusted backend/Cloud Function later.
