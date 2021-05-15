<?php
session_start();
if (isset($_SESSION['profile_name']) && isset($_SESSION['user_friends'])) {
        unset($_SESSION['profile_name']);
        unset($_SESSION['user_friends']);
        session_unset();
        session_destroy();
        header('Location: index.php');
}
header('Location: index.php');
session_destroy();
?>