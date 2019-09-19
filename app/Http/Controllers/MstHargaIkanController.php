<?php

namespace App\Http\Controllers;

use App\Model\Mst_Harga_Ikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class MstHargaIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarif=DB::table('mst_harga_ikan')->whereNull('updated_at')->paginate(5);
        $i=1;
        return view('harga_ikan.index',['tarifs'=>$tarif,'i'=>$i]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('harga_ikan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tarif= new Mst_Harga_Ikan();
        $tarif->ukuran=request('ukuran');
        $tarif->size_from_cm=request('uk_dari');
        $tarif->size_to_cm=request('uk_sampai');
        $tarif->harga_per_ekor=request('harga');
        $tarif->added_at=Carbon::now()->toDateTimeString();
        $tarif->added_by=Auth::user()->id_user;
        $tarif->flag_active='1';
        $tarif->save();
        return redirect()->route('tarif.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mst_Harga_Ikan  $mst_Harga_Ikan
     * @return \Illuminate\Http\Response
     */
    public function show(Mst_Harga_Ikan $mst_Harga_Ikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mst_Harga_Ikan  $mst_Harga_Ikan
     * @return \Illuminate\Http\Response
     */
    public function edit($id_ukuran)
    {
        $tarif=Mst_Harga_Ikan::find($id_ukuran);
        return view('harga_ikan.edit',compact('tarif'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mst_Harga_Ikan  $mst_Harga_Ikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_ukuran)
    {
        //create_new_line
        $new= new Mst_Harga_Ikan();
        $new->ukuran=request('ukuran');
        $new->size_from_cm=request('uk_dari');
        $new->size_to_cm=request('uk_sampai');
        $new->harga_per_ekor=request('harga');
        $new->added_at=Carbon::now()->toDateString();
        $new->added_by=Auth::user()->id_user;
        $new->flag_active='1';
        $new->save();

        //update old line
        $old=Mst_Harga_Ikan::find($id_ukuran);
        $old->updated_at=Carbon::now()->toDateString();
        $old->updated_by=Auth::user()->id_user;
        $old->flag_active='0';
        $old->save();
        return redirect('tarif')->with('success','tarif updated!');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mst_Harga_Ikan  $mst_Harga_Ikan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_ukuran)
    {
        $tarif=Mst_Harga_Ikan::find($id_ukuran);
        $tarif->updated_at=Carbon::now()->toDateString();
        $tarif->updated_by=Auth::user()->id_user;
        $tarif->flag_active='0';
        $tarif->save();
        return redirect('tarif')->with('success','tarif deleted!');
    }
}
