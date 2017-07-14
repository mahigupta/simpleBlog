/* 
 * schema for blog's mysql database
 */
/**
 * Author:  maheshgupta
 * Created: Jul 11, 2017
 */

drop database if exists `mg_blog`;

create database `mg_blog` character set UTF8 collate utf8_bin; 

use `mg_blog`;

create table `users` (
	id int(32) not null AUTO_INCREMENT primary key,
	username varchar(64) not null unique key,
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