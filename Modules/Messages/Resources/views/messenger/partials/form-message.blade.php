

<h2>Add a new message</h2>
 <p>Reply To : {{ $thread->participantsString(Auth::id(),['first_name','last_name']) }}</p>
<form action="{{ route('messages.update', $thread->id) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
        
    <!-- Message Form Input -->
    <div class="form-group">
        <textarea name="message" class="form-control">{{ old('message') }}</textarea>
    </div>

    @if($users->count() > 0)


     <!--    <div class="checkbox">
            @foreach($users as $user)
                <label title="{{ $user->name }}">
                    <input type="checkbox" name="recipients[]" value="{{ $user->id }}">{{ $user->name }}
                </label>
            @endforeach
        </div> -->

        <div  class="form-group">
            


        </div>



    @endif

    <!-- Submit Form Input -->
    <div class="form-group">
        <input type="submit" class="btn btn-success form-control"  value="Send">
    </div>
</form>