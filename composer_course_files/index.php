<?php

require 'vendor/autoload.php';

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

$palette = Palette::fromFilename('./images/flags.jpg');

$colors = $palette->getMostUsedColors(1024);
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ImageAbstractor</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="all">
</head>

<body>

	<header class="masthead">
		<div class="site-branding">
			<h1 class="site-title">ImageAbstractor</h1>
			<p class="site-description">Pull the most dominant colors from an image.</p>
		</div><!-- .site-title -->
	</header><!-- .masthead -->

	<section class="the-grid">

		<ul class="colors">

			<?php

            foreach ($colors as $color => $count) {
                $current = Color::fromIntToHex($color);
                echo '<li style="background-color: '.$current.'">' . $count;
            }

			?>

		</ul>

	</section><!-- .the-grid -->

</body>

</html>

