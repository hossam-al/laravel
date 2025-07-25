@extends('paymob.layout.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">إنشاء معاملة جديدة</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <form action="{{ route('transaction.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" name="amount" class="form-control" step="0.01" required>
                @error('amount')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">نوع العملية</label>
                <select name="type" class="form-select" required>
                    <option value="deposit">إيداع</option>
                    <option value="withdraw">سحب</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="payment_method_id" class="form-label">وسيلة الدفع</label>
                <select id="payment_method_id" name="payment_method_id" class="form-select" required>
                    <option value="">اختر وسيلة الدفع</option>
                    @foreach ($methods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                    @endforeach
                </select>

                @error('payment_method_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

    @include('paymob.Payment.visaform')
        @include('paymob.Payment.vodafonecash')
                @include('paymob.Payment.fawry')


            </div>
        </form>
    </div>
    <script>
          document.getElementById('expiry_date').addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');

        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }

        e.target.value = value;
    });
        document.getElementById("payment_method_id").addEventListener("change", function() {
            const method = this.value;



            // أظهر الفورم المطلوب فقط
            if (method === "1") {

                document.getElementById("visa_form").style.display = "block";
                document.getElementById("vodafone_form").style.display = "none";
                                         document.getElementById("fawry_form").style.display = "none";


            } else if (method === "3") {
                document.getElementById("vodafone_form").style.display = "block";
                         document.getElementById("visa_form").style.display = "none";
                                                  document.getElementById("fawry_form").style.display = "none";

            }else if (method==="4"){

  document.getElementById("fawry_form").style.display = "block";
document.getElementById("vodafone_form").style.display = "none";
document.getElementById("visa_form").style.display = "none";

            }
        });
    </script>
@endsection
