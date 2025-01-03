import {
  __commonJS
} from "./chunk-PLDDJCW6.js";

// node_modules/@yaireo/tagify/dist/tagify.min.js
var require_tagify_min = __commonJS({
  "node_modules/@yaireo/tagify/dist/tagify.min.js"(exports, module) {
    !function(t, e) {
      "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : (t = "undefined" != typeof globalThis ? globalThis : t || self).Tagify = e();
    }(exports, function() {
      "use strict";
      function t(t2, e2) {
        var i2 = Object.keys(t2);
        if (Object.getOwnPropertySymbols) {
          var s2 = Object.getOwnPropertySymbols(t2);
          e2 && (s2 = s2.filter(function(e3) {
            return Object.getOwnPropertyDescriptor(t2, e3).enumerable;
          })), i2.push.apply(i2, s2);
        }
        return i2;
      }
      function e(e2) {
        for (var s2 = 1; s2 < arguments.length; s2++) {
          var a2 = null != arguments[s2] ? arguments[s2] : {};
          s2 % 2 ? t(Object(a2), true).forEach(function(t2) {
            i(e2, t2, a2[t2]);
          }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e2, Object.getOwnPropertyDescriptors(a2)) : t(Object(a2)).forEach(function(t2) {
            Object.defineProperty(e2, t2, Object.getOwnPropertyDescriptor(a2, t2));
          });
        }
        return e2;
      }
      function i(t2, e2, i2) {
        return (e2 = function(t3) {
          var e3 = function(t4, e4) {
            if ("object" != typeof t4 || null === t4) return t4;
            var i3 = t4[Symbol.toPrimitive];
            if (void 0 !== i3) {
              var s2 = i3.call(t4, e4 || "default");
              if ("object" != typeof s2) return s2;
              throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return ("string" === e4 ? String : Number)(t4);
          }(t3, "string");
          return "symbol" == typeof e3 ? e3 : String(e3);
        }(e2)) in t2 ? Object.defineProperty(t2, e2, { value: i2, enumerable: true, configurable: true, writable: true }) : t2[e2] = i2, t2;
      }
      const s = (t2, e2, i2, s2) => (t2 = "" + t2, e2 = "" + e2, s2 && (t2 = t2.trim(), e2 = e2.trim()), i2 ? t2 == e2 : t2.toLowerCase() == e2.toLowerCase()), a = (t2, e2) => t2 && Array.isArray(t2) && t2.map((t3) => n(t3, e2));
      function n(t2, e2) {
        var i2, s2 = {};
        for (i2 in t2) e2.indexOf(i2) < 0 && (s2[i2] = t2[i2]);
        return s2;
      }
      function o(t2) {
        var e2 = document.createElement("div");
        return t2.replace(/\&#?[0-9a-z]+;/gi, function(t3) {
          return e2.innerHTML = t3, e2.innerText;
        });
      }
      function r(t2) {
        return new DOMParser().parseFromString(t2.trim(), "text/html").body.firstElementChild;
      }
      function l(t2, e2) {
        for (e2 = e2 || "previous"; t2 = t2[e2 + "Sibling"]; ) if (3 == t2.nodeType) return t2;
      }
      function d(t2) {
        return "string" == typeof t2 ? t2.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/`|'/g, "&#039;") : t2;
      }
      function h(t2) {
        var e2 = Object.prototype.toString.call(t2).split(" ")[1].slice(0, -1);
        return t2 === Object(t2) && "Array" != e2 && "Function" != e2 && "RegExp" != e2 && "HTMLUnknownElement" != e2;
      }
      function g(t2, e2, i2) {
        function s2(t3, e3) {
          for (var i3 in e3) if (e3.hasOwnProperty(i3)) {
            if (h(e3[i3])) {
              h(t3[i3]) ? s2(t3[i3], e3[i3]) : t3[i3] = Object.assign({}, e3[i3]);
              continue;
            }
            if (Array.isArray(e3[i3])) {
              t3[i3] = Object.assign([], e3[i3]);
              continue;
            }
            t3[i3] = e3[i3];
          }
        }
        return t2 instanceof Object || (t2 = {}), s2(t2, e2), i2 && s2(t2, i2), t2;
      }
      function p() {
        const t2 = [], e2 = {};
        for (let i2 of arguments) for (let s2 of i2) h(s2) ? e2[s2.value] || (t2.push(s2), e2[s2.value] = 1) : t2.includes(s2) || t2.push(s2);
        return t2;
      }
      function c(t2) {
        return String.prototype.normalize ? "string" == typeof t2 ? t2.normalize("NFD").replace(/[\u0300-\u036f]/g, "") : void 0 : t2;
      }
      var u = () => /(?=.*chrome)(?=.*android)/i.test(navigator.userAgent);
      function m() {
        return ("10000000-1000-4000-8000" + -1e11).replace(/[018]/g, (t2) => (t2 ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> t2 / 4).toString(16));
      }
      function v(t2) {
        return t2 && t2.classList && t2.classList.contains(this.settings.classNames.tag);
      }
      function f(t2, e2) {
        var i2 = window.getSelection();
        return e2 = e2 || i2.getRangeAt(0), "string" == typeof t2 && (t2 = document.createTextNode(t2)), e2 && (e2.deleteContents(), e2.insertNode(t2)), t2;
      }
      function T(t2, e2, i2) {
        return t2 ? (e2 && (t2.__tagifyTagData = i2 ? e2 : g({}, t2.__tagifyTagData || {}, e2)), t2.__tagifyTagData) : (console.warn("tag element doesn't exist", t2, e2), e2);
      }
      function w(t2) {
        if (t2 && t2.parentNode) {
          var e2 = t2, i2 = window.getSelection(), s2 = i2.getRangeAt(0);
          i2.rangeCount && (s2.setStartAfter(e2), s2.collapse(true), i2.removeAllRanges(), i2.addRange(s2));
        }
      }
      function b(t2, e2) {
        t2.forEach((t3) => {
          if (T(t3.previousSibling) || !t3.previousSibling) {
            var i2 = document.createTextNode("​");
            t3.before(i2), e2 && w(i2);
          }
        });
      }
      var y = { delimiters: ",", pattern: null, tagTextProp: "value", maxTags: 1 / 0, callbacks: {}, addTagOnBlur: true, addTagOn: ["blur", "tab", "enter"], onChangeAfterBlur: true, duplicates: false, whitelist: [], blacklist: [], enforceWhitelist: false, userInput: true, keepInvalidTags: false, createInvalidTags: true, mixTagsAllowedAfter: /,|\.|\:|\s/, mixTagsInterpolator: ["[[", "]]"], backspace: true, skipInvalid: false, pasteAsTags: true, editTags: { clicks: 2, keepInvalid: true }, transformTag: () => {
      }, trim: true, a11y: { focusableTags: false }, mixMode: { insertAfterTag: " " }, autoComplete: { enabled: true, rightKey: false, tabKey: false }, classNames: { namespace: "tagify", mixMode: "tagify--mix", selectMode: "tagify--select", input: "tagify__input", focus: "tagify--focus", tagNoAnimation: "tagify--noAnim", tagInvalid: "tagify--invalid", tagNotAllowed: "tagify--notAllowed", scopeLoading: "tagify--loading", hasMaxTags: "tagify--hasMaxTags", hasNoTags: "tagify--noTags", empty: "tagify--empty", inputInvalid: "tagify__input--invalid", dropdown: "tagify__dropdown", dropdownWrapper: "tagify__dropdown__wrapper", dropdownHeader: "tagify__dropdown__header", dropdownFooter: "tagify__dropdown__footer", dropdownItem: "tagify__dropdown__item", dropdownItemActive: "tagify__dropdown__item--active", dropdownItemHidden: "tagify__dropdown__item--hidden", dropdownInital: "tagify__dropdown--initial", tag: "tagify__tag", tagText: "tagify__tag-text", tagX: "tagify__tag__removeBtn", tagLoading: "tagify__tag--loading", tagEditing: "tagify__tag--editable", tagFlash: "tagify__tag--flash", tagHide: "tagify__tag--hide" }, dropdown: { classname: "", enabled: 2, maxItems: 10, searchKeys: ["value", "searchBy"], fuzzySearch: true, caseSensitive: false, accentedSearch: true, includeSelectedTags: false, escapeHTML: true, highlightFirst: false, closeOnSelect: true, clearOnSelect: true, position: "all", appendTarget: null }, hooks: { beforeRemoveTag: () => Promise.resolve(), beforePaste: () => Promise.resolve(), suggestionClick: () => Promise.resolve(), beforeKeyDown: () => Promise.resolve() } };
      function x() {
        this.dropdown = {};
        for (let t2 in this._dropdown) this.dropdown[t2] = "function" == typeof this._dropdown[t2] ? this._dropdown[t2].bind(this) : this._dropdown[t2];
        this.dropdown.refs();
      }
      var O = { refs() {
        this.DOM.dropdown = this.parseTemplate("dropdown", [this.settings]), this.DOM.dropdown.content = this.DOM.dropdown.querySelector("[data-selector='tagify-suggestions-wrapper']");
      }, getHeaderRef() {
        return this.DOM.dropdown.querySelector("[data-selector='tagify-suggestions-header']");
      }, getFooterRef() {
        return this.DOM.dropdown.querySelector("[data-selector='tagify-suggestions-footer']");
      }, getAllSuggestionsRefs() {
        return [...this.DOM.dropdown.content.querySelectorAll(this.settings.classNames.dropdownItemSelector)];
      }, show(t2) {
        var e2, i2, a2, n2 = this.settings, o2 = "mix" == n2.mode && !n2.enforceWhitelist, r2 = !n2.whitelist || !n2.whitelist.length, l2 = "manual" == n2.dropdown.position;
        if (t2 = void 0 === t2 ? this.state.inputText : t2, !(r2 && !o2 && !n2.templates.dropdownItemNoMatch || false === n2.dropdown.enable || this.state.isLoading || this.settings.readonly)) {
          if (clearTimeout(this.dropdownHide__bindEventsTimeout), this.suggestedListItems = this.dropdown.filterListItems(t2), t2 && !this.suggestedListItems.length && (this.trigger("dropdown:noMatch", t2), n2.templates.dropdownItemNoMatch && (a2 = n2.templates.dropdownItemNoMatch.call(this, { value: t2 }))), !a2) {
            if (this.suggestedListItems.length) t2 && o2 && !this.state.editing.scope && !s(this.suggestedListItems[0].value, t2) && this.suggestedListItems.unshift({ value: t2 });
            else {
              if (!t2 || !o2 || this.state.editing.scope) return this.input.autocomplete.suggest.call(this), void this.dropdown.hide();
              this.suggestedListItems = [{ value: t2 }];
            }
            i2 = "" + (h(e2 = this.suggestedListItems[0]) ? e2.value : e2), n2.autoComplete && i2 && 0 == i2.indexOf(t2) && this.input.autocomplete.suggest.call(this, e2);
          }
          this.dropdown.fill(a2), n2.dropdown.highlightFirst && this.dropdown.highlightOption(this.DOM.dropdown.content.querySelector(n2.classNames.dropdownItemSelector)), this.state.dropdown.visible || setTimeout(this.dropdown.events.binding.bind(this)), this.state.dropdown.visible = t2 || true, this.state.dropdown.query = t2, this.setStateSelection(), l2 || setTimeout(() => {
            this.dropdown.position(), this.dropdown.render();
          }), setTimeout(() => {
            this.trigger("dropdown:show", this.DOM.dropdown);
          });
        }
      }, hide(t2) {
        var e2 = this.DOM, i2 = e2.scope, s2 = e2.dropdown, a2 = "manual" == this.settings.dropdown.position && !t2;
        if (s2 && document.body.contains(s2) && !a2) return window.removeEventListener("resize", this.dropdown.position), this.dropdown.events.binding.call(this, false), i2.setAttribute("aria-expanded", false), s2.parentNode.removeChild(s2), setTimeout(() => {
          this.state.dropdown.visible = false;
        }, 100), this.state.dropdown.query = this.state.ddItemData = this.state.ddItemElm = this.state.selection = null, this.state.tag && this.state.tag.value.length && (this.state.flaggedTags[this.state.tag.baseOffset] = this.state.tag), this.trigger("dropdown:hide", s2), this;
      }, toggle(t2) {
        this.dropdown[this.state.dropdown.visible && !t2 ? "hide" : "show"]();
      }, render() {
        var t2, e2, i2, s2 = (t2 = this.DOM.dropdown, (i2 = t2.cloneNode(true)).style.cssText = "position:fixed; top:-9999px; opacity:0", document.body.appendChild(i2), e2 = i2.clientHeight, i2.parentNode.removeChild(i2), e2), a2 = this.settings;
        return "number" == typeof a2.dropdown.enabled && a2.dropdown.enabled >= 0 ? (this.DOM.scope.setAttribute("aria-expanded", true), document.body.contains(this.DOM.dropdown) || (this.DOM.dropdown.classList.add(a2.classNames.dropdownInital), this.dropdown.position(s2), a2.dropdown.appendTarget.appendChild(this.DOM.dropdown), setTimeout(() => this.DOM.dropdown.classList.remove(a2.classNames.dropdownInital))), this) : this;
      }, fill(t2) {
        t2 = "string" == typeof t2 ? t2 : this.dropdown.createListHTML(t2 || this.suggestedListItems);
        var e2, i2 = this.settings.templates.dropdownContent.call(this, t2);
        this.DOM.dropdown.content.innerHTML = (e2 = i2) ? e2.replace(/\>[\r\n ]+\</g, "><").split(/>\s+</).join("><").trim() : "";
      }, fillHeaderFooter() {
        var t2 = this.dropdown.filterListItems(this.state.dropdown.query), e2 = this.parseTemplate("dropdownHeader", [t2]), i2 = this.parseTemplate("dropdownFooter", [t2]), s2 = this.dropdown.getHeaderRef(), a2 = this.dropdown.getFooterRef();
        e2 && (s2 == null ? void 0 : s2.parentNode.replaceChild(e2, s2)), i2 && (a2 == null ? void 0 : a2.parentNode.replaceChild(i2, a2));
      }, refilter(t2) {
        t2 = t2 || this.state.dropdown.query || "", this.suggestedListItems = this.dropdown.filterListItems(t2), this.dropdown.fill(), this.suggestedListItems.length || this.dropdown.hide(), this.trigger("dropdown:updated", this.DOM.dropdown);
      }, position(t2) {
        var e2 = this.settings.dropdown;
        if ("manual" != e2.position) {
          var i2, s2, a2, n2, o2, r2, l2, d2, h2, g2 = this.DOM.dropdown, p2 = e2.RTL, c2 = e2.appendTarget === document.body, u2 = c2 ? window.pageYOffset : e2.appendTarget.scrollTop, m2 = document.fullscreenElement || document.webkitFullscreenElement || document.documentElement, v2 = m2.clientHeight, f2 = Math.max(m2.clientWidth || 0, window.innerWidth || 0) > 480 ? e2.position : "all", T2 = this.DOM["input" == f2 ? "input" : "scope"];
          if (t2 = t2 || g2.clientHeight, this.state.dropdown.visible) {
            if ("text" == f2 ? (a2 = (i2 = function() {
              const t3 = document.getSelection();
              if (t3.rangeCount) {
                const e3 = t3.getRangeAt(0), i3 = e3.startContainer, s3 = e3.startOffset;
                let a3, n3;
                if (s3 > 0) return n3 = document.createRange(), n3.setStart(i3, s3 - 1), n3.setEnd(i3, s3), a3 = n3.getBoundingClientRect(), { left: a3.right, top: a3.top, bottom: a3.bottom };
                if (i3.getBoundingClientRect) return i3.getBoundingClientRect();
              }
              return { left: -9999, top: -9999 };
            }()).bottom, s2 = i2.top, n2 = i2.left, o2 = "auto") : (r2 = function(t3) {
              for (var e3 = 0, i3 = 0; t3 && t3 != m2; ) e3 += t3.offsetTop || 0, i3 += t3.offsetLeft || 0, t3 = t3.parentNode;
              return { top: e3, left: i3 };
            }(e2.appendTarget), s2 = (i2 = T2.getBoundingClientRect()).top - r2.top, a2 = i2.bottom - 1 - r2.top, n2 = i2.left - r2.left, o2 = i2.width + "px"), !c2) {
              let t3 = function() {
                for (var t4 = 0, i3 = e2.appendTarget.parentNode; i3; ) t4 += i3.scrollTop || 0, i3 = i3.parentNode;
                return t4;
              }();
              s2 += t3, a2 += t3;
            }
            s2 = Math.floor(s2), a2 = Math.ceil(a2), d2 = ((l2 = e2.placeAbove ?? v2 - i2.bottom < t2) ? s2 : a2) + u2, h2 = `left: ${n2 + (p2 && i2.width || 0) + window.pageXOffset}px;`, g2.style.cssText = `${h2}; top: ${d2}px; min-width: ${o2}; max-width: ${o2}`, g2.setAttribute("placement", l2 ? "top" : "bottom"), g2.setAttribute("position", f2);
          }
        }
      }, events: { binding() {
        let t2 = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];
        var e2 = this.dropdown.events.callbacks, i2 = this.listeners.dropdown = this.listeners.dropdown || { position: this.dropdown.position.bind(this, null), onKeyDown: e2.onKeyDown.bind(this), onMouseOver: e2.onMouseOver.bind(this), onMouseLeave: e2.onMouseLeave.bind(this), onClick: e2.onClick.bind(this), onScroll: e2.onScroll.bind(this) }, s2 = t2 ? "addEventListener" : "removeEventListener";
        "manual" != this.settings.dropdown.position && (document[s2]("scroll", i2.position, true), window[s2]("resize", i2.position), window[s2]("keydown", i2.onKeyDown)), this.DOM.dropdown[s2]("mouseover", i2.onMouseOver), this.DOM.dropdown[s2]("mouseleave", i2.onMouseLeave), this.DOM.dropdown[s2]("mousedown", i2.onClick), this.DOM.dropdown.content[s2]("scroll", i2.onScroll);
      }, callbacks: { onKeyDown(t2) {
        if (this.state.hasFocus && !this.state.composing) {
          var e2 = this.settings, i2 = this.DOM.dropdown.querySelector(e2.classNames.dropdownItemActiveSelector), s2 = this.dropdown.getSuggestionDataByNode(i2), a2 = "mix" == e2.mode;
          e2.hooks.beforeKeyDown(t2, { tagify: this }).then((n2) => {
            switch (t2.key) {
              case "ArrowDown":
              case "ArrowUp":
              case "Down":
              case "Up":
                t2.preventDefault();
                var o2 = this.dropdown.getAllSuggestionsRefs(), r2 = "ArrowUp" == t2.key || "Up" == t2.key;
                i2 && (i2 = this.dropdown.getNextOrPrevOption(i2, !r2)), i2 && i2.matches(e2.classNames.dropdownItemSelector) || (i2 = o2[r2 ? o2.length - 1 : 0]), this.dropdown.highlightOption(i2, true);
                break;
              case "Escape":
              case "Esc":
                this.dropdown.hide();
                break;
              case "ArrowRight":
                if (this.state.actions.ArrowLeft) return;
              case "Tab": {
                let n3 = !e2.autoComplete.rightKey || !e2.autoComplete.tabKey;
                if (!a2 && i2 && n3 && !this.state.editing) {
                  t2.preventDefault();
                  var l2 = this.dropdown.getMappedValue(s2);
                  return this.input.autocomplete.set.call(this, l2), false;
                }
                return true;
              }
              case "Enter":
                t2.preventDefault(), e2.hooks.suggestionClick(t2, { tagify: this, tagData: s2, suggestionElm: i2 }).then(() => {
                  if (i2) return this.dropdown.selectOption(i2), i2 = this.dropdown.getNextOrPrevOption(i2, !r2), void this.dropdown.highlightOption(i2);
                  this.dropdown.hide(), a2 || this.addTags(this.state.inputText.trim(), true);
                }).catch((t3) => t3);
                break;
              case "Backspace": {
                if (a2 || this.state.editing.scope) return;
                const t3 = this.input.raw.call(this);
                "" != t3 && 8203 != t3.charCodeAt(0) || (true === e2.backspace ? this.removeTags() : "edit" == e2.backspace && setTimeout(this.editTag.bind(this), 0));
              }
            }
          });
        }
      }, onMouseOver(t2) {
        var e2 = t2.target.closest(this.settings.classNames.dropdownItemSelector);
        this.dropdown.highlightOption(e2);
      }, onMouseLeave(t2) {
        this.dropdown.highlightOption();
      }, onClick(t2) {
        if (0 == t2.button && t2.target != this.DOM.dropdown && t2.target != this.DOM.dropdown.content) {
          var e2 = t2.target.closest(this.settings.classNames.dropdownItemSelector), i2 = this.dropdown.getSuggestionDataByNode(e2);
          this.state.actions.selectOption = true, setTimeout(() => this.state.actions.selectOption = false, 50), this.settings.hooks.suggestionClick(t2, { tagify: this, tagData: i2, suggestionElm: e2 }).then(() => {
            e2 ? this.dropdown.selectOption(e2, t2) : this.dropdown.hide();
          }).catch((t3) => console.warn(t3));
        }
      }, onScroll(t2) {
        var e2 = t2.target, i2 = e2.scrollTop / (e2.scrollHeight - e2.parentNode.clientHeight) * 100;
        this.trigger("dropdown:scroll", { percentage: Math.round(i2) });
      } } }, getSuggestionDataByNode(t2) {
        var e2 = t2 && t2.getAttribute("value");
        return this.suggestedListItems.find((t3) => t3.value == e2) || null;
      }, getNextOrPrevOption(t2) {
        let e2 = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
        var i2 = this.dropdown.getAllSuggestionsRefs(), s2 = i2.findIndex((e3) => e3 === t2);
        return e2 ? i2[s2 + 1] : i2[s2 - 1];
      }, highlightOption(t2, e2) {
        var i2, s2 = this.settings.classNames.dropdownItemActive;
        if (this.state.ddItemElm && (this.state.ddItemElm.classList.remove(s2), this.state.ddItemElm.removeAttribute("aria-selected")), !t2) return this.state.ddItemData = null, this.state.ddItemElm = null, void this.input.autocomplete.suggest.call(this);
        i2 = this.dropdown.getSuggestionDataByNode(t2), this.state.ddItemData = i2, this.state.ddItemElm = t2, t2.classList.add(s2), t2.setAttribute("aria-selected", true), e2 && (t2.parentNode.scrollTop = t2.clientHeight + t2.offsetTop - t2.parentNode.clientHeight), this.settings.autoComplete && (this.input.autocomplete.suggest.call(this, i2), this.dropdown.position());
      }, selectOption(t2, e2) {
        var i2 = this.settings, s2 = i2.dropdown, a2 = s2.clearOnSelect, n2 = s2.closeOnSelect;
        if (!t2) return this.addTags(this.state.inputText, true), void (n2 && this.dropdown.hide());
        e2 = e2 || {};
        var o2 = t2.getAttribute("value"), r2 = "noMatch" == o2, l2 = this.suggestedListItems.find((t3) => (t3.value ?? t3) == o2);
        if (this.trigger("dropdown:select", { data: l2, elm: t2, event: e2 }), o2 && (l2 || r2)) {
          if (this.state.editing) {
            let t3 = this.normalizeTags([l2])[0];
            l2 = i2.transformTag.call(this, t3) || t3, this.onEditTagDone(null, g({ __isValid: true }, l2));
          } else this["mix" == i2.mode ? "addMixTags" : "addTags"]([l2 || this.input.raw.call(this)], a2);
          this.DOM.input.parentNode && (setTimeout(() => {
            this.DOM.input.focus(), this.toggleFocusClass(true);
          }), n2 && setTimeout(this.dropdown.hide.bind(this)), t2.addEventListener("transitionend", () => {
            this.dropdown.fillHeaderFooter(), setTimeout(() => t2.remove(), 100);
          }, { once: true }), t2.classList.add(this.settings.classNames.dropdownItemHidden));
        } else n2 && setTimeout(this.dropdown.hide.bind(this));
      }, selectAll(t2) {
        this.suggestedListItems.length = 0, this.dropdown.hide(), this.dropdown.filterListItems("");
        var e2 = this.dropdown.filterListItems("");
        return t2 || (e2 = this.state.dropdown.suggestions), this.addTags(e2, true), this;
      }, filterListItems(t2, e2) {
        var i2, s2, a2, n2, o2, r2 = this.settings, l2 = r2.dropdown, d2 = (e2 = e2 || {}, []), g2 = [], p2 = r2.whitelist, u2 = l2.maxItems >= 0 ? l2.maxItems : 1 / 0, m2 = l2.searchKeys, v2 = 0;
        if (!(t2 = "select" == r2.mode && this.value.length && this.value[0][r2.tagTextProp] == t2 ? "" : t2) || !m2.length) return d2 = l2.includeSelectedTags ? p2 : p2.filter((t3) => !this.isTagDuplicate(h(t3) ? t3.value : t3)), this.state.dropdown.suggestions = d2, d2.slice(0, u2);
        function f2(t3, e3) {
          return e3.toLowerCase().split(" ").every((e4) => t3.includes(e4.toLowerCase()));
        }
        for (o2 = l2.caseSensitive ? "" + t2 : ("" + t2).toLowerCase(); v2 < p2.length; v2++) {
          let t3, r3;
          i2 = p2[v2] instanceof Object ? p2[v2] : { value: p2[v2] };
          let u3 = !Object.keys(i2).some((t4) => m2.includes(t4)) ? ["value"] : m2;
          l2.fuzzySearch && !e2.exact ? (a2 = u3.reduce((t4, e3) => t4 + " " + (i2[e3] || ""), "").toLowerCase().trim(), l2.accentedSearch && (a2 = c(a2), o2 = c(o2)), t3 = 0 == a2.indexOf(o2), r3 = a2 === o2, s2 = f2(a2, o2)) : (t3 = true, s2 = u3.some((t4) => {
            var s3 = "" + (i2[t4] || "");
            return l2.accentedSearch && (s3 = c(s3), o2 = c(o2)), l2.caseSensitive || (s3 = s3.toLowerCase()), r3 = s3 === o2, e2.exact ? s3 === o2 : 0 == s3.indexOf(o2);
          })), n2 = !l2.includeSelectedTags && this.isTagDuplicate(h(i2) ? i2.value : i2), s2 && !n2 && (r3 && t3 ? g2.push(i2) : "startsWith" == l2.sortby && t3 ? d2.unshift(i2) : d2.push(i2));
        }
        return this.state.dropdown.suggestions = g2.concat(d2), "function" == typeof l2.sortby ? l2.sortby(g2.concat(d2), o2) : g2.concat(d2).slice(0, u2);
      }, getMappedValue(t2) {
        var e2 = this.settings.dropdown.mapValueTo;
        return e2 ? "function" == typeof e2 ? e2(t2) : t2[e2] || t2.value : t2.value;
      }, createListHTML(t2) {
        return g([], t2).map((t3, i2) => {
          "string" != typeof t3 && "number" != typeof t3 || (t3 = { value: t3 });
          var s2 = this.dropdown.getMappedValue(t3);
          return s2 = "string" == typeof s2 && this.settings.dropdown.escapeHTML ? d(s2) : s2, this.settings.templates.dropdownItem.apply(this, [e(e({}, t3), {}, { mappedValue: s2 }), this]);
        }).join("");
      } };
      const D = "@yaireo/tagify/";
      var M, I = { empty: "empty", exceed: "number of tags exceeded", pattern: "pattern mismatch", duplicate: "already exists", notAllowed: "not allowed" }, N = { wrapper: (t2, e2) => `<tags class="${e2.classNames.namespace} ${e2.mode ? `${e2.classNames[e2.mode + "Mode"]}` : ""} ${t2.className}"
                    ${e2.readonly ? "readonly" : ""}
                    ${e2.disabled ? "disabled" : ""}
                    ${e2.required ? "required" : ""}
                    ${"select" === e2.mode ? "spellcheck='false'" : ""}
                    tabIndex="-1">
            <span ${!e2.readonly && e2.userInput ? "contenteditable" : ""} tabIndex="0" data-placeholder="${e2.placeholder || "&#8203;"}" aria-placeholder="${e2.placeholder || ""}"
                class="${e2.classNames.input}"
                role="textbox"
                aria-autocomplete="both"
                aria-multiline="${"mix" == e2.mode}"></span>
                &#8203;
        </tags>`, tag(t2, e2) {
        let i2 = e2.settings;
        return `<tag title="${t2.title || t2.value}"
                    contenteditable='false'
                    spellcheck='false'
                    tabIndex="${i2.a11y.focusableTags ? 0 : -1}"
                    class="${i2.classNames.tag} ${t2.class || ""}"
                    ${this.getAttributes(t2)}>
            <x title='' class="${i2.classNames.tagX}" role='button' aria-label='remove tag'></x>
            <div>
                <span class="${i2.classNames.tagText}">${t2[i2.tagTextProp] || t2.value}</span>
            </div>
        </tag>`;
      }, dropdown(t2) {
        var e2 = t2.dropdown;
        return `<div class="${"manual" == e2.position ? "" : t2.classNames.dropdown} ${e2.classname}" role="listbox" aria-labelledby="dropdown" dir="${e2.RTL ? "rtl" : ""}">
                    <div data-selector='tagify-suggestions-wrapper' class="${t2.classNames.dropdownWrapper}"></div>
                </div>`;
      }, dropdownContent(t2) {
        var e2 = this.settings.templates, i2 = this.state.dropdown.suggestions;
        return `
            ${e2.dropdownHeader.call(this, i2)}
            ${t2}
            ${e2.dropdownFooter.call(this, i2)}
        `;
      }, dropdownItem(t2) {
        return `<div ${this.getAttributes(t2)}
                    class='${this.settings.classNames.dropdownItem} ${t2.class || ""}'
                    tabindex="0"
                    role="option">${t2.mappedValue || t2.value}</div>`;
      }, dropdownHeader(t2) {
        return `<header data-selector='tagify-suggestions-header' class="${this.settings.classNames.dropdownHeader}"></header>`;
      }, dropdownFooter(t2) {
        var e2 = t2.length - this.settings.dropdown.maxItems;
        return e2 > 0 ? `<footer data-selector='tagify-suggestions-footer' class="${this.settings.classNames.dropdownFooter}">
                ${e2} more items. Refine your search.
            </footer>` : "";
      }, dropdownItemNoMatch: null };
      var _ = { customBinding() {
        this.customEventsList.forEach((t2) => {
          this.on(t2, this.settings.callbacks[t2]);
        });
      }, binding() {
        let t2 = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];
        var e2, i2 = this.events.callbacks, s2 = t2 ? "addEventListener" : "removeEventListener";
        if (!this.state.mainEvents || !t2) {
          for (var a2 in this.state.mainEvents = t2, t2 && !this.listeners.main && (this.events.bindGlobal.call(this), this.settings.isJQueryPlugin && jQuery(this.DOM.originalInput).on("tagify.removeAllTags", this.removeAllTags.bind(this))), e2 = this.listeners.main = this.listeners.main || { focus: ["input", i2.onFocusBlur.bind(this)], keydown: ["input", i2.onKeydown.bind(this)], click: ["scope", i2.onClickScope.bind(this)], dblclick: ["scope", i2.onDoubleClickScope.bind(this)], paste: ["input", i2.onPaste.bind(this)], drop: ["input", i2.onDrop.bind(this)], compositionstart: ["input", i2.onCompositionStart.bind(this)], compositionend: ["input", i2.onCompositionEnd.bind(this)] }) this.DOM[e2[a2][0]][s2](a2, e2[a2][1]);
          clearInterval(this.listeners.main.originalInputValueObserverInterval), this.listeners.main.originalInputValueObserverInterval = setInterval(i2.observeOriginalInputValue.bind(this), 500);
          var n2 = this.listeners.main.inputMutationObserver || new MutationObserver(i2.onInputDOMChange.bind(this));
          n2.disconnect(), "mix" == this.settings.mode && n2.observe(this.DOM.input, { childList: true });
        }
      }, bindGlobal(t2) {
        var e2, i2 = this.events.callbacks, s2 = t2 ? "removeEventListener" : "addEventListener";
        if (this.listeners && (t2 || !this.listeners.global)) for (e2 of (this.listeners.global = this.listeners.global || [{ type: this.isIE ? "keydown" : "input", target: this.DOM.input, cb: i2[this.isIE ? "onInputIE" : "onInput"].bind(this) }, { type: "keydown", target: window, cb: i2.onWindowKeyDown.bind(this) }, { type: "blur", target: this.DOM.input, cb: i2.onFocusBlur.bind(this) }, { type: "click", target: document, cb: i2.onClickAnywhere.bind(this) }], this.listeners.global)) e2.target[s2](e2.type, e2.cb);
      }, unbindGlobal() {
        this.events.bindGlobal.call(this, true);
      }, callbacks: { onFocusBlur(t2) {
        var _a, _b;
        var e2 = this.settings, i2 = t2.target ? this.trim(t2.target.textContent) : "", s2 = (_b = (_a = this.value) == null ? void 0 : _a[0]) == null ? void 0 : _b[e2.tagTextProp], a2 = t2.type, n2 = e2.dropdown.enabled >= 0, o2 = { relatedTarget: t2.relatedTarget }, r2 = this.state.actions.selectOption && (n2 || !e2.dropdown.closeOnSelect), l2 = this.state.actions.addNew && n2, d2 = t2.relatedTarget && v.call(this, t2.relatedTarget) && this.DOM.scope.contains(t2.relatedTarget);
        if ("blur" == a2) {
          if (t2.relatedTarget === this.DOM.scope) return this.dropdown.hide(), void this.DOM.input.focus();
          this.postUpdate(), e2.onChangeAfterBlur && this.triggerChangeEvent();
        }
        if (!r2 && !l2) if (this.state.hasFocus = "focus" == a2 && +/* @__PURE__ */ new Date(), this.toggleFocusClass(this.state.hasFocus), "mix" != e2.mode) {
          if ("focus" == a2) return this.trigger("focus", o2), void (0 !== e2.dropdown.enabled && e2.userInput || this.dropdown.show(this.value.length ? "" : void 0));
          "blur" == a2 && (this.trigger("blur", o2), this.loading(false), "select" == e2.mode && (d2 && (this.removeTags(), i2 = ""), s2 === i2 && (i2 = "")), i2 && !this.state.actions.selectOption && e2.addTagOnBlur && e2.addTagOn.includes("blur") && this.addTags(i2, true)), this.DOM.input.removeAttribute("style"), this.dropdown.hide();
        } else "focus" == a2 ? this.trigger("focus", o2) : "blur" == t2.type && (this.trigger("blur", o2), this.loading(false), this.dropdown.hide(), this.state.dropdown.visible = void 0, this.setStateSelection());
      }, onCompositionStart(t2) {
        this.state.composing = true;
      }, onCompositionEnd(t2) {
        this.state.composing = false;
      }, onWindowKeyDown(t2) {
        var e2, i2 = document.activeElement, s2 = v.call(this, i2) && this.DOM.scope.contains(document.activeElement), a2 = s2 && i2.hasAttribute("readonly");
        if (s2 && !a2) switch (e2 = i2.nextElementSibling, t2.key) {
          case "Backspace":
            this.settings.readonly || (this.removeTags(i2), (e2 || this.DOM.input).focus());
            break;
          case "Enter":
            setTimeout(this.editTag.bind(this), 0, i2);
        }
      }, onKeydown(t2) {
        var e2 = this.settings;
        if (!this.state.composing && e2.userInput) {
          "select" == e2.mode && e2.enforceWhitelist && this.value.length && "Tab" != t2.key && t2.preventDefault();
          var i2 = this.trim(t2.target.textContent);
          this.trigger("keydown", { event: t2 }), e2.hooks.beforeKeyDown(t2, { tagify: this }).then((s2) => {
            if ("mix" == e2.mode) {
              switch (t2.key) {
                case "Left":
                case "ArrowLeft":
                  this.state.actions.ArrowLeft = true;
                  break;
                case "Delete":
                case "Backspace":
                  if (this.state.editing) return;
                  var a2 = document.getSelection(), n2 = "Delete" == t2.key && a2.anchorOffset == (a2.anchorNode.length || 0), r2 = a2.anchorNode.previousSibling, d2 = 1 == a2.anchorNode.nodeType || !a2.anchorOffset && r2 && 1 == r2.nodeType && a2.anchorNode.previousSibling;
                  o(this.DOM.input.innerHTML);
                  var h2, g2, p2, c2 = this.getTagElms(), m2 = 1 === a2.anchorNode.length && a2.anchorNode.nodeValue == String.fromCharCode(8203);
                  if ("edit" == e2.backspace && d2) return h2 = 1 == a2.anchorNode.nodeType ? null : a2.anchorNode.previousElementSibling, setTimeout(this.editTag.bind(this), 0, h2), void t2.preventDefault();
                  if (u() && d2 instanceof Element) return p2 = l(d2), d2.hasAttribute("readonly") || d2.remove(), this.DOM.input.focus(), void setTimeout(() => {
                    w(p2), this.DOM.input.click();
                  });
                  if ("BR" == a2.anchorNode.nodeName) return;
                  if ((n2 || d2) && 1 == a2.anchorNode.nodeType ? g2 = 0 == a2.anchorOffset ? n2 ? c2[0] : null : c2[Math.min(c2.length, a2.anchorOffset) - 1] : n2 ? g2 = a2.anchorNode.nextElementSibling : d2 instanceof Element && (g2 = d2), 3 == a2.anchorNode.nodeType && !a2.anchorNode.nodeValue && a2.anchorNode.previousElementSibling && t2.preventDefault(), (d2 || n2) && !e2.backspace) return void t2.preventDefault();
                  if ("Range" != a2.type && !a2.anchorOffset && a2.anchorNode == this.DOM.input && "Delete" != t2.key) return void t2.preventDefault();
                  if ("Range" != a2.type && g2 && g2.hasAttribute("readonly")) return void w(l(g2));
                  "Delete" == t2.key && m2 && T(a2.anchorNode.nextSibling) && this.removeTags(a2.anchorNode.nextSibling), clearTimeout(M), M = setTimeout(() => {
                    var t3 = document.getSelection();
                    o(this.DOM.input.innerHTML), !n2 && t3.anchorNode.previousSibling, this.value = [].map.call(c2, (t4, e3) => {
                      var i3 = T(t4);
                      if (t4.parentNode || i3.readonly) return i3;
                      this.trigger("remove", { tag: t4, index: e3, data: i3 });
                    }).filter((t4) => t4);
                  }, 20);
              }
              return true;
            }
            var v2 = "manual" == e2.dropdown.position;
            switch (t2.key) {
              case "Backspace":
                "select" == e2.mode && e2.enforceWhitelist && this.value.length ? this.removeTags() : this.state.dropdown.visible && "manual" != e2.dropdown.position || "" != t2.target.textContent && 8203 != i2.charCodeAt(0) || (true === e2.backspace ? this.removeTags() : "edit" == e2.backspace && setTimeout(this.editTag.bind(this), 0));
                break;
              case "Esc":
              case "Escape":
                if (this.state.dropdown.visible) return;
                t2.target.blur();
                break;
              case "Down":
              case "ArrowDown":
                this.state.dropdown.visible || this.dropdown.show();
                break;
              case "ArrowRight": {
                let t3 = this.state.inputSuggestion || this.state.ddItemData;
                if (t3 && e2.autoComplete.rightKey) return void this.addTags([t3], true);
                break;
              }
              case "Tab": {
                let s3 = "select" == e2.mode;
                if (!i2 || s3) return true;
                t2.preventDefault();
              }
              case "Enter":
                if (this.state.dropdown.visible && !v2) return;
                t2.preventDefault(), setTimeout(() => {
                  this.state.dropdown.visible && !v2 || this.state.actions.selectOption || !e2.addTagOn.includes(t2.key.toLowerCase()) || this.addTags(i2, true);
                });
            }
          }).catch((t3) => t3);
        }
      }, onInput(t2) {
        this.postUpdate();
        var e2 = this.settings;
        if ("mix" == e2.mode) return this.events.callbacks.onMixTagsInput.call(this, t2);
        var i2 = this.input.normalize.call(this, void 0, { trim: false }), s2 = i2.length >= e2.dropdown.enabled, a2 = { value: i2, inputElm: this.DOM.input }, n2 = this.validateTag({ value: i2 });
        "select" == e2.mode && this.toggleScopeValidation(n2), a2.isValid = n2, this.state.inputText != i2 && (this.input.set.call(this, i2, false), -1 != i2.search(e2.delimiters) ? this.addTags(i2) && this.input.set.call(this) : e2.dropdown.enabled >= 0 && this.dropdown[s2 ? "show" : "hide"](i2), this.trigger("input", a2));
      }, onMixTagsInput(t2) {
        var e2, i2, s2, a2, n2, o2, r2, l2, d2 = this.settings, h2 = this.value.length, p2 = this.getTagElms(), c2 = document.createDocumentFragment(), m2 = window.getSelection().getRangeAt(0), v2 = [].map.call(p2, (t3) => T(t3).value);
        if ("deleteContentBackward" == t2.inputType && u() && this.events.callbacks.onKeydown.call(this, { target: t2.target, key: "Backspace" }), b(this.getTagElms()), this.value.slice().forEach((t3) => {
          t3.readonly && !v2.includes(t3.value) && c2.appendChild(this.createTagElem(t3));
        }), c2.childNodes.length && (m2.insertNode(c2), this.setRangeAtStartEnd(false, c2.lastChild)), p2.length != h2) return this.value = [].map.call(this.getTagElms(), (t3) => T(t3)), void this.update({ withoutChangeEvent: true });
        if (this.hasMaxTags()) return true;
        if (window.getSelection && (o2 = window.getSelection()).rangeCount > 0 && 3 == o2.anchorNode.nodeType) {
          if ((m2 = o2.getRangeAt(0).cloneRange()).collapse(true), m2.setStart(o2.focusNode, 0), s2 = (e2 = m2.toString().slice(0, m2.endOffset)).split(d2.pattern).length - 1, (i2 = e2.match(d2.pattern)) && (a2 = e2.slice(e2.lastIndexOf(i2[i2.length - 1]))), a2) {
            if (this.state.actions.ArrowLeft = false, this.state.tag = { prefix: a2.match(d2.pattern)[0], value: a2.replace(d2.pattern, "") }, this.state.tag.baseOffset = o2.baseOffset - this.state.tag.value.length, l2 = this.state.tag.value.match(d2.delimiters)) return this.state.tag.value = this.state.tag.value.replace(d2.delimiters, ""), this.state.tag.delimiters = l2[0], this.addTags(this.state.tag.value, d2.dropdown.clearOnSelect), void this.dropdown.hide();
            n2 = this.state.tag.value.length >= d2.dropdown.enabled;
            try {
              r2 = (r2 = this.state.flaggedTags[this.state.tag.baseOffset]).prefix == this.state.tag.prefix && r2.value[0] == this.state.tag.value[0], this.state.flaggedTags[this.state.tag.baseOffset] && !this.state.tag.value && delete this.state.flaggedTags[this.state.tag.baseOffset];
            } catch (t3) {
            }
            (r2 || s2 < this.state.mixMode.matchedPatternCount) && (n2 = false);
          } else this.state.flaggedTags = {};
          this.state.mixMode.matchedPatternCount = s2;
        }
        setTimeout(() => {
          this.update({ withoutChangeEvent: true }), this.trigger("input", g({}, this.state.tag, { textContent: this.DOM.input.textContent })), this.state.tag && this.dropdown[n2 ? "show" : "hide"](this.state.tag.value);
        }, 10);
      }, onInputIE(t2) {
        var e2 = this;
        setTimeout(function() {
          e2.events.callbacks.onInput.call(e2, t2);
        });
      }, observeOriginalInputValue() {
        this.DOM.originalInput.parentNode || this.destroy(), this.DOM.originalInput.value != this.DOM.originalInput.tagifyValue && this.loadOriginalValues();
      }, onClickAnywhere(t2) {
        t2.target == this.DOM.scope || this.DOM.scope.contains(t2.target) || (this.toggleFocusClass(false), this.state.hasFocus = false);
      }, onClickScope(t2) {
        var e2 = this.settings, i2 = t2.target.closest("." + e2.classNames.tag), s2 = +/* @__PURE__ */ new Date() - this.state.hasFocus;
        if (t2.target != this.DOM.scope) {
          if (!t2.target.classList.contains(e2.classNames.tagX)) return i2 ? (this.trigger("click", { tag: i2, index: this.getNodeIndex(i2), data: T(i2), event: t2 }), void (1 !== e2.editTags && 1 !== e2.editTags.clicks || this.events.callbacks.onDoubleClickScope.call(this, t2))) : void (t2.target == this.DOM.input && ("mix" == e2.mode && this.fixFirefoxLastTagNoCaret(), s2 > 500) ? this.state.dropdown.visible ? this.dropdown.hide() : 0 === e2.dropdown.enabled && "mix" != e2.mode && this.dropdown.show(this.value.length ? "" : void 0) : "select" != e2.mode || 0 !== e2.dropdown.enabled || this.state.dropdown.visible || this.dropdown.show());
          this.removeTags(t2.target.parentNode);
        } else this.DOM.input.focus();
      }, onPaste(t2) {
        t2.preventDefault();
        var e2, i2, s2 = this.settings;
        if ("select" == s2.mode && s2.enforceWhitelist || !s2.userInput) return false;
        s2.readonly || (e2 = t2.clipboardData || window.clipboardData, i2 = e2.getData("Text"), s2.hooks.beforePaste(t2, { tagify: this, pastedText: i2, clipboardData: e2 }).then((e3) => {
          void 0 === e3 && (e3 = i2), e3 && (this.injectAtCaret(e3, window.getSelection().getRangeAt(0)), "mix" == this.settings.mode ? this.events.callbacks.onMixTagsInput.call(this, t2) : this.settings.pasteAsTags ? this.addTags(this.state.inputText + e3, true) : (this.state.inputText = e3, this.dropdown.show(e3)));
        }).catch((t3) => t3));
      }, onDrop(t2) {
        t2.preventDefault();
      }, onEditTagInput(t2, e2) {
        var i2 = t2.closest("." + this.settings.classNames.tag), s2 = this.getNodeIndex(i2), a2 = T(i2), n2 = this.input.normalize.call(this, t2), o2 = { [this.settings.tagTextProp]: n2, __tagId: a2.__tagId }, r2 = this.validateTag(o2);
        this.editTagChangeDetected(g(a2, o2)) || true !== t2.originalIsValid || (r2 = true), i2.classList.toggle(this.settings.classNames.tagInvalid, true !== r2), a2.__isValid = r2, i2.title = true === r2 ? a2.title || a2.value : r2, n2.length >= this.settings.dropdown.enabled && (this.state.editing && (this.state.editing.value = n2), this.dropdown.show(n2)), this.trigger("edit:input", { tag: i2, index: s2, data: g({}, this.value[s2], { newValue: n2 }), event: e2 });
      }, onEditTagPaste(t2, e2) {
        var i2 = (e2.clipboardData || window.clipboardData).getData("Text");
        e2.preventDefault();
        var s2 = f(i2);
        this.setRangeAtStartEnd(false, s2);
      }, onEditTagFocus(t2) {
        this.state.editing = { scope: t2, input: t2.querySelector("[contenteditable]") };
      }, onEditTagBlur(t2) {
        if (this.state.editing && (this.state.hasFocus || this.toggleFocusClass(), this.DOM.scope.contains(t2))) {
          var e2, i2, s2 = this.settings, a2 = t2.closest("." + s2.classNames.tag), n2 = T(a2), o2 = this.input.normalize.call(this, t2), r2 = { [s2.tagTextProp]: o2, __tagId: n2.__tagId }, l2 = n2.__originalData, d2 = this.editTagChangeDetected(g(n2, r2)), h2 = this.validateTag(r2);
          if (o2) if (d2) {
            if (e2 = this.hasMaxTags(), i2 = g({}, l2, { [s2.tagTextProp]: this.trim(o2), __isValid: h2 }), s2.transformTag.call(this, i2, l2), true !== (h2 = (!e2 || true === l2.__isValid) && this.validateTag(i2))) {
              if (this.trigger("invalid", { data: i2, tag: a2, message: h2 }), s2.editTags.keepInvalid) return;
              s2.keepInvalidTags ? i2.__isValid = h2 : i2 = l2;
            } else s2.keepInvalidTags && (delete i2.title, delete i2["aria-invalid"], delete i2.class);
            this.onEditTagDone(a2, i2);
          } else this.onEditTagDone(a2, l2);
          else this.onEditTagDone(a2);
        }
      }, onEditTagkeydown(t2, e2) {
        if (!this.state.composing) switch (this.trigger("edit:keydown", { event: t2 }), t2.key) {
          case "Esc":
          case "Escape":
            this.state.editing = false, !!e2.__tagifyTagData.__originalData.value ? e2.parentNode.replaceChild(e2.__tagifyTagData.__originalHTML, e2) : e2.remove();
            break;
          case "Enter":
          case "Tab":
            t2.preventDefault(), t2.target.blur();
        }
      }, onDoubleClickScope(t2) {
        var e2, i2, s2 = t2.target.closest("." + this.settings.classNames.tag), a2 = T(s2), n2 = this.settings;
        s2 && n2.userInput && false !== a2.editable && (e2 = s2.classList.contains(this.settings.classNames.tagEditing), i2 = s2.hasAttribute("readonly"), "select" == n2.mode || n2.readonly || e2 || i2 || !this.settings.editTags || this.editTag(s2), this.toggleFocusClass(true), this.trigger("dblclick", { tag: s2, index: this.getNodeIndex(s2), data: T(s2) }));
      }, onInputDOMChange(t2) {
        t2.forEach((t3) => {
          t3.addedNodes.forEach((t4) => {
            var _a;
            if ("<div><br></div>" == t4.outerHTML) t4.replaceWith(document.createElement("br"));
            else if (1 == t4.nodeType && t4.querySelector(this.settings.classNames.tagSelector)) {
              let e3 = document.createTextNode("");
              3 == t4.childNodes[0].nodeType && "BR" != t4.previousSibling.nodeName && (e3 = document.createTextNode("\n")), t4.replaceWith(e3, ...[...t4.childNodes].slice(0, -1)), w(e3);
            } else if (v.call(this, t4)) if (3 != ((_a = t4.previousSibling) == null ? void 0 : _a.nodeType) || t4.previousSibling.textContent || t4.previousSibling.remove(), t4.previousSibling && "BR" == t4.previousSibling.nodeName) {
              t4.previousSibling.replaceWith("\n​");
              let e3 = t4.nextSibling, i2 = "";
              for (; e3; ) i2 += e3.textContent, e3 = e3.nextSibling;
              i2.trim() && w(t4.previousSibling);
            } else t4.previousSibling && !T(t4.previousSibling) || t4.before("​");
          }), t3.removedNodes.forEach((t4) => {
            t4 && "BR" == t4.nodeName && v.call(this, e2) && (this.removeTags(e2), this.fixFirefoxLastTagNoCaret());
          });
        });
        var e2 = this.DOM.input.lastChild;
        e2 && "" == e2.nodeValue && e2.remove(), e2 && "BR" == e2.nodeName || this.DOM.input.appendChild(document.createElement("br"));
      } } };
      function S(t2, e2) {
        if (!t2) {
          console.warn("Tagify:", "input element not found", t2);
          const e3 = new Proxy(this, { get: () => () => e3 });
          return e3;
        }
        if (t2.__tagify) return console.warn("Tagify: ", "input element is already Tagified - Same instance is returned.", t2), t2.__tagify;
        var i2;
        g(this, function(t3) {
          var e3 = document.createTextNode("");
          function i3(t4, i4, s2) {
            s2 && i4.split(/\s+/g).forEach((i5) => e3[t4 + "EventListener"].call(e3, i5, s2));
          }
          return { off(t4, e4) {
            return i3("remove", t4, e4), this;
          }, on(t4, e4) {
            return e4 && "function" == typeof e4 && i3("add", t4, e4), this;
          }, trigger(i4, s2, a2) {
            var n2;
            if (a2 = a2 || { cloneData: true }, i4) if (t3.settings.isJQueryPlugin) "remove" == i4 && (i4 = "removeTag"), jQuery(t3.DOM.originalInput).triggerHandler(i4, [s2]);
            else {
              try {
                var o2 = "object" == typeof s2 ? s2 : { value: s2 };
                if ((o2 = a2.cloneData ? g({}, o2) : o2).tagify = this, s2.event && (o2.event = this.cloneEvent(s2.event)), s2 instanceof Object) for (var r2 in s2) s2[r2] instanceof HTMLElement && (o2[r2] = s2[r2]);
                n2 = new CustomEvent(i4, { detail: o2 });
              } catch (t4) {
                console.warn(t4);
              }
              e3.dispatchEvent(n2);
            }
          } };
        }(this)), this.isFirefox = /firefox|fxios/i.test(navigator.userAgent) && !/seamonkey/i.test(navigator.userAgent), this.isIE = window.document.documentMode, e2 = e2 || {}, this.getPersistedData = (i2 = e2.id, (t3) => {
          let e3, s2 = "/" + t3;
          if (1 == localStorage.getItem(D + i2 + "/v", 1)) try {
            e3 = JSON.parse(localStorage[D + i2 + s2]);
          } catch (t4) {
          }
          return e3;
        }), this.setPersistedData = ((t3) => t3 ? (localStorage.setItem(D + t3 + "/v", 1), (e3, i3) => {
          let s2 = "/" + i3, a2 = JSON.stringify(e3);
          e3 && i3 && (localStorage.setItem(D + t3 + s2, a2), dispatchEvent(new Event("storage")));
        }) : () => {
        })(e2.id), this.clearPersistedData = /* @__PURE__ */ ((t3) => (e3) => {
          const i3 = D + "/" + t3 + "/";
          if (e3) localStorage.removeItem(i3 + e3);
          else for (let t4 in localStorage) t4.includes(i3) && localStorage.removeItem(t4);
        })(e2.id), this.applySettings(t2, e2), this.state = { inputText: "", editing: false, composing: false, actions: {}, mixMode: {}, dropdown: {}, flaggedTags: {} }, this.value = [], this.listeners = {}, this.DOM = {}, this.build(t2), x.call(this), this.getCSSVars(), this.loadOriginalValues(), this.events.customBinding.call(this), this.events.binding.call(this), t2.autofocus && this.DOM.input.focus(), t2.__tagify = this;
      }
      return S.prototype = { _dropdown: O, placeCaretAfterNode: w, getSetTagData: T, helpers: { sameStr: s, removeCollectionProp: a, omit: n, isObject: h, parseHTML: r, escapeHTML: d, extend: g, concatWithoutDups: p, getUID: m, isNodeTag: v }, customEventsList: ["change", "add", "remove", "invalid", "input", "click", "keydown", "focus", "blur", "edit:input", "edit:beforeUpdate", "edit:updated", "edit:start", "edit:keydown", "dropdown:show", "dropdown:hide", "dropdown:select", "dropdown:updated", "dropdown:noMatch", "dropdown:scroll"], dataProps: ["__isValid", "__removed", "__originalData", "__originalHTML", "__tagId"], trim(t2) {
        return this.settings.trim && t2 && "string" == typeof t2 ? t2.trim() : t2;
      }, parseHTML: r, templates: N, parseTemplate(t2, e2) {
        return r((t2 = this.settings.templates[t2] || t2).apply(this, e2));
      }, set whitelist(t2) {
        const e2 = t2 && Array.isArray(t2);
        this.settings.whitelist = e2 ? t2 : [], this.setPersistedData(e2 ? t2 : [], "whitelist");
      }, get whitelist() {
        return this.settings.whitelist;
      }, generateClassSelectors(t2) {
        for (let e2 in t2) {
          let i2 = e2;
          Object.defineProperty(t2, i2 + "Selector", { get() {
            return "." + this[i2].split(" ")[0];
          } });
        }
      }, applySettings(t2, i2) {
        var _a, _b;
        y.templates = this.templates;
        var s2 = g({}, y, "mix" == i2.mode ? { dropdown: { position: "text" } } : {}), a2 = this.settings = g({}, s2, i2);
        if (a2.disabled = t2.hasAttribute("disabled"), a2.readonly = a2.readonly || t2.hasAttribute("readonly"), a2.placeholder = d(t2.getAttribute("placeholder") || a2.placeholder || ""), a2.required = t2.hasAttribute("required"), this.generateClassSelectors(a2.classNames), void 0 === a2.dropdown.includeSelectedTags && (a2.dropdown.includeSelectedTags = a2.duplicates), this.isIE && (a2.autoComplete = false), ["whitelist", "blacklist"].forEach((e2) => {
          var i3 = t2.getAttribute("data-" + e2);
          i3 && (i3 = i3.split(a2.delimiters)) instanceof Array && (a2[e2] = i3);
        }), "autoComplete" in i2 && !h(i2.autoComplete) && (a2.autoComplete = y.autoComplete, a2.autoComplete.enabled = i2.autoComplete), "mix" == a2.mode && (a2.pattern = a2.pattern || /@/, a2.autoComplete.rightKey = true, a2.delimiters = i2.delimiters || null, a2.tagTextProp && !a2.dropdown.searchKeys.includes(a2.tagTextProp) && a2.dropdown.searchKeys.push(a2.tagTextProp)), t2.pattern) try {
          a2.pattern = new RegExp(t2.pattern);
        } catch (t3) {
        }
        if (a2.delimiters) {
          a2._delimiters = a2.delimiters;
          try {
            a2.delimiters = new RegExp(this.settings.delimiters, "g");
          } catch (t3) {
          }
        }
        a2.disabled && (a2.userInput = false), this.TEXTS = e(e({}, I), a2.texts || {}), ("select" != a2.mode || ((_a = i2.dropdown) == null ? void 0 : _a.enabled)) && a2.userInput || (a2.dropdown.enabled = 0), a2.dropdown.appendTarget = ((_b = i2.dropdown) == null ? void 0 : _b.appendTarget) || document.body;
        let n2 = this.getPersistedData("whitelist");
        Array.isArray(n2) && (this.whitelist = Array.isArray(a2.whitelist) ? p(a2.whitelist, n2) : n2);
      }, getAttributes(t2) {
        var e2, i2 = this.getCustomAttributes(t2), s2 = "";
        for (e2 in i2) s2 += " " + e2 + (void 0 !== t2[e2] ? `="${i2[e2]}"` : "");
        return s2;
      }, getCustomAttributes(t2) {
        if (!h(t2)) return "";
        var e2, i2 = {};
        for (e2 in t2) "__" != e2.slice(0, 2) && "class" != e2 && t2.hasOwnProperty(e2) && void 0 !== t2[e2] && (i2[e2] = d(t2[e2]));
        return i2;
      }, setStateSelection() {
        var t2 = window.getSelection(), e2 = { anchorOffset: t2.anchorOffset, anchorNode: t2.anchorNode, range: t2.getRangeAt && t2.rangeCount && t2.getRangeAt(0) };
        return this.state.selection = e2, e2;
      }, getCSSVars() {
        var t2 = getComputedStyle(this.DOM.scope, null);
        var e2;
        this.CSSVars = { tagHideTransition: ((t3) => {
          let e3 = t3.value;
          return "s" == t3.unit ? 1e3 * e3 : e3;
        })(function(t3) {
          if (!t3) return {};
          var e3 = (t3 = t3.trim().split(" ")[0]).split(/\d+/g).filter((t4) => t4).pop().trim();
          return { value: +t3.split(e3).filter((t4) => t4)[0].trim(), unit: e3 };
        }((e2 = "tag-hide-transition", t2.getPropertyValue("--" + e2)))) };
      }, build(t2) {
        var e2 = this.DOM;
        this.settings.mixMode.integrated ? (e2.originalInput = null, e2.scope = t2, e2.input = t2) : (e2.originalInput = t2, e2.originalInput_tabIndex = t2.tabIndex, e2.scope = this.parseTemplate("wrapper", [t2, this.settings]), e2.input = e2.scope.querySelector(this.settings.classNames.inputSelector), t2.parentNode.insertBefore(e2.scope, t2), t2.tabIndex = -1);
      }, destroy() {
        this.events.unbindGlobal.call(this), this.DOM.scope.parentNode.removeChild(this.DOM.scope), this.DOM.originalInput.tabIndex = this.DOM.originalInput_tabIndex, delete this.DOM.originalInput.__tagify, this.dropdown.hide(true), clearTimeout(this.dropdownHide__bindEventsTimeout), clearInterval(this.listeners.main.originalInputValueObserverInterval);
      }, loadOriginalValues(t2) {
        var e2, i2 = this.settings;
        if (this.state.blockChangeEvent = true, void 0 === t2) {
          const e3 = this.getPersistedData("value");
          t2 = e3 && !this.DOM.originalInput.value ? e3 : i2.mixMode.integrated ? this.DOM.input.textContent : this.DOM.originalInput.value;
        }
        if (this.removeAllTags(), t2) if ("mix" == i2.mode) this.parseMixTags(t2), (e2 = this.DOM.input.lastChild) && "BR" == e2.tagName || this.DOM.input.insertAdjacentHTML("beforeend", "<br>");
        else {
          try {
            JSON.parse(t2) instanceof Array && (t2 = JSON.parse(t2));
          } catch (t3) {
          }
          this.addTags(t2, true).forEach((t3) => t3 && t3.classList.add(i2.classNames.tagNoAnimation));
        }
        else this.postUpdate();
        this.state.lastOriginalValueReported = i2.mixMode.integrated ? "" : this.DOM.originalInput.value;
      }, cloneEvent(t2) {
        var e2 = {};
        for (var i2 in t2) "path" != i2 && (e2[i2] = t2[i2]);
        return e2;
      }, loading(t2) {
        return this.state.isLoading = t2, this.DOM.scope.classList[t2 ? "add" : "remove"](this.settings.classNames.scopeLoading), this;
      }, tagLoading(t2, e2) {
        return t2 && t2.classList[e2 ? "add" : "remove"](this.settings.classNames.tagLoading), this;
      }, toggleClass(t2, e2) {
        "string" == typeof t2 && this.DOM.scope.classList.toggle(t2, e2);
      }, toggleScopeValidation(t2) {
        var e2 = true === t2 || void 0 === t2;
        !this.settings.required && t2 && t2 === this.TEXTS.empty && (e2 = true), this.toggleClass(this.settings.classNames.tagInvalid, !e2), this.DOM.scope.title = e2 ? "" : t2;
      }, toggleFocusClass(t2) {
        this.toggleClass(this.settings.classNames.focus, !!t2);
      }, triggerChangeEvent: function() {
        if (!this.settings.mixMode.integrated) {
          var t2 = this.DOM.originalInput, e2 = this.state.lastOriginalValueReported !== t2.value, i2 = new CustomEvent("change", { bubbles: true });
          e2 && (this.state.lastOriginalValueReported = t2.value, i2.simulated = true, t2._valueTracker && t2._valueTracker.setValue(Math.random()), t2.dispatchEvent(i2), this.trigger("change", this.state.lastOriginalValueReported), t2.value = this.state.lastOriginalValueReported);
        }
      }, events: _, fixFirefoxLastTagNoCaret() {
      }, setRangeAtStartEnd(t2, e2) {
        if (e2) {
          t2 = "number" == typeof t2 ? t2 : !!t2, e2 = e2.lastChild || e2;
          var i2 = document.getSelection();
          if (i2.focusNode instanceof Element && !this.DOM.input.contains(i2.focusNode)) return true;
          try {
            i2.rangeCount >= 1 && ["Start", "End"].forEach((s2) => i2.getRangeAt(0)["set" + s2](e2, t2 || e2.length));
          } catch (t3) {
            console.warn("Tagify: ", t3);
          }
        }
      }, insertAfterTag(t2, e2) {
        if (e2 = e2 || this.settings.mixMode.insertAfterTag, t2 && t2.parentNode && e2) return e2 = "string" == typeof e2 ? document.createTextNode(e2) : e2, t2.parentNode.insertBefore(e2, t2.nextSibling), e2;
      }, editTagChangeDetected(t2) {
        var e2 = t2.__originalData;
        for (var i2 in e2) if (!this.dataProps.includes(i2) && t2[i2] != e2[i2]) return true;
        return false;
      }, getTagTextNode(t2) {
        return t2.querySelector(this.settings.classNames.tagTextSelector);
      }, setTagTextNode(t2, e2) {
        this.getTagTextNode(t2).innerHTML = d(e2);
      }, editTag(t2, e2) {
        t2 = t2 || this.getLastTag(), e2 = e2 || {}, this.dropdown.hide();
        var i2 = this.settings, s2 = this.getTagTextNode(t2), a2 = this.getNodeIndex(t2), n2 = T(t2), o2 = this.events.callbacks, r2 = true;
        if (s2) {
          if (!(n2 instanceof Object && "editable" in n2) || n2.editable) return n2 = T(t2, { __originalData: g({}, n2), __originalHTML: t2.cloneNode(true) }), T(n2.__originalHTML, n2.__originalData), s2.setAttribute("contenteditable", true), t2.classList.add(i2.classNames.tagEditing), s2.addEventListener("focus", o2.onEditTagFocus.bind(this, t2)), s2.addEventListener("blur", o2.onEditTagBlur.bind(this, this.getTagTextNode(t2))), s2.addEventListener("input", o2.onEditTagInput.bind(this, s2)), s2.addEventListener("paste", o2.onEditTagPaste.bind(this, s2)), s2.addEventListener("keydown", (e3) => o2.onEditTagkeydown.call(this, e3, t2)), s2.addEventListener("compositionstart", o2.onCompositionStart.bind(this)), s2.addEventListener("compositionend", o2.onCompositionEnd.bind(this)), e2.skipValidation || (r2 = this.editTagToggleValidity(t2)), s2.originalIsValid = r2, this.trigger("edit:start", { tag: t2, index: a2, data: n2, isValid: r2 }), s2.focus(), this.setRangeAtStartEnd(false, s2), this;
        } else console.warn("Cannot find element in Tag template: .", i2.classNames.tagTextSelector);
      }, editTagToggleValidity(t2, e2) {
        var i2;
        if (e2 = e2 || T(t2)) return (i2 = !("__isValid" in e2) || true === e2.__isValid) || this.removeTagsFromValue(t2), this.update(), t2.classList.toggle(this.settings.classNames.tagNotAllowed, !i2), e2.__isValid = i2, e2.__isValid;
        console.warn("tag has no data: ", t2, e2);
      }, onEditTagDone(t2, e2) {
        t2 = t2 || this.state.editing.scope, e2 = e2 || {};
        var i2, s2 = { tag: t2, index: this.getNodeIndex(t2), previousData: T(t2), data: e2 }, a2 = this.settings;
        this.trigger("edit:beforeUpdate", s2, { cloneData: false }), this.state.editing = false, delete e2.__originalData, delete e2.__originalHTML, t2 && ((i2 = e2[a2.tagTextProp]) ? i2.trim() && i2 : a2.tagTextProp in e2 ? void 0 : e2.value) ? (t2 = this.replaceTag(t2, e2), this.editTagToggleValidity(t2, e2), a2.a11y.focusableTags ? t2.focus() : w(t2)) : t2 && this.removeTags(t2), this.trigger("edit:updated", s2), this.dropdown.hide(), this.settings.keepInvalidTags && this.reCheckInvalidTags();
      }, replaceTag(t2, e2) {
        e2 && e2.value || (e2 = t2.__tagifyTagData), e2.__isValid && 1 != e2.__isValid && g(e2, this.getInvalidTagAttrs(e2, e2.__isValid));
        var i2 = this.createTagElem(e2);
        return t2.parentNode.replaceChild(i2, t2), this.updateValueByDOMTags(), i2;
      }, updateValueByDOMTags() {
        this.value.length = 0, [].forEach.call(this.getTagElms(), (t2) => {
          t2.classList.contains(this.settings.classNames.tagNotAllowed.split(" ")[0]) || this.value.push(T(t2));
        }), this.update();
      }, injectAtCaret(t2, e2) {
        var _a;
        if (!(e2 = e2 || ((_a = this.state.selection) == null ? void 0 : _a.range)) && t2) return this.appendMixTags(t2), this;
        let i2 = f(t2, e2);
        return this.setRangeAtStartEnd(false, i2), this.updateValueByDOMTags(), this.update(), this;
      }, input: { set() {
        let t2 = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", e2 = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
        var i2 = this.settings.dropdown.closeOnSelect;
        this.state.inputText = t2, e2 && (this.DOM.input.innerHTML = d("" + t2)), !t2 && i2 && this.dropdown.hide.bind(this), this.input.autocomplete.suggest.call(this), this.input.validate.call(this);
      }, raw() {
        return this.DOM.input.textContent;
      }, validate() {
        var t2 = !this.state.inputText || true === this.validateTag({ value: this.state.inputText });
        return this.DOM.input.classList.toggle(this.settings.classNames.inputInvalid, !t2), t2;
      }, normalize(t2, e2) {
        var i2 = t2 || this.DOM.input, s2 = [];
        i2.childNodes.forEach((t3) => 3 == t3.nodeType && s2.push(t3.nodeValue)), s2 = s2.join("\n");
        try {
          s2 = s2.replace(/(?:\r\n|\r|\n)/g, this.settings.delimiters.source.charAt(0));
        } catch (t3) {
        }
        return s2 = s2.replace(/\s/g, " "), (e2 == null ? void 0 : e2.trim) ? this.trim(s2) : s2;
      }, autocomplete: { suggest(t2) {
        if (this.settings.autoComplete.enabled) {
          "string" == typeof (t2 = t2 || { value: "" }) && (t2 = { value: t2 });
          var e2 = this.dropdown.getMappedValue(t2);
          if ("number" != typeof e2) {
            var i2 = e2.substr(0, this.state.inputText.length).toLowerCase(), s2 = e2.substring(this.state.inputText.length);
            e2 && this.state.inputText && i2 == this.state.inputText.toLowerCase() ? (this.DOM.input.setAttribute("data-suggest", s2), this.state.inputSuggestion = t2) : (this.DOM.input.removeAttribute("data-suggest"), delete this.state.inputSuggestion);
          }
        }
      }, set(t2) {
        var e2 = this.DOM.input.getAttribute("data-suggest"), i2 = t2 || (e2 ? this.state.inputText + e2 : null);
        return !!i2 && ("mix" == this.settings.mode ? this.replaceTextWithNode(document.createTextNode(this.state.tag.prefix + i2)) : (this.input.set.call(this, i2), this.setRangeAtStartEnd(false, this.DOM.input)), this.input.autocomplete.suggest.call(this), this.dropdown.hide(), true);
      } } }, getTagIdx(t2) {
        return this.value.findIndex((e2) => e2.__tagId == (t2 || {}).__tagId);
      }, getNodeIndex(t2) {
        var e2 = 0;
        if (t2) for (; t2 = t2.previousElementSibling; ) e2++;
        return e2;
      }, getTagElms() {
        for (var t2 = arguments.length, e2 = new Array(t2), i2 = 0; i2 < t2; i2++) e2[i2] = arguments[i2];
        var s2 = "." + [...this.settings.classNames.tag.split(" "), ...e2].join(".");
        return [].slice.call(this.DOM.scope.querySelectorAll(s2));
      }, getLastTag() {
        var t2 = this.DOM.scope.querySelectorAll(`${this.settings.classNames.tagSelector}:not(.${this.settings.classNames.tagHide}):not([readonly])`);
        return t2[t2.length - 1];
      }, isTagDuplicate(t2, e2, i2) {
        var a2 = 0;
        if ("select" == this.settings.mode) return false;
        for (let n2 of this.value) {
          s(this.trim("" + t2), n2.value, e2) && i2 != n2.__tagId && a2++;
        }
        return a2;
      }, getTagIndexByValue(t2) {
        var e2 = [], i2 = this.settings.dropdown.caseSensitive;
        return this.getTagElms().forEach((a2, n2) => {
          a2.__tagifyTagData && s(this.trim(a2.__tagifyTagData.value), t2, i2) && e2.push(n2);
        }), e2;
      }, getTagElmByValue(t2) {
        var e2 = this.getTagIndexByValue(t2)[0];
        return this.getTagElms()[e2];
      }, flashTag(t2) {
        t2 && (t2.classList.add(this.settings.classNames.tagFlash), setTimeout(() => {
          t2.classList.remove(this.settings.classNames.tagFlash);
        }, 100));
      }, isTagBlacklisted(t2) {
        return t2 = this.trim(t2.toLowerCase()), this.settings.blacklist.filter((e2) => ("" + e2).toLowerCase() == t2).length;
      }, isTagWhitelisted(t2) {
        return !!this.getWhitelistItem(t2);
      }, getWhitelistItem(t2, e2, i2) {
        e2 = e2 || "value";
        var a2, n2 = this.settings;
        return (i2 = i2 || n2.whitelist).some((i3) => {
          var o2 = "string" == typeof i3 ? i3 : i3[e2] || i3.value;
          if (s(o2, t2, n2.dropdown.caseSensitive, n2.trim)) return a2 = "string" == typeof i3 ? { value: i3 } : i3, true;
        }), a2 || "value" != e2 || "value" == n2.tagTextProp || (a2 = this.getWhitelistItem(t2, n2.tagTextProp, i2)), a2;
      }, validateTag(t2) {
        var e2 = this.settings, i2 = "value" in t2 ? "value" : e2.tagTextProp, s2 = this.trim(t2[i2] + "");
        return (t2[i2] + "").trim() ? "mix" != e2.mode && e2.pattern && e2.pattern instanceof RegExp && !e2.pattern.test(s2) ? this.TEXTS.pattern : !e2.duplicates && this.isTagDuplicate(s2, e2.dropdown.caseSensitive, t2.__tagId) ? this.TEXTS.duplicate : this.isTagBlacklisted(s2) || e2.enforceWhitelist && !this.isTagWhitelisted(s2) ? this.TEXTS.notAllowed : !e2.validate || e2.validate(t2) : this.TEXTS.empty;
      }, getInvalidTagAttrs(t2, e2) {
        return { "aria-invalid": true, class: `${t2.class || ""} ${this.settings.classNames.tagNotAllowed}`.trim(), title: e2 };
      }, hasMaxTags() {
        return this.value.length >= this.settings.maxTags && this.TEXTS.exceed;
      }, setReadonly(t2, e2) {
        var i2 = this.settings;
        document.activeElement.blur(), i2[e2 || "readonly"] = t2, this.DOM.scope[(t2 ? "set" : "remove") + "Attribute"](e2 || "readonly", true), this.settings.userInput = true, this.setContentEditable(!t2);
      }, setContentEditable(t2) {
        this.settings.userInput && (this.DOM.input.contentEditable = t2, this.DOM.input.tabIndex = t2 ? 0 : -1);
      }, setDisabled(t2) {
        this.setReadonly(t2, "disabled");
      }, normalizeTags(t2) {
        var e2 = this.settings, i2 = e2.whitelist, s2 = e2.delimiters, a2 = e2.mode, n2 = e2.tagTextProp, o2 = [], r2 = !!i2 && i2[0] instanceof Object, l2 = Array.isArray(t2), d2 = l2 && t2[0].value, h2 = (t3) => (t3 + "").split(s2).filter((t4) => t4).map((t4) => ({ [n2]: this.trim(t4), value: this.trim(t4) }));
        if ("number" == typeof t2 && (t2 = t2.toString()), "string" == typeof t2) {
          if (!t2.trim()) return [];
          t2 = h2(t2);
        } else l2 && (t2 = [].concat(...t2.map((t3) => null != t3.value ? t3 : h2(t3))));
        return r2 && !d2 && (t2.forEach((t3) => {
          var e3 = o2.map((t4) => t4.value), i3 = this.dropdown.filterListItems.call(this, t3[n2], { exact: true });
          this.settings.duplicates || (i3 = i3.filter((t4) => !e3.includes(t4.value)));
          var s3 = i3.length > 1 ? this.getWhitelistItem(t3[n2], n2, i3) : i3[0];
          s3 && s3 instanceof Object ? o2.push(s3) : "mix" != a2 && (null == t3.value && (t3.value = t3[n2]), o2.push(t3));
        }), o2.length && (t2 = o2)), t2;
      }, parseMixTags(t2) {
        var e2 = this.settings, i2 = e2.mixTagsInterpolator, s2 = e2.duplicates, a2 = e2.transformTag, n2 = e2.enforceWhitelist, o2 = e2.maxTags, r2 = e2.tagTextProp, l2 = [];
        t2 = t2.split(i2[0]).map((t3, e3) => {
          var d3, h2, g2, p2 = t3.split(i2[1]), c2 = p2[0], u2 = l2.length == o2;
          try {
            if (c2 == +c2) throw Error;
            h2 = JSON.parse(c2);
          } catch (t4) {
            h2 = this.normalizeTags(c2)[0] || { value: c2 };
          }
          if (a2.call(this, h2), u2 || !(p2.length > 1) || n2 && !this.isTagWhitelisted(h2.value) || !s2 && this.isTagDuplicate(h2.value)) {
            if (t3) return e3 ? i2[0] + t3 : t3;
          } else h2[d3 = h2[r2] ? r2 : "value"] = this.trim(h2[d3]), g2 = this.createTagElem(h2), l2.push(h2), g2.classList.add(this.settings.classNames.tagNoAnimation), p2[0] = g2.outerHTML, this.value.push(h2);
          return p2.join("");
        }).join(""), this.DOM.input.innerHTML = t2, this.DOM.input.appendChild(document.createTextNode("")), this.DOM.input.normalize();
        var d2 = this.getTagElms();
        return d2.forEach((t3, e3) => T(t3, l2[e3])), this.update({ withoutChangeEvent: true }), b(d2, this.state.hasFocus), t2;
      }, replaceTextWithNode(t2, e2) {
        if (this.state.tag || e2) {
          e2 = e2 || this.state.tag.prefix + this.state.tag.value;
          var i2, s2, a2 = this.state.selection || window.getSelection(), n2 = a2.anchorNode, o2 = this.state.tag.delimiters ? this.state.tag.delimiters.length : 0;
          return n2.splitText(a2.anchorOffset - o2), -1 == (i2 = n2.nodeValue.lastIndexOf(e2)) ? true : (s2 = n2.splitText(i2), t2 && n2.parentNode.replaceChild(t2, s2), true);
        }
      }, selectTag(t2, e2) {
        var i2 = this.settings;
        if (!i2.enforceWhitelist || this.isTagWhitelisted(e2.value)) {
          this.input.set.call(this, e2[i2.tagTextProp] || e2.value, true), this.state.actions.selectOption && setTimeout(() => this.setRangeAtStartEnd(false, this.DOM.input));
          var s2 = this.getLastTag();
          return s2 ? this.replaceTag(s2, e2) : this.appendTag(t2), this.value[0] = e2, this.update(), this.trigger("add", { tag: t2, data: e2 }), [t2];
        }
      }, addEmptyTag(t2) {
        var e2 = g({ value: "" }, t2 || {}), i2 = this.createTagElem(e2);
        T(i2, e2), this.appendTag(i2), this.editTag(i2, { skipValidation: true });
      }, addTags(t2, e2, i2) {
        var s2 = [], a2 = this.settings, n2 = [], o2 = document.createDocumentFragment();
        if (i2 = i2 || a2.skipInvalid, !t2 || 0 == t2.length) return s2;
        switch (t2 = this.normalizeTags(t2), a2.mode) {
          case "mix":
            return this.addMixTags(t2);
          case "select":
            e2 = false, this.removeAllTags();
        }
        return this.DOM.input.removeAttribute("style"), t2.forEach((t3) => {
          var e3, r2 = {}, l2 = Object.assign({}, t3, { value: t3.value + "" });
          if (t3 = Object.assign({}, l2), a2.transformTag.call(this, t3), t3.__isValid = this.hasMaxTags() || this.validateTag(t3), true !== t3.__isValid) {
            if (i2) return;
            if (g(r2, this.getInvalidTagAttrs(t3, t3.__isValid), { __preInvalidData: l2 }), t3.__isValid == this.TEXTS.duplicate && this.flashTag(this.getTagElmByValue(t3.value)), !a2.createInvalidTags) return void n2.push(t3.value);
          }
          if ("readonly" in t3 && (t3.readonly ? r2["aria-readonly"] = true : delete t3.readonly), e3 = this.createTagElem(t3, r2), s2.push(e3), "select" == a2.mode) return this.selectTag(e3, t3);
          o2.appendChild(e3), t3.__isValid && true === t3.__isValid ? (this.value.push(t3), this.trigger("add", { tag: e3, index: this.value.length - 1, data: t3 })) : (this.trigger("invalid", { data: t3, index: this.value.length, tag: e3, message: t3.__isValid }), a2.keepInvalidTags || setTimeout(() => this.removeTags(e3, true), 1e3)), this.dropdown.position();
        }), this.appendTag(o2), this.update(), t2.length && e2 && (this.input.set.call(this, a2.createInvalidTags ? "" : n2.join(a2._delimiters)), this.setRangeAtStartEnd(false, this.DOM.input)), a2.dropdown.enabled && this.dropdown.refilter(), s2;
      }, addMixTags(t2) {
        if ((t2 = this.normalizeTags(t2))[0].prefix || this.state.tag) return this.prefixedTextToTag(t2[0]);
        var e2 = document.createDocumentFragment();
        return t2.forEach((t3) => {
          var i2 = this.createTagElem(t3);
          e2.appendChild(i2);
        }), this.appendMixTags(e2), e2;
      }, appendMixTags(t2) {
        var e2 = !!this.state.selection;
        e2 ? this.injectAtCaret(t2) : (this.DOM.input.focus(), (e2 = this.setStateSelection()).range.setStart(this.DOM.input, e2.range.endOffset), e2.range.setEnd(this.DOM.input, e2.range.endOffset), this.DOM.input.appendChild(t2), this.updateValueByDOMTags(), this.update());
      }, prefixedTextToTag(t2) {
        var e2, i2 = this.settings, s2 = this.state.tag.delimiters;
        if (i2.transformTag.call(this, t2), t2.prefix = t2.prefix || this.state.tag ? this.state.tag.prefix : (i2.pattern.source || i2.pattern)[0], e2 = this.createTagElem(t2), this.replaceTextWithNode(e2) || this.DOM.input.appendChild(e2), setTimeout(() => e2.classList.add(this.settings.classNames.tagNoAnimation), 300), this.value.push(t2), this.update(), !s2) {
          var a2 = this.insertAfterTag(e2) || e2;
          setTimeout(w, 0, a2);
        }
        return this.state.tag = null, this.trigger("add", g({}, { tag: e2 }, { data: t2 })), e2;
      }, appendTag(t2) {
        var e2 = this.DOM, i2 = e2.input;
        e2.scope.insertBefore(t2, i2);
      }, createTagElem(t2, i2) {
        t2.__tagId = m();
        var s2, a2 = g({}, t2, e({ value: d(t2.value + "") }, i2));
        return function(t3) {
          for (var e2, i3 = document.createNodeIterator(t3, NodeFilter.SHOW_TEXT, null, false); e2 = i3.nextNode(); ) e2.textContent.trim() || e2.parentNode.removeChild(e2);
        }(s2 = this.parseTemplate("tag", [a2, this])), T(s2, t2), s2;
      }, reCheckInvalidTags() {
        var t2 = this.settings;
        this.getTagElms(t2.classNames.tagNotAllowed).forEach((e2, i2) => {
          var s2 = T(e2), a2 = this.hasMaxTags(), n2 = this.validateTag(s2), o2 = true === n2 && !a2;
          if ("select" == t2.mode && this.toggleScopeValidation(n2), o2) return s2 = s2.__preInvalidData ? s2.__preInvalidData : { value: s2.value }, this.replaceTag(e2, s2);
          e2.title = a2 || n2;
        });
      }, removeTags(t2, e2, i2) {
        var s2, a2 = this.settings;
        if (t2 = t2 && t2 instanceof HTMLElement ? [t2] : t2 instanceof Array ? t2 : t2 ? [t2] : [this.getLastTag()], s2 = t2.reduce((t3, e3) => {
          e3 && "string" == typeof e3 && (e3 = this.getTagElmByValue(e3));
          var i3 = T(e3);
          return e3 && i3 && !i3.readonly && t3.push({ node: e3, idx: this.getTagIdx(i3), data: T(e3, { __removed: true }) }), t3;
        }, []), i2 = "number" == typeof i2 ? i2 : this.CSSVars.tagHideTransition, "select" == a2.mode && (i2 = 0, this.input.set.call(this)), 1 == s2.length && "select" != a2.mode && s2[0].node.classList.contains(a2.classNames.tagNotAllowed) && (e2 = true), s2.length) return a2.hooks.beforeRemoveTag(s2, { tagify: this }).then(() => {
          function t3(t4) {
            t4.node.parentNode && (t4.node.parentNode.removeChild(t4.node), e2 ? a2.keepInvalidTags && this.trigger("remove", { tag: t4.node, index: t4.idx }) : (this.trigger("remove", { tag: t4.node, index: t4.idx, data: t4.data }), this.dropdown.refilter(), this.dropdown.position(), this.DOM.input.normalize(), a2.keepInvalidTags && this.reCheckInvalidTags()));
          }
          i2 && i2 > 10 && 1 == s2.length ? (function(e3) {
            e3.node.style.width = parseFloat(window.getComputedStyle(e3.node).width) + "px", document.body.clientTop, e3.node.classList.add(a2.classNames.tagHide), setTimeout(t3.bind(this), i2, e3);
          }).call(this, s2[0]) : s2.forEach(t3.bind(this)), e2 || (this.removeTagsFromValue(s2.map((t4) => t4.node)), this.update(), "select" == a2.mode && this.setContentEditable(true));
        }).catch((t3) => {
        });
      }, removeTagsFromDOM() {
        [].slice.call(this.getTagElms()).forEach((t2) => t2.parentNode.removeChild(t2));
      }, removeTagsFromValue(t2) {
        (t2 = Array.isArray(t2) ? t2 : [t2]).forEach((t3) => {
          var e2 = T(t3), i2 = this.getTagIdx(e2);
          i2 > -1 && this.value.splice(i2, 1);
        });
      }, removeAllTags(t2) {
        t2 = t2 || {}, this.value = [], "mix" == this.settings.mode ? this.DOM.input.innerHTML = "" : this.removeTagsFromDOM(), this.dropdown.refilter(), this.dropdown.position(), this.state.dropdown.visible && setTimeout(() => {
          this.DOM.input.focus();
        }), "select" == this.settings.mode && (this.input.set.call(this), this.setContentEditable(true)), this.update(t2);
      }, postUpdate() {
        var _a, _b;
        this.state.blockChangeEvent = false;
        var t2 = this.settings, e2 = t2.classNames, i2 = "mix" == t2.mode ? t2.mixMode.integrated ? this.DOM.input.textContent : this.DOM.originalInput.value.trim() : this.value.length + this.input.raw.call(this).length;
        this.toggleClass(e2.hasMaxTags, this.value.length >= t2.maxTags), this.toggleClass(e2.hasNoTags, !this.value.length), this.toggleClass(e2.empty, !i2), "select" == t2.mode && this.toggleScopeValidation((_b = (_a = this.value) == null ? void 0 : _a[0]) == null ? void 0 : _b.__isValid);
      }, setOriginalInputValue(t2) {
        var e2 = this.DOM.originalInput;
        this.settings.mixMode.integrated || (e2.value = t2, e2.tagifyValue = e2.value, this.setPersistedData(t2, "value"));
      }, update(t2) {
        clearTimeout(this.debouncedUpdateTimeout), this.debouncedUpdateTimeout = setTimeout((function() {
          var e2 = this.getInputValue();
          this.setOriginalInputValue(e2), this.settings.onChangeAfterBlur && (t2 || {}).withoutChangeEvent || this.state.blockChangeEvent || this.triggerChangeEvent();
          this.postUpdate();
        }).bind(this), 100);
      }, getInputValue() {
        var t2 = this.getCleanValue();
        return "mix" == this.settings.mode ? this.getMixedTagsAsString(t2) : t2.length ? this.settings.originalInputValueFormat ? this.settings.originalInputValueFormat(t2) : JSON.stringify(t2) : "";
      }, getCleanValue(t2) {
        return a(t2 || this.value, this.dataProps);
      }, getMixedTagsAsString() {
        var t2 = "", e2 = this, i2 = this.settings, s2 = i2.originalInputValueFormat || JSON.stringify, a2 = i2.mixTagsInterpolator;
        return function i3(o2) {
          o2.childNodes.forEach((o3) => {
            if (1 == o3.nodeType) {
              const r2 = T(o3);
              if ("BR" == o3.tagName && (t2 += "\r\n"), r2 && v.call(e2, o3)) {
                if (r2.__removed) return;
                t2 += a2[0] + s2(n(r2, e2.dataProps)) + a2[1];
              } else o3.getAttribute("style") || ["B", "I", "U"].includes(o3.tagName) ? t2 += o3.textContent : "DIV" != o3.tagName && "P" != o3.tagName || (t2 += "\r\n", i3(o3));
            } else t2 += o3.textContent;
          });
        }(this.DOM.input), t2;
      } }, S.prototype.removeTag = S.prototype.removeTags, S;
    });
  }
});
export default require_tagify_min();
//# sourceMappingURL=@yaireo_tagify.js.map
