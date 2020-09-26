<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php


$_taxonomy = 'til_fs_form';
$_name = 'Form';
$_in_out = true;
$_sms_template = true;
$_email_template = true;
$_color = true;
$_bg_color = true;

if (isset($_GET['taxonomy'])) {
    if (is_form_status($_GET['taxonomy'])) {
        $_taxonomy = til()->form_status[$_GET['taxonomy']]['taxonomy'];
        $_name = til()->form_status[$_GET['taxonomy']]['name'];
        $_in_out = til()->form_status[$_GET['taxonomy']]['in_out'];
        $_sms_template = til()->form_status[$_GET['taxonomy']]['sms_template'];
        $_email_template = til()->form_status[$_GET['taxonomy']]['email_template'];
        $_color = til()->form_status[$_GET['taxonomy']]['color'];
        $_bg_color = til()->form_status[$_GET['taxonomy']]['bg_color'];
    } else {
        echo get_alert('لم يتم العثور على نوع حالة النموذج.', 'danger');
        exit;
    }
}

add_page_info('title', $_name . ' form');
add_page_info('nav', array('name' => 'خيارات', 'url' => get_site_url('admin/system/')));
add_page_info('nav', array('name' => 'إدارة حالة النموذج', 'url' => get_site_url('admin/system/form_status')));
?>


<?php if (isset($_GET['detail'])): ?>
    <?php include('_detail.php'); ?>
<?php else: ?>
    <?php include('_add.php'); ?>
<?php endif; ?>

<?php get_footer(); ?>1