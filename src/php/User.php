<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 18:01
 */

class User
{
    /**
     * @var PDO
     */
    private static $db;

    public static function createUser($email, $password, $passwordConfirm)
    {
        assert(self::$db != null);

        if (empty($email)) {
            throw new RuntimeException("Email is empty.");
        }

        if (empty($password)) {
            throw new RuntimeException("Password is empty.");
        }

        if ($password != $passwordConfirm) {
            throw new RuntimeException("Password do not match.");
        }

        // TODO check if email exists

        $salt = hash('sha512', uniqid());

        $password_salted = hash('sha512', $password . $salt);

        $statement = "INSERT INTO users (email, password, salt) VALUES ('$email', '$password_salted', '$salt' )";

        $query = self::$db->prepare($statement);

        $results = $query->execute();

        if (!$results) {
            throw new RuntimeException("Failed to create the user due to an unknown error.");
        }
    }

    public static function connectDb()
    {
        self::$db = new PDO('pgsql:dbname=database;host=db;port=5432;user=root;password=supersafepassword');
    }
}