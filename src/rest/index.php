<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 19:04
 */

include '../php/User.php';

$action = $_POST ['action'];

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
        default:

    }
}


function handleRedirect(): void
{
    $redirect = $_POST['redirect'];

    if ($redirect) {
        header("Location: $redirect");
    }
}