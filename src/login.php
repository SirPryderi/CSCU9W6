<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 17:55
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
            <form action="rest/" method="POST" name="Login_Form" class="form-signin">
                <h3 class="form-heading">Authentication</h3>
                <hr class="colorgraph">
                <br>

                <div class="input-group-cluster">
                    <input type="text" class="form-control" name="email" placeholder="Email" required=""
                           autofocus=""/>
                    <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
                </div>

                <input type="hidden" name="action" value="login"/>
                <input type="hidden" name="redirect" value="/"/>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Login
                </button>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>