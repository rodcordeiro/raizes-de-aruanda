
DROP TABLE `icnt_users`;

CREATE TABLE `icnt_users` (
  `id` int(10) AUTO_INCREMENT NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `icnt_users` (`username`, `password`, `admin`) 

VALUES      ('admin', '21232f297a57a5a743894a0e4a801fc3', 1);
