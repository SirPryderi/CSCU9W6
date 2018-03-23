DROP TABLE IF EXISTS users;

create table users
(
  id       serial primary key ,
  email    varchar(50) unique ,
  password varchar(128),
  salt     varchar(128)
);