<?php

    $hidden_field_name = 'mmve_submit_hidden';

    $options = get_option('mmve_valid_email_options');

    if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y')
    {
        $options['emailSelector'] = $_POST['emailSelector'];
        $options['loginSelector'] = $_POST['loginSelector'];
        $options['checkLogin'] = isset($_POST['checkLogin']) && $_POST['checkLogin']  ? '1' : '0';
        $options['css_display'] = $_POST['css_display'];
        $options['css_color'] = $_POST['css_color'];
        $options['css_font_size'] = $_POST['css_font_size'];

        update_option('mmve_valid_email_options', $options);

?>

    <div class="updated"><p><strong><?php _e('Settings saved', 'wp-valid-email'); ?></strong></p></div>
<?php

    }

    echo '<div class="wrap">';
    echo "<h2>" . __('WP Valid Email Settings', 'wp-valid-email') . "</h2>";

 ?>

    <form name="wp-valid-email-settings-form" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
        <p><?php _e("Email Input Selector: ", 'wp-valid-email'); ?>
            <input type="text" name="emailSelector" value="<?php echo $options['emailSelector']; ?>" size="20">
        </p>
        <p><?php _e("Enable on user login? ", 'wp-valid-email'); ?>
            <input type="checkbox" name="checkLogin" value="1" <?php echo ($options['checkLogin'] == '1') ? 'checked' : '' ?>>
        </p>
        <p><?php _e("User Login Input Selector: ", 'wp-valid-email'); ?>
            <input type="text" name="loginSelector" value="<?php echo $options['loginSelector']; ?>" size="20">
        </p>
        <p><?php _e("CSS display value: ", 'wp-valid-email'); ?>
            <input type="text" name="css_display" value="<?php echo $options['css_display']; ?>" size="20">
        </p>
        <p><?php _e("CSS color value: ", 'wp-valid-email'); ?>
            <input type="text" name="css_color" value="<?php echo $options['css_color']; ?>" size="20">
        </p>
        <p><?php _e("CSS font-size value:  ", 'wp-valid-email'); ?>
            <input type="text" name="css_font_size" value="<?php echo $options['css_font_size']; ?>" size="20">
        </p>
        <hr/>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>"/>
        </p>
    </form>
    <hr/>
    <h2><?php echo __('Help', 'wp-valid-email'); ?></h2>
    <p><strong>Email Input Selector: </strong> This is selector used to determine which input field on your form(s) is the email address input.  It can be any jQuery selector and the default is set to work on all inputs with the ID "email".
    You may wish to enable valid email checking on all inputs with the class="valid_email".  In this case, you would just change this setting to ".valid_email".  <a href="http://api.jquery.com/category/selectors/">Learn more about jQuery selectors here</a>.</p>
    <p><strong>Enable on user login? </strong> You can turn on/off the checking of valid emails on your Wordpress login form (wp-login.php) here.  Some Wordpress websites use email addresses to login and enabling this option would check those addresses for typos.</p>
    <p><strong>User Login Input Selector: </strong> The same as the Email Input Selector, this option will identify the form input to check for a valid email address on the Wordpress login form.  The default is set to the input with the ID "user_login" which is the default username/email input ID on wp-login.php.</p>
 </div>
