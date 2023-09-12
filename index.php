<?php
/**
 * @Desc       OOP Database
 * @Date       09-10-2023
 * @Author     Zoggi
 * @github     https://github.com/travelxml
 */

    require 'database.php';
    // $database = new Database('localhost', 'store', 'root', '', 'MYSQL');
    $database = new Database('localhost', 'store', 'postgres', 'postgres', Database::POSTGRE);
    $conn = $database->connect();
    $database->set_table('users');
    $database->set_column('user_id, user_name, email');
    $find = $database->findAll();
    print_r($find);
?>