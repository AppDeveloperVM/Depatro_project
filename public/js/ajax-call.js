function Login(){
    $.ajax({
         type: 'POST',
         url: Ruta,
         data: ({id: id}),
         async: true,
         dataType:"json",
         success: function (data){
 
         }
     });
}