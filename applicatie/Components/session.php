<?php


function redirectIfNotLoggedin() {
    if (!isLoggedIn()) {
        header('Location: /Views/login.php?redirect=');
        exit();
    }

}