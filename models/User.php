<?php
spl_autoload_register(function ($interface) {
    include $interface . '.php';
});

class User implements Iuser
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = &$errors;
    }

    public function signup_user($conn, $name, $email, $password, $image)
    {
        $sql = "SELECT email FROM `user` WHERE email='${email}'";
        $result = $conn->query($sql);
        $nomOfRows = $result->num_rows;

        if ($nomOfRows > 0) {
            array_push($this->errors, "email already used");
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`name`, `email`, `pass`, `photo`) VALUES ('" . $name . "', '" . $email . "', '" . $hash . "', '" . $image . "')";
            $conn->query($sql);
            $conn->close();
            $to      = $email;
            $subject = 'Welcome';
            $message = "Dear ${name}, Thanks to join us.";
            $headers = 'From: abdoali28299@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            header('Location: ' . 'signin.php');
        }
    }

    public function signin_user($conn, $email, $password)
    {
        if (!isset($password) && strlen($password) < 8) {
            array_push($this->errors, "Wrong Password");
        } else {
            $sql = "SELECT * FROM `user` WHERE email='${email}'";
            $result = $conn->query($sql);
            $nomOfRows = $result->num_rows;
            if ($nomOfRows == 0) {
                array_push($this->errors, "Wrong email");
            } else {
                while ($row = $result->fetch_assoc()) {
                    $correct_hashed_pass = $row["pass"];
                    if (!password_verify($password, $correct_hashed_pass)) {
                        array_push($this->errors, "Wrong Password");
                    } else {
                        session_start();
                        $_SESSION['id'] = $row["id"];
                        $_SESSION['name'] = $row["name"];
                        $_SESSION['email'] = $row["email"];
                        $_SESSION['photo'] = $row["photo"];
                        $_SESSION['hash'] = $row["pass"];
                        $conn->close();
                    }
                }
            }
        }
    }

    public function update_user($conn, $id, $name, $email, $hashed_password, $photo)
    {
        if ($email != $_SESSION['email']) {
            $sql = "SELECT email FROM `user` WHERE email='${email}'";
            $result = $conn->query($sql);
            $nomOfRows = $result->num_rows;

            if ($nomOfRows > 0) {
                array_push($this->errors, "email already used");
            } else {
                $sql = "UPDATE `user` SET `name`='${name}',`email`='${email}',`pass`='${hashed_password}',`photo`='${photo}' WHERE `id`=${id}";
                $conn->query($sql);
                $conn->close();
                session_start();
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['photo'] = $photo;
                $_SESSION['hash'] = $hashed_password;
            }
        } else {
            $sql = "UPDATE `user` SET `name`='${name}',`email`='${email}',`pass`='${hashed_password}',`photo`='${photo}' WHERE `id`=${id}";
            $conn->query($sql);
            $conn->close();
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['photo'] = $photo;
            $_SESSION['hash'] = $hashed_password;
        }
    }
}
