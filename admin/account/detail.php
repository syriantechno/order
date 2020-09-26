<?php include('../../ultra.php'); ?>
<?php


if (10 < 9) {
    $q_forms = db()->query("SELECT * FROM " . dbname('forms') . " ");
    while ($list = $q_forms->fetch_assoc()) {
        unset($list['id']);
        db()->query("INSERT INTO " . dbname('forms') . " " . sql_insert_string($list) . " ");
        echo db()->error;

    }
    exit;
}

if (!$account = get_account($_GET['id'])) {
    add_page_info('title', 'بطاقة المستفيد');
    add_page_info('nav', array('name' => 'المستفيد', 'url' => get_site_url('admin/account/')));
    add_page_info('nav', array('name' => 'قائمة', 'url' => get_site_url('admin/account/list.php')));
    add_page_info('nav', array('name' => 'بطاقة المستفيد'));
    get_header();
    print_alert();
    get_footer();
    return false;
}
include_content_page('detail', $account->type, 'account');
?>


<?php get_header(); ?>
<?php

if (isset($_POST['update'])) {
    if (update_account($account->id, $_POST)) {
        $account = get_account($account->id, false);
    }
}


if (isset($_GET['status'])) {
    if ($_GET['status'] == '0' OR $_GET['status'] == '1') {
        if (update_account($account->id, array('update' => array('status' => $_GET['status']), 'add_alert' => false))) {
            $account = get_account($account->id);
        }
    }
}


calc_account($account->id);

$account = get_account($_GET['id'], false);


add_page_info('title', $account->name);
add_page_info('nav', array('name' => 'المستفيد', 'url' => get_site_url('admin/account/')));
add_page_info('nav', array('name' => 'قائمة', 'url' => get_site_url('admin/account/list.php')));
add_page_info('nav', array('name' => $account->name));
?>


<?php if ($account->status == '0'): ?>
    <?php echo get_alert('<i class="fa fa-trash-o"></i> <b>الحذر!</b> بطاقة الحساب غير نشطة.', 'warning', false); ?>
<?php else: ?>
    <?php create_modal(array('id' => 'status_account',
        'title' => 'بطاقة المستفيد <u>معطلة</u>',
        'content' => _b($account->name) . ' هل تريد بالتاكيد تعطيل بيانات المستفيد؟ <br /> <small>اذا قمت بالغاء بطاقة المستفيد فلن تستطيع البحث عنه او ايجاده ضمن النظام <br /> قد تفقد جميع البيانات المتعلقة به </small>',
        'btn' => '<a href="?id=' . $account->id . '&status=0" class="btn btn-danger">نعم, موافق</a>')); ?>
<?php endif; ?>


<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item"><a class="nav-link active" href="#home" id="home-tab" role="tab" data-toggle="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-id-card-o"></i><span
                    class="hidden-xs"> بطاقة المستفيد</span></a></li>
    <li class="nav-item"><a href="#forms" role="tab" id="forms-tab" data-toggle="tab" aria-controls="forms"
                            aria-selected="false"><i class="fa fa-list"></i><span
                    class="hidden-xs">كشف المستفيد</span></a></li>
    <li class="nav-item"><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs"
                            aria-selected="false"><i class="fa fa-database"></i><span
                    class="hidden-xs"> سجل العمليات</span></a>
    </li>

    <li class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle" id="myTabDrop1"
                                                      data-toggle="dropdown" aria-controls="myTabDrop1-contents"
                                                      aria-expanded="false"><i class="fa fa-cogs"></i><span
                    class="hidden-xs"> خيارات</span><span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
            <li><a href="<?php site_url('admin/user/task/add.php?attachment&account_id=' . $account->id); ?>"
                   target="_blank"><i class="fa fa-tasks fa-fw"></i> إلحاق المهمة</a></li>
            <li><a href="<?php site_url('admin/user/message/add.php?attachment&account_id=' . $account->id); ?>"
                   target="_blank"><i class="fa fa-envelope-o fa-fw"></i> إضافة مرفق الرسالة</a></li>
            <li class="divider"></li>
            <?php if ($account->status == '1'): ?>
                <li><a href="#" target="_blank" data-toggle="modal" data-target="#status_account"><i
                                class="fa fa-trash-o fa-fw text-danger"></i> حذف</a></li>
            <?php else: ?>
                <li><a href="?id=<?php echo $account->id; ?>&status=1"><i class="fa fa-undo fa-fw text-success"></i>
                        نشط</a></li>
            <?php endif; ?>
        </ul>
    </li>
    <li class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle" id="myTabDrop1"
                                                      data-toggle="dropdown" aria-controls="myTabDrop1-contents"
                                                      aria-expanded="false"><i class="fa fa-print"></i><span
                    class="hidden-xs"> طباعة</span><span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
            <li><a href="print-statement.php?id=<?php echo $account->id; ?>&print" target="_blank"><i
                            class="fa fa-file-text-o fa-fw"></i> طباعة كشف المستفيد</a></li>
            <li><a href="print-statement.php?id=<?php echo $account->id; ?>" target="_blank"><i
                            class="fa fa-file-text-o fa-fw"></i> معاينة كشف المستفيد</a></li>
            <li class="divider"></li>
            <li><a href="print-barcode.php?id=<?php echo $account->id; ?>&print" target="_blank"><i
                            class="fa fa-barcode fa-fw"></i> طباعة الباركود</a></li>
            <li><a href="print-address.php?id=<?php echo $account->id; ?>&print" target="_blank"><i
                            class="fa fa-address-book-o fa-fw"></i> طباعة بطاقة العنوان</a></li>
            <li><a href="print-cargo.php?id=<?php echo $account->id; ?>&print" target="_blank"><i
                            class="fa fa-address-book-o fa-fw"></i> طباعة الباركود البضائع</a></li>
        </ul>
    </li>
