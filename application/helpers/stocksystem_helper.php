<?php

function is_logged_in()
{
    $ci = get_instance();

    if (!$ci->session->userdata('email')) {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Please login first!</div>');
        redirect('auth');
    }
    //     else {
    //         $menu = $ci->uri->segment(2);

    //         $where = array('name_menu' => $menu);

    //         $queryMenu = $ci->db->get_where('menu', $where)->row_array();
    //         $menu_id = $queryMenu->menu_id;

    //         $userAccess = $ci->db->get_where('user_access', [
    //             'role_id' => $ci->session->userdata('role_id'),
    //             'menu_id' => $menu_id
    //         ]);

    //         if ($userAccess->num_rows() < 1) {
    //             redirect('auth/auth_user/blocked');
    //         }
    //     }
}

if (!function_exists('sess_prefix')) {
    function sess_prefix()
    {
        $CI = &get_instance();
        return $CI->config->item('sess_prefix', 'ion_auth');
    }
}

if (!function_exists('format_angka')) {
    function format_angka($angka, $dec = 0)
    {
        $hasil = number_format($angka, $dec, ".", ",");
        return $hasil;
    }
}

if (!function_exists('remove_format_angka')) {
    function remove_format_angka($angka)
    {
        $hasil = str_replace(",", "", $angka);
        return $hasil;
    }
}

if (!function_exists('get_result_notif')) {
    function get_result_notif()
    {
        $CI = &get_instance();
        $CI->load->model("reference/mcommon", "mcom");
        //$data = $CI->mcom->get_notif_list(); 
        $data = array();
        return $data;
    }
}

if (!function_exists('get_count_notif')) {
    function get_count_notif()
    {
        $CI = &get_instance();
        $CI->load->model("reference/mcommon", "mcom");
        //$cnt = $CI->mcom->get_notif_count();
        $cnt = 0;
        return $cnt;
    }
}

if (!function_exists('str_crslug')) {
    function str_crslug($string)
    {
        $replacement = '-'; // '_';
        $CI = &get_instance();
        $CI->load->helper(array('url', 'text', 'string'));
        $string = strtolower(url_title(convert_accented_characters($string), $replacement));
        return reduce_multiples($string, $replacement, TRUE);
    }
}

//untuk mengetahui bulan bulan
if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if (!function_exists('fdate_by_fromat')) {

    function fdate_by_format($dt, $input_format, $output_format)
    {
        $return_dt = '';
        if (trim($dt) != '') {
            $date = DateTime::createFromFormat($input_format, $dt);
            $return_dt = date_format($date, $output_format);
        }
        return $return_dt;
    }
}

if (!function_exists('fdate_ind_to_eng')) {
    // Konversi dd-mm-yyyy -> yyyy-mm-dd
    function fdate_ind_to_eng($dt)
    {
        $return_dt = '';
        if (trim($dt) != '' && $dt != '00-00-0000') {
            $return_dt = date("Y-m-d", strtotime($dt));
        }
        return $return_dt;
    }
}

if (!function_exists('fdate_eng_to_ind')) {
    // Konversi yyyy-mm-dd -> dd-mm-yyyy
    function fdate_eng_to_ind($dt, $use_long_format = false)
    {
        $return_dt = '';
        if (trim($dt) != '' && $dt != '0000-00-00') {
            $date = DateTime::createFromFormat('Y-m-d', $dt);

            if ($date) {
                $format = '%d-%m-%Y';
                if ($use_long_format) $format = '%d %B %Y';

                $return_dt = strftime($format, $date->getTimestamp());
            }
        }
        return $return_dt;
    }
}

/**
 * Konversi tanggal yyyy-mm-dd H:i:s -> dd-mm-yyyy H:i:s
 *
 * @param $dt
 * @return string
 */
function fdatetime_eng_to_ind($dt, $incSeconds = true, $shortYear = false)
{
    if (trim($dt) != '' && $dt != '0000-00-00 00:00:00') {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $dt);
        $fmt_year = 'Y';
        $fmt_sec = '';
        if ($shortYear) $fmt_year = 'y';
        if ($incSeconds) $fmt_sec = ':s';
        $format = sprintf('d-m-%s H:i%s', $fmt_year, $fmt_sec);
        return date_format($date, $format);
    }
    return '';
}

/**
 * Konversi tanggal dd-mm-yyyy H:i:s -> yyyy-mm-dd H:i:s
 *
 * @param $dt
 * @return string
 */
function fdatetime_ind_to_eng($dt)
{
    if (trim($dt) != '' && $dt != '00-00-0000 00:00:00') {
        $date = strtotime($dt);
        return date('Y-m-d H:i:s', $date);
    }
    return '';
}

//format tanggal timestamp
if (!function_exists('tgl_indo_timestamp')) {

    function tgl_indo_timestamp($tgl)
    {
        $inttime = date('Y-m-d H:i:s', strtotime($tgl)); //mengubah format menjadi tanggal biasa
        $tglBaru = explode(" ", $inttime); //memecah berdasarkan spaasi

        $tglBaru1 = $tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
        $tglBaru2 = $tglBaru[1]; //mendapatkan fotmat hh:ii:ss
        $tglBarua = explode("-", $tglBaru1); //lalu memecah variabel berdasarkan -

        $tgl = $tglBarua[2];
        $bln = $tglBarua[1];
        $thn = $tglBarua[0];

        //$bln=bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
        $ubahTanggal = "$tgl-$bln-$thn $tglBaru2 "; //hasil akhir tanggal

        return $ubahTanggal;
    }
}

