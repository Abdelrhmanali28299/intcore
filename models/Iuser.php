<?php

interface Iuser
{
  public  function signup_user($conn, $name, $email, $password, $image);
  public  function signin_user($conn, $email, $password);
  public  function update_user($conn, $id, $name, $email, $password, $image);
}