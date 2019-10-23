<?php

namespace App\Http\Controllers;

use App\Model\Trn_Penjualan;
use App\Model\Mst_Harga_Ikan;
use App\Model\Detil_Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class TrnPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan=DB::table('trn_penjualan')
                    ->select('id_penjualan','total','tanggal')
                    ->where('trn_penjualan.flag_active','=','1')
                    ->orderby('tanggal','desc')
                    ->paginate(10);
        $harga=DB::select('SELECT hrg.id_harga, uk.ukuran, hrg.harga_per_ekor, uk.size_from_cm, uk.size_to_cm FROM mst_harga_ikan hrg join ukuran uk on hrg.id_ukuran=uk.id_ukuran where hrg.flag_active=? and uk.flag_active=?',['1','1']);
        $i=1;
        return view('penjualan.index',['penjualans'=>$penjualan,'hargas'=>$harga,'i'=>$i]);
    }
    
    function getprice($id_ukuran){
        $data=DB::select('SELECT harga_per_ekor FROM mst_harga_ikan where id_harga=?',[$id_ukuran]);
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
        $harga=DB::select('SELECT hrg.id_harga, uk.ukuran, hrg.harga_per_ekor, uk.size_from_cm, uk.size_to_cm FROM mst_harga_ikan hrg join ukuran uk on hrg.id_ukuran=uk.id_ukuran where hrg.flag_active=? and uk.flag_active=?',['1','1']);
        return view('penjualan.create',['today'=>$today,'hargas'=>$harga]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countitem=count($request->harga_per_ekor);
        $penjualan = new Trn_Penjualan();
        $penjualan->total=request('total');
        $penjualan->tanggal=request('tanggal');
        $penjualan->added_at=Carbon::now()->toDateTimeString();
        $penjualan->added_by=Auth::user()->id_user;
        $penjualan->flag_active='1';
        $penjualan->save();
        for($i=0;$i<$countitem;$i++)
        {
            $item= new Detil_Penjualan();
            $item->id_penjualan=$penjualan->id_penjualan;
            $item->id_harga=$request->get('harga_per_ekor')[$i];
            $item->jumlah_ikan=$request->get('jumlah')[$i];
            $harga=Mst_Harga_Ikan::find($item->id_harga)->harga_per_ekor;
            $item->subtotal=$item->jumlah_ikan*$harga;
            $item->added_at=Carbon::now()->toDateTimeString();
            $item->added_by=Auth::user()->id_user;
            $item->flag_active='1';
            $item->save();
        }
        return redirect('/penjualan')->with('success','Transaksi penjualan berhasil dimasukkan!');
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
    public function edit($id_penjualan)
    {
        $penjualan=Trn_Penjualan::find($id_penjualan);
        $tarif=Mst_Harga_Ikan::find($penjualan->id_ukuran);
        $today=Carbon::now()->toDateString();
        //semua tarif by tanggal
        if($penjualan->tanggal==$today){
            $harga=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where flag_active=?',['1']);
        }
        else{
            $harga=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where (? BETWEEN added_at and updated_at) OR (updated_at IS NULL AND added_at<=?)', 
            [$penjualan->tanggal,$penjualan->tanggal]);
        }
        //id harga yang di select default
        $ukuran=$penjualan->id_ukuran;
        return view('penjualan.edit',['penjualan'=>$penjualan,'hargas'=>$harga,'tanggal'=>$penjualan->tanggal,'ukuran'=>$ukuran,'harga_per_ekor'=>$tarif->harga_per_ekor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function updateTanggal(Request $request)
    {
        // dd($request);
        $penjualan = Trn_Penjualan::find($request->id_penjualan);
        $penjualan->tanggal=$request->tanggal;
        $penjualan->updated_at=Carbon::now()->toDateTimeString();
        $penjualan->updated_by=Auth::user()->id_user;
        $penjualan->save();
        return redirect()->route('detil.index',['id_penjualan'=>$request->id_penjualan])->with('info','Tanggal penjualan berhasil diubah!');
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
        $items=DB::table('detil_penjualan')->where('id_penjualan','=',$id_penjualan)->update(['flag_active' =>'0']);
        return redirect('/penjualan')->with('error','Transaksi penjualan berhasil dihapus!');
    }


    //Detil Penjualan

    public function indexDetil($id_penjualan)
    {
        // find detil penjualan where id penjualan== id_penjualan
        $penjualan=Trn_Penjualan::find($id_penjualan);
        $total=$penjualan->total;;
        $detil=DB::table('detil_penjualan')
                ->join('mst_harga_ikan','detil_penjualan.id_harga','=','mst_harga_ikan.id_harga')
                ->join('ukuran','ukuran.id_ukuran','=','mst_harga_ikan.id_ukuran')
                ->select('mst_harga_ikan.harga_per_ekor','ukuran.ukuran','detil_penjualan.jumlah_ikan','detil_penjualan.subtotal','detil_penjualan.id_detil_penjualan')
                ->where([
                    ['detil_penjualan.id_penjualan','=',$id_penjualan],
                    ['detil_penjualan.flag_active','=','1']])
                ->orderby('detil_penjualan.id_detil_penjualan','asc')
                ->get();
        $i=1;
        // dd($detil);
        return view('penjualan.detil_penjualan.index',['detils'=>$detil,'total'=>$total,'penjualan'=>$penjualan,'i'=>$i]);
    }
    public function editDetil($id_detil_penjualan)
    {
        //hidden id penjualan
        $detil=Detil_Penjualan::find($id_detil_penjualan);
        $harga_per_ekor=Mst_Harga_Ikan::find($detil->id_harga)->harga_per_ekor;     
        $harga=DB::select('SELECT hrg.id_harga, uk.ukuran, hrg.harga_per_ekor, uk.size_from_cm, uk.size_to_cm FROM mst_harga_ikan hrg join ukuran uk on hrg.id_ukuran=uk.id_ukuran where hrg.flag_active=? and uk.flag_active=?',['1','1']);
        return view('penjualan.detil_penjualan.edit',['detil'=>$detil,'hargas'=>$harga,'harga_per_ekor'=>$harga_per_ekor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Pengeluaran  $trn_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function updateDetil(Request $request)
    {
        $detil=Detil_Penjualan::find($request->id_detil_penjualan);
        $detil->id_harga=$request->harga_per_ekor;
        $detil->jumlah_ikan=$request->jumlah;
        $detil->subtotal=$request->total;
        $detil->save();
        
        $penjualan=Trn_Penjualan::find($detil->id_penjualan);
        $penjualan->total=DB::table('Detil_Penjualan')
                        ->where([['flag_active','=','1'],
                                ['id_penjualan','=',$penjualan->id_penjualan]])
                        ->sum('subtotal');
        $penjualan->save();
        return redirect()->route('detil.index',['id_penjualan'=>$detil->id_penjualan])->with('info','Detil penjualan berhasil diubah!');
    }
    public function createDetil($id_penjualan)
    {
        $harga=DB::select('SELECT hrg.id_harga, uk.ukuran, hrg.harga_per_ekor, uk.size_from_cm, uk.size_to_cm FROM mst_harga_ikan hrg join ukuran uk on hrg.id_ukuran=uk.id_ukuran where hrg.flag_active=? and uk.flag_active=?',['1','1']);
        return view('penjualan.detil_penjualan.create',['hargas'=>$harga,'id_penjualan'=>$id_penjualan]);
    }

    public function storeDetil(Request $request)
    {
        $detil= new Detil_Penjualan();
        $detil->id_penjualan=$request->id_penjualan;
        $detil->id_harga=$request->harga_per_ekor;
        $detil->jumlah_ikan=$request->jumlah;
        $detil->subtotal=$request->total;
        $detil->flag_active='1';
        $detil->save();
        $penjualan=Trn_Penjualan::find($request->id_penjualan);
        $penjualan->total=$penjualan->total+$request->total;
        $penjualan->save();
        return redirect()->route('detil.index',['id_penjualan'=>$detil->id_penjualan])->with('success','Detil penjualan berhasil ditambah!');
    }

    

    public function destroyDetil($id_detil_penjualan)
    {
        $detil=Detil_Penjualan::find($id_detil_penjualan);
        $detil->flag_active='0';
        $detil->save();

        $penjualan=Trn_Penjualan::find($detil->id_penjualan);
        $penjualan->total=$penjualan->total-$detil->subtotal;        
        if($penjualan->total==0)
            $penjualan->flag_active='0';
        $penjualan->save();
        return redirect()->route('detil.index',['id_penjualan'=>$detil->id_penjualan])->with('error','Transaksi penjualan berhasil dihapus!');
    }
}
