<?php

class Database
{
    private $db = null;

    public function __construct()
    {
        $credentials = json_decode(file_get_contents('credentials.json'));
        $host = $credentials->host;
        $user = $credentials->user;
        $password = $credentials->password;
        $database = $credentials->database;
        
        $this->db = new mysqli($host, $user, $password, $database);
        $this->db->set_charset('utf8mb4');
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function Chip($full_name, $chip_type)
    {
        $full_name = $this->db->real_escape_string($full_name);
        $chip_type = $this->db->real_escape_string($chip_type);
        
        $query = "INSERT INTO attendance_system
            (`employee_id`, `chip_type_id`)
        VALUES
            (
                (SELECT `id` FROM employees WHERE LOWER(`full_name`) = LOWER('$full_name')),
                (SELECT `id` FROM chip_types WHERE LOWER(`value`) = LOWER('$chip_type'))
            );
        ";
        $this->db->query($query);
    }

    public function EmployeeExists($full_name)
    {
        $full_name = $this->db->real_escape_string($full_name);
        
        $query = "SELECT COUNT(*) AS `count`
        FROM employees
        WHERE LOWER(`full_name`) = LOWER('$full_name');";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result['count'] > 0;
    }

    public function ChipTypeExists($chip_type)
    {
        $chip_type = $this->db->real_escape_string($chip_type);
        
        $query = "SELECT COUNT(*) AS `count`
        FROM chip_types
        WHERE LOWER(`value`) = LOWER('$chip_type');";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result['count'] > 0;
    }

    public function GetRecords($full_name, $date)
    {
        $full_name = $this->db->real_escape_string($full_name);
        $date = $this->db->real_escape_string($date);

        $query = "SELECT
            `full_name` AS `full-name`,
            `chip_time` AS `time`,
            `value` AS `chip-type`
        FROM attendance_system
            JOIN employees ON(attendance_system.`employee_id` = employees.`id`)
            JOIN chip_types ON(attendance_system.`chip_type_id` = chip_types.`id`)
        WHERE DATE(`chip_time`) = '$date' AND LOWER(`full_name`) = LOWER('$full_name')
        ORDER BY `chip_time` DESC;";
        
        $q = $this->db->query($query);
        $records = [];
        while ($record = $q->fetch_assoc())
            $records[] = $record;
        $q->free_result();

        return $records;
    }

    public function EliminateDuplicates($full_name, $chip_type)
    {
        $full_name = $this->db->real_escape_string($full_name);
        $chip_type = $this->db->real_escape_string($chip_type);

        $q = $this->db->query("SELECT CURRENT_TIMESTAMP AS 'time';");
        $current_date = $q->fetch_assoc();
        $current_date = explode(' ', $current_date['time'], 2);

        $query = "SELECT
            `full_name` AS `full-name`,
            `chip_time` AS `time`,
            `value` AS `chip-type`
        FROM attendance_system
            JOIN employees ON(attendance_system.`employee_id` = employees.`id`)
            JOIN chip_types ON(attendance_system.`chip_type_id` = chip_types.`id`)
        WHERE LOWER(`full_name`) = LOWER('$full_name') AND `chip_type_id` <= 2
        ORDER BY `chip_time` DESC LIMIT 1;";

        $q = $this->db->query($query);
        $db_response = $q->fetch_assoc();


        if ($db_response === null and $chip_type === 'arrival')
        return 'success';
        elseif ($db_response !== null)
            if (($chip_type === 'lunch' or $chip_type === 'break') and $db_response['chip-type'] === 'departure')
            return 'empty';
            else {
            }
        else
            return 'empty';

        $db_response_time = explode(' ', $db_response['time'], 2);

        if (strcmp($db_response['chip-type'], $chip_type) !== 0) {
            if (strcmp($db_response_time[0], $current_date[0]) == 0) {
                if (strcmp($db_response_time[1], $current_date[1]) !== 0)
                    return 'success';
                else
                    return 'failed';
            } else
                return 'failed';
        } else
            return 'failed';

        $q->free_result();
    }

    public function ConvertChipType($chip_type){
        switch ($chip_type) {
            case 'arrival':
                return 'príchod';
                break;

            case 'departure':
                return 'odchod';
                break;

            case 'lunch':
                return 'obedná prestávka';
                break;

            case 'break':
                return 'prestávka';
                break;
        }
    }
}

?>
