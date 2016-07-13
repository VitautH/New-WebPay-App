<?php
/*
Template Name: oplata
*/
Factory::import('Form/', 'transaction');
?>
<?php get_header(); ?>
<link href="<?php echo get_template_directory_uri(); ?>/css/view.css" rel="stylesheet">
<script src="<?php echo get_template_directory_uri(); ?>/js/view.js"></script>
<div class="row background_row ">
    <?php get_sidebar(); ?>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 content">
        <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
        <h1 class="zagolovok"><?php the_title(); ?></h1>
        <?php the_content(); ?>

               <? if (($_POST['form_id']== 'id344')&& isset ($_POST['name1']) && isset ($_POST ['lastname1']) && isset ($_POST ['surname']) && ($_POST ['index']) && ($_POST ['city']) && ($_POST['street']) && ($_POST['home']) && ($_POST ['app']) && ($_POST ['email']) && ($_POST ['phone']) && ($_POST ['oferta'])&& ($_POST ['number_passport'])&& ($_POST ['data_passport'])&& ($_POST ['authority_passport']) )
                {


                    $params = array('name' => $_POST['name1'],'lastname'=>$_POST ['lastname1'], 'surname'=>$_POST ['surname'], 'index'=> $_POST ['index'],'city'=> $_POST ['city'], 'street'=> $_POST['street'], 'home'=> $_POST['home'],'app'=> $_POST ['app'],'email'=> $_POST ['email'],'phone'=> $_POST ['phone'], 'number_passport'=> $_POST ['number_passport'],'data_passport'=> $_POST ['data_passport'],'authority_passport'=> $_POST ['authority_passport'],'invoice_item_name'=>$_POST ['invoice_item_name']); // Type- передаём тип поля
                    $invoice_item_name = $_POST ['invoice_item_name'];

                    IO::setArray('user', $params);
                    $webpay =  new Transaction(array('invoice_item_name' =>$invoice_item_name) );
                    IO::getField('price',$invoice_item_name);
                    $wsb_total = IO::getField ('io', 'request'); // Получаем цену
                    $name= $_POST ['lastname1'].' '. $_POST['name1'].' '.$_POST ['surname'];
                    $number_passport=$_POST ['number_passport'];
                    $data_passport= $_POST ['data_passport'];
                    $authority_passport= $_POST ['authority_passport'];
                $address = 'Индекс: '.$_POST ['index'].', город: '.$_POST ['city'].', улица: '.$_POST['street'].', дом: '.$_POST['home'].', кв.: '.$_POST ['app'];
                   $email = $_POST ['email'];
                  $phone = $_POST ['phone'];


                    $wsb_order_num = $webpay->Get('wsb_order_num');

                    $wsb_storeid = $webpay->Get('wsb_storeid');
                    IO::getField('price', $invoice_item_name);
                    $wsb_total = IO::getField ('io', 'request');

                    $wsb_seed  = $webpay->Get('wsb_seed');
                    IO::getField('webpay', 'wsb_signature');
                    $wsb_signature  = $webpay->Get('wsb_signature');









                ?>
                    <table class="table table-condensed">
                        <thead>
                        <tr> <th>#</th> <th>Счёт</th> </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">ФИО:</th> <td><b><? echo $name; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Адрес доставки:</th> <td><b><? echo $address; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Телефон:</th> <td><b><? echo $phone; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">E-mail:</th> <td><b><? echo $email; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Номер паспорта:</th> <td><b><? echo $number_passport; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Дата выдачи паспорта:</th> <td><b><? echo $data_passport; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Кем выдан:</th> <td><b><? echo $authority_passport; ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Услуга:</th> <td><b>Пакет документов для регистрации  <?
                                    switch ($invoice_item_name) {
                                        case 'ooo':
                                           echo "ООО";
                                            break;
                                        case 'chup':

                                            echo "ЧУП";
                                            break;

                                    }
                                    ?></b></td>
                        </tr>
                        <tr>
                            <th scope="row">Стоимость:</th> <td><b> <? echo $wsb_total; ?> <? echo IO::getConfig('wsb_currency_id'); ?></b></td>
                        </tr>
                        <tr> <th scope="row"><form action="https://securesandbox.webpay.by/" method="post">
                                    <input type="hidden" name="*scart">
                                    <input type="hidden" name="wsb_version" value="2">
                                    <input type="hidden" name="wsb_language_id" value="russian">
                                    <input type="hidden" name="wsb_storeid" value="<? echo $wsb_storeid; ?>" >
                                    <input type="hidden" name="wsb_order_num" value="<? echo $wsb_order_num; ?>" >
                                    <input type="hidden" name="wsb_test" value="1" >
                                    <input type="hidden" name="wsb_currency_id" value="<? echo IO::getConfig('wsb_currency_id'); ?>" >
                                    <input type="hidden" name="wsb_seed" value="<? echo $wsb_seed; ?>">
                                    <input type="hidden" name="wsb_customer_name" value="<? echo $lastname.' '.$name.' '.$surname; ?>">
                                    <input type="hidden" name="wsb_customer_address" value="<? echo $address; ?>">
                                    <input type="hidden" name="wsb_return_url" value="http://prav.by/success">
                                    <input type="hidden" name="wsb_cancel_return_url" value="http://prav.by/cancel">
                                    <input type="hidden" name="wsb_notify_url" value="http://prav.by/notify.php">
                                    <input type="hidden" name="wsb_email" value="<? echo $email; ?>" >
                                    <input type="hidden" name="wsb_phone" value="<? echo $phone; ?>" >
                                    <input type="hidden" name="wsb_invoice_item_name[]" value="Пакет документов для регистрации  <?
                                    switch ($invoice_item_name) {
                                        case 'ooo':
                                            echo "ООО";
                                            break;
                                        case 'chup':

                                            echo "ЧУП";
                                            break;

                                    }
                                    ?>">
                                    <input type="hidden" name="wsb_invoice_item_quantity[]" value="1">
                                    <input type="hidden" name="wsb_invoice_item_price[]" value="<? echo $wsb_total; ?>">
                                    <input type="hidden" name="wsb_total" value="<? echo $wsb_total; ?>" >
                                    <input type="hidden" name="wsb_signature" value="<? echo $wsb_signature; //echo $api->wsb_signature;?>" >
                                    <input type="submit" value="Оплатить">
                                </form></th> 
                            <td>
                               <a href="http://prav.by">Назад</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <?

                }
                else {
                echo "Ошибка модификатора доступа! Или Вы ввели не все данные формы.";
                }
                ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
    <div class="col-lg-2 col-md-2 col-sm-0 col-xs-0 rightmenu">
        <?php $other_page2 = 4066; ?>
        <?php while (has_sub_field('action_left', $other_page2)): ?>
            <?php $bigakcia = get_sub_field('action_image', $other_page);
            $akciaimage = wp_get_attachment_image_src($bigakcia, 'akcia-photo');
            $h1_action = get_sub_field('h1_action', $other_page);
            $text_action = get_sub_field('text_action', $other_page); ?>
            <img src="<?php echo $akciaimage[0]; ?>" class="image_akcia" />
            <div class="akcia_text">
                <h1><?php echo $h1_action ?><h1>
                        <?php echo $text_action ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>