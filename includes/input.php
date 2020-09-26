<?php

/* --------------------------------------------------- INPUT */


function is_currency($val)
{
    $r = preg_match("/^-?([0-9]{1,3}+,?)?([0-9]{1,3}+,?)?([0-9]{1,3}+,?)?[0-9]{1,3}+(?:\.[0-9]{1,19})?$/", $val);
    return $r;
} //.is_currency()


function is_email($val)
{
    if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
} //.is_email()


function get_set_decimal_db($val)
{
    return str_replace(',', '', $val);
}


function set_decimal_db($val)
{
    echo get_set_decimal_db($val);
} //.set_decimal_db()

function get_set_gsm($val)
{
    if (strlen($val) > 6) {
        return false;
    }
    if (strlen($val) < 5) {
        return false;
    }

    if (strlen($val) == 6) {
        if (substr($val, 0, 1) == 0) {
            $val = substr($val, 1);
        }
    }
    return $val;
}


function get_set_show_phone($val)
{
    if (strlen($val) > 6) {
        return $val;
    }
    if (strlen($val) < 5) {
        return $val;
    }

    if (strlen($val) == 6) {
        if (substr($val, 0, 1) == 0) {
            $val = substr($val, 1);
        }
    }


    return '0 (' . substr($val, 0, 3) . ') ' . substr($val, 3, 3) . ' ' . substr($val, 6);
}


