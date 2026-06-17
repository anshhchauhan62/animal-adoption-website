<?php
session_start();
$db = new PDO("mysql:host=localhost;dbname=animal_adoption;charset=utf8", "root", "", [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
$uid = $_SESSION['user_id'] ?? null;
$admin = ($_SESSION['user_type'] ?? '') === 'admin';
function h($s) { return htmlspecialchars($s ?? ''); }
