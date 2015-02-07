drop database if exists JdManager;
create database JdManager;

use JdManager;


CREATE TABLE IF NOT EXISTS t_user(
	userId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	password VARCHAR(128) NOT NULL,
	name VARCHAR(128) NOT NULL,
	type VARCHAR(32) NOT NULL,
	createTime DATETIME NOT NULL,
	modifyTime DATETIME NOT NULL 
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_account(
	accountId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	money int(128) NOT NULL,
	type VARCHAR(32) NOT NULL,
	categoryId int(5) NOT NULL,
	cardId int(5) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime DATETIME NOT NULL,
	modifyTime DATETIME NOT NULL
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_card(
	cardId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	bank VARCHAR(128) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime DATETIME NOT NULL,
	modifyTime DATETIME NOT NULL
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_category(
	categoryId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime DATETIME NOT NULL,
	modifyTime DATETIME NOT NULL
)default charset=utf8mb4;

INSERT INTO t_user set userId=10001, password=sha1('123'), name='jd', type='管理员', createTime=NOW(), modifyTime=NOW();
