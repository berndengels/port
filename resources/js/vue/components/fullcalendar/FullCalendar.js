import { defineComponent, h, Fragment, Teleport } from 'vue';
import { Calendar } from '@fullcalendar/core';
import { CustomRenderingStore } from '@fullcalendar/core/internal';
import { OPTION_IS_COMPLEX } from './options';
import { shallowCopy } from './utils';
const FullCalendar = defineComponent({
    props: {
        options: Object
    },
    data() {
        return {
            renderId: 0,
            customRenderingMap: new Map()
        };
    },
    methods: {
        getApi() {
            return getSecret(this).calendar;
        },
        buildOptions(suppliedOptions) {
            return {
                ...suppliedOptions,
                customRenderingMetaMap: this.$slots,
                handleCustomRendering: getSecret(this).handleCustomRendering,
            };
        },
    },
    render() {
        const teleportNodes = [];
        for (const customRendering of this.customRenderingMap.values()) {
            teleportNodes.push(h(Teleport, {
                key: customRendering.id,
                to: customRendering.containerEl
            }, customRendering.generatorMeta(// a slot-render-function
            customRendering.renderProps)));
        }
        return h('div', {
            // when renderId is changed, Vue will trigger a real-DOM async rerender, calling beforeUpdate/updated
            attrs: { 'data-fc-render-id': this.renderId }
        }, h(Fragment, teleportNodes)); // for containing Teleport keys
    },
    mounted() {
        const customRenderingStore = new CustomRenderingStore();
        getSecret(this).handleCustomRendering = customRenderingStore.handle.bind(customRenderingStore);
        const calendarOptions = this.buildOptions(this.options);
        const calendar = new Calendar(this.$el, calendarOptions);
        getSecret(this).calendar = calendar;
        calendar.render();
        customRenderingStore.subscribe((customRenderingMap) => {
            this.customRenderingMap = customRenderingMap; // likely same reference, so won't rerender
            this.renderId++; // force rerender
            getSecret(this).needCustomRenderingResize = true;
        });
    },
    beforeUpdate() {
        this.getApi().resumeRendering(); // the watcher handlers paused it
    },
    updated() {
        if (getSecret(this).needCustomRenderingResize) {
            getSecret(this).needCustomRenderingResize = false;
            this.getApi().updateSize();
        }
    },
    beforeUnmount() {
        this.getApi().destroy();
    },
    watch: buildWatchers()
});
export default FullCalendar;
// storing internal state:
// https://github.com/vuejs/vue/issues/1988#issuecomment-163013818
function getSecret(inst) {
    return inst;
}
function buildWatchers() {
    let watchers = {
        // watches changes of ALL options and their nested objects,
        // but this is only a means to be notified of top-level non-complex options changes.
        options: {
            deep: true,
            handler(options) {
                let calendar = this.getApi();
                calendar.pauseRendering();
                let calendarOptions = this.buildOptions(options);
                calendar.resetOptions(calendarOptions);
                this.renderId++; // will queue a rerender
            }
        }
    };
    for (let complexOptionName in OPTION_IS_COMPLEX) {
        // handlers called when nested objects change
        watchers[`options.${complexOptionName}`] = {
            deep: true,
            handler(val) {
                // unfortunately the handler is called with undefined if new props were set, but the complex one wasn't ever set
                if (val !== undefined) {
                    let calendar = this.getApi();
                    calendar.pauseRendering();
                    calendar.resetOptions({
                        // the only reason we shallow-copy is to trick FC into knowing there's a nested change.
                        // TODO: future versions of FC will more gracefully handle event option-changes that are same-reference.
                        [complexOptionName]: shallowCopy(val)
                    }, true);
                    this.renderId++; // will queue a rerender
                }
            }
        };
    }
    return watchers;
}
//# sourceMappingURL=FullCalendar.js.map
