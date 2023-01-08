/*
 *   Copyright (c) 2023 Mahesh Gupta
 *   All rights reserved.
 */
-- schema for blog's mysql database

drop database if exists `simple_blog`;

create database `simple_blog` character set UTF8 collate utf8_bin; 

use `simple_blog`;

create table `users` (
	id int(32) not null AUTO_INCREMENT primary key,
	username varchar(64) not null unique key,
	email varchar(255) not null unique key,
	password varchar(64) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table blog (
	id int(64) not null AUTO_INCREMENT primary key,
	userid int(32) not null,
	title varchar(256) not null,
	content longtext null,
	last_modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	FOREIGN KEY (userid) references users(id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table comments (
	id int(64) not null AUTO_INCREMENT primary key,
	userid int(32) not null,
	blogid int(64) not null,
	comment text not null,
	last_modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	FOREIGN KEY (userid) references users(id),
	FOREIGN KEY (blogid) references blog(id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;