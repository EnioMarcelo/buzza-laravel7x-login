@extends('masterpage')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><i class="fa fa-fw fa-tachometer"></i> {{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Você está logado!') }}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection


