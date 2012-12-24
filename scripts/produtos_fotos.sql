create table produtos_fotos (
    id integer primary key auto_increment, 
    produto_id integer, 
    ordem integer, 
    tamanho integer, 
    caminho varchar(255), 
    legenda varchar(255)
);