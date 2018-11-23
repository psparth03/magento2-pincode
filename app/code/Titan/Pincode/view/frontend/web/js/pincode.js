// define([
//         "jquery"
//     ],
//     function($) {
//
//
//             $('#sub_button').click(function () {
//                 var pin_number = $('#pin_number').val();
//                 var url = $('#baseUrl').val();
//
//                 $.ajax({
//                     url: url + 'pincode/index/zipcode',
//                     type: "POST",
//                     dataType: 'json',
//                     data: {pin_number: pin_number},
//                     success: function (data) {
//                         console.log(data);
//                         if (data.status == 'success') {
//                             if (data.response.pincode == pin_number && data.response.status == 1) {
//                                 $('#message').html('Delivery available');
//                                 if (data.response.cod == 1) {
//                                     $('#cod_status').html('&#10004;COD available');
//                                 } else if (data.response.cod == 0) {
//                                     $('#cod_status').html('&#10008;COD not available');
//                                 }
//                             } else {
//                                 $('#message').html('Delivery not available');
//                                 if (data.response.cod == 1) {
//                                     $('#cod_status').html('&#10004;COD available');
//                                 } else if (data.response.cod == 0) {
//                                     $('#cod_status').html('&#10008;COD not available');
//                                 }
//                             }
//                         } else {
//                             $('#message').html('This pincode is not registered with us');
//                             $('#cod_status').hide();
//                         }
//                     }
//                 });
//
//             });
//     });
//
