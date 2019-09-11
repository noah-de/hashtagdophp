CREATE TABLE person (
	student_id	CHAR(8) KEY,
	social_media_id	SMALLINT KEY,
	
	name		VARCHAR(128), --READONLY
	role		VARCHAR(8), --READONLY
	year		SMALLINT, --READONLY
	dorm		CHAR, --READONLY
	room_num 	CHAR, --READONLY
	ms_num		SMALLINT, --READONLY
	phone_num	VARCHAR(24),
	email		VARCHAR(128),
	primary_contact	TINYINT, --or VARCHAR(16)
	times_searched	INT,
	profile_pic	VARCHAR(256),	
) PRIMARY KEY (social_media);

CREATE TABLE student_privacy (
	student_id	CHAR(8) KEY,
	
	name		BOOL DEFAULT 1,
	role		BOOL DEFAULT 1,
	year		BOOL DEFAULT 0,
	dorm		BOOL DEFAULT 0,
	room_num	BOOL DEFAULT 0,
	ms_num		BOOL DEFAULT 0,
	social_media	BOOL DEFAULT 0
) PRIMARY KEY (social_media);

CREATE TABLE social_media (
	social_media_id	SMALLINT KEY,
	
	stalkernet	BOOL,
	facebook	VARCHAR(128),
	instagram	VARCHAR(128),
	twitter		VARCHAR(128),
	snapchat	VARCHAR(128),
	groupme		VARCHAR(128)
) PRIMARY KEY (social_media);

