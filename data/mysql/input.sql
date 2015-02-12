drop database if exists JdManager;
create database JdManager;

use JdManager;


CREATE TABLE IF NOT EXISTS t_user(
	userId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	password VARCHAR(128) NOT NULL,
	randKeys VARCHAR(128) NOT NULL,
	name VARCHAR(128) NOT NULL,
	type VARCHAR(32) NOT NULL,
	createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifyTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_account(
	accountId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	userId int(5) NOT NULL,
	name VARCHAR(128) NOT NULL,
	money int(128) NOT NULL,
	type VARCHAR(32) NOT NULL,
	categoryId int(5) NOT NULL,
	cardId int(5) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifyTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_card(
	cardId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	userId int(5) NOT NULL,
	name VARCHAR(128) NOT NULL,
	money int(128) NOT NULL,
	card VARCHAR(128) NOT NULL,
	bank VARCHAR(128) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifyTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_category(
	categoryId int(5) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	userId int(5) NOT NULL,
	name VARCHAR(128) NOT NULL,
	remark VARCHAR(128) NOT NULL,
	createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifyTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS ci_sessions(
	session_id VARCHAR(128) PRIMARY KEY NOT NULL, 
	ip_address VARCHAR(128) NOT NULL,
	user_agent VARCHAR(128) NOT NULL,
	last_activity INT(64) NOT NULL,
	user_data TEXT DEFAULT '' NOT NULL
)default charset=utf8mb4;

INSERT INTO t_user set userId=10001, password=sha1('123234534526860294839104891939'), randKeys='234534526860294839104891939', name='jd', type='0';
INSERT INTO t_account set accountId=10001, userId=10001, name='account1', money=0,type='1',categoryId=10001,cardId=10001,remark='account1';
INSERT INTO t_card set cardId=10001,userId=10001,name='card1',money=0,card='',bank='bank1',remark='card1';
INSERT INTO t_category set categoryId=10001,userId=10001,name='category1',remark='category1'; 
