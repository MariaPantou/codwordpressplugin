<?php
class DeliveryPayAdmin
{


    function __construct()
    {

    }

    //save inputs for range delivery payment to options
    public function SaveRangeInputs($from_input,$to_input,$price_input){

        $arr_inputs = array($from_input, $to_input, $price_input);

        $range_table = get_option('delivery_range_values',false);

        //if not exist create the array
        if(!$range_table){
            $range_table=array();
        }else{
            //check if range input are correct to be added in range table
            if(!$this->CheckRangeInputs($range_table,$from_input,$to_input)){
                return false;
            }
        }

        array_push($range_table,$arr_inputs);
        $updated = update_option('delivery_range_values',$range_table);

        return $updated;

    }

    //save inputs for cyprus range delivery payment to options
    public function SaveCyprusRangeInputs($from_input,$to_input,$price_input){

        $arr_inputs = array($from_input, $to_input, $price_input);

        $cyprus_range_table = get_option('delivery_cyprus_range_values',false);

        //if not exist create the array
        if(!$cyprus_range_table){
            $cyprus_range_table=array();
        }else{
            //check if range input are correct to be added in range table
            if(!$this->CheckRangeInputs($cyprus_range_table,$from_input,$to_input)){
                return false;
            }
        }

        array_push($cyprus_range_table,$arr_inputs);
        $updated = update_option('delivery_cyprus_range_values',$cyprus_range_table);

        return $updated;

    }

    private function CheckRangeInputs($range_table,$from_input,$to_input){
        foreach($range_table as $range){

            if((($range[0] <= $from_input) && ($from_input < $range[1])) || ($range[0] <= $to_input) && ($to_input < $range[1])){
                return false;
            }

        }
        return true;
    }

    //delete range option from option input
    public function DeleteRange($rowNumber){

        //get range table
        $range_table = get_option('delivery_range_values',false);


        //if not exist create the array
        if(!$range_table){
            return false;
        }

        unset($range_table[$rowNumber]);

        $updated = update_option('delivery_range_values',$range_table);


        return $updated;

    }

    //delete range option from option input
    public function DeleteCyprusRange($rowNumber){

        //get range table
        $range_table = get_option('delivery_cyprus_range_values',false);


        //if not exist create the array
        if(!$range_table){
            return false;
        }

        unset($range_table[$rowNumber]);


        $updated = update_option('delivery_cyprus_range_values',$range_table);


        return $updated;

    }


}

