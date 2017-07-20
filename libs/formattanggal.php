<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 3:51
 */
function printKosongRP($isinya)
{
    if($isinya == 0)
        $eco = '-';
    else
        $eco = $isinya;

    return $eco;
}

function formatRP($angka, $rp = false){
    $rupiah=number_format($angka,2,',','.');
    if($rp == true){
        return "Rp ".$rupiah;
    }else{
        return $rupiah;
    }
}

function tglIndo($tanggal, $cetak_hari = false)
{
    $hari = array ( 1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split 	  = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}