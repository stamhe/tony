<?php
//单例模式pdo数据库类
// http://www.cnblogs.com/xiaochaohuashengmi/archive/2010/08/12/1797753.html
// http://blog.csdn.net/qq635785620/article/details/11284591
class DriverPdo {
    private $db;
    private static $instance;

    public static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {
        $dsn = sprintf('mysql:dbname=%s;host=%s;port=%u;charset=%s', DBNAME, DBHOST, DBPORT, DBCHARSET);
        $option = array(PDO::ATTR_PERSISTENT => false);
        $this->db = new PDO($dsn, DBUSER, DBPWD, $option);
        if ($this->db->errorCode() != '0000') {
            echo sprintf('%s%s%s', '无法连接到数据库服务器', $this->db->errorInfo());
            exit;
        }
        $this->db->query("SET NAMES " . DBCHARSET);
    }

    public function fetch($sql, $setFetchMode = PDO::FETCH_ASSOC) {
        if ($result = $this->db->query($sql)) {
            $rows = $result->fetch($setFetchMode);
        }
        return !empty($rows) ? $rows : array();
    }

    public function fetchAll($sql, $setFetchMode = PDO::FETCH_ASSOC) {
        if ($result = $this->db->query($sql)) {
            $rows = $result->fetchAll($setFetchMode);
        }
        return !empty($rows) ? $rows : array();
    }

    public function __get($value) {
        if (property_exists($this->db, $value)) {
            return $this->db->$value;
        }
        throw new Exception("Property {$value} is not exists");
    }

    public function __call($method, $argvs) {
        if (method_exists($this->db, $method)) {
            return call_user_func_array(array($this->db, $method), $argvs);
        }
        throw new Exception("Method {$method} is not exists");
    }

    //防止对象被克隆
    public function __clone() {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }

    public function __destruct() {
        //$this->db = null;
    }

}
