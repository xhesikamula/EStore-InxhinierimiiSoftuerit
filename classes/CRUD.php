<?php

include 'Database.php';

class CRUD {
    private $mysqli;

    public function __construct() {
        $db = Database::getInstance();
        $this->mysqli = $db->getConnection();
    }

    public function create($table, $data) {
        $columns = implode("`, `", array_keys($data));
        $values = implode("', '", array_map([$this->mysqli, 'real_escape_string'], array_values($data)));

        $sql = "INSERT INTO `$table` (`$columns`) VALUES ('$values')";

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }
    
    public function read($table, $condition = [], $limit = null, $order = []) {
        $sql = "SELECT * FROM `$table`";
        $items = [];

        if (count($condition)) {
            $column = $condition['column'];
            $value = $this->mysqli->real_escape_string($condition['value']);
            $sql .= " WHERE `$column` = '$value'";
        }

        if (count($order) == 2) {
            $sql .= " ORDER BY `" . $order['column'] . "` " . $order['order'];
        }

        if (!is_null($limit)) {
            $sql .= " LIMIT " . (int) $limit;
        }

        if ($query = $this->mysqli->query($sql)) {
            while ($row = $query->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        } else {
            return $this->mysqli->error;
        }
    }

    public function update($table, $data, $condition = []) {
        $sql = "UPDATE `$table` SET ";

        $updates = [];
        foreach ($data as $column => $value) {
            $updates[] = "`$column` = '" . $this->mysqli->real_escape_string($value) . "'";
        }
        $sql .= implode(", ", $updates);

        if (count($condition)) {
            $column = $condition['column'];
            $value = $this->mysqli->real_escape_string($condition['value']);
            $sql .= " WHERE `$column` = '$value'";
        }

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }

    public function delete($table, $condition = [], $limit = null) {
        $sql = "DELETE FROM `$table`";

        if (count($condition)) {
            $column = $condition['column'];
            $value = $this->mysqli->real_escape_string($condition['value']);
            $sql .= " WHERE `$column` = '$value'";
        }

        if (!is_null($limit)) {
            $sql .= " LIMIT " . (int) $limit;
        }

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }

    public function search($table, $column, $value) {
        $sql = "SELECT * FROM `$table` WHERE `$column` LIKE '%" . $this->mysqli->real_escape_string($value) . "%'";
        $items = [];

        if ($query = $this->mysqli->query($sql)) {
            while ($row = $query->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        } else {
            return $this->mysqli->error;
        }
    }
    public function getLastInsertedId() {
    return $this->mysqli->insert_id;
}

}
