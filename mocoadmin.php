<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
<title>MocoPlayer Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #0f0f23;
    color: #fff;
    min-height: 100vh;
    display: flex;
}

.sidebar {
    width: 260px;
    background: linear-gradient(180deg, #1a1a2e 0%, #16162a 100%);
    border-right: 1px solid rgba(108, 92, 231, 0.2);
    padding: 30px 20px;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
}

.logo {
    font-size: 24px;
    font-weight: 700;
    background: linear-gradient(135deg, #6C5CE7, #00CEC9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 40px;
    padding-left: 15px;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 15px;
    color: #8b8b9e;
    text-decoration: none;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: all 0.3s;
}

.menu-item:hover, .menu-item.active {
    background: rgba(108, 92, 231, 0.15);
    color: #fff;
}

.menu-item i {
    width: 20px;
}

.main-content {
    margin-left: 260px;
    padding: 40px;
    width: calc(100% - 260px);
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.header h1 {
    font-size: 28px;
    font-weight: 600;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, #1e293b 0%, #1a1a2e 100%);
    border: 1px solid rgba(108, 92, 231, 0.2);
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(108, 92, 231, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    background: rgba(108, 92, 231, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #6C5CE7;
}

.stat-info h3 {
    font-size: 28px;
    font-weight: 700;
}

.stat-info p {
    color: #8b8b9e;
    font-size: 14px;
}

.add-section {
    background: linear-gradient(135deg, #1e293b 0%, #1a1a2e 100%);
    border: 1px solid rgba(108, 92, 231, 0.2);
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 40px;
}

.add-section h2 {
    font-size: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.add-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.add-form input {
    flex: 1;
    min-width: 300px;
    padding: 16px 20px;
    background: #0f0f23;
    border: 1px solid rgba(108, 92, 231, 0.3);
    border-radius: 12px;
    color: #fff;
    font-size: 15px;
    transition: border-color 0.3s;
}

.add-form input:focus {
    outline: none;
    border-color: #6C5CE7;
}

.add-form input::placeholder {
    color: #6b6b7b;
}

.add-form button {
    padding: 16px 30px;
    background: linear-gradient(135deg, #6C5CE7 0%, #8B7CF7 100%);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.add-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
}

.msg {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: none;
    animation: slideIn 0.3s ease;
}

.msg.show {
    display: block;
}

.msg.success {
    background: rgba(39, 174, 96, 0.15);
    border: 1px solid rgba(39, 174, 96, 0.3);
    color: #2ecc71;
}

.msg.error {
    background: rgba(231, 76, 60, 0.15);
    border: 1px solid rgba(231, 76, 60, 0.3);
    color: #e74c3c;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.image-card {
    background: linear-gradient(135deg, #1e293b 0%, #1a1a2e 100%);
    border: 1px solid rgba(108, 92, 231, 0.2);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s;
}

.image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(108, 92, 231, 0.15);
    border-color: rgba(108, 92, 231, 0.5);
}

.image-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-bottom: 1px solid rgba(108, 92, 231, 0.2);
}

.image-card .card-body {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.image-card .image-url {
    font-size: 12px;
    color: #8b8b9e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}

.image-card button {
    padding: 10px 16px;
    background: rgba(231, 76, 60, 0.15);
    border: 1px solid rgba(231, 76, 60, 0.3);
    border-radius: 8px;
    color: #e74c3c;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
}

.image-card button:hover {
    background: #e74c3c;
    color: #fff;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #8b8b9e;
}

.empty-state i {
    font-size: 60px;
    margin-bottom: 20px;
    color: rgba(108, 92, 231, 0.3);
}

.empty-state h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #fff;
}

.empty-state p {
    font-size: 14px;
}

@media (max-width: 768px) {
    .sidebar {
        display: none;
    }
    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 20px;
    }
    .stats {
        grid-template-columns: 1fr;
    }
    .add-form {
        flex-direction: column;
    }
    .add-form input {
        min-width: 100%;
    }
}
</style>
</head>
<body>

<nav class="sidebar">
    <div class="logo"><i class="fas fa-play-circle"></i> MocoPlayer</div>
    <a href="#" class="menu-item active" onclick="showTab('slider')"><i class="fas fa-images"></i> Slider Images</a>
    <a href="#" class="menu-item" onclick="showTab('audios')"><i class="fas fa-music"></i> Audios</a>
    <a href="#" class="menu-item" onclick="showTab('uploads')"><i class="fas fa-upload"></i> Upload & Get URL</a>
    <a href="#" class="menu-item" onclick="showTab('carousel')"><i class="fas fa-layer-group"></i> Carousel Groups</a>
    <a href="#" class="menu-item" onclick="showTab('categories')"><i class="fas fa-tags"></i> Categories</a>
    <a href="#" class="menu-item" onclick="showTab('videos')"><i class="fas fa-film"></i> Videos</a>
    <a href="#" class="menu-item" onclick="showTab('settings')"><i class="fas fa-cog"></i> Settings</a>
    <a href="index.html" class="menu-item"><i class="fas fa-arrow-left"></i> Back to Site</a>
</nav>

<main class="main-content">
    <!-- Slider Images Tab -->
    <div id="tab-slider">
        <div class="header">
            <h1>Slider Images</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-images"></i></div>
                <div class="stat-info">
                    <h3 id="totalImages">0</h3>
                    <p>Total Images</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="activeImages">0</h3>
                    <p>Active Slides</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Recent</h3>
                    <p>Last Updated</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-plus-circle"></i> Add New Image</h2>
            <div id="sliderMsg" class="msg"></div>
            <div class="add-form">
                <input type="text" id="imageUrl" placeholder="Enter image URL (https://example.com/image.jpg)">
                <button onclick="addImage()"><i class="fas fa-plus"></i> Add Image</button>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-photo-video"></i> All Images</h2>
            <div id="imageList"></div>
        </div>
    </div>

    <!-- Audios Tab -->
    <div id="tab-audios" style="display: none;">
        <div class="header">
            <h1>Audios</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-music"></i></div>
                <div class="stat-info">
                    <h3 id="totalAudios">0</h3>
                    <p>Total Audios</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-play-circle" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="recentAudios">0</h3>
                    <p>Recent</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-plus-circle" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Add New</h3>
                    <p>Upload Audio</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-music"></i> Add New Audio</h2>
            <div id="audioMsg" class="msg"></div>
            <div class="add-form" style="flex-direction: column; gap: 15px;">
                <input type="text" id="audioTitle" placeholder="Audio Title">
                <input type="text" id="audioDesc" placeholder="Description (optional)">
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px; border: 2px dashed rgba(108, 92, 231, 0.4); border-radius: 12px; padding: 30px; text-align: center; cursor: pointer;" onclick="document.getElementById('audioFileInput').click()">
                        <i class="fas fa-music" style="font-size: 32px; color: #6C5CE7; margin-bottom: 10px;"></i>
                        <p style="color: #8b8b9e; font-size: 14px;">Click to upload Audio</p>
                        <p style="color: #6b6b7b; font-size: 12px;">MP3, WAV, OGG (max 10MB)</p>
                        <input type="file" id="audioFileInput" style="display: none;" accept="audio/mpeg,audio/mp3,audio/wav,audio/ogg" onchange="handleAudioFileUpload(this, 'audio')">
                    </div>
                    <div style="flex: 1; min-width: 250px; border: 2px dashed rgba(108, 92, 231, 0.4); border-radius: 12px; padding: 30px; text-align: center; cursor: pointer;" onclick="document.getElementById('imageFileInput').click()">
                        <i class="fas fa-image" style="font-size: 32px; color: #6C5CE7; margin-bottom: 10px;"></i>
                        <p style="color: #8b8b9e; font-size: 14px;">Click to upload Thumbnail</p>
                        <p style="color: #6b6b7b; font-size: 12px;">JPEG, PNG, WEBP</p>
                        <input type="file" id="imageFileInput" style="display: none;" accept="image/jpeg,image/png,image/webp" onchange="handleAudioFileUpload(this, 'image')">
                    </div>
                </div>
                <div id="audioUploadProgress" style="display: none; padding: 15px; background: rgba(108, 92, 231, 0.1); border-radius: 12px;">
                    <p id="audioProgressText" style="color: #8b8b9e;">Uploading...</p>
                </div>
                <button onclick="saveAudio()" id="saveAudioBtn" disabled><i class="fas fa-save"></i> Save Audio</button>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-music"></i> All Audios</h2>
            <div id="audioList"></div>
        </div>
    </div>

    <!-- Edit Audio Modal -->
    <div id="editAudioModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: linear-gradient(135deg, #1e293b 0%, #1a1a2e 100%); border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 16px; padding: 30px; max-width: 500px; width: 90%;">
            <h2 style="margin-bottom: 20px;"><i class="fas fa-edit"></i> Edit Audio</h2>
            <div id="editAudioMsg" class="msg"></div>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <input type="text" id="editAudioTitle" placeholder="Audio Title" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editAudioDesc" placeholder="Description" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editAudioThumb" placeholder="Thumbnail URL" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editAudioUrl" placeholder="Audio URL" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;" readonly>
                <input type="hidden" id="editAudioId">
                <div style="display: flex; gap: 12px; margin-top: 10px;">
                    <button onclick="saveEditAudio()" style="flex: 1; padding: 14px 24px; background: linear-gradient(135deg, #6C5CE7 0%, #8B7CF7 100%); border: none; border-radius: 10px; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;"><i class="fas fa-check"></i> Save</button>
                    <button onclick="closeEditAudioModal()" style="flex: 1; padding: 14px 24px; background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); border-radius: 10px; color: #e74c3c; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Tab -->
    <div id="tab-categories" style="display: none;">
        <div class="header">
            <h1>Categories</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <h3 id="totalCategories">0</h3>
                    <p>Total Categories</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-folder-open" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="activeCategories">0</h3>
                    <p>Active</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-plus-circle" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Add New</h3>
                    <p>Create Category</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-plus-circle"></i> Add New Category</h2>
            <div id="categoryMsg" class="msg"></div>
            <div class="add-form">
                <input type="text" id="catName" placeholder="Category Name">
                <input type="text" id="catDesc" placeholder="Description (optional)">
                <button onclick="addCategory()"><i class="fas fa-plus"></i> Add Category</button>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-tags"></i> All Categories</h2>
            <div id="categoryList"></div>
        </div>
    </div>

    <!-- Upload & Get URL Tab -->
    <div id="tab-uploads" style="display: none;">
        <div class="header">
            <h1>Upload & Get URL</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-upload"></i></div>
                <div class="stat-info">
                    <h3 id="totalUploads">0</h3>
                    <p>Total Uploads</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-image" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="imageUploads">0</h3>
                    <p>Images</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Recent</h3>
                    <p>Last Upload</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-cloud-upload-alt"></i> Upload File</h2>
            <div id="uploadMsg" class="msg"></div>
            <div class="upload-area" style="border: 2px dashed rgba(108, 92, 231, 0.4); border-radius: 16px; padding: 40px; text-align: center; margin-bottom: 20px; cursor: pointer; transition: all 0.3s;" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #6C5CE7; margin-bottom: 15px;"></i>
                <p style="color: #8b8b9e;">Click to upload or drag and drop</p>
                <p style="color: #6b6b7b; font-size: 12px;">JPEG, PNG, GIF, WEBP (max 5MB)</p>
                <input type="file" id="fileInput" style="display: none;" accept="image/jpeg,image/png,image/gif,image/webp" onchange="handleFileUpload(this)">
            </div>
            <div id="uploadPreview" style="display: none; margin-bottom: 20px;">
                <div class="image-card" style="max-width: 300px;">
                    <img id="previewImg" src="" alt="Preview">
                    <div class="card-body">
                        <span id="previewName" class="image-url"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-folder-open"></i> All Uploads</h2>
            <div id="uploadList"></div>
        </div>
    </div>

    <!-- Carousel Groups Tab -->
    <div id="tab-carousel" style="display: none;">
        <div class="header">
            <h1>Carousel Groups</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <h3 id="totalGroups">0</h3>
                    <p>Total Groups</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="activeGroups">0</h3>
                    <p>Active</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-plus-circle" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Add New</h3>
                    <p>Create Group</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-plus-circle"></i> Add New Carousel Group</h2>
            <div id="carouselMsg" class="msg"></div>
            <div class="add-form">
                <input type="text" id="groupName" placeholder="Group Name">
                <input type="text" id="groupDesc" placeholder="Description (optional)">
                <button onclick="addCarouselGroup()"><i class="fas fa-plus"></i> Add Group</button>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-object-group"></i> All Groups</h2>
            <div id="carouselGroupList"></div>
        </div>
    </div>

    <!-- Videos Tab -->
    <div id="tab-videos" style="display: none;">
        <div class="header">
            <h1>Videos</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-film"></i></div>
                <div class="stat-info">
                    <h3 id="totalVideos">0</h3>
                    <p>Total Videos</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-play-circle" style="color:#00CEC9;"></i></div>
                <div class="stat-info">
                    <h3 id="activeVideos">0</h3>
                    <p>Active</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-plus-circle" style="color:#FD79A8;"></i></div>
                <div class="stat-info">
                    <h3>Add New</h3>
                    <p>Add Video</p>
                </div>
            </div>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-plus-circle"></i> Add New Video</h2>
            <div id="videoMsg" class="msg"></div>
            <div class="add-form" style="flex-direction: column; gap: 15px;">
                <input type="text" id="videoTitle" placeholder="Video Title">
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px; border: 2px dashed rgba(108, 92, 231, 0.4); border-radius: 12px; padding: 30px; text-align: center; cursor: pointer;" onclick="document.getElementById('videoFileInput').click()">
                        <i class="fas fa-video" style="font-size: 32px; color: #6C5CE7; margin-bottom: 10px;"></i>
                        <p style="color: #8b8b9e; font-size: 14px;">Click to upload Video</p>
                        <p style="color: #6b6b7b; font-size: 12px;">MP4, WEBM, OGG (max 50MB)</p>
                        <input type="file" id="videoFileInput" style="display: none;" accept="video/mp4,video/webm,video/ogg" onchange="handleVideoFileUpload(this, 'video')">
                    </div>
                    <div style="flex: 1; min-width: 250px; border: 2px dashed rgba(108, 92, 231, 0.4); border-radius: 12px; padding: 30px; text-align: center; cursor: pointer;" onclick="document.getElementById('thumbFileInput').click()">
                        <i class="fas fa-image" style="font-size: 32px; color: #6C5CE7; margin-bottom: 10px;"></i>
                        <p style="color: #8b8b9e; font-size: 14px;">Click to upload Thumbnail</p>
                        <p style="color: #6b6b7b; font-size: 12px;">JPEG, PNG, WEBP</p>
                        <input type="file" id="thumbFileInput" style="display: none;" accept="image/jpeg,image/png,image/webp" onchange="handleVideoFileUpload(this, 'thumbnail')">
                    </div>
                </div>
                <div id="videoUploadProgress" style="display: none; padding: 15px; background: rgba(108, 92, 231, 0.1); border-radius: 12px;">
                    <p id="videoProgressText" style="color: #8b8b9e;">Uploading...</p>
                </div>
                <input type="text" id="videoDesc" placeholder="Description (optional)">
                <select id="videoCategory" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px; min-width: 200px;">
                    <option value="">Select Category</option>
                </select>
                <button onclick="saveVideo()" id="saveVideoBtn" disabled><i class="fas fa-save"></i> Save Video</button>
            </div>
        </div>

        <div class="images-section">
            <h2 style="margin-bottom: 20px; font-size: 20px;"><i class="fas fa-video"></i> All Videos</h2>
            <div id="videoList"></div>
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div id="editVideoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: linear-gradient(135deg, #1e293b 0%, #1a1a2e 100%); border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 16px; padding: 30px; max-width: 500px; width: 90%;">
            <h2 style="margin-bottom: 20px;"><i class="fas fa-edit"></i> Edit Video</h2>
            <div id="editVideoMsg" class="msg"></div>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <input type="text" id="editVideoTitle" placeholder="Video Title" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editVideoDesc" placeholder="Description" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editVideoThumb" placeholder="Thumbnail URL" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                <input type="text" id="editVideoUrl" placeholder="Video URL" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;" readonly>
                <input type="hidden" id="editVideoId">
                <select id="editVideoCategory" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                    <option value="">Select Category</option>
                </select>
                <div style="display: flex; gap: 12px; margin-top: 10px;">
                    <button onclick="saveEditVideo()" style="flex: 1; padding: 14px 24px; background: linear-gradient(135deg, #6C5CE7 0%, #8B7CF7 100%); border: none; border-radius: 10px; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;"><i class="fas fa-check"></i> Save</button>
                    <button onclick="closeEditVideoModal()" style="flex: 1; padding: 14px 24px; background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); border-radius: 10px; color: #e74c3c; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Tab -->
    <div id="tab-settings" style="display: none;">
        <div class="header">
            <h1>Settings</h1>
        </div>

        <div class="add-section">
            <h2><i class="fas fa-sliders-h"></i> Site Settings</h2>
            <div id="settingsMsg" class="msg"></div>
            <div style="display: flex; flex-direction: column; gap: 15px; max-width: 600px;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: #8b8b9e; font-size: 14px;">Site Name</label>
                    <input type="text" id="settingSiteName" placeholder="MocoPlayer" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: #8b8b9e; font-size: 14px;">Site Description</label>
                    <textarea id="settingSiteDesc" placeholder="Your site description..." rows="3" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: #8b8b9e; font-size: 14px;">Footer Text</label>
                    <input type="text" id="settingFooter" placeholder="© 2024 MocoPlayer" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="color: #8b8b9e; font-size: 14px;">Contact Email</label>
                    <input type="email" id="settingEmail" placeholder="contact@example.com" style="padding: 16px 20px; background: #0f0f23; border: 1px solid rgba(108, 92, 231, 0.3); border-radius: 12px; color: #fff; font-size: 15px;">
                </div>
                <button onclick="saveSettings()" style="padding: 16px 30px; background: linear-gradient(135deg, #6C5CE7 0%, #8B7CF7 100%); border: none; border-radius: 12px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 10px;"><i class="fas fa-save"></i> Save Settings</button>
            </div>
        </div>
    </div>
</main>

<script>
let currentTab = 'slider';
let categoriesData = [];

function showTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    event.target.classList.add('active');
    
    document.getElementById('tab-slider').style.display = tab === 'slider' ? 'block' : 'none';
    document.getElementById('tab-audios').style.display = tab === 'audios' ? 'block' : 'none';
    document.getElementById('tab-uploads').style.display = tab === 'uploads' ? 'block' : 'none';
    document.getElementById('tab-carousel').style.display = tab === 'carousel' ? 'block' : 'none';
    document.getElementById('tab-categories').style.display = tab === 'categories' ? 'block' : 'none';
    document.getElementById('tab-videos').style.display = tab === 'videos' ? 'block' : 'none';
    document.getElementById('tab-settings').style.display = tab === 'settings' ? 'block' : 'none';
    
    if (tab === 'slider') loadImages();
    if (tab === 'audios') loadAudios();
    if (tab === 'uploads') loadUploads();
    if (tab === 'carousel') loadCarouselGroups();
    if (tab === 'categories') loadCategories();
    if (tab === 'videos') loadVideos();
    if (tab === 'settings') loadSettings();
}

function showMsg(text, type, tab) {
    const msgId = tab === 'slider' ? 'sliderMsg' : tab === 'uploads' ? 'uploadMsg' : tab === 'carousel' ? 'carouselMsg' : tab === 'categories' ? 'categoryMsg' : tab === 'videos' ? 'videoMsg' : 'settingsMsg';
    const msg = document.getElementById(msgId);
    msg.className = 'msg show ' + type;
    msg.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + text;
    setTimeout(() => msg.classList.remove('show'), 4000);
}

// ==================== SLIDER IMAGES ====================
function loadImages() {
    fetch("get_slider.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalImages').textContent = data.length || 0;
        document.getElementById('activeImages').textContent = data.length || 0;
        
        if (!data || data.length === 0) {
            document.getElementById("imageList").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <h3>No Images Yet</h3>
                    <p>Add your first slider image using the form above</p>
                </div>`;
            return;
        }
        
        let html = '<div class="images-grid">';
        data.forEach(img => {
            html += `
            <div class="image-card">
                <img src="${img.image_url}" onerror="this.src='https://via.placeholder.com/400x200?text=Invalid+Image+URL'" alt="Slider">
                <div class="card-body">
                    <span class="image-url">${img.image_url}</span>
                    <button onclick="deleteImg(${img.id})"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>`;
        });
        html += '</div>';
        document.getElementById("imageList").innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        showMsg('Error loading images', 'error', 'slider');
    });
}

function addImage() {
    const url = document.getElementById("imageUrl").value.trim();
    if (!url) {
        showMsg('Please enter an image URL', 'error', 'slider');
        return;
    }

    fetch("add_image.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "url=" + encodeURIComponent(url)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Image added successfully!', 'success', 'slider');
            document.getElementById("imageUrl").value = "";
            loadImages();
        } else {
            showMsg(data.message || 'Error adding image', 'error', 'slider');
        }
    })
    .catch(err => showMsg('Error adding image', 'error', 'slider'));
}

function deleteImg(id) {
    if (!confirm('Are you sure you want to delete this image?')) return;

    fetch("delete_image.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Image deleted successfully!', 'success', 'slider');
            loadImages();
        } else {
            showMsg(data.message || 'Error deleting image', 'error', 'slider');
        }
    })
    .catch(err => showMsg('Error deleting image', 'error', 'slider'));
}

// ==================== AUDIOS ====================
let uploadedAudioUrl = '';
let uploadedImageUrl = '';

function handleAudioFileUpload(input, type) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);

        document.getElementById('audioUploadProgress').style.display = 'block';
        document.getElementById('audioProgressText').textContent = 'Uploading ' + type + '...';

        fetch("upload.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                if (type === 'audio') {
                    uploadedAudioUrl = data.url;
                    showMsg('Audio uploaded successfully!', 'success', 'audios');
                } else {
                    uploadedImageUrl = data.url;
                    showMsg('Image uploaded successfully!', 'success', 'audios');
                }
                
                if (uploadedAudioUrl && uploadedImageUrl) {
                    document.getElementById('saveAudioBtn').disabled = false;
                }
            } else {
                showMsg(data.message || 'Error uploading file', 'error', 'audios');
            }
            document.getElementById('audioUploadProgress').style.display = 'none';
        })
        .catch(err => {
            showMsg('Error uploading file', 'error', 'audios');
            document.getElementById('audioUploadProgress').style.display = 'none';
        });
    }
}

function saveAudio() {
    const title = document.getElementById('audioTitle').value.trim();
    const description = document.getElementById('audioDesc').value.trim();

    if (!title || !uploadedAudioUrl || !uploadedImageUrl) {
        showMsg('Please fill all fields and upload both audio and image', 'error', 'audios');
        return;
    }

    fetch("add_audio.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "title=" + encodeURIComponent(title) + 
             "&description=" + encodeURIComponent(description) + 
             "&audio_url=" + encodeURIComponent(uploadedAudioUrl) + 
             "&image_url=" + encodeURIComponent(uploadedImageUrl)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Audio added successfully!', 'success', 'audios');
            document.getElementById('audioTitle').value = "";
            document.getElementById('audioDesc').value = "";
            uploadedAudioUrl = '';
            uploadedImageUrl = '';
            document.getElementById('saveAudioBtn').disabled = true;
            loadAudios();
        } else {
            showMsg(data.message || 'Error adding audio', 'error', 'audios');
        }
    })
    .catch(err => showMsg('Error adding audio', 'error', 'audios'));
}

function loadAudios() {
    fetch("get_audios.php")
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            const audios = data.audios || [];
            document.getElementById('totalAudios').textContent = audios.length || 0;
            document.getElementById('recentAudios').textContent = audios.length || 0;
            
            if (!audios || audios.length === 0) {
                document.getElementById("audioList").innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-music"></i>
                        <h3>No Audios Yet</h3>
                        <p>Add your first audio using the form above</p>
                    </div>`;
                return;
            }
            
            let html = '<div class="images-grid">';
            audios.forEach(audio => {
                const thumb = audio.image_url || 'https://via.placeholder.com/400x400?text=No+Image';
                html += `
                <div class="image-card">
                    <img src="${thumb}" onerror="this.src='https://via.placeholder.com/400x400?text=Invalid+Image'" alt="${audio.title}" id="audioThumb_${audio.id}">
                    <div class="card-body" style="flex-direction: column; gap: 10px; align-items: flex-start;">
                        <strong style="font-size: 16px;" id="audioTitle_${audio.id}">${audio.title}</strong>
                        <span style="color: #8b8b9e; font-size: 12px;" id="audioDesc_${audio.id}">${audio.description || 'No description'}</span>
                        <span class="image-url" style="max-width: 100%;" id="audioUrl_${audio.id}">${audio.audio_url}</span>
                        <div style="display: flex; gap: 8px; margin-top: 10px;">
                            <button onclick="openEditAudio('${audio.id}', '${audio.title}', '${audio.description || ''}', '${audio.image_url || ''}', '${audio.audio_url}')"><i class="fas fa-edit"></i> Edit</button>
                            <button onclick="deleteAudio('${audio.id}')" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c;"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>`;
            });
            html += '</div>';
            document.getElementById("audioList").innerHTML = html;
        }
    })
    .catch(err => console.error(err));
}

function deleteAudio(id) {
    if (!confirm('Are you sure you want to delete this audio?')) return;

    fetch("delete_audio.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Audio deleted successfully!', 'success', 'audios');
            loadAudios();
        } else {
            showMsg(data.message || 'Error deleting audio', 'error', 'audios');
        }
    })
    .catch(err => showMsg('Error deleting audio', 'error', 'audios'));
}

function openEditAudio(id, title, description, imageUrl, audioUrl) {
    document.getElementById('editAudioId').value = id;
    document.getElementById('editAudioTitle').value = title;
    document.getElementById('editAudioDesc').value = description || '';
    document.getElementById('editAudioThumb').value = imageUrl || '';
    document.getElementById('editAudioUrl').value = audioUrl || '';
    document.getElementById('editAudioModal').style.display = 'flex';
    document.getElementById('editAudioMsg').className = 'msg';
}

function closeEditAudioModal() {
    document.getElementById('editAudioModal').style.display = 'none';
}

function saveEditAudio() {
    const id = document.getElementById('editAudioId').value;
    const title = document.getElementById('editAudioTitle').value.trim();
    const description = document.getElementById('editAudioDesc').value.trim();
    const imageUrl = document.getElementById('editAudioThumb').value.trim();
    const audioUrl = document.getElementById('editAudioUrl').value.trim();

    if (!title) {
        document.getElementById('editAudioMsg').className = 'msg show error';
        document.getElementById('editAudioMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> Title is required';
        return;
    }

    fetch("edit_audio.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "id=" + encodeURIComponent(id) +
             "&title=" + encodeURIComponent(title) +
             "&description=" + encodeURIComponent(description) +
             "&image_url=" + encodeURIComponent(imageUrl) +
             "&audio_url=" + encodeURIComponent(audioUrl)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            document.getElementById('editAudioMsg').className = 'msg show success';
            document.getElementById('editAudioMsg').innerHTML = '<i class="fas fa-check-circle"></i> Audio updated successfully!';
            setTimeout(() => {
                closeEditAudioModal();
                loadAudios();
            }, 1000);
        } else {
            document.getElementById('editAudioMsg').className = 'msg show error';
            document.getElementById('editAudioMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + (data.message || 'Error updating audio');
        }
    })
    .catch(err => {
        document.getElementById('editAudioMsg').className = 'msg show error';
        document.getElementById('editAudioMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> Error updating audio';
    });
}

// ==================== UPLOADS ====================
function handleFileUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const formData = new FormData();
        formData.append('file', file);

        document.getElementById('uploadPreview').style.display = 'block';
        document.getElementById('previewName').textContent = file.name;
        document.getElementById('previewImg').src = URL.createObjectURL(file);

        fetch("upload.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                showMsg('File uploaded successfully!', 'success', 'uploads');
                document.getElementById('uploadPreview').style.display = 'none';
                document.getElementById('fileInput').value = '';
                loadUploads();
                
                setTimeout(() => {
                    prompt('Uploaded File URL:', data.url);
                }, 500);
            } else {
                showMsg(data.message || 'Error uploading file', 'error', 'uploads');
            }
        })
        .catch(err => {
            showMsg('Error uploading file', 'error', 'uploads');
            console.error(err);
        });
    }
}

