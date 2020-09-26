<?php include('../../ultra.php'); ?>

<?php if (isset($_GET['id'])): ?>
    <?php if (!$item = get_item($_GET['id'])) {
        exit('لم يتم العثور على منتج.');
    } ?>
<?php else: exit('معرف المنتج مطلوب'); endif; ?>

<?php
if (!$print = get_option('item_print_barcode_price')) {
    @$print->width = 90;
    @$print->height = 90;
}
?>

<?php include_content_page('print', 'barcode', 'item', array('item' => @$item)); ?>

    <title>طباعة الباركود | <?php echo $item->name; ?></title>
<?php
$args['logo'] = false;
$args['footer'] = false;
?>
<?php get_header_print($args); ?>

    <style>
        .print-page {
            height: <?php echo $print->height; ?>mm !important;
            width: <?php echo $print->width; ?>mm !important;
        }
    </style>


    <div class="row space-none">
        <div class="col-xs-12">

            <div class="fs-12"><span class="bold"><?php echo get_set_money($item->p_sale); ?></span>
                <small>$</small>
            </div>
            <div class="h-5"></div>
            <div class="fs-12"><?php echo $item->name; ?></div>
            <div class="h-5"></div>
            <img src="<?php barcode_url($item->code, array('position' => 'left')); ?>"/>
            <br/>
            <span class="ff-2"><?php echo $item->code; ?></span>


        </div> <!-- /.col -->
    </div> <!-- /.row -->
    <div class="clearfix"></div>


<?php get_footer_print($args); ?>