<?php
require_once 'includes/auth.php';

Auth::logout();
header('Location: login.php');
exit();