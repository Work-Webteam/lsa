USE lsa;

DROP TABLE IF EXISTS milestones;

CREATE TABLE milestones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    donation DECIMAL(19,4) NOT NULL DEFAULT 0
);


DROP TABLE IF EXISTS cities;

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS ministries;

CREATE TABLE ministries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS diet;

CREATE TABLE diet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS roles_user;

CREATE TABLE roles_user (
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role_id INT
);


DROP TABLE IF EXISTS pecsf_regions;

CREATE TABLE pecsf_regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS pecsf_charities;

CREATE TABLE pecsf_charities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    region_id INT,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS ceremonies;

CREATE TABLE ceremonies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    night INT,
    date DATETIME
);


DROP TABLE IF EXISTS awards;

CREATE TABLE awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    milestone INT,
    active BIT
);


DROP TABLE IF EXISTS registration;

CREATE TABLE registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user INT
);


INSERT INTO `milestones` (`id`,`name`) VALUES (1,'25 Years');
INSERT INTO `milestones` (`id`,`name`) VALUES (2,'30 Years');
INSERT INTO `milestones` (`id`,`name`) VALUES (3,'35 Years');
INSERT INTO `milestones` (`id`,`name`) VALUES (4,'40 Years');
INSERT INTO `milestones` (`id`,`name`) VALUES (5,'45 Years');
INSERT INTO `milestones` (`id`,`name`) VALUES (6,'50 Years');
