<?php
require 'config.php';
if (!$admin) { header('Location: index.php'); exit; }
$r = $_GET['r'] ?? '';
$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');
$summary = [['Total Animals', $db->query("SELECT COUNT(*) FROM animals")->fetchColumn()], ['Available', $db->query("SELECT COUNT(*) FROM animals WHERE status='available'")->fetchColumn()], ['Total Donations', $db->query("SELECT COALESCE(SUM(amount),0) FROM donations")->fetchColumn()], ['Total Appointments', $db->query("SELECT COUNT(*) FROM appointments")->fetchColumn()], ['Total Users', $db->query("SELECT COUNT(*) FROM users")->fetchColumn()]];
$animals = $db->query("SELECT a.*, s.shelter_name, s.location FROM animals a JOIN shelters s ON a.shelter_id=s.shelter_id ORDER BY a.name")->fetchAll();
$st = $db->prepare("SELECT * FROM donations WHERE donation_date BETWEEN ? AND ? ORDER BY donation_date DESC"); $st->execute([$from.' 00:00:00', $to.' 23:59:59']); $donations = $st->fetchAll();
$st = $db->prepare("SELECT ap.*, u.full_name, u.email, s.shelter_name, s.location, ts.slot_date, ts.slot_time FROM appointments ap JOIN users u ON ap.user_id=u.user_id JOIN shelters s ON ap.shelter_id=s.shelter_id JOIN time_slots ts ON ap.slot_id=ts.slot_id WHERE ts.slot_date BETWEEN ? AND ? ORDER BY ts.slot_date, ts.slot_time"); $st->execute([$from, $to]); $appointments = $st->fetchAll();
require 'head.php';
?>
<div class="box">
<h1>Reports</h1>
<form method="get" style="margin-bottom:20px;">
<select name="r">
<option value="all" <?php echo ($r==='all'||$r==='')?'selected':''; ?>>All Data</option>
<option value="summary" <?php echo $r==='summary'?'selected':''; ?>>Summary Only</option>
<option value="animals" <?php echo $r==='animals'?'selected':''; ?>>Animals Only</option>
<option value="donations" <?php echo $r==='donations'?'selected':''; ?>>Donations Only</option>
<option value="appointments" <?php echo $r==='appointments'?'selected':''; ?>>Appointments Only</option>
</select>
<input type="date" name="from" value="<?php echo h($from); ?>" style="width:140px;">
<input type="date" name="to" value="<?php echo h($to); ?>" style="width:140px;">
<button type="submit" class="btn">Show</button>
</form>

<?php if ($r==='' || $r==='all' || $r==='summary'): ?>
<h2 style="font-size:1rem;margin:15px 0;">Summary</h2>
<table><tr><th>Item</th><th>Count</th></tr>
<?php foreach ($summary as $row): ?><tr><td><?php echo h($row[0]); ?></td><td><?php echo h($row[1]); ?></td></tr><?php endforeach; ?>
</table>
<?php endif; ?>

<?php if (($r==='' || $r==='all' || $r==='animals') && !empty($animals)): ?>
<h2 style="font-size:1rem;margin:20px 0;">Animals</h2>
<table><tr><th>Name</th><th>Breed</th><th>Type</th><th>Shelter</th><th>Location</th><th>Age</th><th>Gender</th><th>Vaccinated</th><th>Status</th></tr>
<?php foreach ($animals as $d): 
$ay=(float)$d['age_years']; $am=(int)$d['age_months'];
$age = $ay>0 ? $ay.($ay==1?' yr':' yrs') : ''; if ($ay>0 && $am>0) $age .= ' '; if ($am>0) $age .= $am.($am==1?' mo':' mos'); if (!$age) $age = '-';
?>
<tr><td><?php echo h($d['name']); ?></td><td><?php echo h($d['breed']); ?></td><td><?php echo h($d['animal_type']); ?></td><td><?php echo h($d['shelter_name']); ?></td><td><?php echo h($d['location']); ?></td><td><?php echo $age; ?></td><td><?php echo h($d['gender']); ?></td><td><?php echo h($d['vaccinated'] ?? 'No'); ?></td><td><?php echo h($d['status']); ?></td></tr>
<?php endforeach; ?>
</table>
<?php elseif ($r==='animals'): ?><p>No animals.</p><?php endif; ?>

<?php if ($r==='' || $r==='all' || $r==='donations'): ?>
<h2 style="font-size:1rem;margin:20px 0;">Donations (<?php echo date('d/m/Y', strtotime($from)); ?> - <?php echo date('d/m/Y', strtotime($to)); ?>)</h2>
<?php if (!empty($donations)): ?>
<table><tr><th>Donor</th><th>Email</th><th>Amount</th><th>Date</th></tr>
<?php foreach ($donations as $d): ?><tr><td><?php echo h($d['donor_name']); ?></td><td><?php echo h($d['donor_email']); ?></td><td><?php echo number_format($d['amount'], 2); ?></td><td><?php echo date('d/m/Y H:i', strtotime($d['donation_date'])); ?></td></tr><?php endforeach; ?>
</table>
<?php else: ?><p>No donations in this period.</p><?php endif; ?>
<?php endif; ?>

<?php if ($r==='' || $r==='all' || $r==='appointments'): ?>
<h2 style="font-size:1rem;margin:20px 0;">Appointments (<?php echo date('d/m/Y', strtotime($from)); ?> - <?php echo date('d/m/Y', strtotime($to)); ?>)</h2>
<?php if (!empty($appointments)): ?>
<table><tr><th>Date</th><th>Time</th><th>User</th><th>Email</th><th>Shelter</th><th>Location</th><th>Status</th></tr>
<?php foreach ($appointments as $d): ?><tr><td><?php echo date('d/m/Y', strtotime($d['slot_date'])); ?></td><td><?php echo date('h:i A', strtotime($d['slot_time'])); ?></td><td><?php echo h($d['full_name']); ?></td><td><?php echo h($d['email']); ?></td><td><?php echo h($d['shelter_name']); ?></td><td><?php echo h($d['location']); ?></td><td><?php echo h($d['status']); ?></td></tr><?php endforeach; ?>
</table>
<?php else: ?><p>No appointments in this period.</p><?php endif; ?>
<?php endif; ?>
</div>
<?php require 'foot.php'; ?>
