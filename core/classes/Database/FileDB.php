<?php

namespace Core\Database;

class FileDB
{
    private $file_name;
    private $data;

    /**
     * FileDB constructor.
     * @param string $file_name
     */
    public function __construct(string $file_name)
    {
        $this->file_name = $file_name;
        $this->load();
        print '<pre>';
        print_r($this->data);
        print '</pre>';
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $bytes = file_put_contents($this->file_name, json_encode($this->data));

        if (is_numeric($bytes)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function load()
    {
        if (file_exists($this->file_name)) {
            $this->data = json_decode(file_get_contents($this->file_name), 'true');
        } else {
            $this->data = [];
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $table_name
     * @return bool
     */
    public function createTable(string $table_name)
    {
        if (!$this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @return bool
     */
    public function tableExists(string $table_name)
    {
        return isset($this->data[$table_name]);
    }

    /**
     * @param string $table_name
     * @return bool
     */
    public function dropTable(string $table_name)
    {
        if ($this->tableExists($table_name)) {
            unset($this->data[$table_name]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @return bool
     */
    public function truncateTable(string $table_name)
    {
        if ($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @param array $row
     * @param int|null $row_id
     * @return bool|int|int|string|null
     */
    public function insertRow(string $table_name, array $row, int $row_id = null)
    {
        if (isset($this->data[$table_name][$row_id])) {
            return false;
        } else {
            if ($row_id === null) {
                $this->data[$table_name][] = $row;
            } else {
                $this->data[$table_name][$row_id] = $row;
            }

            $row_id = array_key_last($this->data[$table_name]);

            return $row_id;
        }

    }

    /**
     * @param string $table_name
     * @param int $row_id
     * @return bool
     */
    public function rowExists(string $table_name, int $row_id)
    {
        return isset($this->data[$table_name][$row_id]);
    }

    /**
     * @param string $table_name
     * @param array $row
     * @param int $row_id
     * @return bool
     */
    public function insertRowIfNotExists(string $table_name, array $row, int $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @param array $row
     * @param int $row_id
     * @return bool
     */
    public function updateRow(string $table_name, array $row, int $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @param int $row_id
     * @return bool
     */
    public function deleteRow(string $table_name, int $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $table_name
     * @param int $row_id
     * @return bool|mixed
     */
    public function getRow(string $table_name, int $row_id)
    {
        if (!$this->rowExists($table_name, $row_id)) return false;

        return $this->data[$table_name][$row_id];
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return array|bool
     */
    public function getRowsWhere(string $table, array $conditions)
    {
        if (!$this->tableExists($table)) return false;

        $ret = [];

        foreach ($this->data[$table] as $index => $row) {
            $status = true;

            foreach ($conditions as $con_key => $con_value) {
                if ($con_key === 'row_id') {
                    if ($index != $con_value) $status = false;

                } elseif ($row[$con_key] !== $con_value) {
                    $status = false;
                }
            }

            if ($status) $ret[$index] = $row;
        }

        return $ret;
    }

    public function __destruct()
    {
        $this->save();
    }

}