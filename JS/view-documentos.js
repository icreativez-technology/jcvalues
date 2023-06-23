$(document).ready(function() {
    $('.view').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parent().parent().attr('id');
        var item = $(this).attr('data');
 
        var dataString = 'item='+item;
 
        $.ajax({
            type: "POST",
            url: "documentation_view_file.php",
            data: dataString,
            success: function(response) {			
                $('.alert-success').empty();
                $('.alert-success').append(response).fadeIn("slow");
                $('#'+parent).fadeOut("slow");
            }
        });
    });                 
}); 


   