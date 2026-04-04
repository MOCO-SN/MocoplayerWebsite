-- Create database
CREATE DATABASE IF NOT EXISTS mocoplayerside;

-- Use the database
USE mocoplayerside;

-- Create slider_images table
CREATE TABLE IF NOT EXISTS slider_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'folder',
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample categories (optional)
-- INSERT INTO categories (name, description, icon) VALUES ('Movies', 'Watch your favorite movies', 'film');
-- INSERT INTO categories (name, description, icon) VALUES ('Music', 'Listen to music', 'music');
-- INSERT INTO categories (name, description, icon) VALUES ('TV Shows', 'Binge-watch TV series', 'tv');