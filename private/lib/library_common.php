<?php
require('Zend/Db.php');
require('Zend/Log.php');
require('Zend/Log/Writer/Stream.php');
require('Zend/Cache.php');

$PDOParams = array(
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        PDO::ATTR_PERSISTENT => false
);


$parameters = array(
        'host'     => __DB_HOST,
        'username' => __DB_USER,
        'password' => __DB_PASSWORD,
        'dbname'   => __DB_DATABASE,
        'port'   => __DB_PORT,
        'driver_options' => $PDOParams
);

$db = Zend_Db::factory('Pdo_Mysql', $parameters);

$parameters_staing = array(
        'host'     => __DB_HOST_STAGING,
        'username' => __DB_USER_STAGING,
        'password' => __DB_PASSWORD_STAGING,
        'dbname'   => __DB_DATABASE_STAGING,
        'port'   => __DB_PORT_STAGING,
        'driver_options' => $PDOParams
);

$db_STAGING = Zend_Db::factory('Pdo_Mysql', $parameters_staing);

$parameters_matrix = array(
        'host'     => __DB_HOST_MATRIX,
        'username' => __DB_USER_MATRIX,
        'password' => __DB_PASSWORD_MATRIX,
        'dbname'   => __DB_DATABASE_MATRIX,
        'port'   => __DB_PORT_MATRIX,
        'driver_options' => $PDOParams
);

$db_MATRIX = Zend_Db::factory('Pdo_Mysql', $parameters_staing);

/*****************************************************************************************************************/

function GetZendDBConn()
{
        global $db;
        try
        {
                $db->getConnection();
                $db->setFetchMode(Zend_Db::FETCH_ASSOC);
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                //exit;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                //exit;
        }
}
function GetZendDBConn_db_STAGING()
{
        global $db_STAGING;
        try
        {
                $db_STAGING->getConnection();
                $db_STAGING->setFetchMode(Zend_Db::FETCH_ASSOC);
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                //exit;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                //exit;
        }
}
function GetZendCacheObject()
{
        global $cache;
        $frontendOptions = array(
                'lifetime' => __ZEND_CACHE_LIFETIME,
                'automatic_serialization' => true
        );

        $backendOptions = array(
                'cache_dir' => __ZEND_CACHE_FILE_PATH
        );

        $cache = Zend_Cache::factory('Core',
                'File',
                $frontendOptions,
                $backendOptions
        );

        return $cache;
}

function log_errors($err)
{
        $writer = new Zend_Log_Writer_Stream(__ZEND_LOG_FILE);
        $logger = new Zend_Log($writer);
        $logger->info($err);
}

function db__query($query, $params=array())
{
        global $db;
        GetZendDBConn();
        try
        {
                $result = $db->fetchAll($query, $params);
                return $result;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}


function db__select_staging($query, $params=array())
{
        global $db_STAGING;
        GetZendDBConn();
        try
        {
                $result = $db_STAGING->fetchAll($query, $params);
                return $result;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}



function db__select($query, $params=array())
{
        global $db;
        GetZendDBConn();
        try
        {
                $result = $db->fetchAll($query, $params);
                return $result;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__select_matrix($query, $params=array())
{
        global $db_MATRIX;
        GetZendDBConn();
        try
        {
                $result = $db_MATRIX->fetchAll($query, $params);
                return $result;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__select_sql($query, $params=array())
{
        global $db;
        GetZendDBConn();
        try
        {
                $result = $db->fetchAll($query, $params);
                return $result;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}


function db__insert($table_name, $params=array())
{
        global $db;
        GetZendDBConn();
        try
        {
                $db->insert($table_name, $params);
                return $db->lastInsertId();
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__update($table_name, $data, $condition)
{
        if (empty($condition))
        {
                return false;
        }

        global $db;
        GetZendDBConn();
        try
        {
                $db->update($table_name, $data, $condition);
                return true;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__delete($table_name, $condition)
{
        if (empty($condition))
        {
                return false;
        }

        global $db;
        GetZendDBConn();
        try
        {
                $db->delete($table_name, $condition);
                return true;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

/*****************************************************************************************************************/
function db__insert_staging($table_name, $params=array())
{
        global $db_STAGING;
        GetZendDBConn();
        try
        {
                $db_STAGING->insert($table_name, $params);
                return $db_STAGING->lastInsertId();
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__update_staging($table_name, $data, $condition)
{

        if (empty($condition))
        {
                return false;
        }

        global $db_STAGING;
        GetZendDBConn_db_STAGING();
        try
        {
           // print_r($condition); die;
                $db_STAGING->update($table_name, $data, $condition);

                return true;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}

function db__delete_staging($table_name, $condition)
{
        if (empty($condition))
        {
                return false;
        }

        global $db_STAGING;
        GetZendDBConn();
        try
        {
                $db_STAGING->delete($table_name, $condition);
                return true;
        }
        catch (Zend_Db_Adapter_Exception $e)
        {
                log_errors($e);
                return false;
        }
        catch (Zend_Exception $e)
        {
                log_errors($e);
                return false;
        }
}



function GetHTTPResponse($url)
{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, __SITE_URL);
        $body = curl_exec($ch);
        curl_close($ch);

        return $body;
}

function cleanup_string($query)
{
        $pattern = '/\s\s+/';
        $replacement = ' ';

        $query = trim($query);
        $query = preg_replace($pattern, $replacement, $query);
        return $query;
}


function get_formatted_datetime($datetime)
{
        return date('d-m-yy h:i', $datetime);
}


function select_Procedure($query){

                    try {
            $conn = new PDO("mysql:host=localhost;dbname=inventory",
                            "root", "");

                        $sql = $query;
            $q = $conn->query($sql);
           // $q->setFetchMode(PDO::FETCH_ASSOC);
            //$data = $q->fetchAll();
        } catch (PDOException $pe) {
                die();
            //die("Error occurred:" . $pe->getMessage());
        }


                  $r[] = $q->fetchAll();


                return $r;
}



function select_Procedure_62($query){

                    try {
            $conn = new PDO("mysql:host=".__DB_HOST.";dbname=".__DB_DATABASE,
                            __DB_USER, __DB_PASSWORD);

                        $sql = $query;
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $pe) {
                die();
            //die("Error occurred:" . $pe->getMessage());
        }


                  $r[] = $q->fetch();


                return $r;
}



?>