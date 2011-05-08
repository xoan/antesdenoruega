DROP TABLE IF EXISTS blocks;
CREATE TABLE blocks (
	id integer primary key auto_increment,
	name varchar(100),
	friendly_name varchar(100) unique,
	lat_avg decimal(11, 8),
	lon_avg decimal(11, 8)
);
DROP TABLE IF EXISTS sports;
CREATE TABLE sports (
	id integer primary key auto_increment,
	name varchar(100),
	location varchar(255),
	block_id integer,
	lat decimal(11, 8),
	lon decimal(11, 8)
);
DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id integer primary key auto_increment,
	name varchar(50) unique,
	password varchar(80),
	email varchar(255) unique,
	block_id integer
);
