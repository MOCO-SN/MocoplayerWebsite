-- MySQL Database Setup for MocoPlayer
-- Run this SQL on your MySQL server

CREATE DATABASE IF NOT EXISTS mocoplayer;
USE mocoplayer;

CREATE TABLE IF NOT EXISTS audios (
    id VARCHAR(36) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    audio_url VARCHAR(500) NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);