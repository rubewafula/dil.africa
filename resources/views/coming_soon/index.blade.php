<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 

<title>DIL.AFRICA | Africa's Online  Retailer </title> 

<link rel="stylesheet" href="{{asset('coming_soon/style.css')}}" type="text/css" media="screen">

<script type="text/javascript" src="{{asset('coming_soon/js/jquery-1.7.min.js')}}"></script>
<script type="text/javascript" src="{{asset('coming_soon/js/jquery.countdown.js')}}"></script>
<script type="text/javascript" src="{{asset('coming_soon/js/jquery.tipsy.js')}}"></script>
<script type="text/javascript" src="{{asset('coming_soon/js/jquery.subscribe.js')}}"></script>
<script type="text/javascript" src="{{asset('coming_soon/js/jquery.contact.js')}}"></script>
<script type="text/javascript" src="{{asset('coming_soon/js/custom.js')}}"></script>

</head> 
 
<body> 
	<div id="wrapper">
		<header>
			<a class="logo" href="{{asset('/')}}"><img src="{{asset('assets/images/logo.png')}}" alt="logo" title="logo" /></a>
		</header>
		
		<div id="book">		
		
<!-- 			<div id="ribbon" class="contact">click me to reveal the contact form</div>		
 -->			<div class="top-page"></div>
			
			<div class="content-page">
				<div class="top-spiral"></div>
				<div class="bottom-spiral"></div>
				
			
				<div id="home">
					<div class="row">
						

					</div>
					<h2> Something  new  is  coming !!</h2>					
					<div class="row">
						<div  class="col-md-12">
							 @if(Session::has('flash_message'))
    <div class="alert {{ Session::get('alert-class', 'alert-success') }} 
         alert-dismissable mess" style="margin: 5px 0px 0px 0px;background: #F3F3F3;border-color: #3c763d;padding: 10px 30px 24px 10px;padding-left: 100px;color:blue;font-size:16px">

        {{ Session::get('flash_message') }}
    </div>
    @endif
						</div>
					</div>
					<div class="row"></div>
					
					<div class="clear"></div>
					<div class="row"></div>
					<div class="form-wrapper email-list">
					<h3> Be  the  first  to  Know !</h3>
						<div id="mesaj"> </div>
					<form id="" method="post" action="{{url('coming_soon/subscribe')}}" name="subscribe">
						{{csrf_field()}}
							<input type="text" id="semail" name="email" placeholder="Enter your  email address" />
							<!-- You can stylize the submit button by changing its color. To do this, replace the 'orange' from class="orange" with: yellow, red, purple, green, blue, darkblue, white and black.-->								
							
							<input type="submit" id="ssubmit" name="subscribe"  value="Subscribe" class="orange" />

						</form>
											<p style="font-size: 14px"> Have a question  ,send as an  email at info[at]dil.africa</p>

					</div><!--end form-wrapper-->
				</div><!--end home-->
				
			</div><!--end content-page-->
			
			<div class="bottom-page">
				<ul class="social">
				<!-- Change the # with the link to your social page. -->
					<li><a class="facebook tooltip" href="https://facebook.com/dil.africa" title="Facebook"></a></li>
					<li><a class="twitter tooltip" href="http://twitter.com/dil_africa" title="Twitter"></a></li>
					<li><a class="youtube tooltip" href="#" title="YouTube"></a></li>
					<li><a class="skype tooltip" href="#" title="Skype"></a></li>
					
<!-- You can add to social list buttons for digg, delicious, vimeo and dropbox. Just delete the brackets from below -->
			<!--	<li><a class="digg tooltip" href="#" title="Digg"></a></li>
					<li><a class="delicious tooltip" href="#" title="Delicious"></a></li>
					<li><a class="vimeo tooltip" href="#" title="Vimeo"></a></li>
					<li><a class="dropbox tooltip" href="#" title="DropBox"></a></li>		
			-->
				</ul>
			</div><!--end bottom-page-->
		</div><!--end book-->
		
		<p class="copyright">Copyright &copy; DIL.AFRICA - All Rights Reserved</p>
		
	</div><!--end wrapper-->
<script type="text/javascript" src="{{asset('coming_soon/js/jquery.placeholder.js')}}"></script>	<!-- placeholder html5 tag support for IE and Old Browsers -->
</body> 
</html>

