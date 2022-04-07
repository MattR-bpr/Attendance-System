<?php

// pripojenie na databazu
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
            <select id="chip-employee-id">
                <option value="">vyberte meno zamestnanca...</option>
<?php

$employees = $db->GetEmployees();
foreach ($employees as $employee)
{
    $id = $employee['id'];
    $name = $employee['name'];
    echo("                <option value=\"$id\">($id) $name</option>\n");
}

?>
            </select>
            <select id="chip-type-id">
                <option value="">vyberte typ čipnutia...</option>
<?php

$chip_types = $db->GetChipTypes();
foreach($chip_types as $chip_type)
{
    $id = $chip_type['id'];
    $type = $chip_type['type'];
    echo("                <option value=\"$id\">$type</option>\n");
}

?>
            </select>
            <button id="chip">čipni zamestnanca</button>
        </fieldset>
        <fieldset>
            <legend>Zobrazenie dochádzky zamestnanca</legend>
            <select id="view-employee-id">
                <option value="">vyberte meno zamestnanca...</option>
<?php

foreach ($employees as $employee)
{
    $id = $employee['id'];
    $name = $employee['name'];
    echo("                <option value=\"$id\">($id) $name</option>\n");
}

?>
            </select>
            <input type="date" id="view-date" />
            <button id="view">zobraz záznamy zamestnanca</button>
        </fieldset>
        <output id="output"></output>
        <script>
            document.getElementById("view-date").valueAsDate = new Date();
        </script>
    </body>
</html>