<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 17:55
 */

include 'php/Paginator.php';

Paginator::makeHeader('Register');
?>

    <div class="container" id="register">
        <div class="wrapper">
            <form action="rest/" method="post" name="register" class="form">
                <h3 class="form-heading">Register</h3>
                <hr class="colorgraph">
                <br>

                <div class="input-group-cluster">
                    <input type="email" class="form-control" name="email" placeholder="Email" required="required"
                           autofocus=""/>
                    <input type="password" class="form-control" name="password" placeholder="Password" required=""/>

                    <input type="password" class="form-control" name="password-confirm" placeholder="Confirm Password"
                           required=""/>
                </div>

                <input type="hidden" name="action" value="register"/>
                <input type="hidden" name="redirect" value="/"/>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Register
                </button>

                <br/>
                <div class="text-muted">Already registered? <a href="/login">Login</a>!</div>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>