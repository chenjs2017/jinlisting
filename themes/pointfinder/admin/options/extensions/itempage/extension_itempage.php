<?php

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_slides
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) {
    exit;
}

// Don't duplicate me!
if ( !class_exists ( 'ReduxFramework_extension_itempage' ) ) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_extension_itempage {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct ( $field = array(), $value = '' ) {
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render () {

            $defaults = array(
                'show' => array(
                    'title' => true,
                    'description' => true,
                    'url' => true,
                ),
                'content_title' => esc_html__( 'Slide', 'pointfindert2d' )
            );

            $this->field = wp_parse_args ( $this->field, $defaults );
            $ip_options = array('1' => esc_html__('Enable', 'pointfindert2d') ,'0' => esc_html__('Disable', 'pointfindert2d'));
            $ip_options2 = array('1' => esc_html__('Left', 'pointfindert2d'),'2' => esc_html__('Right', 'pointfindert2d') ,'0' => esc_html__('Disable', 'pointfindert2d'));

            echo '<div class="redux-extension_itempage-accordion" data-new-content-title="' . esc_attr ( sprintf ( esc_html__( 'New %s', 'pointfindert2d' ), $this->field[ 'content_title' ] ) ) . '">';

           

            if ( isset ( $this->value ) && is_array ( $this->value ) && !empty ( $this->value ) ) {
                $slides = $this->value;
               
                if (!array_key_exists('customtab1', $this->value)) {
                 
                    $newslides = array( array(
                        'ftitle'=>'customtab1',
                        'title' => 'Custom Tab1',
                        'sort' => '9',
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'customtab2',
                        'title' => 'Custom Tab2',
                        'sort' => '10',
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'customtab3',
                        'title' => 'Custom Tab3',
                        'sort' => '11',
                        'status' => 0
                    ));
                    $slides = array_merge($slides,$newslides);

                }

            }else{
                $slides = array(
                    array(
                        'ftitle'=>'gallery',
                        'title' => 'Gallery',
                        'sort' => '1',
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'informationbox',
                        'title' => 'Information',
                        'sort' => '2',
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'description1',
                        'title' => 'Description',
                        'sort' => '3',
                        'fimage' => 1,
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'description2',
                        'title' => 'Details',
                        'sort' => '4',
                        'fimage' => 1,
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'location',
                        'title' => 'Map View',
                        'sort' => '5',
                        'mheight' => 340,
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'streetview',
                        'title' => 'Street View',
                        'sort' => '6',
                        'mheight' => 340,
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'video',
                        'title' => 'Video',
                        'sort' => '7',
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'contact',
                        'title' => 'Contact',
                        'sort' => '8',
                        'status' => 1
                    ),
                    array(
                        'ftitle'=>'customtab1',
                        'title' => 'Custom Tab1',
                        'sort' => '9',
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'customtab2',
                        'title' => 'Custom Tab2',
                        'sort' => '10',
                        'status' => 0
                    ),
                    array(
                        'ftitle'=>'customtab3',
                        'title' => 'Custom Tab3',
                        'sort' => '11',
                        'status' => 0
                    )

                );
            }
            

            foreach ( $slides as $slide ) {

                if ( empty ( $slide ) ) {
                    continue;
                }

                $defaults = array(
                    'ftitle'=> '',
                    'title' => '',
                    'sort' => '',
                    'mheight' => 340,
                    'fimage' => 0,
                    'status' => 0,
                    'mcontent'=>''
                );
                $slide = wp_parse_args ( $slide, $defaults );

               
                echo '<div class="redux-extension_itempage-accordion-group"><fieldset class="redux-field" data-id="' . $this->field[ 'id' ] . '"><h3><span class="redux-extension_itempage-header">' . $slide[ 'title' ] . '</span></h3><div>';

               

                echo '<ul id="' . $this->field[ 'id' ] . '-ul" class="redux-extension_itempage-list">';

                /**
                *Start: Title of Field
                **/
                    $placeholder = esc_html__( 'Title', 'pointfindert2d' );
                    echo '<li><input type="text" id="' . $this->field[ 'id' ] . '-title_' . $slide[ 'ftitle' ] . '" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][title]' . $this->field['name_suffix'] . '" value="' . esc_attr ( $slide[ 'title' ] ) . '" placeholder="' . $placeholder . '" class="full-text extension_itempage-title" /></li>';
                /**
                *End: Title of Field
                **/




                /**
                *Start: Status of Field
                **/
                    echo '<li class="pf-button-container">';
                    echo '<span class="pf-inner-title">'.esc_html__('Status','pointfindert2d').' : </span>';
                    echo '<div class="buttonset ui-buttonset">';
                    
                    
                    foreach ( $ip_options as $k => $v ) {

                        $selected = '';
                        
                        $multi_suffix = "";
                        $type         = "radio";
                        $selected     = checked( $slide['status'], $k, false );
                        

                        echo '<input data-id="' . $this->field[ 'id' ] . '-status_' . $slide[ 'ftitle' ] . '" type="' . $type . '" id="' . $this->field[ 'id' ] . '-status_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][status]" class="buttonset-item" value="' . $k . '" ' . $selected . '/>';
                        echo '<label for="' . $this->field[ 'id' ] . '-status_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '">' . $v . '</label>';
                    }

                    echo '</div></li>';

                    
                /**
                *End: Status of Field
                **/



                
             
                

                if ($slide[ 'ftitle' ] == 'description1' || $slide[ 'ftitle' ] == 'description2') {
                    /**
                    *Start: Featured Image of Field
                    **/
                        echo '<li class="pf-button-container">';
                        echo '<span class="pf-inner-title">'.esc_html__('Featured Image','pointfindert2d').' : </span>';
                        echo '<div class="buttonset ui-buttonset">';
                        
                        
                        foreach ( $ip_options2 as $k => $v ) {

                            $selected = '';
                            
                            $multi_suffix = "";
                            $type         = "radio";
                            $selected     = checked( $slide['fimage'], $k, false );
                            

                            echo '<input data-id="' . $this->field[ 'id' ] . '-fimage_' . $slide[ 'ftitle' ] . '" type="' . $type . '" id="' . $this->field[ 'id' ] . '-fimage_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][fimage]" class="buttonset-item" value="' . $k . '" ' . $selected . '/>';
                            echo '<label for="' . $this->field[ 'id' ] . '-fimage_' . $slide[ 'ftitle' ] . '-buttonset' . $k . '">' . $v . '</label>';
                        }

                        echo '</div></li>';

                        
                    /**
                    *End: Featured Image of Field
                    **/
                }


                if ($slide[ 'ftitle' ] == 'location' || $slide[ 'ftitle' ] == 'streetview') {

                    /**
                    *Start: Height of Field
                    **/
                        echo '<li>';
                        echo '<span class="pf-inner-title">'.esc_html__('Map Height','pointfindert2d').' : </span>';
                        echo '
                        <input type="text" id="' . $this->field[ 'id' ] . '-mheight_' . $slide[ 'ftitle' ] . '" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][mheight]' . $this->field['name_suffix'] . '" value="' . $slide[ 'mheight' ] . '" class="full-text2 extension_itempage-mheight" />px</li>';
                    /**
                   * End: Height of Field
                    **/

                }

               
                echo '<li><input type="hidden" class="extension_itempage-sort" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][sort]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-sort_' . $slide[ 'ftitle' ] . '" value="' . $slide[ 'sort' ] . '" /></li>';
                echo '<li><input type="hidden" class="extension_itempage-ftitle" name="' . $this->field[ 'name' ] . '[' . $slide[ 'ftitle' ] . '][ftitle]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-ftitle_' . $slide[ 'ftitle' ] . '" value="' . $slide[ 'ftitle' ] . '" /></li>';
                echo '</ul></div></fieldset></div>';
       
            }
            

            
            echo '</div><br/>';

        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue () {
            global $pagenow, $post_type;
            $pagename = (isset($_GET['page']))?$_GET['page']:'';
            if (
                    (
                        $pagenow == 'admin.php' && 
                        (
                            $pagename == '_pointfinderoptions' || 
                            $pagename == '_pfadvancedlimitconf'
                        )
                    ) || 
                    (
                        (
                            $pagenow == 'post.php' || $pagenow == 'post-new.php'
                        ) &&
                        (   $post_type == 'pfaltsettings'
                        )
                    ) 
                ) {
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script (
                    'redux-field-itempage-js', 
                    get_template_directory_uri().'/admin/options/extensions/itempage/field_itempage.js', 
                    array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion'), 
                    time(), 
                    true
                );

                wp_enqueue_style(
                    'redux-field-itempage-css',
                    get_template_directory_uri().'/admin/options/extensions/itempage/field_itempage.css',
                    time(),
                    false
                );      
            }

                     
            

        }
    }

}