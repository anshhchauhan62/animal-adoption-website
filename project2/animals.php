<?php
require 'config.php';
require 'head.php';
$sh = (int)($_GET['shelter']??0);
$type = trim($_GET['type']??'');
$vacc = trim($_GET['vaccinated']??'');
$q = trim($_GET['q']??'');
$sql = "SELECT a.*, s.shelter_name, s.location FROM animals a JOIN shelters s ON a.shelter_id=s.shelter_id WHERE 1=1";
$params = [];
if ($sh) { $sql .= " AND a.shelter_id=?"; $params[] = $sh; }
if ($type) { $sql .= " AND a.animal_type=?"; $params[] = $type; }
if ($vacc==='Yes') { $sql .= " AND a.vaccinated='Yes'"; }
elseif ($vacc==='No') { $sql .= " AND (a.vaccinated='No' OR a.vaccinated IS NULL)"; }
if ($q) { $sql .= " AND (a.name LIKE ? OR a.breed LIKE ? OR a.animal_type LIKE ?)"; $lk = "%$q%"; $params = array_merge($params, [$lk,$lk,$lk]); }
$sql .= " ORDER BY a.name";
$st = $params ? $db->prepare($sql) : $db->query($sql);
if ($params) $st->execute($params);
$list = $st->fetchAll();
$typeOptions = ['Dog', 'Cat', 'Bird', 'Other'];
?>
<div class="box">
<h1>Animals</h1>
<form method="get" style="margin-bottom:12px;">
<?php if ($sh): ?><input type="hidden" name="shelter" value="<?php echo $sh; ?>"><?php endif; ?>
<input type="text" name="q" placeholder="Search name/breed" value="<?php echo h($q); ?>" style="width:150px;">
<select name="type" style="width:100px;">
<option value="">All types</option>
<?php foreach ($typeOptions as $t): ?>
<option value="<?php echo h($t); ?>" <?php echo $type===$t?'selected':''; ?>><?php echo h($t); ?></option>
<?php endforeach; ?>
</select>
<select name="vaccinated" style="width:100px;">
<option value="">All</option>
<option value="Yes" <?php echo $vacc==='Yes'?'selected':''; ?>>Vaccinated</option>
<option value="No" <?php echo $vacc==='No'?'selected':''; ?>>Not Vaccinated</option>
</select>
<button type="submit" class="btn">Filter</button>
<a href="animals.php" class="btn btn2">Clear</a>
</form>
<?php if ($admin): ?><a href="add.php" class="btn">+ Add Animal</a><?php endif; ?>
<?php if (empty($list)): ?><p>No animals.</p>
<?php else: ?>
<table>
<tr><th>Name</th><th>Breed/Type</th><th>Shelter</th><th>Age</th><th>Vaccinated</th><th>Status</th><th></th></tr>
<?php foreach ($list as $a): ?>
<tr><td><?php echo h($a['name']); ?></td><td><?php echo h($a['breed']); ?> (<?php echo h($a['animal_type']); ?>)</td>
<td><?php echo h($a['shelter_name']); ?>, <?php echo h($a['location']); ?></td><td><?php 
$ay=(float)$a['age_years']; $am=(int)$a['age_months'];
if ($ay>0) echo $ay.($ay==1?' yr':' yrs');
if ($ay>0 && $am>0) echo ' ';
if ($am>0) echo $am.($am==1?' mo':' mos');
if ($ay==0 && $am==0) echo '-';
?></td><td><?php echo h($a['vaccinated'] ?? 'No'); ?></td><td><?php echo h($a['status']); ?></td>
<td><a href="detail.php?id=<?php echo $a['animal_id']; ?>" class="btn">View</a></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<?php require 'foot.php'; ?>
