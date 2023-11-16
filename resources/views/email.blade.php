@component('mail::message')

    # New product requisition created

    {{ date('Y-m-d') }}
    Hello Sir/Madam,

    New product requisition created.


    For any queries please contact Admin (employee@gmail.com).

    Regards,
    Employee

    Thanks,
    {{ config('app.name') }}

@endcomponent
