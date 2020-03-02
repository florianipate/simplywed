        
<!--       ==================== Register the user =================-->
<?php
    $user = new User();
    if($user->isLoggedIn()){
    $user->logout();
    Redirect::to('register.php');
    } else{
        if(Input::exists()){
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'f_name' => array(
                'name' => 'First Name',
                'required' => true,
                'min' => 3,
                'max' =>20
                ),
                'l_name' => array(
                'name'=> 'Last Name',
                'required'=> true,
                'min' => 3,
                'max' =>20
                ),
                'username' => array(
                'name'=> 'Email',
                'required'=> true,
                'min' => 3,
                'max' =>50,
                'unique' => 'cms_user'
                ),
                'user_pass' => array(
                'name' => 'Password',
                'required' => true,
                'min' => 6,
                'max' =>20
                ),
                'user_pass_again' => array(
                'name' => 'Password Again',
                'required' => true,
                'matches' => 'user_pass'
                )
                // ,
                // 'contact_no' => array(
                // 'name' => 'Your Contact Number',
                // 'required' => true
                    
                // )
            ));
            if($validation->passed()){
//                $email_check = DB::getInstance()->get('cms_user', array('username', '=', Input::get('user_email')));
//            if($email_check->count()){
//                Session::flash('email_check', '<span style="color:#f00"><p>You all ready have an account. Please use this form to login.</span> ');
                Redirect::to('../index.php');
//            }else{
                $salt = Hash::salt(32);
//                die();
                $user = new User();
                try{
                   $user->create(array(
                       'f_name'     =>Input::get('f_name'),
                       'l_name'     =>Input::get('l_name'),
                       'username' =>Input::get('user_email'),
                       'contact_no' =>Input::get('contact_no'),
                       'user_pass' => password_hash(Input::get('user_pass'), PASSWORD_BCRYPT), 
                       'user_group_id'  => 1
                        )); 
                    Redirect::to('index.php');
                } catch(Exception $e) {
                    die($e->getMessage());
                }
                
            }
             else {  
                 ?><h1 class="text-danger">Errors:</h1><?php                 
                foreach($validation->errors() as $error){
                echo '<span style="color:#f00">'. $error. '</span><br>';
                }
            }
        }
    }
        
?>
<!--       ========================================================-->
        
