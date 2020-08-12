@extends('admin.layout.app')
<style>
    .btn{
        height:27px !important;
    }
    .material-icons{
        margin-top:0px !important;
        margin-bottom:0px !important;
    }
</style>
@section ('content')
<div class="container-fluid">
 <div class="row">
<div class="col-lg-12">
    @if (session()->has('success'))
   <div class="alert alert-success">
    @if(is_array(session()->get('success')))
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            @else
                {{ session()->get('success') }}
            @endif
        </div>
    @endif
     @if (count($errors) > 0)
      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          {{$errors->first()}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      @endif
    @endif
    </div>
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">Store Payout Request</h4>
    </div>
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
                      <!--<th>ID</th>-->
                      <th>Store</th>
                      <th>Address</th>
                      <th>Total Revenue</th>
                      <th>Bank Account Details</th>
                      <th>Already Paid</th>
                      <th>Pending Balance</th>
                      <th>Requested amount</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                         @if(count($total_earnings)>0)
                          @php $i=1; @endphp
                          @foreach($total_earnings as $total_earning)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td>{{$total_earning->store_name}} <p style="font-size:14px">({{$total_earning->phone_number}})</p></td>
                                <td>{{$total_earning->address}}</td>
                                <td>{{$total_earning->sumprice}}</td>
                                <td style="font-size:10px !important"><b>Bank- </b>{{$total_earning->bank_name}}<br>
                                <b>Ac Holder- </b>{{$total_earning->holder_name}}<br>
                                <b>Ac No.- </b>{{$total_earning->ac_no}}<br>
                                <b>IFSC- </b>{{$total_earning->ifsc}}<br>
                                UPI - {{$total_earning->upi}}</td>
                                @if($total_earning->paid != NULL)
                                <td>{{$total_earning->paid}}</td>
                                @else
                                <td>0</td>
                                @endif
                                 @if($total_earning->paid != NULL)
                                <td>{{$total_earning->sumprice - $total_earning->paid }}</td>
                                @else
                                <td>{{$total_earning->sumprice}}</td>
                                @endif
                                
                                <td>{{$total_earning->payout_amt}}</td>
                                <td class="td-actions text-center">
                                    @if($total_earning->sumprice <= $total_earning->paid )
                                    <span style="color:green">Paid</span>
                                    @else
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1{{$total_earning->store_id}}">Pay</button>
                                    @endif
                                </td>
                            </tr>      
                        @php $i++; @endphp
                        @endforeach
                      @else
                        <tr>
                          <td>No data found</td>
                        </tr>
                      @endif  
                    </tbody>
</table>
<div class="pagination justify-content-end" align="right" style="width:100%;float:right !important">{{$total_earnings->links()}}</div>
</div>
</div>
</div>
</div>
<div>
  </div>
    @foreach($total_earnings as $total_earning)
        <div class="modal fade" id="exampleModal1{{$total_earning->store_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        	<div class="modal-dialog" role="document">
        		<div class="modal-content">
        			<div class="modal-header">
        				<h5 class="modal-title" id="exampleModalLabel"><b>{{$total_earning->store_name}}</b></h5>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        						<span aria-hidden="true">&times;</span>
        					</button>
        			</div>
        			<br>
        			<!--//form-->
        			<form class="forms-sample" action="{{route('com_payout', $total_earning->req_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
        			<div class="row">
        			    
        			  <div class="col-md-3" align="center"></div>  
                      <div class="col-md-6" align="center">
                        <div class="form-group">
                        <label>Enter Amount</label>        
        		     	<input class="form-control" type="number" min="10" step="0.01" value="{{$total_earning->payout_amt}}" step ="0.01" @if($total_earning->paid != NULL)
                                max="{{$total_earning->sumprice - $total_earning->paid }}"
                                @else
                                max="{{$total_earning->sumprice}}"
                                @endif  name="amt"/>
        			</div>
        			<button type="submit" class="btn btn-primary pull-center">Submit</button>
        			</div>
        			</div>
        			  
                    <div class="clearfix"></div>
        			</form>
        			<!--//form-->
        		</div>
        	</div>
        </div>
 @endforeach
    @endsection
</div>