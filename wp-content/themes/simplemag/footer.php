<?php
/**
 * The template for displaying the footer.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
global $ti_option;
?>

        <footer id="footer" class="no-print animated" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

          <div class="wrapper">
            <div class="grids">
              <div class="grid-12 column-1">
                <h2 class="insta-header">Soundcake on Instagram</h2>
                <div id="instafeed">
                </div>
              </div>
            </div>
            <div class="grids">
              <div class="grid-4 column-1">
                <div id="search-2" class="widget widget_search">
                  <form method="get" id="searchform" action="http://localhost/dc/" role="search">
                  	<input type="text" name="s" id="s" value="Search" onfocus="if(this.value=='Search')this.value='';" onblur="if(this.value=='')this.value='Search';">
                      <button type="submit">
                      	<i class="icomoon-search"></i>
                      </button>
                  </form>
                </div>
              </div>
              <div class="grid-4 column-2">
                <div class="social-icons-container">
                  <ul class="social-icons">
                    <li><i class="fa fa-envelope"></i></li>
                    <li><i class="fa fa-facebook"></i></li>
                    <li><i class="fa fa-twitter"></i></li>
                    <li><i class="fa fa-tumblr"></i></li>
                    <li><i class="fa fa-instagram"></i></li>
                    <li><i class="fa fa-pinterest"></i></li>
                  </ul>
                </div>
              </div>
              <div class="grid-4 column-3">
                <div class="mesh">Site by <a href="http://meshfresh.com">MESH</a></div>
              </div>
            </div>
          </div>

        </footer><!-- #footer -->

        <div class="soundbar" style="background-image: url('<?php echo get_template_directory_uri() ?>/images/DaniCohen_BackgroundImage.jpg');">
          <div class="wrapper">
            <div class="grids">
              <div class="grid-4">
                <div class="artist-info">
                  <span class="artist-info-song trackTitle"></span>
                   <!-- | <span class="artist-info-artist artistTitle">Artist</span> -->
                </div>
              </div>
              <div class="grid-4">
                <div class="controls">
                  <div class="backward control">
                    <i class="fa fa-backward" id="prev"></i>
                  </div>
                  <div class="play control">
                    <i class="fa fa-play" id="play"></i>
                    <i class="fa fa-pause" id="pause" style="display:none;"></i>
                  </div>
                  <div class="forward control">
                    <i class="fa fa-forward" id="next"></i>
                  </div>
                </div>
              </div>
              <div class="grid-4">
                <div class="soundcloud">
                  <i class="fa fa-soundcloud"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div><!-- .site-content -->
</section><!-- #site -->

<?php wp_footer(); ?>
</body>
</html>
