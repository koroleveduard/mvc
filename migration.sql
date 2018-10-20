CREATE TABLE `users`(
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  password VARCHAR(255),
  balance INT(10) DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO users (username, password, balance) VALUES ('test', MD5(123456),100000);