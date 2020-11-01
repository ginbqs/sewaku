<!doctype html>
<html>
<script>
 window.print();
 </script>
 <style>
table.kasir, th.kasir, td.kasir {
  border: 1px solid black;
  border-collapse: collapse;
}
table {
  width: 100%;
}

th {
  height: 50px;
}
</style>
        <table width="100%">
                <td style='text-align:center;font-size:15px'>{{$nama->value}}</td>  
            </tr>
            <tr>
                <td style='text-align:center;font-size:11px'>{{$alamat->value}}</td>  
            </tr>
            <tr>
                <td style='text-align:center;font-size:15'>-----------------------------------------------</td>  
            </tr>
        </table>
        <br>    
        Pembeli : {{$kasir->pembeli}}
        <br>
        <br>
        <table  width="100%" cellspacing='6' cellpadding='0' class="kasir">
            <tr>
                <th style='text-align:center;font-size:12px' class="kasir">NO</th>
                <th style='text-align:center;font-size:12px' class="kasir">NAMA</th>
                <th style='text-align:center;font-size:12px' class="kasir">QTY</th>
                <th style='text-align:center;font-size:12px' class="kasir">HARGA</th>
                <th style='text-align:center;font-size:12px'  class="kasir">TOTAL</th>
            </tr>
            <?php $i=1; ?>
            @foreach($dt_kasir as $key)
            <tr>
                <td style='text-align:center;font-size:12px' class="kasir">{{$i++}}</td>
                <td style='text-align:center;font-size:12px' class="kasir">{{$key->trans_produk_nama}}</td>
                <td style='text-align:center;font-size:12px' class="kasir">{{$key->jumlah.' '.$key->mst_satuan_nama}}</td>
                <td style='text-align:center;font-size:12px' class="kasir">{{number_format($key->harga_terjual,2)}}</td>
                <td style='text-align:center;font-size:12px'  class="kasir">{{number_format($key->jumlah * $key->harga_terjual,2)}}</td>
            </tr>
            @endforeach
        </table>
        <table width="100%">
            <tr>
                <td style='text-align:center;font-size:15px' colspan="5">-----------------------------------------------</td>  
            </tr>
            <tr>
                <td style='text-align:right;font-size:12px' colspan="2"></td>
                <td style='text-align:right;font-size:12px' >Sub Total</td>
                <td style='text-align:right;font-size:12px' >Rp. {{number_format($kasir->sub_total,2)}}</td>
            </tr>
            <tr>
                <td style='text-align:right;font-size:12px' colspan="2"></td>
                <td style='text-align:right;font-size:12px' >Diskon</td>
                <td style='text-align:right;font-size:12px' >{{$kasir->diskon}}</td>
            </tr>
            <tr>
                <td style='text-align:right;font-size:12px' colspan="2"></td>
                <td style='text-align:right;font-size:12px' >Total Bayar</td>
                <td style='text-align:right;font-size:12px' >Rp. {{number_format($kasir->total_bayar,2)}}</td>
            </tr>
            <tr>
                <td style='text-align:right;font-size:12px' colspan="2"></td>
                <td style='text-align:right;font-size:12px' >Bayar</td>
                <td style='text-align:right;font-size:12px' >Rp. {{number_format($kasir->bayar,2)}}</td>
            </tr>
            <tr>
                <td style='text-align:right;font-size:12px' colspan="2"></td>
                <td style='text-align:right;font-size:12px' >Kembalian</td>
                <td style='text-align:right;font-size:12px' >Rp. {{number_format($kasir->kembalian,2)}}</td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <th style='text-align:center;font-sie:1px'>Terimasih!</th>  
            </tr>
        </table>
<script>
window.close();
</script>
</html>
