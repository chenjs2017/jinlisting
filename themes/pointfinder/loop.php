<?php 

if ( is_front_page() ) {
    $pfg_paged = (esc_sql(get_query_var('page'))) ? esc_sql(get_query_var('page')) : '';   
    if (empty($pfg_paged)) {
        $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
    }
    
} else {
    $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
}

$mp_year = esc_sql( get_query_var('year') );
$mp_month = esc_sql( get_query_var('monthnum') );
$mp_day = esc_sql( get_query_var('day') );


$args = array(
    'paged' => esc_sql($pfg_paged),
    'post_type' => array('post')
);

if (!empty($mp_day)) {$args['day'] = $day;}
if (!empty($mp_month)) {$args['monthnum'] = $mp_month;}
if (!empty($mp_year)) {$args['year'] = $mp_year;}

$mp_mdate = esc_sql(get_query_var('m' ));
if (!empty($mp_mdate)) {
    $mp_date_count = strlen($mp_mdate);

    switch ($mp_date_count) {
        case 8:
            $args['year'] = substr($mp_mdate, 0, 4);
            $args['monthnum'] = substr($mp_mdate, 4, 2);
            $args['day'] = substr($mp_mdate, 6, 2);
            break;
        case 6:
            $args['year'] = substr($mp_mdate, 0, 4);
            $args['monthnum'] = substr($mp_mdate, 4, 2);
            break;
        case 4:
            $args['year'] = substr($mp_mdate, 0, 4);
            break;
        
        default:
            # code...
            break;
    }
}


$pfp_cat = esc_sql(get_query_var('cat'));
if (!empty($pfp_cat)) {
    $args['cat'] = $pfp_cat;
}

if(get_query_var('post_format')) {

    $args['tax_query'] = array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => array( ''.esc_sql(get_query_var('post_format')).'' ),
        ),
    );
}

if(isset($_GET['author_name'])){
    $current_author = esc_sql(get_user_by('login',$author_name));
}else{
    $current_author = get_userdata(intval($author));
}

if (isset($_GET['s'])) {
    $args['s'] = $_GET['s'];
}

if (!empty($current_author)) {
    $args['post_author'] = $current_author;
}

if (is_page_template()) {
    $args['post_status'] = array('publish','private');
    $args['posts_per_page'] = get_option('posts_per_page');
}

get_template_part( 'admin/core/post', 'functions' );

$the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) {
        if (isset($_GET['s'])) {
            echo '<div class="pf-search-resulttag">';
            echo sprintf( esc_html__( '%s Result(s) found! ', 'pointfindert2d' ), $the_query->found_posts );
            echo '</div>';
        }
    	while ($the_query->have_posts()) { 
    		$the_query->the_post(); 	
    ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('pointfinder-post'); ?>>
            
            <?php 

            if ( function_exists( 'get_post_format' )){
                switch (get_post_format()) {
                    case 'aside':
                        pf_singlepost_title_list();
                         pf_singlepost_thumbnail_list_small();
                        pf_singlepost_content();
                        pf_singlepost_info_list();
                        break;

                    case 'audio':
                        pf_singlepost_title_list();
                        pf_singlepost_thumbnail_list_small();
                        pf_singlepost_content();
                        pf_singlepost_info_list();
                        break;

                    case 'chat':
                        pf_singlepost_title_list();
                        pf_singlepost_content();
                        pf_singlepost_thumbnail_list_small();
                        pf_singlepost_info_list();
                        break;

                    case 'gallery':
                        pf_singlepost_title_list();
                        pf_singlepost_content();
                        pf_singlepost_info_list();
                        break;

                    case 'image':
                        pf_singlepost_title_list();
                        pf_singlepost_content_list();
                        pf_singlepost_info_list();                       
                        break;

                    case 'video':
                        pf_singlepost_title_list();
                        pf_singlepost_content();
                        pf_singlepost_info_list();
                        break;

                    case 'quote':
                    case 'link':
                    case 'status':
                        pf_singlepost_title_list();
                        pf_singlepost_content();
                        pf_singlepost_info_list();
                        break;
                    
                    default:
                        pf_singlepost_title_list();
                        pf_singlepost_thumbnail_list_small();
                        pf_singlepost_content_list();
                        pf_singlepost_info_list();
                        break;
                }
                
            }else{
                pf_singlepost_title_list();
                pf_singlepost_content();
                pf_singlepost_info_list();
            }

            ?>

        </article>
    	
    <?php 
    }; 

}else{ 

    PFPageNotFound();
	 
};
echo '<div class="pfstatic_paginate">';
$big = 999999999;
echo paginate_links(array(
    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
    'format' => '?paged=%#%',
    'current' => max(1, $pfg_paged),
    'total' => $the_query->max_num_pages,
    'type' => 'list',
));
echo '</div>';
wp_reset_postdata();
?>