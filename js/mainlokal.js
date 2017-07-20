/**
 * Created by ardi on 08/06/17.
 */

function detailTransaksiNota(value)
{
    $.ajax({
        type: "POST",
        data: "nonota="+value,
        url: "../libs/detailtransaksi.php",
        success: function (psn) {
            $("#pesanDetailTransaksi").html(psn);
            $("#modalDetailTransaksi").modal('show');
        }
    })
}

function lihatNoNota(name)
{
    var nomor = $(name).val();
    $.ajax({
        type: 'POST',
        data: 'nota='+nomor,
        url: '../libs/prosesnota.php',
        success: function(msg){
            if(msg == 1){
                $("#modalPeringatanPesan").html("Nomor Nota Tersebut Sudah Di Pakai");
                $("#modalPeringatan").modal("show");
                $(name).val('');
            }
        }
    })
}

function lihatKtp(name)
{
    var hasil = '';
    var ktpnya = $(name).val();
    $.ajax({
        type: 'POST',
        data: 'ktp='+ktpnya,
        url: "../libs/prosesktp.php",
        success: function(msg){
            hasil = msg.split('_');
            if(hasil[0] >= 1){
                $("#nama").val(hasil[1]);
                $("#telepon").val(hasil[2]);
                $("#alamat").val(hasil[3]);
                $("#idcustomer").val(hasil[4]);
            }else{
                $("#nama").val('');
                $("#telepon").val('');
                $("#alamat").val('');
                $("#idcustomer").val('');
            }
        }
    })
}

function hitungNilai(name, jumlah, hasil)
{
    var kurs = $(name).val();
    var juml = $("input[name="+jumlah+"]").val();
    var total = kurs * juml;
    $("input[name="+hasil+"]").val(total);
}
