<?php
  session_start();

  if (isset($_SESSION['login_user']))
  {
    destroy_session_and_data();
    header('location: /');
  }
  else header('location:/');

  function destroy_session_and_data()
  {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
  }
?>