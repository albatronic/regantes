<?php

/**
 * CLASE QUE IMPLEMENTA LA CAPA DE ACCESO A DATOS.
 * LOS PARAMETROS NECESARIOS PARA LA CONEXION SE DEFINEN EN EL ARCHIVO
 * config/config.xml O EN EL INDICADO EN EL SEGUNDO PARAMETRO DEL CONSTRUCTOR
 *
 * SE ADMITEN DIFERENTES MOTORES DE BASE DE DATOS. ACTUALMENTE ESTAN
 * IMPLEMENTADOS PARA MYSQL, MSSQL E INTERBASE.
 *
 * SI LA CONEXION ES EXITOSA $dbLink TENDRA VALOR,
 * EN CASO CONTRARIO ALMACENA EL MENSAJE DE ERROR PRODUCIDO QUE SE
 * PUEDE CONOCER CON EL METODO getError()
 */
class EntityManager {

    /**
     * Fichero de configuracion de conexiones por defecto
     * Es el fichero que se utilizará si no se indica otro en la
     * llamada al constructor.
     * @var string
     */
    private $file = "config/config.yml";
    public static $dbLinkInstance = null;
    
    /**
     * Link a la conexión establecida
     * @var Link conexion DB
     */
    private $dbLink = null;
    private $dbEngine;
    private $host;
    private $user;
    private $password;
    private $dataBase;
    private $result = null;
    private $affectedRows = null;

    /**
     * Guardar el eventual error producido en la conexión
     * @var array
     */
    private $error = array();

    /**
     * Estable la conexion a la base de datos.
     * Abre el fichero de configuracion '$fileConfig', o en su defecto config/config.yml
     * y lee el nodo $conection donde se definen los parametros de conexion.
     * 
     * Si no se indica valor para el parámetro $conection, se tomarán los valores
     * de la primera conexión definida en el archivo de configuración. De esta forma, y en el caso
     * de trabajar con una sola base de datos, no es necesario indicar el nombre de conexión para
     * cada tabla en el modelo de datos.
     *
     * En entorno de desarrollo los parámetros de conexión se fuerzan a:
     *
     *      user    =   $conection
     *      password=   $conection
     *      dataBase=   $conection
     *
     * 
     * Si la conexion es exitosa, getDblink() devolvera valor y si no getError() nos indica
     * el error producido.
     *
     * @param string $conection Nombre de la conexion, opcional
     * @param string $fileConfig Nombre del fichero de configuracion, opcional
     */
    public function __construct($conection = '', $fileConfig = '') {

        if ($fileConfig == '')
            $fileConfig = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/" . $this->file;

        if (file_exists($fileConfig)) {
            $yaml = sfYaml::load($fileConfig);

            // Si no se ha indicado el nombre de la conexión, se tomara la primera
            if ($conection == '')
                list($conection, $nada) = each($yaml['config']['conections']);

            $params = $yaml['config']['conections'][$conection];

            $this->dbEngine = $params['dbEngine'];
            $this->host = $params['host'];

            if ($_SESSION['EntornoDesarrollo']) {
                // En entorno de desarrollo se fuerzan los valores
                // al nombre de la conexión
                $this->user = $conection;
                $this->password = $conection;
                $this->dataBase = $conection;
            } else {
                // En entorno de producción se respetan los valores
                // indicados en el config/config.yml
                $this->user = $params['user'];
                $this->password = $params['password'];
                $this->dataBase = $params['database'];
            }
            $this->conecta();
        } else {
            $this->error[] = "EntityManager []: ERROR AL LEER EL ARCHIVO DE CONFIGURACION. " . $fileConfig . " NO EXISTE\n";
        }
    }

