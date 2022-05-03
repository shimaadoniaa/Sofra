<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Paid;
use Illuminate\Http\Request;

class PaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paids=Paid::where(function ($q) use($request){
          if($request->input('restaurant_id')){
           $q->where('restaurant_id',$request->restaurant_id);
          }

        })->paginate(8);
        return view('paid.index',compact('paids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation=$this->validate($request,[
            'restaurant_id'=>'required',
            'amount'=>'required'
            ]);
        $paid=Paid::create([
            'restaurant_id'=>$request->restaurant_id,
            'amount'=>$request->amount
        ]);
        $paid->save();

        toastr()->success('created');
        return redirect(route('paid.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation=$this->validate($request,[
            'restaurant_id'=>'required',
            'amount'=>'required'
        ]);
        $paid=Paid::findOrfail($id);
        $paid->update([

         'restaurant_id'=>$request->restaurant_id,
          'amount'=>$request->amount
        ]);

        toastr()->success('updated');
        return redirect(route('paid.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paid=Paid::findOrfail($id);
        $paid->delete();

        toastr()->error('deleted');
        return redirect(route('paid.index'));
    }
}
