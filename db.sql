--CREATE DATABASE chatterbox;
--CREATE USER chatterbox_user WITH PASSWORD 'user' SUPERUSER;

CREATE TABLE Users (
	user_id SERIAL
	PRIMARY KEY,
	
	login VARCHAR(50)
	NOT NULL
	UNIQUE,
	
	password VARCHAR(255)
	NOT NULL,
	
	cookie VARCHAR(20)
	NULL,
	
	name VARCHAR(50)
	NOT NULL,
	
	surname VARCHAR(50)
	NOT NULL,
	
	profile_photo BOOLEAN
	NULL,
	
	status VARCHAR(255)
	NULL,
	
	last_access_time BIGINT
	NULL
);

CREATE TABLE Conversations (
	conversation_id SERIAL
	PRIMARY KEY,
	
	is_dialog BOOLEAN
	NOT NULL,
	
	name VARCHAR(50)
	NULL
);

CREATE TABLE User_to_conversation (
	user_to_conversation_id SERIAL
	PRIMARY KEY,
	
	user_id INTEGER
	NOT NULL
	REFERENCES Users (user_id),
	
	conversation_id INTEGER
	NOT NULL
	REFERENCES Conversations (conversation_id),
	
	last_read_message_id INTEGER
	NULL
);

CREATE TABLE Messages (
	message_id SERIAL
	PRIMARY KEY,
	
	conversation_id INTEGER
	NOT NULL
	REFERENCES Conversations (conversation_id),
	
	sender_id INTEGER
	NOT NULL
	REFERENCES Users (user_id),
	
	message VARCHAR(255)
	NOT NULL
);

ALTER TABLE User_to_conversation ADD FOREIGN KEY (last_read_message_id) REFERENCES Messages (message_id);

