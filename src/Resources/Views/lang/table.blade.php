@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.language.languages'))

@section('navbar-title', Redwine::userLang('redwine.language.languages', [], true))

@section('content')

    @if(Redwine::bladePermissionFail('add_language'))
        <button class="btn btn-primary btn-round pull-right" style="margin:-10px 0 -6px 0" @click="addTable()">
            <i class="material-icons">add</i> {{ Redwine::userLang('redwine.language.add new') }}
        </button>
    @endif

    <div class="card" data-border="purple" style="">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="material-icons">language</i>
        </div>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead class="text-pink text-uppercase">
                    <th>ID</th>
                    <th>{{ Redwine::userLang('redwine.language.folder') }}</th>
                    <th>{{ Redwine::userLang('redwine.language.buttons') }}</th>
                </thead>
                <tbody>
                    @if(Redwine::bladePermissionFail('read_language'))
                        @php $array = ['redwine', 'pages'] @endphp
                        @foreach($directories as $key => $lang)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-uppercase">{{ basename($lang) }}</td>
                                <td>
                                    @if(Redwine::bladePermissionFail('read_language'))
                                        <a href="/redwine/lang/language/read/{{ basename($lang) }}" rel="tooltip" class="btn btn-warning btn-simple btn-xs">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    @endif
                                    @if(!in_array(basename($lang), $array))
                                        @if(Redwine::bladePermissionFail('edit_language'))
                                            <button rel="tooltip" class="btn btn-primary btn-simple btn-xs" @click="editTable('{{ basename($lang) }}')">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        @endif
                                        @if(Redwine::bladePermissionFail('delete_language'))
                                            <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs" @click="deleteTable('{{ basename($lang) }}')">
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
            data: {
                languages: [],
            },
            http: {
                emulateJSON: true,
                emulateHTTP: true
            },
            methods: {
                @if(Redwine::bladePermissionFail('add_language'))
                    addTable: function () {
                        swal({
                            title: '{{ Redwine::userLang('redwine.language.add folder') }}',
                            input: 'text',
                            confirmButtonText: '{{ Redwine::userLang('redwine.language.add') }}',
                            allowOutsideClick: () => !swal.isLoading()
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/lang/directorie/add/' + result.value, data).then(function (data) {
                                    if (data.body) {
                                        swal({
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else {
                                        swal({
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                });
                            }
                        });
                    },
                @endif
                @if(Redwine::bladePermissionFail('edit_language'))
                    editTable: function (name) {
                        swal({
                            title: '{{ Redwine::userLang('redwine.language.edit folder') }}',
                            input: 'text',
                            confirmButtonText: '{{ Redwine::userLang('redwine.language.edit') }}',
                            inputValue : name,
                            allowOutsideClick: () => !swal.isLoading()
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/lang/directorie/edit/' + name + '/' + result.value, data).then(function (data) {
                                    if (data.body) {
                                        swal({
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else {
                                        swal({
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                });
                            }
                        });
                    },
                @endif
                @if(Redwine::bladePermissionFail('delete_language'))
                    deleteTable: function (name) {
                        swal({
                            title: '{{ Redwine::userLang('redwine.language.are you sure') }}',
                            text: '{{ Redwine::userLang('redwine.language.returned back') }}',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: '{{ Redwine::userLang('redwine.language.agreement') }}',
                            cancelButtonText: '{{ Redwine::userLang('redwine.language.cancel') }}',
                            showCloseButton: true,
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/lang/directorie/delete/' + name, data).then(function (data) {
                                    if (data.body) {
                                        swal({
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else {
                                        swal({
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                });
                            }
                        });
                    }
                @endif
            }
        });
    </script>
@endpush