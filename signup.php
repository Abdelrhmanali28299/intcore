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

    $validate = new Validation($errors);

    $target_dir = 'uploads/';
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    //check validation
    if ($validate->validate_name($_POST["name"]) && $validate->validate_mail($_POST["email"]) && $validate->validate_password($_POST["pass"], $_POST["repass"]) && $validate->validate_image($target_file)) {

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $user = new User($errors);
            $user->signup_user($conn, $_POST["name"], $_POST["email"], $_POST["pass"], basename($_FILES["image"]["name"]));
        } else {
            array_push($errors, "there was an error uploading your file.");
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
    <script>
        function validate() {
            var name = document.myForm.name.value;
            var email = document.myForm.email.value;
            var pass = document.myForm.pass.value;
            var repass = document.myForm.repass.value;
            if (!name || name.length <= 2) {
                alert("short name");
                return false;
            } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                alert("You have entered an invalid email address!");
                return false;
            } else if (pass.length < 8) {
                alert("short password");
                return false;
            } else if (pass != repass) {
                alert("password and repassword not equal");
                return false;
            }
            return true;
        }
    </script>

</head>

<body>
    <?php include './partials/nav.php'; ?>
    <main>
        <div class="container">
            <h1>Sign Up</h1>
            <div class="row">
                <?php
                for ($i = 0; $i < sizeof($errors); $i++) {
                    echo '<div class="alert alert-danger">' . $errors[$i] . '</div>';
                }
                ?>
                <form onsubmit="return validate()" name="myForm" action="signup.php" method="POST" class="col s12" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field">
                            <input type="text" name="name">
                            <label for="name">Name:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="text" name="email">
                            <label for="email">Email:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="password" name="pass">
                            <label for="pass">Password:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="password" name="repass">
                            <label for="repass">Confirm Password:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="file" name="image" id="image">
                            <label for="image">Select image to upload:</label>
                        </div>
                    </div>

                    <input type="submit" value="Sign up" class="btn" id="insert">
                </form>
                <br>
                <br>
                or
                <br>
                <br>
                <a class="btn green darken-1" href="signin.php">Sign In</a>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#insert').click(function() {
                var image_name = $('#image').val();
                if (image_name == "") {
                    alert("Please Select Image");
                    return false;
                } else {
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert('Invalid Image File');
                        $('#image').val('');
                        false;
                    }
                }
            })

        });
    </script>
</body>

</html>