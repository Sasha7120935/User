<?php
/**
 * Created by Belous Alex.
 * Description: Crud in file
 * Date: 27/09/22
 */
session_start();
$sessionData = !empty($_SESSION['sessionData']) ? $_SESSION['sessionData'] : '';
spl_autoload_register();
$db = new Classes\User();
$members = $db->getRows();
if (!empty($sessionData['status']['msg'])) {
    $statusMsg = $sessionData['status']['msg'];
    $statusMsgType = $sessionData['status']['type'];
    unset($_SESSION['sessionData']['status']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<div class="container">
    <h1>User Data</h1>
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="userAction.php">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name"
                           value="<?php echo !empty($userData['name']) ? $userData['name'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" class="form-control" name="surname" placeholder="Enter your surname"
                           value="<?php echo !empty($userData['surname']) ? $userData['surname'] : ''; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email"
                           value="<?php echo !empty($userData['email']) ? $userData['email'] : ''; ?>" required="">
                </div>
                <input type="hidden" name="id"
                       value="<?php echo !empty($memberData['id']) ? $memberData['id'] : ''; ?>">
                <input type="submit" name="userSubmit" class="btn btn-success" value="Add Data">
            </form>
        </div>
        <div class="table-nav">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="userData">
                <?php if (!empty($members)) {
                    $count = 0;
                    foreach ($members as $row) {
                        $count++; ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['surname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="userAction.php?action_type=delete&id=<?php echo $row['id']; ?>"
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure to delete?');">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6">No user(s) found...</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>