/*==============================================================*/

/* Nom de SGBD :  MySQL 5.0                                     */

/* Date de cr�ation :  22/11/2023 09:23:15                     */

/*==============================================================*/

drop database if exists TODOLIST;

/*==============================================================*/

/* Database : todolist                                          */

/*==============================================================*/

create database
    TODOLIST character set utf8mb4 collate utf8mb4_0900_ai_ci;

use TODOLIST;

drop table if exists TODO;

drop table if exists USER;

/*==============================================================*/

/* Table : TODO                                                 */

/*==============================================================*/

create table
    TODO (
        TODO_ID int not null auto_increment,
        USER_ID int not null,
        TODO_CONTENT char(255) not null,
        TODO_CREATED_AT datetime not null,
        primary key (TODO_ID)
    ) engine = InnoDB;

/*==============================================================*/

/* Table : USER                                                 */

/*==============================================================*/

create table
    USER (
        USER_ID int not null auto_increment,
        USER_NAME char(255) not null,
        USER_PASSWORD char(255) not null,
        primary key (USER_ID),
        unique(USER_NAME)
    ) engine = InnoDB;

alter table TODO
add
    constraint FK_AVOIR foreign key (USER_ID) references USER (USER_ID) on delete restrict on update restrict;