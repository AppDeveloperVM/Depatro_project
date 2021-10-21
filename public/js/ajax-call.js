function Login(email,passwd){
    var Ruta ="/login";

    // pass auth vars to Security (Login) Controller

    $.ajax({
         type: 'POST',
         url: Ruta,
         data: ({email: email,passwd: passwd}),
         async: true,
         dataType:"json",

         /*success: function (data){
            //Login succesful, reload vars
         }*/
         success: function(data, status) {  
            //success example, modify template info

            //$('..').append(e); $('#..').html('');
             
            $('#login_info').html(data);  // data.username , data.passwd 
             
            
            
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert('Ajax login request failed.');  
         }  
     });
}