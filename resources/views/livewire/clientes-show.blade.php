<div>


    @if($message_type)
        <div class="alert alert-{{$message_type}}" role="alert">
            <h4 class="alert-heading">ATENÇÃO !!! </h4>
            <p>Um erro inesperado ocorreu.</p>
            <p class="margin-top-minus-15">Entre em contato com o Administrador do Sistema.</p>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-outline-danger"
                    wire:click.prevent="set_screen('show')" wire:loading.class="disabled"><i
                    class="fa fa-reply margin-right-10"></i>Voltar
            </button>
        </div>
    @endif


    @if($type_screen == 'show')
        <div class="row">
            <div class="col a-no-color">
                <a href="" wire:click.prevent="set_screen('show')" wire:loading.class="disabled">
                    <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}" aria-hidden="true"></i> {{ $title_page }}</h2>
                </a>
            </div>

            <div class="col">
                <a class="btn btn-block btn-outline-primary col-md-7 col-lg-7 col-xl-6 m-auto"
                   href="" wire:click.prevent="set_screen('add')" wire:loading.class="disabled"><i class="fa fa-plus"></i>
                    Novo Cliente</a>
            </div>

            <div class="col">
                <div class="row float-right">
                    <div class="col-sm">
                        <div class="input-group">
                            <input wire:model="search_for"
                                   wire:keydown="reset_pagination"
                                   class="form-control" type="search" name="search_for"
                                   placeholder="Pesquisar"
                                   aria-label="Pesquisar" kl_vkbd_parsed="true">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="button">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{--<div class="row">
            <div class="m-auto margin-top-20 margin-bottom-10" style="height: 48px;">
                {{ $clientes->links() }}
            </div>
        </div>--}}


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
                        <tr id="trid-{{ $cliente->id}}">
                            <td class="text-center"> {{ $page > 1 ? ($key+($page*$per_page)-$per_page)+1 : $key+1 }} </td>
                            <td> {{ $cliente->tipo_pessoa }} </td>
                            <td> {{ $cliente->nome }} </td>
                            <td> {{ $cliente->cpf }} </td>
                            <td> {{ $cliente->cnpj }} </td>
                            <td> {{ $cliente->email }} </td>

                            {{-- AÇÕES --}}
                            <td class="text-center">
                                <div class="text-center">

                                    <a href=""
                                       wire:click.prevent="set_screen('edit', {{$cliente->id}})"
                                       wire:loading.class="disabled"
                                       class="btn badge bg-primary" data-toggle="tooltip" data-placement="top"
                                       title=""><i class="fa fa-edit"></i></a>

                                    <a href=""
                                       wire:click.prevent="confirm_delete({{$cliente->id}})"
                                       wire:loading.class="disabled"
                                       wire:parent.class="bg-blue"
                                       class="btn badge bg-danger" data-toggle="tooltip" data-placement="top"
                                       title=""><i class="fa fa-trash"></i></a>

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


        <div class="row">
            <div class="m-auto margin-top-10" style="height: 48px;">
                {{ $clientes->links() }}
            </div>
        </div>

    @endif


    @if($type_screen == 'add' && $message_type !== 'danger')

        @include('livewire.clientes-add')

    @endif

    @if($type_screen == 'edit' && $data)

        @include('livewire.clientes-edit')

    @endif

</div>


