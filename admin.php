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
    <a href="#" class="menu-item" onclick="showTab('categories')"><i class="fas fa-layer-group"></i> Categories</a>
    <a href="#" class="menu-item"><i class="fas fa-film"></i> Videos</a>
    <a href="#" class="menu-item"><i class="fas fa-cog"></i> Settings</a>
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
</main>

<script>
let currentTab = 'slider';

function showTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    event.target.classList.add('active');
    
    document.getElementById('tab-slider').style.display = tab === 'slider' ? 'block' : 'none';
    document.getElementById('tab-categories').style.display = tab === 'categories' ? 'block' : 'none';
    
    if (tab === 'slider') loadImages();
    if (tab === 'categories') loadCategories();
}

function showMsg(text, type, tab) {
    const msgId = tab === 'slider' ? 'sliderMsg' : 'categoryMsg';
    const msg = document.getElementById(msgId);
    msg.className = 'msg show ' + type;
    msg.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + text;
    setTimeout(() => msg.classList.remove('show'), 4000);
}

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

function loadCategories() {
    fetch("get_categories.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById('totalCategories').textContent = data.length || 0;
        document.getElementById('activeCategories').textContent = data.length || 0;
        
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

// Enter key to add
document.getElementById('imageUrl').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addImage();
});

document.getElementById('catName').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') addCategory();
});

loadImages();
</script>

</body>
</html>