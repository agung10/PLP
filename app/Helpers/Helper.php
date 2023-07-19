<?php
namespace App\Helpers;

class Helper
{
    /**
    * Number Format for 'backend' and 'frontend'
    * @author moko
    *
    * @param $input number(without decimal) / string('$("input[name='number_1']")')
    * @param $output string (view|db|js|validation|clear_formatted_js|view_discount|dynamic_var_jquery)
    * @param $len_decimal integer
    * @param $in_thousand (, or .)
    * @return any format (number formatted, js, pattern, dll)
    */
    public static function number_formats($input, $output = 'view', $len_decimal = 2, $in_thousand = '.', $ignore_decimal = false)
    {
        $ls_in_thousand = array('', '.', ',');

        // check decimal length
        if (!is_int($len_decimal)) {
            die('length decimal is not number');
        }

        // check in_thousand pada array()
        if (!in_array($in_thousand, $ls_in_thousand)) {
            die('symbol in_thousand not found');
        }


        $symbol_decimal = '';

        // check $in_thousand
        // then, set symbol decimal
        if ($in_thousand == '.') {
            $symbol_decimal = ',';
        } elseif ($in_thousand == ',') {
            $symbol_decimal = '.';
        }

        if ($output == 'view') {
            return number_format($input, $len_decimal, $symbol_decimal, $in_thousand);
        } elseif ($output == 'db') {
            
            $tmp_symbol_decimal = str_replace($symbol_decimal, '#', $input); // # = temporary symbol; ex output: 1.234#76
            $reset_in_thousand  = str_replace($in_thousand, '', $tmp_symbol_decimal); // ex output: 1234#76
            $reset_tmp          = str_replace('#', '.', $reset_in_thousand); // ex output: 1234.76

            // fix reset
            // ex: 123457.33
            $reset              = number_format($reset_tmp, $len_decimal, '.', '');
            
            return $reset;

        } elseif ($output == 'js') {

            $js = "{$input}.number(true, $len_decimal, '$symbol_decimal', '$in_thousand');";
            return $js;

        } elseif ($output == 'validation') {

            $decimal_pattern = '';
            if ($len_decimal > 0) {

                if($ignore_decimal == false){
                    // set decimal pattern
                    // 123,123.44 => .44 is decimal
                    $decimal_pattern = "(\\$symbol_decimal\d+)"; // decimal is required
                }else if ($ignore_decimal == true){
                    if($symbol_decimal == '') $symbol_decimal = '.';
                    $decimal_pattern = "((\\$symbol_decimal\d+)?)"; // ? == decimal is optional
                }
            }

            // 123,234.233 => (123)(,234)(.223)
            return "/^(\d{1,3})($in_thousand\d{3})*$decimal_pattern$/"; // * == Zero or more

        }
        elseif ($output == 'clear_formatted_js') {

            return "replace(/\\{$in_thousand}/g, '').replace(/\\{$symbol_decimal}/g, '.');";

        } elseif ($output == 'view_currency') {

            return 'Rp. ' . number_format($input, $len_decimal, $symbol_decimal, $in_thousand);

        } elseif ($output == 'view_discount') {

            return number_format($input, $len_decimal, $symbol_decimal, $in_thousand) . ' %';

        } elseif ($output == 'dynamic_var_jquery') {

            return "number(true, $len_decimal, '$symbol_decimal', '$in_thousand');";

        }
    }


