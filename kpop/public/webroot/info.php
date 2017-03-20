<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
echo "HEADER";
echo "<br />";
echo 'Basic infomation';
echo "<br />";
echo "key: APN value: ".(isset($_SERVER["APN"])?$_SERVER["APN"]:"");
echo "<br />";
echo "key: IMSI value: ".(isset($_SERVER["IMSI"])?$_SERVER["IMSI"]:"");
echo "<br />";
echo "key: IP value: ".(isset($_SERVER["IP"])?$_SERVER["IP"]:"");
echo "<br />";
echo "key: MSISDN  value: ".(isset($_SERVER["MSISDN "])?$_SERVER["MSISDN"]:"");
echo "<br />";
echo "<br />";
echo 'Full infomation';
echo "<pre>";print_r($_SERVER);echo "</pre>";exit();






