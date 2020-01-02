USE lsa;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS ministries;
DROP TABLE IF EXISTS pecsf_charities;
DROP TABLE IF EXISTS pecsf_regions;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS awards;
DROP TABLE IF EXISTS milestones;
DROP TABLE IF EXISTS diet;
DROP TABLE IF EXISTS ceremonies;

DROP TABLE IF EXISTS user_roles;
DROP TABLE IF EXISTS roles;


USE lsa;


CREATE TABLE milestones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    donation DECIMAL(19,4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE ministries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE diet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE user_roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role_id INT,
    FOREIGN KEY role_key (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE pecsf_regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    charity_id VARCHAR(16)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE pecsf_charities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pecsf_region_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY pecsf_region_key (pecsf_region_id) REFERENCES pecsf_regions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS ceremonies;

CREATE TABLE ceremonies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    night INT,
    date DATETIME,
    notes TEXT,
    attending BLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    milestone_id INT,
    description TEXT,
    image VARCHAR(255),
    options BLOB,
    active BOOLEAN,
    FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created DATETIME,
    modified DATETIME,

    user_id INT,

    employee_id INT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),

    milestone_id INT,
    award_id INT,
    award_options BLOB,
    award_instructions TEXT,
    award_year INT,
    certificate_name VARCHAR(255),

    pecsf_donation BOOLEAN,
    pecsf_region_id INT,
    pecsf_charity1_id INT,
    pecsf_amount1 DECIMAL(19,4) NOT NULL DEFAULT 0,
    pecsf_second_charity BOOLEAN,
    pecsf_charity2_id INT,
    pecsf_amount2 DECIMAL(19,4) NOT NULL DEFAULT 0,
    pecsf_cheque_date DATE,

    retiring_this_year BOOLEAN,
    retirement_date DATE,

    retroactive BOOLEAN,

    admin_notes TEXT,

    alternate_ministry_id INT,
    attending BOOLEAN,
    ceremony_id INT,

    accessibility_requirements_recipient INT,
    accessibility_requirements_guest INT,
    accessibility_recipient_notes TEXT,
    accessibility_guest_notes TEXT,
    accessibility_admin_notes TEXT,

    presentation_number INT,

    ministry_id INT,
    department VARCHAR(255),

    executive_recipient BOOLEAN,
    recipient_speaker BOOLEAN,
    reserved_seating BOOLEAN,

    recipient_diet_id INT,
    recipient_diet_other VARCHAR(255),

    guest BOOLEAN,
    guest_diet_id INT,
    guest_diet_other VARCHAR(255),

    office_address VARCHAR(255),
    office_city_id INT,
    office_province VARCHAR(2),
    office_postal_code VARCHAR(10),

    home_address VARCHAR(255),
    home_city_id INT,
    home_province VARCHAR(2),
    home_postal_code VARCHAR(10),
    home_phone VARCHAR(15),

    work_phone VARCHAR(15),
    work_extension VARCHAR(4),

    preferred_email VARCHAR(255),
    alternate_email VARCHAR(255),

    supervisor_first_name VARCHAR(255),
    supervisor_last_name VARCHAR(255),

    supervisor_address VARCHAR(255),
    supervisor_city_id INT,
    supervisor_province VARCHAR(2),
    supervisor_postal_code VARCHAR(10),
    supervisor_email VARCHAR(255),

    photo_frame_range INT,
    photo_order INT,
    photo_sent BOOLEAN,

    survey_participation BOOLEAN,

    FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id),
	FOREIGN KEY award_key (award_id) REFERENCES awards(id),
    FOREIGN KEY ministry_key (ministry_id) REFERENCES ministries(id),
    FOREIGN KEY alternate_ministry_key (alternate_ministry_id) REFERENCES ministries(id),
    FOREIGN KEY ceremony_key (ceremony_id) REFERENCES ceremonies(id),
    FOREIGN KEY recipient_diet_key (recipient_diet_id) REFERENCES diet(id),
    FOREIGN KEY guest_diet_key (guest_diet_id) REFERENCES diet(id),
    FOREIGN KEY office_city_key (office_city_id) REFERENCES cities(id),
    FOREIGN KEY supervisor_city_key (supervisor_city_id) REFERENCES cities(id),
    FOREIGN KEY home_city_key (office_city_id) REFERENCES cities(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


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

INSERT INTO `ministries` (`name`) VALUES ('Finance');
INSERT INTO `ministries` (`name`) VALUES ('Transportation & Infrastructure');
INSERT INTO `ministries` (`name`) VALUES ('Citizens Services');
INSERT INTO `ministries` (`name`) VALUES ('Agriculture');
INSERT INTO `ministries` (`name`) VALUES ('Attorney General');
INSERT INTO `ministries` (`name`) VALUES ('Advanced Education, Skills & Training');
INSERT INTO `ministries` (`name`) VALUES ('Education');
INSERT INTO `ministries` (`name`) VALUES ('Engergy, Mines & Petroleum Resources');
INSERT INTO `ministries` (`name`) VALUES ('Environment & Climate Change Strategy');
INSERT INTO `ministries` (`name`) VALUES ('Forests, Lands, Natural Resource Operations & Rural Development');
INSERT INTO `ministries` (`name`) VALUES ('Health');
INSERT INTO `ministries` (`name`) VALUES ('Indigenous Relations & Reconciliation');
INSERT INTO `ministries` (`name`) VALUES ('Jobs, Trade & Technology');
INSERT INTO `ministries` (`name`) VALUES ('Labour');
INSERT INTO `ministries` (`name`) VALUES ('Mental Health & Addictions');
INSERT INTO `ministries` (`name`) VALUES ('Municipal Affairs & Housing');
INSERT INTO `ministries` (`name`) VALUES ('Public Safety & Solicitor General & Emergency B.C.');
INSERT INTO `ministries` (`name`) VALUES ('Social Development & Poverty Reduction');
INSERT INTO `ministries` (`name`) VALUES ('Tourism, Arts & Culture');

INSERT INTO `cities` (`name`) VALUES ('Abbotsford');
INSERT INTO `cities` (`name`) VALUES ('Armstrong');
INSERT INTO `cities` (`name`) VALUES ('Burnaby');
INSERT INTO `cities` (`name`) VALUES ('Campbell River');
INSERT INTO `cities` (`name`) VALUES ('Castlegar');
INSERT INTO `cities` (`name`) VALUES ('Chilliwack');
INSERT INTO `cities` (`name`) VALUES ('Colwood');
INSERT INTO `cities` (`name`) VALUES ('Coquiltlam');
INSERT INTO `cities` (`name`) VALUES ('Courtney');
INSERT INTO `cities` (`name`) VALUES ('Cranbrook');
INSERT INTO `cities` (`name`) VALUES ('Dawson Creek');
INSERT INTO `cities` (`name`) VALUES ('Delta');
INSERT INTO `cities` (`name`) VALUES ('Duncan');
INSERT INTO `cities` (`name`) VALUES ('Enderby');
INSERT INTO `cities` (`name`) VALUES ('Fernie');
INSERT INTO `cities` (`name`) VALUES ('Fort St. John');
INSERT INTO `cities` (`name`) VALUES ('Grand Forks');
INSERT INTO `cities` (`name`) VALUES ('Greenwood');
INSERT INTO `cities` (`name`) VALUES ('Kamloops');
INSERT INTO `cities` (`name`) VALUES ('Kelowna');
INSERT INTO `cities` (`name`) VALUES ('Kimberly');
INSERT INTO `cities` (`name`) VALUES ('Langford');
INSERT INTO `cities` (`name`) VALUES ('Langley');
INSERT INTO `cities` (`name`) VALUES ('Maple Ridge');
INSERT INTO `cities` (`name`) VALUES ('Merritt');
INSERT INTO `cities` (`name`) VALUES ('Nanaimo');
INSERT INTO `cities` (`name`) VALUES ('Nelson');
INSERT INTO `cities` (`name`) VALUES ('New Westminster');
INSERT INTO `cities` (`name`) VALUES ('North Vancouver');
INSERT INTO `cities` (`name`) VALUES ('Parksville');
INSERT INTO `cities` (`name`) VALUES ('Penticton');
INSERT INTO `cities` (`name`) VALUES ('Pitt Meadows');
INSERT INTO `cities` (`name`) VALUES ('Port Alberni');
INSERT INTO `cities` (`name`) VALUES ('Port Coquitlam');
INSERT INTO `cities` (`name`) VALUES ('Port Moody');
INSERT INTO `cities` (`name`) VALUES ('Powell River');
INSERT INTO `cities` (`name`) VALUES ('Prince George');
INSERT INTO `cities` (`name`) VALUES ('Prince Rupert');
INSERT INTO `cities` (`name`) VALUES ('Quesnel');
INSERT INTO `cities` (`name`) VALUES ('Revelstoke');
INSERT INTO `cities` (`name`) VALUES ('Richmond');
INSERT INTO `cities` (`name`) VALUES ('Rossland');
INSERT INTO `cities` (`name`) VALUES ('Salmon Arm');
INSERT INTO `cities` (`name`) VALUES ('Surrey');
INSERT INTO `cities` (`name`) VALUES ('Terrace');
INSERT INTO `cities` (`name`) VALUES ('Trail');
INSERT INTO `cities` (`name`) VALUES ('Vancouver');
INSERT INTO `cities` (`name`) VALUES ('Vernon');
INSERT INTO `cities` (`name`) VALUES ('Victoria');
INSERT INTO `cities` (`name`) VALUES ('West Kelowna');
INSERT INTO `cities` (`name`) VALUES ('White Rock');
INSERT INTO `cities` (`name`) VALUES ('Williams Lake');

INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Cross® Pen','This Cross® Calais chrome and blue lacquer rollerball pen is lightweight with a bold profile. It comes in a box with 25 Years engraved on the lid of the pen.
25 year certificate', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Bugatti® writing case and tablet holder','This recycled and synthetic leather case has 25 Years debossed on the front. The zippered closure keeps your tablet secure during transport, and adjustable brackets hold most tablet models, including three sizes of iPad (tablet is not included). The cover includes a pocket for a smartphone, USB and pen holders, card slots, an ID window and writing pad.

Size: 10 3/4" H X 9" W', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Passport and luggage tag set','This genuine black leather passport holder and luggage tag has 25 Years debossed on the front. It has a magnetic closure. ', 1, 1);
INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Pearl earrings','These sterling silver, fresh water pearl earrings have an accent of gold. They are made in Vancouver, B.C. by Howling Dog Artisan Jewellery.

