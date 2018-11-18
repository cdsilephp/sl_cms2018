<?php

class CPdo
{

    protected $_dsn = "";

    protected $_name = "";

    protected $_pass = "";

    protected $_condition = array();

    protected $pdo;

    protected $fetchAll;

    protected $query;

    protected $result;

    protected $num;

    protected $mode;

    protected $prepare;

    protected $row;

    protected $fetchAction;

    protected $beginTransaction;

    protected $rollback;

    protected $commit;

    protected $char;

    private static $get_mode;

    private static $get_fetch_action;
    private static $_instance;    //保存类实例的私有静态成员变量

    /**
     * pdo construct
     */
    public function __construct($pconnect = false, $config = array())
    {
        // var_dump($config);die();
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $user = isset($config['user']) ? $config['user'] : 'root';
        $password = isset($config['password']) ? $config['password'] : '';
        $dbname = isset($config['dbname']) ? $config['dbname'] : '';
        $port = isset($config['port']) ? $config['port'] : '3306';
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';
        
        $this->_dsn = "mysql:host={$host};dbname={$dbname};port={$port}";
        
        $this->_name = $user;
        
        $this->_pass = $password;
        
        $this->_condition = array(
            PDO::ATTR_PERSISTENT => $pconnect,
            PDO::ATTR_EMULATE_PREPARES => true
        );
        $this->pdo_connect();
        
        $this->setChars($charset);
    }

    
    /**
     * 获取实例化对象
     */
    public static function getInstance()
    {
        $dbconfig['host'] = $GLOBALS['config_db']['host'];
        $dbconfig['user'] = $GLOBALS['config_db']['user'];
        $dbconfig['password'] = $GLOBALS['config_db']['password'];
        $dbconfig['dbname'] = $GLOBALS['config_db']['dbname'];
        $dbconfig['port'] = $GLOBALS['config_db']['port'];
        $dbconfig['charset'] = $GLOBALS['config_db']['charset'];
        //检测类是否被实例化
        if ( ! (self::$_instance instanceof self) ) {
            self::$_instance = new CPdo(false, $dbconfig);
        }
        return self::$_instance;
    }
    
    /**
     * pdo connect
     */
    private function pdo_connect()
    {
        // echo $this->_dsn."<br/>". $this->_name."<br/>". $this->_pass."<br/>".$this->_condition."<br/>";
        try {
            try {
                $this->pdo = new PDO($this->_dsn, $this->_name, $this->_pass, $this->_condition);
                //主动抛出异常
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
            }catch (\PDOException $e){
                //throw new \Exception('数据库链接失败：' . $e->getMessage());
                throw  new MyException();
            }
        }catch (MyException $e){
            $e->MysqlConnectException();
        }
        
//         catch (Exception $e) {
//             return $this->setExceptionError("11111111".$e->getMessage(), $e->getline, $e->getFile);
//         }
    }

    /**
     * self sql get value action
     */
    public function getValueBySelfCreateSql($sql, $fetchAction = "assoc", $mode = null)
    {
        $this->fetchAction = $this->fetchAction($fetchAction);
        $this->result = $this->setAttribute($sql, $this->fetchAction, $mode);
        $this->AllValue = $this->result->fetchAll();
        return $this->AllValue;
    }

    /**
     * select condition can query
     */
    private function setAttribute($sql, $fetchAction, $mode)
    {
        $this->mode = self::getMode($mode);
        $this->fetchAction = self::fetchAction($fetchAction);
        $this->pdo->setAttribute(PDO::ATTR_CASE, $this->mode);
        $this->query = $this->base_query($sql);
        $this->query->setFetchMode($this->fetchAction);
        return $this->query;

    }

    /**
     * get mode action
     */
    private static function getMode($get_style)
    {
        switch ($get_style) {
            case null:
                self::$get_mode = PDO::CASE_NATURAL;
                break;
            case true:
                self::$get_mode = PDO::CASE_UPPER;
                break;
            case false:
                self::$get_mode = PDO::CASE_LOWER;
                break;
        }
        return self::$get_mode;
    }

