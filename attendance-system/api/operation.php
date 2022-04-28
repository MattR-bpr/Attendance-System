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

// validácia typu operácie
if (!(
    isset($_POST['operation-type']) &&
    !empty($_POST['operation-type']) &&
    is_numeric($_POST['operation-type']) &&
    $db->operation_type_exists($_POST['operation-type'])
))
{
    echo('<strong>CHYBA:</strong> nevalidný typ operácie');
    exit(1);
}

// zapísanie do databázy
$db->add_operation_record($_POST['employee'], $_POST['operation-type']);
echo('operácia zaznamenaná');

?>