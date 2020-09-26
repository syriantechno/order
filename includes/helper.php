<?php
/* --------------------------------------------------- HELPER */


function til_is_mobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


/* --------------------------------------------------- HELPER - EXPORT */


/**
 * get_convert_str_export()
 *
 */
function get_convert_str_export($val)
{
    return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $val);
}


/**
 * export_pdf()
 *
 */
function export_pdf($filename = '', $ops = array())
{
    $filename = 'ultra_' . $filename;
    if (!isset($ops['paper'])) {
        $ops['paper'] = 'A4';
    }
    if (!isset($ops['landscape'])) {
        $ops['landscape'] = '';
    }

    require_once get_root_path('includes/lib/dompdf/export_pdf.php');
}


function export_excel($filename = '')
{
    $filename = 'ultra_' . $filename . '.xls';
    header('Content-Description: File Transfer');
    header('Content-Encoding: UTF-8');
    header("Content-type: application/vnd.ms-excel;charset=UTF-8");
    header("Content-Disposition: attachment; filename=$filename");
    header('Content-Transfer-Encoding: binary');
    header('Pragma: public');
} //.export_excel()


/* --------------------------------------------------- HELPER - MONEY/DECIMAL */


/**
 * get_set_money()
 *
 */
function get_set_money($val, $arr = array())
{
    $val = str_replace(',', '', $val);

    if (!is_array($arr)) {
        if ($arr == 'str') {
            $arr = array('str' => true);
        } elseif ($arr == 'icon') {
            $arr = array('icon' => true);
        } elseif ($arr == 'small_icon') {
            $arr = array('icon' => true, 'small' => true);
        } elseif ($arr == 'small_str') {
            $arr = array('str' => true, 'small' => true);
        }

        $arr['decimal_separator'] = '.';
        $arr['digit_separator'] = ',';
    }

    if (!isset($arr['decimal_separator'])) {
        $arr['decimal_separator'] = '.';
    }
    if (!isset($arr['digit_separator'])) {
        $arr['digit_separator'] = ',';
    }

    if (isset($arr)) {

    }


    $icon = '';
    if (isset($arr['icon'])) {
        $icon = ' <small class="text-muted"><?php echo til()->company->currency; ?></small>';
    }
    if (isset($arr['str'])) {
        $icon = '';
    }
    if (isset($arr['small'])) {
        $icon = '<small>' . $icon . '</small>';
    }


    if (is_numeric($val)) {
        return number_format($val, 2, '.', $arr['digit_separator']) . $icon;
    } else {
        return number_format(0, 2, '.', $arr['digit_separator']) . $icon;
    }
} //.get_set_money()

/**
 * set_money()
 * ref:get_set_money()
 */
function set_money($val, $arr = array())
{
    echo get_set_money($val, $arr);
} //.set_money()


/**
 * get_set_vat()
 *
 */
function get_set_vat($vat)
{
    if (substr($vat, 0, 1) == 0) {
        $vat = substr($vat, 1);
    }
    if (strlen($vat) == 2) {
        return '1.' . $vat;
    } else {
        return '1.0' . $vat;
    }
} //.get_set_vat()

/**
 * set_vat()
 * ref:get_set_vat()
 */
function set_vat($vat)
{
    echo get_set_vat($vat);
} //.set_vat()


/**
 * til_get_addslashes()
 *
 */
function til_get_addslashes($arr)
{
    $return = array();
    if (!is_array($arr)) {
        $return = addslashes($arr);
    } else {
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $return[$k] = til_get_addslashes($v);
            } else {
                $return[$k] = addslashes($v);
            }
        }
    }


    return $return;
} //.til_get_addslashes()


/**
 * til_get_substr()
 *
 */
function til_get_substr($val, $start, $end, $args = '...')
{
    if (!is_array($args)) {
        $dot3 = $args;
        $args = array();
        if ($dot3) {
            if (empty($dot3)) {
                $args['dot3'] = '';
            } else {
                $args['dot3'] = $dot3;
            }
        } else {
            $args['dot3'] = false;
        }
    }

    $return = trim(mb_substr($val, $start, $end, 'utf-8'));
    if (strlen($val) > ($end - $start)) {
        $return .= $args['dot3'];
    }
    return $return;
}


