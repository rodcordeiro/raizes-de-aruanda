CREATE TABLE `icnt_categoria_linha` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `icnt_categoria_linha` (`categoria`, `id`) values ('orixa', 1);
insert into `icnt_categoria_linha` (`categoria`, `id`) values ('guia', 2);
insert into `icnt_categoria_linha` (`categoria`, `id`) values ('outros', 3);


ALTER TABLE `icnt_categoria_linha` MODIFY `id` int PRIMARY KEY AUTO_INCREMENT NOT NULL