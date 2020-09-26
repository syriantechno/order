<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>

<?php
add_page_info('title', 'إدارة المهام');
add_page_info('nav', array('name' => 'إدارة المهام'));


# gorev kutusu
if (isset($_GET['box'])) {
    $box = 'inbox';
    if ($_GET['box'] == 'inbox') {
        $box = 'inbox';
        add_page_info('title', 'صندوق المهام - قادم');
    } elseif ($_GET['box'] == 'outbox') {
        $box = 'outbox';
        add_page_info('title', 'صندوق المهام - المنتهية');
    } elseif ($_GET['box'] == 'trash') {
        $box = 'trash';
        add_page_info('title', 'صندوق المهام - محذوفات');
    }
} else {
    $box = 'inbox';
}

# durum bilgisi
if (isset($_GET['type_status'])) {
    $type_status = input_check($_GET['type_status']);
}


## gorev silme veya aktif etme
if (isset($_GET['move'])) {
    if ($task = get_task($_GET['id'])) {
        $_args = array();

        # cop kutusuna tasi
        if ($_GET['move'] == 'trash') { // انتقل إلى مربع الشرطي
            if ($task->sen_u_id == get_active_user('id')) {
                $_args['sen_trash_u_id'] = get_active_user('id');
            } elseif ($task->rec_u_id == get_active_user('id')) {
                $_args['rec_trash_u_id'] = get_active_user('id');
            } else {
                til_exit(__LINE__);
            }
        } else { // cop kutusundan cikar
            if ($task->sen_trash_u_id == get_active_user('id')) {
                $_args['sen_trash_u_id'] = '0';
            } elseif ($task->rec_trash_u_id == get_active_user('id')) {
                $_args['rec_trash_u_id'] = '0';
            }
        }


        if (db()->query("UPDATE " . dbname('messages') . " SET " . sql_update_string($_args) . " WHERE id='" . $task->id . "'")) {
            if (db()->affected_rows) {
                if ($_GET['move'] == 'trash') {
                    add_alert(_b($task->title) . ' في الخدمة <i class="fa fa-trash"></i> في صندوق المهملات <span class="underline">انتقل</span>.', 'warning', false);
                } else {
                    add_alert(_b($task->title) . ' في الخدمة <i class="fa fa-trash"></i> في صندوق المهملات <span class="underline">تمت إزالته</span>.', 'warning', false);
                }
            }
        }

    } else {
        add_alert('لم يتم العثور على معرف المهمة.', 'warning', false);
    }
}


## gorevleri cagir
$_args = array();
if ($box == 'inbox') {
    if (!isset($type_status)) {
        $_args['query'] = _get_query_task('inbox');
    } else {
        if ($type_status == '0') {
            $_args['query'] = _get_query_task('inbox-open');
        } elseif ($type_status == '1') {
            $_args['query'] = _get_query_task('inbox-close');
        }
    }
} elseif ($box == 'outbox') {
    if (!isset($type_status)) {
        $_args['query'] = _get_query_task('outbox');
    } else {
        if ($type_status == '0') {
            $_args['query'] = _get_query_task('outbox-open');
        } elseif ($type_status == '1') {
            $_args['query'] = _get_query_task('outbox-close');
        }
    }
} elseif ($box == 'trash') {
    $_args['query'] = _get_query_task('trash');
} else {
    $_args['query'] = get_query_task('inbox');
}

$tasks = get_tasks($_args);
?>


