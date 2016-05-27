<?php
/**
 * Clase encargada de hacer las conexiones a la base de datos 
 *
 * @author Felipe Barnett
 */
class DataBase {
    /**
     * Connection to the data base
     * @var mysqli connection
     */
    private $_conn;
    /**
     * query for exec
     * @var string
     */
    private $_query;
    /**
     * ip or hostname of the database
     * @var String 
     */
    private $_host = "localhost";
    /**
     * username of the database
     * @var String
     */
    private $_user = "ejemplo";
    /**
     * password of the database
     * @var String
     */
    private $_password = "123";
    /**
     * name of the database
     * @var String
     */
    private $_dataBase = "ejemplo";
    /**
     * port of the database
     * @var int
     */
    private $_port = 3306;
    /**
     * Contructor de la clase
     * 
     * @param String $host
     * @param String $user
     * @param String $password
     * @param String $database
     * @param int $port
     */
    public function __construct($host="", $user="", $password="", $database="", $port=0) {
        if($host != "") {
            $this->_host = $host;
            $this->_user = $user;
            $this->_password = $password;
            $this->_database = $database;
            $this->_port = $port;
        }
        $this->_connect();
    }
    /**
     * Creates a connection with the database
     */
    private function _connect()
    {
        $this->_conn  = new mysqli(
            $this->_host, $this->_user, $this->_password, $this->_dataBase, $this->_port
        );
        if ($this->_conn->connect_errno) {
            echo "Fallo al contenctar a MySQL: (" 
            . $this->_conn->connect_errno . ") " 
            . $this->_conn->connect_error;
            return;
        } 
    }
    /**
     * Exec a query in the data base
     * 
     * @param Strng $table
     * @param String $where
     */
    private function _execute()
    {
        //echo $this->_query;
        if (!($res = $this->_conn->query($this->_query))) {
            trigger_error(
                "Error: (".$this->_conn->errno.")"
                .$this->_conn->erroron." the query:".$this->_query,
                E_USER_WARNING
            );
        }
        return $res;
    }
    /**
     * Close the data base connections
     * 
     * @return void
     * @access private
     */
    public function disconnect()
    {
        mysqli_close($this->_conn); 
    }
    /**
     * Convierte el resultado un query en un arreglo 
     * 
     * @param DBresult $result resultado de la ejecución de un query
     * 
     * @return array
     */
    private function _resultToArray($result)
    {
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return $rows;
    }
    /**
     * Selects a table from data base
     * 
     * @param Strng $table
     * @param String $where
     */
    public function select($columns, $table, $where = 1) {
        $this->_query = "SELECT $columns FROM $table where $where";
        $result = $this->_execute();
        $array = $this->_resultToArray($result);
        return $array;
    }
    /**
     * Selects a table from data base
     * 
     * @param Strng $table
     * @param String $where
     */
    public function insert($values, $columns, $table) {
        $this->_query = "INSERT INTO $table ($columns) values($values) ";
        $result = $this->_execute();
    }
    /**
     * Obtiene el número de filas de una consulta
     * 
     * @param mysqliresult $result resultado de la ejecución del query
     * 
     * @return int númeor de filas de la consulta
     */
    private function _getNumRows($result)
    {
        return mysqli_num_rows($result);
    }
}
/**
 * Print results as a json object 
 * @param array $resultArray
 */
function printResults($resultArray) {
    $callback = isset($_GET['callback']);
//    header('Content-Type: application/javascript');
    if ($callback) {
        echo "{$_GET['callback']}(";
    }
    echo json_encode($resultArray);
    if ($callback) {
        echo ")";
    }
    exit();
}
 $defaultPostNumber = 30;

