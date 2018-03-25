<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 24/03/18
 * Time: 16:52
 */

include 'php/Paginator.php';
include 'php/User.php';

session_start();

if (User::isLogged()) {
    header('Location: /');
}

Paginator::makeHeader('login');
?>

    <div class="container" id="login">
        <div class="wrapper">
            <form action="rest/" method="POST" name="forgot_form" class="form-signin">
                <h3 class="form-heading">Forgot Password</h3>
                <hr class="colorgraph">
                <br>
                <?php Paginator::errorNotification() ?>

                <input type="email" class="form-control" name="email" placeholder="Email" required="" autofocus=""/>

                <br>

                <input type="hidden" name="action" value="forgot"/>
                <input type="hidden" name="redirect" value="/"/>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Renew password
                </button>

                <br/>
                <div class="text-muted">Don't have an account? <a href="/register">Register</a>!</div>
                <div class="text-muted">Just remembered your password? <a href="/forgot">Login</a>!</div>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>