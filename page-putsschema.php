<?php
/*
  Template Name: Putsschema
 * Author: Kristian Erendi 
 * URI: http://reptilo.se
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
!empty($_REQUEST['kommun']) ? $kommunid = $_REQUEST['kommun'] : $kommunid = '';
get_header();
the_post();
?>
<input type="hidden" value="<?php echo $kommunid ?>" id="kommun-id"/>

<?php get_template_part('include_main_head'); ?>

<!-- <div id="main-head" class="omraden">

	<section>

	<div class="column grid_12">

			<p class="label">
				<?php /*
					$label = simple_fields_value("info_sidetikett");
					echo $label;*/
				?>
			</p>

			<?php/*
				$text = simple_fields_value("info_text");
				echo $text;*/
			?>

		</div>


	</section> 
	
<!-- </div> -->


<script type="text/javascript">
  jQuery(document).ready(function($){
    //$("#ss-progress").show();
    $('#no-city').hide();
    $('.choose-areas').hide(); 
    var kommun_id = $('#kommun-id').val();
    if(kommun_id == ''){
      $('.choose-areas').hide();
      $('#no-city').show();
    } else{
      $('.choose-areas').show();
      getPutsschema(kommun_id);
    }
    
    /**
     * Ajax call to get all areas and schedule id's 
     */
    function getPutsschema(kommun_id){
      var data = {
        action : 'get_putsschema',
        kommun_id: kommun_id
      };
      $.post('/wp-admin/admin-ajax.php', data, function(response) {
        var rows = '';
        var city = '';
        $(response).each(function( index, row ) {
          var li = '<input type="radio" id="id-'+row.id+'" name="area" class="area" value="'+row.schedule+'"><label for="id-'+row.id+'">'+row.area+' ('+row.schedule+')</label><br />';
          rows += li;
          city = row.city;
        });
        $('#area-list').append(rows);
        $('#city').html(city);        
      });  
    }
    
    function hideAllPutsschema(){
      $('#schedule-1').hide('slow');
      $('#schedule-2').hide('slow');
      $('#schedule-3').hide('slow');
      $('#schedule-4').hide('slow');
      $('#schedule-5').hide('slow');
      $('#schedule-6').hide('slow');
      $('#schedule-7').hide('slow');      
    } 
 

    $('.overlay').click(function(event) {
		hideAllPutsschema();
    });

 
    $('.area').live('click', function(e){
      hideAllPutsschema();
      var schedule_id = $(this).attr('value');    
      $('#schedule-'+schedule_id).show();
    });

  });  
</script>

<div id="main" class="standard putsschema">

	<section>

		<div class="column grid_8 hidden choose-areas">

			<h1><?php echo get_the_title(); ?></h1>
			<p>Nedan visas de områden och orter i din kommun där vi erbjuder fönsterputsning.</p>
			<p>Du kan ladda ner och skriva ut putsschema för 2014 som <a href="http://eriksfonsterputs.se/wp-content/uploads/Putsschema2014.pdf">utskriftsvänlig PDF</a>.</p>
			
			<h2>Schema för fönsterputsning i <span id="city"></span>, schemanummer inom parentes:</h2>
			<div id="area-list"></div>

		</div>

		<div class="column grid_8" id="no-city" class="hidden">

			<h1><?php echo get_the_title(); ?></h1>
			<p><a href="<?php home_url('/'); ?>/putsomraden/" >Vänligen välj en kommun först</a></p>
			<p>Vet du redan vilket schema du har kan du du kan ladda ner och skriva ut ditt putschema <a href="http://eriksfonsterputs.se/wp-content/uploads/Putsschema2014.pdf">här</a> (PDF).</p>

		</div>

		<div class="column grid_4">

			<p><strong>Abonnera på</strong> fönsterputs:</p>
			<p>- snabbt och enkelt!</p>			

			<form action="/abonnemang/bestallning" id="orderForm" name="orderForm" method="post" >
				<ul>
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

<div id="schedule-1" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema1.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-2" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema2.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-3" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema3.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-4" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema4.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-5" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema5.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-6" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema6.png" alt=""/><span class="close">Stäng</span></div>
<div id="schedule-7" class="hidden overlay"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/putsschema7.png" alt=""/><span class="close">Stäng</span></div>

<?php get_footer(); ?>