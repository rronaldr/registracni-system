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
            <td>{{ sprintf('%d - %s', $event->type, __('app.event.type.'. $event->type)) }}</td>
            <td>{{ $event->global_blacklist ? 'Y - Ano' : 'N - Ne' }}</td>
            <td>{{ $event->event_blacklist ? 'Y - Ano' : 'N - Ne'}}</td>
            <td>{{ sprintf('%d - %s', $event->user_group, __('app.event.user_group.'. $event->user_group)) }}</td>
        </tr>
    </tbody>
</table>

<h3>{{ __('app.date.dates') }}</h3>
<table>
    <thead>
    <tr class="font-weight-bold">
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