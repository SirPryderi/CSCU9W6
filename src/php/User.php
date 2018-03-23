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

    private $id;
    private $email;

    /**
     * User constructor.
     * @param $id
     * @param $email
     */
    public function __construct($id, $email)
    {
        $this->id = intval($id);
        $this->email = $email;
    }

    public static function createUser($email, $password, $passwordConfirm)
    {
        assert(self::$db != null);

        if (empty($email)) {
            throw new RuntimeException("Email is empty.");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException("Email $email is not valid.");
        }

        if (empty($password)) {
            throw new RuntimeException("Password is empty.");
        }

        if ($password != $passwordConfirm) {
            throw new RuntimeException("Password do not match.");
        }

        if (self::getUserByEmail($email) != null) {
            throw new RuntimeException("User $email already exists.");
        }

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

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return User[]
     */
    public static function getUsers()
    {
        $results = self::$db->query("SELECT id, email FROM users");

        $users = [];

        while ($result = $results->fetchObject()) {
            $users[] = new User($result->id, $result->email);
        }

        return $users;
    }

    public static function getUserByEmail($email)
    {
        $results = self::$db->query("SELECT id, email FROM users WHERE email = '$email' LIMIT 1");

        if (!$results) {
            throw new RuntimeException("Failed to fetch user.");
        }

        $rawUser = $results->fetchObject();

        if ($rawUser == null) {
            return null;
        }

        return new User($rawUser->id, $rawUser->email);
    }
}