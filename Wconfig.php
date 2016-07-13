<?php
/**
 * Class Wconfig
 *  Конфигурационный статический класс
 */
class Wconfig
{
    private static $instance = null;
    private  $driver_db = 'mysqli'; //or sqlite - пока ещё не доступна
    private $prefix = 'webpay'; 
 private   $email_admin = 'ip-94@ya.ru'; 
    private    $wsb_storeid= '824779'; // Id магазина
    private  $wsb_secret_key ='3452345676569';
    private   $wsb_test = 1;
    private  $wsb_currency_id = 'BYN';
    private  $tcpdflib_path = 'tcpdf/examples/accept.php';
    private   $dbhost='localhost';
    private  $dbname= 'Vitaut';
    private   $dbuser = 'VITAUT';
    private  $dbpassword = 'VITAUT';
    private  $log_path = 'ClassWebPay/log.txt';
    private  $charset = 'utf8';
private  $url_sandbox = 'https://sandbox.webpay.by';


    /**
     * @return Singleton
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * prevent the instance from being cloned.
     *
     * @throws SingletonPatternViolationException
     *
     * @return void
     */
    final private function __construct()
    {

    }
    final private function __clone()
    {

    }

    /**
     * prevent from being unserialized.
     *
     * @throws SingletonPatternViolationException
     *
     * @return void
     */
    final private function __wakeup()
    {

    }
    public function __isset($name) {
        return isset($this->$name);
    }
    public function __get($name) {
        return $this->$name;
    }
    public function __set($name, $value) {
        throw new Exception('Not allowed');
    }

}


