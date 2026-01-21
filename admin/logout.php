<?php
/**
 * Admin Logout Handler
 */
require_once 'auth.php';

logout_admin();
header("Location: ../login.php");
exit();
?>
