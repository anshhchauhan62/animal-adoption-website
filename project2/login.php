<?php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $u = $db->prepare("SELECT user_id, full_name, email, password, user_type FROM users WHERE email=?");
    $u->execute([trim($_POST['email']??'')]); $u = $u->fetch();
    if ($u && password_verify($_POST['pass']??'', $u['password'])) {
        $_SESSION['user_id']=$u['user_id']; $_SESSION['user_name']=$u['full_name']; $_SESSION['user_email']=$u['email']; $_SESSION['user_type']=$u['user_type'];
        header('Location: index.php'); exit;
    }
    $err = 'Wrong email or password.';
}
if ($uid) { header('Location: index.php'); exit; }
require 'head.php';
?>
<div class="box" style="max-width:350px;">
<h1>Login</h1>
<p style="font-size:13px;color:#666;margin-bottom:10px;">Login as user or admin with your email and password. Your role is set when you registered.</p>
<?php if ($err) echo '<div class="alert err">'.h($err).'</div>'; ?>
<form method="post">
<label>I am logging in as</label>
<select name="login_as" style="margin-bottom:10px;">
<option value="user">User</option>
<option value="admin">Admin</option>
</select>
<label>Email</label>
<input type="email" name="email" placeholder="Email" required>
<label>Password</label>
<input type="password" name="pass" placeholder="Password" required>
<button type="submit" class="btn">Login</button>
<a href="register.php" class="btn btn2">Register</a>
</form>
</div>
<?php require 'foot.php'; ?>
