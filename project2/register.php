<?php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $n = trim($_POST['name'] ?? '');
    $e = trim($_POST['email'] ?? '');
    $p = $_POST['password'] ?? '';
    if (!$n || !$e) {
        $err = 'Enter name and email.';
    } elseif (strlen($p) < 6) {
        $err = 'Password must be 6+ characters.';
    } else {
        $chk = $db->prepare("SELECT 1 FROM users WHERE email=?");
        $chk->execute([$e]);
        if ($chk->fetch()) {
            $err = 'This email is already registered.';
        } else {
            $role = ($_POST['user_type'] ?? '') === 'admin' ? 'admin' : 'user';
            $stmt = $db->prepare("INSERT INTO users (full_name, email, password, user_type) VALUES (?, ?, ?, ?)");
            $stmt->execute([$n, $e, password_hash($p, PASSWORD_DEFAULT), $role]);
            $err = 'Done! <a href="login.php">Login now</a>';
        }
    }
}
if ($uid) { header('Location: index.php'); exit; }
require 'head.php';
?>
<div class="box" style="max-width:400px;">
<h1>Register</h1>
<?php if ($err): ?>
<div class="alert <?php echo strpos($err,'Done')!==false ? 'ok' : 'err'; ?>"><?php echo $err; ?></div>
<?php endif; ?>
<?php if (!$err || strpos($err,'Done')===false): ?>
<form method="post" action="register.php">
<label>Name</label>
<input type="text" name="name" required value="<?php echo h($_POST['name']??''); ?>">
<label>Email</label>
<input type="email" name="email" required value="<?php echo h($_POST['email']??''); ?>">
<label>Password (6+ characters)</label>
<input type="password" name="password" required minlength="6">
<label>Register as</label>
<select name="user_type">
<option value="user" <?php echo ($_POST['user_type']??'')==='admin'?'':'selected'; ?>>User</option>
<option value="admin" <?php echo ($_POST['user_type']??'')==='admin'?'selected':''; ?>>Admin</option>
</select>
<button type="submit" class="btn">Register</button>
<a href="login.php" class="btn btn2">Login</a>
</form>
<?php endif; ?>
</div>
<?php require 'foot.php'; ?>
