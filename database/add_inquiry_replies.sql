-- Run this in phpMyAdmin on your production database
-- Adds reply history storage for the messenger-style inquiries view

CREATE TABLE IF NOT EXISTS inquiry_replies (
  reply_id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  inquiry_id     INT UNSIGNED NOT NULL,
  direction      ENUM('client','admin') NOT NULL DEFAULT 'admin',
  reply_subject  VARCHAR(255) NOT NULL DEFAULT '',
  reply_message  TEXT NOT NULL,
  replied_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (reply_id),
  KEY idx_ir_inquiry (inquiry_id),
  CONSTRAINT fk_ir_inquiry FOREIGN KEY (inquiry_id)
    REFERENCES project_inquiries (inquiry_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
