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
<div id="main" class="standard order">
  <section>
    <div class="column grid_8">
      <h1>Tillval eller förändring av ditt abonnemang</h1>
      <p>Här kan du som är registrerad kund hos oss beställa tillval och förändra så att abonnemanget passar just dina behov.</p>
      <form action="/abonnemang/mottagen-forandring/" id="orderForm" name="orderForm" method="post" >
        <ul>
          <h2>Välj vilket sorts ärende du vill utföra</h2>
          <li><input name="option" id="op1" value="op1" type="radio" /><label for="op1">Beställa <b>permanenta</b> tillval eller göra <b>tillfälliga</b> bokningar</label></li>
          <li><input name="option" id="op2" value="op2" type="radio" /><label for="op2">Göra <b>tillfällig</b> avbokning av putstillfälle</label></li>
          <li><input name="option" id="op3" value="op3" type="radio" /><label for="op3">Ändra dina kunduppgifter</label></li>

          <div id="basics" class="hidden">
            <h2>Grunduppgifter</h2>
            <li><input name="show-ss" id="ss1" value="ss1" type="radio" checked/><label for="ss1">Jag vill själv ange namn och adressuppgifter</label></li>
            <li><input name="show-ss" id="ss2" value="ss2" type="radio" /><label for="ss2">Jag är skriven på putsadressen detta gäller och vill hämta personuppgifter automatiskt</label></li>
          </div>  

          <div id="ss-container" class="hidden">
            <h2>Fyll i personnummer för att hämta adressuppgifter (OBS! 12 siffror)</h2>
            <li>
              <input name="ss" id="ss" type="text" value="ÅÅÅÅMMDD-XXXX" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
              <input type="submit" value="HÄMTA" id="ss-button">  
              <img id="ss-progress" src="<?php bloginfo('stylesheet_directory'); ?>/img/inline/ajax-loader.gif" alt="" />
            </li>  
          </div>
          <div id="ss-error" class="hidden invalid">Personnumret verkar vara felaktigt.</div>

          <div id="pers-container" class="hidden">
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
          <div>
            
			<fieldset id="rut" class="hidden">
              <h2>Ändra skattereduktion (RUT-avdrag)</h2>
			  <li>
                <input name="rutchange" id="rutSame" value="SAMMA" type="radio" checked/>
                <label for="rutSame">Jag vill att ni lämnar detta oförändrat</label>
              </li>
              <li>
                <input name="rutchange" id="rutYes" value="JA" type="radio" />
                <label for="rutYes">Jag vill ha RUT-avdrag</label>
              </li>
              <li>
                <input name="rutchange" id="rutNo" value="NEJ" type="radio" />
                <label for="rutNo">Jag vill <u>inte</u> ha RUT-avdrag</label>
              </li>
            </fieldset>			
          </div>

          <fieldset id="tillval" class="tillval hidden">
            <h2>Nedanstående val beskriver..</h2>
            <li><input name="tillval" id="tillval1" value="tillval1" type="radio" checked/><label for="tillval1"> ..vad <u>LÄGGER TILL</u> permanent på mitt årliga abonnemang</label></li>
            <li><input name="tillval" id="tillval2" value="tillval2" type="radio" /><label for="tillval2"> .. beskriver detaljerat hur ni <u>VARJE ÅR</u> ska putsa mitt hus</label></li>
            <li><input name="tillval" id="tillval3" value="tillval3" type="radio" /><label for="tillval3"> ..vad ni <u>TAR BORT</u> permanent från mitt årliga abonnemang</label></li>
			<br />
			<li><input name="tillval" id="tillval4" value="tillval4" type="radio" /><label for="tillval4"> ..vad ni ska utföra vid ett <u>ENSTAKA TILLFÄLLE</u> utanför mitt årliga abonnemang</label></li>
            <br />
			<?php echo getTillvalTable(); ?>
          </fieldset>


          <fieldset id="avbokning" class="tillval hidden">
            
            <h2>Välj ett datumintervall då du vill att vi avbokar:</h2>
            För permanenta förändringar av hur vi årligen putsar ditt hus, gå istället till formuläret förändring. För att kunna tillgodose dina önskemål kan du välja <b>tidigast 7 dagar</b> från dagens datum och intervallet kan vara <b>maximalt 7 veckor</b> långt.</br>
			</br>
			<label for="from">Från datum: &nbsp;</label><input type="text" id="from" name="from" style="width:100px;"/>
            <label for="to">&nbsp;&nbsp; till datum: &nbsp;</label><input type="text" id="to" name="to" style="width:100px;"/>
            <br /><br />
            <li><input name="avbokning[]" id="avbokning1" value="1" type="checkbox" /><label for="avbokning1"> Hela putstillfället</label></li>
            <li><input name="avbokning[]" id="avbokning2" value="2" type="checkbox" /><label for="avbokning2"> Spröjs på</label></li>
            <li><input name="avbokning[]" id="avbokning3" value="3" type="checkbox" /><label for="avbokning3"> Rengöring spröjs</label></li>
            <li><input name="avbokning[]" id="avbokning4" value="4" type="checkbox" /><label for="avbokning4"> Bleck</label></li>
            <li><input name="avbokning[]" id="avbokning5" value="5" type="checkbox" /><label for="avbokning5"> Karmar</label></li>
            <li><input name="avbokning[]" id="avbokning6" value="6" type="checkbox" /><label for="avbokning6"> Uterum</label></li>
            <li><input name="avbokning[]" id="avbokning7" value="7" type="checkbox" /><label for="avbokning7"> Ovanvåning</label></li>
            <li><input name="avbokning[]" id="avbokning8" value="8" type="checkbox" /><label for="avbokning8"> Källare</label></li>

            <li>
              <label class="comments" for="comments">Ytterligare information till kundtjänst:</label>
              <textarea name="comments" id="comments" placeholder="Plats för mer meddelanden och övriga önskemål"></textarea>
            </li>              
            
			</fieldset>

          
          
          <fieldset id="send" class="hidden">
              <li><a href="#" target="_blank" id="terms-link">Läs villkoren</a> <a href="#" target="_blank" id="price-link">Se prislista 2013</a> <a href="#" target="_blank" id="rut-info-link">Om RUT-avdrag</a></li>
              <li>&nbsp;</li>
              <li>
                <input name="terms" id="terms" type="checkbox" style="float:left;" value ="Ja"/>
                <label for="terms"><b>Ja tack!</b></label> Jag har läst och godkänner villkor, prislista och övrig information.
              </li>
              <li>&nbsp;</li>
              <li><input type="submit" value="Skicka"></li>
            </fieldset>
          

        </ul>
      </form>
      <script type="text/javascript">
        jQuery(document).ready(function($){   
          $("#ss-progress").hide();
          $("#tillval").hide();
          var toDateMin;
          var toDateMax;
    
          $( "#from" ).datepicker({
            firstDay: 1,
            monthNames: ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'],
            dayNamesMin: [ 'sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'],
            dateFormat: 'yy-mm-dd',
            showWeek: true,
            weekHeader: "v",
            defaultDate: "+1w",
            minDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
              //min date
              toDateMin = $( "#from" ).val();
              $("#to").datepicker('option', "minDate", toDateMin);
              
              //calc new maxDate, add 7 weeks 
              var date = new Date(toDateMin);
              var d = date.getDate();
              var m = date.getMonth();
              var y = date.getFullYear();
              var toDateMax = new Date(y, m, d+49);  //add 7 weeks
              $("#to").datepicker( "option", "maxDate", toDateMax);
            }
          });
          
          
          $( "#to" ).datepicker({
            defaultDate: "+1w",
            firstDay: 1,
            monthNames: ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'],
            dayNamesMin: [ 'sön', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör'],
            dateFormat: 'yy-mm-dd',
            showWeek: true,
            weekHeader: "v",
            changeMonth: true,
            numberOfMonths: 1
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
              terms: "Tacka ja!"
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
    
    
          $('input[name=option]').change(function(){
            $('#basics').show('slow');
            $('#pers-container').show('slow');                        
            $('#send').show('slow');            
            radio = $('input:radio[name=option]:checked').val();
            switch (radio)
            {
              case 'op1':
                $('#tillval').show('slow');
                $('#send').show('slow');
                $('#avbokning').hide('slow');
                $('#rut').show('slow');
                break;
              case 'op2':
                $('#avbokning').show('slow');
                $('#send').show('slow');
                $('#tillval').hide('slow');
                $('#rut').show('slow');
                break;
              case 'op3':
                $('#avbokning').hide('slow');
                $('#send').show('slow');
                $('#tillval').hide('slow');
                $('#rut').show('slow');
                break;
              case 'op4':
                $('#avbokning').hide('slow');
                $('#send').show('slow');
                $('#tillval').hide('slow');
                $('#rut').hide('slow');
                $('#uppsagning').show('slow');
                break;
            }
          });







          $('input[name=show-ss]').change(function(){
            radio = $('input:radio[name=show-ss]:checked').val();
            if(radio == 'ss1'){
              $('#ss-container').hide('slow');
            } else {
              $('#ss-container').show('slow');
            }            
          });



          $('.select-all').change(function(){
            var check = $(this);
            var id = check.attr('id');
            id = id.replace('_all', '');
            if(check.attr('checked')){
              $('input:checkbox[row='+id+']').prop('checked', true);
            }else{
              $('input:checkbox[row='+id+']').prop('checked', false);
            }
          });



          $('#avbokning1').change(function(){
            if($('#avbokning1').attr('checked')){
              $('#avbokning1').prop('checked', true);
              $('#avbokning2').prop('checked', true);
              $('#avbokning2').prop('disabled', true);
              $('#avbokning3').prop('checked', true);
              $('#avbokning3').prop('disabled', true);
              $('#avbokning4').prop('checked', true);
              $('#avbokning4').prop('disabled', true);
              $('#avbokning5').prop('checked', true);
              $('#avbokning5').prop('disabled', true);
              $('#avbokning6').prop('checked', true);
              $('#avbokning6').prop('disabled', true);
              $('#avbokning7').prop('checked', true);
              $('#avbokning7').prop('disabled', true);
              $('#avbokning8').prop('checked', true);
              $('#avbokning8').prop('disabled', true);
            }else{
              $('#avbokning1').prop('checked', false);
              $('#avbokning2').prop('checked', false);
              $('#avbokning2').prop('disabled', false);
              $('#avbokning3').prop('checked', false);
              $('#avbokning3').prop('disabled', false);
              $('#avbokning4').prop('checked', false);
              $('#avbokning4').prop('disabled', false);
              $('#avbokning5').prop('checked', false);
              $('#avbokning5').prop('disabled', false);
              $('#avbokning6').prop('checked', false);
              $('#avbokning6').prop('disabled', false);
              $('#avbokning7').prop('checked', false);
              $('#avbokning7').prop('disabled', false);
              $('#avbokning8').prop('checked', false);
              $('#avbokning8').prop('disabled', false);
            }
          });
    
        });
      </script>


    </div>
    <div class="column grid_4">
      <?php $p = array_shift(get_posts("post_type=template-content&p=90")); ?>
      <?php echo $p->post_content; ?>

      <!--hr />

      <p class="rut"><img src="<?php bloginfo('template_directory'); ?>/img/inline/halva-priset.png" /></p-->

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