alter table produtos add column exibir_index boolean default false;
update produtos set exibir_index = false;
alter table produtos modify column exibir_index boolean not null default false;

create table clients(
    id int auto_increment primary key, 
    `name` varchar (200) not null,
    email varchar (200) not null,
    receive_news boolean not null default false,
    register_date timestamp not null,
    registered boolean not null default false,
    validated boolean not null default false,
    timezone varchar (200) not null default 'America/Sao_Paulo',
    country_code varchar (200),
    `type` char not null default 'F',
    `active` boolean not null default true
    
);

CREATE TABLE marcas(
    id INTEGER PRIMARY KEY AUTO_INCREMENT ,
    nome VARCHAR( 100 ) NOT NULL ,
    data_criacao TIMESTAMP NOT NULL DEFAULT NOW( ),
    status boolean default true
);