    /**
    * Date Format for 'backend' and 'frontend'
    * @author moko
    *
    * @param $input date | string('$("input[name='date_pickers']")')
    * @param $output string date (view|db|js|format)
    * @param $opt_js array
    * @param $date_db ;date format for DB
    * @param $date_php ;date format for PHP
    * @return any format (date view, date for input(js), date_php)
    */
    public static function date_formats($input, $output = 'view', $opt_js = array('format'=>'dd-mm-yyyy','autoclose'=>true), $date_db = 'Y-m-d', $date_php = 'd-m-Y')
    {
        if ($output == 'view') {

            $reset = date($date_php, strtotime($input));
            return (empty($input) ? '' : $reset);

        } elseif ($output == 'db') {

            $reset = date($date_db, strtotime($input));
            return (empty($input) ? '' : $reset);

        } elseif ($output == 'js') {
            // parsing date format from php to javascript
            if($date_php == 'Y-m-d') $opt_js['format'] = 'yyyy-mm-dd';
            if($date_php == 'Y-d-m') $opt_js['format'] = 'yyyy-dd-mm';
            if($date_php == 'd-m-Y') $opt_js['format'] = 'dd-mm-yyyy';

            $opt_datepicker = json_encode($opt_js);

            $js = "{$input}.datepicker(
                        {$opt_datepicker}
                    );";
            return $js;
        } elseif ($output == 'date_php') {
            return $date_php;
        }
    }

    /**
    * Format number into indonesian word of number
    *
    * @param $num number
    * @return indonesian word of number from input
    */
    public static function terbilang($num){
        $_this = new self;
        $num = abs($num);
        $angka = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA",
        "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
        $temp = "";
        if ($num <12) {
            $temp = " ". $angka[$num];
        } else if ($num <20) {
            $temp = $_this->terbilang($num - 10). " BELAS";
        } else if ($num <100) {
            $temp = $_this->terbilang($num/10)." PULUH". $_this->terbilang($num % 10);
        } else if ($num <200) {
            $temp = " SERATUS" . $_this->terbilang($num - 100);
        } else if ($num <1000) {
            $temp = $_this->terbilang($num/100) . " RATUS" . $_this->terbilang($num % 100);
        } else if ($num <2000) {
            $temp = " SERIBU" . $_this->terbilang($num - 1000);
        } else if ($num <1000000) {
            $temp = $_this->terbilang($num/1000) . " RIBU" . $_this->terbilang($num % 1000);
        } else if ($num <1000000000) {
            $temp = $_this->terbilang($num/1000000) . " JUTA" . $_this->terbilang($num % 1000000);
        } else if ($num <1000000000000) {
            $temp = $_this->terbilang($num/1000000000) . " MILYAR" . $_this->terbilang(fmod($num,1000000000));
        } else if ($num <1000000000000000) {
            $temp = $_this->terbilang($num/1000000000000) . " TRILYUN" . $_this->terbilang(fmod($x,1000000000000));
        }     
            return $temp;
    }

    /**
    * Session data in for show alert in index page
    * @param $status store/update
    * @param $result result from store/update (baseRepository)
    * @return alert with class and text reserved
    */
    public static function alertStatus($status, $result){
        $alert = [];
        $alert['alert'] = $result === true ? 'success' : 'danger';
        
        if($status == 'store' && $result === true)
        {
            $alert['alert-text'] = \Lang::get('db.saved');    
        } 
        elseif($status == 'store' && $result !== true) 
        {
            $alert['alert-text'] = \Lang::get('db.failed_saved');
        } 
        elseif($status == 'update' && $result === true) 
        {
            $alert['alert-text'] = \Lang::get('db.updated');
        } 
        elseif ($status == 'update' && $result !== true) 
        {
            $alert['alert-text'] = \Lang::get('db.failed_updated');
        }
        elseif ($status == 'restrict' && $result !== true) 
        {
            $alert['alert-text'] = \Lang::get('db.failed_delete');
        }

        return $alert;
    }

    /**
    * Format timestamp without timestamp date into
    * dd mm yyyy with month name using indonesian lang
    *
    * @param $tanggal
    * @return indonesian date with format dd mm yyyy
    */
    public static function tglIndo($tanggal){
        if($tanggal != null){
            $bulan = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // check if $tanggal has jam menit detik
            if ( preg_match('/\s/',$tanggal)){
                $waktu    = explode(' ', $tanggal);
                $tanggal  = $waktu[0]; // tanggal bulan tahun
                $jam      = $waktu[1]; // jam menit detik
                $pecahkanWaktu = explode('-', $tanggal);

                return $pecahkanWaktu[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkanWaktu[0].' '. $jam;
            } else {
                return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
            }
        } else {
            return null;
        }
    }

    /**
    * Convert byte of file into more readable format
    *
    * @param $byte byte number
    * @return byte / kb / mb  / etc
    */
    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
    
    public static function limitText($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      
      return $text;
    }

    public static function imageLoad($folder='', $fileName='') {
        $fullPath = $folder . '/' . $fileName;
        $exist    = is_file( \Storage::url($fullPath) );
        $file     = asset('uploaded_files/no-image.png');
        if($exist) {
            $file = asset('uploaded_files' . '/' . $fullPath);
        }
        
        return $file;
    }

    /**
    * Truncates text.
    *
    * Cuts a string to the length of $length and replaces the last characters
    * with the ending if the text is longer than length.
    *
    * ### Options:
    *
    * - `ending` Will be used as Ending and appended to the trimmed string
    * - `exact` If false, $text will not be cut mid-word
    * - `html` If true, HTML tags would be handled correctly
    *
    * @param string  $text String to truncate.
    * @param integer $length Length of returned string, including ellipsis.
    * @param array $options An array of html attributes and options.
    * @return string Trimmed string.
    * @access public
    * @link http://book.cakephp.org/view/1469/Text#truncate-1625
    */
    public static function truncateHtmlWords($text, $length = 100, $options = array()) {
        $default = array(
            'ending' => '...', 'exact' => true, 'html' => false
        );
        $options = array_merge($default, $options);
        extract($options);

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ending));
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</'.$tag.'>';
            }
        }

        return $truncate;
    }

    public static function multiOption() {
        $opt = [
            1 => 'Ya', 
            0 => 'Tidak', 
        ];

        return $opt;
    } 
}