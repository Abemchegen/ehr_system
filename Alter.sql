-- ALTER TABLE `admin`
-- ADD COLUMN `image` varchar(255) DEFAULT NULL;

-- ALTER TABLE `doctor`
-- ADD COLUMN `image` varchar(255) DEFAULT NULL;

-- ALTER TABLE `patient`
-- ADD COLUMN `image` varchar(255) DEFAULT NULL;


CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    pid INT,
    report TEXT,
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY `pid` (`pid`)
);