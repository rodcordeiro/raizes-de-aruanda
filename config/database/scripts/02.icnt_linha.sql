CREATE TABLE `icnt_linha` (
  `id` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `linha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 1, 'Orixa Exu');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 2, 'Iansa');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 3, 'Iroko');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 4, 'Logun-Edé');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 5, 'Nanã');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 6, 'Obá');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 7, 'Ogun');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 8, 'Omulu');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 9, 'Ossain');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 10, 'Oxalá');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 11, 'Oxóssi');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 12, 'Oxum');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 13, 'Oxumarê');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 14, 'Xangô');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 15, 'Yemanja');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (1, 16, 'Yewá');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 17, 'Bahianos');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 18, 'Boiadeiros');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 19, 'Caboclos');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 20, 'Ciganos');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 21, 'Exu');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 22, 'Exu-mirim');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 23, 'Ibeijada');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 24, 'Malandro');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 25, 'Marinheiro');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 26, 'Pomba-gira');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 27, 'Preto-velho');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (3, 28, 'Abertura');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (3, 29, 'Encerramento');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (3, 30, 'Defumação');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (3, 31, 'Bater cabeça');
insert into `icnt_linha` (`categoria`, `id`, `linha`) values (2, 32, 'Catimbozeiros');

ALTER TABLE `icnt_linha` MODIFY `id` int PRIMARY KEY AUTO_INCREMENT NOT NULL