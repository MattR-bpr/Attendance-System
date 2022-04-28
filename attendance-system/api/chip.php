<?php

// pripojenie na databázu
require_once 'db.php';
$db = new Database();

// validácia zamestnanca
if (!(
    isset($_POST['employee']) &&
    !empty($_POST['employee']) &&
    is_numeric($_POST['employee']) &&
    $db->employee_exists($_POST['employee'])
))
{
    echo('<strong>CHYBA:</strong> nevalidný zamestnanec');
    exit(1);
}

// validácia typu čipnutia
if (!(
    isset($_POST['chip-type']) &&
    !empty($_POST['chip-type']) &&
    is_numeric($_POST['chip-type']) &&
    $db->chip_type_exists($_POST['chip-type'])
))
{
    echo('<strong>CHYBA:</strong> nevalidný typ čipnutia');
    exit(1);
}

// zapísanie do databázy
$db->add_chip_record($_POST['employee'], $_POST['chip-type']);
echo('čipnutie zaznamenané');

?>