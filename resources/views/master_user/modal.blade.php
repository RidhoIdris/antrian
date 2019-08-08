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
            <form method="POST" id="form" action="{{ route('master-user.store')}}">
        <fieldset>
                @csrf
                <div class="row">
                    <div class="form-group col-12">
                        <input type="hidden" name="id">
                        <input type="text" autocomplete="off" class="form-control" placeholder="Nama User" name="name">
                    </div>
                    <div class="form-group col-12">
                        <input type="email" autocomplete="off" class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="form-group col-12">
                        <input type="password" autocomplete="off" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="form-group col-12">
                        <input type="password" autocomplete="off" class="form-control"  name="password_confirmation" placeholder="Repeat Password" name="password_confirmation">
                    </div>
                    <div class="form-group col-12">
                        <select name="role" class="form-control" id="role">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
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
