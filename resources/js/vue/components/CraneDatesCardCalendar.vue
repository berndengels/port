<template>
    <div class="card align-self-center calendar">
        <div class="card-header">
            <strong v-html="title"></strong>
        </div>
        <div v-if="loading" class="card-body p-3 loader-wrapper">
            <pulse-loader color="#394263" size="20px" />
        </div>
        <div v-else class="card-body p-3">
            <FullCalendar ref="fullCalendar" :options="options" />
        </div>
        <div v-if="this.selectedDate">
            <MyForm :data="craneDate" :errors="errors">
                <MySelect name="cranable_type" :options="cranableTypeOptions" label="Art" @change="onChange" class="w-75" />
                <MySelect v-if="boats" name="cranable_id" label="Boot" :options="boats" class="w-75" />
                <MyInput name="crane_date" label="Kran-Termin" class="w-75" />
            </MyForm>
        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timegridGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import MyForm from "v@/components/form/MyForm.vue";
import MySelect from "v@/components/form/MySelect.vue";
import MyInput from "v@/components/form/MyInput.vue";

export default {
    name: "CraneDatesCardCalendar",
    components: {MyInput, MySelect, MyForm, FullCalendar, PulseLoader },
    props: {
        title: String,
    },
    data() {
        return {
            loading: true,
            calendarApi: null,
            selectedDate: null,
            craneDate: {
                cranable_type: null,
                cranable_id: null,
                crane_date: null,
            },
            options: {
                plugins: [ dayGridPlugin, timegridGridPlugin, interactionPlugin ],
                dateClick: this.handleDateClick,
                initialView: 'dayGridMonth',
                contentWidth: '100%',
                contentHeight: '600px',
                selectable: true,
                selectOverlap: true,
                locale: 'de',
                firstDay: 1,
                displayEventTime: true,
                events: [],
            },
        }
    },
    computed: {
        dates() {
            return this.$store.state.craneDates.dates;
        },
        boats() {
            return this.$store.state.craneDates.boats;
        },
        cranableTypeOptions() {
            return this.$store.state.craneDates.cranableTypeOptions;
        },
        errors() {
            return this.$store.state.craneDates.errors;
        },
    },
    methods: {
//        ...mapActions({getBoats: 'craneDates/getBoats'}),

        handleDateClick: function(arg) {
            console.info("arg", arg);
            this.selectedDate = arg.dateStr;
            this.craneDate.crane_date = arg.dateStr;
        },
        onChange(e) {
            let $el = $(e.target);
            if('cranable_type' === $el.attr('name')) {
                this.$store.dispatch("craneDates/getBoats", $el.val());
            }
        },
        close() {
        },
    },
    created() {
    		this.options.events = this.dates;
		    this.loading = false;
    },
    mounted() {
        this.calendarApi = this.$refs ? this.$refs.fullCalendar.getApi() : null;
    }
}
</script>
