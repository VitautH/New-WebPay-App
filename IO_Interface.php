<?
/**
 * Interface I_O Интерфейс Ввода-Вывода
 * ! $type - тип сущностей, который указывает какие данные от кого получить и кому передать
 */

interface IO_Interface {

    static  public   function setField($type,$key, $value); // $value = array данных, $type = тип сущностей Price, User, Webpay
    static  public   function setArray($type,$params=array()); // Теперь можно передовать много данных. Очень много! Главное, чтобы Класс знал, что с ними ему  делать
    static public  function getArray ($type, $params=array()); // Получаем ответ в виде массива
    static  public   function update($type,$params=array());
    static  function setSession( $key, $value);
    static  function getSession ($key);
    static  function delSession ($key);
    static public function getField($type, $key); // $value = array данных, $type = тип сущностей Price, User, Webpay, if $type == null return default
    static public function getConfig($value); // Получаем конфигурационные значения
    static public function delete($type,$params=array());


}