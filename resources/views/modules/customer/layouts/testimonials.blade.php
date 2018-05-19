<div id="advertisement" class="advertisement">
    @php($testimonial = new \Modules\Customer\Entities\Testimonial())
    @php($testimonials = $testimonial->getTestimonials())
    
    @foreach($testimonials as $t)
    <div class="item">
        <div class="avatar"><img src="{{url('assets/images/testimonials/'.$t->image_url)}}" alt="Image"></div>
        <div class="testimonials"><em>"</em> {{$t->message}} <em>"</em></div>
        <div class="clients_author">{{$t->name}}	
            <span>{{$t->organization}}</span>	
        </div><!-- /.container-fluid -->
    </div><!-- /.item -->
    @endforeach

</div><!-- /.owl-carousel -->