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
import {mapGetters} from "vuex";
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
}
</script>

<!--style scoped>
.fc-not-allowed,
.fc-not-allowed .fc-event { /* override events' custom cursors */
    cursor: not-allowed;
}
.fc-unselectable {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    -webkit-touch-callout: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-user-select: none;
    user-select: none;
}
.fc {
    /* layout of immediate children */
    display: flex;
    flex-direction: column;
    font-size: 0.8em
}
.fc,
.fc *,
.fc *:before,
.fc *:after {
    box-sizing: border-box;
}
.fc table {
    border-collapse: collapse;
    border-spacing: 0;
    font-size: 0.8em; /* normalize cross-browser */
}
.fc th {
    text-align: center;
}
.fc th,
.fc td {
    padding: 0;
    vertical-align: top;
}
.fc a[data-navlink] {
    cursor: pointer;
}
.fc a[data-navlink]:hover {
    text-decoration: underline;
}
.fc-direction-ltr {
    direction: ltr;
    text-align: left;
}
.fc-direction-rtl {
    direction: rtl;
    text-align: right;
}
.fc-theme-standard td,
.fc-theme-standard th {
    border: 1px solid #ddd;
}
.fc-liquid-hack td,
.fc-liquid-hack th {
    position: relative;
}
@font-face {
    font-family: 'fcicons';
    src: url("data:application/x-font-ttf;charset=utf-8;base64,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") format('truetype');
    font-weight: normal;
    font-style: normal;
}
.fc-icon {
    /* added for fc */
    display: inline-block;
    font-family: 'fcicons' !important;
    -webkit-font-smoothing: antialiased;
    font-style: normal;
    font-variant: normal;
    font-weight: normal;
    height: 1em;
    line-height: 1;
    /* use !important to prevent issues with browser extensions that change fonts */
    -moz-osx-font-smoothing: grayscale;
    speak: none;
    text-align: center;
    text-transform: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-user-select: none;
    /* Better Font Rendering =========== */
    user-select: none;
    width: 1em;
}
.fc-icon-chevron-left:before {
    content: "\e900";
}
.fc-icon-chevron-right:before {
    content: "\e901";
}
.fc-icon-chevrons-left:before {
    content: "\e902";
}
.fc-icon-chevrons-right:before {
    content: "\e903";
}
.fc-icon-minus-square:before {
    content: "\e904";
}
.fc-icon-plus-square:before {
    content: "\e905";
}
.fc-icon-x:before {
    content: "\e906";
}
.fc .fc-button {
    border-radius: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    margin: 0;
    overflow: visible;
    text-transform: none;
}
.fc .fc-button:focus {
    outline: 1px dotted;
    outline: 5px auto -webkit-focus-ring-color;
}
.fc .fc-button {
    -webkit-appearance: button;
}
.fc .fc-button:not(:disabled) {
    cursor: pointer;
}
.fc .fc-button::-moz-focus-inner {
    border-style: none;
    padding: 0;
}
.fc .fc-button {
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 0.25em;
    display: inline-block;
    font-size: 0.8em;
    font-weight: 400;
    line-height: 1.5;
    padding: 0.4em 0.65em;
    text-align: center;
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    vertical-align: middle;
}
.fc .fc-button:hover {
    text-decoration: none;
}
.fc .fc-button:focus {
    box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    outline: 0;
}
.fc .fc-button:disabled {
    opacity: 0.65;
}
.fc .fc-button-primary {
    background-color: #2C3E50;
    border-color: #2C3E50;
    color: #fff;
}
.fc .fc-button-primary:hover {
    background-color: #1e2b37;
    border-color: #1a252f;
    color: #fff;
}
.fc .fc-button-primary:disabled { /* not DRY */
    background-color: #2C3E50;
    border-color: #2C3E50;
    color: #fff;
}
.fc .fc-button-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
}
.fc .fc-button-primary:not(:disabled):active,
.fc .fc-button-primary:not(:disabled).fc-button-active {
    background-color: #1a252f;
    border-color: #151e27;
    color: #fff;
}
.fc .fc-button-primary:not(:disabled):active:focus,
.fc .fc-button-primary:not(:disabled).fc-button-active:focus {
    box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
}
.fc .fc-button .fc-icon {
    font-size: 1.0em; /* bump up the size (but don't make it bigger than line-height of button, which is 1.5em also) */
    vertical-align: middle;
}
.fc .fc-button-group {
    display: inline-flex;
    position: relative;
    vertical-align: middle;
}
.fc .fc-button-group > .fc-button {
    flex: 1 1 auto;
    position: relative;
}
.fc .fc-button-group > .fc-button:hover {
    z-index: 1;
}
.fc .fc-button-group > .fc-button:focus,
.fc .fc-button-group > .fc-button:active,
.fc .fc-button-group > .fc-button.fc-button-active {
    z-index: 1;
}
.fc-direction-ltr .fc-button-group > .fc-button:not(:first-child) {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
    margin-left: -1px;
}
.fc-direction-ltr .fc-button-group > .fc-button:not(:last-child) {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}
.fc-direction-rtl .fc-button-group > .fc-button:not(:first-child) {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
    margin-right: -1px;
}
.fc-direction-rtl .fc-button-group > .fc-button:not(:last-child) {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}
.fc .fc-toolbar {
    align-items: center;
    display: flex;
    justify-content: space-between;
}
.fc .fc-toolbar.fc-header-toolbar {
    margin-bottom: 1.5em;
}
.fc .fc-toolbar.fc-footer-toolbar {
    margin-top: 1.5em;
}
.fc .fc-toolbar-title {
    font-size: 1.0em !important;
    margin: 0;
}
.fc-direction-ltr .fc-toolbar > * > :not(:first-child) {
    margin-left: .75em; /* space between */
}
.fc-direction-rtl .fc-toolbar > * > :not(:first-child) {
    margin-right: .75em; /* space between */
}
.fc-direction-rtl .fc-toolbar-ltr { /* when the toolbar-chunk positioning system is explicitly left-to-right */
    flex-direction: row-reverse;
}
.fc .fc-scroller {
    -webkit-overflow-scrolling: touch;
    position: relative; /* for abs-positioned elements within */
}
.fc .fc-scroller-liquid {
    height: 100%;
}
.fc .fc-scroller-liquid-absolute {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.fc .fc-scroller-harness {
    direction: ltr;
    overflow: hidden;
    position: relative;
    /* hack for chrome computing the scroller's right/left wrong for rtl. undone below... */
    /* TODO: demonstrate in codepen */
}
.fc .fc-scroller-harness-liquid {
    height: 100%;
}
.fc-direction-rtl .fc-scroller-harness > .fc-scroller { /* undo above hack */
    direction: rtl;
}
.fc-theme-standard .fc-scrollgrid {
    border: 1px solid #ddd;
}
.fc .fc-scrollgrid,
.fc .fc-scrollgrid table { /* all tables (self included) */
    table-layout: fixed;
    width: 100%; /* because tables don't normally do this */
}
.fc .fc-scrollgrid table { /* inner tables */
    border-left-style: hidden;
    border-right-style: hidden;
    border-top-style: hidden;
}
.fc .fc-scrollgrid {
    border-bottom-width: 0;
    border-collapse: separate;
    border-right-width: 0;
}
.fc .fc-scrollgrid-liquid {
    height: 100%;
}
.fc .fc-scrollgrid-section { /* a <tr> */
    height: 1px /* better than 0, for firefox */
}
.fc .fc-scrollgrid-section > td {
    height: 1px; /* needs a height so inner div within grow. better than 0, for firefox */
}
.fc .fc-scrollgrid-section table {
    height: 1px;
    /* for most browsers, if a height isn't set on the table, can't do liquid-height within cells */
    /* serves as a min-height. harmless */
}
.fc .fc-scrollgrid-section-liquid > td {
    height: 100%; /* better than `auto`, for firefox */
}
.fc .fc-scrollgrid-section > * {
    border-left-width: 0;
    border-top-width: 0;
}
.fc .fc-scrollgrid-section-header > *,
.fc .fc-scrollgrid-section-footer > * {
    border-bottom-width: 0;
}
.fc .fc-scrollgrid-section-body table,
.fc .fc-scrollgrid-section-footer table {
    border-bottom-style: hidden; /* head keeps its bottom border tho */
}
.fc .fc-scrollgrid-section-sticky > * {
    background: #fff;
    position: -webkit-sticky;
    position: sticky;
    z-index: 3; /* TODO: var */
    /* TODO: box-shadow when sticking */
}
.fc .fc-scrollgrid-section-header.fc-scrollgrid-section-sticky > * {
    top: 0; /* because border-sharing causes a gap at the top */
    /* TODO: give safari -1. has bug */
}
.fc .fc-scrollgrid-section-footer.fc-scrollgrid-section-sticky > * {
    bottom: 0; /* known bug: bottom-stickiness doesn't work in safari */
}
.fc .fc-scrollgrid-sticky-shim { /* for horizontal scrollbar */
    height: 1px; /* needs height to create scrollbars */
    margin-bottom: -1px;
}
.fc-sticky { /* no .fc wrap because used as child of body */
    position: -webkit-sticky;
    position: sticky;
}
.fc .fc-view-harness {
    flex-grow: 1; /* because this harness is WITHIN the .fc's flexbox */
    position: relative;
}
.fc .fc-view-harness-active > .fc-view {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.fc .fc-col-header-cell-cushion {
    display: inline-block; /* x-browser for when sticky (when multi-tier header) */
    padding: 2px 4px;
}
.fc .fc-bg-event,
.fc .fc-non-business,
.fc .fc-highlight {
    /* will always have a harness with position:relative/absolute, so absolutely expand */
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.fc .fc-non-business {
    background: rgba(215, 215, 215, 0.3);
}
.fc .fc-bg-event {
    background: rgb(143, 223, 130);
    opacity: 0.3;
}
.fc .fc-bg-event .fc-event-title {
    font-size: .8em;
    font-style: italic;
    margin: .5em;
}
.fc .fc-highlight {
    background: rgba(188, 232, 241, 0.3);
}
.fc .fc-cell-shaded,
.fc .fc-day-disabled {
    background: rgba(208, 208, 208, 0.3);
}
/* link resets */
/* ---------------------------------------------------------------------------------------------------- */
a.fc-event,
a.fc-event:hover {
    text-decoration: none;
}

/* cursor */
.fc-event[href],
.fc-event.fc-event-draggable {
    cursor: pointer;
}

/* event text content */
/* ---------------------------------------------------------------------------------------------------- */
.fc-event .fc-event-main {
    position: relative;
    z-index: 2;
}
/* dragging */
/* ---------------------------------------------------------------------------------------------------- */
.fc-event-dragging:not(.fc-event-selected) { /* MOUSE */
    opacity: 0.75;
}
.fc-event-dragging.fc-event-selected { /* TOUCH */
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.3);
}
/* resizing */
/* ---------------------------------------------------------------------------------------------------- */
/* (subclasses should hone positioning for touch and non-touch) */
.fc-event .fc-event-resizer {
    display: none;
    position: absolute;
    z-index: 4;
}
.fc-event:hover .fc-event-resizer, .fc-event-selected .fc-event-resizer {
    display: block;
}
.fc-event-selected .fc-event-resizer {
    background: #fff;
    border-color: inherit;
    border-radius: 4px;
    border-style: solid;
    border-width: 1px;
    height: 8px;
    width: 8px;

    /* expand hit area */

}
.fc-event-selected .fc-event-resizer:before {
    bottom: -20px;
    content: '';
    left: -20px;
    position: absolute;
    right: -20px;
    top: -20px;
}
.fc-event-selected,
.fc-event:focus {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2)
}
.fc-event-selected:before, .fc-event:focus:before {
    bottom: 0;
    content: "";
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 3;
}
.fc-event-selected:after, .fc-event:focus:after {
    background: rgba(0, 0, 0, 0.25);
    bottom: -1px;
    content: "";
    left: -1px;

    /* assume there's a border on all sides. overcome it. */
    /* sometimes there's NOT a border, in which case the dimmer will go over */
    /* an adjacent border, which looks fine. */
    position: absolute;
    right: -1px;
    top: -1px;
    z-index: 1;
}

/*
A HORIZONTAL event
*/
.fc-h-event { /* allowed to be top-level */
    background-color: #3788d8;
    border: 1px solid #3788d8;
    display: block;
}

.fc-h-event .fc-event-main {
    color: #fff;
}

.fc-h-event .fc-event-main-frame {
    display: flex; /* for make fc-event-title-container expand */
}

.fc-h-event .fc-event-time {
    max-width: 100%; /* clip overflow on this element */
    overflow: hidden;
}

.fc-h-event .fc-event-title-container { /* serves as a container for the sticky cushion */
    flex-grow: 1;
    flex-shrink: 1;
    min-width: 0; /* important for allowing to shrink all the way */
}

.fc-h-event .fc-event-title {
    display: inline-block; /* need this to be sticky cross-browser */
    left: 0; /* for sticky */
    max-width: 100%; /* clip overflow on this element */
    overflow: hidden;
    right: 0; /* for sticky */
    vertical-align: top; /* for not messing up line-height */
}

.fc-h-event.fc-event-selected:before {
    /* expand hit area */
    bottom: -10px;
    top: -10px;
}

/* adjust border and border-radius (if there is any) for non-start/end */
.fc-direction-ltr .fc-daygrid-block-event:not(.fc-event-start),
.fc-direction-rtl .fc-daygrid-block-event:not(.fc-event-end) {
    border-bottom-left-radius: 0;
    border-left-width: 0;
    border-top-left-radius: 0;
}

.fc-direction-ltr .fc-daygrid-block-event:not(.fc-event-end),
.fc-direction-rtl .fc-daygrid-block-event:not(.fc-event-start) {
    border-bottom-right-radius: 0;
    border-right-width: 0;
    border-top-right-radius: 0;
}

/* resizers */
.fc-h-event:not(.fc-event-selected) .fc-event-resizer {
    bottom: 0;
    top: 0;
    width: 8px;
}

.fc-direction-ltr .fc-h-event:not(.fc-event-selected) .fc-event-resizer-start,
.fc-direction-rtl .fc-h-event:not(.fc-event-selected) .fc-event-resizer-end {
    cursor: w-resize;
    left: -4px;
}

.fc-direction-ltr .fc-h-event:not(.fc-event-selected) .fc-event-resizer-end,
.fc-direction-rtl .fc-h-event:not(.fc-event-selected) .fc-event-resizer-start {
    cursor: e-resize;
    right: -4px;
}

/* resizers for TOUCH */
.fc-h-event.fc-event-selected .fc-event-resizer {
    margin-top: -4px;
    top: 50%;
}

.fc-direction-ltr .fc-h-event.fc-event-selected .fc-event-resizer-start,
.fc-direction-rtl .fc-h-event.fc-event-selected .fc-event-resizer-end {
    left: -4px;
}

.fc-direction-ltr .fc-h-event.fc-event-selected .fc-event-resizer-end,
.fc-direction-rtl .fc-h-event.fc-event-selected .fc-event-resizer-start {
    right: -4px;
}
.fc .fc-popover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
    position: absolute;
    z-index: 9999;
}
.fc .fc-popover-header {
    align-items: center;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 3px 4px;
}
.fc .fc-popover-title {
    margin: 0 2px;
}
.fc .fc-popover-close {
    cursor: pointer;
    font-size: 1.0em;
    opacity: 0.65;
}
.fc-theme-standard .fc-popover {
    background: #fff;
    border: 1px solid #ddd;
}
.fc-theme-standard .fc-popover-header {
    background: rgba(208, 208, 208, 0.3);
}
</style-->
