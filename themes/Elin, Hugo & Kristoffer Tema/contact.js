//Kontaktformulär
function submit_form(){
    fd = new FormData();
    fd.append('formWasSubmitted', '1');
    fd.append('title', jQuery("#title").val());
    fd.append('name', jQuery("#name").val());
    fd.append('email', jQuery("#email").val());
    fd.append('message', jQuery("#message").val());
    fd.append('file', jQuery("#myfile").val());
    js_submit(fd, form_callback);
}

//Skicka till process.php
function js_submit(fd, callback){
    submitUrl = '../wp-content/themes/Elin, Hugo & Kristoffer Tema/process.php';
    jQuery.ajax({url: submitUrl, type:'post', data: fd, contentType: false, processData: false, success: function(response){callback(response);}, error: function(response){callback(response)}});
}

//Ge svar på frontend
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