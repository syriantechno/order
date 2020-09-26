<?php include('../../ultra.php'); ?>
<?php include_content_page('add', false, 'item'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'إضافة مادة');
add_page_info('nav', array('name' => 'إدارة المواد', 'url' => get_site_url('admin/item/')));
add_page_info('nav', array('name' => 'إضافة مادة'));
?>


<?php
if (isset($_POST['add'])) {

    if ($item_id = add_item($_POST)) {
        print_alert('add_item');

        if (isset($_POST['again'])) {
            unset($_POST);
            $_POST['again'] = true;
        } else {
            header("Location: detail.php?id=" . $item_id);
        }
    } else {
        if (is_alert()) {
            print_alert();

        }
    }
}


if (empty(@$_POST['code'])) {
    $_POST['code'] = get_item_code_generator();
}
?>


    <form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label for="code">رمز المادة <sup><i class="fa fa-barcode"></i> كود المادة</sup> </label>
                    <input type="text" name="code" id="code" value="<?php echo @$_POST['code']; ?>" class="form-control"
                           minlength="3" maxlength="32">
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <label for="name">اسم المادة <sup class="text-muted">اسم المنتج-خدمة-الأسهم</sup></label>
                    <input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>"
                           class="form-control required focus" minlength="3" maxlength="50">
                </div> <!-- /.form-group -->

                <div class="row">
                    <div class="col-md-2">

                    </div> <!-- /.col-md-2 -->
                    <div class="col-xs-6 col-md-5">
                        <div class="form-group">
                            <label for="p_purc_out_vat">سعر التكلفة <sup class="text-muted"><u>بإستثناء
                                        الضريبة</u></sup></label>
                            <input type="text" pattern="[0-9]+([\.,][0-9]+)?" name="p_purc_out_vat" id="p_purc_out_vat"
                                   value="" class="form-control money" maxlength="15" disabled>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-5 -->
                    <div class="col-xs-6 col-md-5">
                        <div class="form-group">
                            <label for="p_sale_out_vat">سعر البيع <sup class="text-muted"><u>بإستثناء الضريبة</u></sup></label>
                            <input type="text" pattern="[0-9]+([\.,][0-9]+)?" name="p_sale_out_vat" id="p_sale_out_vat"
                                   value="" class="form-control money" maxlength="11" disabled>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-5 -->
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-xs-6 col-md-2">
                        <div class="form-group">
                            <label for="vat">VAT<sup class="text-muted">(%)</sup></label>
                            <input type="tel" pattern="[0-9]+([\.,][0-9]+)?" name="vat" id="vat"
                                   value="<?php echo @$_POST['vat']; ?>" class="form-control digits" maxlength="2"
                                   onkeyup="calc_vat();" onfocusout="calc_vat();">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col -->
                    <div class="clearfix visible-xs"></div>
                    <div class="col-xs-6 col-md-5">
                        <div class="form-group">
                            <label for="p_purc">سعر التكلفة</label>
                            <input type="number" pattern="[0-9]+([\.,][0-9]+)?" name="p_purc" id="p_purc"
                                   value="<?php echo @$_POST['p_purc']; ?>" class="form-control money"
                                   onkeyup="calc_vat();" onfocusout="calc_vat();">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col -->
                    <div class="col-xs-6 col-md-5">
                        <div class="form-group">
                            <label for="p_sale">سعر البيع</label>
                            <input type="number" pattern="[0-9]+([\.,][0-9]+)?" name="p_sale" id="p_sale"
                                   value="<?php echo @$_POST['p_sale']; ?>" class="form-control money"
                                   onkeyup="calc_vat();" onfocusout="calc_vat();">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->


                <em class="text-muted">* بمجرد الانتهاء من إنشاء بطاقة المادة، يمكنك إضافة تفاصيل المنتج والصور.</em>
                <div class="h-20"></div>
                <div class="form-group">
                    <label class="veritical-center"><input type="checkbox" name="again" id="again" value="1"
                                                           <?php if (isset($_POST['again']) or isset($_GET['again'])): ?>checked<?php endif; ?>
                                                           data-toggle="switch" switch-size="sm" on-text="نعم"
                                                           off-text="لا"> &nbsp; هل ستقوم باضافة مادة جديدة بعد التسجيل</label>
                </div> <!-- /.form-group -->

                <div class="text-right">
                    <input type="hidden" name="add">
                    <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">

                    <button class="btn btn-success btn-xs-block btn-insert"><i class="fa fa-plus-square"></i> حفظ
                    </button>
                </div>

            </div> <!-- /.col-md-6 -->
            <div class="col-md-6">


            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->


    </form>


    <script>


        /**
         * cal_vat()
         * يضيف المنتج ويحسب تكلفة المنتج بالتفصيل وأسعار البيع دون ضريبة القيمة المضافة
         */
        function calc_vat() {
            var p_purc = get_set_decimal($('#p_purc').val());
            var p_sale = get_set_decimal($('#p_sale').val());
            var p_vat = math_vat_rate($('#vat').val());

            // degeler numeric mi? degil mi?
            if (!$.isNumeric(p_purc)) {
                p_purc = 0.00;
            }
            if (!$.isNumeric(p_sale)) {
                p_sale = 0.00;
            }
            if (!$.isNumeric(p_vat)) {
                p_vat = 0;
            }

            var p_purc_out_vat = p_purc / p_vat;
            var p_sale_out_vat = p_sale / p_vat;
            $('#p_purc_out_vat').val(p_purc_out_vat);
            $('#p_sale_out_vat').val(p_sale_out_vat);
        }
    </script>


<?php get_footer(); ?>