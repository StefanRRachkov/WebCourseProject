-- UPDATE VERSION 1.01 

-- UPDATE: Remove Username column in USERS
-- ADD UNIQUE INDEX(E-Mail) to track 
-- unique accounts. ID is not enough at current 
-- architecture

USE WEB_TAKE_A_REF;

-- We don't need Username Column
ALTER TABLE USERS
DROP COLUMN Username;

-- For MSSQL use this query
ALTER TABLE USERS
ADD CONSTRAINT UQ_Account UNIQUE ([E-Mail]); 

-- For MySQL use this query
ALTER TABLE USERS
ADD UNIQUE (EMail);