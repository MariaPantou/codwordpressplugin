<?php
include_once 'deliveryPayAdmin_class.php';


class DELIVERYPAY_OPTIONS
{

    private $options;
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    //add plugin main page
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Pay On Delivery Settings',
            'Pay On Delivery Settings',
            'manage_options',
            'delivery_pay_setting_admin',
            array($this, 'create_admin_page')
        );
    }

    //admin page main function
    public function create_admin_page()
    {
        $this->options = get_option('delivery_pay_settings');
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('delivery_pay_base_settings');
                do_settings_sections('delivery_pay_setting_admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php

    }

    //function for all setting fields
    public function page_init()
    {
        //add pay on delivery settings area
        register_setting(
            'delivery_pay_base_settings',
            'delivery_pay_settings',
            array($this, 'sanitize')
        );

        //add pay on delivery main section
        add_settings_section(
            'delivery_pay_base_settings_section',
            'Pay On Delivery Settings',
            array($this, 'print_base_section_info'),
            'delivery_pay_setting_admin'
        );

        //add pay on delivery checkbox for cod activation
        add_settings_field(
            'delivery_pay_codcheck',
            'Ενεργοποίηση Αντικαταβολής',
            array($this, 'CodCheckCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery field for main cod price
        add_settings_field(
            'delivery_pay_price',
            'Τιμή Αντικαταβολής',
            array($this, 'CodPriceCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery field for upper limit price
        add_settings_field(
            'delivery_pay_over_amount',
            'Άνω όριο για δωρεάν αντικαταβολή',
            array($this, 'CodUpperLimitCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery checkbox for greek range activation
        add_settings_field(
            'delivery_range_codcheck',
            'Ενεργοποίηση Κόστους με Διαβαθμίσεις',
            array($this, 'RangeCodCheckCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );

        //Cyprus
        //add pay on delivery checkbox for cyprus different cod
        add_settings_field(
            'delivery_cyprus_codcheck',
            'Ενεργοποίηση Ξεχωριστής Αντικαταβολής Κύπρου',
            array($this, 'CyprusCodCheckCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery main price for cyprus cod
        add_settings_field(
            'delivery_cyprus_pay_price',
            'Τιμή Αντικαταβολής Κύπρου',
            array($this, 'CyprusCodPriceCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery field for cyprus upper limit for free cod
        add_settings_field(
            'delivery_pay_cyprus_over_amount',
            'Άνω όριο για δωρεάν αντικαταβολή στην Κύπρο',
            array($this, 'CyprusCodUpperLimitCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );
        //add pay on delivery checkbox for cyprus range activation
        add_settings_field(
            'delivery_cyprus_range_codcheck',
            'Ενεργοποίηση Διαβάθμισης Κύπρου',
            array($this, 'CyprusRangeCodCheckCallback'),
            'delivery_pay_setting_admin',
            'delivery_pay_base_settings_section'
        );


    }

    public function sanitize($input)
    {
        $new_input = $input;
        return $new_input;
    }

    //title for main section
    public function print_base_section_info()
    {
        print 'Base settings for pay on delivery:';
    }
    //Main Cod Checkbox
    public function CodCheckCallback()
    {
        printf(
            '<label class="switch">
                        <input type="checkbox" id="codcheck" name="delivery_pay_settings[delivery_pay_codcheck]" value="1" %s />
                        <span class="slider round"></span>
                        </label>',
            checked(1, $this->options['delivery_pay_codcheck'], false)
        );
    }
    //Main Cod Input
    public function CodPriceCallback()
    {
        printf(
            '<input type="number" id="price" class="cod_input" name="delivery_pay_settings[delivery_pay_price]" value="%s" />',
            isset($this->options['delivery_pay_price']) ? esc_attr($this->options['delivery_pay_price']) : ''
        );
    }
    //Upper Limit Input
    public function CodUpperLimitCallback(){
        printf(
            '<input type="number" id="upper_limit_price" class="cod_input" name="delivery_pay_settings[delivery_pay_upper_limit_price]" value="%s" />',
            isset($this->options['delivery_pay_upper_limit_price']) ? esc_attr($this->options['delivery_pay_upper_limit_price']) : 0
        );
    }

    //Greek Range Checkbox
    public function RangeCodCheckCallback()
    {
        printf(
            '<div class="range_section">
                         <label class="switch">
                               <input type="checkbox" id="rangecheck" name="delivery_pay_settings[delivery_range_codcheck]" value="1" %s />
                               <span class="slider round"></span>
                         </label>
                    </div>',
            checked(1, $this->options['delivery_range_codcheck'], false)
        );
        ?>
        <div class="range_options_wrapper">
            <?php
            $this->InputsForRangeCod();
            $this->GetRangeList();
            ?>
        </div>
        <?php
    }

    //Cyprus Fields
    //Main Cyprus Cod Checkbox
    public function CyprusCodCheckCallback()
    {
        printf(
            '<label class="switch">
                       <input type="checkbox" id="cyprus_check" name="delivery_pay_settings[delivery_cyprus_codcheck]" value="1" %s />
                        <span class="slider round"></span>
                        </label>',
            checked(1, $this->options['delivery_cyprus_codcheck'], false)
        );
    }

    //Main Cyprus Cod Price
    public function CyprusCodPriceCallback(){
        printf(
            '<input type="number" id="cyprus_price" class="cod_input" name="delivery_pay_settings[delivery_cyprus_pay_price]" value="%s" />',
            isset($this->options['delivery_cyprus_pay_price']) ? esc_attr($this->options['delivery_cyprus_pay_price']) : ''
        );
    }

    //Cyprus Range Checkbox
    public function CyprusRangeCodCheckCallback(){
        printf(
            '<div class="cyprus_range_section">
                       <label class="switch">
                       <input type="checkbox" id="cyprus_rangecheck" name="delivery_pay_settings[delivery_cyprus_range_codcheck]" value="1" %s />
                        <span class="slider round"></span>
                        </label>
                        </div>',
            checked(1, $this->options['delivery_cyprus_range_codcheck'], false)
        );
        ?>
        <div class="cyprus_range_options_wrapper">
            <?php
            $this->InputsForCyprusRangeCod();
            $this->GetCyprusRangeList();
            ?>
        </div>
        <?php
    }
    //Upper Limit Input
    public function CyprusCodUpperLimitCallback(){
        printf(
            '<input type="number" id="cyprus_upper_limit_price" class="cod_input" name="delivery_pay_settings[delivery_pay_cyprus_upper_limit_price]" value="%s" />',
            isset($this->options['delivery_pay_cyprus_upper_limit_price']) ? esc_attr($this->options['delivery_pay_cyprus_upper_limit_price']) : 0
        );
    }

    //Inputs for Greek Range Cod
    private function InputsForRangeCod()
    {
        ?>
        <div class="inputs-for-range-delivery-payment">
            <h3>Πρόσθεσε την διαβάθμιση που θέλεις</h3>
            <div class="inputs-for-range-wrapper">
                <input name="delivery_range_from" type="number" class="cod_input" id="delivery_range_from" placeholder="Από">
                <input name="delivery_range_to" type="number" class="cod_input" id="delivery_range_to" placeholder="Έως">
                <input name="delivery_range_price" type="number" class="cod_input" id="delivery_range_price" placeholder="Τιμή">
                <div id="save_delivery_range_option" class="btn" data-action="save_delivery_range_option">Υποβολή</div>
            </div>
            <p>*Η διαβάθμιση δεν πρέπει να είναι ανάμεσα σε άλλη διαβάθμιση.</p>
        </div>
        <?php
    }

    //Inputs for Cyprus Range Cod
    private function InputsForCyprusRangeCod()
    {
        ?>
        <div class="inputs-for-cyprus-range-delivery-payment">
            <h3>Πρόσθεσε την διαβάθμιση που θέλεις</h3>
            <div class="inputs-for-range-wrapper">
                <input name="delivery_cyprus_range_from" type="number" class="cod_input" id="delivery_cyprus_range_from" placeholder="Από">
                <input name="delivery_cyprus_range_to" type="number" class="cod_input" id="delivery_cyprus_range_to" placeholder="Έως">
                <input name="delivery_cyprus_range_price" type="number" class="cod_input" id="delivery_cyprus_range_price" placeholder="Τιμή">
                <div id="save_delivery_cyprus_range_option" class="btn" data-action="save_delivery_cyprus_range_option">Υποβολή</div>
            </div>

            <p>*Η διαβάθμιση δεν πρέπει να είναι ανάμεσα σε άλλη διαβάθμιση.</p>
        </div>
        <?php
    }

    //Get Greek Range List
    private function GetRangeList()
    {
        $range_list = get_option('delivery_range_values', false);
        ?>
        <div class="delivery-range-list-table">
            <div class="delivery-range-list-wrapper">
                <h3>Διαβαθμίσεις</h3>
                <?php if ($range_list) : ?>
                    <table class="range-list-table cod-table">
                        <tr>
                            <th>Από</th>
                            <th>Εώς</th>
                            <th>Τιμή</th>
                            <th>Διαγραφή</th>
                        </tr>
                        <?php
                        foreach ($range_list as $key => $range):?>
                            <tr>
                                <td><?php echo $range[0] ?></td>
                                <td><?php echo $range[1] ?></td>
                                <td><?php echo $range[2] ?></td>
                                <td>
                                    <div id="delete_range_option" class="delete_range_option btn"
                                         data-pickup_no="<?php echo $key ?>">Διαγραφή
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <div class="no_range_list">
                        <p>Δεν έχουν προστεθεί διαβαθμίσεις ακόμα</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    //Get Cyprus Range List
    private function GetCyprusRangeList()
    {
        $cyprus_range_list = get_option('delivery_cyprus_range_values', false);
        ?>
        <div class="delivery-cyprus-range-list-table">
            <div class="delivery-cyprus-range-list-wrapper">
                <h3>Διαβαθμίσεις</h3>
                <?php if ($cyprus_range_list) : ?>
                    <table class="cyprus-range-list-table cod-table">
                        <tr>
                            <th>Από</th>
                            <th>Εώς</th>
                            <th>Τιμή</th>
                            <th>Διαγραφή</th>
                        </tr>
                        <?php
                        foreach ($cyprus_range_list as $key => $range):?>
                            <tr>
                                <td><?php echo $range[0] ?></td>
                                <td><?php echo $range[1] ?></td>
                                <td><?php echo $range[2] ?></td>
                                <td>
                                    <div id="delete_range_option" class="delete_cyprus_range_option btn"
                                         data-pickup_no="<?php echo $key ?>">Διαγραφή
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <div class="no_range_list">
                        <p>Δεν έχουν προστεθεί διαβαθμίσεις ακόμα</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

}

