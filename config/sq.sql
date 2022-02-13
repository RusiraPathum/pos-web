DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
    `userId` int AUTO_INCREMENT,
    `name` varchar(450) DEFAULT NULL,
    `email` varchar(450) DEFAULT NULL,
    `password` varchar(450) DEFAULT NULL,
    `email_verification_link` varchar(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL,
    PRIMARY KEY (`userId`)
);
