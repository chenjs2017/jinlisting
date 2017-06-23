<?php get_header(); ?>

    <section role="main">
        <div class="pf-container">
            <div class="pf-row">
                <div class="col-lg-12">
                 
                    <form method="get" class="form-search" action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
                    <div class="pf-notfound-page">
                        <h1>404</h1>
                        <h2><?php esc_html_e( 'Page not found', 'pointfindert2d' ); ?></h2><br>
                        <p class="text-lightblue-2"><?php esc_html_e( 'You better try to search', 'pointfindert2d' ); ?>:</p>
                        <div class="row">
                            <div class="pfadmdad input-group col-sm-4 col-sm-offset-4">
                                <i class="pfadmicon-glyph-386"></i>
                                <input type="text" name="s" class="form-control" onclick="this.value='';"  onfocus="if(this.value==''){this.value=''};" onblur="if(this.value==''){this.value=''};" value="<?php esc_html_e( 'Search', 'pointfindert2d' ); ?>">
                                <span class="input-group-btn">
                                    <button onc class="btn btn-success" type="submit"><?php esc_html_e( 'Search', 'pointfindert2d' ); ?></button>
                                  </span>
                            </div>
                        </div><br>
                        <a class="btn btn-primary btn-sm" href="<?php echo esc_url(home_url()); ?>"><i class="pfadmicon-glyph-857"></i><?php esc_html_e( 'Return Home', 'pointfindert2d' ); ?></a>
                    </div>
                    </form>
                
                </div>
            </div>
        </div>
    </section>


<?php get_footer(); ?>