jQuery(document).ready(function($){
    
    $('.tab-btn').click(function(e){
       
       id = $(this).attr('id');
       
       $('.tabs-menu button').removeClass('current');
       $(this).parent('button').addClass('current');
       
       $.ajax({
            type:'post',
            url : mugu_ajax.url, 
            data: {  'action' : 'mugu_cat_ajax', 'id' : id },          
            beforeSend: function(){
                $('#loader').fadeIn(500);
            },
            success: function(response){
                $('.article-holder').html(response);
            },
            complete: function(){
                $('.post-section .post').matchHeight();
                $('#loader').fadeOut(500);             
            }            
        });
      
        
    });    
    
});
