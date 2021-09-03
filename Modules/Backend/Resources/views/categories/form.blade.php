<script type="text/javascript">
    
    $(document).ready(function(){

    //var level =  $("")
    check_popular();

    $("#level").change(function(){

      populate_depends();
      check_popular();

    });


    function  check_popular()
    {

      var  level = $("#level").val();

      if(level =='1')
      {
        $(".popular").show();

      } else{

        $(".popular").hide();

      }

    }


    function populate_depends()
    {

      var  level = $("#level").val();

      $.ajax({
        url:"{{url('backend/load_categories')}}",
        type:"GET",
        data:{level:level},
        success:function(data){

            $("#depends_on").empty();
             if(data.length > 0)
             {
         $.each(data,function(index){

            $("#depends_on").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option');  
                     
          });
     

             }else{
                  $("#depends_on").append('<option  value="">Not  Applicable</option');  

             }

        }


      });

    }


    });


</script>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $category->name or ''}}" required>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Icon' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="icon" type="text" id="icon" value="{{ $category->icon or ''}}" >
        {!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
    </div>
</div>
 @if(!empty($category->cover_photo))
  <div class="col-md-4">
  </div>

  <div class="col-md-6">
<img src="{{ asset($category->cover_photo) }}" width="500px"/>
</div>

 @endif


<div class="form-group {{ $errors->has('cover_photo') ? 'has-error' : ''}}">
    <label for="cover_photo" class="col-md-4 control-label">{{ 'Cover Photo' }}</label>
    <div class="col-md-6">
        <input class="" name="cover_photo" type="file" id="cover_photo" value="{{ $category->cover_photo or ''}}" >
        {!! $errors->first('cover_photo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ $category->description or ''}}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div  class="form-group">
    <label class="col-md-4 control-label"> level </label>
    <?php $levels=['1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five']; ?>

        <div class="col-md-6">
      {{Form::select('level',$levels,$category->level,['class'=>'form-control','id'=>'level'])}}
</div>

</div>

<div  class="form-group {{ $errors->has('depends_on') ? 'has-error' : ''}}">
        <label class="col-md-4 control-label">  Parent  Category </label>
                <div class="col-md-6">

 @php($all_categories = \App\Category::pluck('name', 'id'))
 {{Form::select('depends_on',$all_categories ,$category->depends_on, ['class'=>'form-control','id'=>'depends_on'])}}

</div>
</div>

<div class="form-group {{ $errors->has('percent_commission') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Percentage  Commission(%)' }}</label>
    <div class="col-md-6">
             <input class="form-control" name="percent_commission" type="text" id="name" value="{{ $category->percent_commission or ''}}" >
        {!! $errors->first('percent_commission', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div  class="form-group popular">
    <label class="col-md-4 control-label"> Popular </label>
    <?php $populars =[''=>'Select','1'=>'YES','0'=>'No']; ?>

        <div class="col-md-6">
      {{Form::select('is_popular',$populars,null,['class'=>'form-control'])}}
</div>

</div>

<div  class="form-group ">
    <label class="col-md-4 control-label"> Level Two  category </label>
    <?php $two_levels = App\Category::where('level',2)->pluck('name','id')->prepend('Select',''); ?>

        <div class="col-md-6">
      {{Form::select('level_two_category',$two_levels,null,['class'=>'form-control','id'=>'level_two_category'])}}
</div>

</div>



<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
