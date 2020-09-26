<?php

if (isset($_POST['update_staff_salary'])) {
    if (isset($_POST['is_salary'])) {
        update_user_meta($user->id, 'is_salary', $_POST['is_salary']);
    } else {
        update_user_meta($user->id, 'is_salary', false);
    }
    update_user_meta($user->id, 'date_start_work', $_POST['date_start_work']);
    update_user_meta($user->id, 'date_end_work', $_POST['date_end_work']);
    update_user_meta($user->id, 'net_salary', get_set_decimal_db($_POST['net_salary']));
    echo get_alert('تم التحديث بنجاح.', 'success');


    if ($user_meta['date_start_work'] != $_POST['date_start_work']) {
        add_log(array('table_id' => 'users:' . $user->id, 'log_key' => 'update_user_meta', 'log_text' => 'تم تحديث تاريخ بدء العمل. ' . _b($_POST['date_start_work'])));
    }
    if ($user_meta['date_end_work'] != $_POST['date_end_work']) {
        add_log(array('table_id' => 'users:' . $user->id, 'log_key' => 'update_user_meta', 'log_text' => 'تم تحديث تاريخ انتهاء العمل. ' . _b($_POST['date_end_work'])));
    }
    if (get_set_decimal_db($user_meta['net_salary']) != get_set_decimal_db($_POST['net_salary'])) {
        add_log(array('table_id' => 'users:' . $user->id, 'log_key' => 'update_user_meta', 'log_text' => 'تحديث الراتب الشهري. ' . _b($_POST['net_salary'])));
    }
}


$user_meta = get_user_meta($user->id);

set_staff_salary($user->id);

$account = get_account($user->account_id);
?>


