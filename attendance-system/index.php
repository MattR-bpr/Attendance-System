<?php

// pripojenie na databázu
require_once 'api/db.php';
$db = new Database();

?>
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="styles.css" />
        <script src="communication.js" defer></script>
        <title>Dochádzkový Systém</title>
    </head>
    <body>
        <h1>Webkári s.r.o.</h1>
        
        <fieldset>
            <legend>Čipnutie zamestnanca</legend>
            <select id="chip-employee">
                <option value="">vyberte meno zamestnanca...</option>
<?php

$employees = $db->get_employees();
foreach ($employees as $employee)
{
    $id = $employee['id'];
    $full_name = $employee['full_name'];
    echo("                <option value=\"$id\">($id) $full_name</option>\n");
}

?>
            </select>
            <select id="chip-type">
                <option value="">vyberte typ čipnutia...</option>
<?php

$chip_types = $db->get_chip_types();
foreach ($chip_types as $chip_type)
{
    $id = $chip_type['id'];
    $value = $chip_type['value'];
    echo("                <option value=\"$id\">$value</option>\n");
}

?>
            </select>
            <button id="chip">čipni zamestnanca</button>
        </fieldset>
        
        <fieldset>
            <legend>Zobrazenie čipnutí zamestnanca</legend>
            <select id="chip-records-employee">
                <option value="">vyberte meno zamestnanca...</option>
<?php

foreach ($employees as $employee)
{
    $id = $employee['id'];
    $full_name = $employee['full_name'];
    echo("                <option value=\"$id\">($id) $full_name</option>\n");
}

?>
            </select>
            <input type="date" id="chip-records-date" />
            <button id="chip-records">zobraz záznamy čipnutia</button>
        </fieldset>
        
        <fieldset>
            <legend>Čipnutie operácie</legend>
            <select id="operation-employee">
                <option value="">vyberte meno zamestnanca...</option>
<?php

foreach ($employees as $employee)
{
    $id = $employee['id'];
    $full_name = $employee['full_name'];
    echo("                <option value=\"$id\">($id) $full_name</option>\n");
}

?>
            </select>
            <select id="operation-type">
                <option value="">vyberte typ operácie...</option>
<?php

$operation_types = $db->get_operation_types();
foreach ($operation_types as $operation_type)
{
    $id = $operation_type['id'];
    $value = $operation_type['value'];
    echo("                <option value=\"$id\">$value</option>\n");
}

?>
            </select>
            <button id="operation">čipni operáciu</button>
        </fieldset>

        <fieldset>
            <legend>Zobrazenie operácií zamestnanca</legend>
            <select id="operation-records-employee">
                <option value="">vyberte meno zamestnanca...</option>
<?php

foreach ($employees as $employee)
{
    $id = $employee['id'];
    $full_name = $employee['full_name'];
    echo("                <option value=\"$id\">($id) $full_name</option>\n");
}

?>
            </select>
            <input type="date" id="operation-records-date" />
            <button id="operation-records">zobraz záznamy operácií</button>
        </fieldset>
        
        <output id="output"></output>
        <script>
            document.getElementById("chip-records-date").valueAsDate = new Date();
            document.getElementById("operation-records-date").valueAsDate = new Date();
        </script>
    </body>
</html>