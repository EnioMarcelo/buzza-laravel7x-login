@extends('masterpage')

@section('content_header')

    <div class="row">
        <div class="col a-no-color">
            <a href="{{ route('usuario.perfil') }}">
                <h2 style="margin-left: 10px;"><i class="fa fa-user" aria-hidden="true"></i> Perfil <small> -
                        Usuário</small></h2>
            </a>
        </div>
    </div>

@stop



@section('content')


    <div class="col-sm-12 col-md-10 col-lg-10 col-xl-7 m-auto">

        {{-- FORM --}}
        <form id="form-profile-user" role="form" method="POST" action="{{  route('usuario.perfil.update', $data->id) }}"
              novalidate
              class="form-horizontal">

            @csrf
            @method('PUT')

            <div class="col">

                {{-- NOME --}}
                <label for="name" class="col-sm-4 control-label">Nome</label>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" name="name"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') ?? $data->name }}" placeholder="" autofocus>

                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- END NOME --}}

                {{-- EMAIL --}}
                <label for="email" class="col-sm-4 control-label">E-Mail</label>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="{{ $data->email }}" disabled>
                    </div>
                </div>
                {{-- END EMAIL --}}


                {{-- DATA CADASTRO / DATA ÚLTIMO LOGIN --}}
                <div class="row">
                    <div class="col">
                        <label for="created_at" class="col control-label">Data Cadastro</label>
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" name="created_at" class="form-control text-center"
                                       placeholder="{{ $data->created_at }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="created_at" class="col control-label">Último Login</label>
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" name="created_at" class="form-control text-center"
                                       placeholder="dd/mm/aaaa" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
                {{-- END DATA CADASTRO / DATA ÚLTIMO LOGIN --}}

            </div>


            {{-- BUTTONS FORM --}}
            <div class="row m-auto padding-top-10 border-top-1">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Salvar Perfil
                </button>
            </div>
            {{-- BUTTONS FORM --}}


        </form>
        {{-- END FORM --}}


    </div>

@endsection





@section('custom-js')
    <script type="text/javascript">
        $(function () {
            $("[name='active']").bootstrapSwitch();
        });
    </script>
@endsection
