<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 11/06/17
 * Time: 9:06
 */
?>
<div class="modal fade" id="modalPeringatan" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Peringatan Data Sistem !</h4>
            </div>
            <div class="modal-body">
                <p id="modalPeringatanPesan"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailTransaksi" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="pesanDetailTransaksi"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMasterData" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modalMasterDataForm"></div>
            <div class="modal-footer">
                <button type="button" id="btnAksiTambahMaster" class="btn btn-success" >Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>