<?php
/*
 * Function to add things to the dashboard.
*/
function lbakgc_dashboard_setup() {

}

/*
 * Adding the settings menu to the admin page.
*/
function lbakgc_admin_menu() {
    $page = add_submenu_page('tools.php', 'LBAK Google Checkout Options',
            'Google Checkout', 'manage_options', 'lbakgc', 'lbakgc_menu_options');
    add_action('admin_print_scripts-' . $page, 'lbakgc_add_scripts');
}

function lbakgc_add_scripts() {
    wp_enqueue_script('lbakgc_admin_script', lbakgc_get_base_url().'/js/admin_page.js');
}

/*
 * Function that executes when the user clicks on the admin menu link. Put all
 * settings and such in here.
*/
function lbakgc_menu_options() {
    //Check that the user is able to view this page.
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have sufficient permissions to access this page.', 'lbakgc') );
    }

    //Declare global variables.
    global $wpdb;

    //Get lbakgc options.
    $options = lbakgc_get_options();

    ?>

<div class="wrap">
    <h2>LBAK Google Checkout</h2>
    <div id="navigation">
        <a class="button-secondary" href="?page=lbakgc">Settings</a>
        <a class="button-secondary" href="?page=lbakgc&step=addproducts">Add Products</a>
        <a class="button-secondary" href="?page=lbakgc&step=viewproducts">View Products</a>
        <a class="button-secondary" href="?page=lbakgc&step=help">Help/FAQ</a>
        <a class="button-secondary" href="http://donate.lbak.co.uk/" target="_blank">Donate <3</a>
    </div>
    <br />
        <?php
        switch ($_GET['step']) {
            case 'help':
                ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable">
        <div class="postbox" id="top">
            <h3><?php _e('I\'m stuck and I need help!', 'lbakgc'); ?></h3>
            <div class="inside">
                <?php _e('The following page is designed to answer any and all
                    queries you might have about the LBAK Google Checkout plugin.
                    Click on any of the topics below to begin:
                    <br /><br />
                    <a href="#setup">How do I set up the plugin?</a><br /><br />
                    <a href="#sandbox">What does Sandbox Mode mean?</a><br /><br />
                    <a href="#mid">How do I find my Merchant ID?</a><br /><br />
                    <a href="#currency">What currency should I use?</a><br /><br />
                    <a href="#addproduct">How do I add a product to my blog?</a><br /><br />
                    <a href="#shortcode">What is a shortcode and how do I use one?</a><br /><br />
                    <a href="#help">I\'m still confused :(</a><br /><br />
                    <br /><br /><br />
                    <div id="setup">
                    <b>How do I set up the plugin?</b>
                    <br /><br />
                    The first thing you need to use this plugin is a Google Checkout
                    account. Head on over to <a href="http://checkout.google.com">Google Checkout</a>
                    and sign in with your Google Account. Once you have an account you need
                    to set up your bank account and verify it (bank account verification
                    can take a few days so don\'t worry if it doesn\'t happen instantly).<br /><br />
                    Next, you should set up your tax settings. This is done in your Google Checkout
                    account under the Preferences in the Settings tab. This plugin does not define
                    any taxing rules so this makes it your sole responsibility to ensure you are
                    taxing your customers correctly.<br /><br />
                    Next you will want to look into setting up shipping. You can do this
                    either in your Google Checkout account or on each individual item in
                    the plugin. If you are going to do this via your Google Checkout account,
                    you will want to go to Settings > Shipping Setup and follow the
                    instructions there.
                    <br /><br />
                    Lastly, you need to enter your merchant ID. The plugin will not
                    function at all without your merchant ID. This can be found either in
                    the top right hand corner of the screen when you are logged in
                    to your Google Checkout account or under Profile in the Settings tab.
                    If you are wanting to use Sandbox Mode to test out your system please
                    note that your sandbox merchant ID will be different and there is
                    a box in this plugin\'s settings page where you can specify this.
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="sandbox">
                    <b>What does Sandbox Mode mean?</b>
                    <br /><br />
                    Sandbox Mode is something offered by Google to let you test
                    your Google Checkout system without accidentally processing any
                    orders. You can read more on it <a href="https://checkout.google.com/support/sell/bin/answer.py?hl=en-uk&answer=134469" target="_blank">here</a>.
                    <br /><br />
                    (In the "Moving to Production" section of that link, don\'t worry
                    about the steps they specify. All of that is handled by the plugin
                    provided you have entered the correct merchant ID)
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="mid">
                    <b>How do I find my Merchant ID?</b>
                    <br /><br />
                    Your Merchant ID can be found either in the top right hand
                    side of your screen when you are logged into your Google
                    Checkout account or under "Profile" in the Settings tab of
                    your Google Checkout account. It will be a long (~15 digits)
                    number.
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="currency">
                    <b>What currency should I use?</b>
                    <br /><br />
                    I believe that Google Checkout only currently supports the
                    UK and the US. I could be wrong. For now it is advised you use
                    GBP if you are in the UK and USD if you are in the US. If you
                    have any further info on this I\'d be glad to hear about it,
                    my email is samwho@lbak.co.uk
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="addproduct">
                    <b>How do I add a product to my blog?</b>
                    <br /><br />
                    To add a product to your database and then your blog there are
                    a few easy steps:
                    <br /><br />
                    1. Click on "Add Products" at the top of this screen and fill out the
                    form.
                    <br />
                    2. When you have filled the form out and clicked "Add", click on
                    "View Products" at the top of this page, find the product you
                    just added and click "Get Shortcode".
                    <br />
                    3. Paste this shortcode into a blog post and viola! If you have
                    configured the plugin correctly then your users should now be
                    able to purchase your product.
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="shortcode">
                    <b>What is a shortcode and how do I use one?</b>
                    <br /><br />
                    A shortcode is a bit of text you can put in your posts that get
                    filtered and changed into something useful. For example, a lot of
                    forums use "bbcode" which stands for bulletin board code, which is
                    a type of short code. They have tags like [b] for bold, [i] for
                    italic and so on.
                    <br /><br />
                    LBAK Google Checkout uses its own shortcode system to let you
                    easily post your products to your blog. Simply enter:
                    <blockquote>
                    [checkout product="1"]
                    </blockquote>
                    To post the product with an ID of 1 to your blog. The product
                    attribute also supports lists of comma separated values for posting
                    multiple products to your blog. Example:
                    <blockquote>
                    [checkout product="1, 2, 23, 5"]
                    </blockquote>
                    This will print out 4 products with the respective 1, 2, 23 and 5
                    product IDs. Product also supports the "all" value which is seld explanatory .
                    You can also print out everything in a category by
                    specifying the category attribute:
                    <blockquote>
                    [checkout category="Example"]
                    </blockquote>
                    This will print out everything in the category "Example". You can
                    combine this with the product attribute to print out items not in
                    the specified category.
                    <br /><br />
                    Other attributes:<br />
                    <b>price</b> - let\'s you specify pricing rules such as price=">20" will
                    only print out products that cost more than 20 of whatever currency it
                    is you are trading in. You can use >, <, >=, <= or specify a range
                    like "x-y" with x and y being 2 numbers, eg "20-30". This can
                    <b>only</b> be used in conjunction with product and or category. Just
                    typing [checkout price="<20"] will show nothing, you would have to do
                    [checkout product="all" price="<20"] to display all of your products
                    under 20 of whatever currency you\'re trading in.
                    <br /><br />
                    <b>style</b> - The style attribute will apply CSS styles to the
                    outer most div on the product. This is useful for specifying things like
                    size: [checkout product="all" style="width: 50%"] for example.
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>
                    <div id="help">
                    <b>I\'m still confused :(</b>
                    <br /><br />
                    If the above Help/FAQ did not answer your needs you have a few
                    options:<br /><br />
                    1. Read the <a href="https://checkout.google.com/support/sell/" target="_blank">help section</a> on Google Checkout
                    to see if they have answered your query.
                    <br />
                    2. Or email me: samwho@lbak.co.uk and I will try my best to get back to you ASAP. :)
                    <br /><br />
                    <a href="#top">Back to top</a>
                    <br /><br />
                    </div>', 'lbakgc'); ?>
            </div>
        </div>
    </div>
                <?php
                break;
            case '':
            case 'settings':
                if (isset($_POST['settings_submit'])) {
                    $options['merchant_id'] = $wpdb->escape($_POST['merchant_id']);
                    $options['currency'] = $wpdb->escape($_POST['currency']);
                    $options['sandbox'] = $wpdb->escape($_POST['sandbox']);
                    $options['sandbox_merchant_id'] = $wpdb->escape($_POST['sandbox_merchant_id']);
                    $options['highlight-time'] = $wpdb->escape($_POST['highlight-time']);
                    $options['highlight-color'] = $wpdb->escape($_POST['highlight-color']);
                    $options['cart-opening-time'] = intval($_POST['cart-opening-time']);
                    $options['hide-cart-when-empty'] = $wpdb->escape($_POST['hide-cart-when-empty']);
                    $options['close-cart-when-click-away'] = $wpdb->escape($_POST['close-cart-when-click-away']);
                    $options['image-width'] = $wpdb->escape($_POST['image-width']);
                    $options['image-height'] = $wpdb->escape($_POST['image-height']);
                    $options['product-width'] = $wpdb->escape($_POST['product-width']);
                    $options['product-height'] = $wpdb->escape($_POST['product-height']);


                    lbakgc_update_options($options);
                    echo '<div class="updated">LBAK Google Checkout settings updated!
                        Note that changes to the cart will not take effect on this
                        current page as the cart was loaded before the options were
                        updated. Please refresh the page or navigate to another
                        page to see the changes.</div>';
                }
                if ($options['sandbox']) {
                    $sandbox_checked = 'checked';
                }
                ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable">
        <div class="postbox" id="lbakgc_settings">
            <h3><?php _e('LBAK Google Checkout Settings', 'lbakgc'); ?></h3>
            <div class="inside">
                <form action="?page=lbakgc" method="post">
                    <table class="widefat">
                        <thead>
                        <th><?php _e('Setting', 'lbakgc'); ?></th>
                        <th><?php _e('Options', 'lbakgc'); ?></th>
                        <th><?php _e('Description', 'lbakgc'); ?></th>
                        </thead>
                        <tr>
                            <td>
                                <label for="sandbox">
                                    <b><?php _e('Sandbox Mode', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="hidden" name="sandbox" value="0" />
                                <input type="checkbox" name="sandbox" id="sandbox"
                                                   <?php echo $sandbox_checked; ?> />
                            </td>
                            <td>
                                            <?php _e('Check this to use Google Checkout\'s
                                        Sandbox mode. This allows you to test out
                                        your Google Checkout setup. Click
                                        <a href="http://code.google.com/apis/checkout/developer/Google_Checkout_Basic_HTML_Sandbox.html">here</a> for more info.
                                        If you are uncertain then I would recommend
                                        either thoroughly reading the previous link, asking
                                        someone who knows how to use Google Checkout
                                        sandbox to help you or jusst leave it off.', 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="sandbox_merchant_id">
                                    <b><?php _e('Sandbox Merchant ID', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="sandbox_merchant_id" id="sandbox_merchant_id"
                                       value="<?php echo $options['sandbox_merchant_id']; ?>" />
                            </td>
                            <td>
                                            <?php _e('This is the Merchant ID for your merchant
                                    sandbox account. Use this only in conjunction with
                                    sandbox mode. If you do not use sandbox mode at all
                                    you can leave this blank.', 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="merchant_id">
                                    <b><?php _e('Merchant ID', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="merchant_id" id="merchant_id"
                                       value="<?php echo $options['merchant_id']; ?>" />
                            </td>
                            <td>
                                            <?php _e('Your Merchant ID can be found
                                    in Google Checkout\'s Settings tab under the
                                    "Preferences" heading on the left. It\'s a
                                    long number, ~15 digits.', 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="currency">
                                    <b><?php _e('Currency', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="currency" id="currency"
                                       value="<?php echo $options['currency']; ?>" />
                            </td>
                            <td>
                                            <?php _e('This is the currency in which you want
                                    to take payments. This needs to correspond
                                    with the currency setting in your Google
                                    checkout account. If you are based in the UK
                                    it will be "GBP" and if you are in the US
                                    it will be "USD" (both without quotes).'
                                                    , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="highlight-time">
                                    <b><?php _e('Cart Highlight Time', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="highlight-time" id="highlight-time"
                                       value="<?php echo $options['highlight-time']; ?>" />
                            </td>
                            <td>
                                <?php _e('This is the time (in miliseconds)
                                    that an item should be highlighted for after
                                    being added to the cart.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="highlight-color">
                                    <b><?php _e('Cart Highlight Color', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="highlight-color" id="highlight-color"
                                       value="<?php echo $options['highlight-color']; ?>" />
                            </td>
                            <td>
                                <?php _e('This is the color that items added to the cart
                                    will be highlighted in.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cart-opening-time">
                                    <b><?php _e('Cart Opening Time', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="cart-opening-time" id="cart-opening-time"
                                       value="<?php echo $options['cart-opening-time']; ?>" />
                            </td>
                            <td>
                                <?php _e('This is the time (in miliseconds)
                                    that it will take the cart to expand and
                                    collapse.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="hide-cart-when-empty">
                                    <b><?php _e('Hide Cart When Empty?', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="hide-cart-when-empty" id="hide-cart-when-empty"
                                       value="<?php echo $options['hide-cart-when-empty']; ?>" />
                            </td>
                            <td>
                                <?php _e('This variable specifies whether or not the
                                    cart will show up when there are no items in it.
                                    Please set to either "true" or "false".'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="close-cart-when-click-away">
                                    <b><?php _e('Close Cart When Click Away?', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="close-cart-when-click-away" id="close-cart-when-click-away"
                                       value="<?php echo $options['close-cart-when-click-away']; ?>" />
                            </td>
                            <td>
                                <?php _e('This variable specifies whether or not the
                                    cart will disappear when you click off it.
                                    Please set to either "true" or "false".'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="image-width">
                                    <b><?php _e('Image width', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="image-width" id="image-width"
                                       value="<?php echo $options['image-width']; ?>" />
                            </td>
                            <td>
                                <?php _e('The max width to use for
                                    images displayed in products.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="image-height">
                                    <b><?php _e('Image height', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="image-height" id="image-height"
                                       value="<?php echo $options['image-height']; ?>" />
                            </td>
                            <td>
                                <?php _e('The max height to use for
                                    images displayed in products.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="product-width">
                                    <b><?php _e('Product width', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="product-width" id="product-width"
                                       value="<?php echo $options['product-width']; ?>" />
                            </td>
                            <td>
                                <?php _e('The max width to use for
                                    products displayed on your site.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="product-height">
                                    <b><?php _e('Product height', 'lbakgc'); ?></b>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="product-height" id="product-height"
                                       value="<?php echo $options['product-height']; ?>" />
                            </td>
                            <td>
                                <?php _e('The max height to use for
                                    products displayed on your site.'
                                        , 'lbakgc'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="settings_submit">
                                    <b>Submit</b>
                                </label>
                            </td>
                            <td>
                                <input type="submit" name="settings_submit" id="settings_submit"
                                       value="Submit" class="button-primary" />
                            </td>
                            <td>
                                <?php _e('Save these options.', 'lbakgc'); ?>
                            </td>
                        </tr>
                        <thead>
                        <th>Setting</th>
                        <th>Options</th>
                        <th>Description</th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
                <?php
                break;
            case 'addproducts':
                /*
                 * Need to output the max width and height of images here because
                 * the javascript can't use the PHP function used to generate
                 * the thumbnails.
                 */
                if (isset($_POST['add_product_submit'])) {
                    $data = array();
                    $format = array();

                    $data['product_name'] = $_POST['product_name'];
                    $format[] = '%s';
                    $data['product_price'] = $_POST['product_price'];
                    $format[] = '%s';
                    $data['product_image'] = $_POST['product_image'];
                    $format[] = '%s';
                    $data['product_description'] = $_POST['product_description'];
                    $format[] = '%s';
                    $data['product_extra'] = $_POST['product_extra'];
                    $format[] = '%s';
                    $data['product_category'] = $_POST['product_category'];
                    $format[] = '%s';
                    $data['in_stock'] = $_POST['in_stock'];
                    $format[] = '%d';
                    $data['product_shipping'] = $_POST['product_shipping'];
                    $format[] = '%s';
                    $data['use_custom'] = $_POST['use_custom'];
                    $format[] = '%d';
                    $data['custom'] = $_POST['custom'];
                    $format[] = '%s';

                    $wpdb->insert($options['product_table_name'], $data, $format);

                    echo '<div class="updated">Product "'.$data['product_name'].'" added!</div>';
                }

                ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="width: 100%; float: left;">
        <div class="postbox">
            <h3><?php _e('About this page', 'lbakgc'); ?></h3>
            <div class="inside">
                <p>
                        <?php _e('To add a product to your database of products
                        simply fill out the form below. If you do not require
                        one of the fields, feel free to leave it blank.<br /><br />
                        <b>Using the Custom HTML Option:</b> If you want to
                        completely customise your product box you are welcome to
                        tick the "Use Custom HTML?" option. Upon doing this a box
                        will appear for you to edit the HTML appearance of your product
                        yourself. Doing this requires a solid working knowledge of
                        the Google Checkout API, HTML and CSS. It is advised that you
                        <a href="http://code.google.com/apis/checkout/developer/Google_Checkout_Shopping_Cart_Annotating_Products.html" target="_blank">
                        read this</a> before using the Custom HTML option.
                        You can still edit the values of the form boxes (name, description
                        etc.) for the purposes of your product list in the admin
                        menu but these will not be displayed when the product is
                        displayed on your site.', 'lbakgc'); ?>
                </p>
            </div>
        </div>
    </div>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="width: 50%; float: left;">
        <div class="postbox" id="lbakgc_settings">
            <h3><?php _e('Add a Product', 'lbakgc'); ?></h3>
            <div class="inside">
                <form action="?page=lbakgc&step=addproducts" method="post" name="add_product">
                    <table class="widefat">
                        <thead>
                        <th><?php _e('Option', 'lbakgc'); ?></th>
                        <th><?php _e('Value', 'lbakgc'); ?></th>
                        </thead>
                        <tr>
                            <td>
                                <?php _e('Name', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_name" id="product_name"
                                       onkeyup="updateProductPreview(document.forms.add_product)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Description', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="product_description"
                                          id="product_description"
                                          cols="20"
                                          rows="3"
                                          onkeyup="updateProductPreview(document.forms.add_product)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Category', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_category" id="product_category"
                                       onkeyup="updateProductPreview(document.forms.add_product)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Image (URL)', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_image" id="product_image"
                                       onkeyup="updateProductPreview(document.forms.add_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Extra Info', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="product_extra"
                                          id="product_extra"
                                          cols="20"
                                          rows="3"
                                          onkeyup="updateProductPreview(document.forms.add_product)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Price (in '.$options['currency'].')', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_price" id="product_price"
                                       onkeyup="updateProductPreview(document.forms.add_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Shipping (in '.$options['currency'].')', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_shipping" id="product_shipping"
                                       onkeyup="updateProductPreview(document.forms.add_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('In Stock?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="in_stock" value="0" />
                                <input type="checkbox" name="in_stock" id="in_stock" value="1"
                                       onclick="updateProductPreview(document.forms.add_product)" checked/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Use Custom HTML?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="use_custom" value="0" />
                                <input type="checkbox" name="use_custom" id="use_custom" value="1"
                                       onclick="toggleCheckbox(document.forms.add_product, 'custom_html');"/>
                            </td>
                        </tr>
                        <tr id="custom_html" style="display: none;">
                            <td>
                                <?php _e('Custom HTML', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="custom"
                                          id="custom"
                                          cols="40"
                                          rows="7"
                                          onkeyup="updateProductPreview(document.forms.add_product)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <input type="submit" name="add_product_submit"
                                       class="button-primary" value="<?php _e('Add', 'lbakgc'); ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="width: auto; max-width: 49%; float: left;">
        <div class="postbox" id="lbakgc_settings">
            <h3><?php _e('Product Preview', 'lbakgc'); ?></h3>
            <div class="inside">
                <p>
                    <?php _e('Start filling out the form to view a real-time product preview.', 'lbakgc'); ?>
                </p>
                <div id="product_preview">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        toggleCheckbox(document.forms.add_product, 'custom_html');
    </script>
                <?php
                break;
            case 'deleteproduct':
                if ($_GET['confirm'] == 1) {
                    echo lbakgc_delete_product($_GET['id']);
                }
                else {
                    echo '<div class="error" style="padding: 5px;">Are you sure you want to delete the product "'.lbakgc_get_product_name($_GET['id']).'"?
                        <a href="?page=lbakgc&step=deleteproduct&id='.$_GET['id'].'&confirm=1" class="button-primary">Yes</a>
                        <a href="?page=lbakgc&step=viewproducts" class="button-secondary">No</a></div>';
                    break;
                }
            case 'editproduct':
                if ($_GET['step'] != 'deleteproduct') {
                    lbakgc_edit_product($_GET['id']);
                }
            case 'deleteproduct':
            case 'viewproducts':
                ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="float:left; width: 100%;">
        <div class="postbox">
            <h3><?php _e('View Products', 'lbakgc'); ?></h3>
            <div class="inside">
                            <?php
                            echo lbakgc_admin_list_products();
                            ?>
            </div>
        </div>
    </div>
                <?php
                    break;
                case 'deleteproduct':

                    break;
        } //end switch
        ?>
</div> <!-- CLOSE DIV CLASS WRAP -->
    <?php
}

function lbakgc_admin_list_products() {
    //Check that the user is able to view this page.
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have sufficient permissions to access this page.', 'lbakgc') );
    }

    //Declare global variables.
    global $wpdb;

    //Get lbakgc options.
    $options = lbakgc_get_options();

    $query = 'SELECT * FROM `'.$options['product_table_name'].'`
        LIMIT 20
        OFFSET '.((lbakgc_page_var())-1)*20;

    $rows = $wpdb->get_results($query);

    $return = '<table class="widefat">
        <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Category</th>
        <th>Price</th>
        <th>Shipping</th>
        <th>Extra Info</th>
        <th>In Stock?</th>
        <th>Custom HTML?</th>
        <th>Options</th>
        </thead>';
    foreach ($rows as $row) {
        $row = lbakgc_stripslashes_product($row);
        $return .= '<tr>';
        $return .= '<td>'.$row->product_id.'</td>';
        $return .= '<td>'.$row->product_name.'</td>';
        $return .= '<td>'.$row->product_description.'</td>';
        $return .= '<td>'.lbakgc_img_thumb($row->product_image).'</td>';
        $return .= '<td>'.$row->product_category.'</td>';
        $return .= '<td>'.lbakgc_parse_currency($row->product_price, $options).'</td>';
        $return .= '<td>'.lbakgc_parse_currency($row->product_shipping, $options).'</td>';
        $return .= '<td>'.$row->product_extra.'</td>';
        $return .= '<td>'.($row->in_stock ? '<span style="color: green;">Yes.</span>' : '<span style="color: red;">No.</span>').'</td>';
        $return .= '<td>'.($row->use_custom ? '<span style="color: green;">Yes.</span>' : '<span style="color: red;">No.</span>').'</td>';
        $return .= '<td><a href="tools.php?page=lbakgc&step=editproduct&id='.$row->product_id.'">Edit</a> |
            <a href="tools.php?page=lbakgc&step=deleteproduct&id='.$row->product_id.'">Delete</a> | 
            <a href="javascript:displayShortcode('.$row->product_id.');">Get Shortcode</a></td>';
        $return .= '</tr>';
    }
    $return .= '</table>';

    $no_of_results = $wpdb->get_var('SELECT COUNT(*) FROM `'.$options['product_table_name'].'`');

    $return .= '<br />'.lbakgc_do_pagination($no_of_results, $options);

    return $return;
}

/*
 * Generates the pagination based on the amount of results and the place of
 * the table. $place is used for deciding how many rows get shown, thus how
 * many pages there are.
*/
function lbakgc_do_pagination($no_of_results, $options = null) {
    if ($options == null) {
        $options = lbakgc_get_options();
    }

    $pages = ceil($no_of_results/20);

    if ($pages < 2) {
        return null;
    }

    $start = max(1, lbakgc_page_var() - 3);
    $end = min($pages, lbakgc_page_var() + 3);

    $result .= '<div class="lbakgc_pages">';
    $result .= 'Showing results '.((lbakgc_page_var()-1)*20+1).'
        - '.(lbakgc_page_var()*20).' of '.$no_of_results.'<br /><br />';

    $uri = preg_replace('/&lbakgc_page=[0-9]+/', '', $_SERVER['QUERY_STRING']);

    if ($start != 1) {
        if ($uri == '') {
            $page_uri = '?lbakgc_page=1';
        }
        else {
            $page_uri = '?'.$uri.'&lbakgc_page=1';
        }
        $result .= '<span class="lbakgc_page"><a href="'.$page_uri.'">&nbsp;1&nbsp;</a></span> ... ';
    }

    for ($page = $start; $page <= $end; $page++) {
        if ($uri == '') {
            $page_uri = '?lbakgc_page='.$page;
        }
        else {
            $page_uri = '?'.$uri.'&lbakgc_page='.$page;
        }

        if ($page == lbakgc_page_var()) {
            $result .= '<span class="lbakgc_page_selected"><a href="'.$page_uri.'">&nbsp;'.$page.'&nbsp;</a></span>';
        }
        else {
            $result .= '<span class="lbakgc_page"><a href="'.$page_uri.'">&nbsp;'.$page.'&nbsp;</a></span>';
        }
    }

    if ($end != $pages) {
        if ($uri == '') {
            $page_uri = '?lbakgc_page='.$pages;
        }
        else {
            $page_uri = '?'.$uri.'&lbakgc_page='.$pages;
        }
        $result .= ' ... <span class="lbakgc_page"><a href="'.$page_uri.'">&nbsp;'.$pages.'&nbsp;</a></span>';
    }

    $result .= '</div>';

    return $result;
}

/*
 * Get the variable used in pagination.
*/
function lbakgc_page_var() {
    if (!isset($_GET['lbakgc_page'])) {
        return 1;
    }
    else {
        return abs($_GET['lbakgc_page']);
    }
}

/*
 * Function to add the correct preceeding symbol to currency values.
*/
function lbakgc_parse_currency($number, $options = null) {
    if ($options == null) {
        $options = lbakgc_get_options();
    }
    if ($number) {
        if ($options['currency'] == 'GBP') {
            return '£'.$number;
        }
        else if ($options['currency'] == 'USD') {
            return '$'.$number;
        }
        else {
            return $number;
        }
    }
    else {
        return null;
    }
}

/*
 * Makes an image smaller based on its url. Nothing fancy, just CSS.
*/
function lbakgc_img_thumb($url, $width = 100, $height = 50, $product = false) {
    $class = $product ? 'class="product-image"' : '';
    return $url ? '<img '.$class.' src="'.$url.'" style="max-width: '.$width.'px; max-height='.$height.'px;" />' : null;
}

function lbakgc_edit_product($product_id) {
    //Check that the user is able to view this page.
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have sufficient permissions to access this page.', 'lbakgc') );
    }
    
    global $wpdb;
    $options = lbakgc_get_options();
    $product_id = intval($product_id);

    if (isset($_POST['edit_product_submit'])) {
        $data = array();
        $format = array();
        $where = array();
        $where_format = array();

        $data['product_name'] = $_POST['product_name'];
        $format[] = '%s';
        $data['product_price'] = $_POST['product_price'];
        $format[] = '%s';
        $data['product_shipping'] = $_POST['product_shipping'];
        $format[] = '%s';
        $data['product_extra'] = $_POST['product_extra'];
        $format[] = '%s';
        $data['in_stock'] = $_POST['in_stock'];
        $format[] = '%d';
        $data['product_description'] = $_POST['product_description'];
        $format[] = '%s';
        $data['product_image'] = $_POST['product_image'];
        $format[] = '%s';
        $data['product_category'] = $_POST['product_category'];
        $format[] = '%s';
        $data['use_custom'] = $_POST['use_custom'];
        $format[] = '%d';
        $data['custom'] = $_POST['custom'];
        $format[] = '%s';

        $where['product_id'] = $product_id;
        $where_format[] = '%d';

        $wpdb->update($options['product_table_name'], $data, $where, $format, $where_format);

        echo '<div class="updated">Updated product "'.$_POST['product_name'].'"!</div>';
    }
    else {
        $row = lbakgc_stripslashes_product($wpdb->get_row('SELECT * FROM `'.$options['product_table_name'].'` WHERE `product_id`='.$product_id));
    ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="width: 50%; float: left;">
        <div class="postbox">
            <h3><?php _e('Edit a Product', 'lbakgc'); ?></h3>
            <div class="inside">
                <form action="?page=lbakgc&step=editproduct&id=<?php echo $product_id; ?>" method="post" name="edit_product">
                    <table class="widefat">
                        <thead>
                        <th>Option</th>
                        <th>Value</th>
                        </thead>
                        <tr>
                            <td>
                                <?php _e('Name', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_name" id="product_name"
                                       value="<?php echo $row->product_name; ?>" onkeyup="updateProductPreview(document.forms.edit_product)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Description', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="product_description"
                                          id="product_description"
                                          cols="20"
                                          rows="3"
                                          onkeyup="updateProductPreview(document.forms.edit_product)"><?php echo $row->product_description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Category', 'lbakgc'); ?>
                            </td>
                            <td>
                                 <input type="text" name="product_category" id="product_category"
                                       value="<?php echo $row->product_category; ?>" onkeyup="updateProductPreview(document.forms.edit_product)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Image (URL)', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_image" id="product_image"
                                       value="<?php echo $row->product_image; ?>" onkeyup="updateProductPreview(document.forms.edit_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Extra Info', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="product_extra"
                                          id="product_extra"
                                          cols="20"
                                          rows="3"
                                          onkeyup="updateProductPreview(document.forms.edit_product)"><?php echo $row->product_extra; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Price (in '.$options['currency'].')', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_price" id="product_price"
                                       value="<?php echo $row->product_price; ?>" onkeyup="updateProductPreview(document.forms.edit_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Shipping (in '.$options['currency'].')', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="text" name="product_shipping" id="product_shipping"
                                       value="<?php echo $row->product_shipping; ?>" onkeyup="updateProductPreview(document.forms.edit_product)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('In Stock?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="in_stock" value="0" />
                                <input type="checkbox" name="in_stock" id="in_stock" value="1"
                                       onclick="updateProductPreview(document.forms.edit_product)" <?php echo $row->in_stock ? 'checked' : ''; ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php _e('Use Custom HTML?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="use_custom" value="0" />
                                <input type="checkbox" name="use_custom" id="use_custom" value="1"
                                       onclick="toggleCheckbox(document.forms.edit_product, 'custom_html');"
                                       <?php echo $row->use_custom ? 'checked' : ''; ?>/>
                            </td>
                        </tr>
                        <tr id="custom_html" style="display: none;">
                            <td>
                                <?php _e('Custom HTML', 'lbakgc'); ?>
                            </td>
                            <td>
                                <textarea name="custom"
                                          id="custom"
                                          cols="40"
                                          rows="7"
                                          onkeyup="updateProductPreview(document.forms.edit_product)"><?php echo stripslashes($row->custom); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <input type="submit" name="edit_product_submit"
                                       class="button-primary" value="Edit" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div id="poststuff" class="ui-sortable meta-box-sortable" style="width: auto; max-width: 49%; float: left;">
        <div class="postbox" id="lbakgc_settings">
            <h3><?php _e('Product Preview', 'lbakgc'); ?></h3>
            <div class="inside">
                <div id="product_preview">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        toggleCheckbox(document.forms.edit_product, 'custom_html');
    </script>
    <?php
    }
}

function lbakgc_delete_product($product_id) {
    //Check that the user is able to view this page.
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have sufficient permissions to access this page.', 'lbakgc') );
    }

    global $wpdb;
    $product_id = intval($product_id);
    $options = lbakgc_get_options();

    $product_name = lbakgc_get_product_name($product_id, $options);
    $wpdb->query('DELETE FROM `'.$options['product_table_name'].'` WHERE `product_id`='.$product_id);

    return '<div class="updated">Deleted product "'.$product_name.'".</div>';
}

function lbakgc_get_product_name($product_id, $options = null) {
    global $wpdb;
    $product_id = intval($product_id);
    if ($options == null) {
        $options = lbakgc_get_options();
    }
    return $wpdb->get_var('SELECT `product_name` FROM `'.$options['product_table_name'].'` WHERE `product_id`='.$product_id);
}

function lbakgc_get_product_box($product_ids, $options = null, $style = null) {
    global $wpdb;
    $product_ids = intval($product_ids);
    if ($options == null) {
        $options = lbakgc_get_options();
    }

    $rows = $wpdb->get_results('SELECT * FROM `'.$options['product_table_name'].'` WHERE `product_id` IN ('.$product_ids.')');
    foreach ($rows as $row) {
        $return .= lbakgc_get_product_box_no_query($row, $options, $style);
    }
    return $return;
}

function lbakgc_get_product_box_no_query($row, $options, $style = null) {
    $row = lbakgc_stripslashes_product($row);
    if ($row->use_custom) {
        if ($row->in_stock) {
            if ($style != null) {
                $row->custom = preg_replace('/\<div class=\"product\">/i', '<div class="product" style="'.$style.'">', $row->custom);
            }
            return $row->custom;
        }
        else {
            return '';
        }
    }
    else {
        $image = $row->product_image ? '<img class="product-image" src="'.$row->product_image.'" />' : '';
        $name = $row->product_name ? '<div class="product_attribute"><span class="product_title"><span class="product-title">'.$row->product_name.'</span></span></div>' : '';
        $category = $row->product_category ? '<div class="product_attribute"><b>Category:</b> '.$row->product_category.'</div>' : '';
        $price = $row->product_price ? '<div class="product_attribute"><b>Price:</b> <span class="product-price">'.lbakgc_parse_currency($row->product_price, $options).'</span></div>' : '';
        $shipping = $row->product_shipping ? '<div class="product_attribute"><b>Shipping:</b> <span class="product-shipping">'.lbakgc_parse_currency($row->product_shipping, $options).'</span></div>' : '';
        $description = $row->product_description ? '<div class="product_attribute"><b>Description:</b> <span class="product-attr-description">'.nl2br($row->product_description).'</span></div>' : '';
        $extra = $row->product_extra ? '<div class="product_attribute"><b>Extra Info:</b> <span class="product-attr-extra">'.nl2br($row->product_extra).'</span></div>' : '';
        $button = '<div role="button" alt="Add to cart" tabindex="0" class="googlecart-add-button"></div>';
        if ($style != null) {
                $style = ' style="'.$style.'"';
        }
        if ($row->in_stock) {
            $return .= '
                <div class="product"'.$style.'>
                    '.$image.'
                    <div class="product_info">
                        '.$name.'
                        '.$category.'
                        '.$price.'
                        '.$shipping.'
                        '.$description.'
                        '.$extra.'
                        '.$button.'
                    </div>
                </div>
            ';
        }
        else {
            $return .= '
                <div class="product not_in_stock"'.$style.'>
                    '.$image.'
                    <div class="product_info">
                        <b>NOT IN STOCK</b>
                        '.$name.'
                        '.$category.'
                        '.$price.'
                        '.$shipping.'
                        '.$description.'
                        '.$extra.'
                    </div>
                </div>
            ';
        }

        return $return;
    }
}

function lbakgc_stripslashes_product($row) {
    if (is_object($row)) {
        $row->product_name = stripslashes($row->product_name);
        $row->product_description = stripslashes($row->product_description);
        $row->product_extra = stripslashes($row->product_extra);
        $row->product_category = stripslashes($row->product_category);
        $row->custom = stripslashes($row->custom);
        return $row;

    }
    else {
        return false;
    }
}
?>
