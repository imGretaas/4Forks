-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Lug 07, 2019 alle 09:25
-- Versione del server: 5.7.26-0ubuntu0.18.04.1
-- Versione PHP: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Prova`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Categorie`
--

CREATE TABLE `Categorie` (
  `Nome` varchar(15) NOT NULL,
  `Gruppo` varchar(15) NOT NULL,
  `Tag` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Categorie`
--

INSERT INTO `Categorie` (`Nome`, `Gruppo`, `Tag`) VALUES
('Alcolici', 'Bevande', 'vino,alcool'),
('Analcolici', 'Bevande', 'smoothie,frullato,succo,latte'),
('Contorni', 'Piatti0Caldi', 'verdura,patate,insalata'),
('Dessert', 'Piatti0Caldi', 'dolce,frutta,cioccolato'),
('Dispensa', 'Bottega', 'farina,taralli,biscotti,olio,spezie'),
('Fornaio', 'Bottega', 'pane,forno,biscotti,farina'),
('Latticini', 'Bottega', 'latte,formaggio,mozzarella'),
('Pizze', 'Piatti0Caldi', 'Calzone,Panzerotto,bruschetta,focacce'),
('Primi0Piatti', 'Piatti0Caldi', 'pasta,risotto,crema,zuppa,riso,primo,pappardelle,trofie,tortellini,gnocchi'),
('Salumeria', 'Bottega', 'salumi,formaggi,latteria'),
('Secondi0Piatti', 'Piatti0Caldi', 'hamburger,carne,secondo');

-- --------------------------------------------------------
--
-- Struttura della tabella `Cliente`
--

CREATE TABLE `Cliente` (
  `Email` varchar(35) NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Cognome` varchar(15) NOT NULL,
  `Datanascita` date NOT NULL,
  `PayPal` tinyint(1) DEFAULT NULL,
  `NCarta` varchar(18) DEFAULT NULL,
  `Scadenza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Cliente (`Email`, `Nome`, `Cognome`, `Datanascita`, `PayPal`, `NCarta`, `Scadenza`) VALUES
('m.rossi@gmail.com', 'Mario', 'Rossi', '1980-01-01', 0, '5342333476234321', '2022-07-07'),
('nile.rodgers@gmail.com', 'Nile', 'Rodgers', '1952-09-19', 1, NULL, NULL),
('mr.white@gmail.com', 'Maurice', 'White', '1961-12-19', 1, NULL, NULL),
('miss.jones@me.com', 'Grace', 'Jones', '1984-05-18', 1, NULL, NULL),
('ggil42@gmail.com', 'Gilberto', 'Gil', '1972-06-24', 0, '4935098078560954', '2022-07-07'),
('diana@ross.com', 'Diana', 'Ross', '1988-03-26', 1, NULL, NULL),
('file@jil.com', 'Jil', 'File', '1978-08-18', 0, '4935674567953291', '2022-07-07'),
('marvin39@gmail.com', 'Marvin', 'Gaye', '1989-04-01', 0, '5342342123420098', '2022-07-07'),
('bedwards@live.it', 'Bernard', 'Edwards', '1952-10-31', 1, NULL, NULL),
('user@user.it', 'Giovanni Giorgio', 'Moroder', '1980-04-26', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `LogghinC`
--

CREATE TABLE `LogghinC` (
  `Nome` varchar(35) NOT NULL,
  `Credenziali` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO LogghinC (`Nome`, `Credenziali`) VALUES
('nile.rodgers@gmail.com', '84a13726d3225267f01856c48489cf0fe2d7d45f3b732a99e76160d470556856'),
('mr.white@gmail.com', '018fa96a44715c90bf93be148069cb28dd45d398f2cc75aa1565311f6e55d174'),
('miss.jones@me.com', 'e010fd1ce1acc173e3b4835b7635f8d4600d774869102adb5cb7b5d7895649ba'),
('diana@ross.com', '85355d38faa576ab658847e5891e5b7c66bc3afee2daf93a406767f59a850367'),
('marvin39@gmail.com', '4b9b8e5acb46ed65e662100690be9effc76c126e49d956433fbf316f74109939'),
('bedwards@live.it', '66f86b1f3c61159b9ad9824e52cd4dbd3d87ab45afcdb60943437e1bc0159433'),
('m.rossi@gmail.com', 'aaef9bed2fddaec6cb8eebe05ece96b542501c55c81540123aca45c062adadb7'),
('ggil42@gmail.com', 'd904ab5adb2884d54c66ec632548461bdbd8d672db67c6d2c152ed14f519ef41'),
('file@jil.com', '3b9c358f36f0a31b6ad3e14f309c7cf198ac9246e8316f9ce543d5b19ac02b80'),
('user@user.it', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb');

/*
Nome e Credenziale
('nile.rodgers@gmail.com', 'rodgers');
('mr.white@gmail.com', 'white');
('miss.jones@me.com', 'grace');
('diana@ross.com', 'diana09');
('marvin39@gmail.com', 'gaye3939');
('bedwards@live.it', 'edwards');
('m.rossi@gmail.com', 'mrossi');
('ggil42@gmail.com', 'ggil');
('file@jil.com', 'file');
*/


-- --------------------------------------------------------

--
-- Struttura della tabella `LogghinV`
--

CREATE TABLE `LogghinV` (
  `Nome` varchar(35) NOT NULL,
  `Credenziali` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `LogghinV`
--

/*
Credenziali Venditori

- honeybee
- panetavola
- pizzel
- ilgelataio
- alfungo
- alberobellopu
- maisonpizza
- smoothievr
- oasipr

*/

INSERT INTO `LogghinV` (`Nome`, `Credenziali`) VALUES
('admin@admin.it', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
('food@honeybee.com', '30cce014727386344ef954b48eaef95010f6a1b65fbb4758890fb272c9470b68'),
('info@dalpaneallatavola.com', '6addc78e94463f1365272461d0475a9d24ca5cf5a2a109c69f75fe8fb7b3c9a9'),
('info@pizzel.com', '2e06b52845e2e5625618f2b739eaaa95838081b4b7a112aeeee10b51be1af5b2'),
('food@ilgelataio.com', 'f9c8b18a9fcd9c50c658a9a8060582d3d44c7336231136441974be5d1fd76ac5'),
('info@trattoriaalfungo.it', 'ab4303ce9d8d3338d32829b370547a25154601a05fc44666b440f4a35111dbbe'),
('bottega@alberobello.it', 'ecce28b9ef243f9f6dc1ae742cfd815246024f23c399af37d6565ef632f03c58'),
('maison@pizza.it', '3c4221fadaa770e9ee29edb27e861b4c486f37044f1620bd2ac473a1c00ccc75'),
('verona@smoothie.it', '2d083635ca631365278b62835e18e2c84a7b84970a490aa6c6a5cd21a699cdd5'),
('oasi@perugina.it', '5da8476a83d7a4a8c9080ddbd82136c37a65f37f48d003d2ccb9c353f22612e8'),
('online@wineshop.it', '32c4feed996880bc92a062dc476f9b8cdb2596a989f2cc5246e9cef605bd5c78');


-- --------------------------------------------------------

--
-- Struttura della tabella `Negozi`
--

CREATE TABLE `Negozi` (
  `Nome` varchar(45) NOT NULL,
  `Email` varchar(35) NOT NULL,
  `Descrizione` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Negozi`
--

INSERT INTO `Negozi` (`Nome`, `Email`, `Descrizione`) VALUES
('Honey0Bee', 'food@honeybee.com', 'Honey Bee &grave; una bakery formata da professionisti, la quale cura l&apos;arte del pane dal 1970. La crew di Honey Bee &grave; costituita da sette bakers specializzati nello sfornare dolci, a base di miele dell&apos;Alto Adige.'),
('Dal0Pane0alla0Tavola', 'info@dalpaneallatavola.com', 'Dal Pane alla Tavola offre numerosi soluzioni da forno sia per la quotidianit&agrave; che per le feste'),
('Pizzel', 'info@pizzel.com', 'Pizzeria tradizionale napoletana d&apos;asporto. Il nostro men&ugrave; prevede diverse categorie di pizze al metro e classiche cucinate con passione per soddisfare ogni tipo di palato.'),
('Il0Gelataio', 'food@ilgelataio.com', 'Il Gelataio &egrave; una gelateria specializzata in dessert freschi, di alta qualit&agrave;, preparati con materie prime di prima scelta e rigorosamente di stagione.'),
('Al0Fungo', 'info@trattoriaalfungo.it', 'Cucina veneta e piatti a base di funghi in intimo locale a conduzione familiare con affreschi degli anni 50.'),
('La0Bottega0di0Alberobello', 'bottega@alberobello.it', 'La Bottega di Alberobello offre prodotti tipici di origine Pugliese, tra i quali tarallini fatti a mano con olio evo, olio tipico, facaccia barese, pasticciotto leccese, orecchiette e latticini.'),
('La0Maison0della0Pizza', 'maison@pizza.it', 'La Maison0della Pizza crea pizze gourmet sfizziose, da gustare in compagnia e solo con ingredienti di prima qualit&agrave;'),
('Smoothie', 'verona@smoothie.it', 'Smoothie di Verona dispone di numerosi smoothie, frullati e mix di frutta fresca di stagione di alta qualit&agrave;'),
('Oasi0del0Cioccolato', 'oasi@perugina.it', 'L&apos;Oasi del cioccolato offre numerosi prodotti dolciari a base di cioccolato, tutti artigianali e da dispensa'),
('Martha0Vandellas', 'admin@admin.it', 'Nella loro cucina, tra mestoli e pentole, Martha And The Vandellas producono i loro deliziosi Primi Piatti'),
('Wine0Shop', 'online@wineshop.it', 'Lo Store Wine Shop dispone di una scelta di vini Italiani certificati');
-- --------------------------------------------------------

--
-- Struttura della tabella `Newsletter`
--

CREATE TABLE `Newsletter` (
  `Email` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `Prodotti`
--

CREATE TABLE `Prodotti` (
  `ID` int(10) NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Inserimento` date NOT NULL,
  `Certificazione` varchar(30) DEFAULT NULL,
  `Prezzo` decimal(5,2) NOT NULL,
  `Raggio` int(7) NOT NULL,
  `Negozio` varchar(35) NOT NULL,
  `Categoria` varchar(15) NOT NULL,
  `Descrizione` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Prodotti`
--

INSERT INTO `Prodotti` (`ID`, `Nome`, `Inserimento`, `Certificazione`, `Prezzo`, `Raggio`, `Negozio`, `Categoria`, `Descrizione`) VALUES
(33, 'Pizza0Margherita', '2019-01-19', 'STG', '12.30', 46, 'Pizzel', 'Pizze', 'Pizza cotta a forno a legna con pomodoro, mozzarella ed un filo di olio evo. Basilico a piacere'),
(34, 'Pizza0Diavola', '2019-01-19', 'DOP', '14.50', 46, 'Pizzel', 'Pizze', 'Pizza cotta a forno a legna, pomodoro, mazzarella e salamino, olio evo'),
(35, 'Pizza0Patatosa', '2019-01-19', 'DOP', '13.70', 46, 'Pizzel', 'Pizze', 'Pizza cotta a forno a legna, pomodoro &lpar;a piacere&rpar;, mozzarella e patate cornette croccanti, olio evo'),
(36, 'Pizza0Capricciosa', '2019-01-19', 'DOP', '15.89', 46, 'Pizzel', 'Pizze', 'Pizza cotta a forno a legna, pomodoro, mozzarella, prosciutto cotto, funghi e carciofi, olio evo'),
(37, 'Pizza0Ortolana', '2019-01-19', 'DOP', '17.90', 46, 'Pizzel', 'Pizze', 'Pizza cotta a forno a legna, pomodoro &lpar;a piacere&rpar;, mozzarella, verdura grigliata di stagione, olio evo'),
(38, 'Calzoncino', '2019-01-19', 'DOP', '19.80', 46, 'Pizzel', 'Pizze', 'Calzone cotto a forno a legna, fior di latte, funghi, pecorino, friarielli'),
(39, 'Focaccia0Al0Metro', '2019-01-19', 'DOP', '14.90', 0, 'La0Maison0della0Pizza', 'Pizze', 'Pizza cotta su pietra, pomodoro, mozzarella, olio evo, basilico'),
(40, 'Focaccia0Al0Rosmarino', '2019-01-19', 'DOP', '12.90', 0, 'La0Maison0della0Pizza', 'Pizze', 'Pizza bianca cotta su pietra, olio evo e rosmarino'),
(41, 'Pizza0Fantasia', '2019-01-19', 'DOP', '9.80', 0, 'La0Maison0della0Pizza', 'Pizze', 'Tagliere di bruschettine cotte a forno a legna con materie prime di stagione, olio evo'),
(42, 'Pizza0Gamberi0Gourmet', '2019-01-19', 'IGT', '35.00', 0, 'La0Maison0della0Pizza', 'Pizze', 'Focaccia cotta su pietra con gambero di Mazara'),
(43, 'Pizza0Gourmet0Classica', '2019-01-19', 'IGT', '30.00', 0, 'La0Maison0della0Pizza', 'Pizze', 'Jamon Iberico de Bellota Capa Negra Riserva &lpar;fiordilatte, stracchino delle Pertiche e rucoletta&rpar;'),
(44, 'Calzone0Tartufino', '2019-01-19', 'DOP', '23.70', 0, 'La0Maison0della0Pizza', 'Pizze', 'Calzone con tartufo pregiato e speck'),
(45, 'Pane0Di0Altamura', '2019-01-19', 'IGP', '7.90', 0, 'Dal0Pane0alla0Tavola', 'Fornaio', 'Pane fresco di Altamura 500gr'),
(46, 'Biscotti0Ai0Fiocchi0Dorati', '2019-01-19', 'DOP', '3.80', 0, 'Honey0Bee', 'Fornaio', 'Biscottini a base di fiocchi d avena e miele 250gr'),
(47, 'Dolce0Sofficioso', '2019-01-19', 'DOP', '8.70', 0, 'Honey0Bee', 'Fornaio', 'Morbido plumcake al cioccolato 250gr'),
(48, 'Dolci0Rollini', '2019-01-19', 'SLOW FOOD', '5.80', 0, 'Honey0Bee', 'Fornaio', 'Soffici rolls dolci al miele 250gr'),
(49, 'Dolci0Miele0e0Vaniglia', '2019-01-19', 'DOP', '4.90', 0, 'Honey0Bee', 'Fornaio', 'Cupcake al miele e vaniglia 125gr'),
(50, 'Macedonia', '2019-01-19', 'SLOW FOOD', '6.50', 38, 'Il0Gelataio', 'Dessert', 'Mix di frutta fresca di stagione 180gr'),
(51, 'Gelato0al0Cioccolato', '2019-01-19', 'BIO', '7.50', 0, 'Il0Gelataio', 'Dessert', 'Gelato Artigianale al cioccolato fondente al 60&percnt; con cacao del Madagascar 150gr'),
(52, 'Gelato0alla0Fragola', '2019-01-19', 'BIO', '7.50', 38, 'Il0Gelataio', 'Dessert', 'Gelato Artigianale alla fragola 150gr'),
(53, 'Gelato0Fantasia', '2019-01-19', 'BIO', '19.80', 38, 'Il0Gelataio', 'Dessert', 'Mix di sei gusti di gelato Artigianale 500gr'),
(54, 'Millefoglie0al0Cioccolato', '2019-01-19', 'DOP', '12.80', 38, 'Il0Gelataio', 'Dessert', 'Fragrante sfoglia immersa fra pezzi di cioccolato e crema Chantilly 300gr'),
(55, 'Mousse0al0Cioccolato', '2019-01-19', 'DOP', '9.90', 38, 'Il0Gelataio', 'Dessert', 'Mousse al cioccolato con lamponi di bosco della Transilvania 250gr'),
(56, 'Tiramisu', '2019-01-19', 'STG', '13.80', 38, 'Oasi0del0Cioccolato', 'Dessert', 'Soffice tiramisu con caffe Java 300gr'),
(57, 'Contorno0Caprese', '2019-01-19', 'DOP', '11.90', 0, 'Martha0Vandellas', 'Contorni', 'Pomodoro fresco, mozzarella di Bufala Campana, basilico, olio evo ed origano di Sicilia'),
(58, 'Contorno0Porcini0e0Provola0Affumicata', '2019-01-19', 'DOP', '15.90', 0, 'Martha0Vandellas', 'Contorni', 'Funghi Porcini tagliati a fette, cotti con olio evo, e Provola Affumicata'),
(59, 'Insalata0Arancia0e0Melograno', '2019-01-19', 'BIO', '17.80', 0, 'Martha0Vandellas', 'Contorni', 'Insalata Arancia, Melograna, Spinaci e Avocado'),
(60, 'Contorno0Nidi0di0Patate', '2019-01-19', 'DOP', '6.90', 0, 'Martha0Vandellas', 'Contorni', 'Purea di patate al forno, 10 nidi'),
(61, 'Contorno0Patate0Nocciolate', '2019-01-19', 'DOP', '9.95', 0, 'Martha0Vandellas', 'Contorni', 'Ciotola di patate in crosta di nocciola cotte al forno con olio evo, sale, pepe e rosmarino'),
(62, 'Verdure0al0Vapore', '2019-01-19', 'BIO', '10.20', 0, 'Martha0Vandellas', 'Contorni', 'Tris di verdure cotte al vapore, con sale rosa dell Himalaya&colon; carote, cavolfiore e broccolo romano'),
(63, 'Contorno0Sale0e0Rosmarino', '2019-01-19', 'DOP', '7.15', 0, 'Martha0Vandellas', 'Contorni', 'Patate classiche al forno con sale grosso e rosmarino'),
(64, 'Insalata0Greca', '2019-01-19', 'BIO', '9.00', 0, 'Martha0Vandellas', 'Contorni', 'Insalata greca con feta, lattuga romana, olive e pomodoro tagliato'),
(65, 'Risotto0al0Guanciale0Croccante', '2019-01-19', 'IGP', '17.40', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Risotto con limone, cumino e Guanciale Croccante'),
(66, 'Risotto0Zafferano0Porcini0Nocciole', '2019-01-19', 'IGP', '19.40', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Risotto allo zafferano di montagna, polvere di porcini e nocciole'),
(67, 'Pasta0con0Aragosta', '2019-01-19', 'IGP', '35.00', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Pappardelle fresche, fatte in casa, al sugo di pomodoro fresco ed aragosta mediterranea, per 4 persone'),
(68, 'Pasta0Ligure', '2019-01-19', 'STG', '20.90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Trofie Liguri con Pesto fresco alla Genovese, per 2 persone'),
(69, 'Tortellini0Bolognesi', '2019-01-19', 'IGP', '20.90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Tortellini alla Bolognese in brodo di carne, per 2 persone'),
(70, 'Pasta0Ai0Pomodorini', '2019-01-19', 'BIO', '14,90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Pappardelle con pomodorini ciliegini freschi, basilico e olio evo, per 2 persone'),
(71, 'Gnocchi0al0Rag&ugrave;', '2019-01-19', 'STG', '14.90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Gnocchi di patate con sugo al rag&ugrave;, per 2 persone'),
(72, 'Gnocchi0alla0Zucca', '2019-01-19', 'STG', '15.90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Gnocchi alla zucca con burro fuso, salvia e parmigiano grattugiato, per 2 persone'),
(73, 'Pasta0alla0Campidanese', '2019-01-19', 'DOP', '19.80', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Gnocchetti sardi alla Campidanese, con salsiccia, per 2 persone'),
(74, 'Orecchiette0Pugliesi', '2019-01-19', 'STG', '23.70', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Orecchiette pugliesi con cime di rapa, acciughe e ricotta, per 2 persone'),
(75, 'Ravioli0delle0Alpi', '2019-01-19', 'SLOW FOOD', '17,90', 0, 'Martha0Vandellas', 'Primi0Piatti', 'Ravioli alla carne di cervo con sugo alle noci'),
(76, 'Hamburger0Astice0e0Tartufini0Gourmet', '2019-01-19', 'IGP', '29.80', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Hamburgher con astice, tartufini in salsa, un letto di lattuga fresca. Con contorno di patate nocciolate e funghi porcini'),
(116, 'Hamburger0The0Classic', '2019-01-19', 'DOP', '17.60', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Hamburgher classico con bacon, pomodoro e lattuga. Con contorno di patate al sale e rosmarino'),
(77, 'Hamburger0Hampolpo0Gourmet', '2019-01-19', 'DOP', '18.65', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Hamburger Gourmet con polpo, patate, hummus di ceci e mela fritta. Con contorno di patate al sale e rosmarino'),
(78, 'Polpo0di0Scoglio', '2019-01-19', 'DOP', '25.30', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Polpo di scoglio con melone arrosto, maionese di pomodoro e riduzione al Nepente di Oliena'),
(79, 'Costine0di0Maiale0Glassate', '2019-01-19', 'IGP', '30.80', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Costine di maiale glassate con miele e semi di sesamo, per 2 persone'),
(80, 'Tempura', '2019-01-19', 'IGP', '23.90', 0, 'Martha0Vandellas', 'Secondi0Piatti', 'Tempura di gamberi con ribes, frutti rossi e salsa agrodolce'),
(81, 'Cookies0al0Cioccolato', '2019-01-19', 'SLOW FOOD', '9.00', 0, 'Honey0Bee', 'Fornaio', 'Biscotti di pasta frolla con pepite di finissimo cioccolato al latte salato 250gr'),
(82, 'Focaccia0Genovese', '2019-01-19', 'STG', '11.00', 0, 'Honey0Bee', 'Fornaio', 'Focaccia tipica Genovese con olio evo, sale grosso marino e rosmarino'),
(83, 'Tarallini0Pugliesi', '2019-01-19', 'STG', '8.00', 0, 'Honey0Bee', 'Fornaio', 'Classici tarallini pugliesi con olio evo 350gr'),
(84, 'Taralli0Napoletani', '2019-01-19', 'STG', '9.80', 0, 'Honey0Bee', 'Fornaio', 'Tipici taralli napoletani salati con sugna e mandorle tritate 350gr'),
(85, 'Burrata', '2019-01-19', 'STG', '13.30', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Formaggio fresco pugliese, di latte vaccino, a pasta filata'),
(86, 'Latte0Intero', '2019-01-19', 'BIO', '4.90', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Latte Intero 1L'),
(87, 'Latte0di0Mandorla', '2019-01-19', 'BIO', '5.10', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Latte di Mandorla 1L'),
(88, 'Latte0di0Riso', '2019-01-19', 'BIO', '5.10', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Latte di Riso 1L'),
(89, 'Latte0di0Soia', '2019-01-19', 'BIO', '5.10', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Latte di Soia 1L'),
(90, 'Mozzarella0di0Bufala', '2019-01-19', 'STG', '14.60', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Mozzarella di Bufala Campana, 1 pezzo'),
(91, 'Bocconcini0Di0Bufala', '2019-01-19', 'DOP', '20.45', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Bocconcini di mozzarella di bufala campana, 10 pezzi'),
(92, 'Bocconcini0Di0Latte', '2019-01-19', 'STG', '20.50', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Spiedini di bocconcini di fior di latte, con pomodorini ciliegino, 20 pezzi'),
(93, 'Nodini', '2019-01-19', 'STG', '14.60', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Nodini pugliesi, di fior di latte, a pasta filata, lavorata a mano, 1 pezzo'),
(94, 'Tomino', '2019-01-19', 'STG', '7.90', 41, 'La0Bottega0di0Alberobello', 'Latticini', 'Tomino tipico Piemontese, 1 pezzo'),
(95, 'Smoothie0di0Anguria', '2019-01-19', 'BIO', '7.90', 0, 'Smoothie', 'Analcolici', 'Frullato a base di anguria &lpar;60&percnt;&rpar; e latte intero fresco italiano, 250ml'),
(96, 'Succo0di0Mela', '2019-01-19', 'BIO', '5.30', 0, 'Smoothie', 'Analcolici', 'Acqua, succo di mela &lpar;60&percnt;&rpar; e zucchero, 250ml'),
(97, 'Succo0di0Arancia', '2019-01-19', 'SLOW FOOD', '5.20', 0, 'Smoothie', 'Analcolici', 'Acqua, succo di arancia &lpar;60&percnt;&rpar; e zucchero, 250ml'),
(98, 'Centrifuga0Arancia0e0Carota', '2019-01-19', 'SLOW FOOD', '5.10', 0, 'Smoothie', 'Analcolici', 'Acqua, succo di arancia &lpar;45&percnt;&rpar;, succo di carota &lpar;15&percnt;&rpar; e zucchero, 250ml'),
(99, 'Frullato0di0Banana', '2019-01-19', 'SLOW FOOD', '5.40', 0, 'Smoothie', 'Analcolici', 'Frullato a base di banana &lpar;60&percnt;&rpar; e latte intero fresco italiano, 250ml'),
(100, 'Centrifuga0Pera0e0Rosmarino', '2019-01-19', 'SLOW FOOD', '5.60', 0, 'Smoothie', 'Analcolici', 'Acqua, succo di pera &lpar;58&percnt;&rpar;, aroma al rosmarino &lpar;2&percnt;&rpar; e zucchero, 250ml'),
(101, 'Frullato0di0Pitahaya', '2019-01-19', 'BIO', '6.90', 0, 'Smoothie', 'Analcolici', 'Frullato a base di Pitahaya tropicale &lpar;60&percnt;&rpar; e latte intero fresco italiano, 250ml'),
(102, 'Mix0di0Smoothie', '2019-01-19', 'SLOW FOOD', '18.90', 0, 'Smoothie', 'Analcolici', 'Mix di sei frullati a base di frutta &lpar;60&percnt;&rpar; e latte intero fresco italiano. Gusti variabili di stagione, 250ml per 6 pezzi'),
(103, 'Pasta040Forchette', '2019-03-01', 'IGP', '13.90', 0, 'La0Maison0della0Pizza', 'Primi0Piatti', 'Scialatielli fatti in casa con pomodorini del Piennolo del Vesuvio, basilico ed un filo d’olio evo'),
(104, 'Olio0Dauno', '2019-03-01', 'DOP', '17.90', 0, 'La0Bottega0di0Alberobello', 'Dispensa', 'Olio extravergine d&apos;oliva D.O.P. di origine Garganica'),
(105, 'Olio0della0Terra0di0Bari', '2019-03-01', 'DOP', '19.90', 0, 'La0Bottega0di0Alberobello', 'Dispensa', 'Olio extravergine d&apos;oliva D.O.P. della Terra di Bari'),
(106, 'Olio0delle0Colline0di0Brindisi', '2019-03-01', 'DOP', '18.90', 0, 'La0Bottega0di0Alberobello', 'Dispensa', 'Olio extravergine d&apos;oliva D.O.P. delle Colline di Brinisi'),
(107, 'Olio0della0Terra0Di0Otranto', '2019-03-01', 'DOP', '19.70', 0, 'La0Bottega0di0Alberobello', 'Dispensa', 'Olio extravergine d&apos;oliva D.O.P. di provenienza della Terra d&apos;Otranto'),
(108, 'Pasticciotto0Leccese', '2019-03-01', 'STG', '7.50', 0, 'La0Bottega0di0Alberobello', 'Dolci', 'Dolce tipico Salentino composto da pasta frolla farcita di crema pasticcera e cotto in forno, 125gr'),
(109, 'Pizza0A0Portafoglio', '2019-12-25', 'STG', '4.90', 0, 'La0Maison0della0Pizza', 'Pizze', 'Pizza tipica a portafoglio da passeggio, pomodoro, fior di latte, olio evo'),
(110, 'Friarielli0Classic', '2019-12-25', 'STG', '9.00', 0, 'Pizzel', 'Contorni', 'Friarielli alla napoletana'),
(111, 'Vino0Tignanello', '2019-05-07', 'IGT', '89.00', 0, 'Wine0Shop', 'Alcolici', 'Bottiglia da 750ml di Tignanello annata 2016 Originale'),
(112, 'Vino0Chianti0Classico', '2019-05-07', 'DOCG', '58.00', 0, 'Wine0Shop', 'Alcolici', 'Bottiglia da 750ml di Chianti Classico annata 2011 Originale'),
(113, 'Vino0Brunello0Di0Montalcino', '2019-05-07', 'DOCG', '27.00', 0, 'Wine0Shop', 'Alcolici', 'Bottiglia da 750m di Brunello di Montalcino annata 2017 Originale'),
(114, 'Vino0Barolo0Luxury', '2019-05-07', 'DOCG', '209.99', 0, 'Wine0Shop', 'Alcolici', 'Cofanetto 4 Bottiglie da 750ml di Barolo Cantine Damilano annata 2006 Originale'),
(115, 'Vino0Barbaresco', '2019-05-07', 'DOCG', '43.70', 0, 'Wine0Shop', 'Alcolici', 'Bottiglia da 750ml di Barbaresco Ovello Riserva 2011 Originale'),
(117, 'Farina0di0Soia','2019-05-07','BIO','4.50', 0,'Dal0Pane0alla0Tavola','Dispensa','Pacco di farina di soia da agricoltura biologica 1kg'),
(118, 'Farina0di0Segale','2019-05-07','BIO','4.50', 0, 'Dal0Pane0alla0Tavola','Dispensa','Pacco di farina di segale da agricoltura biologica 1kg'),
(119, 'Spezie0al0Cumino','2019-05-07','BIO', '5.50', 0,'Dal0Pane0alla0Tavola','Dispensa','Porzione di cumino biologico 150gr'),
(120, 'Spezie0alla0Curcuma','2019-05-07','BIO','5.55', 0, 'Dal0Pane0alla0Tavola','Dispensa','Porzione di curcuma biologico 150gr'),
(121, 'Cassetta0di0grissini0olio0evo','2019-05-07','SLOW FOOD', '7.50', 0,'Dal0Pane0alla0Tavola','Dispensa','Cassetta di grissini olio evo, pizza e basilico 350gr'),
(122, 'Prosciutto0di0Parma','2019-05-07','DOP','9.90', 0, 'Al0Fungo', 'Salumeria', 'Porzione di prosciutto crudo di parma da 350gr'),
(123, 'Parmigiano0Reggiano','2019-05-07','DOP','9.90', 0, 'Al0Fungo', 'Salumeria', 'Fetta di Parmigiano Reggiano Stagionato 24 mesi, 350gr'),
(124, 'Provolone0del0Monaco','2019-05-07','DOP','24.80', 0, 'La0Maison0della0Pizza', 'Salumeria', 'Provolone del monaco di origine campana, 1 pezzo da 1kg'),
(125, 'Speck0del0Trentino','2019-05-07','IGP','11.90', 0, 'Al0Fungo', 'Salumeria', 'Speck del trentino, porzione da 300gr'),
(126, 'Capocollo0di0Calabria','2019-05-07','DOP','13.70', 0, 'Al0Fungo', 'Salumeria', 'Capocollo di Calabria D.O.P. da 300gr'),
(127, 'Pizza0Veneta', '2019-08-13','SLOW FOOD','15.90', 45, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(128, 'Pizza0Friulana', '2019-08-13','SLOW FOOD','15.90', 56, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(129, 'Pizza0Lombarda', '2019-08-13','SLOW FOOD','15.90', 46, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(130, 'Pizza0Piemontese','2019-08-13','SLOW FOOD','15.90', 43, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(131, 'Pizza0Emiliana','2019-08-13','SLOW FOOD','15.90', 57, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(146, 'Pizza0Ligure','2019-08-13','SLOW FOOD','15.90', 47, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(132, 'Pizza0Valdostana','2019-08-13','SLOW FOOD','15.90', 58, 'Martha0Vandellas','Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(133, 'Pizza0Laziale','2019-08-13','SLOW FOOD','15.90', 49, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(134, 'Pizza0Toscana','2019-08-13','SLOW FOOD','15.90', 48, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(135, 'Pizza0Marchigiana','2019-08-13','SLOW FOOD','15.90', 50, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(136, 'Pizza0Abruzzese','2019-08-13','SLOW FOOD','15.90', 59, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(137, 'Pizza0Pugliese','2019-08-13','SLOW FOOD','15.90', 37, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(138, 'Pizza0Calabrese','2019-08-13','SLOW FOOD','15.90', 52, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(139, 'Pizza0Campana','2019-08-13','SLOW FOOD','15.90', 36, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(140, 'Pizza0Siciliana','2019-08-13','SLOW FOOD','15.90', 53, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(141, 'Pizza0Sarda','2019-08-13','SLOW FOOD','15.90', 54, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(142, 'Pizza0Umbra','2019-08-13','SLOW FOOD','15.90', 51, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(143, 'Pizza0Molisana','2019-08-13','SLOW FOOD','15.90', 1, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(144, 'Pizza0Basilicana','2019-08-13','SLOW FOOD','15.90', 60, 'Martha0Vandellas','Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(145, 'Pizza0Trentina','2019-08-13','SLOW FOOD','15.90', 55, 'Martha0Vandellas', 'Pizze', 'Pizza Regionale fatta solo con ingredienti di prima scelta, freschissimi e della zona. Cotta su forno a legna'),
(149, 'Latte0Intero0a0Lunga0Conservazione','2019-09-06','BIO','3.00', 0, 'Honey0Bee', 'Latticini', 'Latte intero a lunga conservazione da 1LT'),
(147, 'Latte0Scremato0a0Lunga0Conservazione','2019-09-06','BIO','3.00', 0,'Honey0Bee', 'Latticini', 'Latte scremato a lunga conservazione da 1LT'),
(148, 'Latte0Light0a0Lunga0Conservazione','2019-09-06','BIO','3.00', 0, 'Honey0Bee', 'Latticini', 'Latte parzialmente scremato a lunga conservazione da 1LT');
-- --------------------------------------------------------

--
-- Struttura della tabella `province`
--

CREATE TABLE `province` (
  `id_province` int(16) NOT NULL,
  `nome_province` varchar(128) NOT NULL,
  `sigla_province` varchar(5) NOT NULL,
  `regione_province` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `province`
--

INSERT INTO `province` (`id_province`, `nome_province`, `sigla_province`, `regione_province`) VALUES
(1, 'Agrigento', 'AG', 'Sicilia'),
(2, 'Alessandria', 'AL', 'Piemonte'),
(3, 'Ancona', 'AN', 'Marche'),
(4, 'Arezzo', 'AR', 'Toscana'),
(5, 'Ascoli0Piceno', 'AP', 'Marche'),
(6, 'Asti', 'AT', 'Piemonte'),
(7, 'Avellino', 'AV', 'Campania'),
(8, 'Bari', 'BA', 'Puglia'),
(9, 'Barletta-Andria-Trani', 'BT', 'Puglia'),
(10, 'Belluno', 'BL', 'Veneto'),
(11, 'Benevento', 'BN', 'Campania'),
(12, 'Bergamo', 'BG', 'Lombardia'),
(13, 'Biella', 'BI', 'Piemonte'),
(14, 'Bologna', 'BO', 'Emilia-Romagna'),
(15, 'Bolzano', 'BZ', 'Trentino-Alto0Adige'),
(16, 'Brescia', 'BS', 'Lombardia'),
(17, 'Brindisi', 'BR', 'Puglia'),
(18, 'Cagliari', 'CA', 'Sardegna'),
(19, 'Caltanissetta', 'CL', 'Sicilia'),
(20, 'Campobasso', 'CB', 'Molise'),
(21, 'Carbonia-Iglesias', 'CI', 'Sardegna'),
(22, 'Caserta', 'CE', 'Campania'),
(23, 'Catania', 'CT', 'Sicilia'),
(24, 'Catanzaro', 'CZ', 'Calabria'),
(25, 'Chieti', 'CH', 'Abruzzo'),
(26, 'Como', 'CO', 'Lombardia'),
(27, 'Cosenza', 'CS', 'Calabria'),
(28, 'Cremona', 'CR', 'Lombardia'),
(29, 'Crotone', 'KR', 'Calabria'),
(30, 'Cuneo', 'CN', 'Piemonte'),
(31, 'Enna', 'EN', 'Sicilia'),
(32, 'Fermo', 'FM', 'Marche'),
(33, 'Ferrara', 'FE', 'Emilia-Romagna'),
(34, 'Firenze', 'FI', 'Toscana'),
(35, 'Foggia', 'FG', 'Puglia'),
(36, 'Forli-Cesena', 'FC', 'Emilia-Romagna'),
(37, 'Frosinone', 'FR', 'Lazio'),
(38, 'Genova', 'GE', 'Liguria'),
(39, 'Gorizia', 'GO', 'Friuli-Venezia0Giulia'),
(40, 'Grosseto', 'GR', 'Toscana'),
(41, 'Imperia', 'IM', 'Liguria'),
(42, 'Isernia', 'IS', 'Molise'),
(43, 'L0Aquila', 'AQ', 'Abruzzo'),
(44, 'La0Spezia', 'SP', 'Liguria'),
(45, 'Latina', 'LT', 'Lazio'),
(46, 'Lecce', 'LE', 'Puglia'),
(47, 'Lecco', 'LC', 'Lombardia'),
(48, 'Livorno', 'LI', 'Toscana'),
(49, 'Lodi', 'LO', 'Lombardia'),
(50, 'Lucca', 'LU', 'Toscana'),
(51, 'Macerata', 'MC', 'Marche'),
(52, 'Mantova', 'MN', 'Lombardia'),
(53, 'Massa0e0Carrara', 'MS', 'Toscana'),
(54, 'Matera', 'MT', 'Basilicata'),
(55, 'Medio0Campidano', 'VS', 'Sardegna'),
(56, 'Messina', 'ME', 'Sicilia'),
(57, 'Milano', 'MI', 'Lombardia'),
(58, 'Modena', 'MO', 'Emilia-Romagna'),
(59, 'Monza0e0Brianza', 'MB', 'Lombardia'),
(60, 'Napoli', 'NA', 'Campania'),
(61, 'Novara', 'NO', 'Piemonte'),
(62, 'Nuoro', 'NU', 'Sardegna'),
(63, 'Ogliastra', 'OG', 'Sardegna'),
(64, 'Olbia-Tempio', 'OT', 'Sardegna'),
(65, 'Oristano', 'OR', 'Sardegna'),
(66, 'Padova', 'PD', 'Veneto'),
(67, 'Palermo', 'PA', 'Sicilia'),
(68, 'Parma', 'PR', 'Emilia-Romagna'),
(69, 'Pavia', 'PV', 'Lombardia'),
(70, 'Perugia', 'PG', 'Umbria'),
(71, 'Pesaro0e0Urbino', 'PU', 'Marche'),
(72, 'Pescara', 'PE', 'Abruzzo'),
(73, 'Piacenza', 'PC', 'Emilia-Romagna'),
(74, 'Pisa', 'PI', 'Toscana'),
(75, 'Pistoia', 'PT', 'Toscana'),
(76, 'Pordenone', 'PN', 'Friuli-Venezia0Giulia'),
(77, 'Potenza', 'PZ', 'Basilicata'),
(78, 'Prato', 'PO', 'Toscana'),
(79, 'Ragusa', 'RG', 'Sicilia'),
(80, 'Ravenna', 'RA', 'Emilia-Romagna'),
(81, 'Reggio0Calabria', 'RC', 'Calabria'),
(82, 'Reggio0Emilia', 'RE', 'Emilia-Romagna'),
(83, 'Rieti', 'RI', 'Lazio'),
(84, 'Rimini', 'RN', 'Emilia-Romagna'),
(85, 'Roma', 'RM', 'Lazio'),
(86, 'Rovigo', 'RO', 'Veneto'),
(87, 'Salerno', 'SA', 'Campania'),
(88, 'Sassari', 'SS', 'Sardegna'),
(89, 'Savona', 'SV', 'Liguria'),
(90, 'Siena', 'SI', 'Toscana'),
(91, 'Siracusa', 'SR', 'Sicilia'),
(92, 'Sondrio', 'SO', 'Lombardia'),
(93, 'Taranto', 'TA', 'Puglia'),
(94, 'Teramo', 'TE', 'Abruzzo'),
(95, 'Terni', 'TR', 'Umbria'),
(96, 'Torino', 'TO', 'Piemonte'),
(97, 'Trapani', 'TP', 'Sicilia'),
(98, 'Trento', 'TN', 'Trentino-Alto0Adige'),
(99, 'Treviso', 'TV', 'Veneto'),
(100, 'Trieste', 'TS', 'Friuli-Venezia0Giulia'),
(101, 'Udine', 'UD', 'Friuli-Venezia0Giulia'),
(102, 'Aosta', 'AO', 'Valle0d0Aosta'),
(103, 'Varese', 'VA', 'Lombardia'),
(104, 'Venezia', 'VE', 'Veneto'),
(105, 'Verbano-Cusio-Ossola', 'VB', 'Piemonte'),
(106, 'Vercelli', 'VC', 'Piemonte'),
(107, 'Verona', 'VR', 'Veneto'),
(108, 'Vibo0Valentia', 'VV', 'Calabria'),
(109, 'Vicenza', 'VI', 'Veneto'),
(110, 'Viterbo', 'VT', 'Lazio');

-- --------------------------------------------------------

--
-- Struttura della tabella `Raggio`
--

CREATE TABLE `Raggio` (
  `ID` int(7) NOT NULL,
  `Regione` varchar(100) DEFAULT NULL,
  `Province` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Raggio`
--

INSERT INTO `Raggio` (`ID`, `Regione`, `Province`) VALUES
(0, 'Italia', NULL),
(1, 'Molise', NULL),
(4, 'Basilicata', 'BL'),
(12, 'Emilia-Romagna,Molise,Sicilia', 'BL,PD'),
(13, 'Basilicata,Friuli-Venezia0Giulia,Sardegna', 'BL,PD,BZ'),
(14, 'Friuli-Venezia0Giulia,Liguria,Sardegna', 'BL,PD,BZ'),
(15, 'Emilia-Romagna,Friuli-Venezia0Giulia,Sicilia,Trentino-Alto0Adige', 'BL,PD'),
(18, 'Abruzzo,Basilicata,Campania,Veneto', 'BZ'),
(19, 'Veneto', 'NA'),
(20, 'Lazio,Trentino-Alto0Adige,Veneto', NULL),
(23, 'Campania,Friuli-Venezia0Giulia,Sardegna', NULL),
(24, 'Campania,Sardegna,Veneto', 'BZ'),
(25, 'Campania,Sardegna,Sicilia,Valle0d0Aosta,Veneto', NULL),
(26, 'Campania,Sardegna,Sicilia,Valle0d0Aosta,Veneto', 'BZ'),
(29, 'Liguria', 'PD'),
(34, 'Lombardia,Puglia,Sicilia', NULL),
(35, 'Liguria,Sicilia', NULL),
(36, 'Campania', NULL),
(37, 'Puglia', NULL),
(38, 'Emilia-Romagna, Piemonte, Veneto, Friuli-Venezia0Giulia, Lombardia, Liguria, Valle0d0Aosta, Trentino-Alto0Adige, Toscana', 'NA,SA, CT, CA, RM'),
(39, 'Calabria, Campania, Sicilia, Sardegna', NULL),
(40, 'Lazio, Campania, Toscana', NULL),
(41, 'Sardegna, Puglia, Campania, Basilicata, Sicilia', 'NA, RM'),
(42, 'Toscana, Umbria, Marche, Lazio, Molise', 'NA'),
(43, 'Piemonte', NULL),
(44, 'Lazio, Campania', NULL),
(45, 'Veneto', NULL),
(46, 'Lombardia', NULL),
(47, 'Liguria', NULL),
(48, 'Toscana', NULL),
(49, 'Lazio', NULL),
(50, 'Marche', NULL),
(51, 'Umbria', NULL),
(52, 'Calabria', NULL),
(53, 'Sicilia', NULL),
(54, 'Sardegna', NULL),
(55, 'Trentino-Alto0Adige', NULL),
(56, 'Friuli-Venezia0Giulia', NULL),
(57, 'Emilia-Romagna', NULL),
(58, 'Valle0d0Aosta', NULL),
(59, 'Abruzzo', NULL),
(60, 'Basilicata', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Recapito`
--

CREATE TABLE `Recapito` (
  `Proprietario` varchar(35) NOT NULL,
  `Citta` varchar(30) NOT NULL,
  `Via` varchar(30) NOT NULL,
  `CAP` varchar(10) NOT NULL,
  `Provincia` varchar(2) DEFAULT NULL,
  `numTel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Recapito (`Proprietario`, `Citta`, `Via`, `CAP`, `Provincia`, `numTel`) VALUES
('nile.rodgers@gmail.com', 'Milano', 'Via Montenapoleone, 13 Scala A', '20019', 'MI', '3498932894'),
('mr.white@gmail.com', 'Milano', 'Viale Zara, 72', '20019', 'MI', '3478392321'),
('miss.jones@me.com', 'Roma', 'Piazza Pietro D&apos;Illiria, 83', '00153', 'RM', '3489843201'),
('diana@ross.com', 'Venezia', 'Piazza San Marco, 81', '30100', 'VE', '3443298109'),
('marvin39@gmail.com', 'Napoli', 'Via Toledo, 02, Scala B', '80100', 'NA', '3694930909'),
('bedwards@live.it', 'Napoli', 'Via dei Tribunali, 26 Primo Piano', '80100', 'NA', '3339854394'),
('m.rossi@gmail.com', 'Torino', 'Piazza Solferino, 21&sol;A Ultimo Piano', '10125', 'TO', '3498954324'),
('ggil42@gmail.com', 'Roma', 'Via Flaminia 21, Roma Nord', '00191', 'RM', '3399430389'),
('file@jil.com', 'Verona', 'Piazza Duomo, 14', '37100', 'VR', '3489843892'),
('user@user.it', 'Roma', 'Via Flaminia 23, Roma Nord', '00191', 'RM', '3489857435');

-- --------------------------------------------------------

--
-- Struttura della tabella `Scontrino`
--

CREATE TABLE `Scontrino` (
  `ID` int(11) NOT NULL,
  `Cliente` varchar(35) NOT NULL,
  `Data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `Sede`
--

CREATE TABLE `Sede` (
  `Azienda` varchar(35) NOT NULL,
  `Citta` varchar(30) DEFAULT NULL,
  `Via` varchar(30) DEFAULT NULL,
  `CAP` varchar(10) DEFAULT NULL,
  `numTel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Sede`
--

INSERT INTO `Sede` (`Azienda`, `Citta`, `Via`, `CAP`, `numTel`) VALUES
('Deltasimmons', 'Feltre', 'Via della Padovana 90', 'av321', NULL),
('Al0Fungo', 'Padova', 'Via Ugo Bassi, 22', 35131, '049650645'),
('Dal0Pane0alla0Tavola', 'Altamura', 'Via della Roverella, 82', 7200, '0800135801'),
('Honey0Bee', 'Bolzano', 'Piazza Duomo, 12', 39100, '0471524912'),
('Il0Gelataio', 'Roma', 'Piazza di Spagna, 42', 00187, '348321010'),
('La0Bottega0di0Alberobello', 'Bari', 'Corso Italia, 63', 70121, '0801234567'),
('Pizzel', 'Napoli', 'Via dei Tribunali, 287&minus;289', 80138, '0815567421'),
('La0Maison0della0Pizza', 'Roma', 'Fontana di Trevi', 00100, '061957243'),
('Smoothie', 'Verona', 'Viale Arena, 1', 37100, '3419440044'),
('Oasi0del0Cioccolato', 'Torino', 'Mole Antoneliana, 15', 10121, '3478027767'),
('Martha0Vandellas', 'Milano', 'Piazza Duomo, 9', 20019, '3488932438'),
('Wine0Shop', 'Valdobbiadene', 'Viale Mazzini 11', 31049, '3339893218');

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS=0;
--
-- Struttura della tabella `Vendita`
--

CREATE TABLE `Vendita` (
  `Scontrino` int(11) NOT NULL,
  `Prodotto` int(10) NOT NULL,
  `Numero` int(11) NOT NULL,
  `Prezzo` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`Email`);

--
-- Indici per le tabelle `LogghinC`
--
ALTER TABLE `LogghinC`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `LogghinV`
--
ALTER TABLE `LogghinV`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `Negozi`
--
ALTER TABLE `Negozi`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `Newsletter`
--
ALTER TABLE `Newsletter`
  ADD PRIMARY KEY (`Email`);

--
-- Indici per le tabelle `Prodotti`
--
ALTER TABLE `Prodotti`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Negozio` (`Negozio`),
  ADD KEY `Raggio` (`Raggio`),
  ADD KEY `Categoria` (`Categoria`);

--
-- Indici per le tabelle `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id_province`);

--
-- Indici per le tabelle `Raggio`
--
ALTER TABLE `Raggio`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `Recapito`
--
ALTER TABLE `Recapito`
  ADD PRIMARY KEY (`Proprietario`);

--
-- Indici per le tabelle `Scontrino`
--
ALTER TABLE `Scontrino`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Clientecomprante` (`Cliente`);

--
-- Indici per le tabelle `Sede`
--
ALTER TABLE `Sede`
  ADD PRIMARY KEY (`Azienda`);

--
-- Indici per le tabelle `Vendita`
--
ALTER TABLE `Vendita`
  ADD PRIMARY KEY (`Scontrino`,`Prodotto`),
  ADD KEY `prodottovenduto` (`Prodotto`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Prodotti`
--
ALTER TABLE `Prodotti`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT per la tabella `province`
--
ALTER TABLE `province`
  MODIFY `id_province` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT per la tabella `Scontrino`
--
ALTER TABLE `Scontrino`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Prodotti`
--
ALTER TABLE `Prodotti`
  ADD CONSTRAINT `Prodotti_ibfk_1` FOREIGN KEY (`Negozio`) REFERENCES `Negozi` (`Nome`),
  ADD CONSTRAINT `Prodotti_ibfk_2` FOREIGN KEY (`Negozio`) REFERENCES `Negozi` (`Nome`),
  ADD CONSTRAINT `Prodotti_ibfk_3` FOREIGN KEY (`Raggio`) REFERENCES `Raggio` (`ID`),
  ADD CONSTRAINT `Prodotti_ibfk_4` FOREIGN KEY (`Categoria`) REFERENCES `Categorie` (`Nome`);

--
-- Limiti per la tabella `Recapito`
--
ALTER TABLE `Recapito`
  ADD CONSTRAINT `Recapito_ibfk_1` FOREIGN KEY (`Proprietario`) REFERENCES `Cliente` (`Email`);

--
-- Limiti per la tabella `Scontrino`
--
ALTER TABLE `Scontrino`
  ADD CONSTRAINT `Clientecomprante` FOREIGN KEY (`Cliente`) REFERENCES `Cliente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `Sede`
--
ALTER TABLE `Sede`
  ADD CONSTRAINT `Sede_ibfk_1` FOREIGN KEY (`Azienda`) REFERENCES `Negozi` (`Nome`),
  ADD CONSTRAINT `Sede_ibfk_2` FOREIGN KEY (`Azienda`) REFERENCES `Negozi` (`Nome`);

--
-- Limiti per la tabella `Vendita`
--
ALTER TABLE `Vendita`
  ADD CONSTRAINT `prodottovenduto` FOREIGN KEY (`Prodotto`) REFERENCES `Prodotti` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

  SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
