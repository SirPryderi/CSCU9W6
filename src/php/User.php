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
    private $password;
    private $salt;

    /**
     * User constructor.
     * @param $id integer
     * @param $email string
     * @param $password string
     * @param $salt string
     */
    public function __construct($id, $email, $password, $salt)
    {
        $this->id = intval($id);
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
    }

    public static function createUser($email, $password, $passwordConfirm)
    {
        assert(self::$db != null);

        self::validate($email, $password);

        if ($password != $passwordConfirm) {
            throw new RuntimeException("Passwords do not match.");
        }

        if (self::getUserByEmail($email) != null) {
            throw new RuntimeException("User $email already exists.");
        }

        $password_hash = $salt_hash = null;

        self::generateHashPair($password, $password_hash, $salt_hash);

        $statement = "INSERT INTO users (email, password, salt) VALUES ('$email', '$password_hash', '$salt_hash' )";

        $query = self::$db->prepare($statement);

        $results = $query->execute();

        if (!$results) {
            throw new RuntimeException("Failed to create the user due to an unknown error.");
        }
    }

    /**
     * @param $email string
     * @param $password string
     */
    private static function validate($email, $password): void
    {
        if (empty($email)) {
            throw new RuntimeException("Email is empty.");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException("Email $email is not valid.");
        }

        if (empty($password)) {
            throw new RuntimeException("Password is empty.");
        }
    }

    public static function getUserByEmail($email)
    {
        $results = self::$db->query("SELECT id, email, password, salt FROM users WHERE email = '$email' LIMIT 1");

        if (!$results) {
            throw new RuntimeException("Failed to fetch user.");
        }

        $rawUser = $results->fetchObject();

        if ($rawUser == null) {
            return null;
        }

        return new User($rawUser->id, $rawUser->email, $rawUser->password, $rawUser->salt);
    }

    private static function generateHashPair($password, &$password_hash, &$salt_hash)
    {
        $salt_hash = self::encode(uniqid());
        $password_hash = self::encode($password . $salt_hash);
    }

    private static function encode($data)
    {
        return hash('sha512', $data);
    }

    public static function login($email, $password)
    {
        self::validate($email, $password);

        $user = self::getUserByEmail($email);

        if ($user === null) {
            throw new RuntimeException("Email not present in the database.");
        }

        $password_salted = self::encode($password . $user->salt);

        if ($password_salted !== $user->password) {
            throw new RuntimeException("Wrong password.");
        }

        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    public static function connectDb()
    {
        self::$db = new PDO('pgsql:dbname=database;host=db;port=5432;user=root;password=supersafepassword');

        session_start();
    }

    public static function isLogged()
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return User[]
     */
    public static function getUsers()
    {
        $results = self::$db->query("SELECT id, email, password, salt FROM users");

        $users = [];

        while ($result = $results->fetchObject()) {
            $users[] = new User($result->id, $result->email, $result->password, $result->salt);
        }

        return $users;
    }

    public static function sendNewPasswordByEmail($email)
    {
        require_once 'Postman.php';

        $user = self::getUserByEmail($email);

        if ($user === null) {
            throw new RuntimeException("User not present our databases.");
        }

        $password = uniqid();

        try {
            Postman::sendEmail($email, 'Password reset', "Your new password is: <b>$password</b>.");
            $user->setPassword($password);
            // TODO convert this to a success message
            $_SESSION['error'] = "A new password has been sent to $email.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email to $email.";
        }
    }

    public function setPassword($password)
    {
        $password_hash = $salt_hash = null;

        self::generateHashPair($password, $password_hash, $salt_hash);

        self::$db->query("UPDATE users SET salt = '$salt_hash', password = '$password_hash' WHERE id = $this->id");
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
}