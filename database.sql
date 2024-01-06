-- Ezt be kell importálni az adatbázis kezelő felületre az adatbázis létrehozásáért --

CREATE DATABASE IF NOT EXISTS savemoneyapp;

USE savemoneyapp;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(48) NOT NULL,
    username VARCHAR(48) NOT NULL,
    password VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    description VARCHAR(32),
    type VARCHAR(32) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
    );