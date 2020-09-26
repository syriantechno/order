<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'قائمة الموظفين');
add_page_info('nav', array('name' => 'الموظفين', 'url' => get_site_url('admin/user/index.php')));
add_page_info('nav', array('name' => 'قائمة الموظفين'));
?>

<?php
$users = get_users();
?>

<div class="mobile-full">
    <table class="table table-hover table-stripedd table-condensed dataTable">
        <thead class="hidden-xs">
        <tr>
            <th>الاسم الأول والأخير</th>
            <th class="hidden-xs-portrait">البريد الإلكتروني</th>
            <th width="250">الهاتف المحمول</th>
            <th width="100" class="hidden-xs-portrait">الرتبة</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $list): ?>
            <tr onclick="window.location = '<?php site_url('admin/user/user.php'); ?>?id=<?php echo $list->id; ?>'; "
                class="pointer">
                <td><img src="<?php echo get_user_info($list->id, 'avatar'); ?>"
                         class="img-responsive img-32 br-5 inline-block"> <?php echo $list->username; ?> <?php echo $list->surname; ?>
                </td>
                <td class="hidden-xs-portrait"><a
                            href="<?php site_url('admin/user/user.php'); ?>?id=<?php echo $list->id; ?>"><?php echo $list->email; ?></a>
                </td>
                <td><?php echo $list->gsm; ?></td>
                <td class="hidden-xs-portrait"><?php echo get_user_role_text($list->role); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php get_footer(); ?>