    /**
     * Conecta a la base de datos con los parametros de conexión indicados
     * en config/config.yml.
     * Si la conexion es exitosa, $this->dblink tendrá valor en caso contrario,
     * $this->error tendra el mensaje de error.
     */
    private function conecta() {

        switch ($this->dbEngine) {
            case 'mysql':
                if (is_null(self::$dbLinkInstance)) {
                    self::$dbLinkInstance = mysql_connect($this->getHost(), $this->getUser(), $this->getPassword());
                    if (is_resource(self::$dbLinkInstance)) {
                        mysql_select_db($this->getDataBase(), self::$dbLinkInstance);
                    }
                }
                $this->dbLink = self::$dbLinkInstance;
                break;

            case 'mssql':
                if (is_null(self::$dbLinkInstance)) {
                    self::$dbLinkInstance = mssql_connect($this->getHost(), $this->getUser(), $this->getPassword());
                    if (is_resource(self::$dbLinkInstance)) {
                        mssql_select_db($this->getDataBase(), self::$dbLinkInstance);
                    }
                }
                $this->dbLink = self::$dbLinkInstance;                
                break;

            case 'interbase':
                if (is_null(self::$dbLinkInstance)) {
                    self::$dbLinkInstance = ibase_connect($this->getHost(), $this->getUser(), $this->getPassword());
                }                
                $this->dbLink = self::$dbLinkInstance;
                break;
            default:
                $this->error[] = "EntityManager [conecta]: Conexión no realizada. No se ha indicado el tipo de base de datos. " . mysql_errno() . " " . mysql_error();
        }

        if (!$this->dbLink) {
            $this->error[] = "EntityManager [conecta]: No se pudo conectar " . $this->getHost() . ":" . $this->getDataBase() . "Error: " . $ex->message;
        }
    }

    /**
     * Cierra la conexión con la base de datos
     */
    public function desConecta() {
        /**
          if (is_resource($this->dbLink)) {
          switch ($this->dbEngine) {
          case 'mysql':
          mysql_close($this->dbLink);
          break;
          case 'mssql':
          mssql_close($this->dbLink);
          break;
          case 'interbase':
          ibase_free_result($this->result);
          ibase_close($this->dbLink);
          break;
          default:
          $this->error[] = "EntityManager [desConecta]: Desconexión no realizada. No se ha indicado el tipo de base de datos";
          }
          }
         */
    }
    
    /**
     * Ejecuta un query sobre la conexion existente. Si se produce algun error
     * se puede consultar con getError().
     * @param string Sentencia sql
     * @return result
     */
    public function query($query) {
        $this->result = null;

        switch ($this->dbEngine) {
            case 'mysql':
                //mysql_select_db($this->getdataBase());
                $this->result = mysql_query($query, $this->dbLink);
                if (!$this->result)
                    $this->setError("query");
                else
                    $this->affectedRows = mysql_affected_rows($this->dbLink);
                break;

            case 'mssql':
                //mssql_select_db($this->dataBase);
                $this->result = mssql_query($query, $this->dbLink);
                if (!$this->result)
                    $this->setError("query");
                else
                    $this->affectedRows = mysql_affected_rows($this->dbLink);
                break;

            case 'interbase':
                $query = str_replace("`", "", $query);
                $this->result = ibase_query($this->dbLink, $query);
                if (!$this->result)
                    $this->setError("query");
                else
                    $this->affectedRows = ibase_affected_rows($this->dbLink);
                break;

            default:
                $this->setError("query", "No se ha indicado el tipo de base de datos");
        }
        return $this->result;
    }

    /**
     * Carga datos en un array desde la BD.
     * El primer elemento del array tiene el indice 0. Cada elemento es a su vez
     * otro array ASOCIATIVO.
     * Este metodo debe ser llamado despues del metodo query().
     * Si se produce algun error se puede consultar con getError().
     * @return array Las filas encontradas
     */
    public function fetchResult() {
        $rows = array();

        switch ($this->dbEngine) {
            case 'mysql':
                while ($row = mysql_fetch_array($this->result, MYSQL_ASSOC))
                    $rows[] = $row;
                break;

            case 'mssql':
                while ($row = mssql_fetch_array($this->result, MYSQL_ASSOC))
                    $rows[] = $row;
                break;

            case 'interbase':
                while ($row = ibase_fetch_assoc($this->result))
                    $rows[] = $row;
                break;

            default:
                $this->setError("fetchResult", "No se ha indicado el tipo de base de datos");
                break;
        }
        return $rows;
    }

