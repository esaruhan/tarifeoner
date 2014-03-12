<?php

/*
 * @todo #36 must fix
 */

class db {

    private $db_link;
    private $where_string;
    private $select_string;
    private $insert_string;
    private $update_string;
    private $columns;
    private $table;
    private $query_string;
    private $order_string;
    private $limit;
    private $result;
    private $debug;

    function __construct() {
        global $database;
        global $debug;
        $this->debug = $debug;
        $this->db_link = $database;
    }

    function get() {
        $this->query_string = $this->select_string . $this->where_string . $this->order_string . $this->limit;
        if ($this->debug) {
            echo "<br/>DEBUG  db->get<br/>";
            var_dump($this->query_string);
            echo "<br/>END db->get<br/>";
        }
        $this->db_link->Query($this->query_string);
        $this->query_string = "";
        $this->select_string = "";
        $this->where_string = "";
        $this->order_string = "";
        $this->limit = "";
        $this->columns = "";
    }

    function table($table) {
        $this->table = $table . " ";
    }

    function result() {
        return $this->db_link->FetchAssoc();
    }

    function run($query) {

        $this->db_link->Query($query);
    }

    function AffectedRows() {
        return $this->db_link->AffectedRows();
    }

    function select($columns) {
        $column_count = count($columns);
        foreach ($columns as $column) {
            if (is_array($column)) {
                $column = key($columns) . " as " . $column[0];
            }

            $c++;
            if ($column_count > 1) {
                $comma = ",";
                if ($column_count == $c) {
                    unset($comma);
                }
                $this->columns .= $column . $comma;
            } elseif ($column_count == 0) {
                $this->columns .= "*";
            } else {
                $this->columns .=$column;
            }
        }
        $this->select_string = "SELECT $this->columns FROM $this->table";

        if ($this->debug) {
            echo "<br/>DEBUG[db->select]<br/>";
            echo "select_string: " . $this->select_string;
            echo "<br/>END[db->select]<br/>";
        }
    }

    function order($by, $type) {
        if (!is_null($type)) {
            $this->order_string = " ORDER BY " . $by . " " . $type;
        } else {
            $this->order_string = " ORDER BY " . $by;
        }
        if ($this->debug) {
            echo "<br/>DEBUG db->order<br/>";
            var_dump($this->order_string);
            echo "<br/>END db->order<br/>";
        }
    }

    function limit($start, $end) {
        if (!$end) {
            $this->limit = " LIMIT $start";
        } else {
            $this->limit = " LIMIT $start, $end";
        }
    }

    function where($where, $ofset) {
        $count = count($where);
        $c = 0;
        $this->where_string .= "WHERE ";
        foreach ($where as $key => $value) {
            $c++;
            if ($count > 1) {
                $ofset = $ofset;
            } else {
                unset($ofset);
            }
            if ($count == $c) {
                unset($ofset);
            }
            if (isset($ofset)) {
                $this->where_string .= " " . $key . " = '" . $value . "' " . $ofset . " ";
            } else {
                $this->where_string .= " " . $key . " = '" . $value . "' ";
            }
        }
    }

    function like($where, $ofset) {
        $count = count($where);
        $c = 0;
        foreach ($where as $key => $value) {
            $c++;
            if ($count > 1) {
                $ofset = $ofset;
            } else {
                unset($ofset);
            }

            if ($count == $c) {
                unset($ofset);
            }
            $this->where_string .= "WHERE " . $key . " LIKE '" . $value . "' " . $ofset . "";
        }
    }

    function insert($data) {

        $this->insert_string .= "INSERT INTO " . $this->table;
        $columns = array_keys($data);
        $column_string .="(";
        $c = 0;
        $column_count = count($columns);
        foreach ($columns as $column) {
            $c++;
            if ($column_count > 1) {
                $comma = ",";
                if ($column_count == $c) {
                    $comma = ")";
                }
            }
            $column_string .= $column . $comma;
        }

        $this->insert_string .= $column_string . " VALUES ";

        $value_string = "(";
        $c = 0;
        foreach ($data as $value) {
            $c++;
            if ($column_count > 1) {
                $comma = ",";
                if ($column_count == $c) {
                    $comma = ")";
                }
                $value_string .= "'" . $value . "'" . $comma;
            }
        }

        $this->insert_string .= $value_string;
        $this->db_link->Query($this->insert_string);
        return $this->db_link->InsertID();
    }

    function delete() {
        $this->delete_string = "DELETE FROM " . $this->table . $this->where_string;
        self::run($this->delete_string);
    }

    function update($data) {
        $this->update_string = "UPDATE " . $this->table . "SET ";
        $count = count($data);
        $c = 0;
        $string = "";
        foreach ($data as $key => $value) {
            $c++;
            if ($count > 1) {
                $comma = ",";
                if ($count == $c) {
                    unset($comma);
                }
                $this->update_string .= "$key ='" . $value . "'" . $comma;
            } elseif ($count == 1) {
                $this->update_string .= "$key ='" . $value . "'";
            }
        }

        $this->update_string .= $string;
        $this->update_string .= " " . $this->where_string;
        $this->db_link->Query($this->update_string);
        return $this->db_link->AffectedRows();
    }

    function getErrors() {
        return $this->db_link->_GetErrors();
    }

    function debug() {

        echo "Select: " . $this->select_string . "<br/>";
        echo "Where: " . $this->where_string . "<br/>";
        var_dump(self::getErrors());
    }
    
    function count(){
        $query = "SELECT (*) FROM " . $this->table;
        self::run($query);
    }
}

?>
