<?php
session_start();
if (isset($_POST['cellnumber'])) {
  $cellnumber = $_POST['cellnumber'];
  if ($_SESSION['nowturn'] == 0 and $_SESSION['state'][$cellnumber] == 1) {
    $_SESSION['state'][$cellnumber] = 2;
    $_SESSION['nowturn'] = 1;
    $_SESSION['count']++;
  } else if ($_SESSION['nowturn'] == 1 and $_SESSION['state'][$cellnumber] == 1) {
    $_SESSION['state'][$cellnumber] = 3;
    $_SESSION['nowturn'] = 0;
    $_SESSION['count']++;
  }
}
header("Location:index.php");
