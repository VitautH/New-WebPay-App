<?
/*
 * Класс для работы с пользователями
 */

 class User {
     private $name;
     private  $address;
     private  $email;
     private $phone;
private  $price;
     private $number_passport;
     private $data_passport;
     private $authority_passport;
     private $service;

     private  $action;

     public function __construct ($params) {
         $this->action = $params ['action']; // Динамически вызываем нужный нам метод
        // if (isset($params ['price_ooo']) and isset ( $params ['price_chup'])) {
        //     $this->price_ooo = $params ['price_ooo'];

         //    $this->price_chup = $params ['price_chup'];
        // }

         $key= $params ['key'];

         $method = ucfirst($this->action);

         $this->$method($params); // Динамически вызываем нужный нам метод
     }

     private function Set ($params){
  $this->name = $params ['lastname'].' '. $params ['name'].' '. $params ['surname'];
         $this->address = 'Индекс: '.$params ['index'].', город: '.$params ['city'].', улица: '.$params['street'].', дом: '.$params['home'].', кв.: '.$params ['app'];
   $this->email = $params ['email'];
         $this->phone = $params['phone'];
         $this->service = $params ['invoice_item_name'];
       IO::getField('price', $this->service);
         $this->price = IO::getField ('io', 'request');
         $this->number_passport = $params ['number_passport'];
         $this->data_passport = $params ['data_passport'];
         $this->authority_passport= $params ['authority_passport'];

         // Проверку реализовать позднее If Check return true-> call method Save ();
         $this->Save();

     }
     private function Check (){

     }
     private function Delete ($params){
$id= $params['id'];
         $db = &Factory::getDb();

         $query = $db->getQuery(true);

         $conditions = array(
             $db->quoteName('id') . ' ='.$id.''
 );

         $query->delete($db->quoteName('webpay_user'));
         $query->where($conditions);

         $db->setQuery($query);

         $result = $db->execute();
     }
     private function Get ($params){

             $order_id = $params ['order_id'];
             $db =& Factory::getDb();

             $query = 'SELECT * FROM webpay_user WHERE  order_id  = "' . $order_id . '"';

             $db->setQuery($query);
             $result = $db->loadAssoc();
             IO::setField('io', 'request', $result);

     }
     public static function getAll (){
         $db =& Factory::getDb();

         $query = 'SELECT * FROM webpay_user WHERE  status  = 4';

         $db->setQuery($query);
      return   $row = $db->loadAssocList();


     }
     private function Setemail ($params){
         $order_id = $params ['order_id'];
         $db =& Factory::getDb();

         $query='SELECT * FROM webpay_user WHERE  order_id  = "'.$order_id.'"';

         $db->setQuery($query);
         $request =  $db->loadAssoc();
//
//         $name = $request ['name'];
//         $service = $request ['service'];
//         $address = $request ['address'];
//         $phone = $request ['phone'];
//         $email = $request ['email'];
    $url_dogovor ='http://prav.by/'.IO::getConfig('tcpdflib_path').'/?&file='.$params.'';
         $message= 'Произведена оплата. Договор:'.$url_dogovor.'';
         mail(IO::getConfig('email_admin'), "Оплата от Prav.by", $message,
             "From: admin@prav.by \r\n"
             ."X-Mailer: PHP/" . phpversion());
     }
     private function Save (){
// Create and populate an object.
         $data = new stdClass();
         $data->data = date("m.d.Y");
         $data->name = $this->name;
         $data->address = $this->address;
         $data->email =   $this->email;
         $data->phone =   $this->phone;
         $data->service =    $this->service;
         $data->price = $this->price;
         $data->number_passport =  $this->number_passport;
         $data->data_passport =   $this->data_passport;
         $data->authority_passport= $this->authority_passport;
// Insert the object into the user profile table.
         $result = &Factory::getDb()->insertObject('webpay_user', $data);
         $id = &Factory::getDb()->insertid(); // Получаем ссылку на запись
         IO::setSession('id_user', $id); // Сохраняем её в Реестре
     unset($result);
         unset ($data);

     }
     private  function Update ($params){


         $object = new stdClass();

// Must be a valid primary key value.
         $object->id = $params['id'];
         $object->status =  $params['status'];
         $object->order_id =  $params['order_id'];

// Update their details in the users table using id as the primary key.
         $result = &Factory::getDb()->updateObject('webpay_user', $object, 'id');
         unset ($object);
       $params = &$params['order_id'];
         $this->Setemail($params);
     }
}
