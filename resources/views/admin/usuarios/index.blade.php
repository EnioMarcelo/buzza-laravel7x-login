@extends('masterpage')


@section('content_header')

<div class="row">
    <div class="col a-no-color">
        <a href="usuarios">
            <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}"></i> {{ $title_page }}</h2>
        </a>
    </div>

    <div class="col">
        <a class="btn btn-block btn-outline-primary col-md-7 col-lg-7 col-xl-6 m-auto" href="{{ route('admin.usuario.create') }}"><i class="fa fa-plus"></i> Novo Usuário</a>
    </div>

    <div class="col">
        <div class="row float-right">
            <div class="col-sm">
                <form action="#" method="get" class="form-inline mx-2">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search_for" placeholder="Pesquisar" aria-label="Pesquisar" kl_vkbd_parsed="true" value="{{ $search_for }}">
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
                    <th scope="col">Nome</th>
                    <th scope="col">E-Mail</th>
                    <th class="text-center" scope="col">Data Cadastro</th>
                    <th class="text-center" scope="col">Ativo</th>
                    <th class="text-center" style="width: 140px;" scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $key => $usuario)

                <tr>
                    <td class="text-center"> {{ $page > 1 ? ($key+($page*$per_page)-$per_page)+1 : $key+1 }} </td>
                    <td> {{ $usuario->name }} </td>
                    <td> {{ $usuario->email }} </td>
                    <td class="text-center"> {{ $usuario->created_at }} </td>
                    <td class="text-center">
                        <input type="checkbox" class="btn-active" name="active" {{ $usuario->active == 1 ? 'checked' : '' }} data-action="{{ route('admin.usuario.btnactive',['usuario'=>$usuario->id]) }}" data-toggle="toggle" data-onstyle="outline-primary" data-offstyle="outline-danger" data-size="xs" {{ $usuario->id == Auth::user()->id ? 'disabled' : '' }}>
                    </td>
                    <td class="text-center">
                        <div class="text-center">

                            <a href="{{ route('admin.usuario.edit',['usuario'=>$usuario->id]) }}" class="btn badge bg-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></a>

                            <button class="btn badge bg-danger btn_delete_data" data-action="{{ route('admin.usuario.destroy',['usuario'=>$usuario->id]) }}" data-redirect="{{ url()->full() }}" data-toggle="tooltip" data-placement="top" title="Deletar" {{ $usuario->id == Auth::user()->id ? 'disabled' : '' }}><i class="fa fa-trash"></i></button>


                            <span class="margin-right-5 margin-left-5">|</span>

                            <a href="{{ route('admin.usuario.role',['usuario'=>$usuario->id]) }}" class="btn btn-sm btn-outline-info">Perfis</a>


                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <tfoot>
            {{-- <tr>--}}
            {{-- <td colspan="12">{{ $usuarios->links() }}</td>--}}
            {{-- </tr>--}}

            @if( $usuarios->count()==0 )
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
        <div class="col">{{ $usuarios->links() }}</div>
    </div>
</div>

@stop




@section('custom-js')
<script type="text/javascript">
    $(function() {

        $('.btn-active').change(function(e) {
            e.preventDefault();

            var _this = $(this);
            var _data_action = _this.attr('data-action');

            $.ajax({
                method: 'get',
                url: _data_action,
                success: function(response) {

                    if (response.warning) {
                        mc_alert_toast_warning(response.warning);
                        _this.parent().remove();
                    }
                    if (response.success) {
                        mc_alert_toast_success(response.success);
                    }

                }
            });
        });

    });
</script>
@endsection