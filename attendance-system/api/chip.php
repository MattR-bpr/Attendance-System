<?php

// pripojenia na databazu
require_once 'db.php';
$db = new Database();

// validacia mena
if (!(
    isset($_POST['full-name']) &&
    !empty($_POST['full-name']) &&
    is_string($_POST['full-name']) &&
    $db->EmployeeExists($_POST['full-name'])
))
{
    echo('<strong>CHYBA: </strong> nevalidné meno alebo zamestnanec neexistuje');
    exit(1);
}

// validacia typu cipnutia
if (!(
    isset($_POST['chip-type']) &&
    !empty($_POST['chip-type']) &&
    is_string($_POST['chip-type']) &&
    $db->ChipTypeExists($_POST['chip-type'])
))
{
    echo('<strong>CHYBA: </strong> nevalidný typ čipnutia alebo typ čipnutia neexistuje');
    exit(1);
}

// zapisanie do databazy
$db->Chip($_POST['full-name'], $_POST['chip-type']);
echo('boli ste čipnutý');

?>