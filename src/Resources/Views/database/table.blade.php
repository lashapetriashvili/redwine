@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.database.database'))

@section('navbar-title', Redwine::userLang('redwine.database.database', [], true))

@section('content')
    
    @if(Redwine::bladePermissionFail('add_database'))
        <a href="/redwine/database/add" class="btn btn-primary btn-round pull-right" style="margin:-10px 0 -6px 0">
            <i class="material-icons">add</i> {{ Redwine::userLang('redwine.database.add new') }}
        </a>
    @endif

    <div class="card" data-border="purple" style="">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="fa fa-cloud" aria-hidden="true"></i>
        </div>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead class="text-pink text-uppercase">
                    <th>ID</th>
                    <th>{{ Redwine::userLang('redwine.database.table') }}</th>
                    <th>{{ Redwine::userLang('redwine.database.model') }}</th>
                    <th>{{ Redwine::userLang('redwine.database.buttons') }}</th>
                </thead>
                <tbody>
                    @if(Redwine::bladePermissionFail('read_database'))
                        @foreach($tables as $key => $table)
                            @php $array = get_object_vars($table); @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-uppercase">{{ reset($array) }}</td>
                                @if($controller->getModel(reset($array)))
                                    <td>{{ $controller->getModel(reset($array)) }}</td>
                                @else
                                    @if(isset($models[reset($array)]))
                                        <td>{{ $models[reset($array)] }}</td>
                                    @else
                                        <td style="color: #999999">{{ Redwine::userLang('redwine.database.find model') }}</td>
                                    @endif
                                @endif
                                <td class="td-actions" style="color: #999999">
                                    @if(!in_array(reset($array), $columns))
                                        @if($controller->checkPage(reset($array)))
                                            <a href="/redwine/page/{{ reset($array) }}" rel="tooltip" class="btn btn-warning btn-simple btn-xs">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            @if(Redwine::bladePermissionFail('edit_custom_page'))
                                                <a href="/redwine/custompage/edit/{{ reset($array) }}" rel="tooltip" class="btn btn-primary btn-simple btn-xs">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            @endif
                                        @endif
                                        @if(!$controller->checkPage(reset($array)))
                                            @if(Redwine::bladePermissionFail('add_custom_page'))
                                                <a href="/redwine/custompage/{{ reset($array) }}" rel="tooltip" class="btn btn-primary btn-simple btn-xs">
                                                    <i class="material-icons">note_add</i>
                                                </a>
                                            @endif
                                        @endif
                                        @if(Redwine::bladePermissionFail('delete_database'))
                                            <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs" @click="deleteTable('{{ reset($array) }}')">
                                                <i class="material-icons">close</i>
                                            </button>
                                        @endif
                                    @else
                                        {{ Redwine::userLang('redwine.database.prohibited') }}
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
                @if(Redwine::bladePermissionFail('delete_database'))
                    deleteTable: function (table) {
                        swal({
                            title: '{{ Redwine::userLang('redwine.database.are you sure') }}',
                            text: '{{ Redwine::userLang('redwine.database.returned back') }}',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: '{{ Redwine::userLang('redwine.database.agreement') }}',
                            cancelButtonText: '{{ Redwine::userLang('redwine.database.cancel') }}',
                            showCloseButton: true,
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/database/delete/' + table, data).then(function (data) {

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