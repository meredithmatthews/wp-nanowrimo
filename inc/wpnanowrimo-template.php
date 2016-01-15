<!-- Generic page template modified to display WP-REST api content -->
<base href="<?php $url_info = parse_url( home_url() ); echo trailingslashit( $url_info['path'] ); ?>">

<?php get_header(); ?>

	<div id="primary" class="content-area" ng-app="app">
		<main id="main" class="site-main" role="main">
		
		<article class="hentry">
			<header class="entry-header">
				<h1><?php echo get_option('nano_novel_title'); ?></h1>
			</header>
				<div ng-view></div>
		</article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>