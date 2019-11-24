CREATE TABLE person (
	student_id		CHAR(7) KEY,
	
	firstname		VARCHAR(128) NOT NULL, --READONLY
	lastname		VARCHAR(128) NOT NULL, --READONLY
	role			VARCHAR(8) NOT NULL, --READONLY
	year			SMALLINT NOT NULL, --READONLY
	dorm			CHAR NOT NULL, --READONLY
	room_num 		CHAR NOT NULL, --READONLY
	ms_num			SMALLINT NOT NULL, --READONLY
	phone_num		VARCHAR(24) NOT NULL,
	email			VARCHAR(128) NOT NULL,
	primary_contact	TINYINT DEFAULT 0 NOT NULL, --or VARCHAR(16)
	searched_num	INT DEFAULT 0 NOT NULL,
	profile_pic		VARCHAR(256) NOT NULL,
	preferred_name	VARCHAR(128) DEFAULT NULL,
	alt_email		VARCHAR(128) DEFAULT NULL,
) UNIQUE (student_id) PRIMARY KEY (student_id);

CREATE TABLE student_privacy (
	student_id		CHAR(7) KEY,
	
	name			BOOLEAN DEFAULT true NOT NULL,
	preferred_name	BOOLEAN DEFAULT false NOT NULL,
	year			BOOLEAN DEFAULT true NOT NULL,
	email			BOOLEAN DEFAULT true NOT NULL,
	alt_email		BOOLEAN DEFAULT false NOT NULL,
	phone_num		BOOLEAN DEFAULT true NOT NULL,
	dorm			BOOLEAN DEFAULT true NOT NULL,
	room_num		BOOLEAN DEFAULT true NOT NULL,
	ms_num			BOOLEAN DEFAULT true NOT NULL,
	roommates		BOOLEAN DEFAULT true NOT NULL,
	searched_num	BOOLEAN DEFAULT true NOT NULL
) UNIQUE (student_id) PRIMARY KEY (student_id);

CREATE TABLE roommate (
	student			CHAR(7),
	roommate		CHAR(7)
);

CREATE TABLE user_login (
	student_id		CHAR(7) KEY,
	
	username		VARCHAR(16),
	hashpass		CHAR(64)
) UNIQUE (student_id, username, hashpass) PRIMARY KEY (student_id);