function loadUploads() {
    fetch("get_uploads.php")
    .then(res => res.json())
    .then(data => {
        const uploads = data.uploads || data || [];
        document.getElementById('totalUploads').textContent = uploads.length || 0;
        document.getElementById('imageUploads').textContent = uploads.length || 0;
        
        if (!data || data.length === 0) {
            document.getElementById("uploadList").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-upload"></i>
                    <h3>No Uploads Yet</h3>
                    <p>Upload your first file using the form above</p>
                </div>`;
            return;
        }
        
        let html = '<div class="images-grid">';
        uploads.forEach(upload => {
            html += `
            <div class="image-card">
                <img src="${upload.file_url}" onerror="this.src='https://via.placeholder.com/400x200?text=Invalid+Image+URL'" alt="${upload.file_name}">
                <div class="card-body">
                    <span class="image-url">${upload.file_name}</span>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="copyUrl('${upload.file_url}')"><i class="fas fa-copy"></i> Copy</button>
                        <button onclick="deleteUpload(${upload.id})" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c;"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                </div>
            </div>`;
        });
        html += '</div>';
        document.getElementById("uploadList").innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        showMsg('Error loading uploads', 'error', 'uploads');
    });
}

function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        showMsg('URL copied to clipboard!', 'success', 'uploads');
    });
}

function deleteUpload(id) {
    if (!confirm('Are you sure you want to delete this upload?')) return;

    fetch("delete_upload.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Upload deleted successfully!', 'success', 'uploads');
            loadUploads();
        } else {
            showMsg(data.message || 'Error deleting upload', 'error', 'uploads');
        }
    })
    .catch(err => showMsg('Error deleting upload', 'error', 'uploads'));
}

// ==================== CAROUSEL GROUPS ====================
function loadCarouselGroups() {
    fetch("get_carousel_groups.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalGroups').textContent = data.length || 0;
        document.getElementById('activeGroups').textContent = data.length || 0;
        
        if (!data || data.length === 0) {
            document.getElementById("carouselGroupList").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-layer-group"></i>
                    <h3>No Carousel Groups Yet</h3>
                    <p>Add your first carousel group using the form above</p>
                </div>`;
            return;
        }
        
        let html = '<div class="images-grid">';
        data.forEach(group => {
            html += `
            <div class="image-card">
                <div style="height: 100px; display: flex; align-items: center; justify-content: center; background: rgba(108, 92, 231, 0.1);">
                    <i class="fas fa-layer-group" style="font-size: 40px; color: #6C5CE7;"></i>
                </div>
                <div class="card-body" style="flex-direction: column; gap: 10px;">
                    <strong style="font-size: 18px;">${group.name}</strong>
                    <span style="color: #8b8b9e; font-size: 13px; text-align: center;">${group.description || 'No description'}</span>
                    <button onclick="deleteCarouselGroup(${group.id})" style="margin-top: 10px;"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>`;
        });
        html += '</div>';
        document.getElementById("carouselGroupList").innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        showMsg('Error loading carousel groups', 'error', 'carousel');
    });
}

