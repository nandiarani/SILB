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
        .left{
            text-align: left;
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

        .footer td{
            font: 13px sans-serif;
            font-weight: bold;
            padding: 10px 0px;
        }
    </style>
    <br>
	<center>
        <h3>LAPORAN KEUANGAN</h3>
        <h4>{{$periode}}</h4>
	</center>
<br>
<p>Per {{$today}}</p>
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
			@foreach($datas as $d)
			<tr>
                <td>{{ $i++ }}</td>
				<td>{{date('d-m-Y', strtotime($d->tanggal))}}</td>
				<td>{{$d->tipe}}</td>
                <td class="left">{{$d->keterangan}}</td>
				<td class="left total">Rp. {{number_format($d->harga_satuan,0,',','.')}}</td>
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
			</tr><tr class="footer">
                <td colspan="6">Profit periode {{$periode}}</td>
                @if ($saldo>0)                
    				<td colspan="2">Rp. {{number_format($saldo,0,',','.')}}</td>
                @else
				    <td colspan="2" style="color:red;">Rp. {{number_format($saldo,0,',','.')}}</td>
                @endif
			</tr>
		</tbody>
	</table>

</body>
</html>