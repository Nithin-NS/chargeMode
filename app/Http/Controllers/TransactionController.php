<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Transaction::paginate(10);
        // dd($data);
        return view('pages/transactions/index')->with('data',$data);
    }

    public function show($id)
    {
        $data=Transaction::findorfail($id);
        return view('pages/transactions/edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        $date = $request->Trans_DateTime;
        $Trans_DateTime = (new Carbon($date))->format('d-m-y H:i:s');
        // dd($Trans_DateTime);

        $validated_data=$this->validate($request,[
            'Connector_ID'=>'',
            'CP_ID'=>'',
            'CS_ID'=>'',
            'User_ID'=>'',
            'Reservation_ID'=>'',
            'Trans_DateTime'=>'',
            'Trans_Meter_Start'=>'',
            'Trans_Meter_Stop'=>''
        ]);
        Transaction::whereId($id)->update([
                'Connector_ID' => $request->Connector_ID,
                'CP_ID' => $request->CP_ID,
                'CS_ID' => $request->CS_ID,
                'User_ID' => $request->User_ID,
                'Reservation_ID' => $request->Reservation_ID,
                'Trans_DateTime' => $Trans_DateTime,
                'Trans_Meter_Start' => $request->Trans_Meter_Start,
                'Trans_Meter_Stop' => $request->Trans_Meter_Stop,
            ]);
        return redirect(route('transactions'))->with('success','Added Successfully');
    }
    public function destroy($id)
  {
        $data=Transaction::findorFail($id)->delete();
        return redirect(route('transactions'))->with('success','Deleted Successfully');
  }
}
