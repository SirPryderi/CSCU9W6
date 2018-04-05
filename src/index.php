<?php

use PHP\Paginator;
use PHP\User;

include 'vendor/autoload.php';

User::connectDb();

if (!User::isLogged()) {
    header('Location: /login');
}

Paginator::makeHeader('Home');
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">CSCU9W6</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>
            <form class="form-inline my-2 my-lg-0" method="POST" action="rest/">
                <input type="hidden" name="action" value="logout"/>
                <input type="hidden" name="redirect" value="/"/>
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container" id="index">
        <div class="wrapper">
            <?php Paginator::errorNotification() ?>
            <h1>Users</h1>
            <hr class="colorgraph">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                </tr>
                </thead>
                <?php
                $users = User::getUsers();

                foreach ($users as $user) {
                    echo
                    "<tr>",
                    "<td>{$user->getId()}</td>",
                    "<td>{$user->getEmail()}</td>",
                    "</td>";
                }
                ?>
            </table>
        </div>
    </div>

<?php Paginator::makeFooter(); ?>