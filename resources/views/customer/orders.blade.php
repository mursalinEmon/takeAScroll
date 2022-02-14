@extends('layouts.theme')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-11"></div>
            <div>
                <button onclick="reload()" class="btn btn-success p-2">
                    Rfresh
                </button>
            </div>
        </div>
        @foreach($orders as $order)
            @php $total=0 @endphp
            @foreach($carts as $key=>$value)
                @if($key == $order->id)
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Order Issued At : {{\Carbon\Carbon::parse($order->created_at)->format('D-M-Y')}}</h5>
                        </div>
                    </div>
                    <br>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text text-center" scope="col">Image</th>
                        <th class="text text-center" scope="col">Name</th>
                        <th class="text text-center" scope="col">Quantity</th>
                        <th class="text text-center" scope="col">Delivery Staus</th>
                        <th class="text text-center" scope="col">Price</th>
                    </tr>
                    </thead>
                    @foreach($value as $row)
                        {{-- <p>{{$order->id}} {{$row->model->name}}</p> --}}

                            <tbody>

                                <tr>
                                    <td scope="row"><img style="width: 80px;height: 80px;" src="{{asset($row->model->product_pictures[0])}}" alt=""></td>
                                    <td class="text text-center">{{$row->model->name}}</td>
                                    <td  class="text text-center">{{$row->qty}}</td>
                                    @if($deliveries[$order->id]->delivery_status=="delivered")
                                        <td>  <rating :product_id="{{$row->model->id}}"></rating></td>

                                    @else
                                        <td  class="text text-center">{{$deliveries[$order->id]->delivery_status}}</td>
                                    @endif
                                    <td  class="text text-center">{{$row->model->price }}</td>
                                    @php $total+=$row->model->price @endphp
                                </tr>

                            </tbody>


                    @endforeach
                </table>
                    <hr style=" border: 1px solid black; border-radius: 5px;">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-2  text-danger text-right"></div>
                        <div class="col-md-2 text-right"><h5>Total :{{$total}} ৳</h5></div>
                        @if($order->status=="Pending")
                        <div class="col-md-2 text-left"><h6 class="text text-danger">Payment Status:{{$order->status}}</h6></div>
                        @else
                            <div class="col-md-2 text-left"><h6 class="text text-primary mt-2">Payment Status:{{$order->status}}</h6></div>
                        @endif

                    </div>
                    <br>
                    <br>

                @else
                @endif

            @endforeach
        @endforeach

    </div>
@endsection
