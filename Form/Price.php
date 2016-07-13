<?

/*

 * Сохранение, проверка и получение  Цены

 */
class Price

{

    private $price_ooo;

    private $price_chup;
    private $action;



    public function __construct($params)

    {

        $this->action = $params ['action']; // Динамически вызываем нужный нам метод
        if (isset($params ['price_ooo']) and isset ( $params ['price_chup'])) {
            $this->price_ooo = $params ['price_ooo'];

            $this->price_chup = $params ['price_chup'];
        }
        $data= $params ['key'];

        $method = ucfirst($this->action);

        $request =  $this->$method($data); // Динамически вызываем нужный нам метод

     // Отдаём Ответ классу Ввод-Вывода
    }

    /*

     * Получаем цену из базы данных

     */



    private function Get($data){


        $db =& Factory::getDb();

        $query='SELECT price FROM webpay_price WHERE  name = "'.$data.'"';

        $db->setQuery($query);
      $result =  $db->loadResult();
        IO::setField('io', 'request',$result);





    }



    /*

     * Обновляем цену в базе данных

     */

    private function Update(){



        if ($this->Chek()== true){



            $object = new stdClass();

// Must be a valid primary key value.
            $object->name = 'ooo';
            $object->price =$this->price_ooo;

// Update their details in the users table using id as the primary key.
            $result = &Factory::getDb()->updateObject('webpay_price', $object, 'name');
            unset ($object);
            $object = new stdClass();

// Must be a valid primary key value.
            $object->name = 'chup';
            $object->price =$this->price_chup;
            $result = &Factory::getDb()->updateObject('webpay_price', $object, 'name');
            unset ($object);
// Update their details in the users table using id as the primary key.
            return true;
        }

        else {



            throw new \RuntimeException("Ошибка! Цена должна иметь вид и минимальное значение 00,01");

        }

    }

    /*

     * Проверяем цену и приводим её к виду **,** BYN

     */

    private function Chek(){





        if ((number_format($this->price_ooo, 2, ',', '')) != '0,00' or (number_format($this->price_chup, 2, ',', '')) != '0,00'  ){

            $this->price_ooo = number_format($this->price_ooo, 2, ',', '');
            $this->price_chup = number_format($this->price_chup, 2, ',', '');

            return true;

        }

        else {

            return false;

        }



    }



}