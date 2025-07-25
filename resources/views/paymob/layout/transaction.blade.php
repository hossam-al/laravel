@extends('paymob.layout.app')

@section('content')
    <div class="container">

        </h5>

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <table class="table table-bordered table-hover bg-white">

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">📬 البريد الإلكتروني: {{ $user->email }}</p>
            <h4 class="text-success">💰 الرصيد الحالي: {{ number_format($user->balance(), 2) }} EGP</h4>
        </div>
    </div>

            <thead class="table-primary">

                <tr>
                    <th>#</th>
                    <th>رقم المعاملة</th>
                    <th>المستخدم</th>
                    <th>المبلغ</th>
                    <th>نوع العملية</th>
                    <th>الحالة</th>
                    <th>وسيلة الدفع</th>
                    <th>تاريخ الإنشاء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $txn)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $txn->transaction_number }}</td>
                        <td>{{ $txn->user->name ?? '---' }}</td>
                        <td>{{ number_format($txn->amount, 2) }} EGP</td>
                        @if ($txn->type == 'deposit')
                            <td class="text-success">ايداع</td>
                        @else
                            <td class="text-danger">سحب</td>
                        @endif

                        <td>
                            @if ($txn->status == 'success')
                                <span class="badge bg-success">ناجحة</span>
                            @elseif($txn->status == 'failed')
                                <span class="badge bg-danger">فاشلة</span>
                            @else
                                <span class="badge bg-warning text-dark">معلقة</span>
                            @endif
                        </td>
                        <td>{{ $txn->paymentMethod->name ?? '---' }}</td>
                        <td>{{ $txn->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
