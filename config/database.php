<?php
include( __DIR__. "/config.php"); 

$create_database_sql = "CREATE DATABASE IF NOT EXISTS auth_core";
$db_Created = mysqli_query($conn, $create_database_sql);
if(!$db_Created){
    die("Database is not available ". mysqli_connect_error());
}

mysqli_select_db($conn, "auth_core"); 

$create_user_sql = "CREATE TABLE if NOT EXISTS users(
    id BIGINT UNSIGNED AUTO_INCREMENT primary key,
    name varchar(255) not null,
    email varchar(255) not null unique,
    phone varchar(255) not null unique,
    password varchar(255) not null,
    profile_image varchar(255) default null,
    status tinyint(1) default 0,
    email_verified_at timestamp null default null, 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
) ";




$create_role_sql = "CREATE TABLE IF NOT EXISTS roles(
    id bigint unsigned auto_increment primary key,
    name varchar(255) not null ,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";


$create_password_reset_sql = "CREATE TABLE IF NOT EXISTs password_reset(
        id bigint unsigned auto_increment primary key,
        user_id bigint unsigned not null,
        token varchar(255) not null,
        expires_at timestamp not null,
        used_at timestamp null default null,
        created_at timestamp default CURRENT_TIMESTAMP,
        foreign key(user_id) references users(id) on delete cascade,
        index(user_id),
        index(token)
)";

$create_remember_token_sql = "CREATE TABLE IF NOT EXISTS remember_token(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    token varchar(255) not null,
    device_name varchar(255) default null,
    device_type varchar(100) default null,
    ip_address varchar(45) default null,
    user_agent text default null,
    expires_at timestamp null,
    last_used_at timestamp null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp

    foreign key(user_id) references users(id) on delete cascade,

    index(user_id),
    UNIQUE(token)
)";


$create_login_history_table = "
    CREATE TABLE IF NOT EXIST login_history(
        id bigint unsigned auto_increment primary key,
        user_id bigint unsigned not null,

        ip_address varchar(255) default null,
        user_agent text default null,
        browser varchar(255) default null,
        operating_system varchar(255) default null,
        device_type varchar(50) default null,

        login_at timestamp default current_timestamp,
        logout_at timestamp default current_timestamp,

        login_status enum('success', 'failed') default 'success',
        foreign key (user_id) REFERENCES on users(id) on delete cascade,

        index(user_id),
        index(login_at)
    
    )
";


mysqli_begin_transaction($conn);
try{

    if(!mysqli_query($conn, $create_user_sql)){
        die(mysqli_error($conn));
    }


    if(!mysqli_query($conn, $create_role_sql)){
        die(mysqli_error($conn));
    }
    if(!mysqli_query($conn, $create_password_reset_sql)){
        die(mysqli_error($conn));
    }
    if(!mysqli_query($conn, $create_remember_token_sql)){
        die(mysqli_error($conn));
    }
    if(!mysqli_query($conn, $create_login_history_table)){
        die(mysqli_error($conn));
    } 
    mysqli_commit($conn);

}catch(Exception $e){
    var_dump($e->getMessage());
    mysqli_rollback($conn);

}