DROP TABLE IF EXISTS sports;
CREATE TABLE sports (
	id integer primary key autoincrement,
	name varchar(100),
	location varchar(255),
	block_id integer,
	lon float,
	lat float,
	FOREIGN KEY (block_id) REFERENCES blocks(id)
);