function form_validation($val, $input_name = '', $name = '', $options = array(), $alert_name = 'form')
{
    global $til;


    if (!is_array($options)) {
        $explode = explode('|', $options);

        foreach ($explode as $exp) {


            if ($exp == 'required') {
                if (empty($val)) {
                    add_alert('<b>' . $name . '</b> لا يمكن ترك حقل النص فارغا.', 'danger', $alert_name, $input_name);
                }
            } else if (strstr($exp, 'min_length') AND mb_strlen($val, 'utf-8') > 0) {
                $min_length = str_replace(']', '', str_replace('min_length[', '', $exp));
                if (mb_strlen($val, 'utf-8') < $min_length) {
                    add_alert('<b>' . $name . '</b> منطقة الكتابة الحد الأدنى ' . $min_length . ' محارف.', 'danger', $alert_name, $input_name);
                }
            } else if (strstr($exp, 'max_length')) {
                $max_length = str_replace(']', '', str_replace('max_length[', '', $exp));
                if (mb_strlen($val, 'utf-8') > $max_length) {
                    add_alert('<b>' . $name . '</b> حقل النص الأقصى ' . $max_length . ' محارف.', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'number' AND strlen($val) > 0) {
                if (!ctype_digit($val)) {
                    add_alert('<b>' . $name . '</b> يجب أن يكون حقل النص قيمة رقمية.', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'alpha' AND strlen($val) > 0) {
                if (!ctype_alpha($val)) {
                    add_alert('<b>' . $name . '</b> يجب أن يحتوي حقل النص على قيمة أبجدية.', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'alnum' AND strlen($val) > 0) {
                if (!ctype_alnum($val)) {
                    add_alert('<b>' . $name . '</b> يجب أن يحتوي حقل النص على قيمة أبجدية.', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'money' AND strlen($val) > 0) {
                if (!is_currency($val)) {
                    add_alert('<b>' . $name . '</b> يجب أن يكون لحقل النص قيمة نقدية.', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'email' AND strlen($val) > 0) {
                if (!is_email($val)) {
                    add_alert('<b>' . $name . '</b> يجب أن يتوافق حقل النص مع تنسيق "البريد الإلكتروني".', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'date' AND strlen($val) > 0) {
                if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $val, $match)) {
                    add_alert('<b>' . $name . '</b> يجب أن يتوافق حقل النص مع تنسيق التاريخ. <small>مثال: "2010-05-25"</small>', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'datetime' AND strlen($val) > 0) {
                if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}$/', $val, $match)) {
                    add_alert('<b>' . $name . '</b> يجب أن يتطابق حقل النص مع تنسيق التاريخ والوقت. <small>مثال: "2010-05-25 16:00"</small>', 'danger', $alert_name, $input_name);
                }
            } else if ($exp == 'boolean' AND strlen($val) > 0) {
                if ($val != 1 && $val != true && $val != 0 && $val != false) {
                    add_alert('<b>' . $name . '</b> يجب أن يكون حقل نوع البيانات صحيح / خطأ. <small>مثال: "0/1  خطأ صحيح"</small>', 'danger', $alert_name, $input_name);
                }
            }


        }
    }

    return $val;
}


function add_alert($message, $class = 'danger', $group = 'global', $input_name = '')
{
    if (empty($input_name)) {
        $input_name = 'null';
    }

    til()->alert[$group][$class][$input_name][] = $message;
}


function is_alert($group = '', $class = '')
{
    if (!empty($group)) {

        if (isset(til()->alert[$group])) {
            if (!empty($class)) {
                if (isset(til()->alert[$group][$class])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    } else {
        if (isset(til()->alert)) {
            return true;
        } else {
            return false;
        }
    }

}


function print_alert($alert_name = '', $options = array())
{
    global $til;
    if (@$til->alert) {
        if ($alert_name == '') {
            $alert = $til->alert;
        } else {
            if (isset($til->alert[$alert_name])) {
                $alert = $til->alert[$alert_name];
                $alert = array('0' => $alert);
            } else {
                $alert = false;
            }
        }
        if ($alert) {
            foreach ($alert as $func_name => $sub_alert) {
                foreach ($sub_alert as $class => $array_messages) {
                    if (count($array_messages, COUNT_RECURSIVE) > 2) {
                        $one_message = '<ul>';
                        foreach ($array_messages as $message) {
                            foreach ($message as $msg) {
                                $one_message .= '<li>' . $msg . '</li>';
                            }
                        }
                        $one_message .= '</ul>';
                        echo get_alert($one_message, $class . ' FUNC_NAME_' . $func_name, $options);
                    } else {
                        foreach ($array_messages as $message) {
                            echo get_alert($message[0], $class . ' FUNC_NAME_' . $func_name, $options);
                        }

                    }
                }
            }
        }
    }
}


function get_alert($message, $class = 'danger', $options = array())
{

    if (!is_array($options)) {
        $options = array('x' => $options);
    }

    if (is_array($message)) {
        @$r['title'] = $message['title'];
        @$r['description'] = $message['description'];
        if (isset($message['x'])) {
            $r['x'] = $message['x'];
        } else {
            $r['x'] = true;
        }
    } else {
        $r['description'] = $message;
    }


    if (!isset($options['x'])) {
        $options['x'] = true;
    }
    if (empty($options['x']) and @$options['x'] == false) {
        $options['x'] = '';
    } else {
        $options['x'] = 'alert-dismissible';
    }


    $alert = '<div class="alert alert-' . $class . ' ' . $options['x'] . ' fade in" role="alert">';
    if (@$options['x'] == true) {
        $alert = $alert . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    }
    if (@$r['title']) {
        $alert = $alert . '<h4>' . $r['title'] . '</h4>';
    }
    if (@$r['description']) {
        $alert = $alert . '<p>' . $r['description'] . '</p>';
    }
    $alert = $alert . '</div>';

    return $alert;
}


function alert_form_element($group = 'form')
{
    if (isset(til()->alert)) {
        foreach (til()->alert as $group) {
            foreach ($group as $form_class => $form_alert) {
                if ($form_class == 'danger') {
                    $class = 'has-error';
                } elseif ($form_class == 'warning') {
                    $class = 'has-warning';
                } else {
                    $class = '';
                }
                foreach ($form_alert as $name => $message) {
                    ?>
                    <script>
                        $(document).ready(function () {
                            $("input[name='<?php echo $name; ?>']").parent('.form-group').addClass('<?php echo $class; ?>');
                        })
                    </script>
                    <?php
                }
            }
        }
    }
}


function get_checked($val_1, $val_2 = 'deneme')
{
    if (is_array($val_2)) {
        if (in_array($val_1, $val_2)) {
            return 'checked';
        } else {
            return '';
        }
    } else {
        if (empty($val_2)) {
            if ($val_1) {
                return 'checked';
            } else {
                return '';
            }
        } else {
            if ($val_1 == $val_2) {
                return 'checked';
            } else {
                return '';
            }
        }

    }

} //.get_checked()


function checked($val_1, $val_2)
{
    echo get_checked($val_1, $val_2);
} //.checked()


function get_selected($val_1, $val_2)
{
    if ($val_1 == $val_2) {
        return 'selected';
    } else {
        return '';
    }
} //.get_checked()

function selected($val_1, $val_2)
{
    echo get_selected($val_1, $val_2);
} //.checked()


/* --------------------------------------------------- URL */


function get_current_url($type = 'request_uri')
{
    if ($type == 'request_uri') {
        return $_SERVER['REQUEST_URI'];
    } elseif ($type == 'script_name') {
        return $_SERVER['SCRIPT_NAME'];
    } else {
        return $_SERVER['SERVER_NAME'];
    }

}


function get_set_url_parameters($arr = array())
{
    $url = get_current_url('script_name');
    $parameters = '?';

    if (isset($arr['add']) and is_array(@$arr['add'])) {
        foreach ($arr['add'] as $key => $val) {
            $parameters .= '&' . $key . '=' . $val;
        }
    }

    foreach ($_GET as $key => $val) {
        if (!isset($arr['add'][$key]) AND !isset($arr['remove'][$key])) {
            $parameters .= '&' . $key . '=' . $val;
        }
    }

    $parameters = str_replace('?&', '?', $parameters);
    return $url . $parameters;
} //.get_set_url_parameters()


function set_url_parameters($arr = array())
{
    echo get_set_url_parameters($arr);
}


function get_url_parameters_for_form($arr = array())
{

    $url = get_current_url('script_name');
    $parameters = '';

    if (isset($arr['add']) and is_array(@$arr['add'])) {
        foreach ($arr['add'] as $key => $val) {
            $parameters .= '<input type="text" name="' . $key . '" id="func_' . $key . '" value="' . $val . '">';
        }
    }

    foreach ($_GET as $key => $val) {
        if (!isset($arr['add'][$key]) && !isset($arr['del'][$key])) {
            $parameters .= '<input type="hidden" name="' . $key . '" id="func_' . $key . '" value="' . $val . '">';
        }
    }

    return $parameters;
}

?>