/**
 * til_get_abbreviation()
 *
 */
function til_get_abbreviation($str, $max_length = 2)
{

    if (preg_match_all('/\b(\w)/', strtoupper($str), $m)) {
        $v = implode('', $m[1]);
        echo substr($v, 0, $max_length);
    } else {
        return false;
    }


}


function til_active_site_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
}


/* --------------------------------------------------- HELPER - STRING - CONVERTING */


/**
 * get_time_late()
 *
 */
function get_time_late($date)
{
    date_default_timezone_set('Europe/Istanbul');
    $date1 = strtotime(date('Y-m-d H:i:s'));
    $date2 = strtotime($date);
    $day = (($date1 - $date2) / 3600) / 24;

    if ($day < 1) {
        $hours = $day * 24;
        if ($hours < 1) {
            $second = $hours * 3600;
            if ($second < 60) {
                return str_replace('', '', $second) . ' ثانية';
            } else {
                return str_replace('', '', round($second / 60)) . ' دقيقة';
            }
        } else {
            return str_replace('', '', round($hours)) . ' الساعة';
        }
    } else {
        return str_replace('', '', round($day)) . ' اليوم';
    }
} //.get_time_late()


function til_get_date_lang($val)
{
    $arr1 = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $arr2 = array('كانون ثاني', 'شباط', 'أذار', 'نيسان', 'أيار', 'حزيران', 'تموز', 'اب', 'ايلول', 'تشرين اول', 'تشرين ثاني', 'كانون اول');
    $val = str_replace($arr1, $arr2, $val);

    $arr1 = array('Jan', 'Fev', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    $arr2 = array('ك٢', 'ش', 'اذ', 'ن', 'ايا', 'حز', 'تم', 'اب', 'اي', 'ت١', 'ت٢', 'ك١');
    $val = str_replace($arr1, $arr2, $val);

    $arr1 = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $arr2 = array('Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar');
    $val = str_replace($arr1, $arr2, $val);

    $arr1 = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $arr2 = array('Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz');
    $val = str_replace($arr1, $arr2, $val);

    return $val;
}


/**
 * til_get_date()
 * tarih formatlarini duzenler
 */
function til_get_date($date, $args = array())
{
    $return = '';
    if ($date == 'true' OR $date == '1') {
        $date = date('Y-m-d H:i:s');
    }
    if (!is_array($args)) {
        if ($args == 'date') {
            $return = substr($date, 0, 10);
        } elseif ($args == 'datetime') {
            $return = substr($date, 0, 16);
        } elseif ($args == 'time') {
            $return = substr($date, 11, 16);
        } elseif ($args == 'str: F Y') {
            $return = date('F Y', strtotime($date));
        } else {
            $return = date($args, strtotime($date));
        }
    }

    return til_get_date_lang($return);
}


/**
 * til_exit()
 * betik akisini durdurur
 */
function til_exit($line_no)
{
    exit('Akış durduruldu. Satir no: ' . $line_no);
}


/**
 * json_encode_utf8()
 * json_encode fonksiyonu UTF8 karakterlerini eksik gostermektedir. Bu fonksiyon tum sunucularda sorunsuz calismaktadir.
 */
function json_encode_utf8($input, $flags = 0)
{
    $fails = implode('|', array_filter(array(
        '\\\\',
        $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
        $flags & JSON_HEX_AMP ? 'u0026' : '',
        $flags & JSON_HEX_APOS ? 'u0027' : '',
        $flags & JSON_HEX_QUOT ? 'u0022' : '',
    )));
    $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
    $callback = function ($m) {
        return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
    };
    return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
} //.json_encode_utf8()


/**
 * is_json()
 * bir degerin json olup olmadigini kontrol eder
 */
function is_json($string)
{
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
} //.is_json()


/** * remove_accents()
 * bir degiskendeki boşluk nokta virgül gibi fazlaıkları siler "-" olarak değiştirir
 */
function remove_accents($fonktmp)
{
    $returnstr = "";
    $turkcefrom = array("/Ğ/", "/Ü/", "/Ş/", "/İ/", "/Ö/", "/Ç/", "/ğ/", "/ü/", "/ş/", "/ı/", "/ö/", "/ç/");
    $turkceto = array("G", "U", "S", "I", "O", "C", "g", "u", "s", "i", "o", "c");
    $fonktmp = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç_]/", " ", $fonktmp);
    // Türkçe harfleri ingilizceye çevir
    $fonktmp = preg_replace($turkcefrom, $turkceto, $fonktmp);
    // Birden fazla olan boşlukları tek boşluk yap
    $fonktmp = preg_replace("/ +/", " ", $fonktmp);
    // Boşukları - işaretine çevir
    $fonktmp = preg_replace("/ /", "-", $fonktmp);
    // Tüm beyaz karekterleri sil
    $fonktmp = preg_replace("/\s/", "", $fonktmp);
    // Karekterleri küçült
    $fonktmp = strtolower($fonktmp);
    // Başta ve sonda - işareti kaldıysa yoket
    $fonktmp = preg_replace("/^-/", "", $fonktmp);
    $fonktmp = preg_replace("/-$/", "", $fonktmp);
    return $fonktmp;
} //.remove_accents()


