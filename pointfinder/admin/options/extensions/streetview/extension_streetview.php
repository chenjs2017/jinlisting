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
     * @subpackage  Field_Color_Gradient
     * @author      Luciano "WebCaos" Ubertini
     * @author      Daniel J Griffiths (Ghost1227)
     * @author      Dovy Paukstys
     * @version     3.0.0
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

// Don't duplicate me!
    if ( ! class_exists( 'ReduxFramework_extension_streetview' ) ) {

        /**
         * Main ReduxFramework_link_color class
         *
         * @since       1.0.0
         */
        class ReduxFramework_extension_streetview {

            /**
             * Field Constructor.
             * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            function __construct( $field = array(), $value = '') {

                $this->field  = $field;
                $this->value  = $value;

                $defaults = array(
                    'heading' => 0,
                    'pitch'   => 0,
                    'zoom' => 0,
                );

                $this->value = wp_parse_args( $this->value, $defaults );

                /*
                    Array ( 
                    [id] => webbupointfinder_item_streetview 
                    [type] => extension_streetview 
                    [class] => 
                    [name] => pointfinderthemefmb_options[webbupointfinder_item_streetview] 
                    [name_suffix] => )
                */
            }

            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            public function render() {

                $pointfinder_center_lat = PFSAIssetControl('setup5_mapsettings_lat','','33.87212589943945');
                $pointfinder_center_lng = PFSAIssetControl('setup5_mapsettings_lng','','-118.19297790527344');
                $pointfinder_google_map_zoom = PFSAIssetControl('setup5_mapsettings_zoom','','6');

                $pfitemid = get_the_id();
                if (isset($pfitemid)) {
                    $pffmarkerget = esc_attr(get_post_meta( $pfitemid, 'webbupointfinder_items_location', true ));
                    if (!empty($pffmarkerget)) {
                         $pfcoordinates = explode( ',', $pffmarkerget);
                    }
                }

                if (isset($pfcoordinates[0])) {
                    if (empty($pfcoordinates[0])) {
                        $pfcoordinates = '';
                    }
                }
                if (!empty($pfcoordinates)) {
                    if (!is_array($pfcoordinates)) {
                        $pfcoordinates = array($pointfinder_center_lat,$pointfinder_center_lng,$pointfinder_google_map_zoom);
                    }else{
                        if (isset($pfcoordinates[2]) == false) {
                            $pfcoordinates[2] = $pointfinder_google_map_zoom;
                        }
                    }
                }else{
                    $pfcoordinates = array($pointfinder_center_lat,$pointfinder_center_lng,$pointfinder_google_map_zoom);
                }
               
                
                echo '<div id="pfitempagestreetviewMap" data-pfitemid="' . $this->field['id'] . '" data-pfcoordinateslat="'.$pfcoordinates[0].'" data-pfcoordinateslng="'.$pfcoordinates[1].'" data-pfzoom = "'.$pfcoordinates[2].'"></div>';
                echo '<input id="' . $this->field['id'] . '-heading" name="' . $this->field['name'] . '[heading]' . $this->field['name_suffix'] . '" value="' . $this->value['heading'] . '" type="hidden" />';
                echo '<input id="' . $this->field['id'] . '-pitch" name="' . $this->field['name'] . '[pitch]' . $this->field['name_suffix'] . '" value="' . $this->value['pitch'] . '" type="hidden" />';
                echo '<input id="' . $this->field['id'] . '-zoom" name="' . $this->field['name'] . '[zoom]' . $this->field['name_suffix'] . '" value="' . $this->value['zoom'] . '" type="hidden" />';

            }

            /**
             * Enqueue Function.
             * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            public function enqueue() {
                global $post_type;
                $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

                
                if ($setup3_pointposttype_pt1 == $post_type) {
                
                 wp_enqueue_script( 'admin-google-api', 'https://maps.google.com/maps/api/js', array(), '', true );
                 wp_enqueue_script( 
                    'admin-gmap3', 
                    get_template_directory_uri() . '/js/gmap3.js',
                    array( 'jquery', 'redux-js','admin-google-api' ),
                    time(),
                    true
                );

                 wp_enqueue_script(
                    'redux-field-streetview-js',
                    get_template_directory_uri().'/admin/options/extensions/streetview/field_streetview.js',
                    array( 'jquery', 'redux-js','admin-gmap3'),
                    time(),
                    true
                );
                 wp_localize_script( 'redux-field-streetview-js', 'theme_quickjs2', array( 
                  'msg' => esc_html__('Please select a point from location map','pointfindert2d')
                ));

                wp_enqueue_style(
                    'redux-field-streetview-css',
                    get_template_directory_uri().'/admin/options/extensions/streetview/field_streetview.css',
                    time(),
                    true
                );
               }
            }

        }
    }