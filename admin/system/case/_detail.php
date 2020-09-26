<?php
$case = get_case($_GET['status_id']);

if (isset($_POST['update'])) {

    $args['taxonomy'] = $_taxonomy;
    $args['name'] = $_POST['name'];
    $args['is_bank'] = $_POST['is_bank'];
    if ($args['is_bank'] == 1) {
        $args['bank_name'] = $_POST['bank_name'];
        $args['bank_admin_name'] = $_POST['bank_admin_name'];
        $args['bank_detail'] = json_encode(array('branch_code' => $_POST['branch_code'], 'account_no' => $_POST['account_no'], 'iban' => $_POST['iban']));
    }

    if (isset($_POST['default'])) {
        $args['is_default'] = 'default';
    } else {
        $args['is_default'] = '';
    }


    $_update = $args;
    $_where['id'] = $_GET['status_id'];
    update_case($_where, $_update);
}

print_alert();
?>

<?php if ($case = get_case($_GET['status_id'])): ?>

    <?php add_page_info('title', ' الصندوق والبنك - ' . $case->name); ?>
    <?php add_page_info('nav', array('name' => 'الصندوق والبنك', 'url' => get_site_url('admin/payment/case/index.php'))); ?>
    <?php add_page_info('nav', array('name' => $case->name)); ?>

    <div class="row">
        <div class="col-md-4">
            <form name="form_status" id="form_status" action="" method="POST" class="validate">
                <div class="form-group">
                    <label for="name">اسم الحالة</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $case->name; ?>">
                </div> <!-- /.form-group -->

                <input type="hidden" name="is_bank" value="<?php echo $case->is_bank; ?>">


                <?php if ($case->is_bank): ?>
                    <div class="bank_detail bg-info padding-5 margin-bottom-15">

                        <div class="form-group">
                            <label for="bank_name">اسم المصرف</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control" minlength="3"
                                   maxlength="32" value="<?php echo $case->bank_name; ?>">
                        </div> <!-- /.form-group -->

                        <div class="form-group">
                            <label for="bank_admin_name">اسم صاحب الحساب المصرفي</label>
                            <input type="text" name="bank_admin_name" id="bank_admin_name" class="form-control"
                                   minlength="3" maxlength="32" value="<?php echo $case->bank_admin_name; ?>">
                        </div> <!-- /.form-group -->

                        <div class="row space-5">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="branch_code">رمز الفرع</label>
                                    <input type="text" name="branch_code" id="branch_code" class="form-control"
                                           minlength="3" maxlength="32" value="<?php echo $case->bank_branch_code; ?>">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-3 -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="account_no">رقم الحساب</label>
                                    <input type="text" name="account_no" id="account_no" class="form-control"
                                           minlength="3" maxlength="32" value="<?php echo $case->bank_account_no; ?>">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-3 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="iban">Iban</label>
                                    <input type="text" name="iban" id="iban" class="form-control" minlength="3"
                                           maxlength="32" value="<?php echo $case->bank_iban; ?>">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-3 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.bank_detail -->
                <?php endif; ?>


                <div class="form-group">
                    <label class="veritical-center"><input type="checkbox" name="default" id="default" value="true"
                                                           class="toogle" <?php checked($case->is_default, 'default'); ?>
                                                           data-size="mini" data-on-text="Evet" data-off-text="Hayır">
                        &nbsp; يتم تحديد الافتراضي عند إنشاء النموذج الأول؟</label>
                </div> <!-- /.form-group -->


                <div class="text-right">
                    <input type="hidden" name="update">
                    <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
                    <button class="btn btn-default">حفظ</button>
                </div>

            </form>

            <hr/>


            <label>تم العثور على مبلغ من المال <b><?php echo get_set_money($case->total, true); ?></b> في هذا
                الصندوق.</label>
            <br/>
            <label>هل تريد حذف الصندوق? <a href="#" class="text-danger" data-toggle="modal"
                                           data-target="#form_status_delete"><i class="fa fa-trash"></i>نعم ، احذف
                    الصندوق</a></label>


            <!-- Modal -->
            <div class="modal fade" id="form_status_delete" tabindex="-1">
                <form name="status_delete" id="status_delete" action="" method="GET" class="modal-dialog modal-md"
                      role="document">
                    <div class="modal-content panel-danger">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><?php echo $case->name; ?> حذف الآمن</h4>
                        </div>
                        <div class="modal-body">


                            <div class="alert <?php echo ($case->count > 0) ? 'alert-danger' : 'alert-warning'; ?>"><?php echo $case->name; ?>
                                ينتمون إلى، <?php echo _b($case->count); ?> تم العثور على نموذج دفع الوحدة.
                            </div>
                            <?php $form_status_all = get_form_status_all(array('taxonomy' => $_taxonomy, 'in_out' => $case->in_out, 'not_in' => array('id' => $case->id))); ?>


                            <?php if ($case->count > 0): ?>
                                <?php if ($form_status_all): ?>
                                    <p>
                                        <small class="text-muted">يرجى تحديد حالة نموذج مختلف من القائمة أدناه.
                                            <b><?php echo $case->name; ?></b> form durumuna
                                            ait <?php echo _b($case->count); ?> وسوف يتغير شكل جهاز الكمبيوتر الشخصي مع
                                            وضع النموذج الذي تحدده أدناه.
                                        </small>
                                    </p>
                                    <select name="change_status_id" id="change_status_id" class="form-control select">
                                        <?php foreach ($form_status_all as $_status): ?>
                                            <option value="<?php echo $_status->id; ?>"><?php echo $_status->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="h-10"></div>
                                    <p class="text-danger"><b><?php echo $case->name; ?></b> لحذف حالة النموذج،
                                        و <?php echo _b($case->count); ?> هل تريد نقل النموذج إلى النموذج الجديد الذي
                                        حددته أعلاه؟</p>
                                <?php else: ?>
                                    <p>
                                        <small class="text-muted"><b><?php echo $case->name; ?></b> لا يمكنك حذف حالة
                                            النموذج. <br/> لأنه في شكل <?php echo _b($case->count); ?> لا يمكن العثور
                                            على حالات شكل آخر لنقل النموذج.
                                        </small>
                                    </p>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($form_status_all): ?>
                                    <p>
                                        <small class="text-muted"><b><?php echo $case->name; ?></b> هل تريد حذف حالة
                                            النموذج؟
                                        </small>
                                    </p>
                                <?php else: ?>
                                    <div class="alert alert-danger">يتم وضع حالة النموذج بشكل افتراضي. لا يمكنك حذف حالة
                                        النموذج.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>


                        </div> <!-- /.modal-body -->
                        <div class="modal-footer">
                            <input type="hidden" name="taxonomy" value="<?php echo $_taxonomy; ?>">
                            <input type="hidden" name="delete_status_id" id="delete_status_id"
                                   value="<?php echo $case->id; ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                            <?php if ($form_status_all): ?>
                                <button type="submit" class="btn btn-primary">نعم، أوافق</button><?php endif; ?>
                        </div> <!-- /.modal-footer -->
                    </div> <!-- /.modal-content -->
                </form>
            </div> <!-- /.modal -->


        </div> <!-- /.col-md-4 -->
    </div> <!-- /.row -->

<?php else: ?>
    <?php echo get_alert('لم يتم العثور على حالة النموذج.', 'warning', ''); ?>
<?php endif ?>


