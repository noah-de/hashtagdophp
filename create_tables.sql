CREATE TABLE person (
	student_id	CHAR(8) KEY,
	social_media_id	SMALLINT KEY,
	
	name		VARCHAR(128) NOT NULL, --READONLY
	role		VARCHAR(8) NOT NULL, --READONLY
	year		SMALLINT NOT NULL, --READONLY
	dorm		CHAR NOT NULL, --READONLY
	room_num 	CHAR NOT NULL, --READONLY
	ms_num		SMALLINT NOT NULL, --READONLY
	phone_num	VARCHAR(24) NOT NULL,
	email		VARCHAR(128) NOT NULL,
	primary_contact	TINYINT DEFAULT 0 NOT NULL, --or VARCHAR(16)
	times_searched	INT DEFAULT 0 NOT NULL,
	profile_pic	VARCHAR(256) NOT NULL
) PRIMARY KEY (social_media);

CREATE TABLE student_privacy (
	student_id	CHAR(8) KEY,
	
	name		BOOL DEFAULT 1 NOT NULL,
	role		BOOL DEFAULT 1 NOT NULL,
	year		BOOL DEFAULT 0 NOT NULL,
	dorm		BOOL DEFAULT 0 NOT NULL,
	room_num	BOOL DEFAULT 0 NOT NULL,
	ms_num		BOOL DEFAULT 0 NOT NULL,
	social_media	BOOL DEFAULT 0 NOT NULL
) PRIMARY KEY (social_media);

CREATE TABLE social_media (
	social_media_id	SMALLINT KEY,
	
	stalkernet	BOOL NOT NULL,
	facebook	VARCHAR(128) NOT NULL,
	instagram	VARCHAR(128) NOT NULL,
	twitter		VARCHAR(128) NOT NULL,
	snapchat	VARCHAR(128) NOT NULL,
	groupme		VARCHAR(128) NOT NULL
) PRIMARY KEY (social_media);

