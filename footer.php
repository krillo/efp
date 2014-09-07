<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
?>

<footer>

	<section class="top">

		<?php
			$getShortcuts = new WP_Query(array(
			"post_type" => "template-content",
			"name" => "genvagar-i-sidfoten",
			)); 
		?>
		<?php if ( $getShortcuts->have_posts() ) : while ( $getShortcuts->have_posts() ) : $getShortcuts->the_post(); ?>
		
		<?php $shortcuts = simple_fields_get_post_group_values($post->ID, "Genvägar i sidfoten", true, 2); ?>
		
			<?php foreach($shortcuts as $info): ?>
				<div class="column grid_3">
		
					<h2><?php echo $info["Rubrik"]; ?></h2>
					<?php echo $info["Text"]; ?>
					<p><a href="<?php echo $info["Länkadress"]; ?>"><?php echo $info["Länktext"]; ?></a></p>
		
				</div>
			<?php endforeach; ?>
		
		<?php endwhile; endif; ?>

	</section>

	<section class="mid">

		<div class="column grid_3">

			<?php
				wp_nav_menu(
					array(
						'items_wrap' => '<nav><ul>%3$s</ul></nav>',
						'container' => 'false',
						'theme_location' => 'primary'
					)
				);
			?>
			<a href="http://eriksfonsterputs.se/?am_force_theme_layout=mobile">Mobil version</a>
		</div>

		<div class="column grid_3">

			<?php $p = array_shift(get_posts("post_type=template-content&p=23")); ?>
			<?php echo $p->post_content; ?>

		</div>

		<div class="column grid_6">

			<?php $p = array_shift(get_posts("post_type=template-content&p=24")); ?>
			<?php echo $p->post_content; ?>

		</div>

	</section>
	
	<section class="btm">

		<div class="column grid_12">
		<p>&copy; <?php year(2012); ?> Eriks Fönsterputs. Alla rättigheter förbehålles.</p>
			<p id="siteby"><a class="plucera" href="http://www.plucera.se" title=" Plucera Webbyrå ">plucera</a> <a href="http://www.plucera.se/plucera-webbyra/" title=" Plucera Webbyrå ">webbyrå</a></p>

			<p>Du kan få Eriks Fönsterputs i Helsingborg, Malmö, Landskrona, Lomma, Lund, Ängelholm, Vellinge, Höganäs, Kungsbacka, Varberg, Falkenberg, Halmstad, Laholm, Båstad, Markaryd, Älmhult, Gislaved, Värnamo, Alvesta, Ljungby, Hylte, Växjö, Olofström, Bromölla, Sölvesborg, Simrishamn, Osby, Östra Göinge, Örkelljunga, Svalöv, Klippan, Åstorp, Bjuv, Perstorp, Höör, Hörby, Eslöv, Kävlinge, Sjöbo, Tomelilla, Ystad, Trelleborg, Svedala, Staffanstorp, Skurup, Burlöv och Hässleholm.</p>
			</div>

	</section>

</footer>

<?php wp_footer(); ?>
 


</body>
</html>
