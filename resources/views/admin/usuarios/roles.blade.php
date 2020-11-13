@extends('masterpage')

@section('content_header')


    <div class="row">
        <div class="col a-no-color">
            <a href="{{ route('admin.usuario') }}">
                <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}" aria-hidden="true"></i> {!! nl2br($title_page)
                !!}</h2>
            </a>
        </div>
    </div>

@stop


@section('content')


    <div class="col-sm-12 col-md-10 col-lg-10 col-xl-7 m-auto">

        {{-- FORM --}}
        <form id="form-edit-user" role="form" method="POST" action="{{  route('admin.usuario.roleSync') }}" novalidate
              class="form-horizontal">

            @csrf
            @method('PUT')
            <input type="hidden" name="url" value="{{ URL::previous() }}">
            <input type="hidden" name="id" value="{{ $usuario->id }}">


            {{-- PERFIS --}}
            <div class="col">

                @foreach ($roles as $role)

                    <div class="form-check">
                        <label class="form-check-label" for="{{ $role->id }}">
                            <input type="checkbox" class="form-check-input" id="{{ $role->id }}"
                                   name="{{ $role->id }}"
                                {{ ($role->can == 1 ? 'checked' : '') }}>{{ $role->name }}
                        </label>
                    </div>

                @endforeach

            </div>
            {{-- END PERFIS --}}


            {{-- BUTTONS FORM --}}
            <div class="row border-top-1 margin-top-10">
                <div class="row m-auto margin-top-10">

                    <div class="inputgroup">
                        <div class="col">
                            <a href="{{ session()->get('origin_ref') }}"
                               class="btn btn-outline-secondary margin-right-5"><i
                                    class="fa fa-long-arrow-left"></i> Voltar</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <a href="{{ route('admin.usuario.create') }}"
                               class="btn btn-outline-primary margin-right-5"><i
                                    class="fa fa-plus"></i> Novo Usuário</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-exchange"></i> Sincronizar
                                Usuário
                            </button>
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

    </script>
@endsection
