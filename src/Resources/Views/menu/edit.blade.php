@extends('redwine::layouts.dashboard')

@section('title', 'მენიუ')

@section('navbar-title', 'მენიუ')

@push('styles')
    <style>
        .dd { position: relative; display: block; margin: 0; padding: 0; list-style: none; font-size: 13px; line-height: 20px; }

        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }

        .dd-item,
        .dd-empty,
        .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

        .dd-handle { display: block; height: 40px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }

        .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 27px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
        .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0;  }
        .dd-item > button[data-action="collapse"]:before { content: '-'; }

        .dd-placeholder,
        .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                 -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                      linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
                    box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        }

        /**
         * Nestable Extras
         */

        .nestable-lists { display: block; clear: both; width: 100%; border: 0; }

        #nestable-menu { padding: 0; margin: 20px 0; }

        #nestable-output,
        #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
            background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
            background:         linear-gradient(top, #bbb 0%, #999 100%);
        }
        #nestable2 .dd-handle:hover { background: #bbb; }
        #nestable2 .dd-item > button:before { color: #fff; }

        .dd { float: left; width: 100%; }
        .dd + .dd { margin-left: 2%; }

        .dd-hover > .dd-handle { background: #2ea8e5 !important; }

        /**
         * Nestable Draggable Handles
         */

        .dd3-content { display: block; height: 40px; margin: 5px 0; padding: 9px 10px 5px 40px; color: #333; text-decoration: none; border: 1px solid #ccc;
            box-sizing: border-box; -moz-box-sizing: border-box; text-transform: uppercase; font-size: 12px
        }

        .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

        .dd3-item > button { margin-left: 30px; }

        .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 35px; text-indent: 100%; white-space: nowrap; overflow: hidden;
            border: 1px solid #73379e;
            background: #73379e;
            color: #fff;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 8px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 25px; font-weight: normal; }
        .dd3-handle:hover { background: #73379e; }

        .dd-button{ float: right; font-size: 16px }
    </style>
@endpush

@section('content')
    <div class="col-md-4">
        <div class="card text-card-show" data-border="pink">
            <div class="card-header card-circle-icon" data-background-color="pink">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </div>
            <div class="card-content table-responsive text-card">
                <div class="form-group label-floating">
                    <input type="text" class="form-control" id="label" placeholder="სათაური">
                </div>
                <div class="form-group label-floating"> 
                    <input type="text" class="form-control" id="link" placeholder="ლინკი">
                </div>
                <div class="form-group label-floating"> 
                    <input type="text" class="form-control" id="icon" placeholder="ხატულა">
                </div>
                @if(Request::is('redwine/menu/add'))
                    <input type="hidden" id="menuName">
                @else
                    <input type="hidden" id="menuName" value="{{ $name }}">
                @endif
                <div class="text-center">
                    <button class="btn btn-pink" id="submit">დამატება</button>
                </div>
                <input type="hidden" id="id">
            </div> <!-- .card-content -->
        </div> <!-- .card -->
    </div>

    <div class="col-md-8">
        <div class="card text-card-show" data-border="purple">
            <div class="card-header card-circle-icon" data-background-color="purple">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="card-content table-responsive text-card">
                <div class="cf nestable-lists">
                    <div class="dd" id="nestable">
                        {!! $controller->getMenu($items) !!}
                    </div>
                </div>
                <input type="hidden" id="nestable-output">
            </div> <!-- .card-content -->
        </div> <!-- .card -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function(){

            @if(Request::is('redwine/menu/add'))
                function add() {
                    swal({
                        title: 'ახალი მენიუს სახელი',
                        input: 'text',
                        confirmButtonText: 'შექმნა',
                        allowOutsideClick: () => !swal.isLoading()
                    }).then((result) => {
                        if (result.value) {
                            var dataString = {
                                _token : '{{ csrf_token() }}'
                            };
                            $.ajax({
                                type: "POST",
                                url: "/redwine/menu/check/" + result.value,
                                data: dataString,
                                cache : false,
                                success: function(data){

                                    if (data) {
                                        redwine.note('danger', 'notifications', 'ასეთი მენიუ უკვე არსებობს');
                                        add();
                                    } else {
                                        window.history.pushState('obj', 'newtitle', '/redwine/menu/edit/' + result.value);
                                        $('#menuName').val(result.value);
                                    }
                                    
                                } ,error: function(xhr, status, error) {
                                    alert(error);
                                },
                            });
                        }
                    });
                }
                add();
            @endif

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));
                } else {
                    output.val('JSON-ის მხარდაჭერა არ აქვს ამ ბრაუზერს');
                }
            };

            function loadNestable() {
                $('#nestable').nestable({
                    group: 1
                })
                .on('change', updateOutput);
                updateOutput($('#nestable').data('output', $('#nestable-output')));
                $('#nestable-menu').on('click', function(e)
                {
                    var target = $(e.target),
                        action = target.data('action');
                    if (action === 'expand-all') {
                        $('.dd').nestable('expandAll');
                    }
                    if (action === 'collapse-all') {
                        $('.dd').nestable('collapseAll');
                    }
                });
            }
            
            loadNestable();

            $("#submit").click(function(){
                
                if ($("#menuName").val() == '') {
                    location.reload();
                } else {
                    if ($("#label").val() == '') {
                        redwine.note('danger', 'notifications', 'სახელი აუცილებელია');
                    } else {
                        var dataString = { 
                            _token : '{{ csrf_token() }}',
                            label : $("#label").val(),
                            link : $("#link").val(),
                            icon : $("#icon").val(),
                            menuName : $("#menuName").val(),
                            id : $("#id").val()
                        };

                        $.ajax({
                            type: "POST",
                            url: "/redwine/menu/save",
                            data: dataString,
                            dataType: "json",
                            cache : false,
                            success: function(data){
                                if (data.type == 'add') {
                                    $("#menu-id").append(data.menu);
                                } else if (data.type == 'edit') {
                                    $('#label_show' + data.id).html(data.label);
                                    $('.edit_' + data.id).attr('label', data.label);
                                    $('.edit_' + data.id).attr('link', data.link);
                                    $('.edit_' + data.id).attr('icon', data.icon);
                                }

                                loadNestable();
                                change();
                                if ($("#submit").text() == 'რედაქტირება') {
                                    redwine.note('success', 'notifications', 'წარმატებით განახლდა მენიუ');
                                    $("#submit").text('დამატება');
                                } else {
                                    redwine.note('success', 'notifications', 'წარმატებით დაემატა მენიუში');
                                }
                                $('#label').val('');
                                $('#link').val('');
                                $("#icon").val('');
                                $('#id').val('');
                                $("#load").hide();
                            } ,error: function(xhr, status, error) {
                                alert(error);
                            },
                        });  
                    }
                }
                
            });

            $('.dd').on('change', function() {
                var dataString = {
                    _token : '{{ csrf_token() }}',
                    data : $("#nestable-output").val(),
                };
                $.ajax({
                    type: "POST",
                    url: "/redwine/menu/save/change",
                    data: dataString,
                    cache : false,
                    success: function(data){
                        redwine.note('success', 'notifications', 'წარმატებით განახლდა მენიუ');
                    } ,error: function(xhr, status, error) {
                        alert(error);
                    },
                });
            });

            function change(){
                $("#load").show();
                    var dataString = {
                        _token : '{{ csrf_token() }}',
                        data : $("#nestable-output").val(),
                    };
                $.ajax({
                    type: "POST",
                    url: "/redwine/menu/save/change",
                    data: dataString,
                    cache : false,
                    success: function(data){
                        $("#load").hide();
                    } ,error: function(xhr, status, error) {
                        alert(error);
                    },
                });
            }

            $(document).on("click",".del-button",function() {
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
                        var id = $(this).attr('id');
                        $.ajax({
                            type: "POST",
                            url: "/redwine/menu/delete",
                            data: {
                                _token : '{{ csrf_token() }}',
                                id : id
                            },
                            cache : false,
                            success: function(data){
                                loadNestable();
                                $("#load").hide();
                                $("li[data-id='" + id +"']").remove();
                                redwine.note('success', 'notifications', 'წარმატებით წაიშალა მენიუდან');
                            } ,error: function(xhr, status, error) {
                                alert(error);
                            },
                        });
                    }
                });
                    
            });

            $(document).on("click",".edit-button",function() {
                var id = $(this).attr('id');
                var label = $(this).attr('label');
                var link = $(this).attr('link');
                $("#id").val(id);
                $("#label").val(label);
                $("#link").val(link);
                $("#icon").val($(this).attr('icon'));
                $("#submit").text('რედაქტირება');
            });
        });
    </script>
@endpush
