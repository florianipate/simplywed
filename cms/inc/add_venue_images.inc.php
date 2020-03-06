<?php 
    if(isset($_POST['add_image'])){
        
//      COUNT TOTAL OF FILES FOR UPLOADING
     $countfiles = count($_FILES['file']['name']);

//     LOOPING ALL FILES AND INSERT DATA TO THE DTABASE
     for($i=0;$i<$countfiles;$i++){
        $filename = $_FILES['file']['name'][$i];
         if($filename !=''){
     
            $add_bookings = DB::getInstance();
            try{
                $add_bookings->insert('cms_venue_images', array(
                    'venue_ref'       =>    $venue_ref,
                    'image_path'     =>     $filename  
                ));
                move_uploaded_file($_FILES['file']['tmp_name'][$i],'../images/venues/large_test/'.$filename);
                } catch(Exception $e) {
                die($e->getMessage());
                }
         }else {
             echo '<div class="col-12 cms-bg-danger p3">
                    <h5 class="text-danger">You must choose an image file first then click the upload buton</h5>
                 </div>';
         }
         
         } 
    } 

//    GET IMAGES FROM THE DATABASE
    $venue_images = DB::getInstance()->get('cms_venue_images', array('venue_ref', '=', $venue_ref));
    if(!$venue_images->count()){
        echo '<div class="col cms-bg-danger p3 mb-4"><h4 class="text-danger"> No image has been added for this venue</h4></div>';
    } else {
        foreach($venue_images->results() as $image){
            echo '<div class="col-3 py-3">
            <img src="../images/venues/large_test/'.$image->image_path.'" style="max-height:100px;">
            <div class="text-center"><a href ="delete_image.php?id='.$image->id.'">Delete</a></div>
            </div>';
        }
    }
?>