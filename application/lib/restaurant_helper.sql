CREATE DATABASE restaurant_helper;

CREATE TABLE restaurant_helper.users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name CHAR(100) NOT NULL,
    surname CHAR(100) NOT NULL,
    patronymic CHAR(100) NOT NULL,
    date DATETIME NOT NULL,
    date_of_birth DATE NOT NULL,
    avatar CHAR(50) DEFAULT 'avatar_default.png'
);

CREATE TABLE restaurant_helper.positions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    code_name CHAR(50) NOT NULL,
    name CHAR(100) NOT NULL,
    is_admin BOOL NOT NULL,
    UNIQUE (code_name, name)
);

CREATE TABLE restaurant_helper.user_position(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_position INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id) ON DELETE CASCADE,
    FOREIGN KEY (id_position) REFERENCES restaurant_helper.positions (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.accounts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    login CHAR(50) NOT NULL,
    password CHAR(50) NOT NULL,
    token CHAR(50),
    date DATETIME NOT NULL,
    UNIQUE (login, token),
    FOREIGN KEY (id_user) REFERENCES restaurant_helper.users (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.restaurants(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name CHAR(100) NOT NULL,
    address CHAR(255),
    about CHAR(255),
    logo CHAR(50) DEFAULT 'logo_default.png',
    date DATETIME,
    UNIQUE (name)
);

CREATE TABLE restaurant_helper.restaurant_employees(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_restaurant INT NOT NULL,
    id_user_position INT NOT NULL,
    date DATETIME,
    FOREIGN KEY (id_restaurant) REFERENCES restaurant_helper.restaurants (id) ON DELETE CASCADE,
    FOREIGN KEY (id_user_position) REFERENCES restaurant_helper.user_position (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.modules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name CHAR(50) NOT NULL,
    UNIQUE (name)
);

CREATE TABLE restaurant_helper.module_position(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_position INT NOT NULL,
    id_module INT NOT NULL,
    FOREIGN KEY (id_position) REFERENCES restaurant_helper.positions (id) ON DELETE CASCADE,
    FOREIGN KEY (id_module) REFERENCES restaurant_helper.modules (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.menu_admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_module INT NOT NULL,
    name CHAR(100) NOT NULL,
    action CHAR(50) NOT NULL,
    UNIQUE (action, name),
    FOREIGN KEY (id_module) REFERENCES restaurant_helper.modules (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.menu_employee (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_module INT NOT NULL,
    name CHAR(100) NOT NULL,
    action CHAR(50) NOT NULL,
    UNIQUE (action, name),
    FOREIGN KEY (id_module) REFERENCES restaurant_helper.modules (id) ON DELETE CASCADE
);

CREATE TABLE restaurant_helper.module_table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_module INT NOT NULL,
    name CHAR(100) NOT NULL,
    UNIQUE (name),
    FOREIGN KEY (id_module) REFERENCES restaurant_helper.modules (id) ON DELETE CASCADE
);

INSERT INTO restaurant_helper.positions (code_name, name, is_admin) VALUES
('head_admin','Главный администратор', 1),
('admin', 'Администратор', 1);