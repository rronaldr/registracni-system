import moment from "moment/moment";
export const formatDate = function (date) {
    if (date) {
    return moment(String(date)).format('DD.MM.YYYY HH:mm')
    }
}
