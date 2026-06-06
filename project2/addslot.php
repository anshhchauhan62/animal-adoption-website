<?php
require 'config.php';
if (!$admin) { header('Location: index.php'); exit; }
$ok = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $db->prepare("INSERT INTO time_slots (shelter_id, slot_date, slot_time, is_booked) VALUES (?,?,?,0)")->execute([(int)$_POST['shelter'], $_POST['date'], $_POST['time']]);
    $ok = 'Slot added.';
}
require 'head.php';
?>
<div class="box" style="max-width:400px;">
<h1>Add Slot</h1>
<?php if ($ok) echo '<div class="alert ok">'.h($ok).'</div>'; ?>
<form method="post">
<label>Shelter</label>
<select name="shelter" required>
<?php foreach ($db->query("SELECT shelter_id, shelter_name, location FROM shelters")->fetchAll() as $sh): ?>
<option value="<?php echo $sh['shelter_id']; ?>"><?php echo h($sh['shelter_name']); ?> - <?php echo h($sh['location']); ?></option>
<?php endforeach; ?>
</select>
<label>Date</label><input type="date" name="date" required value="<?php echo date('Y-m-d'); ?>">
<label>Time</label><input type="time" name="time" required value="10:00">
<button type="submit" class="btn">Add</button>
</form>
</div>
<?php require 'foot.php'; ?>
