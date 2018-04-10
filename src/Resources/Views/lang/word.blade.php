@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.language.languages'))

@section('navbar-title', strtoupper($directorie . '/' . $language . '/' . $file))

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
                    <th>{{ Redwine::userLang('redwine.language.name') }}</th>
                    <th>{{ Redwine::userLang('redwine.language.translation') }}</th>
                    <th>{{ Redwine::userLang('redwine.language.code') }}</th>
                    <th>{{ Redwine::userLang('redwine.language.buttons') }}</th>
                </thead>
                <tbody>
                    @if(Redwine::bladePermissionFail('read_language'))
                        @php $number = 0 @endphp
                        @foreach($words as $key => $word)
                            <tr>
                                <td>{{ ++$number }}</td>
                                <td>{{ $key }}</td>
                                <td>{{ $word }}</td>
                                <td>Redwine::lang(&#x27;{{ $directorie }}.{{ $file }}.{{ $key }}&#x27;)</td>
                                <td>
                                    @if(Redwine::bladePermissionFail('edit_language'))
                                        <button rel="tooltip" class="btn btn-primary btn-simple btn-xs" @click="editTable('{{ basename($word) }}', '{{ $key }}')">
                                            <i class="material-icons">edit</i>
                                        </button>
                                    @endif
                                    @if(Redwine::bladePermissionFail('delete_language'))
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs" @click="deleteTable('{{ $key }}')">
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
                            title: '{{ Redwine::userLang('redwine.language.add') }}',
                            html:
                                '<input type="text" id="swal-input1" class="swal2-input" placeholder="{{ Redwine::userLang('redwine.language.name') }}">' + 
                                '<textarea style="height:150px; padding-top:10px" id="swal-input2" class="swal2-input" placeholder="{{ Redwine::userLang('redwine.language.translation') }}"></textarea>',
                            confirmButtonText: '{{ Redwine::userLang('redwine.language.add') }}',
                            preConfirm: function () {
                                return new Promise(function (resolve) {
                                    resolve([
                                        $('#swal-input1').val(),
                                        $('#swal-input2').val()
                                    ])
                                })
                            },
                            onOpen: function () {
                                $('#swal-input1').focus()
                            }
                        }).then(function (result) {
                            if (result.dismiss != 'overlay') {
                                console.log(result);
                                data = {
                                    _token: '{{ csrf_token() }}',
                                    directorie: '{{ $directorie }}',
                                    language: '{{ $language }}',
                                    file: '{{ $file }}',
                                    name: result.value[0],
                                    lang: result.value[1]
                                };

                                vue.$http.post('/redwine/lang/word/add', data).then(function (data) {
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
                            
                        }).catch(swal.noop);
                    },
                @endif
                @if(Redwine::bladePermissionFail('edit_language'))
                    editTable: function (name, lang) {
                        swal({
                            title: '{{ Redwine::userLang('redwine.language.edit') }}',
                            html:
                                '<textarea style="height:150px; padding-top:10px" id="swal-input1" class="swal2-input" placeholder="{{ Redwine::userLang('redwine.language.translation') }}">' + name + '</textarea>',
                            confirmButtonText: '{{ Redwine::userLang('redwine.language.edit') }}',
                            preConfirm: function () {
                                return new Promise(function (resolve) {
                                    resolve([
                                        $('#swal-input1').val()
                                    ])
                                })
                            },
                            onOpen: function () {
                                $('#swal-input1').focus()
                            }
                        }).then(function (result) {
                            if (result.dismiss != 'overlay') {
                                console.log(result);
                                data = {
                                    _token: '{{ csrf_token() }}',
                                    directorie: '{{ $directorie }}',
                                    language: '{{ $language }}',
                                    file: '{{ $file }}',
                                    oldLang: lang,
                                    name: result.value[0]
                                };

                                vue.$http.post('/redwine/lang/word/edit', data).then(function (data) {
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
                            
                        }).catch(swal.noop);
                    },
                @endif
                @if(Redwine::bladePermissionFail('delete_language'))
                    deleteTable: function (lang) {
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
                                    _token: '{{ csrf_token() }}',
                                    directorie: '{{ $directorie }}',
                                    language: '{{ $language }}',
                                    file: '{{ $file }}',
                                    lang: lang
                                };

                                this.$http.post('/redwine/lang/word/delete', data).then(function (data) {
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
