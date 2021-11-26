drop database if exists citas_db;
create database citas_db;
use citas_db;

create table especialidades(
    id_especialidad int primary key not null auto_increment,
    nombre varchar(100)
);

insert into especialidades(nombre) values("Médico general");
insert into especialidades(nombre) values("Dermatología");
insert into especialidades(nombre) values("Oncología");
insert into especialidades(nombre) values("Podología");
insert into especialidades(nombre) values("Oftalmología");
insert into especialidades(nombre) values("Oculista");

create table usuarios(
    id_usuario int primary key not null auto_increment,
    email varchar(100) unique not null,
    rol varchar(10) not null,
    password varchar(100) not null
);

create table medicos(
    id_medico int primary key not null auto_increment,
    nombre_completo varchar(100) not null,
    cedula_profesional varchar(100) not null,
    id_usuario int not null,
    foreign key(id_usuario) references usuarios(id_usuario),
    id_especialidad int not null,
    foreign key(id_especialidad) references especialidades(id_especialidad) 
);

create table pacientes(
    id_paciente int primary key not null auto_increment,
    nombre_completo varchar(100) not null,
    telefono varchar(10) not null,
    id_usuario int not null,
    foreign key(id_usuario) references usuarios(id_usuario)
);


create table horarios(
    id_horario int primary key not null auto_increment,
    fecha date,
    hora_ingreso time,
    hora_salida time,
    id_medico int not null,
    foreign key(id_medico) references medicos(id_medico) 
);

create table citas(
    id_cita int primary key not null auto_increment,
    hora time,
    status varchar(20) default "Activo",
    id_horario int not null,
    foreign key(id_horario) references horarios(id_horario),
    id_medico int not null,
    foreign key(id_medico) references medicos(id_medico),
    id_paciente int not null,
    foreign key(id_paciente) references pacientes(id_paciente)
);