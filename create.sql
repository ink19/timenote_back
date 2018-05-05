CREATE TABLE IF NOT EXISTS `user` (
    `uid` INT UNSIGNED AUTO_INCREMENT,
    PRIMARY KEY (`uid`),
    `username` TEXT,
    `phone` VARCHAR(11),
    `email` TEXT,
    `password` VARCHAR(64),
    `img` TEXT
);
