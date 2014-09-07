<?php
/*
 * Template Name: Tack
 * Description: This page collects all register data, logs to file and then send a mail to customer service and to the customer  
 * Author: Kristian Erendi
 * Author URI: http://reptilo.se 
 * Date: 2013-01-23
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
global $order;
$order = new stdClass;
!empty($_REQUEST['firstname']) ? $order->fname = $_REQUEST['firstname'] : $order->fname = '';
!empty($_REQUEST['lastname']) ? $order->lname = $_REQUEST['lastname'] : $order->lname = '';
!empty($_REQUEST['phone']) ? $order->phone = $_REQUEST['phone'] : $order->phone = '';
!empty($_REQUEST['mobile']) ? $order->mobile = $_REQUEST['mobile'] : $order->mobile = '';
!empty($_REQUEST['street1']) ? $order->street = $_REQUEST['street1'] : $order->street = '';
!empty($_REQUEST['street2']) ? $order->street = $order->street . ' ;; ' . $_REQUEST['street2'] : null;
!empty($_REQUEST['zip']) ? $order->zip = $_REQUEST['zip'] : $order->zip = '';
!empty($_REQUEST['city']) ? $order->city = $_REQUEST['city'] : $order->city = '';
!empty($_REQUEST['email']) ? $order->email = $_REQUEST['email'] : $order->email = '';
!empty($_REQUEST['rut']) ? $order->rut = $_REQUEST['rut'] : $order->rut = '';
!empty($_REQUEST['o2']) ? $order->o2 = $_REQUEST['o2'] : $order->o2 = 'Nej';
!empty($_REQUEST['o3']) ? $order->o3 = $_REQUEST['o3'] : $order->o3 = 'Nej';
!empty($_REQUEST['o4']) ? $order->o4 = $_REQUEST['o4'] : $order->o4 = 'Nej';
!empty($_REQUEST['comments']) ? $order->comments = $_REQUEST['comments'] : $order->comments = '';
!empty($_REQUEST['ss']) ? $order->ss = $_REQUEST['ss'] : $order->ss = '';
!empty($_REQUEST['ex_firstname']) ? $order->ex_fname = $_REQUEST['ex_firstname'] : $order->ex_fname = '';
!empty($_REQUEST['ex_lastname']) ? $order->ex_lname = $_REQUEST['ex_lastname'] : $order->ex_lname = '';
!empty($_REQUEST['ex_phone']) ? $order->ex_phone = $_REQUEST['ex_phone'] : $order->ex_phone = '';
!empty($_REQUEST['ex_mobile']) ? $order->ex_mobile = $_REQUEST['ex_mobile'] : $order->ex_mobile = '';
!empty($_REQUEST['ex_street1']) ? $order->ex_street = $_REQUEST['ex_street1'] : $order->ex_street = '';
!empty($_REQUEST['ex_street2']) ? $order->ex_street = $order->ex_street . ' ;; ' . $_REQUEST['ex_street2'] : null;
!empty($_REQUEST['ex_zip']) ? $order->ex_zip = $_REQUEST['ex_zip'] : $order->ex_zip = '';
!empty($_REQUEST['ex_city']) ? $order->ex_city = $_REQUEST['ex_city'] : $order->ex_city = '';
!empty($_REQUEST['ex_email']) ? $order->ex_email = $_REQUEST['ex_email'] : $order->ex_email = '';
!empty($_REQUEST['option']) ? $order->option = $_REQUEST['option'] : $order->option = '';
!empty($_REQUEST['customernbr']) ? $order->customernbr = $_REQUEST['customernbr'] : $order->customernbr = '';
!empty($_REQUEST['rutchange']) ? $order->rutchange = $_REQUEST['rutchange'] : $order->rutchange = '';
!empty($_REQUEST['period']) ? $order->period = $_REQUEST['period'] : $order->period = '';
!empty($_REQUEST['tillval']) ? $order->tillval = $_REQUEST['tillval'] : $order->tillval = '';
!empty($_REQUEST['avbokning']) ? $order->avbokning = $_REQUEST['avbokning'] : $order->avbokning = '';
!empty($_REQUEST['from']) ? $order->from = $_REQUEST['from'] : $order->from = '';
!empty($_REQUEST['to']) ? $order->to = $_REQUEST['to'] : $order->to = '';
!empty($_REQUEST['terms']) ? $order->terms = $_REQUEST['terms'] : $order->terms = 'Nej';
!empty($_REQUEST['vem']) ? $order->vem = $_REQUEST['vem'] : $order->vem = '';
!empty($_REQUEST['why']) ? $order->why = $_REQUEST['why'] : $order->why = '';
!empty($_REQUEST['campaign_code']) ? $order->campaign_code = $_REQUEST['campaign_code'] : $order->campaign_code = '';

//uppsagning
!empty($_REQUEST['uppsagning']) ? $order->uppsagning = $_REQUEST['uppsagning'] : $order->uppsagning = '';
!empty($_REQUEST['extra-date1']) ? $order->extradate1 = $_REQUEST['extra-date1'] : $order->extradate1 = '';
!empty($_REQUEST['extra-date6']) ? $order->extradate6 = $_REQUEST['extra-date6'] : $order->extradate6 = '';
!empty($_REQUEST['cancelation-date']) ? $order->cancelationdate = $_REQUEST['cancelation-date'] : $order->cancelationdate = '';
!empty($_REQUEST['comments1']) ? $order->comments1 = $_REQUEST['comments1'] : $order->comments1 = '';
!empty($_REQUEST['comments2']) ? $order->comments2 = $_REQUEST['comments2'] : $order->comments2 = '';
!empty($_REQUEST['comments7']) ? $order->comments7 = $_REQUEST['comments7'] : $order->comments7 = '';



$logfile = getLogFileName();
$data = print_r($order, true);


if ($order->option != '') {
  switch ($order->option) {
    case 'op1':
      $title = 'FÖRÄNDRING - ';
      if ($order->tillval == 'tillval1') {
        $title .= 'Lägg till';
      }
      if ($order->tillval == 'tillval2') {
        $title .= 'Detaljerat varje år';
      }
      if ($order->tillval == 'tillval3') {
        $title .= 'Ta bort';
      }
	 //adrian lagt till nummer 4
	  if ($order->tillval == 'tillval4') {
        $title .= 'Tillfällig bokning';
      }
      saveToLogFile($logfile, $title . " \n" . $data, 'INFO');
      $message .= '<strong>' . $title . "</strong><br>";
      $message .= efp_getKundnummer();
      $message .= efp_getAddress();
      $message .= 'RUT - ' . $order->rutchange . "<br><br>";
      $message .= getTillvalTableForCustomerService() . "<br><br>";
      $message .= "Egen kommentar: $order->comments<br/>";
      $message .= "<br/><br/>";
      $message .= efp_getDate();
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, true);
      break;
    case 'op2':
      $title = 'FÖRÄNDRING - Tillfällig avbokning';
      saveToLogFile($logfile, $title . " \n" . $data, 'INFO');
      $message .= '<strong>' . $title . "</strong><br>";
      $message .= efp_getKundnummer();
      $message .= efp_getAddress();
      $message .= 'Önskad bokning/avbokning mellan ' . $order->from . ' och ' . $order->to . '<br/>';
      $message .= efp_getAvbokninMsg();
      $message .= "<br/><br/>";
      $message .= "Egen kommentar: $order->comments<br/>";
      $message .= "<br/><br/>Klientinformation<br />";
      $message .= efp_getDate();
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, true);
      break;
    case 'op3':
      $title = 'FÖRÄNDRING - Uppgifter';
      saveToLogFile($logfile, $title . " \n" . $data, 'INFO');
      $message .= '<strong>' . $title . "</strong><br>";
      $message .= efp_getDate();
      $message .= efp_getKundnummer();
      $message .= efp_getAddress();
      $message .= 'RUT - ' . $order->rutchange . "<br><br>";
      $message .= "Egen kommentar: $order->comments<br/>";
      $message .= "<br/><br/>Klientinformation<br />";
      $message .= efp_getDate();
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, true);
      break;
    case 'op4':
      $extraDate = '';
      $kommentar = '';
      switch ($order->uppsagning) {
        case 1:
          $title = 'UPPSÄGNING - Flytt';
          $extraDate = "Flyttdatum: " . $order->extradate1 . "<br/>";
          $kommentar = "Kommentar: " . $order->comments1 . "<br/>";
          break;
        case 2:
          $title = 'UPPSÄGNING - Missnöjd med kvaliteten';
          $kommentar = "Kommentar: " . $order->comments1 . "<br/>";
          break;
        case 3:
          $title = 'UPPSÄGNING - För dyrt';
          break;
        case 4:
          $title = 'UPPSÄGNING - Ville bara testa';
          break;
        case 5:
          $title = 'UPPSÄGNING - Avliden';
          break;
        case 6:
          $title = 'UPPSÄGNING - Renovera';
          $extraDate = "Klar med renoveringen " . $order->extradate6 . "<br/>";
          break;
        case 7:
          $title = 'UPPSÄGNING - Annan anledning';
          $kommentar = "Kommentar: " . $order->comments1 . "<br/>";
          break;
        default:
          $title = 'UPPSÄGNING';
          break;
      }
      saveToLogFile($logfile, $title . " \n" . $data, 'INFO');
      $message .= '<strong>' . $title . "</strong><br/><br/>";
      $message .= efp_getVem();
      $message .= efp_getKundnummer();
      $message .= efp_getAddress();
      $message .= "Uppsägningdatum: $order->cancelationdate<br/>";
      $message .= $extraDate;
      $message .= $kommentar;
      $message .= getCustExpTableForCustomerService() . "<br><br>";
      $message .= "<br/><br/>Klientinformation<br />";
      $message .= efp_getDate();
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, true);
      break;
    case 'op5':
      $title = 'BESTÄLLNING';
      saveToLogFile($logfile, $title . "\n" . $data, 'INFO');
      $message .= '<strong>' . $title . "</strong><br>";
      $message .= efp_getKundnummer();
      $message .= efp_getAddress();
      $message .= efp_getNykundExtra();      
      $message .= "Vad fick dig att beställa: $order->why<br/>";
      $message .= "Kampanjkod: $order->campaign_code<br/>";
      $message .= "Egen kommentar: $order->comments<br/>";
      $message .= "<br/><br/>Klientinformation<br />";
      $message .= efp_getDate();
      //send to kundservice
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, true);
      //send to customer
      $titleKund = 'Välkommen till Eriks Fönsterputs';
      $message = "Hej $order->fname,<br/><br/>";
      $message .= "Välkommen som kund hos Eriks Fönsterputs!<br/><br/>";
      $message .= "<b>Vi har mottagit din beställning av fönsterputsabonnemang enligt nedanstående:</b><br/>";
      $message .= efp_getAddress();
      $message .= efp_getNykundExtra();
      $message .= "- Vill du göra anpassningar av ditt abonnemang kan du göra det genom att <a href=\"http://eriksfonsterputs.se/abonnemang/forandring/\">klicka här</a><br />";
	  $message .= "- Vi erbjuder e-faktura till alla våra kunder, anmäl dig redan nu via din internetbank!<br />";
	  $message .= "- Har du ytterligare frågor, var vänlig och besök <a href=\"http://eriksfonsterputs.se/fragor-svar/allmanna-fragor/\">frågor och svar</a> på vår hemsida alternativt kontakta kundtjänst på 0771-42 42 42.";
      preSendMail($title, $message, $order->email, $order->fname . " " . $order->lname, false);
      break;
    default:
      saveToLogFile($logfile, "Tacksidan visas utan att skicka mail, data saknas!? \n" . $data, 'ERROR');
      break;
  }
}

/**
 * Return the adderss
 * @return type 
 */
