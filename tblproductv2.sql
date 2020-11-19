DROP database IF EXISTS my_shop_db;
CREATE database my_shop_db;
USE my_shop_db;


CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'FinePix Pro2 3D Camera', '3DcAM01', 'product-images/camera.jpg', 1500.00),
(2, 'EXP Portable Hard Drive', 'USB02', 'product-images/external-hard-drive.jpg', 800.00),
(3, 'Luxury Ultra thin Wrist Watch', 'wristWear03', 'product-images/watch.jpg', 300.00),
(4, 'XP 1155 Intel Core Laptop', 'LPN45', 'product-images/laptop.jpg', 800.00),
(5, '5 Ripe Bananas', '5BAN', 'product-images/bana.jpg', 4.99),
(6, 'GX Head Set Beetroots', 'beetgx', 'product-images/headset.jpg', 12.00),
(7, 'MaxoTypo Keyboard', 'Key01', 'product-images/keyboard.jpg', 99.00),
(8, 'Nokia 7210 Classico', 'NK7210', 'product-images/nokia.jpg', 500.00);


ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  
  
  
/*New SQL */  
  
CREATE TABLE user_tbl(
	user_id int AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) UNIQUE,
	password VARCHAR(128),
	salt VARCHAR(50),
	fname VARCHAR(50),
	lname VARCHAR(50),
	admin_acc Boolean
)engine=innodb;

SET @password = 'letmein', @salt = 'randomSaltWords';
SET @password2 = 'mypass', @salt2 = 'randomSaltWords2';
SET @password3 = 'passy', @salt3 = 'randomSaltWords3';

INSERT INTO user_tbl VALUES(101,'admin',SHA2(CONCAT(@password,@salt),512),@salt,'James','Smith', TRUE);
INSERT INTO user_tbl VALUES(102,'lillym',SHA2(CONCAT(@password2,@salt2),512),@salt2,'Lilly','May', FALSE);
INSERT INTO user_tbl VALUES(103,'tinyt',SHA2(CONCAT(@password3,@salt3),512),@salt3,'Tina','Turner', FALSE);

SELECT * FROM user_tbl;
SELECT * FROM user_tbl WHERE username = 'admin' AND password = SHA2(CONCAT('letmein',@salt),512);


CREATE TABLE order_tbl(
	order_id int AUTO_INCREMENT PRIMARY KEY,
	ord_date DATE,
	ord_time TIME,
	product_id_fk INT,
	user_id_fk INT,
	FOREIGN KEY (product_id_fk) REFERENCES tblproduct(id) ON DELETE CASCADE,
	FOREIGN KEY (user_id_fk) REFERENCES user_tbl(user_id) ON DELETE CASCADE
)engine=innodb;

INSERT INTO order_tbl VALUES(1,'2020/10/23','9:00',2,102);
INSERT INTO order_tbl VALUES(2,'2020/10/24','9:30',4,102);
INSERT INTO order_tbl VALUES(3,'2020/10/25','10:00',5,103);
INSERT INTO order_tbl VALUES(4,'2020/10/26','11:00',2,103);
INSERT INTO order_tbl VALUES(5,'2020/10/27','21:00',8,103);

SELECT * FROM order_tbl;

SELECT fname,lname,ord_date,ord_time,name,price FROM order_tbl 
INNER JOIN user_tbl ON user_id_fk = user_id 
INNER JOIN tblproduct ON product_id_fk = id;


SELECT fname, lname , COUNT(*) AS "Number Of Orders" FROM order_tbl 
INNER JOIN user_tbl ON user_id_fk = user_id 
INNER JOIN tblproduct ON product_id_fk = id 
GROUP BY fname, lname;

COMMIT;

