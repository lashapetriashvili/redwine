@extends('redwine::layouts.dashboard')

@section('title', $controller->lang($customPage->display_name, $slug))

@section('navbar-title', $controller->lang($customPage->display_name, $slug, true))

@section('content')

    @if(Redwine::bladePermissionFail('add_' . $slug))
        <a href="/redwine/page/{{ $slug }}/add" class="btn btn-primary btn-round pull-right" style="margin:-10px 0 -6px 0">
            <i class="material-icons">add</i> {{ Redwine::userLang('redwine.pages.add new') }}
        </a>
    @endif
    
    <div class="card" data-border="purple">
        <div class="card-header card-icon" data-background-color="purple">
            @if(substr( $customPage->icon, 0, 3 ) === "fa ")
                <i class="{{ $customPage->icon }}"></i>
            @else
                <i class="material-icons">{{ $customPage->icon }}</i>
            @endif
        </div>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead class="text-pink">
                    @foreach($customPageRow as $row)
                        @if($row->column_browse)
                            <th>{{ $controller->lang($row->display_name, $slug, true) }}</th>
                        @endif
                    @endforeach
                    @if(Redwine::bladePermissionFail('read_' . $slug) || Redwine::bladePermissionFail('edit_' . $slug) || Redwine::bladePermissionFail('delete_' . $slug))
                        <th>{{ Redwine::userLang('redwine.pages.buttons', [], true) }}</th>
                    @endif
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr>
                            @foreach($customPageRow as $row)
                                @if($row->column_browse)
                                    @if($row->type == 'textarea (editor)' || $row->type == 'tinytextarea (editor)')
                                        @if(strlen($post[$row->field]) > 100 )
                                            <td>{!! substr($post[$row->field],0,100) . '...'; !!}</td>
                                        @else
                                            <td>{!! $post[$row->field] !!}</td>
                                        @endif
                                    @elseif($row->type == 'image')
                                        @if( $post[$row->field] )
                                            @if( File::exists( 'uploads/images/' . $post[$row->field] ) )
                                                <td><img src="{{ asset('uploads/images/' . $post[$row->field]) }}" style="width:200px"></td>
                                            @else
                                                <td style="color:#999">{{ Redwine::userLang('redwine.pages.image not found') }}</td>
                                            @endif
                                        @else
                                            <td style="color:#999">{{ Redwine::userLang('redwine.pages.image not found') }}</td>
                                        @endif
                                    @elseif($row->type == 'checkbox')
                                        @if($post[$row->field] == 1)
                                            <td>
                                                <input type="checkbox" checked disabled>
                                            </td>
                                        @else
                                            <td>
                                                <input type="checkbox" disabled>
                                            </td>
                                        @endif
                                    @else
                                        @if(isset(json_decode($row->details, true)['display']))
                                            <td>{{ $controller->view(json_decode($row->details, true), $post[$row->field]) }}</td>
                                        @else
                                            <td>{{ $post[$row->field] }}</td>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                            <td>
                                @if(Redwine::bladePermissionFail('read_' . $slug))
                                    <button class="btn btn-warning btn-simple btn-xs" data-toggle="modal" data-target="#myModal" @click="read({{ $post['id'] }})">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                @endif
                                @if(Redwine::bladePermissionFail('edit_' . $slug))
                                    <a href="/redwine/page/{{ $slug }}/{{ $post->id }}/edit" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endif
                                @if(Redwine::bladePermissionFail('delete_' . $slug))
                                    <button class="btn btn-danger btn-simple btn-xs" @click="postDelete({{ $post['id'] }})">
                                        <i class="material-icons">close</i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> <!-- .table -->

            {{ $posts->links() }}

        </div> <!-- .card-content -->
    </div> <!-- .card -->

    @if(Redwine::bladePermissionFail('read_' . $slug))
        <!-- Sart Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">{{ $controller->lang($customPage->display_name, $slug) }}</h4>
                    </div>
                    <div class="modal-body" v-for="row in rows" v-if="row.column_read">
                        <div class="read-typo">
                            <div v-if="row.type == 'image'">
                                <span :class="'read-note text-uppercase model' + row.display_name.substring(1, row.display_name.length -1 )" v-if="row.display_name">@{{ lang(row.display_name) }}</span>
                                <span class="read-note text-uppercase" v-else style="color:#999">{{ Redwine::userLang('redwine.pages.no image') }}</span>
                                <img :src="'/uploads/images/' + posts[row.field]" @error="imageLoadError" style="width: 100%" v-if="imageErorr">
                                <p class="text-muted" v-else style="color:#999">{{ Redwine::userLang('redwine.pages.image not found') }}</p>
                            </div>
                            <div v-if="row.type == 'checkbox'">
                                <span :class="'read-note text-uppercase model' + row.display_name.substring(1, row.display_name.length -1 )" v-if="row.display_name">@{{ lang(row.display_name) }}</span>
                                <span class="read-note text-uppercase" v-else style="color:#999">{{ Redwine::userLang('redwine.pages.no image') }}</span>
                                <p class="text-muted" v-if="posts[row.field] == 1"><input type="checkbox" checked disabled></p>
                                <p class="text-muted" v-else><input type="checkbox" disabled></p>
                            </div>
                            <div v-else>
                                <span :class="'read-note text-uppercase model' + row.display_name.substring(1, row.display_name.length -1 )" v-if="row.display_name">@{{ lang(row.display_name) }}</span>
                                <span class="read-note text-uppercase" v-else style="color:#999">{{ Redwine::userLang('redwine.pages.no image') }}</span>
                                <p class="text-muted" v-if="row.type == 'textarea (editor)' || row.type == 'tinytextarea (editor)'" v-html="posts[row.field]"></p>
                                <p :class="'text-muted ' + row.field" v-else>@{{ view(posts[row.field], row.details, row.field) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif

@endsection

@push('scripts')
    <script>
        var vue = new Vue({
            el: '.vue',
            data: {
                posts: [],
                rows: [],
                imageErorr: true
            },
            http: {
                emulateJSON: true,
                emulateHTTP: true
            },
            methods: {
                @if(Redwine::bladePermissionFail('read_' . $slug))
                    read: function (id) {
                        this.$http.get('/redwine/page/{{ $slug }}/' + id + '/read').then(function(data){
                            this.imageErorr = true;
                            this.posts = data.body.post;
                            this.rows = data.body.pageRow;
                        });
                    },
                    view: function (value, details, field) {
                        
                        json = JSON.parse(details);

                        if (json != null) {
                            if (json['display']) {

                                data = {
                                    'details': json,
                                    'value': value
                                };
                                
                                this.$http.get('/redwine/page/{{ $slug }}/view', {params: data}).then(function(data){
                                    $('.' + field).text(data.body);
                                }); 
                            } else {
                                return value;
                            }
                        } else {
                            return value;
                        }
                        
                    },
                    lang: function (lang) {
                        if (lang.substr(0, 1) == '{' && lang.substr(-1) == '}') {
                            this.$http.get('/redwine/page/{{ $slug }}/' + lang.substring(1, lang.length -1 ) + '/language').then(function(data){    
                                $('.model' + lang.substring(1, lang.length -1 )).text(data.body);
                            });
                        } else {
                            return lang;
                        }
                    },
                @endif
                @if(Redwine::bladePermissionFail('delete_' . $slug))
                    postDelete: function (id) {
                        swal({
                            title: '{{ Redwine::userLang('redwine.pages.are you sure') }}',
                            text: '{{ Redwine::userLang('redwine.pages.returned back') }}',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#f44336',
                            confirmButtonText: '{{ Redwine::userLang('redwine.pages.agreement') }}',
                            cancelButtonText: '{{ Redwine::userLang('redwine.pages.cancel') }}',
                            showCloseButton: true,
                        }).then((result) => {
                            if (result.value) {
                                data = {
                                    _token: '{{ csrf_token() }}'
                                };

                                this.$http.post('/redwine/page/{{ $slug }}/' + id + '/delete', data).then(function (data) {
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
                    },
                @endif
                imageLoadError () {
                    this.imageErorr = false;
                }
            }
        });
    </script>
@endpush
