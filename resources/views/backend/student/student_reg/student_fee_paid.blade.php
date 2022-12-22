@extends('admin.admin_master') @section('admin')
<div class="content-wrapper">
   <div class="container-full">
      <!-- Content Header (Page header) -->
      <section class="content">
         <!-- Basic Forms -->
         <div class="box">
            <div class="box-header with-border">
               <h4 class="box-title">Add Fee Category</h4>
            </div>
            <!-- /.box-header -->
            @php
            $months = \App\Models\Month::with(['fee_category', 'transport_fee' ,'fee_paid'])->get();
            @endphp
            <div class="box-body" style="overflow: auto;">
               <form method="post" action="{{ route('store.fee.paid') }}">
               @csrf
               <input type="hidden" name="id" value="{{ $id }}">
               @foreach ($months as $month)
               <div class="category-body">
                  <div class="month">
                     <div class="heading">
                        <h4>Month Name*</h4>
                     </div>
                     <div class="box-content">





                 @if( count($month->fee_paid) !==0)
               {{--   <input type="checkbox" id="{{$month->id}}" name="month[]" value="{{$month->id}}" checked>  --}} 
               <label for="{{$month->id}}">Paid</label>

                @else
                <input type="checkbox" id="{{$month->id}}" name="month[]" value="{{$month->id}}" >
                @endif

                 <label for="{{$month->id}}">{{$month->month}}</label>



                     </div>
                  </div>
                  <div class="cotegory-amount-box">
                     <div class="category-name">
                        <div class="heading">
                           <h4>Fee Category Name <span>*</span></h4>
                        </div>
                        @foreach ($month->fee_category as $feecat)
                        <div class="box-content">
                           <p>{{$feecat->name}}</p>
                        </div>
                  @endforeach

                        @foreach ($month->transport_fee as $transf)
                        <h5>Fee <span class="text-danger">*</span></h5>
                        <p> Transport Fee</p>

                        {{$transf->amount}}
                  @endforeach

                        @php
                        $fee_category_id = $feecat->id;
                        $std = \App\Models\AssignStudent::where('student_id',$id)->first();
                        $fee_ammount = \App\Models\FeeCategoryAmount::where('fee_category_id',$fee_category_id)->where('class_id',$std->class_id)->first();
                        @endphp
                     </div>
                     <div class="category-name">
                        <div class="heading">
                           <h4>Fee Amount <span>*</span></h4>
                        </div>
                        <div class="box-content">
                           <p>@if( $fee_ammount !==null )
                              {{$amount= $fee_ammount->amount;}}
                              @endif<span>*</span>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
               <div class="text-xs-right">
                                            <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                        </div>
               </from>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </section>
   </div>
</div>
@endsection