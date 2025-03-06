CREATE TABLE IF NOT EXISTS `cmw_daily_rewards`
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    rarity       VARCHAR(50)  NOT NULL,
    probability  FLOAT        NOT NULL,
    command      TEXT         NOT NULL,
    image        VARCHAR(255) DEFAULT NULL
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;