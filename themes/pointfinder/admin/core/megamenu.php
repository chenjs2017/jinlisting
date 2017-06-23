<?php
/**********************************************************************************************************************************
*
* Megamenu Addon
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/



add_action('wp_update_nav_menu_item', 'pointfinder_custom_nav_update',10, 3);
function pointfinder_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    if(empty($_REQUEST['menu-item-columnvalue'])){
        update_post_meta( $menu_item_db_id, '_menu_item_columnvalue', '0' );
    }else{
        if ( is_array($_REQUEST['menu-item-columnvalue']) ) {
            $custom_value = $_REQUEST['menu-item-columnvalue'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_columnvalue', $custom_value );
        }
    }

    if(empty($_REQUEST['menu-item-megamenu'])){
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu', '0' );
    }else{
        if ( is_array($_REQUEST['menu-item-megamenu']) ) {
            
            if (isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id])) {
                $custom_value2 = $_REQUEST['menu-item-megamenu'][$menu_item_db_id];
                update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $custom_value2 );
            }
        }
    }

    if(empty($_REQUEST['menu-item-megamenu-hide'])){
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_hide', '0' );
    }else{
        if ( is_array($_REQUEST['menu-item-megamenu-hide']) ) {
            
            if (isset($_REQUEST['menu-item-megamenu-hide'][$menu_item_db_id])) {
                $custom_value2 = $_REQUEST['menu-item-megamenu-hide'][$menu_item_db_id];
                update_post_meta( $menu_item_db_id, '_menu_item_megamenu_hide', $custom_value2 );
            }
        }
    }


    if(empty($_REQUEST['menu-item-icon'])){
        update_post_meta( $menu_item_db_id, '_menu_item_icon', '' );
    }else{
        if ( is_array($_REQUEST['menu-item-icon']) ) {
            
            if (isset($_REQUEST['menu-item-icon'][$menu_item_db_id])) {
                $custom_value2 = $_REQUEST['menu-item-icon'][$menu_item_db_id];
                update_post_meta( $menu_item_db_id, '_menu_item_icon', $custom_value2 );
            }
        }
    }
}

add_filter( 'wp_setup_nav_menu_item','pointfinder_custom_nav_item' );
function pointfinder_custom_nav_item($menu_item) {
    $menu_item->columnvalue = get_post_meta( $menu_item->ID, '_menu_item_columnvalue', true );
    $menu_item->megamenu = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
    $menu_item->megamenu_hide_menu = get_post_meta( $menu_item->ID, '_menu_item_megamenu_hide', true );
    $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
    return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'pointfinder_custom_nav_edit_walker',10,2 );
function pointfinder_custom_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}

class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
function start_lvl( &$output, $depth = 0, $args = array() ) {}
function end_lvl(&$output, $depth = 0, $args = array()) {
}

function start_el(&$output, $item = array(), $depth = 0, $args = array(), $id = 0) {
    global $_wp_nav_menu_max_depth;
    
    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        $title = sprintf( __( '%s (Invalid)' , 'pointfindert2d'), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        $title = sprintf( __('%s (Pending)', 'pointfindert2d'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_html__('Move up', 'pointfindert2d'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_html__('Move down','pointfindert2d'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_html__('Edit Menu Item', 'pointfindert2d'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item', 'pointfindert2d' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL', 'pointfindert2d' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label', 'pointfindert2d' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute', 'pointfindert2d' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab', 'pointfindert2d' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)', 'pointfindert2d' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)', 'pointfindert2d' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description', 'pointfindert2d' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'pointfindert2d'); ?></span>
                </label>
            </p> 
            


            <?php
            /*
             * Mega menu Checkbox Field ------------------------------------------------------------------------
             */
            ?>  
            <p class="field-breakline description description-wide"></p>
            
            <p class="field-link-megamenu description description-thin">
                <label for="edit-menu-item-megamenu-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-megamenu-<?php echo $item_id; ?>" value="1" name="menu-item-megamenu[<?php echo $item_id; ?>]"<?php checked( $item->megamenu, '1' ); ?> />
                    <?php _e( 'Enable Mega Menu', 'pointfindert2d' ); ?>
                </label>
            </p>

            <p class="field-link-megamenu-hide description description-thin">
                <label for="edit-menu-item-megamenu-hide-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-megamenu-hide-<?php echo $item_id; ?>" value="1" name="menu-item-megamenu-hide[<?php echo $item_id; ?>]"<?php checked( $item->megamenu_hide_menu, '1' ); ?> />
                    <?php _e( 'Hide Menu', 'pointfindert2d' ); ?>
                </label>
            </p>

            <p class="field-breakline description description-wide"></p>

            <?php
            /*
             * Column Field ------------------------------------------------------------------------
             */
            ?>
            <p class="field-columnvalue description description-wide">
                <label for="edit-menu-item-columnvalue-<?php echo $item_id; ?>">
                    <?php _e( 'Column Number for Mega Menu', 'pointfindert2d' ); ?><br />
                   
                    <select name="menu-item-columnvalue[<?php echo $item_id; ?>]" id="edit-menu-item-columnvalue-<?php echo $item_id; ?>" class="input-block-level aura_wpmse_select2_<?php echo $item_id; ?>" style="width: 100%;" required>
                        <?php if($item->columnvalue != ''){?>
                        <option value="<?php echo esc_attr( $item->columnvalue ); ?>" data-icon="<?php echo esc_attr( $item->columnvalue ); ?>" selected><?php echo esc_attr( $item->columnvalue ); ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <?php }else{?>
                        <option value="1"><?php echo __('Please select','pointfindert2d');?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <?php }?>
                    </select>
                </label>
            </p>

            <p class="field-breakline description description-wide"></p>

            <p class="description description-wide">
                <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                    <?php _e( 'Icon', 'pointfindert2d' ); ?><br />
                    <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat edit-menu-item-icon" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->icon ); ?>" />
                </label>
            </p>


            
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s', 'pointfindert2d'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove', 'pointfindert2d'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'pointfindert2d'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php
    $output .= ob_get_clean();
    }
}

?>