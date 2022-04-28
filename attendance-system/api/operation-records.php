<?php

// pripojenie na databázu
require_once 'db.php';
$db = new Database();

/// validácia zamestnanca
if (!(
    isset($_POST['employee']) &&
    !empty($_POST['employee']) &&
    is_numeric($_POST['employee']) &&
    $db->employee_exists($_POST['employee'])
))
{
    echo('<strong>CHYBA:</strong> nevalidný zamestnanec');
    exit(1);
}

// validácia datumu
if (!(
    isset($_POST['date']) &&
    !empty($_POST['date']) &&
    is_string($_POST['date']) &&
    preg_match('/(?:19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['date']) // skopírované zo stackoverflow :)
))
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