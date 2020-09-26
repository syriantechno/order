<?php
/* --------------------------------------------------- ACCOUNT */


/**
 * add_account()
 */
function add_account($args)
{

    if (!have_log()) {

        $args = _args_helper(input_check($args), 'insert');
        $insert = $args['insert'];

        @form_validation($insert['code'], 'code', 'رمز الباركود', 'min_length[3]|max_length[32]', __FUNCTION__);
        @form_validation($insert['name'], 'name', 'اسم الحساب', 'required|min_length[3]|max_length[32]', __FUNCTION__);
        @form_validation($insert['countrynumber'], 'countrynumber', 'الرقم الوطني', 'min_length[3]|max_length[100]', __FUNCTION__);
        @form_validation($insert['fathername'], 'fathername', 'اسم الاب', 'max_length[100]', __FUNCTION__);
        @form_validation($insert['gsm'], 'gsm', 'الهاتف المحمول', 'gsm', __FUNCTION__);
        @form_validation($insert['DateofBirth'], 'DateofBirth', ' تاريخ الميلاد', 'min_length[3]|max_length[25]', __FUNCTION__);
        @form_validation($insert['address'], 'address', 'العنوان', 'min_length[3]|max_length[255]', __FUNCTION__);
        @form_validation($insert['district'], 'district', 'مقاطعة', 'min_length[3]|max_length[25]', __FUNCTION__);
        @form_validation($insert['city'], 'city', 'المدينة', 'min_length[3]|max_length[25]', __FUNCTION__);
        @form_validation($insert['Retardationtype'], 'Retardationtype', 'نوع الاعاقة', 'min_length[3]|max_length[25]', __FUNCTION__);
        @form_validation($insert['Retardationnum'], 'Retardationnum', ' رقم الاعاقة', 'min_length[3]|max_length[25]', __FUNCTION__);


        if (!isset($insert['type'])) {
            $insert['type'] = 'account';
        } else {
            $insert['type'] = input_check($insert['type']);
        }
        if (!isset($insert['date'])) {
            $insert['date'] = date('Y-m-d H:i:s');
        }
        if (empty($insert['code'])) {
            $insert['code'] = get_account_code_generator();
        }

        if (!is_alert(__FUNCTION__, 'danger')) {

            $q_is_code = db()->query("SELECT * FROM " . dbname('accounts') . " WHERE code='" . $insert['code'] . "' ");
            if ($q_is_code->num_rows) {
                $q_is_code = $q_is_code->fetch_object();

                if ($args['add_alert']) {
                    add_alert('<b>' . $insert['code'] . '</b> تم العثور على رمز الحساب على بطاقة حساب أخرى. يرجى تغيير رمز الحساب أو <a href="' . get_site_url('admin/account/detail.php?id=' . $q_is_code->id) . '" target="_blank"><b>هنا</b></a> استخدام حساب.', 'warning', 'add_account');
                }
                if ($q_is_code->status == '1') {
                    if ($args['add_alert']) {
                        add_alert('<u>أيضا، تم العثور على هذا الرمز بين بطاقات الحساب المحذوفة</u>. بطاقة حسابك <a href="' . get_site_url('admin/account/detail.php?id=' . $q_is_code->id) . '"><b>من هنا</b></a> يمكنك تفعيله مرة أخرى.', 'warning', 'add_account');
                    }
                }

                return false;
            } else {

                if (isset($insert['name'])) {
                    $insert['name'] = til_get_strtoupper($insert['name']);
                }
                if (isset($insert['address'])) {
                    $insert['address'] = til_get_strtoupper($insert['address']);
                }

                if (isset($insert['district'])) {
                    $insert['district'] = til_get_strtoupper($insert['district']);
                }
                if (isset($insert['country'])) {
                    $insert['country'] = til_get_strtoupper($insert['country']);
                }


                if (db()->query("INSERT INTO " . dbname('accounts') . " " . sql_insert_string($insert) . " ")) {
                    $insert_id = db()->insert_id;
                    if ($args['add_alert']) {
                        add_alert('تمت إضافة بطاقة حساب جديدة.', 'success', 'add_account');
                    }
                    if ($args['add_log']) {
                        add_log(array('uniquetime' => @$insert['uniquetime'], 'table_id' => 'accounts:' . $insert_id, 'log_key' => 'add_account', 'log_text' => 'تمت إضافة بطاقة الحساب.'));
                    }
                    return $insert_id;
                } else {
                    add_mysqli_error_log(__FUNCTION__);
                }

                return false;
            } // $q_is_code->num_rows


        } else {
            return false;
        } // !is_alert()
    } else {
        repetitive_operation(__FUNCTION__);
    } // !have_log()
}

