<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <section id="contact">
        <div class="container">
            <div>
                <h2>Contact <br>OU Libraries</h2>
                <p>
                    <strong>OU University Libraries</strong><br>
                    401 W. Brooks St. Norman, OK 73019<br>
                    (405) 325-4142
                </p>
            </div>
            <div>
                <form id="contactsubmit" action="/models/contactsubmission.php" method="post" >
                    <div id="name-group" class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="cf_name" />
                    </div>
                    <div id="email-group" class="form-group">
                        <label>Email</label>
                        <input type="text" name="cf_email"/>
                    </div>
                    <div id="subject-group" class="form-group">
                        <label>Subject</label>
                        <input type="text" name="cf_subject"/>
                    </div>
                    <div id="message-group" class="form-group">
                        <label>Message</label>
                        <textarea name="cf_message"></textarea>
                    </div>
                  <!--  <a href="#" class="btn" name="submit" id="contact-submit" data-submit="...Sending">Make a Gift</a>
-->  
                   <button class="btn" type="submit" name="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                 </form>
               <div id="results" class="hide-message">You're message has been sent!</div>
            </div>
        </div>
    </section>

<script>
$(document).ready(function(){
 $("input").focus(function(){
  $("#results").hide();
});
});

$("#contactsubmit").submit(function(event){

    $('.form-group').removeClass('has-error');
    $('.help-block').remove();

    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data,
        dataType: 'json',
        encode: true
    }).done(function(data){ //
console.log(data)
console.log(data.success);

       if(! data.success){
         console.log('nope');
         if(data.errors.name){
           $('#name-group').addClass('has-error');
           $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>');
       }
         if(data.errors.email){
           $('#email-group').addClass('has-error');
           $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
       }
         if(data.errors.subject){
           $('#subject-group').addClass('has-error');
           $('#subject-group').append('<div class="help-block">' + data.errors.subject + '</div>');
       }
         if(data.errors.subject){
           $('#message-group').addClass('has-error');
           $('#message-group').append('<div class="help-block">' + data.errors.message + '</div>');
       }
         
}
       else {
         console.log(data.message);
       //  $('form').append('<div class="alert alert-success success-message">' + data.message + '</div>');
         $('#contactsubmit')[0].reset();
         resultsShow();
}

    });
});

function resultsShow() {
  $('#results').show();
}

</script>

