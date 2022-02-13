DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
    `userId` int AUTO_INCREMENT,
    `name` varchar(450) DEFAULT NULL,
    `email` varchar(450) DEFAULT NULL,
    `password` varchar(450) DEFAULT NULL,
    PRIMARY KEY (`userId`)
);
