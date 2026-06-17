<?php
require 'config.php';
if (!$uid) { header('Location: login.php'); exit; }
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $db->prepare("UPDATE users SET full_name=?, phone=? WHERE user_id=?")->execute([h($_POST['name']), h($_POST['phone']), $uid]);
    $_SESSION['user_name'] = $_POST['name'];
    $msg = 'Updated.';
}
$u = $db->prepare("SELECT full_name, email, phone FROM users WHERE user_id=?"); $u->execute([$uid]); $u = $u->fetch();
require 'head.php';
?>
<div class="box" style="max-width:400px;">
<h1>Profile</h1>
<?php if ($msg) echo '<div class="alert ok">'.h($msg).'</div>'; ?>
<form method="post">
<input type="text" name="name" value="<?php echo h($u['full_name']); ?>">
<input type="text" value="<?php echo h($u['email']); ?>" disabled>
<input type="text" name="phone" value="<?php echo h($u['phone']??''); ?>">
<button type="submit" class="btn">Update</button>
</form>
</div>
<?php require 'foot.php'; ?>