</ul>


<div class="tab-content">

    <!-- tab:home -->
    <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">
        <div class="row">
            <div class="col-md-8">
                <?php print_alert('update_account'); ?>

                <form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

                    <div class="row">
                        <div class="col-md-6">


                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="name">كود المستفيد</label>
                                        <input type="text" name="name" id="name"
                                               value="<?php echo $account->code; ?>" class="form-control required"
                                               maxlength="32" readonly>
                                    </div> <!-- /.form-group -->
                                </div>

                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="done">تم الكشف</label>
                                        <select type="text" name="done" id="done"
                                                value="<?php echo $account->done; ?>" class="form-control select"
                                                maxlength="100">
                                            <option><?= $account->done ?></option>
                                            <option value="نعم">نعم</option>
                                            <option value="لا">لا</option>
                                        </select>
                                    </div> <!-- /.form-group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="name">اسم المستفيد <sup class="text-muted">الاسم الشخصي،
                                                اللقب </sup></label>
                                        <input type="text" name="name" id="name"
                                               value="<?php echo $account->name; ?>" class="form-control required"
                                               maxlength="32">
                                    </div> <!-- /.form-group -->
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="fathername">اسم الاب</label>
                                        <input type="text" name="fathername" id="fathername"
                                               value="<?php echo $account->fathername; ?>" class="form-control"
                                               maxlength="100">
                                    </div> <!-- /.form-group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="DateofBirth">تاريخ الميلاد</label>

                                        <input type="text" name="DateofBirth" id="DateofBirth"
                                               value="<?php echo @substr($account->DateofBirth, 0, 16); ?>"
                                               class="form-control input-sm datetime" maxlength="32">
                                    </div> <!-- /.form-group -->
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="job">المهنة</label>
                                        <input type="text" name="job" id="job" value="<?php echo $account->job; ?>"
                                               class="form-control" maxlength="100">
                                    </div> <!-- /.form-group -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="countrynumber">الرقم الوطني</label>
                                        <input type="tel" name="countrynumber" id="countrynumber"
                                               value="<?php echo $account->countrynumber; ?>" class="form-control"
                                               minlength="2" maxlength="25">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">
                                        <label for="Retardationnum">رقم بطاقة الاعاقة</label>
                                        <input type="text" name="Retardationnum" id="Retardationnum"
                                               value="<?php echo $account->Retardationnum; ?>" class="form-control "
                                               maxlength="100">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                            </div> <!-- /.row -->

                        </div> <!-- /.col-md-4 -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="address">عنوان</label>
                                <input type="text" name="address" id="address"
                                       value="<?php echo $account->address; ?>" class="form-control"
                                       maxlength="250">
                            </div> <!-- /.form-group -->

                            <div class="row">
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="district">الحالة الاجتماعية</label>
                                        <select name="district" id="district" value="<?php echo @$_POST['district']; ?>"
                                                class="form-control select" maxlength="25">
                                            <option><?php echo $account->district; ?></option>
                                            <option value="اعزب">اعزب</option>
                                            <option value="عزباء">عزباء</option>
                                            <option value="متزوج">متزوج</option>
                                            <option value="متزوجة">متزوجة</option>
                                            <option value="ارمل">ارمل</option>
                                            <option value="ارملة">ارملة</option>
                                            <option value="مطلق">مطلق</option>
                                            <option value="مطلقة">مطلقة</option>

                                        </select>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="mo3el">المعيل</label>
                                        <input type="text" name="mo3el" id="mo3el"
                                               value="<?php echo $account->mo3el; ?>" class="form-control"
                                               maxlength="20">
                                    </div> <!-- /.form-group -->
                                </div>

                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group country_selected">
                                        <label for="country">البلد</label>
                                        <?php echo list_selectbox(get_country_array(), array('name' => 'country', 'selected' => $account->country, 'class' => 'form-control select select-account')); ?>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col-md-4 -->
                            </div> <!-- /.row -->

                            <div class="row">
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="gsm">الموبايل</label>
                                        <input type="tel" name="gsm" id="gsm" value="<?php echo $account->gsm; ?>"
                                               class="form-control" maxlength="25">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="Retardationtype">نوع الاعاقة</label>
                                        <input type="text" name="Retardationtype" id="Retardationtype"
                                               value="<?php echo $account->Retardationtype; ?>" class="form-control"
                                               maxlength="25">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="sex"> الجنس </label>
                                        <select name="sex" id="sex" value="<?php echo @$_POST['sex']; ?>"
                                                class="form-control select" maxlength="25">
                                            <option><?php echo $account->sex; ?></option>
                                            <option value="ذكر">ذكر</option>
                                            <option value="انثى">انثى</option>
                                        </select>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                            </div> <!-- /.row -->
                            <div class="row">
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="needsomeone">المرافق</label>
                                        <select type="text" name="needsomeone" id="needsomeone"
                                                value="<?php echo @$_POST['needsomeone']; ?>"
                                                class="form-control select" maxlength="25">
                                            <option><?php echo $account->needsomeone; ?></option>
                                            <option value="لايحتاج مرافق">لايحتاج مرافق</option>
                                            <option value="يحتاج مرافق">يحتاج مرافق</option>
                                        </select>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <label for="famelynum">عدد افراد الاسرة</label>
                                        <input type="tel" name="famelynum" id="famelynum"
                                               value="<?php echo $account->famelynum; ?>" class="form-control"
                                               maxlength="25">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group country_selected">
                                        <label for="living">الحالة</label>
                                        <select type="text" name="living" id="living"
                                                value="<?php echo @$_POST['living']; ?>"
                                                class="form-control select" maxlength="255">
                                            <option><?= $account->living ?></option>
                                            <option value="سيء جدا">سيء جدا</option>
                                            <option value="سيء">سيء</option>
                                            <option value="وسط">وسط</option>
                                            <option value="جيد">جيد</option>
                                            <option value="جيد جدا">جيد جدا</option>
                                            <option value="ممتاز">ممتاز</option>


                                        </select>
                                    </div>
                                </div> <!-- /.col -->

                            </div> <!-- /.row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note"> الملاحظات</label>
                                        <input type="text" name="note" id="note"
                                               value="<?php echo $account->note; ?>" class="form-control"
                                               maxlength="255">
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col -->
                            </div> <!-- /.row -->
                        </div> <!-- /.col-md-4 -->

                    </div>
                    <!-- /.row -->


                    <div class="text-right">
                        <input type="hidden" name="update">
                        <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
                        <button class="btn btn-success btn-insert btn-xs-block"><i class="fa fa-floppy-o"></i> حفظ
                        </button>
                    </div>

                </form>
            </div>

            <?php

            if ($account->type !== 'Retardation') :
                ?>
                <div class="shide-Retardation">
                    <div class="col-md-4">

                        <div class="h-20 visible-xs"></div>
                        <div class="row space-none">
                            <div class="col-md-5">

                                <div class="">
                                    <span class="ff-2 fs-17 bold <?php echo $account->balance < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($account->balance); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                    <br/>
                                    <small class="text-muted">الرصيد</small>
                                </div>

                            </div> <!-- /.col-md-4 -->
                            <div class="col-md-7">
                                <?php
                                $accountTotal = array();
                                $q = db()->query("SELECT sum(total) as total FROM " . dbname("forms") . " WHERE status='1' AND type='form' AND in_out='0' AND account_id='" . $account->id . "'");
                                $accountTotal['form_in'] = $q->fetch_object()->total;
                                $q = db()->query("SELECT sum(total) as total FROM " . dbname("forms") . " WHERE status='1' AND type='form' AND in_out='1' AND account_id='" . $account->id . "'");
                                $accountTotal['form_out'] = $q->fetch_object()->total;

                                $q = db()->query("SELECT sum(total) as total FROM " . dbname("forms") . " WHERE status='1' AND type='payment' AND in_out='0' AND account_id='" . $account->id . "'");
                                $accountTotal['payment_in'] = $q->fetch_object()->total;
                                $q = db()->query("SELECT sum(total) as total FROM " . dbname("forms") . " WHERE status='1' AND type='payment' AND in_out='1' AND account_id='" . $account->id . "'");
                                $accountTotal['payment_out'] = $q->fetch_object()->total;

                                ?>

                                <?php
                                $chart = array();
                                $chart['type'] = 'line';
                                $chart['data']['datasets'][0]['label'] = 'الحركات';
                                $chart['data']['datasets'][0]['fill'] = true;
                                $chart['data']['datasets'][0]['lineTension'] = '0';
                                $chart['data']['datasets'][0]['borderWidth'] = 1;
                                $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
                                $chart['data']['datasets'][0]['pointRadius'] = 1;
                                $chart['data']['datasets'][0]['backgroundColor'] = 'rgba(253, 196, 48, 0.2)';
                                $chart['data']['datasets'][0]['borderColor'] = 'rgba(253, 196, 48, 1)';


                                $_start_date = date('Y-m-d', strtotime('-2 week', strtotime(date('Y-m-d'))));
                                $_end_date = date('Y-m-d');
                                while (strtotime($_start_date) <= strtotime($_end_date)) {
                                    $chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

                                    $total = 0;
                                    $chart_balance = $account->balance;
                                    $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='0' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                                    if (($total = $q_forms->fetch_object()->total) > 0) {
                                        // $chartt['data']['datasets'][0]['data'][] = $total;
                                    } else {
                                        // $chartt['data']['datasets'][0]['data'][] = '0.00';
                                    }
                                    $chart_balance = $chart_balance + $total;

                                    $total = 0;
                                    $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='1' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                                    if (($total = $q_forms->fetch_object()->total) > 0) {
                                        // $chartt['data']['datasets'][1]['data'][] = $total;
                                    } else {
                                        // $chartt['data']['datasets'][1]['data'][] = '0.00';
                                    }
                                    $chart_balance = $chart_balance - $total;
                                    $chart['data']['datasets'][0]['data'][] = $chart_balance;


                                }

                                $chart['options']['legend']['display'] = false;
                                $chart['options']['scales']['yAxes'][0]['display'] = false;
                                $chart['options']['scales']['xAxes'][0]['display'] = false;
                                $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
                                $chart['options']['maintainAspectRatio'] = false;
                                $chart['options']['tooltips']['enabled'] = true;
                                $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
                                $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";


                                $args['height'] = '40';
                                $args['chart'] = $chart;
                                ?>

                                <?php chartjs($args); ?>
                            </div> <!-- /.col-md-8 -->
                        </div> <!-- /.row -->

                        <div class="h-20"></div>

                        <div class="h-20 visible-xs"></div>
                        <div class="row space-none">
                            <div class="col-md-4">

                                <div class="">
                                    <span class="ff-2 fs-15 bold <?php echo $account->profit < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($account->profit); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                    <br/>
                                    <small class="text-muted">الربح / الخسارة</small>
                                </div>

                            </div> <!-- /.col-md-4 -->
                            <div class="col-md-8">
                                <?php
                                $chart = array();
                                $chart['type'] = 'line';
                                $chart['data']['datasets'][0]['label'] = 'الحركات';
                                $chart['data']['datasets'][0]['fill'] = true;
                                $chart['data']['datasets'][0]['lineTension'] = '0';
                                $chart['data']['datasets'][0]['borderWidth'] = 1;
                                $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
                                $chart['data']['datasets'][0]['pointRadius'] = 1;
                                $chart['data']['datasets'][0]['backgroundColor'] = 'rgba(75, 192, 192, 0.2)';
                                $chart['data']['datasets'][0]['borderColor'] = 'rgba(75, 192, 192, 1)';


                                $_start_date = date('Y-m-d', strtotime('-2 week', strtotime(date('Y-m-d'))));
                                $_end_date = date('Y-m-d');
                                while (strtotime($_start_date) <= strtotime($_end_date)) {
                                    $chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

                                    $total = 0;
                                    $chart_balance = $account->profit;
                                    $q_forms = db()->query("SELECT sum(profit) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='0' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                                    if (($total = $q_forms->fetch_object()->total) > 0) {
                                        // $chartt['data']['datasets'][0]['data'][] = $total;
                                    } else {
                                        // $chartt['data']['datasets'][0]['data'][] = '0.00';
                                    }
                                    $chart_balance = $chart_balance + $total;

                                    $total = 0;
                                    $q_forms = db()->query("SELECT sum(profit) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='1' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                                    if (($total = $q_forms->fetch_object()->total) > 0) {
                                        // $chartt['data']['datasets'][1]['data'][] = $total;
                                    } else {
                                        // $chartt['data']['datasets'][1]['data'][] = '0.00';
                                    }
                                    $chart_balance = $chart_balance - $total;
                                    $chart['data']['datasets'][0]['data'][] = $chart_balance;


                                }

                                $chart['options']['legend']['display'] = false;
                                $chart['options']['scales']['yAxes'][0]['display'] = false;
                                $chart['options']['scales']['xAxes'][0]['display'] = false;
                                $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
                                $chart['options']['maintainAspectRatio'] = false;
                                $chart['options']['tooltips']['enabled'] = true;
                                $chart['options']['tooltips']['yLabel'] = 'krall';
                                $chart['options']['tooltips']['mode'] = 'nearest';
                                $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
                                $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";


                                $args['height'] = '40';
                                $args['chart'] = $chart;
                                ?>

                                <?php chartjs($args); ?>
                            </div> <!-- /.col-md-8 -->
                        </div> <!-- /.row -->

                        <div class="h-20"></div>
                        <hr/>
                        <small class="text-muted"><i class="fa fa-calendar-o"></i> لغاية الأن</small>
                        <div class="h-10"></div>

                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <div class="">
                                    <small class="text-muted">إجمالي دخول المنتج</small>
                                    <br/>
                                    <span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['form_in']); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                </div>
                            </div> <!-- /.col -->
                            <div class="col-xs-6 col-md-6">
                                <div class="">
                                    <small class="text-muted">إجمالي الناتج</small>
                                    <br/>
                                    <span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['form_out']); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                </div>
                            </div> <!-- /.col -->
                        </div> <!-- /.row -->

                        <div class="h-20"></div>

                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <div class="">
                                    <small class="text-muted">إجمالي دخول الدفعة</small>
                                    <br/>
                                    <span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['payment_in']); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                </div>
                            </div> <!-- /.col -->
                            <div class="col-xs-6 col-md-6">
                                <div class="">
                                    <small class="text-muted">إجمالي العائد</small>
                                    <br/>
                                    <span class="ff-2 fs-15 bold"><?php echo get_set_money($accountTotal['payment_out']); ?></span>
                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                </div>
                            </div> <!-- /.col -->
                        </div> <!-- /.row -->


                    </div> <!-- /.col-md-4 -->

                </div> <!-- /.row -->

            <?php endif; ?>


            <div class="h-20"></div>

            <div class="row">
                <div class="col-md-8">
                    <?php
                    $chart = array();
                    $chart['type'] = 'bar';
                    $chart['data']['datasets'][0]['label'] = 'ادخال / اخراج';
                    $chart['data']['datasets'][0]['fill'] = true;
                    $chart['data']['datasets'][0]['lineTension'] = 0.3;
                    $chart['data']['datasets'][0]['borderWidth'] = 1;
                    $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
                    $chart['data']['datasets'][0]['pointRadius'] = 1;

                    $chart['data']['datasets'][1]['label'] = 'المدفوعات';
                    $chart['data']['datasets'][1]['type'] = 'line';
                    $chart['data']['datasets'][1]['fill'] = true;
                    $chart['data']['datasets'][1]['lineTension'] = 0.3;
                    $chart['data']['datasets'][1]['borderWidth'] = 1;
                    $chart['data']['datasets'][1]['pointBorderWidth'] = 1;
                    $chart['data']['datasets'][1]['pointRadius'] = 1;

                    $chart['data']['datasets'][2]['label'] = 'الربح والخسارة';
                    $chart['data']['datasets'][2]['type'] = 'line';
                    $chart['data']['datasets'][2]['fill'] = true;
                    $chart['data']['datasets'][2]['lineTension'] = 0.3;
                    $chart['data']['datasets'][2]['borderWidth'] = 1;
                    $chart['data']['datasets'][2]['pointBorderWidth'] = 1;
                    $chart['data']['datasets'][2]['pointRadius'] = 1;


                    $_start_date = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))));
                    $_end_date = date('Y-m-d');
                    while (strtotime($_start_date) < strtotime($_end_date)) {
                        $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));
                        $chart['data']['labels'][] = til_get_date($_start_date, 'd F');


                        $form_total = 0;
                        $total = 0;
                        $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='form' AND in_out='0' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' AND date <= '" . $_start_date . " 23:59:59' ORDER BY id DESC, date DESC");
                        if (($total = $q_forms->fetch_object()->total) > 0) {
                            // $chart['data']['datasets'][0]['data'][] = '-'.$total;
                        } else {
                            // $chart['data']['datasets'][0]['data'][] = '0.00';
                        }
                        $form_total = $total;

                        $total = 0;
                        $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='form' AND in_out='1' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' AND date <= '" . $_start_date . " 23:59:59' ORDER BY id DESC, date DESC");
                        if (($total = $q_forms->fetch_object()->total) > 0) {
                            // $chart['data']['datasets'][1]['data'][] = $total;
                        } else {
                            // $chart['data']['datasets'][1]['data'][] = '0.00';
                        }
                        $chart['data']['datasets'][0]['data'][] = $form_total = $total - $form_total;


                        $payment_total = 0;
                        $total = 0;
                        $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='payment' AND in_out='1' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' AND date <= '" . $_start_date . " 23:59:59' ORDER BY id DESC, date DESC");
                        if (($total = $q_forms->fetch_object()->total) > 0) {
                            // $chart['data']['datasets'][2]['data'][] = $total;
                        } else {
                            // $chart['data']['datasets'][2]['data'][] = '0.00';
                        }
                        $payment_total = $total;

                        $total = 0;
                        $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='payment' AND in_out='0' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' AND date <= '" . $_start_date . " 23:59:59' ORDER BY id DESC, date DESC");
                        if (($total = $q_forms->fetch_object()->total) > 0) {
                            // $chart['data']['datasets'][3]['data'][] = $total;
                        } else {
                            // $chart['data']['datasets'][3]['data'][] = '0.00';
                        }
                        $chart['data']['datasets'][1]['data'][] = $total - $payment_total;


                        $total = 0;
                        $q_forms = db()->query("SELECT sum(profit) as total FROM " . dbname('forms') . " WHERE status='1' AND account_id='" . $account->id . "' AND date >= '" . $_start_date . " 00:00:00' AND date <= '" . $_start_date . " 23:59:59' ORDER BY id DESC, date DESC");
                        if (($total = $q_forms->fetch_object()->total) > 0) {
                            $chart['data']['datasets'][2]['data'][] = $total;
                        } else {
                            $chart['data']['datasets'][2]['data'][] = '0.00';
                        }
                    }


                    $chart['options']['legend']['display'] = true;
                    $chart['options']['scales']['yAxes'][0]['display'] = true;
                    $chart['options']['scales']['yAxes'][0]['ticks']['beginAtZero'] = false;
                    $chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { if(value >= 1) { return value + ' ل٫س'; } } =TIL=";
                    $chart['options']['scales']['xAxes'][0]['display'] = true;
                    $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
                    $chart['options']['maintainAspectRatio'] = false;
                    $chart['options']['tooltips']['enabled'] = true;
                    $chart['options']['tooltips']['yLabel'] = 'krall';
                    $chart['options']['tooltips']['mode'] = 'nearest';
                    $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return tooltipItems.yLabel.formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";

                    $args['height'] = '250';
                    $args['chart'] = $chart;

                    ?>


                    <div class="h-20 visible-xs"></div>
                    <div class="panel panel-default panel-border-0">
                        <div class="panel-heading"><h3 class="panel-title">ملخص الرسم البياني في آخر 30 يوما</h3>
                        </div>
                        <div class="panel-body">
                            <?php chartjs($args); ?>
                        </div>
                    </div> <!-- /.panel -->

                </div> <!-- /.col-* -->
                <div class="col-md-4">

                    <?php
                    $chart = array();
                    $chart['type'] = 'doughnut';
                    // $chart['data']['datasets'][0]['label'] 	= 'Giriş';
                    $chart['data']['datasets'][0]['fill'] = true;
                    $chart['data']['datasets'][0]['lineTension'] = 0.3;
                    $chart['data']['datasets'][0]['borderWidth'] = 1;
                    $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
                    $chart['data']['datasets'][0]['pointRadius'] = 1;

                    $_data = array();
                    $q_form_items = db()->query("SELECT * FROM " . dbname('form_items') . " WHERE status='1' AND type='item' AND account_id='" . $account->id . "'");
                    while ($list = $q_form_items->fetch_object()) {
                        if (!isset($_data[$list->item_id])) {
                            $_data[$list->item_id] = array();
                        }

                        $_data[$list->item_id]['quantity'] = @$_data[$list->item_id]['quantity'] + $list->quantity;
                        $_data[$list->item_id]['total'] = @$_data[$list->item_id]['total'] + $list->total;
                    }
                    $i = 0;
                    $_other = 0;
                    foreach ($_data as $key => $val) {
                        if ($i < 7) {
                            $chart['data']['labels'][] = til_get_substr(get_item($key)->name, 0, 10);
                            $chart['data']['datasets'][0]['data'][] = $val['total'];
                            $i++;
                        } else {
                            $_other = $_other + $val['total'];
                        }
                    }

                    $chart['data']['labels'][] = "أخرى";
                    $chart['data']['datasets'][0]['data'][] = $_other;

                    $chart['options']['legend']['display'] = true;
                    $chart['options']['scales']['yAxes'][0]['display'] = false;
                    $chart['options']['scales']['xAxes'][0]['display'] = false;
                    $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
                    $chart['options']['maintainAspectRatio'] = false;
                    $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
                    $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";

                    // $args['height'] 	= '550';
                    $args['chart'] = $chart;
                    ?>

                    <div class="h-20 visible-xs"></div>
                    <small class="text-muted module-title-small"><i class="fa fa-pie-chart"></i> المنتجات الأكثر
                        تفضيلا
                    </small>
                    <div class="h-10"></div>

                    <div class="relative"><?php chartjs($args); ?></div>

                </div> <!-- /.col-* -->
            </div> <!-- /.row -->


        </div>
    </div>
    <!-- /tab:home -->


    <!-- tab:forms -->
    <div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab">
        <div class="col-sm-21">
            <input class="user_info" type="checkbox" name="userinfo" value='-1'>
            <h width="60">اظهار او اخفاء الموظف</h>
        </div>


        <?php
        $args_form['where']['status'] = '1';
        $args_form['where']['account_id'] = $account->id;
        $args_form['where']['order_by'] = array('date' => 'ASC', 'id' => 'ASC');
        if ($forms = get_forms($args_form)): ?>

            <table class="table table-hover table-bordered table-condensed table-striped dataTable">

                <thead>
                <?php if (til_is_mobile()): ?>
                    <tr>
                        <th width="60">ID</th>
                        <th class="hidden-xs-portrait">تاريخ</th>
                        <th class="hidden-xs-portrait">الموظف</th>
                        <th width="80">مدين</th>
                        <th width="80">دائن</th>
                        <!--							<th width="100">الرصيد</th>-->
                    </tr>
                <?php else: ?>
                    <tr>
                        <th width="60">ID</th>
                        <th width="60">التاريخ</th>
                        <th width="30">د/خ</th>
                        <th width="10%">الحالة</th>
                        <th class="userinfo" width="60">الموظف</th>
                        <th>الحركة</th>
                        <th width="30%">البيان</th>
                        <!--							<th width="140">مدين</th>-->
                        <!--							<th width="140">دائن</th>-->
                        <!--							<th width="140">الرصيد</th>-->

                    </tr>
                <?php endif; ?>

                </thead>
                <tbody>
                <?php $balance = 0;
                foreach ($forms->list as $form): ?>
                    <?php $form_status = get_form_status($form->status_id); ?>
                    <?php if (til_is_mobile()): ?>
                        <tr>
                            <td>
                                <?php if ($form->type === 'payment') { ?>
                                    <a href="../payment/detail.php?id=<?php echo $form->id; ?>"
                                       target="_blank">#<?php echo $form->id; ?></a>
                                <?php } else { ?>
                                    <a href="../form/detail.php?id=<?php echo $form->id; ?>"
                                       target="_blank">#<?php echo $form->id; ?></a>
                                <?php } ?>
                            </td>
                            <td class="hidden-xs-portrait">
                                <small class="text-muted"><?php echo til_get_date($form->date, 'Y-m-d'); ?></small>
                            </td>
                            <td class="hidden-xs-portrait">
                                <small class="text-muted"><?php echo get_user_info($form->user_id, 'display_name'); ?></small>
                            </td>
                            <!--							<td class="text-right">-->
                            <?php //if($form->in_out == 1) { echo get_set_money($form->total, true); $balance = $balance - $form->total; } else { echo ''; } ?><!--</td>-->
                            <!--							<td class="text-right">-->
                            <?php //if($form->in_out == 0) { echo get_set_money($form->total, true); $balance = $balance + $form->total; } else { echo ''; } ?><!--</td>-->
                            <!--							<td class="text-right">-->
                            <?php //echo get_set_money($balance, true); ?><!--</td>-->
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td>
                                <?php if ($form->type === 'payment') { ?>
                                    <a href="../payment/detail.php?id=<?php echo $form->id; ?>"
                                       target="_blank">#<?php echo $form->id; ?></a>
                                <?php } else { ?>
                                    <a href="../form/detail.php?id=<?php echo $form->id; ?>"
                                       target="_blank">#<?php echo $form->id; ?></a>
                                <?php } ?>
                            </td>
                            <td class="text-muted hidden-xs"><?php echo substr($form->date, 0, 16); ?></td>
                            <td class="hidden-xs"><?php echo get_in_out_label($form->in_out); ?></td>
                            <?php if ($form->type == 'form'): ?>
                                <td class="hidden-xs"><?php echo get_form_status_span($form_status); ?></td>
                            <?php else: ?>
                                <td class="hidden-xs"></td>
                            <?php endif; ?>
                            <td class="userinfo"
                                name="userinfo"> <?php echo get_user_info($form->user_id, 'display_name'); ?></td>
                            <td class="text-muted hidden-xs">
                                <?php
                                if ($form->type == 'form') {
                                    $item = get_form_items($form->id);
                                    $item = $item->list[0];
                                    $in_out = ($form->in_out == '0') ? 'معونة' : 'مبيعات';
                                    echo " {$in_out} : "
                                        . " عدد {$form->item_quantity} "
                                        . " : {$item->item_name}";
                                } elseif ($form->type == 'payment') {
                                    if ($form->in_out == '0') {
                                        echo 'دفعة منه';
                                    } else {
                                        echo 'دفعة له';
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-muted hidden-xs">
                                <?php
                                $meta = get_form_meta($form->id, 'note');
                                echo $meta->meta_value;
                                ?>
                            </td>
                            <!--							<td class="text-right">-->
                            <?php //if($form->in_out == 1) { echo get_set_money($form->total, true); $balance = $balance + $form->total; } else { echo ''; } ?><!--</td>-->
                            <!--                            <td class="text-right">-->
                            <?php //if($form->in_out == 0) { echo get_set_money($form->total, true); $balance = $balance - $form->total; } else { echo ''; } ?><!--</td>-->
                            <!--							<td class="text-right">-->
                            <?php //echo get_set_money($balance, true); ?><!--</td>-->

                        </tr>

                    <?php endif; ?>

                <?php endforeach; ?>
                <?php if (til_is_mobile()): ?>
                    <td colspan="1" class="hidden-xs-portrait"></td>
                    <td colspan="1" class="hidden-xs-portrait"></td>
                    <td colspan="1" class="userinfo"></td>
                <?php else: ?>
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="text-right" ></td>-->
                    <!--                    <td colspan="1" class="userinfo" ></td>-->
                <?php endif; ?>

                <!--                <td colspan="1" class="text-right"style="-->
                <!--    color: black;-->
                <!--    background: #6be0e2;-->
                <!--    font-weight: bold;-->
                <!--    text-align: center;-->
                <!--">-->
                <!---->
                <!--                    --><?php //echo get_set_money($accountTotal['payment_out'] + $accountTotal['form_out']); ?>
                <!--                </td>-->
                <!--                <td colspan="1" class="text-right"  style="-->
                <!--    color: black;-->
                <!--    background: #6be0e2;-->
                <!--    font-weight: bold;-->
                <!--    text-align: center;-->
                <!--">-->
                <!--                    --><?php //echo get_set_money($accountTotal['payment_in'] + $accountTotal['form_in']); ?>
                <!--                </td>-->
                <!--                <td colspan="1" class="text-right"  style="-->
                <!--    color: black;-->
                <!--    background: #6be0e2;-->
                <!--    font-weight: bold;-->
                <!--    text-align: center;-->
                <!--">-->
                <!--                    --><?php //echo get_set_money($account->balance); ?>
                <!--                </td>-->

                </tbody>
                <tfoot style="font-size: 14px;">
                <!--                  <tr>-->
                <!--                      --><?php
                //                      $D_C = ($account->balance < 0 )? 'دائن' : 'مدين' ;
                //                       ?>
                <!--                       <td colspan="10" class="text-right" ><b>الرصيد : </b>-->
                <!--                           <span class="ff-2 fs-17 bold -->
                <?php //echo $account->balance < 0 ? 'text-danger' : 'text-success'; ?><!--">-->
                <!--                               --><?php //echo get_set_money($account->balance); ?>
                <!--                               --><?php //echo $D_C;?><!--</span>-->
                <!--                       <h> فقط : </h> --><?php //echo til_get_money_convert_string($account->balance); ?>
                <!--                       </td>-->
                <!---->
                <!--                   </tr>-->

            </table>
        <?php else: ?>
            <?php echo get_alert(array('title' => 'لايوجد اي حركة على هذا الحساب', 'description' => 'لم تتم اضافة اي إجراءات لبطاقة الحساب هذه.'), 'warning', false); ?>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function () {
            $('.userinfo').hide();
            $('.user_info').click(function () {
                if ($(this).is(':checked')) {
                    $('.userinfo').show();
                } else {
                    $('.userinfo').hide();
                }
            });
        });

    </script>


    <!-- tab:logs -->
    <div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab">
        <?php theme_get_logs(" table_id='accounts:" . $account->id . "' "); ?>
    </div>
    <!-- /tab:logs -->

</div> <!-- /.tab-content -->


<?php get_footer(); ?>
