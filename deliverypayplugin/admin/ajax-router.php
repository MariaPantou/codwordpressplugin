<?php


function find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    do {
        if (file_exists($dir . "/wp-config.php")) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));

    return null;
}

function load_wp()
{
    define('BASE_PATH', find_wordpress_base_path() . "/");
    define('WP_USE_THEMES', false);
    global $wp;
    require(BASE_PATH . 'wp-load.php');
}


include_once 'deliveryPayAdmin_class.php';


if (!isset($_POST['action'])) die();

load_wp();


$data = [
    'status' => false
];

switch ($_POST['action']) {

    case 'save_pay_range_options':
    {

        $delivery_range_from = isset($_POST['delivery_range_from']) ? filter_var($_POST['delivery_range_from'], FILTER_SANITIZE_NUMBER_INT) : null;
        $delivery_range_to = isset($_POST['delivery_range_to']) ? filter_var($_POST['delivery_range_to'], FILTER_SANITIZE_NUMBER_INT) : null;
        $delivery_range_price = isset($_POST['delivery_range_price']) ? filter_var($_POST['delivery_range_price'], FILTER_SANITIZE_NUMBER_INT) : null;

        //check if values are empty
        if (!$delivery_range_from || !$delivery_range_to || !$delivery_range_price) {
            $data = [
                'status' => false
            ];
            break;
        }

        //save inputs
        $delivery_pay_admin = new DeliveryPayAdmin();
        $updated = $delivery_pay_admin->SaveRangeInputs($delivery_range_from,$delivery_range_to,$delivery_range_price);


        if($updated){
        $data = [
            'status' => true
        ];
        break;
        }

        break;
    }
    case 'save_pay_cyprus_range_options':
    {


        $delivery_cyprus_range_from = isset($_POST['delivery_cyprus_range_from']) ? filter_var($_POST['delivery_cyprus_range_from'], FILTER_SANITIZE_NUMBER_INT) : null;
        $delivery_cyprus_range_to = isset($_POST['delivery_cyprus_range_to']) ? filter_var($_POST['delivery_cyprus_range_to'], FILTER_SANITIZE_NUMBER_INT) : null;
        $delivery_cyprus_range_price = isset($_POST['delivery_cyprus_range_price']) ? filter_var($_POST['delivery_cyprus_range_price'], FILTER_SANITIZE_NUMBER_INT) : null;

        //check if values are empty
        if (!$delivery_cyprus_range_from || !$delivery_cyprus_range_to || !$delivery_cyprus_range_price) {
            $data = [
                'status' => false
            ];
            break;
        }

        //save inputs
        $delivery_pay_admin = new DeliveryPayAdmin();
        $updated = $delivery_pay_admin->SaveCyprusRangeInputs($delivery_cyprus_range_from,$delivery_cyprus_range_to,$delivery_cyprus_range_price);


        if($updated){
            $data = [
                'status' => true
            ];
            break;
        }

        break;
    }
    case "delete_range_option":
    {

        $range_no = isset($_POST['range_no']) ? filter_var($_POST['range_no'], FILTER_SANITIZE_NUMBER_INT) : null;

        if(!$range_no && $range_no!=0){
            $data = [
                'status' => false
            ];
            break;
        }

        $delivery_pay_admin = new DeliveryPayAdmin();

        $delete_range = $delivery_pay_admin->DeleteRange($range_no);


        $data = [
            'status' => $delete_range
        ];

        break;

    }
    case "delete_cyprus_range_option":
        {

            $cyprus_range_no = isset($_POST['cyprus_range_no']) ? filter_var($_POST['cyprus_range_no'], FILTER_SANITIZE_NUMBER_INT) : null;

            if(!$cyprus_range_no && $cyprus_range_no!=0){
                $data = [
                    'status' => false
                ];
                break;
            }

            $delivery_pay_admin = new DeliveryPayAdmin();

            $delete_range = $delivery_pay_admin->DeleteCyprusRange($cyprus_range_no);



            $data = [
                'status' => $delete_range
            ];

            break;

        }


}

echo json_encode($data);

die();


