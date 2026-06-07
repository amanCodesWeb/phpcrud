<?php
<<<<<<< HEAD
/* connection */
$con = new mysqli('localhost', 'root', 'Password', 'dbname');
if (!$con) {
    die(mysqli_error($con));
}
$idToUpdate = $_GET['id'];
$sql = "select * from `crud` where sno = $idToUpdate";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$id = $row['sno'];
$name = $row['name'];
$email = $row['email'];

/* update */
if (isset($_POST['update'])) {
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];

    $updateSql = "UPDATE `crud` SET name = '$newName', email = '$newEmail' WHERE sno = $idToUpdate";
    $updateResult = mysqli_query($con, $updateSql);

    if ($updateResult) {
        header('location:main.php');
    }else{
        echo "Error updating record: " . mysqli_error($con);
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phpcrud</title>
</head>

<body>
    <div class="container">
        <form method="post" style="padding: 20px;">
            <div class="form-group" style="padding: 10px;">
                <label>Name</label>
                <input type="text" name="new_name" value="<?php echo $name ?>">
            </div>
            <div class="form-group" style="padding: 10px;">
                <label>email</label>
                <input type="text" name="new_email" value="<?php echo $email ?>">
            </div>
            <button type="submit" name="update" style="margin-left: 60px;">update</button>
        </form>
    </div>
</body>

</html>
=======
/**
 * update.php — Edit an existing record
 *
 * Loads a record by ID from the URL (?id=N), shows an edit form,
 * and saves changes on submission.
 */

session_start();
require_once 'config.php';

// Validate record ID from URL
$id = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    redirect('index.php', 'Invalid record ID.', 'error');
}

// Fetch existing record
$stmt = safeQuery("SELECT * FROM crud WHERE sno = ?", 'i', [$id]);
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    redirect('index.php', 'Record not found.', 'error');
}

$existing_name  = $row['name'];
$existing_email = $row['email'];

// =============================================
// UPDATE — Handle form submission
// =============================================
if (isset($_POST['update'])) {

    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $errors = [];
    if ($name === '') {
        $errors[] = 'Name is required.';
    }
    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($errors)) {
        safeQuery("UPDATE crud SET name = ?, email = ? WHERE sno = ?", 'ssi', [$name, $email, $id]);
        redirect('index.php', 'Record updated successfully!', 'success');
    } else {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = ['name' => $name, 'email' => $email];
        header('Location: update.php?id=' . $id);
        exit;
    }
}

$display_name  = $_SESSION['old_input']['name'] ?? $existing_name;
$display_email = $_SESSION['old_input']['email'] ?? $existing_email;
unset($_SESSION['old_input']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record #<?= $id ?> — PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .container { max-width: 600px; }
    </style>
</head>
<body>

    <div class="bg-warning text-white text-center py-4 mb-4 shadow-sm">
        <h1 class="h3 mb-1">Edit Record #<?= $id ?></h1>
    </div>

    <div class="container">

        <!-- Validation errors -->
        <?php if (isset($_SESSION['form_errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    <?php foreach ($_SESSION['form_errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['form_errors']); ?>
        <?php endif; ?>

        <!-- Edit Form -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Record Details</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?= htmlspecialchars($display_name) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?= htmlspecialchars($display_email) ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update" class="btn btn-success">Save Changes</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="text-center text-muted py-4 mt-4 small border-top">
        <a href="index.php" class="text-decoration-none">← Back to Records</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> master
