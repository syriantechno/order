<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'تغيير كلمة المرور');
add_page_info('nav', array('name' => 'ملفي الشخصي', 'url' => get_site_url('admin/user/profile.php')));
add_page_info('nav', array('name' => 'تغيير كلمة المرور'));
?>

<?php
// جميع المعلومات من المستخدم النشط
$active = get_active_user();

if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_again = $_POST['new_password_again'];

    if ($old_password != $active->password) {
        add_alert('كلمة المرور القديمة الخاصة بك ليست صحيحة. يجب كتابة كلمة المرور القديمة لإنشاء كلمة مرور جديدة.', 'warning', 'change_password');
    } else {
        if ($new_password != $new_password_again) {
            add_alert('كلمة المرور غير متطابقة الرجاء المحاولة مجددا.', 'warning', 'change_password');
        } else {
            if (db()->query("UPDATE " . dbname('users') . " SET password='" . $new_password . "' WHERE id='" . $active->id . "' ")) {
                if (db()->affected_rows) {
                    add_alert('تم تغير كلمة المرور بنجاح.', 'success', 'change_password');
                }
            }
        }
    }
}

print_alert('change_password');
?>


    <div class="row">
        <div class="col-md-3">
            <form name="form_change_password" id="form_change_password" action="?" method="POST" class="validate">
                <div class="form-group">
                    <label for="old_password">كلمة المرور القديمة</label>
                    <input type="password" name="old_password" id="old_password" class="form-control required" value="">
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <label for="new_password">كلمة المرور جديدة</label>
                    <input type="password" name="new_password" id="new_password" class="form-control required"
                           minlength="6" value="">
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <label for="new_password_again">تكرار كلمة المرور الجديدة</label>
                    <input type="password" name="new_password_again" id="new_password_again"
                           class="form-control required" minlength="6" value="">
                </div> <!-- /.form-group -->

                <div class="text-right">
                    <input type="hidden" name="change_password" id="change_password">
                    <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">
                    <button class="btn btn-default">تغيير كلمة المرور</button>
                </div> <!-- /.text-right -->

            </form>
        </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->


<?php get_footer(); ?>