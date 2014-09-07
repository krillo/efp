<!-- /* ASX Checkpoint Invocation Script v0.2 */ -->
<!-- /* Place this checkpoint script as the first element in the body tag on the page you want to track. */ -->
<script type="text/javascript">
var protocol = ('https:' == document.location.protocol ? 'https' : 'http');
var uri = protocol + '://adsby.bidtheatre.com/checkpoint?c=393&output=js&rnd=' + new String (Math.random()).substring (2, 11);
var base = document.getElementsByTagName('script')[0];
var image = new Image();
image.src = uri;
image.width = 0;
image.height = 0;
base.parentNode.insertBefore(image, base.nextSibling);
</script>


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