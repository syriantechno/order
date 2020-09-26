<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'الخيارات العامة');
add_page_info('nav', array('name' => 'خيارات', 'url' => get_site_url('admin/system/')));
add_page_info('nav', array('name' => 'الخيارات العامة'));
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs til-nav-page" role="tablist">
    <li role="presentation" class="active"><a href="#general" id="general-tab" aria-controls="general" role="tab"
                                              data-toggle="tab" aria-expanded="false">عامة</a></li>

    <li role="presentation" class=""><a href="#mail" id="mail-tab" aria-controls="mail" role="tab" data-toggle="tab"
                                        aria-expanded="false">البريد</a></li>

</ul>


<!-- Tab panes -->
<div class="tab-content">

    <!--/ General /-->
    <div role="tabpanel" class="tab-pane fade in active" id="general" aria-labelledby="general-tab">
        <?php
        if (isset($_POST['company'])) {
            if (update_option('company', json_encode_utf8($_POST['company']))) {
                add_alert('تحديث معلومات الشركة!', 'success', 'company');
            }
        }

        $_company = get_option('company');
        if (empty($_company)) {
            $_company = (object)array('name' => '', 'address' => '', 'district' => '', 'city' => '', 'country' => '', 'email' => '', 'phone' => '', 'gsm' => '', 'currency' => '', 'price1' => '', 'price2' => '', 'price4' => '', 'price5' => '', 'price6' => '', 'highlight' => '');
        }
        ?>

        <form action="#general" method="post" autocomplete="off">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-7">
                        <?php print_alert('company'); ?>
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[name]">اسم الشركة</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[name]" id="company[name]"
                               value="<?php echo $_company->name; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[email]">البريد الالكتروني</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[email]" id="company[email]"
                               value="<?php echo $_company->email; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[phone]">رقم التلفون</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[phone]" id="company[phone]"
                               value="<?php echo $_company->phone; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[gsm]">رقم المحمول</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[gsm]" id="company[gsm]" value="<?php echo $_company->gsm; ?>"
                               class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[address]">العنوان</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[address]" id="company[address]"
                               value="<?php echo $_company->address; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[district]">المحافظة</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[district]" id="company[district]"
                               value="<?php echo $_company->district; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[city]">المدينة</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[city]" id="company[city]"
                               value="<?php echo $_company->city; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[country]">البلد</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[country]" id="company[country]"
                               value="<?php echo $_company->country; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="company[currency]">العملة</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="company[currency]" id="company[currency]"
                               value="<?php echo $_company->currency; ?>" class="form-control">

                    </div><!--/ .col-md-5 /-->

                </div><!--/ .row /-->
            </div><!--/ .form-group /-->
            <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="company[highlight]">لون اختيار الجدول</label>
                        </div><!--/ .col-md-2 /-->

                        <div class="col-md-5">
                            <input type="text" name="company[highlight]" id="highlight"
                                   value="<?php echo $_company->highlight; ?>" class="form-control colorpicker_bg_status colorpicker-element valid" maxlength="32" value="#fdc430" aria-required="true" aria-invalid="false">

                            <script>

                                $(function () {

                                    $('#highlight').colorpicker();

                                });

                            </script>
                        </div><!--/ .col-md-5 /-->

                    </div><!--/ .row /-->
                </div><!--/ .form-group /-->
                <div class="form-group">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="company[highlight2]">لون مرور الجدول</label>
                            </div><!--/ .col-md-2 /-->

                            <div class="col-md-5">
                                <input type="text" name="company[highlight2]" id="highlight2"
                                       value="<?php echo $_company->highlight2; ?>" class="form-control colorpicker_bg_status colorpicker-element valid" maxlength="32" value="#fdc430" aria-required="true" aria-invalid="false">

                                <script>

                                    $(function () {

                                        $('#highlight2').colorpicker();

                                    });

                                </script>
                            </div><!--/ .col-md-5 /-->

                        </div><!--/ .row /-->
                    </div><!--/ .form-group /-->


            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-7">
                        <button type="submit" class="btn btn-primary btn-icon btn-lg "><i class="fa fa-rocket"></i>
                            حــــفــــــظ
                        </button>
                    </div><!--/ .col-md-7 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->
        </form>

    </div><!--/ .tab-panel /-->
    <!--/ General /-->








    <div role="tabpanel" class="tab-pane" id="forms" aria-labelledby="forms-tab">

        <!--/ Forms /-->

    </div><!--/ .tab-panel /-->


    <div role="tabpanel" class="tab-pane" id="person" aria-labelledby="person-tab">

        <!--/ Person /-->

    </div><!--/ .tab-panel /-->


    <div role="tabpanel" class="tab-pane" id="mail" aria-labelledby="mail-tab">
        <?php
        if (isset($_POST['mail'])) {
            if (update_option('mail', json_encode_utf8($_POST['mail']))) {
                add_alert('Mail Ayarları Güncellendi.', 'success', 'mail');
            }
        }

        $_mail = get_option('mail');
        if (empty($_mail)) {
            $_mail = (object)array('send_address' => '', 'host' => '', 'port' => '', 'password' => '');
        }
        ?>

        <form action="#accounts" method="post" autocomplete="off">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-7">
                        <?php print_alert('mail'); ?>
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="mail[send_address]">من البريد الإلكتروني</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="mail[send_address]" id="mail[send_address]"
                               value="<?php echo $_mail->send_address; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="mail[host]">خادم البريد</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="mail[host]" id="mail[host]" value="<?php echo $_mail->host; ?>"
                               class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="mail[port]">المنفذ</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="mail[port]" id="mail[port]" value="<?php echo $_mail->port; ?>"
                               class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <label for="mail[password]">كلمة المرور</label>
                    </div><!--/ .col-md-2 /-->

                    <div class="col-md-5">
                        <input type="text" name="mail[password]" id="mail[password]"
                               value="<?php echo $_mail->password; ?>" class="form-control">
                    </div><!--/ .col-md-5 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

            <div class="form-grouo">
                <div class="row">
                    <div class="col-md-7">
                        <button type="submit" class="btn btn-primary btn-icon btn-lg "><i class="fa fa-rocket"></i>
                            حــــفــــــظ
                        </button>
                    </div><!--/ .col-md-7 /-->
                </div><!--/ .row /-->
            </div><!--/ .form-group /-->

        </form>

    </div><!--/ .tab-panel /-->
</div><!--/ .tab-content /-->
<?php get_footer(); ?>
