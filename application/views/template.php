<!DOCTYPE html>
<html>
<head lang="en">
	<title><?php if (isset($title)) echo HTML::chars($title).' &sdot;'; ?>HSJB Membership</title>
	
	<link rel="shortcut icon" href="<?php echo URL::site('favicon.png'); ?>" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<?php echo HTML::style('assets/css/v1/bootstrap.css'); ?>
	<?php echo HTML::style('assets/css/v1/app.css'); ?>

	<?php echo HTML::script('assets/js/v1/jquery-2.0.3.min.js'); ?>
	<?php echo HTML::script('assets/js/v1/bootstrap.min.js'); ?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<?php echo HTML::anchor('/', 'HSJB Membership', array('class' => 'navbar-brand')); ?>
			</div><!-- .navbar-header -->

			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<?php include Kohana::find_file('views', 'elements/_menu'); ?>
				</ul><!-- .navbar-nav -->

				<ul class="nav navbar-nav navbar-right">
					<?php include Kohana::find_file('views', 'elements/_login'); ?>
				</ul><!-- .navbar-right -->
			</div><!-- .navbar-collapse -->
		</div>
	</nav><!-- .navbar -->

	<div class="container" id="wrap">
		<?php include Kohana::find_file('views', 'elements/_flash_messages'); ?>

		<?php if (isset($content)) echo $content; ?>
	</div>

	<footer>
		<div class="container">
			<p class="text-muted">
				A community project by <a href="http://hackerspacejb.org">HackerSpaceJB</a>.
			</p>
		</div>
	</footer>
</body>
</html>
