<?php
/**
 * The main template file
 *
 * @package SimpleMag
 * @since   SimpleMag 1.0
**/
get_header();
global $ti_option;
?>

<?php $archive_sidebar = get_field( 'page_sidebar', get_option('page_for_posts') ); ?>

    <section id="content" role="main" class="clearfix animated">

		<?php if ( $ti_option['posts_page_title'] == 'full_width_title' ) : ?>
        <header class="entry-header page-header">
            <div class="wrapper title-with-sep page-title">
                <h1 class="entry-title">
                    <?php
                    $posts_page_id = get_option( 'page_for_posts' );
                    echo get_the_title( $posts_page_id );
                    ?>
                </h1>
            </div>
        </header>
        <?php endif; ?>


        <div class="wrapper">

		<?php
        // Enable/Disable sidebar based on the field selection
        if ( ! $archive_sidebar || $archive_sidebar == 'page_sidebar_on' ):
        ?>

            <div class="grids">

              <div class="grid-12 column-1">

                <section class="wrapper home-section featured-posts">

                  <?php if( get_sub_field( 'featured_main_title' ) ): ?>
                    <header class="section-header">
                        <div class="title-with-sep">
                            <h2 class="title"><?php the_sub_field( 'featured_main_title' ); ?></h2>
                        </div>
                        <?php if( get_sub_field( 'featured_sub_title' ) ): ?>
                        <span class="sub-title"><?php the_sub_field( 'featured_sub_title' ); ?></span>
                        <?php endif; ?>
                    </header>
                    <?php endif; ?>

                    <?php
                    /**
                     * Add posts to this section only if the 'Make Featured'
                     * custom field checkbox was checked on the Post edit page
                    **/
                    $fposts_to_show = get_sub_field( 'featured_posts_per_page' );
                    $ti_featured_posts = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'meta_key' => 'featured_post_add',
                            'meta_value' => '1',
                            'posts_per_page' => 1
                        )
                    );
                    ?>

                    <div class="grids entries top-post">

                  <?php
                    if ( $ti_featured_posts->have_posts() ) :
                        while ( $ti_featured_posts->have_posts() ) : $ti_featured_posts->the_post(); ?>

                            <article <?php post_class("grid-12"); ?>>

                                <figure class="entry-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail( 'rectangle-size' );
                                        } elseif( first_post_image() ) { // Set the first image from the editor
                                            echo '<img src="' . first_post_image() . '" class="wp-post-image" alt="' . get_the_title() . '" />';
                                        } ?>
                                    </a>
                                </figure>

                                <header class="entry-header ">

                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="entry-meta">
                                       <?php ti_meta_data(); ?>
                                    </div>
                                     <div class="entry-read-more">
                                       <a href="<?php the_permalink();?>">Read More</a>                                  </div>
                                    <?php
                                    if( $ti_option['site_author_name'] == 1 ) { ?>

                                    <?php } ?>
                                </header>

                                <?php if( get_sub_field( 'featured_excerpt' ) == 'enable' ) { ?>
                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php } ?>

                            </article>

                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                    </div>

                    <?php else : ?>

                    <p class="message">
                        <?php _e( 'There are no featured posts yet', 'themetext' ); ?>
                    </p>

                    <?php endif; ?>

                </section><!-- Featured Posts -->

              </div>

              <div class="grid-8 column-1">


    <?php
        endif;
        ?>

                <?php if ( $ti_option['posts_page_title'] == 'above_content_title' ) : ?>
                <header class="entry-header page-header">
                    <div class="title-with-sep page-title">
                        <h1 class="entry-title">
							<?php
                            $posts_page_id = get_option( 'page_for_posts' );
                            echo get_the_title( $posts_page_id );
                            ?>
                        </h1>
                    </div>
                </header>
                <?php endif; ?>

                <div class="grids <?php echo $ti_option['posts_page_layout']; ?> entries">
					<?php
                    if ( have_posts() ) : while ( have_posts()) : the_post();

                      if (!get_field('featured_post_add')) {
                        get_template_part( 'content', 'post' );
                      }

                    endwhile;
                    ?>
                </div>

                <?php ti_pagination(); ?>

                <?php else : ?>

                <p class="message">
                	<?php _e( 'Sorry, no posts were found', 'themetext' ); ?>
                </p>

                <?php endif;?>

                <?php
                // Enable/Disable sidebar based on the field selection
                if ( ! $archive_sidebar || $archive_sidebar == 'page_sidebar_on' ):
                ?>
                </div><!-- .grid-8 -->

                <?php get_sidebar(); ?>

            </div><!-- .grids -->
    		<?php endif; ?>

        </div><!-- .wrapper -->
    </section><!-- #content -->

<?php get_footer(); ?>
