<?php

// pripojenie na databazu
require_once 'db.php';
$db = new Database();

// validacia id zamestnanca
if (!(
    isset($_POST['employee-id']) &&
    !empty($_POST['employee-id']) &&
    is_numeric($_POST['employee-id']) &&
    $db->EmployeeExists($_POST['employee-id'])
))
{
    echo('<strong>CHYBA: </strong> nevalidné meno alebo zamestnanec neexistuje');
    exit(1);
}

// validacia typu operacie
if (!(
    isset($_POST['operation-type-id']) &&
    !empty($_POST['operation-type-id']) &&
    is_string($_POST['operation-type-id']) &&
    $db->OperationTypeExists($_POST['operation-type-id'])
))
{
    echo('<strong>CHYBA: </strong> nevalidný typ operácie alebo typ operácie neexistuje');
    exit(1);
}

// zapisanie do databazy
$db->ChipOperation($_POST['employee-id'], $_POST['operation-type-id']);
echo('operácia bola zaznamenaná');

?>