function addCarouselGroup() {
    const name = document.getElementById("groupName").value.trim();
    if (!name) {
        showMsg('Please enter a group name', 'error', 'carousel');
        return;
    }
    
    const description = document.getElementById("groupDesc").value.trim();

    fetch("add_carousel_group.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Carousel group added successfully!', 'success', 'carousel');
            document.getElementById("groupName").value = "";
            document.getElementById("groupDesc").value = "";
            loadCarouselGroups();
        } else {
            showMsg(data.message || 'Error adding carousel group', 'error', 'carousel');
        }
    })
    .catch(err => showMsg('Error adding carousel group', 'error', 'carousel'));
}

function deleteCarouselGroup(id) {
    if (!confirm('Are you sure you want to delete this carousel group?')) return;

    fetch("delete_carousel_group.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Carousel group deleted successfully!', 'success', 'carousel');
            loadCarouselGroups();
        } else {
            showMsg(data.message || 'Error deleting carousel group', 'error', 'carousel');
        }
    })
    .catch(err => showMsg('Error deleting carousel group', 'error', 'carousel'));
}

// ==================== CATEGORIES ====================
function loadCategories() {
    fetch("get_categories.php")
    .then(res => res.json())
    .then(data => {
        categoriesData = data;
        document.getElementById('totalCategories').textContent = data.length || 0;
        document.getElementById('activeCategories').textContent = data.length || 0;
        
        const categorySelect = document.getElementById('videoCategory');
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        data.forEach(cat => {
            categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
        });
        
        if (!data || data.length === 0) {
            document.getElementById("categoryList").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-layer-group"></i>
                    <h3>No Categories Yet</h3>
                    <p>Add your first category using the form above</p>
                </div>`;
            return;
        }
        
        let html = '<div class="images-grid">';
        data.forEach(cat => {
            html += `
            <div class="image-card">
                <div class="feature-icon" style="margin: 30px auto 20px; width: 80px; height: 80px; font-size: 36px;">
                    <i class="fas fa-${cat.icon || 'folder'}"></i>
                </div>
                <div class="card-body" style="flex-direction: column; gap: 10px;">
                    <strong style="font-size: 18px;">${cat.name}</strong>
                    <span style="color: #8b8b9e; font-size: 13px; text-align: center;">${cat.description || 'No description'}</span>
                    <button onclick="deleteCategory(${cat.id})" style="margin-top: 10px;"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>`;
        });
        html += '</div>';
        document.getElementById("categoryList").innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        showMsg('Error loading categories', 'error', 'categories');
    });
}

function addCategory() {
    const name = document.getElementById("catName").value.trim();
    if (!name) {
        showMsg('Please enter a category name', 'error', 'categories');
        return;
    }
    
    const description = document.getElementById("catDesc").value.trim();
    const icon = 'folder';

    fetch("add_category.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description) + "&icon=" + encodeURIComponent(icon)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Category added successfully!', 'success', 'categories');
            document.getElementById("catName").value = "";
            document.getElementById("catDesc").value = "";
            loadCategories();
        } else {
            showMsg(data.message || 'Error adding category', 'error', 'categories');
        }
    })
    .catch(err => showMsg('Error adding category', 'error', 'categories'));
}

function deleteCategory(id) {
    if (!confirm('Are you sure you want to delete this category?')) return;

    fetch("delete_category.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Category deleted successfully!', 'success', 'categories');
            loadCategories();
        } else {
            showMsg(data.message || 'Error deleting category', 'error', 'categories');
        }
    })
    .catch(err => showMsg('Error deleting category', 'error', 'categories'));
}

// ==================== VIDEOS ====================
let uploadedVideoUrl = '';
let uploadedThumbUrl = '';

function handleVideoFileUpload(input, type) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);

        document.getElementById('videoUploadProgress').style.display = 'block';
        document.getElementById('videoProgressText').textContent = 'Uploading ' + type + '...';

        fetch("upload.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                if (type === 'video') {
                    uploadedVideoUrl = data.url;
                    showMsg('Video uploaded successfully!', 'success', 'videos');
                } else {
                    uploadedThumbUrl = data.url;
                    showMsg('Thumbnail uploaded successfully!', 'success', 'videos');
                }
                
                if (uploadedVideoUrl) {
                    document.getElementById('saveVideoBtn').disabled = false;
                }
            } else {
                showMsg(data.message || 'Error uploading file', 'error', 'videos');
            }
            document.getElementById('videoUploadProgress').style.display = 'none';
        })
        .catch(err => {
            showMsg('Error uploading file', 'error', 'videos');
            document.getElementById('videoUploadProgress').style.display = 'none';
        });
    }
}

function saveVideo() {
    const title = document.getElementById('videoTitle').value.trim();
    const description = document.getElementById('videoDesc').value.trim();
    const categoryId = document.getElementById('videoCategory').value;

    if (!title || !uploadedVideoUrl) {
        showMsg('Please enter video title and upload video file', 'error', 'videos');
        return;
    }

    fetch("add_video.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "title=" + encodeURIComponent(title) + 
             "&video_url=" + encodeURIComponent(uploadedVideoUrl) + 
             "&thumbnail_url=" + encodeURIComponent(uploadedThumbUrl) +
             "&description=" + encodeURIComponent(description) +
             "&category_id=" + encodeURIComponent(categoryId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Video added successfully!', 'success', 'videos');
            document.getElementById('videoTitle').value = "";
            document.getElementById('videoDesc').value = "";
            document.getElementById('videoCategory').value = "";
            uploadedVideoUrl = '';
            uploadedThumbUrl = '';
            document.getElementById('saveVideoBtn').disabled = true;
            loadVideos();
        } else {
            showMsg(data.message || 'Error adding video', 'error', 'videos');
        }
    })
    .catch(err => showMsg('Error adding video', 'error', 'videos'));
}

function loadVideos() {
    fetch("get_videos.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalVideos').textContent = data.length || 0;
        document.getElementById('activeVideos').textContent = data.length || 0;
        
        if (!data || data.length === 0) {
            document.getElementById("videoList").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-film"></i>
                    <h3>No Videos Yet</h3>
                    <p>Add your first video using the form above</p>
                </div>`;
            return;
        }
        
        let html = '<div class="images-grid">';
        data.forEach(video => {
            const thumb = video.thumbnail_url || 'https://via.placeholder.com/400x225?text=No+Thumbnail';
            html += `
            <div class="image-card">
                <img src="${thumb}" onerror="this.src='https://via.placeholder.com/400x225?text=Invalid+Thumbnail'" alt="${video.title}">
                <div class="card-body" style="flex-direction: column; gap: 10px; align-items: flex-start;">
                    <strong style="font-size: 16px;">${video.title}</strong>
                    <span style="color: #8b8b9e; font-size: 12px;">${video.category_name || 'Uncategorized'}</span>
                    <span style="color: #8b8b9e; font-size: 11px;">${video.description || ''}</span>
                    <span class="image-url" style="max-width: 100%;">${video.video_url}</span>
                    <div style="display: flex; gap: 8px; margin-top: 10px;">
                        <button onclick="openEditVideo('${video.id}', '${video.title}', '${video.description || ''}', '${video.thumbnail_url || ''}', '${video.video_url}', '${video.category_id || ''}')"><i class="fas fa-edit"></i> Edit</button>
                        <button onclick="deleteVideo(${video.id})" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c;"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                </div>
            </div>`;
        });
        html += '</div>';
        document.getElementById("videoList").innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        showMsg('Error loading videos', 'error', 'videos');
    });
}

