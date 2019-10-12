<?php

namespace App\Http\Controllers;

use App\Model\Mst_Harga_Ikan;
use App\Model\Ukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Log;
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
        $tarif=DB::table('mst_harga_ikan')
                ->join('ukuran','mst_harga_ikan.id_ukuran','=','ukuran.id_ukuran')
                ->select('mst_harga_ikan.id_harga','mst_harga_ikan.harga_per_ekor','ukuran.ukuran','ukuran.size_from_cm','ukuran.size_to_cm')
                ->where('mst_harga_ikan.flag_active','=','1')->paginate(5);
                // dd($tarif);
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
        $ukuran= new Ukuran();
        $ukuran->ukuran=$request->ukuran;
        $ukuran->size_from_cm=$request->uk_dari;
        $ukuran->size_to_cm=$request->uk_sampai;
        $ukuran->added_at=Carbon::now()->toDateTimeString();
        $ukuran->added_by=Auth::user()->id_user;
        $ukuran->flag_active='1';
        $ukuran->save();
        $tarif= new Mst_Harga_Ikan();
        $tarif->harga_per_ekor=request('harga');
        $tarif->id_ukuran=$ukuran->id_ukuran;
        $tarif->added_at=Carbon::now()->toDateTimeString();
        $tarif->added_by=Auth::user()->id_user;
        $tarif->flag_active='1';
        $tarif->save();
        return redirect()->route('tarif.index')->with('success','Kategori harga ikan baru berhasil ditambah!');

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
    public function edit($id_harga)
    {
        $tarif=Mst_Harga_Ikan::find($id_harga);
        $ukuran=Ukuran::find($tarif->id_ukuran);
        return view('harga_ikan.edit',['tarif'=>$tarif,'ukuran'=>$ukuran]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mst_Harga_Ikan  $mst_Harga_Ikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_harga)
    {
        //if ukuran ganti then create new line
        $old_harga=Mst_Harga_Ikan::find($id_harga);
        $old_uk=Ukuran::find($old_harga->id_ukuran);
        if($request->ukuran!=$old_uk->ukuran or $request->uk_dari<>$old_uk->size_from_cm or $request->uk_sampai<>$old_uk->size_to_cm){
            $new_uk=new Ukuran();
            $new_uk->ukuran=$request->ukuran;
            $new_uk->size_from_cm=$request->uk_dari;
            $new_uk->size_to_cm=$request->uk_sampai;
            $new_uk->added_at=Carbon::now()->toDateString();
            $new_uk->added_by=Auth::user()->id_user;
            $new_uk->flag_active='1';
            $new_uk->save();
            $old_uk->updated_at=Carbon::now()->toDateString();
            $old_uk->updated_by=Auth::user()->id_user;
            $old_uk->flag_active='0';
            $old_uk->save();
            $id_ukuran=$new_uk->id_ukuran;
        }
        else{
            $id_ukuran=$old_uk->id_ukuran;
        }
        //create_new_line
        $new_harga= new Mst_Harga_Ikan();
        $new_harga->id_ukuran=$id_ukuran;
        $new_harga->harga_per_ekor=request('harga');
        $new_harga->added_at=Carbon::now()->toDateString();
        $new_harga->added_by=Auth::user()->id_user;
        $new_harga->flag_active='1';
        $new_harga->save();

        //update old line
        $old_harga=Mst_Harga_Ikan::find($id_harga);
        $old_harga->updated_at=Carbon::now()->toDateString();
        $old_harga->updated_by=Auth::user()->id_user;
        $old_harga->flag_active='0';
        $old_harga->save();
        return redirect('tarif')->with('info','Kategori harga ikan berhasil diperbaharui!');
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
        return redirect('tarif')->with('error','Kategori harga ikan berhasil dihapus!');
    }
}
