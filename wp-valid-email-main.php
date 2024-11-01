<?php
class MmVE_Valid_Email
{
    public static $instance;

    const VERSION = '1.0';

    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new MmVE_Valid_Email();
        return self::$instance;
    }

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
        add_action('wp_head', array($this, 'wp_head'));
        add_action('wp_footer', array($this, 'wp_footer'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
        add_action('login_enqueue_scripts', array($this, 'login_enqueue_scripts'));
        add_action('login_head', array($this, 'login_head'));

        //set option defaults
        $options = get_option('mmve_valid_email_options');
        if (!$options || $options['pluginVersion'] != self::VERSION)
        {
            $this->set_option_defaults($options);
        }
    }

    function set_option_defaults($options)
    {
        if (!$options)
        {
            $defaults = array(
                'pluginVersion' => self::VERSION,
                'emailSelector' => '#email',
                'loginSelector' => '#user_login',
                'checkLogin' => false,
                'css_display' => "block",
                'css_color' => 'red',
                'css_font_size' => '1em'
            );
            update_option('mmve_valid_email_options', $defaults);
        }
        else // version change
        {
            $options['pluginVersion'] = self::VERSION;
            if (!array_key_exists('emailSelector', $options)) $options['emailSelector'] = '#email';
            if (!array_key_exists('loginSelector', $options)) $options['loginSelector'] = '#user_login';
            if (!array_key_exists('checkLogin', $options)) $options['checkLogin'] = false;
            if (!array_key_exists('css_display', $options)) $options['css_display'] = 'block';
            if (!array_key_exists('css_color', $options)) $options['css_color'] = 'red';
            if (!array_key_exists('css_font_size', $options)) $options['css_font_size'] = '1em';

            update_option('mmve_valid_email_options', $options);
        }
    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        wp_register_script('mmve-valid-email-js', plugins_url('/js/mailcheck.min.js', __FILE__), array('jquery'), true);
        wp_enqueue_script('mmve-valid-email-js');
    }

    public function wp_head()
    {
        $options = get_option('mmve_valid_email_options');
        echo '<style type="text/css" media="screen">' .
            '.mmve-valid-email-msg { display: ' . $options['css_display'] . ';' .
            'color: ' . $options['css_color'] . ';' .
            'font-size: ' . $options['css_font_size'] . '; }' .
            '</style>';
    }

    public function wp_footer()
    {
        $options = get_option('mmve_valid_email_options');
        $this->selector = $options['emailSelector'];
        include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wp-valid-email-inline.php';
    }

    public function login_enqueue_scripts()
    {
        $this->wp_enqueue_scripts();
    }

    public function login_head()
    {
        $options = get_option('mmve_valid_email_options');
        if ($options['checkLogin'] == 1)
            $this->selector = $options['loginSelector'];
        else
            $this->selector = '';
        include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wp-valid-email-inline.php';
    }

    public function admin_menu()
    {
        add_options_page('Valid Email Settings', 'WP Valid Email', 'manage_options', 'mmve-valid-email-settings', array($this, 'admin_settings_page'));
    }

    public function admin_settings_page()
    {
        if (!current_user_can('manage_options'))
        {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wp-valid-email-settings.php';
    }

    public function plugin_action_links($links, $file)
    {
        if ($file == plugin_basename(__FILE__))
        {
            $settings_link = '<a href="' . menu_page_url('mmve-valid-email-settings', false) . '">' . esc_html(__('Settings', 'mmve-valid-email-settings')) . '</a>';
            array_unshift($links, $settings_link);
        }
        return $links;

    }

}

MmVE_Valid_Email::getInstance();