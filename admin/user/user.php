<?php include('../../ultra.php'); ?>
<?php get_header(); ?>

<?php
// جميع المعلومات من المستخدم النشط
if (!$user = get_user($_GET['id'])) {
    echo get_alert('لم يتم العثور على حساب المستخدم.', 'warning', false);
    get_footer();
    return false;
}
if ($user->account_id) {
    $account = get_account($user->account_id);
}


## حذف الحساب
if (isset($_GET['status']) and user_access('admin')) {
    if ($_GET['status'] == '0' OR $_GET['status'] == '1') {
        $_args = array();
        $_args['add_log'] = false;
        $_args['add_alert'] = false;
        $_args['update']['status'] = $_GET['status'];
        if (update_user($user->id, $_args)) {
            if ($_GET['status'] == '0') {
                add_log(array('table_id' => 'users:' . $user->id, 'log_key' => __FUNCTION__, 'log_text' => _b($user->display_name) . ' حساب المستخدم <u>غير نشط</u> aldı.'));
                add_alert('حساب المستخدم غير نشط.', 'warning', false);
            } else {
                add_log(array('table_id' => 'users:' . $user->id, 'log_key' => __FUNCTION__, 'log_text' => _b($user->display_name) . ' حساب المستخدم <u>نشط</u> aldı.'));
                add_alert('تم تنشيط حساب المستخدم.', 'success', false);
            }
        }
    }
}


## حذف الصور
if (isset($_GET['delete_avatar']) and user_access('admin')) {
    if ($user->avatar) {
        if (delete_image($user->avatar)) {
            update_user($user->id, array('avatar' => ''));
        }
    }
}

## تحميل الصور
if (isset($_POST['update_profile']) and user_access('admin')) {

    $_user['username'] = $_POST['username'];
    $_user['email'] = $_POST['email'];
    $_user['surname'] = $_POST['surname'];
    $_user['gsm'] = get_set_gsm($_POST['gsm']);
    $_user['role'] = $_POST['role'];
    $_user['gender'] = $_POST['gender'];
    $_user['citizenship_no'] = $_POST['citizenship_no'];

    if (!isset($_POST['til_login'])) {
        $_user['til_login'] = false;
    }

    // تحميل الصورة
    if ($_FILES['avatar']['size'] > 0) {

        $args['uniquetime'] = get_uniquetime();
        $args['sizing']['width'] = '150';
        $args['sizing']['height'] = '150';
        if ($upload_image = upload_image($_FILES['avatar'], $args)) {
            $_user['avatar'] = $upload_image;

            // حذف الصورة القديمة من الخادم كما يتم تحميل الصورة الجديدة
            delete_image($user->avatar);
        }
    }

    // إذا كان مربع كلمة مرور إيجر فارغ، يتم تحديث كلمة المرور.
    if (!empty($_POST['password'])) {
        if ($_POST['password'] != $_POST['password_again']) {
            add_alert('كلمة المرور التي أنشأتها للتو ليست هي نفسها كلمة المرور. الرجاء إعادة المحاولة.', 'warning', 'update_profile');
        } else {
            $_user['password'] = $_POST['password'];
        }
    }

    if (!is_alert('update_profile')) {
        if (update_user($user->id, $_user)) {

        }
    }
}


## إذا تم تحديث إجر أعلاه، فإننا سوف إعادة إعلام المعلومات مرة أخرى.
$user = get_user($_GET['id'], false);

