<?php 
get_header();
$theme_options = get_theme_mod('popster_options');
 ?>

			<div id="content">
				<?php
				$current_page = get_query_var('paged');
				?>
				<div id="inner-content" class="wrap clearfix">
					<div id="main" class="boxed clearfix" role="main">
						<?php 
						$hide_slider = ( $current_page && isset($theme_options['homepage_featured_slider_hide']) && $theme_options['homepage_featured_slider_hide']);
						if ( $theme_options['homepage_featured_slider'] && !($hide_slider) ) {
							if ( isset($theme_options['featured_posts_categories']) && $theme_options['featured_posts_categories'] ) $cats = implode(',', $theme_options['featured_posts_categories'] );
							else $cats = '';
							$args = array('cat' => $cats, 'showposts' => $theme_options['featured_posts_number'], 'heading-tag'=>'h1', 'thumb-size'=> 'full' );
							popster_featured_posts( $args , $theme_options['featured_posts_title'] );
						}
						?>
						<!--<h4 class="widgettitle"><span>Recent Posts</span></h4>-->
						<?php if (have_posts()) : $i = 1; while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb"><?php the_post_thumbnail('thumbnail'); ?></a>
								<?php else : 
										if ( get_post_format() == 'video'){
											$video_options = get_post_meta(get_the_ID(), '_popster_video_options', true );
											if ( $video_options['video_provider'] == 'youtube' ){ ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb"><img src="http://img.youtube.com/vi/<?php echo $video_options['video_id']; ?>/hqdefault.jpg" /></a>	
								<?php		}
										}
								?>
								<?php endif; ?>

							<header>
								<div class="category-meta" style="display: none;"><?php the_category(', '); ?></div>
								<div class="meta" style="display: none;"><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time><!--, <?php the_author_posts_link(); ?>, <?php comments_popup_link(__('No Comment', 'popster'), '1 Comment', '% Comments','','Comment Closed'); ?>--></div>
								<h2 class="post-title h3"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							</header> <!-- end article header -->

							<ul class="post-information">
								<li>
									<?php $gravatar = md5(get_the_author_meta('user_email')); $default = get_template_directory_uri().'/images/avatar.png'; ?>
									<img class="author-avatar alignleft" src="http://www.gravatar.com/avatar/<?php echo $gravatar; ?>?d=<?php echo $default; ?>&amp;s=50" style="margin-top:5px;" alt="author avatar"  />
									<span><?php _e('Written by', 'popster'); ?></span> <?php the_author_posts_link(); ?>
								</li>
								<li><span><?php _e('Categories', 'popster'); ?></span> <?php the_category(', '); ?></li>
								<li><?php the_tags('<span>Tags</span> ', ', ', ''); ?></li>
								<li><time datetime="<?php echo the_time('Y-m-d'); ?>"><span><?php the_time('j'); ?></span> <?php the_time('F Y'); ?></time></li>
							</ul>

							<section class="post_content clearfix">
								<?php the_excerpt(); ?>
								<p class="read-more"><a href="<?php the_permalink() ?>"><?php _e('Read Post', 'popster'); ?></a></p>
							</section> <!-- end article section -->							
						
						</article> <!-- end article -->
						
						<?php comments_template(); ?>
						<?php 	$i++; ?>
						<?php endwhile; ?>	
						
						<?php 
							if (function_exists('popster_pagenavi')) { 
									popster_pagenavi();
							} else { // if it is disabled, display regular wp prev & next links ?>

							<nav class="wp-prev-next">
								<ul class="clearfix">
									<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'popster')) ?></li>
									<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'popster')) ?></li>
								</ul>
							</nav>
						<?php } ?>		
						
						<?php else : ?>
						
						<article id="post-not-found">
						    <header>
						    	<h1>Not Found</h1>
						    </header>
						    <section class="post_content">
						    	<p>Sorry, but the requested resource was not found on this site.</p>
						    </section>
						    <footer>
						    </footer>
						</article>
						
						<?php endif; ?>
					
					</div> <!-- end #main -->
					<?php get_sidebar();  ?>
					
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>