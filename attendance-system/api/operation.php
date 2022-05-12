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

// validácia typu operácie
if (!operation_type_valid('operation-type'))
{
    echo('<strong>CHYBA:</strong> nevalidný typ operácie');
    exit(1);
}

// kontrola správnosti operácie
if (!correct_operation_type($_POST['operation-type'], $db->get_previous_operation_type($_POST['employee'])))
{
    echo('<strongCHYBY:</strong> nesprávny typ operácie');
    exit(1);
}

// zapísanie do databázy
$db->add_operation_record($_POST['employee'], $_POST['operation-type']);
echo('operácia zaznamenaná');

?>