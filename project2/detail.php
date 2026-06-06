<?php
require 'config.php';
$id = (int)($_GET['id']??0);
$a = $db->prepare("SELECT a.*, s.shelter_name, s.location FROM animals a JOIN shelters s ON a.shelter_id=s.shelter_id WHERE a.animal_id=?");
$a->execute([$id]); $a = $a->fetch();
if (!$a) { header('Location: animals.php'); exit; }
require 'head.php';
?>
<div class="box">
<a href="animals.php<?php echo $a['shelter_id']?'?shelter='.$a['shelter_id']:''; ?>">← Back</a>
<h1><?php echo h($a['name']); ?></h1>
<p><?php echo h($a['breed']); ?> (<?php echo h($a['animal_type']); ?>) | <?php echo h($a['shelter_name']); ?>, <?php echo h($a['location']); ?></p>
<p>Age: <?php 
$ay=(float)$a['age_years']; $am=(int)$a['age_months'];
if ($ay>0) echo $ay.($ay==1?' year':' years');
if ($ay>0 && $am>0) echo ' ';
if ($am>0) echo $am.($am==1?' month':' months');
if ($ay==0 && $am==0) echo 'Not specified';
?> | Gender: <?php echo h($a['gender']); ?> | Vaccinated: <?php echo h($a['vaccinated'] ?? 'No'); ?> | <?php echo h($a['status']); ?></p>
<?php if ($a['food_habits']): ?><p><b>Food:</b> <?php echo h($a['food_habits']); ?></p><?php endif; ?>
<?php if ($a['living_info']): ?><p><b>Living:</b> <?php echo h($a['living_info']); ?></p><?php endif; ?>
<?php if ($a['health_notes']): ?><p><b>Health:</b> <?php echo h($a['health_notes']); ?></p><?php endif; ?>
</div>
<?php require 'foot.php'; ?>
