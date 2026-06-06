<?php
require 'config.php';
if (!$uid) { header('Location: login.php'); exit; }
$booked = '';
if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_POST['slot_id'])) {
    $sid=(int)$_POST['slot_id']; $shid=(int)$_POST['shelter_id'];
    $chk = $db->prepare("SELECT slot_id FROM time_slots WHERE slot_id=? AND shelter_id=? AND is_booked=0");
    $chk->execute([$sid,$shid]);
    if ($chk->fetch()) {
        $db->prepare("INSERT INTO appointments (user_id, shelter_id, slot_id, status) VALUES (?,?,?,'scheduled')")->execute([$uid,$shid,$sid]);
        $db->prepare("UPDATE time_slots SET is_booked=1 WHERE slot_id=?")->execute([$sid]);
        $b = $db->prepare("SELECT s.shelter_name, s.location, ts.slot_date, ts.slot_time FROM appointments ap JOIN shelters s ON ap.shelter_id=s.shelter_id JOIN time_slots ts ON ap.slot_id=ts.slot_id WHERE ap.user_id=? AND ap.slot_id=? ORDER BY ap.appointment_id DESC LIMIT 1");
        $b->execute([$uid,$sid]); $booked = $b->fetch();
    }
}
$my = $db->prepare("SELECT ap.*, s.shelter_name, s.location, ts.slot_date, ts.slot_time FROM appointments ap JOIN shelters s ON ap.shelter_id=s.shelter_id JOIN time_slots ts ON ap.slot_id=ts.slot_id WHERE ap.user_id=? ORDER BY ts.slot_date DESC");
$my->execute([$uid]); $my = $my->fetchAll();
$shid = (int)($_GET['shelter']??0);
$slots = [];
if ($shid) {
    $slots = $db->prepare("SELECT * FROM time_slots WHERE shelter_id=? AND slot_date>=CURDATE() AND is_booked=0 ORDER BY slot_date, slot_time");
    $slots->execute([$shid]); $slots = $slots->fetchAll();
}
require 'head.php';
?>
<div class="box">
<h1>Appointments</h1>
<?php if ($booked): ?>
<div class="alert ok" style="margin-bottom:15px;">
<h2 style="font-size:1rem; margin-bottom:10px;">Booking Confirmed!</h2>
<p>Your visit has been scheduled successfully.</p>
<p><strong>Shelter:</strong> <?php echo h($booked['shelter_name']); ?>, <?php echo h($booked['location']); ?></p>
<p><strong>Date:</strong> <?php echo date('l, d M Y', strtotime($booked['slot_date'])); ?></p>
<p><strong>Time:</strong> <?php echo date('h:i A', strtotime($booked['slot_time'])); ?></p>
<p style="color:#666; margin-top:10px;">Please arrive on time. We look forward to seeing you!</p>
</div>
<?php endif; ?>
<h2 style="font-size:1rem;">My bookings</h2>
<?php if (empty($my)): ?><p>None.</p>
<?php else: ?>
<table><tr><th>Shelter</th><th>Date</th><th>Time</th><th>Status</th></tr>
<?php foreach ($my as $m): ?>
<tr><td><?php echo h($m['shelter_name']); ?>, <?php echo h($m['location']); ?></td><td><?php echo date('d/m/Y', strtotime($m['slot_date'])); ?></td><td><?php echo date('h:i A', strtotime($m['slot_time'])); ?></td><td><?php echo h($m['status']); ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
<h2 style="font-size:1rem;margin-top:15px;">Book visit</h2>
<form method="get"><select name="shelter" onchange="this.form.submit()">
<option value="">Select shelter</option>
<?php foreach ($db->query("SELECT shelter_id, shelter_name, location FROM shelters")->fetchAll() as $sh): ?>
<option value="<?php echo $sh['shelter_id']; ?>" <?php echo $shid==$sh['shelter_id']?'selected':''; ?>><?php echo h($sh['shelter_name']); ?> - <?php echo h($sh['location']); ?></option>
<?php endforeach; ?>
</select></form>
<?php if ($shid && !empty($slots)): ?>
<form method="post"><input type="hidden" name="shelter_id" value="<?php echo $shid; ?>">
<?php foreach ($slots as $sl): ?><label style="display:block;"><input type="radio" name="slot_id" value="<?php echo $sl['slot_id']; ?>" required> <?php echo date('d/m/Y', strtotime($sl['slot_date'])); ?> <?php echo date('h:i A', strtotime($sl['slot_time'])); ?></label><?php endforeach; ?>
<button type="submit" class="btn">Book</button>
</form>
<?php elseif ($shid): ?><p>No free slots. Admin: Add Slot.</p><?php endif; ?>
</div>
<?php require 'foot.php'; ?>
