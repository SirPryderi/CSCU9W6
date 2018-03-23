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
            <form action="" method="post" name="Login_Form" class="form">
                <h3 class="form-heading">Register</h3>
                <hr class="colorgraph">
                <br>

                <div class="input-group-cluster">
                    <input type="email" class="form-control" name="Email" placeholder="Email" required="required"
                           autofocus=""/>
                    <input type="password" class="form-control" name="Password" placeholder="Password" required=""/>

                    <input type="password" class="form-control" name="Password-Confirm" placeholder="Confirm Password"
                           required=""/>
                </div>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Register
                </button>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>