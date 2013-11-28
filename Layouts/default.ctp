<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title_for_layout . ' &raquo; ' . Configure::read( 'Site.title' ); ?></title>
		<?php
		echo $this->Layout->meta();
		echo $this->Layout->feed();
		echo $this->Html->css( array(
			'bootstrap',
			'theme',
			'bootstrap-responsive'
		) );
		?>

		<!-- Should replace the following with your icons -->
		<link rel="shortcut icon" href="/img/favicon.ico">
		<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	</head>

	<body>

		<?php echo $this->element( 'header' ); ?>

		<div class="container">

			<?php
			if( $this->here == $this->webroot ) {
				//Home page layout
				echo $this->element('home');
			} else {
				//Layout for all other pages
				?>
				<div class="hero-unit subpage">
					<h1><?php echo $title_for_layout; ?></h1>
				</div>

				<div class="row">
					<div class="span8">
						<?php
						echo $this->Layout->sessionFlash();
						echo $content_for_layout;
						?>
					</div>
					<div class="span4">
						<div class="well sidebar-nav">
							<?php echo $this->Layout->blocks( 'right' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<hr />

			<?php echo $this->element( 'footer' ); ?>

		</div>
		<?php
		echo $this->Layout->js();
		echo $this->Html->script( array(
			'jquery.min',
			'bootstrap'
		) );
		echo $scripts_for_layout;
		?>
	</body>
</html>
