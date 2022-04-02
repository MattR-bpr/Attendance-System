<?php

// pripojenia na databazu
require_once 'db.php';
$db = new Database();

// validacia mena
if (!(
    isset($_POST['full-name']) &&
    !empty($_POST['full-name']) &&
    is_string($_POST['full-name']) &&
    $db->EmployeeExists($_POST['full-name'])
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
    preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['date']) // skopirovane zo stackoverflow :)
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
$records = $db->GetRecords($_POST['full-name'], $_POST['date']);
foreach ($records as $record)
{
    $full_name = $record['full-name'];
    $time = $record['time'];
    $chip_type = $record['chip-type'];

    switch ($chip_type)
    {
        case 'arrival':
            $chip_type = 'príchod';
            break;

        case 'departure':
            $chip_type = 'odchod';
            break;

        case 'lunch':
            $chip_type = 'obedná prestávka';
            break;

        case 'break':
            $chip_type = 'prestávka';
            break;

        default:
            $chip_type = 'INVALID TYPE. CHECK YOUR DATABASE!';
            break;
    }
        
        echo("        <tr>\n");
        echo("            <td>$full_name</td>\n");
        echo("            <td>$time</td>\n");
        echo("            <td>$chip_type</td>\n");
        echo("        </tr>\n");

    }
?>

    </tbody>
</table>
