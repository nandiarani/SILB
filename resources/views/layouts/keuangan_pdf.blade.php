<!DOCTYPE html>
<html>
<head>
	<title>Laporan Keuangan {{$today}}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
        td{
            text-align: center;
        }
        p{
            text-align: right;
            font: 13px;
            margin: 2px;
        }
        h3{
            font-family: 'Century Gothic';
            font-weight: 700;
            text-transform: uppercase;
        }
        .page-break {
            page-break-after: always;
        }
        .left{
            text-align: left;
        }
        .right{
            text-align:right;
        }
        .left.total{
            padding-left: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 6px;
            vertical-align: top;
            border-top: 1px solid #c8ced3;
            font: 11px sans-serif;
        }

        .table thead th {
            text-align: center;
            vertical-align: middle;
            border-bottom: 2px solid #c8ced3;
            font-weight: bold;
        }
        .minus{
            color: red;
        }
        .footer td{
            font: 13px sans-serif;
            font-weight: bold;
            padding: 10px 0px;
        }
    </style>
    <br>
    
<div class="page-break">
	<center>
        <h3>LAPORAN KEUANGAN {{$periode}}</h3>
	</center>
<br>
<p>Dibuat: {{$today}}</p>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th style="text-align:center;width:3%;">No</th>
				<th style="width:10%;">Tanggal</th>
				<th style="width:10%;">Jenis Transaksi</th>
				<th>Keterangan</th>
				<th>Harga Satuan</th>
				<th style="width:10%;">Jumlah</th>
				<th>Saldo Keluar</th>
				<th>Saldo Masuk</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($tabel_keuangan as $d)
			<tr>
                <td>{{ $i++ }}</td>
				<td>{{date('d-m-Y', strtotime($d->tanggal))}}</td>
				<td>{{$d->tipe}}</td>
                <td class="left">{{$d->keterangan}}</td>
                @if ($d->harga_satuan==="")
				<td class="left total"></td>
                @else
				<td class="left total">Rp. {{number_format($d->harga_satuan,0,',','.')}}</td>
                    
                @endif
                <td>{{$d->jumlah}}</td>
                @if ($d->tipe==='Penjualan')
                    <td></td>
                    <td class="left total">Rp. {{number_format($d->total,0,',','.')}}</td>
                @else
                    <td class="left total">Rp. {{number_format($d->total,0,',','.')}}</td>
                    <td></td>
                @endif
			</tr>
			@endforeach
			<tr class="footer">
                <td colspan="6">Total</td>
				<td>Rp. {{number_format($total_keluar,0,',','.')}}</td>
				<td>Rp. {{number_format($total_jual,0,',','.')}}</td>
            </tr>
            <tr class="footer">
                <td colspan="6">Laba kotor</td>
                @if ($saldo>0)                
    				<td colspan="2">Rp. {{number_format($saldo,0,',','.')}}</td>
                @else
				    <td colspan="2" class="minus">Rp. {{number_format($saldo,0,',','.')}}</td>
                @endif
			</tr>
		</tbody>
    </table>
</div>
<h3 style="text-align:center;">Profit pada {{$periode}}</h6>
    <br>
    <br>
    <p style="margin-right:10%">Dibuat: {{$today}}</p>
    <div style="margin-left:10%;width:80%;padding-top:10px;">
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th style="width:75%">Keterangan</th>
                        <th style="width:25%">Nominal</th>
                    </tr>
                </thead>
                <tbody >
                    {{-- modal --}}
                        <tr>
                            <td class="left">Modal sebelum {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['m_before'],0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="left">Modal {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['m_now'],0,',','.')}}</td>
                        </tr>
                        <tr class="footer">
                            <td>Total Modal</td>
                            <td>Rp. {{number_format($tabel_profit['m_after'],0,',','.')}}</td>
                        </tr>
                    {{-- pengeluaran --}}
                        <tr>
                            <td class="left">Pengeluaran sebelum {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['o_before'],0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="left">Pengeluaran {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['o_now'],0,',','.')}}</td>
                        </tr>
                        <tr class="footer">
                            <td>Total Pengeluaran</td>
                            <td>Rp. {{number_format($tabel_profit['o_after'],0,',','.')}}</td>
                        </tr>
                    {{-- penjualan --}}
                        <tr>
                            <td class="left">Penjualan sebelum {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['s_before'],0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="left">Penjualan {{$periode}}</td>
                            <td>Rp. {{number_format($tabel_profit['s_now'],0,',','.')}}</td>
                        </tr>
                        <tr class="footer">
                            <td >Total Penjualan</td>
                            <td>Rp. {{number_format($tabel_profit['s_after'],0,',','.')}}</td>
                        </tr>
                        <tr class="footer">
                            <td >Laba bersih</td>
                            
                            @if ($tabel_profit['profit']>0)                
                            <td>Rp. {{number_format($tabel_profit['profit'],0,',','.')}}</td>
                            @else
                            <td class="minus">Rp. {{number_format($tabel_profit['profit'],0,',','.')}}</td>
                            @endif
                        </tr>
                </tbody>
            </table>
    </div>
</body>
</html>