    /**
     * fetch value action
     */
    private static function fetchAction($fetchAction)
    {
        switch ($fetchAction) {
            case "assoc":
                self::$get_fetch_action = PDO::FETCH_ASSOC; // asso array
                break;
            case "num":
                self::$get_fetch_action = PDO::FETCH_NUM; // num array
                break;
            case "object":
                self::$get_fetch_action = PDO::FETCH_OBJ; // object array
                break;
            case "both":
                self::$get_fetch_action = PDO::FETCH_BOTH; // assoc array and num array
                break;
            default:
                self::$get_fetch_action = PDO::FETCH_ASSOC;
                break;
        }
        return self::$get_fetch_action;
    }

    /**
     * get total num action
     */
    public function rowCount($sql)
    {
        $this->result = $this->base_query($sql);
        $this->num = $this->result->rowCount();
        return $this->num;
    }

    /*
     * simple query and easy query action
     */
    public function query($table, $column = "*", $condition = array(), $group = "", $order = "", $having = "", $startSet = "", $endSet = "", $fetchAction = "assoc", $params = null)
    {
        $sql = "select " . $column . " from `" . $table . "` ";
        $where = "";
        if ($condition != null && is_array($condition)) {
            foreach ($condition as $k => $value) {
                $value = addslashes($value);
                if(!strpos($k,'>') && !strpos($k,'<') && !strpos($k,'=') && substr($value, 0, 1) != '%' && substr($value, -1) != '%'){    //where(array('age'=>'22'))
                    $where.= $k."= '".$value."' AND ";
                }else if(substr($value, 0, 1) == '%' || substr($value, -1) == '%'){	//where(array('name'=>'%php%'))
                    $where.= $k." LIKE '".$value."' AND ";
                }else{
                    $where.= $k."'".$value."' AND ";      //where(array('age>'=>'22'))
                }
                
                //$where .= "$key = '$value' and ";
                
            }
            $sql .= "where $where";
            $sql .= "1 = 1 ";
        }else if ($condition != null && !is_array($condition)) {
            
            $sql .= "where $condition";
        }
        
        
        if ($group != "") {
            $sql .= "group by " . $group . " ";
        }
        if ($order != "") {
            $sql .= " order by " . $order . " ";
        }
        if ($having != "") {
            $sql .= " having {$having} ";
        }
        if (  is_numeric($endSet) && is_numeric($startSet)) {
            $sql .= "limit $startSet,$endSet";
        }
        //echo $sql;die();
        $this->result = $this->getValueBySelfCreateSql($sql, $fetchAction, $params);
        return $this->result;
    }

    /**
     * execute delete update insert and so on action
     */
    public function exec($sql)
    {
        try {
            try {
                $this->result = $this->pdo->exec($sql);
                $substr = substr($sql, 0, 6);
                if ($this->result) {
                    return $this->getInsertId();
                } else {
                    return false;
                }
            } catch (\PDOException $e){
                throw new MyException();
            }
        } catch (MyException $e) {
            $e->SQLException($sql);
        }
       
    }
    
    /**
     * 返回修改后受影响的数据量
     * @param unknown $sql
     * @return boolean
     */
    public function exec_update_delete($sql)
    {
        $this->result = $this->pdo->exec($sql);
        $substr = substr($sql, 0, 6);
        if ($this->result) {
            return $this->result;
        } else {
            return false;
        }
    }
    
    
    
    
    /**
	 * 获取上一步insert操作产生的id
	 */
	public function getInsertId(){
		return $this->pdo->lastInsertId();
	}

    /**
     * prepare action
     */
    public function prepare($sql)
    {
        $this->prepare = $this->pdo->prepare($sql);
        // $this->setChars();
        $this->prepare->execute();
        while ($this->rowz = $this->prepare->fetch()) {
            return $this->row;
        }
    }

