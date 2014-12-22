PRAGMA foreign_keys = false;

-- ----------------------------
--  Table structure for "tblvideos"
-- ----------------------------
DROP TABLE IF EXISTS "tblvideos";
CREATE TABLE "tblvideos" (
	 "videoId" integer PRIMARY KEY AUTOINCREMENT,
	 "directorId" integer,
	 "title" text(200,0),
	 "duration" integer,
	 "synopsis" text(500,0),
	 "genre" text(50,0),
	 "website" text(200,0),
	 "releaseDate" text(8)
);

-- ----------------------------
--  Table structure for "tblvideos"
-- ----------------------------
DROP TABLE IF EXISTS "tbldirectors";
CREATE TABLE "tbldirectors" (
	 "directorId" integer PRIMARY KEY AUTOINCREMENT,
	 "firstName" text(200,0),
	 "lastName" text(100,0),
	 "dateOfBirth" text(8),
	 "nationality" text(100)
);

PRAGMA foreign_keys = true;
