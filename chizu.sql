CREATE DATABASE chizu;

USE chizu;

CREATE TABLE cards (
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    picture VARCHAR(250),
    name VARCHAR(100),
    power INT,
    type VARCHAR(50)
);

CREATE TABLE character_attacks (
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    character_id SMALLINT,
    attack_name VARCHAR(50),
    damage INT,
    FOREIGN KEY (character_id) REFERENCES cards(id)
);

INSERT INTO cards
(picture, name, power, type)
VALUES
("https://i.pinimg.com/originals/9f/f5/b2/9ff5b29a0ed34347713bc6b60092a3cd.jpg", "Maki Zenin", 17, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/6/6f/Yuji_Itadori_%28Anime_2%29.png/revision/latest?cb=20200908071838", "Yuji Itadori", 21, "exorciste"), 
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/d/dd/Nobara_Kugisaki_%28Anime_2%29.png/revision/latest?cb=20201219222346", "Nobara Kugisaki", 28, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/5/5e/Toge_Inumaki_Saison_2.png/revision/latest?cb=20230901121705&path-prefix=fr", "Toge Inumaki", 23, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/4/40/Megumi_Fushiguro_Saison_2.png/revision/latest?cb=20230901120755&path-prefix=fr", "Megumi Fushiguro", 27, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/d/d8/Kento_Nanami_Saison_2_%28Shibuya%29.png/revision/latest?cb=20230901132602&path-prefix=fr", "Kento Nanami", 35, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/0/0f/Satoru_Gojo_Saison_2.png/revision/latest?cb=20221225115403&path-prefix=fr", "Satoru Gojo", 52, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/0/08/Yuta_Okkotsu_0_Film.png/revision/latest/scale-to-width/360?cb=20230901170456&path-prefix=fr", "Yuta Okkotsu", 25, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/7/73/Mei_Mei_%28Anime%29.png/revision/latest?cb=20210201021211", "Mei Mei", 30, "exorciste"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/3/39/Suguru_Geto_0_Film.png/revision/latest?cb=20230901131917&path-prefix=fr", "Suguru Geto", 43, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/d/dd/Mahito_Saison_2.png/revision/latest?cb=20230901132641&path-prefix=fr", "Mahito", 31, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/b/bd/Jogo_Anime.png/revision/latest?cb=20221225114040&path-prefix=fr", "Jogo", 15, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/9/9d/Ryomen_Sukuna_Saison_2.png/revision/latest?cb=20230901132810&path-prefix=fr", "Ryomen Sukuna", 50, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/7/7c/Dagon_Anime.png/revision/latest/scale-to-width/360?cb=20231027085922&path-prefix=fr", "Dagon", 11, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/7/79/Hanami_Anime.png/revision/latest?cb=20221225114030&path-prefix=fr", "Hanami", 21, "fleau"),
( "https://static.wikia.nocookie.net/jujutsu-kaisen/images/d/d2/Nanako_Hasaba_Saison_2.png/revision/latest?cb=20230901132739&path-prefix=fr", "Nanako Hasaba", 12, "fleau"),
( "https://static.wikia.nocookie.net/jujutsu-kaisen/images/1/1f/Mimiko_Hasaba_Saison_2.png/revision/latest?cb=20230901132733&path-prefix=fr", "Mimiko Hasaba", 11, "fleau"),
("https://static.wikia.nocookie.net/jujutsu-kaisen/images/f/f2/Toji_Fushiguro_Saison_2.png/revision/latest?cb=20221225115945&path-prefix=fr", "Toji Fushiguro", 26, "Tueur d'exorciste");

INSERT INTO character_attacks
(character_id, attack_name, damage)
VALUES
(1, "Os de dragon", 10),
(1, "Sabre des âmes",15 ),
(2, "Rayon noir", 15) ,
(2, "Technique intervalle", 10),
(3, "Technique vaudou",12) ,
(3, "Rayon noir", 16),
(4, "Compression", 22),
(4, "Explosion", 24),
(5, "Serpent géant", 18),
(5, "Chiens de jade", 22),
(6, "Rayon noir", 28),
(6, "Epée émousser", 31),
(7, "Pouvoir de l'infini", 41),
(7, "Sixième oeil", 52),
(8, "Sort d'inversion", 22),
(8, "Extension du territoire",29),
(9, "Hache de combat", 23),
(9, "Bird strike", 19),
(10, "Dragon Irisé", 27),
(10, "Femme à la bouche cousue",24),
(11, "Altération absolue", 17),
(11, "Extension du territoire", 20),
(12, "Frelon volcanique", 12),
(12, "Extension du territoire", 19),
(13, "Lacération", 36),
(13, "Extension du territoire", 42),
(14, "Horde silurienne", 13),
(14, "Extension du territoire",15),
(15, "Sort inné", 24),
(15, "Extension du territoire", 28),
(16, "Sort inné", 10),
(16,"Smartphone", 8),
(17, "Sort inné", 10),
(17, "Corde", 12),
(18, "Tête de mouche", 20),
(18, "Sabres", 19);

UPDATE cards
SET picture = "https://i.pinimg.com/originals/b8/63/84/b86384719d650e379804ef0d2b9c4375.jpg"
WHERE id = 3;

CREATE TABLE card_types (
    type_id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    type_name VARCHAR(50)
);

ALTER TABLE cards
ADD COLUMN type_id SMALLINT,
ADD FOREIGN KEY (type_id) REFERENCES card_types(type_id);

INSERT INTO card_types (type_name)
VALUES
("exorciste"),
("fleau"),
("Tueur d'exorciste");












