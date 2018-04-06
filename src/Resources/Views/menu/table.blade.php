@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.menu page.menu'))

@section('navbar-title', Redwine::userLang('redwine.menu page.menu', [], true))

@section('content')
    
    @if(Redwine::bladePermissionFail('add_menu'))
        <a href="/redwine/menu/add" class="btn btn-primary btn-round pull-right" style="margin:-10px 0 -6px 0">
            <i class="material-icons">add</i> {{ Redwine::userLang('redwine.menu page.add new') }}
        </a>
    @endif

    <div class="card" data-border="purple" style="">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead class="text-pink text-uppercase">
                    <th>ID</th>
                    <th>{{ Redwine::userLang('redwine.menu page.name') }}</th>
                    <th>{{ Redwine::userLang('redwine.menu page.buttons') }}</th>
                </thead>
                <tbody>
                    @if(Redwine::bladePermissionFail('read_menu'))
                        @php 
                            $number = 0;
                            $redwineArray  = ['redwine', 'footer redwine']; 
                        @endphp
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
                                    @if(!in_array($menu, $redwineArray))
                                        @if(Redwine::bladePermissionFail('delete_menu'))
                                            <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs" @click="deleteTable('{{ $menu }}')">
                                                <i class="material-icons">close</i>
                                            </button>
                                        @endif
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
                            title: '{{ Redwine::userLang('redwine.menu page.are you sure') }}',
                            text: '{{ Redwine::userLang('redwine.menu page.returned back') }}',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: '{{ Redwine::userLang('redwine.menu page.agreement') }}',
                            cancelButtonText: '{{ Redwine::userLang('redwine.menu page.cancel') }}',
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
                                        timer: 1000
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
