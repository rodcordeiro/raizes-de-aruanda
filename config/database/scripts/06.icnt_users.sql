CREATE TABLE `icnt_users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `icnt_users` (`admin`, `id`, `password`, `username`) values (1, 1, '21232f297a57a5a743894a0e4a801fc3', 'admin');

ALTER TABLE `icnt_users` MODIFY `id` int PRIMARY KEY AUTO_INCREMENT NOT NULL