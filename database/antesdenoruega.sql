DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id integer primary key auto_increment,
	name varchar(50) unique,
	password varchar(80),
	email varchar(255) unique,
	block_id integer,
	FOREIGN KEY (block_id) REFERENCES blocks(id)
);
