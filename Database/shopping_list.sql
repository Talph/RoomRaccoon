CREATE DATABASE room_raccoon_shopping_list;
use room_raccoon_shopping_list;

CREATE TABLE IF NOT EXISTS `users`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `name`       varchar(100) NOT NULL,
    `username`   varchar(45)  NOT NULL UNIQUE,
    `password`   varchar(255) NOT NULL,
    `created_at` datetime     NOT NULL,
    `updated_at` datetime     NULL,
    `deleted_at` datetime     NULL,

    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `shopping_lists`
(
    `id`          int      NOT NULL AUTO_INCREMENT,
    `user_id`     int      NOT NULL,
    `title`       varchar(100) NOT NULL,
    `description` text     NULL,
    `created_at`  datetime NOT NULL,
    `updated_at`  datetime NULL,
    `deleted_at`  datetime NULL,

    PRIMARY KEY (`id`),
    KEY `FK_2` (`user_id`),
    CONSTRAINT `FK_3` FOREIGN KEY `FK_2` (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `shopping_items`
(
    `id`               int            NOT NULL AUTO_INCREMENT,
    `shopping_list_id` int            NOT NULL,
    `name`             varchar(255)   NOT NULL,
    `description`      varchar(255)   NOT NULL,
    `price`            decimal(10, 4) NULL,
    `quantity`         int(11)        NOT NULL,
    `is_checked`       int(11)        NULL DEFAULT 0,
    `created_at`       datetime       NOT NULL,
    `updated_at`       datetime       NULL,
    `deleted_at`       datetime       NULL,

    PRIMARY KEY (`id`),
    KEY `FK_2` (`shopping_list_id`),
    CONSTRAINT `FK_1` FOREIGN KEY `FK_2` (`shopping_list_id`) REFERENCES `shopping_lists` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);


INSERT INTO users(name, username, password, created_at, updated_at)
VALUES ('Suvin Abrahams', 'suvin', '$2y$10$S2uKzzZvX2.7.7kevzcy.eQnDD8rErjZznA95mr88s4Gr4eVp9t.q',
        '2023-04-01 16:01:26', '2023-04-01 16:01:26');

