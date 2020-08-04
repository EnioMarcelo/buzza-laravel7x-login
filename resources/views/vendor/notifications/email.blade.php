@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else

@lang('Enio Marcelo Buzaneli'),<br>
{{ config('app.app_name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
"Se você estiver com problemas para clicar no botão \":actionText\", copie e cole esta URL\n".
'no seu navegador:',
[
'actionText' => $actionText,
]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>

<span class="break-all">ATENÇÃO... Favor não responder este e-mail.</span>

@endslot
@endisset
@endcomponent
