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
COMMIT;