<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "booking";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => 'Vehicle Booking Plugin Settings',
        'display_version'      => '1.0.0',
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => __( 'Booking Options', 'vbs' ),
        'page_title'           => __( 'Booking Options', 'vbs' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => true,
        'admin_bar'            => false,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => false,
        'customizer'           => false,

        'page_priority'        => null,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '',
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => '_options',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => true,

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,

        'database'             => '',
        'use_cdn'              => false,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    $args['share_icons'][] = array(
        'url'   => 'http://www.facebook.com/interactivedes',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/intera_design',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/companies/820832',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    // Add content after the form.
    $args['footer_text'] = __( '<p>Development by <a href="http://interactive-design.gr" target="_blank" >Interactive Design | creative studio</a></p>', 'vbs' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Basic Settings', 'vbs' ),
        'desc'       => __( 'General settings', 'vbs' ),
        'id'         => 'opt-general',
        'icon'       => 'fa fa-cogs',
        'fields'     => array(
            array(
                'id'       => 'base_location',
                'type'     => 'text',
                'title'    => __( 'Set your base location', 'vbs' ),
                'default'  => 'Pl. Sintagmatos, Athina 105 63, Greece',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'PayPal Settings', 'vbs' ),
        'desc'       => __( 'PayPal Setting', 'vbs' ),
        'id'         => 'opt-paypal',
        'icon'       => 'fa fa-paypal',
        'fields'     => array(
            array(
                'id'       => 'paypal_email',
                'type'     => 'text',
                'title'    => __( 'PayPal email', 'vbs' ),
                'default'  => 'example@example.com',
                'validate' => 'email'
            ),

            array(
                'id'       => 'paypal_mode',
                'type'     => 'switch',
                'title'    => __('Sandbox mode', 'vbs'),
                'subtitle' => __('Enable PayPal Sandbox mode', 'vbs'),
                'default'  => true,
            ),

            array(
                'id'       => 'business_name',
                'type'     => 'text',
                'title'    => __( 'Will appear on the PayPal form', 'vbs' ),
                'default'  => 'Your Company LLC.',
            ),

            array(
                'id'       => 'currency_code',
                'type'     => 'text',
                'title'    => __( 'Currency', 'vbs' ),
                'default'  => 'USD',
            ),

            array(
                'id'       => 'return_page',
                'type'     => 'select',
                'title'    => __( 'Page to return to after transaction', 'vbs' ),
                'data'     => 'pages',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Email Settings', 'vbs' ),
        'desc'       => __( 'Email addresses, reply-to, notifications', 'vbs' ),
        'id'         => 'opt-email',
        'icon'       => 'fa fa-envelope',
        'fields'     => array(
            array(
                'id'       => 'default_email',
                'type'     => 'text',
                'title'    => __( 'Email to be used as the From: field', 'vbs' ),
                'default'  => 'example@example.com',
                'validate' => 'email'
            ),

            array(
                'id'       => 'email_mode',
                'type'     => 'switch',
                'title'    => __('Use PHP mailer?', 'vbs'),
                'subtitle' => __('Use PHP Mailer instead of wp_mail()', 'vbs'),
                'default'  => true,
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'PHP Mailer Settings', 'vbs' ),
        'desc'       => __( 'Only needed when you don\'t want to use wp_mail()', 'vbs' ),
        'id'         => 'opt-mailer',
        'icon'       => 'fa fa-envelope-o',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'default_email',
                'type'     => 'text',
                'title'    => __( 'Email to be used as the From: field', 'vbs' ),
                'default'  => 'example@example.com',
                'validate' => 'email'
            ),

            array(
                'id'       => 'email_mode',
                'type'     => 'switch',
                'title'    => __('Use PHP mailer?', 'vbs'),
                'subtitle' => __('Use PHP Mailer instead of wp_mail()', 'vbs'),
                'default'  => true,
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */
