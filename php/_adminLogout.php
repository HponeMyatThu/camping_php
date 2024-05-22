<?php
session_start();
session_destroy();
header("Location: ../view/AdminLogin.php");
exit();
