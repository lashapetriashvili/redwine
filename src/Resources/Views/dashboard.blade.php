@extends('redwine::layouts.dashboard')

@section('title', 'მთავარი გვერდი')

@section('navbar-title', 'მთავარი გვერდი')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6" >
            <div class="card card-stats" data-border="pink">
                <div class="card-header" data-background-color="pink" >
                    <i class="material-icons">person</i>
                </div>
                <div class="card-content">
                    <p class="category">მომხმარებელი</p>
                    <h3 class="title">{{ $user }}
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">person</i>
                        მომხმარებლების <a href="/redwine/page/users" class="text-pink">ნახვა</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons">library_books</i>
                </div>
                <div class="card-content">
                    <p class="category">პოსტები</p>
                    <h3 class="title">{{ Redwine::model('Redwine\Models\Post')->count() }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">library_books</i>
                        პოსტების <a href="/redwine/page/posts">ნახვა</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" data-border="medium-purple">
                <div class="card-header" data-background-color="medium-purple">
                    <i class="material-icons">cloud</i>
                </div>
                <div class="card-content">
                    <p class="category">მონაცემთა ბაზა</p>
                    <h3 class="title">{{ $table }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">cloud</i>
                        მონაცემთა ბაზის <a href="/redwine/database/table">ნახვა</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
