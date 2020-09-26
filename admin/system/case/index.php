<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php


$_taxonomy = 'til_case';

_set_case_default(); //  حساب الصندوق الافتراضي والبنك الافتراضي

add_page_info('title', 'الصندوق والبنك');
add_page_info('nav', array('name' => 'المدفوعات', 'url' => get_site_url('admin/payment/')));
?>


<?php if (isset($_GET['detail'])): ?>
    <?php include('_detail.php'); ?>
<?php else: ?>
    <?php include('_add.php'); ?>
<?php endif; ?>


<?php get_footer(); ?>