ALTER TABLE `admin`
ADD COLUMN `image` varchar(255) DEFAULT NULL;

ALTER TABLE `doctor`
ADD COLUMN `image` varchar(255) DEFAULT NULL;

ALTER TABLE `patient`
ADD COLUMN `image` varchar(255) DEFAULT NULL;
