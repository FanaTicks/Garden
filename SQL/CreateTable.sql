use Garden
go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Acount' AND type_desc = 'USER_TABLE')
drop table Acount
go
CREATE TABLE Acount(
    Id_Acount INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Login_Acount CHAR(100),
    Password_Acount CHAR(100),
	Hash_Acount varchar(32) NOT NULL default '',
    Ip_Acount INT  NOT NULL default '0'
);

go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Sowing' AND type_desc = 'USER_TABLE')
drop table Sowing
go
CREATE TABLE Sowing(
    Id_Sowing INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Name_Sowing CHAR(100),
    Description_Sowing CHAR(1000),
	Number_Of_Plots_Area INT,
	ID_Acount INT NOT NULL,
    FOREIGN KEY (ID_Acount) References Acount (Id_Acount) ON DELETE CASCADE
);

go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Area' AND type_desc = 'USER_TABLE')
drop table Area
go
CREATE TABLE Area(
    Id_Area INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Name_Area CHAR(100),
    Number_Of_Lines_Area INT,
	ID_Sowing INT NOT NULL,
    FOREIGN KEY (ID_Sowing) References Sowing (Id_Sowing) ON DELETE CASCADE
);

go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Culture' AND type_desc = 'USER_TABLE')
drop table Culture
go
CREATE TABLE Culture(
    Id_Culture INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Name_Culture CHAR(100)
);

go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Seed' AND type_desc = 'USER_TABLE')
drop table Seed
go
CREATE TABLE Seed(
    Id_Seed INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Name_Seed CHAR(100)
);

go
IF EXISTS(SELECT name FROM sys.objects
WHERE name = 'Line' AND type_desc = 'USER_TABLE')
drop table Line
go
CREATE TABLE Line(
    Id_Line INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	ID_Seed INT NOT NULL,
	ID_Area INT NOT NULL,
	ID_Culture INT NOT NULL,
	FOREIGN KEY (ID_Culture) References Culture (Id_Culture) ON DELETE CASCADE,
	FOREIGN KEY (ID_Seed) References Seed (ID_Seed) ON DELETE CASCADE,
    FOREIGN KEY (ID_Area) References Area (Id_Area) ON DELETE CASCADE
);