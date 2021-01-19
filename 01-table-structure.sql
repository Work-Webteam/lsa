USE lsa;

DROP TABLE IF EXISTS log;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS vip;

DROP TABLE IF EXISTS userroles;
DROP TABLE IF EXISTS roles;

DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS ministries;
DROP TABLE IF EXISTS pecsfcharities;
DROP TABLE IF EXISTS pecsfregions;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS awards;
DROP TABLE IF EXISTS milestones;
DROP TABLE IF EXISTS diet;
DROP TABLE IF EXISTS accessibility;
DROP TABLE IF EXISTS ceremonies;
DROP TABLE IF EXISTS registrationperiods;

CREATE TABLE milestones (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            years VARCHAR(16) NOT NULL,
                            personalized TINYINT(1) DEFAULT false,
                            donation DECIMAL(19,4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE cities (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE ministries (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            name_shortform VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE diet (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE accessibility (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               name VARCHAR(255) NOT NULL,
                               sortorder INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE roles (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE userroles (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           idir VARCHAR(16),
                           guid varchar(128) DEFAULT '',
                           role_id INT,
                           ministry_id INT DEFAULT 0,
                           FOREIGN KEY role_key (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE pecsfregions (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(255) NOT NULL,
                              charity_id VARCHAR(16)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE pecsfcharities (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                pecsf_region_id INT,
                                vendor_code VARCHAR(10) NOT NULL,
                                name VARCHAR(255) NOT NULL,
                                url VARCHAR(255) NOT NULL,
                                FOREIGN KEY pecsf_region_key (pecsf_region_id) REFERENCES pecsfregions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE registrationperiods (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     registration_year INT,
                                     qualifying_years VARCHAR(255) NOT NULL,
                                     open_registration DATETIME,
                                     close_registration DATETIME,
                                     open_rvsp DATETIME,
                                     close_rsvp DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE ceremonies (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            registration_year INT,
                            night INT,
                            date DATETIME,
                            notes TEXT,
                            attending TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE awards (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        abbreviation VARCHAR(32) NOT NULL,
                        milestone_id INT,
                        description TEXT,
                        image VARCHAR(255),
                        options TEXT,
                        personalized TINYINT(1) DEFAULT false,
                        active TINYINT(1) DEFAULT true,
                        FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE registrations (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               created DATETIME,
                               modified DATETIME,

                               user_idir VARCHAR(16),
                               user_guid VARCHAR(128),

                               employee_id INT,
                               first_name VARCHAR(255),
                               last_name VARCHAR(255),

                               milestone_id INT,
                               award_id INT,
                               award_options TEXT,
                               award_instructions TEXT,

                               service_pin TINYINT(1) DEFAULT false,

                               registration_year INT,
                               qualifying_year INT,
                               award_received TINYINT(1) DEFAULT false,
                               engraving_sent TINYINT(1) DEFAULT false,
                               certificate_name VARCHAR(255),
                               certificate_ordered TINYINT(1),

                               pecsf_donation TINYINT(1) DEFAULT 0,
                               pecsf_donation_type INT,
                               pecsf_region_id INT,
                               pecsf_charity1_id INT,
                               pecsf_amount1 DECIMAL(19,4) NOT NULL DEFAULT 0,
                               pecsf_charity2_id INT,
                               pecsf_amount2 DECIMAL(19,4) NOT NULL DEFAULT 0,
                               pecsf_cheque_date DATE,
                               pecsf_name VARCHAR(255),

                               retiring_this_year TINYINT(1) DEFAULT false,
                               retirement_date DATE,

                               retroactive TINYINT(1),

                               member_bcgeu TINYINT(1),
                               admin_notes TEXT,

                               alternate_ministry_id INT,

                               invite_sent DATETIME,

                               responded TINYINT(1) DEFAULT false,
                               attending TINYINT(1) DEFAULT false,
                               guest TINYINT(1) DEFAULT false,
                               noshow TINYINT(1) DEFAULT false,

                               waitinglist TINYINT(1) DEFAULT false,

                               ceremony_id INT,

                               accessibility_recipient TINYINT(1),
                               accessibility_guest TINYINT(1),
                               accessibility_requirements_recipient TEXT,
                               accessibility_requirements_guest TEXT,
                               accessibility_recipient_notes TEXT,
                               accessibility_guest_notes TEXT,
                               accessibility_admin_notes TEXT,

                               presentation_number INT,

                               ministry_id INT,
                               branch VARCHAR(255),

                               executive_recipient TINYINT(1),
                               recipient_speaker TINYINT(1),
                               reserved_seating TINYINT(1),

                               recipient_diet TINYINT(1),
                               dietary_requirements_recipient TEXT,
                               dietary_recipient_other TEXT,

                               guest_first_name VARCHAR(255),
                               guest_last_name VARCHAR(255),

                               guest_diet TINYINT(1),
                               dietary_requirements_guest TEXT,
                               dietary_guest_other TEXT,

                               office_careof VARCHAR(255),
                               office_address VARCHAR(255),
                               office_suite VARCHAR(16),
                               office_city_id INT,
                               office_province VARCHAR(2),
                               office_postal_code VARCHAR(10),

                               home_address VARCHAR(255),
                               home_suite VARCHAR(16),
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

                               supervisor_careof VARCHAR(255),
                               supervisor_address VARCHAR(255),
                               supervisor_suite VARCHAR(16),
                               supervisor_city_id INT,
                               supervisor_province VARCHAR(2),
                               supervisor_postal_code VARCHAR(10),
                               supervisor_email VARCHAR(255),

                               photo_frame_range INT,
                               photo_order INT,
                               photo_sent DATETIME,

                               survey_participation TINYINT(1) DEFAULT false,

                               FOREIGN KEY milestone_key (milestone_id) REFERENCES milestones(id),
                               FOREIGN KEY ministry_key (ministry_id) REFERENCES ministries(id),
                               FOREIGN KEY alternate_ministry_key (alternate_ministry_id) REFERENCES ministries(id),
                               FOREIGN KEY ceremony_key (ceremony_id) REFERENCES ceremonies(id),
                               FOREIGN KEY office_city_key (office_city_id) REFERENCES cities(id),
                               FOREIGN KEY supervisor_city_key (supervisor_city_id) REFERENCES cities(id),
                               FOREIGN KEY home_city_key (office_city_id) REFERENCES cities(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE vip (
                     id INT AUTO_INCREMENT PRIMARY KEY,

                     created DATETIME,
                     modified DATETIME,

                     user_idir VARCHAR(16),
                     user_guid VARCHAR(128),

                     year INT,

                     ministry_id INT,
                     ceremony_id INT,

                     group_no INT,

                     category_id INT,

                     first_name VARCHAR(255),
                     last_name VARCHAR(255),
                     prefix VARCHAR(255),
                     title VARCHAR(255),

                     address_street VARCHAR(255),
                     address_po_box VARCHAR(255),
                     city_id INT,
                     province VARCHAR(2),
                     postal_code VARCHAR(10),
                     phone VARCHAR(15),
                     mobile VARCHAR(15),
                     fax VARCHAR(15),
                     email VARCHAR(255),

                     contact_first_name VARCHAR(255),
                     contact_last_name VARCHAR(255),
                     contact_prefix VARCHAR(255),
                     contact_title VARCHAR(255),
                     contact_phone VARCHAR(15),
                     contact_fax VARCHAR(15),
                     contact_email VARCHAR(255),

                     attending INT DEFAULT -1,
                     attending_designate TINYINT(1),
                     invitation_sent TINYINT(1),
                     total_attending INT,
                     parking_required TINYINT(1),
                     parking_spots_required INT,
                     guest_first_name VARCHAR(255),
                     guest_last_name VARCHAR(255),
                     guest_prefix VARCHAR(255),
                     guest_title VARCHAR(255),

                     notes TEXT,

                     FOREIGN KEY ceremony_key (ceremony_id) REFERENCES ceremonies(id),
                     FOREIGN KEY category_key (category_id) REFERENCES categories(id),
                     FOREIGN KEY ministry_key (ministry_id) REFERENCES ministries(id),
                     FOREIGN KEY city_key (city_id) REFERENCES cities(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE log (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     user_idir VARCHAR(16),
                     user_guid VARCHAR(128),
                     timestamp DATETIME,
                     registration_id INT,
                     type VARCHAR(16),
                     operation VARCHAR(16),
                     description VARCHAR(255),
                     old_value INT DEFAULT NULL,
                     new_value INT DEFAULT NULL,

                     FOREIGN KEY registration_key (registration_id) REFERENCES registrations(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
