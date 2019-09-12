CREATE TABLE person (
	student_id		CHAR(8) KEY,
	
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
	profile_pic		VARCHAR(256) NOT NULL
) UNIQUE (student_id) PRIMARY KEY (student_id);

CREATE TABLE student_privacy (
	student_id		CHAR(8) KEY,
	
	name			BOOL DEFAULT 1 NOT NULL,
	role			BOOL DEFAULT 1 NOT NULL,
	year			BOOL DEFAULT 0 NOT NULL,
	dorm			BOOL DEFAULT 0 NOT NULL,
	room_num		BOOL DEFAULT 0 NOT NULL,
	ms_num			BOOL DEFAULT 0 NOT NULL,
	social_media	BOOL DEFAULT 0 NOT NULL,
	roommates		BOOL DEFAULT 0 NOT NULL
) UNIQUE (student_id) PRIMARY KEY (student_id);

CREATE TABLE social_media (
	student_id		CHAR(8) KEY,
	
	stalkernet		BOOL NOT NULL,
	facebook		VARCHAR(128) NOT NULL,
	instagram		VARCHAR(128) NOT NULL,
	twitter			VARCHAR(128) NOT NULL,
	snapchat		VARCHAR(128) NOT NULL,
	groupme			VARCHAR(128) NOT NULL
) UNIQUE (student_id) PRIMARY KEY (student_id);

CREATE TABLE roommate (
	student			CHAR(8),
	roommate		CHAR(8)
);

CREATE TABLE user_login (
	student_id		CHAR(8) KEY,
	
	username		VARCHAR(16),
	hashpass		CHAR(64)
) UNIQUE (student_id, username, hashpass) PRIMARY KEY (student_id);

