<?php
$comma = ",";

$create_admin_table = "CREATE TABLE IF NOT EXISTS admin" .
    "(" .
    "id int not null auto_increment" . $comma .
    "name varchar(50) not null" . $comma .
    "password varchar(255) not null" . $comma .
    "email varchar(100) not null unique" . $comma .
    "phone varchar(30) not null unique" . $comma .
    "address varchar(255) not null" . $comma .
    "status enum('ACTIVE', 'INACTIVE', 'PENDING') default 'PENDING'" . $comma .
    "primary key(id)" .
    ")";

$create_user_table = "CREATE TABLE IF NOT EXISTS user" .
    "(" .
    "id int not null auto_increment" . $comma .
    "name varchar(50) not null" . $comma .
    "password varchar(255) not null" . $comma .
    "email varchar(100) not null unique" . $comma .
    "phone varchar(30) not null unique" . $comma .
    "address varchar(255) not null" . $comma .
    "status enum('ACTIVE', 'INACTIVE', 'PENDING') default 'PENDING'" . $comma .
    "primary key(id)" .
    ")";

$create_pitch_type_table = "CREATE TABLE IF NOT EXISTS pitch_type" .
    "(" .
    "id int not null auto_increment" . $comma .
    "pitch_type_name varchar(50) not null" . $comma .
    "primary key(id)" .
    ")";


$create_pitch_table = "CREATE TABLE IF NOT EXISTS pitch" .
    "(" .
    "id int not null auto_increment" . $comma .
    "pitch_name varchar(50)" . $comma .
    "map varchar(255)" . $comma .
    "address varchar(255)" . $comma .
    "photo1 varchar(255)" . $comma .
    "photo2 varchar(255)" . $comma .
    "photo3 varchar(255)" . $comma .
    "fees int" . $comma .
    "localAttraction varchar(100)" . $comma .
    "pitch_type_id int" . $comma .
    "primary key(id)" . $comma .
    "foreign key (pitch_type_id) references pitch_type(id)" .
    ")";

$create_review_table = "CREATE TABLE IF NOT EXISTS review" .
    "(" .
    "id int not null auto_increment" . $comma .
    "review_info varchar(255)" . $comma .
    "user_id int" . $comma .
    "pitch_id int" . $comma .
    "primary key(id)" . $comma .
    "foreign key (user_id) references user(id)" . $comma .
    "foreign key (pitch_id) references pitch(id)" .
    ")";

$create_booking_table = "CREATE TABLE IF NOT EXISTS booking" .
    "(" .
    "id int not null auto_increment" . $comma .
    "booking_date varchar(100) not null" . $comma .
    "no_of_person int" . $comma .
    "status enum('ACTIVE', 'INACTIVE', 'PENDING') default 'PENDING'" . $comma .
    "user_id int" . $comma .
    "pitch_id int" . $comma .
    "admin_id int" . $comma .
    "primary key(id)" . $comma .
    "foreign key (user_id) references user(id)" . $comma .
    "foreign key (pitch_id) references pitch(id)" . $comma .
    "foreign key (admin_id) references admin(id)" .
    ")";
