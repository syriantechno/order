<?php include('../../ultra.php'); ?>
<?php

$accountNotFound = false;

if ($form = get_form(@$_GET['id'])) {

} else {
    $form = new StdClass;
}

if (isset($_POST['account_code']) && empty($_POST['account_code'])) {
    $accountNotFound = true;
}

if (isset($_POST['account_name'])) {
    if (empty($_POST['account_name'])) {
        $accountNotFound = true;
    }

    $tbl_prefix = _prefix;
    $accountTest = db()->query("SELECT * FROM {$tbl_prefix}accounts WHERE `name` = '{$_POST['account_name']}'");

    if (!$accountTest->num_rows) {
        $accountNotFound = true;
    }
}

if ($accountNotFound) {
    $_POST = [];
}

if (!isset($form->template)) {
    if (isset($_GET['template'])) {
        $form->template = $_GET['template'];
    }
}
include_content_page('detail', @$form->template, 'form', array('form' => $form));
?>
<?php get_header(); ?>
<?php


if (isset($_GET['id'])) {
    if (empty($form->id)) {
        add_page_info('title', 'لم يتم العثور على النموذج');
        echo get_alert(_b($_GET['id']) . ' لم يتم العثور على نموذج رقم التعريف.', 'warning', false);
        get_footer();
        exit;
    }
}


if (empty($form->id)) {
    $form->id = 0;
    $form->date = date('Y-m-d H:i:s');

    if (isset($_GET['in'])) {
        $form->in_out = '0';
    } elseif (isset($_GET['out'])) {
        $form->in_out = '1';
    }
    if (!$form_status = get_form_status(array('val_5' => 'default', 'val_enum' => $form->in_out))) {
        echo get_alert("<b></b> لم يتم العثور على النموذج المحدد يجب ان يكون هناك نموذج واحد على الاقل قم بإنشاء نموذج . <b></b><a href='" . get_site_url('admin/system/form_status/form_status.php?taxonomy=til_fs_form') . "' class='strong'>من هنا</a> ", "warning");
        return false;
    }
} else {

    if (isset($_GET['update_status_id'])) {
        $args['where']['id'] = $_GET['status_id'];
        $args['where']['in_out'] = $form->in_out;

        if (change_form_status($form->id, $args)) {
            $form = get_form($form->id);
        }
    }


    if (!$form_status = get_form_status($form->status_id)) {
        if ($form_status = get_form_status(array('val_5' => 'default', 'val_enum' => $form->in_out))) {
            update_form($form->id, array('status_id' => $form_status->id));
            $form = get_form($form->id);
        }
    }
    $form_status_all = get_form_status_all($form->in_out);
}


// in_out control
if ($form->in_out != '0' and $form->in_out != '1') {
    echo get_alert('نوع إخراج الإدخال غير صحيح.', 'warning');
    exit;
}


// page info
if ($form->id) {
    add_page_info('title', ' توزيع ' . get_in_out_label($form->in_out) . '-' . $form->id . '#');
} else {
    add_page_info('title', 'عملية ' . get_in_out_label($form->in_out) . ' جديدة ');
}

add_page_info('nav', array('name' => 'إدارة التوزيع', 'url' => get_site_url('admin/form/')));
add_page_info('nav', array('name' => 'جميع عمليات التوزيع', 'url' => get_site_url('admin/form/list.php')));
add_page_info('nav', array('name' => til()->page['title']));


if (isset($_POST['form'])) {
    if ($form_id = set_form($form->id, $_POST)) {

        if (empty($form->id)) {
            header("Location: ?id=" . $form_id);
        }
    }


    if ($form->id) {
        $form_item['in_out'] = $form->in_out;
        $form_item['uniquetime'] = $_POST['item_uniquetime'];
        $form_item['form_id'] = $form->id;
        $form_item['account_id'] = $form->account_id;
        $form_item['item_code'] = $_POST['item_code'];
        $form_item['item_name'] = $_POST['item_name'];
        $form_item['quantity'] = $_POST['quantity'];
        $form_item['price'] = $_POST['price'];
        $form_item['vat'] = $_POST['vat'];

        if (!empty($_POST['item_code']) or !empty($_POST['item_name'])) {
            add_form_item($form->id, $form_item);
        }
    } //.$form->id

} //.isset($_POST['form'])


