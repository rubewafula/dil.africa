    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #0f7dc2;background-color: #f5f8fa;
    margin: 0;
    padding: 0;
    width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    -premailer-width: 100%;">
    <tr>
        <td align="center">
            <table style="margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;" width="100%" cellpadding="0" cellspacing="0">
            
            <tr>
                <td style="background: #0f7dc2;">
                    <table width="100%">
                        <tr>
                            <td style="width: 65%;padding: 25px 0;
                            text-align: center;">
                            <div>
                                <a href="{{url('/shop')}}">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="DIL.AFRICA"/>
                                </a>
                            </div>
                            <div>
                                <a href="{{ $url }}">
                                 <span style="font-size: 16px;color: #FFF;"> {{ $slot }}, </span> <span style="font-style: italic;font-size: 12px;color:#FFF;font-weight: normal;">The Ultimate Customer Experience! </span>
                             </a>
                         </div>
                     </td>
                     <td style="width: 35%;padding: 10px 0;line-height: 1.5em;">
                        <div style="float: right;">
                            <span style="font-size: 14px;color:#FFF;font-weight: normal;">DIL.AFRICA,</span><br/>
                            <span style="font-size: 14px;color:#FFF;font-weight: normal;">P.O. BOX 6301-00601,</span><br/>
                            <span style="font-size: 14px;color:#FFF;font-weight: normal;">Nairobi, Kenya,</span><br/>
                            <span style="font-size: 14px;color:#FFF;font-weight: normal;">Telephone: +254 797522522,</span><br/>
                            <span style="font-size: 14px;color:#FFF;font-weight: normal;">Website: www.dil.africa</span><br/>
                        </div>     
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Email Body -->
    <tr>
        <td style="background-color: #EEE;
        border-bottom: 1px solid #EDEFF2;
        border-top: 1px solid #EDEFF2;
        margin: 0;
        padding: 0;
        width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;" width="100%" cellpadding="0" cellspacing="0">              

        <table style="background-color: #FFFFFF;
        margin: 0 auto;
        padding: 0;
        width:800px;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 800px;" align="center" width="570" cellpadding="0" cellspacing="0">
        <!-- Body content -->
        <tr>
            <td class="content-cell">
                {{ Illuminate\Mail\Markdown::parse($slot) }}

                <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            {{ Illuminate\Mail\Markdown::parse($slot) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</td>
</tr>

<tr style="background: #F89530;height: 50px;">
    <td style="background: #F89530;">
        <table class="footer" align="center" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center" style="border-bottom: 1px solid #FFF;">
                    <span style="color: #FFF;">
                        Same Day Delivery within Nairobi and its Environs and at Zero Shipping Cost for Orders above KES 10,000 in Value
                    </span>
                </td>
            </tr>
            <tr>
                <td class="content-cell" align="center">
                    <span style="color: #FFF;">{{ Illuminate\Mail\Markdown::parse($slot) }}</span>
                </td>
                
            </tr>
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>