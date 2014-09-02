<?php
unset($_SESSION['logged']);
unset($_SESSION['loggedInUser']);
header('Location: login.php');
exit;
