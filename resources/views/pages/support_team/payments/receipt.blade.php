<html>
<head>
    <title>Receipt_{{ $pr->ref_no.'_'.$sr->user->name }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/receipt.css') }}"/>
</head>
<body>
<div class="container">
    <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
        {{--  School Details--}}
        <table width="100%">
            <tr>

                <td>
                    <strong><span
                                style="color: #1b0c80; font-size: 25px;">{{ strtoupper(Qs::getSetting('system_name')) }}</span></strong><br/>
                    {{-- <strong><span style="color: #1b0c80; font-size: 20px;">MINNA, NIGER STATE</span></strong><br/>--}}
                    <strong><span
                                style="color: #000; font-size: 15px;"><i>{{ ucwords($s['address']) }}</i></span></strong>
                    <br/> <br/>

                     <span style="color: #000; font-weight: bold; font-size: 25px;"> PAYMENT RECEIPT</span>
                </td>
            </tr>
        </table>

        {{--Background Logo--}}
        <div style="position: relative;  text-align: center; ">
            <img src="{{ $s['logo'] }}"
                 style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.1; margin-left: auto;margin-right: auto; left: 0; right: 0;"/>
        </div>

        {{--Receipt No --}}
    <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
        <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
            <span  style="font-size: 16px;">Receipt Reference No.</span>
        </div>
        <div  style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
            <span  style="font-size: 25px;">{{ $pr->ref_no }}</span>
        </div>
    </div>

        <div style="clear: both"></div>

        {{-- Student Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">معلومات الطالب</span>
        </div>

        {{--Photo--}}
        <div style="margin: 15px;">
            <img style="width: 100px; height: 100px; float: left;" src="{{ $sr->user->photo }}" alt="...">
        </div>

       <div style="float: left; margin-left: 20px">
           <table style="font-size: 16px" class="td-left" cellspacing="5" cellpadding="5">
               <tr>
                   <td class="bold">{{ __('msg.NAME') }}:</td>
                   <td>{{ $sr->user->name }}</td>
               </tr>
               <tr>
                   <td class="bold">رقم القبول:</td>
                   <td>{{ $sr->adm_no }}</td>
               </tr>
               <tr>
                   <td class="bold">{{ __('msg.Class') }}:</td>
                   <td>{{ $sr->my_class->name }}</td>
               </tr>
           </table>
       </div>
        <div class="clear"></div>

        {{-- Payment Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">معلومات الدفع</span>
        </div>

        <table class="td-left" style="font-size: 16px" cellspacing="2" cellpadding="2">
                <tr>
                    <td class="bold">{{ __('msg.Ref_No') }}:</td>
                    <td>{{ $payment->ref_no }}</td>
                    <td class="bold">{{ __('msg.Title') }}:</td>
                    <td>{{ $payment->title }}</td>
                </tr>
                <tr>
                    <td class="bold">{{ __('msg.Amount') }}:</td>
                    <td>{{ $payment->amount }}</td>
                    <td class="bold">الوصف:</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            </table>

        {{-- Payment Desc --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">الوصف</span>
        </div>

        <table class="td-left" style="font-size: 16px" width="100%" cellspacing="2" cellpadding="2">
           <thead>
           <tr>
               <td class="bold">التاريخ</td>
               <td class="bold">المبلغ المدفوع  </del></td>
               <td class="bold">الباقي</del></td>
           </tr>
           </thead>
            <tbody>
            @foreach($receipts as $r)
                <tr>
                    <td>{{ date('D\, j F\, Y', strtotime($r->created_at)) }}</td>
                    <td>{{ $r->amt_paid }}</td>
                    <td>{{ $r->balance }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
            <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
                <span  style="font-size: 16px;">{{ $pr->paid ? 'PAYMENT STATUS' : 'TOTAL DUE' }}</span>
            </div>
            <div  style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
                <span  style="font-size: 25px;">{{ $pr->paid ? 'CLEARED' : $pr->balance }}</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script>
window.print();
</script>
</body>
</html>