if (isset($_GET['status'])) {
    if ($_GET['status'] != $form->status) {
        if ($_GET['status'] == '0' OR $_GET['status'] == '1') {
            if (update_form($form->id, array('update' => array('status' => $_GET['status']), 'add_alert' => false))) {
                $db = db();
                $db->query("UPDATE " . dbname('form_items') . " SET status = {$_GET['status']} WHERE `form_id` = {$form->id}");
            }
        }
    }
} //.isset($_GET['status'])


if (isset($_GET['delete_form_item'])) {
    delete_form_item($form->id, $_GET['delete_form_item']);
}


if ($form->id) {
    calc_form($form->id);
    calc_account($form->account_id);
    $form = get_form($form->id);
    $form_meta = get_form_meta($form->id);
}
?>




<?php if (@$form->status == '0' AND $form->id): ?>
    <?php echo get_alert('<i class="fa fa-trash-o"></i> <b>تحذير!</b> النموذج غير نشط.', 'warning', false); ?>
    <div class="h-20 visible-xs"></div>
<?php else: ?>
    <?php create_modal(array('id' => 'status_item',
        'title' => 'حذف النموذج',
        'content' => _b($form->id) . ' هل تريد تعطيل نموذج رقم التعريف? <br /> <small> من قاعدة البيانات <u>متعذر محوه</u>. ولكن لا يمكن العثور عليها في عمليات البحث وقوائم البيانات.</small>',
        'btn' => '<a href="?id=' . $form->id . '&status=0" class="btn btn-danger">نعم، أوافق</a>')); ?>

<?php endif; ?>

<ul class="nav nav-tabs til-nav-page" role="tablist">
    <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab"
                                              aria-controls="home" aria-expanded="true"><i
                    class="fa fa-file-text-o"></i><span class="hidden-xs"> نموذج</span></a></li>
    <?php if ($form->id): ?>
        <li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs"
                                            aria-expanded="false"><i class="fa fa-database"></i><span class="hidden-xs"> تاريخ</span></a>
        </li>

        <li role="presentation" class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle"
                                                                              id="myTabDrop1" data-toggle="dropdown"
                                                                              aria-controls="myTabDrop1-contents"
                                                                              aria-expanded="false"><i
                        class="fa fa-cogs"></i><span class="hidden-xs"> خيارات</span> <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="<?php site_url('admin/user/task/add.php?attachment&form_id=' . $form->id); ?>"
                       target="_blank"><i class="fa fa-tasks fa-fw"></i> إلحاق المهمة</a></li>
                <li><a href="<?php site_url('admin/user/message/add.php?attachment&form_id=' . $form->id); ?>"
                       target="_blank"><i class="fa fa-envelope-o fa-fw"></i> إضافة مرفق الرسالة</a></li>
                <li role="separator" class="divider"></li>
                <?php if ($form->status == '1'): ?>
                    <li><a href="#" data-toggle="modal" data-target="#status_item"><i
                                    class="fa fa-trash-o fa-fw text-danger"></i> حذف</a></li>
                <?php else: ?>
                    <li><a href="?id=<?php echo $form->id; ?>&status=1"><i class="fa fa-undo fa-fw text-success"></i>
                            نشط</a></li>
                <?php endif; ?>
            </ul>
        </li>

        <li role="presentation" class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle"
                                                                              id="myTabDrop1" data-toggle="dropdown"
                                                                              aria-controls="myTabDrop1-contents"
                                                                              aria-expanded="false"><i
                        class="fa fa-print"></i><span class="hidden-xs"> طباعة</span> <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="print.php?id=<?php echo $form->id; ?>&print" target="_blank"><i
                                class="fa fa-fw fa-file-text-o"></i> نموذج الطباعة</a></li>
                <li><a href="print.php?id=<?php echo $form->id; ?>&print&showBarcode" target="_blank"><i
                                class="fa fa-fw fa-file-text-o"></i> طباعة فاتورة باركود</a></li>
                <li><a href="print-invoice.php?id=<?php echo $form->id; ?>&print" target="_blank"><i
                                class="fa fa-fw fa-file-archive-o"></i> طباعة الفاتورة</a></li>
            </ul>
        </li>

        <li role="presentation" class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle"
                                                                              id="myTabDrop1" data-toggle="dropdown"
                                                                              aria-controls="myTabDrop1-contents"
                                                                              aria-expanded="false"><i
                        class="fa fa-square" style="color:<?php echo $form_status->bg_color; ?>"></i>
                <span class="hidden-xs"><?php echo $form_status->name; ?></span>
                <span class="visible-xs-inline hidden-xs-portrait"><?php echo $form_status->name; ?></span>
                <span class="visible-xs-inline hidden-xs-landscape"><?php echo til_get_abbreviation($form_status->name); ?></span>
                <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <?php if ($form_status_all): ?>
                    <?php foreach ($form_status_all as $status): ?>
                        <li>
                            <a href="?id=<?php echo $form->id; ?>&status_id=<?php echo $status->id; ?>&update_status_id&uniquetime=<?php uniquetime(); ?>"><i
                                        class="fa fa-square" style="color:<?php echo $status->bg_color; ?>"></i>
                                &nbsp; <?php echo $status->name; ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
