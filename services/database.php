<?php
// TODO : tester

declare(strict_types=1);

const DB_HOST = 'localhost';  // Would probably be `localhost` or `127.0.0.1` in your case (:
const DB_PORT = '3308';
const DB_NAME = 'cup_of_tea';
const DB_USERNAME = 'root';
// const DB_PASSWORD = '3wa';

function getConnection(): \PDO
{
    return new \PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME,
        DB_USERNAME,
        // DB_PASSWORD
    );
}
