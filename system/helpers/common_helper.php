<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function dump($data, $label = '', $exit = false) {
    if ($label != '')
        echo '<br /><br />' . $label;
    echo '<br />';
    if (is_array($data) || is_object($data)) {
        print("<pre>");
        print_r($data);
        print("</pre><hr>");
    } else {
        echo $data;
    }
    if ($exit)
        exit ;
}
?>
