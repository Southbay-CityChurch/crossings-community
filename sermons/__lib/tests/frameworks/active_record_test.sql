drop table if exists products; 
create table products ( 
   id int not null auto_increment,
   name varchar(255) not null,
   product_id int not null, 
   quantity int not null default 0, 
   unit_price decimal(10,2) not null, 
   primary key (id) 
); 
