CREATE TABLE `tbl_gender` (
	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`gender_name` varchar(255) NOT NULL
);

CREATE TABLE `tbl_patient` (
	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`first_name` varchar(255) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	`gender_id` int NOT NULL,
	`date_of_birth` DATE NOT NULL,
	`phone_number` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`address` varchar(255) NOT NULL
);

CREATE TABLE `tbl_services` (
	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`service_name` varchar(255),
	`description` varchar(255),
	`cost` FLOAT NOT NULL
);

CREATE TABLE `tbl_appointments` (
	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`appointment_date` DATE NOT NULL,
	`comments` varchar(255) NOT NULL
);

CREATE TABLE `tbl_appointment_services` (
	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`service_id` int NOT NULL
);

ALTER TABLE `tbl_patient` ADD CONSTRAINT `tbl_patient_fk0` FOREIGN KEY (`gender_id`) REFERENCES `tbl_gender`(`id`);

ALTER TABLE `tbl_appointments` ADD CONSTRAINT `tbl_appointments_fk0` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`id`);

ALTER TABLE `tbl_appointment_services` ADD CONSTRAINT `tbl_appointment_services_fk0` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`id`);

ALTER TABLE `tbl_appointment_services` ADD CONSTRAINT `tbl_appointment_services_fk1` FOREIGN KEY (`service_id`) REFERENCES `tbl_services`(`id`);
