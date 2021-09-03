<div class="container">
    @if(Session::has('flash_message'))
    <div class="alert {{ Session::get('alert-class', 'alert-success') }} 
         alert-dismissable mess" style="margin: 15px 0px 0px 0px;background: #F3F3F3;border-color: #3c763d;padding: 10px 30px 24px 10px;">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        {{ Session::get('flash_message') }}
    </div>
    @endif

    @if(Session::has('flash_message_error'))
    <div class="alert {{ Session::get('alert-class', 'alert-danger') }} 
         alert-dismissable mess" style="margin: 15px 0px 0px 0px;background: #F3F3F3;border-color: #cc0000;padding: 10px 30px 24px 10px;">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        {{ Session::get('flash_message_error') }}
    </div>
    @endif

    @if(isset($errors))
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissable mess" style="margin: 15px 0px 0px 0px;background: #F3F3F3;border-color: #cc0000;padding: 10px 30px 24px 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    @endif
</div>
<!--<div class="row">
<div class="col-sm-12">

</div>
</div>-->