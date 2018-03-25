<?php
namespace PHP;

/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 23/03/18
 * Time: 18:15
 */
class Paginator
{
    public static function makeHeader($title)
    {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title><?php echo $title ?></title>
            <script src="dist/bundle.js"></script>
        </head>
        <body>
        <?php
    }

    public static function makeFooter()
    {
        ?>
        </body>
        </html>
        <?php
    }

    public static function errorNotification()
    {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
            unset($_SESSION['error']);
        }
    }
}