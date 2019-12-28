@component('mail::message')
# You have a new response on {{ $form->name }}

@foreach($response->data as $key => $value)
    {{ $key }}: {{ $value }}
    
@endforeach

@component('mail::button', ['url' => config('app.url') . '/form/' . $form->id])
Check It Out Now!
@endcomponent

@endcomponent
