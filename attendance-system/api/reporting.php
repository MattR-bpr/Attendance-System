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

// údaje o časi v práci
$total_time = $db->get_sum_time_between_chips($_POST['employee'], $_POST['date'], 1, 2);
$breaks = $db->get_sum_time_between_chips($_POST['employee'], $_POST['date'], 3, 4);
$lunches = $db->get_sum_time_between_chips($_POST['employee'], $_POST['date'], 5, 6);

// údaje o operáciach
$turning = $db->get_sum_time_between_operations($_POST['employee'], $_POST['date'], 1, 2);
$milling = $db->get_sum_time_between_operations($_POST['employee'], $_POST['date'], 3, 4);

?>
<table>
    <tbody>
        <tr>
            <th>Celkový čas v práci</th>
            <td><?php echo($total_time ?? 'žiadne údaje'); ?></td>
        </tr>
        <tr>
            <th>Prestávky</th>
            <td><?php echo($breaks ?? 'žiadne údaje'); ?></td>
        </tr>
        <tr>
            <th>Obedy</th>
            <td><?php echo($lunches ?? 'žiadne údaje'); ?></td>
        </tr>
        <tr>
            <th>Sústruženie</th>
            <td><?php echo($turning ?? 'žiadne údaje'); ?></td>
        </tr>
        <tr>
            <th>Frézovanie</th>
            <td><?php echo($milling ?? 'žiadne údaje'); ?></td>
        </tr>
    </tbody>
</table>