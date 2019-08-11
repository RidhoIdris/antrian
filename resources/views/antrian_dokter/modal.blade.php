<!-- The Modal -->
<div class="modal fade" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="max-width:80% !important">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="z-index:1000; baground:inherit">
            <h4 class="col-12 modal-title text-center">List Antrian Pasien</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style=" height: calc(100vh - 300px);; overflow-y: scroll !important;">
            <table id="tabel" class="table table-bordered table-hover"  width="100%">
                    <thead>
                    <tr>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Tipe Pembayaran</th>
                        <th>Asuransi</th>
                        <th>Status</th>
                    </tr>
                    </thead>
            </table>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-prmary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
