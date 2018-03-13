@extends('redwine::layouts.dashboard')

@section('title', 'ახალი გვერდი')

@section('navbar-title', 'ახალი გვერდი')

@push('styles')
    <style>
        .togglebutton label {
            min-width: 150px;
            text-align: left;
        }

        pre{
            font-size: 10px;
        }

        .code{
            min-width: 330px;
            margin:0px;
            border-radius: 0px;
        }

        .ui-state-highlight{
            height: 155px;
            background: #f0f0f0;
            border: 0px;
        }

        .fa-arrows{
            position: absolute;
            left: 0px;
            top: 0px;
            padding: 8px 8px;
            color: #73379e;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <div class="card" data-border="purple">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="material-icons">note_add</i>
        </div>
        <div class="card-content table-responsive">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">ცხრილი</label>
                        <input type="text" class="form-control" value="{{ $custompage }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">გვერდის სახელი</label>
                        <input type="text" class="form-control" id="displayName">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">ხატულა (Font Awesome & Material Icon)</label>
                        <input type="text" class="form-control" id="icon">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">მოდელი</label>
                        <input type="text" class="form-control" id="modelName" value="{{ $model }}">
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead class="text-pink">
                    <th>ველი</th>
                    <th>ნებართვა</th>
                    <th>ველის ტიპი</th>
                    <th>სახელი</th>
                    <th>დეტალები</th>
                </thead>
                <tbody id="sortable">
                    @foreach($columns as $key => $column)
                        <tr class="column">
                            <td style="position: relative;">
                                <i class="fa fa-arrows" aria-hidden="true"></i>
                                <h3 class="text-primary text-uppercase">{{ $column->Field }}</h3>
                                <pre class="text-pink">{{ $column->Type }}</pre>
                                    @if($column->Null)
                                        <pre class="text-pink">Null: {{ $column->Null }}</pre>
                                    @endif
                                    @if($column->Key)
                                        <pre class="text-pink">Key: {{ $column->Key }}</pre>
                                    @endif
                                    @if($column->Default)
                                        <pre class="text-pink">Default: {{ $column->Default }}</pre>
                                    @endif
                                    @if($column->Extra)
                                        <pre class="text-pink">Extra: {{ $column->Extra }}</pre>
                                    @endif
                            </td>
                            <td class="togglebutton">
                                <label class="text-uppercase">
                                    <input type="checkbox" class="browse">
                                    Browse
                                </label> 
                                <br>
                                <label class="text-uppercase">
                                    <input type="checkbox" class="read">
                                    Read
                                </label>
                                <br>        
                                <label class="text-uppercase">
                                    <input type="checkbox" class="edit">
                                    Edit
                                </label>
                                <br>
                                <label class="text-uppercase">
                                    <input type="checkbox" class="add">
                                    Add
                                </label>
                            </td>
                            <td>
                                <div class="form-group" style="margin-top: -5px;font-family: roboto">
                                    <select class="form-control type">
                                        <option value="">არჩება</option>
                                        <option value="text">text</option>
                                        <option value="textarea (editor)">textarea (Rich Text Editor)</option>
                                        <option value="tinytextarea (editor)">tinytextarea (Rich Text Editor)</option>
                                        <option value="textarea">textarea</option>
                                        <option value="select">select</option>
                                        <option value="checkbox">checkbox</option>
                                        <option value="number">number</option>
                                        <option value="image">image</option>
                                        <option value="hidden">hidden</option>
                                        <option value="password">password</option>
                                        <option value="email">email</option>
                                        <option value="time">timestamp</option>
                                        <option value="date">date</option>
                                        <option value="seo text">seo text</option>
                                        <option value="seo textarea">seo textarea</option>
                                        <option value="seo tag">seo tag</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="margin-top: 0px;">
                                    <input type="text" class="form-control displayName" placeholder="სახელი" style="min-width:120px">
                                </div>
                            </td>
                            <td>
                                <input type="hidden" value="{{ $key }}" class="key">
                                <pre id="editor_{{ $key }}" class="code"></pre>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> <!-- .table -->
        </div> <!-- .card-content -->
    </div> <!-- .card -->
    
    <div class="text-right">
        <button class="btn btn-primary get" @click="get()">გვერდის შექმნა</button>  
    </div>

    
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/ace.js') }}"></script>
    
    <script>
        vue = new Vue({
            el: ".vue",
            data: {
                table: [],
                save: true
            },
            http: {
                emulateJSON: true,
                emulateHTTP: true
            },
            methods: {
                get: function () {

                    this.save = true;

                    if($('#displayName').val() == ""){
                        redwine.note('danger', 'notifications', 'გვერდის სახელი აუცილებელია!');
                        return false;
                    }

                    if($('#icon').val() == ""){
                        redwine.note('danger', 'notifications', 'ხატულა აუცილებელია!');
                        return false;
                    }

                    if($('#modelName').val() == ""){
                        redwine.note('danger', 'notifications', 'მოდელი აუცილებელია!');
                        return false;
                    }

                    $('.get').prop('disabled', true);

                    table = [];

                    $.each($('#sortable').find('.column'), function(i) {

                        var columnDisplayNameCheck = true;

                        var column = new Object();

                        column.columnDisplayName = $(this).find( ".displayName" ).val();

                        column.columnType = $(this).find( ".type" ).val();

                        column.columnName = $(this).find('h3').text();

                        if ($(this).find( ".browse" ).is(':checked')) {

                            column.columnBrowse = 1;

                            if (column.columnDisplayName == "") {
                                columnDisplayNameCheck = false;
                            }

                        } else {
                            column.columnBrowse = 0;
                        }

                        if ($(this).find( ".read" ).is(':checked')) {

                            column.columnRead = 1;

                            if (column.columnDisplayName == "") {
                                columnDisplayNameCheck = false;
                            }

                        } else {
                            column.columnRead = 0;
                        }

                        if ($(this).find( ".edit" ).is(':checked')) {

                            column.columnEdit = 1;

                            if (column.columnDisplayName == "") {
                                columnDisplayNameCheck = false;
                            }

                        } else {
                            column.columnEdit = 0;
                        }

                        if ($(this).find( ".add" ).is(':checked')) {

                            column.columnAdd = 1;

                            if (column.columnDisplayName == "") {
                                columnDisplayNameCheck = false;
                            }

                        } else {
                            column.columnAdd = 0;
                        }

                        if ($(this).find( ".delete" ).is(':checked')) {

                            column.columnDelete = 1;

                            if (column.columnDisplayName == "") {
                                columnDisplayNameCheck = false;
                            }

                        } else {
                            column.columnDelete = 0;
                        }

                        column.position = i + 1;

                        column.id = $(this).find( ".id" ).val();

                        annot = ace.edit('editor_' + $(this).find( ".key" ).val()).getSession().getAnnotations();

                        if (!$.isEmptyObject(annot)) {
                            redwine.note('danger', 'notifications', column.columnName.toUpperCase() + ' ველის დეტალებში შეცდომაა!');
                            vue.save = false;
                        } else {
                           column.columnDetails = ace.edit('editor_' + $(this).find( ".key" ).val()).getValue(); 
                        }

                        table[i] = column;

                        if (!columnDisplayNameCheck) {
                            redwine.note('danger', 'notifications', column.columnName.toUpperCase() + ' ველის სახელის შევსება აუცილებელია!');
                            vue.save = false;
                        }
                    });

                    this.table = table;

                    if (vue.save) {
                        this.create();
                    } else {
                        $('.get').prop('disabled', false);
                    }
                    
                },
                create: function () {
                    var table = new Object();
                    var tableRow = this.table;

                    table.tableName = '{{ $custompage }}';
                    table.displayName = $('#displayName').val();
                    table.icon = $('#icon').val();
                    table.modelName = $('#modelName').val();

                    data = {
                        _token: '{{ csrf_token() }}',
                        page: table,
                        customPageRow: tableRow
                    };
                    
                    Vue.http.post('/redwine/custompage/add', data).then((data) => {

                        $('.get').prop('disabled', false);
                        
                        if (data) {
                            swal({
                                type: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                window.location = '/redwine/database/table';
                            });
                        } else {
                            swal({
                                type: 'error',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }, (response) => {
                        
                        $('.get').prop('disabled', false);

                        swal({
                            type: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        }); 
                    });

                }
            }
        });

        for (var i = 0; i < {{ count($columns) }}; i++) {
            var editor = ace.edit('editor_' + i);
            editor.session.setMode("ace/mode/json");
            editor.setOptions({
                autoScrollEditorIntoView: true,
                maxLines: 25,
                minLines: 12
            });
        }

        $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight",
            handle: ".fa-arrows",
        });
        $( "#sortable" ).disableSelection();
    </script>

@endpush
