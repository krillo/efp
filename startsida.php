<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 * Template Name: Startsida
 */
get_header(); the_post(); ?>

<div id="panorama">

	<section class="top">

		<div class="column grid_8">

			<?php the_content(); ?>
			
			<form action="/abonnemang/bestallning/" id="orderForm" name="orderForm" method="post" >
				<ul>
					<!--li><label for="zip1">Postnr</label></li-->
					<li>  
						<input name="zip" id="zip" value="Skriv ditt postnummer här" type="text" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
						<input type="submit" value="Testa om vi putsar där du bor" id="zip-button">
					</li>
				</ul>
			</form>

		</div>

		<div class="column grid_4">

			<p id="slogan">Sveriges <strong>största</strong> leverantör av utvändig fönsterputs i abonnemangsform!</p>
			<!--p id="windows">
				<?php
					$windows = simple_fields_value("fonster_antal");
					echo $windows;
				?>
			</p -->
			<!-- START PÅ RÄKNARE -->
			<?php 
			date_default_timezone_set('Europe/Stockholm');
			$startamount = 12500000; //vid årets början, ca 500000*25
			$yearlyincrement = 85000*25; // putsas under året
			$dailyincrement = $yearlyincrement/220; //daglig ökning per arbetsdag
			if (date('N') > 5) { $workdays = ((date('W')-1)*5)+5; } else { $workdays = ((date('W')-1)*5)+(date('N')); }
			$incremented = $workdays*$dailyincrement; // hittills ökat under året
			$clean_start = $startamount+$incremented; // antal vid början på arbetsdagen
			$clean_end = $startamount+$incremented+$dailyincrement; // antal vid slutet på arbetsdagen
			$speed = 21000000;  // 4h=14400000 8h = 28800000 att räkna från start till slut
			if (date('N') > 5) $clean_end = $clean_start+1;
			if (date('G') < 7) {     // före arbetstid
				$clean_end = $clean_start+1; 
				} elseif (date('G') > 15) { // efter arbetstid
				$clean_start = $clean_end-1; 
				}
			?>
			<!-- SLUT PÅ RÄKNARE -->
			<p id="since">Vi har putsat</p>
			<p id="counter" style="padding;0px;"><input type="hidden" name="counter-value" value="100" /></p>
			<script type="text/javascript">
			/* <![CDATA[ */
			        jQuery(document).ready(function($) {
						$("#counter").flipCounter(
							"startAnimation", // scroll counter from the current number to the specified number
						{
					        number:<?=$clean_start?>, // the initial number the counter should display, overrides the hidden field
					        end_number:<?=$clean_end?>, // the number we want the counter to scroll to
					        numIntegralDigits:1, // number of places left of the decimal point to maintain
					        numFractionalDigits:0, // number of places right of the decimal point to maintain
					        digitClass:"counter-digit", // class of the counter digits
					        counterFieldName:"counter-value", // name of the hidden field
					        digitHeight:30, // the height of each digit in the flipCounter-medium.png sprite image
					        digitWidth:23, // the width of each digit in the flipCounter-medium.png sprite image
					        imagePath:"/wp-content/themes/eriksfonsterputs/img/flipCounter-small.png", // the path to the sprite image relative to your html document
					        easing: false, // the easing function to apply to animations, you can override this with a jQuery.easing method
					        duration:<?=$speed?>, // duration of animations
					        onAnimationStarted:false, // call back for animation upon starting
					        onAnimationStopped:false, // call back for animation upon stopping
					        onAnimationPaused:false, // call back for animation upon pausing
					        onAnimationResumed:false // call back for animation upon resuming from pause
						});
			        });
			/* ]]> */
			</script>
			<p id="since">fönster sedan 1997</p>

		</div>

	</section><!-- //section top -->

</div> <!-- //panorama -->

<div id="main" class="home">

	<section class="top">

		<div class="column grid_8">

			<div id="slides">

				<div class="slides_container">

				<?php $slideshow = simple_fields_get_post_group_values($post->ID, "Bildspel", true, 2); ?>
				<?php foreach($slideshow as $slide) : ?>
					<div class="slide">
						<?php echo wp_get_attachment_image($slide["Bild"], "full"); ?>
						<div class="caption"><p><?php echo $slide["Bildtext"]; ?></p></div>
					</div>
				<?php endforeach; ?>

				</div>

				<!--div id="slide-heading">
					<?php
						$slideHeading = simple_fields_value("bildspelsrubrik_rubrik");
						echo $slideHeading;
					?>
				</div-->

			</div>

		</div>

		<div class="column grid_4">

			<img src="<?php bloginfo('template_directory'); ?>/img/inline/erik-och-katten.png" alt="Eriks Fönsterputs - Erik och katten" />

		</div>

	</section><!-- //section top -->

</div> <!-- //main -->

<?php get_footer(); ?>