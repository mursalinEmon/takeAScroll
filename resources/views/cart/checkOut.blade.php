@extends('layouts.front-end.theme')
@section('section')
<div class="row">
    <div class="container" style="">
        <form action="{{ route('ssl.pay') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-title">
                    <h2 class="text text-success text-center">Your Cart.. Wanna CheckOut ?? </h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total=0;@endphp
                        @forelse (Cart::content() as $product)
                            <tr>
                                <th scope="row">{{ $product->name }}</th>
                                <td>{{$product->model->price - ($product->model->price * ($product->model->discount/100)) }}</td>
                                <td>{{ $product->qty }}</td>
                                <td>{{ ($product->model->price - ($product->model->price * ($product->model->discount/100)))  * $product->qty }}</td>
                                @php $total+=($product->model->price - ($product->model->price * ($product->model->discount/100))) * $product->qty;@endphp
                            </tr>
                        @empty
                            <h1 class="text text-danger">Not Item in Cart...!!</h1>
                        @endforelse
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <th >Total Amount = </th>
                            <td>{{ $total }}</td>
                            <input type="hidden" value="{{ $total }}" name="total_amount">
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="d-flex justify-content-around">
                                <button  type="submit" class="btn btn-success" style="color:white;">Pay Now</button>

                                <a href="#" type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Pay On Delivery</a>
                                <a href="#" class="btn btn-danger" style="color:white;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">In Order to Procede We Need Your Delivery Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient" class="col-form-label">Delivery Address Will be the Address You Gave in Profile.</label>
                        <h6 class="text text-primary">To Change it Go To Profile..and Cahnge ..!!</h6>
                    </div>
                    <input type="hidden" id="totalam" value="{{ $total }}" name="total_amount">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" style="color:white;" data-dismiss="modal">Close</button>
                    <button class="btn btn-success payd" id="payd" style="color:white;" >Proceed</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