function efp_getAddress() {
  global $order;
  $message = "$order->ss<br/>";
  $message .= "$order->fname  $order->lname <br/>";
  $message .= "$order->street<br/>";
  $message .= "$order->zip  $order->city <br/>";
  $message .= "Telefon: $order->phone<br/>";
  $message .= "Mobiltelefon: $order->mobile<br/>";
  $message .= "Email: $order->email<br/><br/>";
  if ($order->ex_street != '') {
    $message .= "<br/><strong>Putsa på annan adress:</strong><br/>";
    $message .= "$order->ex_fname  $order->ex_lname <br/>";
    $message .= "$order->ex_street<br/>";
    $message .= "$order->ex_zip  $order->ex_city <br/>";
    $message .= "Telefon: $order->ex_phone<br/>";
    $message .= "Mobiltelefon: $order->ex_mobile<br/>";
    $message .= "Email: $order->ex_email<br/>";
  }
  return $message;
}

/**
 * Just return the date, formated
 * @return string 
 */
function efp_getDate() {
  $message = date("Y-m-d H:i:s") . "<br/>" . $_SERVER['REMOTE_ADDR'] . "<br/>" . $_SERVER['HTTP_USER_AGENT'] . "<br/>";
  return $message;
}

function efp_getKundnummer() {
  global $order;
  $message = "Kundnummer: $order->customernbr<br/><br/>";
  return $message;
}

