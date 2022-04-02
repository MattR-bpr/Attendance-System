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
}

?>