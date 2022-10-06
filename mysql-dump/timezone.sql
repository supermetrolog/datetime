CREATE TABLE `timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` char(36) CHARACTER SET ascii NOT NULL,
  `offset` varchar(100) NOT NULL,
  `dst` int(1) NOT NULL,
  `zone_start` int(11) NOT NULL,
  `zone_end` int(11),
  PRIMARY KEY (`id`),
  INDEX `idx-timezone-city_id` (city_id),
  FOREIGN KEY (city_id) REFERENCES city(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;