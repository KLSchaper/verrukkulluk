-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 26 mrt 2024 om 16:12
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `agenda`
--

CREATE TABLE `agenda` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `blurb` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `agenda`
--

INSERT INTO `agenda` (`id`, `name`, `date`, `blurb`) VALUES
(1, 'Gezond Koken & Eten', '2024-04-07 15:30:00', 'Workshop door Rogier Abbink ter ere van Wereld Gezondheids Dag'),
(2, 'Wereld Tonijndag', '2024-05-02 00:00:00', ''),
(3, 'Italiaans Koken', '2024-06-12 19:00:00', 'Workshop door Elske Hulter.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `comments`
--

INSERT INTO `comments` (`id`, `recipe_id`, `user_id`, `text`, `date`) VALUES
(1, 2, 1, 'Heerlijk! Maar hou er wel rekening mee dat de voorbereiding erg lang duurt.', '2024-03-14 16:38:13'),
(2, 2, 2, 'Door vrienden aangeraden, maar viel heel erg tegen!', '2024-03-14 16:38:13'),
(3, 1, 3, 'Top!', '2024-03-14 16:38:13');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cuisines`
--

CREATE TABLE `cuisines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('region','country','other') NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `cuisines`
--

INSERT INTO `cuisines` (`id`, `name`, `type`, `parent_id`) VALUES
(1, 'Europees', 'region', NULL),
(2, 'Mediterraans', 'region', 1),
(3, 'Frans', 'country', 1),
(4, 'Grieks', 'country', 2),
(5, 'Italiaans', 'country', 2),
(6, 'Nederlands', 'country', 1),
(7, 'Spaans', 'country', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `favorites`
--

CREATE TABLE `favorites` (
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `favorites`
--

INSERT INTO `favorites` (`recipe_id`, `user_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` enum('gram','litre','numerical') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit`) VALUES
(1, 'tarwebloem', 'gram'),
(2, 'gedroogde gist', 'gram'),
(3, 'zout', 'gram'),
(4, 'traditionele olijfolie', 'litre'),
(5, 'kraanwater', 'litre'),
(6, 'romatomaten', 'numerical'),
(7, 'mozzarella', 'gram'),
(8, 'gedroogde Italiaanse kruiden', 'gram'),
(9, 'rode ui', 'numerical'),
(10, 'winterpeen', 'gram'),
(11, 'bleekselderij', 'gram'),
(12, 'Parmigiano Reggiano', 'gram'),
(13, 'rundergehakt', 'gram'),
(14, 'tomatenpuree', 'gram'),
(15, 'volle melk', 'litre'),
(16, 'passata di pomodoro', 'gram'),
(17, 'ongezouten roomboter', 'gram'),
(18, 'lasagne all\'uovo', 'gram');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lookup`
--

CREATE TABLE `lookup` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `lookup`
--

INSERT INTO `lookup` (`id`, `group`, `value`, `display`) VALUES
(1, 'recipe_types', 'meat_and_fish', 'Vlees en Vis'),
(2, 'recipe_types', 'meat', 'Vlees'),
(3, 'recipe_types', 'fish', 'Vis'),
(4, 'recipe_types', 'vegetarian', 'Vegetarisch'),
(5, 'recipe_types', 'vegan', 'Veganistisch'),
(6, 'cuisine_types', 'region', 'Regio'),
(7, 'cuisine_types', 'country', 'Land'),
(8, 'cuisine_types', 'other', 'Overig'),
(9, 'units', 'gram', 'Gram'),
(10, 'units', 'litre', 'Liter'),
(11, 'units', 'numerical', 'Numeriek'),
(12, 'detail_tabs', 'ingredients', 'Ingrediënten'),
(13, 'detail_tabs', 'prep_steps', 'Bereidingswijze'),
(14, 'detail_tabs', 'comments', 'Reacties');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `measures`
--

CREATE TABLE `measures` (
  `id` int(10) UNSIGNED NOT NULL,
  `ingredient_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `unit` enum('gram','litre','numerical') NOT NULL,
  `quantity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `measures`
--

INSERT INTO `measures` (`id`, `ingredient_id`, `name`, `unit`, `quantity`) VALUES
(1, NULL, 'gram', 'gram', 1),
(2, NULL, 'kilogram', 'gram', 1000),
(3, NULL, 'liter', 'litre', 1),
(4, NULL, 'milliliter', 'litre', 0.001),
(5, NULL, 'stuks', 'numerical', 1),
(6, 11, 'stengels', 'gram', 60),
(7, NULL, 'theelepel', 'litre', 0.002),
(8, NULL, 'eetlepel', 'litre', 0.012),
(9, 2, 'zakje', 'gram', 7),
(10, 3, 'theelepel', 'gram', 2),
(11, 8, 'theelepel', 'gram', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `prep_steps`
--

CREATE TABLE `prep_steps` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `number` tinyint(2) UNSIGNED NOT NULL,
  `descr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `prep_steps`
--

INSERT INTO `prep_steps` (`id`, `recipe_id`, `number`, `descr`) VALUES
(1, 1, 1, '\r\n	Zeef de bloem, gist en zout boven een grote kom. Maak een kuiltje in het midden en schenk hierin\r\n	de olie en het lauwe water. Begin met de vingers vanuit het midden te mengen. Ga over tot kneden\r\n	zodra er een samenhangend deeg ontstaat. Kneed 10 min. tot een soepel, elastisch deeg. Maak een\r\n	deegbal en laat deze in een grote kom, afgedekt met vochtige theedoek, op een warme plek\r\n	minimaal 1 uur rijzen tot het volume is verdubbeld.\r\n'),
(2, 1, 2, '\r\n	Verwarm de oven voor op 200 °C. Snijd de tomaat aan de onderkant kruislings in. Dompel ze 20 sec.\r\n	in kokend water. Neem ze eruit en laat afkoelen. Pel het vel van de tomaat eraf. Snijd het\r\n	vruchtvlees in plakken. Duw het deeg plat. Verdeel het in gelijke stukken en rol met de met bloem\r\n	bestoven deegroller uit tot flinterdunne, ronde lappen. Snijd de mozzarella in plakken. Beleg elke\r\n	pizzabodem met tomaat, mozzarella en bestrooi met de Italiaanse kruiden. Breng op smaak met peper\r\n	en zout. Besprenkel met de olie.\r\n'),
(3, 1, 3, '\r\n	Bak de pizza\'s één voor één in 8-10 min. in het midden van de oven krokant en gaar. Snijd een pizza,\r\n	zodra deze klaar is, in punten en eet de pizza op terwijl de volgende in de oven ligt.\r\n'),
(4, 2, 1, '\r\n	Snipper de ui. Schil de winterpeen en snijd in dunne plakjes. Snijd de bleekselderij\r\n	in boogjes en rasp de kaas.\r\n'),
(5, 2, 2, '\r\n	Verhit de olie in een hapjespan en fruit de ui, winterpeen en bleekselderij 5 min. op laag vuur.\r\n	Voeg het gehakt toe en bak op middelhoog vuur in 5 min. rul. Voeg de tomatenpuree toe en bak\r\n	2 min. mee. Voeg 200 ml melk toe en laat al roerend op laag vuur bijna helemaal inkoken.\r\n	Voeg de passata toe, breng aan de kook. Zet het vuur laag.\r\n	Laat met de deksel half op de pan 45 min. zachtjes koken.\r\n'),
(6, 2, 3, '\r\n	Maak ondertussen de bechamelsaus. Smelt daarvoor de boter in een steelpan met dikke bodem\r\n	op laag vuur. Meng de bloem erdoor en laat op laag vuur 3 min. garen. Voeg op laag vuur al\r\n	roerend 500 ml melk in scheuten toe. Voeg pas de volgende scheut toe als de vorige helemaal\r\n	is opgenomen. Laat op laag vuur 2-3 min. zachtjes koken. Breng op smaak met peper en eventueel zout.\r\n	Zet weg tot gebruik.\r\n'),
(7, 2, 4, '\r\n	Verwarm de oven voor op 180 °C. Maak laagjes in de ovenschaal van achtereenvolgens wat saus,\r\n	lasagnebladen, saus, bechamelsaus en kaas. Herhaal tot alle ingrediënten op zijn en eindig\r\n	met een laag bechamelsaus en kaas. Bak de lasagne ca. 40 min. in het midden van de oven.\r\n	Laat afgedekt met aluminiumfolie 10 min. rusten.\r\n');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `ingredient_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `blurb` varchar(255) NOT NULL,
  `quantity` double NOT NULL,
  `measure_id` int(11) UNSIGNED NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `calories` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `ingredient_id`, `name`, `img`, `blurb`, `quantity`, `measure_id`, `price`, `calories`) VALUES
(1, 1, 'AH Tarwebloem', 'product.png', 'Een kilo huismerk tarwebloem.', 1, 2, 0.89, 3490),
(2, 1, 'AH Biologische Tarwebloem', 'product.png', 'Een kilo biologisch geteelde tarwebloem.', 1, 2, 1.13, 3420),
(3, 2, 'Dr. Oetker Gist levure', 'product.png', 'Gist van Dr. Oetker is het ideale bakingredient voor allerlei zoet en hartig gebak.', 1, 9, 0.85, 0),
(4, 4, 'AH Olijfolie traditioneel', 'product.png', 'Olijfolie verkregen uit koude extractie. Verfijnd en zacht, voor bakken en braden.', 1, 3, 7.49, 8190),
(5, 4, 'Carbonell Olijfolie traditioneel', 'product.png', 'Carbonell traditioneel is een spaanse olijfolie geschikt voor bereiding op hoge temperaturen.', 1, 3, 12.19, 8210),
(6, 6, 'AH Roma tomaten', 'product.png', 'Romatomaten hebben een lichtzoete smaak. Deze tomaat is perfect geschikt om te gebruiken voor het maken van verse pastasaus of tomatensoep.', 1, 5, 0.29, 22),
(7, 7, 'AH Italiaanse mozzarella', 'product.png', 'Mozzarella uit koemelk.', 228, 1, 1.89, 497),
(8, 7, 'AH Mozzarella', 'product.png', 'Mozzarella is een ideale kaas om altijd in huis te hebben, veelzijdig in gebruik bij maaltijden, salades en als tussendoortje.', 200, 1, 0.89, 494),
(9, 7, 'AH Biologisch Italiaanse mozzarella', 'product.png', 'Verse biologische Italiaanse mozzarella kaas gemaakt van koemelk.', 317, 1, 2.49, 723),
(10, 8, 'Verstegen Italiaanse kruiden', 'product.png', 'Nogal logisch: Italiaanse kruiden gebruik je in de Italiaanse keuken.', 12, 1, 1.69, 0),
(11, 3, 'AH Tafelzout met jodium', 'product.png', 'Een smaakmaker van allerhande maaltijden.', 125, 1, 0.39, 0),
(12, 9, 'AH Rode Uien', 'product.png', 'Deze rode uien hebben een uiachtige, extra pittige smaak. Een echte smaakmaker om elk gerecht extra smaak te geven.', 1, 5, 0.19, 35),
(13, 10, 'AH Winterpeen', 'product.png', 'Winterpeen heeft een zoete smaak. Heerlijk door een Nederlandse stamppot.', 1, 2, 1.75, 350),
(14, 11, 'AH Bleekselderij', 'product.png', 'Bleekselderij heeft frisse, knapperige en iets pittige smaak. Heerlijk door een salade of als gezonde snack.', 630, 1, 1.69, 88),
(15, 12, 'AH Parmigiano Reggiano', 'product.png', 'Deze typisch Italiaanse kaas, ook wel bekend onder de naam Parmezaanse kaas, wordt geroemd om haar karaktervolle smaak en korrelige structuur.', 165, 1, 5.29, 657),
(16, 12, 'AH Biologisch Parmigiano Reggiano', 'product.png', 'Een mooie harde typisch Italiaanse kaas gemaakt van biologische koemelk.', 145, 1, 5.73, 580),
(17, 12, 'AH Excellent Parmigiano Reggiano DOP 32+ montagna', 'product.png', 'Onze Parmigiano Reggiano Prodotto di Montagna 24 maanden DOP wordt geproduceerd met melk van koeien die gevoed worden met gras dat groeit boven 600 meter zeeniveau.', 200, 1, 5.99, 796),
(18, 13, 'AH Rundergehakt', 'product.png', 'Rundergehakt om eindeloos mee te varieren. Natuurlijk voor een gewone gehaktbal, maar ook voor snackballetjes of soepballetjes of gebruik het geruld in pastasaus en ovengerechten.', 500, 1, 4.69, 1140),
(19, 14, 'AH Tomatenpuree', 'product.png', 'Heerlijke dubbel geconcentreerde tomatenpuree die zorgt voor een volle en intense tomatensmaak.', 70, 1, 0.49, 62),
(20, 15, 'AH Volle melk', 'product.png', 'Verse volle melk, lekker voor ieder moment van de dag.', 0.5, 3, 0.95, 325),
(21, 15, 'AH Volle melk', 'product.png', 'Verse volle melk, lekker voor ieder moment van de dag.', 1, 3, 1.29, 650),
(22, 15, 'AH Volle melk', 'product.png', 'Verse volle melk, lekker voor ieder moment van de dag.', 1.5, 3, 1.75, 975),
(23, 15, 'AH Volle melk', 'product.png', 'Verse volle melk, lekker voor ieder moment van de dag.', 2, 3, 2.04, 1300),
(24, 15, 'De Zaanse Hoeve Volle melk', 'product.png', 'Verse volle melk, lekker voor ieder moment van de dag.', 1, 3, 1.05, 650),
(25, 16, 'AH Biologisch Passata di pomodoro', 'product.png', 'Tomaten passata is ideaal als basis voor klassieke Italiaanse en mediterrane gerechten. Bijvoorbeeld voor de pastasaus, maar ook voor op de pizza.', 690, 1, 1.99, 255),
(26, 17, 'De Zaanse Hoeve Roomboter ongezouten', 'product.png', 'Ongezouten roomboter bevat 81% melkvet.', 250, 1, 2.39, 1860),
(27, 18, 'AH Lasagne all uovo', 'product.png', 'Verse lasagne gemaakt met vrije-uitloopeieren.', 250, 1, 2.29, 713);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ratings`
--

CREATE TABLE `ratings` (
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `rating` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `ratings`
--

INSERT INTO `ratings` (`recipe_id`, `user_id`, `rating`) VALUES
(1, 1, 5),
(2, 1, 7),
(2, 2, 4),
(1, 3, 8),
(2, 3, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipes`
--

CREATE TABLE `recipes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `blurb` varchar(255) NOT NULL,
  `people` tinyint(2) NOT NULL,
  `cuisine_id` int(11) UNSIGNED NOT NULL,
  `type` enum('meat_and_fish','meat','fish','vegetarian','vegan') NOT NULL,
  `descr` text NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `img`, `blurb`, `people`, `cuisine_id`, `type`, `descr`, `user_id`, `date`) VALUES
(1, 'Pizza Margherita', 'pizza_margherita.webp', 'Heerlijke pizza met tomaat en mozarella, helemaal zelf gemaakt, inclusief bodem!', 4, 5, 'vegetarian', 'Met dit recept maake je zelf je eigen pizza margherita van de losse ingrediënten. Je maakt zelf de\r\n	bodem en de saus, en voegt daarna de mozarella en kruiden toe.', 1, '2024-03-14 16:38:13'),
(2, 'Lasagne al Forno', 'lasagne_al_forno.webp', 'Een heerlijk recept voor echt klassieke lasagne.', 4, 5, 'meat', 'Lasagne is een recept dat terug gaat tot 1282, wanneer de oudste tekst bekent is waarin het bescheven\r\n	is, hoewel het natuurlijk wel sinds dien veranderd is. De \"al forno\" in de naam betekent simpelweg\r\n	dat het een ovengerecht is.', 3, '2024-03-14 16:38:13');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `ingredient_id` int(11) UNSIGNED NOT NULL,
  `quantity` double NOT NULL,
  `measure_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `quantity`, `measure_id`) VALUES
(1, 1, 300, 1),
(1, 2, 1, 9),
(1, 3, 1, 10),
(1, 4, 4, 8),
(1, 5, 100, 4),
(1, 6, 10, 5),
(1, 7, 500, 1),
(1, 8, 4, 11),
(2, 1, 60, 1),
(2, 4, 2, 8),
(2, 9, 1, 5),
(2, 10, 300, 1),
(2, 11, 2, 6),
(2, 12, 180, 1),
(2, 13, 350, 1),
(2, 14, 70, 1),
(2, 15, 700, 4),
(2, 16, 690, 1),
(2, 17, 50, 1),
(2, 18, 250, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'placeholder.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `img`) VALUES
(1, 'Sjaak van den Burg', 'sjaak@testmail.com', 'WachtwoordSjaak', 'profiel_foto_sjaak.webp'),
(2, 'Gert Grooters', 'gert@testmail.com', 'WachtwoordGert', 'profiel_foto_gert.webp'),
(3, 'Lieke Hooggreven', 'lieke@testmail.com', 'WachtwoordLieke', 'profiel_foto_lieke.webp'),
(4, 'Aaltje Bosboom', 'aaltje@testmail.com', 'WachtwoordAaltje', 'profiel_foto_aaltje.webp');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_recipe_id` (`recipe_id`),
  ADD KEY `comment_user_id` (`user_id`);

--
-- Indexen voor tabel `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_cuisine_id` (`parent_id`);

--
-- Indexen voor tabel `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`recipe_id`),
  ADD KEY `favorites_recipe_id` (`recipe_id`);

--
-- Indexen voor tabel `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `lookup`
--
ALTER TABLE `lookup`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `measures`
--
ALTER TABLE `measures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measure_ingredient_id` (`ingredient_id`);

--
-- Indexen voor tabel `prep_steps`
--
ALTER TABLE `prep_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_step_id` (`recipe_id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ingredient_id` (`ingredient_id`),
  ADD KEY `product_measure_id` (`measure_id`);

--
-- Indexen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`user_id`,`recipe_id`),
  ADD KEY `ratings_recipe_id` (`recipe_id`);

--
-- Indexen voor tabel `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_cuisine_id` (`cuisine_id`),
  ADD KEY `recipe_user_id` (`user_id`);

--
-- Indexen voor tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`recipe_id`,`ingredient_id`) USING BTREE,
  ADD KEY `ri_ingredient_id` (`ingredient_id`),
  ADD KEY `ri_measure_id` (`measure_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT voor een tabel `lookup`
--
ALTER TABLE `lookup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `measures`
--
ALTER TABLE `measures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `prep_steps`
--
ALTER TABLE `prep_steps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT voor een tabel `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `cuisines`
--
ALTER TABLE `cuisines`
  ADD CONSTRAINT `parent_cuisine_id` FOREIGN KEY (`parent_id`) REFERENCES `cuisines` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `measures`
--
ALTER TABLE `measures`
  ADD CONSTRAINT `measure_ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `prep_steps`
--
ALTER TABLE `prep_steps`
  ADD CONSTRAINT `recipe_step_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_measure_id` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipe_cuisine_id` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisines` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `ri_ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ri_measure_id` FOREIGN KEY (`measure_id`) REFERENCES `measures` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ri_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
