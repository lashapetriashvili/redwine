@extends('redwine::layouts.dashboard')

@section('title', 'უფლების დამატება')

@section('navbar-title', 'უფლების დამატება')

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
                        <label class="control-label">სახელი</label>
                        <input type="text" class="form-control" name="name" form="add-form">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">სრული დასახელება</label>
                        <input type="text" class="form-control" name="display_name" form="add-form">
                    </div>
                </div>
            </div>
            
            <table class="table table-hover">
                <thead class="text-pink">
                    <th>ცხრილი</th>
                    <th>ნებართვა</th>
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
                                        <input type="checkbox" class="browse" name="{{ $permission_key->key_name }}_{{ $permission }}" form="add-form">
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
    
    <form action="/redwine/permission/add" method="post" id="add-form" class="text-right">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-primary">დამატება</button>
    </form>
@endsection

@push('scripts')
    <script>
        $( "#add-form" ).submit(function( event ) {
            if ( $( "input[name='name']" ).val() == '' ) {
                redwine.note('danger', 'notifications', 'სახელი სავალდებულოა!');
                event.preventDefault();
            }
            if ( $( "input[name='display_name']" ).val() == '' ) {
                redwine.note('danger', 'notifications', 'სრული დასახელება სავალდებულოა!');
                event.preventDefault();
            }
        });
    </script>
@endpush