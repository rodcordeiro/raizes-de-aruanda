--
-- Estrutura da tabela `bot_tb_registered_channels`
--

CREATE TABLE `bot_tb_registered_channels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `channel_id` varchar(255) DEFAULT NULL
);

--
-- Extraindo dados da tabela `bot_tb_registered_channels`
--

INSERT INTO `bot_tb_registered_channels` (`id`, `name`, `channel_id`) VALUES
(1, 'raizes', '5511982645275@c.us'),
(2, 'pontos', '5511983808494@c.us');

-- --------------------------------------------------------

--
-- Estrutura da tabela `icnt_categoria_linha`
--

CREATE TABLE `icnt_categoria_linha` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `icnt_categoria_linha`
--

INSERT INTO `icnt_categoria_linha` (`id`, `categoria`) VALUES
(1, 'orixa'),
(2, 'guia'),
(3, 'outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `icnt_linha`
--

CREATE TABLE `icnt_linha` (
  `id` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `linha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `icnt_linha`
--

INSERT INTO `icnt_linha` (`id`, `categoria`, `linha`) VALUES
(1, 1, 'Orixa Exu'),
(2, 1, 'Iansa'),
(3, 1, 'Iroko'),
(4, 1, 'Logun-Edé'),
(5, 1, 'Nanã'),
(6, 1, 'Obá'),
(7, 1, 'Ogun'),
(8, 1, 'Omulu'),
(9, 1, 'Ossain'),
(10, 1, 'Oxalá'),
(11, 1, 'Oxóssi'),
(12, 1, 'Oxum'),
(13, 1, 'Oxumarê'),
(14, 1, 'Xangô'),
(15, 1, 'Yemanja'),
(16, 1, 'Yewá'),
(17, 2, 'Bahianos'),
(18, 2, 'Boiadeiros'),
(19, 2, 'Caboclos'),
(20, 2, 'Ciganos'),
(21, 2, 'Exu'),
(22, 2, 'Exu-mirim'),
(23, 2, 'Ibeijada'),
(24, 2, 'Malandro'),
(25, 2, 'Marinheiro'),
(26, 2, 'Pomba-gira'),
(27, 2, 'Preto-velho'),
(28, 3, 'Abertura'),
(29, 3, 'Encerramento'),
(30, 3, 'Defumação'),
(31, 3, 'Bater cabeça'),
(32, 2, 'Catimbozeiros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `icnt_pontos`
--

CREATE TABLE `icnt_pontos` (
  `id` int(11) NOT NULL,
  `ritmo` int(11) NOT NULL,
  `ponto` mediumtext NOT NULL,
  `linha` int(11) NOT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `audio_link` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `icnt_pontos`
--

INSERT INTO `icnt_pontos` (`id`, `ritmo`, `ponto`, `linha`, `tipo`, `audio_link`, `title`) VALUES
(1, 1, 'Colhe amendoim, milho e coco\r\nManda preparar o axoxô\r\nArco e flecha em punho, é só bravura\r\nPlanta, roça, agricultura\r\nIansã, Ogum, Agué e Oxalá\r\nBrinca, ginga, corre, reza e cura\r\nPressa o passo, criatura\r\nA mãe-mata céu e ouro chama\r\n\r\nJeje, Ketu e Angola vem te ver\r\nDesfilar teu abebê\r\nVer teu lume, sol e bronze de urucum\r\nDespe o véu, derrama realeza\r\nTece, cresce com riqueza\r\nÊ Logun, Logun!\r\n\r\nCamarão, cebola, azeite e ovo\r\nTempera o feijão do omolocum\r\nLava a alma, sal, mel e candura\r\nLaroiê, dendê, doçura\r\nAjunsum, Bessém, Sobô, Iemanjá\r\nNanã nina flor de formosura\r\nBenze e brinda com fartura\r\nA mãe-água céu e ouro canta\r\n\r\nTodo encanto canta, é só beleza\r\nOuro, amor, azul-turquesa\r\nÉ de sonhos, caçador e pescador\r\nValha-me, perfuma e me arrebata\r\nPelas cascatas e matas\r\nÊ Logun, Logun arô!\r\n\r\nLossi, Lossi!\r\nDança, filho de Tobossi!\r\nOlha quanta flor eu trouxe\r\nPra embalar teu Ijexá!\r\nFará, Logun!\r\nCaça, filho de Otulu!\r\nPai maior, que é Olorum\r\nTrouxe axé pro teu ofá!\r\n', 4, 'Chamada', NULL, NULL),
(2, 3, 'Malandro te digo meu irmão\r\nQue essa nega mexeu com meu coração \r\n\r\nEu hoje vou subir lá na favela\r\nVou dizer ao marido dela\r\nQue eu me apaixonei por ela\r\nMalandro eu posso até correr perigo\r\nMas se eu descer o morro\r\nA nega desce comigo\r\n', 24, 'Sustentação', NULL, NULL),
(3, 3, 'Malandro se na minha cara der\r\nPode fazer testamento e se despedir da mulher \r\n\r\nSe tiver filho deixa uma recordação \r\nCara que mamãe beijou vagabundo nenhum põe a mão', 24, 'Sustentação', NULL, NULL),
(4, 2, 'Pode me chamar de covarde\r\nMas não abandono essa mulher \r\nIsso não é mulher, é uma tentação \r\nIsso não é mulher, é uma tentação \r\nEla joga baralho, \r\nEla puxa a navalha,\r\nRisca a faca no chão \r\n\r\n', 24, 'Chamada', NULL, NULL),
(5, 1, 'Oxalá criou a terra\r\nOxalá criou o mar\r\nOxalá criou o mundo\r\nOnde reinam os Orixás }bis\r\n\r\nA pedra deu pra Xangô\r\nMeu pai, rei e justiceiro\r\nAs matas deu pra Oxóssi\r\nCaçador, velho guerreiro\r\nGrandes campos de batalha\r\nDeu pra Seu Ogum guerreiro\r\nCampinas Pai Oxalá\r\nDeu para Seu Boiadeiro\r\n\r\nMar com pescaria farta\r\nEle deu pra Iemanjá\r\nOs rios para Oxum\r\nOs ventos para Oyá\r\nLindos jardins com gramados\r\nDeu pras Crianças brincar\r\nOxalá criou o mundo onde reinam os Orixás\r\n\r\nOxalá criou a terra\r\nOxalá criou o mar\r\nOxalá criou o mundo\r\nOnde reinam os Orixás }bis\r\n\r\nO poço deu pra Nanã\r\nA mais velha Orixá\r\nE o Cruzeiro bendito\r\nDeu pras Almas trabalhar\r\nFinalmente deu as ruas\r\nCom estrelas e luar\r\nPra Exus e Bombogiras\r\nNossos caminhos guardar\r\n\r\nOxalá criou a terra\r\nOxalá criou o mar\r\nOxalá criou o mundo\r\nOnde reinam os Orixás }bis\r\n', 10, 'Chamada', NULL, NULL),
(6, 1, 'Oxalá nas oliveiras…\r\npediu ao Senhor do Mundo: }bis\r\nque plantasse\r\ne semeasse\r\na caridade que o Pai determinou }bis\r\nComo é lindo, Oxalá!\r\nComo é lindo, Oxalá!\r\nComo é lindo, Oxalá em seu Congá. }bis\r\n', 10, 'Chamada', NULL, NULL),
(7, 1, 'Zambi, olhai este mundo \r\nque o senhor criou \r\ncom beleza e encanto \r\nOxalá com o seu manto \r\na bondade semeou! }bis\r\n\r\nCarregando a cruz \r\ncarregando a dor \r\nOxalá é luz \r\nele é o amor!\r\n\r\nAbra as portas do coração\r\npra receber meu pai \r\nabra as portas do coração\r\npra encontrar a paz! }bis\r\n', 10, 'Sustentação', NULL, NULL),
(8, 1, 'Pombinho branco\r\nMensageiro de Oxalá }bis\r\nLeve esta mensagem\r\nDe todo coração até Jesus\r\nDiga que somos\r\nSoldados de Aruanda\r\nTrabalhamos na Umbanda\r\nCarregando a nossa Cruz }bis\r\n', 10, 'Chamada', NULL, NULL),
(9, 1, 'Oxalá meu pai\r\nTem pena de nós, tem dó\r\nSe a volta no mundo é grande\r\nSeus poderes são maiores\r\n', 10, 'Chamada', NULL, NULL),
(10, 1, 'No alto das oliveiras\r\nNo alto das oliveiras\r\neu vi uma pombinha a voar\r\n\r\nVoou, voou, tornou voar!\r\nÉ uma pombinha, \r\nDivina de Oxalá }bis\r\n', 10, 'Chamada', NULL, NULL),
(11, 5, 'Acredite em Exu, Exu é Orixá\r\nele é o primeiro que poe a mão no alguidar\r\nAcredite em Exu, Exu é Mojubá\r\nele é o primeiro, o primeiro Orixá\r\nEle é o mensageiro, do Orun e do Ayê\r\nO senhor dos meus caminhos o Guardião do meu Ilê\r\n', 1, 'Chamada', NULL, NULL),
(12, 1, 'O DONO DO CORPO QUER DANÇAR\r\nMAVAMBO NA BARRA DO DIA\r\nNO SEMBA, BOMBOGIRA SAMBA\r\nALUVAIÁ ALIVIA\r\nNO BAQUE DO BATICUM DO BAOBÁ \r\nBARÁ É BOCA QUE TUDO COME\r\n\r\nMENINO TRAVESSO É ELEGUÁ \r\nNA GIRA QUEM TRANCA A RUA É HOMEM\r\nELEGBARA VODUM \r\nEXU ODARA, AGÔ IÊ! – 2x\r\n\r\nINA, INA, MOJUBÁ \r\nARÁ DE ORUM NO AIÊ – 2x\r\n\r\nNO TEMPO SEM TEMPO QUE TEMPO TEM\r\nACERTA A PEDRA QUE NÃO LANÇOU\r\nA PEDRA DO TEMPO VAI E VEM\r\nNUM PÁSSARO QUE JÁ VOOU\r\n', 1, 'Chamada', NULL, NULL),
(13, 7, 'Elegbara vodum aza kere kere }bis\r\n', 1, 'Chamada', NULL, NULL),
(14, 2, 'Os campos de meu pai sao largos\r\nDeixa os cavalos correr\r\n\r\nQuem vem na frente é seu matinata\r\nOgum iara e ogum mege', 7, 'Chamada', NULL, NULL),
(15, 4, 'Nesta casa de guerreiro\r\nVim de longe pra rezar\r\nRogo a Deus pelos doentes\r\nNa fé de Obatalá\r\n\r\nOgum salve a casa santa\r\nOs presentes e os ausentes\r\nSalve nossas esperanças\r\nSalve velhos e crianças\r\n\r\nNego velho ensinou\r\nNa cartilha de aruanda\r\nE Ogum não esqueceu\r\nComo vencer a demanda\r\n\r\nA tristeza foi embora\r\nNa espada de um guerreiro\r\nE a luz do romper da aurora\r\nVai brilhar neste terreiro', 7, 'Sustentação', NULL, NULL),
(16, 2, 'Quando Oyá me chamou eu fui\r\natender tava sentada Iansã na palha\r\ndo dendê o guerreou guerreou relampejou\r\nou pelo cálice pela hóstia relampejo!!!\r\n\r\nTibere bere ooo Iansã tiberere\r\nooo tibere bere ooo Iansã tiberere\r\n\r\n\r\nOyá Oyá Oyá oi eu olha a Matamba do\r\nkacuruta dendê!!!\r\n', 2, 'Chamada', NULL, NULL),
(17, 2, 'Ô Iansã Menina seu jeito me fascina\r\nÉ de arrepiar\r\nÔ Iansã guerreira não há barreiras\r\nPra lhe segurar\r\nEla chegou ! Bem devagar\r\nE observou em cada canto desse mundo\r\nE a fez pensar\r\nA luz brilhou em seu Jacutá\r\nE anunciou \r\nPrepare que a Guerreira agora vai Reinar\r\nÔ Iansã Menina seu jeito me fascina\r\nÉ de arrepiar\r\nÔ Iansã guerreira não há barreiras\r\nPra lhe segurar\r\nO tempo mudou ! Fez o céu brilhar\r\nO Sol e a Lua irradiam energia\r\nPara renovar\r\nQue renasça o amor e fortaleça a fé\r\nPois Iansã esta soprando pelo mundo \r\nUm vendaval de Axé !\r\nÔ Iansã Menina seu jeito me fascina\r\nÉ de arrepiar\r\nÔ Iansã guerreira não há barreiras\r\nPra lhe segurar', 2, 'Chamada', NULL, NULL),
(18, 2, 'Olha que o céu clareou\r\nQuando o dia raiou\r\nFez o filho pensar\r\n\r\nA mãe do tempo mandou\r\nA nova era chegou\r\nAgora vamos plantar\r\n\r\nDo Humaitá Ogum bradou\r\nSenhor Oxossi atinou\r\nIansã vai chegar\r\n\r\nO ogã já firmou\r\nAtabaque afinou\r\nAgora vamos cantar\r\n\r\nAh! Eparrei!\r\nEla é Oyá! Ela é Oyá!\r\nAh! Eparrei!\r\nÉ Iansã! É Iansã!\r\nAh! Eparrei!\r\n\r\nQuando Iansã vai pra batalha\r\nTodos cavaleiros param\r\nSó pra ver ela passar.\r\n\r\nAh! Eparrei!\r\nEla é Oyá! Ela é Oyá!\r\nAh! Eparrei!\r\nÉ Iansã! É Iansã!\r\nAh! Eparrei!\r\n\r\nQuando Iansã vai pra batalha\r\nTodos cavaleiros param\r\nSó pra ver ela passar.', 2, 'Chamada', NULL, NULL),
(19, 5, 'ELE PULOU BRASA\r\nELE PULOU A PORTEIRA\r\nELE PULOU BRASA\r\nELE PULOU A PORTEIRA\r\nTACOU FOGO NO PAIOL\r\nNUMA BRINCADEIRA\r\nTACOU FOGO NO PAIOL\r\nNUMA BRINCADEIRA\r\nÉ MIRIM\r\nÉ MIRIM\r\nÉ EXÚ TRAVESSO\r\nÉ MIRIM\r\nÉ MIRIM\r\nÉ EXÚ TRAVESSO\r\nÉ MIRIM\r\nÉ MIRIM\r\nÉ EXÚ TRAVESSO\r\nÉ MIRIM\r\nÉ MIRIM\r\nÉ EXÚ TRAVESSO\r\n', 22, 'Chamada', NULL, NULL),
(20, 2, 'Em gira de exu\r\nNinguem fica parado  2x\r\n\r\nUns pedem dinheiro\r\nE outros namorado \r\nMas todos voltam\r\nPra dizer muito obrigado', 21, 'Chamada', NULL, NULL),
(21, 3, 'Se o sol me queima\r\nVem a lua e me cura\r\n\r\nCoroa linda\r\né de seu Tranca ruas 2x\r\n', 21, 'Chamada', NULL, NULL),
(22, 3, 'O sol brilhou na aruanda\r\nchoveu ventou, arco-iris no céu }bis\r\n\r\nMas vejam só , que coisa linda\r\nOxumarê num terreiro de umbanda\r\n\r\nAyeye, ayeye Oxumarê\r\nAyeye, ayeye Oxumarê }bis\r\n', 13, 'Sustentação', NULL, NULL),
(23, 2, 'Brilhou a estrela matutina, \r\nRolaram pedras de Xangô, \r\nQuem será essa menina, \r\nQue a lua iluminou, \r\nCanta no clarão da Lua, \r\nDança no calor do sol, \r\nTodo o ouro se ilumina, \r\nPra saudar Oxum menina\r\nPois Oxum é Mãe maior, \r\nSaravá Oxum menina,\r\nOxum é Mãe maior.\r\n', 12, 'Chamada', NULL, NULL),
(24, 3, 'O senhor das matas, nesta sua paz eu vou\r\nMe abrigar, neste\r\nChão de igualdade vou sentir liberdade com\r\nO sr. vou caçar\r\nVou parar neste verde de oxóssi esperanças\r\nPra mim, entre folhas caindo pé no chão\r\nVou seguindo eu vou viver, a toda\r\nCor do sol no horizonte nascer\r\nMe banhar nos seus rios liberto a correr\r\nFolhas verdes no frio irão me guardar\r\nSanta paz de oxóssi vai me agasalhar', 11, 'Sustentação', NULL, NULL),
(25, 4, 'Papai me manda um balão\r\nCom todas as crianças \r\nQue tem lá no céu\r\nTem doce Papai\r\nTem doce Papai\r\nTem doce lá no meu jardim', 23, 'Chamada', NULL, NULL),
(26, 1, 'Adorei as almas\r\nAs almas me atenderam\r\nAdorei as almas\r\nAs almas me atenderam\r\nEram as Santas almas\r\nLá do cruzeiro', 27, 'Chamada', NULL, NULL),
(27, 3, 'De vermelho e preto\r\nVestindo a noite um mistério traz\r\nDe colar de ouro brinco dourado a promessa faz\r\nVocê pode ir você pode vir\r\nPeça o que quiser\r\nMas cuidado amigo ela é bonita ela é mulher (bis)\r\nE no canto da rua rodando rodando, rodando está\r\nEla é moça bonita girando girando, girando lá\r\nOi girando lá ô lê lê\r\nOi girando lá ô lá lá\r\n', 26, 'Chamada', NULL, NULL),
(28, 2, 'É meia noite em ponto o galo cantou(2x)\r\nCantou pra anunciar que Tiriri chegou(2x)\r\nEle vem da Calunga de capa, cartola e tridente na mão.\r\nEsse Exú de fé é quem nos trás Axé e nos dá proteção.\r\nEle é Exú Odara e vem nos ajudar, \r\ncom seu punhal ele fura, ele corta demanda, ele salva, ele cura\r\nExú Amojubá\r\nLaruê\r\nLaruê Exú, Exú Amojubá \r\nEu perguntei a ele o que é Exú, ele vem me falar\r\nLaruê Exú\r\nLaruê Exú, Exú Amojubá\r\nEu perguntei a ele o que é Exú ele vem me falar\r\nExú é caminho, é energia, é vida, é determinação, é cumpridor da Lei, Exú é esperto, Exú é guardião, Exú é trabalho, é alegria veloz, Exú é viver, é a magia, é o encanto, é o fogo, é o sangue na veia vibrando, Exú é prazer.\r\nLaruê\r\nLaruê Exú, Exú Amojubá\r\nTras sua falange Exú Tiriri para trabalhar\r\nLaruê Exú\r\nLaruê Exú, Exú Amojubá\r\nTras sua falange Exú Tiriri para trabalhar.\r\nVem seu Tranca-Ruas, Maria Padilha e Exú Marabô\r\nSete Encruzilhadas, se Zé Pilintra aqui chegou\r\nMaria Mulambo, Maria Farrapo e Dona Figueira\r\nDona Sete Saias, Pombogira menina e Rosa Vermelha\r\nSete Catacumbas, Exú Caveira firmam ponto aqui\r\ne o Exú Capa Preta anunciou a festa do Exú Tiriri\r\nDeu meia noite em ponto!', 21, 'Chamada', '851ac3f980ba83311dffa77bea49bdb7.mp3', 'Ponto de Exú - Festa do Exú Tiriri-Xs9yFtgjpTk.mp3'),
(29, 6, 'Irôko, Irôko ê ee\r\nIrôko, Irôko á\r\nNo tronco da gameleira meu Irôko eu vou louvar\r\nNo tronco da gameleira meu Irôko eu vou louvar\r\nIrôko, Irôko ê ee\r\nIrôko, Irôko á\r\nIrôko aos seus pés o céu surgiu\r\nBerço de Obatalá, lá pro mundo ele surgiu\r\nIrôko, Irôko ê ee\r\nIrôko, Irôko á\r\nIrôko suas folhas como um véu\r\nCobriram um dia o céu que Obatalá criou\r\nIrôko Orixá da gameleira, vou rezar a vida inteira uma reza em seu louvor', 3, 'Chamada', NULL, NULL),
(30, 2, 'Ô Ogum !!!\r\nÔ Ogunhê, iê, iê!!!\r\nÔ Ogum !!!\r\nOgum Xoroquê !!!\r\n\r\nÔ Ogum !!!\r\nÔ Ogunhê, iê, iê!!!\r\nÔ Ogum !!!\r\nOgum Xoroquê !!!\r\n\r\nMeu senhor das estradas, \r\nOgunhê !!\r\nAbra meus caminhos,\r\nOgunhê !!\r\nMeu senhor da porteira,\r\nOgunhê !!!\r\nEle é meu pai, Ogum Xoroquê !!!\r\n\r\nÔ Ogum !!!\r\nÔ Ogunhê, iê, iê!!!\r\nÔ Ogum !!!\r\nOgum Xoroquê !!!\r\n\r\nÔ Ogum !!!\r\nÔ Ogunhê, iê, iê!!!\r\nÔ Ogum !!!\r\nOgum Xoroquê !!!\r\n\r\nMeu senhor das estradas, \r\nOgunhê !!\r\nAbra meus caminhos,\r\nOgunhê !!\r\nMeu senhor da porteira,\r\nOgunhê !!!\r\nEle é meu pai, Ogum Xoroquê !!!\r\n\r\nÔ Ogum !!!\r\nÔ Ogunhê, iê, iê!!!\r\nÔ Ogum !!!\r\nOgum Xoroquê !!!', 7, 'Chamada', NULL, NULL),
(31, 2, 'Peço de tudo Ogun Xoroquê\r\nPois um bom pai nunca abandona o filho \r\nOgum, Ogum, Ogunhê\r\nOgum, venha me proteger \r\nOgum, Ogum, Ogunhê\r\nÉ meu pai é Ogum Xoroquê\r\n\r\nDe espada na mão com capa de Exú\r\nCom sua fúria venha me valer \r\nMe ajoelho aos teus pés Ogum \r\nPorque é meu Pai é Ogum Xoroquê \r\nDono do dia e também da noite \r\nDono do ouro e do meu caminho \r\nPeço de tudo Ogum Xoroquê \r\nPois um bom pai nunca abandona um filho \r\n\r\n\r\nOgum, venha me proteger \r\nOgum, Ogum, Ogunhê\r\nÉ meu pai é Ogum Xoroquê\r\n\r\nDe espada na mão com capa de Exú\r\nCom sua fúria venha me valer \r\nMe ajoelho aos teus pés Ogum \r\nPorque é meu Pai é Ogum Xoroquê \r\nOgum, Ogum, Ogunhê\r\nOgum, venha me proteger \r\nOgum, Ogum, Ogunhê\r\nÉ meu Pai é Ogum Xoroquê ', 7, 'Sustentação', NULL, NULL),
(32, 3, 'Eu escrevi um pedido na areia\r\nPedindo a Zambi pra me socorrer\r\nEu escrevi um pedido na areia\r\nMas foi Mãe D\'água que veio me valer\r\n\r\nE foi nas ondas do Mar\r\nQue entreguei os meus problemas\r\nE aprendi a confiar\r\nQue todo mal não dura para sempre\r\nE que a paz é uma semente que precisa semear\r\n\r\nE no horizonte de um mar tão infinito\r\nIemanjá me acolheu e meu deu um mundo tão mais bonito\r\nEu abri meu coração, ela me estendeu a mão\r\nE entreguei meu caminhar a Iemanjá', 15, 'Chamada', NULL, NULL),
(33, 2, 'Hoje eu vou cantar\r\nVou louvar na areia\r\nEm lua cheia à mãe Iemanjá\r\n\r\nRosa do mar\r\nMinha estrela do céu azul\r\nNão é historia de pescador\r\nQue o meu amor eu vou lhe entregar\r\n\r\nDeixa\r\nDeixa as ondas do mar passar\r\nOuça o canto da bela Odoiá\r\nOxalá quem mandou\r\nUm grande amor\r\nDo fundo do mar', 15, 'Chamada', NULL, NULL),
(34, 1, 'Eu pedi um abraço ela me deu\r\neu pedi amor e ela não negou\r\nYemanjá olhai pelo filho seu\r\nYemanjá cuida do seu Yawo\r\nQuando a vida era só tristeza\r\npelos caminhos pedras e rancor\r\nEu fui na praia falar com Yemanjá\r\ne rainha do mar minha vida mudou\r\neu pedi um abraço ela me deu\r\neu pedi amor e ela não negou\r\nYemanjá olhai pelo filho seu\r\nYemanjá cuida do seu Yawo\r\nela me dá motivos pra sorrir\r\nMesmo o mundo me fazendo chorar\r\nSe com ela a vida anda sozinho\r\nSem ela eu sei que não posso andar\r\neu pedi um abraço ela me deu\r\neu pedi amor e ela não negou\r\nYemanjá olhai pelo filho seu\r\nYemanjá cuida do seu Yawo\r\nAs suas ondas eram o meu refúgio\r\nO meu castelo era o fundo do mar\r\nCada estrela era testemunha\r\nDo meu amor por mamãe Yemanjá.\r\neu pedi um abraço ela me deu\r\neu pedi amor e ela não negou\r\nYemanjá olhai pelo filho seu\r\nYemanjá cuida do seu Yawo\r\nMinha oração é de corpo e alma\r\nO seu canto me faz emocionar\r\nO meu presente é a flor mais bela\r\nMinha coroa é de Yemanjá\r\neu pedi um abraço ela me deu\r\neu pedi amor e ela não negou\r\nYemanjá olhai pelo filho seu\r\nYemanjá cuida do seu Yawo', 15, 'Sustentação', NULL, NULL),
(35, 4, 'Sonhei que estava na beira da praia\r\nOlhando as ondas do mar\r\nNo céu, tinha muitas estrelas\r\nA lua estava a brilhar, perdida no mundo\r\nEu estava, sem ter onde ficar\r\nDe repente uma voz me falou baixinho:\r\nTenha fé em Oxalá ( bis)\r\nEra ela, nas ondas do mar\r\nQue coisa mais linda\r\nMamãe Iemanjá \r\nEra ela nas ondas do mar\r\nEstendendo suas mãos\r\nPara me abençoar.\r\nEu sonhei', 15, 'Sustentação', NULL, NULL),
(36, 1, 'Tava sentado no alto da pedreira \r\nolhando as cachoeiras,\r\nas matas e o mar\r\nIemanjá ta arrumando seu vestido \r\nXangô lhe deu um grito\r\nOxum vai levantar\r\nAieie Oxum vai levantar\r\nAieie Oxum vai levantar\r\nNa mata virgem Oxossi assoviou\r\nAieie Oxum ja levantou\r\nAieie Oxum ja levantou', 12, 'Chamada', NULL, NULL),
(37, 6, 'Lá vem Logun\r\nLogun-Edé\r\nEle é filho de Oxum\r\nTambém filho de Odé\r\n\r\nOxum ... que é dona do ouro\r\nLhe deu a riqueza\r\nE também a nobreza\r\nDa Nação Ijexá\r\nOdé ... o dono da fartura\r\nLevantou com bravura\r\nA coroa do Ketu pra lhe abençoar\r\n\r\nO, o, o Logun é pescador\r\nQue reina lá nas matas\r\nNos rios e cascatas\r\nO, o, o, Logun é caçador\r\nDe Inlê tem o ofá \r\nE a espada de Oxum Ipondá', 4, 'Chamada', NULL, NULL),
(38, 1, 'No toque do aguerê\r\nNa nacão de Ijexá\r\nTrazendo o iru kerê\r\nLogun ê ê á\r\nEle é Logun Edé\r\nUm grande orixá\r\nFilho de Oxum ilé\r\nLogun ê ê á\r\n\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\n\r\nOxum achou por bem\r\nLogun disfarçar\r\nTrajando o velho monarca\r\nComo sereia do mar\r\nSeis meses como Oxóssi\r\nSeis meses como Oxum\r\nVive esse orixá\r\nSeu filho Logun\r\n\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\n\r\nNo toque do aguerê\r\nNa nacão de Ijexá\r\nTrazendo o iru kerê\r\nLogun ê ê á\r\nEle é Logun Edé\r\nUm grande orixá\r\nFilho de Oxum ilé\r\nLogun ê ê á\r\n\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\n\r\nOxum achou por bem\r\nLogun disfarçar\r\nTrajando o velho monarca\r\nComo sereia do mar\r\nSeis meses como Oxóssi\r\nSeis meses como Oxum\r\nVive esse orixá\r\nSeu filho Logun\r\n\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\nAê abaissá\r\nLogun ê ê ê ê\r\nAê abaissá\r\nLogun ê ê á\r\n', 4, 'Sustentação', NULL, NULL),
(39, 1, 'Àiyé oba ní sá\r\nLogun dé lé ré\r\nÀiyé oba ní sá\r\nLogun dé lé wá\r\n', 4, 'Chamada', NULL, NULL),
(40, 4, 'Gira no terreiro oh minha mãe Obá\r\nProtege os seus filhos, pra gira concentrar\r\nFirma o seu reino aqui no meu congá\r\nNos dá sabedoria, vem iluminar\r\nCom as forças da terra eu vou trabalhar, \r\nMe envolve em sua luz oh minha mãe Obá\r\n', 6, 'Chamada', NULL, NULL),
(41, 2, 'Que luz tão linda\r\nClareou a mata\r\nEstremeceu a serra\r\nCom sua espada }bis\r\n\r\nÉ mamãe Obá\r\nLinda Orixá\r\nQue vem no terreiro\r\nPra nos ajudar }bis', 6, 'Chamada', NULL, NULL),
(42, 1, 'Obá, rainha de Umbanda\r\nVencedora de demanda\r\nNos traga seu axé\r\nOh yabá, menina mulher\r\nSe você tiver fé, ela põe o filho em pé\r\n', 6, 'Sustentação', NULL, NULL),
(43, 1, 'Se ver um velho no caminho \r\nOi pede a benção\r\nSe ver um velho no caminho \r\nOi pede a benção\r\n\r\nÉ o velho Omolú \r\nAtotô Obaluaê\r\nAtotô Obaluaê\r\nAtotô baba\r\nAtotô Obaluaê é o velho Orixá\r\n', 8, 'Chamada', NULL, NULL),
(44, 3, 'Uma roseira nasceu na catacumba, todas as almas esperavam essa flor (2x)\r\nA roseira criou uma luz na escuridão \r\nMas os galhos da roseira se enrolaram em um caixão \r\nApareceu uma mulher no lugar dessa roseira, no rosto havia um manto que escondia uma caveira\r\nDe uma lado uma mulher muito linda e perfumada,\r\nDo outro um esqueleto, uma caveira toda queimada\r\n\r\nOh que linda rosa, que linda roseira\r\nEssa rosa tem espinhos ela é mulher de Exu Caveira\r\nOh que linda rosa, que linda roseira\r\nEssa rosa tem espinhos ela é Rosa Caveira', 26, 'Chamada', NULL, NULL),
(45, 2, 'É Nanã ê\r\nÉ Nanã ê\r\nÉ Nanã ê\r\n\r\nSenhora das águas turvas\r\nNana é Iabá\r\nEm Orum\r\nVive Nanã Buruquê\r\nSaluba linda senhora\r\nViva seu poder\r\n\r\nÉ Nanã ê\r\nÉ Nanã ê\r\nÉ Nanã ê', 5, 'Sustentação', NULL, NULL),
(46, 3, 'Oh Nanã Buruquê\r\nOs seus filhos lhe pedem\r\nseus filhos imploram\r\nVenha ver o terreiro\r\nE levar todo o mal\r\nna a sua marola\r\nSaravá Nanã aê\r\nSaravá Nanã êa\r\nSaráva Nanã na beira do rio\r\nÔ nas ondas do mar\r\n', 5, 'Chamada', NULL, NULL),
(47, 2, 'Eu vi lá no terreiro\r\nterreiro de bom Jesus 2x\r\n\r\nO povo da bahia\r\nlouvando a santa cruz 2x', 17, 'Chamada', NULL, NULL),
(48, 3, 'Quem não viu baiano bom\r\ncorra e venha ver agora 2x\r\n\r\nEle quebra mandinga\r\nele vence demanda\r\nele vem de Aruanda\r\nvamos todos saravá', 17, 'Chamada', NULL, NULL),
(49, 4, 'Titia me deu cocada, \r\ntio me deu guaraná\r\nTitia me deu cocada, \r\ntio me deu guaraná\r\nGostei foi do caruru \r\nque a mamãe mandou preparar\r\nGostei foi do caruru \r\nque a mamãe mandou preparar\r\nMamãe me deu caruru, \r\neu comi caruru de mamãe\r\nMamãe me deu caruru, \r\neu comi caruru de mamãe\r\nMamãe me deu caruru, \r\neu comi caruru de mamãe\r\nMamãe me deu caruru, \r\neu comi caruru de mamãe', 23, 'Sustentação', NULL, NULL),
(50, 3, 'Ele é pequinininho, \r\nmora no fundo mar\r\nSua madrinha é Sereia, \r\nseu padrinho é Beira-Mar\r\nEle é pequinininho, \r\nmora no fundo mar\r\nSua madrinha é Sereia, \r\nseu padrinho é Beira-Mar\r\nEle é pequinininho, \r\nmora no fundo mar\r\nSua madrinha é Sereia, \r\nseu padrinho é Beira-Mar\r\nNo fundo do mar tem areia, \r\nno fundo do mar tem areia\r\nSeu padrinho é Beira-Mar, \r\nsua madrinha é Sereia', 23, 'Sustentação', NULL, NULL),
(51, 4, 'Cosme e Damião,\r\nDamião cadê Doun ?\r\nDoun foi passear lá no cavalo de Ogum\r\nCosme e Damião,\r\nDamião cadê Doun ?\r\nDoun foi passear lá no cavalo de Ogum\r\nDois dois sereias do mar\r\nDois dois mamãe Iemanjá\r\nDois dois sereias do mar\r\nDois dois mamãe Iemanjá\r\nVamos brincar de roda\r\nCosme, Damião e Doum\r\nEles vem montados no cavalo de Ogum\r\nVem trazendo rosas pra Mamãe Oxum', 23, 'Tipo', NULL, NULL),
(52, 5, 'Papai me manda um balão\r\nCom todas as crianças \r\nQue tem lá no céu\r\nTem doce Papai\r\nTem doce Papai\r\nTem doce lá no meu jardim', 23, 'Chamada', NULL, NULL),
(53, 4, 'Bahia é que é terra de dois\r\nÉ terra de dois irmãos (bis)\r\nGovernador da Bahia\r\nÉ Cosme e São Damião (bis)', 23, 'Sustentação', NULL, NULL),
(54, 4, 'Lá no céu tem três estrelas\r\nTodas as três em carreirinha (bis)\r\nUma é Cosme e Damião\r\nA outra é Mariazinha (bis)', 23, 'Sustentação', NULL, NULL),
(55, 2, 'Fui no jardim colher as rosas\r\nA vovózinha deu-me a rosa mais formosa\r\nCosme e Damião, ôoooh Doun\r\nCrispim, Crispiniano\r\nSão os filhos de Ogum\r\nCosme e Damião, ôoooh Doun\r\nCrispim, Crispiniano\r\nSão os filhos de Ogum', 23, 'Sustentação', NULL, NULL),
(56, 5, 'Eu quero doce, eu quero bala, \r\nEu quero açúcar pra passar na sua cara', 23, 'Sustentação', NULL, NULL),
(57, 3, 'São Cosme mandou fazer\r\nDuas camisas azul }bis\r\n\r\nUma é pro guia dele\r\noh São Cosme\r\nA outra é de pai Ogun }bis', 23, 'Sustentação', NULL, NULL),
(58, 3, 'Tem bala de côco e peteca,\r\nDeixa Ibejada brincar\r\nTem bala de côco e peteca,\r\nDeixa Ibejada brincar\r\n\r\nHoje é dia de festa,\r\nIbeijada vem sarava', 23, 'Chamada', NULL, NULL),
(59, 5, '1, 2, 3\r\n4, 5, 6\r\nEu vou chamar o ere\r\nNa cabeça de vocês \r\n', 23, 'Chamada', NULL, NULL),
(60, 1, 'Vim em seu cruzeiro\r\nPara lhe ofertar\r\nNesse Portal de Luz\r\nVenha me curar\r\n\r\nOi atotô, oi atotô\r\nOi atotô meu Pai Obaluaiê\r\n', 8, 'Chamada', NULL, NULL),
(61, 1, 'O velho Omolú\r\nVem caminhando no terreiro\r\nO velho Omolú\r\nVem saravar neste congá\r\nO velho Omolú\r\nSustenta o campo santo\r\nO velho Omolú \r\nVem saravar neste conga\r\nÔ atotô atoto pai Omolú, ô atotô, atotô é Orixá\r\n', 8, 'Chamada', NULL, NULL),
(62, 2, 'ABALUAÊ QUANDO ERA MENINO\r\nESTAVA ESCRITO EM SEU DESTINO \r\nO QUE IRIA ACONTECER\r\nCOM SEU CORPO COBERTO DE CHAGAS\r\nSUA MÃE SEMPRE CHORAVA\r\nNÃO SABIA O QUE FAZER [2X]\r\n \r\nNUM BALAIO LHE DEIXOU A BEIRA MAR\r\nPEDIU A ZAMBI SEMPRE LHE PROTEGER\r\nUMA ORAÇÃO ELA DEIXOU A ELE\r\nNÃO QUERIA VER ELE SOFRER [2X]\r\n\r\nCHORAVA AQUELE MENINO\r\nCHORAVA AQUELE MENINO\r\nIEMANJÁ OUVINDO AQUELE CHORO\r\nA BEIRA MAR ELA FOI SURGINDO [2X]\r\n\r\nPEGOU ABALUAÊ EM SEUS BRAÇOS\r\nEM ALTO MAR COM ELA FOI MORAR\r\nIEMANJÁ TRATOU AS SUAS CHAGAS\r\nPARA O SOFRIMENTO DELE ACABAR [2X]\r\n \r\nHOJE ELE É UM REI\r\nCURA A PESTE A DOENÇA E O SOFRIMENTO\r\nATO TÔ MEU PAI VEM ME VALER\r\nME BANHA COM A PIPOCA OLHA VENHA ME BENZER [2X]\r\n\r\nSUA MÃE É NANÃ BURUQUÊ\r\nIEMANJÁ FOI QUEM LHE CRIOU\r\nELE É ORIXÁ DA CURA\r\nATO TÔ ABALUAÊ, MEU PAI ATO TÔ [2X]\r\n', 8, 'Sustentação', NULL, NULL),
(63, 2, 'SILÊNCIO, \r\nATOTÔ,ATOTÔ, ATOTÔ ,ATOTÔ OOO [2X]\r\n\r\nSUAS FLORES SAGRADAS SÃO DEBORÔ \r\nQUE LIMPAM MEU CORPO E TIRAM A MINHA DOR\r\nSUA PALHA DIVINA É SEU AJÊ, \r\nORIXÁ PODEROSO OBALUAÊ\r\n\r\nSILÊNCIO \r\nATOTÔ, ATOTÔ, ATOTÔ,ATOTÔ OOO [2X]\r\n\r\nSENHOR DA TERRA,\r\nSENHOR DA VIDA, \r\nSENHOR DA CHAGA, \r\nSENHOR DA PARTIDA\r\nSEU NOME SANTO \r\nME FAZ REFLETIR \r\nDA VIDA O QUE LEVO E O QUE DEIXO AQUI\r\n\r\nSILÊNCIO, \r\nATOTÔ, ATOTÔ, ATOTÔ OOO [2X]\r\n', 8, 'Sustentação', NULL, NULL),
(64, 1, 'É OBALUAÊ, É OBALUAÊ \r\nÉ ATOTÔ \r\nÉ OBALUAÊ, É OBALUAÊ \r\n\r\nSE VOCÊ ESTÁ SOFRENDO, \r\nNO LEITO OU COM FRIO E COM DOR. \r\nCOM PIPOCA E COM DENDÊ \r\nMUITA GENTE ELE CUROU. \r\n\r\nSE SEU CORPO ESTÁ FERIDO, \r\nE NÃO PODE MAIS SUPORTAR. \r\nPEÇA PROTEÇÃO Á ELE, \r\nQUE ELE VAI LHE AJUDAR! \r\nOBALUAÊ!!! \r\n\r\nÉ OBALUAÊ , É OBALUAÊ \r\nÉ ATOTÔ \r\nÉ OBALUAÊ , É OBALUAÊ \r\n\r\nTENHO SEGREDO DA VIDA, \r\nDO COMEÇO E DO FIM. \r\nO MEU SENHOR DAS PALHAS, \r\nTENHA MUITA DÓ DE MIM. \r\n\r\nNA PROCISSÃO DAS ALMAS, \r\nQUE PARTEM PRO INFINITO. \r\nELE VAI MOSTRANDO Á ELAS, \r\nOUTRO MUNDO MAIS BONITO! \r\nOBALUAÊ!!! \r\n', 8, 'Tipo', NULL, NULL),
(65, 1, 'Se obaluae é o rei das almas\r\nrei do cemiterio \r\nrei das catacumbas }bis\r\n\r\nPelo amor de deus\r\nCorre essa gira\r\nVem com sua força \r\nRetirar toda quizila }bis\r\n', 8, 'Sustentação', NULL, NULL),
(66, 1, 'Quem é aquele velhinho\r\nem seu cajado apoiado\r\ncoberto com palha africana\r\nde cães vem acompanhado }bis\r\n\r\nÉ o senhor Omulu\r\nÉ o senhor Omulu\r\nCorre gira sem parar\r\ncom a ordem de Oxalá\r\nEle é orixá da peste\r\nna calunga ele é o senhor\r\nCorre os cantos do mundo\r\npara aliviar a dor }bis\r\n', 8, 'Sustentação', NULL, NULL),
(67, 1, 'Na pedra fria\r\nno pé do morro\r\ndizem que mora um velho lá }bis\r\n\r\nEle é curador\r\nele é rezador\r\nele é Xapanã\r\nele vai lhe curar }bis\r\n', 8, 'Sustentação', NULL, NULL),
(68, 6, 'Meu pai Oxalá é rei\r\nvenha me valer }bis\r\nÉ o velho Omulú\r\nAtotô Obaluaê }bis\r\n\r\nAtoto Obaluaê\r\nAtoto babá\r\nAtoto Obaluaê\r\nÉ o velho orixá }bis', 8, 'Sustentação', NULL, NULL),
(69, 2, 'Ele é um grande Orixá\r\nEle é o chefe da calunga\r\nEle é seu atotô, Obaluaiê.\r\nEle é seu atotô, Obaluaiê.\r\nEle é seu atotô, Obaluaiê\r\n', 8, 'Sustentação', NULL, NULL),
(70, 1, 'Céu vermelho em fim de tarde\r\nNinguém sabe quando e onde\r\nManto de constelação\r\nEstendido no horizonte\r\nQuando foge é só neblina\r\nQue disfarça e faz sonhar\r\nCanto em cores, moça fina\r\nVirgem que não quer casar\r\nBrilha Ewá\r\nArco íris que cruza o firmamento\r\nBranca Ewá\r\nDom (dan) que muda e desmuda qual camaleão\r\nAh Ewá\r\nDança cobra que cisca pra fazer brotar a vida\r\nTão somente o encanto e a luz do meu coração\r\nOnde ela pisa, nasce uma flor\r\nTem cheiro de terra antes da chuva\r\nEmbeleza o céu e a terra\r\nBrinca de moldar a lua', 16, 'Sustentação', NULL, NULL),
(71, 1, 'Ewá, Ewá\r\nÉ uma moça cismada\r\nQue se esconde na mata\r\nE não tem medo de nada\r\nEwá, Ewá\r\nNão tem medo de nada\r\nO chão, os bichos\r\nAs folhas, o céu\r\nEwá, Ewá\r\nVirgem da mata virgem\r\nVirgem da mata virgem\r\nDos lábios de mel\r\nEwá, Ewá\r\nÉ uma moça cismada\r\nQue se esconde na mata\r\nE não tem medo de nada\r\nEwá, Ewá\r\nNão tem medo de nada\r\nO chão, os bichos\r\nAs folhas, o céu\r\nEwá, Ewá\r\nVirgem da mata virgem\r\nVirgem da mata virgem\r\nDos lábios de mel\r\n', 16, 'Sustentação', NULL, NULL),
(72, 5, 'É um balé de folha \r\nÉ um balé de sonho \r\nÉ um balé de folha \r\nÉ um balé, balé, balé\r\nKatendê, Katendê, Katendê Ossain\r\n', 9, 'Sustentação', NULL, NULL),
(73, 3, 'PAI OSSAIN DAS MATAS\r\nEU VENHO PARA LOUVAR \r\nSARAVÁ REI DAS ERVAS\r\nFILHO DE PAI OXALÁ \r\n\r\nIE IE IE OSSAIN\r\nSEU CANTO EU QUERO ESCUTAR\r\nIE IE IE OSSAIN\r\nSUAS ERVAS PODEM CURAR\r\n', 9, 'Chamada', NULL, NULL),
(74, 1, 'Fala balé é koxumâô\r\nfala balé é koxumâ }bis\r\nKukudunkun o ori ewe\r\nFala balé é koxumâô\r\n', 9, 'Sustentação', NULL, NULL),
(75, 3, 'A lua lá no céu brilhou;\r\nVai bater cabeça pro meu pai Xangô;\r\nOh-oh-oh\r\nA lua era mais forte, clareou;\r\nA lua nasce por detrás da cachoeira;\r\nIluminando pai Xangô lá nas pedreiras;\r\nBate cabeça, filhos de fé;\r\nE peça a Xangô o que quiser.\r\n', 31, 'Chamada', NULL, NULL),
(76, 3, 'Graças a Deus meu Deus  \r\nGraças a Deus meu Deus  \r\nPelo dia de hoje louvado seja Deus \r\nPelo dia de hoje louvado seja Deus \r\n\r\nA...... muito obrigado\r\nA...... muito obrigado\r\nPelo dia de hoje louvado seja Deus\r\nPelo dia de hoje louvado seja Deus', 29, 'Sustentação', NULL, NULL),
(77, 2, 'Vi um menino,sentado na encruza\r\nperguntei o que é que foi, perguntei o que é que há }bis\r\n\r\nEu vim aqui pra quebrar feitiço\r\nMas pra calunga eu já vou voltar\r\nEu sou Exu-Mirim\r\ne o cemitério é o meu lugar }bis', 22, 'Chamada', NULL, NULL),
(78, 2, 'Bate tambor na umbanda\r\nPra ver meu velho chegar /2x\r\n\r\nEle é pai Cipriano\r\nEle é pai Cipriano\r\nMensageiro de Oxalá /2x\r\n', 27, 'Chamada', NULL, 'Ponto de Preto-velho - '),
(79, 2, 'Minhas almas, santas almas\r\nOlha minha oração /2x\r\n\r\nOlha minha oração santas almas, olha minha oração /2x\r\n\r\nE eu louvei, louvei\r\nEu louvei senhor\r\nEu louvei as terras de são salvador /2x', 27, 'Chamada', NULL, 'Ponto de Preto-velho - '),
(80, 3, 'Ai vovó eu tenho medo \r\nAi vovó eu tenho medo\r\nAi vovó eu tenho medo\r\nda fumaça do cachimbo descobrir o meu segredo\r\n\r\nAi vovô eu tenho medo\r\nAi vovô eu tenho medo\r\nAi vovô eu tenho medo da fumaça do cachimbo descobrir o meu segredo', 27, 'Sustentação', NULL, NULL),
(81, 3, 'Lá vem Preta Velha\r\nDescendo a serra com sua sacola\r\nEla traz um rosário , ela traz uma guia , ela vem de angola\r\nEu quero ver vovó, eu quero ver\r\nEu quero ver se filho de pemba tem querer', 27, 'Chamada', NULL, NULL),
(82, 4, 'Preto Velho nunca foi à cidade Oi sinhá\r\nFala na língua de Zambi \r\nOi sinhá\r\nEeee oi sinhá Fala na língua de Zambi\r\nEeee oi sinhá\r\nFala na língua de Zambi', 27, 'Chamada', NULL, NULL),
(83, 3, 'Negra Cambinda. \r\nNegra da costa do mar, negra da costa linda \r\nFilha de Yalorixá. \r\n\r\nNa macumba hê, na macumba hâ. \r\nNa macumba hê, na macumba hâ.\r\nNego fuma, nego dança \r\nna batida do tambor. \r\nNego bebe seu marafo. \r\nSaravá seu protetor! }bis\r\n', 27, 'Chamada', NULL, NULL),
(84, 3, 'Preto velho senta no toco\r\nFaz o sinal da cruz \r\nPede proteção a Zambi\r\nPara os filhos de Jesus Cada conta do seu rosário\r\nÉ um filho que ai está\r\nSe não fosse o Preto Velho Eu não sabia caminhar', 27, 'Chamada', NULL, NULL),
(85, 3, 'Quando a velha Cambinda ;\r\nChega na gira e vem dar axé;  \r\nO chão todo estremece e filho de Umbanda não fica de pé ;\r\n\r\nEla é preta velha ;\r\nUma nega sabida;\r\nDe rosário na mão ; \r\n\r\nEla faz seus trabalhos ; \r\nÓ dona Cambinda; \r\nNos dê proteção.\r\n', 27, 'Chamada', NULL, NULL),
(86, 3, 'FIO\r\nSE SUNCÊ PRECISA\r\nÉ SÓ PENSAR NA VOVÓ\r\nQUE ELA VEM LHE AJUDAR\r\n\r\nFIO\r\nSE SUNCÊ PRECISA\r\nÉ SÓ PENSAR NA VOVÓ\r\nQUE ELA VEM LHE AJUDAR\r\n\r\nPENSA NUMA ESTRADA LONGA, ZI FIO\r\nLÁ NO SEU JACUTÁ\r\nE NUMA CASINHA BRANCA ZI FIO\r\nQUE A VOVÓ TÁ LÁ\r\n\r\nSENTADA NUM BANQUINHO TOSCO, ZI FIO\r\nCOM SEU ROSÁRIO NA MÃO\r\nPENSA NA VOVÓ MARIA REDONDA\r\nFAZENDO ORAÇÃO }bis\r\n', 27, 'Chamada', NULL, NULL),
(87, 3, 'VOVÓ NÃO QUER\r\nCASCA DE COCO NO TERREIRO\r\nVOVÓ NÃO QUER\r\nCASCA DE COCO NO TERREIRO\r\n\r\nQUE É PARA NÃO LEMBRAR\r\nO TEMPO DO CATIVEIRO }bis\r\n', 27, 'Sustentação', NULL, NULL),
(88, 1, 'Tava dormindo quando a princesa chamou\r\nAcorda preto-velho, cativeiro acabou }bis\r\n\r\nImperador, imperador\r\n13 de maio demorou mas já chegou }bis\r\n', 27, 'Sustentação', NULL, NULL),
(89, 1, 'Pai Joaquim, cadê pai mané?\r\nMané foi na mata pegar guiné }bis\r\n\r\nDiga a ele quando vier\r\nque suba a escada e bata o pé }bis', 27, 'Sustentação', NULL, NULL),
(90, 1, 'A sineta do céu bateu Oxalá já diz é hora\r\nA sineta do céu bateu Oxalá já diz é hora\r\nEu vou, eu vou, eu vou\r\nFiquem com Deus e Com Nossa Senhora\r\nEu vou, eu vou, eu vou\r\nFiquem com Deus e Com Nossa Senhora', 27, 'Subida', NULL, NULL),
(91, 4, 'To incensando\r\nTo defumando\r\nA casa do bom Jesus da Lapa /2x\r\n\r\nNossa Senhora incensou a Jesus Cristo\r\ne Jesus Cristo incensoa os filhos teus\r\nEu incenso, eu incenso esta casa\r\nna fé de Oxossi, de Ogum e Oxalá /2x', 30, 'Sustentação', NULL, NULL),
(92, 3, 'Na mata virgem\r\nTamborim tocou\r\ne Oxalá mandou\r\nSaravá Babalaô /2x\r\n\r\nBabalaô, meu pai Babalaô\r\nSua bandeira cobre os filhos de Oxalá /2x', 31, 'Chamada', NULL, NULL),
(93, 3, 'Folha verde na floresta\r\nArco e flecha, caça e flor\r\n\r\nÊ Oxóssi vem chegando, Okê Arô\r\nPassarinho no mato cantou', 11, 'Chamada', NULL, NULL),
(94, 4, 'Caboclo roxo da pele morena\r\né seu Oxossi\r\ncaçador lá da Jurema }bis\r\n\r\nEle jurou, ele jurará\r\npelos conceitos que a Jurema vai lhe dar }bis', 11, 'Chamada', NULL, NULL),
(95, 3, 'NA MATA VIRGEM VI UM GRANDE CAÇADOR\r\nELE DAVA UM BRADO, KIÔ, KIÔ\r\n\r\nELE É OXÓSSI, OKÊ ARÔ\r\nCOM UMA FLECHA DOURADA, SUA CAÇA ACERTOU\r\n', 11, 'Chamada', NULL, NULL),
(96, 4, 'Não bote fogo nas matas, \r\nnas matas tem morador }bis\r\n\r\nO nome dele é Oxossi\r\nEle é o rei dos caçador }bis', 11, 'Sustentação', NULL, NULL),
(97, 3, 'Eu vi chover, eu vi relampejar\r\nmas mesmo assim o céu estava azul\r\n\r\nSamborê pemba, folhas de jurema\r\nOxossi reina de norte à sul }bis', 11, 'Chamada', NULL, NULL),
(98, 4, 'Sou filho do guerreiro de uma flecha só \r\nSou filho de Oxossi caçador\r\nE todo bom guerreiro não anda só \r\nTem sempre um irmão merecedor\r\n\r\nO Rei das Matas \r\nO meu protetor \r\nO Rei das Matas \r\nO meu protetor\r\n\r\nSarava meu pai Oxossi \r\nSua bênção meu senhor\r\nOke Arô\r\n\r\nSou filho do guerreiro de uma flecha só \r\nSou filho de Oxossi caçador\r\nEle é mensageiro do Pai maior\r\nE cumpre sua missão com muito amor\r\n\r\nO Rei das Matas \r\nO meu protetor \r\nO Rei das Matas \r\nO meu protetor\r\n\r\nSarava meu pai Oxossi \r\nSua bênção meu senhor\r\nOke Arô', 11, 'Sustentação', NULL, NULL),
(99, 1, 'Mãe d’água, rainha das ondas Sereia do mar\r\nMãe d’água, seu canto é bonito\r\nQuando tem luar\r\n\r\nAuê, Auê Yemanjá \r\nAuê, Auê Yemanjá \r\n\r\nComo é lindo o canto de Yemanjá\r\nFaz até o pescador chorar\r\nQuem escuta a mãe d’água cantar \r\nVai com ela pro fundo do mar', 15, 'Sustentação', NULL, NULL),
(100, 5, 'Saia do mar, linda sereia\r\nSaia do mar, venha brincar na areia\r\nSaia do mar, sereia bela\r\nSaia do mar, venha brincar com ela', 15, 'Chamada', NULL, NULL),
(101, 3, 'Eu fui na beira da praia \r\nPra ver o balanço do mar \r\nEu vi um retrato na areia\r\nMe lembrei da sereia\r\nComecei a chamar\r\n\r\n\r\nVem Janaína vem ver \r\nVem Janaína vem cá \r\nReceber suas flores \r\nQue venho lhe ofertar', 15, 'Chamada', NULL, NULL),
(102, 3, 'Retira a jangada do mar\r\nMãe d água mandou avisar\r\nQue hoje não pode pescar\r\nPois hoje tem festa no mar\r\n\r\nE, e, e, e, e, e Yemanjá\r\nEla é ela é a rainha do mar\r\nTraz pente, traz espelho o, o, o, o\r\nPra ela se enfeitar o, o, o, o\r\nTraz flores, traz perfumes\r\nEnfeita todo o mar', 15, 'Sustentação', NULL, NULL),
(103, 2, 'Yemanjá mamãe sereia\r\nYemanjá mamãe sereia \r\nSua força vem do mar\r\nVem de lá das profundezas \r\n\r\nSeus filhos choram \r\nmas não é por fraqueza \r\nEles tem em sua coroa\r\nA mais bela riqueza\r\nA força de Yemanjá\r\nQue é sua fortaleza\r\n\r\nYemanjá mamãe sereia\r\nYemanjá mamãe sereia\r\nSua força vem do mar\r\nVem de lá das profundezas \r\n\r\nA maré sobe\r\nem noites de lua cheia \r\nÉ um sinal que vai chegar\r\nMinha mãe, minha princesa\r\nPra terra purificar\r\nCom toda sua beleza', 15, 'Sustentação', NULL, NULL),
(104, 3, 'ESTOU OUVINDO O LINDO TOQUE DO TAMBOR\r\nÉ LOUVAÇÃO A YEMANJÁ COM MUITO AMOR\r\n\r\nO YAÔ, YEMANJÁ\r\nQUE TODO AMOR VEM DE OXALÁ\r\nO YAÔ YEMANJÁ\r\nQUE TODA DOR LEVA PRO MAR.', 15, 'Chamada', NULL, NULL),
(105, 4, 'Eu sou filho de yabá\r\nYabá é minha mãe /2x\r\n\r\nA rainha do tesouso, Odociaba\r\nÉ do fundo do Mar\r\n\r\nOdociaba, do fundo do mar\r\nOdociaba, do fundo do mar /2x', 15, 'Sustentação', NULL, NULL),
(106, 2, 'Você me traiu, você me iludiu\r\nArrumei um novo homem\r\narrumei um novo amor\r\n\r\nAmor, amor, amor\r\nAmor é uma palavra pra quem sabe dar valor /2x', 26, 'Sustentação', NULL, NULL),
(107, 2, 'Bara bara Mona Laroye /2x\r\n\r\nLaroye Legbara', 26, 'Sustentação', NULL, NULL),
(108, 5, 'Acredite em Exu, Exu é Orixá\r\nele é o primeiro \r\nque poe a mão no alguidar\r\n\r\nAcredite em Exu, Exu é Mojubá\r\nele é o primeiro, o primeiro Orixá\r\nEle é o mensageiro, do Orun e do Ayê\r\nO senhor dos meus caminhos o Guardião do meu Ilê', 1, 'Sustentação', NULL, NULL),
(109, 1, 'O DONO DO CORPO QUER DANÇAR\r\nMAVAMBO NA BARRA DO DIA\r\nNO SEMBA, BOMBOGIRA SAMBA\r\nALUVAIÁ ALIVIA\r\nNO BAQUE DO BATICUM DO BAOBÁ \r\nBARÁ É BOCA QUE TUDO COME\r\n\r\nMENINO TRAVESSO É ELEGUÁ \r\nNA GIRA QUEM TRANCA A RUA É HOMEM\r\nELEGBARA VODUM \r\nEXU ODARA, AGÔ IÊ! – 2x\r\n\r\nINA, INA, MOJUBÁ \r\nARÁ DE ORUM NO AIÊ – 2x\r\n\r\nNO TEMPO SEM TEMPO QUE TEMPO TEM\r\nACERTA A PEDRA QUE NÃO LANÇOU\r\nA PEDRA DO TEMPO VAI E VEM\r\nNUM PÁSSARO QUE JÁ VOOU', 1, 'Chamada', NULL, NULL),
(110, 1, 'É MEIA NOITE, ESCURIDÃO PRA ELE É LUZ\r\nNÃO TEM PERDIDO QUE NÃO POSSA ENCONTRAR\r\nFIRMA A CABEÇA DEIXA QUE ELE CONDUZ\r\nE O CAMINHO VAI SEMPRE TE  MOSTRAR\r\nGRANDE ORIXÁ, EXU É MOJUBÁ\r\nÉ MOJUBÁ, EXU É ORIXÁ   2X\r\nA NOITE CHEGA LÁ NA CALUNGA\r\nE AS FALANGES DE EXU VÃO SE ENCONTRAR\r\nPRESTAR RESPEITO AO GRANDE PROTETOR\r\nNESTA CORRENTE TODOS VÃO SAUDAR\r\nGRANDE ORIXÁ, EXU É MOJUBÁ\r\nÉ MOJUBÁ, EXU É  ORIXÁ  2X', 1, 'Chamada', NULL, NULL),
(111, 4, 'QUEM ROLA PEDRA NA PEDREIRA É XANGÔ\r\nQUEM ROLA PEDRA NA PEDREIRA É XANGÔ\r\n\r\nVIBROU NA COROA DE ZAMBI\r\nVIBROU NA COROA DE ZAMBI\r\nVIBROU NA COROA DE ZAMBI\r\n\r\nKAÔ', 14, 'Sustentação', NULL, NULL),
(112, 3, 'XANGÔ MEU XANGÔ MENINO\r\nDA LINHA DE OXALÁ\r\nNOS DÊ SEU AXÉ PRA NÓS, OH XANGÔ\r\nKAÔ MEU XANGÔ AYRÁ\r\n\r\nDÊ FORÇA PARA SEUS FILHOS\r\nPROTEJA SEU ABAÇÁ\r\nSEGURA SUA PEDREIRA XANGÔ\r\nNÃO DEIXE A PEDRA ROLAR', 14, 'Chamada', NULL, NULL),
(113, 3, 'PEGA NO SEU LIVRO ELE VAI LENDO\r\nPEGA NA PENA PRA ESCREVER\r\n\r\nXANGÔ , KAÔ\r\nSARAVÁ NA UMBANDA SEU ALAFIN , SEU AGODÔ.', 14, 'Chamada', NULL, NULL),
(114, 5, 'Xangô é Rei\r\nÉ rei nago {2x}\r\n\r\nOh vamos bater palmas pra coroa de Xangô {2x}', 14, 'Sustentação', NULL, NULL),
(115, 4, 'Xangô meu pai\r\nDeixa essa pedreira aí {2x}\r\n\r\nSão teus filhos que lhe chamam  \r\nDeixa essa pedreira aí {2x}', 14, 'Chamada', NULL, NULL),
(116, 4, 'Meu pai São João Batista ele é Xangô \r\nSenhor do meu destino até fim  {2x}\r\n\r\nSe um dia me faltar a fé no meu senhor \r\nQue rolem as pedreiras sobre mim {2x}', 14, 'Sustentação', NULL, NULL),
(117, 4, 'Pedra rolou pra Xangô\r\nLá nas pedreiras\r\nAfirma o ponto meu pai\r\nNa cachoeira {2x}\r\n\r\nTenho meu corpo fechado\r\nXangô é meu protetor\r\nAfirma o ponto meu filho\r\nPai de cabeça chegou {2x}', 14, 'Chamada', NULL, NULL),
(118, 2, 'Xangô meu Pai\r\nAmarra os inimigos e dá um nó, \r\nXangô meu pai\r\nAmarra os inimigos no cipó {2x}\r\n\r\nEstão queimando vela \r\npra me derrubar\r\nEu ja fiquei doente meu pai, \r\nsem poder andar\r\nAgora estou aqui \r\nPra saudar Xangô\r\nVira essa macumba meu pai \r\nNo peito de quem mandou!', 14, 'Sustentação', NULL, NULL),
(119, 3, 'Por detrás daquela serra\r\ntem uma linda cachoeira\r\n\r\nQue é de meu pai Xangô\r\nQue arrebentou 7 pedreiras {2x}', 14, 'Sustentação', NULL, NULL),
(120, 3, 'Se eu errei, aqui estou, \r\nPedindo Maleme meu pai Xangô {2x}\r\n\r\nMandai a faísca de um raio pra me iluminar, \r\nSegura pedra na pedreira não deixa rolar, \r\nXangô Kao meu pai\r\nOs seus filhos bambeiam mas não caem.', 14, 'Sustentação', NULL, NULL),
(121, 4, 'Trovejou lá no céu\r\nE o mundo balanceou     {2x}\r\n\r\nOh! Cristo o mundo balanceou\r\nSó não balanceou a coroa de Xangô    {2x}', 14, 'Sustentação', NULL, NULL),
(122, 2, 'ELE BRADOU NA ALDEIA\r\nBRADOU NA CACHOEIRA\r\nEM NOITE DE LUAR\r\n\r\nNO ALTO DA PEDREIRA\r\nVAI FAZER JUSTIÇA\r\nPRA NOS AJUDAR [2X]\r\n\r\n[refrão]\r\nELE BRADOU NA ALDEIA\r\nKAÔ KAÔ\r\nE AQUI VAI BRADAR\r\nKAÔ KAÔ\r\n\r\nELE É XANGÔ DA PEDREIRA\r\nELE NASCEU NA CACHOEIRA\r\nLÁ NO JUREMÁ [2X]\r\n[/refrão]', 14, 'Sustentação', NULL, NULL),
(123, 4, 'Lá vem Xangô, lá vem Xangô\r\nLá vem Xangô, lá vem Xangô\r\n\r\nNa coroa de lei, Xangô é rei\r\nNa coroa de lei, Xangô é rei\r\n\r\nÔ oo,ooooooo /ôôôôõô.......', 14, 'Chamada', NULL, NULL),
(124, 4, 'Lá vem Xangô\r\nVem descendo a serra\r\nEle vem beirando o mar....\r\nEle deixou sua pedreira lá no alto\r\n\r\nKaô, Kabecilê\r\nEle deixou sua pedreira lá no alto\r\nKaô, Kabecilê', 14, 'Chamada', NULL, NULL),
(125, 3, 'XANGÔ E FORTE E FORTE COMO UM LEÃO\r\nXANGÔ E FORTE E FORTE COMO UM LEÃO\r\n\r\nARREBENTOU SETE PEDREIRAS SEM FERIR\r\nA SUA MÃO\r\nARREBENTOU SETE PEDREIRAS SEM FERIR\r\nA SUA MÃO\r\n', 14, 'Sustentação', NULL, NULL),
(126, 4, 'OGUM ME DISSE\r\nQUE DANÇAR NAGÔ É BOM [2X]\r\n\r\nQUE DANÇAR NAGÔ É BOM\r\nQUE DANÇAR NAGÔ É BOM\r\nQUE DANÇAR NAGÔ É BOM\r\nQUE DANÇAR NAGÔ É BOM', 7, 'Sustentação', NULL, NULL),
(127, 2, 'Ogun já venceu, já venceu, já venceu\r\nOgun vem de Aruanda e quem lhe manda é Deus\r\nEle vem beirando o rio\r\nEle vem beirando o mar\r\nÔh salve Santo Antônio da Calunga, Benedito e Beira-Mar', 7, 'Sustentação', NULL, NULL),
(128, 2, 'OGUM EM SEU CAVALO CORRE\r\nE A SUA ESPADA RELUZ\r\nOGUM, OGUM MEGÊ\r\nSUA BANDEIRA COBRE OS FILHOS DE JESUS , OGUM IÊ', 7, 'Sustentação', NULL, NULL),
(129, 4, 'Quem beira rio, beira rio, beira mar\r\nO que se ganha de Ogun só Ogun pode tirar\r\n\r\nSeu Ogun de ronda, é quem vem girar\r\nE vem trazendo folhas\r\nPra descarregarNago\r\nQuem beira rio, beira rio, beira mar\r\nO que se ganha de Ogun só Ogun pode tirar\r\n\r\nSeu Ogun de ronda, é quem vem girar\r\nE vem trazendo folhas\r\nPra descarregar', 7, 'Sustentação', NULL, NULL),
(130, 3, 'SE MEU PAI É OGUM\r\nVENCEDOR DE DEMANDAS\r\nELE VEM DE ARUANDA\r\nPRA SALVAR FILHOS DE UMBANDA\r\n\r\nOGUM, OGUM IARA\r\nOGUM, OGUM IARA\r\nSALVE OS CAMPOS DE BATALHA\r\nSALVE A SEREIA DO MAR\r\nOGUM, OGUM IARA\r\nSARAVÁ OGUM, OGUM IARA', 7, 'Sustentação', NULL, NULL),
(131, 3, 'MANDEI FAZER\r\nUM CAPACETE DE PENAS\r\nPARA USAR\r\nANTES DA ALVORADA\r\n\r\nVERMELHO E BRANCO\r\nVERDE E AZUL\r\nESSE CAPACETE\r\nTEM AS CORES DE OGUM [2X]\r\n\r\nDE OGUM MEGÊ\r\nDE OGUM MATINATA\r\nDE OGUM MEGÊ\r\nDE OGUM MATINATA\r\n\r\nQUANDO USO O CAPACETE\r\nOUÇO O TOQUE DA ALVORADA [2X]', 7, 'Sustentação', NULL, NULL),
(132, 3, 'OGUM BEIRA-MAR\r\nO QUE TROUXE DO MAR\r\nOGUM BEIRA-MAR\r\nO QUE TROUXE DO MAR\r\n\r\nQUANDO ELE VEM\r\nVEM BEIRANDO A AREIA\r\nNA MÃO DIREITA\r\nELE TRÁS A GUIA DA MAMÃE SEREIA\r\n\r\nQUANDO ELE VEM\r\nVEM BEIRANDO A AREIA\r\nNA MÃO DIREITA\r\nELE TRÁS A GUIA DA MAMÃE SEREIA\r\n2X]', 7, 'Chamada', NULL, NULL),
(133, 3, 'POR SETE VEZES PAI OGUN ME LEVANTOU \r\nSETE CAMINHOS COM SUA MÃO ME GUIOU \r\nCOM SUA ESPADA PRONTO PRA ME DEFENDER \r\nMEU PAI OGUN \r\nNÃO DEIXE FILHO SOFRER \r\nE QUANDO A LUA BRILHAR NOS CAMPOS DO HUMAITÁ\r\nESTÁ NA HORA DE SAUDAR BRAVO GUERREIRO DE UMBANDA \r\nNO TOQUE DA ALVORADA,, NÃO TEM INIMIGO ALGUM \r\nÉ VENCEDOR DE DEMANDA \r\nGENERAL DE UMBANDA SALVE PAI OGUN \r\n\r\nOGUN, OGUN DILÊ, \r\nOGUN MEGÊ SEU MATINATA VEM TAMBÉM \r\nSALVE OGUN ROMPE-MATO, SEU OGUN IARA NO GONGÁ \r\nSALVE OGUN SETE ESPADAS, SALVE SEU BEIRA-MAR', 7, 'Sustentação', NULL, NULL),
(134, 2, 'Ogum voltou da guerra,\r\nE entregou sua espada aos pés de Oxalá.\r\nEle foi nomeado, general de Umbanda por Obatalá.\r\nEle venceu demandas.\r\nPara me proteger.\r\nEle usou escudo,\r\npara me defender.\r\nSou filho do guerreiro,\r\nQue vem nos ajudar,\r\nA sua espada é lei,\r\nQue corta todo mal,\r\nSeu nome é Ogunjá.', 7, 'Sustentação', NULL, NULL),
(135, 2, 'Com seu cavalo branco\r\nde espada na mão\r\nDe lança e escudo ele venceu o dragão\r\n\r\nOgun de Lei\r\nOgun megê\r\nOgun meu pai\r\nQuem é filho de Ogun balanceia mas não cai\r\nQuem é filho de Ogun balanceia mas não cai', 7, 'Sustentação', NULL, NULL),
(136, 3, 'Oi na linha de umbanda \r\norixá quem comanda é Ogun\r\nÉ o santo guerreiro, segura o terreiro Ogun\r\nSaravá Ogun Iara,Ogun beira-mar\r\nAuê Ogun Rompe-mato, Ogun de Lei\r\nQuem está de ronda é Ogun Megê', 7, 'Chamada', NULL, NULL),
(137, 3, 'Na porta da romarinha\r\nEu vi um cavaleiro de ronda\r\ntrazia um escudo no braço e uma lança na mão\r\nOgun venceu a guerra e matou o dragão', 7, 'Sustentação', NULL, NULL),
(138, 3, 'Eu tenho sete espadas pra me defender\r\nEu tenho Ogun em minha companhia\r\nOgun é meu pai, Ogun é meu guia\r\nOgun é meu orixa\r\nFilho de Deus e da Virgem Maria', 7, 'Sustentação', NULL, NULL),
(139, 2, 'SELEI SELEI\r\nO SEU CAVALO EU SELEI\r\n\r\nMEU PAI OGUM JA VAI EMBORA\r\nSEU CAVALO SELEI }bis\r\n', 7, 'Subida', NULL, NULL),
(140, 3, 'Saluba ê Saluba ê Nanã\r\nSaluba ê\r\nÔ Nanã Buruquê', 5, 'Sustentação', NULL, NULL),
(141, 3, 'SOU FILHO DA SENHORA NANÃ\r\nO QUE EU FAÇO AGORA\r\n\r\nTÔ NO MEIO DO CAMINHO \r\nEM BUSCA DA VITÓRIA\r\n\r\nCACURUCAIA DA NOSSA UMBANDA\r\nME PÕE NO COLO NANÃ E ME BALANÇA\r\nCACURUCAIA DA NOSSA UMBANDA \r\nME PÕE NO COLO NANÃ, SOU UMA CRIANÇA', 5, 'Sustentação', NULL, NULL),
(142, 1, 'SÃO FLORES NANÃ, SÃO FLORES\r\nSÃO FLORES NANÃ BURUKÊ\r\nSÃO FLORES NANÃ, SÃO FLORES\r\nDO SEU FILHO OBALUAÊ [2X]\r\n\r\nNAS HORAS E AGONÍA\r\nELE SEMPRE VEM VALER\r\nÉ SEU FILHO NANÃ, É MEU PAI\r\nELE É OBALUAÊ', 5, 'Sustentação', NULL, NULL),
(143, 3, ' SE A MINHA MÃE É SALUBA\r\nMAS ELA É O ORIXA MAIS ANTIGO DO CÉU\r\nNANÃ , NANÃ BURUQUÊ\r\nQUEM É SEU FILHO\r\nAGORA QUE EU QUERO VER [2x]', 5, 'Sustentação', NULL, NULL),
(144, 3, 'MANHÃS, SUBLIMES MANHÃS DOS MEUS DIAS\r\nLINDO TODO O MEU DESPERTAR \r\n\r\nNANÃ, OH! MINHA MÃE COMO É BELA A MINHA VIDA \r\nNANÃ, COMO É BOM ACORDAR E TE VER\r\nSUA BÊNÇÃO NANÃ, MINHA MÃE NANÃ BURUQUÊ\r\n\r\nQUANDO EM SEU COLO ME DEITO \r\nME SINTO PERFEITO \r\nEM TODO MEU SER \r\n\r\nOH! MINHA MÃE NANÃ \r\nQUE EM TODAS MANHÃS EU POSSA LHE VER\r\n\r\nNANÃ, OH! NANÃ BURUQUÊ \r\nSOU AINDA UMA CRIANÇA \r\nEM MANHÃ DE ESPERANÇA \r\nCOM VONTADE DE CRESCER', 5, 'Sustentação', NULL, NULL),
(145, 1, 'Negra da costa\r\nO que traz em seu balaio para vender...\r\nEla traz Acarajé, com azeite de dendê\r\nEla traz Acarajé, com azeite de dendê\r\n\r\nInanauê, inanaua\r\nInanauê, é Nanã de Buruquê\r\n\r\nNegra da costa...\r\nO que traz em seu balaio para vender...\r\nEla traz Acarajé, com azeite de dendê\r\nEla traz Acarajé, com azeite de dendê\r\n\r\nInanauê, inanaua\r\nInanauê, é Nanã de Buruquê', 5, 'Sustentação', NULL, NULL),
(146, 4, 'Atraca atraca que aí vem Nanã, ea\r\nAtraca atraca que aí vem Nanã, ea\r\nAtraca atraca que aí vem Nanã, ea\r\nAtraca atraca que aí vem Nanã, ea\r\n\r\nÉ Nanã, é Oxum é que vem saravá, ea\r\nAtraca atraca que aí vem Nanã, ea', 5, 'Chamada', NULL, NULL),
(147, 1, 'Quando eu for pra Aruanda\r\nsei que vou te encontrar \r\nrodeada de crianças, do lado de Iemanjá.\r\nVou pedir pra Omolú e aos sagrados Orixás\r\npra chover chuva de rosas quando eu for te abraçar. \r\n\r\nPerdoa Nanã, perdoa. \r\nPerdoa que eu vou chorar, \r\nquem eu amava foi embora, está nos braços de Oxalá.', 5, 'Sustentação', NULL, NULL),
(148, 4, 'Nana, Nana eu vou\r\nvou nas ondas dançar com você \r\n\r\nFirma a cabeça filhos de terreiro\r\npeça maleime a Nanã Buruquê.\r\n', 5, 'Sustentação', NULL, NULL),
(149, 1, 'Oxum Aieieo\r\nOxum Aieieo\r\nÓ linda mamãe Oxum\r\nOlhe pelos filhos teus\r\n\r\nOlho pro céu, vejo uma estrela encantada.\r\nUma lua iluminada com estrelas a brilhar.\r\nEla é Oxum, Orixá da natureza e a sua pura beleza\r\nvem a todos encantar.\r\n\r\nOxum Aieieo\r\nOxum Aieieo\r\nÓ linda mamãe Oxum\r\nolhe pelos filhos teus \r\n\r\nTeu manto santo nos dá paz nos dá amor.\r\nAlivia nossa dor e nos traz a proteção.\r\nMamãe Oxum hoje rezo e agradeço.\r\nMostro que fé não tem preço quando vem do coração.\r\n\r\nOxum Aieieo\r\nOxum Aieieo\r\nÓ linda mamãe Oxum\r\nOlhe pelos filhos teus', 12, 'Sustentação', NULL, NULL),
(150, 2, 'A CACHOEIRA DA MAMÃE OXUM\r\nÉ TÃO BONITA QUE DÁ GOSTO VER \r\n\r\nAS ÁGUAS ROLAM\r\nAS ÁGUAS BRILHAM\r\nMAS QUE BELEZA MINHA MÃE\r\nQUE MARAVILHA \r\n\r\nAIEIEU MINHA MÃE\r\nME LEVA NOS BRAÇOS AIEIEU ', 12, 'Sustentação', NULL, NULL),
(151, 1, 'Eu vi mamãe Oxum na cachoeira\r\nsentada na beira do rio }bis\r\n\r\nColhendo lirios, lirio ê\r\ncolhendo lirios, liro á\r\ncolhendo lirios para enfeitar nosso congar }bis', 12, 'Sustentação', NULL, NULL),
(152, 1, 'Mamãe Oxum, dos cabelos louros\r\nSe o mar tem água na sua aldeia tem ouro\r\n\r\nAuê, auê\r\nAuê, auá\r\nMamãe Oxum é a sereia do mar }bis', 12, 'Sustentação', NULL, NULL),
(153, 1, 'Aieieu, aieieu mamãe Oxum }bis\r\nAieieu mamãe Oxum, aieieu Oxumarê }bis', 12, 'Sustentação', NULL, NULL),
(154, 1, 'Eu vi mamãe Oxum\r\nsentada, chorando, na cachoeira\r\nEsperando pai Ogun jurar bandeira }bis\r\n\r\nOh saravamos mamãe orixá\r\nOgun jurou bandeira\r\nem nome de Oxalá }bis', 12, 'Sustentação', NULL, NULL),
(155, 4, 'Bate cabeça filhos de umbanda\r\nSalve Oxalá\r\nsalve a nossa banda', 31, 'Sustentação', NULL, NULL),
(156, 4, 'Bate cabeça babalaô\r\nVamos pedir a proteção\r\nPara seus filhos não cair', 31, 'Sustentação', NULL, NULL),
(157, 3, 'Iansã orixá de Umbanda\r\nRainha do nosso congá\r\nSaravá Iansã! Lá na Aruanda, eparrei, eparrei,\r\nIansã venceu demanda\r\nIansã, saravou pai Xangô! No céu trovão roncou\r\nE lá na mata o leão bradou, Saravá Iansã! Saravá Xangô!', 2, 'Sustentação', NULL, NULL),
(158, 3, 'Iansã é uma moça bonita\r\nEla e dona do seu jacuta }bis\r\n \r\nEparrei eparrei eparrei\r\nÓ mamãe de aruanda\r\nSarava na Umbanda que eu quero ver', 2, 'Chamada', NULL, NULL),
(159, 4, 'VENTOU, MAS QUE VENTANIA\r\nVENTOU, MAS QUE VENTANIA\r\nIANSÃ É NOSSA MÃE\r\nIANSÃ É NOSSA GUIA \r\n', 2, 'Sustentação', NULL, NULL);
INSERT INTO `icnt_pontos` (`id`, `ritmo`, `ponto`, `linha`, `tipo`, `audio_link`, `title`) VALUES
(160, 3, 'ME PROTEGI NO BAMBUZAL DE IANSÃ\r\nDAS DEMANDAS QUE JOGARAM EM MIM\r\n\r\nELA É DO VENTO QUE TRAZ TODA BONDADE\r\nE COM SEU RAIO DESTRÓI TODA MALDADE\r\n\r\nEPARREI BELA OYÁ\r\nVIROU O TEMPO, FOI PRA ELA GUERREAR\r\nEPARREI BELA OYÁ\r\nNA NOSSA UMBANDA ELA É GRANDE ORIXÁ\r\n', 2, 'Sustentação', NULL, NULL),
(161, 5, 'Aiê dindi, Aiê dindá\r\nA matamba de arulê\r\na matamba de arulá', 2, 'Sustentação', NULL, NULL),
(162, 3, 'Iansã tem um leque que venta\r\nPra abanar, dias de calor }bis\r\nIansã mora nas pedreiras\r\nEu quero ver, meu pai Xangô }bis\r\n', 2, 'Sustentação', NULL, NULL),
(163, 2, 'Oh tibere bere\r\nOh Iansã tibereré /2x\r\n\r\nOya Oya\r\nOya oi olha a mataba do kacuruta dendê /2x', 2, 'Sustentação', NULL, NULL),
(164, 3, 'Eram duas ventarolas, duas ventarolas\r\nVenta aqui, venta no mar /2x\r\n\r\nUma era Iansã, Eparrei\r\na outra era Iemanjá, Odociaba /2x', 2, 'Sustentação', NULL, NULL),
(165, 3, 'Eparrê ô, eparrê á, eparrê, força de Oyá /3x\r\n\r\nEla é mais que temporal\r\nmuito mais que ventania\r\nUma força sem igual\r\num poder que arrepia\r\nA bravura de mil homens\r\ntudo em uma só mulher\r\nE por nós ela guerreia\r\nvenha o mal de onde vier\r\n\r\nEparrê ô, eparrê á, eparrê, força de Oyá /3x\r\n\r\nFilha de santa guerreira\r\nmeu caminho eu mesmo traço\r\nFui criada em fogo alto\r\ntenho minha alma de aço\r\nAgradeço a Iansã\r\ntudo que ela me ensinou\r\na coragem de Ogun\r\ne a justiça de Xangô\r\n\r\nEparrê ô, eparrê á, eparrê, força de Oyá /3x', 2, 'Sustentação', NULL, NULL),
(166, 2, 'O tempo fechou, \r\nO céu escureceu\r\nChoveu, choveu\r\nChoveu, choveu \r\n\r\nE as 7 cores, \r\nSe estenderam pela eternidade,\r\nAnunciando o final da tempestade, \r\n\r\nE quando a chuva parou,\r\nEu vi o sol nascer,\r\nEu vi o arco íris de Oxumarê \r\nNão foi ninguém que contou,\r\nEstava lá pra ver,\r\nEu vi o arco íris de Oxumarê, \r\n\r\nEu vejo um arco íris,\r\nEu vejo um tesouro,\r\nEu vejo uma serpente,\r\nToda feita de ouro. ', 13, 'Sustentação', NULL, NULL),
(167, 6, 'OXUMARÊ, OXUMARÊ\r\nELE É FILHO DE NANÃ\r\nÉ IRMÃO DE OBALUAÊ [2x]\r\nCOM SUA SERPENTE SAGRADA\r\nQUE FICA EM SUA MÃO\r\nA SUA DANÇA ENCANTADA\r\nMOSTRA O CÉU E O CHÃO\r\nSALVE O REI DO ARCO-ÍRIS\r\nARROBOBOI OXUMARÊ\r\nNA CABECEIRA DE UM RIO\r\nSETE CORES VI NASCER\r\nOXUMARÊ, OXUMARÊ\r\nELE É FILHO DE NANÃ\r\nÉ IRMÃO DE OBALUAÊ', 13, 'Sustentação', NULL, NULL),
(168, 1, 'Oxumarê, meu Pai das cores\r\nDeu cor a terra, deu cor ao mar\r\nDeu verde as matas, pintou as flôres\r\nNo azul do céu é o arco iris a brilhar', 13, 'Sustentação', NULL, NULL),
(169, 1, 'Plantei mandioca, a formiga comeu\r\n\r\nJá plantei, não planto mais', 27, 'Sustentação', NULL, NULL),
(170, 4, 'Lá se vão os pretos velhos\r\nVão subindo para o céu\r\nE nossa senhora vai cobrindo com seu véu\r\n\r\nNo caminho onde eles passam\r\nNão tem desarmonia\r\nQue nossa senhora\r\nseja sua estrela guia.', 27, 'Subida', NULL, NULL),
(171, 3, 'Oh Martin Pescador que banda é a sua\r\nBebendo cachaça e caindo na rua\r\nOh Martin Pescador que banda é a sua\r\nBebendo cachaça e caindo na rua\r\nEu bebo minha cachaça, eu bebo muito bem\r\nBebo com meu dinheiro, não é da conta de ninguém\r\n\r\nOh Martin Pescador que banda é a sua\r\nBebendo cachaça e caindo na rua\r\nOh Martin Pescador que banda é a sua\r\nBebendo cachaça e caindo na rua', 25, 'Sustentação', NULL, NULL),
(172, 5, 'Eu não sou daqui, marinheiro só\r\nEu não tenho amor, marinheiro só\r\nEu sou da Bahia, marinheiro só\r\nE de São Salvador, marinheiro só\r\n\r\nOh marinheiro, marinheiro, marinheiro só\r\nQuem te ensinou a nadar, marinheiro só\r\nOu foi o tombo do navio, marinheiro só\r\nOu foi o balanço do mar, marinheiro só\r\n\r\nLá vem, lá vem, marinheiro só\r\nComo ele vem faceiro, marinheiro só\r\nTodo de ranco, marinheiro só\r\nCom o seu bonezinho, marinheiro só', 25, 'Sustentação', NULL, NULL),
(173, 3, 'Minha jangada vai sair pro mar\r\nPra trabalhar, meu bem querer\r\nSe Deus quiser quando eu voltar do mar\r\nUm peixe bom eu vou trazer, hei de trazer\r\nMeus companheiros também vão voltar\r\nE a Deus do céu vamos agradecer', 25, 'Sustentação', NULL, NULL),
(174, 3, 'Seu marinheiro eu não sei porque\r\nToda madrugada eu sonho com você\r\n\r\nMarinheiro é bom aqui nesta corrente\r\nSó um marinheiro pra salvar toda esta gente', 25, 'Sustentação', NULL, NULL),
(175, 3, 'O cachaça para de ser besta\r\nTe mando pra barriga\r\nE você sobe pra cabeça', 25, 'Sustentação', NULL, NULL),
(176, 3, 'Na barra haviam dois navios\r\nNa barra haviam dois navios\r\nPerguntei se podia entrar\r\nA barra  já está tomada seu marujo\r\nessa barra aqui quem manda é Oxalá 2x', 25, 'Sustentação', NULL, NULL),
(177, 3, 'Cirandeiro oh\r\nO Cirandeiro, Cirandeiro oh\r\nA pedra do seu anel\r\nBrilha mais que ouro em pó\r\nA pedra do seu anel\r\nBrilha mais que ouro em pó', 25, 'Sustentação', NULL, NULL),
(178, 3, 'Seu Marinheiro, é hora\r\nÉ hora de vir trabalhar\r\nSeu Marinheiro, é hora\r\nÉ hora de vir trabalhar\r\nÉ céu\r\nÉ terra\r\nÉ mar\r\nSeu Marinheiro, vem das ondas do mar\r\nÉ céu\r\nÉ terra\r\nÉ mar\r\nSeu Marinheiro, olha as ondas do mar ', 25, 'Sustentação', NULL, NULL),
(179, 3, 'Eu joguei meu barco na água\r\nViajei para Lisboa\r\nNossa Senhora na frente\r\nOs marujos vêm na proa', 25, 'Sustentação', NULL, NULL),
(180, 3, 'Quem vem do mar \r\nPisa na areia\r\nSão os guerreiros de Yemanjá\r\nMamãe Sereia\r\nO Mar é bravo quem conhece é pescador\r\nMarinheiro Mora nela \r\nE também é se protetor\r\nPeça licença quando no mar for entrar \r\nDiga Agô bate cabeça \r\nOdoyá Yemanjá.', 25, 'Sustentação', NULL, NULL),
(181, 2, 'Oi chove chuva bem miudinha\r\nChove chuva bem miudinha \r\nNa aba do meu chapéu\r\nNa aba do meu chapéu \r\nMas se eu tivesse um grande amor\r\nMas se eu tivesse um grande amor\r\nEu largava de beber\r\nEu largava de beber \r\n\r\nMas como eu não tenho amor\r\nMas como eu não tenho amor\r\nA cachaça é minha amada\r\nA cachaça é minha amada', 25, 'Sustentação', NULL, NULL),
(182, 3, 'Leva leva leva marujo\r\nLeva pro fundo do mar\r\nLeva embora toda demanda\r\nE toda kizumba deste Cazuá\r\nLeva leva leva marujo\r\nLeva pro fundo do mar\r\nLeva embora tudo que faz mal\r\nPro mar de Yemanjá\r\nPara purificar.', 25, 'Subida', NULL, NULL),
(183, 3, 'Cigano que corre o mundo\r\nEm uma carroça de pano \r\nCigano não tem lugar\r\nCigano é de ano em ano', 20, 'Sustentação', NULL, NULL),
(184, 3, 'Mandei fazer um baralho de ouro\r\nPara a Cigana jogar\r\nEmbaralha ê, embaralha ah\r\nEmbaralha ê\r\nDeixa a Cigana jogar', 20, 'Sustentação', NULL, NULL),
(185, 3, 'Quem neste mundo nunca ouviu dizer?\r\nQuem neste mundo nunca ouviu falar?\r\nQuem neste mundo nunca ouviu dizer?\r\nQuem neste mundo nunca ouviu falar\r\nDe uma cigana que mora naquela estrada?\r\nEla fez sua morada sob o clarão do luar.\r\nDe uma cigana que mora naquela estrada;\r\nEla fez sua morada sob o clarão do luar.\r\nCigana da Estrada, força poderosa,\r\nMe dê proteção e axé, ciganinha formosa.\r\nCigana da Estrada, força poderosa,\r\nMe dê proteção e axé, ciganinha formosa.', 20, 'Sustentação', NULL, NULL),
(186, 2, 'Povo Cigano, povo contente\r\nA força dos Ciganos \r\nEla vem lá do Oriente \r\n\r\nO Ciganinho tem sabedoria \r\nEle anda toda noite \r\nEle anda todo dia ', 20, 'Chamada', NULL, NULL),
(187, 3, 'Gosta de mim\r\nPor que não vem me ver }bis\r\n\r\nSe é cigano e se é valente \r\nvenha ver a força\r\nque a gente tem }bis', 20, 'Chamada', NULL, NULL),
(188, 3, 'Ganhei uma barraca velha\r\nfoi a cigana quem me deu\r\nO que é meu é da cigana\r\nO que é dela não é meu', 20, 'Sustentação', NULL, NULL),
(189, 3, 'O ciganinha puere\r\npuerê, puera\r\nEla é uma cigana\r\npuerê, puerâ', 20, 'Sustentação', NULL, NULL),
(190, 3, 'Cigana, ciganinha\r\nda sandália de pau }bis\r\n\r\nQuando chega no terreiro\r\nfaz o bem e leva o mal }bis', 20, 'Sustentação', NULL, NULL),
(191, 3, 'A cigana me pediu\r\npara eu abrir meu coração }bis\r\n\r\nAbre a roda que a cigana\r\nAbre a roda que a cigana\r\nquer ler a minha mão }bis\r\n', 20, 'Sustentação', NULL, NULL),
(192, 2, 'Mas eles vão no clarão da Lua\r\nVão caminhando por aquela estrada \r\nPovo Cigano desarma a Tsara \r\nE deixa a proteção de Santa Sara', 20, 'Subida', NULL, NULL),
(193, 4, 'Vamos brincar de roda\r\nCosme, Damião e Doun }bis\r\nEles vem montados no cavalo de Ogun\r\nVem trazendo rosas\r\npra mamãe Oxum', 23, 'Chamada', NULL, NULL),
(194, 2, 'Na mata fechada \r\nCaboclo brada e não teme a nada }bis\r\n\r\nE ele brada, lá da pedreira \r\nnão é caçador, ele protege sua aldeia }bis\r\n\r\nKiô Kiô Caboclo\r\nOkê Okê Arô\r\nÉ Treme Terra\r\nmeu Caboclo Guerreiro\r\nque vem cruzado na linha de Xangô }bis', 19, 'Sustentação', NULL, NULL),
(195, 2, 'Oxalá chamou\r\nOxalá chamou e já mandou buscar \r\nOs caboclos da Jurema \r\nPro seu Juremá \r\nPai Oxalá \r\nÉ o rei do mundo inteiro \r\nJá deu ordens pra Jurema \r\nChamar seus capangueiros ', 19, 'Sustentação', NULL, NULL),
(196, 5, 'Portão da Aldeia abriu\r\nPara Caboclo passar \r\nÉ hora, é hora, é hora meus Caboclos\r\nÉ hora de trabalhar \r\n\r\nAuê auê auê boca da mata\r\nDeixa Caboclo passar boca da mata ', 19, 'Chamada', NULL, NULL),
(197, 3, 'Ô JUREMÊ Ô JUREMA\r\nSUA FOLHA CAIU SERENA Ô JUREMA\r\nDENTRO DESSE GONGÁ\r\n\r\nÔ JUREMÊ Ô JUREMÁ\r\nSUA FOLHA CAIU SERENA Ô JUREMA\r\nDENTRO DESSE GONGÁ\r\n\r\nSUA FOLHA CAIU SERENA Ô JUREMA\r\nDENTRO DESSE GONGÁ\r\nELA É CABOCLA JUREMA\r\nAQUI E EM QUALQUER LUGAR\r\n\r\nSUA FOLHA CAIU SERENA Ô JUREMA\r\nDENTRO DESSE GONGÁ\r\nELA É CABOCLA JUREMA\r\nAQUI E EM QUALQUER LUGAR', 19, 'Chamada', NULL, NULL),
(198, 3, 'E RÊ RÊ\r\nCABOCLO 7 FLECHAS NO GONGÁ\r\nE RÊ RÊ\r\nCABOCLO 7 FLECHAS NO GONGÁ\r\n\r\nSARAVÁ SEU 7 FLECHAS\r\nQUE ELE É O REI DA MATA\r\nCOM A SUA BODOQUE ATIRA (Ô PARANGA)\r\nSUA FLECHA MATA [2X]\r\n\r\nE RÊ RÊ\r\nCABOCLO 7 FLECHAS NO GONGÁ\r\nE RÊ RÊ\r\nCABOCLO 7 FLECHAS NO GONGÁ', 19, 'Chamada', NULL, NULL),
(199, 3, 'CAÇADOR NA BEIRA DO CAMINHO\r\nNÃO ME MATE ESSA CORAL NA ESTRADA\r\nELA ABANDONOU SUA CHOUPANA\r\nNO ROMPER DA MADRUGADA [2X]', 19, 'Sustentação', NULL, NULL),
(200, 3, 'FOI NUMA TARDE SERENA\r\nLÁ NAS MATAS DA JUREMA\r\nEU VI UM CABOCLO BRADAR [2X]\r\n\r\n[refrão]\r\nKIÔ\r\nOH KIÔ KIÔ KIÔ KIERA\r\nTODA MATA ESTÁ EM FESTA\r\n\r\nSARAVÁ SEU SETE FLECHAS\r\nQUE ELE É REI DA FLORESTA\r\n[/refrão]', 19, 'Sustentação', NULL, NULL),
(201, 3, 'VESTIMENTA DE CABOCLO\r\nÉ SAMAMBAIA, É SAMAMBAIA, É SAMAMBAIA [2X]\r\n\r\n[refrão]\r\nSAIA CABOCLO\r\nNÃO SE ATRAPALHA\r\nSAIA DO MEIO\r\nDA SAMAMBIA\r\n[/refrão]', 19, 'Sustentação', NULL, NULL),
(202, 3, 'Caboclo não tem caminhos para caminhar }bis\r\n\r\nCaminha por cima das folhas\r\npor baixo das folhas\r\nem qualquer lugar }bis', 19, 'Sustentação', NULL, NULL),
(203, 3, 'Se a coral é sua cinta\r\nA jiboiá é sua lança }bis\r\n\r\nOia, quizôa, quizôa, quizôa ê\r\nCaboclo mora nas matas. }bis', 19, 'Sustentação', NULL, NULL),
(204, 4, 'O Orvalho caiu no Juremá\r\nUma estrela no céu brilhou\r\nOi Saravá seu Treme-terra de Aruanda\r\nele é o rei dos caçador \r\n\r\nMas ele é o rei ele é o rei ele é o rei\r\nMas ele é o rei de Aruanda é o rei            (2x)\r\nMas ele é o rei do nosso congá', 19, 'Sustentação', NULL, NULL),
(205, 3, 'Caboclo pega a sua flecha\r\nPegue seu bodoque\r\nQue o galo já cantou.\r\n\r\nO galo já cantou na Aruanda\r\nOxalá te chama \r\nPara sua banda\r\nOkê caboclo\r\n', 19, 'Subida', NULL, NULL),
(206, 3, 'Baiana chegou na aldeia, na luz da lua cheia\r\nEstremece os corações, e a fé ele incendeia\r\nPisa leve pisa manso meu nego, oh lua meia\r\nClareia o congá, quando olha mamãe sereia\r\nQuando pisa na areia o mar já balanceia\r\nJoga a rede pescador, proteção Mãe das Candeias', 17, 'Chamada', NULL, NULL),
(207, 3, 'Mas olha meu camarada\r\nCamarada meu \r\nSeu MARCELINO quem chegou aqui agora\r\nCandomblé bato no Ketu\r\nUmbanda bato na Angola \r\nMas olha meu camarada\r\nCamarada meu ', 17, 'Chamada', NULL, NULL),
(208, 3, 'Seu guarda civil não quer\r\nA roupa no quarador \r\nMeu Deus como eu vou quarar ?\r\nQuarar minha roupa ', 17, 'Sustentação', NULL, NULL),
(209, 2, 'Seu Marcelino vem\r\nvem pra animar\r\nÉ festa no terreiro\r\nvem saldar nosso congá }bis\r\n\r\nÉ festa em Aruanda\r\nvamos todos celebrar\r\nsalve suas forças\r\nsalve meu pai Oxalá', 17, 'Chamada', NULL, NULL),
(210, 4, 'A subida dos Baianos, faz o coco até rachar\r\nA demanda do Terreiro os Baianos vão levar\r\nCoco cai, coqueiro chora, coco cai os Baianos vão embora.\r\n', 17, 'Subida', NULL, NULL),
(211, 1, 'Quando o côco cai\r\ntodo o coqueiro chora }bis\r\n\r\nAdeus, adeus meu pai\r\nos bahianos vão embora }bis\r\n', 17, 'Subida', NULL, NULL),
(212, 3, 'Rodeia, rodeia, rodeia,\r\nMeu Santo Antônio rodeia.\r\nSanto Antônio Pequenino,\r\nAmansador de burro brabo,\r\nQuem mexer com (Nome do Exu)\r\nTa mexendo com o diabo.', 21, 'Sustentação', NULL, NULL),
(213, 2, 'BALANÇOU…\r\nA TERRA CHACOALHOU\r\nBALANÇOU…\r\nA TERRA CHACOALHOU\r\n\r\nMAS ELE FICOU DE PÉ\r\nTREME TERRA É\r\nTREME TERRA OH\r\nMAS FOI LÁ NO CEMITÉRIO\r\nQUE SEU TREME TERRA\r\nDESCARREGOU', 21, 'Sustentação', NULL, NULL),
(214, 2, 'Na praia deserta eu vi\r\nExu\r\nO meu corpo tremeu todo (2x)\r\nArriei o seu marafo\r\nSaravei Exu do Lodo\r\nArriei o seu charuto\r\nSaravei Exu do Lodo;', 21, 'Sustentação', NULL, NULL),
(215, 2, 'É uma casa de pombo (bis)\r\nÉ de pomba gira\r\nAuê auê auê auá (bis).', 26, 'Sustentação', NULL, NULL),
(216, 3, 'Dói, dói, dói, dói, dói\r\nUm amor faz sofrer\r\nDois amores fazem chorar /2x\r\n\r\nNo tempo em que ela tinha dinheiro\r\nOs homens queriam lhe amar\r\nMas hoje o dinheiro acabou\r\nA velhice chegou e ela se põe a chorar\r\n\r\nDói, dói, dói, dói, dói\r\nUm amor faz sofrer\r\nDois amores fazem chorar /2x\r\n\r\nTe dei amor\r\nTe dei carinhos\r\nTe dei uma rosa\r\nE tirei os espinhos /2x\r\n\r\nDói, dói, dói, dói, dói\r\nUm amor faz sofrer\r\nDois amores fazem chorar /2x\r\n', 26, 'Sustentação', NULL, NULL),
(217, 2, 'Escorreguei na lama Exu do Lodo Apareceu \r\nSorte lhe encontrar amigo o prazer é todo meu \r\nEle vem da lama ele vem da mata escura \r\nVem levanta a macumba, vem levanta a macumba \r\nEle gira na encruza, mato, praia e na calunga ', 21, 'Chamada', NULL, NULL),
(218, 3, 'Maria Mulambo você é a flor mais bela\r\nÉ Deus no céu e você aqui na Terra \r\nDe braços abertos ela é minha fé \r\nComo é formosa essa mulher\r\nEu vou cantar, eu vou louvar\r\nEssa morena da cor de Jambo \r\nComo é tão linda a Maria Mulambo', 26, 'Sustentação', NULL, NULL),
(219, 2, 'A SETE SAIAS VEM DESCENDO A SERRA\r\nTRAZENDO PINGA PRO EXU TOMAR\r\n\r\nELA É CASADA, É NAMORADEIRA\r\nA SETE SAIAS NO TERREIRO É QUIMBANDEIRA /2x\r\n\r\nPOMBAGIRA SETE SAIAS \r\nMULHER DE SEU TRANCARUA\r\nQUANDO BEBE FICA LOUCA\r\nTIRA A ROUPA E SAI PARA A RUA \r\nSHALAIA É A POMBAGIRA\r\nSHALAIA É A SETE SAIAS', 26, 'Chamada', NULL, NULL),
(220, 3, 'EU VOU CHAMAR\r\nSEU GIRA MUNDO NA ENCRUZA\r\nEU VOU CHAMAR\r\nQUE ELE VEM ME AJUDAR \r\nELE ME DISSE\r\nQUANDO PRECISAR CHAME\r\nTO LHE CHAMANDO \r\nELE VAI VIM ME AJUDAR \r\nTEM MUITAS PEDRAS\r\nATRAPALHANDO MEUS CAMINHOS\r\nTEM MUITOS NÓS\r\nQUE É PRECISO DESATAR\r\nEU TENHO FÉ E SEI QUE NÃO ESTOU SOZINHO\r\nSEU GIRA MUNDO\r\nELE VEM ME AJUDAR\r\nME COBRE COM SUA CAPA\r\nME LIVRE DE TODO MAL\r\nME ABRA MEUS CAMINHOS\r\nPARA QUE EU VENÇA NO FINAL ', 21, 'Chamada', NULL, NULL),
(221, 3, 'Madalena mora num caixão de veludo \r\nQue um dia foi enterrada numa cova fria\r\nTem sete vidas sete fôlegos de gato \r\nA famosa Madalena hoje é chamada de Farrapo', 21, 'Sustentação', NULL, NULL),
(222, 3, 'Olhando a imensidão do mar em noite calma de estrelas eu encontrei você majestoso e soberano tu es o homem do mar .\r\nCai a noite na terra ooh cai a noite no mar e na calunga grande EXU PIRATA vem trabalhar .\r\nEXU PIRATA guardião do mar fez o seu trono na areia e vem saudar sua mãe sereia . Para chegar até aqui oooh longo caminho percorreu mostrando a fé e a verdade sua coroa recebeu .', 21, 'Sustentação', NULL, NULL),
(223, 3, 'Sua gargalhada ecoa na madrugada, \r\na dona figueira não é cinza ela é prata\r\nCom sol ou lua nós vamos com fé, \r\na dona figueira está pro que der e vier\r\n\r\nTá pro que der e vier, ta pro que der e vier, \r\nnão mexa com a figueira brincadeira ela não é\r\nTransforma espinho em rosas, se fores merecedor, \r\nna barra da sua saia ninguém nunca encostou\r\nLabareda de fogo queima é o aviso que ela dá, \r\nquem quer caminhos floridos com ela não vai brincar\r\nTá pro que der e vier, ta pro que der e vier, não mexa com a figueira brincadeira ela não é', 26, 'Chamada', NULL, NULL),
(224, 2, 'À meia noite,\r\nAo cair da madrugada,\r\nGalo canta, é a alvorada\r\nPia itatuité.\r\nNem sei de onde começou a caminhada:\r\nEncruza, calunga, estrada…?\r\nVenha de onde vier\r\nEle é o mago, o senhor das oferendas,\r\nO homem das velhas lendas\r\nQue fazem o sague gelar;\r\nEle é o bruxo que faz cura, faz feitiço,\r\nEm macumba de catiço.\r\nIna Ina Mojubá!\r\nExu Marabô.\r\nExu Marabô ôh ôh\r\nExu Marabô\r\nExu Marabô\r\nEle, Elebara.\r\nEle Alarô\r\nExu Marabô', 21, 'Chamada', NULL, NULL),
(225, 3, 'Olha quem chegou pra trabalhar \r\nCaminhando veio daquela porteira \r\nTrazendo o feitiço no olhar \r\nEla não é de brincar \r\nEla é Rosa Caveira\r\nPombogira com andar tão sensual \r\nAbre todos os caminhos,\r\nPra quem não fizer o mal,\r\n Sua morada é embaixo de uma figueira \r\nSe o perigo aparecer, \r\nchame por rosa Caveira....\r\n\r\nOlha quem chegou pra trabalhar \r\nCaminhando veio daquela porteira \r\nTrazendo o feitiço no olhar \r\nEla não é de brincar \r\nEla é Rosa Caveira', 26, 'Chamada', NULL, NULL),
(226, 3, 'Deu meia noite na calunga.\r\nA catatumba gemeu.\r\nDeu meia noite na calunga.\r\nA catatumba gemeu.\r\nOlha quem vem lá no cruzeiro.\r\nJoão caveira apareceu.\r\nOlha quem vem lá no cruzeiro.\r\nJoão caveira apareceu.\r\n\r\nRisca risca risca ponto, na folha da bananeira.\r\nJoão caveira e homem serio e não de brincadeira.\r\nRisca risca risca ponto, na folha da bananeira.\r\nJoão caveira é homem serio e não é de brincadeira.\r\n\r\nOrdenança de Atotô e também de Omulu.\r\nCemitério é coisa serio e não é pra qualquer um.\r\nSaravando com pipocas, pra suas chagas curar.\r\nJoão caveira é curador e ele vem pra te ajudar.\r\nSaravá João Caveira guardião de todas almas.\r\nEle é Exu Odara e nele posso confiar. \r\nDeu meia noite na calunga a catatumba gemeu, olha quem vem La no cruzeiro João caveira apareceu.\r\n', 21, 'Chamada', NULL, NULL),
(227, 4, 'Exu vai pelo pé, pelo pé, exu vai pela mão, pela mão\r\nExu já vai embora, olha a banda com banda Exu vai só\r\nExu vai pelo pé, pelo pé, exu vai pela mão, pela mão\r\nExu já vai embora, olha a banda com banda Exu vai só\r\n\r\nExu já comeu, Exu já bebeu, agora quem manda na banda sou eu\r\nMas seu exu pra que tanta demora, dona da casa diz que é hora é hora é hora\r\nExu já comeu, Exu já bebeu, agora quem manda na banda sou eu\r\nMas seu exu pra que tanta demora, dona da casa diz que é hora é hora é hora\r\nExu já comeu, Exu já bebeu\r\nAgora quem manda na banda sou eu\r\n\r\nMas seu exu pra que tanta demora \r\ndona da casa diz que é hora é hora é hora\r\n', 21, 'Subida', NULL, NULL),
(228, 1, 'É Mirim, é Mirim, é Mirim\r\nÉ Mirim, Pirim Pim Pim! }bis\r\n\r\nPisa no Galho\r\nPisa no Toco\r\nTira encrenca\r\nTira sufoco! }bis', 22, 'Sustentação', NULL, NULL),
(229, 1, 'O garfo do Mirim é forte,\r\nO galo do Mirim me rodeia.\r\nA meia noite na encruzilhada, dando a sua gargalhada \r\nExu Mirim não bambeia\r\nNão bambeia, não bambeia\r\nExu Mirim é um Exu que não bambeia', 22, 'Chamada', NULL, NULL),
(230, 1, 'Exu Mirim e caixa de marimbondo, Exu Mirim e caixa de marimbondo\r\nbate o pé, \r\nou bate a mão,\r\nsai rolando pelo chão\r\n', 22, 'Sustentação', NULL, NULL),
(231, 3, 'Pombogira traz ouro\r\nPombogira traz prata\r\n\r\nSem pombogira não se faz nada\r\n', 26, 'Sustentação', NULL, NULL),
(232, 3, 'Ela gosta de Amarelo\r\né ouro que ela quer\r\n\r\nBrilha no sol\r\nBrilha na lua\r\né ouro achado\r\nno meio da rua /2x\r\n', 26, 'Sustentação', NULL, NULL),
(233, 3, 'Naquela estrada\r\ntem uma roseira\r\n\r\nNa bananeira eu plantei uma caveira\r\nAs onze horas você pode passar lá\r\nmas a meia noite a Viuva negra vai estar lá.', 26, 'Chamada', NULL, NULL),
(234, 3, 'Naquela estrada\r\ntem uma roseira\r\n\r\nNa bananeira eu plantei uma caveira\r\nAs onze horas você pode passar lá\r\nmas a meia noite a Viuva negra vai estar lá.', 26, 'Chamada', NULL, NULL),
(235, 3, 'Estava sentado\r\nNuma mesa da Jurema\r\nAfirmei meu ponto\r\nE balancei o maracá\r\nEu saudei foi a Jurema Preta\r\nSeu José Pelintra\r\nDê um tombo e venha cá ', 24, 'Chamada', NULL, NULL),
(236, 3, 'Malandro te digo meu irmão\r\nQue essa nega mexeu com meu coração \r\n\r\nEu hoje vou subir lá na favela\r\nVou dizer ao marido dela\r\nQue eu me apaixonei por ela\r\nMalandro eu posso até correr perigo\r\nMas se eu descer o morro\r\nA nega desce comigo', 24, 'Sustentação', NULL, NULL),
(237, 3, 'Malandro se na minha cara der\r\nPode fazer testamento e se despedir da mulher \r\n\r\nSe tiver filho deixa uma recordação \r\nCara que mamãe beijou vagabundo nenhum põe a mão ', 24, 'Sustentação', NULL, NULL),
(238, 2, 'Pode me chamar de covarde\r\nMas não abandono essa mulher \r\nIsso não é mulher, é uma tentação \r\nIsso não é mulher, é uma tentação \r\nEla joga baralho, \r\nEla puxa a navalha,\r\nRisca a faca no chão ', 24, 'Chamada', NULL, NULL),
(239, 3, 'Oi, Zé quando vier de Alagoas\r\nToma cuidado, oi Zé com o balanço da canoa\r\nOi, Zé faça o que quiser\r\nSó não maltrate o coração desta mulher\r\nOi, Zé faça o que quiser\r\nSó não maltrate o coração desta mulher', 24, 'Chamada', NULL, NULL),
(240, 3, 'O morro de Santa Teresa está de luto\r\nPorque Zé Pilintra morreu\r\nEle chorava, por uma mulher\r\nQue não lhe amava', 24, 'Sustentação', NULL, NULL),
(241, 3, 'Quando eu venho descendo o morro\r\nA nega pensa que eu vou trabalhar\r\nEu boto meu baralho no bolso\r\nCastiçal no pescoço e vou pra Barão de Mauá\r\nTrabalhar, trabalhar\r\nTrabalhar pra que\r\nSe eu trabalhar eu vou morrer', 24, 'Sustentação', NULL, NULL),
(242, 3, 'Às quatro da madrugada\r\nEla me acorda e eu não quero nada\r\nMas qualquer dia eu quebro esse seu despertador\r\nMas trabalhar eu não vou', 24, 'Sustentação', NULL, NULL),
(243, 3, 'LEVA FÉ, LEVA FÉ NESSE HOMEM\r\nQUE ESSE HOMEM É DE AJUDAR\r\nVOCÊ PODE GRITAR POR SEU NOME\r\nTODA VEZ QUE PRECISAR\r\n\r\nLEVA FÉ, LEVA FÉ NESSE HOMEM\r\nQUE ESSE HOMEM É DE AJUDAR\r\nVOCÊ PODE GRITAR POR SEU NOME\r\nTODA VEZ QUE PRECISAR\r\n\r\nSALVE A SUA BATUCADA, SOB A LUZ DA LUA\r\nN’UMA LINDA MADRUGADA\r\nNAS ESQUINAS PELAS RUAS\r\nE NO SEU SAMBA TEM MUITA CERVEJA , TEM MUITA MULHER\r\nMAS TAMBÉM TEM CARIDADES\r\nQUE ELE PRESTA A QUEM QUISER\r\n\r\nÉ POIS É BATE PALMA NO SAMBA DO SEU ZÉ\r\nCANTA FORTE MINHA GENTE\r\nQUE ESSE SAMBA É DE FÉ\r\nÉ POIS É BATE PALMA NO SAMBA DO SEU ZÉ\r\nCANTA FORTE MINHA GENTE\r\nQUE ESSE SAMBA É DE FÉ\r\n\r\nSE NO TEU CAMINHAR ENCONTRAR ALGUM PERIGO\r\nCHAMA O SEU ZÉ QUE ELE PASSA CONTIGO ELE TEM MUITA FORÇA, ELE TEM MUITO AXÉ\r\nELE CHEGA NA UMBANDA, GINGANDO, CANTANDO E SAMBANDO NO PÉ\r\nTODO DE BRANCO VEM MALANDREANDO E AJUDANDO A QUEM TEM FÉ\r\n\r\nSARAVÁ SEU ZÉ\r\nÊ, SARAVÁ SEU ZÉ, SEU ZÉ\r\nÊ SARAVÁ SEU ZÉ\r\nSARAVÁ SEU ZÉ NA UMBANDA E SALVE A FORÇA DA FÉ', 24, 'Chamada', NULL, NULL),
(244, 3, 'EU VI SEU ZÉ PILINTRA\r\nFALANDO COM A SETE SAIAS\r\nMOÇA BONITA E VALENTE\r\nMULHER QUE TANTO TRABALHA\r\n\r\nAH IA IA\r\nEU VI SEU ZÉ PILINTRA [2X]', 24, 'Sustentação', NULL, NULL),
(245, 3, 'Vi eu vi\r\nDe vermelho e branco descendo a ladeira\r\nCom ginga de malandro e mestre em capoeira\r\nFoi na roda de samba onde ele viveu\r\nE onde até hoje vivi o Zé.. O Zé\r\n\r\nTeve muitas mulheres e muitos amigos\r\nMas foi homem valente diante dos perigos\r\nDo corte da navalha camisa de seda o livrou\r\nMas foi pego pelas mandingas do amor    (2x)\r\n\r\nO Zé, ooo Zé\r\nNunca vi um malandro ser enganado por uma mulher (O Zé)\r\nO Zé, ooo Zé\r\nNunca vi um malandro ser enganado por uma mulher', 24, 'Sustentação', NULL, NULL),
(246, 3, 'Chegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.\r\nEle e malandro andarilho, que vive nas madrugas.\r\nEm bares, esquinas onde faz suas jogadas.\r\nMalandro que é malandro sempre joga pra ganhar.\r\nNas jogadas da vida sei que vai me ajudar.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé...\r\nQuando chega no terreiro. \r\nEsse mestre juremeiro é bom trabalhador.\r\nDizem que é o rei da vadiagem.\r\nMas da vida torta muita gente ele tirou.\r\nPor isso nele eu confio.\r\nEntrego meu caminho.\r\nPeço a ele o que eu quiser.\r\nPois as riquezas da vida desse homem.\r\nSó eram duas. Cerveja e mulher.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.\r\nQuando chega no terreiro. \r\nEsse mestre juremeiro é bom trabalhador.\r\nDizem que é o rei da vadiagem.\r\nMas da vida torta muita gente ele tirou.\r\nPor isso nele eu confio.\r\nEntrego meu caminho.\r\nPeço a ele o que eu quiser.\r\nPois as riquezas da vida desse homem.\r\nSó eram duas. Cerveja e mulher.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.\r\nChegou a hora!! \r\nVamos saravar esse homem é de fé, é de fé,é de fé.\r\nChegou a hora. Aí vem Zé Pretinho trazendo seu axé.', 24, 'Chamada', NULL, NULL),
(247, 1, 'Lá vem Zé, la vem Zé\r\nLá vem Zé la da Jurema\r\nLá vem Zé, la vem Zé\r\nLá vem Zé do Juremá               (2x)\r\n\r\nZé Pilintra desce o morro de Santa Isabel malandreado\r\nCom seu copo de cerveja, o cigarro e seu chapéu de lado\r\nNa boca de quem não presta Zé Pilintra é vagabundo\r\nNão teve pai não teve mãe foi criado pelo mundo.\r\n\r\nLá vem Zé, la vem Zé\r\nLá vem Zé la da Jurema\r\nLá vem Zé, la vem Zé\r\nLá vem Zé do Juremá               (2x)\r\n\r\nNascido em alagoas, foi criado na Bahia\r\nPor onde ele passava mulher sempre ele tinha\r\nCerta noite caminhando uma nega ele encontrou\r\nEstava tão machucada mesmo assim ele ajudou.\r\n\r\nLá vem Zé, la vem Zé\r\nLá vem Zé la da Jurema\r\nLá vem Zé, la vem Zé\r\nLá vem Zé do Juremá               (2x)\r\n\r\nO tempo foi se passando e a nega melhorou\r\nE por José Pilintra a Maria Padilha se apaixonou\r\nUm amor inexplicável que ninguém viu nada igual\r\nE foi graças a Rosinha que chegou ao seu final.\r\n\r\nLá vem Zé, la vem Zé\r\nLá vem Zé la da Jurema\r\nLá vem Zé, la vem Zé\r\nLá vem Zé do Juremá               (2x)\r\n\r\nEm meados de agosto a notícia aconteceu\r\nFoi naquele dia 14, Zé Pilintra faleceu\r\nUma morte tão covarde foi pego na traição\r\nA facada foi nas costas e acertou seu coração', 24, 'Chamada', NULL, NULL),
(248, 3, 'Seu Zé Pelintra onde é que o senhor mora ?\r\nSeu Zé Pelintra onde é sua morada? \r\nEu não posso te dizer, por que você não vai me compreender ... \r\nEu nasci no Juremá, minha morada é bem pertinho de Oxalá', 24, 'Sustentação', NULL, NULL),
(249, 3, 'Zé pelintra é cabra enganador\r\nZé pelintra é cabra enganador \r\nenganou a filha dele com palavras de amor\r\nenganou a filha dele com palavras de amor\r\n\r\nnão foi eu\r\nFoi ela quem me enganou }bis\r\n\r\nEu passava ela gritava\r\nZé pelintra meu amor }bis\r\n\r\nFoi eu quem roubei o pau, foi eu que fiz a jangada\r\nFoi eu quem roubei a moça\r\ne casei na encruzilhada }bis', 24, 'Sustentação', NULL, NULL),
(250, 3, 'Levei chumbo de espingarda \r\nNavalhada de outro Zé\r\nMuita paulada de guarda\r\nmais o que mata é mulher\r\nA policia eu despacho \r\nNavalho foi de raspão\r\nO chumbo acertou o braço \r\nE a mulher o coração \r\n\r\nSou o mestre Zé Pilintra\r\nSou Boêmio, sou malandro\r\nSe aqui houver demanda\r\nMeu chapéu eu vou tirando\r\n\r\nVenho lá de Aruanda\r\nSou doutro do Catimbó \r\nMulher tive mais trinta\r\nMais minh\'alma anda só', 24, 'Sustentação', NULL, NULL),
(251, 3, 'Seu zé pelintra chorou, chorou /2x\r\n\r\nPorque teve de brigar com seu filho por amor /2x\r\n\r\nAmor danado que maltrata como ninguém /2x\r\n\r\nZé pelintra quis navalha\r\nZé pretinho quis também /2x\r\n', 24, 'Sustentação', NULL, NULL),
(252, 5, 'É mirim mirim mirm\r\nQuebrando demanda com sorriso no rosto /2x\r\n\r\nÉ exu mirim que vem chegando agora /2x\r\n\r\nÉ Faísca\r\nÉ Cobrinha\r\nÉ Risadinha\r\nQue vem chegando agora', 22, 'Chamada', NULL, NULL),
(253, 2, 'Senhores mestres desse mundo\r\ne de outros mundos também /2x\r\n\r\nSalve o povo da encruzilhada\r\no povo da calunga e da figueira também /2x', 21, 'Chamada', NULL, NULL),
(254, 2, 'Agora eu quero ver o povo da terra de Ganga /2x\r\n\r\nGanga ê ganga\r\nPovo da terra de Ganga /2x', 21, 'Chamada', NULL, NULL),
(255, 2, 'A Laroyê povo de guerra /2x\r\nMarabô chegou, chegou nessa terra /2x\r\n\r\nA Laroyê povo de guerra /2x\r\n(Nome de exu) chegou, chegou nessa terra /2x', 21, 'Chamada', NULL, NULL),
(256, 2, 'Foi numa estrada velha\r\nna subida de uma serra\r\nNuma noite de luar, de luar, de luar\r\n\r\nPombogira da Figueira\r\nmoça bela e faceira\r\ndava o seu gargalhar porque\r\n\r\nEla é mojubá /4x', 26, 'Chamada', NULL, NULL),
(257, 3, 'Chorei, chorei\r\nO homem que eu amava eu matei /2x\r\n\r\nMatei com 7 facadas\r\nEm cima do coração\r\nSou pombogira Menina\r\nNão aceito traição /2x\r\n', 26, 'Sustentação', NULL, NULL),
(258, 2, 'Mas que caminho tão escuro\r\nQue vem passando aquela moça (bis)\r\nCom vestidinho de chita\r\nEstalando osso, osso por osso (bis)\r\nMas a pomba gira é a tatá molambo\r\nMas ela é a pomba gira é a tatá molambo\r\nCom vestidinho de chita\r\nEstalando osso, osso por osso\r\nCom vestidinho de chita\r\nEstalando osso, osso por osso.', 26, 'Chamada', NULL, NULL),
(259, 3, 'Maria Mulambo\r\nEla mereceu ganhar\r\nGanhar o que ganhou\r\nForam sete rosas na calunga\r\nSete marafos\r\nE uma saia de cetim\r\nE como tudo isso não bastasse\r\nEla ganhou uma coroa de atotô\r\nAtotô meu pai atotô meu senhor\r\nMaria Mulambo mereceu o que ganhou.\r\n', 26, 'Sustentação', NULL, NULL),
(260, 2, 'Ela é da lixeira, ela é da pá virada\r\nMaloqueira da lixeira, ela é da pá virada\r\n\r\nEla é Maria Mulambo e não me deve nada\r\nEla é Maria Mulambo e não me deve nada /2x\r\n\r\nOlha do luxo ao lixo, do trapo ao pó\r\nEla é Maria Mulambo, ela é um farrapo só\r\nEla é Maria Mulambo, ela é um farrapo só /2x\r\n', 26, 'Sustentação', NULL, NULL),
(261, 2, 'Mulambo você me falou\r\nFalou que gostava de mim /2x\r\n\r\nMulambo quando você for embora, quando você for embora\r\nDeixe uma rosa pra mim /2x', 26, 'Sustentação', NULL, NULL),
(262, 2, 'Tem cadeado debaixo de sua cama\r\nE a sua cama ela é feita de madeira /2x\r\n\r\nMadeira velha, madeira nova\r\na morada da Mulambo é por debaixo da cova', 26, 'Sustentação', NULL, NULL),
(263, 2, 'Dizem que a Mulambo vem do lixo\r\nCom sua saia cheia de nó /2x\r\n\r\nEm cada nó ela traz um inimigo\r\nQuem mexer com a Mulambo\r\nTa mexendo com o perigo', 26, 'Sustentação', NULL, NULL),
(264, 2, 'É mal de amor\r\nÉ mal de amor\r\nMaria bebe﻿ todas pra curar a minha dor X2\r\n\r\nMulambo tira da solidão\r\nVou te levar pra casa pra ganhar seu coração x2\r\n\r\nÉ mal de amor\r\nÉ mal de amor\r\nMaria bebe todas pra curar a minha dor\r\n\r\nAmanheceu ela vai pra casa\r\nToda embriagada por causa do amor x2\r\n\r\nÉ mal de amor\r\nÉ mal de amor\r\nMaria bebe todas pra curar a minha dor\r\n\r\nMulambo tira da solidão\r\nVou te levar pra casa pra ganhar seu coração x2\r\n\r\nÉ mal de amor\r\nÉ mal de amor\r\nMaria bebe todas pra curar a minha dor X2\r\n\r\nAmanheceu ela vai pra casa\r\nToda embriagada por causa do amor x2\r\n\r\n', 26, 'Sustentação', NULL, NULL),
(265, 2, 'É segunda feira, eu vou\r\npro casamento de rosa caveira,\r\nQue vai ser a meia noite em ponto\r\nem uma capela feita de madeira.\r\nMandei chamar seu omolu, pra cerimônia vir rezar.\r\nA capela toda enfeitada, com um chão de flores para ela entrar\r\n\r\nA catacumba se abriu e até o chão tremeu\r\nCom as sete badaladas que o sino deu\r\nVem anunciando, que ela vem ai\r\nA corte convidada, dama da noite com seu tiriri\r\nEu pensei que eles não vinham,foi o que eu falei\r\n\r\nTomei um tapa na minha cara\r\npois eu vi a rainha com o exu rei\r\nQuem vem vindo ai, veja quem chegou\r\nCom sua roupa em escamas douradas\r\nera a da praia com seu marabô\r\n\r\nEu até me assustei, quando olhei para a esquina\r\nVinha chegando o exu maré\r\nbem acompanhado de sua menina\r\nA festa foi ficando boa e o tempo foi passando.\r\nMaria mulambo e exu do lodo, era mais\r\num casal que vinha chegando\r\n\r\nExu morcego bebeu todas e o convite não chegou lá em casa,\r\nNós viemos assim mesmo, eu sou\r\na milongueira e esse é o exu brasa\r\nE nesse momento a confusão aconteceu\r\nRosa caveira ficou na mão, porque o seu noivo desapareceu\r\n\r\nOs irmãos da noiva, joão caveira e o caveirinha\r\nForam correndo atrás do noivo que estava fugindo com a \"maria\"\r\nO malandro entrou na favela, pulando telhados muros e janelas.\r\nFeito fumaça ele sumiu no ar, mais uma noiva ele deixou no altar\r\nDizem por ai que ele é José, usa um terninho branco que danado que ele é', 26, 'Sustentação', NULL, NULL),
(266, 2, 'Padilha quem descobriu\r\nSegredo não revelado\r\nNo meio do cemitério\r\nAonde um corpo foi enterrado\r\n\r\nSe passaram vários anos\r\no caixão ainda lacrado\r\nQue o defunto virou pó\r\nAs más linguas já vem falado\r\n\r\nAí que mora o mistério\r\nMagia não é brincadeira\r\nPombo gira invocava\r\npor Tata Caveira\r\n\r\nLevanta ae Tata\r\nLevanta ae Tata\r\nVem dançar no fogo\r\nCom Maria Padilha\r\n', 26, 'Chamada', NULL, NULL),
(267, 3, 'SE QUISER ME VER\r\nSUBA NO BARRANCO ZÉ\r\n\r\nO HOMEM É\r\nTRANCA-RUA DE EMBARÉ [2X]', 21, 'Sustentação', NULL, NULL),
(268, 3, 'O VENTO QUE TE TROUXE\r\nÉ O QUE SOBROU LÁ DA CALUNGA\r\nELA FIRMOU SEU PONTO\r\nNAS SETE CATACUMBAS (2X)\"\r\n\r\nMÃE OXUM LHE FEZ RAINHA\r\nOMULU A COROOU \r\nPAI OGUM CORTOU DEMANDAS\r\nPOR ONDE ELA PASSOU\r\nGALO CANTA À MEIA-NOITE\r\nPRA DIZER QUEM ELA É ?\r\nELA É MARIA DE JOB\r\nSARAVÁ EXU MULHER\r\nVESTINDO PRETO E DOURADO\r\nMORENA DA COR DE JAMBO\r\nQUANDO CHEGA NO TERREIRO\r\nSE DIZ MARIA MULAMBO\r\n\r\nO MULAMBO O MULAMBO\r\nME DÊ SUA PROTEÇÃO \r\nE ME GUIA POR ONDE EU ANDO\r\nO MULAMBO O MULAMBO\r\nVEM NO SOM DO MEU TAMBOR\r\nQUE A BANDA TÁ LHE CHAMANDO(2X)\r\n', 26, 'Chamada', NULL, NULL),
(269, 3, 'Meu pai que barulho é esse?\r\nQue vem lá daquela Mata\r\n\r\nA boiada vai subindo e o vento vai zunindo\r\n\r\nQuem é que ele é?  Ele é Boiadeiro da Jurema, Ele é Boiadeiro da Jurema', 18, 'Chamada', NULL, NULL),
(270, 3, 'XÔ, XÔ, XÔ ANDORINHA\r\nSAIA DO MEIO DA ESTRADA\r\n\r\nAÍ VEM SEU BOIADEIRO TOCANDO A SUA BOIADA', 18, 'Chamada', NULL, NULL),
(271, 4, 'Me chamo Laço de Ouro.\r\nBoiadeiro de Oxum,\r\nBoi Bravo eu amanso no braço\r\nNo laço eu carrego Egun', 18, 'Sustentação', NULL, NULL),
(272, 2, 'Seu boiadeiro por aqui choveu\r\nSeu boiadeiro por aqui choveu\r\nChoveu que água rolou\r\nFoi tanta água que seu boi nadou\r\nFoi tanta água que seu boi bebeu\r\nSeu boiadeiro\r\nFoi tanta água que seu boi nadou', 18, 'Sustentação', NULL, NULL),
(273, 3, 'A menina do sobrado\r\nMandou me chamar, pois sou criado\r\nEu mandei dizer a ela\r\nEstou vaquejando o seu gado\r\nSou eu boiadeiro, que gosta de samba arrojado\r\nSou eu boiadeiro oh que gosta de samba arrojado', 18, 'Sustentação', NULL, NULL),
(274, 2, 'Pedrinha miudinha\r\nPedrinha de Aruanda eh\r\nLajedo tão grande\r\nTão grande de Aruanda eh\r\n\r\nUma é maior\r\noutra é menor\r\nMas a pequena que me alumia', 18, 'Sustentação', NULL, NULL),
(275, 4, 'De lá vem vindo\r\nDe lá vem só\r\nDe lá vem vindo a força maior\r\n\r\nDe lá vem vindo seu boiadeiro, de lá vem só\r\nDe lá vem vindo a força maior', 18, 'Chamada', NULL, NULL),
(276, 4, 'Bóia boiadeiro\r\nBoiadeiro bóia }bis\r\n\r\nSe eu contar minha sina\r\nBoiadeiro chora', 18, 'Sustentação', NULL, NULL),
(277, 3, 'Cadê seu boiadeiro\r\nAonde ele ta\r\nEle ta juntando o gado\r\nPara trabalhar\r\n\r\nTange muito gado\r\nCura muita gente\r\nEle é seu boiadeiro\r\nQue cabra valente }bis', 18, 'Chamada', NULL, NULL),
(278, 2, 'Serra de três pontas, \r\nrio de esmeraldas\r\nAjudai ò mãe Senhora eu chegar na minha morada', 18, 'Subida', NULL, NULL),
(279, 2, 'Minha boiada é de 31\r\nmas eu contei só 30\r\noh ta faltando 1', 18, 'Sustentação', NULL, 'Ponto de Boiadeiros - '),
(280, 3, 'De terno branco, seu punhal de aço puro\r\nSeu ponto é seguro quando vem para trabalhar }bis\r\n\r\nOh segura o nego, que esse nego é Ze Pelintra\r\nNa descida do morro, Ele vem trabalhar ', 24, 'Chamada', NULL, NULL),
(281, 3, 'Firmei meu ponto no curral\r\nArmei meu laço e peguei meu alasão\r\n\r\nGibão de couro e perfume da jurema,\r\né na Jurema que busquei minha proteção\r\n\r\nÉ boiadeiro oi /2x\r\né da Jurema /2x\r\n', 18, 'Chamada', NULL, NULL),
(282, 1, 'Oh Zambele pomba branca voou\r\nCaiu na areia babá /2x\r\n\r\nOh zambele baba\r\nOh zambele /2x', 10, 'Sustentação', NULL, NULL),
(283, 3, 'Bahia, que terra boa\r\nNunca vi um rei da Umbanda trabalhar sem sua coroa /2x\r\n\r\nSaravá NOME_DO_BAHIANO\r\nSalve meu pai oxalá\r\nSaravá a estrela guia que ilumina esse congá /2x', 17, 'Sustentação', NULL, NULL),
(284, 2, 'Eu cruzei mata\r\nEu cruzei serra\r\nEu cruzei rio montado em minha égua /2x\r\n\r\nEu me chamo gentileiro\r\nE cheguei aqui agora\r\nQuem quiser falar comigo\r\nvenha que já vou embora', 18, 'Chamada', NULL, NULL),
(285, 3, 'Boa noite para quem é de boa noite\r\nBom dia para quem é de bom dia\r\n\r\nMas eu só quero que Deus me dê\r\numa estrela para iluminar seu dia', 18, 'Sustentação', NULL, NULL),
(286, 3, 'Pisei no tição\r\nEspalhei brasa\r\nquem tem medo de exu não sai de casa /2x\r\n\r\nCandeaeae\r\nExu não bambeia /2x', 21, 'Sustentação', NULL, NULL),
(287, 1, 'Oi zé, oi zé\r\nOi zé da Lagoinha\r\n\r\nOi zé quebra esse nó\r\nOi zé corta essa linha /2x', 24, 'Chamada', NULL, NULL),
(288, 2, 'O relógio do inferno deu hora\r\nEita relóogio para dar hora ligeiro\r\n\r\nCadê, cadê, cadê\r\nCadê João Caveira e seus 7 feiticeiros', 21, 'Chamada', NULL, NULL),
(289, 1, 'Hmmm Hmmm Hmmmm\r\nUma garrafa de rum /2x\r\n\r\nNavio negro brilhou lá no mar\r\nOs piratas já vem trabalhar.', 25, 'Chamada', NULL, NULL),
(290, 3, 'Sacode o pó que chegou Rosa Caveira!\r\nPomba Gira da calunga\r\nVem levantando poeira\r\n\r\nSuas mandingas são\r\nCercadas de mistérios\r\nSaravá a Pomba Gira\r\nQue vem lá do cemitério\r\n\r\nSe diz que faz é melhor não duvidar\r\nPorque a Rosa Caveira\r\nPromete para não faltar\r\n\r\nSacode o pó que chegou Rosa Caveira!\r\nPomba Gira da calunga\r\nVem levantando poeira\r\n\r\nLevo uma rosa quando vou ao seu axé\r\nFalo com Rosa Caveira\r\nPorque nela eu tenho fé\r\n\r\nTudo o que peço nunca me deixou faltar\r\nEla é muito formosa Ena Ena Mojubá\r\n\r\nSacode o pó que chegou Rosa Caveira!\r\nPomba Gira da calunga\r\nVem levantando poeira', 26, 'Chamada', NULL, 'Ponto de Pomba-gira - '),
(291, 4, 'Canindé, Canindé \r\nToma quem pode, toma quem quer /2x\r\n', 32, 'Sustentação', NULL, 'Ponto de Calungueiros - '),
(292, 4, 'Eu tava la na mata, meu chapeu é furadinho\r\nEu tava la na mata, esperando malunguinho\r\n\r\nMalunguinho na mata é rei /4x\r\n', 32, 'Chamada', NULL, 'Ponto de Catimbozeiros - '),
(293, 3, 'VAMOS DEFUMAR, DEFUMA A NOSSA BANDA\r\nCOSME E DAMIÃO, ALEGRIA DAS CRIANÇAS\r\n\r\nTEM COCADA BOA, TEM MANJÁ E TEM PUDIM\r\nDEFUMA NOSSA BANDA COM ARRUDA E ALECRIM', 30, 'Chamada', NULL, 'Ponto de Defumação - Alegria das Crianças\"'),
(294, 3, 'Que lindo cavalo branco\r\nQue aquele menino vem montado\r\n\r\nDescendo aquela serra\r\nDizendo ser filho de um soldado /2x\r\n\r\nÉ Damião, É Damião\r\nÉ Damião no lindo cavalo de Ogum /2x', 23, 'Chamada', NULL, 'Ponto de Ibeijada - '),
(295, 1, 'ELE FOI DOUTOR, ELE FOI DOUTOR, ELE ME CUROU\r\nNUMA BRINCADEIRA ELE ME CUROU, ELE ME CUROU\r\n\r\nERAM TRÊS CRIANÇAS, EU ME LEMBRO BEM\r\nO TERREIRO EM FESTA, ALEGRIA TEM\r\nVIERAM DE UM A UM\r\nERA COSME, DAMIÃO E DOUM', 23, 'Sustentação', NULL, 'Ponto de Ibeijada - '),
(296, 3, 'No mar e e, no mar\r\nEu vi cavaleiro cavalgar sob o luar\r\n\r\nNa beira do mar eu vi\r\nEm seu cavalo branco fiel\r\nOgum erguer sua espada prateada\r\nDar um brado de comando\r\nE um clarão surgiu no céu\r\n\r\nOgum guerreou no Humaitá\r\nCom sua espada travou lutas\r\nContra as forças do mal\r\nOgum cavaleiro de deus\r\nBatalha , vence demanda\r\nPra salvar os filhos teus\r\n\r\nCom sua lança, matou dragão\r\nCom seu escudo nos defendeu\r\nMeu pai ogum trouxe do mar\r\nA luz sagrada dada por Iemanjá\r\n\r\nQuebra as ondas do mar\r\nSopra o vento na terra\r\nPai ogum beira mar\r\nNos protege da guerra', 7, 'Chamada', NULL, 'Ponto de Ogun - Cavaleiro de Deus (Ao Vivo)-vLX_Mc4BtJk.m4a'),
(297, 2, 'Vi um menino,sentado na encruza\r\nperguntei o que é que foi, perguntei o que é que há }bis\r\n\r\nEu vim aqui pra quebrar feitiço\r\nMas pra calunga eu já vou voltar\r\nEu sou Exu-Mirim\r\ne o cemitério é o meu lugar }bis', 22, 'Chamada', NULL, 'Ponto de Exu-mirim - Morada de Exu - Vi Um Menino Sentado na Encruza-rV4xWHtE8NU.m4a'),
(298, 3, 'A lua lá no céu brilhou;\r\nVai bater cabeça pro meu pai Xangô;\r\nOh-oh-oh\r\nA lua era mais forte, clareou;\r\nA lua nasce por detrás da cachoeira;\r\nIluminando pai Xangô lá nas pedreiras;\r\nBate cabeça, filhos de fé;\r\nE peça a Xangô o que quiser.', 31, 'Chamada', NULL, 'Ponto de Bater cabeça - #63 Bater cabeça - A lua lá no céu brilhou-kOJZ6esw2Zo.m4a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `icnt_ritmos`
--

CREATE TABLE `icnt_ritmos` (
  `id` int(11) NOT NULL,
  `ritmo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `icnt_ritmos`
--

INSERT INTO `icnt_ritmos` (`id`, `ritmo`) VALUES
(1, 'Ijexá'),
(2, 'Congo'),
(3, 'Samba'),
(4, 'Nagô'),
(5, 'Barravento'),
(6, 'Ijexá quebrado'),
(7, 'Rufar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `icnt_users`
--

CREATE TABLE `icnt_users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `icnt_users`
--

INSERT INTO `icnt_users` (`id`, `username`, `password`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
);

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_04_18_015219_create_categories_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categories`
--

CREATE TABLE `tb_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wweb_bot_migrations`
--

CREATE TABLE `wweb_bot_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `migration_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

--
-- Extraindo dados da tabela `wweb_bot_migrations`
--

INSERT INTO `wweb_bot_migrations` (`id`, `name`, `batch`, `migration_time`) VALUES
(1, '20230419211456_bot_register_channels.js', 1, '2023-04-19 18:21:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wweb_bot_migrations_lock`
--

CREATE TABLE `wweb_bot_migrations_lock` (
  `index` int(10) UNSIGNED NOT NULL,
  `is_locked` int(11) DEFAULT NULL
);

--
-- Extraindo dados da tabela `wweb_bot_migrations_lock`
--

INSERT INTO `wweb_bot_migrations_lock` (`index`, `is_locked`) VALUES
(1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bot_tb_registered_channels`
--
ALTER TABLE `bot_tb_registered_channels`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `icnt_categoria_linha`
--
ALTER TABLE `icnt_categoria_linha`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `icnt_linha`
--
ALTER TABLE `icnt_linha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ICNT_CATEGORIA_LINHA` (`categoria`);

--
-- Índices para tabela `icnt_pontos`
--
ALTER TABLE `icnt_pontos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ICNT_RITMO_PONTO` (`ritmo`),
  ADD KEY `FK_ICNT_LINHA_PONTO` (`linha`);

--
-- Índices para tabela `icnt_ritmos`
--
ALTER TABLE `icnt_ritmos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `icnt_users`
--
ALTER TABLE `icnt_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wweb_bot_migrations`
--
ALTER TABLE `wweb_bot_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wweb_bot_migrations_lock`
--
ALTER TABLE `wweb_bot_migrations_lock`
  ADD PRIMARY KEY (`index`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bot_tb_registered_channels`
--
ALTER TABLE `bot_tb_registered_channels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `icnt_categoria_linha`
--
ALTER TABLE `icnt_categoria_linha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `icnt_linha`
--
ALTER TABLE `icnt_linha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `icnt_pontos`
--
ALTER TABLE `icnt_pontos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT de tabela `icnt_ritmos`
--
ALTER TABLE `icnt_ritmos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `icnt_users`
--
ALTER TABLE `icnt_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `wweb_bot_migrations`
--
ALTER TABLE `wweb_bot_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `wweb_bot_migrations_lock`
--
ALTER TABLE `wweb_bot_migrations_lock`
  MODIFY `index` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `icnt_linha`
--
ALTER TABLE `icnt_linha`
  ADD CONSTRAINT `FK_ICNT_CATEGORIA_LINHA` FOREIGN KEY (`categoria`) REFERENCES `icnt_categoria_linha` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `icnt_pontos`
--
ALTER TABLE `icnt_pontos`
  ADD CONSTRAINT `FK_ICNT_LINHA_PONTO` FOREIGN KEY (`linha`) REFERENCES `icnt_linha` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ICNT_RITMO_PONTO` FOREIGN KEY (`ritmo`) REFERENCES `icnt_ritmos` (`id`) ON DELETE CASCADE;
COMMIT;

