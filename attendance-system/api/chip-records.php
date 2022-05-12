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

// validácia datumu
if (!date_valid('date'))
{
    echo('<strong>CHYBA:</strong> nevalidný dátum');
    exit(1);
}

?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Meno</th>
            <th>Čas čipnutia</th>
            <th>Typ čipnutia</th>
        </tr>
    </thead>
    <tbody>
<?php

// vypísanie záznamov o zamestnancovi
$chip_records = $db->get_chip_records($_POST['employee'], $_POST['date']);
foreach ($chip_records as $chip_record)
{
    $id = $chip_record['id'];
    $full_name = $chip_record['full_name'];
    $time = $chip_record['time'];
    $chip_type = $chip_record['chip_type'];

    echo("        <tr>\n");
    echo("            <td>$id</td>\n");
    echo("            <td>$full_name</td>\n");
    echo("            <td>$time</td>\n");
    echo("            <td>$chip_type</td>\n");
    echo("        </tr>\n");
}

?>
    </tbody>
</table>