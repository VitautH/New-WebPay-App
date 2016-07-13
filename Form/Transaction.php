<?
class Transaction {

    private  $wsb_storeid;
    private  $wsb_seed;
    private  $wsb_secret_key;
    private $wsb_order_num;
    private  $wsb_test;
    private  $wsb_currency_id;
    private $wsb_total;
    private $wsb_invoice_item_name;
    private $wsb_signature;

    public function __construct($params)
    {


       $this->wsb_storeid= IO::getConfig('wsb_storeid');
        $this->wsb_seed  = time();

       $this->wsb_secret_key = IO::getConfig('wsb_secret_key');
        $this->wsb_invoice_item_name = $params['invoice_item_name'];
      IO::getField('price',  $this->wsb_invoice_item_name);
          $this->wsb_total =    IO::getField ('io', 'request');
        $id_user = IO::getSession ('id_user');

        $site_order_id = preg_replace("/[^0-9]/", '', $id_user);
        $site_order_id_tmp= ++$site_order_id;
        $this->wsb_order_num='ORDER-'.$site_order_id_tmp;
        /////
        $this->wsb_test=  IO::getConfig('wsb_test');
        $this->wsb_currency_id =  IO::getConfig('wsb_currency_id');

        $this->wsb_signature= $this->key();




}

public function Get ($data){
   return $results= $this->$data;

}

    private function key (){



     return   $this->wsb_signature = sha1($this->wsb_seed.$this->wsb_storeid.$this->wsb_order_num.$this->wsb_test.$this->wsb_currency_id.$this->wsb_total.
            $this->wsb_secret_key);

    }
    static public function oplata_save_Db (  $order_num,$order_id, $transaction_id,   $status){
     try {
         $id_user = IO::getSession ('id_user');
     }

catch(Exception $e) {

    $id_user = preg_replace("/[^0-9]/", '', $order_num)-1;
}

        // Create and populate an object.
        $data = new stdClass();

        $data->order_id = intval ($order_id);
        $data->user_id = intval ($id_user);
        $data->status =   intval ($status);
        $data->transaction_id	 =   intval ($transaction_id);
// Insert the object into the user profile table.
        $result = &Factory::getDb()->insertObject('webpay_transaction', $data);
        unset($result);
        unset ($data);
        $params= array('order_id'=> intval ($order_id),'id' => intval ($id_user), 'status' => intval ($status));
       IO::update('user', $params);
        }
   public  function __destruct() {
      //  $this->db->close();
    }
}