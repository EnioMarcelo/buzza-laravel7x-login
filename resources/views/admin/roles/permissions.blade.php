@extends('masterpage')

@section('content_header')

    <div class="row">
        <div class="col a-no-color">
            <a href="{{ route('admin.role') }}">
                <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}" aria-hidden="true"></i> {!! nl2br($title_page)
                !!}</h2>
            </a>
        </div>
    </div>

@stop


@section('content')


    <div class="col-sm-12 col-md-10 col-lg-10 col-xl-7 m-auto">


        {{-- FORM --}}
        <form id="form-edit-user" role="form" method="POST" action="{{  route('admin.role.permissionSync') }}"
              novalidate
              class="form-horizontal">

            @csrf
            @method('PUT')
            <input type="hidden" name="url" value="{{ URL::previous() }}">
            <input type="hidden" name="id" value="{{ $role->id }}">

            {{-- PERMISSÕES --}}
            <div class="col">

                @foreach ($permissions as $permission)

                    <div class="form-check">
                        <label class="form-check-label" for="{{ $permission->id }}">
                            <input type="checkbox" class="form-check-input" id="{{ $permission->id }}"
                                   name="{{ $permission->id }}"
                                {{ ($permission->can == 1 ? 'checked' : '') }}>{{ $permission->name }}
                        </label>
                    </div>

                @endforeach

            </div>
            {{-- END PERMISSÕES --}}



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
                            <a href="{{ route('admin.role.create') }}" class="btn btn-outline-primary margin-right-5"><i
                                    class="fa fa-plus"></i> Novo Perfil do Usuário</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-exchange"></i> Sincronizar
                                Perfil
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
