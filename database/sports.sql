DROP TABLE IF EXISTS sports;
CREATE TABLE sports (
	id integer primary key auto_increment,
	name varchar(100),
	location varchar(255),
	block_id integer,
	lon numeric,
	lat numeric,
	FOREIGN KEY (block_id) REFERENCES blocks(id)
);
