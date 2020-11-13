@extends('masterpage')

@section('content_header')

<div class="row">
    <div class="col a-no-color">
        <a href="{{ route('usuario.alterar-senha') }}">
            <h2 style="margin-left: 10px;"><i class="fa fa-unlock" aria-hidden="true"></i> Alterar Senha</h2>
        </a>
    </div>
</div>

@stop



@section('content')



<div class="col-sm-12 col-md-10 col-lg-10 col-xl-10 m-auto">

    {{-- FORM --}}
    <form id="form-change-password" role="form" method="POST" action="{{ route('usuario.alterar-senha.change') }}"
        novalidate class="form-horizontal">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">



        {{-- DADOS DO USUÁRIO --}}

        <div class="col">

            <div class="row margin-bottom-15">
                <label for="email" class="mb-12 control-label">Dados do Usuário</label>

                {{-- NOME --}}
                <div class="input-group mb-12 margin-bottom-15">
                    <input type="text" name="usuario" class="form-control" value="" placeholder="{{ $user_name }}"
                        disabled>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                {{-- END NOME --}}

                {{-- EMAIL --}}
                <div class="input-group mb-12">
                    <input type="text" name="email" class="form-control" value="" placeholder="{{ $user_email }}"
                        disabled>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                {{-- END EMAIL --}}
            </div>

        </div>
        {{-- END DADOS DO USUÁRIO --}}

        {{-- SENHA ATUAL --}}
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label for="current-password" class="mb-12 control-label">Senha Atual</label>
                <div class="input-group mb-12">
                    <input type="password" name="current_password"
                        class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" value=""
                        placeholder="Digite aqui sua senha atual" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-unlock"></span>
                        </div>
                    </div>
                    @if($errors->has('current_password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('current_password') }}</strong>
                    </div>
                    @endif
                </div>

            </div>
            {{-- END SENHA ATUAL --}}

            {{-- NOVA SENHA --}}
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label for="password" class="mb-12 control-label">Nova Senha</label>
                <div class="input-group mb-12">
                    <input type="password" name="new_password"
                        class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" value=""
                        placeholder="Digite aqui sua nova senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-key"></span>
                        </div>
                    </div>
                    @if($errors->has('new_password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </div>
                    @endif
                </div>

            </div>
            {{-- END NOVA SENHA --}}

            {{-- CONFIRME NOVA SENHA --}}
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <label for="password_confirmation" class="mb-12 control-label">Confirme Nova Senha</label>
                <div class="input-group mb-12">
                    <input type="password" name="new_confirm_password"
                        class="form-control {{ $errors->has('new_confirm_password') ? 'is-invalid' : '' }}" value=""
                        placeholder="Confirme aqui sua nova senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-key"></span>
                        </div>
                    </div>
                    @if($errors->has('new_confirm_password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('new_confirm_password') }}</strong>
                    </div>
                    @endif
                </div>

            </div>
            {{-- END CONFIRME NOVA SENHA --}}

        </div>


        {{-- BUTTONS FORM --}}
        <div class="col-12 margin-top-25">
            <div class="row m-auto padding-top-10">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Alterar Senha
                </button>
            </div>
        </div>
        {{-- BUTTONS FORM --}}


    </form>
    {{-- END FORM --}}


</div>

@endsection
