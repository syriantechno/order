<?php include('../../ultra.php'); ?>

<?php if (isset($_GET['id'])): ?>
    <?php if (!$payment = get_payment($_GET['id'])) {
        exit('لم يتم العثور على شكل المطلوب.');
    } ?>
<?php else: exit('معرف مطلوب'); endif; ?>

<?php
include_content_page('print', $payment->template, 'payment', array('payment' => $payment));
?>


<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/ultra.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">


<?php if ($payment->in_out == 0): ?>
    <title> سند قبض : <?php echo $payment->account_name; ?></title>
<?php else: ?>
    <title> سند صرف : <?php echo $payment->account_name; ?></title>
<?php endif; ?>


<?php $form_meta = get_form_meta($payment->id); ?>

<?php
if ($payment->in_out == '0') {
    $print['title'] = 'سند قبض';
} else {
    $print['title'] = 'سند صرف';
}
$print['date'] = $payment->date;
$print['barcode'] = 'TILP-' . $payment->id;
?>
<?php get_header_print($print); ?>


<div class="row">
    <div class="col-xs-6">

    </div> <!-- /.col-md-6 -->
    <div class="col-xs-6">

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->

<div class="h-20"></div>

<div class="row">
    <div class="col-xs-6">

        <div class="p-22 br-3">
            <div class="fs-14 bold"><?php echo til()->company->name; ?></div>
            <div class="fs-12"><?php echo til()->company->address; ?></div>
            <div class="fs-12"><?php echo til()->company->district; ?><?php echo til()->company->city; ?><?php echo til()->company->country; ?></div>
            <div class="fs-12"><?php echo til()->company->phone; ?><?php echo til()->company->email; ?></div>
        </div>

    </div> <!-- /.col-md-* -->
    <div class="col-xs-6">

        <div class="bg-gray p-10 br-3">
            <div class="fs-14 bold"><?php echo $payment->account_name; ?></div>
            <div class="fs-11"><?php echo $form_meta->address; ?></div>
            <div class="fs-11"><?php echo $form_meta->district; ?><?php echo $payment->account_city ? '/' : ''; ?><?php echo $payment->account_city; ?><?php echo $form_meta->country ? ' - ' : ''; ?><?php echo $form_meta->country; ?></div>
            <div class="fs-11"><?php echo get_set_show_phone($payment->account_gsm); ?><?php echo $payment->account_phone ? ' - ' : ''; ?><?php echo get_set_show_phone($payment->account_phone); ?></div>
            <div class="fs-11"><?php echo $payment->account_tax_home ? 'مكتب الضرائب: ' . $payment->account_tax_home : ''; ?><?php echo ($payment->account_tax_home and $payment->account_tax_no) ? ' - ' : ''; ?><?php echo $payment->account_tax_no ? 'رقم الضريبة: ' . $payment->account_tax_no : ''; ?></div>
            <?php if ($payment->account_email): ?>
                <div class="fs-11"><?php echo $payment->account_email; ?></div><?php endif; ?>
        </div>

    </div> <!-- /.ol-md-* -->
</div> <!-- /.row -->


<div class="h-20"></div>
<table class="table table-condensed table-bordered">
    <thead>
    <?php if ($payment->cheq_number != 0) : ?>
        <tr>
            <th>نوع الدفع</th>
            <th>اسم المصرف</th>
            <th>رقم الشيك</th>
            <th>تاريخ الاستحقاق</th>
            <th>سعر الصرف</th>
            <th>المبلغ ل.ل</th>
            <th>المبلغ $</th>
        </tr>
    <?php else: ?>
        <tr>
            <th>نوع الدفع</th>
            <th>سعر الصرف</th>
            <th>المبلغ ل.ل</th>
            <th>المبلغ $</th>
        </tr>
    <?php endif; ?>
    </thead>
    <tbody>
    <?php if ($payment->cheq_number != 0) : ?>
        <tr>
            <td>شيك</td>
            <td><?= $payment->bank_name; ?></td>
            <td><?= $payment->cheq_number; ?></td>
            <td><?= substr($payment->cheq_date, 0, 10); ?></td>
            <td class="text-right"><?php echo get_set_money($payment->exchange_price); ?></td>
            <td class="text-right"><?php echo get_set_money($payment->total, 'str'); ?></td>
            <td class="text-right">$<?php echo get_set_money($payment->exc_price); ?></td>
        </tr>
    <? else: ?>
        <tr>
            <td>نقداً</td>
            <td class="text-right"><?php echo get_set_money($payment->exchange_price); ?></td>
            <td class="text-right"><?php echo get_set_money($payment->total, 'str'); ?></td>
            <td class="text-right">$<?php echo get_set_money($payment->exc_price); ?></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<b>فقط:</b> <?php echo til_get_money_convert_string($payment->total); ?>

<div class="h-50"></div>


<div class="row">
    <div class="col-xs-6">

        <?php if ($payment->in_out == 1): ?>
            <div class="fs-10 text-muted"> المسلم -
                <small>الاسم والشهرة والامضاء</small>
            </div>
        <?php else: ?>
            <div class="fs-10 text-muted"> المستلم -
                <small>الاسم والشهرة والامضاء</small>
            </div>
        <?php endif; ?>
        <div class="h-10"></div>
        <div><?php echo get_user_info($payment->user_id, 'name'); ?><?php echo get_user_info($payment->user_id, 'surname'); ?></div>

        <div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>

    </div> <!-- /.col-xs-* -->
    <div class="col-xs-6">

        <div class="pull-right">
            <?php if ($payment->in_out == 0): ?>
                <div class="fs-10 text-muted"> المسلم -
                    <small>الاسم والشهرة والامضاء</small>
                </div>
            <?php else: ?>
                <div class="fs-10 text-muted"> المستلم -
                    <small>الاسم والشهرة والامضاء</small>
                </div>
            <?php endif; ?>

            <div class="h-10"></div>
            <div><?php echo $payment->account_name; ?></div>

            <div class="text-muted h-10" style="border-bottom: 1px dotted #ccc; width:150px"></div>
        </div> <!-- /.pull-right -->

    </div> <!-- /.col-xs-* -->
</div> <!-- /.row -->


<?php get_footer_print(); ?>







