DROP TABLE IF EXISTS blocks;
CREATE TABLE blocks (
	id integer primary key auto_increment,
	name varchar(100),
	friendly_name varchar(100) unique,
	lon_avg numeric,
	lat_avg numeric
);
