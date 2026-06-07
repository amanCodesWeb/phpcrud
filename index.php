<?php
/**
 * index.php — Main CRUD page: Create, Read, Delete
 *
 * PHP at the top handles form submissions before any HTML is rendered.
 */

session_start();
require_once 'config.php';

// =============================================
// CREATE — Add a new record
// =============================================
if (isset($_POST['submit'])) {

    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validate input
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
        $sql = "INSERT INTO crud (name, email) VALUES (?, ?)";
        safeQuery($sql, 'ss', [$name, $email]);
        redirect('index.php', 'Record added successfully!', 'success');
    } else {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = ['name' => $name, 'email' => $email];
        header('Location: index.php');
        exit;
    }
}

// =============================================
// DELETE — Remove a record
// =============================================
if (isset($_POST['delete'])) {
    $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
    if ($id && $id > 0) {
        safeQuery("DELETE FROM crud WHERE sno = ?", 'i', [$id]);
        redirect('index.php', 'Record deleted successfully!', 'success');
    } else {
        redirect('index.php', 'Invalid record ID.', 'error');
    }
}

// =============================================
// READ — Fetch all records for display
// =============================================
$stmt = safeQuery("SELECT * FROM crud ORDER BY sno DESC");
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .container { max-width: 900px; }
    </style>
</head>
<body>

    <div class="bg-primary text-white text-center py-4 mb-4 shadow-sm">
        <h1 class="h3 mb-1">PHP CRUD Application</h1>
        <p class="mb-0 small opacity-75">Create, Read, Update, Delete</p>
    </div>

    <div class="container">

        <!-- Flash messages (success / error) -->
        <?php if (isset($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; ?>
            <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show">
                <?= htmlspecialchars($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

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

        <!-- Add Record Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Add New Record</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter your name"
                                   value="<?= htmlspecialchars($_SESSION['old_input']['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Enter your email"
                                   value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="submit" class="btn btn-primary w-100">+ Add</button>
                        </div>
                    </div>
                </form>
                <?php unset($_SESSION['old_input']); ?>
            </div>
        </div>

        <!-- Records Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">All Records</h2>
                <span class="badge bg-primary rounded-pill">
                    <?= $result->num_rows ?> record<?= $result->num_rows !== 1 ? 's' : '' ?>
                </span>
            </div>
            <div class="card-body p-0">
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold text-muted"><?= $counter++ ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="text-center">
                                        <a href="update.php?id=<?= $row['sno'] ?>"
                                           class="btn btn-sm btn-warning me-2">Edit</a>
                                        <form method="POST" style="display: inline;"
                                              onsubmit="return confirm('Delete this record?');">
                                            <input type="hidden" name="id" value="<?= $row['sno'] ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <p class="fs-5 mb-1">No records found</p>
                        <p class="small">Add your first record using the form above!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="text-center text-muted py-4 mt-4 small border-top">
        PHP CRUD &mdash; Create, Read, Update, Delete
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
