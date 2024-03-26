CREATE TABLE ingredient (
    id           int NOT NULL,
    name         varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE ingredient
    ADD PRIMARY KEY (id),
    MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE package (
    id               int NOT NULL,
    ingredient_id int NOT NULL,
    descr         varchar(30) COLLATE utf8_bin NOT NULL,
    factor         double NOT NULL,
    price         double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE package
    ADD PRIMARY KEY (id),
    MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ADD CONSTRAINT fk_ingredient_id FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE RESTRICT ON UPDATE CASCADE;

INSERT INTO ingredient (id, name) VALUES
    (1, 'Melk'),
    (2, 'Suiker');

INSERT INTO package (id,ingredient_id,descr,factor, price) VALUES
    (1,1,'Halve liter pak',500,0.60),
    (2,1,'Liter pak',1000,1.15),
    (3,1,'2 liter container',2000,2.20),
    (4,1,'Hele koe',5000,5.25),
    (5,2,'Doos 100 klontjes',200,1.50),
    (6,2,'Pak 1 kg',1000,2.00);

SELECT 
    descr, 
    factor, 
    price, 
    (factor/800) AS fit,
    CEIL(800/factor) AS numpacks,
    (CEIL(800/factor)factor)-800 AS left,
    CASE
        WHEN (factor/800) >= 1 THEN price
        ELSE CEIL(800/factor)price 
    END AS cost 
FROM package WHERE ingredient_id=1 ORDER BY cost ASC;

SELECT 
    descr, 
    factor, 
    price, 
    (factor/1500) AS fit,
    CEIL(1500/factor) AS numpacks,
    (CEIL(1500/factor)factor)-1500 AS left,
    CASE
        WHEN (factor/1500) >= 1 THEN price
        ELSE CEIL(1500/factor)price 
    END AS cost 
FROM package WHERE ingredient_id=1 ORDER BY cost ASC;


--Largest fit :
--Begin met NEEDED, herhaal met LEFT totdat niets gevonden:
SELECT 
    1500 AS needed
    descr, 
    factor, 
    price, 
    FLOOR(1500/factor) AS numpacks,
    1500-(FLOOR(1500/factor)*factor) AS left
FROM package WHERE ingredient_id=1 AND FLOOR(1500/factor) > 0 ORDER BY factor DESC, left ASC LIMIT 1;

--Best for rest :
--Zoek dan best voor LEFT
SELECT 
    400 AS needed
    descr, 
    factor, 
    price, 
    (factor-400) AS teveel
FROM package WHERE ingredient_id=1 ORDER BY (factor-400) ASC LIMIT 1;