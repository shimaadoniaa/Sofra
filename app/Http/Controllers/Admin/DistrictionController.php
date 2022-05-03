<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Distriction;
use Illuminate\Http\Request;

class DistrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $districtions=Distriction::with('city')->paginate(5);


        return view('distriction.index',compact('districtions'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'city_id'=>'required'
        ]);
        $distriction= new Distriction();
        $distriction->name=$request->name;
        $distriction->city_id=$request->city_id;

        $distriction->save();

        toastr()->success('Distriction Added');
        return redirect()->route('distriction.index');

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


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {


        $this->validate($request,[
            'name'=>'required',
            'city_id'=>'required'
        ]);

        $distriction=Distriction::findOrfail($id);
        $distriction->update([
            $distriction->name=>$request->name,
            $distriction->city_id=>$request->city_id,


        ]);

        //return $request;

         toastr()->success('Distriction Edited');

        return redirect(route('distriction.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id)
    {
        $distriction=Distriction::findOrfail($id);
        $distriction->delete();

        toastr()->error('Distriction deleted');

        return redirect(route('distriction.index'));
    }
}
