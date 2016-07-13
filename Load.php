<?php
/**

 * Class Factory

 * Для автозагрузки, инициализации и подключения  классов и модулей  приложения

 * Designed by Vitaut, May, 2016

 */

//error_reporting( E_ERROR );

include_once ('Wconfig.php');
abstract class Factory

{
    public static $database = null;
    public static function load_params ($path,$class,$params)

    {

        if ($path==''){

            $class = ucfirst($class);

            if (file_exists(dirname(__FILE__).'/'.$path.''.$class.'.php')==false){



                throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

            }

            else {

                include_once(dirname(__FILE__).'/'.$path.''.$class.'.php');

            }



        }

        else {

            $class = ucfirst($class);

            if (file_exists(dirname(__FILE__).'/'.$path.''.$class.'.php')==false){



                throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

            } else

            {

                include_once(dirname(__FILE__).'/'.$path.''.$class.'.php');

                if (class_exists($class)) {





                    return new $class ($params);







                }

                else

                {

                    throw new \Exception("Такой класс ".$class."  не существует");

                }

            }



        }











    }



    public static function load($path,$class)

    {

        if ($path==''){

            $class = ucfirst($class);

            if (file_exists(dirname(__FILE__).'/'.$path.''.$class.'.php')==false){



                throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

            }

            else {

                include_once(dirname(__FILE__).'/'.$path.''.$class.'.php');
                if (class_exists($class)) {





                 $obj = new $class ();


                    return $obj;




                }

            }



        }

        else {

            $class = ucfirst($class);

            if (file_exists(dirname(__FILE__).'/'.$path.''.$class.'.php')==false){



                throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

            } else

            {

                include_once(dirname(__FILE__).'/'.$path.''.$class.'.php');

                if (class_exists($class)) {





                  $obj = new $class ();

return $obj;





                }

                else

                {

                    throw new \Exception("Такой класс- ".$class." не существует");

                }

            }



        }

    }

public  static function getDb(){
    if (!self::$database)
               {
                  self::$database = self::createDbo();
         }

        return self::$database;
}
    public static function createDbo() {
        self::import('Database/', 'FactoryDB');
        $driver =  IO::getConfig('driver_db'); // Получаем тип базы данных
        $options = array('prefix'=>IO::getConfig('prefix'),'user' => IO::getConfig('dbuser'),'host' => IO::getConfig('dbhost'), 'password' =>IO::getConfig('dbpassword'), 'database' =>IO::getConfig('dbname'), 'charset' => IO::getConfig('charset'));

        try
        {
            $db = FactoryDB::getInstance();
$db = FactoryDB::getDriver($driver, $options);
         }
         catch (RuntimeException $e)
         {
                         if (!headers_sent())
                             {
                                 header('HTTP/1.1 500 Internal Server Error');
             }

             exit('Database Error: ' . $e->getMessage());
         }



         return $db;
    }

    public  static  function import ($path, $class){

        if ($path==''){

            $class = ucfirst($class);

           if (file_exists(dirname(__FILE__).'/'.$path.$class.'.php')==false){



               throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

           }

            else {

                include_once(dirname(__FILE__).'/'.$path.$class.'.php');

            }



        }

        else {

            $class = ucfirst($class);

            if (file_exists(dirname(__FILE__).'/'.$path.''.$class.'.php')==false){



                throw new \Exception("Error! File ".$path."".$class.".php"." not found in folder ClassWebPay!");

            } else

            {

                include_once(dirname(__FILE__).'/'.$path.''.$class.'.php');

            }



        }

    }

}



 Factory::import('','Io'); // Подключаем библиотеку Ввода-Вывода
$db = Factory::getDb(); // Инициализируем и создаём подключение к базе данных

/**

 * Factory::load_params('', $class ,$params);  - Инициализация класса с параметрами. Первый аргумент- путь к файлу

 * Factory::load('', $class); - Инициализация класса без параметров.Первый аргумент- путь к файлу

 * Метод import- если экземпляр класса создать нельзя (напр. это Статический класс) или данный файл не содержит Класс, или экземпляр класса будет создавать кто-то другой

 * Factory::import ($path, $class); - Подключение библиотек/ Path- путь от корневой папки данного файла. Если файл находится в той же папки, то Path = null

 * Название файлов библиотек и самих классов должны начинаться  с Прописной буквы

 * Пример:

 * Factory::import('Form/' ,'User');

 * Factory::import('','Io');

*/