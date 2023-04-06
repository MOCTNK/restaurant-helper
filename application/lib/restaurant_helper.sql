CREATE DATABASE restaurant_helper;

CREATE TABLE restaurant_helper.users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    patronymic VARCHAR(50) NOT NULL,
    date DATETIME NOT NULL,
    date_of_birth DATE NOT NULL,
    avatar VARCHAR(50) DEFAULT 'avatar_default.png'
);

CREATE TABLE restaurant_helper.positions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    code_name VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    is_admin TINYINT NOT NULL
);

CREATE TABLE restaurant_helper.user_position(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_position INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id),
    FOREIGN KEY (id_position) REFERENCES restaurant_helper.positions (id)
);

CREATE TABLE restaurant_helper.accounts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    login VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    token VARCHAR(50),
    date DATETIME NOT NULL,
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id)
);

INSERT INTO restaurant_helper.positions (code_name, name, is_admin) VALUES
('head_admin','Главный админ', 1),
('admin', 'Админ', 1);