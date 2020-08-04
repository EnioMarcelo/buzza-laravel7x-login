{{-- https://adminlte.io/docs/3.0/index.html --}}
@extends('adminlte::page')


@section('title', config('adminlte.title'))



@section('css')
    {{-- https://gitbrent.github.io/bootstrap4-toggle/ --}}
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"
          rel="stylesheet">


    <link rel="stylesheet" href="/css/boot-buzza.css">
    <link rel="stylesheet" href="/css/style.css">

    @yield('custom-css')

@stop







@section('js')
    {{-- https://gitbrent.github.io/bootstrap4-toggle/ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>



    <script src="/js/macros_js.js"></script>
    <script src="/js/scripts.js"></script>



    {{-- @if ($errors->any())
    <script type="text/javascript">
        $(function() {
            $(document).Toasts('create', {
                title: 'ERRO...',
                body: 'Ocorreu um erro inesperável.',
                class:'bg-danger toasts-width margin-top-5 margin-right-5',
                autohide:true,
                delay:5000,
                fade:true,
                icon:'fa fa-exclamation-triangle'
            });
        });
    </script>
    @endif --}}


    @if ($message = Session::get('error'))
        <script type="text/javascript">
            $(function () {
                $(document).Toasts('create', {
                    title: 'ATENÇÃO...',
                    body: '{{ $message }}',
                    class: 'bg-danger toasts-width margin-top-5 margin-right-5',
                    autohide: true,
                    delay: 3000,
                    fade: true,
                    icon: 'fa fa-exclamation-triangle'
                });
            });
        </script>
    @endif



    @if ($message = Session::get('info'))
        <script type="text/javascript">
            $(function () {
                $(document).Toasts('create', {
                    title: 'INFORMAÇÃO...',
                    body: '{{ $message }}',
                    class: 'bg-info toasts-width margin-top-5 margin-right-5',
                    autohide: true,
                    delay: 3000,
                    fade: true,
                    icon: 'fa fa-thumbs-up '
                });
            });
        </script>
    @endif



    @if ($message = Session::get('success'))
        <script type="text/javascript">
            $(function () {
                $(document).Toasts('create', {
                    title: 'SUCESSO...',
                    body: '{{ $message }}',
                    class: 'bg-success toasts-width margin-top-5 margin-right-5',
                    autohide: true,
                    delay: 2000,
                    fade: true,
                    icon: 'fa fa-thumbs-up '
                });
            });
        </script>
    @endif



    @if ($message = Session::get('warning'))
        <script type="text/javascript">
            $(function () {
                $(document).Toasts('create', {
                    title: 'ATENÇÃO...',
                    body: '{{ $message }}',
                    class: 'bg-warning toasts-width margin-top-5 margin-right-5',
                    autohide: true,
                    delay: 3000,
                    fade: true,
                    icon: 'fas fa-exclamation-triangle '
                });
            });
        </script>
    @endif



    @yield('custom-js')



@stop



@section('footer')
    <div class="row m-auto margin-top-15 margin-bottom-20">
        <div class="col text-right">
            <i class="fas fa-fw fa-calendar-day"></i>
            {{ strftime('%A, %d de %B de %Y', strtotime('today')) }}
        </div>
    </div>
@stop
