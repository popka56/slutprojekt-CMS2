//Hämta datan från formuläret i frontend
function submit_form(){
    fd = new FormData();
    fd.append('formWasSubmitted', '1');
    fd.append('email', jQuery("#email").val());
    //Skicka vidare till ajax/jquery
    js_submit(fd, form_callback);
}

//När ajax blivit klar skicikar vi responsen tillbaka till frontend
function form_callback(data){
    jData = JSON.parse(data);

    if(jData.success == 1){
        jQuery('#response').html(jData.message);
        jQuery('#response').css('color', 'green');
    }
    else{
        jQuery('#response').html(jData.message);
        jQuery('#response').css('color', 'red');
    }
}

//Ajax grejs, sanering sker i process.php
function js_submit(fd, callback){
    submitUrl = '../wp-content/plugins/betalnings-plugin/process.php';
    jQuery.ajax({url: submitUrl, type:'post', data: fd, contentType: false, processData: false, success: function(response){callback(response);}, error: function(response){callback(response)}});
}