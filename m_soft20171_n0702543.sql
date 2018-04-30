-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2017 at 08:39 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m_soft20171_n0702543`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cards`
--

DROP TABLE IF EXISTS `tbl_cards`;
CREATE TABLE IF NOT EXISTS `tbl_cards` (
  `cardID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `cardType` varchar(20) NOT NULL,
  `cardNo` varchar(255) NOT NULL,
  `securityNo` int(3) NOT NULL,
  `cardName` varchar(50) NOT NULL,
  `validTo` varchar(7) NOT NULL,
  PRIMARY KEY (`cardID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cards`
--

INSERT INTO `tbl_cards` (`cardID`, `userID`, `cardType`, `cardNo`, `securityNo`, `cardName`, `validTo`) VALUES
(5, 4, 'Mastercard/Eurocard', '86fed20a8c31da04658e8115ed3f3950ff73342211756f45842d36e1fc1010c4', 123, 'S Thompson', '8/2020'),
(6, 4, 'Visa/Delta/Electron', '92325fe38280e6130ca4157520d818e0073e89e0a58685a6a0a3682c93767108', 345, 'S Thompson', '8/2022'),
(7, 3, 'Maestro', 'f280b50bf74dc2102a9e75b084e4ec9029c8bd7e29a25da3151cc9ad8a4a48c5', 745, 'T Smith', '1/2022');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

DROP TABLE IF EXISTS `tbl_cart`;
CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `basketID` int(11) NOT NULL AUTO_INCREMENT,
  `bookID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`basketID`),
  KEY `bookID` (`bookID`),
  KEY `email` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`basketID`, `bookID`, `Quantity`, `userID`) VALUES
