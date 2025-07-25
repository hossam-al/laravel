@extends('paymob.layout.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">إجمالي المعاملات</h5>
                    <p class="fs-4">{{ $count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-success">
                <div class="card-body">
                    <h5 class="card-title">ناجحة</h5>
                    <p class="fs-4">{{ $successCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-danger">
                <div class="card-body">
                    <h5 class="card-title">فاشلة</h5>
                    <p class="fs-4">{{ $failedCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-warning">
                <div class="card-body">
                    <h5 class="card-title">معلقة</h5>
                    <p class="fs-4">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <style>
        .credit-card-updated {
            width: 100%;
            max-width: 500px;
            aspect-ratio: 1.6;
            background: linear-gradient(135deg, #2c3e50, #2980b9);
            color: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            font-family: 'Segoe UI', sans-serif;
            position: relative;
        }

        .credit-card-updated .chip {
            width: 50px;
            height: 35px;
            background: gold;
            border-radius: 8px;
            margin-top: 20px;
        }

        .credit-card-number {
            font-size: 1.7rem;
            letter-spacing: 2.5px;
            margin: 25px 0;
        }

        .credit-card-details {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            flex-wrap: wrap;
        }

        .credit-card-details div {
            margin-top: 5px;
        }

        .credit-card-logo {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .credit-card-logo img {
            width: 60px;
        }
    </style>
    @if ($cards != null)
        <div class="container mt-4">
            <div class="row">
                <div class="col-auto">
                    <div class="credit-card-updated">
                        <div class="credit-card-logo">
                            <img src="{{ asset('upload/Visa.ico') }}" alt="Visa">
                        </div>

                        <div class="chip"></div>

                        <div class="credit-card-number">
                            {{ chunk_split($cards->card_number, 4, ' ') }}
                        </div>

                        <div class="credit-card-details">
                            <div>
                                <small class="text-light">الاسم</small><br>
                                <strong>{{ $cards->user->name }}</strong>
                            </div>
                            <div>
                                <small class="text-light">تاريخ الانتهاء</small><br>
                                <strong>{{ $cards->expiry_month }}/{{ $cards->expiry_year }}</strong>
                            </div>
                            <div>
                                <small class="text-light">CVV</small><br>
                                <strong>{{ $cards->cvv }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
