<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Animal Adoption</title>
<style>*{margin:0;padding:0;}body{font:Arial;background:#e8f5e9;padding:10px;}
header{background:#2e7d32;color:#fff;padding:10px;margin:-10px -10px 15px -10px;}
header a{color:#fff;text-decoration:none;margin-right:12px;font-size:14px;}
.box{background:#fff;padding:15px;margin-bottom:15px;border-radius:6px;box-shadow:0 1px 3px #ccc;}
.box h1{font-size:1.2rem;color:#2e7d32;margin-bottom:10px;}
input,select,textarea{width:100%;padding:8px;margin:5px 0;border:1px solid #ccc;border-radius:4px;}
.btn{display:inline-block;padding:8px 14px;background:#2e7d32;color:#fff;border:none;border-radius:4px;cursor:pointer;text-decoration:none;font-size:13px;margin:5px 5px 5px 0;}
.btn2{background:#666;}
table{width:100%;border-collapse:collapse;}th,td{padding:8px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#2e7d32;color:#fff;font-size:12px;}
.alert{padding:10px;margin:10px 0;border-radius:4px;}.ok{background:#c8e6c9;}.err{background:#ffcdd2;}
.stats{display:flex;gap:15px;}.stats div{background:#fff;padding:15px;min-width:100px;text-align:center;border-radius:6px;box-shadow:0 1px 3px #ccc;}
.stats strong{font-size:1.5rem;color:#2e7d32;display:block;}
</style></head>
<body>
<header>
<a href="index.php">Home</a><a href="shelters.php">Shelters</a><a href="animals.php">Animals</a>
<?php if ($uid): ?>
<a href="donate.php">Donate</a><a href="appointments.php">Appointments</a><a href="profile.php">Profile</a>
<?php if ($admin): ?><a href="add.php">Add Animal</a><a href="addslot.php">Add Slot</a><a href="reports.php">Reports</a><?php endif; ?>
<a href="logout.php">Logout</a>
<?php else: ?>
<a href="donate.php">Donate</a><a href="login.php">Login</a><a href="register.php">Register</a>
<?php endif; ?>
</header>
<div style="max-width:900px;margin:0 auto;">
