<?php
session_start();
spl_autoload_register();
$db = new Classes\User();
$redirectURL = 'index.php';

if (isset($_POST['userSubmit'])) {
    $id = $_POST['id'];
    $name = trim(strip_tags($_POST['name']));
    $surname = trim(strip_tags($_POST['surname']));
    $email = trim(strip_tags($_POST['email']));

    $id_str = '';
    if (!empty($id)) {
        $id_str = '?id=' . $id;
    }
    $errorMsg = '';
    if (empty($name)) {
        $errorMsg .= '<p>Please enter your name.</p>';
    }
    if (empty($surname)) {
        $errorMsg .= '<p>Please enter your surname.</p>';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= '<p>Please enter a valid email.</p>';
    }
    $userData = array(
        'name' => $name,
        'surname' => $surname,
        'email' => $email
    );
    $sessData['userData'] = $userData;

    if (empty($errorMsg)) {
        $insert = $db->insert($userData);

        if ($insert) {
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Member data has been added successfully.';
            unset($sessData['userData']);
        } else {
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Some problem occurred, please try again.';
            $redirectURL = 'index.php' . $id_str;
        }
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>' . $errorMsg;
        $redirectURL = 'index.php' . $id_str;
    }
    $_SESSION['sessData'] = $sessData;
} elseif (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])) {
    $delete = $db->delete($_GET['id']);

    if ($delete) {
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Member data has been deleted successfully.';
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred, please try again.';
    }
    $_SESSION['sessData'] = $sessData;
}
header("Location:" . $redirectURL);
exit();