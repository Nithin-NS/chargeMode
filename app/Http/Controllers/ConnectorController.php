<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connector;

class ConnectorController extends Controller
{
    public function index()
    {
        $data = Connector::paginate(10);
        // dd($data);
        return view('pages/connectors/index')->with('data', $data);
    }

    public function create()
    {
        return view('pages/connectors/create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'Type'=>'required',
            'Remarks'=>'required'
        ]);
        $connector = str_replace(' ', '', $request->Type);
        if(Connector::where('Type', $connector)->exists()){
            return redirect(route('createconnector'))->with('error','already exists');
        }
        else{
                $data=new Connector();
                $data->Type=$request->Type;
                $data->Remarks=$request->Remarks;
                $data->save();
                return redirect(route('connector'))->with('success','Added Successfully');
            }
    }

    public function show($id)
    {
        $data = Connector::find($id);
        return view('pages/connectors/edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        $data = Connector::findorfail($id);
        $validated_data=$this->validate($request,[
            'Type'=>'',
            'Remarks'=>''
        ]);
        
        Connector::whereId($id)->update($validated_data);
        return redirect(route('connector'))->with('success','Updated Successfully');
    }

    public function destroy($id)
    {
        $data=Connector::findorFail($id);
        $data->delete();
        return redirect(route('connector'))->with('success','Deleted Successfully');;
    }

    public function search_connector()
    {
        $search = \Request::get('search');
        // $search = request->search;
        // dd($search);
        $data = Connector::where('Type','like','%'.$search.'%')
            ->orderBy('Type')
            ->paginate(20);

        return view('pages/connectors/index')->with('data',$data);
    }
}