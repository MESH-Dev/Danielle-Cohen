<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.4
**/
global $ti_option;
if ( $ti_option['site_sidebar_fixed'] == true ) { $sidebar_fixed = ' sidebar-fixed'; }
?>
<div class="grid-4 column-2<?php echo isset( $sidebar_fixed ) ? $sidebar_fixed : ''; ?>">
    <aside class="sidebar" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
        <?php
        // Output sidebar for pages besides homepage
        if ( is_page() && !is_page_template( 'page-composer.php' )) {
            if ( is_active_sidebar( 'sidebar-2' ) ) {
                dynamic_sidebar( 'sidebar-2' );
            }
        // Output sidebar for homepage, categories and posts
        } else {
            if ( is_active_sidebar( 'sidebar-1' ) ) {
                dynamic_sidebar( 'sidebar-1' );
            }
        }
        ?>
        <div id="tags-2" class="widget widget_categories">
          <?php
            $tags = get_tags();
            if ($tags) {
              echo "<h3>Categories</h3>";
              echo "<ul>";
              foreach ($tags as $tag) {


                if(get_field('show_in_sidebar', $tag)) {
                  echo '<li><a href="' . get_tag_link( $tag->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $tag->name ) . '" ' . '>' . $tag->name.'</a></li>';
                }

              }
              echo "</ul>";
            }
          ?>
        </div>
    </aside><!-- .sidebar -->
</div>
