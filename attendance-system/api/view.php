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

// validacia datumu
if (!(
    isset($_POST['date']) &&
    !empty($_POST['date']) &&
    is_string($_POST['date']) &&
    preg_match("/(?:19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['date']) // skopirovane zo stackoverflow :)
))
{
    echo('<strong>CHYBA: </strong> nevalidný formát dátumu');
    exit(1);
}

?>
<table>
    <thead>
        <tr>
            <th>Meno</th>
            <th>Čas čipnutia</th>
            <th>Typ čipnutia</th>
        </tr>
    </thead>
    <tbody>
<?php

// vypisanie zaznamov o zamestnancovi
$records = $db->GetRecords($_POST['employee-id'], $_POST['date']);
foreach ($records as $record)
{
    $name = $record['name'];
    $time = $record['time'];
    $chip_type = $record['chip-type'];

    echo("        <tr>\n");
    echo("            <td>$name</td>\n");
    echo("            <td>$time</td>\n");
    echo("            <td>$chip_type</td>\n");
    echo("        </tr>\n");
}

?>
    </tbody>
</table>
