USE lsa;

DROP IF EXISTS milestones;

CREATE TABLE milestones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
);

DROP IF EXISTS awards;

CREATE TABLE awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    milestone INT,
    active BIT,
);
