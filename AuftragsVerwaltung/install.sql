CREATE TABLE `auftraggeber` (  
`id` int(11) NOT NULL AUTO_INCREMENT,  
`name` varchar(255) NOT NULL,  
`adresse` text NOT NULL,  
`status` varchar(200) NOT NULL,  
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1

CREATE TABLE `auftraege` (  
	`id` int(11) NOT NULL AUTO_INCREMENT,  
	`datum` date NOT NULL,  
	`strasse` varchar(255) NOT NULL,  
	`nummer` varchar(20) NOT NULL,
	`plz` varchar(10) NOT NULL,  
	`ort` varchar(255) NOT NULL,  
	`auftraggeber` int(11) NOT NULL, 
	`status` varchar(50) NOT NULL,  
	`adresszusatz` varchar(200) NOT NULL,  
	PRIMARY KEY (`id`),  
	KEY `auftraggeber` (`auftraggeber`),  
	CONSTRAINT `auftraege_ibfk_1` FOREIGN KEY (`auftraggeber`) REFERENCES `auftraggeber` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1