<?php

interface Ivalidation
{
  public  function validate_name($name);
  public  function validate_mail($mail);
  public  function validate_password($password, $repassword);
  public  function validate_image($target_file);
}