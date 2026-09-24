<?php
/*
 * Minimal ADOdb-compatible wrapper over PDO, covering the subset of the ADOdb API
 * used by this project: Execute, FetchRow, RowCount/RecordCount, AutoExecute,
 * Insert_Id, qstr, ErrorMsg.
 */

class DBRecordSet
{
    private $rows;
    private $pos = 0;
    public $fields = false;
    public $EOF = true;

    public function __construct(array $rows = array())
    {
        $this->rows = $rows;
        $this->sync();
    }

    private function sync()
    {
        $this->EOF = $this->pos >= count($this->rows);
        $this->fields = $this->EOF ? false : $this->rows[$this->pos];
    }

    public function FetchRow()
    {
        if ($this->pos >= count($this->rows)) {
            return false;
        }
        $row = $this->rows[$this->pos++];
        $this->sync();
        return $row;
    }

    public function MoveNext()
    {
        $this->pos++;
        $this->sync();
        return !$this->EOF;
    }

    public function RowCount()    { return count($this->rows); }
    public function RecordCount() { return count($this->rows); }
    public function GetRows()     { return $this->rows; }
    public function GetArray()    { return $this->rows; }
    public function Close()       { return true; }
}

class DBConnection
{
    private $pdo;
    private $error = '';
    private $affected = 0;

    public function __construct($host, $port, $user, $pass, $name)
    {
        $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass, array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
        // The code was written for MySQL 5.x: allow its GROUP BY / zero-date habits
        $this->pdo->exec("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");
    }

    public function Execute($sql, $params = false)
    {
        try {
            if (is_array($params)) {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(array_values($params));
            } else {
                $stmt = $this->pdo->query($sql);
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            throw new RuntimeException('Database error: ' . $e->getMessage() . "\nSQL: " . $sql, 0, $e);
        }
        $this->affected = $stmt->rowCount();
        $rows = $stmt->columnCount() > 0 ? $stmt->fetchAll() : array();
        return new DBRecordSet($rows);
    }

    /* ADOdb signature: AutoExecute($table, $fields, $mode, $where = false, $forceUpdate = true, $magicq = false) */
    public function AutoExecute($table, $fields, $mode, $where = false, $forceUpdate = true, $magicq = false)
    {
        if (!is_array($fields) || !$fields) {
            return false;
        }
        $cols = array_keys($fields);
        foreach ($cols as $col) {
            if (!preg_match('/^[A-Za-z0-9_]+$/', $col)) {
                throw new InvalidArgumentException("Invalid column name: $col");
            }
        }
        $mode = strtoupper(is_string($mode) ? $mode : ($mode == 2 ? 'UPDATE' : 'INSERT'));
        if ($mode == 'UPDATE') {
            if (!is_string($where) || trim($where) == '') {
                return false;
            }
            $set = implode(', ', array_map(function ($c) { return "`$c` = ?"; }, $cols));
            $sql = "UPDATE `$table` SET $set WHERE $where";
        } else {
            $sql = "INSERT INTO `$table` (`" . implode('`, `', $cols) . "`) VALUES (" .
                implode(', ', array_fill(0, count($cols), '?')) . ")";
        }
        $this->Execute($sql, $fields);
        return true;
    }

    public function Insert_Id()     { return $this->pdo->lastInsertId(); }
    public function Affected_Rows() { return $this->affected; }
    public function ErrorMsg()      { return $this->error; }
    public function qstr($value)    { return $this->pdo->quote((string)$value); }
}
