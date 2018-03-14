@extends('redwine::layouts.dashboard')

@section('title', 'მენიუ')

@section('navbar-title', 'მენიუ')

@section('content')
    
    @if(Redwine::bladePermissionFail('add_menu'))
        <a href="/redwine/menu/add" class="btn btn-primary btn-round pull-right" style="margin:-10px 0 -6px 0">
            <i class="material-icons">add</i> ახლის დამატება
        </a>
    @endif

    <div class="card" data-border="purple" style="">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead class="text-pink">
                    <th>ID</th>
                    <th>სახელი</th>
                    <th>ღილაკები</th>
                </thead>
                <tbody>
                    @if(Redwine::bladePermissionFail('read_menu'))
                        @php $number = 0; @endphp
                        @foreach ($array as $menu)
                            <tr>
                                <td>{{ ++$number }}</td>
                                <td>{{ $menu }}</td>
                                <td>
                                    @if(Redwine::bladePermissionFail('add_menu'))
                                        <a href="/redwine/menu/edit/{{ $menu }}" rel="tooltip" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">edit</i>
                                        </a>
                                    @endif
                                    @if(Redwine::bladePermissionFail('delete_menu'))
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs" @click="deleteTable('{{ $menu }}')">
                                            <i class="material-icons">close</i>
                                        </button>
                                    @endif
                                </td>   
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table> <!-- .table -->
        </div> <!-- .card-content -->
    </div> <!-- .card -->

@endsection

@push('scripts')
    <script>
        vue = new Vue({
            el: ".vue",
            http: {
                emulateJSON: true,
                emulateHTTP: true
            },
            methods: {
                @if(Redwine::bladePermissionFail('delete_menu'))
                    deleteTable: function (name) {
                        swal({
                            title: 'დარწმუნებული ხარ?',
                            text: 'ამ მოქმედებას უკან ვერ დააბრუნებ!',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: 'თანხმობა',
                            cancelButtonText: 'გაუქმება',
                            showCloseButton: true,
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/menu/menus/delete/' + name, data).then(function (data) {

                                    swal({
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then((result) => {
                                        location.reload();
                                    });
                                });
                            }
                        });
                    }
                @endif
            }
        });
    </script>
@endpush
