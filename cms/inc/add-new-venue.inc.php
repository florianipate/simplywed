<?php
    function randomString($lenght){
        $chars = "0123456789012345678901234567890123456789";
        srand ((double)microtime()* 1000000);
        $str ="";
        $i =1;
            while($i <= $lenght){
                $num = rand() %33;
                $tmp = substr($chars, $num, 1);
                $str = $str . $tmp;
                $i++;
        }
    return $str;
    }
        if(Input::exists()){
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'venue_name' => array(
                    'name' => 'Venue Name',
                    'required' => true,
                    'min' => 3,
                    'max' =>50
                ),
                'address_line_1' => array(
                    'name'=> 'First line of addres is require' ,
                    'required'=> true,
                    'min' => 3,
                    'max' =>50
                ),
                'town_city' => array(
                    'name'=> 'Town or City',
                    'required'=> true,
                    'min' => 3,
                    'max' =>50
                ),
                'county' => array(
                    'name' => 'County',
                    'required' => true,
                    'min' => 2,
                    'max' =>20
                ),
                'postcode' => array(
                    'name' => 'Postcode',
                    'required' => true,
                    'min' => 2,
                    'max' =>11
                ),
                'venue_email' => array(
                    'name' => 'Email',
                    'min' => 3,
                    'max' =>50
                    
                ),
                'venue_description' =>array(
                    'name' => 'Venue Description',
                    'required' => true,
                    'min' => 2,
                    'max' =>1000
                )
            ));
            if($validation->passed()){
                $venue_ref = 'V'. randomString(rand(5, 5));
                $venues_info = DB::getInstance()->get('cms_venue_details', array('id', '>', 0));
                foreach($venues_info->results() as $venue_info){
                    if($venue_ref === $venue_info->venue_ref){
                        $venue_ref = 'V'. randomString(rand(5, 5));
                    } else {
                       Session::put('venue_ref', $venue_ref); 
                    }
                }
                Session::put('venue_name', escape(Input::get('venue_name')));
                Session::put('address_line_1', escape(Input::get('address_line_1')));
                Session::put('address_line_2', escape(Input::get('address_line_2')));
                Session::put('address_line_3', escape(Input::get('address_line_3')));
                Session::put('town_city', escape(Input::get('town_city')));
                Session::put('county', escape(Input::get('county')));
                Session::put('postcode', escape(Input::get('postcode')));
                Session::put('venue_email', escape(Input::get('venue_email')));
                Session::put('venue_description', escape(Input::get('venue_description')));
                Redirect::to('preview-venue-info.php');
            }
             else {                   
                foreach($validation->errors() as $error){
                echo '<span style="color:#f00">'. $error. '</span><br>';
                }
            }
        }

?>