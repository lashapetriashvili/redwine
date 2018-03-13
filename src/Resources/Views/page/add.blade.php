@extends('redwine::layouts.dashboard')

@section('title', 'ახლის დამატება')

@section('navbar-title', $customPage->display_name)

@push('styles')
    <!-- Include stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}">
    <!-- Add the theme's stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/quill.bubble.css') }}">
    <!-- Taggle.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/taggle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/component.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.css') }}">
    
    <style>
        .ql-container.ql-snow{
            border:none;
        }

        .ql-toolbar.ql-snow{
            border:none;
        }

        .ql-tooltip{
            left: 14px !important;
        }

        .table-responsive-overflow{
            overflow: visible;
        }
    </style>
@endpush

@section('content')
    <div class="col-md-8">
        
        <div class="card text-card-show" data-border="purple">
            <div class="card-header card-circle-icon" data-background-color="purple">
                <i class="material-icons">text_fields</i>
            </div>
            <div class="card-content table-responsive text-card">
                @foreach($customPageRows as $customPageRow)
                    @if($customPageRow->type == 'text')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif

                        @if(isset(json_decode($customPageRow->details, true)['slug']))
                                <div class="form-group">
                                    @if(isset(json_decode($customPageRow->details, true)['slug']['number']))
                                        <input type="text" class="form-control" name="{{ $customPageRow->field }}" form="add-form" placeholder="{{ $customPageRow->display_name }}" value="{{ $controller->get($customPageRow->details) }}" @change="slug('{{ json_decode($customPageRow->details, true)['slug']['number'] }}', '{{ $customPageRow->field }}')">
                                    @else
                                        <input type="text" class="form-control" name="{{ $customPageRow->field }}" form="add-form" placeholder="{{ $customPageRow->display_name }}" value="{{ $controller->get($customPageRow->details) }}" @change="slug(35, '{{ $customPageRow->field }}')">
                                    @endif
                                    
                                </div>
                            </div>
                        @else
                                <div class="form-group label-floating">
                                    <label class="control-label">{{ $customPageRow->display_name }}</label>
                                    <input type="text" class="form-control" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}" {!! (isset(json_decode($customPageRow->details, true)['unique'])) ? '@change="unique(\''. $customPageRow->field .'\',\''. $customPageRow->display_name .'\')"' : '' !!}>
                                </div>
                            </div>
                        @endif
                            
                    @endif

                    @if($customPageRow->type == 'textarea')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-12">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <textarea class="form-control" rows="5" name="{{ $customPageRow->field }}" form="add-form">{{ $controller->get($customPageRow->details) }}</textarea>
                            </div>
                        </div>
                    @endif

                    @if($customPageRow->type == 'number')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <input type="number" class="form-control" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}" {!! (isset(json_decode($customPageRow->details, true)['unique'])) ? '@change="unique(\''. $customPageRow->field .'\',\''. $customPageRow->display_name .'\')"' : '' !!}>
                            </div>
                        </div>
                    @endif

                    @if($customPageRow->type == 'hidden')
                        <input type="hidden" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}">
                    @endif

                    @if($customPageRow->type == 'password')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <input type="password" class="form-control" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}">
                            </div>
                        </div>

                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">გაიმეორე {{ $customPageRow->display_name }}</label>
                                <input type="password" class="form-control" id="password-{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}">
                            </div>
                        </div>
                    @endif

                    @if($customPageRow->type == 'email')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <input type="email" class="form-control" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}" {!! (isset(json_decode($customPageRow->details, true)['unique'])) ? '@change="unique(\''. $customPageRow->field .'\',\''. $customPageRow->display_name .'\')"' : '' !!}>
                            </div>
                        </div>
                    @endif

                    @if($customPageRow->type == 'time')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <input type="text" class="form-control time" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}">
                            </div>
                        </div>
                    @endif

                    @if($customPageRow->type == 'date')
                        @if(isset(json_decode($customPageRow->details, true)['col']))
                            <div class="{{ json_decode($customPageRow->details, true)['col'] }}">
                        @else
                            <div class="col-md-6">
                        @endif
                            <div class="form-group label-floating">
                                <label class="control-label">{{ $customPageRow->display_name }}</label>
                                <input type="text" class="form-control date" name="{{ $customPageRow->field }}" form="add-form" value="{{ $controller->get($customPageRow->details) }}">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div> <!-- .card-content -->
        </div> <!-- .card -->
        
        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'textarea (editor)')
                <div class="card" data-border="purple">
                    <div class="card-header card-circle-icon" data-background-color="purple">
                        <i class="material-icons">format_align_center</i>
                    </div>
                    <div class="card-content table-responsive table-responsive-overflow" style="padding: 10px 0 0">
                        <h6 class="card-title text-gray text-center">{{ $customPageRow->display_name }}</h6>
                        <input type="hidden" name="{{ $customPageRow->field }}" class="editor-{{ $key }}" form="add-form">
                        <div id="editor-{{ $key }}" style="height: 300px;">
                            <p>{{ $controller->get($customPageRow->details) }}</p>
                        </div>
                    </div> <!-- .card-content -->
                </div> <!-- .card -->
            @endif
        @endforeach
        
        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'tinytextarea (editor)')
                <div class="card" data-border="purple">
                    <div class="card-header card-circle-icon" data-background-color="purple">
                        <i class="material-icons">insert_comment</i>
                    </div>
                    <div class="card-content table-responsive table-responsive-overflow" style="padding: 10px 0 0">
                        <h6 class="card-title text-gray text-center">{{ $customPageRow->display_name }}</h6>
                        <input type="hidden" name="{{ $customPageRow->field }}" class="mini-editor-{{ $key }}" form="add-form">
                        <div id="mini-editor-{{ $key }}" style="height: 70px;">
                            <p>{{ $customPageRow->display_name }}{{ $controller->get($customPageRow->details) }}</p>
                        </div>
                    </div> <!-- .card-content -->
                </div> <!-- .card -->
            @endif
        @endforeach
    </div>

    <div class="col-md-4">
        
        <div class="card" data-border="pink">
            <div class="card-header card-circle-icon" data-background-color="pink">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </div>
            <div class="card-content table-responsive text-center">
                <h6 class="card-title text-gray">@{{ date }}</h6>
                @foreach($customPageRows as $customPageRow)
                    @if($customPageRow->type == 'select')
                        <div class="form-group" >
                            <select class="form-control" name="{{ $customPageRow->field }}" form="add-form">
                                <option value="">{{ $customPageRow->display_name }}</option>
                                @if(isset(json_decode($customPageRow->details, true)['option']))
                                    @foreach(json_decode($customPageRow->details, true)['option'] as $key => $select)
                                        @if(isset(json_decode($customPageRow->details, true)['selected']))
                                            @if(json_decode($customPageRow->details, true)['selected'] == $select)
                                                <option value="{{ $key }}" selected>{{ $select }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $select }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $key }}">{{ $select }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                @if($controller->get($customPageRow->details) != [])
                                    @php $get = $controller->get($customPageRow->details); @endphp
                                    @foreach($get[0] as $select)
                                        @if(isset(json_decode($customPageRow->details, true)['value']['selected']))
                                            @if(json_decode($customPageRow->details, true)['value']['selected'] == $select[$get[1]])
                                                <option value="{{ $select[$get[2]] }}" selected>{{ $select[$get[1]] }}</option>
                                            @else
                                                <option value="{{ $select[$get[2]] }}">{{ $select[$get[1]] }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $select[$get[2]] }}">{{ $select[$get[1]] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                    @if($customPageRow->type == 'checkbox')
                        <div class="form-group togglebutton">
                            <label>
                                <input type="checkbox" name="{{ $customPageRow->field }}" form="add-form" {{ (isset(json_decode($customPageRow->details, true)['checked'])) ? 'checked' : '' }}>
                                {{ $customPageRow->display_name }}
                            </label> 
                        </div>
                    @endif
                @endforeach
                <form action="/redwine/page/{{ $customPage->table_name }}/add" method="post" enctype="multipart/form-data" id="add-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-pink">დამატება</button>
                </form>
            </div> <!-- .card-content -->
        </div> <!-- .card -->
    
        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'image')
                <div class="card" data-border="purple">
                    <div class="card-header card-circle-icon" data-background-color="purple">
                        <i class="fa fa-picture-o" aria-hidden="purple"></i>
                    </div>
                    <div class="card-content table-responsive">
                        
                        <div class="box text-center image_{{ $key }}">

                            <h6 class="card-title text-gray">{{ $customPageRow->display_name }}</h6>

                            <input type="file" name="{{ $customPageRow->field }}" id="upload-image-{{ $key }}" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" form="add-form" multiple @change="onFileChange($event, {{ $key }}, '{{ $customPageRow->field }}')" />
                            <label for="upload-image-{{ $key }}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>სურათის არჩევა</span></label>
                        </div>
                        
                        <div class="upload-image show_image_{{ $key }}" style="display:none" @click="removeImage({{ $key }}, '{{ $customPageRow->field }}')">
                            <img class="{{ $customPageRow->field }}" />
                            <div class="close-image">სხვა სურათის არჩევა</div>
                        </div>
                        
                    </div> <!-- .card-content -->
                </div> <!-- .card -->
            @endif
        @endforeach

        <div class="card tag-card-show" data-border="pink">
            <div class="card-header card-circle-icon" data-background-color="pink">
                <i class="material-icons">local_offer</i>
            </div>
            <div class="card-content table-responsive tag-card">
                
                @foreach($customPageRows as $key => $customPageRow)
                    @if($customPageRow->type == 'seo text')
                        <div class="form-group label-floating">
                            <label class="control-label">{{ $customPageRow->display_name }}</label>
                            <input type="text" class="form-control" name="{{ $customPageRow->field }}" form="add-form">
                        </div>
                    @endif

                    @if($customPageRow->type == 'seo textarea')
                        <div class="form-group label-floating">
                            <label class="control-label">{{ $customPageRow->display_name }}</label>
                            <textarea class="form-control" rows="5" name="{{ $customPageRow->field }}" form="add-form"></textarea>
                        </div>
                    @endif

                    @if($customPageRow->type == 'seo tag')
                        <div id="tag-{{ $key }}" style="position: relative;margin-top: 16px"></div>
                        <input type="hidden" class="tag-{{ $key }}" form="add-form" name="{{ $customPageRow->field }}">                        
                    @endif
                @endforeach

            </div> <!-- .card-content -->
        </div> <!-- .card -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/taggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-timepicker.js') }}"></script>
    <script>
        moment.locale('ka');

        var vue = new Vue({
            el: '.vue',
            data: {
                date: moment().format('LLLL'),
                slugName: ''
            },
            methods: {
                onFileChange(event, number, name) {
                    var files = event.target.files || event.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0], number, name);
                },
                createImage(file, number, name) {
                    var image = new Image();
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        $('.' + name).attr('src', e.target.result);
                        $('.image_' + number).hide();
                        $('.show_image_' + number).show();
                    };
                    reader.readAsDataURL(file);
                },
                removeImage: function (number, name) {
                    $('.' + name).attr('src', '');
                    $('.image_' + number).show();
                    $('.show_image_' + number).hide();
                },
                slug: function (number, name, value) {
                    if (value) {
                        slug = value;
                    } else {
                        slug = $( "input[name='" + name + "']" ).val();
                    }

                    if (slug != null) {
                        if (slug.substring(0, number).slice(-1) == " ") {
                            slug = slug.substring(0, number-1);
                        } else {
                            slug = slug.substring(0, number);
                        }

                        slug = slug.replace(/\ /g,'-');

                        if (slug.length > 3) {

                            data = {
                                 _token: '{{ csrf_token() }}',
                                slug: slug,
                                slugColumn: name 
                            };

                            this.slugName = slug;

                            this.$http.post("{{ URL::to('redwine/page/'. $customPage->table_name .'/check/slug')}}", data).then(function(json){
                                if (json.body) {
                                    $( "input[name='" + name + "']" ).val(this.slugName);
                                } else {
                                    $( "input[name='" + name + "']" ).val(this.slugName + "-1");
                                    this.slug(number, name);
                                }
                            });
                        }
                    }
                },
                unique: function (field, displayName) {
                    data = {
                         _token: '{{ csrf_token() }}',
                        field: field,
                        value: $( "input[name='" + field + "']" ).val() 
                    };

                    this.$http.post("{{ URL::to('redwine/page/'. $customPage->table_name .'/check/unique')}}", data).then(function(json){
                        if (json.body) {
                            redwine.note('danger', 'notifications', 'ასეთი ' + displayName + ' უკვე არსებობს!');
                            $( "input[name='" + field + "']" ).val('');
                        }
                    });
                }
            }
        });

        @foreach($customPageRows as $customPageRow)
            @if($customPageRow->type == 'text')
                @if(isset(json_decode($customPageRow->details, true)['slug']))
                    @if(isset(json_decode($customPageRow->details, true)['slug']['get']))
                        @if(isset(json_decode($customPageRow->details, true)['slug']['number']))
                            $( "input[name='{{ json_decode($customPageRow->details, true)['slug']['get'] }}']" ).change(function(){
                                vue.slug('{{ json_decode($customPageRow->details, true)['slug']['number'] }}', '{{ $customPageRow->field }}', $(this).val());
                            });
                        @else
                            $( "input[name='{{ json_decode($customPageRow->details, true)['slug']['get'] }}']" ).change(function(){
                                vue.slug(35, '{{ $customPageRow->field }}', $(this).val());
                            });
                        @endif
                    @endif
                @endif  
            @endif
        @endforeach

        $( "#add-form" ).submit(function( event ) {
            @foreach($customPageRows as $customPageRow)
                @if(isset(json_decode($customPageRow->details, true)['required']))
                    @if($customPageRow->type == 'seo textarea' || $customPageRow->type == 'textarea')
                        if ( $( "textarea[name='{{ $customPageRow->field }}']" ).val() == '' ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }
                    @elseif($customPageRow->type == 'image')
                        if ( $( ".{{ $customPageRow->field }}" ).attr('src') == '' ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }
                    @elseif($customPageRow->type == 'checkbox')
                        if ( !$( "input[name='{{ $customPageRow->field }}']" ).is(':checked') ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }
                    @elseif($customPageRow->type == 'password')
                        if ( $( "input[name='{{ $customPageRow->field }}']" ).val() == '' ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }

                        if ( $( "#password-{{ $customPageRow->field }}" ).val() == '' ) {
                            redwine.note('danger', 'notifications', 'გაიმეორე {{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }

                        if ($( "input[name='{{ $customPageRow->field }}']" ).val() != $( "#password-{{ $customPageRow->field }}" ).val()) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} და გაიმეორე {{ $customPageRow->display_name }} არ ემთხვევა!');
                            event.preventDefault();
                        }
                    @elseif($customPageRow->type == 'select')
                        if ( $( "select[name='{{ $customPageRow->field }}']" ).val() == '' ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }
                    @else
                        if ( $( "input[name='{{ $customPageRow->field }}']" ).val() == '' ) {
                            redwine.note('danger', 'notifications', '{{ $customPageRow->display_name }} სავალდებულოა!');
                            event.preventDefault();
                        }
                    @endif
                @endif
            @endforeach
        });

        $('.date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked"
        });

        $('.time').timepicker({
            use24hours: true,
            showMeridian: false,
            defaultTime: false
        });

        if ($('.text-card').html() == "") {
            $('.text-card-show').hide()
        }

        if ($('.tag-card').html() == "") {
            $('.tag-card-show').hide()
        }

        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'seo tag')
                var tag_{{ $key }} = new Taggle('tag-{{ $key }}', {
                    @if($customPageRow->display_name)
                        placeholder: '{{ $customPageRow->display_name }}',
                    @else
                        placeholder: 'ტეგები',
                    @endif
                    onTagAdd: function(event, tag) {
                        $('.tag-{{ $key }}').val(tag_{{ $key }}.getTagValues().toString());
                    },
                    onTagRemove: function(event, tag) {
                        $('.tag-{{ $key }}').val(tag_{{ $key }}.getTagValues().toString());
                    },
                });
            @endif
        @endforeach

        var toolbarOptions = [
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],                     // custom button values
            ['link', 'video', 'formula' ],
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'align': [] }],
            ['clean'],                                        // remove formatting button
        ];

        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'textarea (editor)')
                var editor{{ $key }} = new Quill('#editor-{{ $key }}', {
                    modules: {
                        toolbar: toolbarOptions,
                    },
                    theme: 'snow'
                });

                editor{{ $key }}.on('text-change', function() {
                    var html = editor{{ $key }}.root.innerHTML;

                    if (html == '<p><br></p>') {
                        html = '';
                    }

                    $('.editor-{{ $key }}').val(html);
                });    
            @endif
        @endforeach

        @foreach($customPageRows as $key => $customPageRow)
            @if($customPageRow->type == 'tinytextarea (editor)')
                var mini_editor{{ $key }} = new Quill('#mini-editor-{{ $key }}', {
                    theme: 'bubble'
                });

                mini_editor{{ $key }}.on('text-change', function() {
                    var html = mini_editor{{ $key }}.root.innerHTML;

                    if (html == '<p><br></p>') {
                        html = '';
                    }

                    $('.mini-editor-{{ $key }}').val(html);
                });            
            @endif
        @endforeach
    </script>
@endpush
