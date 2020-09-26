<?php include('../../ultra.php'); ?>

<link href="<?php echo template_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/ultra.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/app.css'); ?>" rel="stylesheet">
<link href="<?php echo template_url('css/print.css'); ?>" rel="stylesheet">

<?php

// جميع المعلومات من المستخدم النشط
$user = get_user($_GET['id']);
@$user_meta = get_user_meta($user->id);

?>

<title>CV - <?php echo $user->display_name; ?></title>

<div class="print-page" size="A4">


    <div class="print-ultra-logo">
        <img src="<?php site_url('content/themes/default/img/logo_blank.png'); ?>" class="img-responsive">
    </div>

    <div class="row">
        <div class="col-xs-4">
            <img src="<?php echo $user->avatar; ?>" class="img-responsive" style="width:100%;">

            <div class="h-20"></div>

            <table class="table table-condensed table-condensed">
                <tr>
                    <td class="bold">رقم الهوية</td>
                    <td><?php echo $user->citizenship_no; ?></td>
                </tr>
                <tr>
                    <td class="bold">الجنس</td>
                    <td><?php echo $user->gender ? 'رجل' : 'سيدة'; ?></td>
                </tr>
                <tr>
                    <td class="bold" width="100">Adı</td>
                    <td><?php echo $user->name; ?></td>
                </tr>
                <tr>
                    <td class="bold">اللقب / الشهرة</td>
                    <td><?php echo $user->surname; ?></td>
                </tr>
                <tr>
                    <td class="bold">تاريخ الميلاد</td>
                    <td><?php echo @$user_meta['date_birth']; ?></td>
                </tr>
                <tr>
                    <td class="bold">مكان الميلاد</td>
                    <td><?php echo @$user_meta['birthplace']; ?></td>
                </tr>
                <?php if (@$user_meta['blood_group']): ?>
                    <tr>
                    <td class="bold">فصيلة الدم</td>
                    <td><?php echo @$user_meta['blood_group']; ?></td></tr><?php endif; ?>
                <tr>
                    <td class="bold">الخليوي</td>
                    <td><?php echo $user->gsm; ?></td>
                </tr>
                <?php if (!empty(@$user_meta['driving_license'])): ?>
                    <tr>
                        <td class="bold">رخصة القيادة</td>
                        <td><?php echo implode(", ", @$user_meta['driving_license']); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty(@$user_meta['src'])): ?>
                    <tr>
                        <td class="bold">SRC</td>
                        <td><?php echo implode(", ", @$user_meta['src']); ?></td>
                    </tr>
                <?php endif; ?>
            </table>

            <h4 class="content-title title-line text-danger">معلومات العائلة</h4>
            <table class="table table-condensed table-condensed">
                <tr>
                    <td class="bold">اسم الأب</td>
                    <td><?php echo @$user_meta['father_name']; ?></td>
                </tr>
                <tr>
                    <td class="bold">اسم الام</td>
                    <td><?php echo @$user_meta['mother_name']; ?></td>
                </tr>
                <?php if (@$user_meta['is_married']): ?>
                    <tr>
                        <td class="bold" width="100">الحالة المدنية</td>
                        <td><?php echo _get_usermeta_is_married(@$user_meta['is_married']); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (@$user_meta['spouses_name']): ?>
                    <tr>
                        <td class="bold">اسم زوجتك</td>
                        <td><?php echo @$user_meta['spouses_name']; ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (@$user_meta['children_count']): ?>
                    <tr>
                        <td class="bold">عدد الأطفال</td>
                        <td><?php echo @$user_meta['children_count']; ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (@$user_meta['humble_person_count']): ?>
                    <tr>
                        <td colspan="2">خارج الأسرة <b><?php echo @$user_meta['humble_person_count']; ?></b> المعالين من
                            الأشخاص.
                        </td>
                    </tr>
                <?php endif; ?>
            </table>


            <?php if (@$user_meta['unhealthy']): ?>
                <h4 class="content-title title-line text-danger">معاق</h4>
                <table class="table table-condensed table-condensed">
                    <tr>
                        <td class="bold" width="100">درجة الاعاقة</td>
                        <td><?php echo @$user_meta['unhealthy_type']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold">درجة</td>
                        <td><?php echo @$user_meta['unhealthy_degree']; ?></td>
                    </tr>
                </table>
            <?php endif; ?>


            <?php if (@$user_meta['prison']): ?>
                <h4 class="content-title title-line text-danger">محكوم</h4>
                <table class="table table-condensed table-condensed">
                    <tr>
                        <td class="bold" width="100">وقت</td>
                        <td><?php echo @$user_meta['prison_year']; ?> Yıl <?php echo @$user_meta['prison_month']; ?>
                            Ay
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">البيان</td>
                        <td><?php echo @$user_meta['prison_desc']; ?></td>
                    </tr>
                </table>
            <?php endif; ?>

            <?php if (@$user_meta['terror']): ?>
                <h4 class="content-title title-line text-danger">ضحايا الإرهاب</h4>
                <table class="table table-condensed table-condensed">
                    <tr>
                        <td class="bold" width="100">قرب</td>
                        <td><?php echo @$user_meta['terror_type']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold">البيان</td>
                        <td><?php echo @$user_meta['terror_desc']; ?></td>
                    </tr>
                </table>
            <?php endif; ?>


        </div> <!-- /.col-md-4 -->
        <div class="col-xs-8">

            <div class="pull-right">
                <img src="<?php barcode_url('TILU-' . $user->id); ?>"/>
                <br/>
                <span class="pull-right mr-15"><?php echo 'TILU-' . $user->id; ?></span>
            </div>

            <h4 class="content-title"><?php echo $user->name; ?> <?php echo $user->surname; ?>
                <small class="pull"><?php echo $user->username; ?></small>
            </h4>
            <?php echo @$user_meta['address']; ?> <?php echo @$user_meta['district']; ?>
            /<?php echo @$user_meta['city']; ?>

            <div class="h-20"></div>

            <?php if (isset($user_meta['school']) and !empty(@$user_meta['school'])): ?>
                <h4 class="content-title">الموهلات التعليمية</h4>
                <table class="table table-condensed">
                    <tr>
                    <tr>
                        <th>مستوى</th>
                        <th>اسم المنظمة</th>
                        <th>قسم</th>
                        <th>تاريخ الشهادة</th>
                        <th>نتيجة</th>
                    </tr>
                    </tr>
                    <?php foreach (@$user_meta['school'] as $school): ?>
                        <tr>
                            <td><?php echo _get_usermeta_school_text($school->school_level); ?></td>
                            <td><?php echo $school->school_name; ?></td>
                            <td><?php echo $school->school_department; ?></td>
                            <td><?php echo $school->school_graduation_year; ?></td>
                            <td><?php echo $school->school_grade; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>


            <?php if (isset($user_meta['language']) and !empty(@$user_meta['language'])): ?>
                <h4 class="content-title">اللغات الأجنبية</h4>
                <table class="table table-condensed">
                    <tr>
                    <tr>
                        <th>Dil</th>
                        <th>قراءة</th>
                        <th>كتابة</th>
                        <th>خطاب</th>
                    </tr>
                    </tr>
                    <?php foreach (@$user_meta['language'] as $lang): ?>
                        <tr>
                            <td><?php echo $lang->lang_lang; ?></td>
                            <td><?php echo _get_usermeta_lang_text($lang->lang_reading); ?></td>
                            <td><?php echo _get_usermeta_lang_text($lang->lang_writing); ?></td>
                            <td><?php echo _get_usermeta_lang_text($lang->lang_talk); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>


            <?php if (isset($user_meta['work']) and !empty(@$user_meta['work'])): ?>
                <h4 class="content-title">الخبرة في العمل</h4>
                <table class="table table-condensed">
                    <tr>
                    <tr>
                        <th width="80">وقت</th>
                        <th width="80">موقف</th>
                        <th width="120">اسم الشركة</th>
                        <th>البيان</th>
                    </tr>
                    </tr>
                    <?php foreach (@$user_meta['work'] as $work): ?>
                        <tr>
                            <td>
                                <small><?php echo _get_usermeta_work_level_text($work->work_level); ?></small>
                                <br/>
                                <small><?php echo $work->work_end_date; ?>
                                    - <?php echo $work->work_start_date; ?></small>
                            </td>
                            <td><?php echo $work->work_position; ?></td>
                            <td><?php echo $work->work_company_name; ?></td>
                            <td><?php echo $work->work_description; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>


            <?php if (isset($user_meta['reference']) and !empty(@$user_meta['reference'])): ?>
                <h4 class="content-title">Referanslar</h4>
                <table class="table table-condensed">
                    <tr>
                    <tr>
                        <th width="120">الاسم الأول والأخير</th>
                        <th width="">اسم الشركة</th>
                        <th width="100">هاتف</th>
                    </tr>
                    </tr>
                    <?php foreach (@$user_meta['reference'] as $reference): ?>
                        <tr>
                            <td><?php echo $reference->ref_name_surname; ?></td>
                            <td><?php echo $reference->ref_company; ?></td>
                            <td><?php echo $reference->ref_phone; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>


            <h4 class="content-title">معلومات إضافية</h4>
            <table class="table table-condensed">
                <tr>
                    <td width="85%">هل تدخن?</td>
                    <td width="15%"><?php echo @$user_meta['smoking'] ? 'لا' : 'نعم'; ?></td>
                </tr>
                <tr>
                    <td width="85%">هل هناك إعاقة سفر?</td>
                    <td width="15%"><?php echo @$user_meta['travel_ban'] ? 'لا' : 'نعم'; ?></td>
                </tr>
                <tr>
                    <td width="85%">هل يمكنه العمل الإضافي?</td>
                    <td width="15%"><?php echo @$user_meta['work_overtime'] ? 'لا' : 'نعم'; ?></td>
                </tr>
                <tr>
                    <td width="85%">يمكن أن تعمل في الليل?</td>
                    <td width="15%"><?php echo @$user_meta['work_night'] ? 'لا' : 'نعم'; ?></td>
                </tr>
            </table>


            <?php if (@$user_meta['military_status']): ?>
                <h4 class="content-title">الوضع العسكري</h4>
                <table class="table table-condensed">
                    <tr>
                        <td width="85%">الوضع العسكري</td>
                        <td width="15%"><?php echo _get_usermeta_military_status(@$user_meta['military_status']); ?></td>
                    </tr>
                    <?php if (@$user_meta['military_end_date']): ?>
                        <tr>
                            <td>تاريخ انتهاء الخدمة</td>
                            <td><?php echo @$user_meta['military_end_date']; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (@$user_meta['military_postponed']): ?>
                        <tr>
                            <td>تاريخ التاجيل</td>
                            <td><?php echo @$user_meta['military_postponed']; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (@$user_meta['military_exempt']): ?>
                        <tr>
                            <td colspan="2"><?php echo @$user_meta['military_exempt']; ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>


            <?php if (@$user_meta['emergency']): ?>
                <h4 class="content-title">في حالات الطوارئ</h4>
                <table class="table table-condensed">
                    <?php foreach (@$user_meta['emergency'] as $emergency): ?>
                        <tr>
                            <td width="50%"><?php echo $emergency->emergency_name; ?></td>
                            <td width="25%"><?php echo $emergency->emergency_relative; ?></td>
                            <td width="25%"><?php echo $emergency->emergency_phone; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>


        </div> <!-- /.col-md-8 -->
    </div> <!-- /.row -->


    <div class="print-footer print-footer-right text-center">
        <small class="text-muted">أؤكد دقة المعلومات الواردة أعلاه.</small>
        <br/>
        <small><?php echo $user->name; ?><?php echo $user->surname; ?></small>
        <br/>
        <small class="text-muted">توقيع</small>
    </div>


    <div class="print-footer print-footer-left">
        <small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>"
                                       class="img-responsive pull-left" width="64"> برمجيات مفتوحة المصدر.
        </small>
    </div>


</div> <!-- /.print-page -->


