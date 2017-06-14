<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
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
if (!defined('ABSPATH')) exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_extension_sidebar_slides')) {

    /**
     * Main ReduxFramework_sidebar_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_extension_sidebar_slides extends ReduxFramework{

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='' ) {//, $parent
        
            //parent::__construct( $parent->sections, $parent->args );
           // $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
			
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 30 );      
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            //print_r($this->value);

            echo '<div class="redux-sidebar-slides-accordion">';

            $x = 0;

            $multi = (isset($this->field['multi']) && $this->field['multi']) ? ' multiple="multiple"' : "";

            if (isset($this->value) && is_array($this->value)) {

                $slides = $this->value;

                foreach ($slides as $slide) {
                    
                    if ( empty( $slide ) ) {
                        continue;
                    }

                    $defaults = array(
                        'title' => '',
                        'description' => '',
						'rvalues' => '',
                        'sort' => '',
                        'url' => 'field'.md5(uniqid(rand(), true)),
						'standart' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args( $slide, $defaults );
					if($slide['url'] == ''){$slide['url'] = 'field_'.md5(uniqid(rand(), true));}
                    echo '<div class="redux-sidebar-slides-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-sidebar-slides-header">' . $slide['title'] . '</span></h3><div>';
                    echo '<ul id="' . $this->field['id'] . '-ul" class="redux-sidebar-slides-list">';
                    $placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : esc_html__( 'Title', 'pointfindert2d' );
					
					

                    echo '<li><label for="' . $this->field['id'] . '-title_' . $x . '">' . esc_html__('Title :', 'pointfindert2d') . '</label><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][title]" value="' . esc_attr($slide['title']) . '" placeholder="'.$placeholder.'" class="full-text slide-title" /></li>';
					$placeholder = (isset($this->field['placeholder']['url'])) ? esc_attr($this->field['placeholder']['url']) : esc_html__( 'ID', 'pointfindert2d' );
                    echo '<li><label for="' . $this->field['id'] . '-url_' . $x . '">' . esc_html__('ID : (Do not change or remove after beginning to use widget!)', 'pointfindert2d') . '</label><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][url]" value="' . $slide['url'] . '" class="full-text slide-url" /></li>';
					echo '<li><input type="hidden" class="slide-sort" name="' . $this->field['name'] . '[' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $slide['sort'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-sidebar-slides-remove">' . esc_html__('Delete Field', 'pointfindert2d') . '</a></li>';
                    echo '</ul></div></fieldset></div>';

                    $x++;
                
                }
            }

            if ($x == 0) {
                echo '<div class="redux-sidebar-slides-accordion-group"><fieldset class="redux-field" data-id="'.$this->field['id'].'"><h3><span class="redux-sidebar-slides-header">New Item</span></h3><div>';
                echo '<ul id="' . $this->field['id'] . '-ul" class="redux-sidebar-slides-list">';
				
          
				$placeholder = (isset($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : esc_html__( 'Title', 'pointfindert2d' );
                echo '<li><label for="' . $this->field['id'] . '-title_' . $x . '">' . esc_html__('Title :', 'pointfindert2d') . '</label><input type="text" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][title]" value="" placeholder="'.$placeholder.'" class="full-text slide-title" /></li>';
              
				$placeholder = (isset($this->field['placeholder']['url'])) ? esc_attr($this->field['placeholder']['url']) : esc_html__( 'ID', 'pointfindert2d' );
                echo '<li><label for="' . $this->field['id'] . '-url_' . $x . '">' . esc_html__('ID : (Leave empty for assigning auto unique key)', 'pointfindert2d') . '</label><input type="text" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][url]" value="" class="full-text"  /></li>';
			    echo '<li><input type="hidden" class="slide-sort" name="' . $this->field['name'] . '[' . $x . '][sort]" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $x . '" /></li>';
                echo '<li><a href="javascript:void(0);" class="button deletion redux-sidebar-slides-remove">' . esc_html__('Delete Field', 'pointfindert2d') . '</a></li>';
                echo '</ul></div></fieldset></div>';

            }
            echo '</div><a href="javascript:void(0);" class="button redux-sidebar-slides-add button-primary" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->field['name'] . '[title][]">' . esc_html__('Add New Field', 'pointfindert2d') . '</a><br/>';
			
			
			
        }         

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */

        public function enqueue() {

            global $pagenow;
            $pagename = (isset($_GET['page']))?$_GET['page']:'';
            if ($pagenow == 'admin.php' && $pagename == '_pfsidebaroptions') {
                wp_enqueue_script(
                    'redux-field-sidebarslides-js',
                    get_template_directory_uri().'/admin/options/extensions/sidebar_slides/field_custom_slides.js',
                    array('jquery', 'jquery-ui-core', 'jquery-ui-accordion','jquery-ui-sortable'),
                    time(),
                    true
                );
                
                wp_enqueue_style(
                    'redux-field-sidebarslides-css',
                    get_template_directory_uri().'/admin/options/extensions/sidebar_slides/field_custom_slides.css',
                    time(),
                    true
                );
            }
           


        }

    }
}
