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
            <th>Čas operácie</th>
            <th>Typ operácie</th>
        </tr>
    </thead>
    <tbody>
<?php

// vypísanie záznamov o zamestnancovi
$operation_records = $db->get_operation_records($_POST['employee'], $_POST['date']);
foreach ($operation_records as $operation_record)
{
    $id = $operation_record['id'];
    $full_name = $operation_record['full_name'];
    $time = $operation_record['time'];
    $operation_type = $operation_record['operation_type'];

    echo("        <tr>\n");
    echo("            <td>$id</td>\n");
    echo("            <td>$full_name</td>\n");
    echo("            <td>$time</td>\n");
    echo("            <td>$operation_type</td>\n");
    echo("        </tr>\n");
}

?>
    </tbody>
</table>