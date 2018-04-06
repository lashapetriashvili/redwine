@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.database.new table'))

@section('navbar-title', Redwine::userLang('redwine.database.new table', [], true))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/octicons/4.3.0/font/octicons.min.css" integrity="sha256-pNGG0948CVwfHxxS8lVkUKftaSsMBzFSUknrKr2utfY=" crossorigin="anonymous" />
@endpush

@section('content')
    <div class="card" data-border="purple">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="material-icons">cloud</i>
        </div>
        <div class="card-content table-responsive">
            
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.database.table name') }}</label>
                        <input type="text" class="form-control" id="tableName">
                    </div>
                </div>

                <div class="togglebutton" style="margin-top: 30px;">
                    <label>
                        <input type="checkbox" class="model" checked>
                        {{ Redwine::userLang('redwine.database.create model') }}
                    </label>

                    <label>
                        <input type="checkbox" class="controller" checked>
                        {{ Redwine::userLang('redwine.database.create controller') }}
                    </label>
                </div>
            </div>

            <table id="database" class="table table-hover"></table>

            <div class="text-center">
                <button type="button" class="btn btn-primary" id="btnRow">{{ Redwine::userLang('redwine.database.column') }}</button>
                <button type="button" class="btn btn-primary" id="btnTimestamps">{{ Redwine::userLang('redwine.database.add timestamps') }}</button>
                <button type="button" class="btn btn-primary" id="btnCreate">{{ Redwine::userLang('redwine.database.add table') }}</button>
            </div>
            
        </div> <!-- .card-content -->
    </div> <!-- .card -->

@endsection

