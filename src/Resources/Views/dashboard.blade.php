@extends('redwine::layouts.dashboard')

@section('title', Redwine::userLang('redwine.home page.title'))

@section('navbar-title', Redwine::userLang('redwine.home page.title', [], true))

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4" >
            <div class="card card-stats" data-border="pink">
                <div class="card-header" data-background-color="pink" >
                    <i class="material-icons">person</i>
                </div>
                <div class="card-content">
                    <p class="category">{{ Redwine::userLang('redwine.home page.user', [], true) }}</p>
                    <h3 class="title">{{ $user }}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">person</i>
                        {{ Redwine::userLang('redwine.home page.all users', [], true) }} <a href="/redwine/page/users" class="text-pink">{{ Redwine::userLang('redwine.home page.show', [], true) }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons">folder</i>
                </div>
                <div class="card-content">
                    <p class="category">UPLOADS {{ Redwine::userLang('redwine.home page.file', [], true) }}</p>
                    <h3 class="title">{{ $size }}<small>MG</small></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">folder</i> {{ Redwine::userLang('redwine.home page.file size', [], true) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats" data-border="medium-purple">
                <div class="card-header" data-background-color="medium-purple">
                    <i class="material-icons">cloud</i>
                </div>
                <div class="card-content">
                    <p class="category">{{ Redwine::userLang('redwine.home page.database', [], true) }}</p>
                    <h3 class="title">{{ $table }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">cloud</i>
                        {{ Redwine::userLang('redwine.home page.show database', [], true) }} <a href="/redwine/database/table">{{ Redwine::userLang('redwine.home page.show', [], true) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
