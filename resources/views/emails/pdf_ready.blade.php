<x-mail::message>
# Your PDF is Ready

Hello,

Your label PDF **{{ $ready->set->name }}** has been generated successfully.

**Records:** {{ $ready->records }}

The PDF is attached to this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>