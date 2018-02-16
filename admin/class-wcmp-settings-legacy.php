<?php

class WCMp_Settings_Legacy {

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $tab;

    /**
     * Start up
     */
    public function __construct($tab) {
        $this->tab = $tab;
        $this->options = get_option("wcmp_{$this->tab}_settings_name");
        $this->settings_page_init();
        //general tab migration option
    }

    /**
     * Register and add settings
     */
    public function settings_page_init() {
        global $WCMp;

        $settings_tab_options = array("tab" => "{$this->tab}",
            "ref" => &$this,
            "sections" => array(
                "venor_approval_settings_section" => array("title" => '', // Section one
                    "fields" => apply_filters('wcmp_general_tab_filds', array(
                        "enable_registration" => array('title' => __('Vendor Registration', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'enable_registration', 'label_for' => 'enable_registration', 'text' => __('Anyone can register as vendor. Leave it unchecked if you want to keep your site an invite only marketpace.', 'dc-woocommerce-multi-vendor'), 'name' => 'enable_registration', 'value' => 'Enable'), // Checkbox
                        "is_university_on" => array('title' => __('Vendor Knowledgebase', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'is_university_on', 'label_for' => 'is_university_on', 'name' => 'is_university_on', 'value' => 'Enable', 'text' => __('Enable "Knowledgebase" section on vendor dashboard.', 'dc-woocommerce-multi-vendor')), // Checkbox
                        "enable_vendor_tab" => array('title' => __('Vendor Tab', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'enable_vendor_tab', 'label_for' => 'enable_vendor_tab', 'text' => stripslashes(__('Display vendor details on product page.', 'dc-woocommerce-multi-vendor')), 'name' => 'enable_vendor_tab', 'value' => 'Enable'), // Checkbox
                        "sold_by_text" => array('title' => __('"Sold by" label', 'dc-woocommerce-multi-vendor'), 'type' => 'text', 'id' => 'sold_by_textt', 'label_for' => 'sold_by_textt', 'name' => 'sold_by_text', 'desc' => stripslashes(__('Add the text you want to replace the phrase \"Sold by {vendor name}\".', 'dc-woocommerce-multi-vendor'))), // Text
                        "sold_by_textt" => array('title' => __('Vendor Slug', 'dc-woocommerce-multi-vendor'), 'type' => 'text', 'id' => 'sold_by_texttt', 'label_for' => 'sold_by_texttt', 'name' => 'sold_by_textt', 'desc' => stripslashes(sprintf(__('To change the slug (/vendor/) , go to %s\"Settings/Permalinks\"%s . Type in your desired slug in the "\Vendor Shop base\" text box. Eg: yoursite.com/slug/[vendor_name].', 'dc-woocommerce-multi-vendor'), '<a target="_blank" href="options-permalink.php">', '</a>'))), // Text
                        "show_report_abuse" => array('title' => __('Show "Report abuse" link', 'dc-woocommerce-multi-vendor'), 'type' => 'select', 'id' => 'show_report_abuse', 'name' => 'show_report_abuse', 'label_for' => 'show_report_abuse', 'desc' => stripslashes(__('A "Report abuse" link will appear in single product page.', 'dc-woocommerce-multi-vendor')), 'options' => array('all_products' => __('All Products', 'dc-woocommerce-multi-vendor'), 'only_vendor_products' => __("Only for Vendor's Products", 'dc-woocommerce-multi-vendor'), 'disable' => __('Disable', 'dc-woocommerce-multi-vendor'))), // select
                        "report_abuse_text" => array('title' => __('"Report Abuse" label', 'dc-woocommerce-multi-vendor'), 'type' => 'text', 'id' => 'report_abuse_text', 'label_for' => 'report_abuse_text', 'name' => 'report_abuse_text'), // Text
                        "block_vendor_desc" => array('title' => stripslashes(__('Blocked Vendor Notice', 'dc-woocommerce-multi-vendor')), 'type' => 'wpeditor', 'id' => 'block_vendor_descc', 'label_for' => 'block_vendor_descc', 'name' => 'block_vendor_desc', 'rows' => 5), // Textarea
                        "inventory" => array('title' => __('Inventory', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'inventory', 'label_for' => 'inventory', 'name' => 'inventory', 'value' => 'Enable'), // Checkbox
                        "shipping" => array('title' => __('Shipping', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'shipping', 'label_for' => 'shipping', 'name' => 'shipping', 'value' => 'Enable'), // Checkbox
                        "linked_products" => array('title' => __('Linked Products', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'linked_products', 'label_for' => 'linked_products', 'name' => 'linked_products', 'value' => 'Enable'), // Checkbox
                        "attribute" => array('title' => __('Attributes', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'attribute', 'label_for' => 'attribute', 'name' => 'attribute', 'value' => 'Enable'), // Checkbox
                        "advanced" => array('title' => __('Advanced', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'advanced', 'label_for' => 'advanced', 'name' => 'advanced', 'value' => 'Enable'), // Checkbox
                        "is_vendor_view_comment" => array('title' => __('View Order Note', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'is_vendor_view_comment', 'label_for' => 'is_vendor_view_comment', 'name' => 'is_vendor_view_comment', 'text' => __('Vendor can see order notes.', 'dc-woocommerce-multi-vendor'), 'value' => 'Enable'), // Checkbox
                        "is_vendor_submit_comment" => array('title' => __('Add Order Note', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'is_vendor_submit_comment', 'label_for' => 'is_vendor_submit_comment', 'name' => 'is_vendor_submit_comment', 'text' => __('Vendor can add order notes.', 'dc-woocommerce-multi-vendor'), 'value' => 'Enable'), // Checkbox
                        "is_order_csv_export" => array('title' => __('Allow vendors to Export orders.', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'is_order_csv_export', 'label_for' => 'is_order_csv_export', 'name' => 'is_order_csv_export', 'value' => 'Enable'), // Checkbox
                        "show_customer_dtl_export" => array('title' => __('Customer Details in Export', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_customer_dtl_export', 'label_for' => 'show_customer_dtl_export', 'name' => 'show_customer_dtl_export', 'value' => 'Enable'), // Checkbox
                        "show_customer_billing_export" => array('title' => __('Billing Address in Export', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_customer_billing_export', 'label_for' => 'show_customer_billing_export', 'name' => 'show_customer_billing_export', 'value' => 'Enable'), // Checkbox
                        "show_customer_shipping_export" => array('title' => __('Shipping Address in Export', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_customer_shipping_export', 'label_for' => 'show_customer_shipping_export', 'name' => 'show_customer_shipping_export', 'value' => 'Enable'), // Checkbox
                        "show_cust_dtl_email" => array('title' => __('Name, Phone no. and Email', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_cust_dtl_email', 'label_for' => 'show_cust_dtl_email', 'name' => 'show_cust_dtl_email', 'value' => 'Enable'), // Checkbox
                        "show_cust_billing_email" => array('title' => __('Billing Address', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_cust_billing_email', 'label_for' => 'show_cust_billing_email', 'name' => 'show_cust_billing_email', 'value' => 'Enable'), // Checkbox
                        "show_cust_shipping_email" => array('title' => __('Shipping Address', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_cust_shipping_email', 'label_for' => 'show_cust_shipping_email', 'name' => 'show_cust_shipping_email', 'value' => 'Enable'), // Checkbox
                        "show_cust_order_calulations" => array('title' => __('Order Calculations', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'show_cust_order_calulations', 'label_for' => 'show_cust_order_calulations', 'name' => 'show_cust_order_calulations', 'value' => 'Enable'), // Checkbox
                        "can_vendor_add_message_on_email_and_thankyou_page" => array('title' => __('Message to buyer', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'can_vendor_add_message_on_email_and_thankyou_page', 'label_for' => 'can_vendor_add_message_on_email_and_thankyou_page', 'name' => 'can_vendor_add_message_on_email_and_thankyou_page', 'value' => 'Enable', 'text' => __('Allow vendors to add vendor shop specific message in "Thank you" page and order mail.', 'dc-woocommerce-multi-vendor')), // Checkbox
                        "is_vendor_add_external_url" => array('title' => __('Enable store url', 'dc-woocommerce-multi-vendor'), 'type' => 'checkbox', 'id' => 'is_vendor_add_external_url', 'label_for' => 'is_vendor_add_external_url', 'name' => 'is_vendor_add_external_url', 'text' => __('Vendor can add external store url.', 'dc-woocommerce-multi-vendor'), 'value' => 'Enable'), // Checkbox
                            )
                    ),
                ),
            ),
        );

        $WCMp->admin->settings->settings_field_init(apply_filters("settings_{$this->tab}_tab_options", $settings_tab_options));
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function wcmp_general_settings_sanitize($input) {
        $new_input = array();
        $hasError = false;
        
        if(isset($input['enable_registration'])){
            $new_input['enable_registration'] = $input['enable_registration'];
        }
        if (isset($input['is_university_on'])){
            $new_input['is_university_on'] = sanitize_text_field($input['is_university_on']);
        }
        if(isset($input['enable_vendor_tab'])){
            $new_input['enable_vendor_tab'] = sanitize_text_field($input['enable_vendor_tab']);
        }
        if (isset($input['sold_by_text'])){
            $new_input['sold_by_text'] = sanitize_text_field($input['sold_by_text']);
        }
        if (isset($input['block_vendor_desc'])){
            $new_input['block_vendor_desc'] = sanitize_text_field($input['block_vendor_desc']);
        }
        if (isset($input['show_report_abuse'])){
            $new_input['show_report_abuse'] = sanitize_text_field($input['show_report_abuse']);
        }
        if (isset($input['report_abuse_text'])){
            $new_input['report_abuse_text'] = sanitize_text_field($input['report_abuse_text']);
        }
        if (isset($input['inventory'])) {
            $new_input['inventory'] = sanitize_text_field($input['inventory']);
        }
        if (isset($input['shipping'])) {
            $new_input['shipping'] = sanitize_text_field($input['shipping']);
        }
        if (isset($input['linked_products'])) {
            $new_input['linked_products'] = sanitize_text_field($input['linked_products']);
        }
        if (isset($input['attribute'])) {
            $new_input['attribute'] = sanitize_text_field($input['attribute']);
        }
        if (isset($input['advanced'])) {
            $new_input['advanced'] = sanitize_text_field($input['advanced']);
        }
        if (isset($input['is_vendor_view_comment'])) {
            $new_input['is_vendor_view_comment'] = sanitize_text_field($input['is_vendor_view_comment']);
        }
        if (isset($input['is_vendor_submit_comment'])) {
            $new_input['is_vendor_submit_comment'] = sanitize_text_field($input['is_vendor_submit_comment']);
        }
        if (isset($input['is_order_csv_export'])) {
            $new_input['is_order_csv_export'] = sanitize_text_field($input['is_order_csv_export']);
        }
        if (isset($input['show_customer_dtl_export'])) {
            $new_input['show_customer_dtl_export'] = sanitize_text_field($input['show_customer_dtl_export']);
        }
        if (isset($input['show_customer_billing_export'])) {
            $new_input['show_customer_billing_export'] = sanitize_text_field($input['show_customer_billing_export']);
        }
        if (isset($input['show_customer_shipping_export'])) {
            $new_input['show_customer_shipping_export'] = sanitize_text_field($input['show_customer_shipping_export']);
        }
        if (isset($input['show_cust_dtl_email'])) {
            $new_input['show_cust_dtl_email'] = sanitize_text_field($input['show_cust_dtl_email']);
        }
        if (isset($input['show_cust_billing_email'])) {
            $new_input['show_cust_billing_email'] = sanitize_text_field($input['show_cust_billing_email']);
        }
        if (isset($input['show_cust_shipping_email'])) {
            $new_input['show_cust_shipping_email'] = sanitize_text_field($input['show_cust_shipping_email']);
        }
        if (isset($input['show_cust_order_calulations'])) {
            $new_input['show_cust_order_calulations'] = sanitize_text_field($input['show_cust_order_calulations']);
        }
        if (isset($input['can_vendor_add_message_on_email_and_thankyou_page'])) {
            $new_input['can_vendor_add_message_on_email_and_thankyou_page'] = sanitize_text_field($input['can_vendor_add_message_on_email_and_thankyou_page']);
        }
        if (isset($input['is_vendor_add_external_url'])) {
            $new_input['is_vendor_add_external_url'] = sanitize_text_field($input['is_vendor_add_external_url']);
        }
        
        if (!$hasError) {
            add_settings_error(
                    "wcmp_{$this->tab}_settings_name", esc_attr("wcmp_{$this->tab}_settings_admin_updated"), __('General Settings Updated', 'dc-woocommerce-multi-vendor'), 'updated'
            );
        }
        return apply_filters("settings_{$this->tab}_tab_new_input", $new_input, $input);
    }

}
