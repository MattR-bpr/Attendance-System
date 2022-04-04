<?php

// pripojenie na databazu
require_once 'db.php';
$db = new Database();

// validacia mena
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

// validacia typu cipnutia
if (!(
    isset($_POST['chip-type-id']) &&
    !empty($_POST['chip-type-id']) &&
    is_string($_POST['chip-type-id']) &&
    $db->ChipTypeExists($_POST['chip-type-id'])
))
{
    echo('<strong>CHYBA: </strong> nevalidný typ čipnutia alebo typ čipnutia neexistuje');
    exit(1);
}

// validacia posledneho a tohto cipnutia
$last_chip_type = $db->GetLastChipType($_POST['employee-id']);
$current_chip_type = $_POST['chip-type-id'];
if (!(
    ($current_chip_type === 'A' && $last_chip_type === null) ||
    ($current_chip_type === 'A' && $last_chip_type === 'D') ||
    ($current_chip_type === 'A' && $last_chip_type === 'B') ||
    ($current_chip_type === 'A' && $last_chip_type === 'L') ||
    ($current_chip_type === 'B' && $last_chip_type === 'A') ||
    ($current_chip_type === 'L' && $last_chip_type === 'A') ||
    ($current_chip_type === 'D' && $last_chip_type !== 'D')
))
{
    echo('<strong>CHYBA: </strong> nemôžete zovliť tento typ čipnutia');
    exit(1);
}

// zapisanie do databazy
$db->Chip($_POST['employee-id'], $_POST['chip-type-id']);
echo('boli ste čipnutý');

?>