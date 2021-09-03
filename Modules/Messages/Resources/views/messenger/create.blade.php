@extends('messages::layouts.message_master')

@section('content')
    <h1>New Message</h1>
    <form action="{{ route('messages.store') }}" method="post">
        {{ csrf_field() }}
        <div class="col-md-9">
            <!-- Subject Form Input -->
            <div class="form-group">
                <label class="control-label">Subject</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject"
                       value="{{ old('subject') }}">
            </div>

            <!-- Message Form Input -->
            <div class="form-group">
                <label class="control-label">Message</label>
                <textarea name="message" class="form-control">{{ old('message') }}</textarea>
            </div>

       
        <?php  $user=  App\User::find(Auth::user()->id) ?>

           @if($user->hasRole('admin'))

          <?php  $users= App\User::where('active',1)->get(); ?>
           <div class="form-group">
               <label>  Select  User</label>
               <select  name="recipients[]" class="form-control">
                   @foreach($users  as $user)

                <option  value="{{$user->id}}">{{$user->full_name}}</option>
                   @endforeach

               </select>

           </div>

           @endif


    

    
            <!-- Submit Form Input -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </div>
        </div>
    </form>
@stop
