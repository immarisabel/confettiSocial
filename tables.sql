CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE gallery (
    user_id INT,
    idGallery INT AUTO_INCREMENT PRIMARY KEY,
    titleGallery VARCHAR(100),
    descGallery TEXT,
    imgFullNameGallery VARCHAR(255),
    orderGallery INT,
    dateGallery TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
