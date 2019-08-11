<!-- The Modal -->
<div class="modal fade" id="modal-profile" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="max-width:80% !important; ">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="z-index:1000; baground:inherit">
            <h4 class="col-12 modal-title text-center">Profile Pasien</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style=" height: calc(100vh - 300px);; overflow-y: scroll !important;">
            <div class="row">
                <div class="form-group col-4">
                    <label for="name"  class="control-label">No Identitas</label>
                    <input type="text"readonly id="no_identitas" class="form-control" value="123456789">
                </div>
                <div class="form-group col-4">
                    <label for="name"  class="control-label">Nama Lengkap</label>
                    <input type="text"readonly id="nama_lengkap" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label for="name"  class="control-label">Jenis Kelamin</label>
                    <input type="text"readonly id="jk" class="form-control" value="Laki-laki">
                </div>
                <div class="form-group col-4">
                    <label for="name"  class="control-label">Tanggal Lahir</label>
                    <input type="text"readonly id="tgl_lahir" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label for="name"  class="control-label">Agama</label>
                    <input type="text"readonly id="agama" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label for="name"  class="control-label">Pendidikan</label>
                    <input type="text"readonly id="pendidikan" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="name"  class="control-label">No Hp</label>
                    <input type="text"readonly id="no_hp" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="name"  class="control-label">Nama Penjamin</label>
                    <input type="text"readonly id="nama_pj" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="name"  class="control-label">No Hp Penjamin</label>
                    <input type="text"readonly id="no_hp_pj" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="name"  class="control-label">Hubungan</label>
                    <input type="text"readonly id="hubungan" class="form-control">
                </div>
                <div class="form-group col-6">
                    <label for="name"  class="control-label">Alamat</label>
                    <textarea class="form-control" readonly rows="5" name="alamat" id="alamat"></textarea>
                </div>
                <div class="form-group col-6">
                    <label for="name"  class="control-label">Alamat Penjamin</label>
                    <textarea class="form-control" readonly rows="5" name="alamat" id="alamat_pj"></textarea>
                </div>
                <div class="form-group col-6">
                    <label for="name"  class="control-label">Foto</label>
                    <br>
                    <img style="width:200px;height:200px;" id="avatar_pasien" src="{{ asset('images/avatar/41560571198.jpg')}}" alt="">
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-prmary" data-dismiss="modal">Batal</button>
        </div>
        </div>
    </div>
</div>
