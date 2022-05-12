<?php

require_once 'db.php';

// pripojenie na databázu
$db = new Database();

function employee_valid($name)
{
    global $db;
    
    return (
        isset($_POST[$name]) &&
        !empty($_POST[$name]) &&
        is_numeric($_POST[$name]) &&
        $db->employee_exists($_POST[$name])
    );
}

function date_valid($name)
{
    global $db;
    
    return (
        isset($_POST[$name]) &&
        !empty($_POST[$name]) &&
        is_string($_POST[$name]) &&
        preg_match('/(?:19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST[$name]) // skopírované zo stackoverflow :)
    );
}

function chip_type_valid($name)
{
    global $db;

    return (
        isset($_POST[$name]) &&
        !empty($_POST[$name]) &&
        is_numeric($_POST[$name]) &&
        $db->chip_type_exists($_POST[$name])
    );
}

function operation_type_valid($name)
{
    global $db;
    
    return (
        isset($_POST[$name]) &&
        !empty($_POST[$name]) &&
        is_numeric($_POST[$name]) &&
        $db->operation_type_exists($_POST[$name])
    );
}

function correct_chip_type($current_chip_type, $previous_chip_type)
{
    switch ($current_chip_type)
    {
    case 1: // príchod do práce
        return in_array($previous_chip_type, [null, 2]);

    case 2: // odchod z práce
        return in_array($previous_chip_type, [1, 4, 6]);

    case 3: // začiatok prestávky
        return in_array($previous_chip_type, [1, 4, 6]);

    case 4: // koniec prestávky
        return in_array($previous_chip_type, [3]);

    case 5: // začiatok obeda
        return in_array($previous_chip_type, [1, 4, 6]);

    case 6: // koniec obeda
        return in_array($previous_chip_type, [5]);
    }

    return false;
}

function correct_operation_type($current_operation_type, $previous_operation_type)
{
    switch ($current_operation_type)
    {
    case 1: // začiatok sústruženia
        return in_array($previous_operation_type, [null, 2, 4]);

    case 2: // koniec sústruženia
        return in_array($previous_operation_type, [1]);

    case 3: // začiatok frézovania
        return in_array($previous_operation_type, [null, 2, 4]);

    case 4: // koniec frézovania
        return in_array($previous_operation_type, [3]);
    }

    return false;
}

?>