<?php
// /analytics/admin/guard.php
session_start();
if (empty($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
