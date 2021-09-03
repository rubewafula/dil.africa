/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    var BASE_URL = 'http://localhost:82/dil/public/shop/';
    
    $("#successdialog").hide();
    $("#failuredialog").hide();
    
    function addToCart(product_id, quantity) {
        
        var filedata = new FormData();
        filedata.append('product_ref', product_id);
        filedata.append('quantity', quantity);

        $.ajax({url: BASE_URL + "add_to_cart",
            data: filedata,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if(output.status == 200){
                    
                    $('#successdialog').html("<p>Item added to cart \n\
                        successfully.</p>");

                    $('#successdialog').dialog({
                        modal: true,
                        width: 400,
                        close: function (ui, event) {
                            $(this).dialog('close');
                        },
                        buttons: {
                            Ok: function () {
                                $(this).dialog('close');
                            }
                        }
                    });
                }
            }
        });
    }

    $('input[type=radio][name=checkout_option]').change(function() {

        var selected = $(this).val();
        
        if(selected == "guest"){
             
        }else if(selected == "register"){
                   
        }
        
    });
    
    $('#checkout_continue').click(function() {
       
        var selected = $("input[type=radio][name='checkout_option']:checked").val();
        
        if(selected == "guest"){
            
            window.location.replace(BASE_URL+"checkout/guest");
            
        }else if(selected == "register"){
            
           window.location.replace(BASE_URL+"register");          
        }
    });
    
});