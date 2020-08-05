@extends('masterpage')

@section('content_header')

    <div class="row">
        <div class="col a-no-color">
            <a href="{{ route('admin.usuarios') }}">
                <h2 style="margin-left: 10px;"><i class="fa fa-user" aria-hidden="true"></i> Usuário <small> -
                        Edição</small></h2>
            </a>
        </div>
    </div>

@stop


@section('content')


    <div class="col-sm-12 col-md-10 col-lg-10 col-xl-7 m-auto">

        {{-- FORM --}}
        <form id="form-edit-user" role="form" method="POST" action="{{  route('admin.usuarios.update') }}" novalidate
              class="form-horizontal">

            @csrf
            @method('PUT')
            <input type="hidden" name="url" value="{{ URL::previous() }}">
            <input type="hidden" name="id" value="{{ $usuario->id }}">

            <div class="col">

                {{-- NOME --}}
                <label for="name" class="col-sm-4 control-label">Nome</label>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" name="name"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') ?? $usuario->name }}" placeholder="" autofocus>

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
                        <input type="text" name="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') ?? $usuario->email }}" placeholder="">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- END EMAIL --}}

                {{-- ATIVO --}}
                <label for="email" class="col-sm-4 control-label">Ativo</label>
                <div class="col">
                    <div class="input-group mb-3">

                        <div class="make-switch switch-large">
                            <input type="checkbox" name="active" class="" data-off-color="danger"
                                   data-on-color="primary"
                                {{ old('active') == 'on' ? 'checked': $usuario->active == 1 ? 'checked' : '' }} {{  $usuario->id == Auth::user()->id ? 'disabled' : ''  }}>
                        </div>

                    </div>
                </div>
                {{-- END ATIVO --}}

            </div>

            {{-- BUTTONS FORM --}}
            <div class="row border-top-1">
                <div class="row m-auto margin-top-10">

                    <div class="inputgroup">
                        <div class="col">
                            <a href="{{ $_COOKIE['origin_ref'] }}"
                               class="btn btn-outline-secondary margin-right-5">Cancelar</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <a href="{{ route('admin.usuarios.create') }}"
                               class="btn btn-outline-primary margin-right-5"><i class="fa fa-plus"></i> Novo
                                Usuário</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </div>

                </div>
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
