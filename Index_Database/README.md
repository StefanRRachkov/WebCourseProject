# Database

The project contains 5 tables: Users, Ref_Library, Pending_Refs, Owned_Refs, Exported_Refs. There is a visual representation of the relations in the initial readme: https://github.com/gospodinove/WebCourseProject#readme

## Tables - Version 1.01
### USERS
| Column_Name | Type | Constraint |
|:--:|:--:|:--:|
| User_ID | Integer | Primary Key |
| Password | String | - |
| E-Mail | String | Unique |

### REF_LIBRARY
| Column_Name | Type | Constraint |
|:--:|:--:|:--:|
| Book_ID | Integer | Primary Key |
| Title | String | - |
| Ref | String | - |
| Max_Exports | Integer | - |

### OWNED_REFS
| Column_Name | Type | Constraint |
|:--:|:--:|:--:|
| User_ID | Integer | Primary Key Composition Part & Foreign Key To USERS |
| Book_ID | Integer | Primary Key Composition Part & Foreign Key To REF_LIBRARY |
| Duration | Integer | - |

### EXPORTED_REFS
| Column_Name | Type | Constraint |
|:--:|:--:|:--:|
| Book_ID | Integer | Foreign Key To REF_LIBRARY |
| Exports | Integer | - |

### PENDING_REFS
| Column_Name | Type | Constraint |
|:--:|:--:|:--:|
| Pending_ID | Integer | Primary Key |
| IMPUser_ID | Integer | Foreign Key To USERS |
| Title | String | - |
| File | String | - |

## How-To
### Create a DB Server
#### * MSSQL 
Try downloading MS SQL Server Management Studio and it will forward you to SQL Server. There is tutorial with everything needed.
#### * MySQL
A helpful tutorial - https://docs.oracle.com/en/java/java-components/advanced-management-console/2.22/install-guide/mysql-database-installation-and-configuration-advanced-management-console.html#JSAMI-GUID-12323233-07E3-45C2-B77A-F35B3BBA6592
### Create the Database
#### * Initial Step
Pull InitialScript.sql and execute just:
`CREATE DATABASE WEB_TAKE_A_REF;`
#### * Create the tables
After the initial step, run the rest of the script and all the tables should be ready to go
### Identity Error
In case of error with Identity(1,1). Change all from Identity(1,1) to AUTO_INCREMENT and everything should be fine
### Use Versions
Look at which version is your script, if there is new one, pull the update script and apply the updates. The other way is to use `DROP DATABASE WEB_TAKE_A_REF` and create the new one with the latest version.
