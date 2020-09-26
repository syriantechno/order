<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('العنوان', 'إضافة موظفين');
add_page_info('nav', array('name' => 'الموظفين', 'url' => get_site_url('admin/user/index.php')));
add_page_info('nav', array('name' => 'إضافة موظفين'));
?>


<?php if (page_access('admin')): ?>


    <?php
    if (isset($_POST['add_user']) and user_access('admin')) {

        $_user['date'] = date('Y-m-d H:i:s');
        $_user['username'] = $_POST['username'];
        $_user['name'] = $_POST['name'];

        $_user['surname'] = til_get_strtoupper($_POST['surname']);
        $_user['gsm'] = til_get_strtoupper($_POST['gsm']);
        $_user['role'] = $_POST['role'];
        $_user['gender'] = $_POST['gender'];
        $_user['citizenship_no'] = $_POST['citizenship_no'];
        $_user['til_login'] = @$_POST['til_login'];
        $_user['password'] = $_POST['password'];


        if ($_POST['password'] != $_POST['password_again']) {
            add_alert('كلمة المرور التي أنشأتها للتو ليست هي نفسها كلمة المرور. الرجاء إعادة المحاولة.', 'warning');
        } else {
            if ($user_id = add_user($_user)) {
                unset($_user);
                header("Location: user.php?id=" . $user_id);
            }
        }
    }
    ?>


    <?php print_alert(); ?>


    <form name="form-profile" id="form-profile" method="POST" action="" class="validate">
        <div class="row">
            <div class="col-md-6">


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">اسم الدخول</label>
                            <input type="text" name="username" id="username" class="form-control required" minlength="3"
                                   maxlength="20" value="<?php echo @$_user['username']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control required" minlength="3"
                                   maxlength="20" value="<?php echo @$_user['name']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="surname">اللقب/الشهرة</label>
                            <input type="text" name="surname" id="surname" class="form-control required" minlength="3"
                                   maxlength="20" value="<?php echo @$_user['surname']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني </label>
                            <input type="email" name="email" id="email" class="form-control  email"
                                   value="<?php echo @$_user['email']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="text">الهاتف المحمول</label>
                            <input type="tel" name="gsm" id="gsm" class="form-control  digits" minlength="1"
                                   maxlength="25" value="<?php echo @$_user['gsm']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">الجنس</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="1" selected>ذكر</option>
                                <option value="0">انثى</option>
                            </select>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="citizenship_no">رقم الهوية</label>
                            <input type="tel" name="citizenship_no" id="citizenship_no" class="form-control digits"
                                   minlength="1" maxlength="25" value="<?php echo @$_user['citizenship_no']; ?>">
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->

                <div class="form-group">
                    <label for="til_login" id="label_til_login">
                        <input type="checkbox" name="til_login" id="til_login" data-toggle='switch' switch-size="sm"
                               value="1">
                        هذا الموظف <b>المستقبل!</b> هل يستطيع الدخول الى النظام
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
                    });
                </script>

                <div id="is_til_login_div" class="hidden">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="role">السلطة الممنوحة</label>
                                <select name="role" id="role" class="select">
                                    <option value="5">موظف</option>
                                    <option value="4">موظف معتمد</option>
                                    <option value="3">مشرف متميز</option>
                                    <option value="2">مدير</option>
                                    <option value="1">مدير متميز</option>
                                </select>
                            </div> <!-- /.form-group -->

                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">كلمة المرور</label>
                                <input type="password" name="password" id="password" class="form-control required"
                                       minlength="6" maxlength="32" value="">
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_again">تكرار كلمة المرور </label>
                                <input type="password" name="password_again" id="password_again"
                                       class="form-control required" minlength="6" maxlength="32" value="">
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </div> <!-- /.is_til_login_div -->


                <div class="text-right">
                    <input type="hidden" name="add_user">
                    <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
                    <button class="btn btn-success btn-xs-block btn-insert">حفظ</button>
                </div> <!-- /.pull-right -->

            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->
    </form>


<?php endif; // page_access() ?>

<?php get_footer(); ?>