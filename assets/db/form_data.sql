/*
data for the form is taken from the forms table in SQL. This table has the following columns:
 -- id
 -- name
 -- method
 -- action
 -- classes
 -- attributes
 -- submit_text
 -- label_column_class
 -- input_column_class
 -- error_column_class
 -- row_class
*/


-- TODO: turn into proper tables
CREATE TABLE IF NOT EXISTS forms (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    `method` VARCHAR(255),
    `action` VARCHAR(255),
    `classes` VARCHAR(255),
    `attributes` VARCHAR(255),
    `submit_text` VARCHAR(255),
    `label_layout_class` VARCHAR(255),
    `input_layout_class` VARCHAR(255),
    `error_layout_class` VARCHAR(255),
    `complete_layout_class` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*
data for the fields is taken from the form_fields table in SQL. This table has the following columns:
 -- id
 -- form_id
 -- name
 -- type
 -- label
 -- required
 -- label_class
 -- input_class
 -- error_class
 -- value
 -- validation
*/

CREATE TABLE IF NOT EXISTS fields (
    `id` INT(11) UNSIGNED PRIMARY KEY,
    `form_id` INT(11) UNSIGNED,
    `name` VARCHAR(255),
    `type` VARCHAR(255),
    `label` VARCHAR(255),
    `required` TINYINT(1),
    `label_class` VARCHAR(255),
    `input_class` VARCHAR(255),
    `error_class` VARCHAR(255),
    `value` VARCHAR(255),
    `validation` VARCHAR(255),
    FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/*
Forms:
1. Login Form
-- email (email)
-- wachtwoord (password)
Submit: Login

2. Comment Form
-- Reactie (textarea)
Submit: Reageren

3. Search Form
-- Zoeken (search)
Submit: Zoeken (of leeg)

4. Recipe Form
-- Naam (text)
-- Afbeelding (file)
-- Keuken (dropdown: cuisines)
-- Type (dropdown: types)
-- Korte Omschrijving (textarea)
-- Uitgebreide Omschrijving (textarea)
-- open div (comment -> div)
-- "Ingredienten" (comment -> text)
-- Ingredient (dropdown: ingredients)
-- Hoeveelheid (numeric)
-- Measure (dropdown: measures, depends on ingredient) (no label)
-- "Maateenheid toevoegen" (comment -> button)
-- "Ingredient toevoegen" (comment -> button)
-- "Bereidingswijze" (comment -> text)
-- Stap Bereidingswijze (textarea)
-- "Meer stappen toevoegen" (comment -> button)
Submit: Recept Toevoegen

5. Measure Form
-- Maateenheid (text)
-- Hoeveelheid (numeric)
-- (unit) (dropdown) (no label)
Submit: Maateenheid Toevoegen

6. Registration Form
-- Naam (text)
-- Email (email)
-- Wachtwoord (password)
-- Herhaal Wachtwoord (password)
-- Profielfoto (file) (optional)
Submit: Registreren

*/

-- Code for inserting forms:
INSERT INTO forms (id, name, method, action, classes, attributes, submit_text, label_layout_class, input_layout_class, error_layout_class, complete_layout_class)
VALUES 
(1, 'Login Form', 'post', '', 'login-class', '', 'Login', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(2, 'Comment Form', 'post', '', 'comment-class', '', 'Reageren', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(3, 'Search Form', 'post', '', 'search-class', '', 'Zoeken', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(4, 'Recipe Form', 'post', '', 'recipe-class', '', 'Recept Toevoegen', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(5, 'Measure Form', 'post', '', 'measure-class', '', 'Maateenheid Toevoegen', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3'),
(6, 'Registreren Form', 'post', '', 'register-class', '', 'Registreren', 'col-sm-2', 'col-sm-6', 'col-sm-4', 'row my-3');


/*
1.1 email (email)
2.1 wachtwoord (password)
3.2 Reactie (textarea)
4.3 Zoeken (search) (no label)
5.4 Naam (text)
6.4 Afbeelding (file)
7.4 Keuken (dropdown: cuisines)
8.4 Type (dropdown: types)
9.4 Korte Omschrijving (textarea)
10.4 Uitgebreide Omschrijving (textarea)
11.4 "Ingredienten" (comment -> text)
12.4 open div (comment -> div)
13.4 Ingredient (dropdown: ingredients)
14.4 Hoeveelheid (numeric)
15.4 Measure (dropdown: measures, depends on ingredient) (no label)
16.4 "Maateenheid toevoegen" (comment -> button)
17.4 close div (comment -> div)
18.4 "Ingredient toevoegen" (comment -> button)
19.4 "Bereidingswijze" (comment -> text)
20.4 open div (comment -> div)
21.4 Stap Bereidingswijze (textarea)
22.4 close div (comment -> div)
23.4 "Meer stappen toevoegen" (comment -> button)
24.5 Maateenheid (text)
25.5 Hoeveelheid (numeric)
26.5 (unit) (dropdown) (no label)
27.6 Naam (text)
28.6 Email (email)
29.6 Wachtwoord (password)
30.6 Herhaal Wachtwoord (password)
31.6 Profielfoto (file) (optional)
*/

-- Code for inserting fields:
-- TODO missing field: for how many people is the recipe?
INSERT INTO fields (id, form_id, name, type, label, required, label_class, input_class, error_class, value, validation)
VALUES 
(1, 1, 'email', 'email', 'Email:', 1, 'form-label', 'form-control', 'text-warning', '', 'email_validation'),
(2, 1, 'password', 'password', 'Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'password_validation'),
(3, 2, 'comment', 'textarea', 'Reactie:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(4, 3, 'search', 'search', '', 1, '', 'form-control', 'text-warning', '', 'text_validation'),
(5, 4, 'recipe_name', 'text', 'Naam:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(6, 4, 'recipe_img', 'file', 'Afbeelding:', 1, 'form-label', 'form-control', 'text-warning', '', 'file_validation'),
(7, 4, 'cuisine_choice', 'dropdown', 'Keuken:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation'),
(8, 4, 'type', 'dropdown', 'Type:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation'),
(9, 4, 'recipe_blurb', 'textarea', 'Korte Omschrijving:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validaton'),
(10, 4, 'recipe_description', 'textarea', 'Uitgebreide Omschrijving:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(11, 4, 'ingredient_title', 'comment', '', 0, '', '', '', '', ''),
(12, 4, 'open_ingredient_div', 'comment', '', 0, '', '', '', '', ''),
(13, 4, 'ingredient_choice', 'dropdown', 'Ingrediënt:', 1, 'form-label', 'form-control', 'text-warning', '', 'dropdown_validation'),
(14, 4, 'quantity', 'numeric', 'Hoeveelheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'numeric_validation'),
(15, 4, 'measure_choice', 'dropdown', '', 1, '', 'form-control', 'text-warning', '', 'dropdown_validation'),
(16, 4, 'measure_button', 'comment', '', 0, '', '', '', '', ''),
(17, 4, 'close_ingredient_div', 'comment', '', 0, '', '', '', '', ''),
(18, 4, 'ingredient_button', 'comment', '', 0, '', '', '', '', ''),
(19, 4, 'prep_step_button', 'comment', '', 0, '', '', '', '', ''),
(20, 4, 'open_prep_step_div', 'comment', '', 0, '', '', '', '', ''),
(21, 4, 'prep_step', 'textarea', 'Stap bereidingswijze:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(22, 4, 'close_prep_step_div', 'comment', '', 0, '', '', '', '', ''),
(23, 4, 'prep_step_title', 'comment', '', 0, '', '', '', '', ''),
(24, 5, 'measure', 'text', 'Maateenheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(25, 5, 'measure_quantity', 'numeric', 'Hoeveelheid:', 1, 'form-label', 'form-control', 'text-warning', '', 'numeric_validation'),
(26, 5, 'measure_unit', 'dropdown', '', 1, '', 'form-control', 'text-warning', '', 'dropdown_validation'),
(27, 6, 'username', 'text', 'Naam:', 1, 'form-label', 'form-control', 'text-warning', '', 'text_validation'),
(28, 6, 'email', 'email', 'Email:', 1, 'form-label', 'form-control', 'text-warning', '', 'email_validation'),
(29, 6, 'password', 'password', 'Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'password_validation'),
(30, 6, 'repeat_password', 'password', 'Herhaal Wachtwoord:', 1, 'form-label', 'form-control', 'text-warning', '', 'repeat_password_validation'),
(31, 6, 'profile_picture', 'file', 'Profielfoto:', 0, 'form-label', 'form-control', 'text-warning', '', 'file_validation');


-- Code for additional numerics table
CREATE TABLE IF NOT EXISTS `fields_numeric` (
    `field_id` INT(11) UNSIGNED PRIMARY KEY,
    `min_value` INT(11),
    `max_value` INT(11),
    FOREIGN KEY (`field_id`) REFERENCES `fields`(`id`)
);

INSERT INTO `fields_numeric` (`field_id`, `min_value`, `max_value`)
VALUES
(14, 1, NULL),
(25, 1, NULL);


-- Code for additional comment table
CREATE TABLE IF NOT EXISTS `fields_comments` (
    `field_id` INT(11) UNSIGNED PRIMARY KEY,
    `text` TEXT,
    FOREIGN KEY (`field_id`) REFERENCES `fields`(`id`)
);

INSERT INTO `fields_comments` (`field_id`, `text`)
VALUES
(11, '<p>Ingrediënten:</p>'),
(12, '<div>'),
(16, '<button>Maateenheid Toevoegen</button>'),
(17, '</div>'),
(18, '<button>Ingrediënt Toevoegen</button>'),
(19, '<p>Bereidingswijze:</p>'),
(20, '<div>'),
(22, '</div>'),
(23, 'Stap Toevoegen');