if (!function_exists('is_array_multi')) {
    function is_array_multi($arr)
    {
        $rv = array_filter($arr, 'is_array');
        if (count($rv) > 0) return true;
        return false;
    }
}

if (!function_exists('cempty_to_null')) {
    function cempty_to_null($value)
    {
        return empty($value) ? NULL : $value;
    }
}

if (!function_exists('array_to_tree')) {
    /**
     * Flat Array Parent Child to Tree Object
     * @author Adnan
     * @param array $items
     * @param array $config
     * @return array
     */
    function array_to_tree($items, $config = null)
    {
        ini_set('error_reporting', E_STRICT);

        if ($config === null) {
            $config = ['id' => 'id', 'parentId' => 'parentId'];
        }

        // the resulting unflattened tree
        $rootItems = [];

        // stores all already processed items with their ids as key so we can easily look them up
        $lookup = [];

        // idea of this loop:
        // whenever an item has a parent, but the parent is not yet in the lookup object, we store a preliminary parent
        // in the lookup object and fill it with the data of the parent later
        // if an item has no parentId, add it as a root element to rootItems
        $items_1 = $items;
        $cnt = count($items_1);
        for ($_i = 0; $_i < $cnt; $_i++) {
            $item = $items_1[$_i];
            $itemId = $item->{$config['id']};
            $parentId = $item->{$config['parentId']};

            // look whether item already exists in the lookup table
            //            if (!array_key_exists($itemId, $lookup)) {
            //                // item is not yet there, so add a children
            //                $item->children = [];
            //            }

            // add the current item's data to the item in the lookup table
            $lookup[$itemId] = $item;

            $TreeItem = $lookup[$itemId];

            if ($parentId === '0' || $parentId === null) {
                // is a root item
                $rootItems[] = $TreeItem;
            } else {

                // has a parent
                // look whether the parent already exists in the lookup table
                if (!array_key_exists($parentId, $lookup)) {
                    // parent is not yet there, so add a preliminary parent (its data will be added later)
                    $lookup[$parentId]->children = [];
                }

                // add the current item to the parent
                $lookup[$parentId]->children[] = $TreeItem;
            }
        }
        return $rootItems;
    }
}

if (!function_exists('build_tree')) {
    /**
     * Flat array to tree
     * https://stackoverflow.com/a/27360654/526523
     * @param $flatList - a flat list of tree nodes; a node is an array with keys: id, parentId, name.
     * @return array
     */
    function build_tree(array $flatList, $pidKey = 'parentId', $idKey = 'id', $root = null)
    {
        $tree = [];
        $grouped = [];
        foreach ($flatList as $node) {
            $grouped[$node[$pidKey]][] = $node;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if (isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        if (isset($grouped[$root])) $tree = $fnBuilder($grouped[$root]);
        return $tree;
    }
}

if (!function_exists('get_children_ids')) {
    /**
     * Get children ids from parent
     * @param $tree - a flat list of tree nodes; a node is an array with keys: id, parentId, name.
     * @return mixed
     */
    function get_children_ids(array $tree, $id, $pidKey = 'parentId', $idKey = 'id', $childKey = 'children', $buildTree = FALSE)
    {
        $results = [];

        if ($buildTree === TRUE) $tree = build_tree($tree, $pidKey, $idKey, $id);

        foreach ($tree as $el) {
            if ($el[$pidKey] == $id) {
                $results[] = $el[$idKey];
            }
            if (isset($el[$childKey]) && count($el[$childKey]) > 0 && ($children = get_children_ids($el[$childKey], $el[$idKey], $pidKey, $idKey, $childKey)) !== FALSE) {
                $results = array_merge($results, $children);
            }
        }
        return count($results) > 0 ? $results : FALSE;
    }
}



if (!function_exists('get_icon_mime')) {
    function get_icon_mime($ext)
    {
        $mimes = array(
            'gif' => "fa fa-file-image-o",
            'jpg' => "fa fa-file-image-o",
            'png' => "fa fa-file-image-o",
            'jpeg' => "fa fa-file-image-o",
            'bmp' => "fa fa-file-image-o",
            'pdf' => "fa fa-file-pdf-o",
            'txt' => "fa fa-file-text-o",
            'csv' => "fa fa-file-excel-o",
            'xls' => "fa fa-file-excel-o",
            'xlsx' => "fa fa-file-excel-o",
            'doc' => "fa fa-file-word-o",
            'docx' => "fa fa-file-word-o",
            'ppt' => "fa fa-file-powerpoint-o",
            'pptx' => "fa fa-file-powerpoint-o"
        );


        $ret_value = "fa fa-file-o";
        foreach ($mimes as $key => $value) {
            if ($ext == $key) {
                $ret_value = $value;
                break;
            }
        }

        return $ret_value;
    }
}
