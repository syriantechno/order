<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'معلومات عنا');
add_page_info('nav', array('name' => 'Seçenekler', 'url' => get_site_url('admin/system/')));
add_page_info('nav', array('name' => 'Hakkımızda'));
?>
<style media="screen">
    .breadcrumb-header {
        display: none;
    }
</style>

<h1 style="font-weight: 300;">معتمد من قبل Louai ALshaaer!</h1>
<div class="h-20 hidden-lg"></div>

<ul class="nav nav-pills mb-3" role="tablist">
    <li role="presentation" class="active"><a href="#team" onclick="document.title='المبرمجون | ultra'" id="team-tab"
                                              aria-controls="team" role="tab" data-toggle="tab" aria-expanded="false">المبرمجون</a>
    </li>
    <li role="presentation" class=""><a href="#terms-of-use" onclick="document.title='شروط الاستخدام | ultra'"
                                        id="terms-of-use-tab" aria-controls="terms-of-use" role="tab" data-toggle="tab"
                                        aria-expanded="false">شروط الاستخدام</a></li>
</ul>


<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="team" aria-labelledby="team-tab">

        <style media="screen">
            .team-area {
                max-width: 1150px;
                padding: 20px 0;
            }

            .sociail-nav {
                margin-left: -5px;
                position: absolute;
                bottom: 10px;
            }

            .sociail-nav > li > a {
                padding: 5px 10px;
            }

            .developer-area {
                border: 1px solid #ccc;
                border-radius: 3px;
                padding: 10px;
                min-height: 105px;
            }

            .developer-area .avatar-area {
                width: 82px;
                display: inline-block;
                float: left;
                margin-right: 0px;
            }

            .developer-area .info-area {
                width: auto;
                display: inline-block;
            }


            @media (max-width: 767px) {
                .sociail-nav {
                    margin-left: -5px;
                    margin-right: -5px;
                }

                .sociail-nav > li {
                    display: inline-block;
                }

                .sociail-nav > li > a {
                    padding: 5px !important;
                }

                .team-area {
                    width: 100%;
                }

                .developer-area .avatar-area {
                    width: 25%;
                    margin-right: 10px;
                }
            }

            .twitter {
                color: #00aced
            }

            .facebook {
                color: #3b5998
            }

            .googleplus {
                color: #dd4b39
            }

            .pinterest {
                color: #cb2027
            }

            .linkedin {
                color: #007bb6
            }

            .youtube {
                color: #bb0000
            }

            .instagram {
                color: #bc2a8d
            }

            .dribbble {
                color: #ea4c89
            }

            .wordpress {
                color: #21759b
            }
        </style>

        <div style="team-area">
            <div class="row">
                <div class="col-md-4">
                    <div class="developer-area">
                        <div class="avatar-area">
                            <img src="<?php echo template_url('img/loay.jpg'); ?> " alt="" class="img-responsive">
                        </div><!--/ .avatar-area /-->

                        <div class="info-area">
                            <strong>Louai ALshaaer</strong>
                            <p><i>Web developer</i></p>

                            <ul class="nav navbar-nav sociail-nav">
                                <li><a href="https://www.facebook.com/louai.alshaaer" class="facebook"
                                       data-wenk="facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href=" https://wa.me/0096176404750" class="whatsapp" data-wenk="whatsapp"><i
                                                class="fa fa-whatsapp"></i></a></li>
                                <li><a href="#" class="" data-wenk="0096176404750"><i class="fa fa-phone"></i></a></li>
                            </ul>
                        </div><!--/ .info-area /-->
                    </div><!--/ .developer-area /-->
                </div><!--/ .col-md-4 /-->

                <div class="clearfix hidden-md"></div>
                <div class="h-20 hidden-md"></div>


                <div class="clearfix hidden-md"></div>
                <div class="h-20 hidden-md"></div>


            </div><!--/ .row /-->
        </div><!--/ .team-area /-->
    </div><!--/ .tab-panel /-->


    <div role="tabpanel" class="tab-pane" id="terms-of-use" aria-labelledby="terms-of-use-tab">
        <p> البرنامج خاضع لاتفاقية البرامج المفتوحة المصدر GNU General Public License لايجوز بيعه او نقله تحت اي ظرف او
            اي شكل من الاشكال</p>
        <p>لاتقم بتعديل السورس كود ابدا اتصل بالمبرمج واطلب منه التعديل المناسب / قد يتسبب التعديل من قبلك باتلاف
            البيانات</p>  <!--/ Terms Of Use /-->
        <p>البرنامج يعمل على PHP7 و Mysql 5.6 و Apache Server 2.4 يفضل تركيب سيرفر Ampps</p>
        <p>البرنامج مصمم بناَءعلى طلب خاص من الجمعية وفق البيانات الازمة التي تتوافق معها</p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
    </div><!--/ .tab-panel /-->
</div>
<?php get_footer(); ?>
