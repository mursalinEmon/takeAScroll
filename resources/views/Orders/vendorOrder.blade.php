@extends('layouts.theme')

@section('content')
    <div class="container">
        <div class="row">
           <div class="col-md-6"><span class="text text-danger text-center col-md-6"><h4>Payment Status: {{$status}}</h4> </span></div>
            <div class="col-md-6"><span class="text-secondary text-center col-md-6"><h4>Transaction ID: {{$tid}}</h4> </span></div>=
        </div>
        <hr>
        <form action="{{route('vendor.order.update')}}" method="post">
            @csrf
            <input type="hidden" value="{{$order_id}}" name="oreder_id">
            @php  $total=0;@endphp
                <h2 class="text text-center text-primary">Store Name : {{$store_name}}</h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text text-center" scope="col">Image</th>
                        <th class="text text-center" scope="col">Name</th>
                        <th class="text text-center" scope="col">Quantity</th>
                        <th class="text text-center" scope="col">Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($orders as $order)
                        <tr>
                            <td scope="row"><img style="width: 100px;height: 100px;" src="{{asset($order['product']->product_pictures[0])}}" alt=""></td>
                            <td class="text text-center">{{$order['product']->name}}</td>
                            <td  class="text text-center">{{$order['qty']}}</td>
                            <td  class="text text-center">{{$order['product']->price * $order['qty']}}</td>
                            @php $total+=$order['product']->price * $order['qty'];@endphp
                        </tr>
                    @empty
                        <h1 class="text text-danger">No Data..!!!</h1>
                    @endforelse
                    </tbody>
                </table>
                <hr style=" border: 1px solid black; border-radius: 5px;">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-2  text-danger text-right"><h5>Total : </h5></div>
                    <div class="col-md-2 text-left">   <h5>{{$total}} ৳</h5></div>

                </div>

                <br>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-2"><button type="submit"  class="btn btn-success text-center mr-2"><h5 class=" text  text-center ">Proceed</h5></button></div>
                <div class="col-md-2"><span  href="#" id="markasdone" onclick="mark()" class="btn btn-primary text-center markasdone"><h5 class=" text  text-center ">Mark As Done</h5>
                    <input type="hidden" id="markvalue" value="{{$noti_id}}"></span></div>
                <div class="col-md-4"></div>
            </div>
            <br>
            <br>
        </form>

    </div>

@endsection
