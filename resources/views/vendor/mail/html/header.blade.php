<tr>
    <td class="header" style="background: #0f7dc2;">

        <div class="col-md-4">
            <a href="{{url('/shop')}}">
                <img src="{{asset('assets/images/logo.png')}}" alt="DIL.Africa">
            </a>
        </div>
        <div class="col-md-8">
            <a href="{{ $url }}" style="color: #FFF;">
                {{ $slot }}. <span style="font-style: italic;font-size: 13px;color: #F89530;">Convenient. Magical Online Experience! </span>
            </a>
        </div>      
    </td>
</tr>