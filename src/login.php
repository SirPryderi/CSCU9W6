<?php
/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 17:55
 */

include 'php/Paginator.php';

Paginator::makeHeader('login');
?>

    <div class="container" id="login">
        <div class="wrapper">
            <form action="" method="post" name="Login_Form" class="form-signin">
                <h3 class="form-heading">Authentication</h3>
                <hr class="colorgraph">
                <br>

                <div class="input-group-cluster">
                <input type="text" class="form-control" name="Username" placeholder="Username" required=""
                       autofocus=""/>
                <input type="password" class="form-control" name="Password" placeholder="Password" required=""/>
                </div>

                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Login
                </button>
            </form>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>