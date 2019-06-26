<?php
spl_autoload_register(function ($interface) {
    include $interface . '.php';
});

class Validation implements Ivalidation
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = &$errors;
    }

    public function validate_name($name)
    {
        if (isset($name) && strlen($name) > 2) {
            return true;
        } else {
            array_push($this->errors, "name is requiered and should be greater than 2 char");
        }
        return false;
    }

    public function validate_mail($mail)
    {
        if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $mail)) {
            return true;
        }
        array_push($this->errors, "Invalid email");
        return false;
    }

    public function validate_password($password, $repassword)
    {
        if (isset($password) && isset($repassword) && strlen($password) >= 8) {

            if ($password != $repassword) {
                array_push($this->errors, "Repeted password not equal password");
            } else {
                return true;
            }
        } else if (isset($password) && isset($repassword) && strlen($password) < 8) {
            array_push($this->errors, "short password, it atlest 8 chars");
        } else if (!isset($password) || !isset($repassword)) {
            array_push($this->errors, "password and Confirm Password are requierd");
        }
        return false;
    }

    public function validate_image($target_file)
    {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($this->errors, "File is not an image.");
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            array_push($this->errors, "Sorry, file already exists.");
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            array_push($this->errors, "Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            array_push($this->errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($this->errors, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
        } else {
            return true;
        }
        return false;
    }
}
