<?php 

//if(isset($_POST['submit'])) {    
  error_log('hit it');
   $errors = array();
   $data = array();
   $success = null;
   $headers = array(
        'From' => 'lib-noreply@ou.edu'
   );
   
//   $required_fields['cf_name'] = 'You are required to enter your Name.';
//   $required_fields['cf_email'] = 'You are required to enter your E-mail Address.';
//  $required_fields['cf_subject'] = 'You are required to enter a Subject.';
//   $required_fields['cf_message'] = 'You are required to enter a Message.';
                   
//   foreach($_POST as $key => $value) {
//      if(array_key_exists($key, $required_fields)) {
//         if(trim($_POST[$key]) === '') {
//             $errors[$key] = $required_fields[$key];
//          }
//       }
//    }

    if (empty($_POST['cf_name']))
        $errors['name'] = 'Name is required.';
    if (empty($_POST['cf_email']))
        $errors['email'] = 'Email is required.';
    if (empty($_POST['cf_message']))
        $errors['message'] = 'A Message is required.';
    if (empty($_POST['cf_subject']))
        $errors['subject'] = 'A Subject is required.';

    if(empty($errors)) {
         $to = "timsmith@ou.edu";
         $subject = $_POST['cf_subject'];
         $name_field = $_POST['cf_name'];
         $email_field = $_POST['cf_email'];
         $message = $_POST['cf_message'];
        
         $body = "From: $name_field\n E-Mail: $email_field\n Message:\n $message";
         $success = mail($to, $subject, $body, $headers);

         $data['success'] = true;
         $data['message'] = 'Thank you! Your message has been sent.';
    }
    
//    if($success) {
//              echo "<p><strong>Thank you for getting in touch. Expect to hear back from us soon.</strong></p>";
//         } else {
//              echo "<strong>Error sending email! </strong>";
//         }
//    }
    if(!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } 

echo json_encode($data);
?>
 
