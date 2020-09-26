<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>


<?php
add_page_info('title', 'صندوق الرسائل - الوارد');
add_page_info('nav', array('name' => 'صندوق الرسائل'));

## mesja kutusu secimi ve sayfa bilgilendirme
if (isset($_GET['box'])) {
    $box = 'inbox';
    if ($_GET['box'] == 'inbox') {
        $box = 'inbox';
        add_page_info('title', 'صندوق الرسائل - الوارد');
    } elseif ($_GET['box'] == 'outbox') {
        $box = 'outbox';
        add_page_info('title', 'صندوق الرسائل - المحفوظة');
    } elseif ($_GET['box'] == 'trash') {
        $box = 'trash';
        add_page_info('title', 'صندوق الرسائل - المحذوفة');
    }
} else {
    $box = 'inbox';
}


## mesajı çöp kutusuna taşıma
if (isset($_GET['move']) and isset($_GET['id'])) {
    if ($message = get_message($_GET['id'])) {

        if ($_GET['move'] == 'trash') {
            if ($message->sen_u_id == get_active_user('id')) {
                $set = "sen_trash_u_id='" . get_active_user('id') . "'";
            }
            if ($message->rec_u_id == get_active_user('id')) {
                $set = "rec_trash_u_id='" . get_active_user('id') . "'";
            }

            if ($q_update = db()->query("UPDATE " . dbname('messages') . " SET " . $set . " WHERE id='" . input_check($_GET['id']) . "'")) {
                add_alert(_b($message->title) . ' موضوع الرسالة <i class="fa fa-trash-o"></i> في سلة المهملات <span class="underline">انتقل</span>.', 'warning');
            }
        } else {

            if ($message->sen_trash_u_id == get_active_user('id')) {
                $set = "sen_trash_u_id='0'";
            }
            if ($message->rec_trash_u_id == get_active_user('id')) {
                $set = "rec_trash_u_id='0'";
            }
            if (@$set) {
                if ($q_update = db()->query("UPDATE " . dbname('messages') . " SET " . $set . " WHERE id='" . input_check($_GET['id']) . "'")) {
                    add_alert(_b($message->title) . ' موضوع الرسالة <i class="fa fa-trash-o"></i> من سلة المهملات <span class="underline">إزالة</span>.', 'warning');
                }
            }
        }
    }
}


### mesajlari veritabanından cekme

# mesajlar okunmus veya okunmamis
if (isset($_GET['read_it'])) {
    if ($_GET['read_it'] == '0' OR $_GET['read_it'] == '1') {
        $read_it = input_check($_GET['read_it']);
    } else {
        echo get_alert('"read_it" القيمة "0" أو "1" لا بد وأن.', 'warning', false);
    }
}


# mesajlari cekelim
$args = array();
if (isset($read_it)) {
    $argss['read_it'] = $read_it;
}
if ($box == 'inbox') {
    if (@!$read_it) {
        $args['query'] = _get_query_message('inbox');
    }
    if (isset($read_it)) {
        if ($read_it == '0') {
            $args['query'] = _get_query_message('inbox-unread');
        }
        if ($read_it == '1') {
            $args['query'] = $args['query'] = _get_query_message('inbox-read');
        }
    }
} elseif ($box == 'outbox') {
    $args['query'] = _get_query_message('outbox');
} else {
    $args['query'] = _get_query_message('trash');
}


$messages = get_messages($args);
?>


