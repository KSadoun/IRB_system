CREATE TABLE `researcher` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `email` varchar(254) UNIQUE,
  `password` varchar(128),
  `national_id` varchar(50),
  `serial_number` varchar(50) UNIQUE COMMENT 'يُصدره الأدمن عند التفعيل',
  `phone_no` varchar(15),
  `department` varchar(100),
  `faculty` varchar(100),
  `specialization` varchar(100),
  `id_front` varchar(255) COMMENT 'File/Image upload',
  `id_back` varchar(255) COMMENT 'File/Image upload',
  `is_active` boolean DEFAULT false,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `staff` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `role` varchar(50) COMMENT 'ADMIN, REVIEWER, MANAGER, SAMPLE_SIZE_OFFICER',
  `email` varchar(254) UNIQUE,
  `password` varchar(128),
  `ssn` varchar(50),
  `is_active` boolean DEFAULT true,
  `created_at` datetime
);

CREATE TABLE `reviewer_profile` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `staff_id` integer UNIQUE,
  `specialization` varchar(100),
  `department` varchar(100)
);

CREATE TABLE `research_details` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `researcher_id` integer COMMENT 'FK → researcher',
  `research_title` varchar(255),
  `principal_investigator_name` varchar(255),
  `description` longtext,
  `research_path` longtext COMMENT 'Nullable',
  `status` varchar(50) COMMENT 'DRAFT, PENDING_ACTIVATION, PENDING_INITIAL_PAYMENT, PENDING_SAMPLE_SIZE, PENDING_SAMPLE_PAYMENT, READY_FOR_REVIEW, UNDER_REVIEW, REVISION_REQUESTED, REVIEWED_APPROVED, FINAL_APPROVED, REJECTED',
  `assigned_reviewer_id` integer COMMENT 'Nullable FK → staff',
  `approved_manager_id` integer COMMENT 'Nullable FK → staff',
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `attachment` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer COMMENT 'FK → research_details',
  `file_type` varchar(50) COMMENT 'RESEARCH_PROTOCOL, PROTOCOL_REVIEW_APPLICATION, CONFLICT_OF_INTEREST, IRB_REVIEW_CHECKLIST, PI_CONSENT, PATIENT_CONSENT, CONSENT_PHOTOS_BIOPSIES',
  `file_path` varchar(255) COMMENT 'File upload path',
  `is_required` boolean DEFAULT true COMMENT 'false for optional files like CONSENT_PHOTOS_BIOPSIES',
  `uploaded_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `co_investigator` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `department` varchar(100),
  `specialization` varchar(100)
);

CREATE TABLE `research_co_link` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer,
  `co_id` integer
);

CREATE TABLE `sample_size_record` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer,
  `officer_id` integer COMMENT 'FK → staff (SAMPLE_SIZE_OFFICER)',
  `sample_size` integer,
  `description` longtext COMMENT 'وصف/ملاحظات حجم العينة',
  `calculated_price` decimal COMMENT 'decimal(10,2) - الرسوم بناءً على حجم العينة',
  `created_at` datetime
);

CREATE TABLE `payment_intent` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer,
  `researcher_id` integer,
  `payment_type` varchar(50) COMMENT 'INITIAL_FEE, SAMPLE_SIZE_FEE',
  `amount` decimal COMMENT 'decimal(10,2)',
  `status` varchar(50) COMMENT 'PENDING, PAID, FAILED, REFUNDED',
  `note` longtext COMMENT 'Nullable',
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `payment_record` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `payment_intent_id` integer COMMENT 'FK → payment_intent',
  `method` varchar(50) COMMENT 'FAWRY, WALLET, CARD, BANK_TRANSFER',
  `transaction_ref` varchar(255) COMMENT 'رقم مرجعي من بوابة الدفع',
  `serial_number` varchar(50) COMMENT 'الرقم التسلسلي على الإيصال',
  `amount_paid` decimal COMMENT 'decimal(10,2)',
  `paid_at` datetime
);

CREATE TABLE `initial_fee_config` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `fee_amount` decimal COMMENT 'decimal(10,2) - رسوم التقديم الأولية',
  `updated_at` datetime
);

CREATE TABLE `research_evaluation` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer,
  `reviewer_id` integer COMMENT 'FK → staff',
  `status` varchar(50) COMMENT 'PENDING, APPROVED, REJECTED, REVISION_REQUESTED',
  `is_confirmed` boolean DEFAULT false,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `research_log` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `evaluation_id` integer,
  `comment` longtext,
  `created_at` datetime
);

CREATE TABLE `audit_log` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer COMMENT 'Nullable',
  `user_type` varchar(20) COMMENT 'RESEARCHER, STAFF',
  `user_id` integer,
  `action` varchar(100) COMMENT 'e.g. STATUS_CHANGED, DOCUMENT_UPDATED, REVIEWER_ASSIGNED',
  `last_version` longtext COMMENT 'Nullable',
  `latest_version` longtext COMMENT 'Nullable',
  `description` longtext COMMENT 'Nullable',
  `created_at` datetime
);

CREATE TABLE `notification` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `recipient_type` varchar(20) COMMENT 'RESEARCHER, STAFF',
  `recipient_id` integer,
  `research_id` integer COMMENT 'Nullable',
  `title` varchar(255),
  `message_content` longtext,
  `channel` varchar(20) COMMENT 'SYSTEM, EMAIL, SMS',
  `is_read` boolean DEFAULT false,
  `sent_at` datetime
);

CREATE TABLE `certificate` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `research_id` integer,
  `researcher_id` integer,
  `reviewer_name` varchar(255),
  `manager_id` integer,
  `co_investigators` longtext COMMENT 'JSON list',
  `certificate_number` varchar(100) UNIQUE,
  `pdf_path` varchar(255),
  `issued_at` datetime
);

CREATE TABLE `notification_queue` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `recipient_type` varchar(20) COMMENT 'RESEARCHER, STAFF',
  `recipient_id` integer,
  `notification_id` integer COMMENT 'FK → notification, Nullable',
  `research_id` integer COMMENT 'Nullable',
  `title` varchar(255),
  `dicreption` varchar(500),
  `is_read` boolean DEFAULT false,
  `created_at` datetime,
  `read_at` datetime COMMENT 'Nullable'
);

ALTER TABLE `notification_queue` ADD FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`);

