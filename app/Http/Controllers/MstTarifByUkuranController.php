<?php

namespace App\Http\Controllers;

use App\Model\Mst_Tarif_By_Ukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;


class MstTarifByUkuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarif=DB::table('mst_tarif_by_ukuran')->where('flag_active','=','1')->paginate(5);
        $i=1;
        return view('tarif',['tarifs'=>$tarif,'i'=>$i]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tarif_create');
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
        $tarif= new Mst_Tarif_By_Ukuran();
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
     * @param  \App\Mst_Tarif_By_Ukuran  $mst_Tarif_By_Ukuran
     * @return \Illuminate\Http\Response
     */
    public function show(Mst_Tarif_By_Ukuran $mst_Tarif_By_Ukuran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Mst_Tarif_By_Ukuran  $mst_Tarif_By_Ukuran
     * @return \Illuminate\Http\Response
     */
    public function edit($id_ukuran)
    {
        $tarif=Mst_Tarif_By_Ukuran::find($id_ukuran);
        return view('tarif_edit',compact('tarif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mst_Tarif_By_Ukuran  $mst_Tarif_By_Ukuran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_ukuran)
    {
        $tarif=Mst_tarif_by_ukuran::find($id_ukuran);
        $tarif->ukuran = $request->get('ukuran');
        $tarif->size_from_cm = $request->get('uk_dari');
        $tarif->size_to_cm = $request->get('uk_sampai');
        $tarif->harga_per_ekor = $request->get('harga');
        $tarif->updated_at=Carbon::now()->toDateTimeString();
        $tarif->updated_by=Auth::user()->id_user;
        $tarif->save();
        return redirect('tarif')->with('success','tarif updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mst_Tarif_By_Ukuran  $mst_Tarif_By_Ukuran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_ukuran)
    {
        $tarif=Mst_Tarif_By_Ukuran::find($id_ukuran);
        $tarif->flag_active='0';
        $tarif->save();
        return redirect()->route('tarif.index');
    }
}
