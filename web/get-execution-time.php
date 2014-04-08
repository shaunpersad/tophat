<?php
session_start();
if (!empty($_SESSION['execution_time'])) {
    echo $_SESSION['execution_time'];
}