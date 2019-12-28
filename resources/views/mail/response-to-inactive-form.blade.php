@component('mail::message')
# You have response to a Disabled Form

## The form titled {{ $form->name }} just got a new response. However, that form is currently disabled.

The response was saved, but we recommend checking it out.

@component('mail::button', ['url' => config('app.url') . '/form/' . $form->id])
Go To Form Now!
@endcomponent
@endcomponent
