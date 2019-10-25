</div><!--/#puremag-content-wrapper -->
</div><!--/#puremag-puremag-wrapper -->

<?php if ( !(puremag_get_option('hide_social_buttons')) ) { ?>
<div class="puremag-social-icons clearfix">
<div class="puremag-social-icons-inner clearfix">
<div class='puremag-container clearfix'>
    <?php if ( puremag_get_option('twitterlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('twitterlink') ); ?>" target="_blank" class="puremag-social-icon-twitter" title="<?php esc_attr_e('Twitter','puremag'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('facebooklink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('facebooklink') ); ?>" target="_blank" class="puremag-social-icon-facebook" title="<?php esc_attr_e('Facebook','puremag'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('googlelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('googlelink') ); ?>" target="_blank" class="puremag-social-icon-google-plus" title="<?php esc_attr_e('Google Plus','puremag'); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('pinterestlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('pinterestlink') ); ?>" target="_blank" class="puremag-social-icon-pinterest" title="<?php esc_attr_e('Pinterest','puremag'); ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('linkedinlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('linkedinlink') ); ?>" target="_blank" class="puremag-social-icon-linkedin" title="<?php esc_attr_e('Linkedin','puremag'); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('instagramlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('instagramlink') ); ?>" target="_blank" class="puremag-social-icon-instagram" title="<?php esc_attr_e('Instagram','puremag'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('flickrlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('flickrlink') ); ?>" target="_blank" class="puremag-social-icon-flickr" title="<?php esc_attr_e('Flickr','puremag'); ?>"><i class="fa fa-flickr" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('youtubelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('youtubelink') ); ?>" target="_blank" class="puremag-social-icon-youtube" title="<?php esc_attr_e('Youtube','puremag'); ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('vimeolink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('vimeolink') ); ?>" target="_blank" class="puremag-social-icon-vimeo" title="<?php esc_attr_e('Vimeo','puremag'); ?>"><i class="fa fa-vimeo" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('soundcloudlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('soundcloudlink') ); ?>" target="_blank" class="puremag-social-icon-soundcloud" title="<?php esc_attr_e('SoundCloud','puremag'); ?>"><i class="fa fa-soundcloud" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('lastfmlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('lastfmlink') ); ?>" target="_blank" class="puremag-social-icon-lastfm" title="<?php esc_attr_e('Lastfm','puremag'); ?>"><i class="fa fa-lastfm" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('githublink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('githublink') ); ?>" target="_blank" class="puremag-social-icon-github" title="<?php esc_attr_e('Github','puremag'); ?>"><i class="fa fa-github" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('bitbucketlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('bitbucketlink') ); ?>" target="_blank" class="puremag-social-icon-bitbucket" title="<?php esc_attr_e('Bitbucket','puremag'); ?>"><i class="fa fa-bitbucket" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('tumblrlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('tumblrlink') ); ?>" target="_blank" class="puremag-social-icon-tumblr" title="<?php esc_attr_e('Tumblr','puremag'); ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('digglink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('digglink') ); ?>" target="_blank" class="puremag-social-icon-digg" title="<?php esc_attr_e('Digg','puremag'); ?>"><i class="fa fa-digg" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('deliciouslink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('deliciouslink') ); ?>" target="_blank" class="puremag-social-icon-delicious" title="<?php esc_attr_e('Delicious','puremag'); ?>"><i class="fa fa-delicious" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('stumblelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('stumblelink') ); ?>" target="_blank" class="puremag-social-icon-stumbleupon" title="<?php esc_attr_e('Stumbleupon','puremag'); ?>"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('redditlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('redditlink') ); ?>" target="_blank" class="puremag-social-icon-reddit" title="<?php esc_attr_e('Reddit','puremag'); ?>"><i class="fa fa-reddit" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('dribbblelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('dribbblelink') ); ?>" target="_blank" class="puremag-social-icon-dribbble" title="<?php esc_attr_e('Dribbble','puremag'); ?>"><i class="fa fa-dribbble" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('behancelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('behancelink') ); ?>" target="_blank" class="puremag-social-icon-behance" title="<?php esc_attr_e('Behance','puremag'); ?>"><i class="fa fa-behance" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('codepenlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('codepenlink') ); ?>" target="_blank" class="puremag-social-icon-codepen" title="<?php esc_attr_e('Codepen','puremag'); ?>"><i class="fa fa-codepen" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('jsfiddlelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('jsfiddlelink') ); ?>" target="_blank" class="puremag-social-icon-jsfiddle" title="<?php esc_attr_e('JSFiddle','puremag'); ?>"><i class="fa fa-jsfiddle" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('stackoverflowlink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('stackoverflowlink') ); ?>" target="_blank" class="puremag-social-icon-stackoverflow" title="<?php esc_attr_e('Stack Overflow','puremag'); ?>"><i class="fa fa-stack-overflow" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('stackexchangelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('stackexchangelink') ); ?>" target="_blank" class="puremag-social-icon-stackexchange" title="<?php esc_attr_e('Stack Exchange','puremag'); ?>"><i class="fa fa-stack-exchange" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('bsalink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('bsalink') ); ?>" target="_blank" class="puremag-social-icon-buysellads" title="<?php esc_attr_e('BuySellAds','puremag'); ?>"><i class="fa fa-buysellads" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('slidesharelink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('slidesharelink') ); ?>" target="_blank" class="puremag-social-icon-slideshare" title="<?php esc_attr_e('SlideShare','puremag'); ?>"><i class="fa fa-slideshare" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('skypeusername') ) : ?>
            <a href="skype:<?php echo esc_html( puremag_get_option('skypeusername') ); ?>?chat" class="puremag-social-icon-skype" title="<?php esc_attr_e('Skype','puremag'); ?>"><i class="fa fa-skype" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('emailaddress') ) : ?>
            <a href="mailto:<?php echo esc_html( puremag_get_option('emailaddress') ); ?>" class="puremag-social-icon-email" title="<?php esc_attr_e('Email Us','puremag'); ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a><?php endif; ?>
    <?php if ( puremag_get_option('rsslink') ) : ?>
            <a href="<?php echo esc_url( puremag_get_option('rsslink') ); ?>" target="_blank" class="puremag-social-icon-rss" title="<?php esc_attr_e('RSS','puremag'); ?>"><i class="fa fa-rss" aria-hidden="true"></i></a><?php endif; ?>
</div>
</div>
</div>
<?php } ?>

<div class='clearfix' id='puremag-footer-blocks' role='contentinfo'>
<div class='puremag-container clearfix'>

<div class='puremag-footer-block-1'>
<?php dynamic_sidebar( 'puremag-footer-1' ); ?>
</div>

<div class='puremag-footer-block-2'>
<?php dynamic_sidebar( 'puremag-footer-2' ); ?>
</div>

<div class='puremag-footer-block-3'>
<?php dynamic_sidebar( 'puremag-footer-3' ); ?>
</div>

<div class='puremag-footer-block-4'>
<?php dynamic_sidebar( 'puremag-footer-4' ); ?>
</div>

</div>
</div><!--/#puremag-footer-blocks-->


<div class='clearfix' id='puremag-footer'>
<div class='puremag-foot-wrap puremag-container'>
<?php if ( puremag_get_option('footer_text') ) : ?>
  <p class='puremag-copyright'><?php echo esc_html(puremag_get_option('footer_text')); ?></p>
<?php else : ?>
  <p class='puremag-copyright'><?php /* translators: %s: Year and site name. */ printf( esc_html__( 'Copyright &copy; %s', 'puremag' ), esc_html(date_i18n(__('Y','puremag'))) . ' ' . esc_html(get_bloginfo( 'name' ))  ); ?></p>
<?php endif; ?>
<p class='puremag-credit'><a href="<?php echo esc_url( 'https://themesdna.com/' ); ?>"><?php /* translators: %s: Theme author. */ printf( esc_html__( 'Design by %s', 'puremag' ), 'ThemesDNA.com' ); ?></a></p>
</div>
</div><!--/#puremag-footer -->

<?php wp_footer(); ?>
</body>
</html>