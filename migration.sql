CREATE TABLE `users`(
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  password VARCHAR(255),
  balance BIGINT(20) unsigned DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO users (username, password, balance) VALUES ('test', MD5(123456),100000);