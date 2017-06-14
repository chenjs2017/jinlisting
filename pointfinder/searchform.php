<!-- Searchform -->
<div class="subhead">
<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' )); ?>" data-ajax="false">
	<div class="input">
	<input id="s" type="text" name="s" onclick="this.value='';"  onfocus="if(this.value==''){this.value=''};" onblur="if(this.value==''){this.value=''};" value="<?php esc_html_e( 'Search', 'pointfindert2d' ); ?>" class="search-query fa-input" >
    </div>
</form>
</div>
<!-- /Searchform -->