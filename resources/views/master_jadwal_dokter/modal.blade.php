<!-- The Modal -->
<div class="modal fade" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <form method="POST" id="form" action="{{ route('master-jadwal-dokter.store')}}">
        <fieldset>
                @csrf
                <input type="hidden" name="id">
                <div class="row">
                    <div class="form-group col-12">
                        <select class="form-control" name="id_dokter" id="id_dokter">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($mdokter as $md)
                                <option value="{{$md->id}}">{{$md->nama_dokter}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <select class="form-control" name="hari" id="hari">
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="input-group col-12" data-target="#jam_mulai" data-toggle="datetimepicker">

                        <input type="text" autocomplete="off" id="jam_mulai" name="jam_mulai" class="form-control datetimepicker-input" data-target="#jam_mulai">
                        <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                    </div>
                    <br>
                    <div class="input-group col-12" data-target="#jam_selesai" data-toggle="datetimepicker">

                        <input type="text" autocomplete="off" id="jam_selesai" name="jam_selesai" class="form-control datetimepicker-input" data-target="#jam_selesai">
                        <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-prmary" data-dismiss="modal">Batal</button>
                <button type="submit" id="submit" class="btn btn-info">Save</button>
            </div>
        </fieldset>
        </form>
        </div>
    </div>
</div>
