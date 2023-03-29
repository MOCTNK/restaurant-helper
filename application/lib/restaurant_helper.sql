CREATE DATABASE restaurant_helper;

CREATE TABLE restaurant_helper.users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    surname VARCHAR(50),
    patronymic VARCHAR(50),
    date DATETIME
);

CREATE TABLE restaurant_helper.positions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255)
);

CREATE TABLE restaurant_helper.user_position(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_position INT,
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id),
    FOREIGN KEY (id_position) REFERENCES restaurant_helper.positions (id)
);

CREATE TABLE restaurant_helper.accounts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    login VARCHAR(50),
    password VARCHAR(50),
    token VARCHAR(50),
    date DATETIME,
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id)
);

INSERT INTO restaurant_helper.positions (name) VALUES
('Главный админ'),
('Админ');