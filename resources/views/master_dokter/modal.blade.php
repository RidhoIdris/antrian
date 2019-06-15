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
            <form method="POST" id="form" action="{{ route('master-dokter.store')}}" enctype="multipart/form-data">
        <fieldset>
                @csrf
                <div class="row">
                    <div class="form-group col-12">
                            <input type="hidden" name="id">
                            <input type="text" autocomplete="off" class="form-control" placeholder="Nama Dokter" name="nama_dokter">
                    </div>
                    <div class="form-group col-12">
                        <select class="form-control" name="id_spesialis" id="id_spesialis">
                            <option value="">-- Pilih Spesialis --</option>
                            @foreach ($mspesialis as $ms)
                                <option value="{{$ms->id}}">{{$ms->nama_spesialis}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12">
                            <input type="file" class="form-control" id="image" name="image">
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
