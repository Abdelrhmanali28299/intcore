<?php
session_start();
if (isset($_SESSION['id']) || isset($_COOKIE["id"])) {
    header('Location: ' . 'index.php');
}
$errors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include './helpers/db_connect.php';

    spl_autoload_register(function ($class_name) {
        include './models/' . $class_name . '.php';
    });
    echo $_POST["check"];
    if (!isset($_POST["check"])) {
        if (isset($_POST["email"]) && isset($_POST["pass"])) {
            $user = new User($errors);
            $user->signin_user($conn, $_POST["email"], $_POST["pass"]);
            header('Location: ' . 'index.php');
        }
    } else {
        if (isset($_POST["email"]) && isset($_POST["pass"])) {
            $user = new User($errors);
            $user->signin_user($conn, $_POST["email"], $_POST["pass"]);
            setcookie("id", $_SESSION['id'], time() + (86400 * 30), "/");
            setcookie("name", $_SESSION['name'], time() + (86400 * 30), "/");
            setcookie("email", $_SESSION['email'], time() + (86400 * 30), "/");
            setcookie("photo", $_SESSION['photo'], time() + (86400 * 30), "/");
            setcookie("hash", $_SESSION['hash'], time() + (86400 * 30), "/");
            header('Location: ' . 'index.php');
        }
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Task</title>
</head>

<body>
    <?php include './partials/nav.php'; ?>
    <main>
        <div class="container">
            <h1>Sign In</h1>
            <div class="row">
                <?php
                for ($i = 0; $i < sizeof($errors); $i++) {
                    echo '<div class="alert alert-danger">' . $errors[$i] . '</div>';
                }
                ?>
                <form action="signin.php" method="POST" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" name="email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="password" name="pass" required>
                            <label for="pass">Password</label>
                        </div>

                    </div>
                    <div class="row">
                        <div>
                            <input type="checkbox" id="check" name="check">
                            <label for="check">remember me</label>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Sign in" class="btn">
                </form>
                <br>
                <br>
                or
                <br>
                <br>
                <a class="btn green darken-1" href="signup.php">Sign Up</a>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</body>

</html>