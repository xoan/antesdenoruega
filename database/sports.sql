CREATE TABLE sports (
	id integer primary key auto_increment,
	name varchar(100),
	location varchar(255),
	block_id integer,
	lat decimal(11, 8),
	lon decimal(11, 8),
	FOREIGN KEY (block_id) REFERENCES blocks(id)
);
