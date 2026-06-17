<?php
require 'config.php';
$thanks = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $n=trim($_POST['name']??''); $e=trim($_POST['email']??''); $amt=(float)($_POST['amount']??0);
    if ($n && $e && $amt>0) {
        $db->prepare("INSERT INTO donations (user_id, donor_name, donor_email, amount) VALUES (?,?,?,?)")->execute([$uid, $n, $e, $amt]);
        $thanks = ['name'=>$n, 'amount'=>$amt];
    }
}
require 'head.php';
?>
<div class="box" style="max-width:500px;">
<?php if ($thanks): ?>
<h1>Thank You!</h1>
<p style="font-size:1.1rem; margin:15px 0;">Thanks for your generous donation, <?php echo h($thanks['name']); ?>!</p>
<p style="font-size:1.2rem; color:#2e7d32;"><strong>Amount: <?php echo number_format($thanks['amount'], 2); ?></strong></p>
<p style="color:#666;">Your support helps animals in need. We appreciate you.</p>
<a href="index.php" class="btn">Back to Home</a>
<a href="donate.php" class="btn btn2">Donate Again</a>
<?php else: ?>
<h1>Donate</h1>
<form method="post">
<input type="text" name="name" placeholder="Name" required value="<?php echo h($_SESSION['user_name']??''); ?>">
<input type="email" name="email" placeholder="Email" required value="<?php echo h($_SESSION['user_email']??''); ?>">
<input type="number" name="amount" placeholder="Amount" step="0.01" min="1" required>
<button type="submit" class="btn">Donate</button>
</form>
<?php endif; ?>
</div>
<?php require 'foot.php'; ?>
