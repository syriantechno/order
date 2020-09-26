<?php
/* --------------------------------------------------- ITEM */
global $lang;
$lang['دخول الأعضاء'] = 'User Login';
$lang['خروج الأعضاء'] = 'User Logout';
function language()
{
    global $lang;
    return $lang;
}


/**
 * get_lang()
 * gecerli dil seçeneğini dondurur
 */
function get_lang($text, $arr = array())
{
    $lang = language();
    if (isset($lang[$text])) {
        return $lang[$text];
    } else {
        return $text;
    }
}


?>