@push('scripts')
    <!-- jQuery appendGrid 2 -->
    <script src="{{ asset('assets/js/jquery.appendGrid-2.js') }}"></script>

    <script>
        $(function () {

            $('#database').appendGrid({
                initRows: 1,
                columns: [
                    { name: 'Name', display: '{{ Redwine::userLang('redwine.database.name', [], true) }}', type: 'text', ctrlAttr: { 'placeholder': '{{ Redwine::userLang('redwine.database.name') }}' }, ctrlCss: { 'margin-top': -20 } },
                    { name: 'Type', display: '{{ Redwine::userLang('redwine.database.type', [], true) }}', ctrlCss: { 'margin-top': -20 }, type: 'select', 
                        ctrlOptions: [
                            { label: 'INT', value: 'int' },
                            { label: 'VARCHAR', value: 'varchar' },
                            { label: 'TEXT', value: 'text' },
                            { label: 'DATE', value: 'date' },
                            { label: 'TIMESTAMP', value: 'timestamp' },
                            // Numeric
                            { label: 'TINYINT', value: 'tinyint', group: 'Numeric' },
                            { label: 'SMALLINT', value: 'smallint', group: 'Numeric' },
                            { label: 'INT', value: 'int', group: 'Numeric' },
                            { label: 'BIGINT', value: 'bigint', group: 'Numeric' },
                            { label: 'DECIMAL', value: 'decimal', group: 'Numeric' },
                            { label: 'FLOAT', value: 'float', group: 'Numeric' },
                            { label: 'DOUBLE', value: 'double', group: 'Numeric' },
                            { label: 'BOOLEAN', value: 'boolean', group: 'Numeric' },
                            // Date and time
                            { label: 'DATE', value: 'date', group: 'Date and time' },
                            { label: 'DATETIME', value: 'datetime', group: 'Date and time' },
                            { label: 'TIMESTAMP', value: 'timestamp', group: 'Date and time' },
                            { label: 'TIME', value: 'time', group: 'Date and time' },
                            // String
                            { label: 'CHAR', value: 'char', group: 'String' },
                            { label: 'VARCHAR', value: 'varchar', group: 'String' },
                            { label: 'TEXT', value: 'text', group: 'String' },
                            { label: 'MEDIUMTEXT', value: 'mediumtext', group: 'String' },
                            { label: 'LONGTEXT', value: 'longtext', group: 'String' },
                            { label: 'BINARY', value: 'binary', group: 'String' },
                            { label: 'BLOB', value: 'blob', group: 'String' },
                            // Spatial
                            { label: 'GEOMETRY', value: 'geometry', group: 'Spatial' },
                            { label: 'POINT', value: 'point', group: 'Spatial' },
                            { label: 'LINESTRING', value: 'linestring', group: 'Spatial' },
                            { label: 'POLYGON', value: 'polygon', group: 'Spatial' },
                            { label: 'MULTIPOINT', value: 'multipoint', group: 'Spatial' },
                            { label: 'MULTILINESTRING', value: 'multilinestring', group: 'Spatial' },
                            { label: 'MULTIPOLYGON', value: 'multipolygon', group: 'Spatial' },
                            { label: 'GEOMETRYCOLLECTION', value: 'geometrycollection', group: 'Spatial' },
                        ]
                    },
                    { name: 'Length', display: '{{ Redwine::userLang('redwine.database.length', [], true) }}', type: 'number', ctrlAttr: { 'placeholder': '{{ Redwine::userLang('redwine.database.length') }}' }, ctrlCss: { 'margin-top': -20 } },
                    { name: 'Default', display: '{{ Redwine::userLang('redwine.database.default', [], true) }}', type: 'number', ctrlAttr: { 'placeholder': '{{ Redwine::userLang('redwine.database.default') }}' }, ctrlCss: { 'margin-top': -20 } },
                    { name: 'NotNull', display: 'NOT NULL', type: 'checkbox', ctrlCss: { 'margin-top': -15, height: 20 }, ctrlClass: 'ios' },
                    { name: 'Unsigned', display: 'UNSIGNED', type: 'checkbox', ctrlCss: { 'margin-top': -15, height: 20 } },
                    { name: 'AutoIncrement', display: '{{ Redwine::userLang('redwine.database.autoincrement', [], true) }}', type: 'checkbox', ctrlCss: { 'margin-top': -15, height: 20 } },
                    { name: 'Index', display: '{{ Redwine::userLang('redwine.database.index', [], true) }} ', type: 'select', ctrlOptions: { 0: '{{ Redwine::userLang('redwine.database.choose') }}', 1: 'INDEX', 2: 'UNIQUE', 3: 'PRIMARY' }, ctrlAttr: { 'placeholder': 'Index' }, ctrlCss: { 'margin-top': -20 } },
                ],
                rowDragging: true,
                hideButtons: { insert: true, removeLast: true, moveUp: true, moveDown: true, append: true },
                sectionClasses: {
                    header: 'text-pink',
                }
            });
            
            
            $('#database').appendGrid('load', [
                { 'Name': 'id', 'Type': 'int', 'NotNull': true, 'Unsigned': true, 'AutoIncrement': true, 'Index': 3 },
            ]);

            // Timestamp
            $('#btnTimestamps').click(function () {
                $('#database').appendGrid('insertRow', [
                    { 'Name': 'created_at', 'Type': 'timestamp', 'Index': 0 },
                    { 'Name': 'updated_at', 'Type': 'timestamp', 'Index': 0 }
                ]);
            });

            // Timestamp
            $('#btnRow').click(function () {
                $('#database').appendGrid('insertRow', [{ 'Index': 0, 'Type': 'int' }]);
            });

            // Create
            $('#btnCreate').click(function () {

                if($('#tableName').val() == ""){
                    redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.database.required') }}!');
                    return false;
                }

                $(this).prop('disabled', true);

                var getModel = 1;

                if ($('.model').is(":checked")) {
                    getModel = 1;
                } else {
                    getModel = 0;
                }

                var getController = 1;

                if ($('.controller').is(":checked")) {
                    getController = 1;
                } else {
                    getController = 0;
                }

                var data = $('#database').appendGrid('getAllValue');

                $.post("/redwine/database/add",
                    {
                        "_token": "{{ csrf_token() }}",
                        data:          data,
                        name:          $("#tableName").val(),
                        getModel:      getModel,
                        getController: getController
                    },
                function(data){

                    if (data) {
                        swal({
                            type: 'success',
                            title: '{{ Redwine::userLang('redwine.database.success') }}',
                            text: '{{ Redwine::userLang('redwine.database.create page') }}',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: '{{ Redwine::userLang('redwine.database.yes') }}',
                            cancelButtonText: '{{ Redwine::userLang('redwine.database.no') }}',
                        }).then((result) => {

                            if (result.value) {
                                window.location = '/redwine/custompage/' + $("#tableName").val();
                            } else {
                                window.location = '/redwine/database/table';
                            }
                            
                        });

                        $('#btnCreate').prop('disabled', false);

                    } else {
                        swal({
                            type: 'error',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        
                        $('#btnCreate').prop('disabled', false);
                        
                    }
                    
                });
            });
        });
    </script>
@endpush