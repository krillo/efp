<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
get_header(); the_post(); ?>

<?php get_template_part('include_main_head'); ?>

<div id="main" class="standard employees">

	<section>

		<div class="column grid_8">

			<h1><?php the_title(); ?></h1>

			<?php $employees = simple_fields_get_post_group_values($post->ID, "Anställda kontor", true, 2); ?>
			<?php foreach($employees as $person): ?>
			<div class="employee">
				<?php echo wp_get_attachment_image($person["Bild"], "full"); ?>
				<p>
					<strong><?php echo $person["Namn"]; ?></strong><br />
					<?php echo $person["Avdelning"]; ?><br />
					Telefon: <?php echo $person["Telefon"]; ?><br />
					E-post: <a href="mailto:<?php echo $person["E-post"]; ?>">Skicka</a>
				</p>
			</div>
			<?php endforeach; ?>

		</div>

		<div class="column grid_4">

			<p><strong>Abonnera på</strong> fönsterputs:</p>
			<p>- snabbt och enkelt!</p>
			
			<form action="/abonnemang/bestallning" id="orderForm" name="orderForm" method="post" >
				<ul>
					<!--li><label for="zip1">Postnr</label></li-->
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