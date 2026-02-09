@extends('layouts.naa')

@section('content')
<div class="text-center py-20">
    <h1 class="text-4xl font-bold text-green-600 mb-4">تم طلب الأوردر بنجاح! 🎉</h1>
    <p class="text-gray-600">شكراً لك، سيتم التواصل معك قريباً لتأكيد الطلب.</p>
    <a href="{{ route('menu.index') }}" class="mt-6 inline-block bg-red-600 text-white px-6 py-2 rounded-lg">العودة للمنيو</a>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

<script type="text/javascript">
   (function(){
      emailjs.init("YOUR_PUBLIC_KEY"); // الـ Public Key بتاعك
   })();

   window.onload = function() {
      const templateParams = {
         order_id: "{{ session('order_id') }}",
         customer_name: "{{ session('customer_name') }}",
         phone: "{{ session('phone') }}",
         address: "{{ session('address') }}",
         total_price: "{{ session('total_price') }}",
         order_details: "تم طلب الأكل بنجاح" // ممكن تفصلها أكتر لو حبيت
      };

      emailjs.send('YOUR_SERVICE_ID', 'YOUR_TEMPLATE_ID', templateParams)
         .then(function(response) {
            alert('تم إرسال نسخة من الطلب للمطعم بنجاح!');
         }, function(error) {
            console.log('FAILED...', error);
         });
   };
</script>
@endsection