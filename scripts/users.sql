 create table users(
  id integer auto_increment primary key,
  name varchar(100),
  username varchar(100),
  email varchar(100),
  cpf varchar(100),
  `group` integer,
  `password` varchar(255)
);
