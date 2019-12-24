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


DROP TABLE IF EXISTS user_roles;

CREATE TABLE user_roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role_id INT,
    FOREIGN KEY role_key (role_id) REFERENCES roles(id)
);


DROP TABLE IF EXISTS pecsf_regions;

CREATE TABLE pecsf_regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);


DROP TABLE IF EXISTS pecsf_charities;

CREATE TABLE pecsf_charities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pecsf_region_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY pecsf_region_key (pecsf_region_id) REFERENCES pecsf_regions(id)
);


DROP TABLE IF EXISTS ceremonies;

CREATE TABLE ceremonies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    night INT,
    date DATETIME,
    notes TEXT,
    attending BLOB
);


DROP TABLE IF EXISTS awards;

CREATE TABLE awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    milestone_id INT,
    description TEXT,
    image VARCHAR(255),
    options BLOB,
    active BOOLEAN,
    FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id)
);


DROP TABLE IF EXISTS registrations;

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    milestone_id INT,
    award_id INT,
    award_options BLOB,
    admin_notes TEXT,
    FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id),
    FOREIGN KEY award_key (award_id) REFERENCES awards(id)
);


INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (1,'25 Years', 75);
INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (2,'30 Years', 150);
INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (3,'35 Years', 300);
INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (4,'40 Years', 400);
INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (5,'45 Years', 0);
INSERT INTO `milestones` (`id`,`name`, `donation`) VALUES (6,'50 Years', 0);

INSERT INTO `roles` (`id`, `name`) VALUES(1, 'Administrator');
INSERT INTO `roles` (`id`, `name`) VALUES(2, 'LSA Admin');
INSERT INTO `roles` (`id`, `name`) VALUES(3, 'Protocol');
INSERT INTO `roles` (`id`, `name`) VALUES(4, 'Award Procurement');
INSERT INTO `roles` (`id`, `name`) VALUES(5, 'Ministry Contact');
INSERT INTO `roles` (`id`, `name`) VALUES(6, 'Supervisor');

INSERT INTO `diet` (`name`) VALUES ('Dairy Free');
INSERT INTO `diet` (`name`) VALUES ('Gluten Free');
INSERT INTO `diet` (`name`) VALUES ('Sugar Free');
INSERT INTO `diet` (`name`) VALUES ('No Shellfish');
INSERT INTO `diet` (`name`) VALUES ('Vegetarian');
INSERT INTO `diet` (`name`) VALUES ('Vegan');

INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Cross® Pen','This Cross® Calais chrome and blue lacquer rollerball pen is lightweight with a bold profile. It comes in a box with 25 Years engraved on the lid of the pen.
25 year certificate', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Bugatti® writing case and tablet holder','This recycled and synthetic leather case has 25 Years debossed on the front. The zippered closure keeps your tablet secure during transport, and adjustable brackets hold most tablet models, including three sizes of iPad (tablet is not included). The cover includes a pocket for a smartphone, USB and pen holders, card slots, an ID window and writing pad.

Size: 10 3/4" H X 9" W', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Passport and luggage tag set','This genuine black leather passport holder and luggage tag has 25 Years debossed on the front. It has a magnetic closure. ', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Pearl earrings','These sterling silver, fresh water pearl earrings have an accent of gold. They are made in Vancouver, B.C. by Howling Dog Artisan Jewellery.

Size: 2.5 cm L x 1 cm W

Note: Due to the nature of this award, engraving is not possible.', 1, 1);
