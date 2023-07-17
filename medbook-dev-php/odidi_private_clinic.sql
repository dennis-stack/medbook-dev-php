CREATE TABLE `tbl_gender` (
	`id` int NOT NULL,
	`gender_name` varchar NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tbl_patient` (
	`id` int NOT NULL,
	`first_name` varchar NOT NULL,
	`last_name` varchar NOT NULL,
	`gender_id` int NOT NULL,
	`date_of_birth` DATE NOT NULL,
	`phone_number` varchar NOT NULL,
	`email` varchar NOT NULL,
	`address` varchar NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tbl_services` (
	`id` int NOT NULL,
	`service_name` varchar NOT NULL,
	`description` varchar NOT NULL,
	`cost` FLOAT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tbl_patient_services` (
	`id` int NOT NULL,
	`patient_id` int NOT NULL,
	`service_id` int NOT NULL,
	`service_date` DATE NOT NULL,
	`comments` varchar NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `tbl_patient` ADD CONSTRAINT `tbl_patient_fk0` FOREIGN KEY (`gender_id`) REFERENCES `tbl_gender`(`id`);

ALTER TABLE `tbl_patient_services` ADD CONSTRAINT `tbl_patient_services_fk0` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`id`);

ALTER TABLE `tbl_patient_services` ADD CONSTRAINT `tbl_patient_services_fk1` FOREIGN KEY (`service_id`) REFERENCES `tbl_services`(`id`);
