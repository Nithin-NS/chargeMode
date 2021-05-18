<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChargePoint;

class CustomerController extends Controller
{
    public function index()
    {
        $data = User::all();
        $chargepoints = ChargePoint::all();
        // dd($chargepoints);
        return view('pages.Customers.index')->with('data', $data)->with('chargepoints', $chargepoints);
    }

    public function getUserDetails(){
        $data = User::all();
        return $data;
    }

    public function findChargePoints(){
        $data = ChargePoint::all();
        return $data;
    }

    public function create()
    {
        return view('pages.Customers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            // 'User_Type'=>'required',
            'User_Name'=>'required',
            'User_Mobile'=>'required',
            'User_email'=>'required',
            // 'User_Password'=>'required',
            'User_Password' => 'required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required',
            'User_Address'=>'required',
            'User_Pin'=>'required',
            'User_State'=>'required',
            'User_District'=>'required',
        ]);

        $data = new User();
        $data->user_id = $this->getUserID();
        $data->name=$request->User_Name;
        $data->mobile=$request->User_Mobile;
        $data->email =$request->User_email;
        $data->password=bcrypt($request->User_Password);
        $data->address=$request->User_Address;
        $data->pin=$request->User_Pin;
        $data->state=$request->User_State;
        $data->district=$request->User_District;
        $data->Status=0;
        $data->save();

        return redirect(route('customers'))->with('success','Added Successfully');;
    }

    //User ID generator
    public function getUserID(){
    do{

        // generate a 4 Digit pin
        $pin = rand(1000, 9999);

        // shuffle the result
        $UniqueId = str_shuffle($pin);
    }
        while(!empty(User::where('user_id',$UniqueId)->first()));
            return $UniqueId;
    }

    public function show($id)
    {
        $data = User::where('id',$id)->first();
        return view('pages.customers.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        $validated_data=$this->validate($request,[
            // 'User_Type'=>'',
            'User_Name'=>'',
            'User_Mobile'=>'',
            'User_Email'=>'',
            // 'User_Password'=>'',
            'User_Address'=>'',
            'User_Pin'=>'',
            'User_State'=>'',
            'User_District'=>'',
        ]);
        // User::where('id',$id)->update($validated_data);

        User::whereId($id)->update([
            'name' => $request->User_Name,
            'mobile' => $request->User_Mobile,
            'email' => $request->User_Email,
            'address' => $request->User_Address,
            'pin' => $request->User_Pin,
            'state' => $request->User_State,
            'district' => $request->User_District,
            // 'Trans_Meter_Stop' => $request->Trans_Meter_Stop,
        ]);

        return redirect(route('customers'))->with('success','Updated Successfully');;
    }

    public function destroy($id)
    {
            User::findorFail($id)->delete();
            return redirect(route('customers'))->with('success','Deleted Successfully');
    }

    // public function deactivate($id)
    // {
    //     Customers::where('User_ID', $id)->update(array('Status' => 'Deactive'));
    //     return redirect('/customer')->with('success','Deactivated Successfully');;
    // }

    public function searchcustomer()
    {
        $search = \Request::get('search');
        $data = User::where('name','like','%'.$search.'%')
            ->orWhere('user_id','like','%'.$search.'%')
            ->orWhere('mobile','like','%'.$search.'%')
            ->orWhere('email','like','%'.$search.'%')
            ->orderBy('name')
            ->paginate(20);

        return view('pages.Customers.index')->with('data',$data);
    }
}
