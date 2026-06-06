<?php
require 'config.php';
require 'head.php';
$list = $db->query("SELECT s.*, (SELECT COUNT(*) FROM animals a WHERE a.shelter_id=s.shelter_id) AS cnt FROM shelters s")->fetchAll();
?>
<div class="box">
<h1>Shelters</h1>
<table>
<tr><th>Name</th><th>Location</th><th>Animals</th><th></th></tr>
<?php foreach ($list as $s): ?>
<tr><td><?php echo h($s['shelter_name']); ?></td><td><?php echo h($s['location']); ?></td><td><?php echo $s['cnt']; ?></td>
<td><a href="animals.php?shelter=<?php echo $s['shelter_id']; ?>" class="btn">Animals</a></td></tr>
<?php endforeach; ?>
</table>
</div>
<?php require 'foot.php'; ?>
