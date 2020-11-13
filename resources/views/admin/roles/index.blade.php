@extends('masterpage')


@section('content_header')

    <div class="row">
        <div class="col a-no-color">
            <a href="roles">
                <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}"></i> {{ $title_page }}</h2>
            </a>
        </div>

        <div class="col">
            <a class="btn btn-block btn-outline-primary col-md-7 col-lg-7 col-xl-6 m-auto"
               href="{{ route('admin.role.create') }}"><i class="fa fa-plus"></i> Novo Perfil</a>
        </div>

        <div class="col">
            <div class="row float-right">
                <div class="col-sm">
                    <form action="#" method="get" class="form-inline mx-2">
                        <div class="input-group">
                            <input class="form-control" type="search" name="search_for" placeholder="Pesquisar"
                                   aria-label="Pesquisar" kl_vkbd_parsed="true" value="{{ $search_for }}">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@stop

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">

            <table class="table table-striped table-hover table-sm table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th class="text-center" style="width: 50px" scope="col">#</th>
                    <th scope="col">Nome do Perfil</th>
                    <th class="text-center" style="" scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $key => $role)

                    <tr>
                        <td class="text-center"> {{ $page > 1 ? ($key+($page*$per_page)-$per_page)+1 : $key+1 }} </td>
                        <td> {{ $role->name }} </td>
                        <td class="text-center" style="width: 200px">
                            @if($role->id <> 1)
                                <div class="text-center">

                                    <a href="{{ route('admin.role.edit',['role'=>$role->id]) }}"
                                       class="btn badge bg-primary"
                                       data-toggle="tooltip" data-placement="top" title="Editar"><i
                                            class="fa fa-edit"></i></a>

                                    <button class="btn badge bg-danger btn_delete_data"
                                            data-action="{{ route('admin.role.destroy',['role'=>$role->id]) }}"
                                            data-redirect="{{ url()->full() }}" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Deletar"><i class="fa fa-trash"></i></button>

                                    <span class="margin-right-5 margin-left-5">|</span>

                                    <a href="{{ route('admin.role.permission',['role'=>$role->id]) }}"
                                       class="btn btn-sm btn-outline-info">Permisssões</a>


                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <tfoot>
            {{--            <tr>--}}
            {{--                <td colspan="12">{{ $role->links() }}</td>--}}
            {{--            </tr>--}}

            @if( $roles->count()==0 )
                <tr>
                    <td colspan="12" class="">Nenhum registro encontrado.</td>
                </tr>
            @endif


            </tfoot>
        </div>
    </div>

@endsection



@section('custom-css')

    <style>
        .content-header {
            padding-top: 7px !important;
            padding-bottom: 0px !important;
        }
    </style>

@stop



@section('footer')

    <div class="row">
        <div class="m-auto margin-top-10" style="height: 48px !important;">
            <div class="col">{{ $roles->links() }}</div>
        </div>
    </div>

@stop




@section('custom-js')
    <script type="text/javascript">

    </script>
@endsection
