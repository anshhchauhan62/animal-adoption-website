<?php
require 'config.php';
require 'head.php';
$ac = $db->query("SELECT COUNT(*) FROM animals WHERE status='available'")->fetchColumn();
$sc = $db->query("SELECT COUNT(*) FROM shelters")->fetchColumn();
?>
<div class="box"><h1>Animal Adoption</h1><p>View animals, donate, book appointment.</p></div>
<div class="stats"><div><strong><?php echo $ac; ?></strong> Animals</div><div><strong><?php echo $sc; ?></strong> Shelters</div></div>
<?php require 'foot.php'; ?>
