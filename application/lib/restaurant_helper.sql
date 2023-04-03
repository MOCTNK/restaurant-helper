CREATE DATABASE restaurant_helper;

CREATE TABLE restaurant_helper.users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    surname VARCHAR(50),
    patronymic VARCHAR(50),
    date DATETIME,
    date_of_birth DATE,
    avatar VARCHAR(50)
);

CREATE TABLE restaurant_helper.positions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    code_name VARCHAR(255),
    name VARCHAR(255),
    is_admin TINYINT
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

INSERT INTO restaurant_helper.positions (code_name, name, is_admin) VALUES
('head_admin','Главный админ', 1),
('admin', 'Админ', 1);