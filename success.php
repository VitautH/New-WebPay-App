<?php
/*
Template Name: success
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
<? //print_r($_GET ['wsb_tid']); ?>
                 <?   $postdata = '*API=&API_XML_REQUEST='.urlencode('
                    <?xml version="1.0" encoding="ISO-8859-1" ?>
                    <wsb_api_request>
                        <command>get_transaction</command>
                        <authorization>
                            <username>prav</username>
                            <password>'.md5("mn:z'GPo?.]").'</password>
                        </authorization>
                        <fields>
                            <transaction_id>'.$_GET ['wsb_tid'].'
                            </transaction_id>
                        </fields>
                    </wsb_api_request>
                    ');
                    $curl = curl_init (IO::getConfig('url_sandbox')); curl_setopt ($curl, CURLOPT_HEADER, 0); curl_setopt ($curl, CURLOPT_POST, 1);
                    curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata); curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1); curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    $response = curl_exec ($curl); curl_close ($curl);
                    $xml = simplexml_load_string($response);

                  $order_id= $xml->fields->order_id;
                    $order_num= $xml->fields->order_num;
                     $site_order_id= $xml->fields->order_num;
                    $transaction_id= $xml->fields->transaction_id;
                  $status= $xml->fields->payment_type;
                     $price= $xml->fields->amount;



if ($status==1 or $status==4){

  Transaction::oplata_save_Db ($order_num,$order_id, $transaction_id,   $status);


    echo "<a href='http://www.prav.by/".IO::getConfig('tcpdflib_path')."?&file=".$order_id."' target='_blank'>Скачать Договор</a>";
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