<!doctype html>
<html>
<head lang="en">
	<meta charset="UTF-8" />
	<link rel="shortcut icon" href="<?php echo URL::site('favicon.png'); ?>" />
	<title><?php if (isset($title)) echo HTML::chars($title).' &sdot;'; ?>HSJB Membership</title>

	<?php echo HTML::style('assets/css/v1/bootstrap.css'); ?>
	<?php echo HTML::style('assets/css/v1/app.css'); ?>

	<?php echo HTML::script('assets/js/v1/jquery-2.0.3.min.js'); ?>
	<?php echo HTML::script('assets/js/v1/bootstrap.min.js'); ?>
</head>
<body>
	<nav class="navbar navbar-fixed-top">
		<div class="container">
			<div class="nav-header">
				<?php echo HTML::anchor('/', 'HSJB Membership', array('class' => 'navbar-brand'));?>
			</div><!-- .navbar-header -->

			<ul class="nav navbar-nav">
				<?php include Kohana::find_file('views', 'elements/_menu'); ?>
			</ul><!-- .navbar-nav -->

			<ul class="nav navbar-nav navbar-right">
				<?php include Kohana::find_file('views', 'elements/_login'); ?>
			</ul><!-- .navbar-right -->
		</div>
	</nav>	

	<div class="container" id="wrap">
		<?php include Kohana::find_file('views', 'elements/_flash_messages'); ?>

		<?php if (isset($content)) echo $content; ?>
	</div>

	<footer>
		<div class="container">
			<p class="text-muted">
				<a href="http://hackerspacejb.org">HackerSpaceJB</a>
			</p>
		</div>
	</footer>
</body>
</html>
