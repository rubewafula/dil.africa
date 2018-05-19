<form  method="POST" action="{{url('create_brand')}}">

	{{csrf_field()}}

	<input type="text" name="name">

	<input type="submit" name="submit">

</form>