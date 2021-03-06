<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
get_header();
the_post();
!empty($_REQUEST['zip']) ? $zip = $_REQUEST['zip'] : $zip = '';
!empty($_REQUEST['banner']) ? $banner = $_REQUEST['banner'] : $banner = '';
if ($banner === '1') {
  $check_zip = 'false';
} else {
  $check_zip = 'true';
}
echo $no_zip_check;
if ($zip == '') {
  $uri = $_SERVER[REQUEST_URI];
  $params = explode("/", $uri);
  $temp_zip = $params[3];
  if (is_numeric($temp_zip)) {
    $zip = $temp_zip;
  }
}
?>

<?php get_template_part('include_main_head'); ?>

<div id="main" class="standard order">

  <section>

    <div class="column grid_8">

      <h1>Beställning av fönsterputsabonnemang</h1>
      Här gör du en beställning av ett grundabonnemang hos oss. Efter beställning har du möjlighet att göra ytterligare tillval och anpassa kommande putstillfälle, t.ex. ifall du vill att vi putsar ovanvåning, uterum eller källarfönster.

      <h2 id="zip-header">Fyll i ditt postnummer för att testa om vi putsar i ditt område.</h2>
      <!--input type="text" value="Search" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" /--> 

      <!-- ////////// START PÅ KODEN FRÅN REPTILO ////////// -->


      <form action="/abonnemang/mottagen-bestallning" id="orderForm" name="orderForm" method="post" >
        <input type="hidden" value="<?php echo $zip; ?>" id="request-zip"/>
        <input type="hidden" value="<?php echo $check_zip; ?>" id="check-zip"/>
        <input type="hidden" value="op5" name="option"/>
        <ul>
          <li id="zip1-check-area">  
            <!--input name="zip1" id="zip1" value="" type="text" /-->
            <input name="zip1" id="zip1" type="text" value="Skriv ditt postnummer här" onfocus="if (this.value == this.defaultValue)
                  this.value = ''" onblur="if (this.value == '')
                  this.value = this.defaultValue" />
            <span id="zip-button-placeholder">
              <input type="submit" value="TESTA"  name="zip-button" id="zip-button-submit" class="zip-button" />
              <input type="button" value="TESTA"  name="zip-button" id="zip-button-button" class="zip-button" style="display:none;"/>
            </span>
            <div id="zip-ok" class="hidden">Ja, vi putsar i <span></span>!</div>  
            <div id="zip-nok" class="hidden">Vi verkar inte putsa i detta postnummerområde. Kontakta oss om du har frågor.</div>
          </li>

          <div id="ss-container" class="hidden">
            <!--li><label for="ss">Personnummer ÅÅÅÅMMDD-XXXX</label></li-->
            <h2>Fyll i personnummer för att hämta adressuppgifter</h2>
            <p>Vi hämtar dina adressuppgifter från folkbokföringen för att säkerställa en korrekt beställning. Om du vill ändra faktureringsadressen i efterhand, vänligen kontakta kundtjänst. Dina personuppgifter kommer att hanteras hos oss i enlighet med personuppgiftslagen. OBS, 12 siffror: YYYYMMDD-XXXX</p>
            <li>
              <input name="ss" id="ss" type="text" value="ÅÅÅÅMMDD-XXXX" onfocus="if (this.value == this.defaultValue)
                  this.value = ''" onblur="if (this.value == '')
                  this.value = this.defaultValue" />
              <span id="ss-button-placeholder">
                <input type="submit" value="HÄMTA" id="ss-button-submit" name="ss-button" class="ss-button" />
                <input type="button" value="HÄMTA" id="ss-button-button" name="ss-button" class="ss-button" style="display:none;"/>
              </span>  
              <img id="ss-progress" src="<?php bloginfo('stylesheet_directory'); ?>/img/inline/ajax-loader.gif" alt="" />
            </li>  
          </div>

          <div id="ss-error" class="hidden invalid">Personnumret verkar vara felaktigt.</div>

          <div id="pers-container" class="hidden">

            <fieldset class="fieldset-address">

              <h2>Adress</h2>
              <li><label for="email">E-post</label></li>
              <li><input name="email" id="email" value="" type="text"/></li>

              <li><label for="firstname_show">Förnamn <span class="mandatory">*</span></label></li>
              <li><input name="firstname_show" id="firstname_show" value="" type="text" disabled/></li>
              <li><input name="firstname" id="firstname" value="" type="hidden" /></li>

              <li><label for="lastname_show">Efternamn <span>*</span></label></li>
              <li><input name="lastname_show" id="lastname_show" value="" type="text" disabled/></li>
              <li><input name="lastname" id="lastname" value="" type="hidden" /></li>

              <li><label for="street1_show">Adress <span>*</span></label>&nbsp;&nbsp;<label for="show_extra">(Jag vill putsa på annan adress</label> <input name="show_extra" id="show_extra" value="" type="checkbox"/>)</li>
              <li><input name="street1_show" id="street1_show" value="" type="text" disabled/></li>
              <li><input name="street1" id="street1" value="" type="hidden" /></li>

              <li><label for="zip_show">Postnr <span>*</span></label></li>
              <li><input name="zip_show" id="zip_show" value="" type="text" disabled/></li>
              <li><input name="zip" id="zip" value="" type="hidden" /></li>

              <li><label for="city_show">Ort <span>*</span></label></li>
              <li><input name="city_show" id="city_show" value="" type="text" disabled/></li>
              <li><input name="city" id="city" value="" type="hidden" /></li>

              <li><label for="phone">Telefon</label></li>
              <li><input name="phone" id="phone" value="" type="text" class="tel"/></li>

              <li><label for="mobile">Mobiltelefon</label></li>
              <li><input name="mobile" id="mobile" value="" type="text" class="tel"/></li>		

              <br />
            </fieldset>

            <fieldset id="extra-address" class="fieldset-address">
              <h2>Putsa på följande adress:</h2>
              <li><label for="ex_firstname">Förnamn <span>*</span></label></li>
              <li><input name="ex_firstname" id="ex_firstname" value="" type="text" /></li>

              <li><label for="ex_lastname">Efternamn <span>*</span></label></li>
              <li><input name="ex_lastname" id="ex_lastname" value="" type="text" /></li>

              <li><label for="ex_street1">Leveransadress <span>*</span></label></li>
              <li><input name="ex_street1" id="ex_street1" value="" type="text" /></li>

              <li><label for="ex_zip">Postnr <span>*</span></label></li>
              <li><input name="ex_zip" id="ex_zip" value="" type="text" /></li>

              <li><label for="ex_city">Ort <span>*</span></label></li>
              <li><input name="ex_city" id="ex_city" value="" type="text"/></li>

              <li><label for="ex_phone">Telefon</label></li>
              <li><input name="ex_phone" id="ex_phone" value="" type="text"/></li>

              <li><label for="ex_mobile">Mobiltelefon</label></li>
              <li><input name="ex_mobile" id="ex_mobile" value="" type="text"/></li>		

              <li><label for="ex_email">E-post</label></li>
              <li><input name="ex_email" id="ex_email" value="" type="text"/></li>
            </fieldset>
            <div class="clear"></div>


            <fieldset style="float:left;">
              <h2>Vad fick dig att beställa av oss?</h2>
              <li>
                <select class="" name="why" id="why">
                  <option label="Välj..." value="">Välj gärna en</option>
                  <option label="" value="Direktreklam">Direktreklam i brevlådan</option>
                  <option label="" value="Rekommendation">Rekommendation</option>
                  <option label="" value="Tidningsannons">Tidningsannons</option>
                  <option label="" value="Radioreklam">Radioreklam</option>
                  <option label="" value="TV-reklam">TV-reklam</option>
                  <option label="" value="Närvaro på köpcentrum">Närvaro på köpcentrum</option>
                  <option label="" value="Närvaro på mässa">Närvaro på mässa</option>
                  <option label="" value="Våra bilar">Våra bilar</option>
                  <option label="" value="Annat (ange gärna i textruta)">Annat (ange gärna i textruta)</option>
                </select>
            </fieldset>

            <fieldset style="float:left;margin-left:40px">
              <h2>Ange eventuell kampanjkod</h2>
              <li><input name="campaign_code" id="campaign_code" value="" type="text"/></li>
            </fieldset>
            <div class="clear"></div>

            <fieldset>
              <h2>Övriga val</h2>
              <p><b>Ytterligare tillval kommer du att kunna beställa efteråt i ett separat formulär.</b></p>
              <li>
                <input name="o2" id="o2" type="checkbox" value="JA"/>
                <label for="o2"> Mitt hus har fler än 20 fönsterrutor och jag vet att det kostar extra. (1 fönsterruta = 1kvm glas)</label>
              </li>
              <li>
                <input name="o3" id="o3" type="checkbox" value="JA"/>
                <label for="o3"> Mina fönster har spröjs och jag vet att det kostar extra.</label>
              </li>
              <li>
                <input name="o4" id="o4" type="checkbox" value="JA"/>
                <label for="o4"> Jag vill även ha TILLVAL rengöring av fönsterbleck. </label>
              </li>

            </fieldset>
            <fieldset>
              <p><b>Välj om du vill ha skattereduktion gällande husarbete (RUT-avdrag)</b></p>
              <li>
                <input name="rut" id="rutYes" value="JA" type="radio" checked/>
                <label for="rutYes">Ja, jag vill ha skattereduktion och känner till hur det fungerar.</label>
              </li>
              <li>
                <input name="rut" id="rutNo" value="NEJ" type="radio" />
                <label for="rutNo">Nej, jag vill <b>inte</b> ha skattereduktion.</label>
              </li>

            </fieldset>			

            <fieldset>
              <li>
                <label class="comments" for="comments">Ytterligare information:</label>
                <textarea name="comments" id="comments" placeholder="Plats för mer information till kundtjänst. Tillval gör du enklast i efterföljande formulär."></textarea>
              </li>
            </fieldset>

            <fieldset>				
              <li><a href="#" target="_blank" id="terms-link">Läs villkoren</a> <a href="#" target="_blank" id="price-link">Se prislista 2013</a> <a href="#" target="_blank" id="rut-info-link">Om RUT-avdrag</a></li>
              <li>&nbsp;</li>
              <li>
                <input name="terms" id="terms" type="checkbox" style="float:left;" value ="Ja"/>
                <label for="terms"><b>Ja tack!</b></label> Jag vill abonnera på utvändig fönsterputsning av bottenvåning 6-7 gånger per år. Jag betalar inget i förskott, inget kontant. Jag får faktura efter utförd putsning. Jag har läst och godkänner villkor, prislista och övrig information.
              </li>
              <li>&nbsp;</li>
            </fieldset>
            <p> </p>
            <li><input type="submit" value="Beställ"></li>

          </div>

        </ul>

      </form>



      <script type="text/javascript">
              jQuery(document).ready(function($) {
                $("#ss-progress").hide();
                $("#extra-address").hide();
                var check_zip = $('#check-zip').val();
                if (check_zip === 'false') {
                  hideZipCheck();
                  showSSForm();
                }
                var request_zip = $('#request-zip').val();
                if (request_zip != '') {
                  $('#zip1').val(request_zip);
                  checkValidZip(request_zip);
                }

                //extend validator - add require_from_group  http://stackoverflow.com/a/9202684
                jQuery.validator.addMethod("require_from_group", function(value, element, options) {
                  var numberRequired = options[0],
                          selector = options[1],
                          $fields = $(selector, element.form),
                          validOrNot = $fields.filter(function() {
                    return $(this).val();
                  }).length >= numberRequired,
                          validator = this;
                  if (!$(element).data('being_validated')) {
                    $fields.data('being_validated', true).each(function() {
                      validator.valid(this);
                    }).data('being_validated', false);
                  }
                  return validOrNot;
                }, jQuery.format("Please fill out at least {0} of these fields."));


                // validate signup form on keyup and submit
                var validator = $("#orderForm").validate({
                  errorClass: "invalid",
                  validClass: "valid",
                  rules: {
                    firstname: "required",
                    lastname: "required",
                    street1: {
                      required: true,
                      minlength: 3
                    },
                    zip: {
                      required: true,
                      minlength: 5
                    },
                    city: "required",
                    ss: {
                      required: true,
                      minlength: 12,
                      maxlength: 13
                    },
                    /*extra address*/
                    ex_firstname: "required",
                    ex_lastname: "required",
                    ex_street1: {
                      required: true,
                      minlength: 3
                    },
                    ex_zip: {
                      required: true,
                      minlength: 5
                    },
                    ex_city: "required",
                    phone: {require_from_group: [1, ".tel"]},
                    mobile: {require_from_group: [1, ".tel"]},
                    rut: "required",
                    terms: "required"
                  },
                  messages: {
                    firstname: "",
                    lastname: "",
                    street1: {
                      required: "",
                      minlength: ""
                    },
                    zip: {
                      required: "",
                      minlength: ""
                    },
                    city: "",
                    ss: {
                      required: "Ange personnummer!",
                      minlength: "Ange ett korrekt personnummer i formatet ÅÅÅÅMMDD-XXXX!",
                      maxlength: "Ange ett korrekt personnummer i formatet ÅÅÅÅMMDD-XXXX!"
                    },
                    /*extra address*/
                    ex_firstname: "",
                    ex_lastname: "",
                    ex_street1: {
                      required: "",
                      minlength: ""
                    },
                    ex_zip: {
                      required: "",
                      minlength: ""
                    },
                    ex_city: "",
                    phone: "Ange minst ett telefonnummer",
                    mobile: "Ange minst ett telefonnummer",
                    rut: "Välj om du vill ha skattereduktion eller inte!",
                    terms: "Tacka ja för att genomföra beställningen!"
                  },
                  success: function(label) {
                    // set &nbsp; as text for IE
                    label.html("&nbsp;").addClass("checked");
                  }
                });



                /**
                 * Ajax call to check for valid zip
                 */
                function checkValidZip(zip) {
                  $("#zip-button-submit").hide();
                  $("#zip-button-button").show();
                  var data = {
                    action: 'check_zip',
                    zip: zip
                  };
                  $.post('/wp-admin/admin-ajax.php', data, function(response) {
                    if (response.success == 1) {
                      showZipOK(response);
                      showSSForm();
                    } else {
                      showZipNOK();
                    }
                  });
                }

                function showZipNOK() {
                  $("#zip-nok").removeClass("hidden");
                  $("#zip-ok").addClass("hidden");
                  $("#ss-container").addClass("hidden");
                }

                function showZipOK(response) {
                  $("#zip-ok span").html(response.city);
                  $("#zip-nok").addClass("hidden");
                }


                function showSSForm() {
                  $("#zip-ok").removeClass("hidden");
                  $("#ss-container").removeClass("hidden");
                  //ugly IE 8 fix
                  //IE8 doesn't allow changeing property from submit to button
                  // clone, modify, remove, add  
                  //$("#zip-button").prop('type','button');
                  //var zipButton = $(".zip-button").clone();
                  //zipButton.prop('type','button');
                  //$(".zip-button").remove();
                  //$("#zip-button-placeholder").html(zipButton);
                }


                function hideZipCheck() {
                  $("#zip-header").addClass("hidden");
                  $("#zip1-check-area").addClass("hidden");
                }



                $(".zip-button").click(function(event) {
                  event.preventDefault();
                  zip = $('#zip1').val();
                  checkValidZip(zip);
                });


                /**
                 * if enter is pressed in the #ss input box, do the persInfo lookup
                 */
                $('#ss').keypress(function(event) {
                  if (event.which == 13 && $(this).val().length >= 10) {
                    getPersInfo(event);
                  }
                });


                /**
                 * Do the persInfo lookup
                 */
                $(".ss-button").click(function(event) {
                  event.preventDefault();
                  getPersInfo(event);
                });


                /**
                 * Ajax call to get peronal info
                 */
                function getPersInfo(event) {
                  event.preventDefault();
                  $("#ss-button-submit").hide();
                  $("#ss-button-button").show();

                  $("#ss-progress").css("display", "block");    //show progress wheel
                  ss = $('#ss').val();
                  var data = {
                    action: 'get_pers_info',
                    ss: ss
                  };
                  $.post('/wp-admin/admin-ajax.php', data, function(response) {
                    $("#ss-progress").hide();
                    if (response.success == 1) {
                      $("#pers-container").removeClass("hidden");

                      //ugly IE 8 fix
                      //IE8 doesn't allow changeing property from submit to button
                      // clone, modify, remove, add  
                      //$("#ss-button").prop('type','button'); 
                      //var ssButton = $(".ss-button").clone();
                      //ssButton.prop('type','button');
                      //$(".ss-button").remove();
                      //$("#ss-button-placeholder").html(ssButton);

                      $("#ss-error").addClass("hidden");
                      $("#firstname").val(response.fname);
                      $("#firstname_show").val(response.fname);
                      $("#lastname").val(response.lname);
                      $("#lastname_show").val(response.lname);
                      $("#street1").val(response.street1);
                      $("#street1_show").val(response.street1);
                      $("#street2").val(response.street2);
                      $("#zip").val(response.zip);
                      $("#zip_show").val(response.zip);
                      $("#city").val(response.city);
                      $("#city_show").val(response.city);
                      $("#phone").val(response.phone);
                      $("#email").val(response.email);
                    } else {
                      $("#ss-error").removeClass("hidden");
                      $("#pers-container").addClass("hidden");
                    }
                  });
                }





                //company show or hide delicery address
                $('#show_extra').click(function(event) {
                  if ($(this).is(':checked')) {
                    $('#extra-address').show('slow');
                  } else {
                    $('#extra-address').hide('slow');
                  }
                });


                // read email as soon as it is entered and store it in db   
                $("#email").focusout(function() {
                  updateUppslag();
                });

                // read phone as soon as it is entered and store it in db   
                $("#phone").focusout(function() {
                  updateUppslag();
                });

                // read mobile as soon as it is entered and store it in db   
                $("#mobile").focusout(function() {
                  updateUppslag();
                });

                // read email, mobile and phone as soon as it is entered and store it in db   
                function updateUppslag() {
                  var email = $('#email').val();
                  var mobile = $('#mobile').val();
                  var phone = $('#phone').val();
                  var data = {
                    action: 'updateUppslag',
                    email: email,
                    mobile: mobile,
                    phone: phone,
                  };
                  $.post('/wp-admin/admin-ajax.php', data, function(response) {
                    if (response.success == 1) {
                    } else {

                    }
                  });
                }


              });
      </script>

      <!-- ////////// SLUT PÅ KODEN FRÅN REPTILO ////////// -->

    </div>

    <div class="column grid_4">

      <?php $p = array_shift(get_posts("post_type=template-content&p=90")); ?>
      <?php echo $p->post_content; ?>



    </div>

  </section> <!-- //section -->

</div> <!-- //main -->

<div id="terms-overlay" class="hidden overlay">
  <div class ="text-overlay">
    <?php $terms = array_shift(get_posts("post_type=template-content&p=568")); ?>
    <?php echo $terms->post_content; ?>
  </div>
  <span class="close-text-overlay">Stäng</span>
</div>

<div id="rut-info-overlay" class="hidden overlay">
  <div class="text-overlay">
    <?php $rut = array_shift(get_posts("post_type=template-content&p=583")); ?>
    <?php echo $rut->post_content; ?>
  </div>
  <span class="close-text-overlay">Stäng</span>
</div>

<div id="price-overlay" class="hidden overlay">
  <img id="price-overlay-img" src="http://eriksfonsterputs.se/wp-content/uploads/prislista2013.png" alt="Prislista 2013" />
  <span class="close-text-overlay close-price-overlay">Stäng</span>
</div>

<?php get_footer(); ?>
