<!DOCTYPE html>
<html>

<head>
  <style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>

<body>


  <table id="customers">
    <tr>
      <td>
        <h2>
          <?php $image_path = '/upload/easyschool.png'; ?>
          <img src="{{ public_path() . $image_path }}" width="200" height="100">

        </h2>
      </td>
      <td>
        <h2>Easy School ERP</h2>
        <p>School Address</p>
        <p>Phone : 343434343434</p>
        <p>Email : support@easylerningbd.com</p>
        <p> <b>Student ID Card </b> </p>

      </td>
    </tr>


  </table>

  <table id="customers">

    <tr>
      <td>IMAGE</td>
      <td>Easy School </td>
      <td> Student Id Card</td>

    </tr>







  </table>


  @php


$paidmonth = \App\Models\FeePaid::with([  'month'])->where('id',$id)->get();


@endphp


@foreach ($paidmonth[0]->month as $paidmonth1)


  
  @php


$months = \App\Models\Month::with(['fee_category', 'transport_fee' ])->where('id',$paidmonth1->id)->get();

@endphp

@foreach ($months as $month)
<h2>Month Name <span class="text-danger">*</span></h2>

@php

@endphp

<label for="{{$month->id}}">{{$month->month}}</label><br>

@foreach ($month->fee_category as $feecat)

<h5>Fee Category Name <span class="text-danger">*</span></h5>

{{$feecat->name}}


@foreach ($month->transport_fee as $transf)

<h5>Fee Transport Fee <span class="text-danger">*</span></h5>

{{$transf->amount}}



@php


$fee_category_id = $feecat->id;




$std = \App\Models\AssignStudent::where('student_id',$paidmonth[0]->student_id)->first();
$fee_ammount = \App\Models\FeeCategoryAmount::where('fee_category_id',$fee_category_id)->where('class_id',$std->class_id)->first();


@endphp

@if( $fee_ammount !==null )
<h5>Fee Category amount <span class="text-danger">*</span></h5>

{{$amount= $fee_ammount->amount;}}

@endif



@endforeach


@endforeach


@endforeach


@endforeach

  <br> <br>

  <hr style="border: dashed 2px; width: 95%; color: #000000; margin-bottom: 50px">




</body>

</html>