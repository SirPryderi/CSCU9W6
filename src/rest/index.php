<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 19:04
 */

include '../php/User.php';

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

User::connectDb();

handleAction($action);

handleRedirect();


/*
 *
 *
 *
 *
 *
 *
 *
 */


/**
 * @param $action
 */
function handleAction($action): void
{
    switch ($action) {
        case 'register':
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            User::createUser($email, $_POST['password'], $_POST['password-confirm']);
            break;
        case 'login':
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            User::login($email, $_POST['password']);
            break;
        case 'logout':
            User::logout();
            break;
        default:
            new Exception("Invalid request.");
    }
}


function handleRedirect(): void
{
    $redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING);

    if ($redirect) {
        header("Location: $redirect");
    }
}