create table users(
            `id` integer auto_increment primary key,
            `name` varchar(255), 
            `username` varchar(255), 
            `password` varchar(255), 
            `email` varchar(255), 
            `cpf` varchar(255), 
            `group` integer not null
);

insert into users (
    `name`, 
    username, 
    password, 
    email, 
    cpf, 
    `group`
) 
VALUES (
    'Luis Boch', 
    'luisboch', 
    md5(1234), 
    'luis.ctba19@gmail.com', 
    '', 
    1
);