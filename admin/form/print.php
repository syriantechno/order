<?php require_once('../../ultra.php'); ?>
<?php
if (isset($_GET['id'])) {
    if (!$form = get_form($_GET['id'])) {

    }
}
?>
<?php include_content_page('print', @$form->template, 'form', array('form' => @$form)); ?>

<?php $form_meta = get_form_meta($form->id); ?>

<?php if ($form->in_out == '0'): ?>
    <title>شكل الادخال - <?php echo $form->account_name; ?> | المستقبل </title>
<?php else: ?>
    <title>شكل الإخراج - <?php echo $form->account_name; ?> | المستقبل </title>
<?php endif; ?>


<?php
if ($form->in_out == '0') {
    $print['title'] = 'شكل الادخال';
} else {
    $print['title'] = 'شكل الإخراج';
}
$print['date'] = $form->date;
$print['barcode'] = 'TILF-' . $form->id;
?>
<?php get_header_print($print); ?>


    <div class="clearfix"></div>
    <div class="h-20"></div>

    <div class="row">
        <div class="col-xs-6">

            <div class="p-10 br-3">
                <div class="fs-14 bold"><?php echo til()->company->name; ?></div>
                <div class="fs-11"><?php echo til()->company->address; ?></div>
                <div class="fs-11"><?php echo til()->company->district; ?><?php echo til()->company->city ? '/' : ''; ?><?php echo til()->company->city; ?><?php echo til()->company->country ? ' - ' : ''; ?><?php echo til()->company->country; ?></div>
                <div class="fs-11"><?php echo get_set_show_phone(til()->company->phone); ?></div>
                <div class="fs-11"><?php echo til()->company->email; ?></div>
            </div>

        </div> <!-- /.col-md-* -->
        <div class="col-xs-6">

            <div class="bg-gray p-10 br-3">
                <div class="fs-14 bold"><?php echo $form->account_name; ?></div>
                <div class="fs-11"><?php echo $form_meta->address; ?></div>
                <div class="fs-11"><?php echo $form_meta->district; ?><?php echo $form->account_city ? '/' : ''; ?><?php echo $form->account_city; ?><?php echo $form_meta->country ? ' - ' : ''; ?><?php echo $form_meta->country; ?></div>
                <div class="fs-11"><?php echo get_set_show_phone($form->account_gsm); ?><?php echo $form->account_phone ? ' - ' : ''; ?><?php echo get_set_show_phone($form->account_phone); ?></div>
                <div class="fs-11"><?php echo $form->account_tax_home ? ' المكتب الضريبي: ' . $form->account_tax_home : ''; ?><?php echo ($form->account_tax_home and $form->account_tax_no) ? ' - ' : ''; ?><?php echo $form->account_tax_no ? ' الرقم الضريبي: ' . $form->account_tax_no : ''; ?></div>
                <?php if ($form->account_email): ?>
                    <div class="fs-11"><?php echo $form->account_email; ?></div><?php endif; ?>
            </div>

        </div> <!-- /.col-md-* -->
    </div> <!-- /.row -->


<?php echo $form_meta->note; ?>

    <div class="clearfix"></div>
    <div class="h-20"></div>

    <table class="table table-hover table-bordered table-condensed table-striped">
        <thead>
        <tr>
            <th>كود المادة</th>
            <th>اسم المادة</th>
            <th>عدد</th>
            <th>السعر الافرادي</th>
            <th>المجموع</th>
            <th>VAT</th>
            <th>مبلغ ضريبة القيمة المضافة</th>
            <th>الكمية</th>
        </tr>
        </thead>
        <?php if ($form_items = get_form_items($form->id)): ?>
            <tbody>
            <?php
            $_total_quantity = 0;

            ?>
            <?php foreach ($form_items->list as $item): ?>
                <?php $_total_quantity = $_total_quantity + $item->quantity; ?>
                <tr>
                    <td>
                        <?php if (isset($_GET['showBarcode'])): ?>
                            <img src="<?php echo get_barcode_url($item->item_code, array('position' => 'left')); ?>"/>
                            <br/>
                        <?php endif; ?>
                        <?php echo $item->item_code; ?>
                    </td>
                    <td><?php echo $item->item_name; ?></td>
                    <td class="text-center"><?php echo $item->quantity; ?></td>
                    <td class="text-right"><?php echo get_set_money($item->price, 'str'); ?></td>
                    <td class="text-right"><?php echo get_set_money(($item->price * $item->quantity), 'str'); ?></td>
                    <td class="text-center">% <?php echo $item->vat; ?></td>
                    <td class="text-right"><?php echo get_set_money($item->vat_total, 'str'); ?></td>
                    <td class="text-right"><?php echo get_set_money($item->total, 'str'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td class="text-center"><?php echo $form->item_quantity; ?></td>
                <td colspan="3"></td>
                <td></td>
                <td class="text-right"><?php echo get_set_money($form->total, 'str'); ?></td>
            </tr>
            </tfoot>
        <?php endif; ?>
    </table>


<?php get_footer_print(); ?>