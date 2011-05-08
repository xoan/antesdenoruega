DROP TABLE IF EXISTS blocks;
CREATE TABLE blocks (
	id integer primary key autoincrement,
	name varchar(100),
	friendly_name varchar(100) unique,
	lon_avg float,
	lat_avg float
);
