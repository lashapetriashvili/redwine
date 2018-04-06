@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.pages.edit page'))

@section('navbar-title', Redwine::userLang('redwine.pages.edit page'))

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
                        <label class="control-label">{{ Redwine::userLang('redwine.pages.table', [], true) }}</label>
                        <input type="text" class="form-control" value="{{ $table }}" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.pages.page name', [], true) }}</label>
                        <input type="text" class="form-control" id="displayName" value="{{ $customPage->display_name }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.pages.icon', [], true) }} (Font Awesome & Material Icon)</label>
                        <input type="text" class="form-control" id="icon" value="{{ $customPage->icon }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.pages.model', [], true) }}</label>
                        <input type="text" class="form-control" id="modelName" value="{{ $customPage->model }}">
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead class="text-pink text-uppercase">
                    <th>{{ Redwine::userLang('redwine.pages.column') }}</th>
                    <th>{{ Redwine::userLang('redwine.pages.permission') }}</th>
                    <th>{{ Redwine::userLang('redwine.pages.column name') }}</th>
                    <th>{{ Redwine::userLang('redwine.pages.name') }}</th>
                    <th>{{ Redwine::userLang('redwine.pages.details') }}</th>
                </thead>
                <tbody id="sortable">
                    @foreach($customPageRow as $key => $column)
                        <tr class="column">
                            <input type="hidden" class="id" value="{{ $column->id }}">
                            <td style="position: relative;">
                                <i class="fa fa-arrows" aria-hidden="true"></i>
                                <h3 class="text-primary text-uppercase">{{ $column->field }}</h3>
                                @foreach($controller->columnDetail($table, $column->field) as $detail)
                                    <pre class="text-pink">{{ $detail->Type }}</pre>
                                    @if($detail->Null)
                                        <pre class="text-pink">Null: {{ $detail->Null }}</pre>
                                    @endif
                                    @if($detail->Key)
                                        <pre class="text-pink">Key: {{ $detail->Key }}</pre>
                                    @endif
                                    @if($detail->Default)
                                        <pre class="text-pink">Default: {{ $detail->Default }}</pre>
                                    @endif
                                    @if($detail->Extra)
                                        <pre class="text-pink">Extra: {{ $detail->Extra }}</pre>
                                    @endif
                                @endforeach
                            </td>
                            <td class="togglebutton">
                                <label class="text-uppercase">
                                    <input type="checkbox" class="browse" {{ $column->column_browse ? 'checked' : '' }}>
                                    Browse
                                </label> 
                                <br>
                                <label class="text-uppercase">
                                    <input type="checkbox" class="read" {{ $column->column_read ? 'checked' : '' }}>
                                    Read
                                </label>
                                <br>        
                                <label class="text-uppercase">
                                    <input type="checkbox" class="edit" {{ $column->column_edit ? 'checked' : '' }} >
                                    Edit
                                </label>
                                <br>
                                <label class="text-uppercase">
                                    <input type="checkbox" class="add" {{ $column->column_add ? 'checked' : '' }}>
                                    Add
                                </label>
                            </td>
                            <td>
                                <div class="form-group label-floating" style="margin-top: 0px;font-family: roboto">
                                    <select class="form-control type">
                                        <option value="">{{ Redwine::userLang('redwine.pages.choose') }}</option>
                                        
                                        <option value="text" {{ $column->type == 'text' ? 'selected' : '' }}>text</option>
                                        <option value="textarea (editor)" {{ $column->type == 'textarea (editor)' ? 'selected' : '' }}>textarea (Rich Text Editor)</option>
                                        <option value="tinytextarea (editor)" {{ $column->type == 'tinytextarea (editor)' ? 'selected' : '' }}>tinytextarea (Rich Text Editor)</option>
                                        <option value="textarea" {{ $column->type == 'textarea' ? 'selected' : '' }}>textarea</option>
                                        <option value="select" {{ $column->type == 'select' ? 'selected' : '' }}>select</option>
                                        <option value="checkbox" {{ $column->type == 'checkbox' ? 'selected' : '' }}>checkbox</option>
                                        <option value="number" {{ $column->type == 'number' ? 'selected' : '' }}>number</option>
                                        <option value="image" {{ $column->type == 'image' ? 'selected' : '' }}>image</option>
                                        <option value="hidden" {{ $column->type == 'hidden' ? 'selected' : '' }}>hidden</option>
                                        <option value="password" {{ $column->type == 'password' ? 'selected' : '' }}>password</option>
                                        <option value="email" {{ $column->type == 'email' ? 'selected' : '' }}>email</option>
                                        <option value="time" {{ $column->type == 'time' ? 'selected' : '' }}>time</option>
                                        <option value="date" {{ $column->type == 'date' ? 'selected' : '' }}>date</option>
                                        <option value="seo text" {{ $column->type == 'seo text' ? 'selected' : '' }}>seo text</option>
                                        <option value="seo textarea" {{ $column->type == 'seo textarea' ? 'selected' : '' }}>seo textarea</option>
                                        <option value="seo tag" {{ $column->type == 'seo tag' ? 'selected' : '' }}>seo tag</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="margin-top: -5px;">
                                    <input type="text" class="form-control displayName" placeholder="{{ Redwine::userLang('redwine.pages.name') }}" value="{{ $column->display_name }}">
                                </div>
                            </td>
                            <td>
                                <input type="hidden" value="{{ $key }}" class="key">
                                <pre id="editor_{{ $key }}" class="code">{{ $column->details }}</pre>
                            </td>
                        </tr>

                        @php $columnKey = $key; @endphp
                    @endforeach

                    @foreach($columnArray as $column)
                        
                        @php $columnKey++; @endphp

                        <tr class="column">
                            <input type="hidden" class="id" value="">
                            <td style="position: relative;">
                                <i class="fa fa-arrows" aria-hidden="true"></i>
                                <h3 class="text-primary text-uppercase">{{ $column }}</h3>
                                @foreach($controller->columnDetail($table, $column) as $detail)
                                    <pre class="text-pink">{{ $detail->Type }}</pre>
                                    @if($detail->Null)
                                        <pre class="text-pink">Null: {{ $detail->Null }}</pre>
                                    @endif
                                    @if($detail->Key)
                                        <pre class="text-pink">Key: {{ $detail->Key }}</pre>
                                    @endif
                                    @if($detail->Default)
                                        <pre class="text-pink">Default: {{ $detail->Default }}</pre>
                                    @endif
                                    @if($detail->Extra)
                                        <pre class="text-pink">Extra: {{ $detail->Extra }}</pre>
                                    @endif
                                @endforeach
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
                                        <option value="">{{ Redwine::userLang('redwine.pages.choose') }}</option>
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
                                <div class="form-group" style="margin-top: -5px;">
                                    <input type="text" class="form-control displayName" placeholder="{{ Redwine::userLang('redwine.pages.name') }}" style="min-width:120px">
                                </div>
                            </td>
                            <td>
                                <input type="hidden" value="{{ $columnKey }}" class="key">
                                <pre id="editor_{{ $columnKey }}" class="code"></pre>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> <!-- .table -->
        </div> <!-- .card-content -->
    </div> <!-- .card -->
    
    <div class="text-right">
        <button class="btn btn-primary get" @click="get()">{{ Redwine::userLang('redwine.pages.edit page') }}</button>  
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
                        redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.pages.page name required') }}');
                        return false;
                    }

                    if($('#icon').val() == ""){
                        redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.pages.icon required') }}');
                        return false;
                    }

                    if($('#modelName').val() == ""){
                        redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.pages.model required') }}');
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
                            redwine.note('danger', 'notifications', column.columnName.toUpperCase() + ' {{ Redwine::userLang('redwine.pages.error in details') }}');
                            vue.save = false;
                        } else {
                           column.columnDetails = ace.edit('editor_' + $(this).find( ".key" ).val()).getValue(); 
                        }

                        table[i] = column;

                        if (!columnDisplayNameCheck) {
                            redwine.note('danger', 'notifications', column.columnName.toUpperCase() + ' {{ Redwine::userLang('redwine.pages.column required') }}');
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

                    table.tableName = '{{ $table }}';
                    table.displayName = $('#displayName').val();
                    table.icon = $('#icon').val();
                    table.modelName = $('#modelName').val();

                    data = {
                        _token: '{{ csrf_token() }}',
                        page: table,
                        customPageRow: tableRow
                    };

                    Vue.http.post('/redwine/custompage/edit', data).then((data) => {
                        
                        $('.get').prop('disabled', false);
                        
                        if (data) {
                            swal({
                                type: 'success',
                                title: 'გვერდი წარმატებით განახლდა',
                                text: 'გსურთ რაიმეს ისევ შეცვლა?',
                                showCancelButton: true,
                                confirmButtonColor: '#4caf50',
                                cancelButtonColor: '#f44336',
                                confirmButtonText: 'კი',
                                cancelButtonText: 'არა',
                            }).then((result) => {

                                if (result.value) {} else {
                                    window.location = '/redwine/database/table';
                                }
                                
                            });
                        } else {
                            swal({
                                type: 'error',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                    }, (response) => {
                        
                        $('.get').prop('disabled', false);

                        swal({
                            type: 'error',
                            showConfirmButton: false,
                            timer: 1000
                        }); 
                    });

                }
            }
        });

        for (var i = 0; i < {{ count($customPageRow) + count($columnArray) }}; i++) {
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
