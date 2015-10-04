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
        'display_name'         => 'Vehicle Booking System',
        'display_version'      => '1.0.0',
        'menu_type'            => 'submenu',
        'allow_sub_menu'       => false,
        'menu_title'           => __( 'VBS Options', 'vbs' ),
        'page_title'           => __( 'Vehicle Booking Options', 'vbs' ),
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
        'page_parent'          => 'vbs_admin_menu',
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
            'icon'          => 'fa fa-question',
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
        'icon'  => 'fa fa-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/intera_design',
        'title' => 'Follow us on Twitter',
        'icon'  => 'fa fa-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/companies/820832',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'fa fa-linkedin'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://github.com/gnikolopoulos',
        'title' => 'Find us on GitHub',
        'icon'  => 'fa fa-github'
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
        'title'      => __( 'General', 'vbs' ),
        'id'         => 'opt-general',
        'icon'       => 'fa fa-cogs',
        'fields'     => array(
            array(
                'id'       => 'base_location',
                'type'     => 'text',
                'title'    => __( 'Set your base location', 'vbs' ),
                'default'  => 'Pl. Sintagmatos, Athina 105 63, Greece',
            ),

            array(
                'id'       => 'currency_symbol',
                'type'     => 'text',
                'title'    => __( 'Set Currency symbol', 'vbs' ),
                'default'  => '€',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Styling', 'vbs' ),
        'id'         => 'opt-styling',
        'icon'       => 'fa fa-paint-brush',
        'fields'     => array(
            array(
                'id'       => 'form_style',
                'type'     => 'button_set',
                'title'    => __('Form Style', 'vbs'),
                'options'  => array(
                    'stacked'    => 'Stacked',
                    'horizontal' => 'Horizontal'
                ),
                'default' => 'stacked'
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'PayPal', 'vbs' ),
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
        'title'      => __( 'Email', 'vbs' ),
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
        'title'      => __( 'PHP Mailer', 'vbs' ),
        'desc'       => __( 'Only needed when you don\'t want to use wp_mail()', 'vbs' ),
        'id'         => 'opt-mailer',
        'icon'       => 'fa fa-paper-plane',
        'fields'     => array(
            array(
                'id'       => 'smtp_host',
                'type'     => 'text',
                'title'    => __( 'SMTP Host', 'vbs' ),
                'default'  => 'mail.example.com',
            ),

            array(
                'id'       => 'smtp_port',
                'type'     => 'text',
                'title'    => __( 'SMTP Port', 'vbs' ),
                'default'  => '25',
            ),

            array(
                'id'       => 'smtp_auth',
                'type'     => 'switch',
                'title'    => __('SMTP requires authentication?', 'vbs'),
                'default'  => true,
            ),

            array(
                'id'       => 'smtp_secure',
                'type'     => 'radio',
                'title'    => __('Use  SSL/TLS?', 'vbs'),
                'options'  => array(
                    'none' => 'None',
                    'ssl' => 'Use SSL',
                    'tls' => 'Use TLS'
                ),
                'default' => 'none'
            ),

            array(
                'id'       => 'smtp_login',
                'type'     => 'password',
                'username' => true,
                'title'    => 'SMTP Account',
                'placeholder' => array(
                    'username'   => 'SMTP username',
                    'password'   => 'SMTP Password'
                )
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Email Template', 'vbs' ),
        'id'         => 'opt-template',
        'icon'       => 'fa fa-columns',
        'fields'     => array(
            array(
                'id'       => 'email_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __('Logo image', 'vbs'),
                'subtitle'     => __('140x50px', 'vbs'),
                'default'  => array(
                    'url'=> PLUGIN_DIR_URL . 'templates/default/img/logo.jpg'
                ),
            ),

            array(
                'id'       => 'email_banner',
                'type'     => 'media',
                'url'      => true,
                'title'    => __('Heading image', 'vbs'),
                'subtitle'     => __('600x300px', 'vbs'),
                'default'  => array(
                    'url'=> PLUGIN_DIR_URL . 'templates/default/img/banner.jpg'
                ),
            ),

            array(
                'id'       => 'email_template',
                'type'     => 'text',
                'title'    => __('Folder name that contains the mail template', 'vbs'),
                'subtitle' => __('Must be under the /templates folder', 'vbs'),
                'default'  => 'default',
            ),

            array(
                'id'       => 'email_title',
                'type'     => 'text',
                'title'    => __('Email title/Subject', 'vbs'),
                'default'  => 'Your booking details',
            ),

            array(
                'id'       => 'email_heading',
                'type'     => 'text',
                'title'    => __('Header text for notification emails', 'vbs'),
                'default'  => 'Thank you for booking with us!',
            ),

            array(
                'id'       => 'email_intro',
                'type'     => 'textarea',
                'title'    => __('Email intro text', 'vbs'),
                'subtitle' => __('No HTML allowed', 'vbs'),
                'default'  => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
                'validate' => 'no_html'
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Social', 'vbs' ),
        'id'         => 'opt-social',
        'icon'       => 'fa fa-share-alt',
        'fields'     => array(
            array(
                'id'       => 'facebook_url',
                'type'     => 'text',
                'title'    => __( 'Your Facebook page/profile URL', 'vbs' ),
                'default'  => 'http://facebook.com',
                'validate' => 'url'
            ),

            array(
                'id'       => 'linkedin_url',
                'type'     => 'text',
                'title'    => __( 'Your LinkedIn profile URL', 'vbs' ),
                'default'  => 'http://linkedin.com',
                'validate' => 'url'
            ),

            array(
                'id'       => 'twitter_url',
                'type'     => 'text',
                'title'    => __( 'Your Twitter profile URL', 'vbs' ),
                'default'  => 'http://twitter.com',
                'validate' => 'url'
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */
