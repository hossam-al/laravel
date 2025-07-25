@extends('paymob.layout.app')

@section('content')
    <div class="container">




        <table class="table table-bordered bg-white">
            <thead class="table-warning">
                <tr>
                    <th>name</th>
                    <th>logo</th>
                    <th>code</th>
                    <th>active</th>
                    <th>description</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentMethod as $item)
                    <tr>

                        <th>{{ $item->name }}</th>
                        <td><img src="{{ asset('upload/'.$item->logo) }}" alt="" style="width: 32px; height: 32px; object-fit: contain;"></td>
                        <td>{{ $item->code }}</td>
                        @if ($item->active == 0)
                            <th class="text-danger">Not activated</th>
                        @else
                            <th class="text-success">Activated</th>
                        @endif
                        <th>{{ $item->description }}</th>
                        <th>{{ $item->created_at }}</th>


                    </tr>
                @endforeach

            </tbody>
        </table>


    </div>
@endsection