/**
 * _args_helper()
 * fonksiyonlara gonderilen $args parametlerini duzenler ve fonksiyon icin yardımcı nesneler olusturur
 */
function _args_helper($args, $default = '')
{

    $args2 = array();
    if (is_array($args)) {

        if (is_array($default)) {
            foreach ($default as $def) {
                if (!isset($args[$def])) {
                    add_alert('Parametre ile gelen "<b>' . $def . '</b>" dizisi/verisi eksik yada hatalı.', 'warning', __FUNCTION__);
                }
            }
        } else {
            if ($default != '') {
                if (!isset($args[$default])) {
                    $args2[$default] = $args;
                    unset($args);
                    $args = $args2;
                    unset($args2);
                } elseif ($args[$default] == '') {
                    $args2[$default] = $args;
                    unset($args);
                    $args = $args2;
                    unset($args2);
                }
            }

        }

        // eger hata var ise betik akisin duraruralim
        if (is_alert(__FUNCTION__)) {
            return false;
        }

        // default degerler icin $args dizisine genel parametreleri atayalim
        if (empty($args) AND !empty($default)) {
            $args[$default] = array();
        }

        if (!isset($args['add_alert'])) {
            $args['add_alert'] = true;
        }
        if (!isset($args['add_log'])) {
            $args['add_log'] = true;
        }
        if (!isset($args['add_new'])) {
            $args['add_new'] = true;
        }
        if (!isset($args['return'])) {
            $args['return'] = 'default';
        }
    } else {
        if (!empty($default)) {
            return $args[$default] = array();
        }
    }

    return $args;
} //._args_helper()


/**
 * _return_helper()
 * fonksiyon icinde donen degerlerin donus turlerini belirler
 */
