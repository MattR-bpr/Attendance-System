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

    public function get_employees()
    {
        $query =
        "SELECT
            `id` AS `id`,
            `full_name` AS `full_name`
        FROM `employees`
        ORDER BY `full_name`
        ;";

        $q = $this->db->query($query);
        
        $employees = [];
        while ($employee = $q->fetch_assoc())
        {
            $employees[] = $employee;
        }
        
        $q->free_result();
        return $employees;
    }

    public function employee_exists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query =
        "SELECT
            COUNT(*) AS `count`
        FROM `employees`
        WHERE
            `id` = $id
        ;";

        $q = $this->db->query($query);
        
        $result = $q->fetch_assoc();
        
        $q->free_result();
        return $result['count'] > 0;
    }

    public function get_chip_types()
    {
        $query =
        "SELECT
            `id` AS `id`,
            `value` AS `value` 
        FROM `chip_types`
        ORDER BY `id`
        ;";

        $q = $this->db->query($query);
        
        $chip_types = [];
        while ($chip_type = $q->fetch_assoc())
        {
            $chip_types[] = $chip_type;
        }
        
        $q->free_result();
        return $chip_types;
    }

    public function chip_type_exists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query =
        "SELECT
            COUNT(*) AS `count`
        FROM `chip_types`
        WHERE
            `id` = $id
        ;";

        $q = $this->db->query($query);
        
        $result = $q->fetch_assoc();
        
        $q->free_result();
        return $result['count'] > 0;
    }

    public function get_operation_types()
    {
        $query =
        "SELECT
            `id` AS `id`,
            `value` AS `value`
        FROM `operation_types`
        ORDER BY `id`
        ;";

        $q = $this->db->query($query);
        
        $operation_types = [];
        while ($operation_type = $q->fetch_assoc())
        {
            $operation_types[] = $operation_type;
        }
        
        $q->free_result();
        return $operation_types;
    }

    public function operation_type_exists($id)
    {
        $id = $this->db->real_escape_string($id);
        
        $query =
        "SELECT
            COUNT(*) AS `count`
        FROM `operation_types`
        WHERE
            `id` = $id
        ;";

        $q = $this->db->query($query);
        
        $result = $q->fetch_assoc();
        
        $q->free_result();
        return $result['count'] > 0;
    }

    public function get_chip_records($employee, $date)
    {
        $employee = $this->db->real_escape_string($employee);
        $date = $this->db->real_escape_string($date);
        
        $query =
        "SELECT
            `chip_records`.`id` AS `id`,
            `employees`.`full_name` AS `full_name`,
            `chip_records`.`time` AS `time`,
            `chip_types`.`value` AS `chip_type`
        FROM `chip_records`
            JOIN `employees` ON `employees`.`id` = `chip_records`.`employee`
            JOIN `chip_types` ON `chip_types`.`id` = `chip_records`.`chip_type`
        WHERE
            `chip_records`.`employee` = $employee AND
            DATE(`chip_records`.`time`) = '$date'
        ORDER BY `chip_records`.`time`
        ;";

        $q = $this->db->query($query);
        
        $chip_records = [];
        while ($chip_record = $q->fetch_assoc())
        {
            $chip_records[] = $chip_record;
        }
        
        $q->free_result();
        return $chip_records;
    }

    public function get_previous_chip_type($employee)
    {
        $employee = $this->db->real_escape_string($employee);

        $query =
        "SELECT
            `chip_type` AS `chip_type`
        FROM `chip_records`
        WHERE
            `employee` = $employee
        ORDER BY `time` DESC
        LIMIT 1
        ;";

        $q = $this->db->query($query);

        $result = $q->fetch_assoc();

        $q->free_result();
        return $result['chip_type'] ?? null;
    }

    public function get_sum_time_between_chips($employee, $date, $start_chip_type, $end_chip_type)
    {
        $employee = $this->db->real_escape_string($employee);
        $date = $this->db->real_escape_string($date);
        $start_chip_type = $this->db->real_escape_string($start_chip_type);
        $end_chip_type = $this->db->real_escape_string($end_chip_type);

        $query =
        "SELECT
            SEC_TO_TIME(
                SUM(
                    TIMEDIFF(
                        `o`.`time`,
                        (
                            SELECT
                                `i`.`time`
                            FROM `chip_records` `i`
                            WHERE
                                `i`.`employee` = $employee AND
                                DATE(`i`.`time`) = '$date' AND
                                `i`.`time` < `o`.`time` AND
                                `i`.`chip_type` = $start_chip_type
                            ORDER BY `i`.`time` DESC
                            LIMIT 1
                        )
                    )
                )
            ) AS `sum`
        FROM `chip_records` `o`
        WHERE
            `o`.`employee` = $employee AND
            DATE(`o`.`time`) = '$date' AND
            `o`.`chip_type` = $end_chip_type
        ORDER BY `o`.`time` DESC
        ;";
                
        $q = $this->db->query($query);

        $result = $q->fetch_assoc();

        $q->free_result();
        return $result['sum'] ?? null;
    }

    public function add_chip_record($employee, $chip_type)
    {
        $employee = $this->db->real_escape_string($employee);
        $chip_type = $this->db->real_escape_string($chip_type);
        
        $query =
        "INSERT INTO `chip_records`
        (
            `employee`,
            `chip_type`
        )
        VALUES
        (
            $employee,
            $chip_type
        )
        ;";

        $this->db->query($query);
    }

    public function get_operation_records($employee, $date)
    {
        $employee = $this->db->real_escape_string($employee);
        $date = $this->db->real_escape_string($date);
        
        $query =
        "SELECT
            `operation_records`.`id` AS `id`,
            `employees`.`full_name` AS `full_name`,
            `operation_records`.`time` AS `time`,
            `operation_types`.`value` AS `operation_type`
        FROM `operation_records`
            JOIN `employees` ON `employees`.`id` = `operation_records`.`employee`
            JOIN `operation_types` ON `operation_types`.`id` = `operation_records`.`operation_type`
        WHERE
            `operation_records`.`employee` = $employee AND
            DATE(`operation_records`.`time`) = '$date'
        ORDER BY `operation_records`.`time`
        ;";

        $q = $this->db->query($query);
        
        $operation_records = [];
        while ($operation_record = $q->fetch_assoc())
        {
            $operation_records[] = $operation_record;
        }
        
        $q->free_result();
        return $operation_records;
    }

    public function get_previous_operation_type($employee)
    {
        $employee = $this->db->real_escape_string($employee);

        $query =
        "SELECT
            `operation_type` AS `operation_type`
        FROM `operation_records`
        WHERE
            `employee` = $employee
        ORDER BY `time` DESC
        LIMIT 1
        ;";

        $q = $this->db->query($query);

        $result = $q->fetch_assoc();

        $q->free_result();
        return $result['operation_type'] ?? null;
    }

    public function get_sum_time_between_operations($employee, $date, $start_operation_type, $end_operation_type)
    {
        $employee = $this->db->real_escape_string($employee);
        $date = $this->db->real_escape_string($date);
        $start_operation_type = $this->db->real_escape_string($start_operation_type);
        $end_operation_type = $this->db->real_escape_string($end_operation_type);

        $query =
        "SELECT
            SEC_TO_TIME(
                SUM(
                    TIMEDIFF(
                        `o`.`time`,
                        (
                            SELECT
                                `i`.`time`
                            FROM `operation_records` `i`
                            WHERE
                                `i`.`employee` = $employee AND
                                DATE(`i`.`time`) = '$date' AND
                                `i`.`time` < `o`.`time` AND
                                `i`.`operation_type` = $start_operation_type
                            ORDER BY `i`.`time` DESC
                            LIMIT 1
                        )
                    )
                )
            ) AS `sum`
        FROM `operation_records` `o`
        WHERE
            `o`.`employee` = $employee AND
            DATE(`o`.`time`) = '$date' AND
            `o`.`operation_type` = $end_operation_type
        ORDER BY `o`.`time` DESC
        ;";
                
        $q = $this->db->query($query);

        $result = $q->fetch_assoc();

        $q->free_result();
        return $result['sum'] ?? null;
    }

    public function add_operation_record($employee, $operation_type)
    {
        $employee = $this->db->real_escape_string($employee);
        $operation_type = $this->db->real_escape_string($operation_type);
        
        $query =
        "INSERT INTO `operation_records`
        (
            `employee`,
            `operation_type`
        )
        VALUES
        (
            $employee,
            $operation_type
        )
        ;";

        $this->db->query($query);
    }
}

?>