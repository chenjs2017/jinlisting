<?php
$block = $block_data[0];
$settings = $block_data[1];
?>
<?php if($block === 'title'){ ?>
<span class="post-title" >
    <?php echo !empty($settings[0]) && $settings[0]!='no_link' ? $this->getLinked($post, $post->title, $settings[0], 'link_title') : $post->title ?>
</span>
<?php }elseif($block === 'image' && !empty($post->thumbnail)){ ?>
<div class="post-thumb">
    <?php 
    if(!empty($settings[0]) && $settings[0]!='no_link'){
        if(!empty($post->thumbnail_data['p_img_large'][0])){
        echo $this->getLinked($post,'<div class="wbp_vc_gallery_pfwrapper">'.$post->thumbnail.'<div class="PStyleHe"></div></div>', $settings[0], 'link_image');
        }
    }else{
        if(!empty($post->thumbnail_data['p_img_large'][0])){
            $post->thumbnail;
        }
    }
    ?>
</div>
<?php }elseif($block === 'text'){ ?>
<div class="entry-content" >
    <?php echo !empty($settings[0]) && $settings[0]==='text' ?  $post->content : $post->excerpt; ?>
</div>
<?php }elseif($block === 'link'){ ?>
<a href="<?php echo $post->link ?>" class="vc_read_more"  title="<?php echo esc_attr(sprintf(esc_html__( 'Permalink to %s', "pointfindert2d" ), $post->title_attribute)); ?>"<?php echo $this->link_target ?>><?php esc_html_e('Read more...', "pointfindert2d") ?></a>
<?php }elseif($block === 'bloginfo'){ ?>

    <?php if(!empty($settings[0])){?>
        
            <?php switch ($settings[0]) {
                case 'datecomments':
                    ?>
                    <div class="entry-content" >
                    <a href="<?php echo $post->link ?>" class="bloginfolink" title="<?php echo esc_attr(sprintf(esc_html__( 'Permalink to %s', "pointfindert2d" ), $post->title_attribute)); ?>"<?php echo $this->link_target ?>>
                        <?php echo '<i class="pfadmicon-glyph-28"></i> '.get_the_time(get_option('date_format'),$post->id); ?>
                    </a>
                    <a href="<?php echo $post->link ?>" class="bloginfolink pfvc_bcomment" title="<?php echo esc_attr(sprintf(esc_html__( 'Permalink to %s', "pointfindert2d" ), $post->title_attribute)); ?>"<?php echo $this->link_target ?>>
                        <?php 
                        $commentcount = get_comments(array('post_id' => $post->id, 'count' => true));
                        if($commentcount > 1){ 
                            echo '<i class="pfadmicon-glyph-382"></i> '.$commentcount;
                        }
                        ?>
                    </a>
                    </div>
                    <?php
                    break;
                
                case 'comments':
                    $commentcount = get_comments(array('post_id' => $post->id, 'count' => true));
                    if($commentcount > 1){ 
                    ?>
                    <div class="entry-content" >
                    <a href="<?php echo $post->link ?>" class="bloginfolink pfvc_bcomment" title="<?php echo esc_attr(sprintf(esc_html__( 'Permalink to %s', "pointfindert2d" ), $post->title_attribute)); ?>"<?php echo $this->link_target ?>>
                        <?php 
                            echo '<i class="pfadmicon-glyph-382"></i> '.$commentcount;
                        ?>
                    </a>
                    </div>
                    <?php
                    }
                    break;

                case 'date':
                    ?>
                    <div class="entry-content" >
                    <a href="<?php echo $post->link ?>" class="bloginfolink" title="<?php echo esc_attr(sprintf(esc_html__( 'Permalink to %s', "pointfindert2d" ), $post->title_attribute)); ?>"<?php echo $this->link_target ?>>
                        <?php echo '<i class="pfadmicon-glyph-28"></i> '.get_the_time(get_option('date_format'),$post->id); ?>
                    </a>
                    </div>
                    <?php
                    break;
            } ?>
        	
        
    <?php }?>

<?php }; ?>