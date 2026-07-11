<?php
include __DIR__ . "/config.php";

$create_database_sql = "CREATE DATABASE IF NOT EXISTS auth_core";
$db_Created          = mysqli_query($conn, $create_database_sql);
if (! $db_Created) {
    die("Database is not available " . mysqli_error($conn));
}

mysqli_select_db($conn, "auth_core");

$sql = "
CREATE TABLE if NOT EXISTS users(
    id BIGINT UNSIGNED AUTO_INCREMENT primary key,
    name varchar(255) not null,
    email varchar(255) not null unique,
    phone varchar(20) not null unique,
    password varchar(255) not null,
    profile_image varchar(255) default null,
    status ENUM('active', 'inactive') default 'active',
    email_verified_at timestamp null default null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

CREATE TABLE IF NOT EXISTS roles(
    id bigint unsigned auto_increment primary key,
    name varchar(255) not null UNIQUE,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

CREATE TABLE IF NOT EXISTS password_resets(
    id bigint unsigned auto_increment primary key,
    user_id bigint unsigned not null,
    token varchar(255) not null, 
    expires_at timestamp not null,
    used_at timestamp null default null,
    created_at timestamp default CURRENT_TIMESTAMP,
    foreign key(user_id) references users(id) on delete cascade,
    index(user_id),
    index(token)
);

CREATE TABLE IF NOT EXISTS remember_tokens(
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
    updated_at timestamp default current_timestamp on update current_timestamp,

    foreign key(user_id) references users(id) on delete cascade,

    index(user_id),
    UNIQUE(token)
);
CREATE TABLE IF NOT EXISTS login_history(
    id bigint unsigned auto_increment primary key,
    user_id bigint unsigned not null,

    ip_address varchar(255) default null,
    user_agent text default null,
    browser varchar(255) default null,
    operating_system varchar(255) default null,
    device_type varchar(50) default null,

    login_at timestamp default current_timestamp,
    logout_at timestamp NULL DEFAULT NULL,

    login_status enum('success', 'failed') default 'success',
    foreign key (user_id) REFERENCES users(id) on delete cascade,

    INDEX(user_id),
    INDEX(login_at)
    );

";

try {

    if (! mysqli_multi_query($conn, $sql)) {
        throw new Exception(mysqli_error($conn));
    }

    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }

        if (mysqli_errno($conn)) {
            throw new Exception(mysqli_error($conn));
        }

    } while (mysqli_next_result($conn));

} catch (mysqli_sql_exception $e) {
    var_dump($e->getMessage());
}
