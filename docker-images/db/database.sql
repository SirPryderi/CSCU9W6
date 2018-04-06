DROP TABLE IF EXISTS users;

create table users
(
  id       serial primary key,
  email    varchar(50) unique not null,
  name     varchar(50)        not null,
  password varchar(128)       not null,
  salt     varchar(128)       not null
);