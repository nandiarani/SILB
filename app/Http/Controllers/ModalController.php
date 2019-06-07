<?php

namespace App\Http\Controllers;

use App\Model\Modal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;


class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modal=DB::table('modal')->where('flag_active','=','1')->orderBy('added_at','desc')->paginate(5);
        $i=1;
        return view('modal',['modals'=>$modal,'i'=>$i]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('modal_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modal= new Modal();
        $modal->nominal=request('nominal');
        $modal->tanggal=request('tanggal');
        $modal->added_at=Carbon::now()->toDateTimeString();
        $modal->added_by=Auth::user()->id_user;
        $modal->flag_active='1';
        $modal->save();
        return redirect()->route('modal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_modal)
    {
        $modal=Modal::find($id_modal);
        return view('modal_edit',compact('modal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_modal)
    {
        // $request->validate([
        //     'tanggal'=>'required',
        //     'nominal'=>'required|integer'
        // ]);
        $modal=Modal::find($id_modal);
        $modal->tanggal = $request->get('tanggal');
        $modal->nominal = $request->get('nominal');
        $modal->updated_at=Carbon::now()->toDateTimeString();
        $modal->updated_by=Auth::user()->id_user;
        $modal->save();
        return redirect('modal')->with('success','modal updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_modal)
    {
        $modal=Modal::find($id_modal);
        $modal->flag_active='0';
        $modal->save();
        return redirect()->route('modal.index');

    }

}
