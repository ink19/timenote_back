CREATE TABLE IF NOT EXISTS `user` (
    `uid` INT UNSIGNED AUTO_INCREMENT,
    PRIMARY KEY (`uid`),
    `username` TEXT,
    `phone` VARCHAR(11),
    `email` TEXT,
    `password` VARCHAR(64),
    `img` TEXT
);

CREATE TABLE IF NOT EXISTS `note` (
    `nid` INT UNSIGNED AUTO_INCREMENT,
    PRIMARY KEY (`nid`),
    `title` TEXT,
    `labels` TEXT,
    `content` TEXT,
    `create_time` INT,
    `modify_time` INT,
    `uid` INT,
    `status` INT
);