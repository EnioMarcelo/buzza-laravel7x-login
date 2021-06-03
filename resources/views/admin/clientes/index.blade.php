@extends('masterpage')


@section('content_header')

<div class="row">
    <div class="col a-no-color">
        <a href="cliente">
            <h2 style="margin-left: 10px;"><i class="fa fa-user"></i> Clientes</h2>
        </a>
    </div>

    <div class="col">
        <a class="btn btn-block btn-outline-primary col-md-7 col-lg-7 col-xl-6 m-auto" href="{{ route('clientes.cliente.create') }}"><i class="fa fa-plus"></i> Novo Cliente</a>
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

        <table class="table table-striped table-hover table-sm">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">Tipo Pessoa</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">E-Mail</th>
                    <th class="text-center" scope="col">AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $key => $cliente)
                <tr>
                    <td class="text-center"> {{ $page > 1 ? ($key+($page*$per_page)-$per_page)+1 : $key+1 }} </td>
                    <td> {{ $cliente->tipo_pessoa }} </td>
                    <td> {{ $cliente->nome }} </td>
                    <td> {{ $cliente->cpf }} </td>
                    <td> {{ $cliente->cnpj }} </td>
                    <td> {{ $cliente->email }} </td>

                    {{-- AÇÕES --}}
                    <td class="text-center">
                        <div class="text-center">

                            <a href="{{ route('clientes.cliente.edit',['cliente'=>$cliente->id]) }}" class="btn badge bg-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></a>

                            <button class="btn badge bg-danger btn_delete_data" data-action="{{ route('clientes.cliente.destroy',['cliente'=>$cliente->id]) }}" data-redirect="{{ url()->full() }}" data-toggle="tooltip" data-placement="top" title="Deletar"><i class="fa fa-trash"></i></button>


                        </div>
                    </td>
                    {{-- AÇÕES --}}

                </tr>
                @endforeach
            </tbody>
        </table>
        <tfoot>
            {{-- <tr>--}}
            {{-- <td colspan="12">{{ $clientes->links() }}</td>--}}
            {{-- </tr>--}}

            @if( $clientes->count()==0 )
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
    <div class="m-auto margin-top-10" style="height: 48px;">
        {{ $clientes->links() }}
    </div>
</div>

@stop