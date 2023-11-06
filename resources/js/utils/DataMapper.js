import moment from 'moment/moment'

export const eventCreateObject = {
    name: null,
    subtitle: null,
    calendar_id: null,
    contact: {
        person: null,
        email: null
    },
    type: 1,
    global_blacklist: false,
    event_blacklist: false,
    blacklist_users: null,
    template: {
        id: 0,
        content: null
    },
    user_group: null
}

export const dateObject = {
    id: null,
    name: null,
    location: null,
    capacity: null,
    unlimited_capacity: false,
    substitute: false,
    date_from: null,
    time_from: null,
    date_to: null,
    time_to: null,
    enrollment_from: null,
    enrollment_from_time: null,
    enrollment_to: null,
    enrollment_to_time: null,
    withdraw_date: null,
    withdraw_time: null,
    enrollments_count: 0
}

export const mapLastDateObject = function (date, lastDate) {
    date.id = lastDate.id + 1
    date.name = lastDate.name
    date.location = lastDate.location
    date.capacity = lastDate.capacity
    date.date_from = lastDate.date_from
    date.time_from = lastDate.time_from
    date.date_to = lastDate.date_to
    date.time_to = lastDate.time_to
    date.enrollment_from = lastDate.enrollment_from
    date.enrollment_from_time = lastDate.enrollment_from_time
    date.enrollment_to = lastDate.enrollment_to
    date.enrollment_to_time = lastDate.enrollment_to_time
    date.withdraw_date = lastDate.withdraw_date
    date.withdraw_time = lastDate.withdraw_time
}

export const editEventMap = function (event) {
    return {
        id: event.id,
        name: event.name,
        subtitle: event.subtitle,
        calendar_id: event.calendar_id,
        contact: {
            person: event.contact_person,
            email: event.contact_email
        },
        type: event.type,
        global_blacklist: Boolean(event.global_blacklist),
        event_blacklist: Boolean(event.event_blacklist),
        template: {
            id: event.template_id,
            content: event.template_content
        },
        blacklist_id: event.blacklist_id,
        user_group: event.user_group,
        status: event.status,
        created_at: event.created_at,
        updated_at: event.updated_at,
        user_id: event.user_id
    }
}

export const duplicateEventMap = function (event) {
    return {
        name: event.name,
        subtitle: event.subtitle,
        calendar_id: event.calendar_id,
        contact: {
            person: event.contact_person,
            email: event.contact_email
        },
        type: event.type,
        global_blacklist: Boolean(event.global_blacklist),
        event_blacklist: Boolean(event.event_blacklist),
        template: {
            id: event.template_id ?? null,
            content: event.template_content ?? null
        },
        blacklist_id: event.blacklist_id ?? null,
        user_group: event.user_group ?? null,
        user_id: event.user_id ?? null
    }
}

export const importDatesMap = function (dates) {
    let id = 1

    return dates.map(function (date) {
        let dateTimeFormat = 'YYYY-MM-DD HH:mm:ss'
        let dateFormat = 'YYYY-MM-DD'
        let timeFormat = 'HH:mm'

        let datetimeFrom =
            date.date_start !== null
                ? moment(date.date_start, dateTimeFormat)
                : null
        let datetimeTo =
            date.date_end !== null
                ? moment(date.date_end, dateTimeFormat)
                : null
        let enrollmentFrom =
            date.enrollment_start !== null
                ? moment(date.enrollment_start, dateTimeFormat)
                : null
        let enrollmentTo =
            date.enrollment_end !== null
                ? moment(date.enrollment_end, dateTimeFormat)
                : null
        let withdrawTo =
            date.withdraw_end !== null
                ? moment(date.withdraw_end, dateTimeFormat)
                : null

        return {
            id: id++,
            location: date.location,
            capacity: date.capacity,
            date_from:
                datetimeFrom !== null ? datetimeFrom.format(dateFormat) : null,
            time_from:
                datetimeFrom !== null ? datetimeFrom.format(timeFormat) : null,
            date_to: datetimeTo !== null ? datetimeTo.format(dateFormat) : null,
            time_to: datetimeTo !== null ? datetimeTo.format(timeFormat) : null,
            enrollment_from:
                enrollmentFrom !== null
                    ? enrollmentFrom.format(dateFormat)
                    : null,
            enrollment_from_time:
                enrollmentFrom !== null
                    ? enrollmentFrom.format(timeFormat)
                    : null,
            enrollment_to:
                enrollmentTo !== null ? enrollmentTo.format(dateFormat) : null,
            enrollment_to_time:
                enrollmentTo !== null ? enrollmentTo.format(timeFormat) : null,
            withdraw_date:
                withdrawTo !== null ? withdrawTo.format(dateFormat) : null,
            withdraw_time:
                withdrawTo !== null ? withdrawTo.format(timeFormat) : null
        }
    })
}

