CREATE TABLE `users`(
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  password VARCHAR(255),
  balance INT(10) DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO users (username, password, balance) VALUES ('test', MD5(123456),100000);

CREATE TABLE `transactions_log`(
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_id int,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  old_value int,
  new_value int,
  FOREIGN KEY fk_cat(user_id) REFERENCES users(id)
) ENGINE=InnoDB;


drop trigger if exists log_transactions_trigger;
delimiter // 
CREATE TRIGGER log_transactions_trigger AFTER UPDATE ON users 
FOR EACH ROW     
BEGIN
   IF (NEW.balance != OLD.balance) 
   THEN
       INSERT INTO transactions_log (user_id, old_value, new_value) VALUES (NEW.id, OLD.balance, NEW.balance);
   END IF;
END;
//
DELIMITER ;