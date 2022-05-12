<?php

require_once '../functions/db.php';
require_once '../functions/validators.php';

// pripojenie na databázu
$db = new Database();

// validácia zamestnanca
if (!employee_valid('employee'))
{
    echo('<strong>CHYBA:</strong> nevalidný zamestnanec');
    exit(1);
}

// validácia typu čipnutia
if (!chip_type_valid('chip-type'))
{
    echo('<strong>CHYBA:</strong> nevalidný typ čipnutia');
    exit(1);
}

// kontrola správnosti čipnutia
if (!correct_chip_type($_POST['chip-type'], $db->get_previous_chip_type($_POST['employee'])))
{
    echo('<strongCHYBY:</strong> nesprávny typ čipnutia');
    exit(1);
}

// zapísanie do databázy
$db->add_chip_record($_POST['employee'], $_POST['chip-type']);
echo('čipnutie zaznamenané');

?>