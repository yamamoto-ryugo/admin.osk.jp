create database osk;
use osk

create table user (
  id int not null auto_increment primary key,
  login_id varchar(255),
  name1 varchar(255),
  name2 varchar(255),
  office varchar(255),
  password varchar(255),
  created datetime,
  modified datetime
);