function efp_getNykundExtra() {
  global $order;
  $message = "<br/>RUT: $order->rut<br/>";
  $message .= "Fler än 20 fönster: $order->o2<br/>";
  $message .= "Godkänt kostnad för spröjs: $order->o3<br/>";
  $message .= "Fönsterbleck beställt: $order->o4<br/>";
  $message .= "Villkor godkända: $order->terms<br/><br/>";
  return $message;
}

function efp_getVem() {
  global $order;
  $msg = 'Vi kommer att lösa fönsterputsningen såhär: <br/> &nbsp;&nbsp;';
  switch ($order->vem) {
    case 1:
      $msg .= 'Genom att putsa själva';
      break;
    case 2:
      $msg .= 'En städfirma gör det åt oss';
      break;
    case 3:
      $msg .= 'Ett annat fönsterputsföretag gör det åt oss';
      break;
    case 4:
      $msg .= 'Vi kommer inte att putsa våra fönster';
      break;
    default:
      $msg .= ' - ';
      break;
  }
  $msg .= "<br/><br/>";
  return $msg;
}

function efp_getAvbokninMsg() {
  global $order;
  $message = '';
  if (in_array('1', $order->avbokning)) {
    $message .= in_array('1', $order->avbokning) ? 'Hela putstillfället <br/>' : '';
  } else {
    $message .= in_array('2', $order->avbokning) ? 'Spröjs på<br/>' : '';
    $message .= in_array('3', $order->avbokning) ? 'Rengöring spröjs<br/>' : '';
    $message .= in_array('4', $order->avbokning) ? 'Bleck<br/>' : '';
    $message .= in_array('5', $order->avbokning) ? 'Karmar<br/>' : '';
    $message .= in_array('6', $order->avbokning) ? 'Uterum<br/>' : '';
    $message .= in_array('7', $order->avbokning) ? 'Ovanvåning<br/>' : '';
    $message .= in_array('8', $order->avbokning) ? 'Källare<br/>' : '';
  }
  return $message;
}
?>



<?php
get_header();
the_post();
?>
<?php get_template_part('include_main_head'); ?>

<div id="main" class="standard">

  <section>

    <div class="column grid_8">

      <h1><?php the_title(); ?></h1>
<?php the_content(); ?>

    </div>

    <div class="column grid_4">

      <p><strong>Abonnera på</strong> fönsterputs:</p>
      <p>- snabbt och enkelt!</p>

      <form action="/abonnemang/bestallning" id="orderForm" name="orderForm" method="post" >
        <ul>
          <!--li><label for="zip">Postnr</label></li-->
          <li>  
            <input name="zip" id="zip" value="Skriv ditt postnummer här" type="text" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
            <input type="submit" value="Testa om vi putsar där du bor" id="zip-button">
          </li>
        </ul>
      </form>

      <!--hr />
      
      <p class="rut"><img src="<?php bloginfo('template_directory'); ?>/img/inline/halva-priset.png" /></p-->

      <hr />

      <?php $p = array_shift(get_posts("post_type=template-content&p=90")); ?>
<?php echo $p->post_content; ?>

    </div>

  </section> <!-- //section -->

</div> <!-- //main -->

<?php get_footer(); ?>