    /**
     * Devuelve $limit filas encontradas a partir de la fila $offset
     * Este metodo es similar a fetchResult.
     * @param integer $limit
     * @param integer $offset
     * @return array Las filas encontradas
     */
    public function fetchResultLimit($limit, $rowNumber = '') {
        $rows = array();
        $nfilas = 0;
        if ($rowNumber < 0)
            $rowNumber = 1;

        switch ($this->dbEngine) {
            case 'mysql':
                @mysql_data_seek($this->result, $rowNumber);
                while (($row = mysql_fetch_array($this->result, MYSQL_ASSOC)) and ($nfilas < $limit)) {
                    $nfilas++;
                    $rows[] = $row;
                }
                break;

            case 'mssql':
                //NO ESTA BIEN IMPLEMENTADO
                while ($row = mssql_fetch_array($this->result, MYSQL_ASSOC))
                    $rows[] = $row;
                break;

            case 'interbase':
                //NO ESTA BIEN IMPLEMENTADO
                while ($row = ibase_fetch_assoc($this->result))
                    $rows[] = $row;
                break;
            default:
                $this->setError("fetchResultLimit", "No se ha indicado el tipo de base de datos");
                break;
        }
        return $rows;
    }

    /**
     * Devuelve el numero de columnas de la consulta
     * @return integer El numero de columnas de la consulta
     */
    public function numFields() {
        switch ($this->dbEngine) {
            case 'mysql':
                return mysql_num_fields($this->result);
                break;

            case 'mssql':
                return mssql_num_fields($this->result);
                break;

            case 'interbase':
                return ibase_num_fields($this->result);

            default:
                $this->setError("numFields", "No se ha indicado el tipo de base de datos");
                break;
        }
    }

    /**
     * Devuelve el numero de filas de la consulta
     * @return integer El numero de filas de la consulta
     */
    public function numRows() {
        switch ($this->dbEngine) {
            case 'mysql':
                return mysql_num_rows($this->result);
                break;

            case 'mssql':
                return mssql_num_rows($this->result);
                break;

            case 'interbase': //NO IMPLEMENTADO
                return false;
                break;

            default:
                $this->setError("numRows", "No se ha indicado el tipo de base de datos");
                break;
        }
    }

    /**
     * Se posiciona en el numero de registro indicado
     * @param integer $rowNumber El numero de registro a donde posicionarse
     * @return boolean
     */
    public function dataSeek($rowNumber) {
        switch ($this->dbEngine) {
            case 'mysql':
                return mysql_data_seek($this->result, $rowNumber);
                break;

            case 'mssql':
                //No implementado
                return false;
                break;

            case 'interbase':
                //No implementado
                return false;
                break;

            default:
                $this->setError("dataSeek", "No se ha indicado el tipo de base de datos");
                return false;
                break;
        }
    }

    /**
     * Devuelve el ID del ultimo insert
     * @return inter
     */
    public function getInsertId() {
        switch ($this->dbEngine) {
            case 'mysql':
                return mysql_insert_id($this->dbLink);
                break;

            case 'mssql':
                //No implementado
                return 0;
                break;

            case 'interbase':
                //No implementado
                return 0;
                break;

            default:
                $this->setError("getInsertId", "No se ha indicado el tipo de base de datos");
                return 0;
                break;
        }
    }

    /**
     * Devuelve el numero de filas afectadas en la ultima consulta
     * @return integer
     */
    public function getAffectedRows() {
        return $this->affectedRows;
    }

    /**
     * Devuelve el nombre del servidor de datos
     * @return string El nombre del servidor
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Devuelve el usuario de conexion a la base de datos
     * @return string Usuario
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Devuelve el password de conexion a la base de datos
     * @return string Password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Devuelve el nombre de la base de datos
     * @return string Nombre de la base de datos
     */
    public function getDataBase() {
        return $this->dataBase;
    }

    public function getDbLink() {
        return $this->dbLink;
    }

    /**
     * Genera el mensaje de error haciendo una gestión individualizada
     * de algunos errores dependiendo del código de error y del motor de base de datos
     *
     * @param string $method El nombre del método que capturó el error
     * @param string $error Mensaje de error personalizado (opcional)
     */
    public function setError($method, $error = '') {

        $mensaje = "EntityManager [{$method}]: ";

        if ($error != '')
            $mensaje .= $error;
        else {
            switch ($this->dbEngine) {
                case 'mysql':
                    switch (mysql_errno()) {
                        case '1062':
                            $mensaje .= "Datos duplicados. " . mysql_error();
                            break;
                        default:
                            $mensaje .= mysql_errno() . " " . mysql_error();
                            break;
                    }
                    break;

                default:
                    $mensaje .= mysql_errno() . " " . mysql_error();
                    break;
            }
        }

        $this->error[] = $mensaje;
    }

    /**
     * Devuelve un array con los errores producidos
     * @return array Eventuales errores
     */
    public function getError() {
        return $this->error;
    }

}

?>
