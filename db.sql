SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

-- Creating CITIES table
CREATE TABLE IF NOT EXISTS `CITIES` (
    `ID` INT AUTO_INCREMENT PRIMARY KEY,
    `NAME` VARCHAR(100) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating SPECIALTIES table
CREATE TABLE IF NOT EXISTS `SPECIALTIES` (
    `ID` INT(2) NOT NULL,
    `SNAME` VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating WEBUSER table
CREATE TABLE IF NOT EXISTS `WEBUSER` (
    `USERNAME` VARCHAR(255),
    `EMAIL` VARCHAR(255) NOT NULL,
    `PASSWORD` VARCHAR(255) NOT NULL,
    `USERTYPE` ENUM('p', 'd', 'a') NOT NULL,
    PRIMARY KEY (`EMAIL`)
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating PATIENT table
CREATE TABLE IF NOT EXISTS `PATIENT` (
    `PID` INT(11) NOT NULL AUTO_INCREMENT,
    `PEMAIL` VARCHAR(255) NOT NULL,
    `PNAME` VARCHAR(255) DEFAULT NULL,
    `PADDRESS` VARCHAR(255) DEFAULT NULL,
    `PNIC` VARCHAR(15) DEFAULT NULL,
    `PDOB` DATE DEFAULT NULL,
    `PTEL` VARCHAR(15) DEFAULT NULL,
    PRIMARY KEY (`PID`),
    FOREIGN KEY (`PEMAIL`) REFERENCES `WEBUSER`(`EMAIL`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating DOCTOR table
CREATE TABLE IF NOT EXISTS `DOCTOR` (
    `DOCID` INT(11) NOT NULL AUTO_INCREMENT,
    `DOCEMAIL` VARCHAR(255) DEFAULT NULL,
    `DOCNAME` VARCHAR(255) DEFAULT NULL,
    `DOCNIC` VARCHAR(15) DEFAULT NULL,
    `DOCTEL` VARCHAR(15) DEFAULT NULL,
    `SPECIALTIES` INT(2) DEFAULT NULL,
    `DESCRIPTION` TEXT DEFAULT NULL,
    `EXPERIENCE` INT(3) DEFAULT NULL,
    `IMAGE_PATH` VARCHAR(255) DEFAULT NULL,
    `CITY` INT(11) DEFAULT NULL,
    PRIMARY KEY (`DOCID`),
    KEY `SPECIALTIES` (`SPECIALTIES`),
    KEY `CITY` (`CITY`),
    FOREIGN KEY (`DOCEMAIL`) REFERENCES `WEBUSER`(`EMAIL`) ON DELETE CASCADE,
    FOREIGN KEY (`SPECIALTIES`) REFERENCES `SPECIALTIES`(`ID`),
    FOREIGN KEY (`CITY`) REFERENCES `CITIES`(`ID`)
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating ADMIN table
CREATE TABLE IF NOT EXISTS `ADMIN` (
    `AEMAIL` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`AEMAIL`),
    FOREIGN KEY (`AEMAIL`) REFERENCES `WEBUSER`(`EMAIL`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating SCHEDULE table
CREATE TABLE IF NOT EXISTS `SCHEDULE` (
    `SCHEDULEID` INT(11) NOT NULL AUTO_INCREMENT,
    `DOCID` INT(11) DEFAULT NULL,
    `TITLE` VARCHAR(255) DEFAULT NULL,
    `SCHEDULEDATE` DATE DEFAULT NULL,
    `SCHEDULETIME` TIME DEFAULT NULL,
    `NOP` INT(4) DEFAULT NULL,
    PRIMARY KEY (`SCHEDULEID`),
    KEY `DOCID` (`DOCID`),
    FOREIGN KEY (`DOCID`) REFERENCES `DOCTOR`(`DOCID`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating APPOINTMENT table
CREATE TABLE IF NOT EXISTS `APPOINTMENT` (
    `APPOID` INT(11) NOT NULL AUTO_INCREMENT,
    `PID` INT(10) DEFAULT NULL,
    `APPONUM` INT(3) DEFAULT NULL,
    `SCHEDULEID` INT(10) DEFAULT NULL,
    `APPODATE` DATE DEFAULT NULL,
    PRIMARY KEY (`APPOID`),
    KEY `PID` (`PID`),
    KEY `SCHEDULEID` (`SCHEDULEID`),
    FOREIGN KEY (`PID`) REFERENCES `PATIENT`(`PID`) ON DELETE CASCADE,
    FOREIGN KEY (`SCHEDULEID`) REFERENCES `SCHEDULE`(`SCHEDULEID`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Creating APPOINTMENTS table
CREATE TABLE IF NOT EXISTS `APPOINTMENTS` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `DOCTOR_ID` INT(11) NOT NULL,
    `NAME` VARCHAR(255) NOT NULL,
    `EMAIL` VARCHAR(255) NOT NULL,
    `PHONE` VARCHAR(15) NOT NULL,
    `APPOINTMENT_DATE` DATE NOT NULL,
    `MESSAGE` TEXT NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`DOCTOR_ID`) REFERENCES `DOCTOR`(`DOCID`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Insert test data into SPECIALTIES table
INSERT INTO `SPECIALTIES` (
    `ID`,
    `SNAME`
) VALUES (
    1,
    'Accident and emergency medicine'
),
(
    2,
    'Allergology'
),
(
    3,
    'Anaesthetics'
),
(
    4,
    'Biological hematology'
),
(
    5,
    'Cardiology'
),
(
    6,
    'Child psychiatry'
),
(
    7,
    'Clinical biology'
),
(
    8,
    'Clinical chemistry'
),
(
    9,
    'Clinical neurophysiology'
),
(
    10,
    'Clinical radiology'
),
(
    11,
    'Dental, oral and maxillo-facial surgery'
),
(
    12,
    'Dermato-venerology'
),
(
    13,
    'Dermatology'
),
(
    14,
    'Endocrinology'
),
(
    15,
    'Gastro-enterologic surgery'
),
(
    16,
    'Gastroenterology'
),
(
    17,
    'General hematology'
),
(
    18,
    'General Practice'
),
(
    19,
    'General surgery'
),
(
    20,
    'Geriatrics'
),
(
    21,
    'Immunology'
),
(
    22,
    'Infectious diseases'
),
(
    23,
    'Internal medicine'
),
(
    24,
    'Laboratory medicine'
),
(
    25,
    'Maxillo-facial surgery'
),
(
    26,
    'Microbiology'
),
(
    27,
    'Nephrology'
),
(
    28,
    'Neuro-psychiatry'
),
(
    29,
    'Neurology'
),
(
    30,
    'Neurosurgery'
),
(
    31,
    'Nuclear medicine'
),
(
    32,
    'Obstetrics and gynecology'
),
(
    33,
    'Occupational medicine'
),
(
    34,
    'Ophthalmology'
),
(
    35,
    'Orthopaedics'
),
(
    36,
    'Otorhinolaryngology'
),
(
    37,
    'Paediatric surgery'
),
(
    38,
    'Paediatrics'
),
(
    39,
    'Pathology'
),
(
    40,
    'Pharmacology'
),
(
    41,
    'Physical medicine and rehabilitation'
),
(
    42,
    'Plastic surgery'
),
(
    43,
    'Podiatric Medicine'
),
(
    44,
    'Podiatric Surgery'
),
(
    45,
    'Psychiatry'
),
(
    46,
    'Public health and Preventive Medicine'
),
(
    47,
    'Radiology'
),
(
    48,
    'Radiotherapy'
),
(
    49,
    'Respiratory medicine'
),
(
    50,
    'Rheumatology'
),
(
    51,
    'Stomatology'
),
(
    52,
    'Thoracic surgery'
),
(
    53,
    'Tropical medicine'
),
(
    54,
    'Urology'
),
(
    55,
    'Vascular surgery'
),
(
    56,
    'Venereology'
);

-- Insert test data into CITIES table
INSERT INTO `CITIES` (
    `ID`,
    `NAME`
) VALUES (
    1,
    'Casablanca'
),
(
    2,
    'Rabat'
),
(
    3,
    'Fes'
),
(
    4,
    'Marrakech'
),
(
    5,
    'Agadir'
),
(
    6,
    'Tangier'
),
(
    7,
    'Meknes'
),
(
    8,
    'Oujda'
),
(
    9,
    'Kenitra'
),
(
    10,
    'Tetouan'
),
(
    11,
    'Safi'
),
(
    12,
    'Mohammedia'
),
(
    13,
    'Khouribga'
),
(
    14,
    'El Jadida'
),
(
    15,
    'Beni Mellal'
),
(
    16,
    'Nador'
),
(
    17,
    'Ksar el-Kebir'
),
(
    18,
    'Settat'
),
(
    19,
    'Salé'
),
(
    20,
    'Al Hoceima'
),
(
    21,
    'Errachidia'
),
(
    22,
    'Ifrane'
),
(
    23,
    'Laayoune'
),
(
    24,
    'Taroudant'
),
(
    25,
    'Essaouira'
),
(
    26,
    'Guelmim'
),
(
    27,
    'Ouarzazate'
),
(
    28,
    'Taza'
),
(
    29,
    'Tan-Tan'
),
(
    30,
    'Dakhla'
),
(
    31,
    'Azrou'
),
(
    32,
    'Midelt'
),
(
    33,
    'Zagora'
);

-- Commit the transaction
COMMIT;