<div class="row">

    <div class="col-md-4">

        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="panel-title">معلومات الموظفين ومعلومات الرسوم</h4></div>
            <div class="panel-body">

                <form name="form_staff_salary" id="form_staff_salary" action="" method="POST">
                    <div class="form-group">
                        <label class="pointer"><input type="checkbox" name="is_salary" id="is_salary" value="1"
                                                      data-toggle="switch" text-on="نعم" text-off="لا"
                                                      class="til-hide-show"
                                                      data-e="_is_salary" <?php checked(@$user_meta['is_salary'], '1'); ?>>
                            <span>&nbsp;هل يتم حساب الراتب؟ </span> </label>
                    </div> <!-- /.form-group -->

                    <div class="row _is_salary">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_start_work">تاريخ بدء العمل</label>
                                <input type="text" name="date_start_work" id="date_start_work" class="form-control date"
                                       value="<?php echo @$user_meta['date_start_work']; ?>" readonly="">
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-* -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_end_work">تاريخ ترك العمل</label>
                                <input type="text" name="date_end_work" id="date_end_work" class="form-control date"
                                       value="<?php echo @$user_meta['date_end_work']; ?>" readonly="">
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-* -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="net_salary">صافي الراتب
                                    <small class="text-muted">(شهريا)</small>
                                </label>
                                <input type="tel" name="net_salary" id="net_salary" class="form-control money"
                                       value="<?php echo @$user_meta['net_salary']; ?>">
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-* -->
                    </div> <!-- /.row -->

                    <div class="text-right">
                        <input type="hidden" name="update_staff_salary">
                        <button class="btn btn-success btn-xs-block btn-insert"><i class="fa fa-save"></i> Kaydet
                        </button>
                    </div> <!-- /.text-right -->
                </form>

                <script>
                    $(document).ready(function () {

                        function til_hide_show(e = false, effect = true) {
                            var elem = false;
                            if (e == false) {
                                e = $('.til-hide-show');
                            }

                            if (effect == true) {
                                effect = 'blind';
                            }

                            if (e.attr('data-e')) {
                                elem = e.attr('data-e');
                            }

                            if (e.is(':checked')) {
                                $('.' + elem).show(effect);
                            } else {
                                $('.' + elem).hide(effect);
                            }
                        }

                        $('.til-hide-show').change(function () {
                            til_hide_show($(this));
                        });
                        til_hide_show(false, false);

                    });
                </script>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- /.col-md-6 -->
    <div class="col-md-6">

        <div class="panel panel-default _is_salary">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-6">
                        <h4>إجمالي الرصيد : <span
                                    class="<?php echo $account->balance < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($account->balance, true); ?></span>
                        </h4>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6 text-right">
                        <a href="<?php site_url('admin/payment/detail.php?out'); ?>&template=salary&account_id=<?php echo $user->account_id; ?>&user_type=user"
                           target="_blank" class="btn btn-warning"><i class="fa fa-paypal"></i> إجراء الدفع</a>
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                <div class="h-20"></div>

                <h4 class="content-title title-line">الراتب / الدفع والتحركات الدفع</h4>
                <?php
                $monthlys = false;
                if ($q_select = db()->query("SELECT * FROM " . dbname('forms') . " WHERE status='1' AND type IN ('salary', 'payment') AND account_id='" . $user->account_id . "' ORDER BY date ASC, val_1 ASC ")) {
                    if ($q_select->num_rows) {
                        $monthlys = _return_helper('plural_object', $q_select);
                    }
                }
                ?>

                <?php if ($monthlys): ?>
                    <table class="table table-bordered table-condensed table-hover dataTable">
                        <thead>
                        <tr>
                            <th width="20">المعرف</th>
                            <th>التاريخ</th>
                            <th class="hidden-xs">البيان</th>
                            <th>الاستحقاق</th>
                            <th>دفع</th>
                        </tr>
                        </thead>
                        <?php foreach ($monthlys as $monthly): ?>
                            <?php if ($monthly->type == 'payment'): ?>
                                <tr>
                                    <td><a href="<?php site_url('payment', $monthly->id); ?>"
                                           target="_blank">#<?php echo $monthly->id; ?></a></td>
                                    <td><?php echo til_get_date($monthly->date, 'datetime'); ?></td>
                                    <td class="hidden-xs">
                                        <?php if ($monthly->type == 'payment'): ?>
                                            Ödeme
                                        <?php else: ?>
                                            <?php echo til_get_date($monthly->date, 'F Y'); ?> dönem hakediş
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right"><?php if ($monthly->type == 'salary'): ?><?php echo get_set_money($monthly->total, 'icon'); ?><?php endif; ?></td>
                                    <td class="text-right"><?php if ($monthly->type == 'payment'): ?><?php echo get_set_money($monthly->total, 'icon'); ?><?php endif; ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td><a href="salary.php?id=<?php echo $monthly->id; ?>"
                                           target="_blank">#<?php echo $monthly->id; ?></a></td>
                                    <td><?php echo til_get_date($monthly->date, 'datetime'); ?></td>
                                    <td class="hidden-xs">
                                        <?php echo til_get_date($monthly->date, 'F Y'); ?> dönem
                                        hakediş, <?php echo get_set_money($monthly->val_decimal, 'icon'); ?> üzerinden
                                    </td>
                                    <td class="text-right"><?php if ($monthly->type == 'salary'): ?><?php echo get_set_money($monthly->total, 'icon'); ?><?php endif; ?></td>
                                    <td class="text-right"><?php if ($monthly->type == 'payment'): ?><?php echo get_set_money($monthly->total, 'icon'); ?><?php endif; ?></td>
                                </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        <tfoot>
                        <tr>
                            <th colspan="5"
                                class="text-right"><?php echo get_set_money($account->balance, 'icon'); ?></th>
                        </tr>
                        </tfoot>
                    </table> <!-- /.table -->
                <?php else: ?>
                    <?php echo get_alert('لم يتم العثور على تحركات الراتب.', 'warning', false); ?>
                <?php endif; ?>
            </div>  <!-- /.panel-body -->
        </div> <!-- /.panel -->


    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->






