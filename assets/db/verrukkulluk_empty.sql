-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 05 mrt 2024 om 11:13
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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `favorites`
--

CREATE TABLE `favorites` (
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` enum('gram','litre','numerical') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ratings`
--

CREATE TABLE `ratings` (
  `recipe_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `rating` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
-- Indexen voor tabel `lookup`
--
ALTER TABLE `lookup`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ingredients`
--
ALTER TABLE `ingredients`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ingredients`
--
ALTER TABLE `lookup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `measures`
--
ALTER TABLE `measures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `prep_steps`
--
ALTER TABLE `prep_steps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