</ul>


<div class="tab-content">
    <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">

        <?php
        if ($accountNotFound) {
            echo get_alert('المستفيد غير مسجل في قاعدة البيانات', 'danger', false);
        }

        print_alert('set_form');
        if (isset($_GET['update_status_id'])) {
            print_alert('change_form_status');
        }
        ?>
        <form name="form_add_accout" id="form_add_account"
              action="<?php if ($form->id): ?>?id=<?php echo $form->id; ?><?php else: ?><?php endif; ?>" method="POST"
              class="validate">

            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label for="date"><i class="fa fa-calendar"></i> التاريخ </label>
                        <input type="text" name="date" id="date" value="<?php echo @substr($form->date, 0, 16); ?>"
                               class="form-control input-sm datetime">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
                <div class="col-xs-6 col-md-5">
                    <div class="form-group">
                        <label for="note"><i class="fa fa-pencil"></i> البيان <sup class="text-muted hidden-xs">*بإمكانك
                                كتابة اي شئ حول هذه الفاتورة لتذكرها بشكل اسهل</sup> </label>
                        <input type="text" name="note" id="note" value="<?php echo @$form_meta->note; ?>"
                               class="form-control input-sm" maxlength="128" dir="auto">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_fathername">اسم الاب </label>
                        <input type="text" name="account_fathername" id="account_fathername"
                               value="<?php echo @$form->account_fathername; ?>" class="form-control input-sm"
                               maxlength="32">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-2 -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_countrynumber"> الرقم الوطني </label>
                        <input type="tel" name="account_countrynumber" id="account_countrynumber"
                               value="<?php echo @$form->account_countrynumber; ?>" class="form-control input-sm"
                               maxlength="32">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-2 -->
            </div> <!-- /.row -->

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="account_code"><i class="fa fa-barcode"></i> كود الحساب </label>
                        <input type="text" name="account_code" id="account_code"
                               value="<?php echo @$form->account_code; ?>" class="form-control input-sm" maxlength="32">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-3 -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="account_name">اسم الحساب <?php if (@$form->account_id): ?><a
                                href="../account/detail.php?id=<?php echo $form->account_id; ?>" target="_blank"><i
                                            class="fa fa-external-link"></i></a><?php endif; ?> </label>
                        <label id="new_account" class="pull-right" data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="هل تريد اضافة حساب جديد"><input type="checkbox" name="new_account"
                                                                                    id="new_account" value="true"
                                                                                    data-toggle="switch"
                                                                                    switch-size="xs" on-text="نعم"
                                                                                    off-text="لا"></label>
                        <input type="text" name="account_name" id="account_name"
                               value="<?php echo @$form->account_name; ?>" class="form-control input-sm" maxlength="32">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-3 -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_gsm">الهاتف المحمول </label>
                        <input type="tel" name="account_gsm" id="account_gsm" value="<?php echo @$form->account_gsm; ?>"
                               class="form-control input-sm" maxlength="32">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-2 -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_Retardationtype">نوع الاعاقة </label>
                        <input type="text" name="account_Retardationtype" id="account_Retardationtype"
                               value="<?php echo @$form->account_Retardationtype; ?>" class="form-control input-sm">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-3 -->
                <div class="col-xs-12 col-md-2">
                    <div class="form-group">
                        <label for="account_Retardationnum"> رقم بطاقة الاعاقة </label>
                        <input type="tel" name="account_Retardationnum" id="account_Retardationnum"
                               value="<?php echo @$form->account_Retardationnum; ?>" class="form-control input-sm ">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-3 -->

                <div class="clearfix"></div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="account_address">العنوان </label>
                        <input type="text" name="account_address" id="account_address"
                               value="<?php echo @$form_meta->address; ?>" class="form-control input-sm">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_district">الحالة الاجتماعية </label>
                        <input type="text" name="account_district" id="account_district"
                               value="<?php echo @$form_meta->district; ?>" class="form-control input-sm">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
                <div class="col-xs-6 col-md-2">
                    <div class="form-group">
                        <label for="account_mo3el"> المعيل </label>
                        <input type="text" name="account_mo3el" id="account_mo3el"
                               value="<?php echo @$form->account_mo3el; ?>" class="form-control input-sm">
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
                <div class="col-xs-6 col-md-2 hidden-xs">
                    <div class="form-group country_selected">
                        <label for="account_country">البلد </label>
                        <?php echo list_selectbox(get_country_array(), array('name' => 'account_country', 'selected' => 'SYRIAN ARAB REPUBLIC', 'class' => 'form-control select select-account input-sm')); ?>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col- -->
            </div> <!-- /.row -->


            <div class="text-right">
                <input type="hidden" name="in_out" value="<?php echo $form->in_out; ?>">
                <input type="hidden" name="account_id" id="account_id" value="<?php echo @$form->account_id; ?>">
                <input type="hidden" name="form">
                <input type="hidden" name="uniquetime" value="<?php echo microtime(true); ?>">
            </div>

            <script>
                $(document).ready(function () {

                    var json_url = '<?php site_url("admin/account/getJSON.php"); ?>';
                    var item = {
                        name: '<span class="account_name">[TEXT]</span>',
                        gsm: '<span class="pull-right text-muted">[TEXT]</span>',
                        "br": "<br />",
                        "": "المستفيد موجود في قاعدة البيانات",
                        city: '<span class="account_city pull-right">[TEXT]</span>'
                    }

                    input_getJSON_account('#account_code', 'account', item, json_url, 'code');
                    input_getJSON_account('#account_name', 'account', item, json_url, 'name');

                    var item = {
                        "name": '<span class="account_name">[TEXT]</span>',
                        "br": "<br /> &nbsp;",
                        "gsm": '<span class="pull-right text-muted">[TEXT]</span>'
                    }
                    input_getJSON_account('#account_gsm', 'account', item, json_url, 'gsm');

                    var item = {
                        "name": '<span class="account_name">[TEXT]</span>',
                        "br": "<br /> &nbsp;",
                        "phone": '<span class="pull-right text-muted">[TEXT]</span>'
                    }
                    input_getJSON_account('#account_phone', 'account', item, json_url, 'phone');

                    var item = {
                        "name": '<span class="account_name">[TEXT]</span>',
                        "br": "<br /> &nbsp;",
                        "email": '<span class="pull-right text-muted">[TEXT]</span>'
                    }
                    input_getJSON_account('#account_email', 'account', item, json_url, 'email');

                    var item = {
                        "name": '<span class="account_name">[TEXT]</span>',
                        "br": "<br /> &nbsp;",
                        "tax_no": '<span class="pull-right text-muted">[TEXT]</span>'
                    }
                    input_getJSON_account('#account_tax_no', 'account', item, json_url, 'tax_no');


                    $('#account_code').change(function () {
                        $('#account_id').val('');
                        account_id_change($('#account_id').val());
                    });


                    $('#account_id').change(function () {
                        account_id_change($(this).val());
                    });

                    <?php if(@$form->account_id): ?>
                    account_id_change('x');
                    <?php endif; ?>

                });

                <?php if(@$form_meta->country): ?>
                $('#account_country').val("<?php echo $form_meta->country; ?>");
                <?php endif; ?>

                function account_getJSON_click(param) {
                    var id = $(param).attr('data-id');
                    var code = $(param).attr('data-code');
                    var name = $(param).attr('data-name');
                    var gsm = $(param).attr('data-gsm');
                    var Retardationtype = $(param).attr('data-Retardationtype');
                    var Retardationnum = $(param).attr('data-Retardationnum');
                    var countrynumber = $(param).attr('data-countrynumber');
                    var fathername = $(param).attr('data-fathername');
                    var address = $(param).attr('data-address');
                    var district = $(param).attr('data-district');
                    var mo3el = $(param).attr('data-mo3el');
                    var country = $(param).attr('data-country');

                    $('#account_id').val(id);
                    $('#account_code').val(code);
                    $('#account_name').val(name);
                    $('#account_gsm').val(gsm);
                    $('#account_Retardationtype').val(Retardationtype);
                    $('#account_Retardationnum').val(Retardationnum);
                    $('#account_countrynumber').val(countrynumber);
                    $('#account_fathername').val(fathername);
                    $('#account_address').val(address);
                    $('#account_district').val(district);
                    $('#account_mo3el').val(mo3el);
                    $('#account_gsm').val(gsm);
                    $('#account_country').val(country);

                    // country
                    $('.select-account').val(country);
                    $('.select-account').change();

                    account_id_change($('#account_id').val());

                    $('#item_code').focus();


                }

                function account_id_change(val) {
                    if (val == '') {
                        $('#new_account').show();
                    } else {
                        $('#new_account').hide();
                    }
                }


            </script>


            <div class="clearfix"></div>
            <div class="h-20"></div>


            <div class="panel panel-default panel-table mobile-full" id="form_items">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><i class="fa fa-file-text-o"></i> اصناف المعونة</h3>
                        </div> <!-- /.col- -->
                        <div class="col-md-6">
                            <div class="pull-right">

                            </div>
                        </div> <!-- /.col- -->
                    </div> <!-- /.row -->
                </div> <!-- /.panel-heading -->

                <?php $form_items = get_form_items($form->id); ?>
                <?php if (is_alert('add_form_item') or is_alert('delete_form_item')): ?>
                    <div class="not-found">
                    <?php print_alert('add_form_item'); ?><?php print_alert('delete_form_item'); ?></div> <?php endif; ?>
                <style>table thead tr.border-none td {
                        border: 0px !important;
                    }</style>
                <table class="table table-condensed table-striped table-hover table-bordered">
                    <thead>
                    <tr class="border-none">
                        <td>
                            <label>&nbsp;</label>
                            <input type="hidden" name="item_id" id="item_id" value="">
                            <input type="hidden" name="item_uniquetime" id="item_uniquetime"
                                   value="<?php echo microtime(true); ?>">
                            <button class="btn btn-default" id="add_item"><i class="fa fa-plus"></i></button>
                        </td>
                        <td width="50%" class="hidden-xs-portrait">
                            <div class="form-group">
                                <label for="item_code"><i class="fa fa-barcode hidden-xs"></i><span class="visible-xs">الكود</span>
                                    <span class="hidden-xs">باركود المعونة او المساعدة</span></label>
                                <input type="text" name="item_code" id="item_code" class="form-control input-sm">
                            </div> <!-- /.form-group -->
                        </td>

                        <td width="50%">
                            <div class="form-group">
                                <label for="item_name"><span class="visible-xs">الاسم</span><span class="hidden-xs">اسم  المعونة او المساعدة</span></label>
                                <input type="text" name="item_name" id="item_name" class="form-control input-sm">

                            </div> <!-- /.form-group -->

                        </td>
                        <td class="hidden">
                            <div class="form-group hidden">
                                <label for="quantity">العدد</label>
                                <input type="hidden" name="quantity" value="1" id="quantity"
                                       class="form-control input-sm calc_item">
                            </div> <!-- /.form-group -->
                        </td>
                        <td>
                            <div class="form-group hidden">
                                <label for="price">س.افرادي</label>
                                <input type="hidden" pattern="[0-9]+([\.,][0-9]+)?" name="price" id="price" value="0"
                                       class="form-control input-sm money calc_item">
                            </div> <!-- /.form-group -->
                        </td>
                        <td class="hidden">
                            <div class="form-group">
                                <label for="total">س.إجمالي</label>
                                <input type="hidden" value="0" min="0" name="total" id="total"
                                       class="form-control input-sm money calc_item">
                            </div> <!-- /.form-group -->
                        </td>
                        <td class="hidden">
                            <div class="form-group">
                                <label for="item_vat">VAT</label>
                                <input type="hidden" value="0" name="vat" id="vat"
                                       class="form-control input-sm calc_item">
                            </div> <!-- /.form-group -->
                        </td>
                        <td class="hidden">
                            <div class="form-group">
                                <label for="vat_total"><span class="hidden-xs">T.VAT</span><span
                                            class="visible-xs fs-11">T.VAT</span></label>
                                <input type="hidden" value="0" min="0" name="vat_total" id="vat_total"
                                       class="form-control input-sm money calc_item">
                            </div> <!-- /.form-group -->
                        </td>
                        <td class="hidden">
                            <div class="form-group hidden">
                                <label for="col_total"><span class="hidden-xs">المجموع</span><span class="visible-xs">المجموع</span></label>
                                <input type="hidden" value="0" name="col_total" id="col_total"
                                       class="form-control input-sm money">
                            </div> <!-- /.form-group -->
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($form_items): ?>
                        <?php
                        $total_vat = 0;
                        ?>
                        <?php foreach ($form_items->list as $item): ?>
                            <tr class="<?php echo @$_GET['flashItemID'] == $item->item_id ? 'flashItemID' : ''; ?>">
                                <td class="text-center"><a
                                            href="?id=<?php echo $form->id; ?>&delete_form_item=<?php echo $item->id; ?>#form_items"
                                            title="حذف"><i class="fa fa-trash"></i></a></td>
                                <td class="hidden-xs-portrait"><?php echo $item->item_code; ?></td>
                                <td><?php echo $item->item_name; ?></td>
                                <td class="hidden"><?php echo $item->quantity; ?></td>
                                <td class="hidden"><?php echo get_set_money($item->price, true); ?></td>
                                <td class="hidden hidden-xs"><?php echo get_set_money($item->total, true); ?></td>
                                <td class="hidden text-muted hidden-xs"><?php echo $item->vat; ?></td>
                                <td class="hidden text-muted hidden-xs"><?php echo get_set_money($item->vat_total, true); ?></td>
                                <td class="hidden"><?php echo get_set_money($item->total, true); ?></td>
                            </tr>
                            <?php $total_vat = $total_vat + $item->vat_total; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <?php if (til_is_mobile()): ?>
                        <tr class="fs-12">
                            <th class="text-center text-muted"><?php echo @$form->item_count; ?></th>
                            <th colspan="2"></th>
                            <th class="hidden text-center"><?php echo @$form->item_quantity; ?></th>
                            <th class="hidden text-right text-muted hidden-xs"><?php echo get_set_money(@$total_vat, true); ?></th>
                            <th colspan="2"
                                class=" hidden text-right fs-12"><?php echo get_set_money(@$form->total, true); ?></th>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th class="hidden text-center text-muted"><?php echo @$form->item_count; ?></th>
                            <th colspan="2"></th>
                            <th class="hidden text-center"><?php echo @$form->item_quantity; ?></th>
                            <th colspan="3"></th>
                            <th class="hidden text-right text-muted hidden-xs"><?php echo get_set_money(@$total_vat, true); ?></th>
                            <th class="hidden text-right"><?php echo get_set_money(@$form->total, true); ?></th>
                        </tr>
                    <?php endif; ?>
                    </tfoot>
                </table>
            </div> <!-- /.panel -->

            <style>
                .flashItemID td {
                    animation: alertloginError 300ms infinite;
                    animation-iteration-count: 4;
                }


                @keyframes alertloginError {
                    0% {
                        background-color: transparent;
                    }
                    100% {
                        background-color: #ddd;
                    }
                }
            </style>

            <div class="btn-group btn-group-sm" style="margin: 15px 0;">
                <?php
                $prefix = _prefix;
                $db_result = $db->query("SELECT name, code FROM `{$prefix}items` LIMIT 50000")->fetch_all(MYSQLI_ASSOC);
                foreach ($db_result as $key => $item) :
                    ?>
                    <a class="btn btn-primary" href="javascript:void(0);" data-toggle="js-fill-input"
                       data-code="<?= $item['code']; ?>" data-name="<?= $item['name']; ?>">
                        <?= $item['name']; ?>
                    </a>
                <?php
                endforeach;
                ?>

            </div>

            <div class="text-right">
                <div class="h-20 visible-xs"></div>
                <button class="btn btn-success btn-xs-block btn-insert btn-save"><i class="fa fa-floppy-o"></i> حفظ
                </button>
                <a class="btn btn-warning" href="<?php site_url("admin/form/detail.php?in"); ?>"><i
                            class="fa fa-floppy-o"></i>توزيع جديد</a>
            </div><!-- /.text-right -->


            <script>
                $(document).ready(function () {

                    var json_url = '<?php site_url("admin/item/getJSON.php"); ?>';
                    var item = {
                        name: '<span class="item_name">[TEXT]</span>',
                        "": "<br />",
                        quantity: '<span class="text-muted item_quantity">[TEXT]</span>',
                        p_sale: '<span class="item_price pull-right">[TEXT]</span>'
                    }

                    input_getJSON_account('#item_code', 'item', item, json_url, 'code');
                    input_getJSON_account('#item_name', 'item', item, json_url, 'name');

                    $('.calc_item').keyup(function () {
                        calc_item();
                    });


                    $('#item_code').change(function () {
                        $('#item_id').val('');
                    });

                });

                function item_getJSON_click(param) {
                    var id = $(param).attr('data-id');
                    var code = $(param).attr('data-code');
                    var name = $(param).attr('data-name');
                    var p_purc = $(param).attr('data-p_purc');
                    var p_sale = $(param).attr('data-p_sale');
                    var p_purch_out_vat = $(param).attr('data-p_purch_out_vat');
                    var p_sale_out_vat = $(param).attr('data-p_sale_out_vat');
                    var vat = $(param).attr('data-vat');


                    $('#item_id').val(id);
                    $('#item_code').val(code);
                    $('#item_name').val(name);
                    <?php if($form->in_out == 0): ?>
                    $('#price').val(p_purc);
                    <?php else: ?>
                    $('#price').val(p_sale);
                    <?php endif; ?>
                    $('#vat').val(vat);

                    calc_item();

                    $('#price').focus();
                }

                function calc_item() {
                    var quantity = $('#quantity').val();
                    var price = $('#price').val();
                    var vat = math_vat_rate($('#vat').val());


                    if (!$.isNumeric(quantity)) {
                        quantity = 1;
                    }
                    if (!$.isNumeric(price)) {
                        price = 0.00;
                    }
                    if (!$.isNumeric(vat)) {
                        vat = 0;
                    }


                    var total = quantity * parseFloat(price);
                    var vat_total = total - (parseFloat(total) / vat);
                    var col_total = parseFloat(total);

                    $('#total').val(total);
                    $('#vat_total').val(vat_total);
                    $('#col_total').val(col_total);

                }
            </script>
        </form>

        <div class="clearfix"></div>
        <div class="h-20"></div>


    </div>

    <script>
        $(document).ready(function () {
            $('#btn1').click(function (evens) {
                $('#calc_form').submit(evens);
                evens.preventDefault();
                const literValue = $('[name="num1"]'),
                    tanaka = $('[name="num2"]'),
                    discount = $('[name="num3"]'),
                    liter_price = $('[name="num4"]'),
                    total_price = $('[name="num5"]'),
                    dolar = $('[name="num6"]'),
                    totalDolar = $('[name="num7"]');


                liter_price.val((tanaka.val() - discount.val()) / 20);
                total_price.val(literValue.val() * liter_price.val());

                if (dolar.val()) {
                    totalDolar.val(total_price.val() / dolar.val());

                }

                var totalDolarInt = parseInt(totalDolar.val());
                $('[name="note"]').val(
                    tanaka.val() + " * " + discount.val()
                    + " * " + dolar.val() + " * $" + totalDolarInt
                );
                $('[name="price"]').val(
                    liter_price.val()
                );
                $('[name="quantity"]').val(
                    literValue.val()
                );

            })

        });

    </script>
    <script>
        $(document).ready(function () {
            $('#btn2').click(function (evens) {
                $('#calc_form2').submit(evens);
                evens.preventDefault();
                const literValue2 = $('[name="num11"]'),
                    tanaka2 = $('[name="num22"]'),
                    discount2 = $('[name="num33"]'),
                    liter_price2 = $('[name="num44"]'),
                    total_price2 = $('[name="num55"]'),
                    dolar2 = $('[name="num66"]'),
                    totalDolar2 = $('[name="num77"]');


                liter_price2.val((tanaka2.val() / 20) * dolar2.val());
                total_price2.val(literValue2.val() * liter_price2.val());

                if (dolar2.val()) {
                    totalDolar2.val(total_price2.val() / dolar2.val());

                }

                var totalDolar2Int = parseInt(totalDolar2.val());
                $('[name="note"]').val(
                    tanaka2.val() + " * " + discount2.val()
                    + " * " + dolar2.val() + " * $" + totalDolar2Int
                );
                $('[name="price"]').val(
                    liter_price2.val()
                );
                $('[name="quantity"]').val(
                    literValue2.val()
                );

            })

        });
    </script>
    <script>
        $(document).ready(function () {
            $('.calc_price2').hide();
            $('#calc_type').change(function () {
                if ($(this).val() == 2) {
                    $('.calc_price2').show();
                    $('.calc_price1').hide();
                } else {
                    $('.calc_price2').hide();
                    $('.calc_price1').show();
                }
            });

            $('[data-toggle="js-fill-input"]').on('click', function () {
                var clicked = $(this);
                $('[name="item_name"]').val(clicked.attr('data-name'));
                $('[name="item_code"]').val(clicked.attr('data-code'));
                $('#add_item').click();
            });
        });
    </script>
    <!-- tab:logs -->
    <div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab">
        <?php theme_get_logs(" table_id='forms:" . $form->id . "' "); ?>
    </div>
    <!-- /tab:logs -->

    <?php get_footer(); ?>
