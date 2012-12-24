create table categorias(
    id integer auto_increment primary key,
    descricao varchar(255), 
    categoria_id integer, 
    constraint fk_cat_parent foreign key(categoria_id) references categorias(id)
);
