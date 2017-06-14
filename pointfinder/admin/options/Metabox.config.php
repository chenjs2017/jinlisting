<?php

if ( !function_exists( "pf_redux_add_metaboxes" ) ){
    function pf_redux_add_metaboxes($metaboxes) {
        global $pointfindertheme_option;
        $item_post_type_name = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
        $agents_post_type_name = PFSAIssetControl('setup3_pointposttype_pt8','','agents');
        $setup42_itempagedetails_configuration = (isset($pointfindertheme_option['setup42_itempagedetails_configuration']))? $pointfindertheme_option['setup42_itempagedetails_configuration'] : array();
        $setup42_itempagedetails_claim_status = (isset($pointfindertheme_option['setup42_itempagedetails_claim_status']))? $pointfindertheme_option['setup42_itempagedetails_claim_status'] : 0;

        $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
        
    /**
    *START:PAGE METABOXES
    **/
        


        $boxSections[] = array(
            'title' => 'Header Bar',
            'icon' => 'el-icon-cogs',
            'fields' => array(  
                array(
                    'id'       => 'webbupointfinder_page_titlebararea',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Header Bar Area', 'pointfindert2d' ),
                    'desc'    => esc_html__( 'If it is enabled, you can edit page header bar area by using below options.', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'pointfindert2d' ),
                        '0' => esc_html__( 'Disable', 'pointfindert2d' ),
                    ),
                    'default'  => 0
                ),

                array(
                    'id'       => 'webbupointfinder_page_defaultheaderbararea',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Default Header Bar', 'pointfindert2d' ),
                    'desc'    => esc_html__( 'If it is enabled, all variables will load from default header bar settings.', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'pointfindert2d' ),
                        '0' => esc_html__( 'Disable', 'pointfindert2d' ),
                    ),
                    'default'  => 0,
                    'required' => array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                ),
                array(
                    'id' => 'webbupointfinder_page_shadowopt',
                    'type' => 'button_set',
                    'title' => esc_html__('Header Bar Shadow', 'pointfindert2d') ,
                    'options' => array( 
                        0 => esc_html__('Disabled', 'pointfindert2d'),
                        1 => esc_html__('Shadow 1', 'pointfindert2d'),
                        2 => esc_html__('Shadow 2', 'pointfindert2d'),
                        ),
                    'default' => 0,
                    'required' => array(
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                    ),
                ) ,
                array(
                    'id'       => 'webbupointfinder_page_titlebarareatext',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Header Bar Options', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Show', 'pointfindert2d' ),
                        '0' => esc_html__( 'Hide', 'pointfindert2d' ),
                    ),
                    'default'  => 1,
                    'required' => array(
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                    ),
                ),
                array(
                    'id'       => 'webbupointfinder_page_titlebarareatext-start',
                    'type'     => 'section',
                    'indent'   => true,
                    'required' => array(
                        array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                        )
                ),

                    array(
                        'id'       => 'webbupointfinder_page_titlebarcustomtext_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Custom Text Color', 'pointfindert2d' ),
                        'validate' => 'color',
                        'transparent' => false,
                        'required' => array(
                            array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                            array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                            array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                            )

                    ),
                    array(
                        'id'       => 'webbupointfinder_page_titlebarcustomtext_bgcolor',
                        'type'     => 'color',
                        'transparent' => false,
                        'validate' => 'color',
                        'title'    => esc_html__( 'Custom Text Background Color', 'pointfindert2d' ),
                        'required' => array(
                            array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                            array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                            array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                            )

                    ),
                    array(
                        'id'            => 'webbupointfinder_page_titlebarcustomtext_bgcolorop',
                        'type'          => 'slider',
                        'title'         => esc_html__( 'Custom Text Background Color Opacity', 'pointfindert2d' ),
                        'default'       => 0,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text',
                        'required' => array(
                            array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                            array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                            array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                            )
                    ),

                    array(
                        'id'       => 'webbupointfinder_page_titlebarcustomtext',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Custom Text', 'pointfindert2d' ),
                        'required' => array(
                            array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                            array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                            array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                            )

                    ),

                    array(
                        'id'       => 'webbupointfinder_page_titlebarcustomsubtext',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Custom Sub Text', 'pointfindert2d' ),
                        'required' => array(
                            array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                            array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                            array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                            )

                    ),
                array(
                    'id'       => 'webbupointfinder_page_titlebarareatext-end',
                    'type'     => 'section',
                    'indent'   => false, 
                    'required' => array(
                        array( 'webbupointfinder_page_titlebarareatext', "=", 1 ),
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                        )
                ),
                array(
                    'id'            => 'webbupointfinder_page_titlebarcustomheight',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Custom Height(px)', 'pointfindert2d' ),
                    'default'       => 130,
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 500,
                    'display_value' => 'label',
                    'required' => array(
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                    ),
                ),

                array(
                    'id'       => 'webbupointfinder_page_titlebarcustombg',
                    'type'     => 'background',
                    'title'    => esc_html__( 'Custom Background Image', 'pointfindert2d' ),
                    'required' => array(
                        array( 'webbupointfinder_page_titlebararea', "=", 1 ),
                        array( 'webbupointfinder_page_defaultheaderbararea', "=", 0 )
                    ),
                ),
            )
        );

        
        $boxSections[] = array(
            'title' => 'Transparent Menu',
            'icon' => 'el-icon-cogs',
            'fields' => array(  
                array(
                    'id'       => 'webbupointfinder_page_transparent',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Transparent Header', 'pointfindert2d' ),
                    'desc'    => esc_html__( 'If it is enabled, menu bar will be transparent background.', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'pointfindert2d' ),
                        '0' => esc_html__( 'Disable', 'pointfindert2d' ),
                    ),
                    'default'  => 0
                ),
                array(
                    'id'       => 'webbupointfinder_page_logoadditional',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Show Additional Logo', 'pointfindert2d' ),
                    'desc'    => esc_html__( 'If it is enabled, system will use additional logo instead of default one.', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'pointfindert2d' ),
                        '0' => esc_html__( 'Disable', 'pointfindert2d' ),
                    ),
                    'default'  => 0,
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ),

                array(
                    'id' => 'webbupointfinder_page_menulinecolor',
                    'type' => 'color',
                    'mode' => 'background',
                    'transparent' => false,
                    'title' => esc_html__('Main Menu: Active Line Color', 'pointfindert2d') ,
                    'desc' => esc_html__('Colored line at bottom of the menu links.', 'pointfindert2d'),
                    'default' => '#a32222',
                    'validate' => 'color',
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ) ,
                array(
                    'id' => 'webbupointfinder_page_menucolor',
                    'type' => 'link_color',
                    'title' => esc_html__('Main Menu: Menu Link Color', 'pointfindert2d') ,
                    'active' => false,
                    'default' => array(
                        'regular' => '#444444',
                        'hover' => '#a32221'
                    ) ,
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ) ,
                array(
                    'id'       => 'webbupointfinder_page_menutextsize',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Main Menu: Bold Text', 'pointfindert2d' ),
                    'desc'    => esc_html__( 'If it is enabled, main menu text will be bolder', 'pointfindert2d' ),
                    'options'  => array(
                        '1' => esc_html__( 'Enable', 'pointfindert2d' ),
                        '0' => esc_html__( 'Disable', 'pointfindert2d' ),
                    ),
                    'default'  => 0,
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ),
                array(
                    'id'        => 'webbupointfinder_page_headerbarsettings_bgcolor',
                    'type'      => 'color_rgba',
                    'title'     => esc_html__('Menu Bar Background', 'pointfindert2d'),
                    'default'   => array('color' => '#000000', 'alpha' => '0.2'),
                    'mode'      => 'background',
                    'transparent' => true,
                    'validate'  => 'colorrgba',
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ),
                array(
                    'id'        => 'webbupointfinder_page_headerbarsettings_bgcolor2',
                    'type'      => 'color_rgba',
                    'title'     => esc_html__('Menu Bar Background', 'pointfindert2d'),
                    'subtitle'     => esc_html__('Sticky Menu', 'pointfindert2d'),
                    'default'   => array('color' => '#000000', 'alpha' => '0.7'),
                    'mode'      => 'background',
                    'transparent' => true,
                    'validate'  => 'colorrgba',
                    'required' => array( 'webbupointfinder_page_transparent', "=", 1 ),
                ),

            )
        );
        
        $boxSections[] = array(
            'title' => 'Footer Row',
            'icon' => 'el-icon-cogs',
            'fields' => array(  
                array(
                    'id' => 'webbupointfinder_gbf_status',
                    'type' => 'button_set',
                    'title' => esc_html__('Global Footer', 'pointfindert2d') ,
                    'options' => array(
                        '1' => esc_html__('Enable', 'pointfindert2d') ,
                        '0' => esc_html__('Disable', 'pointfindert2d'),
                    ) ,
                    'default' => 0,
                ),
                array(
                    'id' => 'webbupointfinder_gbf_cols',
                    'type' => 'button_set',
                    'title' => esc_html__('Column Number', 'pointfindert2d') ,
                    'options' => array(
                        '1' => esc_html__('1', 'pointfindert2d') ,
                        '2' => esc_html__('2', 'pointfindert2d'),
                        '3' => esc_html__('3', 'pointfindert2d'),
                        '4' => esc_html__('4', 'pointfindert2d'),
                    ) ,
                    'default' => 4,
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_sidebar1',
                    'type'     => 'select',
                    'title'    => esc_html__('1st Column Widget Area', 'pointfindert2d'),
                    'data'     => 'sidebars',
                    'default'  => '',
                    'required' => array(array( 'webbupointfinder_gbf_cols', '>=', 1 ),array('webbupointfinder_gbf_status','=',1))
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_sidebar2',
                    'type'     => 'select',
                    'title'    => esc_html__('2nd Column Widget Area', 'pointfindert2d'),
                    'data'     => 'sidebars',
                    'default'  => '',
                    'required' => array(array( 'webbupointfinder_gbf_cols', '>=', 2 ),array('webbupointfinder_gbf_status','=',1))
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_sidebar3',
                    'type'     => 'select',
                    'title'    => esc_html__('3rd Column Widget Area', 'pointfindert2d'),
                    'data'     => 'sidebars',
                    'default'  => '',
                    'required' => array(array( 'webbupointfinder_gbf_cols', '>=', 3 ),array('webbupointfinder_gbf_status','=',1))
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_sidebar4',
                    'type'     => 'select',
                    'title'    => esc_html__('4th Column Widget Area', 'pointfindert2d'),
                    'data'     => 'sidebars',
                    'default'  => '',
                    'required' => array(array( 'webbupointfinder_gbf_cols', '>=', 4 ),array('webbupointfinder_gbf_status','=',1))
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_bgopt2',
                    'type'     => 'background',
                    'output'   => array( '.wpf-footer-row-move.wpf-footer-row-movepg:before' ),
                    'title'    => esc_html__('Background (Before Row)', 'pointfindert2d'),
                    'default'   => '#FFFFFF',
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'             => 'webbupointfinder_gbf_bgopt2w',
                    'type'           => 'dimensions',
                    'units'          => array( 'em', 'px', '%' ),
                    'units_extended' => 'true',
                    'output'   => array( '.wpf-footer-row-move.wpf-footer-row-movepg:before' ),
                    'title'          => esc_html__('Background (Before Row) Height', 'pointfindert2d'),
                    'width'         => false,
                    'default'        => array(
                        'height' => 0,
                    ),
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'             => 'webbupointfinder_gbf_bgopt2m',
                    'type'           => 'spacing',
                    'mode'           => 'margin',
                    'output'   => array( '.wpf-footer-row-move.wpf-footer-row-movepg:before' ),
                    'all'            => false,
                    'left'            => false,
                    'right'            => false,
                    'units'          => array( 'em', 'px', '%' ),
                    'units_extended' => 'true',
                    'title'          => esc_html__( 'Margin (Before Row)', 'pointfindert2d' ),
                    'default'        => array(
                        'margin-top'    => '0',
                        'margin-bottom' => '0'
                    ),
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_bgopt',
                    'type'     => 'background',
                    'output'   => array( '.pointfinderexfooterclassxpg' ),
                    'title'    => esc_html__('Background', 'pointfindert2d'),
                    'default'   => '#FFFFFF',
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'        => 'webbupointfinder_gbf_textcolor1',
                    'type'      => 'color',
                    'output'   => array( '.pointfinderexfooterclasspg'),
                    'title'     => esc_html__('Text Color', 'pointfindert2d'),
                    'default' => '#000000',
                    'transparent'   => false,
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'        => 'webbupointfinder_gbf_textcolor2',
                    'type'      => 'link_color',
                    'output'   => array('.pointfinderexfooterclasspg a' ),
                    'title'     => esc_html__('Link Color', 'pointfindert2d'),
                    'active' => false,
                    'default' => array(
                        'regular' => '#000000',
                        'hover' => '#B32E2E'
                    ),
                    'transparent'   => false,
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'             => 'webbupointfinder_gbf_spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'output'   => array( '.pointfinderexfooterclasspg' ),
                    'all'            => false,
                    'left'            => false,
                    'right'            => false,
                    'units'          => array( 'em', 'px', '%' ),
                    'units_extended' => 'true',
                    'title'          => esc_html__( 'Padding', 'pointfindert2d' ),
                    'default'        => array(
                        'padding-top'    => '50px',
                        'padding-bottom' => '50px',
                    ),
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'             => 'webbupointfinder_gbf_spacing2',
                    'type'           => 'spacing',
                    'mode'           => 'margin',
                    'output'   => array( '.pointfinderexfooterclassxpg' ),
                    'all'            => false,
                    'left'            => false,
                    'right'            => false,
                    'units'          => array( 'em', 'px', '%' ),
                    'units_extended' => 'true',
                    'title'          => esc_html__( 'Margin', 'pointfindert2d' ),
                    'default'        => array(
                        'padding-top'    => '0',
                        'padding-bottom' => '0',
                    ),
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),
                array(
                    'id'       => 'webbupointfinder_gbf_border',
                    'type'     => 'border',
                    'title'    => esc_html__( 'Border', 'pointfindert2d' ),
                    'output'   => array( '.pointfinderexfooterclassxpg' ),
                    'all'      => false,
                    'left'            => false,
                    'right'            => false,
                    'default'  => array(
                        'border-color'  => 'transparent',
                        'border-style'  => 'solid',
                        'border-top'    => '0',
                        'border-bottom' => '0',
                    ),
                    'required' => array('webbupointfinder_gbf_status','=',1)
                ),

            )
        );

        $metaboxes = array();

        $metaboxes[] = array(
            'id' => 'pf_page_settings',
            'title' => esc_html__('Page Header Area Options','pointfindert2d'),
            'post_types' => array('page'),
            'position' => 'normal', // normal, advanced, side
            'priority' => 'default', // high, core, default, low
            'sidebar' => false, 
            'sections' => $boxSections
        );

        
        $page_options = array();
        $page_options[] = array(
            //'title'         => esc_html__('General Settings', 'pointfindert2d'),
            'icon_class'    => 'icon-large',
            'icon'          => 'el-icon-home',
            'fields'        => array(
                array(
                    'id' => 'webbupointfinder_page_sidebar',
                    'title' => esc_html__( 'Sidebar', 'pointfindert2d' ),
                    'desc' => esc_html__( 'Please select the sidebar you would like to display on this blog page (Only for blog pages.). Note: You must first create the sidebar under PF Options > Sidebar Generator.', 'pointfindert2d' ),
                    'type' => 'select',
                    'data' => 'sidebars',
                    'default' => 'None',
                ),
            ),
        );

        $metaboxes[] = array(
            'id'            => 'pf-page-options',
            'title'         => esc_html__( 'Blog Sidebar', 'pointfindert2d' ),
            'post_types'    => array( 'page' ),
            'position'      => 'side', 
            'priority'      => 'low', 
            'sidebar'       => true,
            'sections'      => $page_options,
        );
        

    /**
    *END:PAGE METABOXES
    **/ 
        







    /**
    *START:ITEM METABOXES
    **/ 


       


        /**
        *FEATURED POINT
        **/

            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_featuredmarker',
                        'type'     => 'button_set',
                        'title'    => '',
                        'default'  => '0',
                        'options'  => array(1=>esc_html__('Enable','pointfindert2d'),0=>esc_html__('Disable','pointfindert2d'))
                    ),
                )
            );

            $metaboxes[] = array(
                'id' => 'pf_item_featuredpoint',
                'title' => esc_html__('Featured Point(Optional)','pointfindert2d'),
                'post_types' => array($item_post_type_name),
                'position' => 'side', 
                'priority' => 'high', 
                'sections' => $boxSections
            );

            
            if ($setup42_itempagedetails_claim_status == 1) {
                $boxSections = array();
                $boxSections[] = array(
                    'fields' => array(  
                        array(
                            'id'       => 'webbupointfinder_item_verified',
                            'type'     => 'button_set',
                            'title'    => '',
                            'default'  => '0',
                            'options'  => array(1=>esc_html__('Enable','pointfindert2d'),0=>esc_html__('Disable','pointfindert2d'))
                        ),
                    )
                );

                $metaboxes[] = array(
                    'id' => 'pf_item_verifiedpoint',
                    'title' => esc_html__('Verified Point(Optional)','pointfindert2d'),
                    'post_types' => array($item_post_type_name),
                    'position' => 'side', 
                    'priority' => 'high', 
                    'sections' => $boxSections
                );
            }

            


        /**
        *FEATURED VIDEO
        **/
        $pf_vide_status = (isset($setup42_itempagedetails_configuration['video']['status']))?$setup42_itempagedetails_configuration['video']['status']:0;
        if( $pf_vide_status == 1){
            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_video',
                        'type'     => 'text',
                        'desc' => esc_html__( 'Please write video url.', 'pointfindert2d' ),
                        'class'  => 'pfwidthfix'
                    ),
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_item_featuredvideo',
                'title' => esc_html__('Featured Video','pointfindert2d'),
                'post_types' => array($item_post_type_name),
                'position' => 'side', 
                'priority' => 'low', 
                'sections' => $boxSections
            );
        }


        /**
        *SLIDER IMAGE
        **/

            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_sliderimage',
                        'type'     => 'media',
                        'desc' => esc_html__('Recommended size width: 2000px and height: 700 px. (Better for large screens.)','pointfindert2d'),
                    ),
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_item_sliderimage',
                'title' => esc_html__('Slider Image','pointfindert2d'),
                'post_types' => array($item_post_type_name),
                'position' => 'side', 
                'priority' => 'low', 
                'sections' => $boxSections
            );
        /**
        *SLIDER IMAGE
        **/


        /**
        *HEADER IMAGE
        **/

            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_headerimage',
                        'type'     => 'media',
                        'desc' => esc_html__('Recommended size width: 2000px and height: 485 px. (Better for large screens.)','pointfindert2d'),
                    ),
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_item_headerimage',
                'title' => esc_html__('Image for Header','pointfindert2d'),
                'post_types' => array($item_post_type_name),
                'position' => 'side', 
                'priority' => 'low', 
                'sections' => $boxSections
            );
        /**
        *HEADER IMAGE
        **/



       
        /**
        *POINT OPTIONS
        **/
            $boxSections = array();
            $boxSections[] = array(
                'title' => '',
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_point_type',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Point Type', 'pointfindert2d' ),
                        'desc'     => esc_html__( 'Please choose a point type for this item.', 'pointfindert2d' ),
                        'options'  => array(
                            '3' => esc_html__( 'None (Use Category)', 'pointfindert2d' ),
                            '1' => esc_html__( 'Custom Image', 'pointfindert2d' ),
                            '2' => esc_html__( 'Predefined Icon', 'pointfindert2d' )
                        ),
                        'default'  => '3',
                    ),
                    array(
                        'id'       => 'webbupointfinder_item_point_type-start',
                        'type'     => 'section',
                        'indent'   => true, 
                        'required' => array( 'webbupointfinder_item_point_type', "=", 1 ),
                    ),
                        array(
                            'id'       => 'webbupointfinder_item_custom_marker',
                            'type'     => 'media',
                            'title'    => esc_html__( 'Point Icon', 'pointfindert2d' ),
                            'desc'     => esc_html__( 'Upload custom point icon. Default icon size: 84x101 px', 'pointfindert2d' ),
                            'required' => array( 'webbupointfinder_item_point_type', "=", 1 ),
                        ),
                    array(
                        'id'       => 'webbupointfinder_item_point_type-end',
                        'type'     => 'section',
                        'indent'   => false, 
                        'required' => array( 'webbupointfinder_item_point_type', "=", 1 ),
                    ),


                    array(
                        'id'       => 'webbupointfinder_item_point_type2-start',
                        'type'     => 'section',
                        'indent'   => true, 
                        'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                    ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_icontype',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Point Icon Type', 'pointfindert2d' ),
                            'options'  => array(
                                '1' => esc_html__( 'Round', 'pointfindert2d' ),
                                '2' => esc_html__( 'Square', 'pointfindert2d' ),
                                '3' => esc_html__( 'Dot', 'pointfindert2d' ),
                            ),
                            'default' => 1,
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_iconsize',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Point Icon Type', 'pointfindert2d' ),
                            'options'  => array(
                                'small' => esc_html__( 'Small', 'pointfindert2d' ),
                                'middle' => esc_html__( 'Middle', 'pointfindert2d' ),
                                'large' => esc_html__( 'Large', 'pointfindert2d' ),
                                'xlarge' => esc_html__( 'X-Large', 'pointfindert2d' ),
                            ),
                            'default' => 'middle',
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_bgcolor',
                            'type'     => 'color',
                            'title'    => esc_html__( 'Point Color', 'pointfindert2d' ),
                            'validate'     => 'color',
                            'default' => '#b00000',
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_bgcolorinner',
                            'type'     => 'color',
                            'title'    => esc_html__( 'Point Inner Color', 'pointfindert2d' ),
                            'validate'     => 'color',
                            'default' => '#ffffff',
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_iconcolor',
                            'type'     => 'color',
                            'title'    => esc_html__( 'Point Icon Color', 'pointfindert2d' ),
                            'validate'     => 'color',
                            'default' => '#b00000',
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                        array(
                            'id'       => 'webbupointfinder_item_cssmarker_iconname',
                            'type'     => 'extension_custom_icon',
                            'title'    => esc_html__( 'Point Icon', 'pointfindert2d' ),
                            'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                        ),
                    array(
                        'id'       => 'webbupointfinder_item_point_type2-end',
                        'type'     => 'section',
                        'indent'   => false, 
                        'required' => array( 'webbupointfinder_item_point_type', "=", 2 ),
                    ),


                    array(
                        'id'       => 'webbupointfinder_item_point_visibility',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Point Visibilty', 'pointfindert2d' ),
                        'desc'     => esc_html__( 'Hide only this point on the map / listing / search results.', 'pointfindert2d' ),
                        'options'  => array(
                            '1' => esc_html__( 'Show', 'pointfindert2d' ),
                            '0' => esc_html__( 'Hide', 'pointfindert2d' ),
                        ),
                        'default'  => 1,
                    ),
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_item_settings',
                'title' => esc_html__('Point Options (Optional)','pointfindert2d'),
                'post_types' => array($item_post_type_name),
                'position' => 'side', // normal, advanced, side
                'priority' => 'low', // high, core, default, low
                'sections' => $boxSections
            );

        $setup3_pointposttype_pt9 = PFSAIssetControl('setup3_pointposttype_pt9','','PF Agent');
        $setup3_pointposttype_pt6_status = PFSAIssetControl('setup3_pointposttype_pt6_status','','1');
        if($setup3_pointposttype_pt6_status == 1){
        /**
        *AGENTS LIST
        **/

            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                        'id'       => 'webbupointfinder_item_agents',
                        'type'     => 'select',
                        'data'     => 'posts',
                        'args'     => array('post_type'=>$agents_post_type_name,'posts_per_page'=>-1),
                        'multi'    => false,
                        'desc'     => esc_html__( 'You can select an agent for this item.', 'pointfindert2d' ),
                    ),
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_item_agents',
                'title' => $setup3_pointposttype_pt9,
                'post_types' => array($item_post_type_name),
                'position' => 'side', 
                'priority' => 'low', 
                'sections' => $boxSections
            );
        }

        
        /**
        *STREETVIEW SELECTOR
        **/
            $pf_streetview_status = (isset($setup42_itempagedetails_configuration['streetview']['status']))?$setup42_itempagedetails_configuration['streetview']['status']:0;
            $setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
            $st4_sp_med = PFSAIssetControl('st4_sp_med','','1');
            if ($st4_sp_med == 1) {
                if( $pf_streetview_status == 1 && $setup3_pointposttype_pt5_check == 1){
                    $boxSections = array();
                    $boxSections[] = array(
                        'fields' => array(  
                            array(
                                'id'       => 'webbupointfinder_item_streetview',
                                'type'     => 'extension_streetview'
                            )
                        )
                    );

                    $metaboxes[] = array(
                        'id' => 'pf_item_streetview',
                        'title' => esc_html__('Streetview Configuration','pointfindert2d'),
                        'post_types' => array($item_post_type_name),
                        'position' => 'normal', 
                        'priority' => 'high', 
                        'sections' => $boxSections
                    );
                }
            }


        /**
        *CUSTOM TABS
        **/
        $setup42_itempagedetails_configuration = (isset($pointfindertheme_option['setup42_itempagedetails_configuration']))? $pointfindertheme_option['setup42_itempagedetails_configuration'] : array();
        
        /* Custom Tab 1*/
            if(array_key_exists('customtab1', $setup42_itempagedetails_configuration)){
                if ($setup42_itempagedetails_configuration['customtab1']['status'] == 1) {
                    $boxSections = array();
                
                    $boxSections[] = array(
                        'fields' => array(  
                            array(
                                'id'       => 'webbupointfinder_item_custombox1',
                                'type'     => 'editor'
                            )
                        )
                    );


                    $metaboxes[] = array(
                        'id' => 'pf_item_custombox1',
                        'title' => $setup42_itempagedetails_configuration['customtab1']['title'],
                        'post_types' => array($item_post_type_name),
                        'position' => 'normal', 
                        'priority' => 'default', 
                        'sections' => $boxSections
                    );
                }
            }
        /*Custom Tab 1*/


        /* Custom Tab 2*/
            if(array_key_exists('customtab2', $setup42_itempagedetails_configuration)){
                if ($setup42_itempagedetails_configuration['customtab2']['status'] == 1) {
                    $boxSections = array();
                
                    $boxSections[] = array(
                        'fields' => array(  
                            array(
                                'id'       => 'webbupointfinder_item_custombox2',
                                'type'     => 'editor'
                            )
                        )
                    );


                    $metaboxes[] = array(
                        'id' => 'pf_item_custombox2',
                        'title' => $setup42_itempagedetails_configuration['customtab2']['title'],
                        'post_types' => array($item_post_type_name),
                        'position' => 'normal', 
                        'priority' => 'default', 
                        'sections' => $boxSections
                    );
                }
            }
        /*Custom Tab 2*/


        /* Custom Tab 3*/
            if(array_key_exists('customtab3', $setup42_itempagedetails_configuration)){
                if ($setup42_itempagedetails_configuration['customtab3']['status'] == 1) {
                    $boxSections = array();
                
                    $boxSections[] = array(
                        'fields' => array(  
                            array(
                                'id'       => 'webbupointfinder_item_custombox3',
                                'type'     => 'editor'
                            )
                        )
                    );


                    $metaboxes[] = array(
                        'id' => 'pf_item_custombox3',
                        'title' => $setup42_itempagedetails_configuration['customtab3']['title'],
                        'post_types' => array($item_post_type_name),
                        'position' => 'normal', 
                        'priority' => 'default', 
                        'sections' => $boxSections
                    );
                }
            }
        /*Custom Tab 3*/

    /**
    *END:ITEM METABOXES
    **/








    /**
    *START:AGENTS METABOXES
    **/ 
        $boxSections = array();
        $boxSections[] = array(
            'fields' => array(  
             
                array(
                        'title'  => esc_html__( 'Email Address', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_email",
                        'desc'  => esc_html__( 'This email address will contact email for sending forms.', 'pointfindert2d' ),
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Web Address', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_web",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Mobile Number', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_mobile",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Office Number', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_tel",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Fax Number', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_fax",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Facebook', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_face",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Twitter', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_twitter",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'Google+', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_googlel",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                array(
                        'title'  => esc_html__( 'LinkedIn', 'pointfindert2d' ),
                        'id'    => "webbupointfinder_agent_linkedin",
                        'desc'  => '',
                        'type'  => 'text',
                    ),
                
            )
        );


        $metaboxes[] = array(
            'id' => 'pf_agents_general',
            'title' => esc_html__('Agent Information','pointfindert2d'),
            'post_types' => array($agents_post_type_name),
            'position' => 'normal', 
            'priority' => 'high', 
            'sections' => $boxSections
        );
       

    /**
    *END:AGENTS METABOXES
    **/

    if($setup4_membersettings_paymentsystem == 2){

        /**
        *START:MEMBERSHIP METABOXES
        **/ 
            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                            'title'  => esc_html__( 'Package Description', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_description",
                            'desc'  => '',
                            'type'  => 'textarea',
                            'validate' => 'no_html',
                            'default'  => esc_html__( 'No HTML is allowed in here.', 'pointfindert2d' )
                        ),
                    array(
                            'title'  => esc_html__( 'Billing Time Unit', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_billing_time_unit",
                            'desc'  => esc_html__( 'Billing time range unit.', 'pointfindert2d' ),
                            'type'  => 'button_set',
                            'options'  => array( 'yearly' => 'Yearly', 'monthly' => 'Monthly','daily' => 'Daily' ),
                        ),
                    array(
                            'title'  => esc_html__( 'Billing Period', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_billing_period",
                            'desc'  => esc_html__( 'Billing every x unit. IMPORTANT: Please enter max. 365 for day limit, max. 1 for year limit and max 12 for month limit. If you are using recurring payments. Because Paypal does not accept more than 1 year in the recurring payment option.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '1',
                            'step'    => '1',
                            'max'     => '99999',
                        ),
                    array(
                            'title'  => esc_html__( 'Trial Period Permission', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_trial",
                            'desc'  => esc_html__( 'You can use a trial period for this package. Important: You can not use trial period with free packages.', 'pointfindert2d' ),
                            'type'  => 'button_set',
                            'options'  => array( '1' => 'Yes', '0' => 'No'),
                        ),
                    array(
                            'title'  => esc_html__( 'Trial Period', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_trial_period",
                            'desc'  => esc_html__( 'Trial period for x unit.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'required' => array('webbupointfinder_mp_trial','=','1'),
                            'min'     => '1',
                            'step'    => '1',
                            'max'     => '99999',
                        ),
                    array(
                            'title'  => esc_html__( 'How many items are included?', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_itemnumber",
                            'desc'  => esc_html__( 'Type -1 for unlimited items.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '-1',
                            'step'    => '1',
                            'max'     => '9999',
                        ),
                    array(
                            'title'  => esc_html__( 'How many featured item are included?', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_fitemnumber",
                            'desc'  => esc_html__( 'Type 0 for does not permit featured items', 'pointfindert2d' ),
                            'type'  => 'spinner',

                            'min'     => '0',
                            'step'    => '1',
                            'max'     => '9999',
                        ),
                    array(
                            'title'  => esc_html__( 'How many images can upload?', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_images",
                            'desc'  => esc_html__( 'This limit for images per item.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '1',
                            'step'    => '1',
                            'max'     => '9999',
                        ),
                    array(
                            'title'  => esc_html__( 'Price of Package', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_price",
                            'desc'  => esc_html__( 'Write 0 for free.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '0',
                            'step'    => '1',
                            'max'     => '999999999',
                        ),
                    array(
                            'title'  => esc_html__( 'Frontend Visibility', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_mp_showhide",
                            'desc'  => esc_html__( 'If you hide this package, you will not see in frontend site.', 'pointfindert2d' ),
                            'type'  => 'button_set',
                            'options'  => array( '1' => 'Show', '2' => 'Hide')
                        )
                    
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_membership_general',
                'title' => esc_html__('Membership Package Details','pointfindert2d'),
                'post_types' => array('pfmembershippacks'),
                'position' => 'normal', 
                'priority' => 'high', 
                'sections' => $boxSections
            );
           

        /**
        *END:MEMBERSHIP METABOXES
        **/
    }else{
        /**
        *START:PPP METABOXES
        **/ 
            $boxSections = array();
            $boxSections[] = array(
                'fields' => array(  
                    array(
                            'title'  => esc_html__( 'Billing Period', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_lp_billing_period",
                            'desc'  => __( 'Billing for every x days. <br><strong>IMPORTANT:</strong> Recurring payments not support more than 365 days.', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '1',
                            'step'    => '1',
                            'max'     => '999999999',
                        ),
                    array(
                            'title'  => esc_html__( 'Price of Package', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_lp_price",
                            'desc'  => __( 'Write 0 for free.<br/>Note: For price currency settings - Options Panel > Frontend Upload System > Paypal Settings', 'pointfindert2d' ),
                            'type'  => 'spinner',
                            'min'     => '0',
                            'step'    => '1',
                            'max'     => '999999999',
                        ),
                    array(
                            'title'  => esc_html__( 'Frontend Visibility', 'pointfindert2d' ),
                            'id'    => "webbupointfinder_lp_showhide",
                            'desc'  => esc_html__( 'If you hide this package, you will not see in frontend site.', 'pointfindert2d' ),
                            'type'  => 'button_set',
                            'options'  => array( '1' => 'Show', '2' => 'Hide')
                        )
                )
            );


            $metaboxes[] = array(
                'id' => 'pf_ppp_general',
                'title' => esc_html__('Listing Package Details','pointfindert2d'),
                'post_types' => array('pflistingpacks'),
                'position' => 'normal', 
                'priority' => 'high', 
                'sections' => $boxSections
            );
        /**
        *END:PPP METABOXES
        **/
    }


    return $metaboxes;
  }
    add_action("redux/metaboxes/pointfinderthemefmb_options/boxes", "pf_redux_add_metaboxes");
};

require_once(dirname(__FILE__).'/loader.php');