<div class="row">
    <div class="col-md-3 hidden-xs">

        <?php include('_sidebar.php'); ?>

    </div> <!-- /.col-md-3 -->
    <div class="col-md-9">
        <?php print_alert(); ?>

        <div class="panel panel-default panel-table panel-dataTable">
            <?php if ($messages): ?>
                <table class="table table-hover table-condensed table-striped dataTable">
                    <thead class="none">
                    <tr>
                        <th width="10"></th>
                        <th width="180"><?php echo $box == 'inbox' ? 'مرسل' : 'المتلقي'; ?></th>
                        <th class="hidden-xs-portrait">موضوع</th>
                        <th width="100">التاريخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($messages as $list): ?>
                        <?php
                        $sub_message_count = false;
                        $args = array();
                        $args['top_id'] = $list->id;

                        if ($sub_messages = db()->query("SELECT * FROM " . dbname('messages') . " " . sql_where_string($args) . " ")) {
                            if ($sub_messages->num_rows) {
                                $sub_message_count = $sub_messages->num_rows;
                            }
                        }
                        ?>
                        <tr class="<?php if (!$list->read_it AND $list->inbox_u_id == get_active_user('id') AND $box != 'outbox'): ?>bold<?php endif; ?> pointer"
                            onclick="location.href='<?php site_url('message', $list->id); ?>';">
                            <td width="10" class="hidden-xs">
                                <?php if ($box == 'trash'): ?>
                                    <a href="?id=<?php echo $list->id; ?>&move=null&box=trash"
                                       class="btn btn-default btn-xs" data-toggle="tooltip"
                                       title="أخرجه من سلة المهملات"><i class="fa fa-undo"></i></a>
                                <?php else: ?>
                                    <a href="?id=<?php echo $list->id; ?>&move=trash" class="btn btn-default btn-xs"
                                       data-toggle="tooltip" title="ارسال الى سلة المحذوفات"><i
                                                class="fa fa-trash-o text-danger"></i></a>
                                <?php endif; ?>
                            </td>

                            <td width="220" class="">
                                <?php if ($list->inbox_u_id == get_active_user('id')): ?>
                                    <div class="pull-left" style="margin-right:5px;">
                                        <img src="<?php echo get_user_info($list->outbox_u_id, 'avatar'); ?>"
                                             class="img-responsive br-2 pull-right" width="25">
                                    </div>
                                    <?php echo get_user_info($list->outbox_u_id, 'display_name'); ?>
                                    <?php if ($sub_message_count): ?>(<?php echo $sub_message_count; ?>)<?php endif; ?>
                                <?php else: ?>
                                    <div class="pull-left" style="margin-right:5px;">
                                        <img src="<?php echo get_user_info($list->inbox_u_id, 'avatar'); ?>"
                                             class="img-responsive br-2 pull-right" width="25">
                                    </div>
                                    <?php echo get_user_info($list->inbox_u_id, 'display_name'); ?>
                                    <?php if ($sub_message_count): ?>(<?php echo $sub_message_count; ?>)<?php endif; ?>
                                <?php endif; ?>

                                <div class="visible-xs-portrait hidden-md hidden-xs-landscape small"><?php echo get_time_late($list->date_update); ?></div>
                            </td>

                            <td>
                                <?php if (!$list->read_it): ?>
                                    <i class="fa fa-envelope-o mr-3" data-toggle="tooltip" title="غير مقروء!"></i>
                                <?php else: ?>
                                    <i class="fa fa-envelope-open-o mr-3 text-muted" data-toggle="tooltip"
                                       title="مقروء"></i>
                                <?php endif; ?>

                                <a href="detail.php?id=<?php echo $list->id; ?>">
                                    <span class="text-black"><?php echo $list->title; ?> <?php if (!strlen($list->title)): ?>#<?php echo $list->id; ?><?php endif; ?></span>
                                    <?php if ($q_select = db()->query("SELECT * FROM " . dbname('messages') . " WHERE top_id='" . $list->id . "' ORDER BY date_update DESC LIMIT 1")) : ?>
                                        <?php if ($q_select->num_rows) : $sub_message = $q_select->fetch_object(); ?>
                                            <span class="text-muted hidden-portrait"><b>-</b> <span
                                                        class="underline"><?php echo _b(til_get_strtolower(get_user_info($sub_message->sen_u_id, 'surname')), false); ?></span>: <?php echo mb_substr(strip_tags($sub_message->message), 0, 80, 'utf-8'); ?><?php if (strlen($sub_message->message) > 80): ?>...<?php endif; ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </td>

                            <td width="100"
                                class="text-right hidden-xs-portrait"><?php echo get_time_late($list->date_update); ?>
                                منذ
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="not-found">
                    <?php echo get_alert('مربع الرسالة فارغ.', 'warning', false); ?>
                </div>
            <?php endif; ?>
        </div> <!-- /.panel -->
    </div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php get_footer(); ?>