ALTER TABLE `notification_queue` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `staff` ADD FOREIGN KEY (`id`) REFERENCES `reviewer_profile` (`staff_id`);

ALTER TABLE `research_details` ADD FOREIGN KEY (`researcher_id`) REFERENCES `researcher` (`id`);

ALTER TABLE `research_details` ADD FOREIGN KEY (`assigned_reviewer_id`) REFERENCES `staff` (`id`);

ALTER TABLE `research_details` ADD FOREIGN KEY (`approved_manager_id`) REFERENCES `staff` (`id`);

ALTER TABLE `attachment` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `research_co_link` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `research_co_link` ADD FOREIGN KEY (`co_id`) REFERENCES `co_investigator` (`id`);

ALTER TABLE `sample_size_record` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `sample_size_record` ADD FOREIGN KEY (`officer_id`) REFERENCES `staff` (`id`);

ALTER TABLE `payment_intent` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `payment_intent` ADD FOREIGN KEY (`researcher_id`) REFERENCES `researcher` (`id`);

ALTER TABLE `payment_record` ADD FOREIGN KEY (`payment_intent_id`) REFERENCES `payment_intent` (`id`);

ALTER TABLE `research_evaluation` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `research_evaluation` ADD FOREIGN KEY (`reviewer_id`) REFERENCES `staff` (`id`);

ALTER TABLE `research_log` ADD FOREIGN KEY (`evaluation_id`) REFERENCES `research_evaluation` (`id`);

ALTER TABLE `audit_log` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `certificate` ADD FOREIGN KEY (`research_id`) REFERENCES `research_details` (`id`);

ALTER TABLE `certificate` ADD FOREIGN KEY (`researcher_id`) REFERENCES `researcher` (`id`);

ALTER TABLE `certificate` ADD FOREIGN KEY (`manager_id`) REFERENCES `staff` (`id`);
