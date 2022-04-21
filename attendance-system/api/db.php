<?php

class Database
{
    private $db = null;

    public function __construct()
    {
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'attendance_system';
        
        $this->db = new mysqli($host, $user, $password, $database);
        $this->db->set_charset('utf8mb4');
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function GetEmployees()
    {
        $query = "SELECT
            `id` as `id`,
            `full_name` as `name`
        FROM employees
        ORDER BY `full_name`;";

        $q = $this->db->query($query);
        $employees = [];
        while ($employee = $q->fetch_assoc())
            $employees[] = $employee;
        $q->free_result();

        return $employees;
    }

    public function EmployeeExists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query = "SELECT COUNT(*) AS `count`
        FROM employees
        WHERE `id` = '$id';";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result['count'] > 0;
    }

    public function GetChipTypes()
    {
        $query = "SELECT
            `id` as `id`,
            `value` as `type`
        FROM chip_types
        ORDER BY `value`;";

        $q = $this->db->query($query);
        $types = [];
        while ($type = $q->fetch_assoc())
            $types[] = $type;
        $q->free_result();

        return $types;
    }

    public function ChipTypeExists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query = "SELECT COUNT(*) AS `count`
        FROM chip_types
        WHERE `id` = '$id';";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result['count'] > 0;
    }

    public function GetOperationTypes()
    {
        $query = "SELECT
            `id` as `id`,
            `value` as `type`
        FROM operation_types
        ORDER BY `value`;";

        $q = $this->db->query($query);
        $types = [];
        while ($type = $q->fetch_assoc())
            $types[] = $type;
        $q->free_result();

        return $types;
    }

    public function OperationTypeExists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query = "SELECT COUNT(*) AS `count`
        FROM operation_types
        WHERE `id` = '$id';";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result['count'] > 0;
    }

    public function GetLastChipType($employee_id)
    {
        $employee_id = $this->db->real_escape_string($employee_id);

        $query = "SELECT chip_type_id AS `type`
        FROM records
        WHERE employee_id = $employee_id
        ORDER BY chip_time DESC
        LIMIT 1;";

        $q = $this->db->query($query);
        $result = $q->fetch_assoc();
        $q->free_result();

        return $result ? $result['type'] : null;
    }

    public function Chip($employee_id, $chip_type_id)
    {
        $employee_id = $this->db->real_escape_string($employee_id);
        $chip_type_id = $this->db->real_escape_string($chip_type_id);
        
        $query = "INSERT INTO records
        (
            `employee_id`,
            `chip_type_id`
        )
        VALUES
        (
            '$employee_id',
            '$chip_type_id'
        );";
        
        $this->db->query($query);
    }

    public function GetRecords($employee_id, $date)
    {
        $employee_id = $this->db->real_escape_string($employee_id);
        $date = $this->db->real_escape_string($date);

        $query = "SELECT
            `full_name` AS `name`,
            `chip_time` AS `time`,
            `value` AS `chip-type`
        FROM records
            JOIN employees ON(records.`employee_id` = employees.`id`)
            JOIN chip_types ON(records.`chip_type_id` = chip_types.`id`)
        WHERE DATE(`chip_time`) = '$date' AND `employee_id` = '$employee_id'
        ORDER BY `chip_time` DESC;";
        
        $q = $this->db->query($query);
        $records = [];
        while ($record = $q->fetch_assoc())
            $records[] = $record;
        $q->free_result();

        return $records;
    }

    public function ChipOperation($employee_id, $operation_type_id)
    {
        $employee_id = $this->db->real_escape_string($employee_id);
        $operation_type_id = $this->db->real_escape_string($operation_type_id);
        
        $query = "INSERT INTO operations
        (
            `employee_id`,
            `operation_type_id`
        )
        VALUES
        (
            '$employee_id',
            '$operation_type_id'
        );";
        
        $this->db->query($query);
    }
}

?>