Size: 2.5 cm L x 1 cm W

Note: Due to the nature of this award, engraving is not possible.', 1, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Appalachian Sherpa blanket','This high-end plush blanket has 30 Years embroidered on the corner. It’s made of faux suede on one side and soft Sherpa fleece on the other.
--
-- Size: 60" L x 50" W', 2, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Howard Miller® Colonnade clock','This bold optical crystal, carriage-style clock has In recognition of thirty years of service engraved on front plate. It features a black glass center panel and a white dial with black Roman numerals and hour markers surrounded by a polished silver-tone bezel.
--
-- Size: 6.75" H (17 cm) x 6.25" W (16 cm)', 2, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Epiphany III framed art print','This stunning photograph by B.C. artist Marvin Pelkey is printed on fine art paper and comes matted in a black frame. The frame has In recognition of thirty years of service engraved on a plaque.
--
-- Size: 16” H x 16” W', 2, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Sterling silver earrings','These sterling silver drop earrings are individually handcrafted by B.C. artists Nancy Dawson and Vincent Henson of Silver Eagles Design Studio in Alert Bay. They come in a box with In recognition of thirty years of service engraved on the top.
--
-- Size: 2.75 cm L x 2 cm W
--
-- Note: These earrings are designed to coordinate with the 35 year sterling silver bracelet.', 2, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Bulova® watch','This watch features the BC Coat of Arms on the dial and your name and 35 Years is engraved on the back of the watch face. It comes in a choice of gold, silver or two-toned watch face with a plated strap, or a black or brown leather strap. ', 3, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Bushnell® Prime binoculars','The Bushnell® Prime 8x42 binocular is the perfect blend of magnification and field of view, allowing easy viewing of moving animals and birds. The EXO barrier and fully multi coated optics deliver bright images in any weather conditions. The Prime binoculars feature Bushnell’s newest and best protective lens coating that molecularly bonds to the glass, repelling water, oil, dust, debris and preventing scratches. With IPX7 waterproof construction, O-ring sealed optics stay dry inside, when immersed in three feet of water for up to 30 minutes. They come with a soft case.
--
-- Note: Due to the nature of this award, engraving is not possible.
--
-- Configuration = 8 x 42mm
--
-- Field of View 350/117 (ft.@1000 yrds/m@1000m)
--
-- Close Focus = 10F/3M
--
-- Weight = 23.3 oz (660 gm)', 3, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Blue Flower Bouquet glass vase','Each of these unique glass vases are hand-blown by B.C. artist Robert Held in Parksville.
--
-- Size:11.5" H
--
-- Note: Due to the nature of this gift, engraving is not possible.', 3, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Sterling silver bracelet','This sterling silver bracelet has a 14 kt yellow gold insert. It is handcrafted by B.C. artists Nancy Dawson and Vincent Henson of Silver Eagles Design Studio in Alert Bay. It comes in a box with In recognition of thirty five years of serviceengraved on the top.', 3, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Ergo® Napoleon Beauty mantle clock','This clock features a wood frame in solids and veneers in a warm oak finish with burl accents. It has In recognition of forty years of service engraved on front plate. A brass finish bezel surrounds the dial. It has rich chimes which you can adjust to your preference (quarterly Westminster, quarterly Ava Maria, hourly Westminster or hourly/half hour strike).
--
-- Size: 20" H x 10" W', 4, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Genuine diamond pendant and chain','This necklace features a 10 kt white gold, four claw pendant and 18 inch box chain. The round brilliant cut diamonds are .20-carat total weight. It comes in a box with In recognition of forty years of service engraved on the top.', 4, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Genuine diamond stud earrings','These earrings are 14 kt white gold stud earrings featuring round brilliant cut diamonds that are .25 carat total weight. They come in a box with In recognition of forty years of service engraved on the top.', 4, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Blue Flower Bouquet glass bowl','Each of these unique glass bowls are hand-blown by B.C. artist Robert Held in Parksville.
--
-- Size: 7" H
--
-- Note: Due to the nature of this award, engraving is not possible.', 4, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Forest Cove framed art print','This colourful landscape print was originally painted by artist Michaela Davidson, from Lake Cowichan, B.C. The artwork is presented in a matted green frame with In recognition of forty years of service engraved on a plaque.
--
-- Size: 16" H x 14" W ', 4, 1);
--
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Howard Miller® "Park" Clock','Walnut wood finish, chiming wall clock with elegant roman numerals and gold tone accent hands. Quartz battery movement. Comes with an engraved plate “In recognition of forty-five years of service.”
-- Size: 19 ½” H x 10” W ', 5, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Thule® Subterra Luggage','This durable luggage from Thule® is made from water-resistant materials. The tough, oversized wheels and V-Tubing telescoping handles make for smooth and easy transport. It has a divided main compartment to separate clothes and has top, side and bottom grab handles. Complies with carry-on requirements for most airlines.
-- Size:  21.7”L x 13.8”W x 7.9” H ', 5, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Carson® Telescope','Refractor telescope with a 70mm short tube wide angle scope. Comes with an adjustable tabletop tripod and carrying case. D3 Silver Medallion.
-- Specs: focal length of 350mm, 45 degree diagonal, power range of 14x 116.6x.', 5, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('White Diamond Stud Earrings','These brilliant round cut diamonds are set in 14 kt. white gold with four white gold claws and butterfly backs. Comes with an engraved plate on the presentation box, “In recognition of forty-five years of service.”
-- Weight: pair of diamonds is .30 ct. t.w.', 5, 1);
--
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Sterling Silver Gemstone Set','Stunning sterling silver pendant necklace and earrings with blue topaz, peridot, and amethyst stones. Comes with an engraved plate on the presentation box, “In recognition of fifty years of service.”
-- Length: 18”', 6, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Crystal Pitcher and Glass Set','Chesley, lead free crystal, 50 oz. water pitcher. Comes with four matching high ball glasses, 13 oz.
-- Weight: 9 lbs.', 6, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Citizen® Axiom Eco-Drive Watch (mens)','Black dial with black leather strap. Has date feature and is splash resistant. Comes in stainless steel case.
-- Size of face: 40 mm diameter', 6, 1);
-- INSERT INTO `awards` (`name`, `description`, `milestone_id`, `active`) VALUES ('Bulova® "Yarmouth" Clock','Bulova wall clock with thermometer and hygrometer. Comes in a beautiful walnut finish and has an engraved plate, “In recognition of fifty years of service.”
-- Size: 17 ¼ "H x 10 ¾” W x 3“ D', 6, 1);
