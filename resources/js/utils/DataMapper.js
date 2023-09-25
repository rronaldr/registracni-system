import moment from "moment/moment";

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
        id: null,
        content: null,
    },
    user_group: null,
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
    withdraw_time: null
}

export const mapLastDateObject = function (date, lastDate) {
    date.id = lastDate.id + 1
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
        name: event.name,
        subtitle: event.subtitle,
        calendar_id: event.calendar_id,
        contact: {
            person: event.contact_person,
            email: event.contact_email,
        },
        type: event.type,
        global_blacklist: Boolean(event.global_blacklist),
        event_blacklist: Boolean(event.event_blacklist),
        template: {
            id: event.template_id,
            content: event.template_content,
        },
        blacklist_id: event.blacklist_id,
        user_group: event.user_group
    }
}

export const formatEventDates = function (dates) {
    return dates.map(function (date) {
        let dateTimeFormat = 'YYYY-MM-DD HH:mm:ss'
        let dateFormat = 'YYYY-MM-DD'
        let timeFormat = 'HH:mm'

        let datetimeFrom = moment(date.date_start,dateTimeFormat)
        let datetimeTo = moment(date.date_end,dateTimeFormat)
        let enrollmentFrom = moment(date.enrollment_start,dateTimeFormat)
        let enrollmentTo = moment(date.enrollment_end,dateTimeFormat)
        let withdrawTo = moment(date.withdraw_end,dateTimeFormat)

        return {
            id: date.id,
            location: date.location,
            substitute: Boolean(date.substitute),
            capacity: date.capacity,
            name: date.name,
            unlimited_capacity: date.capacity === -1,
            date_from: datetimeFrom.format(dateFormat),
            time_from: datetimeFrom.format(timeFormat),
            date_to: datetimeTo.format(dateFormat),
            time_to: datetimeTo.format(timeFormat),
            enrollment_from: enrollmentFrom.format(dateFormat),
            enrollment_from_time: enrollmentFrom.format(timeFormat),
            enrollment_to: enrollmentTo.format(dateFormat),
            enrollment_to_time: enrollmentTo.format(timeFormat),
            withdraw_date: withdrawTo.format(dateFormat),
            withdraw_time: withdrawTo.format(timeFormat)
        }
    })
}
