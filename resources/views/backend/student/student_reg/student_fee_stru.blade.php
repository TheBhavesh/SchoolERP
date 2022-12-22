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
                <div class="box-body">
                   <form method="post" action="{{ route('store.fee.stru') }}">
                    @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">


                    <div class="feeStructure">
                        <div class="row">


                                        @php

                                        $std = \App\Models\AssignStudent::where('student_id',$id)->first();


                                        $fee_amount =
                                        \App\Models\FeeCategoryAmount::with(['fee_cateogry'])->where('class_id',$std->class_id)->get();





                                        @endphp


                                       @foreach ($fee_amount as $feeamo)

                            <div class="col-md-6">
                                <div class="monthly">


                                    <div class="heading">
                                    <h4>Fee Category *</h4>
                                     <p>Fee Category Name :- <span>{{$feeamo->fee_cateogry->name}}</span></p>  
                                     <input type="hidden" name="fee_category_id[]" value=" {{$feeamo->fee_cateogry->id}}">

                                     <p>Fee Category amount :- <span>{{$feeamo->amount}}</span></p>    
                                    </div>
                                    @php 
                                    $discount =\App\Models\DiscountStudents::where('fee_category_id',$feeamo->fee_cateogry->id)->where('assign_student_id',$id)->first(); 
                                    @endphp

                                    <div class="row">
                                    <div class="box col-md-6">
                                             @error('remark')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        <label>Remark <span>*</span></label>

                                        <input type="text" name="remark[]" value="{{$discount->remark}}" class="form-control">
                                    </div>
                                    <div class="box col-md-6">
                                             @error('discount')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        <label>Discount <span>*</span></label>
            
                                        <input type="text" name="discount[]" value="{{$discount->discount}}" class="form-control">
                                    </div>
                                    </div>

                                </div>
                            </div>
                         @endforeach







                            <div class="col-md-12">
                                <div class="transport">
                                    <div class="heading">
                                        <h4>Transport Fee <span>*</span></h4>
                                    </div>
                                    <div class="transport-months">

                                                @php 
                                                

                                          $months = \App\Models\Month::with([ 'transport_fee' ])->get();
                                          $transfee = \App\Models\TransportFee::with( 'month' )->get();

                                          @endphp
                                                <div class="form-group">
                                                    @foreach ($months as $key =>  $month) 

                                                



                                        <div class="month">
                                        @php 

                                          @endphp

                                            @if( count($month->transport_fee) !==0)
                                           <input type="checkbox" id="{{$month->id}}" name="month[]" value="{{$month->id}}" checked>
                                           @else
                                           <input type="checkbox" id="{{$month->id}}" name="month[]" value="{{$month->id}}" >
                                           @endif

                                                    <label for="{{$month->id}}">{{$month->month}}</label>
                                        </div>
                                        @endforeach
               
                                    </form>
                                    </div>
                                    <div class="box">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Ammount <span>*</span></label>
                                                  <input type="text" name="amount" value="{{$transfee[0]->amount}}" class="form-control"> @error('amount')
                                                    <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Route <span>*</span></label>
                                                   <input type="text" name="route" value="{{$transfee[0]->route}}" class="form-control"> @error('route')
                                                    <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <br>
                                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                    {{-- <div class="row">
                        <div class="col">

                            <form method="post" action="{{ route('store.fee.stru') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        @php $std = \App\Models\AssignStudent::where('student_id',$id)->first(); $fee_amount = \App\Models\FeeCategoryAmount::with(['fee_cateogry'])->where('class_id',$std->class_id)->get(); @endphp
                                        <div class="form-group">

                                            <input type="hidden" name="id" value="{{ $id }}">

                                            <div class="controls">
                                                @foreach ($fee_amount as $feeamo)
                                                <h2>Fee Category <span class="text-danger">*</span></h2>


                                                @php @endphp
                                                <h5>Fee Category Name <span class="text-danger">*</span>={{$feeamo->fee_cateogry->name}}
                                                </h5>


                                                <h5>Fee Category amount <span class="text-danger">={{$feeamo->amount}}</span></h5>

                                                <h5>Discount<span class="text-danger">*</span></h5>

                                                <input type="text" name="name" class="form-control"> @error('name')
                                                <span class="text-danger">{{ $message }}</span> @enderror
                                                <h5>Remark<span class="text-danger">*</span></h5>

                                                <input type="text" name="name" class="form-control"> @error('name')
                                                <span class="text-danger">{{ $message }}</span> @enderror @endforeach
                                                <h2>Transport Fee <span class="text-danger">*</span></h2>

                                                @php $months = \App\Models\Month::get(); @endphp
                                                <div class="form-group">
                                                    @foreach ($months as $month)
                                                    <input type="checkbox" id="{{$month->id}}" name="month[]" value="{{$month->id}}">
                                                    <label for="{{$month->id}}">{{$month->month}}</label><br> @endforeach



                                                    <h5>amount<span class="text-danger">*</span></h5>

                                                    <input type="text" name="amount" class="form-control"> @error('amount')
                                                    <span class="text-danger">{{ $message }}</span> @enderror
                                                    <h5>Route<span class="text-danger">*</span></h5>

                                                    <input type="text" name="route" class="form-control"> @error('name')
                                                    <span class="text-danger">{{ $message }}</span> @enderror

                                                </div>

                                            </div>




                                            <div class="text-xs-right">
                                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                            </div>
                            </form>

                        </div>
                            
                    </div> --}}
                        
                </div>
                            <!-- /.box-body -->
            </div>
                        <!-- /.box -->

        </section>





        </div>
        </div>





        @endsection