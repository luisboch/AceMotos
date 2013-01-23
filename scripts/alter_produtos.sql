alter table produtos add column exibir_index boolean default false;
update produtos set exibir_index = false;
alter table produtos modify column exibir_index boolean not null default false;