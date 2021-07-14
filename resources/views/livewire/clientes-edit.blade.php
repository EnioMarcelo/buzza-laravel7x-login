<div>

    <div class="row">
        <div class="col a-no-color">
            <a href="" wire:click.prevent="set_screen('show')" wire:loading.class="disabled">
                <h2 style="margin-left: 10px;"><i class="{{ $title_icon }}" aria-hidden="true"></i> {{ $title_page }}
                    <small> - Edição</small></h2>
            </a>
        </div>
    </div>


    <div class="col-sm-12 col-md-10 col-lg-10 col-xl-7 m-auto">

        {{-- FORM --}}
        <form id="form-edit-user" role="form" method="POST" action="" novalidate
              class="form-horizontal">

            @csrf
            @method('PUT')
            <input type="hidden" name="url" value="{{ URL::previous() }}">

            <div class="col">

                {{-- NOME --}}
                <label for="nome" class="col-sm-4 control-label">Nome</label>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" name="nome"
                               class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}"
                               placeholder="" wire:model="nome" autofocus>

                        @if($errors->has('nome'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('nome') }}</strong>
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
                               wire:model="email" placeholder="">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- END EMAIL --}}

            </div>

            {{-- BUTTONS FORM --}}
            <div class="row border-top-1">
                <div class="row m-auto margin-top-10">

                    <div class="inputgroup">
                        <div class="col">
                            <a href="" class="btn btn-outline-secondary margin-right-5"
                               wire:click.prevent="set_screen('show')" wire:loading.class="disabled">Cancelar</a>
                        </div>
                    </div>

                    <div class="inputgroup">
                        <div class="col">
                            <button wire:click.prevent="update({{$_id}})" wire:loading.class="disabled" class="btn btn-primary"><i class="fa fa-save"></i>
                                Salvar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            {{-- BUTTONS FORM --}}


        </form>
        {{-- END FORM --}}
    </div>

</div>


