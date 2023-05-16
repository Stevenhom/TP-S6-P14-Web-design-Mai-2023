create database IA;
alter database IA owner to gestion;

\c IA gestion

create table admin(
    idadmin serial primary key,
    pseudo varchar(30),
    name varchar(50),
    pass varchar(20)
);

insert into admin(pseudo,name,pass) values('Admin 01','admin@admin','123456');
insert into admin(pseudo,name,pass) values('Steven Raz','steven@gmail.com','654321');

create table Contenu(
  idcontent serial primary key,
  Titre varchar(50),
  picture varchar(50),
  description text  
);

create table categorie(
    idcategory serial primary key,
    label varchar(50),
    idcontent int,
    foreign key (idcontent) references contenu(idcontent)
);

create table domaine(
    iddomaine serial primary key,
    label varchar(50),
    idcontent int,
    foreign key (idcontent) references contenu(idcontent)
);

create table deleted(
    iddeleted serial primary key,
    titre varchar(50),
    picture varchar(50),
    description text,
    daty timestamp not null default now()
);

create table personality(
    idperso serial primary key,
    name varchar(30),
    nationality varchar(50),
    age int,
    poste varchar(100),
    innovation varchar(100),
    picture varchar(50)
);