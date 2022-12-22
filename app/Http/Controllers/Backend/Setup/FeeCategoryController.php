<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\DiscountStudents;
use Illuminate\Http\Request;
use App\Models\FeeCategory; 
use App\Models\Month;
use App\Models\FeePaid;
use App\Models\TransportFee;
use PDF;

class FeeCategoryController extends Controller
{
    public function ViewFeeCat(){
    	$data['allData'] = FeeCategory::all();
    	return view('backend.setup.fee_category.view_fee_cat',$data);
 
    }


    public function FeeCatAdd(){
    	return view('backend.setup.fee_category.add_fee_cat');
    }


public function FeeCatStore(Request $request){



	// dd($request)->toArray();

	    	$validatedData = $request->validate([
	    		'name' => 'required|unique:fee_categories,name',
	    		
	    	]);

	    	$data = new FeeCategory();
	    	$data->name = $request->name;
	    	$data->save();
	    	// $data1 = FeeCategory::find($data->id);


			$months = $request->month;


	// dd($data1)->toArray();

			$data->month()->attach($months);

	    	$notification = array(
	    		'message' => 'Fee Category Inserted Successfully',
	    		'alert-type' => 'success'
	    	);

	    	return redirect()->route('fee.category.view')->with($notification);

	    }



	 public function FeeCatEdit($id){
	    	$editData = FeeCategory::find($id);
	    	return view('backend.setup.fee_category.edit_fee_cat',compact('editData'));

	    }



	 public function FeeCategoryUpdate(Request $request,$id){

	 $data = FeeCategory::find($id);
     
     $validatedData = $request->validate([
    		'name' => 'required|unique:fee_categories,name,'.$data->id
    		
    	]);

    	
    	$data->name = $request->name;
    	$data->save();

    	$notification = array(
    		'message' => 'Fee Category Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('fee.category.view')->with($notification);
    }


        public function FeeCategoryDelete($id){
	    	$user = FeeCategory::find($id);
	    	$user->delete();

	    	$notification = array(
	    		'message' => 'Fee Category Deleted Successfully',
	    		'alert-type' => 'info'
	    	);

	    	return redirect()->route('fee.category.view')->with($notification);

	    }

		public function FeeStruStore(Request $request){

			// dd($request)->toArray();
			// $data = DiscountStudents::find($request->id );



    	    $countDis = count($request->fee_category_id);
			DiscountStudents::where('assign_student_id',$request->id)->delete(); 

			for ($i=0; $i <$countDis ; $i++) { 


				$discount = new DiscountStudents();
				$discount->assign_student_id = $request->id;
				$discount->fee_category_id = $request->fee_category_id[$i];
				$discount->discount = $request->discount[$i];
				$discount->remark = $request->remark[$i];
				$discount->save();
	
    		}

			  




	    //    $data = TransportFee::find($request->id);



    	    // $countMonth = count($request->month);

			$months = $request->month;

	
		   
		   $trans=	TransportFee::where('student_id',$request->id)->first(); 

			if ($trans !=NULL){

		        $data=	TransportFee::find($trans->id); 
		        $data->student_id = $request->id;
				$data->amount = $request->amount;
				$data->route = $request->route;
				$data->save();

				$data->month()->sync($months);
			}
			else{

				$data = new TransportFee();
				$data->student_id = $request->id;
				$data->amount = $request->amount;
				$data->route = $request->route;
				$data->save();
		
				$data->month()->attach($months);
			}

	
	
				// dd($data1)->toArray();
			
				// $data->month()->attach($months);
				// $data->month()->detach($months);




			return redirect()->route('student.registration.view');



		}

		public function FeePaid(Request $request){


			// dd($request->month);



			// $months = $request->month;


			// $val=	FeePaid::where('student_id',$request->id)->first(); 



			if($months = $request->month){

			$data = new FeePaid();
			$data->student_id = $request->id;
			$data->save();
	
			$data->month()->attach($months);
			}

	  



			return redirect()->route('student.registration.view');



			

		}

		public function FeePaidView(){





	    	$allData = FeePaid::all();


			// dd($allData);

	    	return view('backend.student.fee_paid.fee_paid',compact('allData'));



		}

		public function FeePaidViewPdf( $id){


			$data['id'] = $id;




			$pdf = PDF::loadView('backend.student.fee_paid.fee_paid_pdf',$data);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');





	        return $pdf->stream('document.pdf');





		}



}
