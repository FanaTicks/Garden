go
IF EXISTS (SELECT name FROM sys.objects
WHERE name = 'Garden' AND type_desc = 'USER_DATABASE')
drop database Garden
go
CREATE DATABASE Garden