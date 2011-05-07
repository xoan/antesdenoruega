DROP TABLE IF EXISTS blocks;
CREATE TABLE blocks (
	id integer primary key autoincrement,
	name varchar(100),
	friendly_name varchar(100) unique,
	mid_point_longitude float,
	mid_point_latitude float
);
