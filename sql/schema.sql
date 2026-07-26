CREATE TABLE users (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(50) NOT NULL UNIQUE,

    email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('admin') DEFAULT 'admin',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE categories (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL UNIQUE,

    slug VARCHAR(120) NOT NULL UNIQUE,

    sort_order INT DEFAULT 0,

    is_active BOOLEAN DEFAULT TRUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

CREATE TABLE category_translations (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_id INT UNSIGNED NOT NULL,

    language_code VARCHAR(5) NOT NULL,

    translated_name VARCHAR(100) NOT NULL,

    UNIQUE KEY unique_translation (
        category_id,
        language_code
    ),

    FOREIGN KEY (category_id)
    REFERENCES categories(id)
    ON DELETE CASCADE

);

CREATE TABLE gallery_images (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    category_id INT UNSIGNED NOT NULL,

    filename VARCHAR(255) NOT NULL,

    thumbnail VARCHAR(255),

    sort_order INT DEFAULT 0,

    is_featured BOOLEAN DEFAULT FALSE,

    is_active BOOLEAN DEFAULT TRUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
    REFERENCES categories(id)
    ON DELETE CASCADE

);

CREATE TABLE gallery_translations (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    gallery_id INT UNSIGNED NOT NULL,

    language_code VARCHAR(5) NOT NULL,

    title VARCHAR(255) NOT NULL,

    description TEXT,

    alt_text VARCHAR(255),

    seo_title VARCHAR(255),

    seo_description TEXT,

    UNIQUE KEY unique_translation (
        gallery_id,
        language_code
    ),

    FOREIGN KEY (gallery_id)
    REFERENCES gallery_images(id)
    ON DELETE CASCADE

);

CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL,

    phone VARCHAR(50),

    message TEXT NOT NULL,

    status ENUM('new', 'read', 'archived') DEFAULT 'new',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL
);

CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    content LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);