<?
/*
 * Класс Input Output
 */
include_once ('IO_Interface.php');
abstract class IO implements IO_Interface {
    const LOGGER = 'logger';
    /**
     * @var array
     */

    protected static $storedValues = array();
    // $value = array данных, $type = тип сущностей Price, User, Webpay, if $type == null return default
    /**
     * sets a value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @static
     *
     * @return void
     */
    static  public   function setField($type,$key, $value)
    {

        $data = array();

        $data[$key] = $value;
        $action = array("action" => "set");
        $params = array_merge($action, $data);
        if ($type != '') {
            if ($type == 'io') {
                self::$storedValues[$key] = $value;
            } else {
                $query = Factory::load_params('Form/', $type, $params);
            }
        }

    }
    static  public   function setArray($type,$params=array()){

        $action = array ("action" => "set");
        $data = array_merge ($action, $params);
        if ($type != '') {
            if ($type == 'io') {
                self::$storedValues = $params;
            } else {
                $query = Factory::load_params('Form/', $type, $data);
            }
        }
    }
    static public  function getArray ($type, $params=array()) {
        if ($type != '') {
            if ($type == 'io') {

                return self::$storedValues;
            }
            else {
               $action = array("action" => "get");
               // $value = array("key" => $key);
                $data = array_merge($action, $params);

                $query = Factory::load_params('Form/', $type, $data);


            }
        }

    }
    static  public   function update($type,$params=array()){

        $action = array ("action" => "update");
        $data = array_merge ($action, $params);
        if ($type != '') {
          $query  = Factory::load_params('Form/',$type ,$data);

            if ($query== true) {
                return true;
            }
        }
    }
    /*
     * Тип не нужен, так как Сессия- общее хранилеже данных
     */
    static  function setSession( $key, $value){
        add_action( 'init', 'register_session' );
        $_SESSION[$key] = $value;
    }
    static  function getSession ($key){
        add_action( 'init', 'register_session' );
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        else {
            throw new \RuntimeException("Ошибка! Значение не найдено");
        }
    }
    static  function delSession ($key)
    {
        unset($_SESSION[$key]);
    }
    // $value = array данных, $type = тип сущностей Price, User, Webpay
    /**
     * gets a value from the registry.
     *
     * @param string $key
     *
     * @static
     *
     * @return mixed
     */
    static public  function getField ($type, $key) {
        if ($type != '') {
            if ($type == 'io') {
                 self::$storedValues[$key];
                return self::$storedValues[$key];
            }
            else {
                $action = array("action" => "get");
                $value = array("key" => $key);
                $data = array_merge($action, $value);

                $query = Factory::load_params('Form/', $type, $data);


            }
      }

    }
    // $value = array данных, $type = тип сущностей Price, User, Webpay, if $type == null save default. Save Data in DataBase
 //   static  public  function saveField($type,$key, $value) {
        //self::$storedValues[$key] = $value;

   // }
    // Получаем конфигурационные значения
    static public  function getConfig($value){
        return Wconfig::getInstance()->$value;
    }


    static public function delete($type,$params=array()){

        $action = array ("action" => "delete");
        $data = array_merge ($action, $params);
        if ($type != '') {
            $query  = Factory::load_params('Form/',$type ,$data);
        }
    return true;
    }

}

