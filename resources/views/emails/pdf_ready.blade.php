@component('mail::message')
# Your PDF is Ready

Set Name: {{ $ready->set->name }}
Records: {{ $ready->records }}

Generated In: 2 seconds

@component('mail::button', ['url' => route('download', ['token' => encrypt($ready->id)])])
Download
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
