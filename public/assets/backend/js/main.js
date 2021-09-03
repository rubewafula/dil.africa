/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var BASE_URL = 'http://localhost:82/dil/public/';

    //    alert("JQuery Loaded");

    function addToCart(product_id, quantity) {

        var filedata = new FormData();
        alert("Function Called");
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

                return output.status;
            }
        });
    }


});
