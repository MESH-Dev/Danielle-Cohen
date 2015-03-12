<?php
/**
 * The Template for displaying all single blog posts
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/
get_header();
global $ti_option;
$single_sidebar = get_post_meta( $post->ID, 'post_sidebar', true );
?>

    <main id="content" class="clearfix animated" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">

            <header class="wrapper entry-header page-header">
                <div class="entry-meta">

                    <span class='authormeta'>By <?php the_author(); ?> / </span><?php  $publish_date = '<time class="entry-date updated" datetime="' . get_the_time( 'c' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>'; echo $publish_date;?>
                </div>

                <div class="title-with-sep single-title">
                    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
                </div>
            </header>



            <div class="wrapper">

                <?php if ( ! $single_sidebar || $single_sidebar == "post_sidebar_on" ) { // Enable/Disable post sidebar ?>
                <div class="grids">
                    <div class="grid-8 column-1">
                <?php } ?>


                        <div class="entry-media">
                            <?php
                            if ( ! get_post_format() ): // Standard
                                get_template_part( 'formats/format', 'standard' );
                            elseif ( 'video' == get_post_format() ): // Video
                                get_template_part( 'formats/format', 'video' );
                            elseif ( 'audio' == get_post_format() ): // Audio
                                get_template_part( 'formats/format', 'audio' );
                            endif;
                            ?>
                        </div>

                    <?php
                    // Ad Unit
                    if ( $ti_option['single_image_top_ad']['url'] == true || ! empty ( $ti_option['single_code_top_ad'] ) ) { ?>
                    <div class="advertisement">
                        <?php
                        $single_banner_top = $ti_option['single_image_top_ad'];
                        // Image Ad
                        if ( $single_banner_top['url'] == true ) { ?>
                            <a href="<?php echo $ti_option['single_image_top_ad_url']; ?>" rel="nofollow" target="_blank">
                                <img src="<?php echo $single_banner_top['url']; ?>" width="<?php echo $single_banner_top['width']; ?>" height="<?php echo $single_banner_top['height']; ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                            </a>
                        <?php
                        // Code Ad
                        } elseif( $ti_option['single_code_top_ad'] == true ) {
                            echo $ti_option['single_code_top_ad'];
                        } ?>
                    </div><!-- .advertisment -->
                    <?php } ?>

                    <?php
                    // Post Rating
                    if ( $ti_option['single_rating_box'] == 'rating_top' ) {
                        get_template_part( 'inc/single', 'rating' );
                    }
                    ?>

                    <div class="single-box clearfix entry-content" itemprop="articleBody">
                        <?php the_content(); ?>
                        <?php
                        $args = array(
                            'before' => '<div class="link-pages"><h3 class="title">' . __( 'Continue Reading', 'themetext' ) . '</h3>',
                            'after' => '</div>',
                            'link_before' => '<span>',
                            'link_after' => '</span>',
                            'nextpagelink'     => '&rarr;',
                            'previouspagelink' => '&larr;',
                            'next_or_number'   => 'next_and_number',
                        );
                        wp_link_pages( $args );
                        ?>
                    </div><!-- .entry-content -->

                    <?php
                    // Post Rating output at the bottom
                    if ( $ti_option['single_rating_box'] == 'rating_bottom' ) {
                        get_template_part( 'inc/single', 'rating' );
                    }

                    // Show/Hide tags list
                    if ( $ti_option['single_tags_list'] == 1 ) {
                        the_tags('<div class="single-box tag-box clearfix"><h3 class="title">' . __( 'Tags', 'themetext' ) . '</h3>', '', '</div>');
                    }

                    ?>

                    <div class="social-section">
                      <div class="social-section-icons">
                        <div class="social-section-icons-share"><strong>SHARE</strong></div>
                        <ul class="social-icons">
                          <li><i class="fa fa-envelope"></i></li>
                          <li><i class="fa fa-facebook"></i></li>
                          <li><i class="fa fa-twitter"></i></li>
                        </ul>
                      </div>
                      <div class="social-section-author">
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author" itemprop="url">
                            <span itemprop="name"><strong>MORE FROM:</strong> <?php the_author_meta( 'display_name' ); ?></span>
                        </a>
                      </div>
                    </div>

                    <?php
                    // Ad Unit
                    if ( $ti_option['single_image_bottom_ad']['url'] == true || ! empty ( $ti_option['single_code_bottom_ad'] ) ) { ?>
                        <div class="single-box advertisement">
                            <?php
                            // Image Ad
                            if ( $ti_option['single_image_bottom_ad']['url'] == true ) {
                                $single_banner_botom = $ti_option['single_image_bottom_ad']; ?>
                                <a href="<?php echo $ti_option['single_image_bottom_ad_url']; ?>" rel="nofollow" target="_blank">
                                    <img src="<?php echo $single_banner_botom['url']; ?>" width="<?php echo $single_banner_botom['width']; ?>" height="<?php echo $single_banner_botom['height']; ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                                </a>
                            <?php
                            }
                            // Code Ad
                            elseif ( $ti_option['single_code_bottom_ad'] == true ) {
                                echo $ti_option['single_code_bottom_ad'];
                            } ?>
                        </div><!-- .advertisment -->
                    <?php } ?>


                    <?php
                    // Navigation
                    if ( $ti_option['single_nav_arrows'] == 1 ) { // Show/Hide Previous Post / Next Post Navigation
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                            <nav class="single-box clearfix nav-single">
                                <?php if ( !empty( $prev_post ) ) { ?>
                                <div class="nav-previous">
                                    <?php previous_post_link ( '%link', '<i class="icomoon-chevron-left"></i><span class="sub-title">' . __( 'Previous article', 'themetext' ) . '</span>%title', TRUE ); ?>
                                </div>
                                <?php } ?>

                                <?php if ( !empty( $next_post ) && !empty( $prev_post ) ) { ?>
                                    <span class="sep"></span>
                                <?php } ?>

                                <?php if ( !empty( $next_post ) ){ ?>
                                <div class="nav-next">
                                    <?php next_post_link( '%link', '<i class="icomoon-chevron-right"></i><span class="sub-title">' . __( 'Next article', 'themetext' ) . '</span>%title', TRUE ); ?>
                                </div>
                                <?php } ?>
                            </nav><!-- .nav-single -->
                    <?php } ?>


                    <?php
                    // Show/Hide related posts
                    if ( $ti_option['single_related'] == 1 ) {
                        get_template_part( 'inc/related', 'posts' );
                    }
                    ?>

                    <?php comments_template(); // Comments Template ?>


                    <?php if ( ! $single_sidebar || $single_sidebar == "post_sidebar_on" ) { // Enable/Disable post sidebar ?>
                    </div><!-- .grid-8 -->

                    <?php get_sidebar(); ?>
                </div><!-- .grids -->
                <?php }  ?>

            </div><!-- .wrapper -->

        </article>

    <?php endwhile; endif; ?>

    </main><!-- #content -->

    <?php
    // Show/Hide random posts slide dock
    if ( $ti_option['single_slide_dock'] == 1 ) {
        get_template_part( 'inc/slide', 'dock' );
    }
    ?>

<?php get_footer(); ?>
