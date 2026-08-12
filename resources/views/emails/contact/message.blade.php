<x-mail::message>
# New Contact Message

A new message has been submitted through the Product/Category Catalogue API.

**Name:** {{ $contactMessage->name }}

**Email:** {{ $contactMessage->email }}

**Subject:** {{ $contactMessage->subject }}

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