function _return_helper($type, $result)
{
    $return = array();
    if ($result->num_rows == 1) {
        if ($type == 'default' or $type == 'object' or $type == 'single_object') {
            $return = $result->fetch_object();
        } elseif ($type == 'array') {
            $return = $result->fetch_assoc();
        } elseif ($type == 'plural_object') {

            $return[] = $result->fetch_object();
        } else {
            return false;
        }
    } elseif ($result->num_rows > 1) {
        if ($type == 'single_object') {
            $return = $result->fetch_object();
        } elseif ($type == 'default' or $type == 'object' or $type == 'plural_object') {

            while ($list = $result->fetch_object()) {
                $return[] = $list;
            }
        } elseif ($type == 'array') {
            while ($list = $result->fetch_assoc()) {
                $return[] = $list;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    return $return;
} //._return_helper()


/**
 * _b()
 * parametrede aldığı sonuca "<b>" ekler
 */
function _b($val, $ops = '"')
{
    return $ops . '<b>' . $val . '</b>' . $ops;
}


/**
 * til_get_ucfirst()
 * bir dizgenin ilk harflerini buyuk yapar
 */
function til_get_ucwords($string, $e = 'utf-8')
{
    if (function_exists('mb_convert_case') && !empty($string)) {
        $string = mb_convert_case($string, MB_CASE_TITLE, $e);
    } else {
        $string = ucwords($string);
    }
    return $string;
} //.til_get_ucfirst()


/**
 * til_get_strtoupper()
 * bir dizgeyi komple buyuk harf yapar
 */
function til_get_strtoupper($string, $e = 'utf-8')
{
    if (function_exists('mb_strtoupper') && !empty($string)) {
        $string = mb_strtoupper($string);
    } else {
        $string = strtoupper($string);
    }
    return $string;
} //.til_get_strtoupper()


/**
 * til_get_strtolower()
 * bir dizgeyi komple kucuk harf yapar
 */
function til_get_strtolower($string, $e = 'utf-8')
{
    if (function_exists('mb_strtolower') && !empty($string)) {
        $string = mb_strtolower($string);
    } else {
        $string = strtolower($string);
    }
    return $string;
} //.til_get_strtolower()


/**
 * til_get_money_convert_string()
 * bir rakamı yani parasal degeri string/text formatina cevirir
 */
function til_get_money_convert_string($money = '0.00')
{
    $l10 = '';
    $l9 = '';
    $l8 = '';
    $l7 = '';
    $l6 = '';
    $l5 = '';
    $l4 = '';
    $l3 = '';
    $l2 = '';
    $l1 = '';
    $r1 = '';
    $r2 = '';

    $money = explode('.', $money);

    if (count($money) != 2) return false;

    $money_left = $money['0'];
    $money_right = substr($money['1'], 0, 2);
    if (strlen($money_left) == 10) {
        $i = (int)floor($money_left / 1000000000);
        if ($i == 1) $l10 = "مليار";
        if ($i == 2) $l10 = "مئتان";
        if ($i == 3) $l10 = "ثلاثمائة";
        if ($i == 4) $l10 = "اربعمائة";
        if ($i == 5) $l10 = "خمسمائة";
        if ($i == 6) $l10 = "ستمائة";
        if ($i == 7) $l10 = "سبعمائة";
        if ($i == 8) $l10 = "ثمانمائة";
        if ($i == 9) $l10 = "تسعمائة";
        if ($i == 0) $l10 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }

    //DOKUZLAR
    if (strlen($money_left) == 9) {
        $i = (int)floor($money_left / 100000000);
        if ($i == 1) $l9 = "مائة";
        if ($i == 2) $l9 = "مئتان";
        if ($i == 3) $l9 = "ثلاثمائة";
        if ($i == 4) $l9 = "اربعمائة";
        if ($i == 5) $l9 = "خمسمائة";
        if ($i == 6) $l9 = "ستمائة";
        if ($i == 7) $l9 = "سبعمائة";
        if ($i == 8) $l9 = "ثمانمائة";
        if ($i == 9) $l9 = "تسعمائة";
        if ($i == 0) $l9 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //SEKİZLER
    if (strlen($money_left) == 8) {
        $i = (int)floor($money_left / 10000000);
        if ($i == 1) $l8 = "وعشرة ملايين";
        if ($i == 2) $l8 = "وعشرون مليون";
        if ($i == 3) $l8 = "وثلاثون مليون";
        if ($i == 4) $l8 = "وأربعون مليون";
        if ($i == 5) $l8 = "وخمسون مليون";
        if ($i == 6) $l8 = "وستون مليون";
        if ($i == 7) $l8 = "وسبعون مليون";
        if ($i == 8) $l8 = "وثمانون مليون";
        if ($i == 9) $l8 = "وتسعون مليون";
        if ($i == 0) $l8 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //YEDİLER
    if (strlen($money_left) == 7) {
        $i = (int)floor($money_left / 1000000);
        if ($i == 1) {
            if ($i != "NULL") {
                $l7 = "مليون";
            } else {
                $l7 = "مليون";
            }
        }
        if ($i == 2) $l7 = "اثنان";
        if ($i == 3) $l7 = "ثلاثة ملايين";
        if ($i == 4) $l7 = "اربعة ملايين";
        if ($i == 5) $l7 = "خمسة ملايين";
        if ($i == 6) $l7 = "ستة ملايين";
        if ($i == 7) $l7 = "سبعة ملايين";
        if ($i == 8) $l7 = "ثمانية ملايين";
        if ($i == 9) $l7 = "تسعة ملايين";
        if ($i == 0) {
            if ($i != "NULL") {
                $l7 = "مليون";
            } else {
                $l7 = "";
            }
        }
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //ALTILAR
    if (strlen($money_left) == 6) {
        $i = (int)floor($money_left / 100000);
        if ($i == 1) $l9 = "ومائة";
        if ($i == 2) $l9 = "ومئتان";
        if ($i == 3) $l9 = "وثلاثمائة";
        if ($i == 4) $l9 = "واربعمائة";
        if ($i == 5) $l9 = "وخمسمائة";
        if ($i == 6) $l9 = "وستمائة";
        if ($i == 7) $l9 = "وسبعمائة";
        if ($i == 8) $l9 = "وثمانمائة";
        if ($i == 9) $l9 = "وتسعمائة";
        if ($i == 0) $l9 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //BEŞLER
    if (strlen($money_left) == 5) {
        $i = (int)floor($money_left / 10000);
        if ($i == 1) $l5 = "عشرة آلاف";
        if ($i == 2) $l5 = "عشرون آلف";
        if ($i == 3) $l5 = "ثلاثون آلف";
        if ($i == 4) $l5 = "اربعون آلف";
        if ($i == 5) $l5 = "خمسون آلف";
        if ($i == 6) $l5 = "ستون آلف";
        if ($i == 7) $l5 = "سبعون آلف";
        if ($i == 8) $l5 = "ثمانون آلف";
        if ($i == 9) $l5 = "تسعون آلف";
        if ($i == 0) $l5 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //DÖRTLER
    if (strlen($money_left) == 4) {
        $i = (int)floor($money_left / 1000);
        if ($i == 1) {
            if ($i != "") {
                $l4 = "الف";
            } else {
                $l4 = "الف";
            }
        }
        if ($i == 2) $l4 = "الفان";
        if ($i == 3) $l4 = "وثلاثة";
        if ($i == 4) $l4 = "واربعة";
        if ($i == 5) $l4 = "وخمسة";
        if ($i == 6) $l4 = "وستة";
        if ($i == 7) $l4 = "وسبعة";
        if ($i == 8) $l4 = "وثمانية";
        if ($i == 9) $l4 = "وتسعة";
        if ($i == 0) {
            if ($i != "") {
                $l4 = "الف";
            } else {
                $l4 = "";
            }
        }
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //ÜÇLER
    if (strlen($money_left) == 3) {
        $i = (int)floor($money_left / 100);
        if ($i == 1) $l3 = "و مائة";
        if ($i == 2) $l3 = "و مئتان";
        if ($i == 3) $l3 = "و ثلاثمائة";
        if ($i == 4) $l3 = "و اربعمائة";
        if ($i == 5) $l3 = "و خمسمائة";
        if ($i == 6) $l3 = "و ستمائة";
        if ($i == 7) $l3 = "و سبعمائة";
        if ($i == 8) $l3 = "و ثمانمائة";
        if ($i == 9) $l3 = "و تسعمائة";
        if ($i == 0) $l3 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //İKİLER
    if (strlen($money_left) == 2) {
        $i = (int)floor($money_left / 10);
        if ($i == 1) $l2 = "و عشرة";
        if ($i == 2) $l2 = "و عشرون";
        if ($i == 3) $l2 = "و ثلاثون";
        if ($i == 4) $l2 = "واربعون";
        if ($i == 5) $l2 = "و خمسون";
        if ($i == 6) $l2 = "و ستون";
        if ($i == 7) $l2 = "و سبعون";
        if ($i == 8) $l2 = "و ثمانون";
        if ($i == 9) $l2 = "و تسعون";
        if ($i == 0) $l2 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //BİRLER
    if (strlen($money_left) == 1) {
        $i = (int)floor($money_left / 1);
        if ($i == 1) $l1 = "و واحد";
        if ($i == 2) $l1 = "و اثنان";
        if ($i == 3) $l1 = "و ثلاثة";
        if ($i == 4) $l1 = "و اربعة";
        if ($i == 5) $l1 = "و خمسة";
        if ($i == 6) $l1 = "و ستة";
        if ($i == 7) $l1 = "و سبعة";
        if ($i == 8) $l1 = "و ثمانية";
        if ($i == 9) $l1 = "و تسعة";
        if ($i == 0) $l1 = "";
        $money_left = substr($money_left, 1, strlen($money_left) - 1);
    }
    //SAĞ İKİ
    if (strlen($money_right) == 2) {
        $i = (int)floor($money_right / 10);
        if ($i == 1) $r2 = "عشرة";
        if ($i == 2) $r2 = "عشرون";
        if ($i == 3) $r2 = "ثلاثون";
        if ($i == 4) $r2 = "اربعون";
        if ($i == 5) $r2 = "خمسون";
        if ($i == 6) $r2 = "ستون";
        if ($i == 7) $r2 = "سبعون";
        if ($i == 8) $r2 = "ثمانون";
        if ($i == 9) $r2 = "تسعون";
        if ($i == 0) $r2 = "صفر";
        $money_right = substr($money_right, 1, strlen($money_right) - 1);
    }
    //SAĞ BİR
    if (strlen($money_right) == 1) {
        $i = (int)floor($money_right / 1);
        if ($i == 1) $r1 = "واحد";
        if ($i == 2) $r1 = "اثنان";
        if ($i == 3) $r1 = "ثلاثة";
        if ($i == 4) $r1 = "اربعة";
        if ($i == 5) $r1 = "خمسة";
        if ($i == 6) $r1 = "ستة";
        if ($i == 7) $r1 = "سبعة";
        if ($i == 8) $r1 = "ثمانية";
        if ($i == 9) $r1 = "تسعة";
        if ($i == 0) $r1 = "";
        $money_right = substr($money_right, 1, strlen($money_right) - 1);
    }


    return "$l10 $l7 $l8 $l9 $l6 $l4 $l5 $l3 $l1 $l2 ليرة سورية و $r2 $r1 جزءلاغير ";
} //.til_get_money_convert_string()


/* --------------------------------------------------- HELPER - COUNTRY-CITY-DISTRICT LIST */

/**
 * get_country_array()
 * ülke listelerini dizi halinde dondurur
 */
function get_country_array()
{
    include get_root_path('includes/lib/countries/country.php');
    return $countries;
} //.get_country_array()


function get_types_array()
{
    include get_root_path('includes/lib/countries/type.php');
    return $types;
} //.get_country_array()

function get_sex_array()
{
    include get_root_path('includes/lib/countries/sex.php');
    return $sex;
} //.get_country_array()


/**
 * list_selectbox_array()
 *
 */
function list_selectbox($array = array(), $opt = array())
{
    ob_start();

    // options
    if (!isset($opt['name'])) {
        $opt['name'] = 'selectbox';
    }
    if (!isset($opt['id'])) {
        $opt['id'] = $opt['name'];
    }
    if (!isset($opt['class'])) {
        $opt['class'] = 'form-control select';
    }
    if (!isset($opt['option_val_none'])) {
        $opt['option_val_none'] = false;
    }
    if (!isset($opt['selected'])) {
        $opt['selected'] = '';
    }

    ?><select name="<?php echo $opt['name']; ?>" id="<?php echo $opt['id']; ?>" class="<?php echo $opt['class']; ?>"
              data-live-search="true"> <?php
    foreach ($array as $key => $val) {

        if ($opt['option_val_none'] == true) {
            $key = $$key;
        } else {
            $key = $val;
        }

        $selected = '';
        if ($opt['selected'] == $key) {
            $selected = 'selected';
        }


        echo '<option val="' . $key . '" ' . $selected . '>' . $val . '</option>';


    }

    ?></select> <?php

    $select = ob_get_contents();
    ob_end_clean();
    return $select;
}


/**
 * @func editor_strip_tags()
 * @desc içerikte istenilmeyen html'leri siler $strip ile gelen değerler hariç
 * @param string, string
 * @return string
 */
function editor_strip_tags($val, $strip = "")
{
    if (empty($strip)) {
        $strip = '<h1><h2><h3><h4><h5><a><div><span><p><b><br><li><ol><ul><strong><img><blockquote><em><s><u><i><table><thead><body><tr><td><th>';
    }
    $val = strip_tags($val, $strip);

    return $val;
} //.editor_strin_tags()


?>
