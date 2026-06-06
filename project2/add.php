<?php
require 'config.php';
if (!$admin) { header('Location: index.php'); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $ageUnit = $_POST['age_unit'] ?? 'years';
    $ageVal = (float)($_POST['age_value'] ?? 0);
    $ageY = $ageUnit === 'months' ? 0 : $ageVal;
    $ageM = $ageUnit === 'months' ? (int)$ageVal : 0;
    $db->prepare("INSERT INTO animals (shelter_id, name, breed, animal_type, age_years, age_months, gender, vaccinated, food_habits, living_info, health_notes, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,'available')")->execute([
        (int)$_POST['shelter'], h($_POST['name']), h($_POST['breed']), h($_POST['type']), $ageY, $ageM, h($_POST['gender']), h($_POST['vaccinated']), h($_POST['food']), h($_POST['living']), h($_POST['health'])
    ]);
    header('Location: animals.php'); exit;
}
require 'head.php';
?>
<div class="box" style="max-width:500px;">
<h1>Add Animal</h1>
<form method="post">
<label>Shelter</label>
<select name="shelter" required>
<?php foreach ($db->query("SELECT shelter_id, shelter_name, location FROM shelters")->fetchAll() as $sh): ?>
<option value="<?php echo $sh['shelter_id']; ?>"><?php echo h($sh['shelter_name']); ?> - <?php echo h($sh['location']); ?></option>
<?php endforeach; ?>
</select>
<label>Name</label><input type="text" name="name" required>
<label>Breed</label><input type="text" name="breed">
<label>Type</label>
<select name="type" required>
<option value="">Select type</option>
<option value="Dog">Dog</option>
<option value="Cat">Cat</option>
<option value="Bird">Bird</option>
<option value="Other">Other</option>
</select>
<label>Age</label>
<input type="number" name="age_value" step="0.1" min="0" placeholder="e.g. 1.5 or 6" value="0" style="width:120px;">
<select name="age_unit" style="width:100px;">
<option value="years">Years</option>
<option value="months">Months</option>
</select>
<small style="color:#666;font-size:12px;">Use decimal for years (e.g. 1.5 = 1 year 6 months)</small>
<label>Gender</label>
<select name="gender">
<option value="">Select</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
<label>Vaccinated</label>
<select name="vaccinated">
<option value="Yes">Yes</option>
<option value="No" selected>No</option>
</select>
<label>Food</label><textarea name="food" rows="2"></textarea>
<label>Living</label><textarea name="living" rows="2"></textarea>
<label>Health</label><textarea name="health" rows="2"></textarea>
<button type="submit" class="btn">Add</button>
<a href="animals.php" class="btn btn2">Cancel</a>
</form>
</div>
<?php require 'foot.php'; ?>
