-- ----------------------------
--  Table structure for tblvideos
-- ----------------------------
DROP TABLE IF EXISTS tblvideos;
CREATE TABLE tblvideos (
	 videoId int auto_increment primary key,
	 title varchar(200) not null,
	 director varchar(100) not null,
	 duration integer,
	 synopsis text,
	 genre varchar(50) not null,
	 website varchar(200) null,
	 releaseDate date not null
);
