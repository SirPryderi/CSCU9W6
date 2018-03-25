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

try {
    handleAction($action);
    handleRedirect();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    goBack();
}


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
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    switch ($action) {
        case 'register':
            User::createUser($email, $_POST['password'], $_POST['password-confirm']);
            break;
        case 'login':
            User::login($email, $_POST['password']);
            break;
        case 'logout':
            User::logout();
            break;
        case 'forgot':
            User::sendNewPasswordByEmail($email);
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

function goBack(): void
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}