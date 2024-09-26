ALTER TABLE
    `tbl_organizations_course`
ADD
    `register_through` ENUM(
        'internal_form_submit',
        'external_link'
    ) NOT NULL
AFTER
    `last_submission_date`,
ADD
    `url` TEXT NULL DEFAULT NULL
AFTER
    `register_through`;

-- ALTER TABLE
--     `tbl_services`
-- ADD
--     `required_field` TEXT NULL DEFAULT NULL
-- AFTER
--     `image`;
CREATE TABLE `tbl_carrier_guidlines` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `guardian_name` VARCHAR(255) NOT NULL,
    `whatsapp_number` VARCHAR(10) NOT NULL,
    `mp_percentage` VARCHAR(5) NULL DEFAULT NULL,
    `hs_percentage` VARCHAR(5) NULL DEFAULT NULL,
    `stream` VARCHAR(50) NULL DEFAULT NULL,
    `interest_course_name` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_by` BIGINT UNSIGNED NULL DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP NULL,
    `updated_by` BIGINT UNSIGNED NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_carrier_guidlines`
ADD
    `mobile` VARCHAR(10) NOT NULL
AFTER
    `email`;

--- form 28-05-2024 --
ALTER TABLE
    tbl_services
ADD
    CONSTRAINT uniq_service_name_intended_for UNIQUE (service_name, intended_for);

CREATE TABLE `tbl_banner_types` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE
    tbl_banners RENAME tbl_dashboard_banners;

CREATE TABLE `tbl_banners` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `type_id` bigint(20) unsigned DEFAULT NULL,
    `image` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

ALTER TABLE
    tbl_banners
ADD
    CONSTRAINT fk_type_id_tbl_banners FOREIGN KEY (`type_id`) REFERENCES tbl_banner_types (id) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE
    `tbl_organizations_course`
ADD
    `extra_data` TEXT NULL DEFAULT NULL
AFTER
    `last_submission_date`;

CREATE TABLE `tbl_external_records` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `organization_course_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE
    tbl_external_records
ADD
    CONSTRAINT fk_organization_course_id_tbl_external_records FOREIGN KEY (`organization_course_id`) REFERENCES tbl_organizations_course (id) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE
    tbl_external_records
ADD
    CONSTRAINT fk_user_id_tbl_external_records FOREIGN KEY (`user_id`) REFERENCES tbl_users (id) ON DELETE CASCADE ON UPDATE NO ACTION;

--- from 19-06-2024 --
ALTER TABLE
    `tbl_organizations_course`
ADD
    `eligibility` VARCHAR(255) NULL DEFAULT NULL
AFTER
    `url`;

ALTER TABLE
    `tbl_organizations_course`
ADD
    `required_field` TEXT NULL DEFAULT NULL
AFTER
    `eligibility`;

ALTER TABLE
    `tbl_courses` CHANGE `course_details` `course_details` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

ALTER TABLE
    `tbl_services`
ADD
    `terms_and_conditions` TEXT NULL DEFAULT NULL
AFTER
    `required_field`;

ALTER TABLE
    `tbl_services` CHANGE `service_type` `service_type` ENUM(
        'course',
        'exam',
        'job',
        'scholarship',
        'training'
    ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

-- 09-07-2024 --
ALTER TABLE
    `tbl_users`
ADD
    `reset_token` VARCHAR(250) NULL DEFAULT NULL
AFTER
    `reset_otp`;