@extends('paymob.layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">المعاملات المعلقة</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered bg-white">
        <thead class="table-warning">
            <tr>
                <th>#</th>
                <th>رقم المعاملة</th>
                <th>المستخدم</th>
                <th>المبلغ</th>
                          <th>نوع العملية</th>
                <th>وسيلة الدفع</th>
                <th>التاريخ</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $txn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $txn->transaction_number }}</td>
                    <td>{{ $txn->user->name ?? '---' }}</td>
                    <td>{{ number_format($txn->amount, 2) }} EGP</td>
                       @if ($txn->type == 'deposit')
                            <td  class="text-success">ايداع</td>
                        @else
                            <td  class="text-danger">سحب</td>
                        @endif
                    <td>{{ $txn->paymentMethod->name ?? '---' }}</td>
                    <td>{{ $txn->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form action="{{ route('transaction.updateStatus', $txn->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="success">
                            <button type="submit" class="btn btn-success btn-sm">ناجحة</button>
                        </form>

                        <form action="{{ route('transaction.updateStatus', $txn->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="failed">
                            <button type="submit" class="btn btn-danger btn-sm">فاشلة</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">لا توجد معاملات معلقة.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
