-- Version 1.01
-- EXECUTE FIRST TO CREATE THE DATABASE:
CREATE DATABASE WEB_TAKE_A_REF;

USE WEB_TAKE_A_REF;

-- CREATE USER TABLE
-- IF IT DOESN'T WORK ON YOUR SQL STUDIO
-- CHANGE IDENTITY(1, 1) TO AUTO_INCREMENT

CREATE TABLE USERS(
	[User_ID]		INT	NOT NULL IDENTITY(1, 1),
	[Password]		NVARCHAR(100) NOT NULL,
	[E-Mail]		NVARCHAR(100) NOT NULL,

	PRIMARY KEY([User_ID]),
	UNIQUE([E-Mail])
);

-- CREATE LIBRARY TABLE
-- IF IT DOESN'T WORK ON YOUR SQL STUDIO
-- CHANGE IDENTITY(1, 1) TO AUTO_INCREMENT

CREATE TABLE REF_LIBRARY(
	[Book_ID]		INT NOT NULL IDENTITY(1, 1),
	[Title]			NVARCHAR(100) NOT NULL,
	[Ref]			NVARCHAR(100) NOT NULL,
	[Max_Exports]	INT NOT NULL

	PRIMARY KEY([Book_ID])
);

-- CREATE OWNED BOOKS TABLE
-- CONSTRAINT ONE USER CAN RENT ONE REF ONLY ONCE

CREATE TABLE OWNED_REFS(
	[User_ID]		INT NOT NULL FOREIGN KEY REFERENCES USERS([User_ID]),
	[Book_ID]		INT NOT NULL FOREIGN KEY REFERENCES REF_LIBRARY([Book_ID]),
	[Duration]		INT NOT NULL,

	CONSTRAINT PK_Composite_User_Books PRIMARY	KEY([User_ID], [Book_ID])
);

-- CREATE EXPORTED BOOKS TABLE

CREATE TABLE EXPORTED_REFS(
	[Book_ID]		INT NOT NULL FOREIGN KEY REFERENCES REF_LIBRARY([Book_ID]),
	[Exports]		INT NOT NULL,
);

-- CREATE PENDING BOOKS TABLE
-- IF IT DOESN'T WORK ON YOUR SQL STUDIO
-- CHANGE IDENTITY(1, 1) TO AUTO_INCREMENT

-- IMPUser_ID IS THE ID OF THE USER THAT IMPORTS THE BOOK

CREATE TABLE PENDING_REFS(
	[Pedning_ID]		INT NOT NULL IDENTITY(1, 1),
	[IMPUser_ID]		INT NOT NULL FOREIGN KEY REFERENCES USERS([User_ID]),
	[Title]			NVARCHAR(100) NOT NULL,
	[File]			NVARCHAR(100) NOT NULL,

	PRIMARY KEY([Pedning_ID])
);