    /**
     * USE transaction
     */
    public function transaction($sql)
    {
        $this->begin();
        $this->result = $this->pdo->exec($sql);
        if ($this->result) {
            $this->commit();
        } else {
            $this->rollback();
        }
    }

    /**
     * start transaction
     */
    public function begin()
    {
        $this->beginTransaction = $this->pdo->beginTransaction();
        return $this->beginTransaction;
    }

    /**
     * commit transaction
     */
    public function commit()
    {
        $this->commit = $this->pdo->commit();
        return $this->commit;
    }

    /**
     * rollback transaction
     */
    public function rollback()
    {
        $this->rollback = $this->pdo->rollback();
        return $this->rollback;
    }

    /**
     * base query
     */
    private function base_query($sql)
    {
        // $this->setChars();
        //写日志
        if ($GLOBALS['config_db']['log']=="true") {
            $str = "[" . date("Y-m-d H:i:s") . "] ". $sql . PHP_EOL;
            file_put_contents("log.txt", $str,FILE_APPEND);
        }
        try {
            try {
                $this->query = $this->pdo->query($sql);
                return $this->query;
            }  catch (\PDOException $e){
                throw new MyException();
            }
        } catch (MyException $e) {
            $e->SQLException($sql);
        }
        
        
    }

    /**
     * set chars
     */
    private function setChars($charest = "UTF8")
    {
        $this->char = $this->pdo->query("SET NAMES '{$charest}'");
        return $this->char;
    }

    /**
     * process sucessful action
     */
    private function successful($params)
    {
        return "The " . $params . " action is successful";
    }

    /**
     * process fail action
     */
    private function fail($params)
    {
        return "The " . $params . " action is fail";
    }

    /**
     * process exception action
     */
    private function setExceptionError($getMessage, $getLine, $getFile)
    {
        echo "Error message is " . $getMessage . "<br /> The Error in " . $getLine . " line <br /> This file dir on " . $getFile;
        exit();
    }
    
    
    
    /**
     * 获取一条记录
     * @access public
     * @param $sql 查询的sql语句
     * @return array 关联数组
     */
    public function getRow($sql){
        if ($result = $this->getValueBySelfCreateSql($sql)) {
            $row =$result[0];
            return $row;
        } else {
            return false;
        }
    }
    
    /**
     * 获取第一条记录的第一个字段
     * @access public
     * @param $sql string 查询的sql语句
     * @return 返回一个该字段的值
     */
    public function getOne($sql){
        $result = $this->getValueBySelfCreateSql($sql);
        $row = $result[0];
        if ($row) {
            return $row[0];
        } else {
            return false;
        }
    }
    
    
    /**
     * 获取所有的记录
     * @access public
     * @param $sql 执行的sql语句
     * @return $list 有所有记录组成的二维数组
     */
    public function getAll($sql){
        $result = $this->getValueBySelfCreateSql($sql);
        return $result;
    }
    
    
    /*
     * print sql string
     */
    public function printSql($table, $column = "*", $condition = array(), $group = "", $order = "", $having = "", $startSet = "", $endSet = "", $fetchAction = "assoc", $params = null)
    {
        $sql = "select " . $column . " from `" . $table . "` ";
        $where = "";
        if ($condition != null) {
            foreach ($condition as $key => $value) {
                $where .= "$key = '$value' and ";
            }
            $sql .= "where $where";
            $sql .= "1 = 1 ";
        }
        if ($group != "") {
            $sql .= "group by " . $group . " ";
        }
        if ($order != "") {
            $sql .= " order by " . $order . " ";
        }
        if ($having != "") {
            $sql .= " having {$having} ";
        }
        if (  is_numeric($endSet) && is_numeric($startSet)) {
            $sql .= "limit $startSet,$endSet";
        }
        return $sql;
         
    }
    
}

?>