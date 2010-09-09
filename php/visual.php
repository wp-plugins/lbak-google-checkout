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
                if ($_GET['question'] == 'success') {
                    echo '<div class="updated">Question submitted successfully!
                        Please wait at least a few days for an answer.</div>';
                }
                else if ($_GET['question'] == 'fail') {
                    echo '<div class="error">There was a problem submitting
                        your question. Please fill out all of the form fields.</div>';
                }
                ?>
    <div id="poststuff" class="ui-sortable meta-box-sortable">
        <div class="postbox" id="top">
            <h3><?php _e('I\'m stuck and I need help!', 'lbakgc'); ?></h3>
            <div class="inside">
                <?php _e(lbakgc_get_web_page('http://lbak.co.uk/faq.php?step=get&tag=lbakgc'), 'lbakgc'); ?>
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
                    $data['multiple_pricings'] = $_POST['multiple_pricings'];
                    $format[] = '%d';
                    if (is_array($_POST['product_price'])) {
                        $counter = 0;
                        foreach ($_POST['product_price'] as $price) {
                            $data['product_price'][$counter]['price'] = $price;
                            $counter++;
                        }
                        $counter = 0;
                        foreach ($_POST['product_price_desc'] as $description) {
                            $data['product_price'][$counter]['description'] = $description;
                            $counter++;
                        }
                        foreach ($data['product_price'] as $k => $item) {
                            if ($item['price'] && $item['description']) {

                            }
                            else {
                                unset($data['product_price'][$k]);
                            }
                        }
                        $data['product_price'] = serialize($data['product_price']);
                        $format[] = '%s';
                    }
                    else {
                        $data['product_price'] = $_POST['product_price'];
                        $format[] = '%s';
                    }
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
                        displayed on your site.<br /><br />
                        <b>Multiple Pricings: </b> If you want to have more than
                        one price for a product, perhaps you offer it in different
                        sizes, you can use the new multiple pricings option. Note
                        that it won\'t preview unless you add at least 2 options.
                        If you leave either of the Desc or Price fields blank, that
                        entry will not be saved.', 'lbakgc'); ?>
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
                                <?php _e('Use multiple pricings?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="multiple_pricings" value="0" />
                                <input type="checkbox" name="multiple_pricings" id="multiple_pricings" value="1"
                                       onclick="toggleMultiplePricings('document.forms.add_product'), updateProductPreview(document.forms.add_product)" />
                            </td>
                        </tr>
                        <tr id="price">
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
        if (is_array(unserialize($row->product_price))) {
            $return .= '<td>';
            foreach (unserialize($row->product_price) as $data) {
                $return .= $data['description'].' - '.lbakgc_parse_currency($data['price']).'<br />';
            }
            $return .= '</td>';
        }
        else {
            $return .= '<td>'.lbakgc_parse_currency($row->product_price, $options).'</td>';
        }
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
            return '&#163'.$number;
        }
        else if ($options['currency'] == 'USD') {
            return '&#36;'.$number;
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
        if (is_array($_POST['product_price'])) {
            $counter = 0;
            foreach ($_POST['product_price'] as $price) {
                $data['product_price'][$counter]['price'] = $price;
                $counter++;
            }
            $counter = 0;
            foreach ($_POST['product_price_desc'] as $description) {
                $data['product_price'][$counter]['description'] = $description;
                $counter++;
            }
            foreach ($data['product_price'] as $k => $item) {
                if ($item['price'] && $item['description']) {

                }
                else {
                    unset($data['product_price'][$k]);
                }
            }
            $data['product_price'] = serialize($data['product_price']);
            $format[] = '%s';
        }
        else {
            $data['product_price'] = $_POST['product_price'];
            $format[] = '%s';
        }
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
                                <?php _e('Use multiple pricings?', 'lbakgc'); ?>
                            </td>
                            <td>
                                <input type="hidden" name="multiple_pricings" value="0" />
                                <input type="checkbox" name="multiple_pricings" id="multiple_pricings" value="1"
                                       onclick="toggleMultiplePricings('document.forms.edit_product'), updateProductPreview(document.forms.edit_product)"
                                       <?php echo $row->multiple_pricings ? 'checked' : '' ?>/>
                            </td>
                        </tr>
                        <tr id="price">
                            <td>
                                <?php _e('Price (in '.$options['currency'].')', 'lbakgc'); ?>
                            </td>
                            <td>
                                <?php
                                if (is_array(unserialize($row->product_price))) {
                                    echo '<div id="prices">';
                                    foreach (unserialize($row->product_price) as $data) {
                                        echo '<div>Desc: <input type="text" name="product_price_desc[]"
                                            id="desc'.$count.'" value="'.$data['description'].'" />
                                                Price: <input type="text" name="product_price[]"
                                            id="price'.$count.'" value="'.$data['price'].'" /></div>';
                                    }
                                    echo '</div><br /><a href="javascript:addPriceOption(\'document.forms.edit_product\');" class="button-primary">Add option</a><br /><br />';
                                }
                                else {
                                ?>
                                <input type="text" name="product_price" id="product_price"
                                       value="<?php echo $row->product_price; ?>" onkeyup="updateProductPreview(document.forms.edit_product)" />
                                <?php
                                }
                                ?>
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
        if (is_array(unserialize($row->product_price))) {
            $row->product_price = unserialize($row->product_price);
            $price = '<div class="product_attribute"><div style="display: none;" class="product-price">'.$row->product_price[0]['price'].'</div><select class="product-attr-selection">';
            foreach ($row->product_price as $data) {
                $price .= '<option googlecart-set-product-price="'.$data['price'].'">
                    '.$data['description'].' - '.lbakgc_parse_currency($data['price']).'</option>';
            }
            $price .= '</select></div>';
        }
        else {
            $price = $row->product_price ? '<div class="product_attribute"><b>Price:</b> <span class="product-price">'.lbakgc_parse_currency($row->product_price, $options).'</span></div>' : '';
        }
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
