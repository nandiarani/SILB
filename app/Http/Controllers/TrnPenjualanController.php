<?php

namespace App\Http\Controllers;

use App\Model\Trn_Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class TrnPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan=DB::table('trn_penjualan')->where('flag_active','=','1')->paginate(5);
        $i=1;
        return view('penjualan',['penjualans'=>$penjualan,'i'=>$i]);
        // $date=date('07-08-2019');
        // $data=DB::table('history_mst_tarif')
        //         ->select('id_ukuran','ukuran','size_from_cm','size_to_cm','harga_per_ekor')
        //         ->where('added_at','>=',$date)->where('updated_at','<=',$date)
        //         ->orWhereNull('updated_at')
        //         ->get();
        // echo json_encode($data);
    }
    
    function fetch($date)
    {
        // $data=DB::table('history_mst_tarif')
        //         ->select('id_ukuran','ukuran','size_from_cm','size_to_cm','harga_per_ekor')
        //         ->where('added_at','<=',$date)->where('updated_at','>=',$date)
        //         -orWhere(function($query) use ($date){
        //             $query->where('added_at','<=',$date)
        //                     ->whereNUll('updated_at');
        //         })
        //         ->get();
        $data=DB::select('SELECT id_ukuran, harga_per_ekor FROM history_mst_tarif where :tanggal1 BETWEEN added_at and updated_at or (updated_at is null and added_at<= :tanggal2)', 
                    ['tanggal1'=>$date,
                    'tanggal2'=>$date
                    ]);
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today=Carbon::now()->toDateString();
        // $harga=DB::table('history_mst_tarif')
        //             ->select('id_ukuran','ukuran','size_from_cm','size_to_cm','harga_per_ekor')
        //             ->where('added_at','<=',$today)->where('updated_at','>=',$today)
        //             ->get();
        $harga=DB::select('SELECT id_ukuran, harga_per_ekor FROM history_mst_tarif where :tanggal1 BETWEEN added_at and updated_at or (updated_at is null and added_at<= :tanggal2)', 
                ['tanggal1'=>$today,
                'tanggal2'=>$today
                ]);
        
        return view('penjualan_create',['today'=>$today,'hargas'=>$harga]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_penjualan)
    {
        $penjualan=Trn_Penjualan::find($id_penjualan);
        $penjualan->flag_active='0';
        $penjualan->save();
        return redirect('/penjualan');
    }
}
