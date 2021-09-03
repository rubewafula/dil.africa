<script>

$(document).ready(function(){

    $('.product .product-image img').css({
        
        left: ($(window).width() - $('.product .product-image img').outerWidth())/2,
        top: ($(window).height() - $('.product .product-image img').outerHeight())/2
    });


    // To initially run the function:
    $(window).resize();
    
    $("#pickup_station_div").hide();
    
    @php(Session::put('user_address_id', ""))
    @php(Session::put('delivery_type', 'home_office_delivery'))
    @php($userId = Session::get('userId'))
    @if($userId != null)
    @php($user_address = \Modules\Customer\Entities\User_address::where('user_id',$userId)
                    ->where('default', 1)->first())
    @if($user_address != null)
    @php(Session::put('user_address_id', $user_address->id))
    @endif
    @endif
    
    $("#selection_message").html("'Delivery Address' is selected by default.\n\
             You can change this if you wish to pick up your goods from one of \n\
                our pickup stations.");
        
    var BASE_URL = "{{url('/shop/')}}";
    
    $(".country-select").change(function(){
        
        var country_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('country', country_id);
        $.ajax({
            url: BASE_URL + "/cities",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {
                    
                    $(".city-select").html(output.html);                              
                }
            }
        });
        
    });
    
    
    $(".city-select").change(function(){
        
        var city_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('city', city_id);
        $.ajax({
            url: BASE_URL + "/city/areas",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {
                    
                    $(".area-select").html(output.html);                               
                }
            }
        });
        
    });
    
    
    $(".zone-select").change(function(){
        
        var zone_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('zone', zone_id);
        $.ajax({
            url: BASE_URL + "/areas",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {

                    $(".area-select").html(output.html);                              
                }
            }
        });
        
    });
});

</script>

<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <a href="{{url('/')}}">

                            <img class="hidden-xs hidden-sm" src="{{url('assets/images/logo.png')}}" alt="">

                            <img class="hidden-md hidden-lg" style="width: 117px;margin-top: 8px" src="{{url('assets/images/logo.png')}}" alt="">

                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->				
                    </div><!-- /.logo-holder -->

                    <div class="col-md-8" style="margin-top: 15px;font-size: 18px;text-align: right;padding-right: 30px;">

                        Having Trouble Completing your Order? Call us for assistance on <span style="font-weight: bold;color: #FFA200">0797 522522</span>
            
                    </div><!-- /.container -->

            </div><!-- /.row -->

        </div><!-- /.container -->

    </div><!-- /.main-header -->

</header>