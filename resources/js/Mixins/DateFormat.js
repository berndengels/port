
const DateFormat = {
    methods: {
        formatDate(dateString) {
            const date = dayjs(dateString);
            return date.format('dd D.MM.YYYY');
        },
        formatDateInput(dateString) {
            const date = dayjs(dateString);
            return date.format('YYYY-MM-DD');
        },
        countDays( from, until ) {
            return dayjs(until).diff(from, 'days')
        }
    }
}
export default DateFormat
