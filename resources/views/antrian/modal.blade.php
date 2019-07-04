<!-- The Modal -->
<div class="modal fade" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="col-12 modal-title text-center" style="margin-buttom:-25px;"></h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
        <form method="POST" id="form" action="{{ route('home.store')}}" enctype="multipart/form-data">
            <fieldset>
                @csrf
                @method('post')
                <div class="row">
                    <div class="form-group col-12">
                        <input type="hidden" name="id_dokter" id="id_dokter">
                        <input type="hidden" name="no_antrian" id="no_antrian">
                        <select class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="Umum">Umum</option>
                                <option value="Asuransi">Asuransi</option>
                        </select>
                    </div>
                    <div class="form-group col-12 asuransi">
                        <select class="form-control" name="id_asuransi" id="id_asuransi">
                            <option value="">-- Pilih Asuransi --</option>
                            @foreach ($masuransi as $ma)
                                <option value="{{$ma->asuransi_pasien_id}}">{{$ma->nama_asuransi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-prmary" data-dismiss="modal">Batal</button>
                <button type="submit" id="submit" class="btn btn-info">Ambil No Antrian</button>
            </div>
        </fieldset>
        </form>
        </div>
    </div>
</div>