function get_account($args, $_til = true)
{

    if (!is_array($args)) {
        $args = array('where' => array('id' => $args));
    }
    $args = _args_helper(input_check($args), 'where');
    $where = $args['where'];

    if (isset($where['id']) and $_til) {
        if (isset(til()->accounts[$where['id']])) {
            return til()->accounts[$where['id']];
        }
    }

    if ($query = db()->query("SELECT * FROM " . dbname('accounts') . " " . sql_where_string($where) . " ")) {
        if ($query->num_rows) {
            $return = _return_helper($args['return'], $query);
            til()->accounts[$return->id] = $return;
            return $return;
        } else {
            if ($args['add_alert']) {
                add_alert('لم يتم العثور على بطاقة حساب تطابق المعايير التي تبحث عنها.', 'warning', __FUNCTION__);
            }
            return false;
        }
    } else {
        add_mysqli_error_log(__FUNCTION__);
    }
}

function update_account($where, $args)
{

    $where = input_check($where);
    $args = _args_helper(input_check($args), 'update');
    $update = $args['update'];

    if (isset($update['id'])) {
        unset($update['id']);
    }


    if (!have_log()) {
        if ($old_account = get_account($where)) {

            if (!isset($update['code'])) {
                $update['code'] = $old_account->code;
            }
            if (!isset($update['name'])) {
                $update['name'] = $old_account->name;
            }
            if (!isset($update['gsm'])) {
                $update['gsm'] = $old_account->gsm;
            }

            @form_validation($update['code'], 'code', 'كود الحساب', 'min_length[3]|max_length[32]', 'update_account');
            @form_validation($update['name'], 'name', 'اسم الحساب', 'required|min_length[3]|max_length[50]', 'update_account');
            @form_validation($update['email'], 'email', 'البريد الالكتروني', 'email', 'update_account');

            @form_validation($update['gsm'], 'gsm', 'الهاتف المحمول', 'gsm', 'update_account');
            @form_validation($update['phone'], 'phone', 'الهاتف الثابت', 'number|min_length[10]|max_length[11]', 'update_account');
            @form_validation($update['address'], 'address', 'العنوان', 'max_length[250]', 'update_account');
            @form_validation($update['district'], 'district', 'المقاطعة', 'max_length[20]', 'update_account');
            @form_validation($update['city'], 'city', 'البلد', 'max_length[20]', 'update_account');
            @form_validation($update['tax_home'], 'tax_home', 'مكتب الضرائب', 'max_length[50]', 'update_account');
            @form_validation($update['tax_no'], 'tax_no', 'الرقم الضريبي', 'number|max_length[20]', 'update_account');


            if (!is_alert(__FUNCTION__, 'danger')) {


                if (!isset($update['type'])) {
                    $update['type'] = 'account';
                } else {
                    $update['type'] = $update['type'];
                }

                if (empty($update['code']) and strlen($old_account->code) < 1) {
                    $update['code'] = get_account_code_generator($old_account->id);
                }


                $q_is_code = db()->query("SELECT * FROM " . dbname('accounts') . " WHERE code='" . $update['code'] . "' AND id NOT IN ('" . $old_account->id . "')");
                if ($q_is_code->num_rows) {
                    $q_is_code = $q_is_code->fetch_object();

                    if ($args['add_alert']) {
                        add_alert('<b>' . $update['code'] . '</b> تم العثور على رمز الحساب على بطاقة حساب أخرى. يرجى تغيير رمز الحساب أو <a href="' . get_site_url('admin/account/detail.php?id=' . $q_is_code->id) . '" target="_blank"><b>هنا</b></a> استخدام حساب.', 'warning', 'update_account');
                    }
                    if ($q_is_code->status == '0') {
                        if ($args['add_alert']) {
                            add_alert('<u>أيضا، تم العثور على هذا الرمز في بطاقات الحساب المحذوفة</u>. بطاقة حسابك <a href="' . get_site_url('admin/account/detail.php?id=' . $q_is_code->id) . '"><b>buradan</b></a> يمكنك تفعيله مرة أخرى.', 'warning', 'update_account');
                        }
                    }
                    return false;
                } else {


                    if (isset($update['name'])) {
                        $update['name'] = til_get_strtoupper($update['name']);
                    }
                    if (isset($update['address'])) {
                        $update['address'] = til_get_strtoupper($update['address']);
                    }
                    if (isset($update['city'])) {
                        $update['city'] = til_get_strtoupper($update['city']);
                    }
                    if (isset($update['district'])) {
                        $update['district'] = til_get_strtoupper($update['district']);
                    }
                    if (isset($update['country'])) {
                        $update['country'] = til_get_strtoupper($update['country']);
                    }
                    if (isset($update['tax_home'])) {
                        $update['tax_home'] = til_get_strtoupper($update['tax_home']);
                    }
                    if (isset($update['email'])) {
                        $update['email'] = til_get_strtolower($update['email']);
                    }

                    if (db()->query("UPDATE " . dbname('accounts') . " SET " . sql_update_string($update) . " WHERE id='" . $old_account->id . "' ")) {
                        if (db()->affected_rows > 0) {
                            $new_account = get_account($old_account->id);
                            if ($args['add_alert']) {
                                add_alert('تم تحديث بطاقة الحساب.', 'success', 'update_account');
                            }
                            if ($args['add_log']) {
                                add_log(array('table_id' => 'accounts:' . $old_account->id, 'log_key' => 'update_account', 'log_text' => 'تم تحديث بطاقة الحساب.', 'meta' => log_compare($old_account, $new_account)));
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        add_mysqli_error_log(__FUNCTION__);
                    }
                }


                return true;
            } else {
                return false;
            }
        }
    } else {
        repetitive_operation(__FUNCTION__);
    } // !have_log()
} //.update_account()


/**
 * get_accounts()
 */
function get_accounts($args = array())
{
    $return = new StdClass;

    $query_str = '';
    $query_str_real = '';

    // required
    $args = get_ARR_helper_limit_AND_orderby($args);
    if (!isset($args['status'])) {
        $args['status'] = '1';
    } else {
        $args['status'] = input_check($args['status']);
    }

    /// query string
    $query_str = "SELECT id FROM " . dbname('accounts') . " WHERE status='" . $args['status'] . "' ";


    if (isset($args['s'])) {
        if ($args['db-s-where'] == 'all') {
            $query_str .= "AND ( name LIKE '%" . $args['s'] . "%' ";
            $query_str .= "OR code LIKE '%" . $args['s'] . "%' ";
            $query_str .= "OR gsm LIKE '%" . $args['s'] . "%' ";
            $query_str .= "OR phone LIKE '%" . $args['s'] . "%' ";
            $query_str .= ")";
        } else {
            $query_str .= "AND ( " . $args['db-s-where'] . " LIKE '%" . $args['s'] . "%' ) ";
        }
    }


    $query_str_real = $query_str;

    if (isset($args['orderby_name']) and isset($args['orderby_type'])) {
        $query_str_real .= "ORDER BY " . $args['orderby_name'] . " " . $args['orderby_type'];
    }


    if ($args['limit'] > 1) {
        $query_str_real .= " LIMIT " . $args['page'] . "," . $args['limit'] . " ";
    }
    if (isset($args['select'])) {
        $query_str_real = str_replace('SELECT id', 'SELECT ' . $args['select'], $query_str_real);
    } else {
        $query_str_real = str_replace('SELECT id', 'SELECT *', $query_str_real);
    }


    if ($query = db()->query($query_str)) {
        if ($return->num_rows = $query->num_rows) {
            $query = db()->query($query_str_real);
            $return->display_num_rows = $query->num_rows;

            while ($account = $query->fetch_object()) {
                $return->list[] = $account;
            }

            return $return;
        } else {
            add_alert('لم يتم العثور على بطاقات الحساب التي تطابق المعايير التي تبحث عنها.', 'warning', 'get_accounts');
            return false;
        }
    } else {
        $error_msg = db()->error;
        add_alert('<b>خطأ في قاعدة البيانات:</b> ' . $error_msg, 'danger', 'get_accounts');
        add_log(array('log_key' => 'mysqli_error', 'log_text' => $error_msg));
        return false;
    }

}


/**
 * calc_account()
 */
function calc_account($id)
{
    if ($account = get_account($id)) {
        $in = 0;
        $out = 0;


        if ($q_select_sum = db()->query("SELECT sum(total) as total,sum(profit) as profit FROM " . dbname('forms') . " WHERE status='1' AND type IN ('form', 'salary') AND in_out='0' AND account_id='" . $account->id . "' ")) {
            if ($q_select_sum->num_rows) {
                $in = $q_select_sum->fetch_object();
            }
        } else {
            add_mysqli_error_log(__FUNCTION__);
        }


        if ($q_select_sum = db()->query("SELECT sum(total) as total,sum(profit) as profit FROM " . dbname('forms') . " WHERE status='1' AND type IN ('form', 'salary') AND in_out='1' AND account_id='" . $account->id . "' ")) {
            if ($q_select_sum->num_rows) {
                $out = $q_select_sum->fetch_object();
            }
        } else {
            add_mysqli_error_log(__FUNCTION__);
        }


        $balance = $out->total - $in->total;


        if ($q_select_sum = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='payment' AND in_out='0' AND account_id='" . $account->id . "' ")) {
            if ($q_select_sum->num_rows) {
                $in_payment = $q_select_sum->fetch_object();
                $balance = $balance - $in_payment->total;
            }
        } else {
            add_mysqli_error_log(__FUNCTION__);
        }


        if ($q_select_sum = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND type='payment' AND in_out='1' AND account_id='" . $account->id . "' ")) {
            if ($q_select_sum->num_rows) {
                $out_payment = $q_select_sum->fetch_object();
                $balance = $balance + $out_payment->total;
            }
        } else {
            add_mysqli_error_log(__FUNCTION__);
        }


        if ($q_update = db()->query("UPDATE " . dbname('accounts') . " SET 
			balance='" . $balance . "',
			profit='" . $out->profit . "'
			WHERE id='" . $account->id . "' ")) {
            return true;
        } else {
            return false;
        }

    } else {
        add_alert($id . ' أرقام الهوية بطاقة الحساب غير موجودة.', 'warning', __FUNCTION__);
        return false;
    }
} //.calc_account()


/**
 * get_account_code_generator()
 *
 */
function get_account_code_generator($account_id = '', $type = 'Retardation-')
{
    $generator = true;
    if ($account_id > 0) {
        $code = $type . '-' . $account_id;
        $query = db()->query("SELECT id FROM " . dbname('accounts') . " WHERE code='" . $code . "' AND id NOT IN ('" . $account_id . "') ");
        if ($query->num_rows) {
            $generator = true;
        } else {
            $generator = false;
            return $code;
        }
    }
    if ($generator == true) {
        $query = db()->query("SELECT id FROM " . dbname('accounts') . " ORDER BY id DESC LIMIT 1 ");
        $query = $query->fetch_object();
        return $type . '-' . (@$query->id + 1);
    }

}


?>