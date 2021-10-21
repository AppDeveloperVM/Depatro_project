function Login(email,passwd){
    var Ruta ="/login";
    // pass auth vars to Security (Login) Controller

    //get form values

    /*
    var email = $('#email').val();
    var passwd = $('#passwd').val();
    */
    //({email: email,passwd: passwd}

    $.ajax({
         type: 'POST',
         url: Ruta,
         data: $("#login_form").serialize(),
         async: true,
         dataType:"json",
         success: function(data, status) {  
            //success example, modify template info
            //$('..').append(e); $('#..').html('');

            //$('#login_info').html(data);  // data.username , data.passwd               
            alert('Ajax login request!');
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert('Ajax login request failed.');  
         }  
     });
}