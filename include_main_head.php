<div id="main-head">

	<section>

		<div class="column grid_12">

			<p class="label">
				<?php
					$label = simple_fields_value("info_sidetikett");
					echo $label;
				?>
			</p>

			<?php
				$text = simple_fields_value("info_text");
				echo $text;
			?>

			<nav>
				<ul>
					<?php $parent = top_level_parent(); ?>
					<?php if(! $parent) $parent = $post->ID; ?>
					<?php wp_list_pages('title_li=&depth=1&exclude=8,745,756&child_of='. $parent); ?>
				</ul>
			</nav>

		</div>

	</section> <!-- //section -->
	
</div> <!-- //main-head -->