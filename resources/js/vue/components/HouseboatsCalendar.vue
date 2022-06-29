<template>
    <div v-if="dates" class="flex-item-dashboard p-3 widget">
        <div v-if="title" class="title">{{ title }}</div>
        <div class="calendar content mt-2">
            <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        </div>
    </div>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import {ref} from "vue";

export default {
    name: "HouseboatsCalendar",
    props: ['dates','title','color'],
    components: { FullCalendar },
    data() {
        return {
            calendarOptions: {
                plugins: [ dayGridPlugin, interactionPlugin ],
                dateClick: this.handleDateClick,
                initialView: 'dayGridMonth',
                contentHeight: '350px',
                selectable: true,
                selectOverlap: true,
                locale: 'de',
                firstDay: 1,
                displayEventTime: false,
                expandRows: true,
                events: this.houseboat.dates,
            }
        }
    },
    setup(props) {
        const houseboat = ref({
            dates: props.dates,
        });
        return { houseboat }
    },
    methods: {
        handleDateClick(e)
        {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
//                date = (new Date(e.date)).toLocaleDateString('de-DE', options);
//            alert(date);
        }
    }
}
</script>