export const formatEventDates = function (dates) {
    return dates.map(function (date) {
        let dateTimeFormat = 'YYYY-MM-DD HH:mm:ss'
        let dateFormat = 'YYYY-MM-DD'
        let timeFormat = 'HH:mm'

        let datetimeFrom =
            date.date_start !== null
                ? moment(date.date_start, dateTimeFormat)
                : null
        let datetimeTo =
            date.date_end !== null
                ? moment(date.date_end, dateTimeFormat)
                : null
        let enrollmentFrom =
            date.enrollment_start !== null
                ? moment(date.enrollment_start, dateTimeFormat)
                : null
        let enrollmentTo =
            date.enrollment_end !== null
                ? moment(date.enrollment_end, dateTimeFormat)
                : null
        let withdrawTo =
            date.withdraw_end !== null
                ? moment(date.withdraw_end, dateTimeFormat)
                : null

        return {
            id: date.id,
            location: date.location,
            substitute: Boolean(date.substitute),
            capacity: date.capacity,
            name: date.name,
            unlimited_capacity: date.capacity === -1,
            enrollments_count: date.enrollments_count,
            date_from:
                datetimeFrom !== null ? datetimeFrom.format(dateFormat) : null,
            time_from:
                datetimeFrom !== null ? datetimeFrom.format(timeFormat) : null,
            date_to: datetimeTo !== null ? datetimeTo.format(dateFormat) : null,
            time_to: datetimeTo !== null ? datetimeTo.format(timeFormat) : null,
            enrollment_from:
                enrollmentFrom !== null
                    ? enrollmentFrom.format(dateFormat)
                    : null,
            enrollment_from_time:
                enrollmentFrom !== null
                    ? enrollmentFrom.format(timeFormat)
                    : null,
            enrollment_to:
                enrollmentTo !== null ? enrollmentTo.format(dateFormat) : null,
            enrollment_to_time:
                enrollmentTo !== null ? enrollmentTo.format(timeFormat) : null,
            withdraw_date:
                withdrawTo !== null ? withdrawTo.format(dateFormat) : null,
            withdraw_time:
                withdrawTo !== null ? withdrawTo.format(timeFormat) : null
        }
    })
}

export const formatEnrollments = function (data) {
    return data.enrollments.map(function (enrollment) {
        let user = enrollment.user
        let customFields = null

        if (enrollment.c_fields !== null) {
            customFields = enrollment.c_fields.map(function (field) {
                return `${field.label}: ${field.value}`
            })
        }

        return {
            date_id: data.id,
            enrollment_id: enrollment.id,
            xname: user.xname,
            email: user.email,
            enrolled: moment(
                enrollment.created_at,
                'YYYY-MM-DD HH:mm:ss'
            ).format('D.M.YYYY HH:mm'),
            state: enrollment.state,
            custom_fields:
                customFields !== null ? customFields.toString() : null
        }
    })
}
