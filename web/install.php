<?php
include '../includes/includes.php';
use TopHat\Core;

$admin_email = 'shaunpersad@gmail.com';
$admin_password = 'password';

$admin_data = array(
    'email' => $admin_email,
    'first_name' => 'Shaun',
    'last_name' => 'Persad',
    'display_name' => 'Developer Admin',
    'type' => \TopHat\User::TYPE_DEV,
    'password' => $admin_password);

$admin = Core::getUser($admin_email);
if (!$admin) {

    echo 'Creating admin.<br />';
    $admin = Core::addNewUser($admin_data);

    if (!$admin) {
        echo 'Creation of admin failed. <br />';
    } else {

        echo 'Success! <br />';
    }

} else {

    echo 'Admin already exists.<br />';
}

 