function openEditVideo(id, title, description, thumbnailUrl, videoUrl, categoryId) {
    document.getElementById('editVideoId').value = id;
    document.getElementById('editVideoTitle').value = title;
    document.getElementById('editVideoDesc').value = description || '';
    document.getElementById('editVideoThumb').value = thumbnailUrl || '';
    document.getElementById('editVideoUrl').value = videoUrl || '';
    document.getElementById('editVideoCategory').value = categoryId || '';
    document.getElementById('editVideoModal').style.display = 'flex';
    document.getElementById('editVideoMsg').className = 'msg';
    
    const catSelect = document.getElementById('editVideoCategory');
    catSelect.innerHTML = '<option value="">Select Category</option>';
    categoriesData.forEach(cat => {
        catSelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
    });
    document.getElementById('editVideoCategory').value = categoryId || '';
}

function closeEditVideoModal() {
    document.getElementById('editVideoModal').style.display = 'none';
}

function saveEditVideo() {
    const id = document.getElementById('editVideoId').value;
    const title = document.getElementById('editVideoTitle').value.trim();
    const description = document.getElementById('editVideoDesc').value.trim();
    const thumbnailUrl = document.getElementById('editVideoThumb').value.trim();
    const videoUrl = document.getElementById('editVideoUrl').value.trim();
    const categoryId = document.getElementById('editVideoCategory').value;

    if (!title) {
        document.getElementById('editVideoMsg').className = 'msg show error';
        document.getElementById('editVideoMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> Title is required';
        return;
    }

    fetch("edit_video.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "id=" + encodeURIComponent(id) +
             "&title=" + encodeURIComponent(title) +
             "&description=" + encodeURIComponent(description) +
             "&thumbnail_url=" + encodeURIComponent(thumbnailUrl) +
             "&video_url=" + encodeURIComponent(videoUrl) +
             "&category_id=" + encodeURIComponent(categoryId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            document.getElementById('editVideoMsg').className = 'msg show success';
            document.getElementById('editVideoMsg').innerHTML = '<i class="fas fa-check-circle"></i> Video updated successfully!';
            setTimeout(() => {
                closeEditVideoModal();
                loadVideos();
            }, 1000);
        } else {
            document.getElementById('editVideoMsg').className = 'msg show error';
            document.getElementById('editVideoMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + (data.message || 'Error updating video');
        }
    })
    .catch(err => {
        document.getElementById('editVideoMsg').className = 'msg show error';
        document.getElementById('editVideoMsg').innerHTML = '<i class="fas fa-exclamation-circle"></i> Error updating video';
    });
}

function deleteVideo(id) {
    if (!confirm('Are you sure you want to delete this video?')) return;

    fetch("delete_video.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            showMsg('Video deleted successfully!', 'success', 'videos');
            loadVideos();
        } else {
            showMsg(data.message || 'Error deleting video', 'error', 'videos');
        }
    })
    .catch(err => showMsg('Error deleting video', 'error', 'videos'));
}

