<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 17:55
 */

use PHP\Paginator;
use PHP\User;

include 'vendor/autoload.php';

session_start();

if (User::isLogged()) {
    header('Location: /');
}

Paginator::makeHeader('Login');
?>

    <div class="container" id="login">
        <div class="wrapper">
            <form action="rest/" method="POST" name="Login_Form" class="form-signin">


                <h3 class="form-heading">Authentication</h3>
                <hr class="colorgraph">
                <br>
                <?php Paginator::errorNotification() ?>

                <div class="input-group-cluster">
                    <input type="email" class="form-control" name="email" placeholder="Email" required=""
                           autofocus=""/>
                    <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
                </div>

                <input type="hidden" name="action" value="login"/>
                <input type="hidden" name="redirect" value="/"/>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Login
                </button>

                <br/>
                <div class="text-muted">Don't have an account? <a href="/register">Register</a>!</div>
                <div class="text-muted">Forgot your password? <a href="/forgot">Click here</a>!</div>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>