(10, 53, 1, 4),
(11, 52, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_genre`
--

DROP TABLE IF EXISTS `tbl_genre`;
CREATE TABLE IF NOT EXISTS `tbl_genre` (
  `GenreID` int(11) NOT NULL AUTO_INCREMENT,
  `GenreName` varchar(100) NOT NULL,
  PRIMARY KEY (`GenreID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_genre`
--

INSERT INTO `tbl_genre` (`GenreID`, `GenreName`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mybooks`
--

DROP TABLE IF EXISTS `tbl_mybooks`;
CREATE TABLE IF NOT EXISTS `tbl_mybooks` (
  `stockID` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `month` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `year` int(4) NOT NULL,
  `publisherID` int(5) NOT NULL,
  `type` enum('Hardback','Paperback') COLLATE latin1_general_ci NOT NULL,
  `subgenreID` int(11) NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `quantity` int(5) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`stockID`),
  KEY `subgenreID` (`subgenreID`),
  KEY `publisherID` (`publisherID`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tbl_mybooks`
--

INSERT INTO `tbl_mybooks` (`stockID`, `author`, `title`, `month`, `year`, `publisherID`, `type`, `subgenreID`, `description`, `quantity`, `unitPrice`, `image`) VALUES
(49, 'Jo Nesbo', 'Police', 'Aug', 2017, 1, 'Hardback', 3, 'The police urgently need Harry Hole\r\n\r\nA killer is stalking Osloâ€™s streets. Police officers are being slain at the scenes of crimes they once investigated, but failed to solve. The murders are brutal, the media reaction hysterical. \r\n\r\nBut this time, Harry canâ€™t help anyone\r\n\r\nFor years, detective Harry Hole has been at the centre of every major criminal investigation in Oslo. His dedication to his job and his brilliant insights have saved the lives of countless people. But now, with those he loves most facing terrible danger, Harry canâ€™t protect anyone.\r\n\r\nLeast of all himself.', 5, '4.00', '58b5ddf15e5472.69494773.png'),
(50, 'Evi Nemeth', 'Linux Administration Handbook', 'Oct', 2006, 1, 'Hardback', 2, 'â€œAs this book shows, Linux systems are just as functional, secure, and reliable as their proprietary counterparts. Thanks to the ongoing efforts of thousands of Linux developers, Linux is more ready than ever for deployment at the frontlines of the real world. The authors of this book know that terrain well, and I am happy to leave you in their most capable hands.â€\r\nâ€•Linus Torvaldsâ€œThe most successful sysadmin book of all timeâ€•because it works!â€\r\nâ€•Rik Farrow, editor of ;login:â€œThis book clearly explains current technology with the perspective of decades of experience in large-scale system administration. Unique and highly recommended.â€\r\nâ€•Jonathan Corbet, cofounder, LWN.netâ€œNemeth et al. is the overall winner for Linux administration: itâ€™s intelligent, full of insights, and looks at the implementation of concepts.â€', 5, '3.00', '58b5df4471ad15.05383323.png'),
(51, 'O&#39;Reilly', 'Linux In A Nutshell', 'Jan', 2009, 1, 'Hardback', 2, 'Everything you need to know about Linux is in this book. Written by Stephen Figgins, Ellen Siever, Robert Love, and Arnold Robbins -- people with years of active participation in the Linux community -- Linux in a Nutshell, Sixth Edition, thoroughly covers programming tools, system and network administration tools, the shell, editors, and LILO and GRUB boot loaders. \r\n\r\nThis updated edition offers a tighter focus on Linux system essentials, as well as more coverage of new capabilities such as virtualization, wireless network management, and revision control with git. It also highlights the most important options for using the vast number of Linux commands. You&#39;ll find many helpful new tips and techniques in this reference, whether you&#39;re new to this operating system or have been using it for years. ', 6, '39.00', '58b5dfd4695608.93506231.png'),
(52, 'Neil Matthew, Richard Stones', 'Beginning Linux Programming', 'Nov', 2007, 1, 'Paperback', 2, 'Beginning Linux Programming, Fourth Edition continues its unique approach to teaching UNIX programming in a simple and structured way on the Linux platform. Through the use of detailed and realistic examples, students learn by doing, and are able to move from being a Linux beginner to creating custom applications in Linux. The book introduces fundamental concepts beginning with the basics of writing Unix programs in C, and including material on basic system calls, file I/O, interprocess communication (for getting programs to work together), and shell programming. Parallel to this, the book introduces the toolkits and libraries for working with user interfaces, from simpler terminal mode applications to X and GTK+ for graphical user interfaces. Advanced topics are covered in detail such as processes, pipes, semaphores, socket programming, using MySQL, writing applications for the GNOME or the KDE desktop, writing device drivers, POSIX Threads, and kernel programming for the latest Linux', 3, '23.00', '58b5e3b5983bb3.99701321.png'),
(53, 'Jennifer Niederst', 'Learning Web Design: A Beginner&#39;s Guide to HTML, Graphics, and Beyond', 'Mar', 2001, 1, 'Paperback', 2, 'In Learning Web Design: A Beginner&#39;s Guide to HTML, Graphics, and Beyond, author Jennifer Niederst shares the knowledge she&#39;s gained from years of web design experience, both as a designer and as a teacher. This book starts from the very beginning--defining the Internet, the Web, browsers, and URLs--so you don&#39;t have to have any previous knowledge about how the Web works. Jennifer helps you build the solid foundation in HTML, graphics, and design principles that you need for crafting effective web pages. She also explains the nature of the medium and unpacks the web design process from conceptualization to the final result.Learning Web Design:\r\n\r\nCovers the nuts and bolts of basic HTML, with detailed examples that illustrate how to format text, add graphic elements, make links, create tables and frames, and use color on the Web. In addition to a rundown on each HTML tag, there are tips on using three popular authoring programs: Macromedia Dreamweaver, Adobe GoLive, and Microsoft FrontPag', 3, '7.00', '58b5e62802bfd3.94058314.png'),
(55, 'George R.R. Martin ', 'A Game of Thrones (A Song of Ice and Fire, Book 1)', 'Mar', 2017, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age. A GAME OF THRONES is the first volume in the series.\r\n\r\nâ€˜Completely immersiveâ€™ Guardian\r\n\r\nâ€˜When you play the game of thrones, you win or you die. There is no middle groundâ€™\r\n\r\nSummers span decades. Winter can last a lifetime. And the struggle for the Iron Throne has begun.\r\n\r\nFrom the fertile south, where heat breeds conspiracy, to the vast and savage eastern lands, all the way to the frozen north, kings and queens, knights and renegades, liars, lords and honest men . . . all will play the Game of Thrones.', 4, '6.99', '58e4bccd9d9309.78067201.png'),
(56, 'George R.R. Martin', 'A Clash of Kings (A Song of Ice and Fire, Book 2) ', 'Sep', 2011, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age. A CLASH OF KINGS is the second volume in the series.\r\n\r\nâ€˜Nobody does fantasy quite like Martinâ€™ Sunday Times\r\n\r\nThroughout Westeros, the cold winds are rising.\r\n\r\nFrom the ancient citadel of Dragonstone to the forbidding lands of Winterfell, chaos reigns as pretenders to the Iron Throne of the Seven Kingdoms stake their claims through tempest, turmoil and war.\r\n\r\nAs a prophecy of doom cuts across the sky - a comet the colour of blood and flame - five factions struggle for control of a divided land. Brother plots against brother and the dead rise to walk in the night.\r\n\r\nAgainst a backdrop of incest, fratricide, alchemy and murder, the price of glory is measured in blood.', 5, '6.49', '58e4bcb1ebc416.13762138.png'),
(57, 'George R. R. Martin ', 'Steel and Snow', 'Sep', 2011, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age.\r\n\r\nA STORM OF SWORDS: STEEL AND SNOW is the FIRST part of the third volume in the series.\r\n\r\nâ€˜Martin has captured the imagination of millionsâ€™ Guardian\r\n\r\nWinter approaches Westeros like an angry beast.\r\n\r\nThe Seven Kingdoms are divided by revolt and blood feud. In the northern wastes, a horde of hungry, savage people steeped in the dark magic of the wilderness is poised to invade the Kingdom of the North where Robb Stark wears his new-forged crown. And Robbâ€™s defences are ranged against the South, the land of the cunning and cruel Lannisters, who have his younger sisters in their power.\r\n\r\nThroughout Westeros, the war for the Iron Throne rages more fiercely than ever, but if the Wall is breached, no king will live to claim it.', 7, '6.99', '58e4bf6fa36af0.19965703.png'),
(58, 'George R.R. Martin', 'A Storm of Swords, Part 2: Blood and Gold (A Song of Ice and Fire, Book 3) ', 'Sep', 2011, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age.\r\n\r\nA STORM OF SWORDS: BLOOD AND GOLD is the SECOND part of the third volume in the series.\r\n\r\nâ€˜Colossal, staggering . . . one of the greatsâ€™ SFX\r\n\r\nThe Starks are scattered.\r\n\r\nRobb Stark may be King in the North, but he must bend to the will of the old tyrant Walder Frey if he is to hold his crown. And while his youngest sister, Arya, has escaped the clutches of the depraved Cersei Lannister and her son, the capricious boy-king Joffrey, Sansa Stark remains their captive.\r\n\r\nMeanwhile, across the ocean, Daenerys Stormborn, the last heir of the Dragon King, delivers death to the slave-trading cities of Astapor and Yunkai as she approaches Westeros with vengeance in her heart.', 13, '6.49', '58e4c0311177d9.16215211.png'),
(59, 'George R.R. Martin', 'A Feast for Crows (A Song of Ice and Fire, Book 4)', 'Mar', 2014, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age. A FEAST FOR CROWS is the fourth volume in the series.\r\n\r\nâ€˜Fantasy fictionâ€™s equivalent to THE WIREâ€™ Telegraph\r\n\r\nA Lannister sits upon the Iron Throne.\r\n\r\nBut the days of betrayal and bloodshed are far from over.\r\n\r\nAmong the ashes of war, new conflicts spark to life. Daring new plots and dangerous new alliances are formed which threaten to engulf Westeros.\r\n\r\nBut in this game of thrones, victory will go to those with the sharpest steel and the coldest hearts.', 16, '6.49', '58e4c0e7cd2441.05506065.png'),
(60, 'George R.R. Martin ', 'A Dance With Dragons: Part 1 Dreams and Dust (A Song of Ice and Fire, Book 5) ', 'Mar', 2012, 3, 'Paperback', 1, 'HBOâ€™s hit series A GAME OF THRONES is based on George R R Martinâ€™s internationally bestselling series A SONG OF ICE AND FIRE, the greatest fantasy epic of the modern age.\r\n\r\nA DANCE WITH DRAGONS: DREAMS AND DUST is the FIRST part of the fifth volume in the series.\r\n\r\nâ€˜Richly satisfying and utterly engrossingâ€™ Sunday Times\r\n\r\nIn the aftermath of a colossal battle, new threats are emerging from every direction.\r\n\r\nTyrion Lannister, having killed his father, and wrongfully accused of killing his nephew, King Joffrey, has escaped from Kingâ€™s Landing with a price on his head.\r\n\r\nTo the north lies the great Wall of ice and stone â€“ a structure only as strong as those guarding it. Eddard Stark&#39;s bastard son Jon Snow has been elected 998th Lord Commander of the Nightâ€™s Watch. But Jon has enemies both inside and beyond the Wall. And in the east Daenerys Targaryen struggles to hold a city built on dreams and dust.', 7, '6.99', '58e4c1c9a1ce67.97674659.png'),
(61, 'George R.R. Martin', 'A Dance With Dragons: Part 2 After the Feast (A Song of Ice and Fire, Book 5) ', 'Mar', 2012, 3, 'Paperback', 1, 'The fifth volume, part two of A Song of Ice and Fire, the greatest fantasy epic of the modern age. GAME OF THRONES is now a major Sky Atlantic TV series from HBO, featuring a stellar cast.\r\n\r\nThe future of the Seven Kingdoms hangs in the balance.\r\n\r\nIn Kingâ€™s Landing the Queen Regent, Cersei Lannister, awaits trial, abandoned by all those she trusted; while in the eastern city of Yunkai her brother Tyrion has been sold as a slave. From the Wall, having left his wife and the Red Priestess Melisandre under the protection of Jon Snow, Stannis Baratheon marches south to confront the Boltons at Winterfell. But beyond the Wall the wildling armies are massing for an assaultâ€¦\r\n\r\nOn all sides bitter conflicts are reigniting, played out by a grand cast of outlaws and priests, soldiers and skinchangers, nobles and slaves. The tides of destiny will inevitably lead to the greatest dance of all.\r\nNOTE :This is not a new book , but a new release of a previously published book.', 28, '7.99', '58e4c25a08a4c1.25896466.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

DROP TABLE IF EXISTS `tbl_orders`;
CREATE TABLE IF NOT EXISTS `tbl_orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `bookID` varchar(200) NOT NULL,
  `Quantity` varchar(200) NOT NULL,
  `userID` int(11) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `Email` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`orderID`, `bookID`, `Quantity`, `userID`, `Total`) VALUES
(5, '52, 51', '2, 1', 3, '85.00'),
(6, '55, 56, 57, 58, 59, 60, 61', '1, 1, 1, 1, 1, 1, 1', 4, '50.43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_publishers`
--

DROP TABLE IF EXISTS `tbl_publishers`;
CREATE TABLE IF NOT EXISTS `tbl_publishers` (
  `publisherid` int(11) NOT NULL AUTO_INCREMENT,
  `publishername` varchar(50) NOT NULL,
  PRIMARY KEY (`publisherid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_publishers`
--

INSERT INTO `tbl_publishers` (`publisherid`, `publishername`) VALUES
(1, 'Penguin_Books'),
(2, 'Pan Macmillan'),
(3, 'Harper Voyager');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subgenre`
--

DROP TABLE IF EXISTS `tbl_subgenre`;
CREATE TABLE IF NOT EXISTS `tbl_subgenre` (
  `subgenreID` int(11) NOT NULL AUTO_INCREMENT,
  `genreID` int(11) NOT NULL,
  `subgenreName` varchar(100) NOT NULL,
  PRIMARY KEY (`subgenreID`),
  KEY `genreID` (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subgenre`
--

INSERT INTO `tbl_subgenre` (`subgenreID`, `genreID`, `subgenreName`) VALUES
(1, 1, 'Adventure'),
(2, 2, 'Education'),
(3, 1, 'Crime'),
(4, 1, 'Fantasy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `Fullname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Address1` varchar(20) DEFAULT NULL,
  `Town` varchar(20) DEFAULT NULL,
  `Postcode` varchar(9) DEFAULT NULL,
  `City` varchar(100) NOT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `aLevel` int(1) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `Fullname`, `Email`, `Password`, `Address1`, `Town`, `Postcode`, `City`, `Country`, `aLevel`) VALUES
(1, 'Dom Hart', 'dom@test.com', '$2y$10$0nJwxBHgFUsqi..iBr6HEuc/fedyTTV7yzStLu4yMgUwtlrXCwTKS', '5 Street Name', '', '', 'Nottingham', '', 1),
(3, 'Ted Smith', 'tsmith@test.com', '$2y$10$fWuX4.b7MQJEmdOLjoCqt.Dd0tagRy3i7K.WTjNAdtSSZ9xRLFbMi', '5 Street Name', 'Clifton', 'NG9N 54S', 'Nottingham', 'United Kingdom', 0),
(4, 'Sarah Thompson', 'sthompson@email.co.uk', '$2y$10$R/Rp/PI.ECGzS3gFV7IO2uDdVY00ZPH0zHhS508Y4KFxcMYf3ekmu', '5 Street Name', 'Toton', 'NG8 5JG', 'Nottingham', 'United Kingdom', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_mybooks`
--
ALTER TABLE `tbl_mybooks`
  ADD CONSTRAINT `tbl_mybooks_ibfk_1` FOREIGN KEY (`publisherID`) REFERENCES `tbl_publishers` (`publisherid`),
  ADD CONSTRAINT `tbl_mybooks_ibfk_2` FOREIGN KEY (`subgenreID`) REFERENCES `tbl_subgenre` (`subgenreID`);

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `tbl_users` (`userID`);

--
-- Constraints for table `tbl_subgenre`
--
ALTER TABLE `tbl_subgenre`
  ADD CONSTRAINT `FK_GenreID` FOREIGN KEY (`genreID`) REFERENCES `tbl_genre` (`GenreID`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
