! function (t) {
    const e = t.en = t.en || {};
    e.dictionary = Object.assign(e.dictionary || {}, {
        "Align center": "Align center",
        "Align left": "Align left",
        "Align right": "Align right",
        Justify: "Justify",
        "Text alignment": "Text alignment",
        "Text alignment toolbar": "Text alignment toolbar"
    })
}(window.CKEDITOR_TRANSLATIONS || (window.CKEDITOR_TRANSLATIONS = {})),
/*!
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md.
 */
(() => {
    var t = {
            968: (t, e, n) => {
                t.exports = n(672)("./src/core.js")
            },
            348: (t, e, n) => {
                t.exports = n(672)("./src/ui.js")
            },
            316: (t, e, n) => {
                t.exports = n(672)("./src/utils.js")
            },
            672: t => {
                "use strict";
                t.exports = ClassicEditor.dll
            }
        },
        e = {};

    function n(i) {
        var o = e[i];
        if (void 0 !== o) return o.exports;
        var r = e[i] = {
            exports: {}
        };
        return t[i](r, r.exports, n), r.exports
    }
    n.d = (t, e) => {
        for (var i in e) n.o(e, i) && !n.o(t, i) && Object.defineProperty(t, i, {
            enumerable: !0,
            get: e[i]
        })
    }, n.o = (t, e) => Object.prototype.hasOwnProperty.call(t, e), n.r = t => {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(t, "__esModule", {
            value: !0
        })
    };
    var i = {};
    (() => {
        "use strict";
        n.r(i), n.d(i, {
            Alignment: () => f,
            AlignmentEditing: () => g,
            AlignmentUI: () => d
        });
        var t = n(968),
            e = n(316);
        const o = ["left", "right", "center", "justify"];

        function r(t) {
            return o.includes(t)
        }

        function a(t, e) {
            return "rtl" == e.contentLanguageDirection ? "right" === t : "left" === t
        }

        function s(t) {
            const n = t.map((t => {
                    let e;
                    return e = "string" == typeof t ? {
                        name: t
                    } : t, e
                })).filter((t => {
                    const n = o.includes(t.name);
                    return n || (0, e.logWarning)("alignment-config-name-not-recognized", {
                        option: t
                    }), n
                })),
                i = n.filter((t => Boolean(t.className))).length;
            if (i && i < n.length) throw new e.CKEditorError("alignment-config-classnames-are-missing", {
                configuredOptions: t
            });
            return n.forEach(((n, i, o) => {
                const r = o.slice(i + 1);
                if (r.some((t => t.name == n.name))) throw new e.CKEditorError("alignment-config-name-already-defined", {
                    option: n,
                    configuredOptions: t
                });
                if (n.className) {
                    if (r.some((t => t.className == n.className))) throw new e.CKEditorError("alignment-config-classname-already-defined", {
                        option: n,
                        configuredOptions: t
                    })
                }
            })), n
        }
        const l = "alignment";
        class c extends t.Command {
            refresh() {
                const t = this.editor.locale,
                    n = (0, e.first)(this.editor.model.document.selection.getSelectedBlocks());
                this.isEnabled = Boolean(n) && this._canBeAligned(n), this.isEnabled && n.hasAttribute("alignment") ? this.value = n.getAttribute("alignment") : this.value = "rtl" === t.contentLanguageDirection ? "right" : "left"
            }
            execute(t = {}) {
                const e = this.editor,
                    n = e.locale,
                    i = e.model,
                    o = i.document,
                    r = t.value;
                i.change((t => {
                    const e = Array.from(o.selection.getSelectedBlocks()).filter((t => this._canBeAligned(t))),
                        i = e[0].getAttribute("alignment");
                    a(r, n) || i === r || !r ? function (t, e) {
                        for (const n of t) e.removeAttribute(l, n)
                    }(e, t) : function (t, e, n) {
                        for (const i of t) e.setAttribute(l, n, i)
                    }(e, t, r)
                }))
            }
            _canBeAligned(t) {
                return this.editor.model.schema.checkAttribute(t, l)
            }
        }
        class g extends t.Plugin {
            static get pluginName() {
                return "AlignmentEditing"
            }
            constructor(t) {
                super(t), t.config.define("alignment", {
                    options: o.map((t => ({
                        name: t
                    })))
                })
            }
            init() {
                const t = this.editor,
                    e = t.locale,
                    n = t.model.schema,
                    i = s(t.config.get("alignment.options")).filter((t => r(t.name) && !a(t.name, e))),
                    o = i.some((t => !!t.className));
                n.extend("$block", {
                    allowAttributes: "alignment"
                }), t.model.schema.setAttributeProperties("alignment", {
                    isFormatting: !0
                }), o ? t.conversion.attributeToAttribute(function (t) {
                    const e = {};
                    for (const n of t) e[n.name] = {
                        key: "class",
                        value: n.className
                    };
                    const n = {
                        model: {
                            key: "alignment",
                            values: t.map((t => t.name))
                        },
                        view: e
                    };
                    return n
                }(i)) : t.conversion.for("downcast").attributeToAttribute(function (t) {
                    const e = {};
                    for (const {
                            name: n
                        } of t) e[n] = {
                        key: "style",
                        value: {
                            "text-align": n
                        }
                    };
                    const n = {
                        model: {
                            key: "alignment",
                            values: t.map((t => t.name))
                        },
                        view: e
                    };
                    return n
                }(i));
                const l = function (t) {
                    const e = [];
                    for (const {
                            name: n
                        } of t) e.push({
                        view: {
                            key: "style",
                            value: {
                                "text-align": n
                            }
                        },
                        model: {
                            key: "alignment",
                            value: n
                        }
                    });
                    return e
                }(i);
                for (const e of l) t.conversion.for("upcast").attributeToAttribute(e);
                const g = function (t) {
                    const e = [];
                    for (const {
                            name: n
                        } of t) e.push({
                        view: {
                            key: "align",
                            value: n
                        },
                        model: {
                            key: "alignment",
                            value: n
                        }
                    });
                    return e
                }(i);
                for (const e of g) t.conversion.for("upcast").attributeToAttribute(e);
                t.commands.add("alignment", new c(t))
            }
        }
        var u = n(348);
        const m = new Map([
            ["left", t.icons.alignLeft],
            ["right", t.icons.alignRight],
            ["center", t.icons.alignCenter],
            ["justify", t.icons.alignJustify]
        ]);
        class d extends t.Plugin {
            get localizedOptionTitles() {
                const t = this.editor.t;
                return {
                    left: t("Align left"),
                    right: t("Align right"),
                    center: t("Align center"),
                    justify: t("Justify")
                }
            }
            static get pluginName() {
                return "AlignmentUI"
            }
            init() {
                const t = this.editor,
                    e = t.ui.componentFactory,
                    n = t.t,
                    i = s(t.config.get("alignment.options"));
                i.map((t => t.name)).filter(r).forEach((t => this._addButton(t))), e.add("alignment", (o => {
                    const r = (0, u.createDropdown)(o);
                    (0, u.addToolbarToDropdown)(r, (() => i.map((t => e.create(`alignment:${t.name}`)))), {
                        enableActiveItemFocusOnDropdownOpen: !0,
                        isVertical: !0,
                        ariaLabel: n("Text alignment toolbar")
                    }), r.buttonView.set({
                        label: n("Text alignment"),
                        tooltip: !0
                    }), r.extendTemplate({
                        attributes: {
                            class: "ck-alignment-dropdown"
                        }
                    });
                    const a = "rtl" === o.contentLanguageDirection ? m.get("right") : m.get("left"),
                        s = t.commands.get("alignment");
                    return r.buttonView.bind("icon").to(s, "value", (t => m.get(t) || a)), r.bind("isEnabled").to(s, "isEnabled"), this.listenTo(r, "execute", (() => {
                        t.editing.view.focus()
                    })), r
                }))
            }
            _addButton(t) {
                const e = this.editor;
                e.ui.componentFactory.add(`alignment:${t}`, (n => {
                    const i = e.commands.get("alignment"),
                        o = new u.ButtonView(n);
                    return o.set({
                        label: this.localizedOptionTitles[t],
                        icon: m.get(t),
                        tooltip: !0,
                        isToggleable: !0
                    }), o.bind("isEnabled").to(i), o.bind("isOn").to(i, "value", (e => e === t)), this.listenTo(o, "execute", (() => {
                        e.execute("alignment", {
                            value: t
                        }), e.editing.view.focus()
                    })), o
                }))
            }
        }
        class f extends t.Plugin {
            static get requires() {
                return [g, d]
            }
            static get pluginName() {
                return "Alignment"
            }
        }
    })(), (window.ClassicEditor = window.ClassicEditor || {}).alignment = i
})();
