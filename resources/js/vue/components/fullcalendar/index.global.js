this.FullCalendar = this.FullCalendar || {};
this.FullCalendar.Vue = (function (exports, vue, core, internal) {
    'use strict';

    const OPTION_IS_COMPLEX = {
        headerToolbar: true,
        footerToolbar: true,
        events: true,
        eventSources: true,
        resources: true
    };

    // TODO: add types!
    /*
    works with objects and arrays
    */
    function shallowCopy(val) {
        if (typeof val === 'object') {
            if (Array.isArray(val)) {
                val = Array.prototype.slice.call(val);
            }
            else if (val) { // non-null
                val = { ...val };
            }
        }
        return val;
    }

    const FullCalendar = vue.defineComponent({
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
                teleportNodes.push(vue.h(vue.Teleport, {
                    key: customRendering.id,
                    to: customRendering.containerEl
                }, customRendering.generatorMeta(// a slot-render-function
                customRendering.renderProps)));
            }
            return vue.h('div', {
                // when renderId is changed, Vue will trigger a real-DOM async rerender, calling beforeUpdate/updated
                attrs: { 'data-fc-render-id': this.renderId }
            }, vue.h(vue.Fragment, teleportNodes)); // for containing Teleport keys
        },
        mounted() {
            const customRenderingStore = new internal.CustomRenderingStore();
            getSecret(this).handleCustomRendering = customRenderingStore.handle.bind(customRenderingStore);
            const calendarOptions = this.buildOptions(this.options);
            const calendar = new core.Calendar(this.$el, calendarOptions);
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

    exports["default"] = FullCalendar;

    Object.defineProperty(exports, '__esModule', { value: true });

    return exports;

})({}, Vue, FullCalendar, FullCalendar.Internal);
