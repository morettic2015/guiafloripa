var Chartv2;
if (typeof Chart !== 'undefined') {
    Chartv2 = Chart;
}

(function ($) {

    /*!
     
     * Bootstrap v3.3.6 (http://getbootstrap.com)
     
     * Copyright 2011-2015 Twitter, Inc.
     
     * Licensed under the MIT license
     
     */
    if ("undefined" == typeof jQuery)
        throw new Error("Bootstrap's JavaScript requires jQuery");
    +function (a) {
        "use strict";
        var b = a.fn.jquery.split(" ")[0].split(".");
        if (b[0] < 2 && b[1] < 9 || 1 == b[0] && 9 == b[1] && b[2] < 1 || b[0] > 2)
            throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 3")
    }(jQuery), +function (a) {
        "use strict";
        function b() {
            var a = document.createElement("bootstrap"), b = {WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd otransitionend", transition: "transitionend"};
            for (var c in b)
                if (void 0 !== a.style[c])
                    return{end: b[c]};
            return!1
        }
        a.fn.emulateTransitionEnd = function (b) {
            var c = !1, d = this;
            a(this).one("bsTransitionEnd", function () {
                c = !0
            });
            var e = function () {
                c || a(d).trigger(a.support.transition.end)
            };
            return setTimeout(e, b), this
        }, a(function () {
            a.support.transition = b(), a.support.transition && (a.event.special.bsTransitionEnd = {bindType: a.support.transition.end, delegateType: a.support.transition.end, handle: function (b) {
                    return a(b.target).is(this) ? b.handleObj.handler.apply(this, arguments) : void 0
                }})
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var c = a(this), e = c.data("bs.alert");
                e || c.data("bs.alert", e = new d(this)), "string" == typeof b && e[b].call(c)
            })
        }
        var c = '[data-dismiss="alert"]', d = function (b) {
            a(b).on("click", c, this.close)
        };
        d.VERSION = "3.3.6", d.TRANSITION_DURATION = 150, d.prototype.close = function (b) {
            function c() {
                g.detach().trigger("closed.bs.alert").remove()
            }
            var e = a(this), f = e.attr("data-target");
            f || (f = e.attr("href"), f = f && f.replace(/.*(?=#[^\s]*$)/, ""));
            var g = a(f);
            b && b.preventDefault(), g.length || (g = e.closest(".alert")), g.trigger(b = a.Event("close.bs.alert")), b.isDefaultPrevented() || (g.removeClass("in"), a.support.transition && g.hasClass("fade") ? g.one("bsTransitionEnd", c).emulateTransitionEnd(d.TRANSITION_DURATION) : c())
        };
        var e = a.fn.alert;
        a.fn.alert = b, a.fn.alert.Constructor = d, a.fn.alert.noConflict = function () {
            return a.fn.alert = e, this
        }, a(document).on("click.bs.alert.data-api", c, d.prototype.close)
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.button"), f = "object" == typeof b && b;
                e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b)
            })
        }
        var c = function (b, d) {
            this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1
        };
        c.VERSION = "3.3.6", c.DEFAULTS = {loadingText: "loading..."}, c.prototype.setState = function (b) {
            var c = "disabled", d = this.$element, e = d.is("input") ? "val" : "html", f = d.data();
            b += "Text", null == f.resetText && d.data("resetText", d[e]()), setTimeout(a.proxy(function () {
                d[e](null == f[b] ? this.options[b] : f[b]), "loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c))
            }, this), 0)
        }, c.prototype.toggle = function () {
            var a = !0, b = this.$element.closest('[data-toggle="buttons"]');
            if (b.length) {
                var c = this.$element.find("input");
                "radio" == c.prop("type") ? (c.prop("checked") && (a = !1), b.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == c.prop("type") && (c.prop("checked") !== this.$element.hasClass("active") && (a = !1), this.$element.toggleClass("active")), c.prop("checked", this.$element.hasClass("active")), a && c.trigger("change")
            } else
                this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
        };
        var d = a.fn.button;
        a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function () {
            return a.fn.button = d, this
        }, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (c) {
            var d = a(c.target);
            d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), a(c.target).is('input[type="radio"]') || a(c.target).is('input[type="checkbox"]') || c.preventDefault()
        }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (b) {
            a(b.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(b.type))
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.carousel"), f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b), g = "string" == typeof b ? b : f.slide;
                e || d.data("bs.carousel", e = new c(this, f)), "number" == typeof b ? e.to(b) : g ? e[g]() : f.interval && e.pause().cycle()
            })
        }
        var c = function (b, c) {
            this.$element = a(b), this.$indicators = this.$element.find(".carousel-indicators"), this.options = c, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", a.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart"in document.documentElement) && this.$element.on("mouseenter.bs.carousel", a.proxy(this.pause, this)).on("mouseleave.bs.carousel", a.proxy(this.cycle, this))
        };
        c.VERSION = "3.3.6", c.TRANSITION_DURATION = 600, c.DEFAULTS = {interval: 5e3, pause: "hover", wrap: !0, keyboard: !0}, c.prototype.keydown = function (a) {
            if (!/input|textarea/i.test(a.target.tagName)) {
                switch (a.which) {
                    case 37:
                        this.prev();
                        break;
                        case 39:
                        this.next();
                        break;
                        default:
                        return
                    }
                a.preventDefault()
            }
        }, c.prototype.cycle = function (b) {
            return b || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(a.proxy(this.next, this), this.options.interval)), this
        }, c.prototype.getItemIndex = function (a) {
            return this.$items = a.parent().children(".item"), this.$items.index(a || this.$active)
        }, c.prototype.getItemForDirection = function (a, b) {
            var c = this.getItemIndex(b), d = "prev" == a && 0 === c || "next" == a && c == this.$items.length - 1;
            if (d && !this.options.wrap)
                return b;
            var e = "prev" == a ? -1 : 1, f = (c + e) % this.$items.length;
            return this.$items.eq(f)
        }, c.prototype.to = function (a) {
            var b = this, c = this.getItemIndex(this.$active = this.$element.find(".item.active"));
            return a > this.$items.length - 1 || 0 > a ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function () {
                b.to(a)
            }) : c == a ? this.pause().cycle() : this.slide(a > c ? "next" : "prev", this.$items.eq(a))
        }, c.prototype.pause = function (b) {
            return b || (this.paused = !0), this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
        }, c.prototype.next = function () {
            return this.sliding ? void 0 : this.slide("next")
        }, c.prototype.prev = function () {
            return this.sliding ? void 0 : this.slide("prev")
        }, c.prototype.slide = function (b, d) {
            var e = this.$element.find(".item.active"), f = d || this.getItemForDirection(b, e), g = this.interval, h = "next" == b ? "left" : "right", i = this;
            if (f.hasClass("active"))
                return this.sliding = !1;
            var j = f[0], k = a.Event("slide.bs.carousel", {relatedTarget: j, direction: h});
            if (this.$element.trigger(k), !k.isDefaultPrevented()) {
                if (this.sliding = !0, g && this.pause(), this.$indicators.length) {
                    this.$indicators.find(".active").removeClass("active");
                    var l = a(this.$indicators.children()[this.getItemIndex(f)]);
                    l && l.addClass("active")
                }
                var m = a.Event("slid.bs.carousel", {relatedTarget: j, direction: h});
                return a.support.transition && this.$element.hasClass("slide") ? (f.addClass(b), f[0].offsetWidth, e.addClass(h), f.addClass(h), e.one("bsTransitionEnd", function () {
                    f.removeClass([b, h].join(" ")).addClass("active"), e.removeClass(["active", h].join(" ")), i.sliding = !1, setTimeout(function () {
                        i.$element.trigger(m)
                    }, 0)
                }).emulateTransitionEnd(c.TRANSITION_DURATION)) : (e.removeClass("active"), f.addClass("active"), this.sliding = !1, this.$element.trigger(m)), g && this.cycle(), this
            }
        };
        var d = a.fn.carousel;
        a.fn.carousel = b, a.fn.carousel.Constructor = c, a.fn.carousel.noConflict = function () {
            return a.fn.carousel = d, this
        };
        var e = function (c) {
            var d, e = a(this), f = a(e.attr("data-target") || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""));
            if (f.hasClass("carousel")) {
                var g = a.extend({}, f.data(), e.data()), h = e.attr("data-slide-to");
                h && (g.interval = !1), b.call(f, g), h && f.data("bs.carousel").to(h), c.preventDefault()
            }
        };
        a(document).on("click.bs.carousel.data-api", "[data-slide]", e).on("click.bs.carousel.data-api", "[data-slide-to]", e), a(window).on("load", function () {
            a('[data-ride="carousel"]').each(function () {
                var c = a(this);
                b.call(c, c.data())
            })
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            var c, d = b.attr("data-target") || (c = b.attr("href")) && c.replace(/.*(?=#[^\s]+$)/, "");
            return a(d)
        }
        function c(b) {
            return this.each(function () {
                var c = a(this), e = c.data("bs.collapse"), f = a.extend({}, d.DEFAULTS, c.data(), "object" == typeof b && b);
                !e && f.toggle && /show|hide/.test(b) && (f.toggle = !1), e || c.data("bs.collapse", e = new d(this, f)), "string" == typeof b && e[b]()
            })
        }
        var d = function (b, c) {
            this.$element = a(b), this.options = a.extend({}, d.DEFAULTS, c), this.$trigger = a('[data-toggle="collapse"][href="#' + b.id + '"],[data-toggle="collapse"][data-target="#' + b.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
        };
        d.VERSION = "3.3.6", d.TRANSITION_DURATION = 350, d.DEFAULTS = {toggle: !0}, d.prototype.dimension = function () {
            var a = this.$element.hasClass("width");
            return a ? "width" : "height"
        }, d.prototype.show = function () {
            if (!this.transitioning && !this.$element.hasClass("in")) {
                var b, e = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
                if (!(e && e.length && (b = e.data("bs.collapse"), b && b.transitioning))) {
                    var f = a.Event("show.bs.collapse");
                    if (this.$element.trigger(f), !f.isDefaultPrevented()) {
                        e && e.length && (c.call(e, "hide"), b || e.data("bs.collapse", null));
                        var g = this.dimension();
                        this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                        var h = function () {
                            this.$element.removeClass("collapsing").addClass("collapse in")[g](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                        };
                        if (!a.support.transition)
                            return h.call(this);
                        var i = a.camelCase(["scroll", g].join("-"));
                        this.$element.one("bsTransitionEnd", a.proxy(h, this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])
                    }
                }
            }
        }, d.prototype.hide = function () {
            if (!this.transitioning && this.$element.hasClass("in")) {
                var b = a.Event("hide.bs.collapse");
                if (this.$element.trigger(b), !b.isDefaultPrevented()) {
                    var c = this.dimension();
                    this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                    var e = function () {
                        this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                    };
                    return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(e, this)).emulateTransitionEnd(d.TRANSITION_DURATION) : e.call(this)
                }
            }
        }, d.prototype.toggle = function () {
            this[this.$element.hasClass("in") ? "hide" : "show"]()
        }, d.prototype.getParent = function () {
            return a(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(a.proxy(function (c, d) {
                var e = a(d);
                this.addAriaAndCollapsedClass(b(e), e)
            }, this)).end()
        }, d.prototype.addAriaAndCollapsedClass = function (a, b) {
            var c = a.hasClass("in");
            a.attr("aria-expanded", c), b.toggleClass("collapsed", !c).attr("aria-expanded", c)
        };
        var e = a.fn.collapse;
        a.fn.collapse = c, a.fn.collapse.Constructor = d, a.fn.collapse.noConflict = function () {
            return a.fn.collapse = e, this
        }, a(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (d) {
            var e = a(this);
            e.attr("data-target") || d.preventDefault();
            var f = b(e), g = f.data("bs.collapse"), h = g ? "toggle" : e.data();
            c.call(f, h)
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            var c = b.attr("data-target");
            c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));
            var d = c && a(c);
            return d && d.length ? d : b.parent()
        }
        function c(c) {
            c && 3 === c.which || (a(e).remove(), a(f).each(function () {
                var d = a(this), e = b(d), f = {relatedTarget: this};
                e.hasClass("open") && (c && "click" == c.type && /input|textarea/i.test(c.target.tagName) && a.contains(e[0], c.target) || (e.trigger(c = a.Event("hide.bs.dropdown", f)), c.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger(a.Event("hidden.bs.dropdown", f)))))
            }))
        }
        function d(b) {
            return this.each(function () {
                var c = a(this), d = c.data("bs.dropdown");
                d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c)
            })
        }
        var e = ".dropdown-backdrop", f = '[data-toggle="dropdown"]', g = function (b) {
            a(b).on("click.bs.dropdown", this.toggle)
        };
        g.VERSION = "3.3.6", g.prototype.toggle = function (d) {
            var e = a(this);
            if (!e.is(".disabled, :disabled")) {
                var f = b(e), g = f.hasClass("open");
                if (c(), !g) {
                    "ontouchstart"in document.documentElement && !f.closest(".navbar-nav").length && a(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(a(this)).on("click", c);
                    var h = {relatedTarget: this};
                    if (f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented())
                        return;
                    e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger(a.Event("shown.bs.dropdown", h))
                }
                return!1
            }
        }, g.prototype.keydown = function (c) {
            if (/(38|40|27|32)/.test(c.which) && !/input|textarea/i.test(c.target.tagName)) {
                var d = a(this);
                if (c.preventDefault(), c.stopPropagation(), !d.is(".disabled, :disabled")) {
                    var e = b(d), g = e.hasClass("open");
                    if (!g && 27 != c.which || g && 27 == c.which)
                        return 27 == c.which && e.find(f).trigger("focus"), d.trigger("click");
                    var h = " li:not(.disabled):visible a", i = e.find(".dropdown-menu" + h);
                    if (i.length) {
                        var j = i.index(c.target);
                        38 == c.which && j > 0 && j--, 40 == c.which && j < i.length - 1 && j++, ~j || (j = 0), i.eq(j).trigger("focus")
                    }
                }
            }
        };
        var h = a.fn.dropdown;
        a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function () {
            return a.fn.dropdown = h, this
        }, a(document).on("click.bs.dropdown.data-api", c).on("click.bs.dropdown.data-api", ".dropdown form", function (a) {
            a.stopPropagation()
        }).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f, g.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", g.prototype.keydown)
    }(jQuery), +function (a) {
        "use strict";
        function b(b, d) {
            return this.each(function () {
                var e = a(this), f = e.data("bs.modal"), g = a.extend({}, c.DEFAULTS, e.data(), "object" == typeof b && b);
                f || e.data("bs.modal", f = new c(this, g)), "string" == typeof b ? f[b](d) : g.show && f.show(d)
            })
        }
        var c = function (b, c) {
            this.options = c, this.$body = a(document.body), this.$element = a(b), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function () {
                this.$element.trigger("loaded.bs.modal")
            }, this))
        };
        c.VERSION = "3.3.6", c.TRANSITION_DURATION = 300, c.BACKDROP_TRANSITION_DURATION = 150, c.DEFAULTS = {backdrop: !0, keyboard: !0, show: !0}, c.prototype.toggle = function (a) {
            return this.isShown ? this.hide() : this.show(a)
        }, c.prototype.show = function (b) {
            var d = this, e = a.Event("show.bs.modal", {relatedTarget: b});
            this.$element.trigger(e), this.isShown || e.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', a.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function () {
                d.$element.one("mouseup.dismiss.bs.modal", function (b) {
                    a(b.target).is(d.$element) && (d.ignoreBackdropClick = !0)
                })
            }), this.backdrop(function () {
                var e = a.support.transition && d.$element.hasClass("fade");
                d.$element.parent().length || d.$element.appendTo(d.$body), d.$element.show().scrollTop(0), d.adjustDialog(), e && d.$element[0].offsetWidth, d.$element.addClass("in"), d.enforceFocus();
                var f = a.Event("shown.bs.modal", {relatedTarget: b});
                e ? d.$dialog.one("bsTransitionEnd", function () {
                    d.$element.trigger("focus").trigger(f)
                }).emulateTransitionEnd(c.TRANSITION_DURATION) : d.$element.trigger("focus").trigger(f)
            }))
        }, c.prototype.hide = function (b) {
            b && b.preventDefault(), b = a.Event("hide.bs.modal"), this.$element.trigger(b), this.isShown && !b.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), a(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", a.proxy(this.hideModal, this)).emulateTransitionEnd(c.TRANSITION_DURATION) : this.hideModal())
        }, c.prototype.enforceFocus = function () {
            a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function (a) {
                this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.trigger("focus")
            }, this))
        }, c.prototype.escape = function () {
            this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", a.proxy(function (a) {
                27 == a.which && this.hide()
            }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
        }, c.prototype.resize = function () {
            this.isShown ? a(window).on("resize.bs.modal", a.proxy(this.handleUpdate, this)) : a(window).off("resize.bs.modal")
        }, c.prototype.hideModal = function () {
            var a = this;
            this.$element.hide(), this.backdrop(function () {
                a.$body.removeClass("modal-open"), a.resetAdjustments(), a.resetScrollbar(), a.$element.trigger("hidden.bs.modal")
            })
        }, c.prototype.removeBackdrop = function () {
            this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
        }, c.prototype.backdrop = function (b) {
            var d = this, e = this.$element.hasClass("fade") ? "fade" : "";
            if (this.isShown && this.options.backdrop) {
                var f = a.support.transition && e;
                if (this.$backdrop = a(document.createElement("div")).addClass("modal-backdrop " + e).appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", a.proxy(function (a) {
                    return this.ignoreBackdropClick ? void(this.ignoreBackdropClick = !1) : void(a.target === a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()))
                }, this)), f && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !b)
                    return;
                f ? this.$backdrop.one("bsTransitionEnd", b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : b()
            } else if (!this.isShown && this.$backdrop) {
                this.$backdrop.removeClass("in");
                var g = function () {
                    d.removeBackdrop(), b && b()
                };
                a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : g()
            } else
                b && b()
        }, c.prototype.handleUpdate = function () {
            this.adjustDialog()
        }, c.prototype.adjustDialog = function () {
            var a = this.$element[0].scrollHeight > document.documentElement.clientHeight;
            this.$element.css({paddingLeft: !this.bodyIsOverflowing && a ? this.scrollbarWidth : "", paddingRight: this.bodyIsOverflowing && !a ? this.scrollbarWidth : ""})
        }, c.prototype.resetAdjustments = function () {
            this.$element.css({paddingLeft: "", paddingRight: ""})
        }, c.prototype.checkScrollbar = function () {
            var a = window.innerWidth;
            if (!a) {
                var b = document.documentElement.getBoundingClientRect();
                a = b.right - Math.abs(b.left)
            }
            this.bodyIsOverflowing = document.body.clientWidth < a, this.scrollbarWidth = this.measureScrollbar()
        }, c.prototype.setScrollbar = function () {
            var a = parseInt(this.$body.css("padding-right") || 0, 10);
            this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", a + this.scrollbarWidth)
        }, c.prototype.resetScrollbar = function () {
            this.$body.css("padding-right", this.originalBodyPad)
        }, c.prototype.measureScrollbar = function () {
            var a = document.createElement("div");
            a.className = "modal-scrollbar-measure", this.$body.append(a);
            var b = a.offsetWidth - a.clientWidth;
            return this.$body[0].removeChild(a), b
        };
        var d = a.fn.modal;
        a.fn.modal = b, a.fn.modal.Constructor = c, a.fn.modal.noConflict = function () {
            return a.fn.modal = d, this
        }, a(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (c) {
            var d = a(this), e = d.attr("href"), f = a(d.attr("data-target") || e && e.replace(/.*(?=#[^\s]+$)/, "")), g = f.data("bs.modal") ? "toggle" : a.extend({remote: !/#/.test(e) && e}, f.data(), d.data());
            d.is("a") && c.preventDefault(), f.one("show.bs.modal", function (a) {
                a.isDefaultPrevented() || f.one("hidden.bs.modal", function () {
                    d.is(":visible") && d.trigger("focus")
                })
            }), b.call(f, g, this)
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.tooltip"), f = "object" == typeof b && b;
                (e || !/destroy|hide/.test(b)) && (e || d.data("bs.tooltip", e = new c(this, f)), "string" == typeof b && e[b]())
            })
        }
        var c = function (a, b) {
            this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", a, b)
        };
        c.VERSION = "3.3.6", c.TRANSITION_DURATION = 150, c.DEFAULTS = {animation: !0, placement: "top", selector: !1, template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', trigger: "hover focus", title: "", delay: 0, html: !1, container: !1, viewport: {selector: "body", padding: 0}}, c.prototype.init = function (b, c, d) {
            if (this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), this.$viewport = this.options.viewport && a(a.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), this.inState = {click: !1, hover: !1, focus: !1}, this.$element[0]instanceof document.constructor && !this.options.selector)
                throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
            for (var e = this.options.trigger.split(" "), f = e.length; f--; ) {
                var g = e[f];
                if ("click" == g)
                    this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));
                else if ("manual" != g) {
                    var h = "hover" == g ? "mouseenter" : "focusin", i = "hover" == g ? "mouseleave" : "focusout";
                    this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this))
                }
            }
            this.options.selector ? this._options = a.extend({}, this.options, {trigger: "manual", selector: ""}) : this.fixTitle()
        }, c.prototype.getDefaults = function () {
            return c.DEFAULTS
        }, c.prototype.getOptions = function (b) {
            return b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = {show: b.delay, hide: b.delay}), b
        }, c.prototype.getDelegateOptions = function () {
            var b = {}, c = this.getDefaults();
            return this._options && a.each(this._options, function (a, d) {
                c[a] != d && (b[a] = d)
            }), b
        }, c.prototype.enter = function (b) {
            var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
            return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), b instanceof a.Event && (c.inState["focusin" == b.type ? "focus" : "hover"] = !0), c.tip().hasClass("in") || "in" == c.hoverState ? void(c.hoverState = "in") : (clearTimeout(c.timeout), c.hoverState = "in", c.options.delay && c.options.delay.show ? void(c.timeout = setTimeout(function () {
                "in" == c.hoverState && c.show()
            }, c.options.delay.show)) : c.show())
        }, c.prototype.isInStateTrue = function () {
            for (var a in this.inState)
                if (this.inState[a])
                    return!0;
            return!1
        }, c.prototype.leave = function (b) {
            var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
            return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c)), b instanceof a.Event && (c.inState["focusout" == b.type ? "focus" : "hover"] = !1), c.isInStateTrue() ? void 0 : (clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void(c.timeout = setTimeout(function () {
                "out" == c.hoverState && c.hide()
            }, c.options.delay.hide)) : c.hide())
        }, c.prototype.show = function () {
            var b = a.Event("show.bs." + this.type);
            if (this.hasContent() && this.enabled) {
                this.$element.trigger(b);
                var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
                if (b.isDefaultPrevented() || !d)
                    return;
                var e = this, f = this.tip(), g = this.getUID(this.type);
                this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");
                var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement, i = /\s?auto?\s?/i, j = i.test(h);
                j && (h = h.replace(i, "") || "top"), f.detach().css({top: 0, left: 0, display: "block"}).addClass(h).data("bs." + this.type, this), this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element), this.$element.trigger("inserted.bs." + this.type);
                var k = this.getPosition(), l = f[0].offsetWidth, m = f[0].offsetHeight;
                if (j) {
                    var n = h, o = this.getPosition(this.$viewport);
                    h = "bottom" == h && k.bottom + m > o.bottom ? "top" : "top" == h && k.top - m < o.top ? "bottom" : "right" == h && k.right + l > o.width ? "left" : "left" == h && k.left - l < o.left ? "right" : h, f.removeClass(n).addClass(h)
                }
                var p = this.getCalculatedOffset(h, k, l, m);
                this.applyPlacement(p, h);
                var q = function () {
                    var a = e.hoverState;
                    e.$element.trigger("shown.bs." + e.type), e.hoverState = null, "out" == a && e.leave(e)
                };
                a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", q).emulateTransitionEnd(c.TRANSITION_DURATION) : q()
            }
        }, c.prototype.applyPlacement = function (b, c) {
            var d = this.tip(), e = d[0].offsetWidth, f = d[0].offsetHeight, g = parseInt(d.css("margin-top"), 10), h = parseInt(d.css("margin-left"), 10);
            isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top += g, b.left += h, a.offset.setOffset(d[0], a.extend({using: function (a) {
                    d.css({top: Math.round(a.top), left: Math.round(a.left)})
                }}, b), 0), d.addClass("in");
            var i = d[0].offsetWidth, j = d[0].offsetHeight;
            "top" == c && j != f && (b.top = b.top + f - j);
            var k = this.getViewportAdjustedDelta(c, b, i, j);
            k.left ? b.left += k.left : b.top += k.top;
            var l = /top|bottom/.test(c), m = l ? 2 * k.left - e + i : 2 * k.top - f + j, n = l ? "offsetWidth" : "offsetHeight";
            d.offset(b), this.replaceArrow(m, d[0][n], l)
        }, c.prototype.replaceArrow = function (a, b, c) {
            this.arrow().css(c ? "left" : "top", 50 * (1 - a / b) + "%").css(c ? "top" : "left", "")
        }, c.prototype.setContent = function () {
            var a = this.tip(), b = this.getTitle();
            a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right")
        }, c.prototype.hide = function (b) {
            function d() {
                "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), b && b()
            }
            var e = this, f = a(this.$tip), g = a.Event("hide.bs." + this.type);
            return this.$element.trigger(g), g.isDefaultPrevented() ? void 0 : (f.removeClass("in"), a.support.transition && f.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), this.hoverState = null, this)
        }, c.prototype.fixTitle = function () {
            var a = this.$element;
            (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "")
        }, c.prototype.hasContent = function () {
            return this.getTitle()
        }, c.prototype.getPosition = function (b) {
            b = b || this.$element;
            var c = b[0], d = "BODY" == c.tagName, e = c.getBoundingClientRect();
            null == e.width && (e = a.extend({}, e, {width: e.right - e.left, height: e.bottom - e.top}));
            var f = d ? {top: 0, left: 0} : b.offset(), g = {scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop()}, h = d ? {width: a(window).width(), height: a(window).height()} : null;
            return a.extend({}, e, g, h, f)
        }, c.prototype.getCalculatedOffset = function (a, b, c, d) {
            return"bottom" == a ? {top: b.top + b.height, left: b.left + b.width / 2 - c / 2} : "top" == a ? {top: b.top - d, left: b.left + b.width / 2 - c / 2} : "left" == a ? {top: b.top + b.height / 2 - d / 2, left: b.left - c} : {top: b.top + b.height / 2 - d / 2, left: b.left + b.width}
        }, c.prototype.getViewportAdjustedDelta = function (a, b, c, d) {
            var e = {top: 0, left: 0};
            if (!this.$viewport)
                return e;
            var f = this.options.viewport && this.options.viewport.padding || 0, g = this.getPosition(this.$viewport);
            if (/right|left/.test(a)) {
                var h = b.top - f - g.scroll, i = b.top + f - g.scroll + d;
                h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i)
            } else {
                var j = b.left - f, k = b.left + f + c;
                j < g.left ? e.left = g.left - j : k > g.right && (e.left = g.left + g.width - k)
            }
            return e
        }, c.prototype.getTitle = function () {
            var a, b = this.$element, c = this.options;
            return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title)
        }, c.prototype.getUID = function (a) {
            do
                a += ~~(1e6 * Math.random());
            while (document.getElementById(a));
            return a
        }, c.prototype.tip = function () {
            if (!this.$tip && (this.$tip = a(this.options.template), 1 != this.$tip.length))
                throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
            return this.$tip
        }, c.prototype.arrow = function () {
            return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
        }, c.prototype.enable = function () {
            this.enabled = !0
        }, c.prototype.disable = function () {
            this.enabled = !1
        }, c.prototype.toggleEnabled = function () {
            this.enabled = !this.enabled
        }, c.prototype.toggle = function (b) {
            var c = this;
            b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), a(b.currentTarget).data("bs." + this.type, c))), b ? (c.inState.click = !c.inState.click, c.isInStateTrue() ? c.enter(c) : c.leave(c)) : c.tip().hasClass("in") ? c.leave(c) : c.enter(c)
        }, c.prototype.destroy = function () {
            var a = this;
            clearTimeout(this.timeout), this.hide(function () {
                a.$element.off("." + a.type).removeData("bs." + a.type), a.$tip && a.$tip.detach(), a.$tip = null, a.$arrow = null, a.$viewport = null
            })
        };
        var d = a.fn.tooltip;
        a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function () {
            return a.fn.tooltip = d, this
        }
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.popover"), f = "object" == typeof b && b;
                (e || !/destroy|hide/.test(b)) && (e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]())
            })
        }
        var c = function (a, b) {
            this.init("popover", a, b)
        };
        if (!a.fn.tooltip)
            throw new Error("Popover requires tooltip.js");
        c.VERSION = "3.3.6", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function () {
            return c.DEFAULTS
        }, c.prototype.setContent = function () {
            var a = this.tip(), b = this.getTitle(), c = this.getContent();
            a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide()
        }, c.prototype.hasContent = function () {
            return this.getTitle() || this.getContent()
        }, c.prototype.getContent = function () {
            var a = this.$element, b = this.options;
            return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content)
        }, c.prototype.arrow = function () {
            return this.$arrow = this.$arrow || this.tip().find(".arrow")
        };
        var d = a.fn.popover;
        a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function () {
            return a.fn.popover = d, this
        }
    }(jQuery), +function (a) {
        "use strict";
        function b(c, d) {
            this.$body = a(document.body), this.$scrollElement = a(a(c).is(document.body) ? window : c), this.options = a.extend({}, b.DEFAULTS, d), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", a.proxy(this.process, this)), this.refresh(), this.process()
        }
        function c(c) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.scrollspy"), f = "object" == typeof c && c;
                e || d.data("bs.scrollspy", e = new b(this, f)), "string" == typeof c && e[c]()
            })
        }
        b.VERSION = "3.3.6", b.DEFAULTS = {offset: 10}, b.prototype.getScrollHeight = function () {
            return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
        }, b.prototype.refresh = function () {
            var b = this, c = "offset", d = 0;
            this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), a.isWindow(this.$scrollElement[0]) || (c = "position", d = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function () {
                var b = a(this), e = b.data("target") || b.attr("href"), f = /^#./.test(e) && a(e);
                return f && f.length && f.is(":visible") && [[f[c]().top + d, e]] || null
            }).sort(function (a, b) {
                return a[0] - b[0]
            }).each(function () {
                b.offsets.push(this[0]), b.targets.push(this[1])
            })
        }, b.prototype.process = function () {
            var a, b = this.$scrollElement.scrollTop() + this.options.offset, c = this.getScrollHeight(), d = this.options.offset + c - this.$scrollElement.height(), e = this.offsets, f = this.targets, g = this.activeTarget;
            if (this.scrollHeight != c && this.refresh(), b >= d)
                return g != (a = f[f.length - 1]) && this.activate(a);
            if (g && b < e[0])
                return this.activeTarget = null, this.clear();
            for (a = e.length; a--; )
                g != f[a] && b >= e[a] && (void 0 === e[a + 1] || b < e[a + 1]) && this.activate(f[a])
        }, b.prototype.activate = function (b) {
            this.activeTarget = b, this.clear();
            var c = this.selector + '[data-target="' + b + '"],' + this.selector + '[href="' + b + '"]', d = a(c).parents("li").addClass("active");
            d.parent(".dropdown-menu").length && (d = d.closest("li.dropdown").addClass("active")), d.trigger("activate.bs.scrollspy")
        }, b.prototype.clear = function () {
            a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
        };
        var d = a.fn.scrollspy;
        a.fn.scrollspy = c, a.fn.scrollspy.Constructor = b, a.fn.scrollspy.noConflict = function () {
            return a.fn.scrollspy = d, this
        }, a(window).on("load.bs.scrollspy.data-api", function () {
            a('[data-spy="scroll"]').each(function () {
                var b = a(this);
                c.call(b, b.data())
            })
        })
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.tab");
                e || d.data("bs.tab", e = new c(this)), "string" == typeof b && e[b]()
            })
        }
        var c = function (b) {
            this.element = a(b)
        };
        c.VERSION = "3.3.6", c.TRANSITION_DURATION = 150, c.prototype.show = function () {
            var b = this.element, c = b.closest("ul:not(.dropdown-menu)"), d = b.data("target");
            if (d || (d = b.attr("href"), d = d && d.replace(/.*(?=#[^\s]*$)/, "")), !b.parent("li").hasClass("active")) {
                var e = c.find(".active:last a"), f = a.Event("hide.bs.tab", {relatedTarget: b[0]}), g = a.Event("show.bs.tab", {relatedTarget: e[0]});
                if (e.trigger(f), b.trigger(g), !g.isDefaultPrevented() && !f.isDefaultPrevented()) {
                    var h = a(d);
                    this.activate(b.closest("li"), c), this.activate(h, h.parent(), function () {
                        e.trigger({type: "hidden.bs.tab", relatedTarget: b[0]}), b.trigger({type: "shown.bs.tab", relatedTarget: e[0]})
                    })
                }
            }
        }, c.prototype.activate = function (b, d, e) {
            function f() {
                g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), h ? (b[0].offsetWidth, b.addClass("in")) : b.removeClass("fade"), b.parent(".dropdown-menu").length && b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), e && e()
            }
            var g = d.find("> .active"), h = e && a.support.transition && (g.length && g.hasClass("fade") || !!d.find("> .fade").length);
            g.length && h ? g.one("bsTransitionEnd", f).emulateTransitionEnd(c.TRANSITION_DURATION) : f(), g.removeClass("in")
        };
        var d = a.fn.tab;
        a.fn.tab = b, a.fn.tab.Constructor = c, a.fn.tab.noConflict = function () {
            return a.fn.tab = d, this
        };
        var e = function (c) {
            c.preventDefault(), b.call(a(this), "show")
        };
        a(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', e).on("click.bs.tab.data-api", '[data-toggle="pill"]', e)
    }(jQuery), +function (a) {
        "use strict";
        function b(b) {
            return this.each(function () {
                var d = a(this), e = d.data("bs.affix"), f = "object" == typeof b && b;
                e || d.data("bs.affix", e = new c(this, f)), "string" == typeof b && e[b]()
            })
        }
        var c = function (b, d) {
            this.options = a.extend({}, c.DEFAULTS, d), this.$target = a(this.options.target).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this)), this.$element = a(b), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition()
        };
        c.VERSION = "3.3.6", c.RESET = "affix affix-top affix-bottom", c.DEFAULTS = {offset: 0, target: window}, c.prototype.getState = function (a, b, c, d) {
            var e = this.$target.scrollTop(), f = this.$element.offset(), g = this.$target.height();
            if (null != c && "top" == this.affixed)
                return c > e ? "top" : !1;
            if ("bottom" == this.affixed)
                return null != c ? e + this.unpin <= f.top ? !1 : "bottom" : a - d >= e + g ? !1 : "bottom";
            var h = null == this.affixed, i = h ? e : f.top, j = h ? g : b;
            return null != c && c >= e ? "top" : null != d && i + j >= a - d ? "bottom" : !1
        }, c.prototype.getPinnedOffset = function () {
            if (this.pinnedOffset)
                return this.pinnedOffset;
            this.$element.removeClass(c.RESET).addClass("affix");
            var a = this.$target.scrollTop(), b = this.$element.offset();
            return this.pinnedOffset = b.top - a
        }, c.prototype.checkPositionWithEventLoop = function () {
            setTimeout(a.proxy(this.checkPosition, this), 1)
        }, c.prototype.checkPosition = function () {
            if (this.$element.is(":visible")) {
                var b = this.$element.height(), d = this.options.offset, e = d.top, f = d.bottom, g = Math.max(a(document).height(), a(document.body).height());
                "object" != typeof d && (f = e = d), "function" == typeof e && (e = d.top(this.$element)), "function" == typeof f && (f = d.bottom(this.$element));
                var h = this.getState(g, b, e, f);
                if (this.affixed != h) {
                    null != this.unpin && this.$element.css("top", "");
                    var i = "affix" + (h ? "-" + h : ""), j = a.Event(i + ".bs.affix");
                    if (this.$element.trigger(j), j.isDefaultPrevented())
                        return;
                    this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix", "affixed") + ".bs.affix")
                }
                "bottom" == h && this.$element.offset({top: g - b - f})
            }
        };
        var d = a.fn.affix;
        a.fn.affix = b, a.fn.affix.Constructor = c, a.fn.affix.noConflict = function () {
            return a.fn.affix = d, this
        }, a(window).on("load", function () {
            a('[data-spy="affix"]').each(function () {
                var c = a(this), d = c.data();
                d.offset = d.offset || {}, null != d.offsetBottom && (d.offset.bottom = d.offsetBottom), null != d.offsetTop && (d.offset.top = d.offsetTop), b.call(c, d)
            })
        })
    }(jQuery);


    /*
     * Fuel UX Wizard
     * https://github.com/ExactTarget/fuelux
     *
     * Copyright (c) 2014 ExactTarget
     * Licensed under the BSD New license.
     */
    !function (t) {
        "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == typeof exports ? module.exports = t(require("jquery")) : t(jQuery)
    }(function (t) {
        var e = t.fn.wizard, i = function (e, i) {
            var s;
            this.$element = t(e), this.options = t.extend({}, t.fn.wizard.defaults, i), this.options.disablePreviousStep = "previous" === this.$element.attr("data-restrict") ? !0 : this.options.disablePreviousStep, this.currentStep = this.options.selectedItem.step, this.numSteps = this.$element.find(".steps li").length, this.$prevBtn = this.$element.find("button.btn-prev"), this.$nextBtn = this.$element.find("button.btn-next"), 0 === this.$element.children(".steps-container").length && (this.$element.addClass("no-steps-container"), window && window.console && window.console.warn && window.console.warn('please update your wizard markup to include ".steps-container" as seen in http://getfuelux.com/javascript.html#wizard-usage-markup')), s = this.$nextBtn.children().detach(), this.nextText = t.trim(this.$nextBtn.text()), this.$nextBtn.append(s), this.$prevBtn.on("click.fu.wizard", t.proxy(this.previous, this)), this.$nextBtn.on("click.fu.wizard", t.proxy(this.next, this)), this.$element.on("click.fu.wizard", "li.complete", t.proxy(this.stepclicked, this)), this.selectedItem(this.options.selectedItem), this.options.disablePreviousStep && (this.$prevBtn.attr("disabled", !0), this.$element.find(".steps").addClass("previous-disabled"))
        };
        i.prototype = {constructor: i, destroy: function () {
                return this.$element.remove(), this.$element[0].outerHTML
            }, addSteps: function (e) {
                var i, s, n, a, r, d, l = [].slice.call(arguments).slice(1), p = this.$element.find(".steps"), h = this.$element.find(".step-content");
                for (e = - 1 === e || e > this.numSteps + 1?this.numSteps + 1:e, l[0]instanceof Array && (l = l[0]), r = p.find("li:nth-child(" + e + ")"), a = h.find(".step-pane:nth-child(" + e + ")"), r.length < 1 && (r = null), i = 0, s = l.length; s > i; i++)
                    d = t('<li data-step="' + e + '"><span class="badge badge-info"></span></li>'), d.append(l[i].label || "").append('<span class="chevron"></span>'), d.find(".badge").append(l[i].badge || e), n = t('<div class="step-pane" data-step="' + e + '"></div>'), n.append(l[i].pane || ""), r ? (r.before(d), a.before(n)) : (p.append(d), h.append(n)), e++;
                this.syncSteps(), this.numSteps = p.find("li").length, this.setState()
            }, removeSteps: function (e, i) {
                var s, n = "nextAll", a = 0, r = this.$element.find(".steps"), d = this.$element.find(".step-content");
                i = void 0 !== i ? i : 1, e > r.find("li").length ? s = r.find("li:last") : (s = r.find("li:nth-child(" + e + ")").prev(), s.length < 1 && (n = "children", s = r)), s[n]().each(function () {
                    var e = t(this), s = e.attr("data-step");
                    return i > a ? (e.remove(), d.find('.step-pane[data-step="' + s + '"]:first').remove(), void a++) : !1
                }), this.syncSteps(), this.numSteps = r.find("li").length, this.setState()
            }, setState: function () {
                var e = this.currentStep > 1, i = 1 === this.currentStep, s = this.currentStep === this.numSteps;
                this.options.disablePreviousStep || this.$prevBtn.attr("disabled", i === !0 || e === !1);
                var n = this.$nextBtn.attr("data-last");
                if (n) {
                    this.lastText = n;
                    var a = this.nextText;
                    s === !0 ? (a = this.lastText, this.$element.addClass("complete")) : this.$element.removeClass("complete");
                    var r = this.$nextBtn.children().detach();
                    this.$nextBtn.text(a).append(r)
                }
                var d = this.$element.find(".steps li");
                d.removeClass("active").removeClass("complete"), d.find("span.badge").removeClass("badge-info").removeClass("badge-success");
                var l = ".steps li:lt(" + (this.currentStep - 1) + ")", p = this.$element.find(l);
                p.addClass("complete"), p.find("span.badge").addClass("badge-success");
                var h = ".steps li:eq(" + (this.currentStep - 1) + ")", f = this.$element.find(h);
                f.addClass("active"), f.find("span.badge").addClass("badge-info");
                var o = this.$element.find(".step-content"), c = f.attr("data-step");
                o.find(".step-pane").removeClass("active"), o.find('.step-pane[data-step="' + c + '"]:first').addClass("active"), this.$element.find(".steps").first().attr("style", "margin-left: 0");
                var u = 0;
                this.$element.find(".steps > li").each(function () {
                    u += t(this).outerWidth()
                });
                var m = 0;
                if (m = this.$element.find(".actions").length ? this.$element.width() - this.$element.find(".actions").first().outerWidth() : this.$element.width(), u > m) {
                    var v = u - m;
                    this.$element.find(".steps").first().attr("style", "margin-left: -" + v + "px"), this.$element.find("li.active").first().position().left < 200 && (v += this.$element.find("li.active").first().position().left - 200, 1 > v ? this.$element.find(".steps").first().attr("style", "margin-left: 0") : this.$element.find(".steps").first().attr("style", "margin-left: -" + v + "px"))
                }
                if ("undefined" != typeof this.initialized) {
                    var $ = t.Event("changed.fu.wizard");
                    this.$element.trigger($, {step: this.currentStep})
                }
                this.initialized = !0
            }, stepclicked: function (e) {
                var i = t(e.currentTarget), s = this.$element.find(".steps li").index(i);
                if (!(s < this.currentStep && this.options.disablePreviousStep)) {
                    var n = t.Event("stepclicked.fu.wizard");
                    this.$element.trigger(n, {step: s + 1}), n.isDefaultPrevented() || (this.currentStep = s + 1, this.setState())
                }
            }, syncSteps: function () {
                var e = 1, i = this.$element.find(".steps"), s = this.$element.find(".step-content");
                i.children().each(function () {
                    var i = t(this), n = i.find(".badge"), a = i.attr("data-step");
                    isNaN(parseInt(n.html(), 10)) || n.html(e), i.attr("data-step", e), s.find('.step-pane[data-step="' + a + '"]:last').attr("data-step", e), e++
                })
            }, previous: function () {
                if (!this.options.disablePreviousStep && 1 !== this.currentStep) {
                    var e = t.Event("actionclicked.fu.wizard");
                    if (this.$element.trigger(e, {step: this.currentStep, direction: "previous"}), !e.isDefaultPrevented() && (this.currentStep -= 1, this.setState(), this.$prevBtn.is(":focus"))) {
                        var i = this.$element.find(".active").find("input, select, textarea")[0];
                        "undefined" != typeof i ? t(i).focus() : 0 === this.$element.find(".active input:first").length && this.$prevBtn.is(":disabled") && this.$nextBtn.focus()
                    }
                }
            }, next: function () {
                var e = t.Event("actionclicked.fu.wizard");
                if (this.$element.trigger(e, {step: this.currentStep, direction: "next"}), !e.isDefaultPrevented() && (this.currentStep < this.numSteps ? (this.currentStep += 1, this.setState()) : this.$element.trigger("finished.fu.wizard"), this.$nextBtn.is(":focus"))) {
                    var i = this.$element.find(".active").find("input, select, textarea")[0];
                    "undefined" != typeof i ? t(i).focus() : 0 === this.$element.find(".active input:first").length && this.$nextBtn.is(":disabled") && this.$prevBtn.focus()
                }
            }, selectedItem: function (t) {
                var e, i;
                return t ? (i = t.step || -1, i = Number(this.$element.find('.steps li[data-name="' + i + '"]').first().attr("data-step")) || Number(i), i >= 1 && i <= this.numSteps ? (this.currentStep = i, this.setState()) : (i = this.$element.find(".steps li.active:first").attr("data-step"), isNaN(i) || (this.currentStep = parseInt(i, 10), this.setState())), e = this) : (e = {step: this.currentStep}, this.$element.find(".steps li.active:first[data-name]").length && (e.stepname = this.$element.find(".steps li.active:first").attr("data-name"))), e
            }}, t.fn.wizard = function (e) {
            var s, n = Array.prototype.slice.call(arguments, 1), a = this.each(function () {
                var a = t(this), r = a.data("fu.wizard"), d = "object" == typeof e && e;
                r || a.data("fu.wizard", r = new i(this, d)), "string" == typeof e && (s = r[e].apply(r, n))
            });
            return void 0 === s ? a : s
        }, t.fn.wizard.defaults = {disablePreviousStep: !1, selectedItem: {step: -1}}, t.fn.wizard.Constructor = i, t.fn.wizard.noConflict = function () {
            return t.fn.wizard = e, this
        }, t(document).on("mouseover.fu.wizard.data-api", "[data-initialize=wizard]", function (e) {
            var i = t(e.target).closest(".wizard");
            i.data("fu.wizard") || i.wizard(i.data())
        }), t(function () {
            t("[data-initialize=wizard]").each(function () {
                var e = t(this);
                e.data("fu.wizard") || e.wizard(e.data())
            })
        })
    });

    !function (t) {
        t.color = {}, t.color.make = function (i, e, o, n) {
            var a = {};
            return a.r = i || 0, a.g = e || 0, a.b = o || 0, a.a = null != n ? n : 1, a.add = function (t, i) {
                for (var e = 0; e < t.length; ++e)
                    a[t.charAt(e)] += i;
                return a.normalize()
            }, a.scale = function (t, i) {
                for (var e = 0; e < t.length; ++e)
                    a[t.charAt(e)] *= i;
                return a.normalize()
            }, a.toString = function () {
                return a.a >= 1 ? "rgb(" + [a.r, a.g, a.b].join(",") + ")" : "rgba(" + [a.r, a.g, a.b, a.a].join(",") + ")"
            }, a.normalize = function () {
                function t(t, i, e) {
                    return t > i ? t : i > e ? e : i
                }
                return a.r = t(0, parseInt(a.r), 255), a.g = t(0, parseInt(a.g), 255), a.b = t(0, parseInt(a.b), 255), a.a = t(0, a.a, 1), a
            }, a.clone = function () {
                return t.color.make(a.r, a.b, a.g, a.a)
            }, a.normalize()
        }, t.color.extract = function (i, e) {
            var o;
            do {
                if (o = i.css(e).toLowerCase(), "" != o && "transparent" != o)
                    break;
                i = i.parent()
            } while (i.length && !t.nodeName(i.get(0), "body"));
            return"rgba(0, 0, 0, 0)" == o && (o = "transparent"), t.color.parse(o)
        }, t.color.parse = function (e) {
            var o, n = t.color.make;
            if (o = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(e))
                return n(parseInt(o[1], 10), parseInt(o[2], 10), parseInt(o[3], 10));
            if (o = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(e))
                return n(parseInt(o[1], 10), parseInt(o[2], 10), parseInt(o[3], 10), parseFloat(o[4]));
            if (o = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(e))
                return n(2.55 * parseFloat(o[1]), 2.55 * parseFloat(o[2]), 2.55 * parseFloat(o[3]));
            if (o = /rgba\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(e))
                return n(2.55 * parseFloat(o[1]), 2.55 * parseFloat(o[2]), 2.55 * parseFloat(o[3]), parseFloat(o[4]));
            if (o = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(e))
                return n(parseInt(o[1], 16), parseInt(o[2], 16), parseInt(o[3], 16));
            if (o = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(e))
                return n(parseInt(o[1] + o[1], 16), parseInt(o[2] + o[2], 16), parseInt(o[3] + o[3], 16));
            var a = t.trim(e).toLowerCase();
            return"transparent" == a ? n(255, 255, 255, 0) : (o = i[a] || [0, 0, 0], n(o[0], o[1], o[2]))
        };
        var i = {aqua: [0, 255, 255], azure: [240, 255, 255], beige: [245, 245, 220], black: [0, 0, 0], blue: [0, 0, 255], brown: [165, 42, 42], cyan: [0, 255, 255], darkblue: [0, 0, 139], darkcyan: [0, 139, 139], darkgrey: [169, 169, 169], darkgreen: [0, 100, 0], darkkhaki: [189, 183, 107], darkmagenta: [139, 0, 139], darkolivegreen: [85, 107, 47], darkorange: [255, 140, 0], darkorchid: [153, 50, 204], darkred: [139, 0, 0], darksalmon: [233, 150, 122], darkviolet: [148, 0, 211], fuchsia: [255, 0, 255], gold: [255, 215, 0], green: [0, 128, 0], indigo: [75, 0, 130], khaki: [240, 230, 140], lightblue: [173, 216, 230], lightcyan: [224, 255, 255], lightgreen: [144, 238, 144], lightgrey: [211, 211, 211], lightpink: [255, 182, 193], lightyellow: [255, 255, 224], lime: [0, 255, 0], magenta: [255, 0, 255], maroon: [128, 0, 0], navy: [0, 0, 128], olive: [128, 128, 0], orange: [255, 165, 0], pink: [255, 192, 203], purple: [128, 0, 128], violet: [128, 0, 128], red: [255, 0, 0], silver: [192, 192, 192], white: [255, 255, 255], yellow: [255, 255, 0]}
    }(jQuery), function (t) {
        function i(i, e) {
            var o = e.children("." + i)[0];
            if (null == o && (o = document.createElement("canvas"), o.className = i, t(o).css({direction: "ltr", position: "absolute", left: 0, top: 0}).appendTo(e), !o.getContext)) {
                if (!window.G_vmlCanvasManager)
                    throw new Error("Canvas is not available. If you're using IE with a fall-back such as Excanvas, then there's either a mistake in your conditional include, or the page has no DOCTYPE and is rendering in Quirks Mode.");
                o = window.G_vmlCanvasManager.initElement(o)
            }
            this.element = o;
            var n = this.context = o.getContext("2d"), a = window.devicePixelRatio || 1, r = n.webkitBackingStorePixelRatio || n.mozBackingStorePixelRatio || n.msBackingStorePixelRatio || n.oBackingStorePixelRatio || n.backingStorePixelRatio || 1;
            this.pixelRatio = a / r, this.resize(e.width(), e.height()), this.textContainer = null, this.text = {}, this._textCache = {}
        }
        function e(e, n, a, r) {
            function l(t, i) {
                i = [xt].concat(i);
                for (var e = 0; e < t.length; ++e)
                    t[e].apply(this, i)
            }
            function s() {
                for (var e = {Canvas: i}, o = 0; o < r.length; ++o) {
                    var n = r[o];
                    n.init(xt, e), n.options && t.extend(!0, nt, n.options)
                }
            }
            function c(i) {
                t.extend(!0, nt, i), i && i.colors && (nt.colors = i.colors), null == nt.xaxis.color && (nt.xaxis.color = t.color.parse(nt.grid.color).scale("a", .22).toString()), null == nt.yaxis.color && (nt.yaxis.color = t.color.parse(nt.grid.color).scale("a", .22).toString()), null == nt.xaxis.tickColor && (nt.xaxis.tickColor = nt.grid.tickColor || nt.xaxis.color), null == nt.yaxis.tickColor && (nt.yaxis.tickColor = nt.grid.tickColor || nt.yaxis.color), null == nt.grid.borderColor && (nt.grid.borderColor = nt.grid.color), null == nt.grid.tickColor && (nt.grid.tickColor = t.color.parse(nt.grid.color).scale("a", .22).toString());
                var o, n, a, r = e.css("font-size"), s = r ? +r.replace("px", "") : 13, c = {style: e.css("font-style"), size: Math.round(.8 * s), variant: e.css("font-variant"), weight: e.css("font-weight"), family: e.css("font-family")};
                for (a = nt.xaxes.length || 1, o = 0; a > o; ++o)
                    n = nt.xaxes[o], n && !n.tickColor && (n.tickColor = n.color), n = t.extend(!0, {}, nt.xaxis, n), nt.xaxes[o] = n, n.font && (n.font = t.extend({}, c, n.font), n.font.color || (n.font.color = n.color), n.font.lineHeight || (n.font.lineHeight = Math.round(1.15 * n.font.size)));
                for (a = nt.yaxes.length || 1, o = 0; a > o; ++o)
                    n = nt.yaxes[o], n && !n.tickColor && (n.tickColor = n.color), n = t.extend(!0, {}, nt.yaxis, n), nt.yaxes[o] = n, n.font && (n.font = t.extend({}, c, n.font), n.font.color || (n.font.color = n.color), n.font.lineHeight || (n.font.lineHeight = Math.round(1.15 * n.font.size)));
                for (nt.xaxis.noTicks && null == nt.xaxis.ticks && (nt.xaxis.ticks = nt.xaxis.noTicks), nt.yaxis.noTicks && null == nt.yaxis.ticks && (nt.yaxis.ticks = nt.yaxis.noTicks), nt.x2axis && (nt.xaxes[1] = t.extend(!0, {}, nt.xaxis, nt.x2axis), nt.xaxes[1].position = "top", null == nt.x2axis.min && (nt.xaxes[1].min = null), null == nt.x2axis.max && (nt.xaxes[1].max = null)), nt.y2axis && (nt.yaxes[1] = t.extend(!0, {}, nt.yaxis, nt.y2axis), nt.yaxes[1].position = "right", null == nt.y2axis.min && (nt.yaxes[1].min = null), null == nt.y2axis.max && (nt.yaxes[1].max = null)), nt.grid.coloredAreas && (nt.grid.markings = nt.grid.coloredAreas), nt.grid.coloredAreasColor && (nt.grid.markingsColor = nt.grid.coloredAreasColor), nt.lines && t.extend(!0, nt.series.lines, nt.lines), nt.points && t.extend(!0, nt.series.points, nt.points), nt.bars && t.extend(!0, nt.series.bars, nt.bars), null != nt.shadowSize && (nt.series.shadowSize = nt.shadowSize), null != nt.highlightColor && (nt.series.highlightColor = nt.highlightColor), o = 0; o < nt.xaxes.length; ++o)
                    x(ht, o + 1).options = nt.xaxes[o];
                for (o = 0; o < nt.yaxes.length; ++o)
                    x(ft, o + 1).options = nt.yaxes[o];
                for (var h in mt)
                    nt.hooks[h] && nt.hooks[h].length && (mt[h] = mt[h].concat(nt.hooks[h]));
                l(mt.processOptions, [nt])
            }
            function h(t) {
                ot = f(t), g(), b()
            }
            function f(i) {
                for (var e = [], o = 0; o < i.length; ++o) {
                    var n = t.extend(!0, {}, nt.series);
                    null != i[o].data ? (n.data = i[o].data, delete i[o].data, t.extend(!0, n, i[o]), i[o].data = n.data) : n.data = i[o], e.push(n)
                }
                return e
            }
            function u(t, i) {
                var e = t[i + "axis"];
                return"object" == typeof e && (e = e.n), "number" != typeof e && (e = 1), e
            }
            function d() {
                return t.grep(ht.concat(ft), function (t) {
                    return t
                })
            }
            function p(t) {
                var i, e, o = {};
                for (i = 0; i < ht.length; ++i)
                    e = ht[i], e && e.used && (o["x" + e.n] = e.c2p(t.left));
                for (i = 0; i < ft.length; ++i)
                    e = ft[i], e && e.used && (o["y" + e.n] = e.c2p(t.top));
                return void 0 !== o.x1 && (o.x = o.x1), void 0 !== o.y1 && (o.y = o.y1), o
            }
            function m(t) {
                var i, e, o, n = {};
                for (i = 0; i < ht.length; ++i)
                    if (e = ht[i], e && e.used && (o = "x" + e.n, null == t[o] && 1 == e.n && (o = "x"), null != t[o])) {
                        n.left = e.p2c(t[o]);
                        break
                    }
                for (i = 0; i < ft.length; ++i)
                    if (e = ft[i], e && e.used && (o = "y" + e.n, null == t[o] && 1 == e.n && (o = "y"), null != t[o])) {
                        n.top = e.p2c(t[o]);
                        break
                    }
                return n
            }
            function x(i, e) {
                return i[e - 1] || (i[e - 1] = {n: e, direction: i == ht ? "x" : "y", options: t.extend(!0, {}, i == ht ? nt.xaxis : nt.yaxis)}), i[e - 1]
            }
            function g() {
                var i, e = ot.length, o = -1;
                for (i = 0; i < ot.length; ++i) {
                    var n = ot[i].color;
                    null != n && (e--, "number" == typeof n && n > o && (o = n))
                }
                o >= e && (e = o + 1);
                var a, r = [], l = nt.colors, s = l.length, c = 0;
                for (i = 0; e > i; i++)
                    a = t.color.parse(l[i % s] || "#666"), i % s == 0 && i && (c = c >= 0 ? .5 > c ? -c - .2 : 0 : -c), r[i] = a.scale("rgb", 1 + c);
                var h, f = 0;
                for (i = 0; i < ot.length; ++i) {
                    if (h = ot[i], null == h.color ? (h.color = r[f].toString(), ++f) : "number" == typeof h.color && (h.color = r[h.color].toString()), null == h.lines.show) {
                        var d, p = !0;
                        for (d in h)
                            if (h[d] && h[d].show) {
                                p = !1;
                                break
                            }
                        p && (h.lines.show = !0)
                    }
                    null == h.lines.zero && (h.lines.zero = !!h.lines.fill), h.xaxis = x(ht, u(h, "x")), h.yaxis = x(ft, u(h, "y"))
                }
            }
            function b() {
                function i(t, i, e) {
                    i < t.datamin && i != -b && (t.datamin = i), e > t.datamax && e != b && (t.datamax = e)
                }
                var e, o, n, a, r, s, c, h, f, u, p, m, x = Number.POSITIVE_INFINITY, g = Number.NEGATIVE_INFINITY, b = Number.MAX_VALUE;
                for (t.each(d(), function(t, i){i.datamin = x, i.datamax = g, i.used = !1}), e = 0; e < ot.length; ++e)
                    r = ot[e], r.datapoints = {points: []}, l(mt.processRawData, [r, r.data, r.datapoints]);
                for (e = 0; e < ot.length; ++e) {
                    if (r = ot[e], p = r.data, m = r.datapoints.format, !m) {
                        if (m = [], m.push({x: !0, number: !0, required: !0}), m.push({y: !0, number: !0, required: !0}), r.bars.show || r.lines.show && r.lines.fill) {
                            var v = !!(r.bars.show && r.bars.zero || r.lines.show && r.lines.zero);
                            m.push({y: !0, number: !0, required: !1, defaultValue: 0, autoscale: v}), r.bars.horizontal && (delete m[m.length - 1].y, m[m.length - 1].x = !0)
                        }
                        r.datapoints.format = m
                    }
                    if (null == r.datapoints.pointsize) {
                        r.datapoints.pointsize = m.length, c = r.datapoints.pointsize, s = r.datapoints.points;
                        var k = r.lines.show && r.lines.steps;
                        for (r.xaxis.used = r.yaxis.used = !0, o = n = 0; o < p.length; ++o, n += c) {
                            u = p[o];
                            var y = null == u;
                            if (!y)
                                for (a = 0; c > a; ++a)
                                    h = u[a], f = m[a], f && (f.number && null != h && (h = +h, isNaN(h) ? h = null : h == 1 / 0 ? h = b : h == -(1 / 0) && (h = -b)), null == h && (f.required && (y = !0), null != f.defaultValue && (h = f.defaultValue))), s[n + a] = h;
                            if (y)
                                for (a = 0; c > a; ++a)
                                    h = s[n + a], null != h && (f = m[a], f.autoscale !== !1 && (f.x && i(r.xaxis, h, h), f.y && i(r.yaxis, h, h))), s[n + a] = null;
                            else if (k && n > 0 && null != s[n - c] && s[n - c] != s[n] && s[n - c + 1] != s[n + 1]) {
                                for (a = 0; c > a; ++a)
                                    s[n + c + a] = s[n + a];
                                s[n + 1] = s[n - c + 1], n += c
                            }
                        }
                    }
                }
                for (e = 0; e < ot.length; ++e)
                    r = ot[e], l(mt.processDatapoints, [r, r.datapoints]);
                for (e = 0; e < ot.length; ++e) {
                    r = ot[e], s = r.datapoints.points, c = r.datapoints.pointsize, m = r.datapoints.format;
                    var w = x, M = x, T = g, C = g;
                    for (o = 0; o < s.length; o += c)
                        if (null != s[o])
                            for (a = 0; c > a; ++a)
                                h = s[o + a], f = m[a], f && f.autoscale !== !1 && h != b && h != -b && (f.x && (w > h && (w = h), h > T && (T = h)), f.y && (M > h && (M = h), h > C && (C = h)));
                    if (r.bars.show) {
                        var S;
                        switch (r.bars.align) {
                            case"left":
                                S = 0;
                                break;
                                case"right":
                                S = -r.bars.barWidth;
                                break;
                                default:
                                S = -r.bars.barWidth / 2
                            }
                        r.bars.horizontal ? (M += S, C += S + r.bars.barWidth) : (w += S, T += S + r.bars.barWidth)
                    }
                    i(r.xaxis, w, T), i(r.yaxis, M, C)
                }
                t.each(d(), function (t, i) {
                    i.datamin == x && (i.datamin = null), i.datamax == g && (i.datamax = null)
                })
            }
            function v() {
                e.css("padding", 0).children().filter(function () {
                    return!t(this).hasClass("flot-overlay") && !t(this).hasClass("flot-base")
                }).remove(), "static" == e.css("position") && e.css("position", "relative"), at = new i("flot-base", e), rt = new i("flot-overlay", e), st = at.context, ct = rt.context, lt = t(rt.element).unbind();
                var o = e.data("plot");
                o && (o.shutdown(), rt.clear()), e.data("plot", xt)
            }
            function k() {
                nt.grid.hoverable && (lt.mousemove(X), lt.bind("mouseleave", Y)), nt.grid.clickable && lt.click(q), l(mt.bindEvents, [lt])
            }
            function y() {
                bt && clearTimeout(bt), lt.unbind("mousemove", X), lt.unbind("mouseleave", Y), lt.unbind("click", q), l(mt.shutdown, [lt])
            }
            function w(t) {
                function i(t) {
                    return t
                }
                var e, o, n = t.options.transform || i, a = t.options.inverseTransform;
                "x" == t.direction ? (e = t.scale = dt / Math.abs(n(t.max) - n(t.min)), o = Math.min(n(t.max), n(t.min))) : (e = t.scale = pt / Math.abs(n(t.max) - n(t.min)), e = -e, o = Math.max(n(t.max), n(t.min))), n == i ? t.p2c = function (t) {
                    return(t - o) * e
                } : t.p2c = function (t) {
                    return(n(t) - o) * e
                }, a ? t.c2p = function (t) {
                    return a(o + t / e)
                } : t.c2p = function (t) {
                    return o + t / e
                }
            }
            function M(t) {
                for (var i = t.options, e = t.ticks || [], o = i.labelWidth || 0, n = i.labelHeight || 0, a = o || ("x" == t.direction ? Math.floor(at.width / (e.length || 1)) : null), r = t.direction + "Axis " + t.direction + t.n + "Axis", l = "flot-" + t.direction + "-axis flot-" + t.direction + t.n + "-axis " + r, s = i.font || "flot-tick-label tickLabel", c = 0; c < e.length; ++c) {
                    var h = e[c];
                    if (h.label) {
                        var f = at.getTextInfo(l, h.label, s, null, a);
                        o = Math.max(o, f.width), n = Math.max(n, f.height)
                    }
                }
                t.labelWidth = i.labelWidth || o, t.labelHeight = i.labelHeight || n
            }
            function T(i) {
                var e = i.labelWidth, o = i.labelHeight, n = i.options.position, a = "x" === i.direction, r = i.options.tickLength, l = nt.grid.axisMargin, s = nt.grid.labelMargin, c = !0, h = !0, f = !0, u = !1;
                t.each(a ? ht : ft, function (t, e) {
                    e && (e.show || e.reserveSpace) && (e === i ? u = !0 : e.options.position === n && (u ? h = !1 : c = !1), u || (f = !1))
                }), h && (l = 0), null == r && (r = f ? "full" : 5), isNaN(+r) || (s += +r), a ? (o += s, "bottom" == n ? (ut.bottom += o + l, i.box = {top: at.height - ut.bottom, height: o}) : (i.box = {top: ut.top + l, height: o}, ut.top += o + l)) : (e += s, "left" == n ? (i.box = {left: ut.left + l, width: e}, ut.left += e + l) : (ut.right += e + l, i.box = {left: at.width - ut.right, width: e})), i.position = n, i.tickLength = r, i.box.padding = s, i.innermost = c
            }
            function C(t) {
                "x" == t.direction ? (t.box.left = ut.left - t.labelWidth / 2, t.box.width = at.width - ut.left - ut.right + t.labelWidth) : (t.box.top = ut.top - t.labelHeight / 2, t.box.height = at.height - ut.bottom - ut.top + t.labelHeight)
            }
            function S() {
                var i, e = nt.grid.minBorderMargin;
                if (null == e)
                    for (e = 0, i = 0; i < ot.length; ++i)
                        e = Math.max(e, 2 * (ot[i].points.radius + ot[i].points.lineWidth / 2));
                var o = {left: e, right: e, top: e, bottom: e};
                t.each(d(), function (t, i) {
                    i.reserveSpace && i.ticks && i.ticks.length && ("x" === i.direction ? (o.left = Math.max(o.left, i.labelWidth / 2), o.right = Math.max(o.right, i.labelWidth / 2)) : (o.bottom = Math.max(o.bottom, i.labelHeight / 2), o.top = Math.max(o.top, i.labelHeight / 2)))
                }), ut.left = Math.ceil(Math.max(o.left, ut.left)), ut.right = Math.ceil(Math.max(o.right, ut.right)), ut.top = Math.ceil(Math.max(o.top, ut.top)), ut.bottom = Math.ceil(Math.max(o.bottom, ut.bottom))
            }
            function W() {
                var i, e = d(), o = nt.grid.show;
                for (var n in ut) {
                    var a = nt.grid.margin || 0;
                    ut[n] = "number" == typeof a ? a : a[n] || 0
                }
                l(mt.processOffset, [ut]);
                for (var n in ut)
                    "object" == typeof nt.grid.borderWidth ? ut[n] += o ? nt.grid.borderWidth[n] : 0 : ut[n] += o ? nt.grid.borderWidth : 0;
                if (t.each(e, function (t, i) {
                    var e = i.options;
                    i.show = null == e.show ? i.used : e.show, i.reserveSpace = null == e.reserveSpace ? i.show : e.reserveSpace, z(i)
                }), o) {
                    var r = t.grep(e, function (t) {
                        return t.show || t.reserveSpace
                    });
                    for (t.each(r, function(t, i){I(i), A(i), F(i, i.ticks), M(i)}), i = r.length - 1; i >= 0; --i)
                        T(r[i]);
                    S(), t.each(r, function (t, i) {
                        C(i)
                    })
                }
                dt = at.width - ut.left - ut.right, pt = at.height - ut.bottom - ut.top, t.each(e, function (t, i) {
                    w(i)
                }), o && O(), _()
            }
            function z(t) {
                var i = t.options, e = +(null != i.min ? i.min : t.datamin), o = +(null != i.max ? i.max : t.datamax), n = o - e;
                if (0 == n) {
                    var a = 0 == o ? 1 : .01;
                    null == i.min && (e -= a), (null == i.max || null != i.min) && (o += a)
                } else {
                    var r = i.autoscaleMargin;
                    null != r && (null == i.min && (e -= n * r, 0 > e && null != t.datamin && t.datamin >= 0 && (e = 0)), null == i.max && (o += n * r, o > 0 && null != t.datamax && t.datamax <= 0 && (o = 0)))
                }
                t.min = e, t.max = o
            }
            function I(i) {
                var e, n = i.options;
                e = "number" == typeof n.ticks && n.ticks > 0 ? n.ticks : .3 * Math.sqrt("x" == i.direction ? at.width : at.height);
                var a = (i.max - i.min) / e, r = -Math.floor(Math.log(a) / Math.LN10), l = n.tickDecimals;
                null != l && r > l && (r = l);
                var s, c = Math.pow(10, -r), h = a / c;
                if (1.5 > h ? s = 1 : 3 > h ? (s = 2, h > 2.25 && (null == l || l >= r + 1) && (s = 2.5, ++r)) : s = 7.5 > h ? 5 : 10, s *= c, null != n.minTickSize && s < n.minTickSize && (s = n.minTickSize), i.delta = a, i.tickDecimals = Math.max(0, null != l ? l : r), i.tickSize = n.tickSize || s, "time" == n.mode && !i.tickGenerator)
                    throw new Error("Time mode requires the flot.time plugin.");
                if (i.tickGenerator || (i.tickGenerator = function (t) {
                    var i, e = [], n = o(t.min, t.tickSize), a = 0, r = Number.NaN;
                    do
                        i = r, r = n + a * t.tickSize, e.push(r), ++a;
                    while (r < t.max && r != i);
                    return e
                }, i.tickFormatter = function (t, i) {
                    var e = i.tickDecimals ? Math.pow(10, i.tickDecimals) : 1, o = "" + Math.round(t * e) / e;
                    if (null != i.tickDecimals) {
                        var n = o.indexOf("."), a = -1 == n ? 0 : o.length - n - 1;
                        if (a < i.tickDecimals)
                            return(a ? o : o + ".") + ("" + e).substr(1, i.tickDecimals - a)
                    }
                    return o
                }), t.isFunction(n.tickFormatter) && (i.tickFormatter = function (t, i) {
                    return"" + n.tickFormatter(t, i)
                }), null != n.alignTicksWithAxis) {
                    var f = ("x" == i.direction ? ht : ft)[n.alignTicksWithAxis - 1];
                    if (f && f.used && f != i) {
                        var u = i.tickGenerator(i);
                        if (u.length > 0 && (null == n.min && (i.min = Math.min(i.min, u[0])), null == n.max && u.length > 1 && (i.max = Math.max(i.max, u[u.length - 1]))), i.tickGenerator = function (t) {
                            var i, e, o = [];
                            for (e = 0; e < f.ticks.length; ++e)
                                i = (f.ticks[e].v - f.min) / (f.max - f.min), i = t.min + i * (t.max - t.min), o.push(i);
                            return o
                        }, !i.mode && null == n.tickDecimals) {
                            var d = Math.max(0, -Math.floor(Math.log(i.delta) / Math.LN10) + 1), p = i.tickGenerator(i);
                            p.length > 1 && /\..*0$/.test((p[1] - p[0]).toFixed(d)) || (i.tickDecimals = d)
                        }
                    }
                }
            }
            function A(i) {
                var e = i.options.ticks, o = [];
                null == e || "number" == typeof e && e > 0 ? o = i.tickGenerator(i) : e && (o = t.isFunction(e) ? e(i) : e);
                var n, a;
                for (i.ticks = [], n = 0; n < o.length; ++n) {
                    var r = null, l = o[n];
                    "object" == typeof l ? (a = +l[0], l.length > 1 && (r = l[1])) : a = +l, null == r && (r = i.tickFormatter(a, i)), isNaN(a) || i.ticks.push({v: a, label: r})
                }
            }
            function F(t, i) {
                t.options.autoscaleMargin && i.length > 0 && (null == t.options.min && (t.min = Math.min(t.min, i[0].v)), null == t.options.max && i.length > 1 && (t.max = Math.max(t.max, i[i.length - 1].v)))
            }
            function P() {
                at.clear(), l(mt.drawBackground, [st]);
                var t = nt.grid;
                t.show && t.backgroundColor && D(), t.show && !t.aboveData && L();
                for (var i = 0; i < ot.length; ++i)
                    l(mt.drawSeries, [st, ot[i]]), R(ot[i]);
                l(mt.draw, [st]), t.show && t.aboveData && L(), at.render(), U()
            }
            function N(t, i) {
                for (var e, o, n, a, r = d(), l = 0; l < r.length; ++l)
                    if (e = r[l], e.direction == i && (a = i + e.n + "axis", t[a] || 1 != e.n || (a = i + "axis"), t[a])) {
                        o = t[a].from, n = t[a].to;
                        break
                    }
                if (t[a] || (e = "x" == i ? ht[0] : ft[0], o = t[i + "1"], n = t[i + "2"]), null != o && null != n && o > n) {
                    var s = o;
                    o = n, n = s
                }
                return{from: o, to: n, axis: e}
            }
            function D() {
                st.save(), st.translate(ut.left, ut.top), st.fillStyle = et(nt.grid.backgroundColor, pt, 0, "rgba(255, 255, 255, 0)"), st.fillRect(0, 0, dt, pt), st.restore()
            }
            function L() {
                var i, e, o, n;
                st.save(), st.translate(ut.left, ut.top);
                var a = nt.grid.markings;
                if (a)
                    for (t.isFunction(a) && (e = xt.getAxes(), e.xmin = e.xaxis.min, e.xmax = e.xaxis.max, e.ymin = e.yaxis.min, e.ymax = e.yaxis.max, a = a(e)), i = 0; i < a.length; ++i) {
                        var r = a[i], l = N(r, "x"), s = N(r, "y");
                        if (null == l.from && (l.from = l.axis.min), null == l.to && (l.to = l.axis.max), null == s.from && (s.from = s.axis.min), null == s.to && (s.to = s.axis.max), !(l.to < l.axis.min || l.from > l.axis.max || s.to < s.axis.min || s.from > s.axis.max)) {
                            l.from = Math.max(l.from, l.axis.min), l.to = Math.min(l.to, l.axis.max), s.from = Math.max(s.from, s.axis.min), s.to = Math.min(s.to, s.axis.max);
                            var c = l.from === l.to, h = s.from === s.to;
                            if (!c || !h)
                                if (l.from = Math.floor(l.axis.p2c(l.from)), l.to = Math.floor(l.axis.p2c(l.to)), s.from = Math.floor(s.axis.p2c(s.from)), s.to = Math.floor(s.axis.p2c(s.to)), c || h) {
                                    var f = r.lineWidth || nt.grid.markingsLineWidth, u = f % 2 ? .5 : 0;
                                    st.beginPath(), st.strokeStyle = r.color || nt.grid.markingsColor, st.lineWidth = f, c ? (st.moveTo(l.to + u, s.from), st.lineTo(l.to + u, s.to)) : (st.moveTo(l.from, s.to + u), st.lineTo(l.to, s.to + u)), st.stroke()
                                } else
                                    st.fillStyle = r.color || nt.grid.markingsColor, st.fillRect(l.from, s.to, l.to - l.from, s.from - s.to)
                        }
                    }
                e = d(), o = nt.grid.borderWidth;
                for (var p = 0; p < e.length; ++p) {
                    var m, x, g, b, v = e[p], k = v.box, y = v.tickLength;
                    if (v.show && 0 != v.ticks.length) {
                        for (st.lineWidth = 1, "x" == v.direction ? (m = 0, x = "full" == y ? "top" == v.position ? 0 : pt : k.top - ut.top + ("top" == v.position ? k.height : 0)) : (x = 0, m = "full" == y ? "left" == v.position ? 0 : dt : k.left - ut.left + ("left" == v.position ? k.width : 0)), v.innermost || (st.strokeStyle = v.options.color, st.beginPath(), g = b = 0, "x" == v.direction ? g = dt + 1 : b = pt + 1, 1 == st.lineWidth && ("x" == v.direction ? x = Math.floor(x) + .5 : m = Math.floor(m) + .5), st.moveTo(m, x), st.lineTo(m + g, x + b), st.stroke()), st.strokeStyle = v.options.tickColor, st.beginPath(), i = 0; i < v.ticks.length; ++i) {
                            var w = v.ticks[i].v;
                            g = b = 0, isNaN(w) || w < v.min || w > v.max || "full" == y && ("object" == typeof o && o[v.position] > 0 || o > 0) && (w == v.min || w == v.max) || ("x" == v.direction ? (m = v.p2c(w), b = "full" == y ? -pt : y, "top" == v.position && (b = -b)) : (x = v.p2c(w), g = "full" == y ? -dt : y, "left" == v.position && (g = -g)), 1 == st.lineWidth && ("x" == v.direction ? m = Math.floor(m) + .5 : x = Math.floor(x) + .5), st.moveTo(m, x), st.lineTo(m + g, x + b))
                        }
                        st.stroke()
                    }
                }
                o && (n = nt.grid.borderColor, "object" == typeof o || "object" == typeof n ? ("object" != typeof o && (o = {top: o, right: o, bottom: o, left: o}), "object" != typeof n && (n = {top: n, right: n, bottom: n, left: n}), o.top > 0 && (st.strokeStyle = n.top, st.lineWidth = o.top, st.beginPath(), st.moveTo(0 - o.left, 0 - o.top / 2), st.lineTo(dt, 0 - o.top / 2), st.stroke()), o.right > 0 && (st.strokeStyle = n.right, st.lineWidth = o.right, st.beginPath(), st.moveTo(dt + o.right / 2, 0 - o.top), st.lineTo(dt + o.right / 2, pt), st.stroke()), o.bottom > 0 && (st.strokeStyle = n.bottom, st.lineWidth = o.bottom, st.beginPath(), st.moveTo(dt + o.right, pt + o.bottom / 2), st.lineTo(0, pt + o.bottom / 2), st.stroke()), o.left > 0 && (st.strokeStyle = n.left, st.lineWidth = o.left, st.beginPath(), st.moveTo(0 - o.left / 2, pt + o.bottom), st.lineTo(0 - o.left / 2, 0), st.stroke())) : (st.lineWidth = o, st.strokeStyle = nt.grid.borderColor, st.strokeRect(-o / 2, -o / 2, dt + o, pt + o))), st.restore()
            }
            function O() {
                t.each(d(), function (t, i) {
                    var e, o, n, a, r, l = i.box, s = i.direction + "Axis " + i.direction + i.n + "Axis", c = "flot-" + i.direction + "-axis flot-" + i.direction + i.n + "-axis " + s, h = i.options.font || "flot-tick-label tickLabel";
                    if (at.removeText(c), i.show && 0 != i.ticks.length)
                        for (var f = 0; f < i.ticks.length; ++f)
                            e = i.ticks[f], !e.label || e.v < i.min || e.v > i.max || ("x" == i.direction ? (a = "center", o = ut.left + i.p2c(e.v), "bottom" == i.position ? n = l.top + l.padding : (n = l.top + l.height - l.padding, r = "bottom")) : (r = "middle", n = ut.top + i.p2c(e.v), "left" == i.position ? (o = l.left + l.width - l.padding, a = "right") : o = l.left + l.padding), at.addText(c, o, n, e.label, h, null, null, a, r))
                })
            }
            function R(t) {
                t.lines.show && H(t), t.bars.show && B(t), t.points.show && j(t)
            }
            function H(t) {
                function i(t, i, e, o, n) {
                    var a = t.points, r = t.pointsize, l = null, s = null;
                    st.beginPath();
                    for (var c = r; c < a.length; c += r) {
                        var h = a[c - r], f = a[c - r + 1], u = a[c], d = a[c + 1];
                        if (null != h && null != u) {
                            if (d >= f && f < n.min) {
                                if (d < n.min)
                                    continue;
                                h = (n.min - f) / (d - f) * (u - h) + h, f = n.min
                            } else if (f >= d && d < n.min) {
                                if (f < n.min)
                                    continue;
                                u = (n.min - f) / (d - f) * (u - h) + h, d = n.min
                            }
                            if (f >= d && f > n.max) {
                                if (d > n.max)
                                    continue;
                                h = (n.max - f) / (d - f) * (u - h) + h, f = n.max
                            } else if (d >= f && d > n.max) {
                                if (f > n.max)
                                    continue;
                                u = (n.max - f) / (d - f) * (u - h) + h, d = n.max
                            }
                            if (u >= h && h < o.min) {
                                if (u < o.min)
                                    continue;
                                f = (o.min - h) / (u - h) * (d - f) + f, h = o.min
                            } else if (h >= u && u < o.min) {
                                if (h < o.min)
                                    continue;
                                d = (o.min - h) / (u - h) * (d - f) + f, u = o.min
                            }
                            if (h >= u && h > o.max) {
                                if (u > o.max)
                                    continue;
                                f = (o.max - h) / (u - h) * (d - f) + f, h = o.max
                            } else if (u >= h && u > o.max) {
                                if (h > o.max)
                                    continue;
                                d = (o.max - h) / (u - h) * (d - f) + f, u = o.max
                            }
                            (h != l || f != s) && st.moveTo(o.p2c(h) + i, n.p2c(f) + e), l = u, s = d, st.lineTo(o.p2c(u) + i, n.p2c(d) + e)
                        }
                    }
                    st.stroke()
                }
                function e(t, i, e) {
                    for (var o = t.points, n = t.pointsize, a = Math.min(Math.max(0, e.min), e.max), r = 0, l = !1, s = 1, c = 0, h = 0; ; ) {
                        if (n > 0 && r > o.length + n)
                            break;
                        r += n;
                        var f = o[r - n], u = o[r - n + s], d = o[r], p = o[r + s];
                        if (l) {
                            if (n > 0 && null != f && null == d) {
                                h = r, n = -n, s = 2;
                                continue
                            }
                            if (0 > n && r == c + n) {
                                st.fill(), l = !1, n = -n, s = 1, r = c = h + n;
                                continue
                            }
                        }
                        if (null != f && null != d) {
                            if (d >= f && f < i.min) {
                                if (d < i.min)
                                    continue;
                                u = (i.min - f) / (d - f) * (p - u) + u, f = i.min
                            } else if (f >= d && d < i.min) {
                                if (f < i.min)
                                    continue;
                                p = (i.min - f) / (d - f) * (p - u) + u, d = i.min
                            }
                            if (f >= d && f > i.max) {
                                if (d > i.max)
                                    continue;
                                u = (i.max - f) / (d - f) * (p - u) + u, f = i.max
                            } else if (d >= f && d > i.max) {
                                if (f > i.max)
                                    continue;
                                p = (i.max - f) / (d - f) * (p - u) + u, d = i.max
                            }
                            if (l || (st.beginPath(), st.moveTo(i.p2c(f), e.p2c(a)), l = !0), u >= e.max && p >= e.max)
                                st.lineTo(i.p2c(f), e.p2c(e.max)), st.lineTo(i.p2c(d), e.p2c(e.max));
                            else if (u <= e.min && p <= e.min)
                                st.lineTo(i.p2c(f), e.p2c(e.min)), st.lineTo(i.p2c(d), e.p2c(e.min));
                            else {
                                var m = f, x = d;
                                p >= u && u < e.min && p >= e.min ? (f = (e.min - u) / (p - u) * (d - f) + f, u = e.min) : u >= p && p < e.min && u >= e.min && (d = (e.min - u) / (p - u) * (d - f) + f, p = e.min), u >= p && u > e.max && p <= e.max ? (f = (e.max - u) / (p - u) * (d - f) + f, u = e.max) : p >= u && p > e.max && u <= e.max && (d = (e.max - u) / (p - u) * (d - f) + f, p = e.max), f != m && st.lineTo(i.p2c(m), e.p2c(u)), st.lineTo(i.p2c(f), e.p2c(u)), st.lineTo(i.p2c(d), e.p2c(p)), d != x && (st.lineTo(i.p2c(d), e.p2c(p)), st.lineTo(i.p2c(x), e.p2c(p)))
                            }
                        }
                    }
                }
                st.save(), st.translate(ut.left, ut.top), st.lineJoin = "round";
                var o = t.lines.lineWidth, n = t.shadowSize;
                if (o > 0 && n > 0) {
                    st.lineWidth = n, st.strokeStyle = "rgba(0,0,0,0.1)";
                    var a = Math.PI / 18;
                    i(t.datapoints, Math.sin(a) * (o / 2 + n / 2), Math.cos(a) * (o / 2 + n / 2), t.xaxis, t.yaxis), st.lineWidth = n / 2, i(t.datapoints, Math.sin(a) * (o / 2 + n / 4), Math.cos(a) * (o / 2 + n / 4), t.xaxis, t.yaxis)
                }
                st.lineWidth = o, st.strokeStyle = t.color;
                var r = G(t.lines, t.color, 0, pt);
                r && (st.fillStyle = r, e(t.datapoints, t.xaxis, t.yaxis)), o > 0 && i(t.datapoints, 0, 0, t.xaxis, t.yaxis), st.restore()
            }
            function j(t) {
                function i(t, i, e, o, n, a, r, l) {
                    for (var s = t.points, c = t.pointsize, h = 0; h < s.length; h += c) {
                        var f = s[h], u = s[h + 1];
                        null == f || f < a.min || f > a.max || u < r.min || u > r.max || (st.beginPath(), f = a.p2c(f), u = r.p2c(u) + o, "circle" == l ? st.arc(f, u, i, 0, n ? Math.PI : 2 * Math.PI, !1) : l(st, f, u, i, n), st.closePath(), e && (st.fillStyle = e, st.fill()), st.stroke())
                    }
                }
                st.save(), st.translate(ut.left, ut.top);
                var e = t.points.lineWidth, o = t.shadowSize, n = t.points.radius, a = t.points.symbol;
                if (0 == e && (e = 1e-4), e > 0 && o > 0) {
                    var r = o / 2;
                    st.lineWidth = r, st.strokeStyle = "rgba(0,0,0,0.1)", i(t.datapoints, n, null, r + r / 2, !0, t.xaxis, t.yaxis, a), st.strokeStyle = "rgba(0,0,0,0.2)", i(t.datapoints, n, null, r / 2, !0, t.xaxis, t.yaxis, a)
                }
                st.lineWidth = e, st.strokeStyle = t.color, i(t.datapoints, n, G(t.points, t.color), 0, !1, t.xaxis, t.yaxis, a), st.restore()
            }
            function E(t, i, e, o, n, a, r, l, s, c, h) {
                var f, u, d, p, m, x, g, b, v;
                c ? (b = x = g = !0, m = !1, f = e, u = t, p = i + o, d = i + n, f > u && (v = u, u = f, f = v, m = !0, x = !1)) : (m = x = g = !0, b = !1, f = t + o, u = t + n, d = e, p = i, d > p && (v = p, p = d, d = v, b = !0, g = !1)), u < r.min || f > r.max || p < l.min || d > l.max || (f < r.min && (f = r.min, m = !1), u > r.max && (u = r.max, x = !1), d < l.min && (d = l.min, b = !1), p > l.max && (p = l.max, g = !1), f = r.p2c(f), d = l.p2c(d), u = r.p2c(u), p = l.p2c(p), a && (s.fillStyle = a(d, p), s.fillRect(f, p, u - f, d - p)), h > 0 && (m || x || g || b) && (s.beginPath(), s.moveTo(f, d), m ? s.lineTo(f, p) : s.moveTo(f, p), g ? s.lineTo(u, p) : s.moveTo(u, p), x ? s.lineTo(u, d) : s.moveTo(u, d), b ? s.lineTo(f, d) : s.moveTo(f, d), s.stroke()))
            }
            function B(t) {
                function i(i, e, o, n, a, r) {
                    for (var l = i.points, s = i.pointsize, c = 0; c < l.length; c += s)
                        null != l[c] && E(l[c], l[c + 1], l[c + 2], e, o, n, a, r, st, t.bars.horizontal, t.bars.lineWidth)
                }
                st.save(), st.translate(ut.left, ut.top), st.lineWidth = t.bars.lineWidth, st.strokeStyle = t.color;
                var e;
                switch (t.bars.align) {
                    case"left":
                        e = 0;
                        break;
                        case"right":
                        e = -t.bars.barWidth;
                        break;
                        default:
                        e = -t.bars.barWidth / 2
                    }
                var o = t.bars.fill ? function (i, e) {
                    return G(t.bars, t.color, i, e)
                } : null;
                i(t.datapoints, e, e + t.bars.barWidth, o, t.xaxis, t.yaxis), st.restore()
            }
            function G(i, e, o, n) {
                var a = i.fill;
                if (!a)
                    return null;
                if (i.fillColor)
                    return et(i.fillColor, o, n, e);
                var r = t.color.parse(e);
                return r.a = "number" == typeof a ? a : .4, r.normalize(), r.toString()
            }
            function _() {
                if (null != nt.legend.container ? t(nt.legend.container).html("") : e.find(".legend").remove(), nt.legend.show) {
                    for (var i, o, n = [], a = [], r = !1, l = nt.legend.labelFormatter, s = 0; s < ot.length; ++s)
                        i = ot[s], i.label && (o = l ? l(i.label, i) : i.label, o && a.push({label: o, color: i.color}));
                    if (nt.legend.sorted)
                        if (t.isFunction(nt.legend.sorted))
                            a.sort(nt.legend.sorted);
                        else if ("reverse" == nt.legend.sorted)
                            a.reverse();
                        else {
                            var c = "descending" != nt.legend.sorted;
                            a.sort(function (t, i) {
                                return t.label == i.label ? 0 : t.label < i.label != c ? 1 : -1
                            })
                        }
                    for (var s = 0; s < a.length; ++s) {
                        var h = a[s];
                        s % nt.legend.noColumns == 0 && (r && n.push("</tr>"), n.push("<tr>"), r = !0), n.push('<td class="legendColorBox"><div style="border:1px solid ' + nt.legend.labelBoxBorderColor + ';padding:1px"><div style="width:4px;height:0;border:5px solid ' + h.color + ';overflow:hidden"></div></div></td><td class="legendLabel">' + h.label + "</td>")
                    }
                    if (r && n.push("</tr>"), 0 != n.length) {
                        var f = '<table style="font-size:smaller;color:' + nt.grid.color + '">' + n.join("") + "</table>";
                        if (null != nt.legend.container)
                            t(nt.legend.container).html(f);
                        else {
                            var u = "", d = nt.legend.position, p = nt.legend.margin;
                            null == p[0] && (p = [p, p]), "n" == d.charAt(0) ? u += "top:" + (p[1] + ut.top) + "px;" : "s" == d.charAt(0) && (u += "bottom:" + (p[1] + ut.bottom) + "px;"), "e" == d.charAt(1) ? u += "right:" + (p[0] + ut.right) + "px;" : "w" == d.charAt(1) && (u += "left:" + (p[0] + ut.left) + "px;");
                            var m = t('<div class="legend">' + f.replace('style="', 'style="position:absolute;' + u + ";") + "</div>").appendTo(e);
                            if (0 != nt.legend.backgroundOpacity) {
                                var x = nt.legend.backgroundColor;
                                null == x && (x = nt.grid.backgroundColor, x = x && "string" == typeof x ? t.color.parse(x) : t.color.extract(m, "background-color"), x.a = 1, x = x.toString());
                                var g = m.children();
                                t('<div style="position:absolute;width:' + g.width() + "px;height:" + g.height() + "px;" + u + "background-color:" + x + ';"> </div>').prependTo(m).css("opacity", nt.legend.backgroundOpacity)
                            }
                        }
                    }
                }
            }
            function V(t, i, e) {
                var o, n, a, r = nt.grid.mouseActiveRadius, l = r * r + 1, s = null;
                for (o = ot.length - 1; o >= 0; --o)
                    if (e(ot[o])) {
                        var c = ot[o], h = c.xaxis, f = c.yaxis, u = c.datapoints.points, d = h.c2p(t), p = f.c2p(i), m = r / h.scale, x = r / f.scale;
                        if (a = c.datapoints.pointsize, h.options.inverseTransform && (m = Number.MAX_VALUE), f.options.inverseTransform && (x = Number.MAX_VALUE), c.lines.show || c.points.show)
                            for (n = 0; n < u.length; n += a) {
                                var g = u[n], b = f.datamin;
                                if (null != g && !(g - d > m || -m > g - d || b - p > x || -x > b - p)) {
                                    var v = Math.abs(h.p2c(g) - t), k = Math.abs(f.p2c(b) - i), y = v * v + k * k;
                                    l > y && (l = y, s = [o, n / a])
                                }
                            }
                        if (c.bars.show && !s) {
                            var w, M;
                            switch (c.bars.align) {
                                case"left":
                                    w = 0;
                                    break;
                                    case"right":
                                    w = -c.bars.barWidth;
                                    break;
                                    default:
                                    w = -c.bars.barWidth / 2
                                }
                            for (M = w + c.bars.barWidth, n = 0; n < u.length; n += a) {
                                var g = u[n], b = u[n + 1], T = u[n + 2];
                                null != g && (ot[o].bars.horizontal ? d <= Math.max(T, g) && d >= Math.min(T, g) && p >= b + w && b + M >= p : d >= g + w && g + M >= d && p >= Math.min(T, b) && p <= Math.max(T, b)) && (s = [o, n / a])
                            }
                        }
                    }
                return s ? (o = s[0], n = s[1], a = ot[o].datapoints.pointsize, {datapoint: ot[o].datapoints.points.slice(n * a, (n + 1) * a), dataIndex: n, series: ot[o], seriesIndex: o}) : null
            }
            function X(t) {
                nt.grid.hoverable && Q("plothover", t, function (t) {
                    return 0 != t.hoverable
                })
            }
            function Y(t) {
                nt.grid.hoverable && Q("plothover", t, function (t) {
                    return!1
                })
            }
            function q(t) {
                Q("plotclick", t, function (t) {
                    return 0 != t.clickable
                })
            }
            function Q(t, i, o) {
                var n = lt.offset(), a = i.pageX - n.left - ut.left, r = i.pageY - n.top - ut.top, l = p({left: a, top: r});
                l.pageX = i.pageX, l.pageY = i.pageY;
                var s = V(a, r, o);
                if (s && (s.pageX = parseInt(s.series.xaxis.p2c(s.datapoint[0]) + n.left + ut.left, 10), s.pageY = parseInt(s.series.yaxis.p2c(s.datapoint[1]) + n.top + ut.top, 10)), nt.grid.autoHighlight) {
                    for (var c = 0; c < gt.length; ++c) {
                        var h = gt[c];
                        h.auto != t || s && h.series == s.series && h.point[0] == s.datapoint[0] && h.point[1] == s.datapoint[1] || K(h.series, h.point)
                    }
                    s && $(s.series, s.datapoint, t)
                }
                e.trigger(t, [l, s])
            }
            function U() {
                var t = nt.interaction.redrawOverlayInterval;
                return-1 == t ? void J() : void(bt || (bt = setTimeout(J, t)))
            }
            function J() {
                bt = null, ct.save(), rt.clear(), ct.translate(ut.left, ut.top);
                var t, i;
                for (t = 0; t < gt.length; ++t)
                    i = gt[t], i.series.bars.show ? it(i.series, i.point) : tt(i.series, i.point);
                ct.restore(), l(mt.drawOverlay, [ct])
            }
            function $(t, i, e) {
                if ("number" == typeof t && (t = ot[t]), "number" == typeof i) {
                    var o = t.datapoints.pointsize;
                    i = t.datapoints.points.slice(o * i, o * (i + 1))
                }
                var n = Z(t, i);
                -1 == n ? (gt.push({series: t, point: i, auto: e}), U()) : e || (gt[n].auto = !1)
            }
            function K(t, i) {
                if (null == t && null == i)
                    return gt = [], void U();
                if ("number" == typeof t && (t = ot[t]), "number" == typeof i) {
                    var e = t.datapoints.pointsize;
                    i = t.datapoints.points.slice(e * i, e * (i + 1))
                }
                var o = Z(t, i);
                -1 != o && (gt.splice(o, 1), U())
            }
            function Z(t, i) {
                for (var e = 0; e < gt.length; ++e) {
                    var o = gt[e];
                    if (o.series == t && o.point[0] == i[0] && o.point[1] == i[1])
                        return e
                }
                return-1
            }
            function tt(i, e) {
                var o = e[0], n = e[1], a = i.xaxis, r = i.yaxis, l = "string" == typeof i.highlightColor ? i.highlightColor : t.color.parse(i.color).scale("a", .5).toString();
                if (!(o < a.min || o > a.max || n < r.min || n > r.max)) {
                    var s = i.points.radius + i.points.lineWidth / 2;
                    ct.lineWidth = s, ct.strokeStyle = l;
                    var c = 1.5 * s;
                    o = a.p2c(o), n = r.p2c(n), ct.beginPath(), "circle" == i.points.symbol ? ct.arc(o, n, c, 0, 2 * Math.PI, !1) : i.points.symbol(ct, o, n, c, !1), ct.closePath(), ct.stroke()
                }
            }
            function it(i, e) {
                var o, n = "string" == typeof i.highlightColor ? i.highlightColor : t.color.parse(i.color).scale("a", .5).toString(), a = n;
                switch (i.bars.align) {
                    case"left":
                        o = 0;
                        break;
                        case"right":
                        o = -i.bars.barWidth;
                        break;
                        default:
                        o = -i.bars.barWidth / 2
                    }
                ct.lineWidth = i.bars.lineWidth, ct.strokeStyle = n, E(e[0], e[1], e[2] || 0, o, o + i.bars.barWidth, function () {
                    return a
                }, i.xaxis, i.yaxis, ct, i.bars.horizontal, i.bars.lineWidth)
            }
            function et(i, e, o, n) {
                if ("string" == typeof i)
                    return i;
                for (var a = st.createLinearGradient(0, o, 0, e), r = 0, l = i.colors.length; l > r; ++r) {
                    var s = i.colors[r];
                    if ("string" != typeof s) {
                        var c = t.color.parse(n);
                        null != s.brightness && (c = c.scale("rgb", s.brightness)), null != s.opacity && (c.a *= s.opacity), s = c.toString()
                    }
                    a.addColorStop(r / (l - 1), s)
                }
                return a
            }
            var ot = [], nt = {colors: ["#edc240", "#afd8f8", "#cb4b4b", "#4da74d", "#9440ed"], legend: {show: !0, noColumns: 1, labelFormatter: null, labelBoxBorderColor: "#ccc", container: null, position: "ne", margin: 5, backgroundColor: null, backgroundOpacity: .85, sorted: null}, xaxis: {show: null, position: "bottom", mode: null, font: null, color: null, tickColor: null, transform: null, inverseTransform: null, min: null, max: null, autoscaleMargin: null, ticks: null, tickFormatter: null, labelWidth: null, labelHeight: null, reserveSpace: null, tickLength: null, alignTicksWithAxis: null, tickDecimals: null, tickSize: null, minTickSize: null}, yaxis: {autoscaleMargin: .02, position: "left"}, xaxes: [], yaxes: [], series: {points: {show: !1, radius: 3, lineWidth: 2, fill: !0, fillColor: "#ffffff", symbol: "circle"}, lines: {lineWidth: 2, fill: !1, fillColor: null, steps: !1}, bars: {show: !1, lineWidth: 2, barWidth: 1,
                        fill: !0, fillColor: null, align: "left", horizontal: !1, zero: !0}, shadowSize: 3, highlightColor: null}, grid: {show: !0, aboveData: !1, color: "#545454", backgroundColor: null, borderColor: null, tickColor: null, margin: 0, labelMargin: 5, axisMargin: 8, borderWidth: 2, minBorderMargin: null, markings: null, markingsColor: "#f4f4f4", markingsLineWidth: 2, clickable: !1, hoverable: !1, autoHighlight: !0, mouseActiveRadius: 10}, interaction: {redrawOverlayInterval: 1e3 / 60}, hooks: {}}, at = null, rt = null, lt = null, st = null, ct = null, ht = [], ft = [], ut = {left: 0, right: 0, top: 0, bottom: 0}, dt = 0, pt = 0, mt = {processOptions: [], processRawData: [], processDatapoints: [], processOffset: [], drawBackground: [], drawSeries: [], draw: [], bindEvents: [], drawOverlay: [], shutdown: []}, xt = this;
            xt.setData = h, xt.setupGrid = W, xt.draw = P, xt.getPlaceholder = function () {
                return e
            }, xt.getCanvas = function () {
                return at.element
            }, xt.getPlotOffset = function () {
                return ut
            }, xt.width = function () {
                return dt
            }, xt.height = function () {
                return pt
            }, xt.offset = function () {
                var t = lt.offset();
                return t.left += ut.left, t.top += ut.top, t
            }, xt.getData = function () {
                return ot
            }, xt.getAxes = function () {
                var i = {};
                return t.each(ht.concat(ft), function (t, e) {
                    e && (i[e.direction + (1 != e.n ? e.n : "") + "axis"] = e)
                }), i
            }, xt.getXAxes = function () {
                return ht
            }, xt.getYAxes = function () {
                return ft
            }, xt.c2p = p, xt.p2c = m, xt.getOptions = function () {
                return nt
            }, xt.highlight = $, xt.unhighlight = K, xt.triggerRedrawOverlay = U, xt.pointOffset = function (t) {
                return{left: parseInt(ht[u(t, "x") - 1].p2c(+t.x) + ut.left, 10), top: parseInt(ft[u(t, "y") - 1].p2c(+t.y) + ut.top, 10)}
            }, xt.shutdown = y, xt.destroy = function () {
                y(), e.removeData("plot").empty(), ot = [], nt = null, at = null, rt = null, lt = null, st = null, ct = null, ht = [], ft = [], mt = null, gt = [], xt = null
            }, xt.resize = function () {
                var t = e.width(), i = e.height();
                at.resize(t, i), rt.resize(t, i)
            }, xt.hooks = mt, s(xt), c(a), v(), h(n), W(), P(), k();
            var gt = [], bt = null
        }
        function o(t, i) {
            return i * Math.floor(t / i)
        }
        var n = Object.prototype.hasOwnProperty;
        t.fn.detach || (t.fn.detach = function () {
            return this.each(function () {
                this.parentNode && this.parentNode.removeChild(this)
            })
        }), i.prototype.resize = function (t, i) {
            if (0 >= t || 0 >= i)
                throw new Error("Invalid dimensions for plot, width = " + t + ", height = " + i);
            var e = this.element, o = this.context, n = this.pixelRatio;
            this.width != t && (e.width = t * n, e.style.width = t + "px", this.width = t), this.height != i && (e.height = i * n, e.style.height = i + "px", this.height = i), o.restore(), o.save(), o.scale(n, n)
        }, i.prototype.clear = function () {
            this.context.clearRect(0, 0, this.width, this.height)
        }, i.prototype.render = function () {
            var t = this._textCache;
            for (var i in t)
                if (n.call(t, i)) {
                    var e = this.getTextLayer(i), o = t[i];
                    e.hide();
                    for (var a in o)
                        if (n.call(o, a)) {
                            var r = o[a];
                            for (var l in r)
                                if (n.call(r, l)) {
                                    for (var s, c = r[l].positions, h = 0; s = c[h]; h++)
                                        s.active ? s.rendered || (e.append(s.element), s.rendered = !0) : (c.splice(h--, 1), s.rendered && s.element.detach());
                                    0 == c.length && delete r[l]
                                }
                        }
                    e.show()
                }
        }, i.prototype.getTextLayer = function (i) {
            var e = this.text[i];
            return null == e && (null == this.textContainer && (this.textContainer = t("<div class='flot-text'></div>").css({position: "absolute", top: 0, left: 0, bottom: 0, right: 0, "font-size": "smaller", color: "#545454"}).insertAfter(this.element)), e = this.text[i] = t("<div></div>").addClass(i).css({position: "absolute", top: 0, left: 0, bottom: 0, right: 0}).appendTo(this.textContainer)), e
        }, i.prototype.getTextInfo = function (i, e, o, n, a) {
            var r, l, s, c;
            if (e = "" + e, r = "object" == typeof o ? o.style + " " + o.variant + " " + o.weight + " " + o.size + "px/" + o.lineHeight + "px " + o.family : o, l = this._textCache[i], null == l && (l = this._textCache[i] = {}), s = l[r], null == s && (s = l[r] = {}), c = s[e], null == c) {
                var h = t("<div></div>").html(e).css({position: "absolute", "max-width": a, top: -9999}).appendTo(this.getTextLayer(i));
                "object" == typeof o ? h.css({font: r, color: o.color}) : "string" == typeof o && h.addClass(o), c = s[e] = {width: h.outerWidth(!0), height: h.outerHeight(!0), element: h, positions: []}, h.detach()
            }
            return c
        }, i.prototype.addText = function (t, i, e, o, n, a, r, l, s) {
            var c = this.getTextInfo(t, o, n, a, r), h = c.positions;
            "center" == l ? i -= c.width / 2 : "right" == l && (i -= c.width), "middle" == s ? e -= c.height / 2 : "bottom" == s && (e -= c.height);
            for (var f, u = 0; f = h[u]; u++)
                if (f.x == i && f.y == e)
                    return void(f.active = !0);
            f = {active: !0, rendered: !1, element: h.length ? c.element.clone() : c.element, x: i, y: e}, h.push(f), f.element.css({top: Math.round(e), left: Math.round(i), "text-align": l})
        }, i.prototype.removeText = function (t, i, e, o, a, r) {
            if (null == o) {
                var l = this._textCache[t];
                if (null != l)
                    for (var s in l)
                        if (n.call(l, s)) {
                            var c = l[s];
                            for (var h in c)
                                if (n.call(c, h))
                                    for (var f, u = c[h].positions, d = 0; f = u[d]; d++)
                                        f.active = !1
                        }
            } else
                for (var f, u = this.getTextInfo(t, o, a, r).positions, d = 0; f = u[d]; d++)
                    f.x == i && f.y == e && (f.active = !1)
        }, t.plot = function (i, o, n) {
            var a = new e(t(i), o, n, t.plot.plugins);
            return a
        }, t.plot.version = "0.8.3", t.plot.plugins = [], t.fn.plot = function (i, e) {
            return this.each(function () {
                t.plot(this, i, e)
            })
        }
    }(jQuery);
//axisLabels 2.0
    !function (t) {
        function i() {
            return!!document.createElement("canvas").getContext
        }
        function e() {
            if (!i())
                return!1;
            var t = document.createElement("canvas"), e = t.getContext("2d");
            return"function" == typeof e.fillText
        }
        function s() {
            var t = document.createElement("div");
            return"undefined" != typeof t.style.MozTransition || "undefined" != typeof t.style.OTransition || "undefined" != typeof t.style.webkitTransition || "undefined" != typeof t.style.transition
        }
        function o(t, i, e, s, o) {
            this.axisName = t, this.position = i, this.padding = e, this.plot = s, this.opts = o, this.width = 0, this.height = 0
        }
        function a(t, i, e, s, a) {
            o.prototype.constructor.call(this, t, i, e, s, a)
        }
        function l(t, i, e, s, a) {
            o.prototype.constructor.call(this, t, i, e, s, a), this.elem = null
        }
        function h(t, i, e, s, o) {
            l.prototype.constructor.call(this, t, i, e, s, o)
        }
        function n(t, i, e, s, o) {
            h.prototype.constructor.call(this, t, i, e, s, o), this.requiresResize = !1
        }
        function r(i) {
            i.hooks.processOptions.push(function (i, o) {
                if (o.axisLabels.show) {
                    var r = !1, p = {}, d = 2;
                    i.hooks.draw.push(function (i, o) {
                        var f = !1;
                        r ? (r = !1, t.each(i.getAxes(), function (t, e) {
                            var s = e.options || i.getOptions()[t];
                            s && s.axisLabel && e.show && p[t].draw(e.box)
                        })) : (t.each(i.getAxes(), function (t, o) {
                            var r = o.options || i.getOptions()[t];
                            if (t in p && (o.labelHeight = o.labelHeight - p[t].height, o.labelWidth = o.labelWidth - p[t].width, r.labelHeight = o.labelHeight, r.labelWidth = o.labelWidth, p[t].cleanup(), delete p[t]), r && r.axisLabel && o.show) {
                                f = !0;
                                var c = null;
                                if (r.axisLabelUseHtml || "Microsoft Internet Explorer" != navigator.appName)
                                    c = r.axisLabelUseHtml || !s() && !e() && !r.axisLabelUseCanvas ? l : r.axisLabelUseCanvas || !s() ? a : h;
                                else {
                                    var b = navigator.userAgent, x = new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");
                                    null != x.exec(b) && (rv = parseFloat(RegExp.$1)), c = rv >= 9 && !r.axisLabelUseCanvas && !r.axisLabelUseHtml ? h : r.axisLabelUseCanvas || r.axisLabelUseHtml ? r.axisLabelUseCanvas ? a : l : n
                                }
                                var g = void 0 === r.axisLabelPadding ? d : r.axisLabelPadding;
                                p[t] = new c(t, o.position, g, i, r), p[t].calculateSize(), r.labelHeight = o.labelHeight + p[t].height, r.labelWidth = o.labelWidth + p[t].width
                            }
                        }), f && (r = !0, i.setupGrid(), i.draw()))
                    })
                }
            })
        }
        var p = {axisLabels: {show: !0}};
        o.prototype.cleanup = function () {}, a.prototype = new o, a.prototype.constructor = a, a.prototype.calculateSize = function () {
            this.opts.axisLabelFontSizePixels || (this.opts.axisLabelFontSizePixels = 14), this.opts.axisLabelFontFamily || (this.opts.axisLabelFontFamily = "sans-serif");
            this.opts.axisLabelFontSizePixels + this.padding, this.opts.axisLabelFontSizePixels + this.padding;
            "left" == this.position || "right" == this.position ? (this.width = this.opts.axisLabelFontSizePixels + this.padding, this.height = 0) : (this.width = 0, this.height = this.opts.axisLabelFontSizePixels + this.padding)
        }, a.prototype.draw = function (t) {
            this.opts.axisLabelColour || (this.opts.axisLabelColour = "black");
            var i = this.plot.getCanvas().getContext("2d");
            i.save(), i.font = this.opts.axisLabelFontSizePixels + "px " + this.opts.axisLabelFontFamily, i.fillStyle = this.opts.axisLabelColour;
            var e, s, o = i.measureText(this.opts.axisLabel).width, a = this.opts.axisLabelFontSizePixels, l = 0;
            "top" == this.position ? (e = t.left + t.width / 2 - o / 2, s = t.top + .72 * a) : "bottom" == this.position ? (e = t.left + t.width / 2 - o / 2, s = t.top + t.height - .72 * a) : "left" == this.position ? (e = t.left + .72 * a, s = t.height / 2 + t.top + o / 2, l = -Math.PI / 2) : "right" == this.position && (e = t.left + t.width - .72 * a, s = t.height / 2 + t.top - o / 2, l = Math.PI / 2), i.translate(e, s), i.rotate(l), i.fillText(this.opts.axisLabel, 0, 0), i.restore()
        }, l.prototype = new o, l.prototype.constructor = l, l.prototype.calculateSize = function () {
            var i = t('<div class="axisLabels" style="position:absolute;">' + this.opts.axisLabel + "</div>");
            this.plot.getPlaceholder().append(i), this.labelWidth = i.outerWidth(!0), this.labelHeight = i.outerHeight(!0), i.remove(), this.width = this.height = 0, "left" == this.position || "right" == this.position ? this.width = this.labelWidth + this.padding : this.height = this.labelHeight + this.padding
        }, l.prototype.cleanup = function () {
            this.elem && this.elem.remove()
        }, l.prototype.draw = function (i) {
            this.plot.getPlaceholder().find("#" + this.axisName + "Label").remove(), this.elem = t('<div id="' + this.axisName + 'Label" " class="axisLabels" style="position:absolute;">' + this.opts.axisLabel + "</div>"), this.plot.getPlaceholder().append(this.elem), "top" == this.position ? (this.elem.css("left", i.left + i.width / 2 - this.labelWidth / 2 + "px"), this.elem.css("top", i.top + "px")) : "bottom" == this.position ? (this.elem.css("left", i.left + i.width / 2 - this.labelWidth / 2 + "px"), this.elem.css("top", i.top + i.height - this.labelHeight + "px")) : "left" == this.position ? (this.elem.css("top", i.top + i.height / 2 - this.labelHeight / 2 + "px"), this.elem.css("left", i.left + "px")) : "right" == this.position && (this.elem.css("top", i.top + i.height / 2 - this.labelHeight / 2 + "px"), this.elem.css("left", i.left + i.width - this.labelWidth + "px"))
        }, h.prototype = new l, h.prototype.constructor = h, h.prototype.calculateSize = function () {
            l.prototype.calculateSize.call(this), this.width = this.height = 0, "left" == this.position || "right" == this.position ? this.width = this.labelHeight + this.padding : this.height = this.labelHeight + this.padding
        }, h.prototype.transforms = function (t, i, e) {
            var s = {"-moz-transform": "", "-webkit-transform": "", "-o-transform": "", "-ms-transform": ""};
            if (0 != i || 0 != e) {
                var o = " translate(" + i + "px, " + e + "px)";
                s["-moz-transform"] += o, s["-webkit-transform"] += o, s["-o-transform"] += o, s["-ms-transform"] += o
            }
            if (0 != t) {
                var a = " rotate(" + t + "deg)";
                s["-moz-transform"] += a, s["-webkit-transform"] += a, s["-o-transform"] += a, s["-ms-transform"] += a
            }
            var l = "top: 0; left: 0; ";
            for (var h in s)
                s[h] && (l += h + ":" + s[h] + ";");
            return l += ";"
        }, h.prototype.calculateOffsets = function (t) {
            var i = {x: 0, y: 0, degrees: 0};
            return"bottom" == this.position ? (i.x = t.left + t.width / 2 - this.labelWidth / 2, i.y = t.top + t.height - this.labelHeight) : "top" == this.position ? (i.x = t.left + t.width / 2 - this.labelWidth / 2, i.y = t.top) : "left" == this.position ? (i.degrees = -90, i.x = t.left - this.labelWidth / 2 + this.labelHeight / 2, i.y = t.height / 2 + t.top) : "right" == this.position && (i.degrees = 90, i.x = t.left + t.width - this.labelWidth / 2 - this.labelHeight / 2, i.y = t.height / 2 + t.top), i.x = Math.round(i.x), i.y = Math.round(i.y), i
        }, h.prototype.draw = function (i) {
            this.plot.getPlaceholder().find("." + this.axisName + "Label").remove();
            var e = this.calculateOffsets(i);
            this.elem = t('<div class="axisLabels ' + this.axisName + 'Label" style="position:absolute; ' + this.transforms(e.degrees, e.x, e.y) + '">' + this.opts.axisLabel + "</div>"), this.plot.getPlaceholder().append(this.elem)
        }, n.prototype = new h, n.prototype.constructor = n, n.prototype.transforms = function (t, i, e) {
            var s = "";
            if (0 != t) {
                for (var o = t / 90; 0 > o; )
                    o += 4;
                s += " filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=" + o + "); ", this.requiresResize = "right" == this.position
            }
            return 0 != i && (s += "left: " + i + "px; "), 0 != e && (s += "top: " + e + "px; "), s
        }, n.prototype.calculateOffsets = function (t) {
            var i = h.prototype.calculateOffsets.call(this, t);
            return"top" == this.position ? i.y = t.top + 1 : "left" == this.position ? (i.x = t.left, i.y = t.height / 2 + t.top - this.labelWidth / 2) : "right" == this.position && (i.x = t.left + t.width - this.labelHeight, i.y = t.height / 2 + t.top - this.labelWidth / 2), i
        }, n.prototype.draw = function (t) {
            h.prototype.draw.call(this, t), this.requiresResize && (this.elem = this.plot.getPlaceholder().find("." + this.axisName + "Label"), this.elem.css("width", this.labelWidth), this.elem.css("height", this.labelHeight))
        }, t.plot.plugins.push({init: r, options: p, name: "axisLabels", version: "2.0"})
    }(jQuery);
//improved orderBars 0.2 - github.com/emmerich
    !function (r) {
        function n(r) {
            function n(r, n, e) {
                var i = null;
                if (t(n) && (l(n), a(r), o(r), s(n), p >= 2)) {
                    var u = d(n), v = 0, W = f();
                    "undefined" == typeof D[n.bars.order] && (h(u) ? D[n.bars.order] = -1 * b(g, u - 1, Math.floor(p / 2) - 1) - W : D[n.bars.order] = b(g, Math.ceil(p / 2), u - 2) + W + 2 * y), v = D[n.bars.order], i = c(e, n, v), e.points = i
                }
                return i
            }
            function t(r) {
                return null != r.bars && r.bars.show && null != r.bars.order
            }
            function a(r) {
                var n = w ? r.getPlaceholder().innerHeight() : r.getPlaceholder().innerWidth(), t = w ? e(r.getData(), 1) : e(r.getData(), 0), a = t[1] - t[0];
                W = a / n
            }
            function e(r, n) {
                for (var t = new Array, a = 0; a < r.length; a++)
                    t[0] = r[a].data[0] ? r[a].data[0][n] : null, t[1] = r[a].data[r[a].data.length - 1] ? r[a].data[r[a].data.length - 1][n] : null;
                return t
            }
            function o(r) {
                g = i(r.getData()), p = g.length
            }
            function i(r) {
                for (var n = new Array, t = [], a = 0; a < r.length; a++)
                    null != r[a].bars.order && r[a].bars.show && t.indexOf(r[a].bars.order) < 0 && (t.push(r[a].bars.order), n.push(r[a]));
                return n.sort(u)
            }
            function u(r, n) {
                var t = r.bars.order, a = n.bars.order;
                return a > t ? -1 : t > a ? 1 : 0
            }
            function s(r) {
                v = "undefined" != typeof r.bars.lineWidth ? r.bars.lineWidth : 2, y = v * W
            }
            function l(r) {
                r.bars.horizontal && (w = !0)
            }
            function d(r) {
                for (var n = 0, t = 0; t < g.length; ++t)
                    if (r == g[t]) {
                        n = t;
                        break
                    }
                return n + 1
            }
            function f() {
                var r = 0;
                return p % 2 != 0 && (r = g[Math.ceil(p / 2)].bars.barWidth / 2), r
            }
            function h(r) {
                return r <= Math.ceil(p / 2)
            }
            function b(r, n, t) {
                for (var a = 0, e = n; t >= e; e++)
                    a += r[e].bars.barWidth + 2 * y;
                return a
            }
            function c(r, n, t) {
                for (var a = r.pointsize, e = r.points, o = 0, i = w ? 1 : 0; i < e.length; i += a)
                    e[i] += t, n.data[o][3] = e[i], o++;
                return e
            }
            var g, p, v, y, W = 1, w = !1, D = {};
            r.hooks.processDatapoints.push(n)
        }
        var t = {series: {bars: {order: null}}};
        r.plot.plugins.push({init: n, options: t, name: "orderBars", version: "0.2"})
    }(jQuery);
//"stack",version:"1.2"
    (function ($) {
        var options = {series: {stack: null}};
        function init(plot) {
            function findMatchingSeries(s, allseries) {
                var res = null;
                for (var i = 0; i < allseries.length; ++i) {
                    if (s == allseries[i])
                        break;
                    if (allseries[i].stack == s.stack)
                        res = allseries[i]
                }
                return res
            }
            function stackData(plot, s, datapoints) {
                if (s.stack == null || s.stack === false)
                    return;
                var other = findMatchingSeries(s, plot.getData());
                if (!other)
                    return;
                var ps = datapoints.pointsize, points = datapoints.points, otherps = other.datapoints.pointsize, otherpoints = other.datapoints.points, newpoints = [], px, py, intery, qx, qy, bottom, withlines = s.lines.show, horizontal = s.bars.horizontal, withbottom = ps > 2 && (horizontal ? datapoints.format[2].x : datapoints.format[2].y), withsteps = withlines && s.lines.steps, fromgap = true, keyOffset = horizontal ? 1 : 0, accumulateOffset = horizontal ? 0 : 1, i = 0, j = 0, l, m;
                while (true) {
                    if (i >= points.length)
                        break;
                    l = newpoints.length;
                    if (points[i] == null) {
                        for (m = 0; m < ps; ++m)
                            newpoints.push(points[i + m]);
                        i += ps
                    } else if (j >= otherpoints.length) {
                        if (!withlines) {
                            for (m = 0; m < ps; ++m)
                                newpoints.push(points[i + m])
                        }
                        i += ps
                    } else if (otherpoints[j] == null) {
                        for (m = 0; m < ps; ++m)
                            newpoints.push(null);
                        fromgap = true;
                        j += otherps
                    } else {
                        px = points[i + keyOffset];
                        py = points[i + accumulateOffset];
                        qx = otherpoints[j + keyOffset];
                        qy = otherpoints[j + accumulateOffset];
                        bottom = 0;
                        if (px == qx) {
                            for (m = 0; m < ps; ++m)
                                newpoints.push(points[i + m]);
                            newpoints[l + accumulateOffset] += qy;
                            bottom = qy;
                            i += ps;
                            j += otherps
                        } else if (px > qx) {
                            if (withlines && i > 0 && points[i - ps] != null) {
                                intery = py + (points[i - ps + accumulateOffset] - py) * (qx - px) / (points[i - ps + keyOffset] - px);
                                newpoints.push(qx);
                                newpoints.push(intery + qy);
                                for (m = 2; m < ps; ++m)
                                    newpoints.push(points[i + m]);
                                bottom = qy
                            }
                            j += otherps
                        } else {
                            if (fromgap && withlines) {
                                i += ps;
                                continue
                            }
                            for (m = 0; m < ps; ++m)
                                newpoints.push(points[i + m]);
                            if (withlines && j > 0 && otherpoints[j - otherps] != null)
                                bottom = qy + (otherpoints[j - otherps + accumulateOffset] - qy) * (px - qx) / (otherpoints[j - otherps + keyOffset] - qx);
                            newpoints[l + accumulateOffset] += bottom;
                            i += ps
                        }
                        fromgap = false;
                        if (l != newpoints.length && withbottom)
                            newpoints[l + 2] += bottom
                    }
                    if (withsteps && l != newpoints.length && l > 0 && newpoints[l] != null && newpoints[l] != newpoints[l - ps] && newpoints[l + 1] != newpoints[l - ps + 1]) {
                        for (m = 0; m < ps; ++m)
                            newpoints[l + ps + m] = newpoints[l + m];
                        newpoints[l + 1] = newpoints[l - ps + 1]
                    }
                }
                datapoints.points = newpoints
            }
            plot.hooks.processDatapoints.push(stackData)
        }
        $.plot.plugins.push({init: init, options: options, name: "stack", version: "1.2"})
    })(jQuery);
//"time",version:"1.0"
    (function ($) {
        var options = {xaxis: {timezone: null, timeformat: null, twelveHourClock: false, monthNames: null}};
        function floorInBase(n, base) {
            return base * Math.floor(n / base)
        }
        function formatDate(d, fmt, monthNames, dayNames) {
            if (typeof d.strftime == "function") {
                return d.strftime(fmt)
            }
            var leftPad = function (n, pad) {
                n = "" + n;
                pad = "" + (pad == null ? "0" : pad);
                return n.length == 1 ? pad + n : n
            };
            var r = [];
            var escape = false;
            var hours = d.getHours();
            var isAM = hours < 12;
            if (monthNames == null) {
                monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            }
            if (dayNames == null) {
                dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
            }
            var hours12;
            if (hours > 12) {
                hours12 = hours - 12
            } else if (hours == 0) {
                hours12 = 12
            } else {
                hours12 = hours
            }
            for (var i = 0; i < fmt.length; ++i) {
                var c = fmt.charAt(i);
                if (escape) {
                    switch (c) {
                        case"a":
                            c = "" + dayNames[d.getDay()];
                            break;
                            case"b":
                            c = "" + monthNames[d.getMonth()];
                            break;
                            case"d":
                            c = leftPad(d.getDate());
                            break;
                            case"e":
                            c = leftPad(d.getDate(), " ");
                            break;
                            case"h":
                        case"H":
                            c = leftPad(hours);
                            break;
                            case"I":
                            c = leftPad(hours12);
                            break;
                            case"l":
                            c = leftPad(hours12, " ");
                            break;
                            case"m":
                            c = leftPad(d.getMonth() + 1);
                            break;
                            case"M":
                            c = leftPad(d.getMinutes());
                            break;
                            case"q":
                            c = "" + (Math.floor(d.getMonth() / 3) + 1);
                            break;
                            case"S":
                            c = leftPad(d.getSeconds());
                            break;
                            case"y":
                            c = leftPad(d.getFullYear() % 100);
                            break;
                            case"Y":
                            c = "" + d.getFullYear();
                            break;
                            case"p":
                            c = isAM ? "" + "am" : "" + "pm";
                            break;
                            case"P":
                            c = isAM ? "" + "AM" : "" + "PM";
                            break;
                            case"w":
                            c = "" + d.getDay();
                            break
                        }
                    r.push(c);
                    escape = false
                } else {
                    if (c == "%") {
                        escape = true
                    } else {
                        r.push(c)
                    }
                }
            }
            return r.join("")
        }
        function makeUtcWrapper(d) {
            function addProxyMethod(sourceObj, sourceMethod, targetObj, targetMethod) {
                sourceObj[sourceMethod] = function () {
                    return targetObj[targetMethod].apply(targetObj, arguments)
                }
            }
            var utc = {date: d};
            if (d.strftime != undefined) {
                addProxyMethod(utc, "strftime", d, "strftime")
            }
            addProxyMethod(utc, "getTime", d, "getTime");
            addProxyMethod(utc, "setTime", d, "setTime");
            var props = ["Date", "Day", "FullYear", "Hours", "Milliseconds", "Minutes", "Month", "Seconds"];
            for (var p = 0; p < props.length; p++) {
                addProxyMethod(utc, "get" + props[p], d, "getUTC" + props[p]);
                addProxyMethod(utc, "set" + props[p], d, "setUTC" + props[p])
            }
            return utc
        }
        function dateGenerator(ts, opts) {
            if (opts.timezone == "browser") {
                return new Date(ts)
            } else if (!opts.timezone || opts.timezone == "utc") {
                return makeUtcWrapper(new Date(ts))
            } else if (typeof timezoneJS != "undefined" && typeof timezoneJS.Date != "undefined") {
                var d = new timezoneJS.Date;
                d.setTimezone(opts.timezone);
                d.setTime(ts);
                return d
            } else {
                return makeUtcWrapper(new Date(ts))
            }
        }
        var timeUnitSize = {second: 1e3, minute: 60 * 1e3, hour: 60 * 60 * 1e3, day: 24 * 60 * 60 * 1e3, month: 30 * 24 * 60 * 60 * 1e3, quarter: 3 * 30 * 24 * 60 * 60 * 1e3, year: 365.2425 * 24 * 60 * 60 * 1e3};
        var baseSpec = [[1, "second"], [2, "second"], [5, "second"], [10, "second"], [30, "second"], [1, "minute"], [2, "minute"], [5, "minute"], [10, "minute"], [30, "minute"], [1, "hour"], [2, "hour"], [4, "hour"], [8, "hour"], [12, "hour"], [1, "day"], [2, "day"], [3, "day"], [.25, "month"], [.5, "month"], [1, "month"], [2, "month"]];
        var specMonths = baseSpec.concat([[3, "month"], [6, "month"], [1, "year"]]);
        var specQuarters = baseSpec.concat([[1, "quarter"], [2, "quarter"], [1, "year"]]);
        function init(plot) {
            plot.hooks.processOptions.push(function (plot, options) {
                $.each(plot.getAxes(), function (axisName, axis) {
                    var opts = axis.options;
                    if (opts.mode == "time") {
                        axis.tickGenerator = function (axis) {
                            var ticks = [];
                            var d = dateGenerator(axis.min, opts);
                            var minSize = 0;
                            var spec = opts.tickSize && opts.tickSize[1] === "quarter" || opts.minTickSize && opts.minTickSize[1] === "quarter" ? specQuarters : specMonths;
                            if (opts.minTickSize != null) {
                                if (typeof opts.tickSize == "number") {
                                    minSize = opts.tickSize
                                } else {
                                    minSize = opts.minTickSize[0] * timeUnitSize[opts.minTickSize[1]]
                                }
                            }
                            for (var i = 0; i < spec.length - 1; ++i) {
                                if (axis.delta < (spec[i][0] * timeUnitSize[spec[i][1]] + spec[i + 1][0] * timeUnitSize[spec[i + 1][1]]) / 2 && spec[i][0] * timeUnitSize[spec[i][1]] >= minSize) {
                                    break
                                }
                            }
                            var size = spec[i][0];
                            var unit = spec[i][1];
                            if (unit == "year") {
                                if (opts.minTickSize != null && opts.minTickSize[1] == "year") {
                                    size = Math.floor(opts.minTickSize[0])
                                } else {
                                    var magn = Math.pow(10, Math.floor(Math.log(axis.delta / timeUnitSize.year) / Math.LN10));
                                    var norm = axis.delta / timeUnitSize.year / magn;
                                    if (norm < 1.5) {
                                        size = 1
                                    } else if (norm < 3) {
                                        size = 2
                                    } else if (norm < 7.5) {
                                        size = 5
                                    } else {
                                        size = 10
                                    }
                                    size *= magn
                                }
                                if (size < 1) {
                                    size = 1
                                }
                            }
                            axis.tickSize = opts.tickSize || [size, unit];
                            var tickSize = axis.tickSize[0];
                            unit = axis.tickSize[1];
                            var step = tickSize * timeUnitSize[unit];
                            if (unit == "second") {
                                d.setSeconds(floorInBase(d.getSeconds(), tickSize))
                            } else if (unit == "minute") {
                                d.setMinutes(floorInBase(d.getMinutes(), tickSize))
                            } else if (unit == "hour") {
                                d.setHours(floorInBase(d.getHours(), tickSize))
                            } else if (unit == "month") {
                                d.setMonth(floorInBase(d.getMonth(), tickSize))
                            } else if (unit == "quarter") {
                                d.setMonth(3 * floorInBase(d.getMonth() / 3, tickSize))
                            } else if (unit == "year") {
                                d.setFullYear(floorInBase(d.getFullYear(), tickSize))
                            }
                            d.setMilliseconds(0);
                            if (step >= timeUnitSize.minute) {
                                d.setSeconds(0)
                            }
                            if (step >= timeUnitSize.hour) {
                                d.setMinutes(0)
                            }
                            if (step >= timeUnitSize.day) {
                                d.setHours(0)
                            }
                            if (step >= timeUnitSize.day * 4) {
                                d.setDate(1)
                            }
                            if (step >= timeUnitSize.month * 2) {
                                d.setMonth(floorInBase(d.getMonth(), 3))
                            }
                            if (step >= timeUnitSize.quarter * 2) {
                                d.setMonth(floorInBase(d.getMonth(), 6))
                            }
                            if (step >= timeUnitSize.year) {
                                d.setMonth(0)
                            }
                            var carry = 0;
                            var v = Number.NaN;
                            var prev;
                            do {
                                prev = v;
                                v = d.getTime();
                                ticks.push(v);
                                if (unit == "month" || unit == "quarter") {
                                    if (tickSize < 1) {
                                        d.setDate(1);
                                        var start = d.getTime();
                                        d.setMonth(d.getMonth() + (unit == "quarter" ? 3 : 1));
                                        var end = d.getTime();
                                        d.setTime(v + carry * timeUnitSize.hour + (end - start) * tickSize);
                                        carry = d.getHours();
                                        d.setHours(0)
                                    } else {
                                        d.setMonth(d.getMonth() + tickSize * (unit == "quarter" ? 3 : 1))
                                    }
                                } else if (unit == "year") {
                                    d.setFullYear(d.getFullYear() + tickSize)
                                } else {
                                    d.setTime(v + step)
                                }
                            } while (v < axis.max && v != prev);
                            return ticks
                        };
                        axis.tickFormatter = function (v, axis) {
                            var d = dateGenerator(v, axis.options);
                            if (opts.timeformat != null) {
                                return formatDate(d, opts.timeformat, opts.monthNames, opts.dayNames)
                            }
                            var useQuarters = axis.options.tickSize && axis.options.tickSize[1] == "quarter" || axis.options.minTickSize && axis.options.minTickSize[1] == "quarter";
                            var t = axis.tickSize[0] * timeUnitSize[axis.tickSize[1]];
                            var span = axis.max - axis.min;
                            var suffix = opts.twelveHourClock ? " %p" : "";
                            var hourCode = opts.twelveHourClock ? "%I" : "%H";
                            var fmt;
                            if (t < timeUnitSize.minute) {
                                fmt = hourCode + ":%M:%S" + suffix
                            } else if (t < timeUnitSize.day) {
                                if (span < 2 * timeUnitSize.day) {
                                    fmt = hourCode + ":%M" + suffix
                                } else {
                                    fmt = "%b %d " + hourCode + ":%M" + suffix
                                }
                            } else if (t < timeUnitSize.month) {
                                fmt = "%b %d"
                            } else if (useQuarters && t < timeUnitSize.quarter || !useQuarters && t < timeUnitSize.year) {
                                if (span < timeUnitSize.year) {
                                    fmt = "%b"
                                } else {
                                    fmt = "%b %Y"
                                }
                            } else if (useQuarters && t < timeUnitSize.year) {
                                if (span < timeUnitSize.year) {
                                    fmt = "Q%q"
                                } else {
                                    fmt = "Q%q %Y"
                                }
                            } else {
                                fmt = "%Y"
                            }
                            var rt = formatDate(d, fmt, opts.monthNames, opts.dayNames);
                            return rt
                        }
                    }
                })
            })
        }
        $.plot.plugins.push({init: init, options: options, name: "time", version: "1.0"});
        $.plot.formatDate = formatDate
    })(jQuery);
//resize",version:"1.0"
    (function ($, e, t) {
        "$:nomunge";
        var i = [], n = $.resize = $.extend($.resize, {}), a, r = false, s = "setTimeout", u = "resize", m = u + "-special-event", o = "pendingDelay", l = "activeDelay", f = "throttleWindow";
        n[o] = 200;
        n[l] = 20;
        n[f] = true;
        $.event.special[u] = {setup: function () {
                if (!n[f] && this[s]) {
                    return false
                }
                var e = $(this);
                i.push(this);
                e.data(m, {w: e.width(), h: e.height()});
                if (i.length === 1) {
                    a = t;
                    h()
                }
            }, teardown: function () {
                if (!n[f] && this[s]) {
                    return false
                }
                var e = $(this);
                for (var t = i.length - 1; t >= 0; t--) {
                    if (i[t] == this) {
                        i.splice(t, 1);
                        break
                    }
                }
                e.removeData(m);
                if (!i.length) {
                    if (r) {
                        cancelAnimationFrame(a)
                    } else {
                        clearTimeout(a)
                    }
                    a = null
                }
            }, add: function (e) {
                if (!n[f] && this[s]) {
                    return false
                }
                var i;
                function a(e, n, a) {
                    var r = $(this), s = r.data(m) || {};
                    s.w = n !== t ? n : r.width();
                    s.h = a !== t ? a : r.height();
                    i.apply(this, arguments)
                }
                if ($.isFunction(e)) {
                    i = e;
                    return a
                } else {
                    i = e.handler;
                    e.handler = a
                }
            }};
        function h(t) {
            if (r === true) {
                r = t || 1
            }
            for (var s = i.length - 1; s >= 0; s--) {
                var l = $(i[s]);
                if (l[0] == e || l.is(":visible")) {
                    var f = l.width(), c = l.height(), d = l.data(m);
                    if (d && (f !== d.w || c !== d.h)) {
                        l.trigger(u, [d.w = f, d.h = c]);
                        r = t || true
                    }
                } else {
                    d = l.data(m);
                    d.w = 0;
                    d.h = 0
                }
            }
            if (a !== null) {
                if (r && (t == null || t - r < 1e3)) {
                    a = e.requestAnimationFrame(h)
                } else {
                    a = setTimeout(h, n[o]);
                    r = false
                }
            }
        }
        if (!e.requestAnimationFrame) {
            e.requestAnimationFrame = function () {
                return e.webkitRequestAnimationFrame || e.mozRequestAnimationFrame || e.oRequestAnimationFrame || e.msRequestAnimationFrame || function (t, i) {
                    return e.setTimeout(function () {
                        t((new Date).getTime())
                    }, n[l])
                }
            }()
        }
        if (!e.cancelAnimationFrame) {
            e.cancelAnimationFrame = function () {
                return e.webkitCancelRequestAnimationFrame || e.mozCancelRequestAnimationFrame || e.oCancelRequestAnimationFrame || e.msCancelRequestAnimationFrame || clearTimeout
            }()
        }
    })(jQuery, this);
    (function ($) {
        var options = {};
        function init(plot) {
            function onResize() {
                var placeholder = plot.getPlaceholder();
                if (placeholder.width() == 0 || placeholder.height() == 0)
                    return;
                plot.resize();
                plot.setupGrid();
                plot.draw()
            }
            function bindEvents(plot, eventHolder) {
                plot.getPlaceholder().resize(onResize)
            }
            function shutdown(plot, eventHolder) {
                plot.getPlaceholder().unbind("resize", onResize)
            }
            plot.hooks.bindEvents.push(bindEvents);
            plot.hooks.shutdown.push(shutdown)
        }
        $.plot.plugins.push({init: init, options: options, name: "resize", version: "1.0"})
    })(jQuery);

    /* jquery.sparkline 2.1.2 - http://omnipotent.net/jquery.sparkline/ 
     
     ** Licensed under the New BSD License - see above site for details */

    (function (a, b, c) {
        (function (a) {
            typeof define == "function" && define.amd ? define(["jquery"], a) : jQuery && !jQuery.fn.sparkline && a(jQuery)
        })(function (d) {
            "use strict";
            var e = {}, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L = 0;
            f = function () {
                return{common: {type: "line", lineColor: "#00f", fillColor: "#cdf", defaultPixelsPerValue: 3, width: "auto", height: "auto", composite: !1, tagValuesAttribute: "values", tagOptionsPrefix: "spark", enableTagOptions: !1, enableHighlight: !0, highlightLighten: 1.4, tooltipSkipNull: !0, tooltipPrefix: "", tooltipSuffix: "", disableHiddenCheck: !1, numberFormatter: !1, numberDigitGroupCount: 3, numberDigitGroupSep: ",", numberDecimalMark: ".", disableTooltips: !1, disableInteraction: !1}, line: {spotColor: "#f80", highlightSpotColor: "#5f5", highlightLineColor: "#f22", spotRadius: 1.5, minSpotColor: "#f80", maxSpotColor: "#f80", lineWidth: 1, normalRangeMin: c, normalRangeMax: c, normalRangeColor: "#ccc", drawNormalOnTop: !1, chartRangeMin: c, chartRangeMax: c, chartRangeMinX: c, chartRangeMaxX: c, tooltipFormat: new h('<span style="color: {{color}}">&#9679;</span> {{prefix}}{{y}}{{suffix}}')}, bar: {barColor: "#3366cc", negBarColor: "#f44", stackedBarColor: ["#3366cc", "#dc3912", "#ff9900", "#109618", "#66aa00", "#dd4477", "#0099c6", "#990099"], zeroColor: c, nullColor: c, zeroAxis: !0, barWidth: 4, barSpacing: 1, chartRangeMax: c, chartRangeMin: c, chartRangeClip: !1, colorMap: c, tooltipFormat: new h('<span style="color: {{color}}">&#9679;</span> {{prefix}}{{value}}{{suffix}}')}, tristate: {barWidth: 4, barSpacing: 1, posBarColor: "#6f6", negBarColor: "#f44", zeroBarColor: "#999", colorMap: {}, tooltipFormat: new h('<span style="color: {{color}}">&#9679;</span> {{value:map}}'), tooltipValueLookups: {map: {"-1": "Loss", 0: "Draw", 1: "Win"}}}, discrete: {lineHeight: "auto", thresholdColor: c, thresholdValue: 0, chartRangeMax: c, chartRangeMin: c, chartRangeClip: !1, tooltipFormat: new h("{{prefix}}{{value}}{{suffix}}")}, bullet: {targetColor: "#f33", targetWidth: 3, performanceColor: "#33f", rangeColors: ["#d3dafe", "#a8b6ff", "#7f94ff"], base: c, tooltipFormat: new h("{{fieldkey:fields}} - {{value}}"), tooltipValueLookups: {fields: {r: "Range", p: "Performance", t: "Target"}}}, pie: {offset: 0, sliceColors: ["#3366cc", "#dc3912", "#ff9900", "#109618", "#66aa00", "#dd4477", "#0099c6", "#990099"], borderWidth: 0, borderColor: "#000", tooltipFormat: new h('<span style="color: {{color}}">&#9679;</span> {{value}} ({{percent.1}}%)')}, box: {raw: !1, boxLineColor: "#000", boxFillColor: "#cdf", whiskerColor: "#000", outlierLineColor: "#333", outlierFillColor: "#fff", medianColor: "#f00", showOutliers: !0, outlierIQR: 1.5, spotRadius: 1.5, target: c, targetColor: "#4a2", chartRangeMax: c, chartRangeMin: c, tooltipFormat: new h("{{field:fields}}: {{value}}"), tooltipFormatFieldlistKey: "field", tooltipValueLookups: {fields: {lq: "Lower Quartile", med: "Median", uq: "Upper Quartile", lo: "Left Outlier", ro: "Right Outlier", lw: "Left Whisker", rw: "Right Whisker"}}}}
            }, E = '.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}', g = function () {
                var a, b;
                return a = function () {
                    this.init.apply(this, arguments)
                }, arguments.length > 1 ? (arguments[0] ? (a.prototype = d.extend(new arguments[0], arguments[arguments.length - 1]), a._super = arguments[0].prototype) : a.prototype = arguments[arguments.length - 1], arguments.length > 2 && (b = Array.prototype.slice.call(arguments, 1, -1), b.unshift(a.prototype), d.extend.apply(d, b))) : a.prototype = arguments[0], a.prototype.cls = a, a
            }, d.SPFormatClass = h = g({fre: /\{\{([\w.]+?)(:(.+?))?\}\}/g, precre: /(\w+)\.(\d+)/, init: function (a, b) {
                    this.format = a, this.fclass = b
                }, render: function (a, b, d) {
                    var e = this, f = a, g, h, i, j, k;
                    return this.format.replace(this.fre, function () {
                        var a;
                        return h = arguments[1], i = arguments[3], g = e.precre.exec(h), g ? (k = g[2], h = g[1]) : k = !1, j = f[h], j === c ? "" : i && b && b[i] ? (a = b[i], a.get ? b[i].get(j) || j : b[i][j] || j) : (n(j) && (d.get("numberFormatter") ? j = d.get("numberFormatter")(j) : j = s(j, k, d.get("numberDigitGroupCount"), d.get("numberDigitGroupSep"), d.get("numberDecimalMark"))), j)
                    })
                }}), d.spformat = function (a, b) {
                return new h(a, b)
            }, i = function (a, b, c) {
                return a < b ? b : a > c ? c : a
            }, j = function (a, c) {
                var d;
                return c === 2 ? (d = b.floor(a.length / 2), a.length % 2 ? a[d] : (a[d - 1] + a[d]) / 2) : a.length % 2 ? (d = (a.length * c + c) / 4, d % 1 ? (a[b.floor(d)] + a[b.floor(d) - 1]) / 2 : a[d - 1]) : (d = (a.length * c + 2) / 4, d % 1 ? (a[b.floor(d)] + a[b.floor(d) - 1]) / 2 : a[d - 1])
            }, k = function (a) {
                var b;
                switch (a) {
                    case"undefined":
                        a = c;
                        break;
                        case"null":
                        a = null;
                        break;
                        case"true":
                        a = !0;
                        break;
                        case"false":
                        a = !1;
                        break;
                        default:
                        b = parseFloat(a), a == b && (a = b)
                    }
                return a
            }, l = function (a) {
                var b, c = [];
                for (b = a.length; b--; )
                    c[b] = k(a[b]);
                return c
            }, m = function (a, b) {
                var c, d, e = [];
                for (c = 0, d = a.length; c < d; c++)
                    a[c] !== b && e.push(a[c]);
                return e
            }, n = function (a) {
                return!isNaN(parseFloat(a)) && isFinite(a)
            }, s = function (a, b, c, e, f) {
                var g, h;
                a = (b === !1 ? parseFloat(a).toString() : a.toFixed(b)).split(""), g = (g = d.inArray(".", a)) < 0 ? a.length : g, g < a.length && (a[g] = f);
                for (h = g - c; h > 0; h -= c)
                    a.splice(h, 0, e);
                return a.join("")
            }, o = function (a, b, c) {
                var d;
                for (d = b.length; d--; ) {
                    if (c && b[d] === null)
                        continue;
                    if (b[d] !== a)
                        return!1
                }
                return!0
            }, p = function (a) {
                var b = 0, c;
                for (c = a.length; c--; )
                    b += typeof a[c] == "number" ? a[c] : 0;
                return b
            }, r = function (a) {
                return d.isArray(a) ? a : [a]
            }, q = function (b) {
                var c;
                a.createStyleSheet ? a.createStyleSheet().cssText = b : (c = a.createElement("style"), c.type = "text/css", a.getElementsByTagName("head")[0].appendChild(c), c[typeof a.body.style.WebkitAppearance == "string" ? "innerText" : "innerHTML"] = b)
            }, d.fn.simpledraw = function (b, e, f, g) {
                var h, i;
                if (f && (h = this.data("_jqs_vcanvas")))
                    return h;
                if (d.fn.sparkline.canvas === !1)
                    return!1;
                if (d.fn.sparkline.canvas === c) {
                    var j = a.createElement("canvas");
                    if (!j.getContext || !j.getContext("2d")) {
                        if (!a.namespaces || !!a.namespaces.v)
                            return d.fn.sparkline.canvas = !1, !1;
                        a.namespaces.add("v", "urn:schemas-microsoft-com:vml", "#default#VML"), d.fn.sparkline.canvas = function (a, b, c, d) {
                            return new J(a, b, c)
                        }
                    } else
                        d.fn.sparkline.canvas = function (a, b, c, d) {
                            return new I(a, b, c, d)
                        }
                }
                return b === c && (b = d(this).innerWidth()), e === c && (e = d(this).innerHeight()), h = d.fn.sparkline.canvas(b, e, this, g), i = d(this).data("_jqs_mhandler"), i && i.registerCanvas(h), h
            }, d.fn.cleardraw = function () {
                var a = this.data("_jqs_vcanvas");
                a && a.reset()
            }, d.RangeMapClass = t = g({init: function (a) {
                    var b, c, d = [];
                    for (b in a)
                        a.hasOwnProperty(b) && typeof b == "string" && b.indexOf(":") > -1 && (c = b.split(":"), c[0] = c[0].length === 0 ? -Infinity : parseFloat(c[0]), c[1] = c[1].length === 0 ? Infinity : parseFloat(c[1]), c[2] = a[b], d.push(c));
                    this.map = a, this.rangelist = d || !1
                }, get: function (a) {
                    var b = this.rangelist, d, e, f;
                    if ((f = this.map[a]) !== c)
                        return f;
                    if (b)
                        for (d = b.length; d--; ) {
                            e = b[d];
                            if (e[0] <= a && e[1] >= a)
                                return e[2]
                        }
                    return c
                }}), d.range_map = function (a) {
                return new t(a)
            }, u = g({init: function (a, b) {
                    var c = d(a);
                    this.$el = c, this.options = b, this.currentPageX = 0, this.currentPageY = 0, this.el = a, this.splist = [], this.tooltip = null, this.over = !1, this.displayTooltips = !b.get("disableTooltips"), this.highlightEnabled = !b.get("disableHighlight")
                }, registerSparkline: function (a) {
                    this.splist.push(a), this.over && this.updateDisplay()
                }, registerCanvas: function (a) {
                    var b = d(a.canvas);
                    this.canvas = a, this.$canvas = b, b.mouseenter(d.proxy(this.mouseenter, this)), b.mouseleave(d.proxy(this.mouseleave, this)), b.click(d.proxy(this.mouseclick, this))
                }, reset: function (a) {
                    this.splist = [], this.tooltip && a && (this.tooltip.remove(), this.tooltip = c)
                }, mouseclick: function (a) {
                    var b = d.Event("sparklineClick");
                    b.originalEvent = a, b.sparklines = this.splist, this.$el.trigger(b)
                }, mouseenter: function (b) {
                    d(a.body).unbind("mousemove.jqs"), d(a.body).bind("mousemove.jqs", d.proxy(this.mousemove, this)), this.over = !0, this.currentPageX = b.pageX, this.currentPageY = b.pageY, this.currentEl = b.target, !this.tooltip && this.displayTooltips && (this.tooltip = new v(this.options), this.tooltip.updatePosition(b.pageX, b.pageY)), this.updateDisplay()
                }, mouseleave: function () {
                    d(a.body).unbind("mousemove.jqs");
                    var b = this.splist, c = b.length, e = !1, f, g;
                    this.over = !1, this.currentEl = null, this.tooltip && (this.tooltip.remove(), this.tooltip = null);
                    for (g = 0; g < c; g++)
                        f = b[g], f.clearRegionHighlight() && (e = !0);
                    e && this.canvas.render()
                }, mousemove: function (a) {
                    this.currentPageX = a.pageX, this.currentPageY = a.pageY, this.currentEl = a.target, this.tooltip && this.tooltip.updatePosition(a.pageX, a.pageY), this.updateDisplay()
                }, updateDisplay: function () {
                    var a = this.splist, b = a.length, c = !1, e = this.$canvas.offset(), f = this.currentPageX - e.left, g = this.currentPageY - e.top, h, i, j, k, l;
                    if (!this.over)
                        return;
                    for (j = 0; j < b; j++)
                        i = a[j], k = i.setRegionHighlight(this.currentEl, f, g), k && (c = !0);
                    if (c) {
                        l = d.Event("sparklineRegionChange"), l.sparklines = this.splist, this.$el.trigger(l);
                        if (this.tooltip) {
                            h = "";
                            for (j = 0; j < b; j++)
                                i = a[j], h += i.getCurrentRegionTooltip();
                            this.tooltip.setContent(h)
                        }
                        this.disableHighlight || this.canvas.render()
                    }
                    k === null && this.mouseleave()
                }}), v = g({sizeStyle: "position: static !important;display: block !important;visibility: hidden !important;float: left !important;", init: function (b) {
                    var c = b.get("tooltipClassname", "jqstooltip"), e = this.sizeStyle, f;
                    this.container = b.get("tooltipContainer") || a.body, this.tooltipOffsetX = b.get("tooltipOffsetX", 10), this.tooltipOffsetY = b.get("tooltipOffsetY", 12), d("#jqssizetip").remove(), d("#jqstooltip").remove(), this.sizetip = d("<div/>", {id: "jqssizetip", style: e, "class": c}), this.tooltip = d("<div/>", {id: "jqstooltip", "class": c}).appendTo(this.container), f = this.tooltip.offset(), this.offsetLeft = f.left, this.offsetTop = f.top, this.hidden = !0, d(window).unbind("resize.jqs scroll.jqs"), d(window).bind("resize.jqs scroll.jqs", d.proxy(this.updateWindowDims, this)), this.updateWindowDims()
                }, updateWindowDims: function () {
                    this.scrollTop = d(window).scrollTop(), this.scrollLeft = d(window).scrollLeft(), this.scrollRight = this.scrollLeft + d(window).width(), this.updatePosition()
                }, getSize: function (a) {
                    this.sizetip.html(a).appendTo(this.container), this.width = this.sizetip.width() + 1, this.height = this.sizetip.height(), this.sizetip.remove()
                }, setContent: function (a) {
                    if (!a) {
                        this.tooltip.css("visibility", "hidden"), this.hidden = !0;
                        return
                    }
                    this.getSize(a), this.tooltip.html(a).css({width: this.width, height: this.height, visibility: "visible"}), this.hidden && (this.hidden = !1, this.updatePosition())
                }, updatePosition: function (a, b) {
                    if (a === c) {
                        if (this.mousex === c)
                            return;
                        a = this.mousex - this.offsetLeft, b = this.mousey - this.offsetTop
                    } else
                        this.mousex = a -= this.offsetLeft, this.mousey = b -= this.offsetTop;
                    if (!this.height || !this.width || this.hidden)
                        return;
                    b -= this.height + this.tooltipOffsetY, a += this.tooltipOffsetX, b < this.scrollTop && (b = this.scrollTop), a < this.scrollLeft ? a = this.scrollLeft : a + this.width > this.scrollRight && (a = this.scrollRight - this.width), this.tooltip.css({left: a, top: b})
                }, remove: function () {
                    this.tooltip.remove(), this.sizetip.remove(), this.sizetip = this.tooltip = c, d(window).unbind("resize.jqs scroll.jqs")
                }}), F = function () {
                q(E)
            }, d(F), K = [], d.fn.sparkline = function (b, e) {
                return this.each(function () {
                    var f = new d.fn.sparkline.options(this, e), g = d(this), h, i;
                    h = function () {
                        var e, h, i, j, k, l, m;
                        if (b === "html" || b === c) {
                            m = this.getAttribute(f.get("tagValuesAttribute"));
                            if (m === c || m === null)
                                m = g.html();
                            e = m.replace(/(^\s*<!--)|(-->\s*$)|\s+/g, "").split(",")
                        } else
                            e = b;
                        h = f.get("width") === "auto" ? e.length * f.get("defaultPixelsPerValue") : f.get("width");
                        if (f.get("height") === "auto") {
                            if (!f.get("composite") || !d.data(this, "_jqs_vcanvas"))
                                j = a.createElement("span"), j.innerHTML = "a", g.html(j), i = d(j).innerHeight() || d(j).height(), d(j).remove(), j = null
                        } else
                            i = f.get("height");
                        f.get("disableInteraction") ? k = !1 : (k = d.data(this, "_jqs_mhandler"), k ? f.get("composite") || k.reset() : (k = new u(this, f), d.data(this, "_jqs_mhandler", k)));
                        if (f.get("composite") && !d.data(this, "_jqs_vcanvas")) {
                            d.data(this, "_jqs_errnotify") || (alert("Attempted to attach a composite sparkline to an element with no existing sparkline"), d.data(this, "_jqs_errnotify", !0));
                            return
                        }
                        l = new (d.fn.sparkline[f.get("type")])(this, e, f, h, i), l.render(), k && k.registerSparkline(l)
                    };
                    if (d(this).html() && !f.get("disableHiddenCheck") && d(this).is(":hidden") || !d(this).parents("body").length) {
                        if (!f.get("composite") && d.data(this, "_jqs_pending"))
                            for (i = K.length; i; i--)
                                K[i - 1][0] == this && K.splice(i - 1, 1);
                        K.push([this, h]), d.data(this, "_jqs_pending", !0)
                    } else
                        h.call(this)
                })
            }, d.fn.sparkline.defaults = f(), d.sparkline_display_visible = function () {
                var a, b, c, e = [];
                for (b = 0, c = K.length; b < c; b++)
                    a = K[b][0], d(a).is(":visible") && !d(a).parents().is(":hidden") ? (K[b][1].call(a), d.data(K[b][0], "_jqs_pending", !1), e.push(b)) : !d(a).closest("html").length && !d.data(a, "_jqs_pending") && (d.data(K[b][0], "_jqs_pending", !1), e.push(b));
                for (b = e.length; b; b--)
                    K.splice(e[b - 1], 1)
            }, d.fn.sparkline.options = g({init: function (a, b) {
                    var c, f, g, h;
                    this.userOptions = b = b || {}, this.tag = a, this.tagValCache = {}, f = d.fn.sparkline.defaults, g = f.common, this.tagOptionsPrefix = b.enableTagOptions && (b.tagOptionsPrefix || g.tagOptionsPrefix), h = this.getTagSetting("type"), h === e ? c = f[b.type || g.type] : c = f[h], this.mergedOptions = d.extend({}, g, c, b)
                }, getTagSetting: function (a) {
                    var b = this.tagOptionsPrefix, d, f, g, h;
                    if (b === !1 || b === c)
                        return e;
                    if (this.tagValCache.hasOwnProperty(a))
                        d = this.tagValCache.key;
                    else {
                        d = this.tag.getAttribute(b + a);
                        if (d === c || d === null)
                            d = e;
                        else if (d.substr(0, 1) === "[") {
                            d = d.substr(1, d.length - 2).split(",");
                            for (f = d.length; f--; )
                                d[f] = k(d[f].replace(/(^\s*)|(\s*$)/g, ""))
                        } else if (d.substr(0, 1) === "{") {
                            g = d.substr(1, d.length - 2).split(","), d = {};
                            for (f = g.length; f--; )
                                h = g[f].split(":", 2), d[h[0].replace(/(^\s*)|(\s*$)/g, "")] = k(h[1].replace(/(^\s*)|(\s*$)/g, ""))
                        } else
                            d = k(d);
                        this.tagValCache.key = d
                    }
                    return d
                }, get: function (a, b) {
                    var d = this.getTagSetting(a), f;
                    return d !== e ? d : (f = this.mergedOptions[a]) === c ? b : f
                }}), d.fn.sparkline._base = g({disabled: !1, init: function (a, b, e, f, g) {
                    this.el = a, this.$el = d(a), this.values = b, this.options = e, this.width = f, this.height = g, this.currentRegion = c
                }, initTarget: function () {
                    var a = !this.options.get("disableInteraction");
                    (this.target = this.$el.simpledraw(this.width, this.height, this.options.get("composite"), a)) ? (this.canvasWidth = this.target.pixelWidth, this.canvasHeight = this.target.pixelHeight) : this.disabled = !0
                }, render: function () {
                    return this.disabled ? (this.el.innerHTML = "", !1) : !0
                }, getRegion: function (a, b) {}, setRegionHighlight: function (a, b, d) {
                    var e = this.currentRegion, f = !this.options.get("disableHighlight"), g;
                    return b > this.canvasWidth || d > this.canvasHeight || b < 0 || d < 0 ? null : (g = this.getRegion(a, b, d), e !== g ? (e !== c && f && this.removeHighlight(), this.currentRegion = g, g !== c && f && this.renderHighlight(), !0) : !1)
                }, clearRegionHighlight: function () {
                    return this.currentRegion !== c ? (this.removeHighlight(), this.currentRegion = c, !0) : !1
                }, renderHighlight: function () {
                    this.changeHighlight(!0)
                }, removeHighlight: function () {
                    this.changeHighlight(!1)
                }, changeHighlight: function (a) {}, getCurrentRegionTooltip: function () {
                    var a = this.options, b = "", e = [], f, g, i, j, k, l, m, n, o, p, q, r, s, t;
                    if (this.currentRegion === c)
                        return"";
                    f = this.getCurrentRegionFields(), q = a.get("tooltipFormatter");
                    if (q)
                        return q(this, a, f);
                    a.get("tooltipChartTitle") && (b += '<div class="jqs jqstitle">' + a.get("tooltipChartTitle") + "</div>\n"), g = this.options.get("tooltipFormat");
                    if (!g)
                        return"";
                    d.isArray(g) || (g = [g]), d.isArray(f) || (f = [f]), m = this.options.get("tooltipFormatFieldlist"), n = this.options.get("tooltipFormatFieldlistKey");
                    if (m && n) {
                        o = [];
                        for (l = f.length; l--; )
                            p = f[l][n], (t = d.inArray(p, m)) != -1 && (o[t] = f[l]);
                        f = o
                    }
                    i = g.length, s = f.length;
                    for (l = 0; l < i; l++) {
                        r = g[l], typeof r == "string" && (r = new h(r)), j = r.fclass || "jqsfield";
                        for (t = 0; t < s; t++)
                            if (!f[t].isNull || !a.get("tooltipSkipNull"))
                                d.extend(f[t], {prefix: a.get("tooltipPrefix"), suffix: a.get("tooltipSuffix")}), k = r.render(f[t], a.get("tooltipValueLookups"), a), e.push('<div class="' + j + '">' + k + "</div>")
                    }
                    return e.length ? b + e.join("\n") : ""
                }, getCurrentRegionFields: function () {}, calcHighlightColor: function (a, c) {
                    var d = c.get("highlightColor"), e = c.get("highlightLighten"), f, g, h, j;
                    if (d)
                        return d;
                    if (e) {
                        f = /^#([0-9a-f])([0-9a-f])([0-9a-f])$/i.exec(a) || /^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i.exec(a);
                        if (f) {
                            h = [], g = a.length === 4 ? 16 : 1;
                            for (j = 0; j < 3; j++)
                                h[j] = i(b.round(parseInt(f[j + 1], 16) * g * e), 0, 255);
                            return"rgb(" + h.join(",") + ")"
                        }
                    }
                    return a
                }}), w = {changeHighlight: function (a) {
                    var b = this.currentRegion, c = this.target, e = this.regionShapes[b], f;
                    e && (f = this.renderRegion(b, a), d.isArray(f) || d.isArray(e) ? (c.replaceWithShapes(e, f), this.regionShapes[b] = d.map(f, function (a) {
                        return a.id
                    })) : (c.replaceWithShape(e, f), this.regionShapes[b] = f.id))
                }, render: function () {
                    var a = this.values, b = this.target, c = this.regionShapes, e, f, g, h;
                    if (!this.cls._super.render.call(this))
                        return;
                    for (g = a.length; g--; ) {
                        e = this.renderRegion(g);
                        if (e)
                            if (d.isArray(e)) {
                                f = [];
                                for (h = e.length; h--; )
                                    e[h].append(), f.push(e[h].id);
                                c[g] = f
                            } else
                                e.append(), c[g] = e.id;
                        else
                            c[g] = null
                    }
                    b.render()
                }}, d.fn.sparkline.line = x = g(d.fn.sparkline._base, {type: "line", init: function (a, b, c, d, e) {
                    x._super.init.call(this, a, b, c, d, e), this.vertices = [], this.regionMap = [], this.xvalues = [], this.yvalues = [], this.yminmax = [], this.hightlightSpotId = null, this.lastShapeId = null, this.initTarget()
                }, getRegion: function (a, b, d) {
                    var e, f = this.regionMap;
                    for (e = f.length; e--; )
                        if (f[e] !== null && b >= f[e][0] && b <= f[e][1])
                            return f[e][2];
                    return c
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion;
                    return{isNull: this.yvalues[a] === null, x: this.xvalues[a], y: this.yvalues[a], color: this.options.get("lineColor"), fillColor: this.options.get("fillColor"), offset: a}
                }, renderHighlight: function () {
                    var a = this.currentRegion, b = this.target, d = this.vertices[a], e = this.options, f = e.get("spotRadius"), g = e.get("highlightSpotColor"), h = e.get("highlightLineColor"), i, j;
                    if (!d)
                        return;
                    f && g && (i = b.drawCircle(d[0], d[1], f, c, g), this.highlightSpotId = i.id, b.insertAfterShape(this.lastShapeId, i)), h && (j = b.drawLine(d[0], this.canvasTop, d[0], this.canvasTop + this.canvasHeight, h), this.highlightLineId = j.id, b.insertAfterShape(this.lastShapeId, j))
                }, removeHighlight: function () {
                    var a = this.target;
                    this.highlightSpotId && (a.removeShapeId(this.highlightSpotId), this.highlightSpotId = null), this.highlightLineId && (a.removeShapeId(this.highlightLineId), this.highlightLineId = null)
                }, scanValues: function () {
                    var a = this.values, c = a.length, d = this.xvalues, e = this.yvalues, f = this.yminmax, g, h, i, j, k;
                    for (g = 0; g < c; g++)
                        h = a[g], i = typeof a[g] == "string", j = typeof a[g] == "object" && a[g]instanceof Array, k = i && a[g].split(":"), i && k.length === 2 ? (d.push(Number(k[0])), e.push(Number(k[1])), f.push(Number(k[1]))) : j ? (d.push(h[0]), e.push(h[1]), f.push(h[1])) : (d.push(g), a[g] === null || a[g] === "null" ? e.push(null) : (e.push(Number(h)), f.push(Number(h))));
                    this.options.get("xvalues") && (d = this.options.get("xvalues")), this.maxy = this.maxyorg = b.max.apply(b, f), this.miny = this.minyorg = b.min.apply(b, f), this.maxx = b.max.apply(b, d), this.minx = b.min.apply(b, d), this.xvalues = d, this.yvalues = e, this.yminmax = f
                }, processRangeOptions: function () {
                    var a = this.options, b = a.get("normalRangeMin"), d = a.get("normalRangeMax");
                    b !== c && (b < this.miny && (this.miny = b), d > this.maxy && (this.maxy = d)), a.get("chartRangeMin") !== c && (a.get("chartRangeClip") || a.get("chartRangeMin") < this.miny) && (this.miny = a.get("chartRangeMin")), a.get("chartRangeMax") !== c && (a.get("chartRangeClip") || a.get("chartRangeMax") > this.maxy) && (this.maxy = a.get("chartRangeMax")), a.get("chartRangeMinX") !== c && (a.get("chartRangeClipX") || a.get("chartRangeMinX") < this.minx) && (this.minx = a.get("chartRangeMinX")), a.get("chartRangeMaxX") !== c && (a.get("chartRangeClipX") || a.get("chartRangeMaxX") > this.maxx) && (this.maxx = a.get("chartRangeMaxX"))
                }, drawNormalRange: function (a, d, e, f, g) {
                    var h = this.options.get("normalRangeMin"), i = this.options.get("normalRangeMax"), j = d + b.round(e - e * ((i - this.miny) / g)), k = b.round(e * (i - h) / g);
                    this.target.drawRect(a, j, f, k, c, this.options.get("normalRangeColor")).append()
                }, render: function () {
                    var a = this.options, e = this.target, f = this.canvasWidth, g = this.canvasHeight, h = this.vertices, i = a.get("spotRadius"), j = this.regionMap, k, l, m, n, o, p, q, r, s, u, v, w, y, z, A, B, C, D, E, F, G, H, I, J, K;
                    if (!x._super.render.call(this))
                        return;
                    this.scanValues(), this.processRangeOptions(), I = this.xvalues, J = this.yvalues;
                    if (!this.yminmax.length || this.yvalues.length < 2)
                        return;
                    n = o = 0, k = this.maxx - this.minx === 0 ? 1 : this.maxx - this.minx, l = this.maxy - this.miny === 0 ? 1 : this.maxy - this.miny, m = this.yvalues.length - 1, i && (f < i * 4 || g < i * 4) && (i = 0);
                    if (i) {
                        G = a.get("highlightSpotColor") && !a.get("disableInteraction");
                        if (G || a.get("minSpotColor") || a.get("spotColor") && J[m] === this.miny)
                            g -= b.ceil(i);
                        if (G || a.get("maxSpotColor") || a.get("spotColor") && J[m] === this.maxy)
                            g -= b.ceil(i), n += b.ceil(i);
                        if (G || (a.get("minSpotColor") || a.get("maxSpotColor")) && (J[0] === this.miny || J[0] === this.maxy))
                            o += b.ceil(i), f -= b.ceil(i);
                        if (G || a.get("spotColor") || a.get("minSpotColor") || a.get("maxSpotColor") && (J[m] === this.miny || J[m] === this.maxy))
                            f -= b.ceil(i)
                    }
                    g--, a.get("normalRangeMin") !== c && !a.get("drawNormalOnTop") && this.drawNormalRange(o, n, g, f, l), q = [], r = [q], z = A = null, B = J.length;
                    for (K = 0; K < B; K++)
                        s = I[K], v = I[K + 1], u = J[K], w = o + b.round((s - this.minx) * (f / k)), y = K < B - 1 ? o + b.round((v - this.minx) * (f / k)) : f, A = w + (y - w) / 2, j[K] = [z || 0, A, K], z = A, u === null ? K && (J[K - 1] !== null && (q = [], r.push(q)), h.push(null)) : (u < this.miny && (u = this.miny), u > this.maxy && (u = this.maxy), q.length || q.push([w, n + g]), p = [w, n + b.round(g - g * ((u - this.miny) / l))], q.push(p), h.push(p));
                    C = [], D = [], E = r.length;
                    for (K = 0; K < E; K++)
                        q = r[K], q.length && (a.get("fillColor") && (q.push([q[q.length - 1][0], n + g]), D.push(q.slice(0)), q.pop()), q.length > 2 && (q[0] = [q[0][0], q[1][1]]), C.push(q));
                    E = D.length;
                    for (K = 0; K < E; K++)
                        e.drawShape(D[K], a.get("fillColor"), a.get("fillColor")).append();
                    a.get("normalRangeMin") !== c && a.get("drawNormalOnTop") && this.drawNormalRange(o, n, g, f, l), E = C.length;
                    for (K = 0; K < E; K++)
                        e.drawShape(C[K], a.get("lineColor"), c, a.get("lineWidth")).append();
                    if (i && a.get("valueSpots")) {
                        F = a.get("valueSpots"), F.get === c && (F = new t(F));
                        for (K = 0; K < B; K++)
                            H = F.get(J[K]), H && e.drawCircle(o + b.round((I[K] - this.minx) * (f / k)), n + b.round(g - g * ((J[K] - this.miny) / l)), i, c, H).append()
                    }
                    i && a.get("spotColor") && J[m] !== null && e.drawCircle(o + b.round((I[I.length - 1] - this.minx) * (f / k)), n + b.round(g - g * ((J[m] - this.miny) / l)), i, c, a.get("spotColor")).append(), this.maxy !== this.minyorg && (i && a.get("minSpotColor") && (s = I[d.inArray(this.minyorg, J)], e.drawCircle(o + b.round((s - this.minx) * (f / k)), n + b.round(g - g * ((this.minyorg - this.miny) / l)), i, c, a.get("minSpotColor")).append()), i && a.get("maxSpotColor") && (s = I[d.inArray(this.maxyorg, J)], e.drawCircle(o + b.round((s - this.minx) * (f / k)), n + b.round(g - g * ((this.maxyorg - this.miny) / l)), i, c, a.get("maxSpotColor")).append())), this.lastShapeId = e.getLastShapeId(), this.canvasTop = n, e.render()
                }}), d.fn.sparkline.bar = y = g(d.fn.sparkline._base, w, {type: "bar", init: function (a, e, f, g, h) {
                    var j = parseInt(f.get("barWidth"), 10), n = parseInt(f.get("barSpacing"), 10), o = f.get("chartRangeMin"), p = f.get("chartRangeMax"), q = f.get("chartRangeClip"), r = Infinity, s = -Infinity, u, v, w, x, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R;
                    y._super.init.call(this, a, e, f, g, h);
                    for (A = 0, B = e.length; A < B; A++) {
                        O = e[A], u = typeof O == "string" && O.indexOf(":") > -1;
                        if (u || d.isArray(O))
                            J = !0, u && (O = e[A] = l(O.split(":"))), O = m(O, null), v = b.min.apply(b, O), w = b.max.apply(b, O), v < r && (r = v), w > s && (s = w)
                    }
                    this.stacked = J, this.regionShapes = {}, this.barWidth = j, this.barSpacing = n, this.totalBarWidth = j + n, this.width = g = e.length * j + (e.length - 1) * n, this.initTarget(), q && (H = o === c ? -Infinity : o, I = p === c ? Infinity : p), z = [], x = J ? [] : z;
                    var S = [], T = [];
                    for (A = 0, B = e.length; A < B; A++)
                        if (J) {
                            K = e[A], e[A] = N = [], S[A] = 0, x[A] = T[A] = 0;
                            for (L = 0, M = K.length; L < M; L++)
                                O = N[L] = q ? i(K[L], H, I) : K[L], O !== null && (O > 0 && (S[A] += O), r < 0 && s > 0 ? O < 0 ? T[A] += b.abs(O) : x[A] += O : x[A] += b.abs(O - (O < 0 ? s : r)), z.push(O))
                        } else
                            O = q ? i(e[A], H, I) : e[A], O = e[A] = k(O), O !== null && z.push(O);
                    this.max = G = b.max.apply(b, z), this.min = F = b.min.apply(b, z), this.stackMax = s = J ? b.max.apply(b, S) : G, this.stackMin = r = J ? b.min.apply(b, z) : F, f.get("chartRangeMin") !== c && (f.get("chartRangeClip") || f.get("chartRangeMin") < F) && (F = f.get("chartRangeMin")), f.get("chartRangeMax") !== c && (f.get("chartRangeClip") || f.get("chartRangeMax") > G) && (G = f.get("chartRangeMax")), this.zeroAxis = D = f.get("zeroAxis", !0), F <= 0 && G >= 0 && D ? E = 0 : D == 0 ? E = F : F > 0 ? E = F : E = G, this.xaxisOffset = E, C = J ? b.max.apply(b, x) + b.max.apply(b, T) : G - F, this.canvasHeightEf = D && F < 0 ? this.canvasHeight - 2 : this.canvasHeight - 1, F < E ? (Q = J && G >= 0 ? s : G, P = (Q - E) / C * this.canvasHeight, P !== b.ceil(P) && (this.canvasHeightEf -= 2, P = b.ceil(P))) : P = this.canvasHeight, this.yoffset = P, d.isArray(f.get("colorMap")) ? (this.colorMapByIndex = f.get("colorMap"), this.colorMapByValue = null) : (this.colorMapByIndex = null, this.colorMapByValue = f.get("colorMap"), this.colorMapByValue && this.colorMapByValue.get === c && (this.colorMapByValue = new t(this.colorMapByValue))), this.range = C
                }, getRegion: function (a, d, e) {
                    var f = b.floor(d / this.totalBarWidth);
                    return f < 0 || f >= this.values.length ? c : f
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion, b = r(this.values[a]), c = [], d, e;
                    for (e = b.length; e--; )
                        d = b[e], c.push({isNull: d === null, value: d, color: this.calcColor(e, d, a), offset: a});
                    return c
                }, calcColor: function (a, b, e) {
                    var f = this.colorMapByIndex, g = this.colorMapByValue, h = this.options, i, j;
                    return this.stacked ? i = h.get("stackedBarColor") : i = b < 0 ? h.get("negBarColor") : h.get("barColor"), b === 0 && h.get("zeroColor") !== c && (i = h.get("zeroColor")), g && (j = g.get(b)) ? i = j : f && f.length > e && (i = f[e]), d.isArray(i) ? i[a % i.length] : i
                }, renderRegion: function (a, e) {
                    var f = this.values[a], g = this.options, h = this.xaxisOffset, i = [], j = this.range, k = this.stacked, l = this.target, m = a * this.totalBarWidth, n = this.canvasHeightEf, p = this.yoffset, q, r, s, t, u, v, w, x, y, z;
                    f = d.isArray(f) ? f : [f], w = f.length, x = f[0], t = o(null, f), z = o(h, f, !0);
                    if (t)
                        return g.get("nullColor") ? (s = e ? g.get("nullColor") : this.calcHighlightColor(g.get("nullColor"), g), q = p > 0 ? p - 1 : p, l.drawRect(m, q, this.barWidth - 1, 0, s, s)) : c;
                    u = p;
                    for (v = 0; v < w; v++) {
                        x = f[v];
                        if (k && x === h) {
                            if (!z || y)
                                continue;
                            y = !0
                        }
                        j > 0 ? r = b.floor(n * (b.abs(x - h) / j)) + 1 : r = 1, x < h || x === h && p === 0 ? (q = u, u += r) : (q = p - r, p -= r), s = this.calcColor(v, x, a), e && (s = this.calcHighlightColor(s, g)), i.push(l.drawRect(m, q, this.barWidth - 1, r - 1, s, s))
                    }
                    return i.length === 1 ? i[0] : i
                }}), d.fn.sparkline.tristate = z = g(d.fn.sparkline._base, w, {type: "tristate", init: function (a, b, e, f, g) {
                    var h = parseInt(e.get("barWidth"), 10), i = parseInt(e.get("barSpacing"), 10);
                    z._super.init.call(this, a, b, e, f, g), this.regionShapes = {}, this.barWidth = h, this.barSpacing = i, this.totalBarWidth = h + i, this.values = d.map(b, Number), this.width = f = b.length * h + (b.length - 1) * i, d.isArray(e.get("colorMap")) ? (this.colorMapByIndex = e.get("colorMap"), this.colorMapByValue = null) : (this.colorMapByIndex = null, this.colorMapByValue = e.get("colorMap"), this.colorMapByValue && this.colorMapByValue.get === c && (this.colorMapByValue = new t(this.colorMapByValue))), this.initTarget()
                }, getRegion: function (a, c, d) {
                    return b.floor(c / this.totalBarWidth)
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion;
                    return{isNull: this.values[a] === c, value: this.values[a], color: this.calcColor(this.values[a], a), offset: a}
                }, calcColor: function (a, b) {
                    var c = this.values, d = this.options, e = this.colorMapByIndex, f = this.colorMapByValue, g, h;
                    return f && (h = f.get(a)) ? g = h : e && e.length > b ? g = e[b] : c[b] < 0 ? g = d.get("negBarColor") : c[b] > 0 ? g = d.get("posBarColor") : g = d.get("zeroBarColor"), g
                }, renderRegion: function (a, c) {
                    var d = this.values, e = this.options, f = this.target, g, h, i, j, k, l;
                    g = f.pixelHeight, i = b.round(g / 2), j = a * this.totalBarWidth, d[a] < 0 ? (k = i, h = i - 1) : d[a] > 0 ? (k = 0, h = i - 1) : (k = i - 1, h = 2), l = this.calcColor(d[a], a);
                    if (l === null)
                        return;
                    return c && (l = this.calcHighlightColor(l, e)), f.drawRect(j, k, this.barWidth - 1, h - 1, l, l)
                }}), d.fn.sparkline.discrete = A = g(d.fn.sparkline._base, w, {type: "discrete", init: function (a, e, f, g, h) {
                    A._super.init.call(this, a, e, f, g, h), this.regionShapes = {}, this.values = e = d.map(e, Number), this.min = b.min.apply(b, e), this.max = b.max.apply(b, e), this.range = this.max - this.min, this.width = g = f.get("width") === "auto" ? e.length * 2 : this.width, this.interval = b.floor(g / e.length), this.itemWidth = g / e.length, f.get("chartRangeMin") !== c && (f.get("chartRangeClip") || f.get("chartRangeMin") < this.min) && (this.min = f.get("chartRangeMin")), f.get("chartRangeMax") !== c && (f.get("chartRangeClip") || f.get("chartRangeMax") > this.max) && (this.max = f.get("chartRangeMax")), this.initTarget(), this.target && (this.lineHeight = f.get("lineHeight") === "auto" ? b.round(this.canvasHeight * .3) : f.get("lineHeight"))
                }, getRegion: function (a, c, d) {
                    return b.floor(c / this.itemWidth)
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion;
                    return{isNull: this.values[a] === c, value: this.values[a], offset: a}
                }, renderRegion: function (a, c) {
                    var d = this.values, e = this.options, f = this.min, g = this.max, h = this.range, j = this.interval, k = this.target, l = this.canvasHeight, m = this.lineHeight, n = l - m, o, p, q, r;
                    return p = i(d[a], f, g), r = a * j, o = b.round(n - n * ((p - f) / h)), q = e.get("thresholdColor") && p < e.get("thresholdValue") ? e.get("thresholdColor") : e.get("lineColor"), c && (q = this.calcHighlightColor(q, e)), k.drawLine(r, o, r, o + m, q)
                }}), d.fn.sparkline.bullet = B = g(d.fn.sparkline._base, {type: "bullet", init: function (a, d, e, f, g) {
                    var h, i, j;
                    B._super.init.call(this, a, d, e, f, g), this.values = d = l(d), j = d.slice(), j[0] = j[0] === null ? j[2] : j[0], j[1] = d[1] === null ? j[2] : j[1], h = b.min.apply(b, d), i = b.max.apply(b, d), e.get("base") === c ? h = h < 0 ? h : 0 : h = e.get("base"), this.min = h, this.max = i, this.range = i - h, this.shapes = {}, this.valueShapes = {}, this.regiondata = {}, this.width = f = e.get("width") === "auto" ? "4.0em" : f, this.target = this.$el.simpledraw(f, g, e.get("composite")), d.length || (this.disabled = !0), this.initTarget()
                }, getRegion: function (a, b, d) {
                    var e = this.target.getShapeAt(a, b, d);
                    return e !== c && this.shapes[e] !== c ? this.shapes[e] : c
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion;
                    return{fieldkey: a.substr(0, 1), value: this.values[a.substr(1)], region: a}
                }, changeHighlight: function (a) {
                    var b = this.currentRegion, c = this.valueShapes[b], d;
                    delete this.shapes[c];
                    switch (b.substr(0, 1)) {
                        case"r":
                            d = this.renderRange(b.substr(1), a);
                            break;
                            case"p":
                            d = this.renderPerformance(a);
                            break;
                            case"t":
                            d = this.renderTarget(a)
                        }
                    this.valueShapes[b] = d.id, this.shapes[d.id] = b, this.target.replaceWithShape(c, d)
                }, renderRange: function (a, c) {
                    var d = this.values[a], e = b.round(this.canvasWidth * ((d - this.min) / this.range)), f = this.options.get("rangeColors")[a - 2];
                    return c && (f = this.calcHighlightColor(f, this.options)), this.target.drawRect(0, 0, e - 1, this.canvasHeight - 1, f, f)
                }, renderPerformance: function (a) {
                    var c = this.values[1], d = b.round(this.canvasWidth * ((c - this.min) / this.range)), e = this.options.get("performanceColor");
                    return a && (e = this.calcHighlightColor(e, this.options)), this.target.drawRect(0, b.round(this.canvasHeight * .3), d - 1, b.round(this.canvasHeight * .4) - 1, e, e)
                }, renderTarget: function (a) {
                    var c = this.values[0], d = b.round(this.canvasWidth * ((c - this.min) / this.range) - this.options.get("targetWidth") / 2), e = b.round(this.canvasHeight * .1), f = this.canvasHeight - e * 2, g = this.options.get("targetColor");
                    return a && (g = this.calcHighlightColor(g, this.options)), this.target.drawRect(d, e, this.options.get("targetWidth") - 1, f - 1, g, g)
                }, render: function () {
                    var a = this.values.length, b = this.target, c, d;
                    if (!B._super.render.call(this))
                        return;
                    for (c = 2; c < a; c++)
                        d = this.renderRange(c).append(), this.shapes[d.id] = "r" + c, this.valueShapes["r" + c] = d.id;
                    this.values[1] !== null && (d = this.renderPerformance().append(), this.shapes[d.id] = "p1", this.valueShapes.p1 = d.id), this.values[0] !== null && (d = this.renderTarget().append(), this.shapes[d.id] = "t0", this.valueShapes.t0 = d.id), b.render()
                }}), d.fn.sparkline.pie = C = g(d.fn.sparkline._base, {type: "pie", init: function (a, c, e, f, g) {
                    var h = 0, i;
                    C._super.init.call(this, a, c, e, f, g), this.shapes = {}, this.valueShapes = {}, this.values = c = d.map(c, Number), e.get("width") === "auto" && (this.width = this.height);
                    if (c.length > 0)
                        for (i = c.length; i--; )
                            h += c[i];
                    this.total = h, this.initTarget(), this.radius = b.floor(b.min(this.canvasWidth, this.canvasHeight) / 2)
                }, getRegion: function (a, b, d) {
                    var e = this.target.getShapeAt(a, b, d);
                    return e !== c && this.shapes[e] !== c ? this.shapes[e] : c
                }, getCurrentRegionFields: function () {
                    var a = this.currentRegion;
                    return{isNull: this.values[a] === c, value: this.values[a], percent: this.values[a] / this.total * 100, color: this.options.get("sliceColors")[a % this.options.get("sliceColors").length], offset: a}
                }, changeHighlight: function (a) {
                    var b = this.currentRegion, c = this.renderSlice(b, a), d = this.valueShapes[b];
                    delete this.shapes[d], this.target.replaceWithShape(d, c), this.valueShapes[b] = c.id, this.shapes[c.id] = b
                }, renderSlice: function (a, d) {
                    var e = this.target, f = this.options, g = this.radius, h = f.get("borderWidth"), i = f.get("offset"), j = 2 * b.PI, k = this.values, l = this.total, m = i ? 2 * b.PI * (i / 360) : 0, n, o, p, q, r;
                    q = k.length;
                    for (p = 0; p < q; p++) {
                        n = m, o = m, l > 0 && (o = m + j * (k[p] / l));
                        if (a === p)
                            return r = f.get("sliceColors")[p % f.get("sliceColors").length], d && (r = this.calcHighlightColor(r, f)), e.drawPieSlice(g, g, g - h, n, o, c, r);
                        m = o
                    }
                }, render: function () {
                    var a = this.target, d = this.values, e = this.options, f = this.radius, g = e.get("borderWidth"), h, i;
                    if (!C._super.render.call(this))
                        return;
                    g && a.drawCircle(f, f, b.floor(f - g / 2), e.get("borderColor"), c, g).append();
                    for (i = d.length; i--; )
                        d[i] && (h = this.renderSlice(i).append(), this.valueShapes[i] = h.id, this.shapes[h.id] = i);
                    a.render()
                }}), d.fn.sparkline.box = D = g(d.fn.sparkline._base, {type: "box", init: function (a, b, c, e, f) {
                    D._super.init.call(this, a, b, c, e, f), this.values = d.map(b, Number), this.width = c.get("width") === "auto" ? "4.0em" : e, this.initTarget(), this.values.length || (this.disabled = 1)
                }, getRegion: function () {
                    return 1
                }, getCurrentRegionFields: function () {
                    var a = [{field: "lq", value: this.quartiles[0]}, {field: "med", value: this.quartiles
                                    [1]}, {field: "uq", value: this.quartiles[2]}];
                    return this.loutlier !== c && a.push({field: "lo", value: this.loutlier}), this.routlier !== c && a.push({field: "ro", value: this.routlier}), this.lwhisker !== c && a.push({field: "lw", value: this.lwhisker}), this.rwhisker !== c && a.push({field: "rw", value: this.rwhisker}), a
                }, render: function () {
                    var a = this.target, d = this.values, e = d.length, f = this.options, g = this.canvasWidth, h = this.canvasHeight, i = f.get("chartRangeMin") === c ? b.min.apply(b, d) : f.get("chartRangeMin"), k = f.get("chartRangeMax") === c ? b.max.apply(b, d) : f.get("chartRangeMax"), l = 0, m, n, o, p, q, r, s, t, u, v, w;
                    if (!D._super.render.call(this))
                        return;
                    if (f.get("raw"))
                        f.get("showOutliers") && d.length > 5 ? (n = d[0], m = d[1], p = d[2], q = d[3], r = d[4], s = d[5], t = d[6]) : (m = d[0], p = d[1], q = d[2], r = d[3], s = d[4]);
                    else {
                        d.sort(function (a, b) {
                            return a - b
                        }), p = j(d, 1), q = j(d, 2), r = j(d, 3), o = r - p;
                        if (f.get("showOutliers")) {
                            m = s = c;
                            for (u = 0; u < e; u++)
                                m === c && d[u] > p - o * f.get("outlierIQR") && (m = d[u]), d[u] < r + o * f.get("outlierIQR") && (s = d[u]);
                            n = d[0], t = d[e - 1]
                        } else
                            m = d[0], s = d[e - 1]
                    }
                    this.quartiles = [p, q, r], this.lwhisker = m, this.rwhisker = s, this.loutlier = n, this.routlier = t, w = g / (k - i + 1), f.get("showOutliers") && (l = b.ceil(f.get("spotRadius")), g -= 2 * b.ceil(f.get("spotRadius")), w = g / (k - i + 1), n < m && a.drawCircle((n - i) * w + l, h / 2, f.get("spotRadius"), f.get("outlierLineColor"), f.get("outlierFillColor")).append(), t > s && a.drawCircle((t - i) * w + l, h / 2, f.get("spotRadius"), f.get("outlierLineColor"), f.get("outlierFillColor")).append()), a.drawRect(b.round((p - i) * w + l), b.round(h * .1), b.round((r - p) * w), b.round(h * .8), f.get("boxLineColor"), f.get("boxFillColor")).append(), a.drawLine(b.round((m - i) * w + l), b.round(h / 2), b.round((p - i) * w + l), b.round(h / 2), f.get("lineColor")).append(), a.drawLine(b.round((m - i) * w + l), b.round(h / 4), b.round((m - i) * w + l), b.round(h - h / 4), f.get("whiskerColor")).append(), a.drawLine(b.round((s - i) * w + l), b.round(h / 2), b.round((r - i) * w + l), b.round(h / 2), f.get("lineColor")).append(), a.drawLine(b.round((s - i) * w + l), b.round(h / 4), b.round((s - i) * w + l), b.round(h - h / 4), f.get("whiskerColor")).append(), a.drawLine(b.round((q - i) * w + l), b.round(h * .1), b.round((q - i) * w + l), b.round(h * .9), f.get("medianColor")).append(), f.get("target") && (v = b.ceil(f.get("spotRadius")), a.drawLine(b.round((f.get("target") - i) * w + l), b.round(h / 2 - v), b.round((f.get("target") - i) * w + l), b.round(h / 2 + v), f.get("targetColor")).append(), a.drawLine(b.round((f.get("target") - i) * w + l - v), b.round(h / 2), b.round((f.get("target") - i) * w + l + v), b.round(h / 2), f.get("targetColor")).append()), a.render()
                }}), G = g({init: function (a, b, c, d) {
                    this.target = a, this.id = b, this.type = c, this.args = d
                }, append: function () {
                    return this.target.appendShape(this), this
                }}), H = g({_pxregex: /(\d+)(px)?\s*$/i, init: function (a, b, c) {
                    if (!a)
                        return;
                    this.width = a, this.height = b, this.target = c, this.lastShapeId = null, c[0] && (c = c[0]), d.data(c, "_jqs_vcanvas", this)
                }, drawLine: function (a, b, c, d, e, f) {
                    return this.drawShape([[a, b], [c, d]], e, f)
                }, drawShape: function (a, b, c, d) {
                    return this._genShape("Shape", [a, b, c, d])
                }, drawCircle: function (a, b, c, d, e, f) {
                    return this._genShape("Circle", [a, b, c, d, e, f])
                }, drawPieSlice: function (a, b, c, d, e, f, g) {
                    return this._genShape("PieSlice", [a, b, c, d, e, f, g])
                }, drawRect: function (a, b, c, d, e, f) {
                    return this._genShape("Rect", [a, b, c, d, e, f])
                }, getElement: function () {
                    return this.canvas
                }, getLastShapeId: function () {
                    return this.lastShapeId
                }, reset: function () {
                    alert("reset not implemented")
                }, _insert: function (a, b) {
                    d(b).html(a)
                }, _calculatePixelDims: function (a, b, c) {
                    var e;
                    e = this._pxregex.exec(b), e ? this.pixelHeight = e[1] : this.pixelHeight = d(c).height(), e = this._pxregex.exec(a), e ? this.pixelWidth = e[1] : this.pixelWidth = d(c).width()
                }, _genShape: function (a, b) {
                    var c = L++;
                    return b.unshift(c), new G(this, c, a, b)
                }, appendShape: function (a) {
                    alert("appendShape not implemented")
                }, replaceWithShape: function (a, b) {
                    alert("replaceWithShape not implemented")
                }, insertAfterShape: function (a, b) {
                    alert("insertAfterShape not implemented")
                }, removeShapeId: function (a) {
                    alert("removeShapeId not implemented")
                }, getShapeAt: function (a, b, c) {
                    alert("getShapeAt not implemented")
                }, render: function () {
                    alert("render not implemented")
                }}), I = g(H, {init: function (b, e, f, g) {
                    I._super.init.call(this, b, e, f), this.canvas = a.createElement("canvas"), f[0] && (f = f[0]), d.data(f, "_jqs_vcanvas", this), d(this.canvas).css({display: "inline-block", width: b, height: e, verticalAlign: "top"}), this._insert(this.canvas, f), this._calculatePixelDims(b, e, this.canvas), this.canvas.width = this.pixelWidth, this.canvas.height = this.pixelHeight, this.interact = g, this.shapes = {}, this.shapeseq = [], this.currentTargetShapeId = c, d(this.canvas).css({width: this.pixelWidth, height: this.pixelHeight})
                }, _getContext: function (a, b, d) {
                    var e = this.canvas.getContext("2d");
                    return a !== c && (e.strokeStyle = a), e.lineWidth = d === c ? 1 : d, b !== c && (e.fillStyle = b), e
                }, reset: function () {
                    var a = this._getContext();
                    a.clearRect(0, 0, this.pixelWidth, this.pixelHeight), this.shapes = {}, this.shapeseq = [], this.currentTargetShapeId = c
                }, _drawShape: function (a, b, d, e, f) {
                    var g = this._getContext(d, e, f), h, i;
                    g.beginPath(), g.moveTo(b[0][0] + .5, b[0][1] + .5);
                    for (h = 1, i = b.length; h < i; h++)
                        g.lineTo(b[h][0] + .5, b[h][1] + .5);
                    d !== c && g.stroke(), e !== c && g.fill(), this.targetX !== c && this.targetY !== c && g.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = a)
                }, _drawCircle: function (a, d, e, f, g, h, i) {
                    var j = this._getContext(g, h, i);
                    j.beginPath(), j.arc(d, e, f, 0, 2 * b.PI, !1), this.targetX !== c && this.targetY !== c && j.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = a), g !== c && j.stroke(), h !== c && j.fill()
                }, _drawPieSlice: function (a, b, d, e, f, g, h, i) {
                    var j = this._getContext(h, i);
                    j.beginPath(), j.moveTo(b, d), j.arc(b, d, e, f, g, !1), j.lineTo(b, d), j.closePath(), h !== c && j.stroke(), i && j.fill(), this.targetX !== c && this.targetY !== c && j.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = a)
                }, _drawRect: function (a, b, c, d, e, f, g) {
                    return this._drawShape(a, [[b, c], [b + d, c], [b + d, c + e], [b, c + e], [b, c]], f, g)
                }, appendShape: function (a) {
                    return this.shapes[a.id] = a, this.shapeseq.push(a.id), this.lastShapeId = a.id, a.id
                }, replaceWithShape: function (a, b) {
                    var c = this.shapeseq, d;
                    this.shapes[b.id] = b;
                    for (d = c.length; d--; )
                        c[d] == a && (c[d] = b.id);
                    delete this.shapes[a]
                }, replaceWithShapes: function (a, b) {
                    var c = this.shapeseq, d = {}, e, f, g;
                    for (f = a.length; f--; )
                        d[a[f]] = !0;
                    for (f = c.length; f--; )
                        e = c[f], d[e] && (c.splice(f, 1), delete this.shapes[e], g = f);
                    for (f = b.length; f--; )
                        c.splice(g, 0, b[f].id), this.shapes[b[f].id] = b[f]
                }, insertAfterShape: function (a, b) {
                    var c = this.shapeseq, d;
                    for (d = c.length; d--; )
                        if (c[d] === a) {
                            c.splice(d + 1, 0, b.id), this.shapes[b.id] = b;
                            return
                        }
                }, removeShapeId: function (a) {
                    var b = this.shapeseq, c;
                    for (c = b.length; c--; )
                        if (b[c] === a) {
                            b.splice(c, 1);
                            break
                        }
                    delete this.shapes[a]
                }, getShapeAt: function (a, b, c) {
                    return this.targetX = b, this.targetY = c, this.render(), this.currentTargetShapeId
                }, render: function () {
                    var a = this.shapeseq, b = this.shapes, c = a.length, d = this._getContext(), e, f, g;
                    d.clearRect(0, 0, this.pixelWidth, this.pixelHeight);
                    for (g = 0; g < c; g++)
                        e = a[g], f = b[e], this["_draw" + f.type].apply(this, f.args);
                    this.interact || (this.shapes = {}, this.shapeseq = [])
                }}), J = g(H, {init: function (b, c, e) {
                    var f;
                    J._super.init.call(this, b, c, e), e[0] && (e = e[0]), d.data(e, "_jqs_vcanvas", this), this.canvas = a.createElement("span"), d(this.canvas).css({display: "inline-block", position: "relative", overflow: "hidden", width: b, height: c, margin: "0px", padding: "0px", verticalAlign: "top"}), this._insert(this.canvas, e), this._calculatePixelDims(b, c, this.canvas), this.canvas.width = this.pixelWidth, this.canvas.height = this.pixelHeight, f = '<v:group coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '"' + ' style="position:absolute;top:0;left:0;width:' + this.pixelWidth + "px;height=" + this.pixelHeight + 'px;"></v:group>', this.canvas.insertAdjacentHTML("beforeEnd", f), this.group = d(this.canvas).children()[0], this.rendered = !1, this.prerender = ""
                }, _drawShape: function (a, b, d, e, f) {
                    var g = [], h, i, j, k, l, m, n;
                    for (n = 0, m = b.length; n < m; n++)
                        g[n] = "" + b[n][0] + "," + b[n][1];
                    return h = g.splice(0, 1), f = f === c ? 1 : f, i = d === c ? ' stroked="false" ' : ' strokeWeight="' + f + 'px" strokeColor="' + d + '" ', j = e === c ? ' filled="false"' : ' fillColor="' + e + '" filled="true" ', k = g[0] === g[g.length - 1] ? "x " : "", l = '<v:shape coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '" ' + ' id="jqsshape' + a + '" ' + i + j + ' style="position:absolute;left:0px;top:0px;height:' + this.pixelHeight + "px;width:" + this.pixelWidth + 'px;padding:0px;margin:0px;" ' + ' path="m ' + h + " l " + g.join(", ") + " " + k + 'e">' + " </v:shape>", l
                }, _drawCircle: function (a, b, d, e, f, g, h) {
                    var i, j, k;
                    return b -= e, d -= e, i = f === c ? ' stroked="false" ' : ' strokeWeight="' + h + 'px" strokeColor="' + f + '" ', j = g === c ? ' filled="false"' : ' fillColor="' + g + '" filled="true" ', k = '<v:oval  id="jqsshape' + a + '" ' + i + j + ' style="position:absolute;top:' + d + "px; left:" + b + "px; width:" + e * 2 + "px; height:" + e * 2 + 'px"></v:oval>', k
                }, _drawPieSlice: function (a, d, e, f, g, h, i, j) {
                    var k, l, m, n, o, p, q, r;
                    if (g === h)
                        return"";
                    h - g === 2 * b.PI && (g = 0, h = 2 * b.PI), l = d + b.round(b.cos(g) * f), m = e + b.round(b.sin(g) * f), n = d + b.round(b.cos(h) * f), o = e + b.round(b.sin(h) * f);
                    if (l === n && m === o) {
                        if (h - g < b.PI)
                            return"";
                        l = n = d + f, m = o = e
                    }
                    return l === n && m === o && h - g < b.PI ? "" : (k = [d - f, e - f, d + f, e + f, l, m, n, o], p = i === c ? ' stroked="false" ' : ' strokeWeight="1px" strokeColor="' + i + '" ', q = j === c ? ' filled="false"' : ' fillColor="' + j + '" filled="true" ', r = '<v:shape coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '" ' + ' id="jqsshape' + a + '" ' + p + q + ' style="position:absolute;left:0px;top:0px;height:' + this.pixelHeight + "px;width:" + this.pixelWidth + 'px;padding:0px;margin:0px;" ' + ' path="m ' + d + "," + e + " wa " + k.join(", ") + ' x e">' + " </v:shape>", r)
                }, _drawRect: function (a, b, c, d, e, f, g) {
                    return this._drawShape(a, [[b, c], [b, c + e], [b + d, c + e], [b + d, c], [b, c]], f, g)
                }, reset: function () {
                    this.group.innerHTML = ""
                }, appendShape: function (a) {
                    var b = this["_draw" + a.type].apply(this, a.args);
                    return this.rendered ? this.group.insertAdjacentHTML("beforeEnd", b) : this.prerender += b, this.lastShapeId = a.id, a.id
                }, replaceWithShape: function (a, b) {
                    var c = d("#jqsshape" + a), e = this["_draw" + b.type].apply(this, b.args);
                    c[0].outerHTML = e
                }, replaceWithShapes: function (a, b) {
                    var c = d("#jqsshape" + a[0]), e = "", f = b.length, g;
                    for (g = 0; g < f; g++)
                        e += this["_draw" + b[g].type].apply(this, b[g].args);
                    c[0].outerHTML = e;
                    for (g = 1; g < a.length; g++)
                        d("#jqsshape" + a[g]).remove()
                }, insertAfterShape: function (a, b) {
                    var c = d("#jqsshape" + a), e = this["_draw" + b.type].apply(this, b.args);
                    c[0].insertAdjacentHTML("afterEnd", e)
                }, removeShapeId: function (a) {
                    var b = d("#jqsshape" + a);
                    this.group.removeChild(b[0])
                }, getShapeAt: function (a, b, c) {
                    var d = a.id.substr(8);
                    return d
                }, render: function () {
                    this.rendered || (this.group.innerHTML = this.prerender, this.rendered = !0)
                }})
        })
    })(document, Math);

//! moment.js
//! version : 2.12.0
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com
    !function (a, b) {
        "object" == typeof exports && "undefined" != typeof module ? module.exports = b() : "function" == typeof define && define.amd ? define(b) : a.moment = b()
    }(this, function () {
        "use strict";
        function a() {
            return Zc.apply(null, arguments)
        }
        function b(a) {
            Zc = a
        }
        function c(a) {
            return a instanceof Array || "[object Array]" === Object.prototype.toString.call(a)
        }
        function d(a) {
            return a instanceof Date || "[object Date]" === Object.prototype.toString.call(a)
        }
        function e(a, b) {
            var c, d = [];
            for (c = 0; c < a.length; ++c)
                d.push(b(a[c], c));
            return d
        }
        function f(a, b) {
            return Object.prototype.hasOwnProperty.call(a, b)
        }
        function g(a, b) {
            for (var c in b)
                f(b, c) && (a[c] = b[c]);
            return f(b, "toString") && (a.toString = b.toString), f(b, "valueOf") && (a.valueOf = b.valueOf), a
        }
        function h(a, b, c, d) {
            return Ia(a, b, c, d, !0).utc()
        }
        function i() {
            return{empty: !1, unusedTokens: [], unusedInput: [], overflow: -2, charsLeftOver: 0, nullInput: !1, invalidMonth: null, invalidFormat: !1, userInvalidated: !1, iso: !1}
        }
        function j(a) {
            return null == a._pf && (a._pf = i()), a._pf
        }
        function k(a) {
            if (null == a._isValid) {
                var b = j(a);
                a._isValid = !(isNaN(a._d.getTime()) || !(b.overflow < 0) || b.empty || b.invalidMonth || b.invalidWeekday || b.nullInput || b.invalidFormat || b.userInvalidated), a._strict && (a._isValid = a._isValid && 0 === b.charsLeftOver && 0 === b.unusedTokens.length && void 0 === b.bigHour)
            }
            return a._isValid
        }
        function l(a) {
            var b = h(NaN);
            return null != a ? g(j(b), a) : j(b).userInvalidated = !0, b
        }
        function m(a) {
            return void 0 === a
        }
        function n(a, b) {
            var c, d, e;
            if (m(b._isAMomentObject) || (a._isAMomentObject = b._isAMomentObject), m(b._i) || (a._i = b._i), m(b._f) || (a._f = b._f), m(b._l) || (a._l = b._l), m(b._strict) || (a._strict = b._strict), m(b._tzm) || (a._tzm = b._tzm), m(b._isUTC) || (a._isUTC = b._isUTC), m(b._offset) || (a._offset = b._offset), m(b._pf) || (a._pf = j(b)), m(b._locale) || (a._locale = b._locale), $c.length > 0)
                for (c in $c)
                    d = $c[c], e = b[d], m(e) || (a[d] = e);
            return a
        }
        function o(b) {
            n(this, b), this._d = new Date(null != b._d ? b._d.getTime() : NaN), _c === !1 && (_c = !0, a.updateOffset(this), _c = !1)
        }
        function p(a) {
            return a instanceof o || null != a && null != a._isAMomentObject
        }
        function q(a) {
            return 0 > a ? Math.ceil(a) : Math.floor(a)
        }
        function r(a) {
            var b = +a, c = 0;
            return 0 !== b && isFinite(b) && (c = q(b)), c
        }
        function s(a, b, c) {
            var d, e = Math.min(a.length, b.length), f = Math.abs(a.length - b.length), g = 0;
            for (d = 0; e > d; d++)
                (c && a[d] !== b[d] || !c && r(a[d]) !== r(b[d])) && g++;
            return g + f
        }
        function t(b) {
            a.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + b)
        }
        function u(a, b) {
            var c = !0;
            return g(function () {
                return c && (t(a + "\nArguments: " + Array.prototype.slice.call(arguments).join(", ") + "\n" + (new Error).stack), c = !1), b.apply(this, arguments)
            }, b)
        }
        function v(a, b) {
            ad[a] || (t(b), ad[a] = !0)
        }
        function w(a) {
            return a instanceof Function || "[object Function]" === Object.prototype.toString.call(a)
        }
        function x(a) {
            return"[object Object]" === Object.prototype.toString.call(a)
        }
        function y(a) {
            var b, c;
            for (c in a)
                b = a[c], w(b) ? this[c] = b : this["_" + c] = b;
            this._config = a, this._ordinalParseLenient = new RegExp(this._ordinalParse.source + "|" + /\d{1,2}/.source)
        }
        function z(a, b) {
            var c, d = g({}, a);
            for (c in b)
                f(b, c) && (x(a[c]) && x(b[c]) ? (d[c] = {}, g(d[c], a[c]), g(d[c], b[c])) : null != b[c] ? d[c] = b[c] : delete d[c]);
            return d
        }
        function A(a) {
            null != a && this.set(a)
        }
        function B(a) {
            return a ? a.toLowerCase().replace("_", "-") : a
        }
        function C(a) {
            for (var b, c, d, e, f = 0; f < a.length; ) {
                for (e = B(a[f]).split("-"), b = e.length, c = B(a[f + 1]), c = c ? c.split("-") : null; b > 0; ) {
                    if (d = D(e.slice(0, b).join("-")))
                        return d;
                    if (c && c.length >= b && s(e, c, !0) >= b - 1)
                        break;
                    b--
                }
                f++
            }
            return null
        }
        function D(a) {
            var b = null;
            if (!cd[a] && "undefined" != typeof module && module && module.exports)
                try {
                    b = bd._abbr, require("./locale/" + a), E(b)
                } catch (c) {
                }
            return cd[a]
        }
        function E(a, b) {
            var c;
            return a && (c = m(b) ? H(a) : F(a, b), c && (bd = c)), bd._abbr
        }
        function F(a, b) {
            return null !== b ? (b.abbr = a, null != cd[a] ? (v("defineLocaleOverride", "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale"), b = z(cd[a]._config, b)) : null != b.parentLocale && (null != cd[b.parentLocale] ? b = z(cd[b.parentLocale]._config, b) : v("parentLocaleUndefined", "specified parentLocale is not defined yet")), cd[a] = new A(b), E(a), cd[a]) : (delete cd[a], null)
        }
        function G(a, b) {
            if (null != b) {
                var c;
                null != cd[a] && (b = z(cd[a]._config, b)), c = new A(b), c.parentLocale = cd[a], cd[a] = c, E(a)
            } else
                null != cd[a] && (null != cd[a].parentLocale ? cd[a] = cd[a].parentLocale : null != cd[a] && delete cd[a]);
            return cd[a]
        }
        function H(a) {
            var b;
            if (a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a)
                return bd;
            if (!c(a)) {
                if (b = D(a))
                    return b;
                a = [a]
            }
            return C(a)
        }
        function I() {
            return Object.keys(cd)
        }
        function J(a, b) {
            var c = a.toLowerCase();
            dd[c] = dd[c + "s"] = dd[b] = a
        }
        function K(a) {
            return"string" == typeof a ? dd[a] || dd[a.toLowerCase()] : void 0
        }
        function L(a) {
            var b, c, d = {};
            for (c in a)
                f(a, c) && (b = K(c), b && (d[b] = a[c]));
            return d
        }
        function M(b, c) {
            return function (d) {
                return null != d ? (O(this, b, d), a.updateOffset(this, c), this) : N(this, b)
            }
        }
        function N(a, b) {
            return a.isValid() ? a._d["get" + (a._isUTC ? "UTC" : "") + b]() : NaN
        }
        function O(a, b, c) {
            a.isValid() && a._d["set" + (a._isUTC ? "UTC" : "") + b](c)
        }
        function P(a, b) {
            var c;
            if ("object" == typeof a)
                for (c in a)
                    this.set(c, a[c]);
            else if (a = K(a), w(this[a]))
                return this[a](b);
            return this
        }
        function Q(a, b, c) {
            var d = "" + Math.abs(a), e = b - d.length, f = a >= 0;
            return(f ? c ? "+" : "" : "-") + Math.pow(10, Math.max(0, e)).toString().substr(1) + d
        }
        function R(a, b, c, d) {
            var e = d;
            "string" == typeof d && (e = function () {
                return this[d]()
            }), a && (hd[a] = e), b && (hd[b[0]] = function () {
                return Q(e.apply(this, arguments), b[1], b[2])
            }), c && (hd[c] = function () {
                return this.localeData().ordinal(e.apply(this, arguments), a)
            })
        }
        function S(a) {
            return a.match(/\[[\s\S]/) ? a.replace(/^\[|\]$/g, "") : a.replace(/\\/g, "")
        }
        function T(a) {
            var b, c, d = a.match(ed);
            for (b = 0, c = d.length; c > b; b++)
                hd[d[b]] ? d[b] = hd[d[b]] : d[b] = S(d[b]);
            return function (e) {
                var f = "";
                for (b = 0; c > b; b++)
                    f += d[b]instanceof Function ? d[b].call(e, a) : d[b];
                return f
            }
        }
        function U(a, b) {
            return a.isValid() ? (b = V(b, a.localeData()), gd[b] = gd[b] || T(b), gd[b](a)) : a.localeData().invalidDate()
        }
        function V(a, b) {
            function c(a) {
                return b.longDateFormat(a) || a
            }
            var d = 5;
            for (fd.lastIndex = 0; d >= 0 && fd.test(a); )
                a = a.replace(fd, c), fd.lastIndex = 0, d -= 1;
            return a
        }
        function W(a, b, c) {
            zd[a] = w(b) ? b : function (a, d) {
                return a && c ? c : b
            }
        }
        function X(a, b) {
            return f(zd, a) ? zd[a](b._strict, b._locale) : new RegExp(Y(a))
        }
        function Y(a) {
            return Z(a.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (a, b, c, d, e) {
                return b || c || d || e
            }))
        }
        function Z(a) {
            return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&")
        }
        function $(a, b) {
            var c, d = b;
            for ("string" == typeof a && (a = [a]), "number" == typeof b && (d = function(a, c){c[b] = r(a)}), c = 0; c < a.length; c++)
                Ad[a[c]] = d
        }
        function _(a, b) {
            $(a, function (a, c, d, e) {
                d._w = d._w || {}, b(a, d._w, d, e)
            })
        }
        function aa(a, b, c) {
            null != b && f(Ad, a) && Ad[a](b, c._a, c, a)
        }
        function ba(a, b) {
            return new Date(Date.UTC(a, b + 1, 0)).getUTCDate()
        }
        function ca(a, b) {
            return c(this._months) ? this._months[a.month()] : this._months[Kd.test(b) ? "format" : "standalone"][a.month()]
        }
        function da(a, b) {
            return c(this._monthsShort) ? this._monthsShort[a.month()] : this._monthsShort[Kd.test(b) ? "format" : "standalone"][a.month()]
        }
        function ea(a, b, c) {
            var d, e, f;
            for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []), d = 0; 12 > d; d++) {
                if (e = h([2e3, d]), c && !this._longMonthsParse[d] && (this._longMonthsParse[d] = new RegExp("^" + this.months(e, "").replace(".", "") + "$", "i"), this._shortMonthsParse[d] = new RegExp("^" + this.monthsShort(e, "").replace(".", "") + "$", "i")), c || this._monthsParse[d] || (f = "^" + this.months(e, "") + "|^" + this.monthsShort(e, ""), this._monthsParse[d] = new RegExp(f.replace(".", ""), "i")), c && "MMMM" === b && this._longMonthsParse[d].test(a))
                    return d;
                if (c && "MMM" === b && this._shortMonthsParse[d].test(a))
                    return d;
                if (!c && this._monthsParse[d].test(a))
                    return d
            }
        }
        function fa(a, b) {
            var c;
            if (!a.isValid())
                return a;
            if ("string" == typeof b)
                if (/^\d+$/.test(b))
                    b = r(b);
                else if (b = a.localeData().monthsParse(b), "number" != typeof b)
                    return a;
            return c = Math.min(a.date(), ba(a.year(), b)), a._d["set" + (a._isUTC ? "UTC" : "") + "Month"](b, c), a
        }
        function ga(b) {
            return null != b ? (fa(this, b), a.updateOffset(this, !0), this) : N(this, "Month")
        }
        function ha() {
            return ba(this.year(), this.month())
        }
        function ia(a) {
            return this._monthsParseExact ? (f(this, "_monthsRegex") || ka.call(this), a ? this._monthsShortStrictRegex : this._monthsShortRegex) : this._monthsShortStrictRegex && a ? this._monthsShortStrictRegex : this._monthsShortRegex
        }
        function ja(a) {
            return this._monthsParseExact ? (f(this, "_monthsRegex") || ka.call(this), a ? this._monthsStrictRegex : this._monthsRegex) : this._monthsStrictRegex && a ? this._monthsStrictRegex : this._monthsRegex
        }
        function ka() {
            function a(a, b) {
                return b.length - a.length
            }
            var b, c, d = [], e = [], f = [];
            for (b = 0; 12 > b; b++)
                c = h([2e3, b]), d.push(this.monthsShort(c, "")), e.push(this.months(c, "")), f.push(this.months(c, "")), f.push(this.monthsShort(c, ""));
            for (d.sort(a), e.sort(a), f.sort(a), b = 0; 12 > b; b++)
                d[b] = Z(d[b]), e[b] = Z(e[b]), f[b] = Z(f[b]);
            this._monthsRegex = new RegExp("^(" + f.join("|") + ")", "i"), this._monthsShortRegex = this._monthsRegex, this._monthsStrictRegex = new RegExp("^(" + e.join("|") + ")$", "i"), this._monthsShortStrictRegex = new RegExp("^(" + d.join("|") + ")$", "i")
        }
        function la(a) {
            var b, c = a._a;
            return c && -2 === j(a).overflow && (b = c[Cd] < 0 || c[Cd] > 11 ? Cd : c[Dd] < 1 || c[Dd] > ba(c[Bd], c[Cd]) ? Dd : c[Ed] < 0 || c[Ed] > 24 || 24 === c[Ed] && (0 !== c[Fd] || 0 !== c[Gd] || 0 !== c[Hd]) ? Ed : c[Fd] < 0 || c[Fd] > 59 ? Fd : c[Gd] < 0 || c[Gd] > 59 ? Gd : c[Hd] < 0 || c[Hd] > 999 ? Hd : -1, j(a)._overflowDayOfYear && (Bd > b || b > Dd) && (b = Dd), j(a)._overflowWeeks && -1 === b && (b = Id), j(a)._overflowWeekday && -1 === b && (b = Jd), j(a).overflow = b), a
        }
        function ma(a) {
            var b, c, d, e, f, g, h = a._i, i = Pd.exec(h) || Qd.exec(h);
            if (i) {
                for (j(a).iso = !0, b = 0, c = Sd.length; c > b; b++)
                    if (Sd[b][1].exec(i[1])) {
                        e = Sd[b][0], d = Sd[b][2] !== !1;
                        break
                    }
                if (null == e)
                    return void(a._isValid = !1);
                if (i[3]) {
                    for (b = 0, c = Td.length; c > b; b++)
                        if (Td[b][1].exec(i[3])) {
                            f = (i[2] || " ") + Td[b][0];
                            break
                        }
                    if (null == f)
                        return void(a._isValid = !1)
                }
                if (!d && null != f)
                    return void(a._isValid = !1);
                if (i[4]) {
                    if (!Rd.exec(i[4]))
                        return void(a._isValid = !1);
                    g = "Z"
                }
                a._f = e + (f || "") + (g || ""), Ba(a)
            } else
                a._isValid = !1
        }
        function na(b) {
            var c = Ud.exec(b._i);
            return null !== c ? void(b._d = new Date(+c[1])) : (ma(b), void(b._isValid === !1 && (delete b._isValid, a.createFromInputFallback(b))))
        }
        function oa(a, b, c, d, e, f, g) {
            var h = new Date(a, b, c, d, e, f, g);
            return 100 > a && a >= 0 && isFinite(h.getFullYear()) && h.setFullYear(a), h
        }
        function pa(a) {
            var b = new Date(Date.UTC.apply(null, arguments));
            return 100 > a && a >= 0 && isFinite(b.getUTCFullYear()) && b.setUTCFullYear(a), b
        }
        function qa(a) {
            return ra(a) ? 366 : 365
        }
        function ra(a) {
            return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0
        }
        function sa() {
            return ra(this.year())
        }
        function ta(a, b, c) {
            var d = 7 + b - c, e = (7 + pa(a, 0, d).getUTCDay() - b) % 7;
            return-e + d - 1
        }
        function ua(a, b, c, d, e) {
            var f, g, h = (7 + c - d) % 7, i = ta(a, d, e), j = 1 + 7 * (b - 1) + h + i;
            return 0 >= j ? (f = a - 1, g = qa(f) + j) : j > qa(a) ? (f = a + 1, g = j - qa(a)) : (f = a, g = j), {year: f, dayOfYear: g}
        }
        function va(a, b, c) {
            var d, e, f = ta(a.year(), b, c), g = Math.floor((a.dayOfYear() - f - 1) / 7) + 1;
            return 1 > g ? (e = a.year() - 1, d = g + wa(e, b, c)) : g > wa(a.year(), b, c) ? (d = g - wa(a.year(), b, c), e = a.year() + 1) : (e = a.year(), d = g), {week: d, year: e}
        }
        function wa(a, b, c) {
            var d = ta(a, b, c), e = ta(a + 1, b, c);
            return(qa(a) - d + e) / 7
        }
        function xa(a, b, c) {
            return null != a ? a : null != b ? b : c
        }
        function ya(b) {
            var c = new Date(a.now());
            return b._useUTC ? [c.getUTCFullYear(), c.getUTCMonth(), c.getUTCDate()] : [c.getFullYear(), c.getMonth(), c.getDate()]
        }
        function za(a) {
            var b, c, d, e, f = [];
            if (!a._d) {
                for (d = ya(a), a._w && null == a._a[Dd] && null == a._a[Cd] && Aa(a), a._dayOfYear && (e = xa(a._a[Bd], d[Bd]), a._dayOfYear > qa(e) && (j(a)._overflowDayOfYear = !0), c = pa(e, 0, a._dayOfYear), a._a[Cd] = c.getUTCMonth(), a._a[Dd] = c.getUTCDate()), b = 0; 3 > b && null == a._a[b]; ++b)
                    a._a[b] = f[b] = d[b];
                for (; 7 > b; b++)
                    a._a[b] = f[b] = null == a._a[b] ? 2 === b ? 1 : 0 : a._a[b];
                24 === a._a[Ed] && 0 === a._a[Fd] && 0 === a._a[Gd] && 0 === a._a[Hd] && (a._nextDay = !0, a._a[Ed] = 0), a._d = (a._useUTC ? pa : oa).apply(null, f), null != a._tzm && a._d.setUTCMinutes(a._d.getUTCMinutes() - a._tzm), a._nextDay && (a._a[Ed] = 24)
            }
        }
        function Aa(a) {
            var b, c, d, e, f, g, h, i;
            b = a._w, null != b.GG || null != b.W || null != b.E ? (f = 1, g = 4, c = xa(b.GG, a._a[Bd], va(Ja(), 1, 4).year), d = xa(b.W, 1), e = xa(b.E, 1), (1 > e || e > 7) && (i = !0)) : (f = a._locale._week.dow, g = a._locale._week.doy, c = xa(b.gg, a._a[Bd], va(Ja(), f, g).year), d = xa(b.w, 1), null != b.d ? (e = b.d, (0 > e || e > 6) && (i = !0)) : null != b.e ? (e = b.e + f, (b.e < 0 || b.e > 6) && (i = !0)) : e = f), 1 > d || d > wa(c, f, g) ? j(a)._overflowWeeks = !0 : null != i ? j(a)._overflowWeekday = !0 : (h = ua(c, d, e, f, g), a._a[Bd] = h.year, a._dayOfYear = h.dayOfYear)
        }
        function Ba(b) {
            if (b._f === a.ISO_8601)
                return void ma(b);
            b._a = [], j(b).empty = !0;
            var c, d, e, f, g, h = "" + b._i, i = h.length, k = 0;
            for (e = V(b._f, b._locale).match(ed) || [], c = 0; c < e.length; c++)
                f = e[c], d = (h.match(X(f, b)) || [])[0], d && (g = h.substr(0, h.indexOf(d)), g.length > 0 && j(b).unusedInput.push(g), h = h.slice(h.indexOf(d) + d.length), k += d.length), hd[f] ? (d ? j(b).empty = !1 : j(b).unusedTokens.push(f), aa(f, d, b)) : b._strict && !d && j(b).unusedTokens.push(f);
            j(b).charsLeftOver = i - k, h.length > 0 && j(b).unusedInput.push(h), j(b).bigHour === !0 && b._a[Ed] <= 12 && b._a[Ed] > 0 && (j(b).bigHour = void 0), b._a[Ed] = Ca(b._locale, b._a[Ed], b._meridiem), za(b), la(b)
        }
        function Ca(a, b, c) {
            var d;
            return null == c ? b : null != a.meridiemHour ? a.meridiemHour(b, c) : null != a.isPM ? (d = a.isPM(c), d && 12 > b && (b += 12), d || 12 !== b || (b = 0), b) : b
        }
        function Da(a) {
            var b, c, d, e, f;
            if (0 === a._f.length)
                return j(a).invalidFormat = !0, void(a._d = new Date(NaN));
            for (e = 0; e < a._f.length; e++)
                f = 0, b = n({}, a), null != a._useUTC && (b._useUTC = a._useUTC), b._f = a._f[e], Ba(b), k(b) && (f += j(b).charsLeftOver, f += 10 * j(b).unusedTokens.length, j(b).score = f, (null == d || d > f) && (d = f, c = b));
            g(a, c || b)
        }
        function Ea(a) {
            if (!a._d) {
                var b = L(a._i);
                a._a = e([b.year, b.month, b.day || b.date, b.hour, b.minute, b.second, b.millisecond], function (a) {
                    return a && parseInt(a, 10)
                }), za(a)
            }
        }
        function Fa(a) {
            var b = new o(la(Ga(a)));
            return b._nextDay && (b.add(1, "d"), b._nextDay = void 0), b
        }
        function Ga(a) {
            var b = a._i, e = a._f;
            return a._locale = a._locale || H(a._l), null === b || void 0 === e && "" === b ? l({nullInput: !0}) : ("string" == typeof b && (a._i = b = a._locale.preparse(b)), p(b) ? new o(la(b)) : (c(e) ? Da(a) : e ? Ba(a) : d(b) ? a._d = b : Ha(a), k(a) || (a._d = null), a))
        }
        function Ha(b) {
            var f = b._i;
            void 0 === f ? b._d = new Date(a.now()) : d(f) ? b._d = new Date(+f) : "string" == typeof f ? na(b) : c(f) ? (b._a = e(f.slice(0), function (a) {
                return parseInt(a, 10)
            }), za(b)) : "object" == typeof f ? Ea(b) : "number" == typeof f ? b._d = new Date(f) : a.createFromInputFallback(b)
        }
        function Ia(a, b, c, d, e) {
            var f = {};
            return"boolean" == typeof c && (d = c, c = void 0), f._isAMomentObject = !0, f._useUTC = f._isUTC = e, f._l = c, f._i = a, f._f = b, f._strict = d, Fa(f)
        }
        function Ja(a, b, c, d) {
            return Ia(a, b, c, d, !1)
        }
        function Ka(a, b) {
            var d, e;
            if (1 === b.length && c(b[0]) && (b = b[0]), !b.length)
                return Ja();
            for (d = b[0], e = 1; e < b.length; ++e)
                (!b[e].isValid() || b[e][a](d)) && (d = b[e]);
            return d
        }
        function La() {
            var a = [].slice.call(arguments, 0);
            return Ka("isBefore", a)
        }
        function Ma() {
            var a = [].slice.call(arguments, 0);
            return Ka("isAfter", a)
        }
        function Na(a) {
            var b = L(a), c = b.year || 0, d = b.quarter || 0, e = b.month || 0, f = b.week || 0, g = b.day || 0, h = b.hour || 0, i = b.minute || 0, j = b.second || 0, k = b.millisecond || 0;
            this._milliseconds = +k + 1e3 * j + 6e4 * i + 36e5 * h, this._days = +g + 7 * f, this._months = +e + 3 * d + 12 * c, this._data = {}, this._locale = H(), this._bubble()
        }
        function Oa(a) {
            return a instanceof Na
        }
        function Pa(a, b) {
            R(a, 0, 0, function () {
                var a = this.utcOffset(), c = "+";
                return 0 > a && (a = -a, c = "-"), c + Q(~~(a / 60), 2) + b + Q(~~a % 60, 2)
            })
        }
        function Qa(a, b) {
            var c = (b || "").match(a) || [], d = c[c.length - 1] || [], e = (d + "").match(Zd) || ["-", 0, 0], f = +(60 * e[1]) + r(e[2]);
            return"+" === e[0] ? f : -f
        }
        function Ra(b, c) {
            var e, f;
            return c._isUTC ? (e = c.clone(), f = (p(b) || d(b) ? +b : +Ja(b)) - +e, e._d.setTime(+e._d + f), a.updateOffset(e, !1), e) : Ja(b).local()
        }
        function Sa(a) {
            return 15 * -Math.round(a._d.getTimezoneOffset() / 15)
        }
        function Ta(b, c) {
            var d, e = this._offset || 0;
            return this.isValid() ? null != b ? ("string" == typeof b ? b = Qa(wd, b) : Math.abs(b) < 16 && (b = 60 * b), !this._isUTC && c && (d = Sa(this)), this._offset = b, this._isUTC = !0, null != d && this.add(d, "m"), e !== b && (!c || this._changeInProgress ? ib(this, cb(b - e, "m"), 1, !1) : this._changeInProgress || (this._changeInProgress = !0, a.updateOffset(this, !0), this._changeInProgress = null)), this) : this._isUTC ? e : Sa(this) : null != b ? this : NaN
        }
        function Ua(a, b) {
            return null != a ? ("string" != typeof a && (a = -a), this.utcOffset(a, b), this) : -this.utcOffset()
        }
        function Va(a) {
            return this.utcOffset(0, a)
        }
        function Wa(a) {
            return this._isUTC && (this.utcOffset(0, a), this._isUTC = !1, a && this.subtract(Sa(this), "m")), this
        }
        function Xa() {
            return this._tzm ? this.utcOffset(this._tzm) : "string" == typeof this._i && this.utcOffset(Qa(vd, this._i)), this
        }
        function Ya(a) {
            return this.isValid() ? (a = a ? Ja(a).utcOffset() : 0, (this.utcOffset() - a) % 60 === 0) : !1
        }
        function Za() {
            return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset()
        }
        function $a() {
            if (!m(this._isDSTShifted))
                return this._isDSTShifted;
            var a = {};
            if (n(a, this), a = Ga(a), a._a) {
                var b = a._isUTC ? h(a._a) : Ja(a._a);
                this._isDSTShifted = this.isValid() && s(a._a, b.toArray()) > 0
            } else
                this._isDSTShifted = !1;
            return this._isDSTShifted
        }
        function _a() {
            return this.isValid() ? !this._isUTC : !1
        }
        function ab() {
            return this.isValid() ? this._isUTC : !1
        }
        function bb() {
            return this.isValid() ? this._isUTC && 0 === this._offset : !1
        }
        function cb(a, b) {
            var c, d, e, g = a, h = null;
            return Oa(a) ? g = {ms: a._milliseconds, d: a._days, M: a._months} : "number" == typeof a ? (g = {}, b ? g[b] = a : g.milliseconds = a) : (h = $d.exec(a)) ? (c = "-" === h[1] ? -1 : 1, g = {y: 0, d: r(h[Dd]) * c, h: r(h[Ed]) * c, m: r(h[Fd]) * c, s: r(h[Gd]) * c, ms: r(h[Hd]) * c}) : (h = _d.exec(a)) ? (c = "-" === h[1] ? -1 : 1, g = {y: db(h[2], c), M: db(h[3], c), w: db(h[4], c), d: db(h[5], c), h: db(h[6], c), m: db(h[7], c), s: db(h[8], c)}) : null == g ? g = {} : "object" == typeof g && ("from"in g || "to"in g) && (e = fb(Ja(g.from), Ja(g.to)), g = {}, g.ms = e.milliseconds, g.M = e.months), d = new Na(g), Oa(a) && f(a, "_locale") && (d._locale = a._locale), d
        }
        function db(a, b) {
            var c = a && parseFloat(a.replace(",", "."));
            return(isNaN(c) ? 0 : c) * b
        }
        function eb(a, b) {
            var c = {milliseconds: 0, months: 0};
            return c.months = b.month() - a.month() + 12 * (b.year() - a.year()), a.clone().add(c.months, "M").isAfter(b) && --c.months, c.milliseconds = +b - +a.clone().add(c.months, "M"), c
        }
        function fb(a, b) {
            var c;
            return a.isValid() && b.isValid() ? (b = Ra(b, a), a.isBefore(b) ? c = eb(a, b) : (c = eb(b, a), c.milliseconds = -c.milliseconds, c.months = -c.months), c) : {milliseconds: 0, months: 0}
        }
        function gb(a) {
            return 0 > a ? -1 * Math.round(-1 * a) : Math.round(a)
        }
        function hb(a, b) {
            return function (c, d) {
                var e, f;
                return null === d || isNaN(+d) || (v(b, "moment()." + b + "(period, number) is deprecated. Please use moment()." + b + "(number, period)."), f = c, c = d, d = f), c = "string" == typeof c ? +c : c, e = cb(c, d), ib(this, e, a), this
            }
        }
        function ib(b, c, d, e) {
            var f = c._milliseconds, g = gb(c._days), h = gb(c._months);
            b.isValid() && (e = null == e ? !0 : e, f && b._d.setTime(+b._d + f * d), g && O(b, "Date", N(b, "Date") + g * d), h && fa(b, N(b, "Month") + h * d), e && a.updateOffset(b, g || h))
        }
        function jb(a, b) {
            var c = a || Ja(), d = Ra(c, this).startOf("day"), e = this.diff(d, "days", !0), f = -6 > e ? "sameElse" : -1 > e ? "lastWeek" : 0 > e ? "lastDay" : 1 > e ? "sameDay" : 2 > e ? "nextDay" : 7 > e ? "nextWeek" : "sameElse", g = b && (w(b[f]) ? b[f]() : b[f]);
            return this.format(g || this.localeData().calendar(f, this, Ja(c)))
        }
        function kb() {
            return new o(this)
        }
        function lb(a, b) {
            var c = p(a) ? a : Ja(a);
            return this.isValid() && c.isValid() ? (b = K(m(b) ? "millisecond" : b), "millisecond" === b ? +this > +c : +c < +this.clone().startOf(b)) : !1
        }
        function mb(a, b) {
            var c = p(a) ? a : Ja(a);
            return this.isValid() && c.isValid() ? (b = K(m(b) ? "millisecond" : b), "millisecond" === b ? +c > +this : +this.clone().endOf(b) < +c) : !1
        }
        function nb(a, b, c) {
            return this.isAfter(a, c) && this.isBefore(b, c)
        }
        function ob(a, b) {
            var c, d = p(a) ? a : Ja(a);
            return this.isValid() && d.isValid() ? (b = K(b || "millisecond"), "millisecond" === b ? +this === +d : (c = +d, +this.clone().startOf(b) <= c && c <= +this.clone().endOf(b))) : !1
        }
        function pb(a, b) {
            return this.isSame(a, b) || this.isAfter(a, b)
        }
        function qb(a, b) {
            return this.isSame(a, b) || this.isBefore(a, b)
        }
        function rb(a, b, c) {
            var d, e, f, g;
            return this.isValid() ? (d = Ra(a, this), d.isValid() ? (e = 6e4 * (d.utcOffset() - this.utcOffset()), b = K(b), "year" === b || "month" === b || "quarter" === b ? (g = sb(this, d), "quarter" === b ? g /= 3 : "year" === b && (g /= 12)) : (f = this - d, g = "second" === b ? f / 1e3 : "minute" === b ? f / 6e4 : "hour" === b ? f / 36e5 : "day" === b ? (f - e) / 864e5 : "week" === b ? (f - e) / 6048e5 : f), c ? g : q(g)) : NaN) : NaN
        }
        function sb(a, b) {
            var c, d, e = 12 * (b.year() - a.year()) + (b.month() - a.month()), f = a.clone().add(e, "months");
            return 0 > b - f ? (c = a.clone().add(e - 1, "months"), d = (b - f) / (f - c)) : (c = a.clone().add(e + 1, "months"), d = (b - f) / (c - f)), -(e + d)
        }
        function tb() {
            return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")
        }
        function ub() {
            var a = this.clone().utc();
            return 0 < a.year() && a.year() <= 9999 ? w(Date.prototype.toISOString) ? this.toDate().toISOString() : U(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]") : U(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")
        }
        function vb(b) {
            var c = U(this, b || a.defaultFormat);
            return this.localeData().postformat(c)
        }
        function wb(a, b) {
            return this.isValid() && (p(a) && a.isValid() || Ja(a).isValid()) ? cb({to: this, from: a}).locale(this.locale()).humanize(!b) : this.localeData().invalidDate()
        }
        function xb(a) {
            return this.from(Ja(), a)
        }
        function yb(a, b) {
            return this.isValid() && (p(a) && a.isValid() || Ja(a).isValid()) ? cb({from: this, to: a}).locale(this.locale()).humanize(!b) : this.localeData().invalidDate()
        }
        function zb(a) {
            return this.to(Ja(), a)
        }
        function Ab(a) {
            var b;
            return void 0 === a ? this._locale._abbr : (b = H(a), null != b && (this._locale = b), this)
        }
        function Bb() {
            return this._locale
        }
        function Cb(a) {
            switch (a = K(a)) {
                case"year":
                    this.month(0);
                    case"quarter":
                case"month":
                    this.date(1);
                    case"week":
                case"isoWeek":
                case"day":
                    this.hours(0);
                    case"hour":
                    this.minutes(0);
                    case"minute":
                    this.seconds(0);
                    case"second":
                    this.milliseconds(0)
                }
            return"week" === a && this.weekday(0), "isoWeek" === a && this.isoWeekday(1), "quarter" === a && this.month(3 * Math.floor(this.month() / 3)), this
        }
        function Db(a) {
            return a = K(a), void 0 === a || "millisecond" === a ? this:this.startOf(a).add(1, "isoWeek" === a ? "week" : a).subtract(1, "ms")
        }
        function Eb() {
            return+this._d - 6e4 * (this._offset || 0)
        }
        function Fb() {
            return Math.floor(+this / 1e3)
        }
        function Gb() {
            return this._offset ? new Date(+this) : this._d
        }
        function Hb() {
            var a = this;
            return[a.year(), a.month(), a.date(), a.hour(), a.minute(), a.second(), a.millisecond()]
        }
        function Ib() {
            var a = this;
            return{years: a.year(), months: a.month(), date: a.date(), hours: a.hours(), minutes: a.minutes(), seconds: a.seconds(), milliseconds: a.milliseconds()}
        }
        function Jb() {
            return this.isValid() ? this.toISOString() : null
        }
        function Kb() {
            return k(this)
        }
        function Lb() {
            return g({}, j(this))
        }
        function Mb() {
            return j(this).overflow
        }
        function Nb() {
            return{input: this._i, format: this._f, locale: this._locale, isUTC: this._isUTC, strict: this._strict}
        }
        function Ob(a, b) {
            R(0, [a, a.length], 0, b)
        }
        function Pb(a) {
            return Tb.call(this, a, this.week(), this.weekday(), this.localeData()._week.dow, this.localeData()._week.doy)
        }
        function Qb(a) {
            return Tb.call(this, a, this.isoWeek(), this.isoWeekday(), 1, 4)
        }
        function Rb() {
            return wa(this.year(), 1, 4)
        }
        function Sb() {
            var a = this.localeData()._week;
            return wa(this.year(), a.dow, a.doy)
        }
        function Tb(a, b, c, d, e) {
            var f;
            return null == a ? va(this, d, e).year : (f = wa(a, d, e), b > f && (b = f), Ub.call(this, a, b, c, d, e))
        }
        function Ub(a, b, c, d, e) {
            var f = ua(a, b, c, d, e), g = pa(f.year, 0, f.dayOfYear);
            return this.year(g.getUTCFullYear()), this.month(g.getUTCMonth()), this.date(g.getUTCDate()), this
        }
        function Vb(a) {
            return null == a ? Math.ceil((this.month() + 1) / 3) : this.month(3 * (a - 1) + this.month() % 3)
        }
        function Wb(a) {
            return va(a, this._week.dow, this._week.doy).week
        }
        function Xb() {
            return this._week.dow
        }
        function Yb() {
            return this._week.doy
        }
        function Zb(a) {
            var b = this.localeData().week(this);
            return null == a ? b : this.add(7 * (a - b), "d")
        }
        function $b(a) {
            var b = va(this, 1, 4).week;
            return null == a ? b : this.add(7 * (a - b), "d")
        }
        function _b(a, b) {
            return"string" != typeof a ? a : isNaN(a) ? (a = b.weekdaysParse(a), "number" == typeof a ? a : null) : parseInt(a, 10)
        }
        function ac(a, b) {
            return c(this._weekdays) ? this._weekdays[a.day()] : this._weekdays[this._weekdays.isFormat.test(b) ? "format" : "standalone"][a.day()]
        }
        function bc(a) {
            return this._weekdaysShort[a.day()]
        }
        function cc(a) {
            return this._weekdaysMin[a.day()]
        }
        function dc(a, b, c) {
            var d, e, f;
            for (this._weekdaysParse || (this._weekdaysParse = [], this._minWeekdaysParse = [], this._shortWeekdaysParse = [], this._fullWeekdaysParse = []), d = 0; 7 > d; d++) {
                if (e = Ja([2e3, 1]).day(d), c && !this._fullWeekdaysParse[d] && (this._fullWeekdaysParse[d] = new RegExp("^" + this.weekdays(e, "").replace(".", ".?") + "$", "i"), this._shortWeekdaysParse[d] = new RegExp("^" + this.weekdaysShort(e, "").replace(".", ".?") + "$", "i"), this._minWeekdaysParse[d] = new RegExp("^" + this.weekdaysMin(e, "").replace(".", ".?") + "$", "i")), this._weekdaysParse[d] || (f = "^" + this.weekdays(e, "") + "|^" + this.weekdaysShort(e, "") + "|^" + this.weekdaysMin(e, ""), this._weekdaysParse[d] = new RegExp(f.replace(".", ""), "i")), c && "dddd" === b && this._fullWeekdaysParse[d].test(a))
                    return d;
                if (c && "ddd" === b && this._shortWeekdaysParse[d].test(a))
                    return d;
                if (c && "dd" === b && this._minWeekdaysParse[d].test(a))
                    return d;
                if (!c && this._weekdaysParse[d].test(a))
                    return d
            }
        }
        function ec(a) {
            if (!this.isValid())
                return null != a ? this : NaN;
            var b = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
            return null != a ? (a = _b(a, this.localeData()), this.add(a - b, "d")) : b
        }
        function fc(a) {
            if (!this.isValid())
                return null != a ? this : NaN;
            var b = (this.day() + 7 - this.localeData()._week.dow) % 7;
            return null == a ? b : this.add(a - b, "d")
        }
        function gc(a) {
            return this.isValid() ? null == a ? this.day() || 7 : this.day(this.day() % 7 ? a : a - 7) : null != a ? this : NaN
        }
        function hc(a) {
            var b = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
            return null == a ? b : this.add(a - b, "d")
        }
        function ic() {
            return this.hours() % 12 || 12
        }
        function jc(a, b) {
            R(a, 0, 0, function () {
                return this.localeData().meridiem(this.hours(), this.minutes(), b)
            })
        }
        function kc(a, b) {
            return b._meridiemParse
        }
        function lc(a) {
            return"p" === (a + "").toLowerCase().charAt(0)
        }
        function mc(a, b, c) {
            return a > 11 ? c ? "pm" : "PM" : c ? "am" : "AM"
        }
        function nc(a, b) {
            b[Hd] = r(1e3 * ("0." + a))
        }
        function oc() {
            return this._isUTC ? "UTC" : ""
        }
        function pc() {
            return this._isUTC ? "Coordinated Universal Time" : ""
        }
        function qc(a) {
            return Ja(1e3 * a)
        }
        function rc() {
            return Ja.apply(null, arguments).parseZone()
        }
        function sc(a, b, c) {
            var d = this._calendar[a];
            return w(d) ? d.call(b, c) : d
        }
        function tc(a) {
            var b = this._longDateFormat[a], c = this._longDateFormat[a.toUpperCase()];
            return b || !c ? b : (this._longDateFormat[a] = c.replace(/MMMM|MM|DD|dddd/g, function (a) {
                return a.slice(1)
            }), this._longDateFormat[a])
        }
        function uc() {
            return this._invalidDate
        }
        function vc(a) {
            return this._ordinal.replace("%d", a)
        }
        function wc(a) {
            return a
        }
        function xc(a, b, c, d) {
            var e = this._relativeTime[c];
            return w(e) ? e(a, b, c, d) : e.replace(/%d/i, a)
        }
        function yc(a, b) {
            var c = this._relativeTime[a > 0 ? "future" : "past"];
            return w(c) ? c(b) : c.replace(/%s/i, b)
        }
        function zc(a, b, c, d) {
            var e = H(), f = h().set(d, b);
            return e[c](f, a)
        }
        function Ac(a, b, c, d, e) {
            if ("number" == typeof a && (b = a, a = void 0), a = a || "", null != b)
                return zc(a, b, c, e);
            var f, g = [];
            for (f = 0; d > f; f++)
                g[f] = zc(a, f, c, e);
            return g
        }
        function Bc(a, b) {
            return Ac(a, b, "months", 12, "month")
        }
        function Cc(a, b) {
            return Ac(a, b, "monthsShort", 12, "month")
        }
        function Dc(a, b) {
            return Ac(a, b, "weekdays", 7, "day")
        }
        function Ec(a, b) {
            return Ac(a, b, "weekdaysShort", 7, "day")
        }
        function Fc(a, b) {
            return Ac(a, b, "weekdaysMin", 7, "day")
        }
        function Gc() {
            var a = this._data;
            return this._milliseconds = xe(this._milliseconds), this._days = xe(this._days), this._months = xe(this._months), a.milliseconds = xe(a.milliseconds), a.seconds = xe(a.seconds), a.minutes = xe(a.minutes), a.hours = xe(a.hours), a.months = xe(a.months), a.years = xe(a.years), this
        }
        function Hc(a, b, c, d) {
            var e = cb(b, c);
            return a._milliseconds += d * e._milliseconds, a._days += d * e._days, a._months += d * e._months, a._bubble()
        }
        function Ic(a, b) {
            return Hc(this, a, b, 1)
        }
        function Jc(a, b) {
            return Hc(this, a, b, -1)
        }
        function Kc(a) {
            return 0 > a ? Math.floor(a) : Math.ceil(a)
        }
        function Lc() {
            var a, b, c, d, e, f = this._milliseconds, g = this._days, h = this._months, i = this._data;
            return f >= 0 && g >= 0 && h >= 0 || 0 >= f && 0 >= g && 0 >= h || (f += 864e5 * Kc(Nc(h) + g), g = 0, h = 0), i.milliseconds = f % 1e3, a = q(f / 1e3), i.seconds = a % 60, b = q(a / 60), i.minutes = b % 60, c = q(b / 60), i.hours = c % 24, g += q(c / 24), e = q(Mc(g)), h += e, g -= Kc(Nc(e)), d = q(h / 12), h %= 12, i.days = g, i.months = h, i.years = d, this
        }
        function Mc(a) {
            return 4800 * a / 146097
        }
        function Nc(a) {
            return 146097 * a / 4800
        }
        function Oc(a) {
            var b, c, d = this._milliseconds;
            if (a = K(a), "month" === a || "year" === a)
                return b = this._days + d / 864e5, c = this._months + Mc(b), "month" === a ? c : c / 12;
            switch (b = this._days + Math.round(Nc(this._months)), a) {
                case"week":
                    return b / 7 + d / 6048e5;
                    case"day":
                    return b + d / 864e5;
                    case"hour":
                    return 24 * b + d / 36e5;
                    case"minute":
                    return 1440 * b + d / 6e4;
                    case"second":
                    return 86400 * b + d / 1e3;
                    case"millisecond":
                    return Math.floor(864e5 * b) + d;
                    default:
                    throw new Error("Unknown unit " + a)
                    }
        }
        function Pc() {
            return this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * r(this._months / 12)
        }
        function Qc(a) {
            return function () {
                return this.as(a)
            }
        }
        function Rc(a) {
            return a = K(a), this[a + "s"]()
        }
        function Sc(a) {
            return function () {
                return this._data[a]
            }
        }
        function Tc() {
            return q(this.days() / 7)
        }
        function Uc(a, b, c, d, e) {
            return e.relativeTime(b || 1, !!c, a, d)
        }
        function Vc(a, b, c) {
            var d = cb(a).abs(), e = Ne(d.as("s")), f = Ne(d.as("m")), g = Ne(d.as("h")), h = Ne(d.as("d")), i = Ne(d.as("M")), j = Ne(d.as("y")), k = e < Oe.s && ["s", e] || 1 >= f && ["m"] || f < Oe.m && ["mm", f] || 1 >= g && ["h"] || g < Oe.h && ["hh", g] || 1 >= h && ["d"] || h < Oe.d && ["dd", h] || 1 >= i && ["M"] || i < Oe.M && ["MM", i] || 1 >= j && ["y"] || ["yy", j];
            return k[2] = b, k[3] = +a > 0, k[4] = c, Uc.apply(null, k)
        }
        function Wc(a, b) {
            return void 0 === Oe[a] ? !1 : void 0 === b ? Oe[a] : (Oe[a] = b, !0)
        }
        function Xc(a) {
            var b = this.localeData(), c = Vc(this, !a, b);
            return a && (c = b.pastFuture(+this, c)), b.postformat(c)
        }
        function Yc() {
            var a, b, c, d = Pe(this._milliseconds) / 1e3, e = Pe(this._days), f = Pe(this._months);
            a = q(d / 60), b = q(a / 60), d %= 60, a %= 60, c = q(f / 12), f %= 12;
            var g = c, h = f, i = e, j = b, k = a, l = d, m = this.asSeconds();
            return m ? (0 > m ? "-" : "") + "P" + (g ? g + "Y" : "") + (h ? h + "M" : "") + (i ? i + "D" : "") + (j || k || l ? "T" : "") + (j ? j + "H" : "") + (k ? k + "M" : "") + (l ? l + "S" : "") : "P0D"
        }
        var Zc, $c = a.momentProperties = [], _c = !1, ad = {};
        a.suppressDeprecationWarnings = !1;
        var bd, cd = {}, dd = {}, ed = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g, fd = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, gd = {}, hd = {}, id = /\d/, jd = /\d\d/, kd = /\d{3}/, ld = /\d{4}/, md = /[+-]?\d{6}/, nd = /\d\d?/, od = /\d\d\d\d?/, pd = /\d\d\d\d\d\d?/, qd = /\d{1,3}/, rd = /\d{1,4}/, sd = /[+-]?\d{1,6}/, td = /\d+/, ud = /[+-]?\d+/, vd = /Z|[+-]\d\d:?\d\d/gi, wd = /Z|[+-]\d\d(?::?\d\d)?/gi, xd = /[+-]?\d+(\.\d{1,3})?/, yd = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, zd = {}, Ad = {}, Bd = 0, Cd = 1, Dd = 2, Ed = 3, Fd = 4, Gd = 5, Hd = 6, Id = 7, Jd = 8;
        R("M", ["MM", 2], "Mo", function () {
            return this.month() + 1
        }), R("MMM", 0, 0, function (a) {
            return this.localeData().monthsShort(this, a)
        }), R("MMMM", 0, 0, function (a) {
            return this.localeData().months(this, a)
        }), J("month", "M"), W("M", nd), W("MM", nd, jd), W("MMM", function (a, b) {
            return b.monthsShortRegex(a)
        }), W("MMMM", function (a, b) {
            return b.monthsRegex(a)
        }), $(["M", "MM"], function (a, b) {
            b[Cd] = r(a) - 1
        }), $(["MMM", "MMMM"], function (a, b, c, d) {
            var e = c._locale.monthsParse(a, d, c._strict);
            null != e ? b[Cd] = e : j(c).invalidMonth = a
        });
        var Kd = /D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/, Ld = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"), Md = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"), Nd = yd, Od = yd, Pd = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/, Qd = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/, Rd = /Z|[+-]\d\d(?::?\d\d)?/, Sd = [["YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/], ["YYYY-MM-DD", /\d{4}-\d\d-\d\d/], ["GGGG-[W]WW-E", /\d{4}-W\d\d-\d/], ["GGGG-[W]WW", /\d{4}-W\d\d/, !1], ["YYYY-DDD", /\d{4}-\d{3}/], ["YYYY-MM", /\d{4}-\d\d/, !1], ["YYYYYYMMDD", /[+-]\d{10}/], ["YYYYMMDD", /\d{8}/], ["GGGG[W]WWE", /\d{4}W\d{3}/], ["GGGG[W]WW", /\d{4}W\d{2}/, !1], ["YYYYDDD", /\d{7}/]], Td = [["HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/], ["HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/], ["HH:mm:ss", /\d\d:\d\d:\d\d/], ["HH:mm", /\d\d:\d\d/], ["HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/], ["HHmmss,SSSS", /\d\d\d\d\d\d,\d+/], ["HHmmss", /\d\d\d\d\d\d/], ["HHmm", /\d\d\d\d/], ["HH", /\d\d/]], Ud = /^\/?Date\((\-?\d+)/i;
        a.createFromInputFallback = u("moment construction falls back to js Date. This is discouraged and will be removed in upcoming major release. Please refer to https://github.com/moment/moment/issues/1407 for more info.", function (a) {
            a._d = new Date(a._i + (a._useUTC ? " UTC" : ""))
        }), R("Y", 0, 0, function () {
            var a = this.year();
            return 9999 >= a ? "" + a : "+" + a
        }), R(0, ["YY", 2], 0, function () {
            return this.year() % 100
        }), R(0, ["YYYY", 4], 0, "year"), R(0, ["YYYYY", 5], 0, "year"), R(0, ["YYYYYY", 6, !0], 0, "year"), J("year", "y"), W("Y", ud), W("YY", nd, jd), W("YYYY", rd, ld), W("YYYYY", sd, md), W("YYYYYY", sd, md), $(["YYYYY", "YYYYYY"], Bd), $("YYYY", function (b, c) {
            c[Bd] = 2 === b.length ? a.parseTwoDigitYear(b) : r(b);
        }), $("YY", function (b, c) {
            c[Bd] = a.parseTwoDigitYear(b)
        }), $("Y", function (a, b) {
            b[Bd] = parseInt(a, 10)
        }), a.parseTwoDigitYear = function (a) {
            return r(a) + (r(a) > 68 ? 1900 : 2e3)
        };
        var Vd = M("FullYear", !1);
        a.ISO_8601 = function () {};
        var Wd = u("moment().min is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548", function () {
            var a = Ja.apply(null, arguments);
            return this.isValid() && a.isValid() ? this > a ? this : a : l()
        }), Xd = u("moment().max is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548", function () {
            var a = Ja.apply(null, arguments);
            return this.isValid() && a.isValid() ? a > this ? this : a : l()
        }), Yd = function () {
            return Date.now ? Date.now() : +new Date
        };
        Pa("Z", ":"), Pa("ZZ", ""), W("Z", wd), W("ZZ", wd), $(["Z", "ZZ"], function (a, b, c) {
            c._useUTC = !0, c._tzm = Qa(wd, a)
        });
        var Zd = /([\+\-]|\d\d)/gi;
        a.updateOffset = function () {};
        var $d = /^(\-)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?\d*)?$/, _d = /^(-)?P(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)W)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?$/;
        cb.fn = Na.prototype;
        var ae = hb(1, "add"), be = hb(-1, "subtract");
        a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ";
        var ce = u("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.", function (a) {
            return void 0 === a ? this.localeData() : this.locale(a)
        });
        R(0, ["gg", 2], 0, function () {
            return this.weekYear() % 100
        }), R(0, ["GG", 2], 0, function () {
            return this.isoWeekYear() % 100
        }), Ob("gggg", "weekYear"), Ob("ggggg", "weekYear"), Ob("GGGG", "isoWeekYear"), Ob("GGGGG", "isoWeekYear"), J("weekYear", "gg"), J("isoWeekYear", "GG"), W("G", ud), W("g", ud), W("GG", nd, jd), W("gg", nd, jd), W("GGGG", rd, ld), W("gggg", rd, ld), W("GGGGG", sd, md), W("ggggg", sd, md), _(["gggg", "ggggg", "GGGG", "GGGGG"], function (a, b, c, d) {
            b[d.substr(0, 2)] = r(a)
        }), _(["gg", "GG"], function (b, c, d, e) {
            c[e] = a.parseTwoDigitYear(b)
        }), R("Q", 0, "Qo", "quarter"), J("quarter", "Q"), W("Q", id), $("Q", function (a, b) {
            b[Cd] = 3 * (r(a) - 1)
        }), R("w", ["ww", 2], "wo", "week"), R("W", ["WW", 2], "Wo", "isoWeek"), J("week", "w"), J("isoWeek", "W"), W("w", nd), W("ww", nd, jd), W("W", nd), W("WW", nd, jd), _(["w", "ww", "W", "WW"], function (a, b, c, d) {
            b[d.substr(0, 1)] = r(a)
        });
        var de = {dow: 0, doy: 6};
        R("D", ["DD", 2], "Do", "date"), J("date", "D"), W("D", nd), W("DD", nd, jd), W("Do", function (a, b) {
            return a ? b._ordinalParse : b._ordinalParseLenient
        }), $(["D", "DD"], Dd), $("Do", function (a, b) {
            b[Dd] = r(a.match(nd)[0], 10)
        });
        var ee = M("Date", !0);
        R("d", 0, "do", "day"), R("dd", 0, 0, function (a) {
            return this.localeData().weekdaysMin(this, a)
        }), R("ddd", 0, 0, function (a) {
            return this.localeData().weekdaysShort(this, a)
        }), R("dddd", 0, 0, function (a) {
            return this.localeData().weekdays(this, a)
        }), R("e", 0, 0, "weekday"), R("E", 0, 0, "isoWeekday"), J("day", "d"), J("weekday", "e"), J("isoWeekday", "E"), W("d", nd), W("e", nd), W("E", nd), W("dd", yd), W("ddd", yd), W("dddd", yd), _(["dd", "ddd", "dddd"], function (a, b, c, d) {
            var e = c._locale.weekdaysParse(a, d, c._strict);
            null != e ? b.d = e : j(c).invalidWeekday = a
        }), _(["d", "e", "E"], function (a, b, c, d) {
            b[d] = r(a)
        });
        var fe = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"), ge = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"), he = "Su_Mo_Tu_We_Th_Fr_Sa".split("_");
        R("DDD", ["DDDD", 3], "DDDo", "dayOfYear"), J("dayOfYear", "DDD"), W("DDD", qd), W("DDDD", kd), $(["DDD", "DDDD"], function (a, b, c) {
            c._dayOfYear = r(a)
        }), R("H", ["HH", 2], 0, "hour"), R("h", ["hh", 2], 0, ic), R("hmm", 0, 0, function () {
            return"" + ic.apply(this) + Q(this.minutes(), 2)
        }), R("hmmss", 0, 0, function () {
            return"" + ic.apply(this) + Q(this.minutes(), 2) + Q(this.seconds(), 2)
        }), R("Hmm", 0, 0, function () {
            return"" + this.hours() + Q(this.minutes(), 2)
        }), R("Hmmss", 0, 0, function () {
            return"" + this.hours() + Q(this.minutes(), 2) + Q(this.seconds(), 2)
        }), jc("a", !0), jc("A", !1), J("hour", "h"), W("a", kc), W("A", kc), W("H", nd), W("h", nd), W("HH", nd, jd), W("hh", nd, jd), W("hmm", od), W("hmmss", pd), W("Hmm", od), W("Hmmss", pd), $(["H", "HH"], Ed), $(["a", "A"], function (a, b, c) {
            c._isPm = c._locale.isPM(a), c._meridiem = a
        }), $(["h", "hh"], function (a, b, c) {
            b[Ed] = r(a), j(c).bigHour = !0
        }), $("hmm", function (a, b, c) {
            var d = a.length - 2;
            b[Ed] = r(a.substr(0, d)), b[Fd] = r(a.substr(d)), j(c).bigHour = !0
        }), $("hmmss", function (a, b, c) {
            var d = a.length - 4, e = a.length - 2;
            b[Ed] = r(a.substr(0, d)), b[Fd] = r(a.substr(d, 2)), b[Gd] = r(a.substr(e)), j(c).bigHour = !0
        }), $("Hmm", function (a, b, c) {
            var d = a.length - 2;
            b[Ed] = r(a.substr(0, d)), b[Fd] = r(a.substr(d))
        }), $("Hmmss", function (a, b, c) {
            var d = a.length - 4, e = a.length - 2;
            b[Ed] = r(a.substr(0, d)), b[Fd] = r(a.substr(d, 2)), b[Gd] = r(a.substr(e))
        });
        var ie = /[ap]\.?m?\.?/i, je = M("Hours", !0);
        R("m", ["mm", 2], 0, "minute"), J("minute", "m"), W("m", nd), W("mm", nd, jd), $(["m", "mm"], Fd);
        var ke = M("Minutes", !1);
        R("s", ["ss", 2], 0, "second"), J("second", "s"), W("s", nd), W("ss", nd, jd), $(["s", "ss"], Gd);
        var le = M("Seconds", !1);
        R("S", 0, 0, function () {
            return~~(this.millisecond() / 100)
        }), R(0, ["SS", 2], 0, function () {
            return~~(this.millisecond() / 10)
        }), R(0, ["SSS", 3], 0, "millisecond"), R(0, ["SSSS", 4], 0, function () {
            return 10 * this.millisecond()
        }), R(0, ["SSSSS", 5], 0, function () {
            return 100 * this.millisecond()
        }), R(0, ["SSSSSS", 6], 0, function () {
            return 1e3 * this.millisecond()
        }), R(0, ["SSSSSSS", 7], 0, function () {
            return 1e4 * this.millisecond()
        }), R(0, ["SSSSSSSS", 8], 0, function () {
            return 1e5 * this.millisecond()
        }), R(0, ["SSSSSSSSS", 9], 0, function () {
            return 1e6 * this.millisecond()
        }), J("millisecond", "ms"), W("S", qd, id), W("SS", qd, jd), W("SSS", qd, kd);
        var me;
        for (me = "SSSS"; me.length <= 9; me += "S")
            W(me, td);
        for (me = "S"; me.length <= 9; me += "S")
            $(me, nc);
        var ne = M("Milliseconds", !1);
        R("z", 0, 0, "zoneAbbr"), R("zz", 0, 0, "zoneName");
        var oe = o.prototype;
        oe.add = ae, oe.calendar = jb, oe.clone = kb, oe.diff = rb, oe.endOf = Db, oe.format = vb, oe.from = wb, oe.fromNow = xb, oe.to = yb, oe.toNow = zb, oe.get = P, oe.invalidAt = Mb, oe.isAfter = lb, oe.isBefore = mb, oe.isBetween = nb, oe.isSame = ob, oe.isSameOrAfter = pb, oe.isSameOrBefore = qb, oe.isValid = Kb, oe.lang = ce, oe.locale = Ab, oe.localeData = Bb, oe.max = Xd, oe.min = Wd, oe.parsingFlags = Lb, oe.set = P, oe.startOf = Cb, oe.subtract = be, oe.toArray = Hb, oe.toObject = Ib, oe.toDate = Gb, oe.toISOString = ub, oe.toJSON = Jb, oe.toString = tb, oe.unix = Fb, oe.valueOf = Eb, oe.creationData = Nb, oe.year = Vd, oe.isLeapYear = sa, oe.weekYear = Pb, oe.isoWeekYear = Qb, oe.quarter = oe.quarters = Vb, oe.month = ga, oe.daysInMonth = ha, oe.week = oe.weeks = Zb, oe.isoWeek = oe.isoWeeks = $b, oe.weeksInYear = Sb, oe.isoWeeksInYear = Rb, oe.date = ee, oe.day = oe.days = ec, oe.weekday = fc, oe.isoWeekday = gc, oe.dayOfYear = hc, oe.hour = oe.hours = je, oe.minute = oe.minutes = ke, oe.second = oe.seconds = le, oe.millisecond = oe.milliseconds = ne, oe.utcOffset = Ta, oe.utc = Va, oe.local = Wa, oe.parseZone = Xa, oe.hasAlignedHourOffset = Ya, oe.isDST = Za, oe.isDSTShifted = $a, oe.isLocal = _a, oe.isUtcOffset = ab, oe.isUtc = bb, oe.isUTC = bb, oe.zoneAbbr = oc, oe.zoneName = pc, oe.dates = u("dates accessor is deprecated. Use date instead.", ee), oe.months = u("months accessor is deprecated. Use month instead", ga), oe.years = u("years accessor is deprecated. Use year instead", Vd), oe.zone = u("moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779", Ua);
        var pe = oe, qe = {sameDay: "[Today at] LT", nextDay: "[Tomorrow at] LT", nextWeek: "dddd [at] LT", lastDay: "[Yesterday at] LT", lastWeek: "[Last] dddd [at] LT", sameElse: "L"}, re = {LTS: "h:mm:ss A", LT: "h:mm A", L: "MM/DD/YYYY", LL: "MMMM D, YYYY", LLL: "MMMM D, YYYY h:mm A", LLLL: "dddd, MMMM D, YYYY h:mm A"}, se = "Invalid date", te = "%d", ue = /\d{1,2}/, ve = {future: "in %s", past: "%s ago", s: "a few seconds", m: "a minute", mm: "%d minutes", h: "an hour", hh: "%d hours", d: "a day", dd: "%d days", M: "a month", MM: "%d months", y: "a year", yy: "%d years"}, we = A.prototype;
        we._calendar = qe, we.calendar = sc, we._longDateFormat = re, we.longDateFormat = tc, we._invalidDate = se, we.invalidDate = uc, we._ordinal = te, we.ordinal = vc, we._ordinalParse = ue, we.preparse = wc, we.postformat = wc, we._relativeTime = ve, we.relativeTime = xc, we.pastFuture = yc, we.set = y, we.months = ca, we._months = Ld, we.monthsShort = da, we._monthsShort = Md, we.monthsParse = ea, we._monthsRegex = Od, we.monthsRegex = ja, we._monthsShortRegex = Nd, we.monthsShortRegex = ia, we.week = Wb, we._week = de, we.firstDayOfYear = Yb, we.firstDayOfWeek = Xb, we.weekdays = ac, we._weekdays = fe, we.weekdaysMin = cc, we._weekdaysMin = he, we.weekdaysShort = bc, we._weekdaysShort = ge, we.weekdaysParse = dc, we.isPM = lc, we._meridiemParse = ie, we.meridiem = mc, E("en", {ordinalParse: /\d{1,2}(th|st|nd|rd)/, ordinal: function (a) {
                var b = a % 10, c = 1 === r(a % 100 / 10) ? "th" : 1 === b ? "st" : 2 === b ? "nd" : 3 === b ? "rd" : "th";
                return a + c
            }}), a.lang = u("moment.lang is deprecated. Use moment.locale instead.", E), a.langData = u("moment.langData is deprecated. Use moment.localeData instead.", H);
        var xe = Math.abs, ye = Qc("ms"), ze = Qc("s"), Ae = Qc("m"), Be = Qc("h"), Ce = Qc("d"), De = Qc("w"), Ee = Qc("M"), Fe = Qc("y"), Ge = Sc("milliseconds"), He = Sc("seconds"), Ie = Sc("minutes"), Je = Sc("hours"), Ke = Sc("days"), Le = Sc("months"), Me = Sc("years"), Ne = Math.round, Oe = {s: 45, m: 45, h: 22, d: 26, M: 11}, Pe = Math.abs, Qe = Na.prototype;
        Qe.abs = Gc, Qe.add = Ic, Qe.subtract = Jc, Qe.as = Oc, Qe.asMilliseconds = ye, Qe.asSeconds = ze, Qe.asMinutes = Ae, Qe.asHours = Be, Qe.asDays = Ce, Qe.asWeeks = De, Qe.asMonths = Ee, Qe.asYears = Fe, Qe.valueOf = Pc, Qe._bubble = Lc, Qe.get = Rc, Qe.milliseconds = Ge, Qe.seconds = He, Qe.minutes = Ie, Qe.hours = Je, Qe.days = Ke, Qe.weeks = Tc, Qe.months = Le, Qe.years = Me, Qe.humanize = Xc, Qe.toISOString = Yc, Qe.toString = Yc, Qe.toJSON = Yc, Qe.locale = Ab, Qe.localeData = Bb, Qe.toIsoString = u("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", Yc), Qe.lang = ce, R("X", 0, 0, "unix"), R("x", 0, 0, "valueOf"), W("x", ud), W("X", xd), $("X", function (a, b, c) {
            c._d = new Date(1e3 * parseFloat(a, 10))
        }), $("x", function (a, b, c) {
            c._d = new Date(r(a))
        }), a.version = "2.12.0", b(Ja), a.fn = pe, a.min = La, a.max = Ma, a.now = Yd, a.utc = h, a.unix = qc, a.months = Bc, a.isDate = d, a.locale = E, a.invalid = l, a.duration = cb, a.isMoment = p, a.weekdays = Dc, a.parseZone = rc, a.localeData = H, a.isDuration = Oa, a.monthsShort = Cc, a.weekdaysMin = Fc, a.defineLocale = F, a.updateLocale = G, a.locales = I, a.weekdaysShort = Ec, a.normalizeUnits = K, a.relativeTimeThreshold = Wc, a.prototype = pe;
        var Re = a;
        return Re
    });

    /*!
     Colorbox 1.6.3
     license: MIT
     http://www.jacklmoore.com/colorbox
     */
    (function (t, e, i) {
        function n(i, n, o) {
            var r = e.createElement(i);
            return n && (r.id = Z + n), o && (r.style.cssText = o), t(r)
        }
        function o() {
            return i.innerHeight ? i.innerHeight : t(i).height()
        }
        function r(e, i) {
            i !== Object(i) && (i = {}), this.cache = {}, this.el = e, this.value = function (e) {
                var n;
                return void 0 === this.cache[e] && (n = t(this.el).attr("data-cbox-" + e), void 0 !== n ? this.cache[e] = n : void 0 !== i[e] ? this.cache[e] = i[e] : void 0 !== X[e] && (this.cache[e] = X[e])), this.cache[e]
            }, this.get = function (e) {
                var i = this.value(e);
                return t.isFunction(i) ? i.call(this.el, this) : i
            }
        }
        function h(t) {
            var e = W.length, i = (A + t) % e;
            return 0 > i ? e + i : i
        }
        function a(t, e) {
            return Math.round((/%/.test(t) ? ("x" === e ? E.width() : o()) / 100 : 1) * parseInt(t, 10))
        }
        function s(t, e) {
            return t.get("photo") || t.get("photoRegex").test(e)
        }
        function l(t, e) {
            return t.get("retinaUrl") && i.devicePixelRatio > 1 ? e.replace(t.get("photoRegex"), t.get("retinaSuffix")) : e
        }
        function d(t) {
            "contains"in x[0] && !x[0].contains(t.target) && t.target !== v[0] && (t.stopPropagation(), x.focus())
        }
        function c(t) {
            c.str !== t && (x.add(v).removeClass(c.str).addClass(t), c.str = t)
        }
        function g(e) {
            A = 0, e && e !== !1 && "nofollow" !== e ? (W = t("." + te).filter(function () {
                var i = t.data(this, Y), n = new r(this, i);
                return n.get("rel") === e
            }), A = W.index(_.el), -1 === A && (W = W.add(_.el), A = W.length - 1)) : W = t(_.el)
        }
        function u(i) {
            t(e).trigger(i), ae.triggerHandler(i)
        }
        function f(i) {
            var o;
            if (!G) {
                if (o = t(i).data(Y), _ = new r(i, o), g(_.get("rel")), !$) {
                    $ = q = !0, c(_.get("className")), x.css({visibility: "hidden", display: "block", opacity: ""}), I = n(se, "LoadedContent", "width:0; height:0; overflow:hidden; visibility:hidden"), b.css({width: "", height: ""}).append(I), j = T.height() + k.height() + b.outerHeight(!0) - b.height(), D = C.width() + H.width() + b.outerWidth(!0) - b.width(), N = I.outerHeight(!0), z = I.outerWidth(!0);
                    var h = a(_.get("initialWidth"), "x"), s = a(_.get("initialHeight"), "y"), l = _.get("maxWidth"), f = _.get("maxHeight");
                    _.w = Math.max((l !== !1 ? Math.min(h, a(l, "x")) : h) - z - D, 0), _.h = Math.max((f !== !1 ? Math.min(s, a(f, "y")) : s) - N - j, 0), I.css({width: "", height: _.h}), J.position(), u(ee), _.get("onOpen"), O.add(F).hide(), x.focus(), _.get("trapFocus") && e.addEventListener && (e.addEventListener("focus", d, !0), ae.one(re, function () {
                        e.removeEventListener("focus", d, !0)
                    })), _.get("returnFocus") && ae.one(re, function () {
                        t(_.el).focus()
                    })
                }
                var p = parseFloat(_.get("opacity"));
                v.css({opacity: p === p ? p : "", cursor: _.get("overlayClose") ? "pointer" : "", visibility: "visible"}).show(), _.get("closeButton") ? B.html(_.get("close")).appendTo(b) : B.appendTo("<div/>"), w()
            }
        }
        function p() {
            x || (V = !1, E = t(i), x = n(se).attr({id: Y, "class": t.support.opacity === !1 ? Z + "IE" : "", role: "dialog", tabindex: "-1"}).hide(), v = n(se, "Overlay").hide(), L = t([n(se, "LoadingOverlay")[0], n(se, "LoadingGraphic")[0]]), y = n(se, "Wrapper"), b = n(se, "Content").append(F = n(se, "Title"), R = n(se, "Current"), P = t('<button type="button"/>').attr({id: Z + "Anterior"}), K = t('<button type="button"/>').attr({id: Z + "Próximo"}), S = n("button", "Slideshow"), L), B = t('<button type="button"/>').attr({id: Z + "Fechar"}), y.append(n(se).append(n(se, "TopLeft"), T = n(se, "TopCenter"), n(se, "TopRight")), n(se, !1, "clear:left").append(C = n(se, "MiddleLeft"), b, H = n(se, "MiddleRight")), n(se, !1, "clear:left").append(n(se, "BottomLeft"), k = n(se, "BottomCenter"), n(se, "BottomRight"))).find("div div").css({"float": "left"}), M = n(se, !1, "position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;"), O = K.add(P).add(R).add(S)), e.body && !x.parent().length && t(e.body).append(v, x.append(y, M))
        }
        function m() {
            function i(t) {
                t.which > 1 || t.shiftKey || t.altKey || t.metaKey || t.ctrlKey || (t.preventDefault(), f(this))
            }
            return x ? (V || (V = !0, K.click(function () {
                J.next()
            }), P.click(function () {
                J.prev()
            }), B.click(function () {
                J.close()
            }), v.click(function () {
                _.get("overlayClose") && J.close()
            }), t(e).bind("keydown." + Z, function (t) {
                var e = t.keyCode;
                $ && _.get("escKey") && 27 === e && (t.preventDefault(), J.close()), $ && _.get("arrowKey") && W[1] && !t.altKey && (37 === e ? (t.preventDefault(), P.click()) : 39 === e && (t.preventDefault(), K.click()))
            }), t.isFunction(t.fn.on) ? t(e).on("click." + Z, "." + te, i) : t("." + te).live("click." + Z, i)), !0) : !1
        }
        function w() {
            var e, o, r, h = J.prep, d = ++le;
            if (q = !0, U = !1, u(he), u(ie), _.get("onLoad"), _.h = _.get("height") ? a(_.get("height"), "y") - N - j : _.get("innerHeight") && a(_.get("innerHeight"), "y"), _.w = _.get("width") ? a(_.get("width"), "x") - z - D : _.get("innerWidth") && a(_.get("innerWidth"), "x"), _.mw = _.w, _.mh = _.h, _.get("maxWidth") && (_.mw = a(_.get("maxWidth"), "x") - z - D, _.mw = _.w && _.w < _.mw ? _.w : _.mw), _.get("maxHeight") && (_.mh = a(_.get("maxHeight"), "y") - N - j, _.mh = _.h && _.h < _.mh ? _.h : _.mh), e = _.get("href"), Q = setTimeout(function () {
                L.show()
            }, 100), _.get("inline")) {
                var c = t(e);
                r = t("<div>").hide().insertBefore(c), ae.one(he, function () {
                    r.replaceWith(c)
                }), h(c)
            } else
                _.get("iframe") ? h(" ") : _.get("html") ? h(_.get("html")) : s(_, e) ? (e = l(_, e), U = _.get("createImg"), t(U).addClass(Z + "Photo").bind("error." + Z, function () {
                    h(n(se, "Error").html(_.get("imgError")))
                }).one("load", function () {
                    d === le && setTimeout(function () {
                        var e;
                        _.get("retinaImage") && i.devicePixelRatio > 1 && (U.height = U.height / i.devicePixelRatio, U.width = U.width / i.devicePixelRatio), _.get("scalePhotos") && (o = function () {
                            U.height -= U.height * e, U.width -= U.width * e
                        }, _.mw && U.width > _.mw && (e = (U.width - _.mw) / U.width, o()), _.mh && U.height > _.mh && (e = (U.height - _.mh) / U.height, o())), _.h && (U.style.marginTop = Math.max(_.mh - U.height, 0) / 2 + "px"), W[1] && (_.get("loop") || W[A + 1]) && (U.style.cursor = "pointer", t(U).bind("click." + Z, function () {
                            J.next()
                        })), U.style.width = U.width + "px", U.style.height = U.height + "px", h(U)
                    }, 1)
                }), U.src = e) : e && M.load(e, _.get("data"), function (e, i) {
                    d === le && h("error" === i ? n(se, "Error").html(_.get("xhrError")) : t(this).contents())
                })
        }
        var v, x, y, b, T, C, H, k, W, E, I, M, L, F, R, S, K, P, B, O, _, j, D, N, z, A, U, $, q, G, Q, J, V, X = {html: !1, photo: !1, iframe: !1, inline: !1, transition: "elastic", speed: 300, fadeOut: 300, width: !1, initialWidth: "600", innerWidth: !1, maxWidth: !1, height: !1, initialHeight: "450", innerHeight: !1, maxHeight: !1, scalePhotos: !0, scrolling: !0, opacity: .9, preloading: !0, className: !1, overlayClose: !0, escKey: !0, arrowKey: !0, top: !1, bottom: !1, left: !1, right: !1, fixed: !1, data: void 0, closeButton: !0, fastIframe: !0, open: !1, reposition: !0, loop: !0, slideshow: !1, slideshowAuto: !0, slideshowSpeed: 2500, slideshowStart: "start slideshow", slideshowStop: "stop slideshow", photoRegex: /\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)((#|\?).*)?$/i, retinaImage: !1, retinaUrl: !1, retinaSuffix: "@2x.$1", current: "image {current} of {total}", previous: "previous", next: "next", close: "close", xhrError: "This content failed to load.", imgError: "This image failed to load.", returnFocus: !0, trapFocus: !0, onOpen: !1, onLoad: !1, onComplete: !1, onCleanup: !1, onClosed: !1, rel: function () {
                return this.rel
            }, href: function () {
                return t(this).attr("href")
            }, title: function () {
                return this.title
            }, createImg: function () {
                var e = new Image, i = t(this).data("cbox-img-attrs");
                return"object" == typeof i && t.each(i, function (t, i) {
                    e[t] = i
                }), e
            }, createIframe: function () {
                var i = e.createElement("iframe"), n = t(this).data("cbox-iframe-attrs");
                return"object" == typeof n && t.each(n, function (t, e) {
                    i[t] = e
                }), "frameBorder"in i && (i.frameBorder = 0), "allowTransparency"in i && (i.allowTransparency = "true"), i.name = (new Date).getTime(), i.allowFullscreen = !0, i
            }}, Y = "colorbox", Z = "cbox", te = Z + "Element", ee = Z + "_open", ie = Z + "_load", ne = Z + "_complete", oe = Z + "_cleanup", re = Z + "_closed", he = Z + "_purge", ae = t("<a/>"), se = "div", le = 0, de = {}, ce = function () {
            function t() {
                clearTimeout(h)
            }
            function e() {
                (_.get("loop") || W[A + 1]) && (t(), h = setTimeout(J.next, _.get("slideshowSpeed")))
            }
            function i() {
                S.html(_.get("slideshowStop")).unbind(s).one(s, n), ae.bind(ne, e).bind(ie, t), x.removeClass(a + "off").addClass(a + "on")
            }
            function n() {
                t(), ae.unbind(ne, e).unbind(ie, t), S.html(_.get("slideshowStart")).unbind(s).one(s, function () {
                    J.next(), i()
                }), x.removeClass(a + "on").addClass(a + "off")
            }
            function o() {
                r = !1, S.hide(), t(), ae.unbind(ne, e).unbind(ie, t), x.removeClass(a + "off " + a + "on")
            }
            var r, h, a = Z + "Slideshow_", s = "click." + Z;
            return function () {
                r ? _.get("slideshow") || (ae.unbind(oe, o), o()) : _.get("slideshow") && W[1] && (r = !0, ae.one(oe, o), _.get("slideshowAuto") ? i() : n(), S.show())
            }
        }();
        t[Y] || (t(p), J = t.fn[Y] = t[Y] = function (e, i) {
            var n, o = this;
            return e = e || {}, t.isFunction(o) && (o = t("<a/>"), e.open = !0), o[0] ? (p(), m() && (i && (e.onComplete = i), o.each(function () {
                var i = t.data(this, Y) || {};
                t.data(this, Y, t.extend(i, e))
            }).addClass(te), n = new r(o[0], e), n.get("open") && f(o[0])), o) : o
        }, J.position = function (e, i) {
            function n() {
                T[0].style.width = k[0].style.width = b[0].style.width = parseInt(x[0].style.width, 10) - D + "px", b[0].style.height = C[0].style.height = H[0].style.height = parseInt(x[0].style.height, 10) - j + "px"
            }
            var r, h, s, l = 0, d = 0, c = x.offset();
            if (E.unbind("resize." + Z), x.css({top: -9e4, left: -9e4}), h = E.scrollTop(), s = E.scrollLeft(), _.get("fixed") ? (c.top -= h, c.left -= s, x.css({position: "fixed"})) : (l = h, d = s, x.css({position: "absolute"})), d += _.get("right") !== !1 ? Math.max(E.width() - _.w - z - D - a(_.get("right"), "x"), 0) : _.get("left") !== !1 ? a(_.get("left"), "x") : Math.round(Math.max(E.width() - _.w - z - D, 0) / 2), l += _.get("bottom") !== !1 ? Math.max(o() - _.h - N - j - a(_.get("bottom"), "y"), 0) : _.get("top") !== !1 ? a(_.get("top"), "y") : Math.round(Math.max(o() - _.h - N - j, 0) / 2), x.css({top: c.top, left: c.left, visibility: "visible"}), y[0].style.width = y[0].style.height = "9999px", r = {width: _.w + z + D, height: _.h + N + j, top: l, left: d}, e) {
                var g = 0;
                t.each(r, function (t) {
                    return r[t] !== de[t] ? (g = e, void 0) : void 0
                }), e = g
            }
            de = r, e || x.css(r), x.dequeue().animate(r, {duration: e || 0, complete: function () {
                    n(), q = !1, y[0].style.width = _.w + z + D + "px", y[0].style.height = _.h + N + j + "px", _.get("reposition") && setTimeout(function () {
                        E.bind("resize." + Z, J.position)
                    }, 1), t.isFunction(i) && i()
                }, step: n})
        }, J.resize = function (t) {
            var e;
            $ && (t = t || {}, t.width && (_.w = a(t.width, "x") - z - D), t.innerWidth && (_.w = a(t.innerWidth, "x")), I.css({width: _.w}), t.height && (_.h = a(t.height, "y") - N - j), t.innerHeight && (_.h = a(t.innerHeight, "y")), t.innerHeight || t.height || (e = I.scrollTop(), I.css({height: "auto"}), _.h = I.height()), I.css({height: _.h}), e && I.scrollTop(e), J.position("none" === _.get("transition") ? 0 : _.get("speed")))
        }, J.prep = function (i) {
            function o() {
                return _.w = _.w || I.width(), _.w = _.mw && _.mw < _.w ? _.mw : _.w, _.w
            }
            function a() {
                return _.h = _.h || I.height(), _.h = _.mh && _.mh < _.h ? _.mh : _.h, _.h
            }
            if ($) {
                var d, g = "none" === _.get("transition") ? 0 : _.get("speed");
                I.remove(), I = n(se, "LoadedContent").append(i), I.hide().appendTo(M.show()).css({width: o(), overflow: _.get("scrolling") ? "auto" : "hidden"}).css({height: a()}).prependTo(b), M.hide(), t(U).css({"float": "none"}), c(_.get("className")), d = function () {
                    function i() {
                        t.support.opacity === !1 && x[0].style.removeAttribute("filter")
                    }
                    var n, o, a = W.length;
                    $ && (o = function () {
                        clearTimeout(Q), L.hide(), u(ne), _.get("onComplete")
                    }, F.html(_.get("title")).show(), I.show(), a > 1 ? ("string" == typeof _.get("current") && R.html(_.get("current").replace("{current}", A + 1).replace("{total}", a)).show(), K[_.get("loop") || a - 1 > A ? "show" : "hide"]().html(_.get("next")), P[_.get("loop") || A ? "show" : "hide"]().html(_.get("previous")), ce(), _.get("preloading") && t.each([h(-1), h(1)], function () {
                        var i, n = W[this], o = new r(n, t.data(n, Y)), h = o.get("href");
                        h && s(o, h) && (h = l(o, h), i = e.createElement("img"), i.src = h)
                    })) : O.hide(), _.get("iframe") ? (n = _.get("createIframe"), _.get("scrolling") || (n.scrolling = "no"), t(n).attr({src: _.get("href"), "class": Z + "Iframe"}).one("load", o).appendTo(I), ae.one(he, function () {
                        n.src = "//about:blank"
                    }), _.get("fastIframe") && t(n).trigger("load")) : o(), "fade" === _.get("transition") ? x.fadeTo(g, 1, i) : i())
                }, "fade" === _.get("transition") ? x.fadeTo(g, 0, function () {
                    J.position(0, d)
                }) : J.position(g, d)
            }
        }, J.next = function () {
            !q && W[1] && (_.get("loop") || W[A + 1]) && (A = h(1), f(W[A]))
        }, J.prev = function () {
            !q && W[1] && (_.get("loop") || A) && (A = h(-1), f(W[A]))
        }, J.close = function () {
            $ && !G && (G = !0, $ = !1, u(oe), _.get("onCleanup"), E.unbind("." + Z), v.fadeTo(_.get("fadeOut") || 0, 0), x.stop().fadeTo(_.get("fadeOut") || 0, 0, function () {
                x.hide(), v.hide(), u(he), I.remove(), setTimeout(function () {
                    G = !1, u(re), _.get("onClosed")
                }, 1)
            }))
        }, J.remove = function () {
            x && (x.stop(), t[Y].close(), x.stop(!1, !0).remove(), v.remove(), G = !1, x = null, t("." + te).removeData(Y).removeClass(te), t(e).unbind("click." + Z).unbind("keydown." + Z))
        }, J.element = function () {
            return t(_.el)
        }, J.settings = X)
    })(jQuery, document, window);

    /*!
     * Chart.js
     * http://chartjs.org/
     * Version: 1.0.2
     *
     * Copyright 2015 Nick Downie
     * Released under the MIT license
     * https://github.com/nnnick/Chart.js/blob/master/LICENSE.md
     */
    (function () {
        "use strict";
        var t = this, i = t.Chart, e = function (t) {
            this.canvas = t.canvas, this.ctx = t;
            var i = function (t, i) {
                return t["offset" + i] ? t["offset" + i] : document.defaultView.getComputedStyle(t).getPropertyValue(i)
            }, e = this.width = i(t.canvas, "Width") || t.canvas.width, n = this.height = i(t.canvas, "Height") || t.canvas.height;
            return e = this.width = t.canvas.width, n = this.height = t.canvas.height, this.aspectRatio = this.width / this.height, s.retinaScale(this), this
        };
        e.defaults = {global: {animation: !0, animationSteps: 60, animationEasing: "easeOutQuart", showScale: !0, scaleOverride: !1, scaleSteps: null, scaleStepWidth: null, scaleStartValue: null, scaleLineColor: "rgba(0,0,0,.1)", scaleLineWidth: 1, scaleShowLabels: !0, scaleLabel: "<%=value%>", scaleIntegersOnly: !0, scaleBeginAtZero: !1, scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif", scaleFontSize: 12, scaleFontStyle: "normal", scaleFontColor: "#666", responsive: !1, maintainAspectRatio: !0, showTooltips: !0, customTooltips: !1, tooltipEvents: ["mousemove", "touchstart", "touchmove", "mouseout"], tooltipFillColor: "rgba(0,0,0,0.8)", tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif", tooltipFontSize: 14, tooltipFontStyle: "normal", tooltipFontColor: "#fff", tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif", tooltipTitleFontSize: 14, tooltipTitleFontStyle: "bold", tooltipTitleFontColor: "#fff", tooltipTitleTemplate: "<%= label%>", tooltipYPadding: 6, tooltipXPadding: 6, tooltipCaretSize: 8, tooltipCornerRadius: 6, tooltipXOffset: 10, tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>", multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>", multiTooltipKeyBackground: "#fff", segmentColorDefault: ["#A6CEE3", "#1F78B4", "#B2DF8A", "#33A02C", "#FB9A99", "#E31A1C", "#FDBF6F", "#FF7F00", "#CAB2D6", "#6A3D9A", "#B4B482", "#B15928"], segmentHighlightColorDefaults: ["#CEF6FF", "#47A0DC", "#DAFFB2", "#5BC854", "#FFC2C1", "#FF4244", "#FFE797", "#FFA728", "#F2DAFE", "#9265C2", "#DCDCAA", "#D98150"], onAnimationProgress: function () {}, onAnimationComplete: function () {}}}, e.types = {};
        var s = e.helpers = {}, n = s.each = function (t, i, e) {
            var s = Array.prototype.slice.call(arguments, 3);
            if (t)
                if (t.length === +t.length) {
                    var n;
                    for (n = 0; n < t.length; n++)
                        i.apply(e, [t[n], n].concat(s))
                } else
                    for (var o in t)
                        i.apply(e, [t[o], o].concat(s))
        }, o = s.clone = function (t) {
            var i = {};
            return n(t, function (e, s) {
                t.hasOwnProperty(s) && (i[s] = e)
            }), i
        }, a = s.extend = function (t) {
            return n(Array.prototype.slice.call(arguments, 1), function (i) {
                n(i, function (e, s) {
                    i.hasOwnProperty(s) && (t[s] = e)
                })
            }), t
        }, h = s.merge = function (t, i) {
            var e = Array.prototype.slice.call(arguments, 0);
            return e.unshift({}), a.apply(null, e)
        }, l = s.indexOf = function (t, i) {
            if (Array.prototype.indexOf)
                return t.indexOf(i);
            for (var e = 0; e < t.length; e++)
                if (t[e] === i)
                    return e;
            return-1
        }, r = (s.where = function (t, i) {
            var e = [];
            return s.each(t, function (t) {
                i(t) && e.push(t)
            }), e
        }, s.findNextWhere = function (t, i, e) {
            e || (e = -1);
            for (var s = e + 1; s < t.length; s++) {
                var n = t[s];
                if (i(n))
                    return n
            }
        }, s.findPreviousWhere = function (t, i, e) {
            e || (e = t.length);
            for (var s = e - 1; s >= 0; s--) {
                var n = t[s];
                if (i(n))
                    return n
            }
        }, s.inherits = function (t) {
            var i = this, e = t && t.hasOwnProperty("constructor") ? t.constructor : function () {
                return i.apply(this, arguments)
            }, s = function () {
                this.constructor = e
            };
            return s.prototype = i.prototype, e.prototype = new s, e.extend = r, t && a(e.prototype, t), e.__super__ = i.prototype, e
        }), c = s.noop = function () {}, u = s.uid = function () {
            var t = 0;
            return function () {
                return"chart-" + t++
            }
        }(), d = s.warn = function (t) {
            window.console && "function" == typeof window.console.warn && console.warn(t)
        }, p = s.amd = "function" == typeof define && define.amd, f = s.isNumber = function (t) {
            return!isNaN(parseFloat(t)) && isFinite(t)
        }, g = s.max = function (t) {
            return Math.max.apply(Math, t)
        }, m = s.min = function (t) {
            return Math.min.apply(Math, t)
        }, v = (s.cap = function (t, i, e) {
            if (f(i)) {
                if (t > i)
                    return i
            } else if (f(e) && e > t)
                return e;
            return t
        }, s.getDecimalPlaces = function (t) {
            if (t % 1 !== 0 && f(t)) {
                var i = t.toString();
                if (i.indexOf("e-") < 0)
                    return i.split(".")[1].length;
                if (i.indexOf(".") < 0)
                    return parseInt(i.split("e-")[1]);
                var e = i.split(".")[1].split("e-");
                return e[0].length + parseInt(e[1])
            }
            return 0
        }), S = s.radians = function (t) {
            return t * (Math.PI / 180)
        }, x = (s.getAngleFromPoint = function (t, i) {
            var e = i.x - t.x, s = i.y - t.y, n = Math.sqrt(e * e + s * s), o = 2 * Math.PI + Math.atan2(s, e);
            return 0 > e && 0 > s && (o += 2 * Math.PI), {angle: o, distance: n}
        }, s.aliasPixel = function (t) {
            return t % 2 === 0 ? 0 : .5
        }), y = (s.splineCurve = function (t, i, e, s) {
            var n = Math.sqrt(Math.pow(i.x - t.x, 2) + Math.pow(i.y - t.y, 2)), o = Math.sqrt(Math.pow(e.x - i.x, 2) + Math.pow(e.y - i.y, 2)), a = s * n / (n + o), h = s * o / (n + o);
            return{inner: {x: i.x - a * (e.x - t.x), y: i.y - a * (e.y - t.y)}, outer: {x: i.x + h * (e.x - t.x), y: i.y + h * (e.y - t.y)}}
        }, s.calculateOrderOfMagnitude = function (t) {
            return Math.floor(Math.log(t) / Math.LN10)
        }), C = (s.calculateScaleRange = function (t, i, e, s, o) {
            var a = 2, h = Math.floor(i / (1.5 * e)), l = a >= h, r = [];
            n(t, function (t) {
                null == t || r.push(t)
            });
            var c = m(r), u = g(r);
            u === c && (u += .5, c >= .5 && !s ? c -= .5 : u += .5);
            for (var d = Math.abs(u - c), p = y(d), f = Math.ceil(u / (1 * Math.pow(10, p))) * Math.pow(10, p), v = s ? 0 : Math.floor(c / (1 * Math.pow(10, p))) * Math.pow(10, p), S = f - v, x = Math.pow(10, p), C = Math.round(S / x); (C > h || h > 2 * C) && !l; )
                if (C > h)
                    x *= 2, C = Math.round(S / x), C % 1 !== 0 && (l = !0);
                else if (o && p >= 0) {
                    if (x / 2 % 1 !== 0)
                        break;
                    x /= 2, C = Math.round(S / x)
                } else
                    x /= 2, C = Math.round(S / x);
            return l && (C = a, x = S / C), {steps: C, stepValue: x, min: v, max: v + C * x}
        }, s.template = function (t, i) {
            function e(t, i) {
                var e = /\W/.test(t) ? new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + t.replace(/[\r\t\n]/g, " ").split("<%").join("	").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("	").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');") : s[t] = s[t];
                return i ? e(i) : e
            }
            if (t instanceof Function)
                return t(i);
            var s = {};
            return e(t, i)
        }), b = (s.generateLabels = function (t, i, e, s) {
            var o = new Array(i);
            return t && n(o, function (i, n) {
                o[n] = C(t, {value: e + s * (n + 1)})
            }), o
        }, s.easingEffects = {linear: function (t) {
                return t
            }, easeInQuad: function (t) {
                return t * t
            }, easeOutQuad: function (t) {
                return-1 * t * (t - 2)
            }, easeInOutQuad: function (t) {
                return(t /= .5) < 1 ? .5 * t * t : -0.5 * (--t * (t - 2) - 1)
            }, easeInCubic: function (t) {
                return t * t * t
            }, easeOutCubic: function (t) {
                return 1 * ((t = t / 1 - 1) * t * t + 1)
            }, easeInOutCubic: function (t) {
                return(t /= .5) < 1 ? .5 * t * t * t : .5 * ((t -= 2) * t * t + 2)
            }, easeInQuart: function (t) {
                return t * t * t * t
            }, easeOutQuart: function (t) {
                return-1 * ((t = t / 1 - 1) * t * t * t - 1)
            }, easeInOutQuart: function (t) {
                return(t /= .5) < 1 ? .5 * t * t * t * t : -0.5 * ((t -= 2) * t * t * t - 2)
            }, easeInQuint: function (t) {
                return 1 * (t /= 1) * t * t * t * t
            }, easeOutQuint: function (t) {
                return 1 * ((t = t / 1 - 1) * t * t * t * t + 1)
            }, easeInOutQuint: function (t) {
                return(t /= .5) < 1 ? .5 * t * t * t * t * t : .5 * ((t -= 2) * t * t * t * t + 2)
            }, easeInSine: function (t) {
                return-1 * Math.cos(t / 1 * (Math.PI / 2)) + 1
            }, easeOutSine: function (t) {
                return 1 * Math.sin(t / 1 * (Math.PI / 2))
            }, easeInOutSine: function (t) {
                return-0.5 * (Math.cos(Math.PI * t / 1) - 1)
            }, easeInExpo: function (t) {
                return 0 === t ? 1 : 1 * Math.pow(2, 10 * (t / 1 - 1))
            }, easeOutExpo: function (t) {
                return 1 === t ? 1 : 1 * (-Math.pow(2, -10 * t / 1) + 1)
            }, easeInOutExpo: function (t) {
                return 0 === t ? 0 : 1 === t ? 1 : (t /= .5) < 1 ? .5 * Math.pow(2, 10 * (t - 1)) : .5 * (-Math.pow(2, -10 * --t) + 2)
            }, easeInCirc: function (t) {
                return t >= 1 ? t : -1 * (Math.sqrt(1 - (t /= 1) * t) - 1)
            }, easeOutCirc: function (t) {
                return 1 * Math.sqrt(1 - (t = t / 1 - 1) * t)
            }, easeInOutCirc: function (t) {
                return(t /= .5) < 1 ? -0.5 * (Math.sqrt(1 - t * t) - 1) : .5 * (Math.sqrt(1 - (t -= 2) * t) + 1)
            }, easeInElastic: function (t) {
                var i = 1.70158, e = 0, s = 1;
                return 0 === t ? 0 : 1 == (t /= 1) ? 1 : (e || (e = .3), s < Math.abs(1) ? (s = 1, i = e / 4) : i = e / (2 * Math.PI) * Math.asin(1 / s), -(s * Math.pow(2, 10 * (t -= 1)) * Math.sin((1 * t - i) * (2 * Math.PI) / e)))
            }, easeOutElastic: function (t) {
                var i = 1.70158, e = 0, s = 1;
                return 0 === t ? 0 : 1 == (t /= 1) ? 1 : (e || (e = .3), s < Math.abs(1) ? (s = 1, i = e / 4) : i = e / (2 * Math.PI) * Math.asin(1 / s), s * Math.pow(2, -10 * t) * Math.sin((1 * t - i) * (2 * Math.PI) / e) + 1)
            }, easeInOutElastic: function (t) {
                var i = 1.70158, e = 0, s = 1;
                return 0 === t ? 0 : 2 == (t /= .5) ? 1 : (e || (e = 1 * (.3 * 1.5)), s < Math.abs(1) ? (s = 1, i = e / 4) : i = e / (2 * Math.PI) * Math.asin(1 / s), 1 > t ? -.5 * (s * Math.pow(2, 10 * (t -= 1)) * Math.sin((1 * t - i) * (2 * Math.PI) / e)) : s * Math.pow(2, -10 * (t -= 1)) * Math.sin((1 * t - i) * (2 * Math.PI) / e) * .5 + 1)
            }, easeInBack: function (t) {
                var i = 1.70158;
                return 1 * (t /= 1) * t * ((i + 1) * t - i)
            }, easeOutBack: function (t) {
                var i = 1.70158;
                return 1 * ((t = t / 1 - 1) * t * ((i + 1) * t + i) + 1)
            }, easeInOutBack: function (t) {
                var i = 1.70158;
                return(t /= .5) < 1 ? .5 * (t * t * (((i *= 1.525) + 1) * t - i)) : .5 * ((t -= 2) * t * (((i *= 1.525) + 1) * t + i) + 2)
            }, easeInBounce: function (t) {
                return 1 - b.easeOutBounce(1 - t)
            }, easeOutBounce: function (t) {
                return(t /= 1) < 1 / 2.75 ? 1 * (7.5625 * t * t) : 2 / 2.75 > t ? 1 * (7.5625 * (t -= 1.5 / 2.75) * t + .75) : 2.5 / 2.75 > t ? 1 * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) : 1 * (7.5625 * (t -= 2.625 / 2.75) * t + .984375)
            }, easeInOutBounce: function (t) {
                return.5 > t ? .5 * b.easeInBounce(2 * t) : .5 * b.easeOutBounce(2 * t - 1) + .5
            }}), w = s.requestAnimFrame = function () {
            return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (t) {
                return window.setTimeout(t, 1e3 / 60)
            }
        }(), P = (s.cancelAnimFrame = function () {
            return window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || window.msCancelAnimationFrame || function (t) {
                return window.clearTimeout(t, 1e3 / 60)
            }
        }(), s.animationLoop = function (t, i, e, s, n, o) {
            var a = 0, h = b[e] || b.linear, l = function () {
                a++;
                var e = a / i, r = h(e);
                t.call(o, r, e, a), s.call(o, r, e), i > a ? o.animationFrame = w(l) : n.apply(o)
            };
            w(l)
        }, s.getRelativePosition = function (t) {
            var i, e, s = t.originalEvent || t, n = t.currentTarget || t.srcElement, o = n.getBoundingClientRect();
            return s.touches ? (i = s.touches[0].clientX - o.left, e = s.touches[0].clientY - o.top) : (i = s.clientX - o.left, e = s.clientY - o.top), {x: i, y: e}
        }, s.addEvent = function (t, i, e) {
            t.addEventListener ? t.addEventListener(i, e) : t.attachEvent ? t.attachEvent("on" + i, e) : t["on" + i] = e
        }), L = s.removeEvent = function (t, i, e) {
            t.removeEventListener ? t.removeEventListener(i, e, !1) : t.detachEvent ? t.detachEvent("on" + i, e) : t["on" + i] = c
        }, k = (s.bindEvents = function (t, i, e) {
            t.events || (t.events = {}), n(i, function (i) {
                t.events[i] = function () {
                    e.apply(t, arguments)
                }, P(t.chart.canvas, i, t.events[i])
            })
        }, s.unbindEvents = function (t, i) {
            n(i, function (i, e) {
                L(t.chart.canvas, e, i)
            })
        }), F = s.getMaximumWidth = function (t) {
            var i = t.parentNode, e = parseInt(R(i, "padding-left")) + parseInt(R(i, "padding-right"));
            return i ? i.clientWidth - e : 0
        }, A = s.getMaximumHeight = function (t) {
            var i = t.parentNode, e = parseInt(R(i, "padding-bottom")) + parseInt(R(i, "padding-top"));
            return i ? i.clientHeight - e : 0
        }, R = s.getStyle = function (t, i) {
            return t.currentStyle ? t.currentStyle[i] : document.defaultView.getComputedStyle(t, null).getPropertyValue(i)
        }, T = (s.getMaximumSize = s.getMaximumWidth, s.retinaScale = function (t) {
            var i = t.ctx, e = t.canvas.width, s = t.canvas.height;
            window.devicePixelRatio && (i.canvas.style.width = e + "px", i.canvas.style.height = s + "px", i.canvas.height = s * window.devicePixelRatio, i.canvas.width = e * window.devicePixelRatio, i.scale(window.devicePixelRatio, window.devicePixelRatio))
        }), M = s.clear = function (t) {
            t.ctx.clearRect(0, 0, t.width, t.height)
        }, W = s.fontString = function (t, i, e) {
            return i + " " + t + "px " + e
        }, z = s.longestText = function (t, i, e) {
            t.font = i;
            var s = 0;
            return n(e, function (i) {
                var e = t.measureText(i).width;
                s = e > s ? e : s
            }), s
        }, B = s.drawRoundedRectangle = function (t, i, e, s, n, o) {
            t.beginPath(), t.moveTo(i + o, e), t.lineTo(i + s - o, e), t.quadraticCurveTo(i + s, e, i + s, e + o), t.lineTo(i + s, e + n - o), t.quadraticCurveTo(i + s, e + n, i + s - o, e + n), t.lineTo(i + o, e + n), t.quadraticCurveTo(i, e + n, i, e + n - o), t.lineTo(i, e + o), t.quadraticCurveTo(i, e, i + o, e), t.closePath()
        };
        e.instances = {}, e.Type = function (t, i, s) {
            this.options = i, this.chart = s, this.id = u(), e.instances[this.id] = this, i.responsive && this.resize(), this.initialize.call(this, t)
        }, a(e.Type.prototype, {initialize: function () {
                return this
            }, clear: function () {
                return M(this.chart), this
            }, stop: function () {
                return e.animationService.cancelAnimation(this), this
            }, resize: function (t) {
                this.stop();
                var i = this.chart.canvas, e = F(this.chart.canvas), s = this.options.maintainAspectRatio ? e / this.chart.aspectRatio : A(this.chart.canvas);
                return i.width = this.chart.width = e, i.height = this.chart.height = s, T(this.chart), "function" == typeof t && t.apply(this, Array.prototype.slice.call(arguments, 1)), this
            }, reflow: c, render: function (t) {
                if (t && this.reflow(), this.options.animation && !t) {
                    var i = new e.Animation;
                    i.numSteps = this.options.animationSteps, i.easing = this.options.animationEasing, i.render = function (t, i) {
                        var e = s.easingEffects[i.easing], n = i.currentStep / i.numSteps, o = e(n);
                        t.draw(o, n, i.currentStep)
                    }, i.onAnimationProgress = this.options.onAnimationProgress, i.onAnimationComplete = this.options.onAnimationComplete, e.animationService.addAnimation(this, i)
                } else
                    this.draw(), this.options.onAnimationComplete.call(this);
                return this
            }, generateLegend: function () {
                return C(this.options.legendTemplate, this)
            }, destroy: function () {
                this.clear(), k(this, this.events);
                var t = this.chart.canvas;
                t.width = this.chart.width, t.height = this.chart.height, t.style.removeProperty ? (t.style.removeProperty("width"), t.style.removeProperty("height")) : (t.style.removeAttribute("width"), t.style.removeAttribute("height")), delete e.instances[this.id]
            }, showTooltip: function (t, i) {
                "undefined" == typeof this.activeElements && (this.activeElements = []);
                var o = function (t) {
                    var i = !1;
                    return t.length !== this.activeElements.length ? i = !0 : (n(t, function (t, e) {
                        t !== this.activeElements[e] && (i = !0)
                    }, this), i)
                }.call(this, t);
                if (o || i) {
                    if (this.activeElements = t, this.draw(), this.options.customTooltips && this.options.customTooltips(!1), t.length > 0)
                        if (this.datasets && this.datasets.length > 1) {
                            for (var a, h, r = this.datasets.length - 1; r >= 0 && (a = this.datasets[r].points || this.datasets[r].bars || this.datasets[r].segments, h = l(a, t[0]), - 1 === h); r--)
                                ;
                            var c = [], u = [], d = function (t) {
                                var i, e, n, o, a, l = [], r = [], d = [];
                                return s.each(this.datasets, function (t) {
                                    i = t.points || t.bars || t.segments, i[h] && i[h].hasValue() && l.push(i[h])
                                }), s.each(l, function (t) {
                                    r.push(t.x), d.push(t.y), c.push(s.template(this.options.multiTooltipTemplate, t)), u.push({fill: t._saved.fillColor || t.fillColor, stroke: t._saved.strokeColor || t.strokeColor})
                                }, this), a = m(d), n = g(d), o = m(r), e = g(r), {x: o > this.chart.width / 2 ? o : e, y: (a + n) / 2}
                            }.call(this, h);
                            new e.MultiTooltip({x: d.x, y: d.y, xPadding: this.options.tooltipXPadding, yPadding: this.options.tooltipYPadding, xOffset: this.options.tooltipXOffset, fillColor: this.options.tooltipFillColor, textColor: this.options.tooltipFontColor, fontFamily: this.options.tooltipFontFamily, fontStyle: this.options.tooltipFontStyle, fontSize: this.options.tooltipFontSize, titleTextColor: this.options.tooltipTitleFontColor, titleFontFamily: this.options.tooltipTitleFontFamily, titleFontStyle: this.options.tooltipTitleFontStyle, titleFontSize: this.options.tooltipTitleFontSize, cornerRadius: this.options.tooltipCornerRadius, labels: c, legendColors: u, legendColorBackground: this.options.multiTooltipKeyBackground, title: C(this.options.tooltipTitleTemplate, t[0]), chart: this.chart, ctx: this.chart.ctx, custom: this.options.customTooltips}).draw()
                        } else
                            n(t, function (t) {
                                var i = t.tooltipPosition();
                                new e.Tooltip({x: Math.round(i.x), y: Math.round(i.y), xPadding: this.options.tooltipXPadding, yPadding: this.options.tooltipYPadding, fillColor: this.options.tooltipFillColor, textColor: this.options.tooltipFontColor, fontFamily: this.options.tooltipFontFamily, fontStyle: this.options.tooltipFontStyle, fontSize: this.options.tooltipFontSize, caretHeight: this.options.tooltipCaretSize, cornerRadius: this.options.tooltipCornerRadius, text: C(this.options.tooltipTemplate, t), chart: this.chart, custom: this.options.customTooltips}).draw()
                            }, this);
                    return this
                }
            }, toBase64Image: function () {
                return this.chart.canvas.toDataURL.apply(this.chart.canvas, arguments)
            }}), e.Type.extend = function (t) {
            var i = this, s = function () {
                return i.apply(this, arguments)
            };
            if (s.prototype = o(i.prototype), a(s.prototype, t), s.extend = e.Type.extend, t.name || i.prototype.name) {
                var n = t.name || i.prototype.name, l = e.defaults[i.prototype.name] ? o(e.defaults[i.prototype.name]) : {};
                e.defaults[n] = a(l, t.defaults), e.types[n] = s, e.prototype[n] = function (t, i) {
                    var o = h(e.defaults.global, e.defaults[n], i || {});
                    return new s(t, o, this)
                }
            } else
                d("Name not provided for this chart, so it hasn't been registered");
            return i
        }, e.Element = function (t) {
            a(this, t), this.initialize.apply(this, arguments), this.save()
        }, a(e.Element.prototype, {initialize: function () {}, restore: function (t) {
                return t ? n(t, function (t) {
                    this[t] = this._saved[t]
                }, this) : a(this, this._saved), this
            }, save: function () {
                return this._saved = o(this), delete this._saved._saved, this
            }, update: function (t) {
                return n(t, function (t, i) {
                    this._saved[i] = this[i], this[i] = t
                }, this), this
            }, transition: function (t, i) {
                return n(t, function (t, e) {
                    this[e] = (t - this._saved[e]) * i + this._saved[e]
                }, this), this
            }, tooltipPosition: function () {
                return{x: this.x, y: this.y}
            }, hasValue: function () {
                return f(this.value)
            }}), e.Element.extend = r, e.Point = e.Element.extend({display: !0, inRange: function (t, i) {
                var e = this.hitDetectionRadius + this.radius;
                return Math.pow(t - this.x, 2) + Math.pow(i - this.y, 2) < Math.pow(e, 2)
            }, draw: function () {
                if (this.display) {
                    var t = this.ctx;
                    t.beginPath(), t.arc(this.x, this.y, this.radius, 0, 2 * Math.PI), t.closePath(), t.strokeStyle = this.strokeColor, t.lineWidth = this.strokeWidth, t.fillStyle = this.fillColor, t.fill(), t.stroke()
                }
            }}), e.Arc = e.Element.extend({inRange: function (t, i) {
                var e = s.getAngleFromPoint(this, {x: t, y: i}), n = e.angle % (2 * Math.PI), o = (2 * Math.PI + this.startAngle) % (2 * Math.PI), a = (2 * Math.PI + this.endAngle) % (2 * Math.PI) || 360, h = o > a ? a >= n || n >= o : n >= o && a >= n, l = e.distance >= this.innerRadius && e.distance <= this.outerRadius;
                return h && l
            }, tooltipPosition: function () {
                var t = this.startAngle + (this.endAngle - this.startAngle) / 2, i = (this.outerRadius - this.innerRadius) / 2 + this.innerRadius;
                return{x: this.x + Math.cos(t) * i, y: this.y + Math.sin(t) * i}
            }, draw: function (t) {
                var i = this.ctx;
                i.beginPath(), i.arc(this.x, this.y, this.outerRadius < 0 ? 0 : this.outerRadius, this.startAngle, this.endAngle), i.arc(this.x, this.y, this.innerRadius < 0 ? 0 : this.innerRadius, this.endAngle, this.startAngle, !0), i.closePath(), i.strokeStyle = this.strokeColor, i.lineWidth = this.strokeWidth, i.fillStyle = this.fillColor, i.fill(), i.lineJoin = "bevel", this.showStroke && i.stroke()
            }}), e.Rectangle = e.Element.extend({draw: function () {
                var t = this.ctx, i = this.width / 2, e = this.x - i, s = this.x + i, n = this.base - (this.base - this.y), o = this.strokeWidth / 2;
                this.showStroke && (e += o, s -= o, n += o), t.beginPath(), t.fillStyle = this.fillColor, t.strokeStyle = this.strokeColor, t.lineWidth = this.strokeWidth, t.moveTo(e, this.base), t.lineTo(e, n), t.lineTo(s, n), t.lineTo(s, this.base), t.fill(), this.showStroke && t.stroke()
            }, height: function () {
                return this.base - this.y
            }, inRange: function (t, i) {
                return t >= this.x - this.width / 2 && t <= this.x + this.width / 2 && i >= this.y && i <= this.base
            }}), e.Animation = e.Element.extend({currentStep: null, numSteps: 60, easing: "", render: null, onAnimationProgress: null, onAnimationComplete: null}), e.Tooltip = e.Element.extend({draw: function () {
                var t = this.chart.ctx;
                t.font = W(this.fontSize, this.fontStyle, this.fontFamily), this.xAlign = "center", this.yAlign = "above";
                var i = this.caretPadding = 2, e = t.measureText(this.text).width + 2 * this.xPadding, s = this.fontSize + 2 * this.yPadding, n = s + this.caretHeight + i;
                this.x + e / 2 > this.chart.width ? this.xAlign = "left" : this.x - e / 2 < 0 && (this.xAlign = "right"), this.y - n < 0 && (this.yAlign = "below");
                var o = this.x - e / 2, a = this.y - n;
                if (t.fillStyle = this.fillColor, this.custom)
                    this.custom(this);
                else {
                    switch (this.yAlign) {
                        case"above":
                            t.beginPath(), t.moveTo(this.x, this.y - i), t.lineTo(this.x + this.caretHeight, this.y - (i + this.caretHeight)), t.lineTo(this.x - this.caretHeight, this.y - (i + this.caretHeight)), t.closePath(), t.fill();
                            break;
                            case"below":
                            a = this.y + i + this.caretHeight, t.beginPath(), t.moveTo(this.x, this.y + i), t.lineTo(this.x + this.caretHeight, this.y + i + this.caretHeight), t.lineTo(this.x - this.caretHeight, this.y + i + this.caretHeight), t.closePath(), t.fill()
                        }
                    switch (this.xAlign) {
                        case"left":
                            o = this.x - e + (this.cornerRadius + this.caretHeight);
                            break;
                            case"right":
                            o = this.x - (this.cornerRadius + this.caretHeight)
                        }
                    B(t, o, a, e, s, this.cornerRadius), t.fill(), t.fillStyle = this.textColor, t.textAlign = "center", t.textBaseline = "middle", t.fillText(this.text, o + e / 2, a + s / 2)
                }
            }}), e.MultiTooltip = e.Element.extend({initialize: function () {
                this.font = W(this.fontSize, this.fontStyle, this.fontFamily), this.titleFont = W(this.titleFontSize, this.titleFontStyle, this.titleFontFamily), this.titleHeight = this.title ? 1.5 * this.titleFontSize : 0, this.height = this.labels.length * this.fontSize + (this.labels.length - 1) * (this.fontSize / 2) + 2 * this.yPadding + this.titleHeight, this.ctx.font = this.titleFont;
                var t = this.ctx.measureText(this.title).width, i = z(this.ctx, this.font, this.labels) + this.fontSize + 3, e = g([i, t]);
                this.width = e + 2 * this.xPadding;
                var s = this.height / 2;
                this.y - s < 0 ? this.y = s : this.y + s > this.chart.height && (this.y = this.chart.height - s), this.x > this.chart.width / 2 ? this.x -= this.xOffset + this.width : this.x += this.xOffset
            }, getLineHeight: function (t) {
                var i = this.y - this.height / 2 + this.yPadding, e = t - 1;
                return 0 === t ? i + this.titleHeight / 3 : i + (1.5 * this.fontSize * e + this.fontSize / 2) + this.titleHeight
            }, draw: function () {
                if (this.custom)
                    this.custom(this);
                else {
                    B(this.ctx, this.x, this.y - this.height / 2, this.width, this.height, this.cornerRadius);
                    var t = this.ctx;
                    t.fillStyle = this.fillColor, t.fill(), t.closePath(), t.textAlign = "left", t.textBaseline = "middle", t.fillStyle = this.titleTextColor, t.font = this.titleFont, t.fillText(this.title, this.x + this.xPadding, this.getLineHeight(0)), t.font = this.font, s.each(this.labels, function (i, e) {
                        t.fillStyle = this.textColor, t.fillText(i, this.x + this.xPadding + this.fontSize + 3, this.getLineHeight(e + 1)), t.fillStyle = this.legendColorBackground, t.fillRect(this.x + this.xPadding, this.getLineHeight(e + 1) - this.fontSize / 2, this.fontSize, this.fontSize), t.fillStyle = this.legendColors[e].fill, t.fillRect(this.x + this.xPadding, this.getLineHeight(e + 1) - this.fontSize / 2, this.fontSize, this.fontSize)
                    }, this)
                }
            }}), e.Scale = e.Element.extend({initialize: function () {
                this.fit()
            }, buildYLabels: function () {
                this.yLabels = [];
                for (var t = v(this.stepValue), i = 0; i <= this.steps; i++)
                    this.yLabels.push(C(this.templateString, {value: (this.min + i * this.stepValue).toFixed(t)}));
                this.yLabelWidth = this.display && this.showLabels ? z(this.ctx, this.font, this.yLabels) + 10 : 0
            }, addXLabel: function (t) {
                this.xLabels.push(t), this.valuesCount++, this.fit()
            }, removeXLabel: function () {
                this.xLabels.shift(), this.valuesCount--, this.fit()
            }, fit: function () {
                this.startPoint = this.display ? this.fontSize : 0, this.endPoint = this.display ? this.height - 1.5 * this.fontSize - 5 : this.height, this.startPoint += this.padding, this.endPoint -= this.padding;
                var t, i = this.endPoint, e = this.endPoint - this.startPoint;
                for (this.calculateYRange(e), this.buildYLabels(), this.calculateXLabelRotation(); e > this.endPoint - this.startPoint; )
                    e = this.endPoint - this.startPoint, t = this.yLabelWidth, this.calculateYRange(e), this.buildYLabels(), t < this.yLabelWidth && (this.endPoint = i, this.calculateXLabelRotation())
            }, calculateXLabelRotation: function () {
                this.ctx.font = this.font;
                var t, i, e = this.ctx.measureText(this.xLabels[0]).width, s = this.ctx.measureText(this.xLabels[this.xLabels.length - 1]).width;
                if (this.xScalePaddingRight = s / 2 + 3, this.xScalePaddingLeft = e / 2 > this.yLabelWidth ? e / 2 : this.yLabelWidth, this.xLabelRotation = 0, this.display) {
                    var n, o = z(this.ctx, this.font, this.xLabels);
                    this.xLabelWidth = o;
                    for (var a = Math.floor(this.calculateX(1) - this.calculateX(0)) - 6; this.xLabelWidth > a && 0 === this.xLabelRotation || this.xLabelWidth > a && this.xLabelRotation <= 90 && this.xLabelRotation > 0; )
                        n = Math.cos(S(this.xLabelRotation)), t = n * e, i = n * s, t + this.fontSize / 2 > this.yLabelWidth && (this.xScalePaddingLeft = t + this.fontSize / 2), this.xScalePaddingRight = this.fontSize / 2, this.xLabelRotation++, this.xLabelWidth = n * o;
                    this.xLabelRotation > 0 && (this.endPoint -= Math.sin(S(this.xLabelRotation)) * o + 3)
                } else
                    this.xLabelWidth = 0, this.xScalePaddingRight = this.padding, this.xScalePaddingLeft = this.padding
            }, calculateYRange: c, drawingArea: function () {
                return this.startPoint - this.endPoint
            }, calculateY: function (t) {
                var i = this.drawingArea() / (this.min - this.max);
                return this.endPoint - i * (t - this.min)
            }, calculateX: function (t) {
                var i = (this.xLabelRotation > 0, this.width - (this.xScalePaddingLeft + this.xScalePaddingRight)), e = i / Math.max(this.valuesCount - (this.offsetGridLines ? 0 : 1), 1), s = e * t + this.xScalePaddingLeft;
                return this.offsetGridLines && (s += e / 2), Math.round(s)
            }, update: function (t) {
                s.extend(this, t), this.fit()
            }, draw: function () {
                var t = this.ctx, i = (this.endPoint - this.startPoint) / this.steps, e = Math.round(this.xScalePaddingLeft);
                this.display && (t.fillStyle = this.textColor, t.font = this.font, n(this.yLabels, function (n, o) {
                    var a = this.endPoint - i * o, h = Math.round(a), l = this.showHorizontalLines;
                    t.textAlign = "right", t.textBaseline = "middle", this.showLabels && t.fillText(n, e - 10, a), 0 !== o || l || (l = !0), l && t.beginPath(), o > 0 ? (t.lineWidth = this.gridLineWidth, t.strokeStyle = this.gridLineColor) : (t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor), h += s.aliasPixel(t.lineWidth), l && (t.moveTo(e, h), t.lineTo(this.width, h), t.stroke(), t.closePath()), t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor, t.beginPath(), t.moveTo(e - 5, h), t.lineTo(e, h), t.stroke(), t.closePath()
                }, this), n(this.xLabels, function (i, e) {
                    var s = this.calculateX(e) + x(this.lineWidth), n = this.calculateX(e - (this.offsetGridLines ? .5 : 0)) + x(this.lineWidth), o = this.xLabelRotation > 0, a = this.showVerticalLines;
                    0 !== e || a || (a = !0), a && t.beginPath(), e > 0 ? (t.lineWidth = this.gridLineWidth, t.strokeStyle = this.gridLineColor) : (t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor), a && (t.moveTo(n, this.endPoint), t.lineTo(n, this.startPoint - 3), t.stroke(), t.closePath()), t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor, t.beginPath(), t.moveTo(n, this.endPoint), t.lineTo(n, this.endPoint + 5), t.stroke(), t.closePath(), t.save(), t.translate(s, o ? this.endPoint + 12 : this.endPoint + 8), t.rotate(-1 * S(this.xLabelRotation)), t.font = this.font, t.textAlign = o ? "right" : "center", t.textBaseline = o ? "middle" : "top", t.fillText(i, 0, 0), t.restore()
                }, this))
            }}), e.RadialScale = e.Element.extend({initialize: function () {
                this.size = m([this.height, this.width]), this.drawingArea = this.display ? this.size / 2 - (this.fontSize / 2 + this.backdropPaddingY) : this.size / 2
            }, calculateCenterOffset: function (t) {
                var i = this.drawingArea / (this.max - this.min);
                return(t - this.min) * i
            }, update: function () {
                this.lineArc ? this.drawingArea = this.display ? this.size / 2 - (this.fontSize / 2 + this.backdropPaddingY) : this.size / 2 : this.setScaleSize(), this.buildYLabels()
            }, buildYLabels: function () {
                this.yLabels = [];
                for (var t = v(this.stepValue), i = 0; i <= this.steps; i++)
                    this.yLabels.push(C(this.templateString, {value: (this.min + i * this.stepValue).toFixed(t)}))
            }, getCircumference: function () {
                return 2 * Math.PI / this.valuesCount
            }, setScaleSize: function () {
                var t, i, e, s, n, o, a, h, l, r, c, u, d = m([this.height / 2 - this.pointLabelFontSize - 5, this.width / 2]), p = this.width, g = 0;
                for (this.ctx.font = W(this.pointLabelFontSize, this.pointLabelFontStyle, this.pointLabelFontFamily), i = 0; i < this.valuesCount; i++)
                    t = this.getPointPosition(i, d), e = this.ctx.measureText(C(this.templateString, {value: this.labels[i]})).width + 5, 0 === i || i === this.valuesCount / 2 ? (s = e / 2, t.x + s > p && (p = t.x + s, n = i), t.x - s < g && (g = t.x - s, a = i)) : i < this.valuesCount / 2 ? t.x + e > p && (p = t.x + e, n = i) : i > this.valuesCount / 2 && t.x - e < g && (g = t.x - e, a = i);
                l = g, r = Math.ceil(p - this.width), o = this.getIndexAngle(n), h = this.getIndexAngle(a), c = r / Math.sin(o + Math.PI / 2), u = l / Math.sin(h + Math.PI / 2), c = f(c) ? c : 0, u = f(u) ? u : 0, this.drawingArea = d - (u + c) / 2, this.setCenterPoint(u, c)
            }, setCenterPoint: function (t, i) {
                var e = this.width - i - this.drawingArea, s = t + this.drawingArea;
                this.xCenter = (s + e) / 2, this.yCenter = this.height / 2
            }, getIndexAngle: function (t) {
                var i = 2 * Math.PI / this.valuesCount;
                return t * i - Math.PI / 2
            }, getPointPosition: function (t, i) {
                var e = this.getIndexAngle(t);
                return{x: Math.cos(e) * i + this.xCenter, y: Math.sin(e) * i + this.yCenter}
            }, draw: function () {
                if (this.display) {
                    var t = this.ctx;
                    if (n(this.yLabels, function (i, e) {
                        if (e > 0) {
                            var s, n = e * (this.drawingArea / this.steps), o = this.yCenter - n;
                            if (this.lineWidth > 0)
                                if (t.strokeStyle = this.lineColor, t.lineWidth = this.lineWidth, this.lineArc)
                                    t.beginPath(), t.arc(this.xCenter, this.yCenter, n, 0, 2 * Math.PI), t.closePath(), t.stroke();
                                else {
                                    t.beginPath();
                                    for (var a = 0; a < this.valuesCount; a++)
                                        s = this.getPointPosition(a, this.calculateCenterOffset(this.min + e * this.stepValue)), 0 === a ? t.moveTo(s.x, s.y) : t.lineTo(s.x, s.y);
                                    t.closePath(), t.stroke()
                                }
                            if (this.showLabels) {
                                if (t.font = W(this.fontSize, this.fontStyle, this.fontFamily), this.showLabelBackdrop) {
                                    var h = t.measureText(i).width;
                                    t.fillStyle = this.backdropColor, t.fillRect(this.xCenter - h / 2 - this.backdropPaddingX, o - this.fontSize / 2 - this.backdropPaddingY, h + 2 * this.backdropPaddingX, this.fontSize + 2 * this.backdropPaddingY)
                                }
                                t.textAlign = "center", t.textBaseline = "middle", t.fillStyle = this.fontColor, t.fillText(i, this.xCenter, o)
                            }
                        }
                    }, this), !this.lineArc) {
                        t.lineWidth = this.angleLineWidth, t.strokeStyle = this.angleLineColor;
                        for (var i = this.valuesCount - 1; i >= 0; i--) {
                            var e = null, s = null;
                            if (this.angleLineWidth > 0 && (e = this.calculateCenterOffset(this.max), s = this.getPointPosition(i, e), t.beginPath(), t.moveTo(this.xCenter, this.yCenter), t.lineTo(s.x, s.y), t.stroke(), t.closePath()), this.backgroundColors && this.backgroundColors.length == this.valuesCount) {
                                null == e && (e = this.calculateCenterOffset(this.max)), null == s && (s = this.getPointPosition(i, e));
                                var o = this.getPointPosition(0 === i ? this.valuesCount - 1 : i - 1, e), a = this.getPointPosition(i === this.valuesCount - 1 ? 0 : i + 1, e), h = {x: (o.x + s.x) / 2, y: (o.y + s.y) / 2}, l = {x: (s.x + a.x) / 2, y: (s.y + a.y) / 2};
                                t.beginPath(), t.moveTo(this.xCenter, this.yCenter), t.lineTo(h.x, h.y), t.lineTo(s.x, s.y), t.lineTo(l.x, l.y), t.fillStyle = this.backgroundColors[i], t.fill(), t.closePath()
                            }
                            var r = this.getPointPosition(i, this.calculateCenterOffset(this.max) + 5);
                            t.font = W(this.pointLabelFontSize, this.pointLabelFontStyle, this.pointLabelFontFamily), t.fillStyle = this.pointLabelFontColor;
                            var c = this.labels.length, u = this.labels.length / 2, d = u / 2, p = d > i || i > c - d, f = i === d || i === c - d;
                            0 === i ? t.textAlign = "center" : i === u ? t.textAlign = "center" : u > i ? t.textAlign = "left" : t.textAlign = "right", f ? t.textBaseline = "middle" : p ? t.textBaseline = "bottom" : t.textBaseline = "top", t.fillText(this.labels[i], r.x, r.y)
                        }
                    }
                }
            }}), e.animationService = {frameDuration: 17, animations: [], dropFrames: 0, addAnimation: function (t, i) {
                for (var e = 0; e < this.animations.length; ++e)
                    if (this.animations[e].chartInstance === t)
                        return void(this.animations[e].animationObject = i);
                this.animations.push({chartInstance: t, animationObject: i}), 1 == this.animations.length && s.requestAnimFrame.call(window, this.digestWrapper)
            }, cancelAnimation: function (t) {
                var i = s.findNextWhere(this.animations, function (i) {
                    return i.chartInstance === t
                });
                i && this.animations.splice(i, 1)
            }, digestWrapper: function () {
                e.animationService.startDigest.call(e.animationService)
            }, startDigest: function () {
                var t = Date.now(), i = 0;
                this.dropFrames > 1 && (i = Math.floor(this.dropFrames), this.dropFrames -= i);
                for (var e = 0; e < this.animations.length; e++)
                    null === this.animations[e].animationObject.currentStep && (this.animations[e].animationObject.currentStep = 0), this.animations[e].animationObject.currentStep += 1 + i, this.animations[e].animationObject.currentStep > this.animations[e].animationObject.numSteps && (this.animations[e].animationObject.currentStep = this.animations[e].animationObject.numSteps), this.animations[e].animationObject.render(this.animations[e].chartInstance, this.animations[e].animationObject), this.animations[e].animationObject.currentStep == this.animations[e].animationObject.numSteps && (this.animations[e].animationObject.onAnimationComplete.call(this.animations[e].chartInstance), this.animations.splice(e, 1), e--);
                var n = Date.now(), o = n - t - this.frameDuration, a = o / this.frameDuration;
                a > 1 && (this.dropFrames += a), this.animations.length > 0 && s.requestAnimFrame.call(window, this.digestWrapper)
            }}, s.addEvent(window, "resize", function () {
            var t;
            return function () {
                clearTimeout(t), t = setTimeout(function () {
                    n(e.instances, function (t) {
                        t.options.responsive && t.resize(t.render, !0)
                    })
                }, 50)
            }
        }()), p ? define("Chart", [], function () {
            return e
        }) : "object" == typeof module && module.exports && (module.exports = e), t.Chart = e, e.noConflict = function () {
            return t.Chart = i, e
        }
    }).call(this), function () {
        "use strict";
        var t = this, i = t.Chart, e = i.helpers, s = {scaleBeginAtZero: !0, scaleShowGridLines: !0, scaleGridLineColor: "rgba(0,0,0,.05)", scaleGridLineWidth: 1, scaleShowHorizontalLines: !0, scaleShowVerticalLines: !0, barShowStroke: !0, barStrokeWidth: 2, barValueSpacing: 5, barDatasetSpacing: 1, legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"><%if(datasets[i].label){%><%=datasets[i].label%><%}%></span></li><%}%></ul>'};
        i.Type.extend({name: "Bar", defaults: s, initialize: function (t) {
                var s = this.options;
                this.ScaleClass = i.Scale.extend({offsetGridLines: !0, calculateBarX: function (t, i, e) {
                        var n = this.calculateBaseWidth(), o = this.calculateX(e) - n / 2, a = this.calculateBarWidth(t);
                        return o + a * i + i * s.barDatasetSpacing + a / 2
                    }, calculateBaseWidth: function () {
                        return this.calculateX(1) - this.calculateX(0) - 2 * s.barValueSpacing
                    }, calculateBarWidth: function (t) {
                        var i = this.calculateBaseWidth() - (t - 1) * s.barDatasetSpacing;
                        return i / t
                    }}), this.datasets = [], this.options.showTooltips && e.bindEvents(this, this.options.tooltipEvents, function (t) {
                    var i = "mouseout" !== t.type ? this.getBarsAtEvent(t) : [];
                    this.eachBars(function (t) {
                        t.restore(["fillColor", "strokeColor"])
                    }), e.each(i, function (t) {
                        t.fillColor = t.highlightFill, t.strokeColor = t.highlightStroke
                    }), this.showTooltip(i)
                }), this.BarClass = i.Rectangle.extend({strokeWidth: this.options.barStrokeWidth, showStroke: this.options.barShowStroke, ctx: this.chart.ctx}), e.each(t.datasets, function (i, s) {
                    var n = {label: i.label || null, fillColor: i.fillColor, strokeColor: i.strokeColor, bars: []};
                    this.datasets.push(n), e.each(i.data, function (e, s) {
                        n.bars.push(new this.BarClass({value: e, label: t.labels[s], datasetLabel: i.label, strokeColor: i.strokeColor, fillColor: i.fillColor, highlightFill: i.highlightFill || i.fillColor, highlightStroke: i.highlightStroke || i.strokeColor}))
                    }, this)
                }, this), this.buildScale(t.labels), this.BarClass.prototype.base = this.scale.endPoint, this.eachBars(function (t, i, s) {
                    e.extend(t, {width: this.scale.calculateBarWidth(this.datasets.length), x: this.scale.calculateBarX(this.datasets.length, s, i), y: this.scale.endPoint}), t.save()
                }, this), this.render()
            }, update: function () {
                this.scale.update(), e.each(this.activeElements, function (t) {
                    t.restore(["fillColor", "strokeColor"])
                }), this.eachBars(function (t) {
                    t.save()
                }), this.render()
            }, eachBars: function (t) {
                e.each(this.datasets, function (i, s) {
                    e.each(i.bars, t, this, s)
                }, this)
            }, getBarsAtEvent: function (t) {
                for (var i, s = [], n = e.getRelativePosition(t), o = function (t) {
                    s.push(t.bars[i])
                }, a = 0; a < this.datasets.length; a++)
                    for (i = 0; i < this.datasets[a].bars.length; i++)
                        if (this.datasets[a].bars[i].inRange(n.x, n.y))
                            return e.each(this.datasets, o), s;
                return s
            }, buildScale: function (t) {
                var i = this, s = function () {
                    var t = [];
                    return i.eachBars(function (i) {
                        t.push(i.value)
                    }), t
                }, n = {templateString: this.options.scaleLabel, height: this.chart.height, width: this.chart.width, ctx: this.chart.ctx, textColor: this.options.scaleFontColor, fontSize: this.options.scaleFontSize, fontStyle: this.options.scaleFontStyle, fontFamily: this.options.scaleFontFamily, valuesCount: t.length, beginAtZero: this.options.scaleBeginAtZero, integersOnly: this.options.scaleIntegersOnly, calculateYRange: function (t) {
                        var i = e.calculateScaleRange(s(), t, this.fontSize, this.beginAtZero, this.integersOnly);
                        e.extend(this, i)
                    }, xLabels: t, font: e.fontString(this.options.scaleFontSize, this.options.scaleFontStyle, this.options.scaleFontFamily), lineWidth: this.options.scaleLineWidth, lineColor: this.options.scaleLineColor, showHorizontalLines: this.options.scaleShowHorizontalLines, showVerticalLines: this.options.scaleShowVerticalLines, gridLineWidth: this.options.scaleShowGridLines ? this.options.scaleGridLineWidth : 0, gridLineColor: this.options.scaleShowGridLines ? this.options.scaleGridLineColor : "rgba(0,0,0,0)", padding: this.options.showScale ? 0 : this.options.barShowStroke ? this.options.barStrokeWidth : 0, showLabels: this.options.scaleShowLabels, display: this.options.showScale};
                this.options.scaleOverride && e.extend(n, {calculateYRange: e.noop, steps: this.options.scaleSteps, stepValue: this.options.scaleStepWidth, min: this.options.scaleStartValue, max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth}), this.scale = new this.ScaleClass(n)
            }, addData: function (t, i) {
                e.each(t, function (t, e) {
                    this.datasets[e].bars.push(new this.BarClass({value: t, label: i, datasetLabel: this.datasets[e].label, x: this.scale.calculateBarX(this.datasets.length, e, this.scale.valuesCount + 1), y: this.scale.endPoint, width: this.scale.calculateBarWidth(this.datasets.length), base: this.scale.endPoint, strokeColor: this.datasets[e].strokeColor, fillColor: this.datasets[e].fillColor}))
                }, this), this.scale.addXLabel(i), this.update()
            }, removeData: function () {
                this.scale.removeXLabel(), e.each(this.datasets, function (t) {
                    t.bars.shift()
                }, this), this.update()
            }, reflow: function () {
                e.extend(this.BarClass.prototype, {y: this.scale.endPoint, base: this.scale.endPoint});
                var t = e.extend({height: this.chart.height, width: this.chart.width});
                this.scale.update(t)
            }, draw: function (t) {
                var i = t || 1;
                this.clear();
                this.chart.ctx;
                this.scale.draw(i), e.each(this.datasets, function (t, s) {
                    e.each(t.bars, function (t, e) {
                        t.hasValue() && (t.base = this.scale.endPoint, t.transition({x: this.scale.calculateBarX(this.datasets.length, s, e), y: this.scale.calculateY(t.value), width: this.scale.calculateBarWidth(this.datasets.length)}, i).draw())
                    }, this)
                }, this)
            }})
    }.call(this), function () {
        "use strict";
        var t = this, i = t.Chart, e = i.helpers, s = {segmentShowStroke: !0, segmentStrokeColor: "#fff", segmentStrokeWidth: 2, percentageInnerCutout: 50, animationSteps: 100, animationEasing: "easeOutBounce", animateRotate: !0, animateScale: !1, legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"><%if(segments[i].label){%><%=segments[i].label%><%}%></span></li><%}%></ul>'};
        i.Type.extend({name: "Doughnut", defaults: s, initialize: function (t) {
                this.segments = [], this.outerRadius = (e.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2, this.SegmentArc = i.Arc.extend({ctx: this.chart.ctx, x: this.chart.width / 2, y: this.chart.height / 2}), this.options.showTooltips && e.bindEvents(this, this.options.tooltipEvents, function (t) {
                    var i = "mouseout" !== t.type ? this.getSegmentsAtEvent(t) : [];
                    e.each(this.segments, function (t) {
                        t.restore(["fillColor"])
                    }), e.each(i, function (t) {
                        t.fillColor = t.highlightColor
                    }), this.showTooltip(i)
                }), this.calculateTotal(t), e.each(t, function (i, e) {
                    i.color || (i.color = "hsl(" + 360 * e / t.length + ", 100%, 50%)"), this.addData(i, e, !0)
                }, this), this.render()
            }, getSegmentsAtEvent: function (t) {
                var i = [], s = e.getRelativePosition(t);
                return e.each(this.segments, function (t) {
                    t.inRange(s.x, s.y) && i.push(t)
                }, this), i
            }, addData: function (t, e, s) {
                var n = void 0 !== e ? e : this.segments.length;
                "undefined" == typeof t.color && (t.color = i.defaults.global.segmentColorDefault[n % i.defaults.global.segmentColorDefault.length], t.highlight = i.defaults.global.segmentHighlightColorDefaults[n % i.defaults.global.segmentHighlightColorDefaults.length]), this.segments.splice(n, 0, new this.SegmentArc({value: t.value, outerRadius: this.options.animateScale ? 0 : this.outerRadius, innerRadius: this.options.animateScale ? 0 : this.outerRadius / 100 * this.options.percentageInnerCutout, fillColor: t.color, highlightColor: t.highlight || t.color, showStroke: this.options.segmentShowStroke, strokeWidth: this.options.segmentStrokeWidth, strokeColor: this.options.segmentStrokeColor, startAngle: 1.5 * Math.PI, circumference: this.options.animateRotate ? 0 : this.calculateCircumference(t.value), label: t.label})), s || (this.reflow(), this.update())
            }, calculateCircumference: function (t) {
                return this.total > 0 ? 2 * Math.PI * (t / this.total) : 0
            }, calculateTotal: function (t) {
                this.total = 0, e.each(t, function (t) {
                    this.total += Math.abs(t.value)
                }, this)
            }, update: function () {
                this.calculateTotal(this.segments), e.each(this.activeElements, function (t) {
                    t.restore(["fillColor"])
                }), e.each(this.segments, function (t) {
                    t.save()
                }), this.render()
            }, removeData: function (t) {
                var i = e.isNumber(t) ? t : this.segments.length - 1;
                this.segments.splice(i, 1), this.reflow(), this.update()
            }, reflow: function () {
                e.extend(this.SegmentArc.prototype, {x: this.chart.width / 2, y: this.chart.height / 2}), this.outerRadius = (e.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2, e.each(this.segments, function (t) {
                    t.update({outerRadius: this.outerRadius, innerRadius: this.outerRadius / 100 * this.options.percentageInnerCutout})
                }, this)
            }, draw: function (t) {
                var i = t ? t : 1;
                this.clear(), e.each(this.segments, function (t, e) {
                    t.transition({circumference: this.calculateCircumference(t.value), outerRadius: this.outerRadius, innerRadius: this.outerRadius / 100 * this.options.percentageInnerCutout}, i), t.endAngle = t.startAngle + t.circumference, t.draw(), 0 === e && (t.startAngle = 1.5 * Math.PI), e < this.segments.length - 1 && (this.segments[e + 1].startAngle = t.endAngle)
                }, this)
            }}), i.types.Doughnut.extend({name: "Pie", defaults: e.merge(s, {percentageInnerCutout: 0})})
    }.call(this), function () {
        "use strict";
        var t = this, i = t.Chart, e = i.helpers, s = {scaleShowGridLines: !0, scaleGridLineColor: "rgba(0,0,0,.05)", scaleGridLineWidth: 1, scaleShowHorizontalLines: !0, scaleShowVerticalLines: !0, bezierCurve: !0, bezierCurveTension: .4, pointDot: !0, pointDotRadius: 4, pointDotStrokeWidth: 1, pointHitDetectionRadius: 20, datasetStroke: !0, datasetStrokeWidth: 2, datasetFill: !0, legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"><%if(datasets[i].label){%><%=datasets[i].label%><%}%></span></li><%}%></ul>', offsetGridLines: !1};
        i.Type.extend({name: "Line", defaults: s, initialize: function (t) {
                this.PointClass = i.Point.extend({offsetGridLines: this.options.offsetGridLines, strokeWidth: this.options.pointDotStrokeWidth, radius: this.options.pointDotRadius, display: this.options.pointDot, hitDetectionRadius: this.options.pointHitDetectionRadius, ctx: this.chart.ctx, inRange: function (t) {
                        return Math.pow(t - this.x, 2) < Math.pow(this.radius + this.hitDetectionRadius, 2)
                    }}), this.datasets = [], this.options.showTooltips && e.bindEvents(this, this.options.tooltipEvents, function (t) {
                    var i = "mouseout" !== t.type ? this.getPointsAtEvent(t) : [];
                    this.eachPoints(function (t) {
                        t.restore(["fillColor", "strokeColor"])
                    }), e.each(i, function (t) {
                        t.fillColor = t.highlightFill, t.strokeColor = t.highlightStroke
                    }), this.showTooltip(i)
                }), e.each(t.datasets, function (i) {
                    var s = {label: i.label || null, fillColor: i.fillColor, strokeColor: i.strokeColor, pointColor: i.pointColor, pointStrokeColor: i.pointStrokeColor, points: []};
                    this.datasets.push(s), e.each(i.data, function (e, n) {
                        s.points.push(new this.PointClass({value: e, label: t.labels[n], datasetLabel: i.label, strokeColor: i.pointStrokeColor, fillColor: i.pointColor, highlightFill: i.pointHighlightFill || i.pointColor, highlightStroke: i.pointHighlightStroke || i.pointStrokeColor}))
                    }, this), this.buildScale(t.labels), this.eachPoints(function (t, i) {
                        e.extend(t, {x: this.scale.calculateX(i), y: this.scale.endPoint}), t.save()
                    }, this)
                }, this), this.render()
            }, update: function () {
                this.scale.update(), e.each(this.activeElements, function (t) {
                    t.restore(["fillColor", "strokeColor"])
                }), this.eachPoints(function (t) {
                    t.save()
                }), this.render()
            }, eachPoints: function (t) {
                e.each(this.datasets, function (i) {
                    e.each(i.points, t, this)
                }, this)
            }, getPointsAtEvent: function (t) {
                var i = [], s = e.getRelativePosition(t);
                return e.each(this.datasets, function (t) {
                    e.each(t.points, function (t) {
                        t.inRange(s.x, s.y) && i.push(t)
                    })
                }, this), i
            }, buildScale: function (t) {
                var s = this, n = function () {
                    var t = [];
                    return s.eachPoints(function (i) {
                        t.push(i.value)
                    }), t
                }, o = {templateString: this.options.scaleLabel, height: this.chart.height, width: this.chart.width, ctx: this.chart.ctx, textColor: this.options.scaleFontColor, offsetGridLines: this.options.offsetGridLines, fontSize: this.options.scaleFontSize, fontStyle: this.options.scaleFontStyle, fontFamily: this.options.scaleFontFamily, valuesCount: t.length, beginAtZero: this.options.scaleBeginAtZero, integersOnly: this.options.scaleIntegersOnly, calculateYRange: function (t) {
                        var i = e.calculateScaleRange(n(), t, this.fontSize, this.beginAtZero, this.integersOnly);
                        e.extend(this, i)
                    }, xLabels: t, font: e.fontString(this.options.scaleFontSize, this.options.scaleFontStyle, this.options.scaleFontFamily), lineWidth: this.options.scaleLineWidth, lineColor: this.options.scaleLineColor, showHorizontalLines: this.options.scaleShowHorizontalLines, showVerticalLines: this.options.scaleShowVerticalLines, gridLineWidth: this.options.scaleShowGridLines ? this.options.scaleGridLineWidth : 0, gridLineColor: this.options.scaleShowGridLines ? this.options.scaleGridLineColor : "rgba(0,0,0,0)", padding: this.options.showScale ? 0 : this.options.pointDotRadius + this.options.pointDotStrokeWidth, showLabels: this.options.scaleShowLabels, display: this.options.showScale};
                this.options.scaleOverride && e.extend(o, {calculateYRange: e.noop, steps: this.options.scaleSteps, stepValue: this.options.scaleStepWidth, min: this.options.scaleStartValue, max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth}), this.scale = new i.Scale(o)
            }, addData: function (t, i) {
                e.each(t, function (t, e) {
                    this.datasets[e].points.push(new this.PointClass({value: t, label: i, datasetLabel: this.datasets[e].label, x: this.scale.calculateX(this.scale.valuesCount + 1), y: this.scale.endPoint, strokeColor: this.datasets[e].pointStrokeColor, fillColor: this.datasets[e].pointColor}))
                }, this), this.scale.addXLabel(i), this.update()
            }, removeData: function () {
                this.scale.removeXLabel(), e.each(this.datasets, function (t) {
                    t.points.shift()
                }, this), this.update()
            }, reflow: function () {
                var t = e.extend({height: this.chart.height, width: this.chart.width});
                this.scale.update(t)
            }, draw: function (t) {
                var i = t || 1;
                this.clear();
                var s = this.chart.ctx, n = function (t) {
                    return null !== t.value
                }, o = function (t, i, s) {
                    return e.findNextWhere(i, n, s) || t
                }, a = function (t, i, s) {
                    return e.findPreviousWhere(i, n, s) || t
                };
                this.scale && (this.scale.draw(i), e.each(this.datasets, function (t) {
                    var h = e.where(t.points, n);
                    e.each(t.points, function (t, e) {
                        t.hasValue() && t.transition({y: this.scale.calculateY(t.value), x: this.scale.calculateX(e)}, i)
                    }, this), this.options.bezierCurve && e.each(h, function (t, i) {
                        var s = i > 0 && i < h.length - 1 ? this.options.bezierCurveTension : 0;
                        t.controlPoints = e.splineCurve(a(t, h, i), t, o(t, h, i), s), t.controlPoints.outer.y > this.scale.endPoint ? t.controlPoints.outer.y = this.scale.endPoint : t.controlPoints.outer.y < this.scale.startPoint && (t.controlPoints.outer.y = this.scale.startPoint), t.controlPoints.inner.y > this.scale.endPoint ? t.controlPoints.inner.y = this.scale.endPoint : t.controlPoints.inner.y < this.scale.startPoint && (t.controlPoints.inner.y = this.scale.startPoint)
                    }, this), s.lineWidth = this.options.datasetStrokeWidth, s.strokeStyle = t.strokeColor, s.beginPath(), e.each(h, function (t, i) {
                        if (0 === i)
                            s.moveTo(t.x, t.y);
                        else if (this.options.bezierCurve) {
                            var e = a(t, h, i);
                            s.bezierCurveTo(e.controlPoints.outer.x, e.controlPoints.outer.y, t.controlPoints.inner.x, t.controlPoints.inner.y, t.x, t.y)
                        } else
                            s.lineTo(t.x, t.y)
                    }, this), this.options.datasetStroke && s.stroke(), this.options.datasetFill && h.length > 0 && (s.lineTo(h[h.length - 1].x, this.scale.endPoint), s.lineTo(h[0].x, this.scale.endPoint), s.fillStyle = t.fillColor, s.closePath(), s.fill()), e.each(h, function (t) {
                        t.draw()
                    })
                }, this))
            }})
    }.call(this), function () {
        "use strict";
        var t = this, i = t.Chart, e = i.helpers, s = {scaleShowLabelBackdrop: !0, scaleBackdropColor: "rgba(255,255,255,0.75)", scaleBeginAtZero: !0, scaleBackdropPaddingY: 2, scaleBackdropPaddingX: 2, scaleShowLine: !0, segmentShowStroke: !0, segmentStrokeColor: "#fff", segmentStrokeWidth: 2, animationSteps: 100, animationEasing: "easeOutBounce", animateRotate: !0, animateScale: !1, legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"><%if(segments[i].label){%><%=segments[i].label%><%}%></span></li><%}%></ul>'};
        i.Type.extend({name: "PolarArea", defaults: s, initialize: function (t) {
                this.segments = [], this.SegmentArc = i.Arc.extend({showStroke: this.options.segmentShowStroke, strokeWidth: this.options.segmentStrokeWidth, strokeColor: this.options.segmentStrokeColor, ctx: this.chart.ctx, innerRadius: 0, x: this.chart.width / 2, y: this.chart.height / 2}), this.scale = new i.RadialScale({display: this.options.showScale, fontStyle: this.options.scaleFontStyle, fontSize: this.options.scaleFontSize, fontFamily: this.options.scaleFontFamily, fontColor: this.options.scaleFontColor, showLabels: this.options.scaleShowLabels, showLabelBackdrop: this.options.scaleShowLabelBackdrop, backdropColor: this.options.scaleBackdropColor, backdropPaddingY: this.options.scaleBackdropPaddingY, backdropPaddingX: this.options.scaleBackdropPaddingX, lineWidth: this.options.scaleShowLine ? this.options.scaleLineWidth : 0, lineColor: this.options.scaleLineColor, lineArc: !0, width: this.chart.width, height: this.chart.height, xCenter: this.chart.width / 2, yCenter: this.chart.height / 2, ctx: this.chart.ctx, templateString: this.options.scaleLabel, valuesCount: t.length}), this.updateScaleRange(t), this.scale.update(), e.each(t, function (t, i) {
                    this.addData(t, i, !0)
                }, this), this.options.showTooltips && e.bindEvents(this, this.options.tooltipEvents, function (t) {
                    var i = "mouseout" !== t.type ? this.getSegmentsAtEvent(t) : [];
                    e.each(this.segments, function (t) {
                        t.restore(["fillColor"])
                    }), e.each(i, function (t) {
                        t.fillColor = t.highlightColor
                    }), this.showTooltip(i)
                }), this.render()
            }, getSegmentsAtEvent: function (t) {
                var i = [], s = e.getRelativePosition(t);
                return e.each(this.segments, function (t) {
                    t.inRange(s.x, s.y) && i.push(t)
                }, this), i
            }, addData: function (t, i, e) {
                var s = i || this.segments.length;
                this.segments.splice(s, 0, new this.SegmentArc({fillColor: t.color, highlightColor: t.highlight || t.color, label: t.label, value: t.value, outerRadius: this.options.animateScale ? 0 : this.scale.calculateCenterOffset(t.value), circumference: this.options.animateRotate ? 0 : this.scale.getCircumference(), startAngle: 1.5 * Math.PI})), e || (this.reflow(), this.update())
            }, removeData: function (t) {
                var i = e.isNumber(t) ? t : this.segments.length - 1;
                this.segments.splice(i, 1), this.reflow(), this.update()
            }, calculateTotal: function (t) {
                this.total = 0, e.each(t, function (t) {
                    this.total += t.value
                }, this), this.scale.valuesCount = this.segments.length
            }, updateScaleRange: function (t) {
                var i = [];
                e.each(t, function (t) {
                    i.push(t.value)
                });
                var s = this.options.scaleOverride ? {steps: this.options.scaleSteps, stepValue: this.options.scaleStepWidth, min: this.options.scaleStartValue, max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth} : e.calculateScaleRange(i, e.min([this.chart.width, this.chart.height]) / 2, this.options.scaleFontSize, this.options.scaleBeginAtZero, this.options.scaleIntegersOnly);
                e.extend(this.scale, s, {size: e.min([this.chart.width, this.chart.height]), xCenter: this.chart.width / 2, yCenter: this.chart.height / 2})
            }, update: function () {
                this.calculateTotal(this.segments), e.each(this.segments, function (t) {
                    t.save()
                }), this.reflow(), this.render()
            }, reflow: function () {
                e.extend(this.SegmentArc.prototype, {x: this.chart.width / 2, y: this.chart.height / 2}), this.updateScaleRange(this.segments), this.scale.update(), e.extend(this.scale, {xCenter: this.chart.width / 2, yCenter: this.chart.height / 2}), e.each(this.segments, function (t) {
                    t.update({outerRadius: this.scale.calculateCenterOffset(t.value)})
                }, this)
            }, draw: function (t) {
                var i = t || 1;
                this.clear(), e.each(this.segments, function (t, e) {
                    t.transition({circumference: this.scale.getCircumference(), outerRadius: this.scale.calculateCenterOffset(t.value)}, i), t.endAngle = t.startAngle + t.circumference, 0 === e && (t.startAngle = 1.5 * Math.PI), e < this.segments.length - 1 && (this.segments[e + 1].startAngle = t.endAngle), t.draw()
                }, this), this.scale.draw()
            }})
    }.call(this), function () {
        "use strict";
        var t = this, i = t.Chart, e = i.helpers;
        i.Type.extend({name: "Radar", defaults: {scaleShowLine: !0, angleShowLineOut: !0, scaleShowLabels: !1, scaleBeginAtZero: !0, angleLineColor: "rgba(0,0,0,.1)", angleLineWidth: 1, pointLabelFontFamily: "'Arial'", pointLabelFontStyle: "normal", pointLabelFontSize: 10, pointLabelFontColor: "#666", pointDot: !0, pointDotRadius: 3, pointDotStrokeWidth: 1, pointHitDetectionRadius: 20, datasetStroke: !0, datasetStrokeWidth: 2, datasetFill: !0, legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"><%if(datasets[i].label){%><%=datasets[i].label%><%}%></span></li><%}%></ul>'}, initialize: function (t) {
                this.PointClass = i.Point.extend({strokeWidth: this.options.pointDotStrokeWidth, radius: this.options.pointDotRadius, display: this.options.pointDot, hitDetectionRadius: this.options.pointHitDetectionRadius, ctx: this.chart.ctx}), this.datasets = [], this.buildScale(t), this.options.showTooltips && e.bindEvents(this, this.options.tooltipEvents, function (t) {
                    var i = "mouseout" !== t.type ? this.getPointsAtEvent(t) : [];
                    this.eachPoints(function (t) {
                        t.restore(["fillColor", "strokeColor"])
                    }), e.each(i, function (t) {
                        t.fillColor = t.highlightFill, t.strokeColor = t.highlightStroke
                    }), this.showTooltip(i)
                }), e.each(t.datasets, function (i) {
                    var s = {label: i.label || null, fillColor: i.fillColor, strokeColor: i.strokeColor, pointColor: i.pointColor, pointStrokeColor: i.pointStrokeColor, points: []};
                    this.datasets.push(s), e.each(i.data, function (e, n) {
                        var o;
                        this.scale.animation || (o = this.scale.getPointPosition(n, this.scale.calculateCenterOffset(e))), s.points.push(new this.PointClass({value: e, label: t.labels[n], datasetLabel: i.label, x: this.options.animation ? this.scale.xCenter : o.x, y: this.options.animation ? this.scale.yCenter : o.y, strokeColor: i.pointStrokeColor, fillColor: i.pointColor, highlightFill: i.pointHighlightFill || i.pointColor, highlightStroke: i.pointHighlightStroke || i.pointStrokeColor}))
                    }, this)
                }, this), this.render()
            }, eachPoints: function (t) {
                e.each(this.datasets, function (i) {
                    e.each(i.points, t, this)
                }, this)
            }, getPointsAtEvent: function (t) {
                var i = e.getRelativePosition(t), s = e.getAngleFromPoint({x: this.scale.xCenter, y: this.scale.yCenter}, i), n = 2 * Math.PI / this.scale.valuesCount, o = Math.round((s.angle - 1.5 * Math.PI) / n), a = [];
                return(o >= this.scale.valuesCount || 0 > o) && (o = 0), s.distance <= this.scale.drawingArea && e.each(this.datasets, function (t) {
                    a.push(t.points[o])
                }), a
            }, buildScale: function (t) {
                this.scale = new i.RadialScale({display: this.options.showScale, fontStyle: this.options.scaleFontStyle, fontSize: this.options.scaleFontSize, fontFamily: this.options.scaleFontFamily, fontColor: this.options.scaleFontColor, showLabels: this.options.scaleShowLabels, showLabelBackdrop: this.options.scaleShowLabelBackdrop, backdropColor: this.options.scaleBackdropColor, backgroundColors: this.options.scaleBackgroundColors, backdropPaddingY: this.options.scaleBackdropPaddingY, backdropPaddingX: this.options.scaleBackdropPaddingX, lineWidth: this.options.scaleShowLine ? this.options.scaleLineWidth : 0, lineColor: this.options.scaleLineColor, angleLineColor: this.options.angleLineColor, angleLineWidth: this.options.angleShowLineOut ? this.options.angleLineWidth : 0, pointLabelFontColor: this.options.pointLabelFontColor, pointLabelFontSize: this.options.pointLabelFontSize, pointLabelFontFamily: this.options.pointLabelFontFamily, pointLabelFontStyle: this.options.pointLabelFontStyle, height: this.chart.height, width: this.chart.width, xCenter: this.chart.width / 2, yCenter: this.chart.height / 2, ctx: this.chart.ctx, templateString: this.options.scaleLabel, labels: t.labels, valuesCount: t.datasets[0].data.length}), this.scale.setScaleSize(), this.updateScaleRange(t.datasets), this.scale.buildYLabels()
            }, updateScaleRange: function (t) {
                var i = function () {
                    var i = [];
                    return e.each(t, function (t) {
                        t.data ? i = i.concat(t.data) : e.each(t.points, function (t) {
                            i.push(t.value)
                        })
                    }), i
                }(), s = this.options.scaleOverride ? {steps: this.options.scaleSteps, stepValue: this.options.scaleStepWidth, min: this.options.scaleStartValue, max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth} : e.calculateScaleRange(i, e.min([this.chart.width, this.chart.height]) / 2, this.options.scaleFontSize, this.options.scaleBeginAtZero, this.options.scaleIntegersOnly);
                e.extend(this.scale, s)
            }, addData: function (t, i) {
                this.scale.valuesCount++, e.each(t, function (t, e) {
                    var s = this.scale.getPointPosition(this.scale.valuesCount, this.scale.calculateCenterOffset(t));
                    this.datasets[e].points.push(new this.PointClass({value: t, label: i, datasetLabel: this.datasets[e].label, x: s.x, y: s.y, strokeColor: this.datasets[e].pointStrokeColor, fillColor: this.datasets[e].pointColor}))
                }, this), this.scale.labels.push(i), this.reflow(), this.update()
            }, removeData: function () {
                this.scale.valuesCount--, this.scale.labels.shift(), e.each(this.datasets, function (t) {
                    t.points.shift()
                }, this), this.reflow(), this.update()
            }, update: function () {
                this.eachPoints(function (t) {
                    t.save()
                }), this.reflow(), this.render()
            }, reflow: function () {
                e.extend(this.scale, {width: this.chart.width, height: this.chart.height, size: e.min([this.chart.width, this.chart.height]), xCenter: this.chart.width / 2, yCenter: this.chart.height / 2}), this.updateScaleRange(this.datasets), this.scale.setScaleSize(), this.scale.buildYLabels()
            }, draw: function (t) {
                var i = t || 1, s = this.chart.ctx;
                this.clear(), this.scale.draw(), e.each(this.datasets, function (t) {
                    e.each(t.points, function (t, e) {
                        t.hasValue() && t.transition(this.scale.getPointPosition(e, this.scale.calculateCenterOffset(t.value)), i)
                    }, this), s.lineWidth = this.options.datasetStrokeWidth, s.strokeStyle = t.strokeColor, s.beginPath(), e.each(t.points, function (t, i) {
                        0 === i ? s.moveTo(t.x, t.y) : s.lineTo(t.x, t.y)
                    }, this), s.closePath(), s.stroke(), s.fillStyle = t.fillColor, this.options.datasetFill && s.fill(), e.each(t.points, function (t) {
                        t.hasValue() && t.draw()
                    })
                }, this)
            }})
    }.call(this);

    var Chartv1 = Chart.noConflict();
    Chart = Chartv2;

    Chartv1.types.Doughnut.extend({
        name: "DoughnutWithMiddleIcon",
        showTooltip: function () {
            this.chart.ctx.save();
            Chartv1.types.Doughnut.prototype.showTooltip.apply(this, arguments);
            this.chart.ctx.restore();
        },
        draw: function () {
            Chartv1.types.Doughnut.prototype.draw.apply(this, arguments);

            var width = this.chart.width,
                    height = this.chart.height;

            this.chart.ctx.fillStyle = this.options.middleIconColor;
            this.chart.ctx.font = "80px FontAwesome";
            this.chart.ctx.textAlign = "center";
            this.chart.ctx.textBaseline = "middle";

            var text = "",
                    textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
                    textY = height / 2;

            this.chart.ctx.fillText(this.options.middleIconName, textX, textY);
        }
    });

    /*!
     DataTables 1.10.11
     ©2008-2015 SpryMedia Ltd - datatables.net/license
     */
    (function (h) {
        "function" === typeof define && define.amd ? define(["jquery"], function (D) {
            return h(D, window, document)
        }) : "object" === typeof exports ? module.exports = function (D, I) {
            D || (D = window);
            I || (I = "undefined" !== typeof window ? require("jquery") : require("jquery")(D));
            return h(I, D, D.document)
        } : h(jQuery, window, document)
    })(function (h, D, I, k) {
        function Y(a) {
            var b, c, d = {};
            h.each(a, function (e) {
                if ((b = e.match(/^([^A-Z]+?)([A-Z])/)) && -1 !== "a aa ai ao as b fn i m o s ".indexOf(b[1] + " "))
                    c = e.replace(b[0], b[2].toLowerCase()),
                    d[c] = e, "o" === b[1] && Y(a[e])
            });
            a._hungarianMap = d
        }
        function K(a, b, c) {
            a._hungarianMap || Y(a);
            var d;
            h.each(b, function (e) {
                d = a._hungarianMap[e];
                if (d !== k && (c || b[d] === k))
                    "o" === d.charAt(0) ? (b[d] || (b[d] = {}), h.extend(!0, b[d], b[e]), K(a[d], b[d], c)) : b[d] = b[e]
            })
        }
        function Fa(a) {
            var b = m.defaults.oLanguage, c = a.sZeroRecords;
            !a.sEmptyTable && (c && "No data available in table" === b.sEmptyTable) && E(a, a, "sZeroRecords", "sEmptyTable");
            !a.sLoadingRecords && (c && "Loading..." === b.sLoadingRecords) && E(a, a, "sZeroRecords", "sLoadingRecords");
            a.sInfoThousands && (a.sThousands = a.sInfoThousands);
            (a = a.sDecimal) && db(a)
        }
        function eb(a) {
            A(a, "ordering", "bSort");
            A(a, "orderMulti", "bSortMulti");
            A(a, "orderClasses", "bSortClasses");
            A(a, "orderCellsTop", "bSortCellsTop");
            A(a, "order", "aaSorting");
            A(a, "orderFixed", "aaSortingFixed");
            A(a, "paging", "bPaginate");
            A(a, "pagingType", "sPaginationType");
            A(a, "pageLength", "iDisplayLength");
            A(a, "searching", "bFilter");
            "boolean" === typeof a.sScrollX && (a.sScrollX = a.sScrollX ? "100%" : "");
            "boolean" === typeof a.scrollX && (a.scrollX =
                    a.scrollX ? "100%" : "");
            if (a = a.aoSearchCols)
                for (var b = 0, c = a.length; b < c; b++)
                    a[b] && K(m.models.oSearch, a[b])
        }
        function fb(a) {
            A(a, "orderable", "bSortable");
            A(a, "orderData", "aDataSort");
            A(a, "orderSequence", "asSorting");
            A(a, "orderDataType", "sortDataType");
            var b = a.aDataSort;
            b && !h.isArray(b) && (a.aDataSort = [b])
        }
        function gb(a) {
            if (!m.__browser) {
                var b = {};
                m.__browser = b;
                var c = h("<div/>").css({position: "fixed", top: 0, left: 0, height: 1, width: 1, overflow: "hidden"}).append(h("<div/>").css({position: "absolute", top: 1, left: 1,
                    width: 100, overflow: "scroll"}).append(h("<div/>").css({width: "100%", height: 10}))).appendTo("body"), d = c.children(), e = d.children();
                b.barWidth = d[0].offsetWidth - d[0].clientWidth;
                b.bScrollOversize = 100 === e[0].offsetWidth && 100 !== d[0].clientWidth;
                b.bScrollbarLeft = 1 !== Math.round(e.offset().left);
                b.bBounding = c[0].getBoundingClientRect().width ? !0 : !1;
                c.remove()
            }
            h.extend(a.oBrowser, m.__browser);
            a.oScroll.iBarWidth = m.__browser.barWidth
        }
        function hb(a, b, c, d, e, f) {
            var g, j = !1;
            c !== k && (g = c, j = !0);
            for (; d !== e; )
                a.hasOwnProperty(d) &&
                        (g = j ? b(g, a[d], d, a) : a[d], j = !0, d += f);
            return g
        }
        function Ga(a, b) {
            var c = m.defaults.column, d = a.aoColumns.length, c = h.extend({}, m.models.oColumn, c, {nTh: b ? b : I.createElement("th"), sTitle: c.sTitle ? c.sTitle : b ? b.innerHTML : "", aDataSort: c.aDataSort ? c.aDataSort : [d], mData: c.mData ? c.mData : d, idx: d});
            a.aoColumns.push(c);
            c = a.aoPreSearchCols;
            c[d] = h.extend({}, m.models.oSearch, c[d]);
            ja(a, d, h(b).data())
        }
        function ja(a, b, c) {
            var b = a.aoColumns[b], d = a.oClasses, e = h(b.nTh);
            if (!b.sWidthOrig) {
                b.sWidthOrig = e.attr("width") || null;
                var f =
                        (e.attr("style") || "").match(/width:\s*(\d+[pxem%]+)/);
                f && (b.sWidthOrig = f[1])
            }
            c !== k && null !== c && (fb(c), K(m.defaults.column, c), c.mDataProp !== k && !c.mData && (c.mData = c.mDataProp), c.sType && (b._sManualType = c.sType), c.className && !c.sClass && (c.sClass = c.className), h.extend(b, c), E(b, c, "sWidth", "sWidthOrig"), c.iDataSort !== k && (b.aDataSort = [c.iDataSort]), E(b, c, "aDataSort"));
            var g = b.mData, j = Q(g), i = b.mRender ? Q(b.mRender) : null, c = function (a) {
                return"string" === typeof a && -1 !== a.indexOf("@")
            };
            b._bAttrSrc = h.isPlainObject(g) &&
                    (c(g.sort) || c(g.type) || c(g.filter));
            b._setter = null;
            b.fnGetData = function (a, b, c) {
                var d = j(a, b, k, c);
                return i && b ? i(d, b, a, c) : d
            };
            b.fnSetData = function (a, b, c) {
                return R(g)(a, b, c)
            };
            "number" !== typeof g && (a._rowReadObject = !0);
            a.oFeatures.bSort || (b.bSortable = !1, e.addClass(d.sSortableNone));
            a = -1 !== h.inArray("asc", b.asSorting);
            c = -1 !== h.inArray("desc", b.asSorting);
            !b.bSortable || !a && !c ? (b.sSortingClass = d.sSortableNone, b.sSortingClassJUI = "") : a && !c ? (b.sSortingClass = d.sSortableAsc, b.sSortingClassJUI = d.sSortJUIAscAllowed) :
                    !a && c ? (b.sSortingClass = d.sSortableDesc, b.sSortingClassJUI = d.sSortJUIDescAllowed) : (b.sSortingClass = d.sSortable, b.sSortingClassJUI = d.sSortJUI)
        }
        function U(a) {
            if (!1 !== a.oFeatures.bAutoWidth) {
                var b = a.aoColumns;
                Ha(a);
                for (var c = 0, d = b.length; c < d; c++)
                    b[c].nTh.style.width = b[c].sWidth
            }
            b = a.oScroll;
            ("" !== b.sY || "" !== b.sX) && ka(a);
            u(a, null, "column-sizing", [a])
        }
        function Z(a, b) {
            var c = la(a, "bVisible");
            return"number" === typeof c[b] ? c[b] : null
        }
        function $(a, b) {
            var c = la(a, "bVisible"), c = h.inArray(b, c);
            return-1 !== c ? c : null
        }
        function aa(a) {
            return h(F(a.aoColumns, "nTh")).filter(":visible").length
        }
        function la(a, b) {
            var c = [];
            h.map(a.aoColumns, function (a, e) {
                a[b] && c.push(e)
            });
            return c
        }
        function Ia(a) {
            var b = a.aoColumns, c = a.aoData, d = m.ext.type.detect, e, f, g, j, i, h, l, q, t;
            e = 0;
            for (f = b.length; e < f; e++)
                if (l = b[e], t = [], !l.sType && l._sManualType)
                    l.sType = l._sManualType;
                else if (!l.sType) {
                    g = 0;
                    for (j = d.length; g < j; g++) {
                        i = 0;
                        for (h = c.length; i < h; i++) {
                            t[i] === k && (t[i] = B(a, i, e, "type"));
                            q = d[g](t[i], a);
                            if (!q && g !== d.length - 1)
                                break;
                            if ("html" === q)
                                break
                        }
                        if (q) {
                            l.sType =
                                    q;
                            break
                        }
                    }
                    l.sType || (l.sType = "string")
                }
        }
        function ib(a, b, c, d) {
            var e, f, g, j, i, n, l = a.aoColumns;
            if (b)
                for (e = b.length - 1; 0 <= e; e--) {
                    n = b[e];
                    var q = n.targets !== k ? n.targets : n.aTargets;
                    h.isArray(q) || (q = [q]);
                    f = 0;
                    for (g = q.length; f < g; f++)
                        if ("number" === typeof q[f] && 0 <= q[f]) {
                            for (; l.length <= q[f]; )
                                Ga(a);
                            d(q[f], n)
                        } else if ("number" === typeof q[f] && 0 > q[f])
                            d(l.length + q[f], n);
                        else if ("string" === typeof q[f]) {
                            j = 0;
                            for (i = l.length; j < i; j++)
                                ("_all" == q[f] || h(l[j].nTh).hasClass(q[f])) && d(j, n)
                        }
                }
            if (c) {
                e = 0;
                for (a = c.length; e < a; e++)
                    d(e, c[e])
            }
        }
        function N(a, b, c, d) {
            var e = a.aoData.length, f = h.extend(!0, {}, m.models.oRow, {src: c ? "dom" : "data", idx: e});
            f._aData = b;
            a.aoData.push(f);
            for (var g = a.aoColumns, j = 0, i = g.length; j < i; j++)
                g[j].sType = null;
            a.aiDisplayMaster.push(e);
            b = a.rowIdFn(b);
            b !== k && (a.aIds[b] = f);
            (c || !a.oFeatures.bDeferRender) && Ja(a, e, c, d);
            return e
        }
        function ma(a, b) {
            var c;
            b instanceof h || (b = h(b));
            return b.map(function (b, e) {
                c = Ka(a, e);
                return N(a, c.data, e, c.cells)
            })
        }
        function B(a, b, c, d) {
            var e = a.iDraw, f = a.aoColumns[c], g = a.aoData[b]._aData, j = f.sDefaultContent,
                    i = f.fnGetData(g, d, {settings: a, row: b, col: c});
            if (i === k)
                return a.iDrawError != e && null === j && (L(a, 0, "Requested unknown parameter " + ("function" == typeof f.mData ? "{function}" : "'" + f.mData + "'") + " for row " + b + ", column " + c, 4), a.iDrawError = e), j;
            if ((i === g || null === i) && null !== j && d !== k)
                i = j;
            else if ("function" === typeof i)
                return i.call(g);
            return null === i && "display" == d ? "" : i
        }
        function jb(a, b, c, d) {
            a.aoColumns[c].fnSetData(a.aoData[b]._aData, d, {settings: a, row: b, col: c})
        }
        function La(a) {
            return h.map(a.match(/(\\.|[^\.])+/g) ||
                    [""], function (a) {
                return a.replace(/\\./g, ".")
            })
        }
        function Q(a) {
            if (h.isPlainObject(a)) {
                var b = {};
                h.each(a, function (a, c) {
                    c && (b[a] = Q(c))
                });
                return function (a, c, f, g) {
                    var j = b[c] || b._;
                    return j !== k ? j(a, c, f, g) : a
                }
            }
            if (null === a)
                return function (a) {
                    return a
                };
            if ("function" === typeof a)
                return function (b, c, f, g) {
                    return a(b, c, f, g)
                };
            if ("string" === typeof a && (-1 !== a.indexOf(".") || -1 !== a.indexOf("[") || -1 !== a.indexOf("("))) {
                var c = function (a, b, f) {
                    var g, j;
                    if ("" !== f) {
                        j = La(f);
                        for (var i = 0, n = j.length; i < n; i++) {
                            f = j[i].match(ba);
                            g =
                            j[i].match(V);
                            if (f) {
                                j[i] = j[i].replace(ba, "");
                                "" !== j[i] && (a = a[j[i]]);
                                g = [];
                                j.splice(0, i + 1);
                                j = j.join(".");
                                if (h.isArray(a)) {
                                    i = 0;
                                    for (n = a.length; i < n; i++)
                                        g.push(c(a[i], b, j))
                                }
                                a = f[0].substring(1, f[0].length - 1);
                                a = "" === a ? g : g.join(a);
                                break
                            } else if (g) {
                                j[i] = j[i].replace(V, "");
                                a = a[j[i]]();
                                continue
                            }
                            if (null === a || a[j[i]] === k)
                                return k;
                            a = a[j[i]]
                        }
                    }
                    return a
                };
                return function (b, e) {
                    return c(b, e, a)
                }
            }
            return function (b) {
                return b[a]
            }
        }
        function R(a) {
            if (h.isPlainObject(a))
                return R(a._);
            if (null === a)
                return function () {};
            if ("function" ===
                    typeof a)
                return function (b, d, e) {
                    a(b, "set", d, e)
                };
            if ("string" === typeof a && (-1 !== a.indexOf(".") || -1 !== a.indexOf("[") || -1 !== a.indexOf("("))) {
                var b = function (a, d, e) {
                    var e = La(e), f;
                    f = e[e.length - 1];
                    for (var g, j, i = 0, n = e.length - 1; i < n; i++) {
                        g = e[i].match(ba);
                        j = e[i].match(V);
                        if (g) {
                            e[i] = e[i].replace(ba, "");
                            a[e[i]] = [];
                            f = e.slice();
                            f.splice(0, i + 1);
                            g = f.join(".");
                            if (h.isArray(d)) {
                                j = 0;
                                for (n = d.length; j < n; j++)
                                    f = {}, b(f, d[j], g), a[e[i]].push(f)
                            } else
                                a[e[i]] = d;
                            return
                        }
                        j && (e[i] = e[i].replace(V, ""), a = a[e[i]](d));
                        if (null === a[e[i]] ||
                        a[e[i]] === k)
                            a[e[i]] = {};
                        a = a[e[i]]
                    }
                    if (f.match(V))
                        a[f.replace(V, "")](d);
                    else
                        a[f.replace(ba, "")] = d
                };
                return function (c, d) {
                    return b(c, d, a)
                }
            }
            return function (b, d) {
                b[a] = d
            }
        }
        function Ma(a) {
            return F(a.aoData, "_aData")
        }
        function na(a) {
            a.aoData.length = 0;
            a.aiDisplayMaster.length = 0;
            a.aiDisplay.length = 0;
            a.aIds = {}
        }
        function oa(a, b, c) {
            for (var d = -1, e = 0, f = a.length; e < f; e++)
                a[e] == b ? d = e : a[e] > b && a[e]--;
            -1 != d && c === k && a.splice(d, 1)
        }
        function ca(a, b, c, d) {
            var e = a.aoData[b], f, g = function (c, d) {
                for (; c.childNodes.length; )
                    c.removeChild(c.firstChild);
                c.innerHTML = B(a, b, d, "display")
            };
            if ("dom" === c || (!c || "auto" === c) && "dom" === e.src)
                e._aData = Ka(a, e, d, d === k ? k : e._aData).data;
            else {
                var j = e.anCells;
                if (j)
                    if (d !== k)
                        g(j[d], d);
                    else {
                        c = 0;
                        for (f = j.length; c < f; c++)
                            g(j[c], c)
                    }
            }
            e._aSortData = null;
            e._aFilterData = null;
            g = a.aoColumns;
            if (d !== k)
                g[d].sType = null;
            else {
                c = 0;
                for (f = g.length; c < f; c++)
                    g[c].sType = null;
                Na(a, e)
            }
        }
        function Ka(a, b, c, d) {
            var e = [], f = b.firstChild, g, j, i = 0, n, l = a.aoColumns, q = a._rowReadObject, d = d !== k ? d : q ? {} : [], t = function (a, b) {
                if ("string" === typeof a) {
                    var c = a.indexOf("@");
                    -1 !== c && (c = a.substring(c + 1), R(a)(d, b.getAttribute(c)))
                }
            }, S = function (a) {
                if (c === k || c === i)
                    j = l[i], n = h.trim(a.innerHTML), j && j._bAttrSrc ? (R(j.mData._)(d, n), t(j.mData.sort, a), t(j.mData.type, a), t(j.mData.filter, a)) : q ? (j._setter || (j._setter = R(j.mData)), j._setter(d, n)) : d[i] = n;
                i++
            };
            if (f)
                for (; f; ) {
                    g = f.nodeName.toUpperCase();
                    if ("TD" == g || "TH" == g)
                        S(f), e.push(f);
                    f = f.nextSibling
                }
            else {
                e = b.anCells;
                f = 0;
                for (g = e.length; f < g; f++)
                    S(e[f])
            }
            if (b = b.firstChild ? b : b.nTr)
                (b = b.getAttribute("id")) && R(a.rowId)(d, b);
            return{data: d, cells: e}
        }
        function Ja(a, b, c, d) {
            var e = a.aoData[b], f = e._aData, g = [], j, i, n, l, q;
            if (null === e.nTr) {
                j = c || I.createElement("tr");
                e.nTr = j;
                e.anCells = g;
                j._DT_RowIndex = b;
                Na(a, e);
                l = 0;
                for (q = a.aoColumns.length; l < q; l++) {
                    n = a.aoColumns[l];
                    i = c ? d[l] : I.createElement(n.sCellType);
                    i._DT_CellIndex = {row: b, column: l};
                    g.push(i);
                    if ((!c || n.mRender || n.mData !== l) && (!h.isPlainObject(n.mData) || n.mData._ !== l + ".display"))
                        i.innerHTML = B(a, b, l, "display");
                    n.sClass && (i.className += " " + n.sClass);
                    n.bVisible && !c ? j.appendChild(i) : !n.bVisible && c && i.parentNode.removeChild(i);
                    n.fnCreatedCell && n.fnCreatedCell.call(a.oInstance, i, B(a, b, l), f, b, l)
                }
                u(a, "aoRowCreatedCallback", null, [j, f, b])
            }
            e.nTr.setAttribute("role", "row")
        }
        function Na(a, b) {
            var c = b.nTr, d = b._aData;
            if (c) {
                var e = a.rowIdFn(d);
                e && (c.id = e);
                d.DT_RowClass && (e = d.DT_RowClass.split(" "), b.__rowc = b.__rowc ? pa(b.__rowc.concat(e)) : e, h(c).removeClass(b.__rowc.join(" ")).addClass(d.DT_RowClass));
                d.DT_RowAttr && h(c).attr(d.DT_RowAttr);
                d.DT_RowData && h(c).data(d.DT_RowData)
            }
        }
        function kb(a) {
            var b, c, d, e, f, g = a.nTHead, j = a.nTFoot, i = 0 ===
                    h("th, td", g).length, n = a.oClasses, l = a.aoColumns;
            i && (e = h("<tr/>").appendTo(g));
            b = 0;
            for (c = l.length; b < c; b++)
                f = l[b], d = h(f.nTh).addClass(f.sClass), i && d.appendTo(e), a.oFeatures.bSort && (d.addClass(f.sSortingClass), !1 !== f.bSortable && (d.attr("tabindex", a.iTabIndex).attr("aria-controls", a.sTableId), Oa(a, f.nTh, b))), f.sTitle != d[0].innerHTML && d.html(f.sTitle), Pa(a, "header")(a, d, f, n);
            i && da(a.aoHeader, g);
            h(g).find(">tr").attr("role", "row");
            h(g).find(">tr>th, >tr>td").addClass(n.sHeaderTH);
            h(j).find(">tr>th, >tr>td").addClass(n.sFooterTH);
            if (null !== j) {
                a = a.aoFooter[0];
                b = 0;
                for (c = a.length; b < c; b++)
                    f = l[b], f.nTf = a[b].cell, f.sClass && h(f.nTf).addClass(f.sClass)
            }
        }
        function ea(a, b, c) {
            var d, e, f, g = [], j = [], i = a.aoColumns.length, n;
            if (b) {
                c === k && (c = !1);
                d = 0;
                for (e = b.length; d < e; d++) {
                    g[d] = b[d].slice();
                    g[d].nTr = b[d].nTr;
                    for (f = i - 1; 0 <= f; f--)
                        !a.aoColumns[f].bVisible && !c && g[d].splice(f, 1);
                    j.push([])
                }
                d = 0;
                for (e = g.length; d < e; d++) {
                    if (a = g[d].nTr)
                        for (; f = a.firstChild; )
                            a.removeChild(f);
                    f = 0;
                    for (b = g[d].length; f < b; f++)
                        if (n = i = 1, j[d][f] === k) {
                            a.appendChild(g[d][f].cell);
                            for (j[d][f] = 1; g[d + i] !== k && g[d][f].cell == g[d + i][f].cell; )
                                j[d + i][f] = 1, i++;
                            for (; g[d][f + n] !== k && g[d][f].cell == g[d][f + n].cell; ) {
                                for (c = 0; c < i; c++)
                                    j[d + c][f + n] = 1;
                                n++
                            }
                            h(g[d][f].cell).attr("rowspan", i).attr("colspan", n)
                        }
                }
            }
        }
        function O(a) {
            var b = u(a, "aoPreDrawCallback", "preDraw", [a]);
            if (-1 !== h.inArray(!1, b))
                C(a, !1);
            else {
                var b = [], c = 0, d = a.asStripeClasses, e = d.length, f = a.oLanguage, g = a.iInitDisplayStart, j = "ssp" == y(a), i = a.aiDisplay;
                a.bDrawing = !0;
                g !== k && -1 !== g && (a._iDisplayStart = j ? g : g >= a.fnRecordsDisplay() ? 0 : g, a.iInitDisplayStart =
                        -1);
                var g = a._iDisplayStart, n = a.fnDisplayEnd();
                if (a.bDeferLoading)
                    a.bDeferLoading = !1, a.iDraw++, C(a, !1);
                else if (j) {
                    if (!a.bDestroying && !lb(a))
                        return
                } else
                    a.iDraw++;
                if (0 !== i.length) {
                    f = j ? a.aoData.length : n;
                    for (j = j ? 0 : g; j < f; j++) {
                        var l = i[j], q = a.aoData[l];
                        null === q.nTr && Ja(a, l);
                        l = q.nTr;
                        if (0 !== e) {
                            var t = d[c % e];
                            q._sRowStripe != t && (h(l).removeClass(q._sRowStripe).addClass(t), q._sRowStripe = t)
                        }
                        u(a, "aoRowCallback", null, [l, q._aData, c, j]);
                        b.push(l);
                        c++
                    }
                } else
                    c = f.sZeroRecords, 1 == a.iDraw && "ajax" == y(a) ? c = f.sLoadingRecords :
                            f.sEmptyTable && 0 === a.fnRecordsTotal() && (c = f.sEmptyTable), b[0] = h("<tr/>", {"class": e ? d[0] : ""}).append(h("<td />", {valign: "top", colSpan: aa(a), "class": a.oClasses.sRowEmpty}).html(c))[0];
                u(a, "aoHeaderCallback", "header", [h(a.nTHead).children("tr")[0], Ma(a), g, n, i]);
                u(a, "aoFooterCallback", "footer", [h(a.nTFoot).children("tr")[0], Ma(a), g, n, i]);
                d = h(a.nTBody);
                d.children().detach();
                d.append(h(b));
                u(a, "aoDrawCallback", "draw", [a]);
                a.bSorted = !1;
                a.bFiltered = !1;
                a.bDrawing = !1
            }
        }
        function T(a, b) {
            var c = a.oFeatures, d = c.bFilter;
            c.bSort && mb(a);
            d ? fa(a, a.oPreviousSearch) : a.aiDisplay = a.aiDisplayMaster.slice();
            !0 !== b && (a._iDisplayStart = 0);
            a._drawHold = b;
            O(a);
            a._drawHold = !1
        }
        function nb(a) {
            var b = a.oClasses, c = h(a.nTable), c = h("<div/>").insertBefore(c), d = a.oFeatures, e = h("<div/>", {id: a.sTableId + "_wrapper", "class": b.sWrapper + (a.nTFoot ? "" : " " + b.sNoFooter)});
            a.nHolding = c[0];
            a.nTableWrapper = e[0];
            a.nTableReinsertBefore = a.nTable.nextSibling;
            for (var f = a.sDom.split(""), g, j, i, n, l, q, t = 0; t < f.length; t++) {
                g = null;
                j = f[t];
                if ("<" == j) {
                    i = h("<div/>")[0];
                    n = f[t + 1];
                    if ("'" == n || '"' == n) {
                        l = "";
                        for (q = 2; f[t + q] != n; )
                            l += f[t + q], q++;
                        "H" == l ? l = b.sJUIHeader : "F" == l && (l = b.sJUIFooter);
                        -1 != l.indexOf(".") ? (n = l.split("."), i.id = n[0].substr(1, n[0].length - 1), i.className = n[1]) : "#" == l.charAt(0) ? i.id = l.substr(1, l.length - 1) : i.className = l;
                        t += q
                    }
                    e.append(i);
                    e = h(i)
                } else if (">" == j)
                    e = e.parent();
                else if ("l" == j && d.bPaginate && d.bLengthChange)
                    g = ob(a);
                else if ("f" == j && d.bFilter)
                    g = pb(a);
                else if ("r" == j && d.bProcessing)
                    g = qb(a);
                else if ("t" == j)
                    g = rb(a);
                else if ("i" == j && d.bInfo)
                    g = sb(a);
                else if ("p" ==
                        j && d.bPaginate)
                    g = tb(a);
                else if (0 !== m.ext.feature.length) {
                    i = m.ext.feature;
                    q = 0;
                    for (n = i.length; q < n; q++)
                        if (j == i[q].cFeature) {
                            g = i[q].fnInit(a);
                            break
                        }
                }
                g && (i = a.aanFeatures, i[j] || (i[j] = []), i[j].push(g), e.append(g))
            }
            c.replaceWith(e);
            a.nHolding = null
        }
        function da(a, b) {
            var c = h(b).children("tr"), d, e, f, g, j, i, n, l, q, t;
            a.splice(0, a.length);
            f = 0;
            for (i = c.length; f < i; f++)
                a.push([]);
            f = 0;
            for (i = c.length; f < i; f++) {
                d = c[f];
                for (e = d.firstChild; e; ) {
                    if ("TD" == e.nodeName.toUpperCase() || "TH" == e.nodeName.toUpperCase()) {
                        l = 1 * e.getAttribute("colspan");
                        q = 1 * e.getAttribute("rowspan");
                        l = !l || 0 === l || 1 === l ? 1 : l;
                        q = !q || 0 === q || 1 === q ? 1 : q;
                        g = 0;
                        for (j = a[f]; j[g]; )
                            g++;
                        n = g;
                        t = 1 === l ? !0 : !1;
                        for (j = 0; j < l; j++)
                            for (g = 0; g < q; g++)
                                a[f + g][n + j] = {cell: e, unique: t}, a[f + g].nTr = d
                    }
                    e = e.nextSibling
                }
            }
        }
        function qa(a, b, c) {
            var d = [];
            c || (c = a.aoHeader, b && (c = [], da(c, b)));
            for (var b = 0, e = c.length; b < e; b++)
                for (var f = 0, g = c[b].length; f < g; f++)
                    if (c[b][f].unique && (!d[f] || !a.bSortCellsTop))
                        d[f] = c[b][f].cell;
            return d
        }
        function ra(a, b, c) {
            u(a, "aoServerParams", "serverParams", [b]);
            if (b && h.isArray(b)) {
                var d = {},
                        e = /(.*?)\[\]$/;
                h.each(b, function (a, b) {
                    var c = b.name.match(e);
                    c ? (c = c[0], d[c] || (d[c] = []), d[c].push(b.value)) : d[b.name] = b.value
                });
                b = d
            }
            var f, g = a.ajax, j = a.oInstance, i = function (b) {
                u(a, null, "xhr", [a, b, a.jqXHR]);
                c(b)
            };
            if (h.isPlainObject(g) && g.data) {
                f = g.data;
                var n = h.isFunction(f) ? f(b, a) : f, b = h.isFunction(f) && n ? n : h.extend(!0, b, n);
                delete g.data
            }
            n = {data: b, success: function (b) {
                    var c = b.error || b.sError;
                    c && L(a, 0, c);
                    a.json = b;
                    i(b)
                }, dataType: "json", cache: !1, type: a.sServerMethod, error: function (b, c) {
                    var d = u(a, null, "xhr",
                            [a, null, a.jqXHR]);
                    -1 === h.inArray(!0, d) && ("parsererror" == c ? L(a, 0, "Invalid JSON response", 1) : 4 === b.readyState && L(a, 0, "Ajax error", 7));
                    C(a, !1)
                }};
            a.oAjaxData = b;
            u(a, null, "preXhr", [a, b]);
            a.fnServerData ? a.fnServerData.call(j, a.sAjaxSource, h.map(b, function (a, b) {
                return{name: b, value: a}
            }), i, a) : a.sAjaxSource || "string" === typeof g ? a.jqXHR = h.ajax(h.extend(n, {url: g || a.sAjaxSource})) : h.isFunction(g) ? a.jqXHR = g.call(j, b, i, a) : (a.jqXHR = h.ajax(h.extend(n, g)), g.data = f)
        }
        function lb(a) {
            return a.bAjaxDataGet ? (a.iDraw++, C(a,
                    !0), ra(a, ub(a), function (b) {
                vb(a, b)
            }), !1) : !0
        }
        function ub(a) {
            var b = a.aoColumns, c = b.length, d = a.oFeatures, e = a.oPreviousSearch, f = a.aoPreSearchCols, g, j = [], i, n, l, q = W(a);
            g = a._iDisplayStart;
            i = !1 !== d.bPaginate ? a._iDisplayLength : -1;
            var k = function (a, b) {
                j.push({name: a, value: b})
            };
            k("sEcho", a.iDraw);
            k("iColumns", c);
            k("sColumns", F(b, "sName").join(","));
            k("iDisplayStart", g);
            k("iDisplayLength", i);
            var S = {draw: a.iDraw, columns: [], order: [], start: g, length: i, search: {value: e.sSearch, regex: e.bRegex}};
            for (g = 0; g < c; g++)
                n = b[g],
                        l = f[g], i = "function" == typeof n.mData ? "function" : n.mData, S.columns.push({data: i, name: n.sName, searchable: n.bSearchable, orderable: n.bSortable, search: {value: l.sSearch, regex: l.bRegex}}), k("mDataProp_" + g, i), d.bFilter && (k("sSearch_" + g, l.sSearch), k("bRegex_" + g, l.bRegex), k("bSearchable_" + g, n.bSearchable)), d.bSort && k("bSortable_" + g, n.bSortable);
            d.bFilter && (k("sSearch", e.sSearch), k("bRegex", e.bRegex));
            d.bSort && (h.each(q, function (a, b) {
                S.order.push({column: b.col, dir: b.dir});
                k("iSortCol_" + a, b.col);
                k("sSortDir_" +
                        a, b.dir)
            }), k("iSortingCols", q.length));
            b = m.ext.legacy.ajax;
            return null === b ? a.sAjaxSource ? j : S : b ? j : S
        }
        function vb(a, b) {
            var c = sa(a, b), d = b.sEcho !== k ? b.sEcho : b.draw, e = b.iTotalRecords !== k ? b.iTotalRecords : b.recordsTotal, f = b.iTotalDisplayRecords !== k ? b.iTotalDisplayRecords : b.recordsFiltered;
            if (d) {
                if (1 * d < a.iDraw)
                    return;
                a.iDraw = 1 * d
            }
            na(a);
            a._iRecordsTotal = parseInt(e, 10);
            a._iRecordsDisplay = parseInt(f, 10);
            d = 0;
            for (e = c.length; d < e; d++)
                N(a, c[d]);
            a.aiDisplay = a.aiDisplayMaster.slice();
            a.bAjaxDataGet = !1;
            O(a);
            a._bInitComplete ||
                    ta(a, b);
            a.bAjaxDataGet = !0;
            C(a, !1)
        }
        function sa(a, b) {
            var c = h.isPlainObject(a.ajax) && a.ajax.dataSrc !== k ? a.ajax.dataSrc : a.sAjaxDataProp;
            return"data" === c ? b.aaData || b[c] : "" !== c ? Q(c)(b) : b
        }
        function pb(a) {
            var b = a.oClasses, c = a.sTableId, d = a.oLanguage, e = a.oPreviousSearch, f = a.aanFeatures, g = '<input type="search" class="' + b.sFilterInput + '"/>', j = d.sSearch, j = j.match(/_INPUT_/) ? j.replace("_INPUT_", g) : j + g, b = h("<div/>", {id: !f.f ? c + "_filter" : null, "class": b.sFilter}).append(h("<label/>").append(j)), f = function () {
                var b = !this.value ?
                        "" : this.value;
                b != e.sSearch && (fa(a, {sSearch: b, bRegex: e.bRegex, bSmart: e.bSmart, bCaseInsensitive: e.bCaseInsensitive}), a._iDisplayStart = 0, O(a))
            }, g = null !== a.searchDelay ? a.searchDelay : "ssp" === y(a) ? 400 : 0, i = h("input", b).val(e.sSearch).attr("placeholder", d.sSearchPlaceholder).bind("keyup.DT search.DT input.DT paste.DT cut.DT", g ? ua(f, g) : f).bind("keypress.DT", function (a) {
                if (13 == a.keyCode)
                    return!1
            }).attr("aria-controls", c);
            h(a.nTable).on("search.dt.DT", function (b, c) {
                if (a === c)
                    try {
                        i[0] !== I.activeElement && i.val(e.sSearch)
                    } catch (d) {
                    }
            });
            return b[0]
        }
        function fa(a, b, c) {
            var d = a.oPreviousSearch, e = a.aoPreSearchCols, f = function (a) {
                d.sSearch = a.sSearch;
                d.bRegex = a.bRegex;
                d.bSmart = a.bSmart;
                d.bCaseInsensitive = a.bCaseInsensitive
            };
            Ia(a);
            if ("ssp" != y(a)) {
                wb(a, b.sSearch, c, b.bEscapeRegex !== k ? !b.bEscapeRegex : b.bRegex, b.bSmart, b.bCaseInsensitive);
                f(b);
                for (b = 0; b < e.length; b++)
                    xb(a, e[b].sSearch, b, e[b].bEscapeRegex !== k ? !e[b].bEscapeRegex : e[b].bRegex, e[b].bSmart, e[b].bCaseInsensitive);
                yb(a)
            } else
                f(b);
            a.bFiltered = !0;
            u(a, null, "search", [a])
        }
        function yb(a) {
            for (var b =
                    m.ext.search, c = a.aiDisplay, d, e, f = 0, g = b.length; f < g; f++) {
                for (var j = [], i = 0, n = c.length; i < n; i++)
                    e = c[i], d = a.aoData[e], b[f](a, d._aFilterData, e, d._aData, i) && j.push(e);
                c.length = 0;
                h.merge(c, j)
            }
        }
        function xb(a, b, c, d, e, f) {
            if ("" !== b)
                for (var g = a.aiDisplay, d = Qa(b, d, e, f), e = g.length - 1; 0 <= e; e--)
                    b = a.aoData[g[e]]._aFilterData[c], d.test(b) || g.splice(e, 1)
        }
        function wb(a, b, c, d, e, f) {
            var d = Qa(b, d, e, f), e = a.oPreviousSearch.sSearch, f = a.aiDisplayMaster, g;
            0 !== m.ext.search.length && (c = !0);
            g = zb(a);
            if (0 >= b.length)
                a.aiDisplay = f.slice();
            else {
                if (g || c || e.length > b.length || 0 !== b.indexOf(e) || a.bSorted)
                    a.aiDisplay = f.slice();
                b = a.aiDisplay;
                for (c = b.length - 1; 0 <= c; c--)
                    d.test(a.aoData[b[c]]._sFilterRow) || b.splice(c, 1)
            }
        }
        function Qa(a, b, c, d) {
            a = b ? a : va(a);
            c && (a = "^(?=.*?" + h.map(a.match(/"[^"]+"|[^ ]+/g) || [""], function (a) {
                if ('"' === a.charAt(0))
                    var b = a.match(/^"(.*)"$/), a = b ? b[1] : a;
                return a.replace('"', "")
            }).join(")(?=.*?") + ").*$");
            return RegExp(a, d ? "i" : "")
        }
        function va(a) {
            return a.replace(Zb, "\\$1")
        }
        function zb(a) {
            var b = a.aoColumns, c, d, e, f, g, j, i, h, l =
                    m.ext.type.search;
            c = !1;
            d = 0;
            for (f = a.aoData.length; d < f; d++)
                if (h = a.aoData[d], !h._aFilterData) {
                    j = [];
                    e = 0;
                    for (g = b.length; e < g; e++)
                        c = b[e], c.bSearchable ? (i = B(a, d, e, "filter"), l[c.sType] && (i = l[c.sType](i)), null === i && (i = ""), "string" !== typeof i && i.toString && (i = i.toString())) : i = "", i.indexOf && -1 !== i.indexOf("&") && (wa.innerHTML = i, i = $b ? wa.textContent : wa.innerText), i.replace && (i = i.replace(/[\r\n]/g, "")), j.push(i);
                    h._aFilterData = j;
                    h._sFilterRow = j.join("  ");
                    c = !0
                }
            return c
        }
        function Ab(a) {
            return{search: a.sSearch, smart: a.bSmart,
                regex: a.bRegex, caseInsensitive: a.bCaseInsensitive}
        }
        function Bb(a) {
            return{sSearch: a.search, bSmart: a.smart, bRegex: a.regex, bCaseInsensitive: a.caseInsensitive}
        }
        function sb(a) {
            var b = a.sTableId, c = a.aanFeatures.i, d = h("<div/>", {"class": a.oClasses.sInfo, id: !c ? b + "_info" : null});
            c || (a.aoDrawCallback.push({fn: Cb, sName: "information"}), d.attr("role", "status").attr("aria-live", "polite"), h(a.nTable).attr("aria-describedby", b + "_info"));
            return d[0]
        }
        function Cb(a) {
            var b = a.aanFeatures.i;
            if (0 !== b.length) {
                var c = a.oLanguage,
                        d = a._iDisplayStart + 1, e = a.fnDisplayEnd(), f = a.fnRecordsTotal(), g = a.fnRecordsDisplay(), j = g ? c.sInfo : c.sInfoEmpty;
                g !== f && (j += " " + c.sInfoFiltered);
                j += c.sInfoPostFix;
                j = Db(a, j);
                c = c.fnInfoCallback;
                null !== c && (j = c.call(a.oInstance, a, d, e, f, g, j));
                h(b).html(j)
            }
        }
        function Db(a, b) {
            var c = a.fnFormatNumber, d = a._iDisplayStart + 1, e = a._iDisplayLength, f = a.fnRecordsDisplay(), g = -1 === e;
            return b.replace(/_START_/g, c.call(a, d)).replace(/_END_/g, c.call(a, a.fnDisplayEnd())).replace(/_MAX_/g, c.call(a, a.fnRecordsTotal())).replace(/_TOTAL_/g,
                    c.call(a, f)).replace(/_PAGE_/g, c.call(a, g ? 1 : Math.ceil(d / e))).replace(/_PAGES_/g, c.call(a, g ? 1 : Math.ceil(f / e)))
        }
        function ga(a) {
            var b, c, d = a.iInitDisplayStart, e = a.aoColumns, f;
            c = a.oFeatures;
            var g = a.bDeferLoading;
            if (a.bInitialised) {
                nb(a);
                kb(a);
                ea(a, a.aoHeader);
                ea(a, a.aoFooter);
                C(a, !0);
                c.bAutoWidth && Ha(a);
                b = 0;
                for (c = e.length; b < c; b++)
                    f = e[b], f.sWidth && (f.nTh.style.width = x(f.sWidth));
                u(a, null, "preInit", [a]);
                T(a);
                e = y(a);
                if ("ssp" != e || g)
                    "ajax" == e ? ra(a, [], function (c) {
                        var f = sa(a, c);
                        for (b = 0; b < f.length; b++)
                            N(a, f[b]);
                        a.iInitDisplayStart = d;
                        T(a);
                        C(a, !1);
                        ta(a, c)
                    }, a) : (C(a, !1), ta(a))
            } else
                setTimeout(function () {
                    ga(a)
                }, 200)
        }
        function ta(a, b) {
            a._bInitComplete = !0;
            (b || a.oInit.aaData) && U(a);
            u(a, null, "plugin-init", [a, b]);
            u(a, "aoInitComplete", "init", [a, b])
        }
        function Ra(a, b) {
            var c = parseInt(b, 10);
            a._iDisplayLength = c;
            Sa(a);
            u(a, null, "length", [a, c])
        }
        function ob(a) {
            for (var b = a.oClasses, c = a.sTableId, d = a.aLengthMenu, e = h.isArray(d[0]), f = e ? d[0] : d, d = e ? d[1] : d, e = h("<select/>", {name: c + "_length", "aria-controls": c, "class": b.sLengthSelect}),
                    g = 0, j = f.length; g < j; g++)
                e[0][g] = new Option(d[g], f[g]);
            var i = h("<div><label/></div>").addClass(b.sLength);
            a.aanFeatures.l || (i[0].id = c + "_length");
            i.children().append(a.oLanguage.sLengthMenu.replace("_MENU_", e[0].outerHTML));
            h("select", i).val(a._iDisplayLength).bind("change.DT", function () {
                Ra(a, h(this).val());
                O(a)
            });
            h(a.nTable).bind("length.dt.DT", function (b, c, d) {
                a === c && h("select", i).val(d)
            });
            return i[0]
        }
        function tb(a) {
            var b = a.sPaginationType, c = m.ext.pager[b], d = "function" === typeof c, e = function (a) {
                O(a)
            },
                    b = h("<div/>").addClass(a.oClasses.sPaging + b)[0], f = a.aanFeatures;
            d || c.fnInit(a, b, e);
            f.p || (b.id = a.sTableId + "_paginate", a.aoDrawCallback.push({fn: function (a) {
                    if (d) {
                        var b = a._iDisplayStart, i = a._iDisplayLength, h = a.fnRecordsDisplay(), l = -1 === i, b = l ? 0 : Math.ceil(b / i), i = l ? 1 : Math.ceil(h / i), h = c(b, i), k, l = 0;
                        for (k = f.p.length; l < k; l++)
                            Pa(a, "pageButton")(a, f.p[l], l, h, b, i)
                    } else
                        c.fnUpdate(a, e)
                }, sName: "pagination"}));
            return b
        }
        function Ta(a, b, c) {
            var d = a._iDisplayStart, e = a._iDisplayLength, f = a.fnRecordsDisplay();
            0 === f || -1 ===
                    e ? d = 0 : "number" === typeof b ? (d = b * e, d > f && (d = 0)) : "first" == b ? d = 0 : "previous" == b ? (d = 0 <= e ? d - e : 0, 0 > d && (d = 0)) : "next" == b ? d + e < f && (d += e) : "last" == b ? d = Math.floor((f - 1) / e) * e : L(a, 0, "Unknown paging action: " + b, 5);
            b = a._iDisplayStart !== d;
            a._iDisplayStart = d;
            b && (u(a, null, "page", [a]), c && O(a));
            return b
        }
        function qb(a) {
            return h("<div/>", {id: !a.aanFeatures.r ? a.sTableId + "_processing" : null, "class": a.oClasses.sProcessing}).html(a.oLanguage.sProcessing).insertBefore(a.nTable)[0]
        }
        function C(a, b) {
            a.oFeatures.bProcessing && h(a.aanFeatures.r).css("display",
                    b ? "block" : "none");
            u(a, null, "processing", [a, b])
        }
        function rb(a) {
            var b = h(a.nTable);
            b.attr("role", "grid");
            var c = a.oScroll;
            if ("" === c.sX && "" === c.sY)
                return a.nTable;
            var d = c.sX, e = c.sY, f = a.oClasses, g = b.children("caption"), j = g.length ? g[0]._captionSide : null, i = h(b[0].cloneNode(!1)), n = h(b[0].cloneNode(!1)), l = b.children("tfoot");
            l.length || (l = null);
            i = h("<div/>", {"class": f.sScrollWrapper}).append(h("<div/>", {"class": f.sScrollHead}).css({overflow: "hidden", position: "relative", border: 0, width: d ? !d ? null : x(d) : "100%"}).append(h("<div/>",
                    {"class": f.sScrollHeadInner}).css({"box-sizing": "content-box", width: c.sXInner || "100%"}).append(i.removeAttr("id").css("margin-left", 0).append("top" === j ? g : null).append(b.children("thead"))))).append(h("<div/>", {"class": f.sScrollBody}).css({position: "relative", overflow: "auto", width: !d ? null : x(d)}).append(b));
            l && i.append(h("<div/>", {"class": f.sScrollFoot}).css({overflow: "hidden", border: 0, width: d ? !d ? null : x(d) : "100%"}).append(h("<div/>", {"class": f.sScrollFootInner}).append(n.removeAttr("id").css("margin-left",
                    0).append("bottom" === j ? g : null).append(b.children("tfoot")))));
            var b = i.children(), k = b[0], f = b[1], t = l ? b[2] : null;
            if (d)
                h(f).on("scroll.DT", function () {
                    var a = this.scrollLeft;
                    k.scrollLeft = a;
                    l && (t.scrollLeft = a)
                });
            h(f).css(e && c.bCollapse ? "max-height" : "height", e);
            a.nScrollHead = k;
            a.nScrollBody = f;
            a.nScrollFoot = t;
            a.aoDrawCallback.push({fn: ka, sName: "scrolling"});
            return i[0]
        }
        function ka(a) {
            var b = a.oScroll, c = b.sX, d = b.sXInner, e = b.sY, b = b.iBarWidth, f = h(a.nScrollHead), g = f[0].style, j = f.children("div"), i = j[0].style, n = j.children("table"),
                    j = a.nScrollBody, l = h(j), q = j.style, t = h(a.nScrollFoot).children("div"), m = t.children("table"), o = h(a.nTHead), G = h(a.nTable), p = G[0], r = p.style, u = a.nTFoot ? h(a.nTFoot) : null, Eb = a.oBrowser, Ua = Eb.bScrollOversize, s = F(a.aoColumns, "nTh"), P, v, w, y, z = [], A = [], B = [], C = [], D, E = function (a) {
                a = a.style;
                a.paddingTop = "0";
                a.paddingBottom = "0";
                a.borderTopWidth = "0";
                a.borderBottomWidth = "0";
                a.height = 0
            };
            v = j.scrollHeight > j.clientHeight;
            if (a.scrollBarVis !== v && a.scrollBarVis !== k)
                a.scrollBarVis = v, U(a);
            else {
                a.scrollBarVis = v;
                G.children("thead, tfoot").remove();
                u && (w = u.clone().prependTo(G), P = u.find("tr"), w = w.find("tr"));
                y = o.clone().prependTo(G);
                o = o.find("tr");
                v = y.find("tr");
                y.find("th, td").removeAttr("tabindex");
                c || (q.width = "100%", f[0].style.width = "100%");
                h.each(qa(a, y), function (b, c) {
                    D = Z(a, b);
                    c.style.width = a.aoColumns[D].sWidth
                });
                u && J(function (a) {
                    a.style.width = ""
                }, w);
                f = G.outerWidth();
                if ("" === c) {
                    r.width = "100%";
                    if (Ua && (G.find("tbody").height() > j.offsetHeight || "scroll" == l.css("overflow-y")))
                        r.width = x(G.outerWidth() - b);
                    f = G.outerWidth()
                } else
                    "" !== d && (r.width =
                            x(d), f = G.outerWidth());
                J(E, v);
                J(function (a) {
                    B.push(a.innerHTML);
                    z.push(x(h(a).css("width")))
                }, v);
                J(function (a, b) {
                    if (h.inArray(a, s) !== -1)
                        a.style.width = z[b]
                }, o);
                h(v).height(0);
                u && (J(E, w), J(function (a) {
                    C.push(a.innerHTML);
                    A.push(x(h(a).css("width")))
                }, w), J(function (a, b) {
                    a.style.width = A[b]
                }, P), h(w).height(0));
                J(function (a, b) {
                    a.innerHTML = '<div class="dataTables_sizing" style="height:0;overflow:hidden;">' + B[b] + "</div>";
                    a.style.width = z[b]
                }, v);
                u && J(function (a, b) {
                    a.innerHTML = '<div class="dataTables_sizing" style="height:0;overflow:hidden;">' +
                    C[b] + "</div>";
                    a.style.width = A[b]
                }, w);
                if (G.outerWidth() < f) {
                    P = j.scrollHeight > j.offsetHeight || "scroll" == l.css("overflow-y") ? f + b : f;
                    if (Ua && (j.scrollHeight > j.offsetHeight || "scroll" == l.css("overflow-y")))
                        r.width = x(P - b);
                    ("" === c || "" !== d) && L(a, 1, "Possible column misalignment", 6)
                } else
                    P = "100%";
                q.width = x(P);
                g.width = x(P);
                u && (a.nScrollFoot.style.width = x(P));
                !e && Ua && (q.height = x(p.offsetHeight + b));
                c = G.outerWidth();
                n[0].style.width = x(c);
                i.width = x(c);
                d = G.height() > j.clientHeight || "scroll" == l.css("overflow-y");
                e = "padding" +
                        (Eb.bScrollbarLeft ? "Left" : "Right");
                i[e] = d ? b + "px" : "0px";
                u && (m[0].style.width = x(c), t[0].style.width = x(c), t[0].style[e] = d ? b + "px" : "0px");
                G.children("colgroup").insertBefore(G.children("thead"));
                l.scroll();
                if ((a.bSorted || a.bFiltered) && !a._drawHold)
                    j.scrollTop = 0
            }
        }
        function J(a, b, c) {
            for (var d = 0, e = 0, f = b.length, g, j; e < f; ) {
                g = b[e].firstChild;
                for (j = c?c[e].firstChild:null; g; )
                    1 === g.nodeType && (c ? a(g, j, d) : a(g, d), d++), g = g.nextSibling, j = c ? j.nextSibling : null;
                e++
            }
        }
        function Ha(a) {
            var b = a.nTable, c = a.aoColumns, d = a.oScroll,
                    e = d.sY, f = d.sX, g = d.sXInner, j = c.length, i = la(a, "bVisible"), n = h("th", a.nTHead), l = b.getAttribute("width"), k = b.parentNode, t = !1, m, o, p = a.oBrowser, d = p.bScrollOversize;
            (m = b.style.width) && -1 !== m.indexOf("%") && (l = m);
            for (m = 0; m < i.length; m++)
                o = c[i[m]], null !== o.sWidth && (o.sWidth = Fb(o.sWidthOrig, k), t = !0);
            if (d || !t && !f && !e && j == aa(a) && j == n.length)
                for (m = 0; m < j; m++)
                    i = Z(a, m), null !== i && (c[i].sWidth = x(n.eq(m).width()));
            else {
                j = h(b).clone().css("visibility", "hidden").removeAttr("id");
                j.find("tbody tr").remove();
                var r = h("<tr/>").appendTo(j.find("tbody"));
                j.find("thead, tfoot").remove();
                j.append(h(a.nTHead).clone()).append(h(a.nTFoot).clone());
                j.find("tfoot th, tfoot td").css("width", "");
                n = qa(a, j.find("thead")[0]);
                for (m = 0; m < i.length; m++)
                    o = c[i[m]], n[m].style.width = null !== o.sWidthOrig && "" !== o.sWidthOrig ? x(o.sWidthOrig) : "", o.sWidthOrig && f && h(n[m]).append(h("<div/>").css({width: o.sWidthOrig, margin: 0, padding: 0, border: 0, height: 1}));
                if (a.aoData.length)
                    for (m = 0; m < i.length; m++)
                        t = i[m], o = c[t], h(Gb(a, t)).clone(!1).append(o.sContentPadding).appendTo(r);
                h("[name]",
                        j).removeAttr("name");
                o = h("<div/>").css(f || e ? {position: "absolute", top: 0, left: 0, height: 1, right: 0, overflow: "hidden"} : {}).append(j).appendTo(k);
                f && g ? j.width(g) : f ? (j.css("width", "auto"), j.removeAttr("width"), j.width() < k.clientWidth && l && j.width(k.clientWidth)) : e ? j.width(k.clientWidth) : l && j.width(l);
                for (m = e = 0; m < i.length; m++)
                    k = h(n[m]), g = k.outerWidth() - k.width(), k = p.bBounding ? Math.ceil(n[m].getBoundingClientRect().width) : k.outerWidth(), e += k, c[i[m]].sWidth = x(k - g);
                b.style.width = x(e);
                o.remove()
            }
            l && (b.style.width =
                    x(l));
            if ((l || f) && !a._reszEvt)
                b = function () {
                    h(D).bind("resize.DT-" + a.sInstance, ua(function () {
                        U(a)
                    }))
                }, d ? setTimeout(b, 1E3) : b(), a._reszEvt = !0
        }
        function ua(a, b) {
            var c = b !== k ? b : 200, d, e;
            return function () {
                var b = this, g = +new Date, j = arguments;
                d && g < d + c ? (clearTimeout(e), e = setTimeout(function () {
                    d = k;
                    a.apply(b, j)
                }, c)) : (d = g, a.apply(b, j))
            }
        }
        function Fb(a, b) {
            if (!a)
                return 0;
            var c = h("<div/>").css("width", x(a)).appendTo(b || I.body), d = c[0].offsetWidth;
            c.remove();
            return d
        }
        function Gb(a, b) {
            var c = Hb(a, b);
            if (0 > c)
                return null;
            var d =
                    a.aoData[c];
            return!d.nTr ? h("<td/>").html(B(a, c, b, "display"))[0] : d.anCells[b]
        }
        function Hb(a, b) {
            for (var c, d = -1, e = -1, f = 0, g = a.aoData.length; f < g; f++)
                c = B(a, f, b, "display") + "", c = c.replace(ac, ""), c = c.replace(/&nbsp;/g, " "), c.length > d && (d = c.length, e = f);
            return e
        }
        function x(a) {
            return null === a ? "0px" : "number" == typeof a ? 0 > a ? "0px" : a + "px" : a.match(/\d$/) ? a + "px" : a
        }
        function W(a) {
            var b, c, d = [], e = a.aoColumns, f, g, j, i;
            b = a.aaSortingFixed;
            c = h.isPlainObject(b);
            var n = [];
            f = function (a) {
                a.length && !h.isArray(a[0]) ? n.push(a) : h.merge(n,
                        a)
            };
            h.isArray(b) && f(b);
            c && b.pre && f(b.pre);
            f(a.aaSorting);
            c && b.post && f(b.post);
            for (a = 0; a < n.length; a++) {
                i = n[a][0];
                f = e[i].aDataSort;
                b = 0;
                for (c = f.length; b < c; b++)
                    g = f[b], j = e[g].sType || "string", n[a]._idx === k && (n[a]._idx = h.inArray(n[a][1], e[g].asSorting)), d.push({src: i, col: g, dir: n[a][1], index: n[a]._idx, type: j, formatter: m.ext.type.order[j + "-pre"]})
            }
            return d
        }
        function mb(a) {
            var b, c, d = [], e = m.ext.type.order, f = a.aoData, g = 0, j, i = a.aiDisplayMaster, h;
            Ia(a);
            h = W(a);
            b = 0;
            for (c = h.length; b < c; b++)
                j = h[b], j.formatter && g++, Ib(a,
                        j.col);
            if ("ssp" != y(a) && 0 !== h.length) {
                b = 0;
                for (c = i.length; b < c; b++)
                    d[i[b]] = b;
                g === h.length ? i.sort(function (a, b) {
                    var c, e, g, j, i = h.length, k = f[a]._aSortData, m = f[b]._aSortData;
                    for (g = 0; g < i; g++)
                        if (j = h[g], c = k[j.col], e = m[j.col], c = c < e ? -1 : c > e ? 1 : 0, 0 !== c)
                            return"asc" === j.dir ? c : -c;
                    c = d[a];
                    e = d[b];
                    return c < e ? -1 : c > e ? 1 : 0
                }) : i.sort(function (a, b) {
                    var c, g, j, i, k = h.length, m = f[a]._aSortData, p = f[b]._aSortData;
                    for (j = 0; j < k; j++)
                        if (i = h[j], c = m[i.col], g = p[i.col], i = e[i.type + "-" + i.dir] || e["string-" + i.dir], c = i(c, g), 0 !== c)
                            return c;
                    c = d[a];
                    g = d[b];
                    return c < g ? -1 : c > g ? 1 : 0
                })
            }
            a.bSorted = !0
        }
        function Jb(a) {
            for (var b, c, d = a.aoColumns, e = W(a), a = a.oLanguage.oAria, f = 0, g = d.length; f < g; f++) {
                c = d[f];
                var j = c.asSorting;
                b = c.sTitle.replace(/<.*?>/g, "");
                var i = c.nTh;
                i.removeAttribute("aria-sort");
                c.bSortable && (0 < e.length && e[0].col == f ? (i.setAttribute("aria-sort", "asc" == e[0].dir ? "ascending" : "descending"), c = j[e[0].index + 1] || j[0]) : c = j[0], b += "asc" === c ? a.sSortAscending : a.sSortDescending);
                i.setAttribute("aria-label", b)
            }
        }
        function Va(a, b, c, d) {
            var e = a.aaSorting, f = a.aoColumns[b].asSorting,
                    g = function (a, b) {
                        var c = a._idx;
                        c === k && (c = h.inArray(a[1], f));
                        return c + 1 < f.length ? c + 1 : b ? null : 0
                    };
            "number" === typeof e[0] && (e = a.aaSorting = [e]);
            c && a.oFeatures.bSortMulti ? (c = h.inArray(b, F(e, "0")), -1 !== c ? (b = g(e[c], !0), null === b && 1 === e.length && (b = 0), null === b ? e.splice(c, 1) : (e[c][1] = f[b], e[c]._idx = b)) : (e.push([b, f[0], 0]), e[e.length - 1]._idx = 0)) : e.length && e[0][0] == b ? (b = g(e[0]), e.length = 1, e[0][1] = f[b], e[0]._idx = b) : (e.length = 0, e.push([b, f[0]]), e[0]._idx = 0);
            T(a);
            "function" == typeof d && d(a)
        }
        function Oa(a, b, c, d) {
            var e =
                    a.aoColumns[c];
            Wa(b, {}, function (b) {
                !1 !== e.bSortable && (a.oFeatures.bProcessing ? (C(a, !0), setTimeout(function () {
                    Va(a, c, b.shiftKey, d);
                    "ssp" !== y(a) && C(a, !1)
                }, 0)) : Va(a, c, b.shiftKey, d))
            })
        }
        function xa(a) {
            var b = a.aLastSort, c = a.oClasses.sSortColumn, d = W(a), e = a.oFeatures, f, g;
            if (e.bSort && e.bSortClasses) {
                e = 0;
                for (f = b.length; e < f; e++)
                    g = b[e].src, h(F(a.aoData, "anCells", g)).removeClass(c + (2 > e ? e + 1 : 3));
                e = 0;
                for (f = d.length; e < f; e++)
                    g = d[e].src, h(F(a.aoData, "anCells", g)).addClass(c + (2 > e ? e + 1 : 3))
            }
            a.aLastSort = d
        }
        function Ib(a,
                b) {
            var c = a.aoColumns[b], d = m.ext.order[c.sSortDataType], e;
            d && (e = d.call(a.oInstance, a, b, $(a, b)));
            for (var f, g = m.ext.type.order[c.sType + "-pre"], j = 0, i = a.aoData.length; j < i; j++)
                if (c = a.aoData[j], c._aSortData || (c._aSortData = []), !c._aSortData[b] || d)
                    f = d ? e[j] : B(a, j, b, "sort"), c._aSortData[b] = g ? g(f) : f
        }
        function ya(a) {
            if (a.oFeatures.bStateSave && !a.bDestroying) {
                var b = {time: +new Date, start: a._iDisplayStart, length: a._iDisplayLength, order: h.extend(!0, [], a.aaSorting), search: Ab(a.oPreviousSearch), columns: h.map(a.aoColumns,
                            function (b, d) {
                                return{visible: b.bVisible, search: Ab(a.aoPreSearchCols[d])}
                            })};
                u(a, "aoStateSaveParams", "stateSaveParams", [a, b]);
                a.oSavedState = b;
                a.fnStateSaveCallback.call(a.oInstance, a, b)
            }
        }
        function Kb(a) {
            var b, c, d = a.aoColumns;
            if (a.oFeatures.bStateSave) {
                var e = a.fnStateLoadCallback.call(a.oInstance, a);
                if (e && e.time && (b = u(a, "aoStateLoadParams", "stateLoadParams", [a, e]), -1 === h.inArray(!1, b) && (b = a.iStateDuration, !(0 < b && e.time < +new Date - 1E3 * b) && d.length === e.columns.length))) {
                    a.oLoadedState = h.extend(!0, {}, e);
                    e.start !== k && (a._iDisplayStart = e.start, a.iInitDisplayStart = e.start);
                    e.length !== k && (a._iDisplayLength = e.length);
                    e.order !== k && (a.aaSorting = [], h.each(e.order, function (b, c) {
                        a.aaSorting.push(c[0] >= d.length ? [0, c[1]] : c)
                    }));
                    e.search !== k && h.extend(a.oPreviousSearch, Bb(e.search));
                    b = 0;
                    for (c = e.columns.length; b < c; b++) {
                        var f = e.columns[b];
                        f.visible !== k && (d[b].bVisible = f.visible);
                        f.search !== k && h.extend(a.aoPreSearchCols[b], Bb(f.search))
                    }
                    u(a, "aoStateLoaded", "stateLoaded", [a, e])
                }
            }
        }
        function za(a) {
            var b = m.settings, a =
                    h.inArray(a, F(b, "nTable"));
            return-1 !== a ? b[a] : null
        }
        function L(a, b, c, d) {
            c = "DataTables warning: " + (a ? "table id=" + a.sTableId + " - " : "") + c;
            d && (c += ". For more information about this error, please see http://datatables.net/tn/" + d);
            if (b)
                D.console && console.log && console.log(c);
            else if (b = m.ext, b = b.sErrMode || b.errMode, a && u(a, null, "error", [a, d, c]), "alert" == b)
                alert(c);
            else {
                if ("throw" == b)
                    throw Error(c);
                "function" == typeof b && b(a, d, c)
            }
        }
        function E(a, b, c, d) {
            h.isArray(c) ? h.each(c, function (c, d) {
                h.isArray(d) ? E(a, b, d[0],
                        d[1]) : E(a, b, d)
            }) : (d === k && (d = c), b[c] !== k && (a[d] = b[c]))
        }
        function Lb(a, b, c) {
            var d, e;
            for (e in b)
                b.hasOwnProperty(e) && (d = b[e], h.isPlainObject(d) ? (h.isPlainObject(a[e]) || (a[e] = {}), h.extend(!0, a[e], d)) : a[e] = c && "data" !== e && "aaData" !== e && h.isArray(d) ? d.slice() : d);
            return a
        }
        function Wa(a, b, c) {
            h(a).bind("click.DT", b, function (b) {
                a.blur();
                c(b)
            }).bind("keypress.DT", b, function (a) {
                13 === a.which && (a.preventDefault(), c(a))
            }).bind("selectstart.DT", function () {
                return!1
            })
        }
        function z(a, b, c, d) {
            c && a[b].push({fn: c, sName: d})
        }
        function u(a, b, c, d) {
            var e = [];
            b && (e = h.map(a[b].slice().reverse(), function (b) {
                return b.fn.apply(a.oInstance, d)
            }));
            null !== c && (b = h.Event(c + ".dt"), h(a.nTable).trigger(b, d), e.push(b.result));
            return e
        }
        function Sa(a) {
            var b = a._iDisplayStart, c = a.fnDisplayEnd(), d = a._iDisplayLength;
            b >= c && (b = c - d);
            b -= b % d;
            if (-1 === d || 0 > b)
                b = 0;
            a._iDisplayStart = b
        }
        function Pa(a, b) {
            var c = a.renderer, d = m.ext.renderer[b];
            return h.isPlainObject(c) && c[b] ? d[c[b]] || d._ : "string" === typeof c ? d[c] || d._ : d._
        }
        function y(a) {
            return a.oFeatures.bServerSide ?
                    "ssp" : a.ajax || a.sAjaxSource ? "ajax" : "dom"
        }
        function Aa(a, b) {
            var c = [], c = Mb.numbers_length, d = Math.floor(c / 2);
            b <= c ? c = X(0, b) : a <= d ? (c = X(0, c - 2), c.push("ellipsis"), c.push(b - 1)) : (a >= b - 1 - d ? c = X(b - (c - 2), b) : (c = X(a - d + 2, a + d - 1), c.push("ellipsis"), c.push(b - 1)), c.splice(0, 0, "ellipsis"), c.splice(0, 0, 0));
            c.DT_el = "span";
            return c
        }
        function db(a) {
            h.each({num: function (b) {
                    return Ba(b, a)
                }, "num-fmt": function (b) {
                    return Ba(b, a, Xa)
                }, "html-num": function (b) {
                    return Ba(b, a, Ca)
                }, "html-num-fmt": function (b) {
                    return Ba(b, a, Ca, Xa)
                }}, function (b,
                    c) {
                v.type.order[b + a + "-pre"] = c;
                b.match(/^html\-/) && (v.type.search[b + a] = v.type.search.html)
            })
        }
        function Nb(a) {
            return function () {
                var b = [za(this[m.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));
                return m.ext.internal[a].apply(this, b)
            }
        }
        var m, v, r, p, s, Ya = {}, Ob = /[\r\n]/g, Ca = /<.*?>/g, bc = /^[\w\+\-]/, cc = /[\w\+\-]$/, Zb = RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\|\\$|\\^|\\-)", "g"), Xa = /[',$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfk]/gi, M = function (a) {
            return!a || !0 === a || "-" === a ? !0 : !1
        },
                Pb = function (a) {
                    var b = parseInt(a, 10);
                    return!isNaN(b) && isFinite(a) ? b : null
                }, Qb = function (a, b) {
            Ya[b] || (Ya[b] = RegExp(va(b), "g"));
            return"string" === typeof a && "." !== b ? a.replace(/\./g, "").replace(Ya[b], ".") : a
        }, Za = function (a, b, c) {
            var d = "string" === typeof a;
            if (M(a))
                return!0;
            b && d && (a = Qb(a, b));
            c && d && (a = a.replace(Xa, ""));
            return!isNaN(parseFloat(a)) && isFinite(a)
        }, Rb = function (a, b, c) {
            return M(a) ? !0 : !(M(a) || "string" === typeof a) ? null : Za(a.replace(Ca, ""), b, c) ? !0 : null
        }, F = function (a, b, c) {
            var d = [], e = 0, f = a.length;
            if (c !== k)
                for (; e <
                        f; e++)
                    a[e] && a[e][b] && d.push(a[e][b][c]);
            else
                for (; e < f; e++)
                    a[e] && d.push(a[e][b]);
            return d
        }, ha = function (a, b, c, d) {
            var e = [], f = 0, g = b.length;
            if (d !== k)
                for (; f < g; f++)
                    a[b[f]][c] && e.push(a[b[f]][c][d]);
            else
                for (; f < g; f++)
                    e.push(a[b[f]][c]);
            return e
        }, X = function (a, b) {
            var c = [], d;
            b === k ? (b = 0, d = a) : (d = b, b = a);
            for (var e = b; e < d; e++)
                c.push(e);
            return c
        }, Sb = function (a) {
            for (var b = [], c = 0, d = a.length; c < d; c++)
                a[c] && b.push(a[c]);
            return b
        }, pa = function (a) {
            var b = [], c, d, e = a.length, f, g = 0;
            d = 0;
            a:for (; d < e; d++) {
                c = a[d];
                for (f = 0; f < g; f++)
                    if (b[f] ===
                            c)
                        continue a;
                b.push(c);
                g++
            }
            return b
        }, A = function (a, b, c) {
            a[b] !== k && (a[c] = a[b])
        }, ba = /\[.*?\]$/, V = /\(\)$/, wa = h("<div>")[0], $b = wa.textContent !== k, ac = /<.*?>/g;
        m = function (a) {
            this.$ = function (a, b) {
                return this.api(!0).$(a, b)
            };
            this._ = function (a, b) {
                return this.api(!0).rows(a, b).data()
            };
            this.api = function (a) {
                return a ? new r(za(this[v.iApiIndex])) : new r(this)
            };
            this.fnAddData = function (a, b) {
                var c = this.api(!0), d = h.isArray(a) && (h.isArray(a[0]) || h.isPlainObject(a[0])) ? c.rows.add(a) : c.row.add(a);
                (b === k || b) && c.draw();
                return d.flatten().toArray()
            };
            this.fnAdjustColumnSizing = function (a) {
                var b = this.api(!0).columns.adjust(), c = b.settings()[0], d = c.oScroll;
                a === k || a ? b.draw(!1) : ("" !== d.sX || "" !== d.sY) && ka(c)
            };
            this.fnClearTable = function (a) {
                var b = this.api(!0).clear();
                (a === k || a) && b.draw()
            };
            this.fnClose = function (a) {
                this.api(!0).row(a).child.hide()
            };
            this.fnDeleteRow = function (a, b, c) {
                var d = this.api(!0), a = d.rows(a), e = a.settings()[0], h = e.aoData[a[0][0]];
                a.remove();
                b && b.call(this, e, h);
                (c === k || c) && d.draw();
                return h
            };
            this.fnDestroy = function (a) {
                this.api(!0).destroy(a)
            };
            this.fnDraw = function (a) {
                this.api(!0).draw(a)
            };
            this.fnFilter = function (a, b, c, d, e, h) {
                e = this.api(!0);
                null === b || b === k ? e.search(a, c, d, h) : e.column(b).search(a, c, d, h);
                e.draw()
            };
            this.fnGetData = function (a, b) {
                var c = this.api(!0);
                if (a !== k) {
                    var d = a.nodeName ? a.nodeName.toLowerCase() : "";
                    return b !== k || "td" == d || "th" == d ? c.cell(a, b).data() : c.row(a).data() || null
                }
                return c.data().toArray()
            };
            this.fnGetNodes = function (a) {
                var b = this.api(!0);
                return a !== k ? b.row(a).node() : b.rows().nodes().flatten().toArray()
            };
            this.fnGetPosition =
                    function (a) {
                        var b = this.api(!0), c = a.nodeName.toUpperCase();
                        return"TR" == c ? b.row(a).index() : "TD" == c || "TH" == c ? (a = b.cell(a).index(), [a.row, a.columnVisible, a.column]) : null
                    };
            this.fnIsOpen = function (a) {
                return this.api(!0).row(a).child.isShown()
            };
            this.fnOpen = function (a, b, c) {
                return this.api(!0).row(a).child(b, c).show().child()[0]
            };
            this.fnPageChange = function (a, b) {
                var c = this.api(!0).page(a);
                (b === k || b) && c.draw(!1)
            };
            this.fnSetColumnVis = function (a, b, c) {
                a = this.api(!0).column(a).visible(b);
                (c === k || c) && a.columns.adjust().draw()
            };
            this.fnSettings = function () {
                return za(this[v.iApiIndex])
            };
            this.fnSort = function (a) {
                this.api(!0).order(a).draw()
            };
            this.fnSortListener = function (a, b, c) {
                this.api(!0).order.listener(a, b, c)
            };
            this.fnUpdate = function (a, b, c, d, e) {
                var h = this.api(!0);
                c === k || null === c ? h.row(b).data(a) : h.cell(b, c).data(a);
                (e === k || e) && h.columns.adjust();
                (d === k || d) && h.draw();
                return 0
            };
            this.fnVersionCheck = v.fnVersionCheck;
            var b = this, c = a === k, d = this.length;
            c && (a = {});
            this.oApi = this.internal = v.internal;
            for (var e in m.ext.internal)
                e && (this[e] =
                        Nb(e));
            this.each(function () {
                var e = {}, e = 1 < d ? Lb(e, a, !0) : a, g = 0, j, i = this.getAttribute("id"), n = !1, l = m.defaults, q = h(this);
                if ("table" != this.nodeName.toLowerCase())
                    L(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
                else {
                    eb(l);
                    fb(l.column);
                    K(l, l, !0);
                    K(l.column, l.column, !0);
                    K(l, h.extend(e, q.data()));
                    var t = m.settings, g = 0;
                    for (j = t.length; g < j; g++) {
                        var p = t[g];
                        if (p.nTable == this || p.nTHead.parentNode == this || p.nTFoot && p.nTFoot.parentNode == this) {
                            g = e.bRetrieve !== k ? e.bRetrieve : l.bRetrieve;
                            if (c || g)
                                return p.oInstance;
                            if (e.bDestroy !== k ? e.bDestroy : l.bDestroy) {
                                p.oInstance.fnDestroy();
                                break
                            } else {
                                L(p, 0, "Cannot reinitialise DataTable", 3);
                                return
                            }
                        }
                        if (p.sTableId == this.id) {
                            t.splice(g, 1);
                            break
                        }
                    }
                    if (null === i || "" === i)
                        this.id = i = "DataTables_Table_" + m.ext._unique++;
                    var o = h.extend(!0, {}, m.models.oSettings, {sDestroyWidth: q[0].style.width, sInstance: i, sTableId: i});
                    o.nTable = this;
                    o.oApi = b.internal;
                    o.oInit = e;
                    t.push(o);
                    o.oInstance = 1 === b.length ? b : q.dataTable();
                    eb(e);
                    e.oLanguage && Fa(e.oLanguage);
                    e.aLengthMenu && !e.iDisplayLength && (e.iDisplayLength =
                            h.isArray(e.aLengthMenu[0]) ? e.aLengthMenu[0][0] : e.aLengthMenu[0]);
                    e = Lb(h.extend(!0, {}, l), e);
                    E(o.oFeatures, e, "bPaginate bLengthChange bFilter bSort bSortMulti bInfo bProcessing bAutoWidth bSortClasses bServerSide bDeferRender".split(" "));
                    E(o, e, ["asStripeClasses", "ajax", "fnServerData", "fnFormatNumber", "sServerMethod", "aaSorting", "aaSortingFixed", "aLengthMenu", "sPaginationType", "sAjaxSource", "sAjaxDataProp", "iStateDuration", "sDom", "bSortCellsTop", "iTabIndex", "fnStateLoadCallback", "fnStateSaveCallback",
                        "renderer", "searchDelay", "rowId", ["iCookieDuration", "iStateDuration"], ["oSearch", "oPreviousSearch"], ["aoSearchCols", "aoPreSearchCols"], ["iDisplayLength", "_iDisplayLength"], ["bJQueryUI", "bJUI"]]);
                    E(o.oScroll, e, [["sScrollX", "sX"], ["sScrollXInner", "sXInner"], ["sScrollY", "sY"], ["bScrollCollapse", "bCollapse"]]);
                    E(o.oLanguage, e, "fnInfoCallback");
                    z(o, "aoDrawCallback", e.fnDrawCallback, "user");
                    z(o, "aoServerParams", e.fnServerParams, "user");
                    z(o, "aoStateSaveParams", e.fnStateSaveParams, "user");
                    z(o, "aoStateLoadParams",
                            e.fnStateLoadParams, "user");
                    z(o, "aoStateLoaded", e.fnStateLoaded, "user");
                    z(o, "aoRowCallback", e.fnRowCallback, "user");
                    z(o, "aoRowCreatedCallback", e.fnCreatedRow, "user");
                    z(o, "aoHeaderCallback", e.fnHeaderCallback, "user");
                    z(o, "aoFooterCallback", e.fnFooterCallback, "user");
                    z(o, "aoInitComplete", e.fnInitComplete, "user");
                    z(o, "aoPreDrawCallback", e.fnPreDrawCallback, "user");
                    o.rowIdFn = Q(e.rowId);
                    gb(o);
                    i = o.oClasses;
                    e.bJQueryUI ? (h.extend(i, m.ext.oJUIClasses, e.oClasses), e.sDom === l.sDom && "lfrtip" === l.sDom && (o.sDom =
                            '<"H"lfr>t<"F"ip>'), o.renderer) ? h.isPlainObject(o.renderer) && !o.renderer.header && (o.renderer.header = "jqueryui") : o.renderer = "jqueryui" : h.extend(i, m.ext.classes, e.oClasses);
                    q.addClass(i.sTable);
                    o.iInitDisplayStart === k && (o.iInitDisplayStart = e.iDisplayStart, o._iDisplayStart = e.iDisplayStart);
                    null !== e.iDeferLoading && (o.bDeferLoading = !0, g = h.isArray(e.iDeferLoading), o._iRecordsDisplay = g ? e.iDeferLoading[0] : e.iDeferLoading, o._iRecordsTotal = g ? e.iDeferLoading[1] : e.iDeferLoading);
                    var r = o.oLanguage;
                    h.extend(!0,
                            r, e.oLanguage);
                    "" !== r.sUrl && (h.ajax({dataType: "json", url: r.sUrl, success: function (a) {
                            Fa(a);
                            K(l.oLanguage, a);
                            h.extend(true, r, a);
                            ga(o)
                        }, error: function () {
                            ga(o)
                        }}), n = !0);
                    null === e.asStripeClasses && (o.asStripeClasses = [i.sStripeOdd, i.sStripeEven]);
                    var g = o.asStripeClasses, v = q.children("tbody").find("tr").eq(0);
                    -1 !== h.inArray(!0, h.map(g, function (a) {
                        return v.hasClass(a)
                    })) && (h("tbody tr", this).removeClass(g.join(" ")), o.asDestroyStripes = g.slice());
                    t = [];
                    g = this.getElementsByTagName("thead");
                    0 !== g.length && (da(o.aoHeader,
                            g[0]), t = qa(o));
                    if (null === e.aoColumns) {
                        p = [];
                        g = 0;
                        for (j = t.length; g < j; g++)
                            p.push(null)
                    } else
                        p = e.aoColumns;
                    g = 0;
                    for (j = p.length; g < j; g++)
                        Ga(o, t ? t[g] : null);
                    ib(o, e.aoColumnDefs, p, function (a, b) {
                        ja(o, a, b)
                    });
                    if (v.length) {
                        var s = function (a, b) {
                            return a.getAttribute("data-" + b) !== null ? b : null
                        };
                        h(v[0]).children("th, td").each(function (a, b) {
                            var c = o.aoColumns[a];
                            if (c.mData === a) {
                                var d = s(b, "sort") || s(b, "order"), e = s(b, "filter") || s(b, "search");
                                if (d !== null || e !== null) {
                                    c.mData = {_: a + ".display", sort: d !== null ? a + ".@data-" + d : k, type: d !==
                                                null ? a + ".@data-" + d : k, filter: e !== null ? a + ".@data-" + e : k};
                                    ja(o, a)
                                }
                            }
                        })
                    }
                    var w = o.oFeatures;
                    e.bStateSave && (w.bStateSave = !0, Kb(o, e), z(o, "aoDrawCallback", ya, "state_save"));
                    if (e.aaSorting === k) {
                        t = o.aaSorting;
                        g = 0;
                        for (j = t.length; g < j; g++)
                            t[g][1] = o.aoColumns[g].asSorting[0]
                    }
                    xa(o);
                    w.bSort && z(o, "aoDrawCallback", function () {
                        if (o.bSorted) {
                            var a = W(o), b = {};
                            h.each(a, function (a, c) {
                                b[c.src] = c.dir
                            });
                            u(o, null, "order", [o, a, b]);
                            Jb(o)
                        }
                    });
                    z(o, "aoDrawCallback", function () {
                        (o.bSorted || y(o) === "ssp" || w.bDeferRender) && xa(o)
                    }, "sc");
                    g =
                            q.children("caption").each(function () {
                        this._captionSide = q.css("caption-side")
                    });
                    j = q.children("thead");
                    0 === j.length && (j = h("<thead/>").appendTo(this));
                    o.nTHead = j[0];
                    j = q.children("tbody");
                    0 === j.length && (j = h("<tbody/>").appendTo(this));
                    o.nTBody = j[0];
                    j = q.children("tfoot");
                    if (0 === j.length && 0 < g.length && ("" !== o.oScroll.sX || "" !== o.oScroll.sY))
                        j = h("<tfoot/>").appendTo(this);
                    0 === j.length || 0 === j.children().length ? q.addClass(i.sNoFooter) : 0 < j.length && (o.nTFoot = j[0], da(o.aoFooter, o.nTFoot));
                    if (e.aaData)
                        for (g = 0; g <
                                e.aaData.length; g++)
                            N(o, e.aaData[g]);
                    else
                        (o.bDeferLoading || "dom" == y(o)) && ma(o, h(o.nTBody).children("tr"));
                    o.aiDisplay = o.aiDisplayMaster.slice();
                    o.bInitialised = !0;
                    !1 === n && ga(o)
                }
            });
            b = null;
            return this
        };
        var Tb = [], w = Array.prototype, dc = function (a) {
            var b, c, d = m.settings, e = h.map(d, function (a) {
                return a.nTable
            });
            if (a) {
                if (a.nTable && a.oApi)
                    return[a];
                if (a.nodeName && "table" === a.nodeName.toLowerCase())
                    return b = h.inArray(a, e), -1 !== b ? [d[b]] : null;
                if (a && "function" === typeof a.settings)
                    return a.settings().toArray();
                "string" ===
                        typeof a ? c = h(a) : a instanceof h && (c = a)
            } else
                return[];
            if (c)
                return c.map(function () {
                    b = h.inArray(this, e);
                    return-1 !== b ? d[b] : null
                }).toArray()
        };
        r = function (a, b) {
            if (!(this instanceof r))
                return new r(a, b);
            var c = [], d = function (a) {
                (a = dc(a)) && (c = c.concat(a))
            };
            if (h.isArray(a))
                for (var e = 0, f = a.length; e < f; e++)
                    d(a[e]);
            else
                d(a);
            this.context = pa(c);
            b && h.merge(this, b);
            this.selector = {rows: null, cols: null, opts: null};
            r.extend(this, this, Tb)
        };
        m.Api = r;
        h.extend(r.prototype, {any: function () {
                return 0 !== this.count()
            }, concat: w.concat,
            context: [], count: function () {
                return this.flatten().length
            }, each: function (a) {
                for (var b = 0, c = this.length; b < c; b++)
                    a.call(this, this[b], b, this);
                return this
            }, eq: function (a) {
                var b = this.context;
                return b.length > a ? new r(b[a], this[a]) : null
            }, filter: function (a) {
                var b = [];
                if (w.filter)
                    b = w.filter.call(this, a, this);
                else
                    for (var c = 0, d = this.length; c < d; c++)
                        a.call(this, this[c], c, this) && b.push(this[c]);
                return new r(this.context, b)
            }, flatten: function () {
                var a = [];
                return new r(this.context, a.concat.apply(a, this.toArray()))
            }, join: w.join,
            indexOf: w.indexOf || function (a, b) {
                for (var c = b || 0, d = this.length; c < d; c++)
                    if (this[c] === a)
                        return c;
                return-1
            }, iterator: function (a, b, c, d) {
                var e = [], f, g, h, i, n, l = this.context, m, t, p = this.selector;
                "string" === typeof a && (d = c, c = b, b = a, a = !1);
                g = 0;
                for (h = l.length; g < h; g++) {
                    var o = new r(l[g]);
                    if ("table" === b)
                        f = c.call(o, l[g], g), f !== k && e.push(f);
                    else if ("columns" === b || "rows" === b)
                        f = c.call(o, l[g], this[g], g), f !== k && e.push(f);
                    else if ("column" === b || "column-rows" === b || "row" === b || "cell" === b) {
                        t = this[g];
                        "column-rows" === b && (m = Da(l[g],
                                p.opts));
                        i = 0;
                        for (n = t.length; i < n; i++)
                            f = t[i], f = "cell" === b ? c.call(o, l[g], f.row, f.column, g, i) : c.call(o, l[g], f, g, i, m), f !== k && e.push(f)
                    }
                }
                return e.length || d ? (a = new r(l, a ? e.concat.apply([], e) : e), b = a.selector, b.rows = p.rows, b.cols = p.cols, b.opts = p.opts, a) : this
            }, lastIndexOf: w.lastIndexOf || function (a, b) {
                return this.indexOf.apply(this.toArray.reverse(), arguments)
            }, length: 0, map: function (a) {
                var b = [];
                if (w.map)
                    b = w.map.call(this, a, this);
                else
                    for (var c = 0, d = this.length; c < d; c++)
                        b.push(a.call(this, this[c], c));
                return new r(this.context,
                        b)
            }, pluck: function (a) {
                return this.map(function (b) {
                    return b[a]
                })
            }, pop: w.pop, push: w.push, reduce: w.reduce || function (a, b) {
                return hb(this, a, b, 0, this.length, 1)
            }, reduceRight: w.reduceRight || function (a, b) {
                return hb(this, a, b, this.length - 1, -1, -1)
            }, reverse: w.reverse, selector: null, shift: w.shift, sort: w.sort, splice: w.splice, toArray: function () {
                return w.slice.call(this)
            }, to$: function () {
                return h(this)
            }, toJQuery: function () {
                return h(this)
            }, unique: function () {
                return new r(this.context, pa(this))
            }, unshift: w.unshift});
        r.extend =
                function (a, b, c) {
                    if (c.length && b && (b instanceof r || b.__dt_wrapper)) {
                        var d, e, f, g = function (a, b, c) {
                            return function () {
                                var d = b.apply(a, arguments);
                                r.extend(d, d, c.methodExt);
                                return d
                            }
                        };
                        d = 0;
                        for (e = c.length; d < e; d++)
                            f = c[d], b[f.name] = "function" === typeof f.val ? g(a, f.val, f) : h.isPlainObject(f.val) ? {} : f.val, b[f.name].__dt_wrapper = !0, r.extend(a, b[f.name], f.propExt)
                    }
                };
        r.register = p = function (a, b) {
            if (h.isArray(a))
                for (var c = 0, d = a.length; c < d; c++)
                    r.register(a[c], b);
            else
                for (var e = a.split("."), f = Tb, g, j, c = 0, d = e.length; c < d; c++) {
                    g =
                            (j = -1 !== e[c].indexOf("()")) ? e[c].replace("()", "") : e[c];
                    var i;
                    a:{
                        i = 0;
                        for (var n = f.length; i < n; i++)
                            if (f[i].name === g) {
                                i = f[i];
                                break a
                            }
                        i = null
                    }
                    i || (i = {name: g, val: {}, methodExt: [], propExt: []}, f.push(i));
                    c === d - 1 ? i.val = b : f = j ? i.methodExt : i.propExt
                }
        };
        r.registerPlural = s = function (a, b, c) {
            r.register(a, c);
            r.register(b, function () {
                var a = c.apply(this, arguments);
                return a === this ? this : a instanceof r ? a.length ? h.isArray(a[0]) ? new r(a.context, a[0]) : a[0] : k : a
            })
        };
        p("tables()", function (a) {
            var b;
            if (a) {
                b = r;
                var c = this.context;
                if ("number" ===
                        typeof a)
                    a = [c[a]];
                else
                    var d = h.map(c, function (a) {
                        return a.nTable
                    }), a = h(d).filter(a).map(function () {
                        var a = h.inArray(this, d);
                        return c[a]
                    }).toArray();
                b = new b(a)
            } else
                b = this;
            return b
        });
        p("table()", function (a) {
            var a = this.tables(a), b = a.context;
            return b.length ? new r(b[0]) : a
        });
        s("tables().nodes()", "table().node()", function () {
            return this.iterator("table", function (a) {
                return a.nTable
            }, 1)
        });
        s("tables().body()", "table().body()", function () {
            return this.iterator("table", function (a) {
                return a.nTBody
            }, 1)
        });
        s("tables().header()",
                "table().header()", function () {
                    return this.iterator("table", function (a) {
                        return a.nTHead
                    }, 1)
                });
        s("tables().footer()", "table().footer()", function () {
            return this.iterator("table", function (a) {
                return a.nTFoot
            }, 1)
        });
        s("tables().containers()", "table().container()", function () {
            return this.iterator("table", function (a) {
                return a.nTableWrapper
            }, 1)
        });
        p("draw()", function (a) {
            return this.iterator("table", function (b) {
                "page" === a ? O(b) : ("string" === typeof a && (a = "full-hold" === a ? !1 : !0), T(b, !1 === a))
            })
        });
        p("page()", function (a) {
            return a ===
                    k ? this.page.info().page : this.iterator("table", function (b) {
                Ta(b, a)
            })
        });
        p("page.info()", function () {
            if (0 === this.context.length)
                return k;
            var a = this.context[0], b = a._iDisplayStart, c = a.oFeatures.bPaginate ? a._iDisplayLength : -1, d = a.fnRecordsDisplay(), e = -1 === c;
            return{page: e ? 0 : Math.floor(b / c), pages: e ? 1 : Math.ceil(d / c), start: b, end: a.fnDisplayEnd(), length: c, recordsTotal: a.fnRecordsTotal(), recordsDisplay: d, serverSide: "ssp" === y(a)}
        });
        p("page.len()", function (a) {
            return a === k ? 0 !== this.context.length ? this.context[0]._iDisplayLength :
                    k : this.iterator("table", function (b) {
                        Ra(b, a)
                    })
        });
        var Ub = function (a, b, c) {
            if (c) {
                var d = new r(a);
                d.one("draw", function () {
                    c(d.ajax.json())
                })
            }
            if ("ssp" == y(a))
                T(a, b);
            else {
                C(a, !0);
                var e = a.jqXHR;
                e && 4 !== e.readyState && e.abort();
                ra(a, [], function (c) {
                    na(a);
                    for (var c = sa(a, c), d = 0, e = c.length; d < e; d++)
                        N(a, c[d]);
                    T(a, b);
                    C(a, !1)
                })
            }
        };
        p("ajax.json()", function () {
            var a = this.context;
            if (0 < a.length)
                return a[0].json
        });
        p("ajax.params()", function () {
            var a = this.context;
            if (0 < a.length)
                return a[0].oAjaxData
        });
        p("ajax.reload()", function (a,
                b) {
            return this.iterator("table", function (c) {
                Ub(c, !1 === b, a)
            })
        });
        p("ajax.url()", function (a) {
            var b = this.context;
            if (a === k) {
                if (0 === b.length)
                    return k;
                b = b[0];
                return b.ajax ? h.isPlainObject(b.ajax) ? b.ajax.url : b.ajax : b.sAjaxSource
            }
            return this.iterator("table", function (b) {
                h.isPlainObject(b.ajax) ? b.ajax.url = a : b.ajax = a
            })
        });
        p("ajax.url().load()", function (a, b) {
            return this.iterator("table", function (c) {
                Ub(c, !1 === b, a)
            })
        });
        var $a = function (a, b, c, d, e) {
            var f = [], g, j, i, n, l, m;
            i = typeof b;
            if (!b || "string" === i || "function" ===
                    i || b.length === k)
                b = [b];
            i = 0;
            for (n = b.length; i < n; i++) {
                j = b[i] && b[i].split ? b[i].split(",") : [b[i]];
                l = 0;
                for (m = j.length; l < m; l++)
                    (g = c("string" === typeof j[l] ? h.trim(j[l]) : j[l])) && g.length && (f = f.concat(g))
            }
            a = v.selector[a];
            if (a.length) {
                i = 0;
                for (n = a.length; i < n; i++)
                    f = a[i](d, e, f)
            }
            return pa(f)
        }, ab = function (a) {
            a || (a = {});
            a.filter && a.search === k && (a.search = a.filter);
            return h.extend({search: "none", order: "current", page: "all"}, a)
        }, bb = function (a) {
            for (var b = 0, c = a.length; b < c; b++)
                if (0 < a[b].length)
                    return a[0] = a[b], a[0].length =
                            1, a.length = 1, a.context = [a.context[b]], a;
            a.length = 0;
            return a
        }, Da = function (a, b) {
            var c, d, e, f = [], g = a.aiDisplay;
            c = a.aiDisplayMaster;
            var j = b.search;
            d = b.order;
            e = b.page;
            if ("ssp" == y(a))
                return"removed" === j ? [] : X(0, c.length);
            if ("current" == e) {
                c = a._iDisplayStart;
                for (d = a.fnDisplayEnd(); c < d; c++)
                    f.push(g[c])
            } else if ("current" == d || "applied" == d)
                f = "none" == j ? c.slice() : "applied" == j ? g.slice() : h.map(c, function (a) {
                    return-1 === h.inArray(a, g) ? a : null
                });
            else if ("index" == d || "original" == d) {
                c = 0;
                for (d = a.aoData.length; c < d; c++)
                    "none" ==
                            j ? f.push(c) : (e = h.inArray(c, g), (-1 === e && "removed" == j || 0 <= e && "applied" == j) && f.push(c))
            }
            return f
        };
        p("rows()", function (a, b) {
            a === k ? a = "" : h.isPlainObject(a) && (b = a, a = "");
            var b = ab(b), c = this.iterator("table", function (c) {
                var e = b;
                return $a("row", a, function (a) {
                    var b = Pb(a);
                    if (b !== null && !e)
                        return[b];
                    var j = Da(c, e);
                    if (b !== null && h.inArray(b, j) !== -1)
                        return[b];
                    if (!a)
                        return j;
                    if (typeof a === "function")
                        return h.map(j, function (b) {
                            var e = c.aoData[b];
                            return a(b, e._aData, e.nTr) ? b : null
                        });
                    b = Sb(ha(c.aoData, j, "nTr"));
                    if (a.nodeName) {
                        if (a._DT_RowIndex !==
                                k)
                            return[a._DT_RowIndex];
                        if (a._DT_CellIndex)
                            return[a._DT_CellIndex.row];
                        b = h(a).closest("*[data-dt-row]");
                        return b.length ? [b.data("dt-row")] : []
                    }
                    if (typeof a === "string" && a.charAt(0) === "#") {
                        j = c.aIds[a.replace(/^#/, "")];
                        if (j !== k)
                            return[j.idx]
                    }
                    return h(b).filter(a).map(function () {
                        return this._DT_RowIndex
                    }).toArray()
                }, c, e)
            }, 1);
            c.selector.rows = a;
            c.selector.opts = b;
            return c
        });
        p("rows().nodes()", function () {
            return this.iterator("row", function (a, b) {
                return a.aoData[b].nTr || k
            }, 1)
        });
        p("rows().data()", function () {
            return this.iterator(!0,
                    "rows", function (a, b) {
                        return ha(a.aoData, b, "_aData")
                    }, 1)
        });
        s("rows().cache()", "row().cache()", function (a) {
            return this.iterator("row", function (b, c) {
                var d = b.aoData[c];
                return"search" === a ? d._aFilterData : d._aSortData
            }, 1)
        });
        s("rows().invalidate()", "row().invalidate()", function (a) {
            return this.iterator("row", function (b, c) {
                ca(b, c, a)
            })
        });
        s("rows().indexes()", "row().index()", function () {
            return this.iterator("row", function (a, b) {
                return b
            }, 1)
        });
        s("rows().ids()", "row().id()", function (a) {
            for (var b = [], c = this.context,
                    d = 0, e = c.length; d < e; d++)
                for (var f = 0, g = this[d].length; f < g; f++) {
                    var h = c[d].rowIdFn(c[d].aoData[this[d][f]]._aData);
                    b.push((!0 === a ? "#" : "") + h)
                }
            return new r(c, b)
        });
        s("rows().remove()", "row().remove()", function () {
            var a = this;
            this.iterator("row", function (b, c, d) {
                var e = b.aoData, f = e[c], g, h, i, n, l;
                e.splice(c, 1);
                g = 0;
                for (h = e.length; g < h; g++)
                    if (i = e[g], l = i.anCells, null !== i.nTr && (i.nTr._DT_RowIndex = g), null !== l) {
                        i = 0;
                        for (n = l.length; i < n; i++)
                            l[i]._DT_CellIndex.row = g
                    }
                oa(b.aiDisplayMaster, c);
                oa(b.aiDisplay, c);
                oa(a[d], c, !1);
                Sa(b);
                c = b.rowIdFn(f._aData);
                c !== k && delete b.aIds[c]
            });
            this.iterator("table", function (a) {
                for (var c = 0, d = a.aoData.length; c < d; c++)
                    a.aoData[c].idx = c
            });
            return this
        });
        p("rows.add()", function (a) {
            var b = this.iterator("table", function (b) {
                var c, f, g, h = [];
                f = 0;
                for (g = a.length; f < g; f++)
                    c = a[f], c.nodeName && "TR" === c.nodeName.toUpperCase() ? h.push(ma(b, c)[0]) : h.push(N(b, c));
                return h
            }, 1), c = this.rows(-1);
            c.pop();
            h.merge(c, b);
            return c
        });
        p("row()", function (a, b) {
            return bb(this.rows(a, b))
        });
        p("row().data()", function (a) {
            var b =
                    this.context;
            if (a === k)
                return b.length && this.length ? b[0].aoData[this[0]]._aData : k;
            b[0].aoData[this[0]]._aData = a;
            ca(b[0], this[0], "data");
            return this
        });
        p("row().node()", function () {
            var a = this.context;
            return a.length && this.length ? a[0].aoData[this[0]].nTr || null : null
        });
        p("row.add()", function (a) {
            a instanceof h && a.length && (a = a[0]);
            var b = this.iterator("table", function (b) {
                return a.nodeName && "TR" === a.nodeName.toUpperCase() ? ma(b, a)[0] : N(b, a)
            });
            return this.row(b[0])
        });
        var cb = function (a, b) {
            var c = a.context;
            if (c.length &&
                    (c = c[0].aoData[b !== k ? b : a[0]]) && c._details)
                c._details.remove(), c._detailsShow = k, c._details = k
        }, Vb = function (a, b) {
            var c = a.context;
            if (c.length && a.length) {
                var d = c[0].aoData[a[0]];
                if (d._details) {
                    (d._detailsShow = b) ? d._details.insertAfter(d.nTr) : d._details.detach();
                    var e = c[0], f = new r(e), g = e.aoData;
                    f.off("draw.dt.DT_details column-visibility.dt.DT_details destroy.dt.DT_details");
                    0 < F(g, "_details").length && (f.on("draw.dt.DT_details", function (a, b) {
                        e === b && f.rows({page: "current"}).eq(0).each(function (a) {
                            a = g[a];
                            a._detailsShow && a._details.insertAfter(a.nTr)
                        })
                    }), f.on("column-visibility.dt.DT_details", function (a, b) {
                        if (e === b)
                            for (var c, d = aa(b), f = 0, h = g.length; f < h; f++)
                                c = g[f], c._details && c._details.children("td[colspan]").attr("colspan", d)
                    }), f.on("destroy.dt.DT_details", function (a, b) {
                        if (e === b)
                            for (var c = 0, d = g.length; c < d; c++)
                                g[c]._details && cb(f, c)
                    }))
                }
            }
        };
        p("row().child()", function (a, b) {
            var c = this.context;
            if (a === k)
                return c.length && this.length ? c[0].aoData[this[0]]._details : k;
            if (!0 === a)
                this.child.show();
            else if (!1 ===
                    a)
                cb(this);
            else if (c.length && this.length) {
                var d = c[0], c = c[0].aoData[this[0]], e = [], f = function (a, b) {
                    if (h.isArray(a) || a instanceof h)
                        for (var c = 0, k = a.length; c < k; c++)
                            f(a[c], b);
                    else
                        a.nodeName && "tr" === a.nodeName.toLowerCase() ? e.push(a) : (c = h("<tr><td/></tr>").addClass(b), h("td", c).addClass(b).html(a)[0].colSpan = aa(d), e.push(c[0]))
                };
                f(a, b);
                c._details && c._details.remove();
                c._details = h(e);
                c._detailsShow && c._details.insertAfter(c.nTr)
            }
            return this
        });
        p(["row().child.show()", "row().child().show()"], function () {
            Vb(this,
                    !0);
            return this
        });
        p(["row().child.hide()", "row().child().hide()"], function () {
            Vb(this, !1);
            return this
        });
        p(["row().child.remove()", "row().child().remove()"], function () {
            cb(this);
            return this
        });
        p("row().child.isShown()", function () {
            var a = this.context;
            return a.length && this.length ? a[0].aoData[this[0]]._detailsShow || !1 : !1
        });
        var ec = /^(.+):(name|visIdx|visible)$/, Wb = function (a, b, c, d, e) {
            for (var c = [], d = 0, f = e.length; d < f; d++)
                c.push(B(a, e[d], b));
            return c
        };
        p("columns()", function (a, b) {
            a === k ? a = "" : h.isPlainObject(a) &&
                    (b = a, a = "");
            var b = ab(b), c = this.iterator("table", function (c) {
                var e = a, f = b, g = c.aoColumns, j = F(g, "sName"), i = F(g, "nTh");
                return $a("column", e, function (a) {
                    var b = Pb(a);
                    if (a === "")
                        return X(g.length);
                    if (b !== null)
                        return[b >= 0 ? b : g.length + b];
                    if (typeof a === "function") {
                        var e = Da(c, f);
                        return h.map(g, function (b, f) {
                            return a(f, Wb(c, f, 0, 0, e), i[f]) ? f : null
                        })
                    }
                    var k = typeof a === "string" ? a.match(ec) : "";
                    if (k)
                        switch (k[2]) {
                            case "visIdx":
                            case "visible":
                                b = parseInt(k[1], 10);
                                if (b < 0) {
                                    var m = h.map(g, function (a, b) {
                                        return a.bVisible ? b : null
                                    });
                                    return[m[m.length + b]]
                                }
                                return[Z(c, b)];
                                case "name":
                                return h.map(j, function (a, b) {
                                    return a === k[1] ? b : null
                                });
                                default:
                                return[]
                            }
                    if (a.nodeName && a._DT_CellIndex)
                        return[a._DT_CellIndex.column];
                    b = h(i).filter(a).map(function () {
                        return h.inArray(this, i)
                    }).toArray();
                    if (b.length || !a.nodeName)
                        return b;
                    b = h(a).closest("*[data-dt-column]");
                    return b.length ? [b.data("dt-column")] : []
                }, c, f)
            }, 1);
            c.selector.cols = a;
            c.selector.opts = b;
            return c
        });
        s("columns().header()", "column().header()", function () {
            return this.iterator("column",
                    function (a, b) {
                        return a.aoColumns[b].nTh
                    }, 1)
        });
        s("columns().footer()", "column().footer()", function () {
            return this.iterator("column", function (a, b) {
                return a.aoColumns[b].nTf
            }, 1)
        });
        s("columns().data()", "column().data()", function () {
            return this.iterator("column-rows", Wb, 1)
        });
        s("columns().dataSrc()", "column().dataSrc()", function () {
            return this.iterator("column", function (a, b) {
                return a.aoColumns[b].mData
            }, 1)
        });
        s("columns().cache()", "column().cache()", function (a) {
            return this.iterator("column-rows", function (b,
                    c, d, e, f) {
                return ha(b.aoData, f, "search" === a ? "_aFilterData" : "_aSortData", c)
            }, 1)
        });
        s("columns().nodes()", "column().nodes()", function () {
            return this.iterator("column-rows", function (a, b, c, d, e) {
                return ha(a.aoData, e, "anCells", b)
            }, 1)
        });
        s("columns().visible()", "column().visible()", function (a, b) {
            return this.iterator("column", function (c, d) {
                if (a === k)
                    return c.aoColumns[d].bVisible;
                var e = c.aoColumns, f = e[d], g = c.aoData, j, i, n;
                if (a !== k && f.bVisible !== a) {
                    if (a) {
                        var l = h.inArray(!0, F(e, "bVisible"), d + 1);
                        j = 0;
                        for (i = g.length; j <
                                i; j++)
                            n = g[j].nTr, e = g[j].anCells, n && n.insertBefore(e[d], e[l] || null)
                    } else
                        h(F(c.aoData, "anCells", d)).detach();
                    f.bVisible = a;
                    ea(c, c.aoHeader);
                    ea(c, c.aoFooter);
                    (b === k || b) && U(c);
                    u(c, null, "column-visibility", [c, d, a, b]);
                    ya(c)
                }
            })
        });
        s("columns().indexes()", "column().index()", function (a) {
            return this.iterator("column", function (b, c) {
                return"visible" === a ? $(b, c) : c
            }, 1)
        });
        p("columns.adjust()", function () {
            return this.iterator("table", function (a) {
                U(a)
            }, 1)
        });
        p("column.index()", function (a, b) {
            if (0 !== this.context.length) {
                var c =
                        this.context[0];
                if ("fromVisible" === a || "toData" === a)
                    return Z(c, b);
                if ("fromData" === a || "toVisible" === a)
                    return $(c, b)
            }
        });
        p("column()", function (a, b) {
            return bb(this.columns(a, b))
        });
        p("cells()", function (a, b, c) {
            h.isPlainObject(a) && (a.row === k ? (c = a, a = null) : (c = b, b = null));
            h.isPlainObject(b) && (c = b, b = null);
            if (null === b || b === k)
                return this.iterator("table", function (b) {
                    var d = a, e = ab(c), f = b.aoData, g = Da(b, e), j = Sb(ha(f, g, "anCells")), i = h([].concat.apply([], j)), l, n = b.aoColumns.length, m, p, r, u, v, s;
                    return $a("cell", d, function (a) {
                        var c =
                                typeof a === "function";
                        if (a === null || a === k || c) {
                            m = [];
                            p = 0;
                            for (r = g.length; p < r; p++) {
                                l = g[p];
                                for (u = 0; u < n; u++) {
                                    v = {row: l, column: u};
                                    if (c) {
                                        s = f[l];
                                        a(v, B(b, l, u), s.anCells ? s.anCells[u] : null) && m.push(v)
                                    } else
                                        m.push(v)
                                }
                            }
                            return m
                        }
                        if (h.isPlainObject(a))
                            return[a];
                        c = i.filter(a).map(function (a, b) {
                            return{row: b._DT_CellIndex.row, column: b._DT_CellIndex.column}
                        }).toArray();
                        if (c.length || !a.nodeName)
                            return c;
                        s = h(a).closest("*[data-dt-row]");
                        return s.length ? [{row: s.data("dt-row"), column: s.data("dt-column")}] : []
                    }, b, e)
                });
            var d =
                    this.columns(b, c), e = this.rows(a, c), f, g, j, i, n, l = this.iterator("table", function (a, b) {
                f = [];
                g = 0;
                for (j = e[b].length; g < j; g++) {
                    i = 0;
                    for (n = d[b].length; i < n; i++)
                        f.push({row: e[b][g], column: d[b][i]})
                }
                return f
            }, 1);
            h.extend(l.selector, {cols: b, rows: a, opts: c});
            return l
        });
        s("cells().nodes()", "cell().node()", function () {
            return this.iterator("cell", function (a, b, c) {
                return(a = a.aoData[b]) && a.anCells ? a.anCells[c] : k
            }, 1)
        });
        p("cells().data()", function () {
            return this.iterator("cell", function (a, b, c) {
                return B(a, b, c)
            }, 1)
        });
        s("cells().cache()",
                "cell().cache()", function (a) {
                    a = "search" === a ? "_aFilterData" : "_aSortData";
                    return this.iterator("cell", function (b, c, d) {
                        return b.aoData[c][a][d]
                    }, 1)
                });
        s("cells().render()", "cell().render()", function (a) {
            return this.iterator("cell", function (b, c, d) {
                return B(b, c, d, a)
            }, 1)
        });
        s("cells().indexes()", "cell().index()", function () {
            return this.iterator("cell", function (a, b, c) {
                return{row: b, column: c, columnVisible: $(a, c)}
            }, 1)
        });
        s("cells().invalidate()", "cell().invalidate()", function (a) {
            return this.iterator("cell", function (b,
                    c, d) {
                ca(b, c, a, d)
            })
        });
        p("cell()", function (a, b, c) {
            return bb(this.cells(a, b, c))
        });
        p("cell().data()", function (a) {
            var b = this.context, c = this[0];
            if (a === k)
                return b.length && c.length ? B(b[0], c[0].row, c[0].column) : k;
            jb(b[0], c[0].row, c[0].column, a);
            ca(b[0], c[0].row, "data", c[0].column);
            return this
        });
        p("order()", function (a, b) {
            var c = this.context;
            if (a === k)
                return 0 !== c.length ? c[0].aaSorting : k;
            "number" === typeof a ? a = [[a, b]] : h.isArray(a[0]) || (a = Array.prototype.slice.call(arguments));
            return this.iterator("table", function (b) {
                b.aaSorting =
                        a.slice()
            })
        });
        p("order.listener()", function (a, b, c) {
            return this.iterator("table", function (d) {
                Oa(d, a, b, c)
            })
        });
        p("order.fixed()", function (a) {
            if (!a) {
                var b = this.context, b = b.length ? b[0].aaSortingFixed : k;
                return h.isArray(b) ? {pre: b} : b
            }
            return this.iterator("table", function (b) {
                b.aaSortingFixed = h.extend(!0, {}, a)
            })
        });
        p(["columns().order()", "column().order()"], function (a) {
            var b = this;
            return this.iterator("table", function (c, d) {
                var e = [];
                h.each(b[d], function (b, c) {
                    e.push([c, a])
                });
                c.aaSorting = e
            })
        });
        p("search()", function (a,
                b, c, d) {
            var e = this.context;
            return a === k ? 0 !== e.length ? e[0].oPreviousSearch.sSearch : k : this.iterator("table", function (e) {
                e.oFeatures.bFilter && fa(e, h.extend({}, e.oPreviousSearch, {sSearch: a + "", bRegex: null === b ? !1 : b, bSmart: null === c ? !0 : c, bCaseInsensitive: null === d ? !0 : d}), 1)
            })
        });
        s("columns().search()", "column().search()", function (a, b, c, d) {
            return this.iterator("column", function (e, f) {
                var g = e.aoPreSearchCols;
                if (a === k)
                    return g[f].sSearch;
                e.oFeatures.bFilter && (h.extend(g[f], {sSearch: a + "", bRegex: null === b ? !1 : b, bSmart: null ===
                            c ? !0 : c, bCaseInsensitive: null === d ? !0 : d}), fa(e, e.oPreviousSearch, 1))
            })
        });
        p("state()", function () {
            return this.context.length ? this.context[0].oSavedState : null
        });
        p("state.clear()", function () {
            return this.iterator("table", function (a) {
                a.fnStateSaveCallback.call(a.oInstance, a, {})
            })
        });
        p("state.loaded()", function () {
            return this.context.length ? this.context[0].oLoadedState : null
        });
        p("state.save()", function () {
            return this.iterator("table", function (a) {
                ya(a)
            })
        });
        m.versionCheck = m.fnVersionCheck = function (a) {
            for (var b =
                    m.version.split("."), a = a.split("."), c, d, e = 0, f = a.length; e < f; e++)
                if (c = parseInt(b[e], 10) || 0, d = parseInt(a[e], 10) || 0, c !== d)
                    return c > d;
            return!0
        };
        m.isDataTable = m.fnIsDataTable = function (a) {
            var b = h(a).get(0), c = !1;
            h.each(m.settings, function (a, e) {
                var f = e.nScrollHead ? h("table", e.nScrollHead)[0] : null, g = e.nScrollFoot ? h("table", e.nScrollFoot)[0] : null;
                if (e.nTable === b || f === b || g === b)
                    c = !0
            });
            return c
        };
        m.tables = m.fnTables = function (a) {
            var b = !1;
            h.isPlainObject(a) && (b = a.api, a = a.visible);
            var c = h.map(m.settings, function (b) {
                if (!a ||
                        a && h(b.nTable).is(":visible"))
                    return b.nTable
            });
            return b ? new r(c) : c
        };
        m.util = {throttle: ua, escapeRegex: va};
        m.camelToHungarian = K;
        p("$()", function (a, b) {
            var c = this.rows(b).nodes(), c = h(c);
            return h([].concat(c.filter(a).toArray(), c.find(a).toArray()))
        });
        h.each(["on", "one", "off"], function (a, b) {
            p(b + "()", function () {
                var a = Array.prototype.slice.call(arguments);
                a[0].match(/\.dt\b/) || (a[0] += ".dt");
                var d = h(this.tables().nodes());
                d[b].apply(d, a);
                return this
            })
        });
        p("clear()", function () {
            return this.iterator("table",
                    function (a) {
                        na(a)
                    })
        });
        p("settings()", function () {
            return new r(this.context, this.context)
        });
        p("init()", function () {
            var a = this.context;
            return a.length ? a[0].oInit : null
        });
        p("data()", function () {
            return this.iterator("table", function (a) {
                return F(a.aoData, "_aData")
            }).flatten()
        });
        p("destroy()", function (a) {
            a = a || !1;
            return this.iterator("table", function (b) {
                var c = b.nTableWrapper.parentNode, d = b.oClasses, e = b.nTable, f = b.nTBody, g = b.nTHead, j = b.nTFoot, i = h(e), f = h(f), k = h(b.nTableWrapper), l = h.map(b.aoData, function (a) {
                    return a.nTr
                }),
                        p;
                b.bDestroying = !0;
                u(b, "aoDestroyCallback", "destroy", [b]);
                a || (new r(b)).columns().visible(!0);
                k.unbind(".DT").find(":not(tbody *)").unbind(".DT");
                h(D).unbind(".DT-" + b.sInstance);
                e != g.parentNode && (i.children("thead").detach(), i.append(g));
                j && e != j.parentNode && (i.children("tfoot").detach(), i.append(j));
                b.aaSorting = [];
                b.aaSortingFixed = [];
                xa(b);
                h(l).removeClass(b.asStripeClasses.join(" "));
                h("th, td", g).removeClass(d.sSortable + " " + d.sSortableAsc + " " + d.sSortableDesc + " " + d.sSortableNone);
                b.bJUI && (h("th span." +
                        d.sSortIcon + ", td span." + d.sSortIcon, g).detach(), h("th, td", g).each(function () {
                    var a = h("div." + d.sSortJUIWrapper, this);
                    h(this).append(a.contents());
                    a.detach()
                }));
                f.children().detach();
                f.append(l);
                g = a ? "remove" : "detach";
                i[g]();
                k[g]();
                !a && c && (c.insertBefore(e, b.nTableReinsertBefore), i.css("width", b.sDestroyWidth).removeClass(d.sTable), (p = b.asDestroyStripes.length) && f.children().each(function (a) {
                    h(this).addClass(b.asDestroyStripes[a % p])
                }));
                c = h.inArray(b, m.settings);
                -1 !== c && m.settings.splice(c, 1)
            })
        });
        h.each(["column",
            "row", "cell"], function (a, b) {
            p(b + "s().every()", function (a) {
                var d = this.selector.opts, e = this;
                return this.iterator(b, function (f, g, h, i, n) {
                    a.call(e[b](g, "cell" === b ? h : d, "cell" === b ? d : k), g, h, i, n)
                })
            })
        });
        p("i18n()", function (a, b, c) {
            var d = this.context[0], a = Q(a)(d.oLanguage);
            a === k && (a = b);
            c !== k && h.isPlainObject(a) && (a = a[c] !== k ? a[c] : a._);
            return a.replace("%d", c)
        });
        m.version = "1.10.11";
        m.settings = [];
        m.models = {};
        m.models.oSearch = {bCaseInsensitive: !0, sSearch: "", bRegex: !1, bSmart: !0};
        m.models.oRow = {nTr: null, anCells: null,
            _aData: [], _aSortData: null, _aFilterData: null, _sFilterRow: null, _sRowStripe: "", src: null, idx: -1};
        m.models.oColumn = {idx: null, aDataSort: null, asSorting: null, bSearchable: null, bSortable: null, bVisible: null, _sManualType: null, _bAttrSrc: !1, fnCreatedCell: null, fnGetData: null, fnSetData: null, mData: null, mRender: null, nTh: null, nTf: null, sClass: null, sContentPadding: null, sDefaultContent: null, sName: null, sSortDataType: "std", sSortingClass: null, sSortingClassJUI: null, sTitle: null, sType: null, sWidth: null, sWidthOrig: null};
        m.defaults =
                {aaData: null, aaSorting: [[0, "asc"]], aaSortingFixed: [], ajax: null, aLengthMenu: [10, 25, 50, 100], aoColumns: null, aoColumnDefs: null, aoSearchCols: [], asStripeClasses: null, bAutoWidth: !0, bDeferRender: !1, bDestroy: !1, bFilter: !0, bInfo: !0, bJQueryUI: !1, bLengthChange: !0, bPaginate: !0, bProcessing: !1, bRetrieve: !1, bScrollCollapse: !1, bServerSide: !1, bSort: !0, bSortMulti: !0, bSortCellsTop: !1, bSortClasses: !0, bStateSave: !1, fnCreatedRow: null, fnDrawCallback: null, fnFooterCallback: null, fnFormatNumber: function (a) {
                        return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                this.oLanguage.sThousands)
                    }, fnHeaderCallback: null, fnInfoCallback: null, fnInitComplete: null, fnPreDrawCallback: null, fnRowCallback: null, fnServerData: null, fnServerParams: null, fnStateLoadCallback: function (a) {
                        try {
                            return JSON.parse((-1 === a.iStateDuration ? sessionStorage : localStorage).getItem("DataTables_" + a.sInstance + "_" + location.pathname))
                        } catch (b) {
                        }
                    }, fnStateLoadParams: null, fnStateLoaded: null, fnStateSaveCallback: function (a, b) {
                        try {
                            (-1 === a.iStateDuration ? sessionStorage : localStorage).setItem("DataTables_" + a.sInstance +
                                    "_" + location.pathname, JSON.stringify(b))
                        } catch (c) {
                        }
                    }, fnStateSaveParams: null, iStateDuration: 7200, iDeferLoading: null, iDisplayLength: 10, iDisplayStart: 0, iTabIndex: 0, oClasses: {}, oLanguage: {oAria: {sSortAscending: ": activate to sort column ascending", sSortDescending: ": activate to sort column descending"}, oPaginate: {sFirst: "First", sLast: "Last", sNext: "Next", sPrevious: "Previous"}, sEmptyTable: "No data available in table", sInfo: "Showing _START_ to _END_ of _TOTAL_ entries", sInfoEmpty: "Showing 0 to 0 of 0 entries",
                        sInfoFiltered: "(filtered from _MAX_ total entries)", sInfoPostFix: "", sDecimal: "", sThousands: ",", sLengthMenu: "Show _MENU_ entries", sLoadingRecords: "Loading...", sProcessing: "Processing...", sSearch: "Search:", sSearchPlaceholder: "", sUrl: "", sZeroRecords: "No matching records found"}, oSearch: h.extend({}, m.models.oSearch), sAjaxDataProp: "data", sAjaxSource: null, sDom: "lfrtip", searchDelay: null, sPaginationType: "simple_numbers", sScrollX: "", sScrollXInner: "", sScrollY: "", sServerMethod: "GET", renderer: null, rowId: "DT_RowId"};
        Y(m.defaults);
        m.defaults.column = {aDataSort: null, iDataSort: -1, asSorting: ["asc", "desc"], bSearchable: !0, bSortable: !0, bVisible: !0, fnCreatedCell: null, mData: null, mRender: null, sCellType: "td", sClass: "", sContentPadding: "", sDefaultContent: null, sName: "", sSortDataType: "std", sTitle: null, sType: null, sWidth: null};
        Y(m.defaults.column);
        m.models.oSettings = {oFeatures: {bAutoWidth: null, bDeferRender: null, bFilter: null, bInfo: null, bLengthChange: null, bPaginate: null, bProcessing: null, bServerSide: null, bSort: null, bSortMulti: null,
                bSortClasses: null, bStateSave: null}, oScroll: {bCollapse: null, iBarWidth: 0, sX: null, sXInner: null, sY: null}, oLanguage: {fnInfoCallback: null}, oBrowser: {bScrollOversize: !1, bScrollbarLeft: !1, bBounding: !1, barWidth: 0}, ajax: null, aanFeatures: [], aoData: [], aiDisplay: [], aiDisplayMaster: [], aIds: {}, aoColumns: [], aoHeader: [], aoFooter: [], oPreviousSearch: {}, aoPreSearchCols: [], aaSorting: null, aaSortingFixed: [], asStripeClasses: null, asDestroyStripes: [], sDestroyWidth: 0, aoRowCallback: [], aoHeaderCallback: [], aoFooterCallback: [],
            aoDrawCallback: [], aoRowCreatedCallback: [], aoPreDrawCallback: [], aoInitComplete: [], aoStateSaveParams: [], aoStateLoadParams: [], aoStateLoaded: [], sTableId: "", nTable: null, nTHead: null, nTFoot: null, nTBody: null, nTableWrapper: null, bDeferLoading: !1, bInitialised: !1, aoOpenRows: [], sDom: null, searchDelay: null, sPaginationType: "two_button", iStateDuration: 0, aoStateSave: [], aoStateLoad: [], oSavedState: null, oLoadedState: null, sAjaxSource: null, sAjaxDataProp: null, bAjaxDataGet: !0, jqXHR: null, json: k, oAjaxData: k, fnServerData: null,
            aoServerParams: [], sServerMethod: null, fnFormatNumber: null, aLengthMenu: null, iDraw: 0, bDrawing: !1, iDrawError: -1, _iDisplayLength: 10, _iDisplayStart: 0, _iRecordsTotal: 0, _iRecordsDisplay: 0, bJUI: null, oClasses: {}, bFiltered: !1, bSorted: !1, bSortCellsTop: null, oInit: null, aoDestroyCallback: [], fnRecordsTotal: function () {
                return"ssp" == y(this) ? 1 * this._iRecordsTotal : this.aiDisplayMaster.length
            }, fnRecordsDisplay: function () {
                return"ssp" == y(this) ? 1 * this._iRecordsDisplay : this.aiDisplay.length
            }, fnDisplayEnd: function () {
                var a =
                        this._iDisplayLength, b = this._iDisplayStart, c = b + a, d = this.aiDisplay.length, e = this.oFeatures, f = e.bPaginate;
                return e.bServerSide ? !1 === f || -1 === a ? b + d : Math.min(b + a, this._iRecordsDisplay) : !f || c > d || -1 === a ? d : c
            }, oInstance: null, sInstance: null, iTabIndex: 0, nScrollHead: null, nScrollFoot: null, aLastSort: [], oPlugins: {}, rowIdFn: null, rowId: null};
        m.ext = v = {buttons: {}, classes: {}, builder: "-source-", errMode: "alert", feature: [], search: [], selector: {cell: [], column: [], row: []}, internal: {}, legacy: {ajax: null}, pager: {}, renderer: {pageButton: {},
                header: {}}, order: {}, type: {detect: [], search: {}, order: {}}, _unique: 0, fnVersionCheck: m.fnVersionCheck, iApiIndex: 0, oJUIClasses: {}, sVersion: m.version};
        h.extend(v, {afnFiltering: v.search, aTypes: v.type.detect, ofnSearch: v.type.search, oSort: v.type.order, afnSortData: v.order, aoFeatures: v.feature, oApi: v.internal, oStdClasses: v.classes, oPagination: v.pager});
        h.extend(m.ext.classes, {sTable: "dataTable", sNoFooter: "no-footer", sPageButton: "paginate_button", sPageButtonActive: "current", sPageButtonDisabled: "disabled", sStripeOdd: "odd",
            sStripeEven: "even", sRowEmpty: "dataTables_empty", sWrapper: "dataTables_wrapper", sFilter: "dataTables_filter", sInfo: "dataTables_info", sPaging: "dataTables_paginate paging_", sLength: "dataTables_length", sProcessing: "dataTables_processing", sSortAsc: "sorting_asc", sSortDesc: "sorting_desc", sSortable: "sorting", sSortableAsc: "sorting_asc_disabled", sSortableDesc: "sorting_desc_disabled", sSortableNone: "sorting_disabled", sSortColumn: "sorting_", sFilterInput: "", sLengthSelect: "", sScrollWrapper: "dataTables_scroll", sScrollHead: "dataTables_scrollHead",
            sScrollHeadInner: "dataTables_scrollHeadInner", sScrollBody: "dataTables_scrollBody", sScrollFoot: "dataTables_scrollFoot", sScrollFootInner: "dataTables_scrollFootInner", sHeaderTH: "", sFooterTH: "", sSortJUIAsc: "", sSortJUIDesc: "", sSortJUI: "", sSortJUIAscAllowed: "", sSortJUIDescAllowed: "", sSortJUIWrapper: "", sSortIcon: "", sJUIHeader: "", sJUIFooter: ""});
        var Ea = "", Ea = "", H = Ea + "ui-state-default", ia = Ea + "css_right ui-icon ui-icon-", Xb = Ea + "fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix";
        h.extend(m.ext.oJUIClasses,
                m.ext.classes, {sPageButton: "fg-button ui-button " + H, sPageButtonActive: "ui-state-disabled", sPageButtonDisabled: "ui-state-disabled", sPaging: "dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_", sSortAsc: H + " sorting_asc", sSortDesc: H + " sorting_desc", sSortable: H + " sorting", sSortableAsc: H + " sorting_asc_disabled", sSortableDesc: H + " sorting_desc_disabled", sSortableNone: H + " sorting_disabled", sSortJUIAsc: ia + "triangle-1-n", sSortJUIDesc: ia + "triangle-1-s", sSortJUI: ia + "carat-2-n-s",
                    sSortJUIAscAllowed: ia + "carat-1-n", sSortJUIDescAllowed: ia + "carat-1-s", sSortJUIWrapper: "DataTables_sort_wrapper", sSortIcon: "DataTables_sort_icon", sScrollHead: "dataTables_scrollHead " + H, sScrollFoot: "dataTables_scrollFoot " + H, sHeaderTH: H, sFooterTH: H, sJUIHeader: Xb + " ui-corner-tl ui-corner-tr", sJUIFooter: Xb + " ui-corner-bl ui-corner-br"});
        var Mb = m.ext.pager;
        h.extend(Mb, {simple: function () {
                return["previous", "next"]
            }, full: function () {
                return["first", "previous", "next", "last"]
            }, numbers: function (a, b) {
                return[Aa(a,
                            b)]
            }, simple_numbers: function (a, b) {
                return["previous", Aa(a, b), "next"]
            }, full_numbers: function (a, b) {
                return["first", "previous", Aa(a, b), "next", "last"]
            }, _numbers: Aa, numbers_length: 7});
        h.extend(!0, m.ext.renderer, {pageButton: {_: function (a, b, c, d, e, f) {
                    var g = a.oClasses, j = a.oLanguage.oPaginate, i = a.oLanguage.oAria.paginate || {}, k, l, m = 0, p = function (b, d) {
                        var o, r, u, s, v = function (b) {
                            Ta(a, b.data.action, true)
                        };
                        o = 0;
                        for (r = d.length; o < r; o++) {
                            s = d[o];
                            if (h.isArray(s)) {
                                u = h("<" + (s.DT_el || "div") + "/>").appendTo(b);
                                p(u, s)
                            } else {
                                k = null;
                                l = "";
                                switch (s) {
                                    case "ellipsis":
                                        b.append('<span class="ellipsis">&#x2026;</span>');
                                        break;
                                        case "first":
                                        k = j.sFirst;
                                        l = s + (e > 0 ? "" : " " + g.sPageButtonDisabled);
                                        break;
                                        case "previous":
                                        k = j.sPrevious;
                                        l = s + (e > 0 ? "" : " " + g.sPageButtonDisabled);
                                        break;
                                        case "next":
                                        k = j.sNext;
                                        l = s + (e < f - 1 ? "" : " " + g.sPageButtonDisabled);
                                        break;
                                        case "last":
                                        k = j.sLast;
                                        l = s + (e < f - 1 ? "" : " " + g.sPageButtonDisabled);
                                        break;
                                        default:
                                        k = s + 1;
                                        l = e === s ? g.sPageButtonActive : ""
                                    }
                                if (k !== null) {
                                    u = h("<a>", {"class": g.sPageButton + " " + l, "aria-controls": a.sTableId, "aria-label": i[s],
                                        "data-dt-idx": m, tabindex: a.iTabIndex, id: c === 0 && typeof s === "string" ? a.sTableId + "_" + s : null}).html(k).appendTo(b);
                                    Wa(u, {action: s}, v);
                                    m++
                                }
                            }
                        }
                    }, r;
                    try {
                        r = h(b).find(I.activeElement).data("dt-idx")
                    } catch (o) {
                    }
                    p(h(b).empty(), d);
                    r && h(b).find("[data-dt-idx=" + r + "]").focus()
                }}});
        h.extend(m.ext.type.detect, [function (a, b) {
                var c = b.oLanguage.sDecimal;
                return Za(a, c) ? "num" + c : null
            }, function (a) {
                if (a && !(a instanceof Date) && (!bc.test(a) || !cc.test(a)))
                    return null;
                var b = Date.parse(a);
                return null !== b && !isNaN(b) || M(a) ? "date" :
                null
            }, function (a, b) {
                var c = b.oLanguage.sDecimal;
                return Za(a, c, !0) ? "num-fmt" + c : null
            }, function (a, b) {
                var c = b.oLanguage.sDecimal;
                return Rb(a, c) ? "html-num" + c : null
            }, function (a, b) {
                var c = b.oLanguage.sDecimal;
                return Rb(a, c, !0) ? "html-num-fmt" + c : null
            }, function (a) {
                return M(a) || "string" === typeof a && -1 !== a.indexOf("<") ? "html" : null
            }]);
        h.extend(m.ext.type.search, {html: function (a) {
                return M(a) ? a : "string" === typeof a ? a.replace(Ob, " ").replace(Ca, "") : ""
            }, string: function (a) {
                return M(a) ? a : "string" === typeof a ? a.replace(Ob,
                        " ") : a
            }});
        var Ba = function (a, b, c, d) {
            if (0 !== a && (!a || "-" === a))
                return-Infinity;
            b && (a = Qb(a, b));
            a.replace && (c && (a = a.replace(c, "")), d && (a = a.replace(d, "")));
            return 1 * a
        };
        h.extend(v.type.order, {"date-pre": function (a) {
                return Date.parse(a) || 0
            }, "html-pre": function (a) {
                return M(a) ? "" : a.replace ? a.replace(/<.*?>/g, "").toLowerCase() : a + ""
            }, "string-pre": function (a) {
                return M(a) ? "" : "string" === typeof a ? a.toLowerCase() : !a.toString ? "" : a.toString()
            }, "string-asc": function (a, b) {
                return a < b ? -1 : a > b ? 1 : 0
            }, "string-desc": function (a,
                    b) {
                return a < b ? 1 : a > b ? -1 : 0
            }});
        db("");
        h.extend(!0, m.ext.renderer, {header: {_: function (a, b, c, d) {
                    h(a.nTable).on("order.dt.DT", function (e, f, g, h) {
                        if (a === f) {
                            e = c.idx;
                            b.removeClass(c.sSortingClass + " " + d.sSortAsc + " " + d.sSortDesc).addClass(h[e] == "asc" ? d.sSortAsc : h[e] == "desc" ? d.sSortDesc : c.sSortingClass)
                        }
                    })
                }, jqueryui: function (a, b, c, d) {
                    h("<div/>").addClass(d.sSortJUIWrapper).append(b.contents()).append(h("<span/>").addClass(d.sSortIcon + " " + c.sSortingClassJUI)).appendTo(b);
                    h(a.nTable).on("order.dt.DT", function (e,
                            f, g, h) {
                        if (a === f) {
                            e = c.idx;
                            b.removeClass(d.sSortAsc + " " + d.sSortDesc).addClass(h[e] == "asc" ? d.sSortAsc : h[e] == "desc" ? d.sSortDesc : c.sSortingClass);
                            b.find("span." + d.sSortIcon).removeClass(d.sSortJUIAsc + " " + d.sSortJUIDesc + " " + d.sSortJUI + " " + d.sSortJUIAscAllowed + " " + d.sSortJUIDescAllowed).addClass(h[e] == "asc" ? d.sSortJUIAsc : h[e] == "desc" ? d.sSortJUIDesc : c.sSortingClassJUI)
                        }
                    })
                }}});
        var Yb = function (a) {
            return"string" === typeof a ? a.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : a
        };
        m.render = {number: function (a,
                    b, c, d, e) {
                return{display: function (f) {
                        if ("number" !== typeof f && "string" !== typeof f)
                            return f;
                        var g = 0 > f ? "-" : "", h = parseFloat(f);
                        if (isNaN(h))
                            return Yb(f);
                        f = Math.abs(h);
                        h = parseInt(f, 10);
                        f = c ? b + (f - h).toFixed(c).substring(2) : "";
                        return g + (d || "") + h.toString().replace(/\B(?=(\d{3})+(?!\d))/g, a) + f + (e || "")
                    }}
            }, text: function () {
                return{display: Yb}
            }};
        h.extend(m.ext.internal, {_fnExternApiFunc: Nb, _fnBuildAjax: ra, _fnAjaxUpdate: lb, _fnAjaxParameters: ub, _fnAjaxUpdateDraw: vb, _fnAjaxDataSrc: sa, _fnAddColumn: Ga, _fnColumnOptions: ja,
            _fnAdjustColumnSizing: U, _fnVisibleToColumnIndex: Z, _fnColumnIndexToVisible: $, _fnVisbleColumns: aa, _fnGetColumns: la, _fnColumnTypes: Ia, _fnApplyColumnDefs: ib, _fnHungarianMap: Y, _fnCamelToHungarian: K, _fnLanguageCompat: Fa, _fnBrowserDetect: gb, _fnAddData: N, _fnAddTr: ma, _fnNodeToDataIndex: function (a, b) {
                return b._DT_RowIndex !== k ? b._DT_RowIndex : null
            }, _fnNodeToColumnIndex: function (a, b, c) {
                return h.inArray(c, a.aoData[b].anCells)
            }, _fnGetCellData: B, _fnSetCellData: jb, _fnSplitObjNotation: La, _fnGetObjectDataFn: Q, _fnSetObjectDataFn: R,
            _fnGetDataMaster: Ma, _fnClearTable: na, _fnDeleteIndex: oa, _fnInvalidate: ca, _fnGetRowElements: Ka, _fnCreateTr: Ja, _fnBuildHead: kb, _fnDrawHead: ea, _fnDraw: O, _fnReDraw: T, _fnAddOptionsHtml: nb, _fnDetectHeader: da, _fnGetUniqueThs: qa, _fnFeatureHtmlFilter: pb, _fnFilterComplete: fa, _fnFilterCustom: yb, _fnFilterColumn: xb, _fnFilter: wb, _fnFilterCreateSearch: Qa, _fnEscapeRegex: va, _fnFilterData: zb, _fnFeatureHtmlInfo: sb, _fnUpdateInfo: Cb, _fnInfoMacros: Db, _fnInitialise: ga, _fnInitComplete: ta, _fnLengthChange: Ra, _fnFeatureHtmlLength: ob,
            _fnFeatureHtmlPaginate: tb, _fnPageChange: Ta, _fnFeatureHtmlProcessing: qb, _fnProcessingDisplay: C, _fnFeatureHtmlTable: rb, _fnScrollDraw: ka, _fnApplyToChildren: J, _fnCalculateColumnWidths: Ha, _fnThrottle: ua, _fnConvertToWidth: Fb, _fnGetWidestNode: Gb, _fnGetMaxLenString: Hb, _fnStringToCss: x, _fnSortFlatten: W, _fnSort: mb, _fnSortAria: Jb, _fnSortListener: Va, _fnSortAttachListener: Oa, _fnSortingClasses: xa, _fnSortData: Ib, _fnSaveState: ya, _fnLoadState: Kb, _fnSettingsFromNode: za, _fnLog: L, _fnMap: E, _fnBindAction: Wa, _fnCallbackReg: z,
            _fnCallbackFire: u, _fnLengthOverflow: Sa, _fnRenderer: Pa, _fnDataSource: y, _fnRowAttributes: Na, _fnCalculateEnd: function () {}});
        h.fn.dataTable = m;
        m.$ = h;
        h.fn.dataTableSettings = m.settings;
        h.fn.dataTableExt = m.ext;
        h.fn.DataTable = function (a) {
            return h(this).dataTable(a).api()
        };
        h.each(m, function (a, b) {
            h.fn.DataTable[a] = b
        });
        return h.fn.dataTable
    });

    /*!
     DataTables Bootstrap 3 integration
     ©2011-2015 SpryMedia Ltd - datatables.net/license
     */
    (function (b) {
        "function" === typeof define && define.amd ? define(["jquery", "datatables.net"], function (a) {
            return b(a, window, document)
        }) : "object" === typeof exports ? module.exports = function (a, d) {
            a || (a = window);
            if (!d || !d.fn.dataTable)
                d = require("datatables.net")(a, d).$;
            return b(d, a, a.document)
        } : b(jQuery, window, document)
    })(function (b, a, d) {
        var f = b.fn.dataTable;
        b.extend(!0, f.defaults, {dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>", renderer: "bootstrap"});
        b.extend(f.ext.classes,
                {sWrapper: "dataTables_wrapper form-inline dt-bootstrap", sFilterInput: "form-control input-sm", sLengthSelect: "form-control input-sm", sProcessing: "dataTables_processing panel panel-default"});
        f.ext.renderer.pageButton.bootstrap = function (a, h, r, m, j, n) {
            var o = new f.Api(a), s = a.oClasses, k = a.oLanguage.oPaginate, t = a.oLanguage.oAria.paginate || {}, e, g, p = 0, q = function (d, f) {
                var l, h, i, c, m = function (a) {
                    a.preventDefault();
                    !b(a.currentTarget).hasClass("disabled") && o.page() != a.data.action && o.page(a.data.action).draw("page")
                };
                l = 0;
                for (h = f.length; l < h; l++)
                    if (c = f[l], b.isArray(c))
                        q(d, c);
                    else {
                        g = e = "";
                        switch (c) {
                            case "ellipsis":
                                e = "&#x2026;";
                                g = "disabled";
                                break;
                                case "first":
                                e = k.sFirst;
                                g = c + (0 < j ? "" : " disabled");
                                break;
                                case "previous":
                                e = k.sPrevious;
                                g = c + (0 < j ? "" : " disabled");
                                break;
                                case "next":
                                e = k.sNext;
                                g = c + (j < n - 1 ? "" : " disabled");
                                break;
                                case "last":
                                e = k.sLast;
                                g = c + (j < n - 1 ? "" : " disabled");
                                break;
                                default:
                                e = c + 1, g = j === c ? "active" : ""
                            }
                        e && (i = b("<li>", {"class": s.sPageButton + " " + g, id: 0 === r && "string" === typeof c ? a.sTableId + "_" + c : null}).append(b("<a>", {href: "#",
                            "aria-controls": a.sTableId, "aria-label": t[c], "data-dt-idx": p, tabindex: a.iTabIndex}).html(e)).appendTo(d), a.oApi._fnBindAction(i, {action: c}, m), p++)
                    }
            }, i;
            try {
                i = b(h).find(d.activeElement).data("dt-idx")
            } catch (u) {
            }
            q(b(h).empty().html('<ul class="pagination"/>').children("ul"), m);
            i && b(h).find("[data-dt-idx=" + i + "]").focus()
        };
        return f
    });


    /**
     * @package    Google Analytics by Lara
     * @author     Amr M. Ibrahim <mailamr@gmail.com>
     * @link       https://www.xtraorbit.com/
     * @copyright  Copyright (c) WHMCSAdminTheme 2016 - 2017
     */

    window.gauthWindow = function (url) {
        var newWindow = window.open(url, 'name', 'height=600,width=450');
        if (window.focus) {
            newWindow.focus();
        }
    }

    window.debugWindow = function () {
        var newWindow = window.open('', 'Debug', 'height=600,width=600,scrollbars=yes');
        newWindow.document.write("<pre>" + JSON.stringify(lrgawidget_debug, null, " ") + "</pre>");
        if (window.focus) {
            newWindow.focus();
        }
    }

    window.lrgawidget_debug;

    (function ($) {


        var dateRange = {};
        var systemTimeZone;
        var gaViewTimeZone;
        var lrsessionStorageReady = false;
        var setup = false;
        var debug = false;


        function isObject(val) {
            if (val === null) {
                return false;
            }
            return ((typeof val === 'function') || (typeof val === 'object'));
        }

        function reloadCurrentTab() {
            var $link = $('#lrgawidget li.active a[data-toggle="tab"]');
            $link.parent().removeClass('active');
            var tabLink = $link.data('target');
            $('#lrgawidget a[data-target="' + tabLink + '"]').tab('show');
        }

        function lrgaErrorHandler(err) {
            var error;
            var error_description;
            var error_code;
            var error_debug;
            var message;
            if (typeof err === 'object') {
                error = ((err.error != null) ? "[" + err.error + "]" : "");
                error_description = ((err.error_description != null) ? err.error_description : "");
                error_code = ((err.code != null) ? "code [" + err.code + "]" : "");
                if (err.debug != null) {
                    error_debug = "<a href='javascript:debugWindow();'>debug</a>";
                    lrgawidget_debug = err.debug;
                }
                message = "Error " + error_code + " " + error_debug + ":<br> " + error + " " + error_description;
            } else {
                message = err;
            }
            $("#lrgawidget_error").html('<h4><i class="icon fa fa-ban"></i> ' + message + '</h4>');
            $("#lrgawidget_error").removeClass("hidden");
        }

        function lrWidgetSettings(arr) {
            $("#lrgawidget_error").html("").addClass("hidden");
            $("#lrgawidget_mode").html("");
            $("#lrgawidget_loading").html('<i class="fa fa-spinner fa-pulse"></i>');

            if (arr[0]) {
                arr[0].value = "lrgawidget_" + arr[0].value;
            } else {
                arr['action'] = "lrgawidget_" + arr['action'];
            }
            if (typeof arr === 'object') {
                try {
                    arr.push({name: 'start', value: dateRange.start});
                    arr.push({name: 'end', value: dateRange.end});
                } catch (e) {
                    arr['start'] = dateRange.start;
                    arr['end'] = dateRange.end;
                }
            }

            if (debug) {
                console.log(arr)
            }
            ;
            return $.ajax({
                method: "POST",
                url: lrgawidget_ajax_object.lrgawidget_ajax_url,
                data: arr,
                dataType: 'json'
            })
                    .done(function (data, textStatus, jqXHR) {
                        if (debug) {
                            console.log(data)
                        }
                        ;
                        if (data.status != "done") {
                            lrgaErrorHandler(data);
                        }

                        if (data.setup === 1) {
                            setup = true;
                            if ($("#lrgawidget a[data-target='#lrgawidget_settings_tab']").is(":visible")) {
                                $("#lrgawidget a[data-target='#lrgawidget_settings_tab']").tab('show');
                            } else {
                                lrgaErrorHandler("Initial Setup Required!<br><br>Please contact an administratior to complete the widget setup.");
                            }
                        }

                        if (data.status == "done") {
                            if (data.cached) {
                                $("#lrgawidget_mode").attr("class", "label label-success").html('cached');
                            }
                            if (data.system_timezone) {
                                systemTimeZone = data.system_timezone;
                            }
                            if (data.gaview_timezone) {
                                gaViewTimeZone = data.gaview_timezone;
                            }
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        lrgaErrorHandler(errorThrown);
                        if (debug) {
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    })
                    .always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
                        $("#lrgawidget_loading").html("");
                        $("#lrgawidget_loading_big").hide();
                    });
        }


        var lrgaAccounts;
        var lrgaProfiles;
        var lrgaaccountID;
        var webPropertyID;
        var profileID;
        var webPropertyUrl;


        function getProfileDetails(id) {
            var cProfile = {};
            $.each(lrgaProfiles, function (index, profile) {
                if (profile.id && profile.id == id) {
                    cProfile = profile;
                }
            });
            return cProfile;
        }

        function populateViews() {
            $('#lrgawidget-accounts').html("");
            $('#lrgawidget-properties').html("");
            $('#lrgawidget-profiles').html("");

            $.each(lrgaAccounts, function (index, account) {
                if (account.id) {
                    if (!lrgaaccountID) {
                        lrgaaccountID = account.id;
                    }
                    $('#lrgawidget-accounts').append($("<option></option>").attr("value", account.id).text(account.name));
                    if (account.id == lrgaaccountID) {
                        $("#lrgawidget-accname").html(account.name);
                        if (account.webProperties) {
                            $.each(account.webProperties, function (index, webProperty) {
                                if (!webPropertyID) {
                                    webPropertyID = webProperty.id;
                                }
                                $('#lrgawidget-properties').append($("<option></option>").attr("value", webProperty.id).text(webProperty.name + " - [ " + webProperty.id + " ] "));
                                if (webProperty.id == webPropertyID) {
                                    $("#lrgawidget-propname").html(webProperty.name);
                                    $("#lrgawidget-propurl").html(webProperty.websiteUrl + " - [ " + webProperty.id + " ] ");
                                    webPropertyUrl = webProperty.websiteUrl;
                                    if (webProperty.profiles) {
                                        $.each(webProperty.profiles, function (index, profile) {
                                            if (!profileID) {
                                                profileID = profile.id;
                                            }
                                            $('#lrgawidget-profiles').append($("<option></option>").attr("value", profile.id).text(profile.name));
                                            if (profile.id == profileID) {
                                                $("#lrgawidget-vname").html(profile.name);
                                                $("#lrgawidget-vtype").html(profile.type);
                                                var cProfile = getProfileDetails(profile.id);
                                                $("#lrgawidget-vtimezone").html(cProfile.timezone);
                                                $('#lrgawidget-setProfileID input[name=profile_timezone]').val(cProfile.timezone);
                                                if (cProfile.timezone != systemTimeZone) {
                                                    $("#lrgawidget-tz-error-vtimezone").html(cProfile.timezone);
                                                    $("#lrgawidget-tz-error-stimezone").html(systemTimeZone);
                                                    $("#lrgawidget-timezone-show-error").show();
                                                } else {
                                                    $("#lrgawidget-timezone-show-error").hide();
                                                    $("#lrgawidget-timezone-error").hide();
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                }
            });


            $('#lrgawidget-accounts').val(lrgaaccountID);
            $('#lrgawidget-properties').val(webPropertyID);
            $('#lrgawidget-profiles').val(profileID);

        }

        $(document).ready(function () {

            $("#lrgawidget-credentials").submit(function (e) {
                e.preventDefault();
                lrWidgetSettings($("#lrgawidget-credentials").serializeArray()).done(function (data, textStatus, jqXHR) {
                    $('#lrga-wizard').wizard('selectedItem', {step: "lrga-getCode"});
                    $('#lrga-wizard #code-btn').attr('href', 'javascript:gauthWindow("' + data.url + '");');
                    $('#lrgawidget-code input[name="client_id"]').val($('#lrgawidget-credentials input[name="client_id"]').val());
                    $('#lrgawidget-code input[name="client_secret"]').val($('#lrgawidget-credentials input[name="client_secret"]').val());
                })
            });


            $("#lrgawidget-code").submit(function (e) {
                e.preventDefault();
                lrWidgetSettings($("#lrgawidget-code").serializeArray()).done(function (data, textStatus, jqXHR) {
                    if (data.status == "done") {
                        $('#lrga-wizard').wizard('selectedItem', {step: "lrga-profile"});
                    }
                })
            });

            $("#express-lrgawidget-code").submit(function (e) {
                e.preventDefault();
                lrWidgetSettings($("#express-lrgawidget-code").serializeArray()).done(function (data, textStatus, jqXHR) {
                    if (data.status == "done") {
                        $('#lrga-wizard').wizard('selectedItem', {step: "lrga-profile"});
                    }
                })
            });


            $("#lrgawidget-setProfileID").submit(function (e) {
                e.preventDefault();
                lrWidgetSettings($("#lrgawidget-setProfileID").serializeArray()).done(function (data, textStatus, jqXHR) {
                    if (data.status == "done") {
                        $("#lrgawidget a[data-target^='#lrgawidget_']:eq(1)").click();
                    }
                })
            });

            $('#lrga-wizard').on('changed.fu.wizard', function (evt, data) {
                if ($("[data-step=" + data.step + "]").attr("data-name") == "lrga-profile") {
                    lrWidgetSettings({action: "getProfiles"}).done(function (data, textStatus, jqXHR) {
                        if (data.status == "done") {
                            lrgaaccountID = data.current_selected.account_id;
                            webPropertyID = data.current_selected.property_id;
                            profileID = data.current_selected.profile_id;
                            lrgaAccounts = data.all_accounts;
                            lrgaProfiles = data.all_profiles;
                            populateViews();
                            setup = false;
                        }
                    })
                }
            });

            $('#lrgawidget-accounts').on('change', function () {
                lrgaaccountID = this.value;
                webPropertyID = "";
                profileID = "";
                populateViews();
            });

            $('#lrgawidget-properties').on('change', function () {
                webPropertyID = this.value;
                profileID = "";
                populateViews();
            });

            $('#lrgawidget-profiles').on('change', function () {
                profileID = this.value;
                populateViews();
            });

            $('#lrgawidget-timezone-show-error').on('click', function (e) {
                e.preventDefault();
                $("#lrgawidget-timezone-error").toggle();
            });

            $('a[data-reload="lrgawidget_reload_tab"]').on('click', function (e) {
                e.preventDefault();
                reloadCurrentTab();
            });

            $('a[data-reload="lrgawidget_go_advanced"]').on('click', function (e) {
                e.preventDefault();
                $("#lrgawidget_express_setup").hide();
                $("#lrgawidget_advanced_setup").show();
                $("[data-reload='lrgawidget_go_express']").show();

            });

            $('[data-reload="lrgawidget_go_express"]').on('click', function (e) {
                e.preventDefault();
                $("#lrgawidget_error").html("").addClass("hidden");
                $("#lrgawidget_advanced_setup").hide();
                $("[data-reload='lrgawidget_go_express']").hide();
                $('#lrga-wizard').wizard('selectedItem', {step: 1});
                $("#lrgawidget_express_setup").show();
            });

        });


        var pieColors = ['#8a56e2', '#cf56e2', '#e256ae', '#e25668', '#e28956', '#e2cf56', '#aee256', '#68e256', '#56e289', '#56e2cf', '#56aee2', '#a6cee3'];
        pieColors.reverse();



        var pieObjects = {};

        function tooltipFunction(v, pieData, legendHeader) {
            var percent;
            var tip;
            $.each(pieData, function (i, obj) {
                if (v.value == obj.value) {
                    percent = obj.percent;
                    return false;
                }
            });
            if (percent) {
               // tip = legendHeader + " " + v.label + " - Sessions: " + v.value + " - " + percent + " %";
                tip = legendHeader + " " + v.label + " - " + percent + " %";
            } else {
                tip = legendHeader + " " + v.label + " - Clicks: " + v.value;
            }
            return tip;
        }

        function drawDPieChart(tabName, pieData, legendHeader, iconName, iconColor) {
            var chartName = "#lrgawidget_" + tabName + "_chartDiv";
            var legendName = "#lrgawidget_" + tabName + "_legendDiv";

            $(legendName).empty();
            if (pieObjects[tabName] != null && !$.isEmptyObject(pieObjects[tabName])) {
                pieObjects[tabName].destroy();
                pieObjects[tabName] = {};
            }

            if ($(chartName).is(":visible")) {
                var helpers = Chartv1.helpers;
                var options = {animateRotate: true,
                    animationSteps: 100,
                    segmentShowStroke: true,
                    animationEasing: 'easeInOutQuart',
                    middleIconName: iconName,
                    middleIconColor: iconColor,
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><i class=\"fa fa-circle-o fa-fw\" style=\"color:<%=segments[i].fillColor%>\"></i>  <%if(segments[i].label){%><%if(segments[i].label.length > 18){%><%=segments[i].label.substring(0, 18)%><%=\" ...\"%><%}else{%><%=segments[i].label%><%}%><%}%>   </li><%}%></ul>",
                    tooltipTemplate: function (v) {
                        return tooltipFunction(v, pieData, legendHeader);
                    }
                };
                var ctx = $(chartName).get(0).getContext("2d");

                var moduleDoughnut = new Chartv1(ctx).DoughnutWithMiddleIcon(pieData, options);

                pieObjects[tabName] = moduleDoughnut;

                var legendHolder = document.createElement('div');
                legendHolder.innerHTML = moduleDoughnut.generateLegend();
                helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
                    helpers.addEvent(legendNode, 'mouseover', function () {
                        var activeSegment = moduleDoughnut.segments[index];
                        activeSegment.save();
                        activeSegment.fillColor = activeSegment.highlightColor;
                        moduleDoughnut.showTooltip([activeSegment]);
                        activeSegment.restore();
                    });
                });
                helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
                    moduleDoughnut.draw();
                });

                $(legendName).append(legendHolder.firstChild);
            }

        }

        var browsersIcons = {"chrome": {"hex": "\uf268", "icon": "fa-chrome", "color": "#4587F3"},
            "firefox": {"hex": "\uf269", "icon": "fa-firefox", "color": "#e66000"},
            "safari": {"hex": "\uf267", "icon": "fa-safari", "color": "#1B88CA"},
            "safari (in-app)": {"hex": "\uf179", "icon": "fa-apple", "color": "#979797"},
            "internet explorer": {"hex": "\uf26b", "icon": "fa-internet-explorer", "color": "#1EBBEE"},
            "edge": {"hex": "\uf282", "icon": "fa-edge", "color": "#55acee"},
            "opera": {"hex": "\uf26a", "icon": "fa-opera", "color": "#cc0f16"},
            "opera mini": {"hex": "\uf26a", "icon": "fa-opera", "color": "#cc0f16"},
            "android browser": {"hex": "\uf17b", "icon": "fa-android", "color": "#a4c639"},
            "mozilla compatible agent": {"hex": "\uf136", "icon": "fa-maxcdn", "color": "#FF6600"},
            "default_icon": {"hex": "\uf022", "icon": "fa-list-alt", "color": "#1EBBEE"}
        };

        var osIcons = {"chrome os": {"hex": "\uf268", "icon": "fa-chrome", "color": "#4587F3"},
            "ios": {"hex": "\uf179", "icon": "fa-apple", "color": "#979797"},
            "windows": {"hex": "\uf17a", "icon": "fa-windows", "color": "#1EBBEE"},
            "linux": {"hex": "\uf17c", "icon": "fa-linux", "color": "#000000"},
            "macintosh": {"hex": "\uf179", "icon": "fa-apple", "color": "#979797"},
            "windows phone": {"hex": "\uf17a", "icon": "fa-windows", "color": "#1EBBEE"},
            "android": {"hex": "\uf17b", "icon": "fa-android", "color": "#a4c639"},
            "default_icon": {"hex": "\uf108", "icon": "fa-desktop", "color": "#1EBBEE"}
        };

        var devicesIcons = {"desktop": {"hex": "\uf108", "icon": "fa-desktop", "color": "#1EBBEE"},
            "mobile": {"hex": "\uf10b", "icon": "fa-mobile", "color": "#1EBBEE"},
            "tablet": {"hex": "\uf10a", "icon": "fa-tablet", "color": "#1EBBEE"},
            "default_icon": {"hex": "\uf108", "icon": "fa-desktop", "color": "#1EBBEE"}
        };

        var languagesIcons = {"default_icon": {"hex": "\uf031", "icon": "fa-font", "color": "#1EBBEE"}};
        var screenresIcons = {"default_icon": {"hex": "\uf0b2", "icon": "fa-arrows-alt", "color": "#1EBBEE"}};
        var pagesIcons = {"default_icon": {"hex": "\uf016", "icon": "fa-file-o", "color": "#1EBBEE"}};

        var dataTableDefaults = {"paging": true,
            "pagingType": "full",
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 7,
            "retrieve": true,
            "columnDefs": [{"width": "60%", "targets": 0}],
            "order": [[1, "desc"]]};

        function getIcon(name, icons) {
            var sname = name.toLowerCase();
            if (icons[sname]) {
                return {"hex": icons[sname]['hex'], "name": icons[sname]['icon'], "color": icons[sname]['color']};
            } else {
                return {"hex": icons['default_icon']['hex'], "name": icons['default_icon']['icon'], "color": icons['default_icon']['color']};
            }
        }

        function prepareTable(tableName, options) {
            var settings = $.extend({}, dataTableDefaults, options);
            var table = $(tableName).DataTable(settings);
            return table;
        }

        function prepareData(data, icons) {
            var pieData = [];
            var tableData = [];
            var combined = 0;
            var combinedPercent = 0;
            var lIndex = 0;

            $.each(data, function (i, row) {
                if ((typeof row === 'object') && (row)) {
                    var tableLabel = row[0];
                    var pieLabel = row[0];
                    var rawLabel = row[0];
                    if ($.isArray(row[0])) {
                        rawLabel = row[0][0];
                        tableLabel = row[0][1] + "<br><i class='fa fa-arrow-circle-right fa-lg fa-fw' style='color:#1EBBEE;'></i>&nbsp;&nbsp;<a href='//" + row[0][0] + "' target='_blank'>" + row[0][0] + "</a>";
                        pieLabel = row[0][1];
                    }
                    var icon = getIcon(pieLabel, icons);
                    if ((row[2] <= 1) || (i >= 11)) {
                        combined = combined + parseFloat(row[1]);
                        combinedPercent = combinedPercent + parseFloat(row[2]);
                    } else {
                        pieData[i] = {label: pieLabel, value: row[1], percent: row[2], color: pieColors[i]};
                    }

                    tableData[i] = [rawLabel, "<i class='fa " + icon.name + " fa-lg fa-fw' style='color:" + icon.color + ";'></i>&nbsp;&nbsp;" + tableLabel, row[1], row[2] + " %"];
                    lIndex = i;
                }
            });
            if (combined > 0) {
                pieData.push({label: "Others", value: combined, percent: parseFloat(Math.round(combinedPercent * 100) / 100).toFixed(2), color: pieColors[lIndex]});
            }
            return [tableData, pieData];
        }

        function drawTablePie(tabName, callName, icons) {
            var tableName = "#lrgawidget_" + tabName + "_dataTable";
            var pieData = [];
            var options = {"columnDefs": [{"targets": [0], "visible": false, "searchable": false}, {"width": "60%", "targets": 1}],
                "order": [[2, "desc"]]};

            var table = prepareTable(tableName, options);
            table.clear();
            console.log(callName);
            lrWidgetSettings({action: callName}).done(function (data, textStatus, jqXHR) {
                if (data.status == "done") {
                    console.log(data);
                    var processedData = prepareData(data, icons);
                    table.rows.add(processedData[0]);
                    table.draw();
                    drawDPieChart(tabName, processedData[1], "", icons['default_icon']['hex'], icons['default_icon']['color']);
                }
            });
            return table;
        }


        var mainChart;
        var mainChartDefaults = {"grid": {axisMargin: 20, hoverable: true, borderColor: "#f3f3f3", borderWidth: 1, tickColor: "#f3f3f3", mouseActiveRadius: 350},
            "series": {shadowSize: 1},
            "lines": {fill: true, color: ["#3c8dbc", "#f56954"]},
            "yaxes": [{min: 0}],
            "xaxis": {mode: "time", timeformat: "%b %d"},
            "colors": ["#3c8dbc"],
            "legend": {show: true, container: '#lrga-legendholder'}};

        var lastFlotIndex = null;
        var currentPlotData = {};

        function lrTickFormatter(val, axis) {
            if (Math.round(val) !== val) {
                val = val.toFixed(2);
            }
            return axis.options.lrcustom.before + val + " " + axis.options.lrcustom.after;
        }

        function lrLegendFormatter(label, series) {
            if (series.lrcustom.total >= 0) {
                return label + "</td><td class='legendEarnings'>" + series.lrcustom.before + series.lrcustom.total + " " + series.lrcustom.after + "</td><td>|</td><td class='legendSales'>" + series.lrcustom.totalorders;
            }
        }

        function drawGraph(data, name) {
            var settings = mainChartDefaults;
            var totalSales = 0;
            var totalEarnings = 0;
            var gData = [{data: data["data"], label: data["label"], lines: {show: true}, points: {show: true}, lrcustom: {before: data["lrbefore"], after: data["lrafter"], format: data["lrformat"]}}];
            $("#lrgawidget_sessions_chart_tooltip").remove();
            $("#lrgawidget_sessions_chartDiv").removeData("plot").empty();

            if (mainChart) {
                mainChart.shutdown();
                mainChart.destroy();
                mainChart = null;
                lastFlotIndex = null;
                currentPlotData = {};
            }

            mainChart = $.plot($("#lrgawidget_sessions_chartDiv"), gData, settings);
            currentPlotData = mainChart.getData();

            if ($('#lrga-legendholder').is(':empty')) {
                $("#lrga-legendholder").hide();
            } else {
                $("#lrga-legendholder").show();
            }

            if ((totalSales > 0 || totalEarnings > 0) && (graphData.settings.showtotal == "on")) {
                $("#lrga-legendholder table tr:last").after('<tr class="legendTotals"><td class="legendColorBox"></td><td class="legendLabel">Total</td><td class="legendEarnings">' + plotData["earnings"]["config"]["lrbefore"] + totalEarnings.toFixed(2) + plotData["earnings"]["config"]["lrafter"] + '</td><td>|</td><td class="legendSales">' + totalSales + '</td></tr>');
            }

            $('<div class="tooltip-inner" id="lrgawidget_sessions_chart_tooltip"></div>').css({
                "text-align": "left",
                "position": "absolute",
                "display": "none",
                "opacity": 0.8
            }).appendTo("body");

            $("#lrgawidget_sessions_chartDiv").bind("plothover", function (event, pos, item) {
                if (item) {
                    if ((lastFlotIndex != item.dataIndex)) {
                        lastFlotIndex = item.dataIndex;
                        if (debug) {
                            console.log(item);
                            console.log(currentPlotData);
                            console.log(lastFlotIndex);
                        }
                        var x = item.datapoint[0].toFixed(2);
                        var y = item.datapoint[1];
                        var rightMargin = "auto";
                        var leftMargin = "auto";
                        var formattedDateString = moment(item.datapoint[0]).format('ddd, MMMM D, YYYY');

                        var currToolTipText = formattedDateString + "<br>";
                        var totalorders = 0;
                        $.each(currentPlotData, function (i, dSeries) {
                            if (typeof dSeries.lrcustom !== 'undefined') {
                                var cItem = dSeries.data[item.dataIndex][1];
                                var tOrders = ((totalorders > 0) ? "| " + totalorders : "");
                                if (cItem > 0 || totalorders > 0) {
                                    if (dSeries.lrcustom.format == "seconds") {
                                        cItem = formatSeconds(cItem);
                                    }
                                    currToolTipText += '<div style="display: inline-block;padding:1px;"><div style="width:4px;height:0;border:4px solid ' + dSeries.color + ';overflow:hidden"></div></div><div style="display: inline-block;padding-left:5px;">' + dSeries.label + ' : ' + dSeries.lrcustom.before + cItem + " " + dSeries.lrcustom.after + tOrders + "</div><br>";
                                }
                            } else {
                                totalorders = dSeries.data[item.dataIndex][1];
                            }
                        });

                        if (item.pageX + 350 > $(document).width()) {
                            rightMargin = ($(document).width() - item.pageX) + 15;
                        } else {
                            leftMargin = item.pageX + 15;
                        }

                        $("#lrgawidget_sessions_chart_tooltip").html(currToolTipText)
                                .css({top: item.pageY - 25, left: leftMargin, right: rightMargin})
                                .show();
                    }
                } else {
                    lastFlotIndex = null;
                    $("#lrgawidget_sessions_chart_tooltip").hide();
                    $("#lrgawidget_sessions_chart_tooltip").empty();
                }
            });
        }

        function formatSeconds(totalSec) {
            var hours = Math.floor(totalSec / 3600);
            var minutes = Math.floor((totalSec - (hours * 3600)) / 60);
            var seconds = totalSec - (hours * 3600) - (minutes * 60);
            var fseconds = seconds.toFixed(0);
            var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (fseconds < 10 ? "0" + fseconds : fseconds);
            return result;
        }

        function drawSparkline(id, data, color) {
            if (!color) {
                color = '#b1d1e4';
            }
            $(id).sparkline(data.split(','), {
                type: 'line',
                lineColor: "#3c8dbc",
                fillColor: color,
                spotColor: "#3c8dbc",
                minSpotColor: "#3c8dbc",
                maxSpotColor: "#3c8dbc",
                drawNormalOnTop: false,
                disableTooltips: true,
                disableInteraction: true,
                width: "100px"
            });
        }

        var plotData = {};
        var plotTotalData = {};
        var selectedPname = "";

        function drawMainGraphWidgets(data, selected) {
            if ($('#lrgawidget_sb-main').is(":visible")) {
                $.each(data, function (name, raw) {
                    var appnd = "";
                    var color = "";
                    if ((name == "percentNewSessions") || (name == "bounceRate")) {
                        appnd = " %";
                    }
                    if (name == selected) {
                        color = "#77b2d4";
                    }
                    $("#lrgawidget_sb_" + name + " .description-header").html(raw['total'] + appnd);
                    drawSparkline("#lrgawidget_spline_" + name, raw['data'], color);
                });
            }
        }

        function drawMainGraph() {
            lrWidgetSettings({action: "getSessions"}).done(function (data, textStatus, jqXHR) {
                if (data.status == "done" && data.setup !== 1) {
                    plotData = data.plotdata;
                    plotTotalData = data.totalsForAllResults;
                    if (!selectedPname) {
                        selectedPname = "sessions";
                    }
                    drawGraph(plotData[selectedPname], selectedPname);
                    drawMainGraphWidgets(plotTotalData);
                    $("#lrgawidget_sb_" + selectedPname).addClass("selected");
                }
            });
        }


        $(document).ready(function () {

            dateRange = {start: moment().subtract(29, 'days').format('YYYY-MM-DD'), end: moment().format('YYYY-MM-DD')};

            $('#lrgawidget_reportrange').html(moment(dateRange.start).format('MMMM D, YYYY') + ' - ' + moment(dateRange.end).format('MMMM D, YYYY'));
            $("[data-lrgawidget-reset]").on('click', function () {
                if (confirm("All saved authentication data will be removed.\nDo you want to continue ?!") == true) {
                    lrWidgetSettings({action: "settingsReset"}).done(function (data, textStatus, jqXHR) {
                        if (data.status == "done") {
                            $('#lrga-wizard').wizard('selectedItem', {step: 1});
                            $("[data-lrgawidget-reset]").hide();
                        }
                    });
                }
            });

            $("#lrgawidget_main a[data-toggle='tab']").on('shown.bs.tab', function (e) {

                $("#lrgawidget_sessions_chart_tooltip").remove();

                if (this.hash == "#lrgawidget_settings_tab") {
                    if (!setup) {
                        $('#lrga-wizard').wizard('selectedItem', {step: "lrga-profile"});
                        $("#lrga-wizard .steps li").removeClass("complete");
                        $("[data-lrgawidget-reset]").show();
                    }
                } else if (this.hash == "#lrgawidget_sessions_tab") {
                    drawMainGraph();
                } else if (this.hash == "#lrgawidget_browsers_tab") {

                    browsersTable = drawTablePie("browsers", "getBrowsers", browsersIcons);

                } else if (this.hash == "#lrgawidget_languages_tab") {

                    languagesTable = drawTablePie("languages", "getLanguages", languagesIcons);

                } else if (this.hash == "#lrgawidget_os_tab") {

                    osTable = drawTablePie("os", "getOS", osIcons);

                } else if (this.hash == "#lrgawidget_devices_tab") {

                    devicesTable = drawTablePie("devices", "getDevices", devicesIcons);

                } else if (this.hash == "#lrgawidget_screenres_tab") {

                    screenresTable = drawTablePie("screenres", "getScreenResolution", screenresIcons);
                } else if (this.hash == "#lrgawidget_pages_tab") {

                    pagesTable = drawTablePie("pages", "getPages", pagesIcons);
                }


            });

            $("#lrgawidget_browsers_dataTable tbody, #lrgawidget_os_dataTable tbody, #lrgawidget_devices_dataTable tbody").on('click', 'tr', function (e) {
                e.preventDefault();
                $('#lrgawidget a[data-target="#lrgawidget_gopro_tab"]').tab('show');
            });

            $("#lrgawidget_daterange_label").on('click', function (e) {
                e.preventDefault();
                $('#lrgawidget a[data-target="#lrgawidget_gopro_tab"]').tab('show');

            });

            $("[data-lrgawidget-plot]").on('click', function (e) {
                e.preventDefault();
                selectedPname = $(this).data('lrgawidget-plot');
                $("[data-lrgawidget-plot]").removeClass("selected");
                drawGraph(plotData[selectedPname], selectedPname);
                $(this).addClass("selected");
            });

            $('body').on('click', '#lrgawidget_panel_hide', function (e) {
                var wstatevalue = "";
                if ($(this).is(":checked")) {
                    $("#lrgawidget").show();
                    wstatevalue = "show";
                } else {
                    $("#lrgawidget").hide();
                    wstatevalue = "hide";
                }
                lrWidgetSettings({action: "hideShowWidget", wstate: wstatevalue}).done(function (data, textStatus, jqXHR) {});
            });

            $(".wrap:eq(1)").children("h1:first").remove();
            $("#adv-settings fieldset").append('<label for="lrgawidget_panel_hide"><input id="lrgawidget_panel_hide" type="checkbox" checked="checked">Lara, Google Analytics Dashboard Widget</label>');
            $("#lrgawidget_remove").on('click', function (e) {
                e.preventDefault();
                $("#lrgawidget_panel_hide").click();
            });
            $(".daterangepicker").removeClass("daterangepicker dropdown-menu opensleft").addClass("lrga_bs daterangepicker custom-dropdown-menu opensleft");
            $('[data-toggle="lrgawidget_tooltip"]').tooltip();
            if (typeof actLrgaTabs !== 'undefined') {
                $("#lrgawidget a[data-target='#" + actLrgaTabs + "']").tab('show');
            }

            $(".lrgawidget_view_demo").colorbox({iframe: true, innerWidth: "80%", innerHeight: 575, scrolling: false});
        });



    })(jQuery);

})(jQuery);