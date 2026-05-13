<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
start_admin_session();

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$rememberedUsername = $_COOKIE['portfolio_admin_user'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    try {
        $stmt = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            if ($remember) {
                setcookie('portfolio_admin_user', $admin['username'], time() + 60 * 60 * 24 * 30, '/');
            } else {
                setcookie('portfolio_admin_user', '', time() - 3600, '/');
            }

            header('Location: index.php');
            exit;
        }

        $error = 'Username or password is incorrect.';
    } catch (Throwable $exception) {
        $error = 'Database connection failed. Import database/portfolio.sql first.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login | Derya Portfolio</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <main class="admin-page">
    <div class="admin-shell">
      <div class="admin-header">
        <div>
          <p class="small-title">Admin Area</p>
          <h1>Login</h1>
        </div>
        <a class="btn secondary-btn" href="../index.php">Back to Site</a>
      </div>

      <section class="admin-panel">
        <?php if ($error): ?>
          <p class="message-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form class="admin-form" method="POST" action="login.php">
          <label>
            Username
            <input type="text" name="username" value="<?php echo htmlspecialchars($rememberedUsername, ENT_QUOTES, 'UTF-8'); ?>" required />
          </label>

          <label>
            Password
            <input type="password" name="password" required />
          </label>

          <label class="checkbox-label">
            <input type="checkbox" name="remember" <?php echo $rememberedUsername ? 'checked' : ''; ?> />
            Remember username
          </label>

          <button class="btn primary-btn" type="submit">Login</button>
        </form>
      </section>
    </div>
  </main>
</body>
</html>
