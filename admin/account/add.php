<?php include('../../ultra.php'); ?>
<?php include_content_page('add', false, 'account'); ?>

<?php get_header(); ?>
<?php
add_page_info('title', 'إضافة مستفيد');
add_page_info('nav', array('name' => 'المستفيد', 'url' => get_site_url('admin/account/')));
add_page_info('nav', array('name' => 'إضافة'));
?>


<?php
if (isset($_POST['add'])) {

    if ($account_id = add_account($_POST)) {
        print_alert('add_account');

        if (isset($_POST['again'])) {
            unset($_POST);
            $_POST['again'] = true;
        } else {
            header("Location: detail.php?id=" . $account_id);
        }
    } else {
        if (is_alert()) {
            print_alert();

        }
    }
};


?>


    <form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group country_selected">
                            <label for="types">النوع</label>
                            <select id="types" name="type" class="form-control select select-account"
                                    data-live-search="true">
                                <?php foreach (get_types_array() as $name => $code): ?>
                                    <?php if ($accountCode === $code): ?>
                                        <option value="<?= $code ?>" selected="selected"><?= $name ?></option>
                                    <?php else: ?>
                                        <option value="<?= $code ?>"><?= $name ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-6">
                        <label for="code">رمز المستفيد </label>
                        <input type="text" name="code" id="code" value="<?php echo @$_POST['code']; ?>"
                               class="form-control" maxlength="32" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="name"> اسم المستفيد <sup class="text-muted"> الاسم او اللقب
                                </sup></label>
                            <input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>"
                                   class="form-control required" maxlength="128">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="fathername"> اسم الاب </label>
                            <input type="text" name="fathername" id="fathername"
                                   value="<?php echo @$_POST['fathername']; ?>" class="form-control" maxlength="25">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="DateofBirth">تاريخ الميلاد</label>
                            <input type="date" name="DateofBirth" id="DateofBirth"
                                   value="<?php echo @$_POST['DateofBirth']; ?>"
                                   class="form-control input-sm bootstrap-datetimepicker-widget" maxlength="128">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="countrynumber"> الرقم الوطني</label>
                            <input type="tel" name="countrynumber" id="countrynumber"
                                   value="<?php echo @$_POST['countrynumber']; ?>" class="form-control" maxlength="25">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="Retardationnum">رقم بطاقة الاعاقة</label>
                            <input type="text" name="Retardationnum" id="Retardationnum"
                                   value="<?php echo @$_POST['Retardationnum']; ?>"
                                   class="form-control" maxlength="25">
                        </div>

                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="mo3el">المعيل</label>
                            <input type="text" name="mo3el" id="mo3el" value="<?php echo @$_POST['mo3el']; ?>"
                                   class="form-control" maxlength="128">
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="gsm">رقم الموبايل</label>
                            <input type="tel" name="gsm" id="gsm" value="<?php echo @$_POST['gsm']; ?>"
                                   class="form-control digits" maxlength="25">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="sex"> الجنس </label>
                            <select name="sex" id="sex" value="<?php echo @$_POST['sex']; ?>"
                                    class="form-control select" maxlength="25">
                                <option value="ذكر">ذكر</option>
                                <option value="انثى">انثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="Retardationtype">نوع الاعاقة</label>
                            <input type="text" name="Retardationtype" id="Retardationtype"
                                   value="<?php echo @$_POST['Retardationtype']; ?>" class="form-control"
                                   maxlength="255">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="address">العنوان</label>
                            <input type="text" name="address" id="address" value="<?php echo @$_POST['address']; ?>"
                                   class="form-control" maxlength="255">
                        </div>
                    </div>


                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="district">الحالة الاجتماعية</label>
                            <select name="district" id="district" value="<?php echo @$_POST['district']; ?>"
                                    class="form-control select" maxlength="25">
                                <option value="اعزب">اعزب</option>
                                <option value="عزباء">عزباء</option>
                                <option value="متزوج">متزوج</option>
                                <option value="متزوجة">متزوجة</option>
                                <option value="ارمل">ارمل</option>
                                <option value="ارملة">ارملة</option>
                                <option value="مطلق">مطلق</option>
                                <option value="مطلقة">مطلقة</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="job">المهنة</label>
                            <input type="text" name="job" id="job" value="<?php echo @$_POST['job']; ?>"
                                   class="form-control" maxlength="25">
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group country_selected">
                            <label for="country">الدولة</label>
                            <?php echo list_selectbox(get_country_array(), array('name' => 'country', 'selected' => 'SYRIAN ARAB REPUBLIC', 'class' => 'form-control select select-account')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label for="needsomeone">يحتاج حفوضات</label>
                            <select type="text" name="needsomeone" id="needsomeone"
                                    value="<?php echo @$_POST['needsomeone']; ?>"
                                    class="form-control select" maxlength="25">
                                <option value="لايحتاج حفوضات">لايحتاج حفوضات</option>
                                <option value="يحتاج حفوضات">يحتاج حفوضات</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group country_selected">
                            <label for="famelynum">عدد افراد الاسرة</label>
                            <input type="tel" name="famelynum" id="famelynum"
                                   value="<?php echo @$_POST['famelynum']; ?>"
                                   class="form-control" maxlength="25">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group country_selected">
                            <label for="living">الحالة</label>
                            <input type="text" name="living" id="living" value="<?php echo @$_POST['living']; ?>"
                                   class="form-control" maxlength="255">


                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group country_selected">
                            <label for="note">ملاحظات</label>
                            <input type="text" name="note" id="note" value="<?php echo @$_POST['note']; ?>"
                                   class="form-control" maxlength="255">
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div class="h-20"></div>
        <div class="form-group pull-left">
            <label class="veritical-center text-muted"><input type="checkbox" name="again" id="again" value="true"
                                                              <?php if (isset($_POST['again']) or isset($_GET['again'])): ?>checked<?php endif; ?>
                                                              data-toggle="switch" switch-size="lg" off-text=" لا "
                                                              on-text=" نعم "> &nbsp;
                <div class="visible-xs"></div>
                هل ستقوم باضافة بطاقة حساب جديدة بعد التسجيل</label>
        </div>
        <div class="clearfix"></div>


        <div class="text-right">
            <input type="hidden" name="add">
            <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
            <button class="btn btn-success btn-insert btn-xs-block"><i class="fa fa-plus-square"></i> حفظ</button>
        </div>

    </form>
<?php
if (@empty($_POST['code'])) {
    $accountCode = (isset($_GET['accoutcode'])) ? $_GET['accoutcode'] : 'Retardation';
    $_POST['code'] = get_account_code_generator('', $accountCode);
}
?>

    <script>
        $('#name').focus();
        $('#types').on('change', function () {
            window.location = window.location.pathname + "?accoutcode=" + $(this).val();
        });
    </script>

<?php get_footer(); ?>