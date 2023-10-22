<table>
    <thead>
    <tr>
        <th>{{ __('app.event.name') }}</th>
        <th>{{ __('app.event.subtitle') }}</th>
        <th>{{ __('app.event.calendar_id') }}</th>
        <th>{{ __('app.event.contact_person') }}</th>
        <th>{{ __('app.event.contact_email') }}</th>
        <th>{{ __('app.event.type.type') }}</th>
        <th>{{ __('app.event.status.status') }}</th>
        <th>{{ __('app.blacklist.global-blacklist') }}</th>
        <th>{{ __('app.event.event_blacklist') }}</th>
        <th>{{ __('app.event.user_group.user_group') }}</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $event->name }}</td>
            <td>{{ $event->subtitle }}</td>
            <td>{{ $event->calendar_id }}</td>
            <td>{{ $event->contact_person}}</td>
            <td>{{ $event->contact_email }}</td>
            <td>{{ $event->type }}</td>
            <td>{{ $event->status }}</td>
            <td>{{ $event->global_blacklist }}</td>
            <td>{{ $event->event_blacklist}}</td>
            <td>{{ $event->user_group }}</td>
        </tr>
    </tbody>
</table>

<h3>{{ __('app.event.enums') }}</h3>
<table>
    <thead>
    <tr>
        <th>{{ __('app.event.type.type') }}</th>
        <th>{{ __('app.event.status.status') }}</th>
        <th>{{ __('app.blacklist.global-blacklist') }}</th>
        <th>{{ __('app.event.event_blacklist') }}</th>
        <th>{{ __('app.event.user_group.user_group') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1 - {{ __('app.event.type.1') }}, 2 - {{ __('app.event.type.2') }}</td>
        <td>1 - {{ __('app.event.status.1') }}, 2 - {{ __('app.event.status.2') }}</td>
        <td>0 - {{ __('app.no') }}, 1 - {{ __('app.yes') }}</td>
        <td>0 - {{ __('app.no') }}, 1 - {{ __('app.yes') }}</td>
        <td>1 - {{ __('app.event.user_group.1') }}, 2 - {{ __('app.event.user_group.2') }}, 3 - {{ __('app.event.user_group.3') }}, 4 - {{ __('app.event.user_group.4') }}, 5 - {{ __('app.event.user_group.5') }}</td>
    </tr>
    </tbody>
</table>

<h3>{{ __('app.date.dates') }}</h3>
<table>
    <thead>
    <tr>
        <th>{{ __('app.date.location') }}</th>
        <th>{{ __('app.date.capacity') }}</th>
        <th>{{ __('app.date.date_start') }}</th>
        <th>{{ __('app.date.date_end') }}</th>
        <th>{{ __('app.date.enrollment_start') }}</th>
        <th>{{ __('app.date.enrollment_end') }}</th>
        <th>{{ __('app.date.withdraw_end') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($event->dates as $date)
        <tr>
            <td>{{ $date->location }}</td>
            <td>{{ $date->capacity }}</td>
            <td>{{ $date->date_start }}</td>
            <td>{{ $date->date_end }}</td>
            <td>{{ $date->enrollment_start }}</td>
            <td>{{ $date->enrollment_end }}</td>
            <td>{{ $date->withdraw_end }}</td>
        </tr>
    @endforeach
    </tbody>
</table>