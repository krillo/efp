<?php

/*
 * Description: The code for the registration form (Ratsit). Ajax api, db table for zip codes, SOAP call to ratsit.se 
 * Author: Kristian Erendi
 * Author URI: http://reptilo.se
 * Date: 2012-12-06
 * License: GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Version: 1.0
 */

/**
 * Enqueue some java scripts
 */
function ratsit_scripts() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
  wp_enqueue_script('jquery');
  //wp_register_script('validate', 'http://jzaefferer.github.com/jquery-validation/jquery.validate.js');
  wp_register_script('validate', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js');
  //wp_register_script('validate', 'https://raw.github.com/jzaefferer/jquery-validation/master/jquery.validate.js');
  //wp_register_script('validate_additional', 'https://raw.github.com/jzaefferer/jquery-validation/master/additional-methods.js');
  wp_enqueue_script('validate');
  //wp_enqueue_script('validate_additional');
}

add_action('wp_enqueue_scripts', 'ratsit_scripts');


add_action('init', 'init_zip_table');

function init_zip_table() {
  $version = 3;
  global $wpdb;
  $installed_ver = get_option("ep_zip");
  if ($installed_ver != $version) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = $wpdb->prefix . 'ep_zip';
    $sql = "CREATE TABLE `" . $table_name . "` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `zip` varchar(12) NOT NULL DEFAULT '',
              `city` VARCHAR(128)  NOT NULL  DEFAULT ''  AFTER `date`,
              `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    dbDelta($sql);
//echo $sql;
    update_option("ep_zip", $version);
  }
}

add_action('wp_ajax_check_zip', 'zip_callback');
add_action('wp_ajax_nopriv_check_zip', 'zip_callback');

function zip_callback() {
  $success = 1;
  !empty($_REQUEST['zip']) ? $zip = $_REQUEST['zip'] : $zip = '00000';
  $zip = trim($zip);
  $zip = str_replace(" ", "", $zip);
  $zip = substr($zip, 0, 3) . ' ' . substr($zip, 3);
  global $wpdb;
  $table_name = $wpdb->prefix . 'ep_zip';
  $sql = "SELECT city FROM " . $table_name . " WHERE zip = '" . $zip . "';";
  $city = $wpdb->get_var($sql);
  if (!$city) {
    $success = 0;
  }
  $response = json_encode(array('success' => $success, 'city' => $city));
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo $response;
  die(); // this is required to return a proper result
}

add_action('wp_ajax_get_pers_info', 'pers_info_callback');
add_action('wp_ajax_nopriv_get_pers_info', 'pers_info_callback');

function pers_info_callback() {
  !empty($_REQUEST['ss']) ? $ss = $_REQUEST['ss'] : $ss = '';
  if (!empty($ss)) {
    $response = ratsit($ss);
  } else {
    $response = array(
        'success' => 0,
        'error' => 'Inget personnummer',
    );
  }
  $response = json_encode($response);
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo $response;
  die(); // this is required to return a proper result
}

/**
 * 
 * @throws Exception 
 */
function ratsit($ss) {
  try {
    ini_set('display_warnings', 0);
    ini_set('display_errors', 0);
    libxml_use_internal_errors(true);
//test
//$client = new SoapClient("https://www.ratsit.se:7443/ratsvc/apipackageservice.asmx?WSDL");
//$result = $client->GetPersonInformationPackage(array('token' => '86833014aefc41e8838ad88e5834e52d', 'packages' => 'Small 1', 'pnr' => $ss));
    $client = new SoapClient("https://www.ratsit.se/ratsvc/apipackageservice.asmx?WSDL");
    $result = $client->GetPersonInformationPackage(array('token' => 'bf8b2e81ac594f93a770666bb104baa9', 'packages' => 'Small 1', 'pnr' => $ss));
    $xml = simplexml_load_string($result->GetPersonInformationPackageResult->any);
    $error = (string) $xml->children()->Error->children()->ErrorDescription;
    if (!empty($error)) {
      throw new Exception($error);
    }
    $pip = $xml->children()->PersonInformationPackage;
    $pi = $xml->children()->PersonInformationPackage->children()->PersonInformation;
    $nr = $xml->children()->PersonInformationPackage->children()->NationalRegistration;
    $fname = (string) $pi->GivenName;
    if (!$fname) {
      $fname = (string) $pi->FirstName;
    }
    $person = array(
        'success' => 1,
        'fname' => $fname,
        'lname' => (string) $pi->SurName,
        'street1' => (string) $nr->Street,
        'street2' => '',
        'zip' => (string) $nr->ZipCode,
        'city' => (string) $nr->City,
        'phone' => '',
        'email' => '',
        'ss' => (string) $pi->SSN,
        'error' => '',
    );
//print_r($person);
  } catch (exception $e) {
    $person = array(
        'success' => 0,
        'error' => $e->getMessage(),
        'stacktrace' => $e,
    );
  }
  return $person;
}

add_action('wp_ajax_get_putsschema', 'get_putsschema_callback');
add_action('wp_ajax_nopriv_get_putsschema', 'get_putsschema_callback');

function get_putsschema_callback() {
  $success = 1;
  !empty($_REQUEST['kommun_id']) ? $kommun_id = $_REQUEST['kommun_id'] : $kommun_id = '0000';
  global $wpdb;
  $table_name = $wpdb->prefix . 'ep_areas';
  $sql = "select a.id, a.cod, a.area, a.car_id, a.schedule, a.city, a.city_id from $table_name a where city_id = $kommun_id order by area asc;";
  $response = $wpdb->get_results($sql);
  $response = json_encode($response);
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo $response;
  die(); // this is required to return a proper result
}

function getLogFileName() {
  $logFile = dirname(__FILE__) . '/log/efp' . "." . date("y-m") . ".log";
  return $logFile;
}

function saveToLogFile($filename, $data, $type = 'INFO') {
  if (!file_exists($filename)) {
    touch($filename);
  }
  $fh = fopen($filename, 'a') or die("can't open file");
  fwrite($fh, "\n" . date('Y-m-d H:m:s') . ' [' . $type . '] ');
  fwrite($fh, $data);
  fclose($fh);
}

$tillval = array(
    array('name' => 'Bottenvåning', 'desc' => 'Påmontering av löstagbar spröjs', 'servicename' => 'BV Spröjs på'),
    array('name' => 'Bottenvåning', 'desc' => 'Rengöring av löstagbar spröjs', 'servicename' => 'BV Spröjsrengöring'),
    array('name' => 'Bottenvåning', 'desc' => 'Fönsterbleck rengöring', 'servicename' => 'BV Bleck'),
    array('name' => 'Bottenvåning', 'desc' => 'Karmar & bågar rengöring', 'servicename' => 'BV Karmar & bågar'),
    array('name' => 'Uterum', 'desc' => 'Uterum utvändigt', 'servicename' => 'Uterum utv'),
    array('name' => 'Uterum', 'desc' => 'Uterum invändigt och utvändigt', 'servicename' => 'Uterum utv/inv'),
    array('name' => 'Ovanvåning', 'desc' => 'normala fönster', 'servicename' => 'ÖV normala fönster'),
    array('name' => 'Ovanvåning', 'desc' => 'rengöring av löstagbar spröjs', 'servicename' => 'ÖV spröjsrengöring ÖV spröjsrengöring'),
    array('name' => 'Ovanvåning', 'desc' => 'fönsterbleck rengöring', 'servicename' => 'ÖV bleck'),
    array('name' => 'Ovanvåning', 'desc' => 'fönsterkarmar & fönsterbågar', 'servicename' => 'ÖV karmar & bågar'),
    array('name' => 'Källarfönster', 'desc' => '', 'servicename' => ' Källarfönster'),
    array('name' => 'Källarfönster', 'desc' => 'fönsterbleck', 'servicename' => 'Källare bleck'),
    array('name' => 'Källarfönster', 'desc' => 'fönsterkarmar & fönsterbågar', 'servicename' => 'Källare karmar & bågar'),
);

function getTillvalTable($isKund = true) {
  global $tillval;
  $disabled = '';
  if (!$isKund) {
    $disabled = 'disabled';
  }
  $output = <<<HTML
    <table border="0" class="tillval-table">
    <thead>
      <tr>
        <th></th>
        <th></th>        
        <th colspan="7">Putsperiod</th>
      </tr>
      <tr>
        <th></th>
        <th>Alla</th>        
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
      </tr>
    </thead>
    <tbody>
HTML;
  $i = 1;
  foreach ($tillval as $key => $value) {
    $class = $i % 2 ? 'zebra': '';
    $i++;
    $output .= '<tr class="'.$class.'">';
    $output .= '  <td><strong>' . $value['name'] . '</strong> ' . $value['desc'] . '</td>';
    $output .= '  <td style="text-align:center;"><input name = "" id="id_' . $key . '_all" value="" type="checkbox" class="select-all"/></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "1" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "2" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "3" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "4" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "5" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "6" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '  <td><input name = "id_' . $key . '[]" id = "" value = "7" type = "checkbox" row="id_' . $key . '" /></td>';
    $output .= '</tr>';
  }
  $output .= '</table>';
  return $output;
}

function getTillvalTableForCustomerService() {
  global $tillval;
    $data = print_r($_REQUEST['id_1'], true);
    saveToLogFile(getLogFileName(), "Tillval: \n" . $data, 'INFO');  
  $output = <<<HTML
    <table border="1">
    <thead>
      <tr>
        <th>Putsperiod</th>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
      </tr>
    </thead>
    <tbody>
HTML;
  foreach ($tillval as $key => $value) {
    !empty($_REQUEST['id_' . $key]) ? $val = $_REQUEST['id_' . $key] : $val = '';
    $servicename = $value['servicename'];
    $c1 = $c2 = $c3 = $c4 = $c5 = $c6 = $c7 = ' ';
    if ($val != '') {
      $c1 = in_array('1', $val) ? 'x' : ' ';
      $c2 = in_array('2', $val) ? 'x' : ' ';
      $c3 = in_array('3', $val) ? 'x' : ' ';
      $c4 = in_array('4', $val) ? 'x' : ' ';
      $c5 = in_array('5', $val) ? 'x' : ' ';
      $c6 = in_array('6', $val) ? 'x' : ' ';
      $c7 = in_array('7', $val) ? 'x' : ' ';
    }
    $output .= '<tr>';
    $output .= '  <td>' . $servicename . '</td>';
    $output .= '  <td>' . $c1 . '</td>';
    $output .= '  <td>' . $c2 . '</td>';
    $output .= '  <td>' . $c3 . '</td>';
    $output .= '  <td>' . $c4 . '</td>';
    $output .= '  <td>' . $c5 . '</td>';
    $output .= '  <td>' . $c6 . '</td>';
    $output .= '  <td>' . $c7 . '</td>';
    $output .= '</tr>';
  }
  $output .= '</table>';
  return $output;
}

$customerExperience = array(
    array('desc' => 'Nivån på vår skriftliga kommunikation? (Låg-Hög)', 'servicename' => ''),
    array('desc' => 'Kvaliteten på tjänsten? (Låg-Hög)', 'servicename' => ''),
	array('desc' => 'Prislistans utformning och enkelhet? (Låg-Hög)', 'servicename' => ''),
	array('desc' => 'Upplevelsen av våra fönsterputsare? (Låg-Hög)', 'servicename' => ''),
    array('desc' => 'Upplevelsen av våra kundtjänstmedaretare? (Låg-Hög)', 'servicename' => ''),
	array('desc' => 'Betydelsen av att företaget är välkänt? (Liten-Stor)', 'servicename' => ''),
	array('desc' => 'Hur prisvärd tjänsten är (Litet-Mycket)', 'servicename' => ''),
	array('desc' => 'Sannolikheten att du kan rekommendera oss? (Litet-Mycket)', 'servicename' => ''),
);

function getCustomerExperienceTable() {
  global $customerExperience;
  $output = <<<HTML
    <table border="0" class="tillval-table">
    <thead>
      <tr>
        <th></th>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
      </tr>
    </thead>
    <tbody>
HTML;
  $i = 1;  
  foreach ($customerExperience as $key => $value) {
    $class = $i % 2 ? 'zebra': '';
    $i++;
    $output .= '<tr class="'.$class.'">';
    $output .= '  <td ><label for="cust_exp_' . $key . '"> ' . $value['desc'] . '</label></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="1" value="1" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="2" value="2" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="3" value="3" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="4" value="4" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="5" value="5" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="6" value="6" type="radio" /></td>';
    $output .= '  <td style="text-align:center;"><input name="cust_exp_' . $key . '" id="7" value="7" type="radio" /></td>';
  }
  $output .= '</table>';
  return $output;
}

function getCustExpTableForCustomerService() {
  global $customerExperience;
  $output = <<<HTML
    <table border="1">
    <thead>
      <tr>
        <th></th>
        <th width="40px">Vet ej</th>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
      </tr>
    </thead>
    <tbody>
HTML;
  foreach ($customerExperience as $key => $value) {
    !empty($_REQUEST['cust_exp_' . $key]) ? $val = $_REQUEST['cust_exp_' . $key] : $val = '';
    $servicename = $value['desc'];
    $c1 = $c2 = $c3 = $c4 = $c5 = $c6 = $c7 = '';
    if ($val != '') {
      $c0 = $val == '0' ? 'x' : '';
      $c1 = $val == '1' ? 'x' : '';
      $c2 = $val == '2' ? 'x' : '';
      $c3 = $val == '3' ? 'x' : '';
      $c4 = $val == '4' ? 'x' : '';
      $c5 = $val == '5' ? 'x' : '';
      $c6 = $val == '6' ? 'x' : '';
      $c7 = $val == '7' ? 'x' : '';
    }
    $output .= '<tr>';
    $output .= '  <td>' . $servicename . '</td>';
    $output .= '  <td>' . $c0 . '</td>';
    $output .= '  <td>' . $c1 . '</td>';
    $output .= '  <td>' . $c2 . '</td>';
    $output .= '  <td>' . $c3 . '</td>';
    $output .= '  <td>' . $c4 . '</td>';
    $output .= '  <td>' . $c5 . '</td>';
    $output .= '  <td>' . $c6 . '</td>';
    $output .= '  <td>' . $c7 . '</td>';
    $output .= '</tr>';
  }
  $output .= '</table>';
  return $output;
}

function preSendMail($title, $message, $customer_email, $customer_name, $to_customer_service = true) {
$kundtjanst_name = "Kundtjänst Eriks Fönsterputs";
$kundtjanst_email = "kundtjanst@eriksfonsterputs.se";
//$kundtjanst_email = "adrian@jobbasmart.com";
//$kundtjanst_email = "krillo@gmail.com";    

  if ($customer_email == "") {
    $customer_name = "noreply-" . $customer_name;
    $customer_email = "noreply@eriksfonsterputs.se";
  }

  if ($customer_name == " ") {
    $customer_name = "Inget Namn";
  }

  if ($to_customer_service) {
    sendMail($title, $message, $kundtjanst_email, $kundtjanst_name, $customer_email, $customer_name);
  } else {
    sendMail($title, $message, $customer_email, $customer_name, $kundtjanst_email, $kundtjanst_name);
  }
}

/**
 * Send email, decode utf8 to latin and check for valid email 
 */
function sendMail($title, $message, $to, $to_name, $from, $from_name) {
  if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
    saveToLogFile(getLogFileName(), "Skickar email: " . $title . ", till: $to ", 'INFO');
    
/*
    $headers = 'To: ' . $to_name . ' <' . $to . '>' . "\r\n";
    $headers .= 'From: ' . $from_name . ' <' . $from . '>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\r\n";

    $title_latin = utf8_decode($title);
    $message_latin = utf8_decode($message);
    $headers_latin = utf8_decode($headers);
    $to_latin = utf8_decode($to);

    $success = mail($to_latin, $title_latin, $message_latin, $headers_latin);
*/

    $headers = 'To: ' . $to_name . ' <' . $to . '>' . "\r\n";
    $headers .= 'From: ' . $from_name . ' <' . $from . '>' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $success = mail($to, $title , $message, $headers);
  } else {
    $success = false;
  }
  if (!$success) {
    saveToLogFile(getLogFileName(), "Misslyckades att skicka email: " . $title . ", till: $to ", 'ERROR');
  }
}