<?php

    /*
     * @package     Redux_Framework
     * @subpackage  Fields
     * @access      public
     * @global      $optname
     * @internal    Internal Note string
     * @link        http://reduxframework.com
     * @method      Test
     * @name        $globalvariablename
     * @param       string  $this->field['test']    This is cool.
     * @param       string|boolean  $field[default] Default value for this field.
     * @return      Test
     * @see         ParentClass
     * @since       Redux 3.0.9
     * @todo        Still need to fix this!
     * @var         string cool
     * @var         int notcool
     * @param       string[] $options {
     * @type        boolean $required Whether this element is required
     * @type        string  $label    The display name for this element
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'ReduxFramework_extension_custom_icon' ) ) {
        class ReduxFramework_extension_custom_icon {

            /**
             * Field Constructor.
             *
             * @param       $value  Constructed by Redux class. Based on the passing in $field['defaults'] value and what is stored in the database.
             * @param       $parent ReduxFramework object is passed for easier pointing.
             *
             * @since ReduxFramework 1.0.0
             * @type string $field  [test] Description. Default <value>. Accepts <value>, <value>.
             */
            function __construct( $field = array(), $value = '') {
                $this->field  = $field;
                $this->value  = $value;
            }


            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since ReduxFramework 1.0.0
             *
             * @param array $arr (See above)
             *
             * @return Object A new editor object.
             **/
            function render() {

                $pf_icons_arr = array(
                    array('icon' => '2440'),
                    array('icon' => '2442'),
                    array('icon' => 'accesibility'),
                    array('icon' => 'air6'),
                    array('icon' => 'air7'),
                    array('icon' => 'airplane67'),
                    array('icon' => 'airplane68'),
                    array('icon' => 'airplane73'),
                    array('icon' => 'alto'),
                    array('icon' => 'android2'),
                    array('icon' => 'angry19'),
                    array('icon' => 'antique9'),
                    array('icon' => 'ascendant6'),
                    array('icon' => 'baby137'),
                    array('icon' => 'bag30'),
                    array('icon' => 'baggage1'),
                    array('icon' => 'basketball35'),
                    array('icon' => 'beach3'),
                    array('icon' => 'biceps'),
                    array('icon' => 'bicycle14'),
                    array('icon' => 'black96'),
                    array('icon' => 'books8'),
                    array('icon' => 'bridge3'),
                    array('icon' => 'building22'),
                    array('icon' => 'building7'),
                    array('icon' => 'buildings5'),
                    array('icon' => 'burger4'),
                    array('icon' => 'bus3'),
                    array('icon' => 'bus8'),
                    array('icon' => 'business60'),
                    array('icon' => 'businessman125'),
                    array('icon' => 'call37'),
                    array('icon' => 'car106'),
                    array('icon' => 'car7'),
                    array('icon' => 'car80'),
                    array('icon' => 'car97'),
                    array('icon' => 'cash9'),
                    array('icon' => 'cctv3'),
                    array('icon' => 'checkered7'),
                    array('icon' => 'checkin'),
                    array('icon' => 'chronometer19'),
                    array('icon' => 'circular3'),
                    array('icon' => 'city8'),
                    array('icon' => 'claw1'),
                    array('icon' => 'climbing6'),
                    array('icon' => 'clock100'),
                    array('icon' => 'coconut5'),
                    array('icon' => 'coconut8'),
                    array('icon' => 'coffee50'),
                    array('icon' => 'coin12'),
                    array('icon' => 'coins15'),
                    array('icon' => 'comments16'),
                    array('icon' => 'concrete'),
                    array('icon' => 'construction16'),
                    array('icon' => 'constructor4'),
                    array('icon' => 'covered16'),
                    array('icon' => 'crane1'),
                    array('icon' => 'credit101'),
                    array('icon' => 'credit50'),
                    array('icon' => 'credit51'),
                    array('icon' => 'credit55'),
                    array('icon' => 'credit99'),
                    array('icon' => 'crime1'),
                    array('icon' => 'crowd'),
                    array('icon' => 'cruise7'),
                    array('icon' => 'crying6'),
                    array('icon' => 'cupcake3'),
                    array('icon' => 'deer2'),
                    array('icon' => 'delivery20'),
                    array('icon' => 'delivery25'),
                    array('icon' => 'delivery36'),
                    array('icon' => 'diamond10'),
                    array('icon' => 'dj4'),
                    array('icon' => 'dollar103'),
                    array('icon' => 'dwelling1'),
                    array('icon' => 'earth53'),
                    array('icon' => 'ecg2'),
                    array('icon' => 'ecological19'),
                    array('icon' => 'end3'),
                    array('icon' => 'escalator5'),
                    array('icon' => 'facebook7'),
                    array('icon' => 'family'),
                    array('icon' => 'favorite11'),
                    array('icon' => 'favourites7'),
                    array('icon' => 'film40'),
                    array('icon' => 'film63'),
                    array('icon' => 'finish'),
                    array('icon' => 'fire34'),
                    array('icon' => 'first21'),
                    array('icon' => 'first32'),
                    array('icon' => 'fish9'),
                    array('icon' => 'fishing11'),
                    array('icon' => 'floating1'),
                    array('icon' => 'for4'),
                    array('icon' => 'for5'),
                    array('icon' => 'glasses23'),
                    array('icon' => 'golf16'),
                    array('icon' => 'graduate20'),
                    array('icon' => 'graduation20'),
                    array('icon' => 'guru'),
                    array('icon' => 'hamburger2'),
                    array('icon' => 'hanger'),
                    array('icon' => 'happy35'),
                    array('icon' => 'hazard1'),
                    array('icon' => 'health3'),
                    array('icon' => 'heart118'),
                    array('icon' => 'heart258'),
                    array('icon' => 'heart288'),
                    array('icon' => 'helicopter'),
                    array('icon' => 'home120'),
                    array('icon' => 'home121'),
                    array('icon' => 'home87'),
                    array('icon' => 'hospital15'),
                    array('icon' => 'hot33'),
                    array('icon' => 'hot51'),
                    array('icon' => 'hot6'),
                    array('icon' => 'hotel68'),
                    array('icon' => 'house114'),
                    array('icon' => 'house118'),
                    array('icon' => 'ice64'),
                    array('icon' => 'images'),
                    array('icon' => 'industry2'),
                    array('icon' => 'insurance1'),
                    array('icon' => 'insurance2'),
                    array('icon' => 'insurance3'),
                    array('icon' => 'italian1'),
                    array('icon' => 'jacket2'),
                    array('icon' => 'job9'),
                    array('icon' => 'jumping27'),
                    array('icon' => 'key162'),
                    array('icon' => 'laptop112'),
                    array('icon' => 'left219'),
                    array('icon' => 'light84'),
                    array('icon' => 'linkedin11'),
                    array('icon' => 'logistics3'),
                    array('icon' => 'lorry1'),
                    array('icon' => 'macos'),
                    array('icon' => 'man362'),
                    array('icon' => 'mechanic3'),
                    array('icon' => 'medical14'),
                    array('icon' => 'medical51'),
                    array('icon' => 'medical68'),
                    array('icon' => 'medicine2'),
                    array('icon' => 'money132'),
                    array('icon' => 'money33'),
                    array('icon' => 'mountain24'),
                    array('icon' => 'multiple25'),
                    array('icon' => 'music200'),
                    array('icon' => 'new105'),
                    array('icon' => 'notes24'),
                    array('icon' => 'nurse6'),
                    array('icon' => 'nurse7'),
                    array('icon' => 'objective'),
                    array('icon' => 'offices'),
                    array('icon' => 'padding'),
                    array('icon' => 'painter14'),
                    array('icon' => 'palm9'),
                    array('icon' => 'parking15'),
                    array('icon' => 'party1'),
                    array('icon' => 'percentage6'),
                    array('icon' => 'person1'),
                    array('icon' => 'personal'),
                    array('icon' => 'pet32'),
                    array('icon' => 'photo147'),
                    array('icon' => 'pilot1'),
                    array('icon' => 'plate1'),
                    array('icon' => 'plate17'),
                    array('icon' => 'poison2'),
                    array('icon' => 'protection3'),
                    array('icon' => 'railway'),
                    array('icon' => 'real5'),
                    array('icon' => 'real6'),
                    array('icon' => 'real9'),
                    array('icon' => 'recycle58'),
                    array('icon' => 'regular2'),
                    array('icon' => 'rentacar'),
                    array('icon' => 'rentacar1'),
                    array('icon' => 'restaurant44'),
                    array('icon' => 'resting5'),
                    array('icon' => 'rose11'),
                    array('icon' => 'round58'),
                    array('icon' => 'round59'),
                    array('icon' => 'rugby98'),
                    array('icon' => 'runer'),
                    array('icon' => 'runner5'),
                    array('icon' => 'running30'),
                    array('icon' => 'running31'),
                    array('icon' => 'sad30'),
                    array('icon' => 'sale13'),
                    array('icon' => 'scissors28'),
                    array('icon' => 'sea9'),
                    array('icon' => 'semaphore7'),
                    array('icon' => 'setting'),
                    array('icon' => 'settings48'),
                    array('icon' => 'shopping101'),
                    array('icon' => 'shopping11'),
                    array('icon' => 'shopping236'),
                    array('icon' => 'skidiving'),
                    array('icon' => 'skiing7'),
                    array('icon' => 'skydiving2'),
                    array('icon' => 'slr2'),
                    array('icon' => 'smart'),
                    array('icon' => 'smartphone13'),
                    array('icon' => 'smiling30'),
                    array('icon' => 'smoking5'),
                    array('icon' => 'soccer38'),
                    array('icon' => 'soccer43'),
                    array('icon' => 'soccer44'),
                    array('icon' => 'social71'),
                    array('icon' => 'sold1'),
                    array('icon' => 'stack21'),
                    array('icon' => 'standing75'),
                    array('icon' => 'standing92'),
                    array('icon' => 'stethoscope1'),
                    array('icon' => 'store5'),
                    array('icon' => 'students17'),
                    array('icon' => 'stylish2'),
                    array('icon' => 'sunbathing'),
                    array('icon' => 'surprised14'),
                    array('icon' => 'surveillance11'),
                    array('icon' => 'sweet9'),
                    array('icon' => 'swimming20'),
                    array('icon' => 'swimming22'),
                    array('icon' => 'target'),
                    array('icon' => 'taxi13'),
                    array('icon' => 'taxi17'),
                    array('icon' => 'teeth1'),
                    array('icon' => 'teeth2'),
                    array('icon' => 'telephone91'),
                    array('icon' => 'television4'),
                    array('icon' => 'theater3'),
                    array('icon' => 'thumb38'),
                    array('icon' => 'tools6'),
                    array('icon' => 'tractor3'),
                    array('icon' => 'train1'),
                    array('icon' => 'tree101'),
                    array('icon' => 'tree30'),
                    array('icon' => 'trophy45'),
                    array('icon' => 'truck'),
                    array('icon' => 'truck30'),
                    array('icon' => 'tshirt18'),
                    array('icon' => 'tsunami1'),
                    array('icon' => 'two119'),
                    array('icon' => 'university2'),
                    array('icon' => 'use'),
                    array('icon' => 'volume32'),
                    array('icon' => 'walking17'),
                    array('icon' => 'weightlift'),
                    array('icon' => 'wine57'),
                    array('icon' => 'woman93'),
                    array('icon' => 'worker8'),
                    array('icon' => 'worker9'),
                    array('icon' => 'wrench60'),
                    array('icon' => 'yin6'),
                    array('icon' => 'yoga12')

                );

                   $output ='<div class="pfextendvc_select1" id="'.$this->field['id'].'-main">';
                   $output .= '<ul>';
                   if(is_array($pf_icons_arr)){
                       foreach ( $pf_icons_arr as $iconclass ) {
                            $output .= '<li class="flaticon-'.$iconclass['icon'].'""></li>';
                       }
                   }
                   $output .='</ul>
                    <input type="hidden" class="'.$this->field['class'].'" id="'.$this->field['id'].'-textarea" name="'.$this->field['name'] . $this->field['name_suffix'].''.'" value="'.$this->value.'">
                    <script type="text/javascript">
                    (function ($) {
                      "use strict"

                   
                      $(function () {
                      
                        ';
                        if($this->value!= ''){
                        $output .= '
                            $("#'.$this->field['id'].'-main ul li").each(function(){
                                if($(this).attr("class") == "'.$this->value.'"){
                                    $(this).attr("data-pfa-status","active")
                                }
                            });
                        ';
                        }
                        $output.='
                        $("#'.$this->field['id'].'-main ul li").click(function(){
                            $("#'.$this->field['id'].'-main ul li").each(function(){
                                $(this).attr("data-pfa-status","")
                            });
                            $(this).attr("data-pfa-status","active")
                            $("#'.$this->field['id'].'-textarea").val($(this).attr("class"));
                        });
                        
                    });
                    
                    })(jQuery);</script>
                    </div>';

                    echo $output;

                
            }


            public function enqueue() {
                wp_register_style('extension_flaticons', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0', 'all');
                wp_enqueue_style( 'extension_flaticons' );

                wp_enqueue_style('extension_custom_icon',get_template_directory_uri().'/admin/options/extensions/custom_icon/extension_custom_icon.css',time(),true);
            }
         

        }
    }