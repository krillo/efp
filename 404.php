<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
get_header(); the_post(); ?>

<div id="main" class="standard">

	<section>

		<div class="column grid_8">

			<h1>404 - Sidan du sökte kunde inte hittas</h1>
			<p>Den 1 februari lade vi ut vår nya hemsida och vissa gamla adresser finns därför inte kvar.
			<h2><a href="/">Klicka här för att gå till startsidan</a></h2>

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