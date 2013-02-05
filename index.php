<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
get_header(); ?>

<body class="standard index">

<?php get_template_part('include_header'); ?>

<div id="main">

	<section>

		<div class="column grid_8">

			<h1>Nyheter</h1>

			<?php if (have_posts()) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<article>
						<p class="article-head"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
						<p class="article-date"><?php the_time(get_option('date_format')); ?></p>
						<p class="article-excerpt"><a href="<?php the_permalink() ?>"><?php echo strip_tags(get_the_excerpt()); ?></a></p>
					</article>

				<?php endwhile; ?>

				<div class="navigation">
					<div class="left"><?php next_posts_link('&laquo; Äldre inlägg') ?></div>
					<div class="right"><?php previous_posts_link('Nyare inlägg &raquo;') ?></div>
				</div>

			<?php else : ?>

				<p>Nyhetsarkivet är tomt.</p>
				<p>För tillfället finns det inga nyheter i arkivet. <a href="<?php bloginfo('url'); ?>/" title="Till startsidan">Tillbaka till startsidan.</a></p>

			<?php endif; ?>

		</div>

		<div class="column grid_4">

			<?php
				$q = new WP_Query("name=nyheter&post_type=page");
				$q->the_post();
				if ( has_post_thumbnail()) { the_post_thumbnail(); }
			?>

		</div>

		<div class="label">Nyhetsbrev</div>

	</section><!-- //section -->

</div> <!-- //main -->

<?php get_footer(); ?>