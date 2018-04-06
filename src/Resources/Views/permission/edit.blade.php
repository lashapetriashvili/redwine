@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.permission.rele edit'))

@section('navbar-title', Redwine::userLang('redwine.permission.rele edit', [], true))

@push('styles')
    <style>
        .togglebutton label {
            min-width: 150px;
            text-align: left;
        }
    </style>
@endpush

@section('content')
    <div class="card" data-border="purple">
        <div class="card-header card-icon" data-background-color="purple">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="card-content table-responsive">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.permission.name') }}</label>
                        <input type="text" class="form-control" value="{{ $role[0]['name'] }}" name="name" form="add-form">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">{{ Redwine::userLang('redwine.permission.full name') }}</label>
                        <input type="text" class="form-control" value="{{ $role[0]['display_name'] }}" name="display_name" form="add-form">
                    </div>
                </div>
            </div>
            
            <table class="table table-hover">
                <thead class="text-pink text-uppercase">
                    <th>{{ Redwine::userLang('redwine.permission.table') }}</th>
                    <th>{{ Redwine::userLang('redwine.permission.add') }}</th>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr class="column">
                            <td>
                                <h4 class="text-primary text-uppercase">{{ $permission == 'admin' ? 'dashboard' : $permission }}</h4>
                            </td>
                            <td class="togglebutton">
                                @foreach($controller->getKey($permission) as $key => $permission_key)
                                    <label class="text-uppercase">
                                        <input type="checkbox" class="browse" {{ in_array($permission_key->id, $permission_role) ? 'checked' : '' }} name="{{ $permission_key->key_name }}_{{ $permission }}" form="add-form">
                                        {{ $permission_key->key_name }}
                                    </label>
                                    <br> 
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> <!-- .table -->
            
        </div> <!-- .card-content -->
    </div> <!-- .card -->
    
    <form action="/redwine/permission/edit/{{ $id }}" method="post" id="add-form" class="text-right">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-primary">{{ Redwine::userLang('redwine.permission.edit') }}</button>
    </form>
@endsection

@push('scripts')
    <script>
        $( "#add-form" ).submit(function( event ) {
            if ( $( "input[name='name']" ).val() == '' ) {
                redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.permission.name') }} {{ Redwine::userLang('redwine.permission.required') }}!');
                event.preventDefault();
            }
            if ( $( "input[name='display_name']" ).val() == '' ) {
                redwine.note('danger', 'notifications', '{{ Redwine::userLang('redwine.permission.full name') }} {{ Redwine::userLang('redwine.permission.required') }}!');
                event.preventDefault();
            }
        });
    </script>
@endpush