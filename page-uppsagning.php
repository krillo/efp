<?php
/*
 * Description: This is where the customer chages her cleaning subscription and send a mail to customer service and to the customer  
 * Author: Kristian Erendi
 * Author URI: http://reptilo.se 
 * Date: 2013-01-23
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
get_header();
the_post();
?>
<?php get_template_part('include_main_head'); ?>
<div id="main" class="standard order" style="min-height: 800px;">
  <section>
    <div class="column grid_8">
      <h1>Uppsägning av ditt abonnemang</h1>

      <form action="/abonnemang/mottagen-uppsagning/" id="orderForm" name="orderForm" method="post" >
        <input name="option" id="op4" value="op4" type="hidden" />
        <ul>
          <div id="pers-container" class="">
            <fieldset class="fieldset-address">
              <li><label for="firstname">Förnamn <span class="mandatory">*</span></label></li>
              <li><input name="firstname" id="firstname" value="" type="text" /></li>
              <!--li><input name="firstname" id="firstname" value="" type="hidden" /></li-->
              <li><label for="lastname">Efternamn <span>*</span></label></li>
              <li><input name="lastname" id="lastname" value="" type="text" /></li>
              <!--li><input name="lastname" id="lastname" value="" type="hidden" /></li-->
              <li><label for="street1">Adress <span>*</span></label></li>
              <li><input name="street1" id="street1" value="" type="text" /></li>
              <!--li><input name="street1" id="street1" value="" type="hidden" /></li-->
              <li><label for="zip">Postnr <span>*</span></label></li>
              <li><input name="zip" id="zip" value="" type="text" /></li>
              <!--li><input name="zip" id="zip" value="" type="hidden" /></li-->
              <li><label for="city">Ort <span>*</span></label></li>
              <li><input name="city" id="city" value="" type="text" /></li>
              <!--li><input name="city" id="city" value="" type="hidden" /></li-->              
            </fieldset>
            <fieldset class="fieldset-address">
              <li><label for="phone">Telefon</label></li>
              <li><input name="phone" id="phone" value="" type="text"/></li>
              <li><label for="mobile">Mobiltelefon</label></li>
              <li><input name="mobile" id="mobile" value="" type="text"/></li>		
              <li><label for="email">E-post</label></li>
              <li><input name="email" id="email" value="" type="text"/></li>
              <li><label for="customernbr">Kundnummer <span>*</span></label></li>
              <li><input name="customernbr" id="customernbr" value="" type="text"/></li>
            </fieldset>
          </div>  
          <div class="clear"></div>




          <fieldset id="uppsagning" class="tillval">
            OBS! Uppsägning kan göras när som helst, dock ej under påbörjad putsperiod.
            <h2>Jag vill säga upp mitt abonnemang på grund av</h2>
            <select name="uppsagning" id="uppsagning-op">
              <option value="0">Välj...</option>
              <option value="1">Flytt</option>
              <option value="2">Missnöjd med kvaliteten på utförandet</option>
              <option value="3">Att det är för dyrt</option>
              <option value="4">Ville bara testa hur det fungerade</option>
              <option value="5">Personen är avliden</option>
              <option value="6">Vi ska renovera under en period</option>
              <option value="7">Annan anledning</option>
            </select>
          </fieldset>          

          <fieldset id="" class="tillval">
            <li class="hidden" id="uppsagning-op-1">
              <p>Vill du istället flytta abonnemanget till din nya adress?<br/>
                Om du vill flytta abonnemanget till din nya adress, vänligen ange adress och datum för flytt här:</p>
              <textarea name="comments1" id="comments-op-1" placeholder="" class=""></textarea>
              <input type="text" class="extra-date" name="extra-date1" />
            </li>
            <li class="hidden" id="uppsagning-op-2">
              <p>Var vänlig och beskriv vad som hänt och när det skedde så att vi inte gör om samma misstag igen:</p>
              <textarea name="comments2" id="comments-op-2" placeholder=""></textarea>
            </li>
            <li class="hidden" id="uppsagning-op-3">
              <p>Visste du att du kan förändra ditt abonnemang in i minsta detalj så att det inte blir lika dyrt varje gång?</p>
              <a href="/bestallning/forandring/">Förändra abonnemang</a>
            </li>
            <li class="hidden" id="uppsagning-op-4">
              <p>Skulle du kunna tänka dig att bli kund hos oss igen, önskar vi dig varmt välkommen.</p>
            </li>
            <li class="hidden" id="uppsagning-op-5">
              <p>Vill du istället skriva över abonnemanget på en annan person i hushållet?</p>
              <a href="/bestallning/forandring/">Ändra uppgifter</a>
            </li>  
            <li class="hidden" id="uppsagning-op-6">
              <p>Välj ett datum då du tror att renoveringen är färdig och att du vill att vi kontaktar dig för att se om du vill sätta igång abonnemanget igen:</p>
              <input type="text" class="extra-date" name="extra-date6" style="margin-left: 0;"/>
            </li>
            <li class="hidden" id="uppsagning-op-7">
              <p>Vänligen ange i rutan nedan orsaken till att du säger upp ditt abonnemang.</p>
              <textarea name="comments3" id="comments-op-7" placeholder="" class=""></textarea>
            </li>
          </fieldset>


            <fieldset id="cancelation-datepicker" class="hidden">
              <h2>Jag önskar att uppsägningen träder i kraft från och med..</h2>
              <input type="text" id="cancelation-date" name="cancelation-date" style="width:100px;"/>
              <p>Vi inte kan garantera att uppsägning är möjlig ifall putsperioden är påbörjad.</p>
            </fieldset>

            <fieldset id="customer-experience" class="hidden">
              <h2>Vänligen gradera nedanstående frågor</h2>
			  <p>Gradera så att siffran 1 motsvarar ett lågt omdöme och siffran 7 motsvarar ett högt omdöme
              <?php echo getCustomerExperienceTable(); ?>
              <li><input type="submit" value="Skicka"></li>
            </fieldset>
            <fieldset id="send" class="hidden">

            </fieldset>          

        </ul>
      </form>
      <script type="text/javascript">
        jQuery(document).ready(function($){   
          $("#ss-progress").hide();
          $("#tillval").hide();
    
    
          $( ".extra-date" ).datepicker({
            firstDay: 1,
            monthNames: ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'],
            dayNamesMin: [ 'sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'],
            dateFormat: 'yy-mm-dd',
            showWeek: true,
            weekHeader: "v",
            defaultDate: "",
            minDate: "",
            changeMonth: true,
            numberOfMonths: 1
          });
    
          $( "#cancelation-date" ).datepicker({
            firstDay: 1,
            monthNames: ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'],
            dayNamesMin: [ 'sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'],
            dateFormat: 'yy-mm-dd',
            showWeek: true,
            weekHeader: "v",
            defaultDate: "",
            minDate: "",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
              $( "#customer-experience" ).show('slow');
            }
          });
    
    
          // validate signup form on keyup and submit
          var validator = $("#orderForm").validate({
            errorClass: "invalid",
            validClass: "valid", 
            rules: {
              firstname: "required",
              lastname: "required",
              street1:{
                required: true,
                minlength: 3
              },
              zip:{
                required: true,
                minlength: 5
              },
              city: "required",
              ss:{
                required: true,
                minlength: 12,
                maxlength: 13
              },
              customernbr:{
                required: true,
                minlength: 4                
              },              
              rut: "required",
              terms: "required"
            },
            messages:{
              firstname: "",
              lastname: "",
              customernbr: "",
              street1:{
                required: "",
                minlength: ""
              },
              zip:{
                required: "",
                minlength: ""
              },
              city: "",
              ss:{
                required: "Ange personnummer!",
                minlength: "Ange ett korrekt personnummer i formatet ÅÅÅÅMMDD-XXXX!",
                maxlength: "Ange ett korrekt personnummer i formatet ÅÅÅÅMMDD-XXXX!"
              },
             
              rut: "Välj om du vill ha skattereduktion eller inte!",
              terms: "Tacka ja för att genomföra beställningen!"
            },
            success: function(label) {
              // set &nbsp; as text for IE
              label.html("&nbsp;").addClass("checked");
            }
          });
    


          /**
           * Ajax call to get peronal info
           */        
          $("#ss-button").click(function(event) {
            event.preventDefault();
            $("#ss-progress").css("display", "block");    //show progress wheel
            ss = $('#ss').val();
            var data = {
              action : 'get_pers_info',
              ss: ss
            };
            $.post('/wp-admin/admin-ajax.php', data, function(response) {
              $("#ss-progress").hide();  
              if(response.success == 1){
                $("#pers-container").removeClass("hidden");
                $("#ss-button").prop('type','button');          
                $("#ss-error").addClass("hidden");
                $("#firstname").val(response.fname);
                $("#firstname").val(response.fname);
                $("#lastname").val(response.lname);
                $("#lastname").val(response.lname);
                $("#street1").val(response.street1);
                $("#street1").val(response.street1);
                $("#street2").val(response.street2);
                $("#zip").val(response.zip);
                $("#zip").val(response.zip);
                $("#city").val(response.city);
                $("#city").val(response.city);
                $("#phone").val(response.phone);
                $("#email").val(response.email);          
              }else{
                $("#ss-error").removeClass("hidden");
                $("#pers-container").addClass("hidden");
              }        
            });
          });    
    
    
          $('#uppsagning-op').change(function(){
            $('#cancelation-datepicker').show('slow');
            value = $('#uppsagning-op option:checked').val();
            switch (value)
            {
              case '1':
                closeAll();
                $('#uppsagning-op-1').show('slow');
                break;
              case '2':
                closeAll();
                $('#uppsagning-op-2').show('slow');
                break;
              case '3':
                closeAll();
                $('#uppsagning-op-3').show('slow');
                break;
              case '4':
                closeAll();
                $('#uppsagning-op-4').show('slow');
                break;
              case '5':
                closeAll();
                $('#uppsagning-op-5').show('slow');
                break;
              case '6':
                closeAll()
                $('#uppsagning-op-6').show('slow');
                break;
              case '7':
                closeAll();
                $('#uppsagning-op-7').show('slow');
                break;
            }
          });


          function closeAll(){
            $('#uppsagning-op-1').hide('slow');
            $('#uppsagning-op-2').hide('slow');
            $('#uppsagning-op-3').hide('slow');
            $('#uppsagning-op-4').hide('slow');
            $('#uppsagning-op-5').hide('slow');
            $('#uppsagning-op-6').hide('slow');
            $('#uppsagning-op-7').hide('slow');
          }    

        });
      </script>


    </div>
    <div class="column grid_4" style="min-height: 800px;">
      <?php $p = array_shift(get_posts("post_type=template-content&p=90")); ?>
      <?php echo $p->post_content; ?>

      <!--hr />

      <p class="rut"><img src="<?php bloginfo('template_directory'); ?>/img/inline/halva-priset.png" /></p-->

    </div>

  </section> <!-- //section -->

</div> <!-- //main -->

<?php get_footer(); ?>