add_page_info('title', $user->name . ' ' . $user->surname);
add_page_info('nav', array('name' => 'جميع الموظفين', 'url' => get_site_url('admin/user/list.php')));
add_page_info('nav', array('name' => $user->name . ' ' . $user->surname));
?>


    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab"
                                                  aria-controls="home" aria-expanded="true"><i class="fa fa-user-o"></i>
                الملف الشخصي</a></li>
        <?php if (user_access('admin')): ?>
            <li role="presentation"><a href="#cv" id="cv-tab" role="tab" data-toggle="tab" aria-controls="cv"
                                       aria-expanded="true"><i class="fa fa-address-book-o"></i> السيرة الذاتية</a>
            </li><?php endif; ?>
        <?php if (user_access('admin')): ?>
            <li role="presentation"><a href="#salary" id="salary-tab" role="tab" data-toggle="tab"
                                       aria-controls="salary" aria-expanded="true"><i class="fa fa-money"></i> راتب</a>
            </li><?php endif; ?>
        <li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs"
                                            aria-expanded="false"><i class="fa fa-database"></i> تاريخ</a></li>

        <li role="presentation" class="dropdown pull-right"><a href="#" class="dropdown-toggle" id="myTabDrop1"
                                                               data-toggle="dropdown"
                                                               aria-controls="myTabDrop1-contents"
                                                               aria-expanded="false"><i class="fa fa-cogs"></i> خيارات
                <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">تعيين
                        المهمة</a></li>
                <li><a href="<?php site_url('admin/user/message/add.php?rec_u_id=' . $user->id); ?>">ارسل رسالة</a></li>
            </ul>
        </li>
        <li role="presentation" class="dropdown pull-right"><a href="#" class="dropdown-toggle" id="myTabDrop1"
                                                               data-toggle="dropdown"
                                                               aria-controls="myTabDrop1-contents"
                                                               aria-expanded="false"><i class="fa fa-print"></i> طباعة
                <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="print_cv.php?id=<?php echo $user->id; ?>" target="_blank">السيرة الذاتية (CV) طباعة</a>
                </li>
                <li class="divider"></li>
                <li><a href="print_salary.php?id=<?php echo $user->id; ?>" target="_blank">الراتب طباعة طباعة</a></li>
                <li><a href="print_salary_detail.php?id=<?php echo $user->id; ?>" target="_blank">طباعة بيان الراتب
                        المفصل</a></li>
            </ul>
        </li>
    </ul>

    <div class="tab-content">

        <!-- tab:home -->
        <div class="tab-pane active fade in" role="tabpanel" id="home" aria-labelledby="home-tab">

            <?php print_alert(); ?>

            <form name="form-profile" id="form-profile" method="POST" action="?id=<?php echo $user->id; ?>"
                  class="validate" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">البريد الالكتروني</label>
                                    <input type="text" name="email" id="email" value="<?php echo $user->email; ?>"
                                           class="form-control email">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gsm">الهاتف المحمول</label>
                                    <input type="text" name="gsm" id="gsm" value="<?php echo $user->gsm; ?>"
                                           class="form-control digits" minlength="3" maxlength="11">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                        </div> <!-- /.row -->


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">الاسم</label>
                                    <input type="text" name="username" id="username"
                                           value="<?php echo $user->username; ?>" class="form-control" minlength="3"
                                           maxlength="25">
                                </div> <!-- /.form-group -->
                            </div> <!--- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="surname">اللقب / الشهرة</label>
                                    <input type="text" name="surname" id="surname" value="<?php echo $user->surname; ?>"
                                           class="form-control" minlength="3" maxlength="20">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                        </div> <!-- /.row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">الجنس</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="1" <?php selected('1', $user->gender); ?>>ذكر</option>
                                        <option value="0" <?php selected('0', $user->gender); ?>>انثى</option>
                                    </select>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="citizenship_no">رقم الهوية</label>
                                    <input type="text" name="citizenship_no" id="citizenship_no"
                                           class="form-control digits" minlength="3" maxlength="25"
                                           value="<?php echo $user->citizenship_no; ?>">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-6 -->
                        </div> <!-- /.row -->


                        <?php if (user_access('admin')): ?>
                            <div class="form-group">
                                <label for="til_login" id="label_til_login">
                                    <input type="checkbox" name="til_login" id="til_login"
                                           value="1" <?php echo $user->til_login ? 'checked' : ''; ?>>
                                    هذا الموظف <b>المستقبل!</b> هل يمكنك تسجيل الدخول إلى النظام؟
                                </label>
                            </div> <!-- /.form-group -->

                            <script>
                                $(document).ready(function () {

                                    $('#til_login').change(function () {
                                        if ($('#til_login').is(':checked')) {
                                            $('#is_til_login_div').removeClass('hidden');
                                        } else {
                                            $('#is_til_login_div').addClass('hidden');
                                        }
                                    });

                                    <?php if($user->til_login): ?>
                                    $('#is_til_login_div').removeClass('hidden');
                                    <?php endif; ?>
                                });
                            </script>
                        <?php endif; ?>


                        <div id="is_til_login_div" class="hidden">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">السلطة</label>
                                        <select name="role" id="role"
                                                class="select form-control" <?php if (!user_access('admin')): echo 'disabled'; endif; ?>>
                                            <option value="5" <?php selected($user->role, '5'); ?>>الموظف</option>
                                            <option value="4" <?php selected($user->role, '4'); ?>>كبار الموظفين
                                            </option>
                                            <option value="3" <?php selected($user->role, '3'); ?>>مشرف قسم</option>
                                            <option value="2" <?php selected($user->role, '2'); ?>>مدير</option>
                                            <?php if (user_access('superadmin')): ?>
                                            <option value="1" <?php selected($user->role, '1'); ?>>مدير
                                                    مميز</option><?php endif; ?>
                                        </select>
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col-md-6 -->
                            </div> <!-- /.row -->


                            <?php if (user_access('admin')): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">كلمة المرور</label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-md-6 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_again">كرر كلمة المرور</label>
                                            <input type="password" name="password_again" id="password_again"
                                                   class="form-control">
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-md-6 -->
                                </div> <!-- /.row -->


                            <?php endif; ?>
                        </div> <!-- /#is_til_login_div -->

                        <div class="pull-right hidden-xs">
                            <input type="hidden" name="update_profile">
                            <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
                            <button class="btn btn-default">حفظ</button>
                        </div> <!-- /.pull-right -->

                    </div> <!-- /.col-md-6 -->

                    <div class="clearfix"></div>

                    <div class="col-md-2">
                        <br/>

                        <div class="img-thumbnail">
                            <img src="<?php echo $user->avatar; ?>" class="img-responsive" id="avatar_view"
                                 onclick="document.getElementById('avatar').click()" style="width:180px; height:180px;">
                            <?php if (user_access('admin')): ?>
                                <div class="h-10"></div>
                                <a href="?id=<?php echo $user->id; ?>&delete_avatar"
                                   class="pull-right text-danger fs-12"><i class="fa fa-trash"></i> حذف هذه الصورة</a>
                            <?php endif; ?>
                        </div>

                        <?php if (user_access('admin')): ?>
                            <div class="h-20"></div>
                            <div class="form-group hidden">
                                <label for="avatar">تحميل صورة جديدة.</label>
                                <input type="hidden" name="img_uniquetime" value="<?php usleep(1000);
                                uniquetime(); ?>">
                                <input type="file" name="avatar" id="avatar"
                                       onchange="render_form_file(this, function(img) { document.getElementById('avatar_view').src = img; });">
                            </div> <!-- /.form-group -->
                        <?php endif; ?>


                        <div class="form-group hidden-md hidden-lg hidden-sm">
                            <button class="btn btn-default pull-right">حفظ</button>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-2 -->
                </div> <!-- /.row -->

            </form>


            <?php if (user_access('admin')): ?>
                <hr/>
                <?php if ($user->status == 1): ?>
                    <span class="">هل تريد حذف حساب المستخدم هذا?</span>
                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#userDelete"><i
                                class="fa fa-trash-o"></i> نعم، حذف</a>

                    <!-- Modal -->
                    <div class="modal fade" id="userDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">حذف حساب المستخدم</h4>
                                </div>
                                <div class="modal-body">
                                    <p><strong><?php echo $user->display_name; ?></strong> هل تريد حذف حساب المستخدم?
                                    </p>

                                    <small class="text-muted">لا يتم حذف حساب المستخدم من قاعدة البيانات، يتم حظر الحساب
                                        فقط من دخول النظام. لا يمكن لصفحات مثل "جميع المستخدمين" الدخول إلى حساب
                                        المستخدم هذا.
                                    </small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">نعم</button>
                                    <a href="?id=<?php echo $user->id; ?>&status=0" class="btn btn-danger">نعم،
                                        أوافق</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <span class="">أعد تنشيط حساب المستخدم هذا.</span>
                    <a href="?id=<?php echo $user->id; ?>&status=1" class="btn btn-success btn-xs"><i
                                class="fa fa-undo"></i> نعم، تفعيل</a>
                <?php endif; ?>
            <?php endif; ?>


        </div> <!-- /#home -->
        <!-- /tab:home -->

        <!-- tab:cv -->
        <div class="tab-pane" role="tabpanel" id="cv" aria-labelledy="cv-tab">
            <?php include('inc_user_cv.php'); ?>
        </div>
        <!-- /tab:cv -->

        <!-- tab:cv -->
        <div class="tab-pane" role="tabpanel" id="salary" aria-labelledy="salary-tab">
            <?php include('inc_user_salary.php'); ?>
        </div>
        <!-- /tab:cv -->


        <!-- tab:home -->
        <div class="tab-pane" role="tabpanel" id="logs" aria-labelledby="logs-tab">
            <?php theme_get_logs(" user_id='" . $user->id . "' "); ?>
        </div>
        <!-- tab:logs -->

    </div> <!-- /.tab-content -->


<?php get_footer(); ?>