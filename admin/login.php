<?php
// admin/login.php - Admin Authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_user'] = $admin['username'];
                $_SESSION['admin_id'] = $admin['id'];
                header('Location: index.php');
                exit;
            } else {
                $error = "Invalid username or password credentials.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PHBN Traders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-spice-dark text-white flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white text-spice-dark p-8 rounded-3xl shadow-2xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 bg-spice-red text-white rounded-2xl flex items-center justify-center text-2xl mx-auto shadow-md">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h1 class="text-2xl font-bold uppercase tracking-tight">PHBN <span class="text-spice-red">Admin</span></h1>
            <p class="text-xs text-gray-500">Sign in to manage catalog, orders, & wholesale leads.</p>
        </div>

        <?php if ($error): ?>
            <div class="p-3 bg-red-100 border border-red-300 text-red-700 text-xs rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4 text-xs">
            <div>
                <label class="block font-bold text-gray-700 uppercase mb-1">Username</label>
                <input type="text" name="username" required value="admin" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red font-medium">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase mb-1">Password</label>
                <input type="password" name="password" required value="admin123" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red font-medium">
            </div>

            <button type="submit" class="btn-spice-primary w-full py-3 text-xs uppercase font-bold shadow-md">
                Login to Dashboard <i class="fa-solid fa-right-to-bracket ml-1"></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-100 text-[11px] text-gray-400">
            Demo Admin: Username: <strong>admin</strong> | Password: <strong>admin123</strong>
            <div class="mt-2"><a href="../index.php" class="text-spice-gold underline hover:text-spice-red">&larr; Return to Storefront</a></div>
        </div>
    </div>

</body>
</html>
