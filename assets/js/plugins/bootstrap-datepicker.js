/*!
 * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
! function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
}(function(a, b) {
    function c() {
        return new Date(Date.UTC.apply(Date, arguments))
    }

    function d() {
        var a = new Date;
        return c(a.getFullYear(), a.getMonth(), a.getDate())
    }

    function e(a, b) {
        return a.getUTCFullYear() === b.getUTCFullYear() && a.getUTCMonth() === b.getUTCMonth() && a.getUTCDate() === b.getUTCDate()
    }

    function f(a) {
        return function() {
            return this[a].apply(this, arguments)
        }
    }

    function g(a) {
        return a && !isNaN(a.getTime())
    }

    function h(b, c) {
        function d(a, b) {
            return b.toLowerCase()
        }
        var e, f = a(b).data(),
            g = {},
            h = new RegExp("^" + c.toLowerCase() + "([A-Z])");
        c = new RegExp("^" + c.toLowerCase());
        for (var i in f) c.test(i) && (e = i.replace(h, d), g[e] = f[i]);
        return g
    }

    function i(b) {
        var c = {};
        if (q[b] || (b = b.split("-")[0], q[b])) {
            var d = q[b];
            return a.each(p, function(a, b) {
                b in d && (c[b] = d[b])
            }), c
        }
    }
    var j = function() {
            var b = {
                get: function(a) {
                    return this.slice(a)[0]
                },
                contains: function(a) {
                    for (var b = a && a.valueOf(), c = 0, d = this.length; d > c; c++)
                        if (this[c].valueOf() === b) return c;
                    return -1
                },
                remove: function(a) {
                    this.splice(a, 1)
                },
                replace: function(b) {
                    b && (a.isArray(b) || (b = [b]), this.clear(), this.push.apply(this, b))
                },
                clear: function() {
                    this.length = 0
                },
                copy: function() {
                    var a = new j;
                    return a.replace(this), a
                }
            };
            return function() {
                var c = [];
                return c.push.apply(c, arguments), a.extend(c, b), c
            }
        }(),
        k = function(b, c) {
            this._process_options(c), this.dates = new j, this.viewDate = this.o.defaultViewDate, this.focusDate = null, this.element = a(b), this.isInline = !1, this.isInput = this.element.is("input"), this.component = this.element.hasClass("date") ? this.element.find(".add-on, .input-group-addon, .btn") : !1, this.hasInput = this.component && this.element.find("input").length, this.component && 0 === this.component.length && (this.component = !1), this.picker = a(r.template), this._buildEvents(), this._attachEvents(), this.isInline ? this.picker.addClass("datepicker-inline").appendTo(this.element) : this.picker.addClass("datepicker-dropdown dropdown-menu"), this.o.rtl && this.picker.addClass("datepicker-rtl"), this.viewMode = this.o.startView, this.o.calendarWeeks && this.picker.find("tfoot .today, tfoot .clear").attr("colspan", function(a, b) {
                return parseInt(b) + 1
            }), this._allow_update = !1, this.setStartDate(this._o.startDate), this.setEndDate(this._o.endDate), this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled), this.setDaysOfWeekHighlighted(this.o.daysOfWeekHighlighted), this.setDatesDisabled(this.o.datesDisabled), this.fillDow(), this.fillMonths(), this._allow_update = !0, this.update(), this.showMode(), this.isInline && this.show()
        };
    k.prototype = {
        constructor: k,
        _process_options: function(e) {
            this._o = a.extend({}, this._o, e);
            var f = this.o = a.extend({}, this._o),
                g = f.language;
            switch (q[g] || (g = g.split("-")[0], q[g] || (g = o.language)), f.language = g, f.startView) {
                case 2:
                case "decade":
                    f.startView = 2;
                    break;
                case 1:
                case "year":
                    f.startView = 1;
                    break;
                default:
                    f.startView = 0
            }
            switch (f.minViewMode) {
                case 1:
                case "months":
                    f.minViewMode = 1;
                    break;
                case 2:
                case "years":
                    f.minViewMode = 2;
                    break;
                default:
                    f.minViewMode = 0
            }
            switch (f.maxViewMode) {
                case 0:
                case "days":
                    f.maxViewMode = 0;
                    break;
                case 1:
                case "months":
                    f.maxViewMode = 1;
                    break;
                default:
                    f.maxViewMode = 2
            }
            f.startView = Math.min(f.startView, f.maxViewMode), f.startView = Math.max(f.startView, f.minViewMode), f.multidate !== !0 && (f.multidate = Number(f.multidate) || !1, f.multidate !== !1 && (f.multidate = Math.max(0, f.multidate))), f.multidateSeparator = String(f.multidateSeparator), f.weekStart %= 7, f.weekEnd = (f.weekStart + 6) % 7;
            var h = r.parseFormat(f.format);
            if (f.startDate !== -(1 / 0) && (f.startDate ? f.startDate instanceof Date ? f.startDate = this._local_to_utc(this._zero_time(f.startDate)) : f.startDate = r.parseDate(f.startDate, h, f.language) : f.startDate = -(1 / 0)), f.endDate !== 1 / 0 && (f.endDate ? f.endDate instanceof Date ? f.endDate = this._local_to_utc(this._zero_time(f.endDate)) : f.endDate = r.parseDate(f.endDate, h, f.language) : f.endDate = 1 / 0), f.daysOfWeekDisabled = f.daysOfWeekDisabled || [], a.isArray(f.daysOfWeekDisabled) || (f.daysOfWeekDisabled = f.daysOfWeekDisabled.split(/[,\s]*/)), f.daysOfWeekDisabled = a.map(f.daysOfWeekDisabled, function(a) {
                    return parseInt(a, 10)
                }), f.daysOfWeekHighlighted = f.daysOfWeekHighlighted || [], a.isArray(f.daysOfWeekHighlighted) || (f.daysOfWeekHighlighted = f.daysOfWeekHighlighted.split(/[,\s]*/)), f.daysOfWeekHighlighted = a.map(f.daysOfWeekHighlighted, function(a) {
                    return parseInt(a, 10)
                }), f.datesDisabled = f.datesDisabled || [], !a.isArray(f.datesDisabled)) {
                var i = [];
                i.push(r.parseDate(f.datesDisabled, h, f.language)), f.datesDisabled = i
            }
            f.datesDisabled = a.map(f.datesDisabled, function(a) {
                return r.parseDate(a, h, f.language)
            });
            var j = String(f.orientation).toLowerCase().split(/\s+/g),
                k = f.orientation.toLowerCase();
            if (j = a.grep(j, function(a) {
                    return /^auto|left|right|top|bottom$/.test(a)
                }), f.orientation = {
                    x: "auto",
                    y: "auto"
                }, k && "auto" !== k)
                if (1 === j.length) switch (j[0]) {
                    case "top":
                    case "bottom":
                        f.orientation.y = j[0];
                        break;
                    case "left":
                    case "right":
                        f.orientation.x = j[0]
                } else k = a.grep(j, function(a) {
                    return /^left|right$/.test(a)
                }), f.orientation.x = k[0] || "auto", k = a.grep(j, function(a) {
                    return /^top|bottom$/.test(a)
                }), f.orientation.y = k[0] || "auto";
                else;
            if (f.defaultViewDate) {
                var l = f.defaultViewDate.year || (new Date).getFullYear(),
                    m = f.defaultViewDate.month || 0,
                    n = f.defaultViewDate.day || 1;
                f.defaultViewDate = c(l, m, n)
            } else f.defaultViewDate = d();
            f.showOnFocus = f.showOnFocus !== b ? f.showOnFocus : !0, f.zIndexOffset = f.zIndexOffset !== b ? f.zIndexOffset : 10
        },
        _events: [],
        _secondaryEvents: [],
        _applyEvents: function(a) {
            for (var c, d, e, f = 0; f < a.length; f++) c = a[f][0], 2 === a[f].length ? (d = b, e = a[f][1]) : 3 === a[f].length && (d = a[f][1], e = a[f][2]), c.on(e, d)
        },
        _unapplyEvents: function(a) {
            for (var c, d, e, f = 0; f < a.length; f++) c = a[f][0], 2 === a[f].length ? (e = b, d = a[f][1]) : 3 === a[f].length && (e = a[f][1], d = a[f][2]), c.off(d, e)
        },
        _buildEvents: function() {
            var b = {
                keyup: a.proxy(function(b) {
                    -1 === a.inArray(b.keyCode, [27, 37, 39, 38, 40, 32, 13, 9]) && this.update()
                }, this),
                keydown: a.proxy(this.keydown, this),
                paste: a.proxy(this.paste, this)
            };
            this.o.showOnFocus === !0 && (b.focus = a.proxy(this.show, this)), this.isInput ? this._events = [
                [this.element, b]
            ] : this.component && this.hasInput ? this._events = [
                [this.element.find("input"), b],
                [this.component, {
                    click: a.proxy(this.show, this)
                }]
            ] : this.element.is("div") ? this.isInline = !0 : this._events = [
                [this.element, {
                    click: a.proxy(this.show, this)
                }]
            ], this._events.push([this.element, "*", {
                blur: a.proxy(function(a) {
                    this._focused_from = a.target
                }, this)
            }], [this.element, {
                blur: a.proxy(function(a) {
                    this._focused_from = a.target
                }, this)
            }]), this.o.immediateUpdates && this._events.push([this.element, {
                "changeYear changeMonth": a.proxy(function(a) {
                    this.update(a.date)
                }, this)
            }]), this._secondaryEvents = [
                [this.picker, {
                    click: a.proxy(this.click, this)
                }],
                [a(window), {
                    resize: a.proxy(this.place, this)
                }],
                [a(document), {
                    mousedown: a.proxy(function(a) {
                        this.element.is(a.target) || this.element.find(a.target).length || this.picker.is(a.target) || this.picker.find(a.target).length || this.picker.hasClass("datepicker-inline") || this.hide()
                    }, this)
                }]
            ]
        },
        _attachEvents: function() {
            this._detachEvents(), this._applyEvents(this._events)
        },
        _detachEvents: function() {
            this._unapplyEvents(this._events)
        },
        _attachSecondaryEvents: function() {
            this._detachSecondaryEvents(), this._applyEvents(this._secondaryEvents)
        },
        _detachSecondaryEvents: function() {
            this._unapplyEvents(this._secondaryEvents)
        },
        _trigger: function(b, c) {
            var d = c || this.dates.get(-1),
                e = this._utc_to_local(d);
            this.element.trigger({
                type: b,
                date: e,
                dates: a.map(this.dates, this._utc_to_local),
                format: a.proxy(function(a, b) {
                    0 === arguments.length ? (a = this.dates.length - 1, b = this.o.format) : "string" == typeof a && (b = a, a = this.dates.length - 1), b = b || this.o.format;
                    var c = this.dates.get(a);
                    return r.formatDate(c, b, this.o.language)
                }, this)
            })
        },
        show: function() {
            return this.element.attr("readonly") && this.o.enableOnReadonly === !1 ? void 0 : (this.isInline || this.picker.appendTo(this.o.container), this.place(), this.picker.show(), this._attachSecondaryEvents(), this._trigger("show"), (window.navigator.msMaxTouchPoints || "ontouchstart" in document) && this.o.disableTouchKeyboard && a(this.element).blur(), this)
        },
        hide: function() {
            return this.isInline ? this : this.picker.is(":visible") ? (this.focusDate = null, this.picker.hide().detach(), this._detachSecondaryEvents(), this.viewMode = this.o.startView, this.showMode(), this.o.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find("input").val()) && this.setValue(), this._trigger("hide"), this) : this
        },
        remove: function() {
            return this.hide(), this._detachEvents(), this._detachSecondaryEvents(), this.picker.remove(), delete this.element.data().datepicker, this.isInput || delete this.element.data().date, this
        },
        paste: function(b) {
            var c;
            if (b.originalEvent.clipboardData && b.originalEvent.clipboardData.types && -1 !== a.inArray("text/plain", b.originalEvent.clipboardData.types)) c = b.originalEvent.clipboardData.getData("text/plain");
            else {
                if (!window.clipboardData) return;
                c = window.clipboardData.getData("Text")
            }
            this.setDate(c), this.update(), b.preventDefault()
        },
        _utc_to_local: function(a) {
            return a && new Date(a.getTime() + 6e4 * a.getTimezoneOffset())
        },
        _local_to_utc: function(a) {
            return a && new Date(a.getTime() - 6e4 * a.getTimezoneOffset())
        },
        _zero_time: function(a) {
            return a && new Date(a.getFullYear(), a.getMonth(), a.getDate())
        },
        _zero_utc_time: function(a) {
            return a && new Date(Date.UTC(a.getUTCFullYear(), a.getUTCMonth(), a.getUTCDate()))
        },
        getDates: function() {
            return a.map(this.dates, this._utc_to_local)
        },
        getUTCDates: function() {
            return a.map(this.dates, function(a) {
                return new Date(a)
            })
        },
        getDate: function() {
            return this._utc_to_local(this.getUTCDate())
        },
        getUTCDate: function() {
            var a = this.dates.get(-1);
            return "undefined" != typeof a ? new Date(a) : null
        },
        clearDates: function() {
            var a;
            this.isInput ? a = this.element : this.component && (a = this.element.find("input")), a && a.val(""), this.update(), this._trigger("changeDate"), this.o.autoclose && this.hide()
        },
        setDates: function() {
            var b = a.isArray(arguments[0]) ? arguments[0] : arguments;
            return this.update.apply(this, b), this._trigger("changeDate"), this.setValue(), this
        },
        setUTCDates: function() {
            var b = a.isArray(arguments[0]) ? arguments[0] : arguments;
            return this.update.apply(this, a.map(b, this._utc_to_local)), this._trigger("changeDate"), this.setValue(), this
        },
        setDate: f("setDates"),
        setUTCDate: f("setUTCDates"),
        setValue: function() {
            var a = this.getFormattedDate();
            return this.isInput ? this.element.val(a) : this.component && this.element.find("input").val(a), this
        },
        getFormattedDate: function(c) {
            c === b && (c = this.o.format);
            var d = this.o.language;
            return a.map(this.dates, function(a) {
                return r.formatDate(a, c, d)
            }).join(this.o.multidateSeparator)
        },
        setStartDate: function(a) {
            return this._process_options({
                startDate: a
            }), this.update(), this.updateNavArrows(), this
        },
        setEndDate: function(a) {
            return this._process_options({
                endDate: a
            }), this.update(), this.updateNavArrows(), this
        },
        setDaysOfWeekDisabled: function(a) {
            return this._process_options({
                daysOfWeekDisabled: a
            }), this.update(), this.updateNavArrows(), this
        },
        setDaysOfWeekHighlighted: function(a) {
            return this._process_options({
                daysOfWeekHighlighted: a
            }), this.update(), this
        },
        setDatesDisabled: function(a) {
            this._process_options({
                datesDisabled: a
            }), this.update(), this.updateNavArrows()
        },
        place: function() {
            if (this.isInline) return this;
            var b = this.picker.outerWidth(),
                c = this.picker.outerHeight(),
                d = 10,
                e = a(this.o.container),
                f = e.width(),
                g = e.scrollTop(),
                h = e.offset(),
                i = [];
            this.element.parents().each(function() {
                var b = a(this).css("z-index");
                "auto" !== b && 0 !== b && i.push(parseInt(b))
            });
            var j = Math.max.apply(Math, i) + this.o.zIndexOffset,
                k = this.component ? this.component.parent().offset() : this.element.offset(),
                l = this.component ? this.component.outerHeight(!0) : this.element.outerHeight(!1),
                m = this.component ? this.component.outerWidth(!0) : this.element.outerWidth(!1),
                n = k.left - h.left,
                o = k.top - h.top;
            this.picker.removeClass("datepicker-orient-top datepicker-orient-bottom datepicker-orient-right datepicker-orient-left"), "auto" !== this.o.orientation.x ? (this.picker.addClass("datepicker-orient-" + this.o.orientation.x), "right" === this.o.orientation.x && (n -= b - m)) : k.left < 0 ? (this.picker.addClass("datepicker-orient-left"), n -= k.left - d) : n + b > f ? (this.picker.addClass("datepicker-orient-right"), n = k.left + m - b) : this.picker.addClass("datepicker-orient-left");
            var p, q = this.o.orientation.y;
            if ("auto" === q && (p = -g + o - c, q = 0 > p ? "bottom" : "top"), this.picker.addClass("datepicker-orient-" + q), "top" === q ? o -= c + parseInt(this.picker.css("padding-top")) : o += l, this.o.rtl) {
                var r = f - (n + m);
                this.picker.css({
                    top: o,
                    right: r,
                    zIndex: j
                })
            } else this.picker.css({
                top: o,
                left: n,
                zIndex: j
            });
            return this
        },
        _allow_update: !0,
        update: function() {
            if (!this._allow_update) return this;
            var b = this.dates.copy(),
                c = [],
                d = !1;
            return arguments.length ? (a.each(arguments, a.proxy(function(a, b) {
                b instanceof Date && (b = this._local_to_utc(b)), c.push(b)
            }, this)), d = !0) : (c = this.isInput ? this.element.val() : this.element.data("date") || this.element.find("input").val(), c = c && this.o.multidate ? c.split(this.o.multidateSeparator) : [c], delete this.element.data().date), c = a.map(c, a.proxy(function(a) {
                return r.parseDate(a, this.o.format, this.o.language)
            }, this)), c = a.grep(c, a.proxy(function(a) {
                return a < this.o.startDate || a > this.o.endDate || !a
            }, this), !0), this.dates.replace(c), this.dates.length ? this.viewDate = new Date(this.dates.get(-1)) : this.viewDate < this.o.startDate ? this.viewDate = new Date(this.o.startDate) : this.viewDate > this.o.endDate ? this.viewDate = new Date(this.o.endDate) : this.viewDate = this.o.defaultViewDate, d ? this.setValue() : c.length && String(b) !== String(this.dates) && this._trigger("changeDate"), !this.dates.length && b.length && this._trigger("clearDate"), this.fill(), this.element.change(), this
        },
        fillDow: function() {
            var a = this.o.weekStart,
                b = "<tr>";
            for (this.o.calendarWeeks && (this.picker.find(".datepicker-days .datepicker-switch").attr("colspan", function(a, b) {
                    return parseInt(b) + 1
                }), b += '<th class="cw">&#160;</th>'); a < this.o.weekStart + 7;) b += '<th class="dow">' + q[this.o.language].daysMin[a++ % 7] + "</th>";
            b += "</tr>", this.picker.find(".datepicker-days thead").append(b)
        },
        fillMonths: function() {
            for (var a = "", b = 0; 12 > b;) a += '<span class="month">' + q[this.o.language].monthsShort[b++] + "</span>";
            this.picker.find(".datepicker-months td").html(a)
        },
        setRange: function(b) {
            b && b.length ? this.range = a.map(b, function(a) {
                return a.valueOf()
            }) : delete this.range, this.fill()
        },
        getClassNames: function(b) {
            var c = [],
                d = this.viewDate.getUTCFullYear(),
                f = this.viewDate.getUTCMonth(),
                g = new Date;
            return b.getUTCFullYear() < d || b.getUTCFullYear() === d && b.getUTCMonth() < f ? c.push("old") : (b.getUTCFullYear() > d || b.getUTCFullYear() === d && b.getUTCMonth() > f) && c.push("new"), this.focusDate && b.valueOf() === this.focusDate.valueOf() && c.push("focused"), this.o.todayHighlight && b.getUTCFullYear() === g.getFullYear() && b.getUTCMonth() === g.getMonth() && b.getUTCDate() === g.getDate() && c.push("today"), -1 !== this.dates.contains(b) && c.push("active"), (b.valueOf() < this.o.startDate || b.valueOf() > this.o.endDate || -1 !== a.inArray(b.getUTCDay(), this.o.daysOfWeekDisabled)) && c.push("disabled"), -1 !== a.inArray(b.getUTCDay(), this.o.daysOfWeekHighlighted) && c.push("highlighted"), this.o.datesDisabled.length > 0 && a.grep(this.o.datesDisabled, function(a) {
                return e(b, a)
            }).length > 0 && c.push("disabled", "disabled-date"), this.range && (b > this.range[0] && b < this.range[this.range.length - 1] && c.push("range"), -1 !== a.inArray(b.valueOf(), this.range) && c.push("selected"), b.valueOf() === this.range[0] && c.push("range-start"), b.valueOf() === this.range[this.range.length - 1] && c.push("range-end")), c
        },
        fill: function() {
            var d, e = new Date(this.viewDate),
                f = e.getUTCFullYear(),
                g = e.getUTCMonth(),
                h = this.o.startDate !== -(1 / 0) ? this.o.startDate.getUTCFullYear() : -(1 / 0),
                i = this.o.startDate !== -(1 / 0) ? this.o.startDate.getUTCMonth() : -(1 / 0),
                j = this.o.endDate !== 1 / 0 ? this.o.endDate.getUTCFullYear() : 1 / 0,
                k = this.o.endDate !== 1 / 0 ? this.o.endDate.getUTCMonth() : 1 / 0,
                l = q[this.o.language].today || q.en.today || "",
                m = q[this.o.language].clear || q.en.clear || "",
                n = q[this.o.language].titleFormat || q.en.titleFormat;
            if (!isNaN(f) && !isNaN(g)) {
                this.picker.find(".datepicker-days thead .datepicker-switch").text(r.formatDate(new c(f, g), n, this.o.language)), this.picker.find("tfoot .today").text(l).toggle(this.o.todayBtn !== !1), this.picker.find("tfoot .clear").text(m).toggle(this.o.clearBtn !== !1), this.picker.find("thead .datepicker-title").text(this.o.title).toggle("" !== this.o.title), this.updateNavArrows(), this.fillMonths();
                var o = c(f, g - 1, 28),
                    p = r.getDaysInMonth(o.getUTCFullYear(), o.getUTCMonth());
                o.setUTCDate(p), o.setUTCDate(p - (o.getUTCDay() - this.o.weekStart + 7) % 7);
                var s = new Date(o);
                o.getUTCFullYear() < 100 && s.setUTCFullYear(o.getUTCFullYear()), s.setUTCDate(s.getUTCDate() + 42), s = s.valueOf();
                for (var t, u = []; o.valueOf() < s;) {
                    if (o.getUTCDay() === this.o.weekStart && (u.push("<tr>"), this.o.calendarWeeks)) {
                        var v = new Date(+o + (this.o.weekStart - o.getUTCDay() - 7) % 7 * 864e5),
                            w = new Date(Number(v) + (11 - v.getUTCDay()) % 7 * 864e5),
                            x = new Date(Number(x = c(w.getUTCFullYear(), 0, 1)) + (11 - x.getUTCDay()) % 7 * 864e5),
                            y = (w - x) / 864e5 / 7 + 1;
                        u.push('<td class="cw">' + y + "</td>")
                    }
                    if (t = this.getClassNames(o), t.push("day"), this.o.beforeShowDay !== a.noop) {
                        var z = this.o.beforeShowDay(this._utc_to_local(o));
                        z === b ? z = {} : "boolean" == typeof z ? z = {
                            enabled: z
                        } : "string" == typeof z && (z = {
                            classes: z
                        }), z.enabled === !1 && t.push("disabled"), z.classes && (t = t.concat(z.classes.split(/\s+/))), z.tooltip && (d = z.tooltip)
                    }
                    t = a.unique(t), u.push('<td class="' + t.join(" ") + '"' + (d ? ' title="' + d + '"' : "") + ">" + o.getUTCDate() + "</td>"), d = null, o.getUTCDay() === this.o.weekEnd && u.push("</tr>"), o.setUTCDate(o.getUTCDate() + 1)
                }
                this.picker.find(".datepicker-days tbody").empty().append(u.join(""));
                var A = this.picker.find(".datepicker-months").find(".datepicker-switch").text(this.o.maxViewMode < 2 ? "Months" : f).end().find("span").removeClass("active");
                if (a.each(this.dates, function(a, b) {
                        b.getUTCFullYear() === f && A.eq(b.getUTCMonth()).addClass("active")
                    }), (h > f || f > j) && A.addClass("disabled"), f === h && A.slice(0, i).addClass("disabled"), f === j && A.slice(k + 1).addClass("disabled"), this.o.beforeShowMonth !== a.noop) {
                    var B = this;
                    a.each(A, function(b, c) {
                        if (!a(c).hasClass("disabled")) {
                            var d = new Date(f, b, 1),
                                e = B.o.beforeShowMonth(d);
                            e === !1 && a(c).addClass("disabled")
                        }
                    })
                }
                u = "", f = 10 * parseInt(f / 10, 10);
                var C = this.picker.find(".datepicker-years").find(".datepicker-switch").text(f + "-" + (f + 9)).end().find("td");
                f -= 1;
                for (var D, E = a.map(this.dates, function(a) {
                        return a.getUTCFullYear()
                    }), F = -1; 11 > F; F++) {
                    if (D = ["year"], d = null, -1 === F ? D.push("old") : 10 === F && D.push("new"), -1 !== a.inArray(f, E) && D.push("active"), (h > f || f > j) && D.push("disabled"), this.o.beforeShowYear !== a.noop) {
                        var G = this.o.beforeShowYear(new Date(f, 0, 1));
                        G === b ? G = {} : "boolean" == typeof G ? G = {
                            enabled: G
                        } : "string" == typeof G && (G = {
                            classes: G
                        }), G.enabled === !1 && D.push("disabled"), G.classes && (D = D.concat(G.classes.split(/\s+/))), G.tooltip && (d = G.tooltip)
                    }
                    u += '<span class="' + D.join(" ") + '"' + (d ? ' title="' + d + '"' : "") + ">" + f + "</span>", f += 1
                }
                C.html(u)
            }
        },
        updateNavArrows: function() {
            if (this._allow_update) {
                var a = new Date(this.viewDate),
                    b = a.getUTCFullYear(),
                    c = a.getUTCMonth();
                switch (this.viewMode) {
                    case 0:
                        this.o.startDate !== -(1 / 0) && b <= this.o.startDate.getUTCFullYear() && c <= this.o.startDate.getUTCMonth() ? this.picker.find(".prev").css({
                            visibility: "hidden"
                        }) : this.picker.find(".prev").css({
                            visibility: "visible"
                        }), this.o.endDate !== 1 / 0 && b >= this.o.endDate.getUTCFullYear() && c >= this.o.endDate.getUTCMonth() ? this.picker.find(".next").css({
                            visibility: "hidden"
                        }) : this.picker.find(".next").css({
                            visibility: "visible"
                        });
                        break;
                    case 1:
                    case 2:
                        this.o.startDate !== -(1 / 0) && b <= this.o.startDate.getUTCFullYear() || this.o.maxViewMode < 2 ? this.picker.find(".prev").css({
                            visibility: "hidden"
                        }) : this.picker.find(".prev").css({
                            visibility: "visible"
                        }), this.o.endDate !== 1 / 0 && b >= this.o.endDate.getUTCFullYear() || this.o.maxViewMode < 2 ? this.picker.find(".next").css({
                            visibility: "hidden"
                        }) : this.picker.find(".next").css({
                            visibility: "visible"
                        })
                }
            }
        },
        click: function(b) {
            b.preventDefault(), b.stopPropagation();
            var d, e, f, g = a(b.target).closest("span, td, th");
            if (1 === g.length) switch (g[0].nodeName.toLowerCase()) {
                case "th":
                    switch (g[0].className) {
                        case "datepicker-switch":
                            this.showMode(1);
                            break;
                        case "prev":
                        case "next":
                            var h = r.modes[this.viewMode].navStep * ("prev" === g[0].className ? -1 : 1);
                            switch (this.viewMode) {
                                case 0:
                                    this.viewDate = this.moveMonth(this.viewDate, h), this._trigger("changeMonth", this.viewDate);
                                    break;
                                case 1:
                                case 2:
                                    this.viewDate = this.moveYear(this.viewDate, h), 1 === this.viewMode && this._trigger("changeYear", this.viewDate)
                            }
                            this.fill();
                            break;
                        case "today":
                            var i = new Date;
                            i = c(i.getFullYear(), i.getMonth(), i.getDate(), 0, 0, 0), this.showMode(-2);
                            var j = "linked" === this.o.todayBtn ? null : "view";
                            this._setDate(i, j);
                            break;
                        case "clear":
                            this.clearDates()
                    }
                    break;
                case "span":
                    g.hasClass("disabled") || (this.viewDate.setUTCDate(1), g.hasClass("month") ? (f = 1, e = g.parent().find("span").index(g), d = this.viewDate.getUTCFullYear(), this.viewDate.setUTCMonth(e), this._trigger("changeMonth", this.viewDate), 1 === this.o.minViewMode ? (this._setDate(c(d, e, f)), this.showMode()) : this.showMode(-1)) : (f = 1, e = 0, d = parseInt(g.text(), 10) || 0, this.viewDate.setUTCFullYear(d), this._trigger("changeYear", this.viewDate), 2 === this.o.minViewMode && this._setDate(c(d, e, f)), this.showMode(-1)), this.fill());
                    break;
                case "td":
                    g.hasClass("day") && !g.hasClass("disabled") && (f = parseInt(g.text(), 10) || 1, d = this.viewDate.getUTCFullYear(), e = this.viewDate.getUTCMonth(), g.hasClass("old") ? 0 === e ? (e = 11, d -= 1) : e -= 1 : g.hasClass("new") && (11 === e ? (e = 0, d += 1) : e += 1), this._setDate(c(d, e, f)))
            }
            this.picker.is(":visible") && this._focused_from && a(this._focused_from).focus(), delete this._focused_from
        },
        _toggle_multidate: function(a) {
            var b = this.dates.contains(a);
            if (a || this.dates.clear(), -1 !== b ? (this.o.multidate === !0 || this.o.multidate > 1 || this.o.toggleActive) && this.dates.remove(b) : this.o.multidate === !1 ? (this.dates.clear(), this.dates.push(a)) : this.dates.push(a), "number" == typeof this.o.multidate)
                for (; this.dates.length > this.o.multidate;) this.dates.remove(0)
        },
        _setDate: function(a, b) {
            b && "date" !== b || this._toggle_multidate(a && new Date(a)), b && "view" !== b || (this.viewDate = a && new Date(a)), this.fill(), this.setValue(), b && "view" === b || this._trigger("changeDate");
            var c;
            this.isInput ? c = this.element : this.component && (c = this.element.find("input")), c && c.change(), !this.o.autoclose || b && "date" !== b || this.hide()
        },
        moveMonth: function(a, b) {
            if (!g(a)) return this.o.defaultViewDate;
            if (!b) return a;
            var c, d, e = new Date(a.valueOf()),
                f = e.getUTCDate(),
                h = e.getUTCMonth(),
                i = Math.abs(b);
            if (b = b > 0 ? 1 : -1, 1 === i) d = -1 === b ? function() {
                return e.getUTCMonth() === h
            } : function() {
                return e.getUTCMonth() !== c
            }, c = h + b, e.setUTCMonth(c), (0 > c || c > 11) && (c = (c + 12) % 12);
            else {
                for (var j = 0; i > j; j++) e = this.moveMonth(e, b);
                c = e.getUTCMonth(), e.setUTCDate(f), d = function() {
                    return c !== e.getUTCMonth()
                }
            }
            for (; d();) e.setUTCDate(--f), e.setUTCMonth(c);
            return e
        },
        moveYear: function(a, b) {
            return this.moveMonth(a, 12 * b)
        },
        dateWithinRange: function(a) {
            return a >= this.o.startDate && a <= this.o.endDate
        },
        keydown: function(a) {
            if (!this.picker.is(":visible")) return void((40 === a.keyCode || 27 === a.keyCode) && (this.show(), a.stopPropagation()));
            var b, c, e, f = !1,
                g = this.focusDate || this.viewDate;
            switch (a.keyCode) {
                case 27:
                    this.focusDate ? (this.focusDate = null, this.viewDate = this.dates.get(-1) || this.viewDate, this.fill()) : this.hide(), a.preventDefault(), a.stopPropagation();
                    break;
                case 37:
                case 39:
                    if (!this.o.keyboardNavigation) break;
                    b = 37 === a.keyCode ? -1 : 1, a.ctrlKey ? (c = this.moveYear(this.dates.get(-1) || d(), b), e = this.moveYear(g, b), this._trigger("changeYear", this.viewDate)) : a.shiftKey ? (c = this.moveMonth(this.dates.get(-1) || d(), b), e = this.moveMonth(g, b), this._trigger("changeMonth", this.viewDate)) : (c = new Date(this.dates.get(-1) || d()), c.setUTCDate(c.getUTCDate() + b), e = new Date(g), e.setUTCDate(g.getUTCDate() + b)), this.dateWithinRange(e) && (this.focusDate = this.viewDate = e, this.setValue(), this.fill(), a.preventDefault());
                    break;
                case 38:
                case 40:
                    if (!this.o.keyboardNavigation) break;
                    b = 38 === a.keyCode ? -1 : 1, a.ctrlKey ? (c = this.moveYear(this.dates.get(-1) || d(), b), e = this.moveYear(g, b), this._trigger("changeYear", this.viewDate)) : a.shiftKey ? (c = this.moveMonth(this.dates.get(-1) || d(), b), e = this.moveMonth(g, b), this._trigger("changeMonth", this.viewDate)) : (c = new Date(this.dates.get(-1) || d()), c.setUTCDate(c.getUTCDate() + 7 * b), e = new Date(g), e.setUTCDate(g.getUTCDate() + 7 * b)), this.dateWithinRange(e) && (this.focusDate = this.viewDate = e, this.setValue(), this.fill(), a.preventDefault());
                    break;
                case 32:
                    break;
                case 13:
                    if (!this.o.forceParse) break;
                    g = this.focusDate || this.dates.get(-1) || this.viewDate, this.o.keyboardNavigation && (this._toggle_multidate(g), f = !0), this.focusDate = null, this.viewDate = this.dates.get(-1) || this.viewDate, this.setValue(), this.fill(), this.picker.is(":visible") && (a.preventDefault(), "function" == typeof a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0, this.o.autoclose && this.hide());
                    break;
                case 9:
                    this.focusDate = null, this.viewDate = this.dates.get(-1) || this.viewDate, this.fill(), this.hide()
            }
            if (f) {
                this.dates.length ? this._trigger("changeDate") : this._trigger("clearDate");
                var h;
                this.isInput ? h = this.element : this.component && (h = this.element.find("input")), h && h.change()
            }
        },
        showMode: function(a) {
            a && (this.viewMode = Math.max(this.o.minViewMode, Math.min(this.o.maxViewMode, this.viewMode + a))), this.picker.children("div").hide().filter(".datepicker-" + r.modes[this.viewMode].clsName).show(), this.updateNavArrows()
        }
    };
    var l = function(b, c) {
        this.element = a(b), this.inputs = a.map(c.inputs, function(a) {
            return a.jquery ? a[0] : a
        }), delete c.inputs, n.call(a(this.inputs), c).on("changeDate", a.proxy(this.dateUpdated, this)), this.pickers = a.map(this.inputs, function(b) {
            return a(b).data("datepicker")
        }), this.updateDates()
    };
    l.prototype = {
        updateDates: function() {
            this.dates = a.map(this.pickers, function(a) {
                return a.getUTCDate()
            }), this.updateRanges()
        },
        updateRanges: function() {
            var b = a.map(this.dates, function(a) {
                return a.valueOf()
            });
            a.each(this.pickers, function(a, c) {
                c.setRange(b)
            })
        },
        dateUpdated: function(b) {
            if (!this.updating) {
                this.updating = !0;
                var c = a(b.target).data("datepicker");
                if ("undefined" != typeof c) {
                    var d = c.getUTCDate(),
                        e = a.inArray(b.target, this.inputs),
                        f = e - 1,
                        g = e + 1,
                        h = this.inputs.length;
                    if (-1 !== e) {
                        if (a.each(this.pickers, function(a, b) {
                                b.getUTCDate() || b.setUTCDate(d)
                            }), d < this.dates[f])
                            for (; f >= 0 && d < this.dates[f];) this.pickers[f--].setUTCDate(d);
                        else if (d > this.dates[g])
                            for (; h > g && d > this.dates[g];) this.pickers[g++].setUTCDate(d);
                        this.updateDates(), delete this.updating
                    }
                }
            }
        },
        remove: function() {
            a.map(this.pickers, function(a) {
                a.remove()
            }), delete this.element.data().datepicker
        }
    };
    var m = a.fn.datepicker,
        n = function(c) {
            var d = Array.apply(null, arguments);
            d.shift();
            var e;
            if (this.each(function() {
                    var b = a(this),
                        f = b.data("datepicker"),
                        g = "object" == typeof c && c;
                    if (!f) {
                        var j = h(this, "date"),
                            m = a.extend({}, o, j, g),
                            n = i(m.language),
                            p = a.extend({}, o, n, j, g);
                        if (b.hasClass("input-daterange") || p.inputs) {
                            var q = {
                                inputs: p.inputs || b.find("input").toArray()
                            };
                            b.data("datepicker", f = new l(this, a.extend(p, q)))
                        } else b.data("datepicker", f = new k(this, p))
                    }
                    "string" == typeof c && "function" == typeof f[c] && (e = f[c].apply(f, d))
                }), e === b || e instanceof k || e instanceof l) return this;
            if (this.length > 1) throw new Error("Using only allowed for the collection of a single element (" + c + " function)");
            return e
        };
    a.fn.datepicker = n;
    var o = a.fn.datepicker.defaults = {
            autoclose: !1,
            beforeShowDay: a.noop,
            beforeShowMonth: a.noop,
            beforeShowYear: a.noop,
            calendarWeeks: !1,
            clearBtn: !1,
            toggleActive: !1,
            daysOfWeekDisabled: [],
            daysOfWeekHighlighted: [],
            datesDisabled: [],
            endDate: 1 / 0,
            forceParse: !0,
            format: "mm/dd/yyyy",
            keyboardNavigation: !0,
            language: "en",
            minViewMode: 0,
            maxViewMode: 2,
            multidate: !1,
            multidateSeparator: ",",
            orientation: "auto",
            rtl: !1,
            startDate: -(1 / 0),
            startView: 0,
            todayBtn: !1,
            todayHighlight: !1,
            weekStart: 0,
            disableTouchKeyboard: !1,
            enableOnReadonly: !0,
            container: "body",
            immediateUpdates: !1,
            title: ""
        },
        p = a.fn.datepicker.locale_opts = ["format", "rtl", "weekStart"];
    a.fn.datepicker.Constructor = k;
    var q = a.fn.datepicker.dates = {
            en: {
                days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                today: "Today",
                clear: "Clear",
                titleFormat: "MM yyyy"
            }
        },
        r = {
            modes: [{
                clsName: "days",
                navFnc: "Month",
                navStep: 1
            }, {
                clsName: "months",
                navFnc: "FullYear",
                navStep: 1
            }, {
                clsName: "years",
                navFnc: "FullYear",
                navStep: 10
            }],
            isLeapYear: function(a) {
                return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0
            },
            getDaysInMonth: function(a, b) {
                return [31, r.isLeapYear(a) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][b]
            },
            validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
            nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
            parseFormat: function(a) {
                if ("function" == typeof a.toValue && "function" == typeof a.toDisplay) return a;
                var b = a.replace(this.validParts, "\x00").split("\x00"),
                    c = a.match(this.validParts);
                if (!b || !b.length || !c || 0 === c.length) throw new Error("Invalid date format.");
                return {
                    separators: b,
                    parts: c
                }
            },
            parseDate: function(d, e, f) {
                function g() {
                    var a = this.slice(0, m[j].length),
                        b = m[j].slice(0, a.length);
                    return a.toLowerCase() === b.toLowerCase()
                }
                if (!d) return b;
                if (d instanceof Date) return d;
                if ("string" == typeof e && (e = r.parseFormat(e)), e.toValue) return e.toValue(d, e, f);
                var h, i, j, l = /([\-+]\d+)([dmwy])/,
                    m = d.match(/([\-+]\d+)([dmwy])/g);
                if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(d)) {
                    for (d = new Date, j = 0; j < m.length; j++) switch (h = l.exec(m[j]), i = parseInt(h[1]), h[2]) {
                        case "d":
                            d.setUTCDate(d.getUTCDate() + i);
                            break;
                        case "m":
                            d = k.prototype.moveMonth.call(k.prototype, d, i);
                            break;
                        case "w":
                            d.setUTCDate(d.getUTCDate() + 7 * i);
                            break;
                        case "y":
                            d = k.prototype.moveYear.call(k.prototype, d, i)
                    }
                    return c(d.getUTCFullYear(), d.getUTCMonth(), d.getUTCDate(), 0, 0, 0)
                }
                m = d && d.match(this.nonpunctuation) || [], d = new Date;
                var n, o, p = {},
                    s = ["yyyy", "yy", "M", "MM", "m", "mm", "d", "dd"],
                    t = {
                        yyyy: function(a, b) {
                            return a.setUTCFullYear(b)
                        },
                        yy: function(a, b) {
                            return a.setUTCFullYear(2e3 + b)
                        },
                        m: function(a, b) {
                            if (isNaN(a)) return a;
                            for (b -= 1; 0 > b;) b += 12;
                            for (b %= 12, a.setUTCMonth(b); a.getUTCMonth() !== b;) a.setUTCDate(a.getUTCDate() - 1);
                            return a
                        },
                        d: function(a, b) {
                            return a.setUTCDate(b)
                        }
                    };
                t.M = t.MM = t.mm = t.m, t.dd = t.d, d = c(d.getFullYear(), d.getMonth(), d.getDate(), 0, 0, 0);
                var u = e.parts.slice();
                if (m.length !== u.length && (u = a(u).filter(function(b, c) {
                        return -1 !== a.inArray(c, s)
                    }).toArray()), m.length === u.length) {
                    var v;
                    for (j = 0, v = u.length; v > j; j++) {
                        if (n = parseInt(m[j], 10), h = u[j], isNaN(n)) switch (h) {
                            case "MM":
                                o = a(q[f].months).filter(g), n = a.inArray(o[0], q[f].months) + 1;
                                break;
                            case "M":
                                o = a(q[f].monthsShort).filter(g), n = a.inArray(o[0], q[f].monthsShort) + 1
                        }
                        p[h] = n
                    }
                    var w, x;
                    for (j = 0; j < s.length; j++) x = s[j], x in p && !isNaN(p[x]) && (w = new Date(d), t[x](w, p[x]), isNaN(w) || (d = w))
                }
                return d
            },
            formatDate: function(b, c, d) {
                if (!b) return "";
                if ("string" == typeof c && (c = r.parseFormat(c)), c.toDisplay) return c.toDisplay(b, c, d);
                var e = {
                    d: b.getUTCDate(),
                    D: q[d].daysShort[b.getUTCDay()],
                    DD: q[d].days[b.getUTCDay()],
                    m: b.getUTCMonth() + 1,
                    M: q[d].monthsShort[b.getUTCMonth()],
                    MM: q[d].months[b.getUTCMonth()],
                    yy: b.getUTCFullYear().toString().substring(2),
                    yyyy: b.getUTCFullYear()
                };
                e.dd = (e.d < 10 ? "0" : "") + e.d, e.mm = (e.m < 10 ? "0" : "") + e.m, b = [];
                for (var f = a.extend([], c.separators), g = 0, h = c.parts.length; h >= g; g++) f.length && b.push(f.shift()), b.push(e[c.parts[g]]);
                return b.join("")
            },
            headTemplate: '<thead><tr><th colspan="7" class="datepicker-title"></th></tr><tr><th class="prev">&#171;</th><th colspan="5" class="datepicker-switch"></th><th class="next">&#187;</th></tr></thead>',
            contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
            footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
        };
    r.template = '<div class="datepicker"><div class="datepicker-days"><table class=" table-condensed">' + r.headTemplate + "<tbody></tbody>" + r.footTemplate + '</table></div><div class="datepicker-months"><table class="table-condensed">' + r.headTemplate + r.contTemplate + r.footTemplate + '</table></div><div class="datepicker-years"><table class="table-condensed">' + r.headTemplate + r.contTemplate + r.footTemplate + "</table></div></div>", a.fn.datepicker.DPGlobal = r, a.fn.datepicker.noConflict = function() {
        return a.fn.datepicker = m, this
    }, a.fn.datepicker.version = "1.5.0", a(document).on("focus.datepicker.data-api click.datepicker.data-api", '[data-provide="datepicker"]', function(b) {
        var c = a(this);
        c.data("datepicker") || (b.preventDefault(), n.call(c, "show"))
    }), a(function() {
        n.call(a('[data-provide="datepicker-inline"]'))
    })
});