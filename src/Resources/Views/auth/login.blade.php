@extends("redwine::layouts.assets")

@section("title", "ავტორიზაცია")

@push('styles')
    <style>
        .wrapper{
            background-image: url('{{ asset('assets/img/background2.jpg') }}');
            background-repeat:no-repeat;
            background-size:cover;
        }

        .panel{
            background: none;
            border: none;
            box-shadow: none;
        }

        .mfont{
            font-family: 'mtavruli';
        }

        .error{
            color: rgba(255, 255, 255, 0.6);
            margin-top: 15px;
            margin-bottom: -20px;
            font-family: 'mtavruli';
        }

        .loginBtn{
            margin-top: 20px;
            width: 220px;
            background: none;
            border:1px solid rgba(255, 255, 255, 0.6);
            color:rgba(255, 255, 255, 0.6);
            padding: 9px;
        }

        .loginBtn:hover{
            background: rgba(255, 255, 255, 0.1);
            border:1px solid rgba(255, 255, 255, 0.0);
            color:rgba(255, 255, 255, 0.45);
            transition: .3s;
        }

        .loginBtn:focus{
            background: rgba(255, 255, 255, 0.1);
            border:1px solid rgba(255, 255, 255, 0.0);
            color:rgba(255, 255, 255, 0.45);
            transition: .3s;
        }

        .form-group.is-focused > label{
            margin-top: 18px !important;
            font-size: 12px !important;
        }

        label{
            color:rgba(255, 255, 255, 0.45) !important;
            font-size: 13px !important;
            margin-top: 17px !important;
            width:100%;
            text-align: center;
        }

        i{
            color:rgba(255, 255, 255, 0.6) !important;
        }

        .form-control, .form-group .form-control{
            background-image: linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6));
            background-color: rgba(255, 255, 255, 0.1);
            padding-top: 22px !important;
            padding-bottom: 22px !important;
            color:rgba(255, 255, 255, 0.45) !important;
            text-align: center !important;
        }

        .form-group.is-focused .form-control{
            background-image:linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), linear-gradient(#D2D2D2, #D2D2D2);
            color:rgba(255, 255, 255, 0.45) !important;
        }

        .form-group.label-static label.control-label, .form-group.label-floating.is-focused label.control-label, .form-group.label-floating:not(.is-empty) label.control-label{
            top:-37px !important;
        }
    </style>
@endpush

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-lg-4 col-lg-offset-4 animated fadeInDownBig">
                <form role="form" method="POST" action="{{ route('redwine.login.submit') }}">
                    {{ csrf_field() }}
                    <div class="panel">
                        <div class="card-header text-center" data-background-color="red">
                            <h4 class="card-title" style="font-size:23px;opacity: 0.2;">
                                <img src="{{ asset('assets/img/logo 4 (200X200).png') }}" alt="redwine" width="100">
                            </h4>
                        </div>
                        @if ($errors->has('email'))
                            <p class="text-center error" style="margin-bottom:8px;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </p>
                        @endif
                        @if ($errors->has('password'))
                            <p class="text-center error" style="margin-bottom:8px;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label mfont">E-mail</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating" style="margin-top:20px;">
                                    <label class="control-label mfont">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="loginBtn mfont">LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(window).resize(function() {
            jQuery.fn.center = function () {
                this.css("position","absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2.3) +
            $(window).scrollTop()) + "px");
                return this;
            }

            $('.panel').center();
        });

        jQuery.fn.center = function () {
            this.css("position","absolute");
            this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2.3) +
            $(window).scrollTop()) + "px");
            return this;
        }

        $('.panel').center();
    </script>
@endpush