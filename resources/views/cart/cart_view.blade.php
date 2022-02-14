@extends('layouts.front-end.theme')
@section('section')



<!-- Cart Page Start -->
<div class="page-section section pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-40">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Image</th>
                                    <th class="pro-title">Product</th>
                                    <th class="pro-price">Price</th>
                                    <th class="pro-quantity">Quantity</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=0;@endphp


                                <tr>
                                    @if($address!=null )
                                    <a  href="{{ route('cart.checkout',$address) }}" class="btn btn-success float-right mr-4 pr-4 mt-4 mb-4"><span class="text text-white">Check-Out</span></a>
                                    @else
                                    <button type="button" class="btn btn-success float-right mr-4 pr-4 mt-4 mb-4" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Check-Out</button>
                                    @endif
                                </tr>
                                @forelse(Cart::content() as $row)
                                @php $count++;@endphp
                                    <tr>
                                        <td class="pro-thumbnail"><img src="{{  asset($row->model->product_pictures[0])  }}" style="max-height: 150px;max-width:150px;" alt="Product"></a></td>
                                        <td class="pro-title"><a href="#">{{ $row->name }}</a></td>
                                        <td class="pro-price"><span> ৳{{ $row->model->price - ($row->model->price * ($row->model->discount/100)) }}</span></td>

                                        <td class="pro-quantity"><div class="pro-qty"><span id="{{ $row->rowId }}"  class="dec qtybtn">-</span><input  type="text" value="{{ $row->qty }}"><span id="{{ $row->rowId }}" class="inc qtybtn">+</span></div></td>

                                        <td class="pro-subtotal"> ৳<input id="item-price-{{ $row->rowId }}"  value={{ $row->model->price - ($row->model->price * ($row->model->discount/100)) }} size="5"  disabled ></td>

                                        <td class="pro-remove"><a href="#"><i class="fa fa-trash-o remove-cart" data-rowid="{{ $row->rowId }}"></i></a></td>
                                    </tr>

                                @empty
                                    <h1 class="text text-danger">Empty Cart ....!!</h1>
                                    <br>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->







{{-- modal --}}
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
            <label for="recipient" class="col-form-label">Put Address</label>
            <input type="text" class="form-control recipient" id="recipient">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" style="color:white;" data-dismiss="modal">Close</button>
        <button  class="btn btn-success adz" id="adz" style="color:white;" >Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- JS


@endsection
