<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 19:04
 */

use PHP\Notifier;
use PHP\User;

include '../vendor/autoload.php';

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$return = ["status" => "success"];
$redirecting = isset($_POST['redirect']);

User::connectDb();

try {
    handleAction($action);

    $redirecting = handleRedirect();
} catch (Exception $e) {
    Notifier::addErrorMessage($e->getMessage());

    if ($redirecting) goBack();
}

if (!$redirecting) {
    handleJsonResponse($return);
}

// END OF ACTIONS

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
    global $return;
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    switch ($action) {
        case 'register':
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_EMAIL);
            $passwordConfirm = filter_input(INPUT_POST, 'password-confirm', FILTER_SANITIZE_EMAIL);
            User::createUser($email, $password, $passwordConfirm);
            break;
        case 'login':
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_EMAIL);
            User::login($email, $password);
            break;
        case 'logout':
            User::logout();
            break;
        case 'forgot':
            User::sendNewPasswordByEmail($email);
            break;
        case 'user-exists':
            $return["user-exists"] = (User::getUserByEmail($email) != null);
            break;
        default:
            new RuntimeException("Invalid request.");
    }
}


function handleRedirect(): bool
{
    $redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING);

    if ($redirect) {
        header("Location: $redirect");
        return true;
    }

    return false;
}

/**
 * @param $return
 */
function handleJsonResponse($return): void
{
    header('Content-type: application/json');

    $message = Notifier::getErrorMessage();

    if (!empty($message)) {
        $return["status"] = "error";
        $return["message"] = $message;
    }

    echo json_encode($return);
}

function goBack(): void
{
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}