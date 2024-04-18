-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 09:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `form_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `label_class` varchar(255) DEFAULT NULL,
  `input_class` varchar(255) DEFAULT NULL,
  `error_class` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `validation` varchar(255) DEFAULT NULL,
  `field_order` int(11) NOT NULL DEFAULT 1,
  `grouping_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `form_id`, `name`, `type`, `label`, `required`, `label_class`, `input_class`, `error_class`, `value`, `validation`, `field_order`, `grouping_id`) VALUES
(1, 1, 'email', 'email', 'Email:', 1, 'form-label', 'form-control', 'text-warning', '', 'email_validation', 1, 0),
(2, 1, 'password', 'password', 'Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 2, 0),
(3, 2, 'comment', 'textarea', 'Reactie:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 1, 0),
(4, 3, 'search', 'search', '', 1, '', 'form-control', '', '', 'text_validation', 1, 0),
(5, 4, 'recipe_name', 'text', 'Naam:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 1, 0),
(6, 4, 'recipe_img', 'file', 'Afbeelding:', 0, 'form-label', 'form-control', 'text-warning', '', 'file_validation', 2, 0),
(7, 4, 'cuisine_choice', 'dropdown', 'Keuken:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation', 4, 0),
(8, 4, 'type', 'dropdown', 'Type:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation', 5, 0),
(9, 4, 'recipe_blurb', 'textarea', 'Korte Omschrijving:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validaton', 6, 0),
(10, 4, 'recipe_description', 'textarea', 'Uitgebreide Omschrijving:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 7, 0),
(11, 4, 'ingredient_title', 'comment', '', 0, '', '', '', '', '', 8, 0),
(12, 4, 'open_ingredient_div', 'comment', '', 0, '', '', '', '', '', 9, 0),
(13, 4, 'ingredient_choice_1', 'dropdown', 'Ingrediënt:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation', 10, 34),
(14, 4, 'quantity_1', 'numeric', 'Hoeveelheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'numeric_non_zero_validation', 11, 34),
(15, 4, 'measure_choice_1', 'dropdown', '', 1, '', 'form-control', 'text-warning', '', 'text_validation', 12, 34),
(16, 4, 'measure_button', 'comment', '', 0, '', '', '', '', '', 13, 0),
(17, 4, 'close_ingredient_div', 'comment', '', 0, '', '', '', '', '', 14, 0),
(18, 4, 'ingredient_button', 'comment', '', 0, '', '', '', '', '', 15, 0),
(19, 4, 'prep_step_title', 'comment', '', 0, '', '', '', '', '', 16, 0),
(20, 4, 'open_prep_step_div', 'comment', '', 0, '', '', '', '', '', 17, 0),
(21, 4, 'prep_step_1', 'textarea', 'Stap bereidingswijze:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 18, 35),
(22, 4, 'close_prep_step_div', 'comment', '', 0, '', '', '', '', '', 19, 0),
(23, 4, 'prep_step_button', 'comment', '', 0, '', '', '', '', '', 20, 0),
(24, 5, 'measure', 'text', 'Maateenheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 1, 0),
(25, 5, 'measure_quantity', 'numeric', 'Hoeveelheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'numeric_non_zero_validation', 2, 0),
(26, 5, 'measure_unit', 'dropdown', '', 1, '', 'form-control', 'text-warning', '', 'dropdown_validation', 3, 0),
(27, 6, 'username', 'text', 'Naam:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 1, 0),
(28, 6, 'email', 'email', 'Email:', 1, 'form-label', 'form-control', 'text-warning', '', 'email_validation', 2, 0),
(29, 6, 'password', 'password', 'Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 3, 0),
(30, 6, 'repeat_password', 'password', 'Herhaal Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation', 4, 0),
(31, 6, 'profile_picture', 'file', 'Profielfoto:', 0, 'form-label', 'form-control', 'text-warning', '', 'file_validation', 5, 0),
(32, 4, 'people', 'numeric', 'Aantal Personen:', 1, 'form-label', 'form-control', 'text-warning', '', 'numeric_int_validation', 3, 0),
(33, 4, 'user_id', 'hidden', '', 1, '', '', '', '0', 'numeric_int', 21, 0),
(34, 4, 'number_of_ingredients', 'hidden', '', 1, '', '', '', '1', 'numeric_int', 22, 0),
(35, 4, 'number_of_steps', 'hidden', '', 1, '', '', '', '1', 'numeric_int', 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fields_comments`
--

CREATE TABLE `fields_comments` (
  `field_id` int(11) UNSIGNED NOT NULL,
  `text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields_comments`
--

INSERT INTO `fields_comments` (`field_id`, `text`) VALUES
(11, '<h2 class = \"form-subtitle lily\">Ingrediënten:</h2>'),
(12, '<div class = \"m-2\">'),
(16, '<button class = \"minor-button white-lily my-1\">Maateenheid Toevoegen</button>'),
(17, '</div>'),
(18, '<button class = \"minor-button white-lily my-1\">Ingrediënt Toevoegen</button>'),
(19, '<h2 class = \"form-subtitle lily\">Bereidingswijze:</h2>'),
(20, '<div class = \"m-2\">'),
(22, '</div>'),
(23, '<button class = \"minor-button white-lily my-1\">Stap Toevoegen</button>');

-- --------------------------------------------------------

--
-- Table structure for table `fields_numeric`
--

CREATE TABLE `fields_numeric` (
  `field_id` int(11) UNSIGNED NOT NULL,
  `min_value` int(11) DEFAULT NULL,
  `max_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields_numeric`
--

INSERT INTO `fields_numeric` (`field_id`, `min_value`, `max_value`) VALUES
(14, 0, NULL),
(25, 0, NULL),
(32, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `classes` varchar(255) DEFAULT NULL,
  `attributes` varchar(255) DEFAULT NULL,
  `submit_text` varchar(255) DEFAULT NULL,
  `submit_class` varchar(255) DEFAULT NULL,
  `label_layout_class` varchar(255) DEFAULT NULL,
  `input_layout_class` varchar(255) DEFAULT NULL,
  `error_layout_class` varchar(255) DEFAULT NULL,
  `complete_layout_class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `method`, `action`, `classes`, `attributes`, `submit_text`, `submit_class`, `label_layout_class`, `input_layout_class`, `error_layout_class`, `complete_layout_class`) VALUES
(1, 'Login Form', 'post', '', 'login-class', '', 'Login', 'submit-login white-lily my-3', '', '', '', 'row mx-2 my-1'),
(2, 'Comment Form', 'post', '', 'comment-class', '', 'Reageren', '', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(3, 'Search Form', 'post', '', 'search-class', '', '', '', '', '', '', ''),
(4, 'Recipe Form', 'post', '', 'recipe-class', '', 'Recept Toevoegen', 'submit-recipe white-lily my-3', 'col-sm-3', 'col-sm-6', 'col-sm-3', 'row my-3'),
(5, 'Measure Form', 'post', '', 'measure-class', '', 'Maateenheid Toevoegen', '', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(6, 'Registreren Form', 'post', '', 'register-class', '', 'Registreren', 'submit-register white-lily my-3', 'col-sm-3 lily', 'col-sm-6', 'col-sm-3', 'row my-2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `fields_comments`
--
ALTER TABLE `fields_comments`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `fields_numeric`
--
ALTER TABLE `fields_numeric`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`);

--
-- Constraints for table `fields_comments`
--
ALTER TABLE `fields_comments`
  ADD CONSTRAINT `fields_comments_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`);

--
-- Constraints for table `fields_numeric`
--
ALTER TABLE `fields_numeric`
  ADD CONSTRAINT `fields_numeric_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