// ==================== SETTINGS ====================
function loadSettings() {
    fetch("get_settings.php")
    .then(res => res.json())
    .then(data => {
        if (data.site_name) document.getElementById('settingSiteName').value = data.site_name;
        if (data.site_description) document.getElementById('settingSiteDesc').value = data.site_description;
        if (data.footer_text) document.getElementById('settingFooter').value = data.footer_text;
        if (data.contact_email) document.getElementById('settingEmail').value = data.contact_email;
    })
    .catch(err => console.error(err));
}

function saveSettings() {
    const siteName = document.getElementById('settingSiteName').value.trim();
    const siteDesc = document.getElementById('settingSiteDesc').value.trim();
    const footer = document.getElementById('settingFooter').value.trim();
    const email = document.getElementById('settingEmail').value.trim();
    
    const settings = [
        { key: 'site_name', value: siteName },
        { key: 'site_description', value: siteDesc },
        { key: 'footer_text', value: footer },
        { key: 'contact_email', value: email }
    ];
    
    let saved = 0;
    settings.forEach(s => {
        fetch("update_settings.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "key=" + encodeURIComponent(s.key) + "&value=" + encodeURIComponent(s.value)
        })
        .then(res => res.json())
        .then(data => {
            saved++;
            if (saved === settings.length) {
                showMsg('Settings saved successfully!', 'success', 'settings');
            }
        });
    });
}

// Enter key handlers
document.getElementById('imageUrl').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addImage();
});

document.getElementById('catName').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addCategory();
});

document.getElementById('groupName').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addCarouselGroup();
});

document.getElementById('videoTitle').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addVideo();
});

loadImages();
</script>

</body>
</html>