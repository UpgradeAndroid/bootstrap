<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<h1><?php echo Configure::read( 'Site.tagline' ); ?></h1>
	<p>&nbsp;</p>
	<p><a class="btn btn-large"><b>Call Us To Get Started &raquo;</b></a></p>
</div>

<div class="row">
	<div class="span12">
		<?php echo $this->Layout->sessionFlash(); ?>
	</div>
</div>

<?php echo $content_for_layout; ?>