<div class="row">
    <div class="col-md-3 hidden-xs">

        <?php include('_sidebar.php'); ?>

    </div> <!-- /.col-md-3 -->

    <div class="col-md-9">
        <?php print_alert(); ?>
        <div class="panel panel-default panel-table panel-dataTable">
            <?php if ($tasks): ?>
                <table class="table table-hover table-task table-striped table-condensed dataTable">
                    <thead class="hidden">
                    <tr>
                        <th></th>
                        <th>حالة</th>
                        <th>Atayan</th>
                        <th>تعيين</th>
                        <th>موضوع</th>
                        <th>بداية</th>
                        <th>اللمسات الأخيرة</th>
                        <th>شريط</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <?php $task = get_task($task->id); ?>
                        <?php
                        if ($task->choice_count) {
                            $part = (100 / $task->choice_count);
                            $part_completed = round($part * $task->choice_closed);

                            # progress-bar style
                            $progressbar_style = '';
                            if ($part_completed < 30) {
                                $progressbar_style = 'progress-bar-danger';
                            } elseif ($part_completed < 70) {
                                $progressbar_style = 'progress-bar-warning';
                            } else {
                                $progressbar_style = 'progress-bar-success';
                            }
                        }
                        ?>
                        <tr mobile-progress-width="100" mobile-progress-style="<?php echo $progressbar_style; ?>"
                            class="<?php if (!$task->read_it and $task->inbox_u_id == get_active_user('id')): ?>bold<?php endif; ?> pointer"
                            onclick="location.href='<?php site_url('task', $task->id); ?>';">
                            <td width="10" class="hiddden-xs">
                                <?php if ($task->type_status == '1'): ?>
                                    <?php if ($task->sen_trash_u_id == get_active_user('id') OR $task->rec_trash_u_id == get_active_user('id')): ?>
                                        <a href="?id=<?php echo $task->id; ?>&move=null&box=trash"
                                           class="btn btn-default btn-xs" data-toggle="tooltip"
                                           title="إزالة من المهملات"><i class="fa fa-undo text-warning"></i></a>
                                    <?php else: ?>
                                        <a href="?id=<?php echo $task->id; ?>&move=trash" class="btn btn-default btn-xs"
                                           data-toggle="tooltip" title="ارسال الى سلة المحذوفات"><i
                                                    class="fa fa-trash-o text-danger"></i></a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="#" class="btn btn-default btn-xs disabled" title=""><i
                                                class="fa fa-trash text-muted"></i></a>
                                <?php endif; ?>
                            </td>
                            <td width="40"><?php echo $task->type_status == '0' ? 'فتح' : 'مغلقة'; ?></td>
                            <td width="140">
                                <div class="pull-left" style="margin-right:5px;">
                                    <img src="<?php user_info($task->sen_u_id, 'avatar'); ?>"
                                         class="img-responsive br-2 pull-right" width="21">
                                </div>
                                <?php user_info($task->sen_u_id, 'surname'); ?>
                            </td>
                            <td width="140">
                                <div class="pull-left" style="margin-right:5px;">
                                    <img src="<?php user_info($task->rec_u_id, 'avatar'); ?>"
                                         class="img-responsive br-2 pull-right" width="21">
                                </div>
                                <?php user_info($task->rec_u_id, 'surname'); ?>
                            </td>
                            <td class="hidden-xs-portrait visible-xs-landscape"><a
                                        href="<?php site_url('task', $task->id); ?>"><?php echo $task->title; ?></td>
                            <td class="hidden-xs"><?php echo til_get_date($task->date_start, 'datetime'); ?></td>
                            <td class="visible-xs-landscape"><?php echo til_get_date($task->date_end, 'datetime'); ?></td>
                            <td class="hidden-xs">
                                <?php if ($task->choice_count): ?>
                                    <div class="progress m-0 br-2">
                                        <div class="progress-bar progress-bar-stripedd <?php echo $progressbar_style; ?> text-muted"
                                             role="progressbar" aria-valuenow="<?php echo $part_completed; ?>"
                                             aria-valuemin="30" aria-valuemax="100"
                                             style="width: <?php echo($part_completed == '0' ? '25' : $part_completed); ?>%;">
                                            <span class="sr-only"><?php echo $part_completed; ?>% الانتهاء</span>
                                            %<?php echo $part_completed; ?> الانتهاء
                                        </div> <!-- /.progess-bar -->
                                    </div> <!-- /.progress -->

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="not-found">
                    <?php echo get_alert('لم يتم العثور على مهمة المهمة.', 'warning', false); ?>
                </div>
            <?php endif; ?>
        </div> <!-- /.panel -->
    </div> <!-- /.col-md-9 -->
</div> <!-- /.row -->


<?php get_footer(); ?>
