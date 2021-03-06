! function(t, e, n) {
    ! function(t) {
        "use strict";
        "function" == typeof define && define.amd ? define("datatables", ["jquery"], t) : "object" == typeof exports ? t(require("jquery")) : jQuery && !jQuery.fn.dataTable && t(jQuery)
    }(function(a) {
        "use strict";

        function r(t) {
            var e, n, o = "a aa ai ao as b fn i m o s ",
                i = {};
            a.each(t, function(a) {
                e = a.match(/^([^A-Z]+?)([A-Z])/), e && -1 !== o.indexOf(e[1] + " ") && (n = a.replace(e[0], e[2].toLowerCase()), i[n] = a, "o" === e[1] && r(t[a]))
            }), t._hungarianMap = i
        }

        function o(t, e, i) {
            t._hungarianMap || r(t);
            var s;
            a.each(e, function(r) {
                s = t._hungarianMap[r], s === n || !i && e[s] !== n || ("o" === s.charAt(0) ? (e[s] || (e[s] = {}), a.extend(!0, e[s], e[r]), o(t[s], e[s], i)) : e[s] = e[r])
            })
        }

        function i(t) {
            var e = Ge.defaults.oLanguage,
                n = t.sZeroRecords;
            !t.sEmptyTable && n && "No data available in table" === e.sEmptyTable && Ne(t, t, "sZeroRecords", "sEmptyTable"), !t.sLoadingRecords && n && "Loading..." === e.sLoadingRecords && Ne(t, t, "sZeroRecords", "sLoadingRecords"), t.sInfoThousands && (t.sThousands = t.sInfoThousands);
            var a = t.sDecimal;
            a && Ve(a)
        }

        function s(t) {
            bn(t, "ordering", "bSort"), bn(t, "orderMulti", "bSortMulti"), bn(t, "orderClasses", "bSortClasses"), bn(t, "orderCellsTop", "bSortCellsTop"), bn(t, "order", "aaSorting"), bn(t, "orderFixed", "aaSortingFixed"), bn(t, "paging", "bPaginate"), bn(t, "pagingType", "sPaginationType"), bn(t, "pageLength", "iDisplayLength"), bn(t, "searching", "bFilter")
        }

        function l(t) {
            bn(t, "orderable", "bSortable"), bn(t, "orderData", "aDataSort"), bn(t, "orderSequence", "asSorting"), bn(t, "orderDataType", "sortDataType")
        }

        function u(t) {
            var e = t.oBrowser,
                n = a("<div/>").css({
                    position: "absolute",
                    top: 0,
                    left: 0,
                    height: 1,
                    width: 1,
                    overflow: "hidden"
                }).append(a("<div/>").css({
                    position: "absolute",
                    top: 1,
                    left: 1,
                    width: 100,
                    overflow: "scroll"
                }).append(a('<div class="test"/>').css({
                    width: "100%",
                    height: 10
                }))).appendTo("body"),
                r = n.find(".test");
            e.bScrollOversize = 100 === r[0].offsetWidth, e.bScrollbarLeft = 1 !== r.offset().left, n.remove()
        }

        function c(t, e, a, r, o, i) {
            var s, l = r,
                u = !1;
            for (a !== n && (s = a, u = !0); l !== o;) t.hasOwnProperty(l) && (s = u ? e(s, t[l], l, t) : t[l], u = !0, l += i);
            return s
        }

        function f(t, n) {
            var r = Ge.defaults.column,
                o = t.aoColumns.length,
                i = a.extend({}, Ge.models.oColumn, r, {
                    nTh: n ? n : e.createElement("th"),
                    sTitle: r.sTitle ? r.sTitle : n ? n.innerHTML : "",
                    aDataSort: r.aDataSort ? r.aDataSort : [o],
                    mData: r.mData ? r.mData : o,
                    idx: o
                });
            t.aoColumns.push(i);
            var s = t.aoPreSearchCols;
            s[o] = a.extend({}, Ge.models.oSearch, s[o]), d(t, o, null)
        }

        function d(t, e, r) {
            var i = t.aoColumns[e],
                s = t.oClasses,
                u = a(i.nTh);
            if (!i.sWidthOrig) {
                i.sWidthOrig = u.attr("width") || null;
                var c = (u.attr("style") || "").match(/width:\s*(\d+[pxem%]+)/);
                c && (i.sWidthOrig = c[1])
            }
            r !== n && null !== r && (l(r), o(Ge.defaults.column, r), r.mDataProp === n || r.mData || (r.mData = r.mDataProp), r.sType && (i._sManualType = r.sType), r.className && !r.sClass && (r.sClass = r.className), a.extend(i, r), Ne(i, r, "sWidth", "sWidthOrig"), "number" == typeof r.iDataSort && (i.aDataSort = [r.iDataSort]), Ne(i, r, "aDataSort"));
            var f = i.mData,
                d = I(f),
                h = i.mRender ? I(i.mRender) : null,
                p = function(t) {
                    return "string" == typeof t && -1 !== t.indexOf("@")
                };
            i._bAttrSrc = a.isPlainObject(f) && (p(f.sort) || p(f.type) || p(f.filter)), i.fnGetData = function(t, e, a) {
                var r = d(t, e, n, a);
                return h && e ? h(r, e, t, a) : r
            }, i.fnSetData = function(t, e, n) {
                return A(f)(t, e, n)
            }, t.oFeatures.bSort || (i.bSortable = !1, u.addClass(s.sSortableNone));
            var g = -1 !== a.inArray("asc", i.asSorting),
                b = -1 !== a.inArray("desc", i.asSorting);
            i.bSortable && (g || b) ? g && !b ? (i.sSortingClass = s.sSortableAsc, i.sSortingClassJUI = s.sSortJUIAscAllowed) : !g && b ? (i.sSortingClass = s.sSortableDesc, i.sSortingClassJUI = s.sSortJUIDescAllowed) : (i.sSortingClass = s.sSortable, i.sSortingClassJUI = s.sSortJUI) : (i.sSortingClass = s.sSortableNone, i.sSortingClassJUI = "")
        }

        function h(t) {
            if (t.oFeatures.bAutoWidth !== !1) {
                var e = t.aoColumns;
                be(t);
                for (var n = 0, a = e.length; a > n; n++) e[n].nTh.style.width = e[n].sWidth
            }
            var r = t.oScroll;
            ("" !== r.sY || "" !== r.sX) && pe(t), Me(t, null, "column-sizing", [t])
        }

        function p(t, e) {
            var n = v(t, "bVisible");
            return "number" == typeof n[e] ? n[e] : null
        }

        function g(t, e) {
            var n = v(t, "bVisible"),
                r = a.inArray(e, n);
            return -1 !== r ? r : null
        }

        function b(t) {
            return v(t, "bVisible").length
        }

        function v(t, e) {
            var n = [];
            return a.map(t.aoColumns, function(t, a) {
                t[e] && n.push(a)
            }), n
        }

        function S(t) {
            var e, a, r, o, i, s, l, u, c, f = t.aoColumns,
                d = t.aoData,
                h = Ge.ext.type.detect;
            for (e = 0, a = f.length; a > e; e++)
                if (l = f[e], c = [], !l.sType && l._sManualType) l.sType = l._sManualType;
                else if (!l.sType) {
                for (r = 0, o = h.length; o > r; r++) {
                    for (i = 0, s = d.length; s > i && (c[i] === n && (c[i] = T(t, i, e, "type")), u = h[r](c[i], t), u && "html" !== u); i++);
                    if (u) {
                        l.sType = u;
                        break
                    }
                }
                l.sType || (l.sType = "string")
            }
        }

        function m(t, e, r, o) {
            var i, s, l, u, c, d, h, p = t.aoColumns;
            if (e)
                for (i = e.length - 1; i >= 0; i--) {
                    h = e[i];
                    var g = h.targets !== n ? h.targets : h.aTargets;
                    for (a.isArray(g) || (g = [g]), l = 0, u = g.length; u > l; l++)
                        if ("number" == typeof g[l] && g[l] >= 0) {
                            for (; p.length <= g[l];) f(t);
                            o(g[l], h)
                        } else if ("number" == typeof g[l] && g[l] < 0) o(p.length + g[l], h);
                    else if ("string" == typeof g[l])
                        for (c = 0, d = p.length; d > c; c++)("_all" == g[l] || a(p[c].nTh).hasClass(g[l])) && o(c, h)
                }
            if (r)
                for (i = 0, s = r.length; s > i; i++) o(i, r[i])
        }

        function D(t, e, n, r) {
            var o = t.aoData.length,
                i = a.extend(!0, {}, Ge.models.oRow, {
                    src: n ? "dom" : "data"
                });
            i._aData = e, t.aoData.push(i);
            for (var s = t.aoColumns, l = 0, u = s.length; u > l; l++) n && w(t, o, l, T(t, o, l)), s[l].sType = null;
            return t.aiDisplayMaster.push(o), t.oFeatures.bDeferRender || H(t, o, n, r), o
        }

        function y(t, e) {
            var n;
            return e instanceof a || (e = a(e)), e.map(function(e, a) {
                return n = j(t, a), D(t, n.data, a, n.cells)
            })
        }

        function _(t, e) {
            return e._DT_RowIndex !== n ? e._DT_RowIndex : null
        }

        function C(t, e, n) {
            return a.inArray(n, t.aoData[e].anCells)
        }

        function T(t, e, a, r) {
            var o = t.iDraw,
                i = t.aoColumns[a],
                s = t.aoData[e]._aData,
                l = i.sDefaultContent,
                u = i.fnGetData(s, r, {
                    settings: t,
                    row: e,
                    col: a
                });
            if (u === n) return t.iDrawError != o && null === l && (He(t, 0, "Requested unknown parameter " + ("function" == typeof i.mData ? "{function}" : "'" + i.mData + "'") + " for row " + e, 4), t.iDrawError = o), l;
            if (u !== s && null !== u || null === l) {
                if ("function" == typeof u) return u()
            } else u = l;
            return null === u && "display" == r ? "" : u
        }

        function w(t, e, n, a) {
            var r = t.aoColumns[n],
                o = t.aoData[e]._aData;
            r.fnSetData(o, a, {
                settings: t,
                row: e,
                col: n
            })
        }

        function x(t) {
            return a.map(t.match(/(\\.|[^\.])+/g), function(t) {
                return t.replace(/\\./g, ".")
            })
        }

        function I(t) {
            if (a.isPlainObject(t)) {
                var e = {};
                return a.each(t, function(t, n) {
                        n && (e[t] = I(n))
                    }),
                    function(t, a, r, o) {
                        var i = e[a] || e._;
                        return i !== n ? i(t, a, r, o) : t
                    }
            }
            if (null === t) return function(t) {
                return t
            };
            if ("function" == typeof t) return function(e, n, a, r) {
                return t(e, n, a, r)
            };
            if ("string" != typeof t || -1 === t.indexOf(".") && -1 === t.indexOf("[") && -1 === t.indexOf("(")) return function(e) {
                return e[t]
            };
            var r = function(t, e, a) {
                var o, i, s, l;
                if ("" !== a)
                    for (var u = x(a), c = 0, f = u.length; f > c; c++) {
                        if (o = u[c].match(vn), i = u[c].match(Sn), o) {
                            u[c] = u[c].replace(vn, ""), "" !== u[c] && (t = t[u[c]]), s = [], u.splice(0, c + 1), l = u.join(".");
                            for (var d = 0, h = t.length; h > d; d++) s.push(r(t[d], e, l));
                            var p = o[0].substring(1, o[0].length - 1);
                            t = "" === p ? s : s.join(p);
                            break
                        }
                        if (i) u[c] = u[c].replace(Sn, ""), t = t[u[c]]();
                        else {
                            if (null === t || t[u[c]] === n) return n;
                            t = t[u[c]]
                        }
                    }
                return t
            };
            return function(e, n) {
                return r(e, n, t)
            }
        }

        function A(t) {
            if (a.isPlainObject(t)) return A(t._);
            if (null === t) return function() {};
            if ("function" == typeof t) return function(e, n, a) {
                t(e, "set", n, a)
            };
            if ("string" != typeof t || -1 === t.indexOf(".") && -1 === t.indexOf("[") && -1 === t.indexOf("(")) return function(e, n) {
                e[t] = n
            };
            var e = function(t, a, r) {
                for (var o, i, s, l, u, c = x(r), f = c[c.length - 1], d = 0, h = c.length - 1; h > d; d++) {
                    if (i = c[d].match(vn), s = c[d].match(Sn), i) {
                        c[d] = c[d].replace(vn, ""), t[c[d]] = [], o = c.slice(), o.splice(0, d + 1), u = o.join(".");
                        for (var p = 0, g = a.length; g > p; p++) l = {}, e(l, a[p], u), t[c[d]].push(l);
                        return
                    }
                    s && (c[d] = c[d].replace(Sn, ""), t = t[c[d]](a)), (null === t[c[d]] || t[c[d]] === n) && (t[c[d]] = {}), t = t[c[d]]
                }
                f.match(Sn) ? t = t[f.replace(Sn, "")](a) : t[f.replace(vn, "")] = a
            };
            return function(n, a) {
                return e(n, a, t)
            }
        }

        function F(t) {
            return fn(t.aoData, "_aData")
        }

        function L(t) {
            t.aoData.length = 0, t.aiDisplayMaster.length = 0, t.aiDisplay.length = 0
        }

        function P(t, e, a) {
            for (var r = -1, o = 0, i = t.length; i > o; o++) t[o] == e ? r = o : t[o] > e && t[o] --; - 1 != r && a === n && t.splice(r, 1)
        }

        function R(t, e, a, r) {
            var o, i, s = t.aoData[e];
            if ("dom" !== a && (a && "auto" !== a || "dom" !== s.src)) {
                var l, u = s.anCells;
                if (u)
                    for (o = 0, i = u.length; i > o; o++) {
                        for (l = u[o]; l.childNodes;) l.removeChild(l.firstChild);
                        u[o].innerHTML = T(t, e, o, "display")
                    }
            } else s._aData = j(t, s).data;
            s._aSortData = null, s._aFilterData = null;
            var c = t.aoColumns;
            if (r !== n) c[r].sType = null;
            else
                for (o = 0, i = c.length; i > o; o++) c[o].sType = null;
            N(s)
        }

        function j(t, e) {
            var n, r, o, i, s = [],
                l = [],
                u = e.firstChild,
                c = 0,
                f = t.aoColumns,
                d = function(t, e, n) {
                    if ("string" == typeof t) {
                        var a = t.indexOf("@");
                        if (-1 !== a) {
                            var r = t.substring(a + 1);
                            o["@" + r] = n.getAttribute(r)
                        }
                    }
                },
                h = function(t) {
                    r = f[c], i = a.trim(t.innerHTML), r && r._bAttrSrc ? (o = {
                        display: i
                    }, d(r.mData.sort, o, t), d(r.mData.type, o, t), d(r.mData.filter, o, t), s.push(o)) : s.push(i), c++
                };
            if (u)
                for (; u;) n = u.nodeName.toUpperCase(), ("TD" == n || "TH" == n) && (h(u), l.push(u)), u = u.nextSibling;
            else {
                l = e.anCells;
                for (var p = 0, g = l.length; g > p; p++) h(l[p])
            }
            return {
                data: s,
                cells: l
            }
        }

        function H(t, n, a, r) {
            var o, i, s, l, u, c = t.aoData[n],
                f = c._aData,
                d = [];
            if (null === c.nTr) {
                for (o = a || e.createElement("tr"), c.nTr = o, c.anCells = d, o._DT_RowIndex = n, N(c), l = 0, u = t.aoColumns.length; u > l; l++) s = t.aoColumns[l], i = a ? r[l] : e.createElement(s.sCellType), d.push(i), (!a || s.mRender || s.mData !== l) && (i.innerHTML = T(t, n, l, "display")), s.sClass && (i.className += " " + s.sClass), s.bVisible && !a ? o.appendChild(i) : !s.bVisible && a && i.parentNode.removeChild(i), s.fnCreatedCell && s.fnCreatedCell.call(t.oInstance, i, T(t, n, l, "display"), f, n, l);
                Me(t, "aoRowCreatedCallback", null, [o, f, n])
            }
            c.nTr.setAttribute("role", "row")
        }

        function N(t) {
            var e = t.nTr,
                n = t._aData;
            if (e) {
                if (n.DT_RowId && (e.id = n.DT_RowId), n.DT_RowClass) {
                    var r = n.DT_RowClass.split(" ");
                    t.__rowc = t.__rowc ? gn(t.__rowc.concat(r)) : r, a(e).removeClass(t.__rowc.join(" ")).addClass(n.DT_RowClass)
                }
                n.DT_RowData && a(e).data(n.DT_RowData)
            }
        }

        function W(t) {
            var e, n, r, o, i, s = t.nTHead,
                l = t.nTFoot,
                u = 0 === a("th, td", s).length,
                c = t.oClasses,
                f = t.aoColumns;
            for (u && (o = a("<tr/>").appendTo(s)), e = 0, n = f.length; n > e; e++) i = f[e], r = a(i.nTh).addClass(i.sClass), u && r.appendTo(o), t.oFeatures.bSort && (r.addClass(i.sSortingClass), i.bSortable !== !1 && (r.attr("tabindex", t.iTabIndex).attr("aria-controls", t.sTableId), Ae(t, i.nTh, e))), i.sTitle != r.html() && r.html(i.sTitle), Ee(t, "header")(t, r, i, c);
            if (u && E(t.aoHeader, s), a(s).find(">tr").attr("role", "row"), a(s).find(">tr>th, >tr>td").addClass(c.sHeaderTH), a(l).find(">tr>th, >tr>td").addClass(c.sFooterTH), null !== l) {
                var d = t.aoFooter[0];
                for (e = 0, n = d.length; n > e; e++) i = f[e], i.nTf = d[e].cell, i.sClass && a(i.nTf).addClass(i.sClass)
            }
        }

        function k(t, e, r) {
            var o, i, s, l, u, c, f, d, h, p = [],
                g = [],
                b = t.aoColumns.length;
            if (e) {
                for (r === n && (r = !1), o = 0, i = e.length; i > o; o++) {
                    for (p[o] = e[o].slice(), p[o].nTr = e[o].nTr, s = b - 1; s >= 0; s--) t.aoColumns[s].bVisible || r || p[o].splice(s, 1);
                    g.push([])
                }
                for (o = 0, i = p.length; i > o; o++) {
                    if (f = p[o].nTr)
                        for (; c = f.firstChild;) f.removeChild(c);
                    for (s = 0, l = p[o].length; l > s; s++)
                        if (d = 1, h = 1, g[o][s] === n) {
                            for (f.appendChild(p[o][s].cell), g[o][s] = 1; p[o + d] !== n && p[o][s].cell == p[o + d][s].cell;) g[o + d][s] = 1, d++;
                            for (; p[o][s + h] !== n && p[o][s].cell == p[o][s + h].cell;) {
                                for (u = 0; d > u; u++) g[o + u][s + h] = 1;
                                h++
                            }
                            a(p[o][s].cell).attr("rowspan", d).attr("colspan", h)
                        }
                }
            }
        }

        function O(t) {
            var e = Me(t, "aoPreDrawCallback", "preDraw", [t]);
            if (-1 !== a.inArray(!1, e)) return void de(t, !1);
            var r = [],
                o = 0,
                i = t.asStripeClasses,
                s = i.length,
                l = (t.aoOpenRows.length, t.oLanguage),
                u = t.iInitDisplayStart,
                c = "ssp" == Je(t),
                f = t.aiDisplay;
            t.bDrawing = !0, u !== n && -1 !== u && (t._iDisplayStart = c ? u : u >= t.fnRecordsDisplay() ? 0 : u, t.iInitDisplayStart = -1);
            var d = t._iDisplayStart,
                h = t.fnDisplayEnd();
            if (t.bDeferLoading) t.bDeferLoading = !1, t.iDraw++, de(t, !1);
            else if (c) {
                if (!t.bDestroying && !V(t)) return
            } else t.iDraw++; if (0 !== f.length)
                for (var p = c ? 0 : d, g = c ? t.aoData.length : h, v = p; g > v; v++) {
                    var S = f[v],
                        m = t.aoData[S];
                    null === m.nTr && H(t, S);
                    var D = m.nTr;
                    if (0 !== s) {
                        var y = i[o % s];
                        m._sRowStripe != y && (a(D).removeClass(m._sRowStripe).addClass(y), m._sRowStripe = y)
                    }
                    Me(t, "aoRowCallback", null, [D, m._aData, o, v]), r.push(D), o++
                } else {
                    var _ = l.sZeroRecords;
                    1 == t.iDraw && "ajax" == Je(t) ? _ = l.sLoadingRecords : l.sEmptyTable && 0 === t.fnRecordsTotal() && (_ = l.sEmptyTable), r[0] = a("<tr/>", {
                        "class": s ? i[0] : ""
                    }).append(a("<td />", {
                        valign: "top",
                        colSpan: b(t),
                        "class": t.oClasses.sRowEmpty
                    }).html(_))[0]
                }
            Me(t, "aoHeaderCallback", "header", [a(t.nTHead).children("tr")[0], F(t), d, h, f]), Me(t, "aoFooterCallback", "footer", [a(t.nTFoot).children("tr")[0], F(t), d, h, f]);
            var C = a(t.nTBody);
            C.children().detach(), C.append(a(r)), Me(t, "aoDrawCallback", "draw", [t]), t.bSorted = !1, t.bFiltered = !1, t.bDrawing = !1
        }

        function M(t, e) {
            var n = t.oFeatures,
                a = n.bSort,
                r = n.bFilter;
            a && we(t), r ? Y(t, t.oPreviousSearch) : t.aiDisplay = t.aiDisplayMaster.slice(), e !== !0 && (t._iDisplayStart = 0), t._drawHold = e, O(t), t._drawHold = !1
        }

        function U(t) {
            var e = t.oClasses,
                n = a(t.nTable),
                r = a("<div/>").insertAfter(n),
                o = t.oFeatures,
                i = a("<div/>", {
                    id: t.sTableId + "_wrapper",
                    "class": e.sWrapper + (t.nTFoot ? "" : " " + e.sNoFooter)
                });
            t.nTableWrapper = i[0], t.nTableReinsertBefore = t.nTable.nextSibling, t.nHolding = r[0];
            for (var s, l, u, c, f, d, h = t.sDom.split(""), p = 0; p < h.length; p++) {
                if (s = null, l = h[p], "<" == l) {
                    if (u = a("<div/>")[0], c = h[p + 1], "'" == c || '"' == c) {
                        for (f = "", d = 2; h[p + d] != c;) f += h[p + d], d++;
                        if ("H" == f ? f = e.sJUIHeader : "F" == f && (f = e.sJUIFooter), -1 != f.indexOf(".")) {
                            var g = f.split(".");
                            u.id = g[0].substr(1, g[0].length - 1), u.className = g[1]
                        } else "#" == f.charAt(0) ? u.id = f.substr(1, f.length - 1) : u.className = f;
                        p += d
                    }
                    i.append(u), i = a(u)
                } else if (">" == l) i = i.parent();
                else if ("f" == l && o.bFilter) s = $(t);
                else if ("r" == l && o.bProcessing) s = fe(t);
                else if ("t" == l) s = he(t);
                else if ("l" == l && o.bPaginate && o.bLengthChange) s = le(t);
                else if ("i" == l && o.bInfo) s = ne(t);
                else if ("p" == l && o.bPaginate) s = ue(t);
                else if (0 !== Ge.ext.feature.length)
                    for (var b = Ge.ext.feature, v = 0, S = b.length; S > v; v++)
                        if (l == b[v].cFeature) {
                            s = b[v].fnInit(t);
                            break
                        }
                if (s) {
                    var m = t.aanFeatures;
                    m[l] || (m[l] = []), m[l].push(s), i.append(s)
                }
            }
            r.replaceWith(i)
        }

        function E(t, e) {
            var n, r, o, i, s, l, u, c, f, d, h, p = a(e).children("tr"),
                g = function(t, e, n) {
                    for (var a = t[e]; a[n];) n++;
                    return n
                };
            for (t.splice(0, t.length), o = 0, l = p.length; l > o; o++) t.push([]);
            for (o = 0, l = p.length; l > o; o++)
                for (n = p[o], c = 0, r = n.firstChild; r;) {
                    if ("TD" == r.nodeName.toUpperCase() || "TH" == r.nodeName.toUpperCase())
                        for (f = 1 * r.getAttribute("colspan"), d = 1 * r.getAttribute("rowspan"), f = f && 0 !== f && 1 !== f ? f : 1, d = d && 0 !== d && 1 !== d ? d : 1, u = g(t, o, c), h = 1 === f ? !0 : !1, s = 0; f > s; s++)
                            for (i = 0; d > i; i++) t[o + i][u + s] = {
                                cell: r,
                                unique: h
                            }, t[o + i].nTr = n;
                    r = r.nextSibling
                }
        }

        function J(t, e, n) {
            var a = [];
            n || (n = t.aoHeader, e && (n = [], E(n, e)));
            for (var r = 0, o = n.length; o > r; r++)
                for (var i = 0, s = n[r].length; s > i; i++) !n[r][i].unique || a[i] && t.bSortCellsTop || (a[i] = n[r][i].cell);
            return a
        }

        function B(t, e, n) {
            if (Me(t, "aoServerParams", "serverParams", [e]), e && a.isArray(e)) {
                var r = {},
                    o = /(.*?)\[\]$/;
                a.each(e, function(t, e) {
                    var n = e.name.match(o);
                    if (n) {
                        var a = n[0];
                        r[a] || (r[a] = []), r[a].push(e.value)
                    } else r[e.name] = e.value
                }), e = r
            }
            var i, s = t.ajax,
                l = t.oInstance;
            if (a.isPlainObject(s) && s.data) {
                i = s.data;
                var u = a.isFunction(i) ? i(e) : i;
                e = a.isFunction(i) && u ? u : a.extend(!0, e, u), delete s.data
            }
            var c = {
                data: e,
                success: function(e) {
                    var a = e.error || e.sError;
                    a && t.oApi._fnLog(t, 0, a), t.json = e, Me(t, null, "xhr", [t, e]), n(e)
                },
                dataType: "json",
                cache: !1,
                type: t.sServerMethod,
                error: function(e, n) {
                    var a = t.oApi._fnLog;
                    "parsererror" == n ? a(t, 0, "Invalid JSON response", 1) : 4 === e.readyState && a(t, 0, "Ajax error", 7), de(t, !1)
                }
            };
            t.oAjaxData = e, Me(t, null, "preXhr", [t, e]), t.fnServerData ? t.fnServerData.call(l, t.sAjaxSource, a.map(e, function(t, e) {
                return {
                    name: e,
                    value: t
                }
            }), n, t) : t.sAjaxSource || "string" == typeof s ? t.jqXHR = a.ajax(a.extend(c, {
                url: s || t.sAjaxSource
            })) : a.isFunction(s) ? t.jqXHR = s.call(l, e, n, t) : (t.jqXHR = a.ajax(a.extend(c, s)), s.data = i)
        }

        function V(t) {
            return t.bAjaxDataGet ? (t.iDraw++, de(t, !0), B(t, X(t), function(e) {
                G(t, e)
            }), !1) : !0
        }

        function X(t) {
            var e, n, r, o, i = t.aoColumns,
                s = i.length,
                l = t.oFeatures,
                u = t.oPreviousSearch,
                c = t.aoPreSearchCols,
                f = [],
                d = Te(t),
                h = t._iDisplayStart,
                p = l.bPaginate !== !1 ? t._iDisplayLength : -1,
                g = function(t, e) {
                    f.push({
                        name: t,
                        value: e
                    })
                };
            g("sEcho", t.iDraw), g("iColumns", s), g("sColumns", fn(i, "sName").join(",")), g("iDisplayStart", h), g("iDisplayLength", p);
            var b = {
                draw: t.iDraw,
                columns: [],
                order: [],
                start: h,
                length: p,
                search: {
                    value: u.sSearch,
                    regex: u.bRegex
                }
            };
            for (e = 0; s > e; e++) r = i[e], o = c[e], n = "function" == typeof r.mData ? "function" : r.mData, b.columns.push({
                data: n,
                name: r.sName,
                searchable: r.bSearchable,
                orderable: r.bSortable,
                search: {
                    value: o.sSearch,
                    regex: o.bRegex
                }
            }), g("mDataProp_" + e, n), l.bFilter && (g("sSearch_" + e, o.sSearch), g("bRegex_" + e, o.bRegex), g("bSearchable_" + e, r.bSearchable)), l.bSort && g("bSortable_" + e, r.bSortable);
            l.bFilter && (g("sSearch", u.sSearch), g("bRegex", u.bRegex)), l.bSort && (a.each(d, function(t, e) {
                b.order.push({
                    column: e.col,
                    dir: e.dir
                }), g("iSortCol_" + t, e.col), g("sSortDir_" + t, e.dir)
            }), g("iSortingCols", d.length));
            var v = Ge.ext.legacy.ajax;
            return null === v ? t.sAjaxSource ? f : b : v ? f : b
        }

        function G(t, e) {
            var a = function(t, a) {
                    return e[t] !== n ? e[t] : e[a]
                },
                r = a("sEcho", "draw"),
                o = a("iTotalRecords", "recordsTotal"),
                i = a("iTotalDisplayRecords", "recordsFiltered");
            if (r) {
                if (1 * r < t.iDraw) return;
                t.iDraw = 1 * r
            }
            L(t), t._iRecordsTotal = parseInt(o, 10), t._iRecordsDisplay = parseInt(i, 10);
            for (var s = q(t, e), l = 0, u = s.length; u > l; l++) D(t, s[l]);
            t.aiDisplay = t.aiDisplayMaster.slice(), t.bAjaxDataGet = !1, O(t), t._bInitComplete || ie(t, e), t.bAjaxDataGet = !0, de(t, !1)
        }

        function q(t, e) {
            var r = a.isPlainObject(t.ajax) && t.ajax.dataSrc !== n ? t.ajax.dataSrc : t.sAjaxDataProp;
            return "data" === r ? e.aaData || e[r] : "" !== r ? I(r)(e) : e
        }

        function $(t) {
            var n = t.oClasses,
                r = t.sTableId,
                o = t.oLanguage,
                i = t.oPreviousSearch,
                s = t.aanFeatures,
                l = '<input type="search" class="' + n.sFilterInput + '"/>',
                u = o.sSearch;
            u = u.match(/_INPUT_/) ? u.replace("_INPUT_", l) : u + l;
            var c = a("<div/>", {
                    id: s.f ? null : r + "_filter",
                    "class": n.sFilter
                }).append(a("<label/>").append(u)),
                f = function() {
                    var e = (s.f, this.value ? this.value : "");
                    e != i.sSearch && (Y(t, {
                        sSearch: e,
                        bRegex: i.bRegex,
                        bSmart: i.bSmart,
                        bCaseInsensitive: i.bCaseInsensitive
                    }), t._iDisplayStart = 0, O(t))
                },
                d = a("input", c).val(i.sSearch).attr("placeholder", o.sSearchPlaceholder).bind("keyup.DT search.DT input.DT paste.DT cut.DT", "ssp" === Je(t) ? ve(f, 400) : f).bind("keypress.DT", function(t) {
                    return 13 == t.keyCode ? !1 : void 0
                }).attr("aria-controls", r);
            return a(t.nTable).on("search.dt.DT", function(n, a) {
                if (t === a) try {
                    d[0] !== e.activeElement && d.val(i.sSearch)
                } catch (r) {}
            }), c[0]
        }

        function Y(t, e, a) {
            var r = t.oPreviousSearch,
                o = t.aoPreSearchCols,
                i = function(t) {
                    r.sSearch = t.sSearch, r.bRegex = t.bRegex, r.bSmart = t.bSmart, r.bCaseInsensitive = t.bCaseInsensitive
                },
                s = function(t) {
                    return t.bEscapeRegex !== n ? !t.bEscapeRegex : t.bRegex
                };
            if (S(t), "ssp" != Je(t)) {
                Z(t, e.sSearch, a, s(e), e.bSmart, e.bCaseInsensitive), i(e);
                for (var l = 0; l < o.length; l++) Q(t, o[l].sSearch, l, s(o[l]), o[l].bSmart, o[l].bCaseInsensitive);
                z(t)
            } else i(e);
            t.bFiltered = !0, Me(t, null, "search", [t])
        }

        function z(t) {
            for (var e, n, a = Ge.ext.search, r = t.aiDisplay, o = 0, i = a.length; i > o; o++) {
                for (var s = [], l = 0, u = r.length; u > l; l++) n = r[l], e = t.aoData[n], a[o](t, e._aFilterData, n, e._aData, l) && s.push(n);
                r.length = 0, r.push.apply(r, s)
            }
        }

        function Q(t, e, n, a, r, o) {
            if ("" !== e)
                for (var i, s = t.aiDisplay, l = K(e, a, r, o), u = s.length - 1; u >= 0; u--) i = t.aoData[s[u]]._aFilterData[n], l.test(i) || s.splice(u, 1)
        }

        function Z(t, e, n, a, r, o) {
            var i, s, l, u = K(e, a, r, o),
                c = t.oPreviousSearch.sSearch,
                f = t.aiDisplayMaster;
            if (0 !== Ge.ext.search.length && (n = !0), s = ee(t), e.length <= 0) t.aiDisplay = f.slice();
            else
                for ((s || n || c.length > e.length || 0 !== e.indexOf(c) || t.bSorted) && (t.aiDisplay = f.slice()), i = t.aiDisplay, l = i.length - 1; l >= 0; l--) u.test(t.aoData[i[l]]._sFilterRow) || i.splice(l, 1)
        }

        function K(t, e, n, r) {
            if (t = e ? t : te(t), n) {
                var o = a.map(t.match(/"[^"]+"|[^ ]+/g) || "", function(t) {
                    return '"' === t.charAt(0) ? t.match(/^"(.*)"$/)[1] : t
                });
                t = "^(?=.*?" + o.join(")(?=.*?") + ").*$"
            }
            return new RegExp(t, r ? "i" : "")
        }

        function te(t) {
            return t.replace(nn, "\\$1")
        }

        function ee(t) {
            var e, n, a, r, o, i, s, l, u = t.aoColumns,
                c = Ge.ext.type.search,
                f = !1;
            for (n = 0, r = t.aoData.length; r > n; n++)
                if (l = t.aoData[n], !l._aFilterData) {
                    for (i = [], a = 0, o = u.length; o > a; a++) e = u[a], e.bSearchable ? (s = T(t, n, a, "filter"), s = c[e.sType] ? c[e.sType](s) : null !== s ? s : "") : s = "", s.indexOf && -1 !== s.indexOf("&") && (mn.innerHTML = s, s = Dn ? mn.textContent : mn.innerText), s.replace && (s = s.replace(/[\r\n]/g, "")), i.push(s);
                    l._aFilterData = i, l._sFilterRow = i.join("  "), f = !0
                }
            return f
        }

        function ne(t) {
            var e = t.sTableId,
                n = t.aanFeatures.i,
                r = a("<div/>", {
                    "class": t.oClasses.sInfo,
                    id: n ? null : e + "_info"
                });
            return n || (t.aoDrawCallback.push({
                fn: ae,
                sName: "information"
            }), r.attr("role", "status").attr("aria-live", "polite"), a(t.nTable).attr("aria-describedby", e + "_info")), r[0]
        }

        function ae(t) {
            var e = t.aanFeatures.i;
            if (0 !== e.length) {
                var n = t.oLanguage,
                    r = t._iDisplayStart + 1,
                    o = t.fnDisplayEnd(),
                    i = t.fnRecordsTotal(),
                    s = t.fnRecordsDisplay(),
                    l = s ? n.sInfo : n.sInfoEmpty;
                s !== i && (l += " " + n.sInfoFiltered), l += n.sInfoPostFix, l = re(t, l);
                var u = n.fnInfoCallback;
                null !== u && (l = u.call(t.oInstance, t, r, o, i, s, l)), a(e).html(l)
            }
        }

        function re(t, e) {
            var n = t.fnFormatNumber,
                a = t._iDisplayStart + 1,
                r = t._iDisplayLength,
                o = t.fnRecordsDisplay(),
                i = -1 === r;
            return e.replace(/_START_/g, n.call(t, a)).replace(/_END_/g, n.call(t, t.fnDisplayEnd())).replace(/_MAX_/g, n.call(t, t.fnRecordsTotal())).replace(/_TOTAL_/g, n.call(t, o)).replace(/_PAGE_/g, n.call(t, i ? 1 : Math.ceil(a / r))).replace(/_PAGES_/g, n.call(t, i ? 1 : Math.ceil(o / r)))
        }

        function oe(t) {
            var e, n, a, r = t.iInitDisplayStart,
                o = t.aoColumns,
                i = t.oFeatures;
            if (!t.bInitialised) return void setTimeout(function() {
                oe(t)
            }, 200);
            for (U(t), W(t), k(t, t.aoHeader), k(t, t.aoFooter), de(t, !0), i.bAutoWidth && be(t), e = 0, n = o.length; n > e; e++) a = o[e], a.sWidth && (a.nTh.style.width = _e(a.sWidth));
            M(t);
            var s = Je(t);
            "ssp" != s && ("ajax" == s ? B(t, [], function(n) {
                var a = q(t, n);
                for (e = 0; e < a.length; e++) D(t, a[e]);
                t.iInitDisplayStart = r, M(t), de(t, !1), ie(t, n)
            }, t) : (de(t, !1), ie(t)))
        }

        function ie(t, e) {
            t._bInitComplete = !0, e && h(t), Me(t, "aoInitComplete", "init", [t, e])
        }

        function se(t, e) {
            var n = parseInt(e, 10);
            t._iDisplayLength = n, Ue(t), Me(t, null, "length", [t, n])
        }

        function le(t) {
            for (var e = t.oClasses, n = t.sTableId, r = t.aLengthMenu, o = a.isArray(r[0]), i = o ? r[0] : r, s = o ? r[1] : r, l = a("<select/>", {
                name: n + "_length",
                "aria-controls": n,
                "class": e.sLengthSelect
            }), u = 0, c = i.length; c > u; u++) l[0][u] = new Option(s[u], i[u]);
            var f = a("<div><label/></div>").addClass(e.sLength);
            return t.aanFeatures.l || (f[0].id = n + "_length"), f.children().append(t.oLanguage.sLengthMenu.replace("_MENU_", l[0].outerHTML)), a("select", f).val(t._iDisplayLength).bind("change.DT", function() {
                se(t, a(this).val()), O(t)
            }), a(t.nTable).bind("length.dt.DT", function(e, n, r) {
                t === n && a("select", f).val(r)
            }), f[0]
        }

        function ue(t) {
            var e = t.sPaginationType,
                n = Ge.ext.pager[e],
                r = "function" == typeof n,
                o = function(t) {
                    O(t)
                },
                i = a("<div/>").addClass(t.oClasses.sPaging + e)[0],
                s = t.aanFeatures;
            return r || n.fnInit(t, i, o), s.p || (i.id = t.sTableId + "_paginate", t.aoDrawCallback.push({
                fn: function(t) {
                    if (r) {
                        var e, a, i = t._iDisplayStart,
                            l = t._iDisplayLength,
                            u = t.fnRecordsDisplay(),
                            c = -1 === l,
                            f = c ? 0 : Math.ceil(i / l),
                            d = c ? 1 : Math.ceil(u / l),
                            h = n(f, d);
                        for (e = 0, a = s.p.length; a > e; e++) Ee(t, "pageButton")(t, s.p[e], e, h, f, d)
                    } else n.fnUpdate(t, o)
                },
                sName: "pagination"
            })), i
        }

        function ce(t, e, n) {
            var a = t._iDisplayStart,
                r = t._iDisplayLength,
                o = t.fnRecordsDisplay();
            0 === o || -1 === r ? a = 0 : "number" == typeof e ? (a = e * r, a > o && (a = 0)) : "first" == e ? a = 0 : "previous" == e ? (a = r >= 0 ? a - r : 0, 0 > a && (a = 0)) : "next" == e ? o > a + r && (a += r) : "last" == e ? a = Math.floor((o - 1) / r) * r : He(t, 0, "Unknown paging action: " + e, 5);
            var i = t._iDisplayStart !== a;
            return t._iDisplayStart = a, i && (Me(t, null, "page", [t]), n && O(t)), i
        }

        function fe(t) {
            return a("<div/>", {
                id: t.aanFeatures.r ? null : t.sTableId + "_processing",
                "class": t.oClasses.sProcessing
            }).html(t.oLanguage.sProcessing).insertBefore(t.nTable)[0]
        }

        function de(t, e) {
            t.oFeatures.bProcessing && a(t.aanFeatures.r).css("display", e ? "block" : "none"), Me(t, null, "processing", [t, e])
        }

        function he(t) {
            var e = a(t.nTable);
            e.attr("role", "grid");
            var n = t.oScroll;
            if ("" === n.sX && "" === n.sY) return t.nTable;
            var r = n.sX,
                o = n.sY,
                i = t.oClasses,
                s = e.children("caption"),
                l = s.length ? s[0]._captionSide : null,
                u = a(e[0].cloneNode(!1)),
                c = a(e[0].cloneNode(!1)),
                f = e.children("tfoot"),
                d = "<div/>",
                h = function(t) {
                    return t ? _e(t) : null
                };
            n.sX && "100%" === e.attr("width") && e.removeAttr("width"), f.length || (f = null);
            var p = a(d, {
                "class": i.sScrollWrapper
            }).append(a(d, {
                "class": i.sScrollHead
            }).css({
                overflow: "hidden",
                position: "relative",
                border: 0,
                width: r ? h(r) : "100%"
            }).append(a(d, {
                "class": i.sScrollHeadInner
            }).css({
                "box-sizing": "content-box",
                width: n.sXInner || "100%"
            }).append(u.removeAttr("id").css("margin-left", 0).append(e.children("thead")))).append("top" === l ? s : null)).append(a(d, {
                "class": i.sScrollBody
            }).css({
                overflow: "auto",
                height: h(o),
                width: h(r)
            }).append(e));
            f && p.append(a(d, {
                "class": i.sScrollFoot
            }).css({
                overflow: "hidden",
                border: 0,
                width: r ? h(r) : "100%"
            }).append(a(d, {
                "class": i.sScrollFootInner
            }).append(c.removeAttr("id").css("margin-left", 0).append(e.children("tfoot")))).append("bottom" === l ? s : null));
            var g = p.children(),
                b = g[0],
                v = g[1],
                S = f ? g[2] : null;
            return r && a(v).scroll(function() {
                var t = this.scrollLeft;
                b.scrollLeft = t, f && (S.scrollLeft = t)
            }), t.nScrollHead = b, t.nScrollBody = v, t.nScrollFoot = S, t.aoDrawCallback.push({
                fn: pe,
                sName: "scrolling"
            }), p[0]
        }

        function pe(t) {
            var e, n, r, o, i, s, l, u, c, f = t.oScroll,
                d = f.sX,
                h = f.sXInner,
                g = f.sY,
                b = f.iBarWidth,
                v = a(t.nScrollHead),
                S = v[0].style,
                m = v.children("div"),
                D = m[0].style,
                y = m.children("table"),
                _ = t.nScrollBody,
                C = a(_),
                T = _.style,
                w = a(t.nScrollFoot),
                x = w.children("div"),
                I = x.children("table"),
                A = a(t.nTHead),
                F = a(t.nTable),
                L = F[0],
                P = L.style,
                R = t.nTFoot ? a(t.nTFoot) : null,
                j = t.oBrowser,
                H = j.bScrollOversize,
                N = [],
                W = [],
                k = [],
                O = function(t) {
                    var e = t.style;
                    e.paddingTop = "0", e.paddingBottom = "0", e.borderTopWidth = "0", e.borderBottomWidth = "0", e.height = 0
                };
            if (F.children("thead, tfoot").remove(), i = A.clone().prependTo(F), e = A.find("tr"), r = i.find("tr"), i.find("th, td").removeAttr("tabindex"), R && (s = R.clone().prependTo(F), n = R.find("tr"), o = s.find("tr")), d || (T.width = "100%", v[0].style.width = "100%"), a.each(J(t, i), function(e, n) {
                l = p(t, e), n.style.width = t.aoColumns[l].sWidth
            }), R && ge(function(t) {
                t.style.width = ""
            }, o), f.bCollapse && "" !== g && (T.height = C[0].offsetHeight + A[0].offsetHeight + "px"), c = F.outerWidth(), "" === d ? (P.width = "100%", H && (F.find("tbody").height() > _.offsetHeight || "scroll" == C.css("overflow-y")) && (P.width = _e(F.outerWidth() - b))) : "" !== h ? P.width = _e(h) : c == C.width() && C.height() < F.height() ? (P.width = _e(c - b), F.outerWidth() > c - b && (P.width = _e(c))) : P.width = _e(c), c = F.outerWidth(), ge(O, r), ge(function(t) {
                k.push(t.innerHTML), N.push(_e(a(t).css("width")))
            }, r), ge(function(t, e) {
                t.style.width = N[e]
            }, e), a(r).height(0), R && (ge(O, o), ge(function(t) {
                W.push(_e(a(t).css("width")))
            }, o), ge(function(t, e) {
                t.style.width = W[e]
            }, n), a(o).height(0)), ge(function(t, e) {
                t.innerHTML = '<div class="dataTables_sizing" style="height:0;overflow:hidden;">' + k[e] + "</div>", t.style.width = N[e]
            }, r), R && ge(function(t, e) {
                t.innerHTML = "", t.style.width = W[e]
            }, o), F.outerWidth() < c ? (u = _.scrollHeight > _.offsetHeight || "scroll" == C.css("overflow-y") ? c + b : c, H && (_.scrollHeight > _.offsetHeight || "scroll" == C.css("overflow-y")) && (P.width = _e(u - b)), ("" === d || "" !== h) && He(t, 1, "Possible column misalignment", 6)) : u = "100%", T.width = _e(u), S.width = _e(u), R && (t.nScrollFoot.style.width = _e(u)), g || H && (T.height = _e(L.offsetHeight + b)), g && f.bCollapse) {
                T.height = _e(g);
                var M = d && L.offsetWidth > _.offsetWidth ? b : 0;
                L.offsetHeight < _.offsetHeight && (T.height = _e(L.offsetHeight + M))
            }
            var U = F.outerWidth();
            y[0].style.width = _e(U), D.width = _e(U);
            var E = F.height() > _.clientHeight || "scroll" == C.css("overflow-y"),
                B = "padding" + (j.bScrollbarLeft ? "Left" : "Right");
            D[B] = E ? b + "px" : "0px", R && (I[0].style.width = _e(U), x[0].style.width = _e(U), x[0].style[B] = E ? b + "px" : "0px"), C.scroll(), !t.bSorted && !t.bFiltered || t._drawHold || (_.scrollTop = 0)
        }

        function ge(t, e, n) {
            for (var a, r, o = 0, i = 0, s = e.length; s > i;) {
                for (a = e[i].firstChild, r = n ? n[i].firstChild : null; a;) 1 === a.nodeType && (n ? t(a, r, o) : t(a, o), o++), a = a.nextSibling, r = n ? r.nextSibling : null;
                i++
            }
        }

        function be(e) {
            var n, r, o, i, s, l = e.nTable,
                u = e.aoColumns,
                c = e.oScroll,
                f = c.sY,
                d = c.sX,
                p = c.sXInner,
                g = u.length,
                S = v(e, "bVisible"),
                m = a("th", e.nTHead),
                D = l.getAttribute("width"),
                y = l.parentNode,
                _ = !1;
            for (n = 0; n < S.length; n++) r = u[S[n]], null !== r.sWidth && (r.sWidth = Se(r.sWidthOrig, y), _ = !0);
            if (_ || d || f || g != b(e) || g != m.length) {
                var C = a(l).clone().empty().css("visibility", "hidden").removeAttr("id").append(a(e.nTHead).clone(!1)).append(a(e.nTFoot).clone(!1)).append(a("<tbody><tr/></tbody>"));
                C.find("tfoot th, tfoot td").css("width", "");
                var T = C.find("tbody tr");
                for (m = J(e, C.find("thead")[0]), n = 0; n < S.length; n++) r = u[S[n]], m[n].style.width = null !== r.sWidthOrig && "" !== r.sWidthOrig ? _e(r.sWidthOrig) : "";
                if (e.aoData.length)
                    for (n = 0; n < S.length; n++) o = S[n], r = u[o], a(De(e, o)).clone(!1).append(r.sContentPadding).appendTo(T);
                if (C.appendTo(y), d && p ? C.width(p) : d ? (C.css("width", "auto"), C.width() < y.offsetWidth && C.width(y.offsetWidth)) : f ? C.width(y.offsetWidth) : D && C.width(D), me(e, C[0]), d) {
                    var w = 0;
                    for (n = 0; n < S.length; n++) r = u[S[n]], s = a(m[n]).outerWidth(), w += null === r.sWidthOrig ? s : parseInt(r.sWidth, 10) + s - a(m[n]).width();
                    C.width(_e(w)), l.style.width = _e(w)
                }
                for (n = 0; n < S.length; n++) r = u[S[n]], i = a(m[n]).width(), i && (r.sWidth = _e(i));
                l.style.width = _e(C.css("width")), C.remove()
            } else
                for (n = 0; g > n; n++) u[n].sWidth = _e(m.eq(n).width());
            D && (l.style.width = _e(D)), !D && !d || e._reszEvt || (a(t).bind("resize.DT-" + e.sInstance, ve(function() {
                h(e)
            })), e._reszEvt = !0)
        }

        function ve(t, e) {
            var a, r, o = e || 200;
            return function() {
                var e = this,
                    i = +new Date,
                    s = arguments;
                a && a + o > i ? (clearTimeout(r), r = setTimeout(function() {
                    a = n, t.apply(e, s)
                }, o)) : a ? (a = i, t.apply(e, s)) : a = i
            }
        }

        function Se(t, n) {
            if (!t) return 0;
            var r = a("<div/>").css("width", _e(t)).appendTo(n || e.body),
                o = r[0].offsetWidth;
            return r.remove(), o
        }

        function me(t, e) {
            var n = t.oScroll;
            if (n.sX || n.sY) {
                var r = n.sX ? 0 : n.iBarWidth;
                e.style.width = _e(a(e).outerWidth() - r)
            }
        }

        function De(t, e) {
            var n = ye(t, e);
            if (0 > n) return null;
            var r = t.aoData[n];
            return r.nTr ? r.anCells[e] : a("<td/>").html(T(t, n, e, "display"))[0]
        }

        function ye(t, e) {
            for (var n, a = -1, r = -1, o = 0, i = t.aoData.length; i > o; o++) n = T(t, o, e, "display") + "", n = n.replace(yn, ""), n.length > a && (a = n.length, r = o);
            return r
        }

        function _e(t) {
            return null === t ? "0px" : "number" == typeof t ? 0 > t ? "0px" : t + "px" : t.match(/\d$/) ? t + "px" : t
        }

        function Ce() {
            if (!Ge.__scrollbarWidth) {
                var t = a("<p/>").css({
                        width: "100%",
                        height: 200,
                        padding: 0
                    })[0],
                    e = a("<div/>").css({
                        position: "absolute",
                        top: 0,
                        left: 0,
                        width: 200,
                        height: 150,
                        padding: 0,
                        overflow: "hidden",
                        visibility: "hidden"
                    }).append(t).appendTo("body"),
                    n = t.offsetWidth;
                e.css("overflow", "scroll");
                var r = t.offsetWidth;
                n === r && (r = e[0].clientWidth), e.remove(), Ge.__scrollbarWidth = n - r
            }
            return Ge.__scrollbarWidth
        }

        function Te(t) {
            var e, n, r, o, i, s, l, u = [],
                c = t.aoColumns,
                f = t.aaSortingFixed,
                d = a.isPlainObject(f),
                h = [],
                p = function(t) {
                    t.length && !a.isArray(t[0]) ? h.push(t) : h.push.apply(h, t)
                };
            for (a.isArray(f) && p(f), d && f.pre && p(f.pre), p(t.aaSorting), d && f.post && p(f.post), e = 0; e < h.length; e++)
                for (l = h[e][0], o = c[l].aDataSort, n = 0, r = o.length; r > n; n++) i = o[n], s = c[i].sType || "string", u.push({
                    src: l,
                    col: i,
                    dir: h[e][1],
                    index: h[e][2],
                    type: s,
                    formatter: Ge.ext.type.order[s + "-pre"]
                });
            return u
        }

        function we(t) {
            var e, n, a, r, o, i = [],
                s = Ge.ext.type.order,
                l = t.aoData,
                u = (t.aoColumns, 0),
                c = t.aiDisplayMaster;
            for (S(t), o = Te(t), e = 0, n = o.length; n > e; e++) r = o[e], r.formatter && u++, Le(t, r.col);
            if ("ssp" != Je(t) && 0 !== o.length) {
                for (e = 0, a = c.length; a > e; e++) i[c[e]] = e;
                c.sort(u === o.length ? function(t, e) {
                    var n, a, r, s, u, c = o.length,
                        f = l[t]._aSortData,
                        d = l[e]._aSortData;
                    for (r = 0; c > r; r++)
                        if (u = o[r], n = f[u.col], a = d[u.col], s = a > n ? -1 : n > a ? 1 : 0, 0 !== s) return "asc" === u.dir ? s : -s;
                    return n = i[t], a = i[e], a > n ? -1 : n > a ? 1 : 0
                } : function(t, e) {
                    var n, a, r, u, c, f, d = o.length,
                        h = l[t]._aSortData,
                        p = l[e]._aSortData;
                    for (r = 0; d > r; r++)
                        if (c = o[r], n = h[c.col], a = p[c.col], f = s[c.type + "-" + c.dir] || s["string-" + c.dir], u = f(n, a), 0 !== u) return u;
                    return n = i[t], a = i[e], a > n ? -1 : n > a ? 1 : 0
                })
            }
            t.bSorted = !0
        }

        function xe(t) {
            for (var e, n, a = t.aoColumns, r = Te(t), o = t.oLanguage.oAria, i = 0, s = a.length; s > i; i++) {
                var l = a[i],
                    u = l.asSorting,
                    c = l.sTitle.replace(/<.*?>/g, ""),
                    f = l.nTh;
                f.removeAttribute("aria-sort"), l.bSortable ? (r.length > 0 && r[0].col == i ? (f.setAttribute("aria-sort", "asc" == r[0].dir ? "ascending" : "descending"), n = u[r[0].index + 1] || u[0]) : n = u[0], e = c + ("asc" === n ? o.sSortAscending : o.sSortDescending)) : e = c, f.setAttribute("aria-label", e)
            }
        }

        function Ie(t, e, r, o) {
            var i, s = t.aoColumns[e],
                l = t.aaSorting,
                u = s.asSorting,
                c = function(t) {
                    var e = t._idx;
                    return e === n && (e = a.inArray(t[1], u)), e + 1 >= u.length ? 0 : e + 1
                };
            if ("number" == typeof l[0] && (l = t.aaSorting = [l]), r && t.oFeatures.bSortMulti) {
                var f = a.inArray(e, fn(l, "0")); - 1 !== f ? (i = c(l[f]), l[f][1] = u[i], l[f]._idx = i) : (l.push([e, u[0], 0]), l[l.length - 1]._idx = 0)
            } else l.length && l[0][0] == e ? (i = c(l[0]), l.length = 1, l[0][1] = u[i], l[0]._idx = i) : (l.length = 0, l.push([e, u[0]]), l[0]._idx = 0);
            M(t), "function" == typeof o && o(t)
        }

        function Ae(t, e, n, a) {
            var r = t.aoColumns[n];
            ke(e, {}, function(e) {
                r.bSortable !== !1 && (t.oFeatures.bProcessing ? (de(t, !0), setTimeout(function() {
                    Ie(t, n, e.shiftKey, a), "ssp" !== Je(t) && de(t, !1)
                }, 0)) : Ie(t, n, e.shiftKey, a))
            })
        }

        function Fe(t) {
            var e, n, r, o = t.aLastSort,
                i = t.oClasses.sSortColumn,
                s = Te(t),
                l = t.oFeatures;
            if (l.bSort && l.bSortClasses) {
                for (e = 0, n = o.length; n > e; e++) r = o[e].src, a(fn(t.aoData, "anCells", r)).removeClass(i + (2 > e ? e + 1 : 3));
                for (e = 0, n = s.length; n > e; e++) r = s[e].src, a(fn(t.aoData, "anCells", r)).addClass(i + (2 > e ? e + 1 : 3))
            }
            t.aLastSort = s
        }

        function Le(t, e) {
            var n, a = t.aoColumns[e],
                r = Ge.ext.order[a.sSortDataType];
            r && (n = r.call(t.oInstance, t, e, g(t, e)));
            for (var o, i, s = Ge.ext.type.order[a.sType + "-pre"], l = 0, u = t.aoData.length; u > l; l++) o = t.aoData[l], o._aSortData || (o._aSortData = []), (!o._aSortData[e] || r) && (i = r ? n[l] : T(t, l, e, "sort"), o._aSortData[e] = s ? s(i) : i)
        }

        function Pe(t) {
            if (t.oFeatures.bStateSave && !t.bDestroying) {
                var e = {
                    iCreate: +new Date,
                    iStart: t._iDisplayStart,
                    iLength: t._iDisplayLength,
                    aaSorting: a.extend(!0, [], t.aaSorting),
                    oSearch: a.extend(!0, {}, t.oPreviousSearch),
                    aoSearchCols: a.extend(!0, [], t.aoPreSearchCols),
                    abVisCols: fn(t.aoColumns, "bVisible")
                };
                Me(t, "aoStateSaveParams", "stateSaveParams", [t, e]), t.fnStateSaveCallback.call(t.oInstance, t, e)
            }
        }

        function Re(t) {
            var e, n, r = t.aoColumns;
            if (t.oFeatures.bStateSave) {
                var o = t.fnStateLoadCallback.call(t.oInstance, t);
                if (o) {
                    var i = Me(t, "aoStateLoadParams", "stateLoadParams", [t, o]);
                    if (-1 === a.inArray(!1, i)) {
                        var s = t.iStateDuration;
                        if (!(s > 0 && o.iCreate < +new Date - 1e3 * s) && r.length === o.aoSearchCols.length) {
                            t.oLoadedState = a.extend(!0, {}, o), t._iDisplayStart = o.iStart, t.iInitDisplayStart = o.iStart, t._iDisplayLength = o.iLength, t.aaSorting = [], a.each(o.aaSorting, function(e, n) {
                                t.aaSorting.push(n[0] >= r.length ? [0, n[1]] : n)
                            }), a.extend(t.oPreviousSearch, o.oSearch), a.extend(!0, t.aoPreSearchCols, o.aoSearchCols);
                            var l = o.abVisCols;
                            for (e = 0, n = l.length; n > e; e++) r[e].bVisible = l[e];
                            Me(t, "aoStateLoaded", "stateLoaded", [t, o])
                        }
                    }
                }
            }
        }

        function je(t) {
            var e = Ge.settings,
                n = a.inArray(t, fn(e, "nTable"));
            return -1 !== n ? e[n] : null
        }

        function He(e, n, a, r) {
            if (a = "DataTables warning: " + (null !== e ? "table id=" + e.sTableId + " - " : "") + a, r && (a += ". For more information about this error, please see http://datatables.net/tn/" + r), n) t.console && console.log && console.log(a);
            else {
                var o = Ge.ext,
                    i = o.sErrMode || o.errMode;
                if ("alert" != i) throw new Error(a);
                alert(a)
            }
        }

        function Ne(t, e, r, o) {
            return a.isArray(r) ? void a.each(r, function(n, r) {
                a.isArray(r) ? Ne(t, e, r[0], r[1]) : Ne(t, e, r)
            }) : (o === n && (o = r), void(e[r] !== n && (t[o] = e[r])))
        }

        function We(t, e, n) {
            var r;
            for (var o in e) e.hasOwnProperty(o) && (r = e[o], a.isPlainObject(r) ? (a.isPlainObject(t[o]) || (t[o] = {}), a.extend(!0, t[o], r)) : t[o] = n && "data" !== o && "aaData" !== o && a.isArray(r) ? r.slice() : r);
            return t
        }

        function ke(t, e, n) {
            a(t).bind("click.DT", e, function(e) {
                t.blur(), n(e)
            }).bind("keypress.DT", e, function(t) {
                13 === t.which && (t.preventDefault(), n(t))
            }).bind("selectstart.DT", function() {
                return !1
            })
        }

        function Oe(t, e, n, a) {
            n && t[e].push({
                fn: n,
                sName: a
            })
        }

        function Me(t, e, n, r) {
            var o = [];
            return e && (o = a.map(t[e].slice().reverse(), function(e) {
                return e.fn.apply(t.oInstance, r)
            })), null !== n && a(t.nTable).trigger(n + ".dt", r), o
        }

        function Ue(t) {
            var e = t._iDisplayStart,
                n = t.fnDisplayEnd(),
                a = t._iDisplayLength;
            n === t.fnRecordsDisplay() && (e = n - a), (-1 === a || 0 > e) && (e = 0), t._iDisplayStart = e
        }

        function Ee(t, e) {
            var n = t.renderer,
                r = Ge.ext.renderer[e];
            return a.isPlainObject(n) && n[e] ? r[n[e]] || r._ : "string" == typeof n ? r[n] || r._ : r._
        }

        function Je(t) {
            return t.oFeatures.bServerSide ? "ssp" : t.ajax || t.sAjaxSource ? "ajax" : "dom"
        }

        function Be(t, e) {
            var n = [],
                a = Bn.numbers_length,
                r = Math.floor(a / 2);
            return a >= e ? n = hn(0, e) : r >= t ? (n = hn(0, a - 2), n.push("ellipsis"), n.push(e - 1)) : t >= e - 1 - r ? (n = hn(e - (a - 2), e), n.splice(0, 0, "ellipsis"), n.splice(0, 0, 0)) : (n = hn(t - 1, t + 2), n.push("ellipsis"), n.push(e - 1), n.splice(0, 0, "ellipsis"), n.splice(0, 0, 0)), n.DT_el = "span", n
        }

        function Ve(t) {
            a.each({
                num: function(e) {
                    return Vn(e, t)
                },
                "num-fmt": function(e) {
                    return Vn(e, t, an)
                },
                "html-num": function(e) {
                    return Vn(e, t, Ke)
                },
                "html-num-fmt": function(e) {
                    return Vn(e, t, Ke, an)
                }
            }, function(e, n) {
                qe.type.order[e + t + "-pre"] = n
            })
        }

        function Xe(t) {
            return function() {
                var e = [je(this[Ge.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));
                return Ge.ext.internal[t].apply(this, e)
            }
        }
        var Ge, qe, $e, Ye, ze, Qe = {},
            Ze = /[\r\n]/g,
            Ke = /<.*?>/g,
            tn = /^[\w\+\-]/,
            en = /[\w\+\-]$/,
            nn = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^", "-"].join("|\\") + ")", "g"),
            an = /[',$£€¥%\u2009\u202F]/g,
            rn = function(t) {
                return t && "-" !== t ? !1 : !0
            },
            on = function(t) {
                var e = parseInt(t, 10);
                return !isNaN(e) && isFinite(t) ? e : null
            },
            sn = function(t, e) {
                return Qe[e] || (Qe[e] = new RegExp(te(e), "g")), "string" == typeof t ? t.replace(/\./g, "").replace(Qe[e], ".") : t
            },
            ln = function(t, e, n) {
                var a = "string" == typeof t;
                return e && a && (t = sn(t, e)), n && a && (t = t.replace(an, "")), !t || "-" === t || !isNaN(parseFloat(t)) && isFinite(t)
            },
            un = function(t) {
                return !t || "string" == typeof t
            },
            cn = function(t, e, n) {
                if (rn(t)) return !0;
                var a = un(t);
                return a && ln(pn(t), e, n) ? !0 : null
            },
            fn = function(t, e, a) {
                var r = [],
                    o = 0,
                    i = t.length;
                if (a !== n)
                    for (; i > o; o++) t[o] && t[o][e] && r.push(t[o][e][a]);
                else
                    for (; i > o; o++) t[o] && r.push(t[o][e]);
                return r
            },
            dn = function(t, e, a, r) {
                var o = [],
                    i = 0,
                    s = e.length;
                if (r !== n)
                    for (; s > i; i++) o.push(t[e[i]][a][r]);
                else
                    for (; s > i; i++) o.push(t[e[i]][a]);
                return o
            },
            hn = function(t, e) {
                var a, r = [];
                e === n ? (e = 0, a = t) : (a = e, e = t);
                for (var o = e; a > o; o++) r.push(o);
                return r
            },
            pn = function(t) {
                return t.replace(Ke, "")
            },
            gn = function(t) {
                var e, n, a, r = [],
                    o = t.length,
                    i = 0;
                t: for (n = 0; o > n; n++) {
                    for (e = t[n], a = 0; i > a; a++)
                        if (r[a] === e) continue t;
                    r.push(e), i++
                }
                return r
            },
            bn = function(t, e, a) {
                t[e] !== n && (t[a] = t[e])
            },
            vn = /\[.*?\]$/,
            Sn = /\(\)$/,
            mn = a("<div>")[0],
            Dn = mn.textContent !== n,
            yn = /<.*?>/g;
        Ge = function(t) {
            this.$ = function(t, e) {
                return this.api(!0).$(t, e)
            }, this._ = function(t, e) {
                return this.api(!0).rows(t, e).data()
            }, this.api = function(t) {
                return new $e(t ? je(this[qe.iApiIndex]) : this)
            }, this.fnAddData = function(t, e) {
                var r = this.api(!0),
                    o = a.isArray(t) && (a.isArray(t[0]) || a.isPlainObject(t[0])) ? r.rows.add(t) : r.row.add(t);
                return (e === n || e) && r.draw(), o.flatten().toArray()
            }, this.fnAdjustColumnSizing = function(t) {
                var e = this.api(!0).columns.adjust(),
                    a = e.settings()[0],
                    r = a.oScroll;
                t === n || t ? e.draw(!1) : ("" !== r.sX || "" !== r.sY) && pe(a)
            }, this.fnClearTable = function(t) {
                var e = this.api(!0).clear();
                (t === n || t) && e.draw()
            }, this.fnClose = function(t) {
                this.api(!0).row(t).child.hide()
            }, this.fnDeleteRow = function(t, e, a) {
                var r = this.api(!0),
                    o = r.rows(t),
                    i = o.settings()[0],
                    s = i.aoData[o[0][0]];
                return o.remove(), e && e.call(this, i, s), (a === n || a) && r.draw(), s
            }, this.fnDestroy = function(t) {
                this.api(!0).destroy(t)
            }, this.fnDraw = function(t) {
                this.api(!0).draw(!t)
            }, this.fnFilter = function(t, e, a, r, o, i) {
                var s = this.api(!0);
                null === e || e === n ? s.search(t, a, r, i) : s.column(e).search(t, a, r, i), s.draw()
            }, this.fnGetData = function(t, e) {
                var a = this.api(!0);
                if (t !== n) {
                    var r = t.nodeName ? t.nodeName.toLowerCase() : "";
                    return e !== n || "td" == r || "th" == r ? a.cell(t, e).data() : a.row(t).data() || null
                }
                return a.data().toArray()
            }, this.fnGetNodes = function(t) {
                var e = this.api(!0);
                return t !== n ? e.row(t).node() : e.rows().nodes().flatten().toArray()
            }, this.fnGetPosition = function(t) {
                var e = this.api(!0),
                    n = t.nodeName.toUpperCase();
                if ("TR" == n) return e.row(t).index();
                if ("TD" == n || "TH" == n) {
                    var a = e.cell(t).index();
                    return [a.row, a.columnVisible, a.column]
                }
                return null
            }, this.fnIsOpen = function(t) {
                return this.api(!0).row(t).child.isShown()
            }, this.fnOpen = function(t, e, n) {
                return this.api(!0).row(t).child(e, n).show().child()[0]
            }, this.fnPageChange = function(t, e) {
                var a = this.api(!0).page(t);
                (e === n || e) && a.draw(!1)
            }, this.fnSetColumnVis = function(t, e, a) {
                var r = this.api(!0).column(t).visible(e);
                (a === n || a) && r.columns.adjust().draw()
            }, this.fnSettings = function() {
                return je(this[qe.iApiIndex])
            }, this.fnSort = function(t) {
                this.api(!0).order(t).draw()
            }, this.fnSortListener = function(t, e, n) {
                this.api(!0).order.listener(t, e, n)
            }, this.fnUpdate = function(t, e, a, r, o) {
                var i = this.api(!0);
                return a === n || null === a ? i.row(e).data(t) : i.cell(e, a).data(t), (o === n || o) && i.columns.adjust(), (r === n || r) && i.draw(), 0
            }, this.fnVersionCheck = qe.fnVersionCheck;
            var e = this,
                r = t === n,
                c = this.length;
            r && (t = {}), this.oApi = this.internal = qe.internal;
            for (var h in Ge.ext.internal) h && (this[h] = Xe(h));
            return this.each(function() {
                var h, p = {},
                    g = c > 1 ? We(p, t, !0) : t,
                    b = 0,
                    v = this.getAttribute("id"),
                    S = !1,
                    _ = Ge.defaults;
                if ("table" != this.nodeName.toLowerCase()) return void He(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
                s(_), l(_.column), o(_, _, !0), o(_.column, _.column, !0), o(_, g);
                var C = Ge.settings;
                for (b = 0, h = C.length; h > b; b++) {
                    if (C[b].nTable == this) {
                        var T = g.bRetrieve !== n ? g.bRetrieve : _.bRetrieve,
                            w = g.bDestroy !== n ? g.bDestroy : _.bDestroy;
                        if (r || T) return C[b].oInstance;
                        if (w) {
                            C[b].oInstance.fnDestroy();
                            break
                        }
                        return void He(C[b], 0, "Cannot reinitialise DataTable", 3)
                    }
                    if (C[b].sTableId == this.id) {
                        C.splice(b, 1);
                        break
                    }
                }(null === v || "" === v) && (v = "DataTables_Table_" + Ge.ext._unique++, this.id = v);
                var x = a.extend(!0, {}, Ge.models.oSettings, {
                    nTable: this,
                    oApi: e.internal,
                    oInit: g,
                    sDestroyWidth: a(this)[0].style.width,
                    sInstance: v,
                    sTableId: v
                });
                C.push(x), x.oInstance = 1 === e.length ? e : a(this).dataTable(), s(g), g.oLanguage && i(g.oLanguage), g.aLengthMenu && !g.iDisplayLength && (g.iDisplayLength = a.isArray(g.aLengthMenu[0]) ? g.aLengthMenu[0][0] : g.aLengthMenu[0]), g = We(a.extend(!0, {}, _), g), Ne(x.oFeatures, g, ["bPaginate", "bLengthChange", "bFilter", "bSort", "bSortMulti", "bInfo", "bProcessing", "bAutoWidth", "bSortClasses", "bServerSide", "bDeferRender"]), Ne(x, g, ["asStripeClasses", "ajax", "fnServerData", "fnFormatNumber", "sServerMethod", "aaSorting", "aaSortingFixed", "aLengthMenu", "sPaginationType", "sAjaxSource", "sAjaxDataProp", "iStateDuration", "sDom", "bSortCellsTop", "iTabIndex", "fnStateLoadCallback", "fnStateSaveCallback", "renderer", ["iCookieDuration", "iStateDuration"],
                    ["oSearch", "oPreviousSearch"],
                    ["aoSearchCols", "aoPreSearchCols"],
                    ["iDisplayLength", "_iDisplayLength"],
                    ["bJQueryUI", "bJUI"]
                ]), Ne(x.oScroll, g, [
                    ["sScrollX", "sX"],
                    ["sScrollXInner", "sXInner"],
                    ["sScrollY", "sY"],
                    ["bScrollCollapse", "bCollapse"]
                ]), Ne(x.oLanguage, g, "fnInfoCallback"), Oe(x, "aoDrawCallback", g.fnDrawCallback, "user"), Oe(x, "aoServerParams", g.fnServerParams, "user"), Oe(x, "aoStateSaveParams", g.fnStateSaveParams, "user"), Oe(x, "aoStateLoadParams", g.fnStateLoadParams, "user"), Oe(x, "aoStateLoaded", g.fnStateLoaded, "user"), Oe(x, "aoRowCallback", g.fnRowCallback, "user"), Oe(x, "aoRowCreatedCallback", g.fnCreatedRow, "user"), Oe(x, "aoHeaderCallback", g.fnHeaderCallback, "user"), Oe(x, "aoFooterCallback", g.fnFooterCallback, "user"), Oe(x, "aoInitComplete", g.fnInitComplete, "user"), Oe(x, "aoPreDrawCallback", g.fnPreDrawCallback, "user");
                var I = x.oClasses;
                if (g.bJQueryUI ? (a.extend(I, Ge.ext.oJUIClasses, g.oClasses), g.sDom === _.sDom && "lfrtip" === _.sDom && (x.sDom = '<"H"lfr>t<"F"ip>'), x.renderer ? a.isPlainObject(x.renderer) && !x.renderer.header && (x.renderer.header = "jqueryui") : x.renderer = "jqueryui") : a.extend(I, Ge.ext.classes, g.oClasses), a(this).addClass(I.sTable), ("" !== x.oScroll.sX || "" !== x.oScroll.sY) && (x.oScroll.iBarWidth = Ce()), x.oScroll.sX === !0 && (x.oScroll.sX = "100%"), x.iInitDisplayStart === n && (x.iInitDisplayStart = g.iDisplayStart, x._iDisplayStart = g.iDisplayStart), null !== g.iDeferLoading) {
                    x.bDeferLoading = !0;
                    var A = a.isArray(g.iDeferLoading);
                    x._iRecordsDisplay = A ? g.iDeferLoading[0] : g.iDeferLoading, x._iRecordsTotal = A ? g.iDeferLoading[1] : g.iDeferLoading
                }
                "" !== g.oLanguage.sUrl ? (x.oLanguage.sUrl = g.oLanguage.sUrl, a.getJSON(x.oLanguage.sUrl, null, function(t) {
                    i(t), o(_.oLanguage, t), a.extend(!0, x.oLanguage, g.oLanguage, t), oe(x)
                }), S = !0) : a.extend(!0, x.oLanguage, g.oLanguage), null === g.asStripeClasses && (x.asStripeClasses = [I.sStripeOdd, I.sStripeEven]);
                var F = x.asStripeClasses,
                    L = a("tbody tr:eq(0)", this); - 1 !== a.inArray(!0, a.map(F, function(t) {
                    return L.hasClass(t)
                })) && (a("tbody tr", this).removeClass(F.join(" ")), x.asDestroyStripes = F.slice());
                var P, R = [],
                    H = this.getElementsByTagName("thead");
                if (0 !== H.length && (E(x.aoHeader, H[0]), R = J(x)), null === g.aoColumns)
                    for (P = [], b = 0, h = R.length; h > b; b++) P.push(null);
                else P = g.aoColumns;
                for (b = 0, h = P.length; h > b; b++) f(x, R ? R[b] : null);
                if (m(x, g.aoColumnDefs, P, function(t, e) {
                    d(x, t, e)
                }), L.length) {
                    var N = function(t, e) {
                        return t.getAttribute("data-" + e) ? e : null
                    };
                    a.each(j(x, L[0]).cells, function(t, e) {
                        var a = x.aoColumns[t];
                        if (a.mData === t) {
                            var r = N(e, "sort") || N(e, "order"),
                                o = N(e, "filter") || N(e, "search");
                            (null !== r || null !== o) && (a.mData = {
                                _: t + ".display",
                                sort: null !== r ? t + ".@data-" + r : n,
                                type: null !== r ? t + ".@data-" + r : n,
                                filter: null !== o ? t + ".@data-" + o : n
                            }, d(x, t))
                        }
                    })
                }
                var W = x.oFeatures;
                if (g.bStateSave && (W.bStateSave = !0, Re(x, g), Oe(x, "aoDrawCallback", Pe, "state_save")), g.aaSorting === n) {
                    var k = x.aaSorting;
                    for (b = 0, h = k.length; h > b; b++) k[b][1] = x.aoColumns[b].asSorting[0]
                }
                Fe(x), W.bSort && Oe(x, "aoDrawCallback", function() {
                    if (x.bSorted) {
                        var t = Te(x),
                            e = {};
                        a.each(t, function(t, n) {
                            e[n.src] = n.dir
                        }), Me(x, null, "order", [x, t, e]), xe(x)
                    }
                }), Oe(x, "aoDrawCallback", function() {
                    (x.bSorted || "ssp" === Je(x) || W.bDeferRender) && Fe(x)
                }, "sc"), u(x);
                var O = a(this).children("caption").each(function() {
                        this._captionSide = a(this).css("caption-side")
                    }),
                    M = a(this).children("thead");
                0 === M.length && (M = a("<thead/>").appendTo(this)), x.nTHead = M[0];
                var U = a(this).children("tbody");
                0 === U.length && (U = a("<tbody/>").appendTo(this)), x.nTBody = U[0];
                var B = a(this).children("tfoot");
                if (0 === B.length && O.length > 0 && ("" !== x.oScroll.sX || "" !== x.oScroll.sY) && (B = a("<tfoot/>").appendTo(this)), 0 === B.length || 0 === B.children().length ? a(this).addClass(I.sNoFooter) : B.length > 0 && (x.nTFoot = B[0], E(x.aoFooter, x.nTFoot)), g.aaData)
                    for (b = 0; b < g.aaData.length; b++) D(x, g.aaData[b]);
                else(x.bDeferLoading || "dom" == Je(x)) && y(x, a(x.nTBody).children("tr"));
                x.aiDisplay = x.aiDisplayMaster.slice(), x.bInitialised = !0, S === !1 && oe(x)
            }), e = null, this
        };
        var _n = [],
            Cn = Array.prototype,
            Tn = function(t) {
                var e, n, r = Ge.settings,
                    o = a.map(r, function(t) {
                        return t.nTable
                    });
                return t ? t.nTable && t.oApi ? [t] : t.nodeName && "table" === t.nodeName.toLowerCase() ? (e = a.inArray(t, o), -1 !== e ? [r[e]] : null) : t && "function" == typeof t.settings ? t.settings().toArray() : ("string" == typeof t ? n = a(t) : t instanceof a && (n = t), n ? n.map(function() {
                    return e = a.inArray(this, o), -1 !== e ? r[e] : null
                }).toArray() : void 0) : []
            };
        $e = function(t, e) {
            if (!this instanceof $e) throw "DT API must be constructed as a new object";
            var n = [],
                r = function(t) {
                    var e = Tn(t);
                    e && n.push.apply(n, e)
                };
            if (a.isArray(t))
                for (var o = 0, i = t.length; i > o; o++) r(t[o]);
            else r(t);
            this.context = gn(n), e && this.push.apply(this, e.toArray ? e.toArray() : e), this.selector = {
                rows: null,
                cols: null,
                opts: null
            }, $e.extend(this, this, _n)
        }, Ge.Api = $e, $e.prototype = {
            concat: Cn.concat,
            context: [],
            each: function(t) {
                for (var e = 0, n = this.length; n > e; e++) t.call(this, this[e], e, this);
                return this
            },
            eq: function(t) {
                var e = this.context;
                return e.length > t ? new $e(e[t], this[t]) : null
            },
            filter: function(t) {
                var e = [];
                if (Cn.filter) e = Cn.filter.call(this, t, this);
                else
                    for (var n = 0, a = this.length; a > n; n++) t.call(this, this[n], n, this) && e.push(this[n]);
                return new $e(this.context, e)
            },
            flatten: function() {
                var t = [];
                return new $e(this.context, t.concat.apply(t, this.toArray()))
            },
            join: Cn.join,
            indexOf: Cn.indexOf || function(t, e) {
                for (var n = e || 0, a = this.length; a > n; n++)
                    if (this[n] === t) return n;
                return -1
            },
            iterator: function(t, e, a) {
                var r, o, i, s, l, u, c, f, d = [],
                    h = this.context,
                    p = this.selector;
                for ("string" == typeof t && (a = e, e = t, t = !1), o = 0, i = h.length; i > o; o++)
                    if ("table" === e) r = a(h[o], o), r !== n && d.push(r);
                    else if ("columns" === e || "rows" === e) r = a(h[o], this[o], o), r !== n && d.push(r);
                else if ("column" === e || "column-rows" === e || "row" === e || "cell" === e)
                    for (c = this[o], "column-rows" === e && (u = Ln(h[o], p.opts)), s = 0, l = c.length; l > s; s++) f = c[s], r = "cell" === e ? a(h[o], f.row, f.column, o, s) : a(h[o], f, o, s, u), r !== n && d.push(r);
                if (d.length) {
                    var g = new $e(h, t ? d.concat.apply([], d) : d),
                        b = g.selector;
                    return b.rows = p.rows, b.cols = p.cols, b.opts = p.opts, g
                }
                return this
            },
            lastIndexOf: Cn.lastIndexOf || function() {
                return this.indexOf.apply(this.toArray.reverse(), arguments)
            },
            length: 0,
            map: function(t) {
                var e = [];
                if (Cn.map) e = Cn.map.call(this, t, this);
                else
                    for (var n = 0, a = this.length; a > n; n++) e.push(t.call(this, this[n], n));
                return new $e(this.context, e)
            },
            pluck: function(t) {
                return this.map(function(e) {
                    return e[t]
                })
            },
            pop: Cn.pop,
            push: Cn.push,
            reduce: Cn.reduce || function(t, e) {
                return c(this, t, e, 0, this.length, 1)
            },
            reduceRight: Cn.reduceRight || function(t, e) {
                return c(this, t, e, this.length - 1, -1, -1)
            },
            reverse: Cn.reverse,
            selector: null,
            shift: Cn.shift,
            sort: Cn.sort,
            splice: Cn.splice,
            toArray: function() {
                return Cn.slice.call(this)
            },
            to$: function() {
                return a(this)
            },
            toJQuery: function() {
                return a(this)
            },
            unique: function() {
                return new $e(this.context, gn(this))
            },
            unshift: Cn.unshift
        }, $e.extend = function(t, e, n) {
            if (e && (e instanceof $e || e.__dt_wrapper)) {
                var r, o, i, s = function(t, e, n) {
                    return function() {
                        var a = e.apply(t, arguments);
                        return $e.extend(a, a, n.methodExt), a
                    }
                };
                for (r = 0, o = n.length; o > r; r++) i = n[r], e[i.name] = "function" == typeof i.val ? s(t, i.val, i) : a.isPlainObject(i.val) ? {} : i.val, e[i.name].__dt_wrapper = !0, $e.extend(t, e[i.name], i.propExt)
            }
        }, $e.register = Ye = function(t, e) {
            if (a.isArray(t))
                for (var n = 0, r = t.length; r > n; n++) $e.register(t[n], e);
            else {
                var o, i, s, l, u = t.split("."),
                    c = _n,
                    f = function(t, e) {
                        for (var n = 0, a = t.length; a > n; n++)
                            if (t[n].name === e) return t[n];
                        return null
                    };
                for (o = 0, i = u.length; i > o; o++) {
                    l = -1 !== u[o].indexOf("()"), s = l ? u[o].replace("()", "") : u[o];
                    var d = f(c, s);
                    d || (d = {
                        name: s,
                        val: {},
                        methodExt: [],
                        propExt: []
                    }, c.push(d)), o === i - 1 ? d.val = e : c = l ? d.methodExt : d.propExt
                }
            }
        }, $e.registerPlural = ze = function(t, e, r) {
            $e.register(t, r), $e.register(e, function() {
                var t = r.apply(this, arguments);
                return t === this ? this : t instanceof $e ? t.length ? a.isArray(t[0]) ? new $e(t.context, t[0]) : t[0] : n : t
            })
        };
        var wn = function(t, e) {
            if ("number" == typeof t) return [e[t]];
            var n = a.map(e, function(t) {
                return t.nTable
            });
            return a(n).filter(t).map(function() {
                var t = a.inArray(this, n);
                return e[t]
            }).toArray()
        };
        Ye("tables()", function(t) {
            return t ? new $e(wn(t, this.context)) : this
        }), Ye("table()", function(t) {
            var e = this.tables(t),
                n = e.context;
            return n.length ? new $e(n[0]) : e
        }), ze("tables().nodes()", "table().node()", function() {
            return this.iterator("table", function(t) {
                return t.nTable
            })
        }), ze("tables().body()", "table().body()", function() {
            return this.iterator("table", function(t) {
                return t.nTBody
            })
        }), ze("tables().header()", "table().header()", function() {
            return this.iterator("table", function(t) {
                return t.nTHead
            })
        }), ze("tables().footer()", "table().footer()", function() {
            return this.iterator("table", function(t) {
                return t.nTFoot
            })
        }), ze("tables().containers()", "table().container()", function() {
            return this.iterator("table", function(t) {
                return t.nTableWrapper
            })
        }), Ye("draw()", function(t) {
            return this.iterator("table", function(e) {
                M(e, t === !1)
            })
        }), Ye("page()", function(t) {
            return t === n ? this.page.info().page : this.iterator("table", function(e) {
                ce(e, t)
            })
        }), Ye("page.info()", function() {
            if (0 === this.context.length) return n;
            var t = this.context[0],
                e = t._iDisplayStart,
                a = t._iDisplayLength,
                r = t.fnRecordsDisplay(),
                o = -1 === a;
            return {
                page: o ? 0 : Math.floor(e / a),
                pages: o ? 1 : Math.ceil(r / a),
                start: e,
                end: t.fnDisplayEnd(),
                length: a,
                recordsTotal: t.fnRecordsTotal(),
                recordsDisplay: r
            }
        }), Ye("page.len()", function(t) {
            return t === n ? 0 !== this.context.length ? this.context[0]._iDisplayLength : n : this.iterator("table", function(e) {
                se(e, t)
            })
        });
        var xn = function(t, e, n) {
            if ("ssp" == Je(t) ? M(t, e) : (de(t, !0), B(t, [], function(n) {
                L(t);
                for (var a = q(t, n), r = 0, o = a.length; o > r; r++) D(t, a[r]);
                M(t, e), de(t, !1)
            })), n) {
                var a = new $e(t);
                a.one("draw", function() {
                    n(a.ajax.json())
                })
            }
        };
        Ye("ajax.json()", function() {
            var t = this.context;
            return t.length > 0 ? t[0].json : void 0
        }), Ye("ajax.params()", function() {
            var t = this.context;
            return t.length > 0 ? t[0].oAjaxData : void 0
        }), Ye("ajax.reload()", function(t, e) {
            return this.iterator("table", function(n) {
                xn(n, e === !1, t)
            })
        }), Ye("ajax.url()", function(t) {
            var e = this.context;
            return t === n ? 0 === e.length ? n : (e = e[0], e.ajax ? a.isPlainObject(e.ajax) ? e.ajax.url : e.ajax : e.sAjaxSource) : this.iterator("table", function(e) {
                a.isPlainObject(e.ajax) ? e.ajax.url = t : e.ajax = t
            })
        }), Ye("ajax.url().load()", function(t, e) {
            return this.iterator("table", function(n) {
                xn(n, e === !1, t)
            })
        });
        var In = function(t, e) {
                var r, o, i, s, l, u, c = [];
                for (t && "string" != typeof t && t.length !== n || (t = [t]), i = 0, s = t.length; s > i; i++)
                    for (o = t[i] && t[i].split ? t[i].split(",") : [t[i]], l = 0, u = o.length; u > l; l++) r = e("string" == typeof o[l] ? a.trim(o[l]) : o[l]), r && r.length && c.push.apply(c, r);
                return c
            },
            An = function(t) {
                return t || (t = {}), t.filter && !t.search && (t.search = t.filter), {
                    search: t.search || "none",
                    order: t.order || "current",
                    page: t.page || "all"
                }
            },
            Fn = function(t) {
                for (var e = 0, n = t.length; n > e; e++)
                    if (t[e].length > 0) return t[0] = t[e], t.length = 1, t.context = [t.context[e]], t;
                return t.length = 0, t
            },
            Ln = function(t, e) {
                var n, r, o, i = [],
                    s = t.aiDisplay,
                    l = t.aiDisplayMaster,
                    u = e.search,
                    c = e.order,
                    f = e.page;
                if ("ssp" == Je(t)) return "removed" === u ? [] : hn(0, l.length);
                if ("current" == f)
                    for (n = t._iDisplayStart, r = t.fnDisplayEnd(); r > n; n++) i.push(s[n]);
                else if ("current" == c || "applied" == c) i = "none" == u ? l.slice() : "applied" == u ? s.slice() : a.map(l, function(t) {
                    return -1 === a.inArray(t, s) ? t : null
                });
                else if ("index" == c || "original" == c)
                    for (n = 0, r = t.aoData.length; r > n; n++) "none" == u ? i.push(n) : (o = a.inArray(n, s), (-1 === o && "removed" == u || o >= 0 && "applied" == u) && i.push(n));
                return i
            },
            Pn = function(t, e, n) {
                return In(e, function(e) {
                    var r = on(e);
                    if (null !== r && !n) return [r];
                    var o = Ln(t, n);
                    if (null !== r && -1 !== a.inArray(r, o)) return [r];
                    if (!e) return o;
                    for (var i = [], s = 0, l = o.length; l > s; s++) i.push(t.aoData[o[s]].nTr);
                    return e.nodeName && -1 !== a.inArray(e, i) ? [e._DT_RowIndex] : a(i).filter(e).map(function() {
                        return this._DT_RowIndex
                    }).toArray()
                })
            };
        Ye("rows()", function(t, e) {
            t === n ? t = "" : a.isPlainObject(t) && (e = t, t = ""), e = An(e);
            var r = this.iterator("table", function(n) {
                return Pn(n, t, e)
            });
            return r.selector.rows = t, r.selector.opts = e, r
        }), Ye("rows().nodes()", function() {
            return this.iterator("row", function(t, e) {
                return t.aoData[e].nTr || n
            })
        }), Ye("rows().data()", function() {
            return this.iterator(!0, "rows", function(t, e) {
                return dn(t.aoData, e, "_aData")
            })
        }), ze("rows().cache()", "row().cache()", function(t) {
            return this.iterator("row", function(e, n) {
                var a = e.aoData[n];
                return "search" === t ? a._aFilterData : a._aSortData
            })
        }), ze("rows().invalidate()", "row().invalidate()", function(t) {
            return this.iterator("row", function(e, n) {
                R(e, n, t)
            })
        }), ze("rows().indexes()", "row().index()", function() {
            return this.iterator("row", function(t, e) {
                return e
            })
        }), ze("rows().remove()", "row().remove()", function() {
            var t = this;
            return this.iterator("row", function(e, n, r) {
                var o = e.aoData;
                o.splice(n, 1);
                for (var i = 0, s = o.length; s > i; i++) null !== o[i].nTr && (o[i].nTr._DT_RowIndex = i);
                a.inArray(n, e.aiDisplay);
                P(e.aiDisplayMaster, n), P(e.aiDisplay, n), P(t[r], n, !1), Ue(e)
            })
        }), Ye("rows.add()", function(t) {
            var e = this.iterator("table", function(e) {
                    var n, a, r, o = [];
                    for (a = 0, r = t.length; r > a; a++) n = t[a], o.push(n.nodeName && "TR" === n.nodeName.toUpperCase() ? y(e, n)[0] : D(e, n));
                    return o
                }),
                n = this.rows(-1);
            return n.pop(), n.push.apply(n, e.toArray()), n
        }), Ye("row()", function(t, e) {
            return Fn(this.rows(t, e))
        }), Ye("row().data()", function(t) {
            var e = this.context;
            return t === n ? e.length && this.length ? e[0].aoData[this[0]]._aData : n : (e[0].aoData[this[0]]._aData = t, R(e[0], this[0], "data"), this)
        }), Ye("row().node()", function() {
            var t = this.context;
            return t.length && this.length ? t[0].aoData[this[0]].nTr || null : null
        }), Ye("row.add()", function(t) {
            t instanceof a && t.length && (t = t[0]);
            var e = this.iterator("table", function(e) {
                return t.nodeName && "TR" === t.nodeName.toUpperCase() ? y(e, t)[0] : D(e, t)
            });
            return this.row(e[0])
        });
        var Rn = function(t, e, n, r) {
                var o = [],
                    i = function(e, n) {
                        if (e.nodeName && "tr" === e.nodeName.toLowerCase()) o.push(e);
                        else {
                            var r = a("<tr><td/></tr>").addClass(n);
                            a("td", r).addClass(n).html(e)[0].colSpan = b(t), o.push(r[0])
                        }
                    };
                if (a.isArray(n) || n instanceof a)
                    for (var s = 0, l = n.length; l > s; s++) i(n[s], r);
                else i(n, r);
                e._details && e._details.remove(), e._details = a(o), e._detailsShow && e._details.insertAfter(e.nTr)
            },
            jn = function(t) {
                var e = t.context;
                if (e.length && t.length) {
                    var a = e[0].aoData[t[0]];
                    a._details && (a._details.remove(), a._detailsShow = n, a._details = n)
                }
            },
            Hn = function(t, e) {
                var n = t.context;
                if (n.length && t.length) {
                    var a = n[0].aoData[t[0]];
                    a._details && (a._detailsShow = e, e ? a._details.insertAfter(a.nTr) : a._details.detach(), Nn(n[0]))
                }
            },
            Nn = function(t) {
                var e = new $e(t),
                    n = ".dt.DT_details",
                    a = "draw" + n,
                    r = "column-visibility" + n,
                    o = "destroy" + n,
                    i = t.aoData;
                e.off(a + " " + r + " " + o), fn(i, "_details").length > 0 && (e.on(a, function(n, a) {
                    t === a && e.rows({
                        page: "current"
                    }).eq(0).each(function(t) {
                        var e = i[t];
                        e._detailsShow && e._details.insertAfter(e.nTr)
                    })
                }), e.on(r, function(e, n) {
                    if (t === n)
                        for (var a, r = b(n), o = 0, s = i.length; s > o; o++) a = i[o], a._details && a._details.children("td[colspan]").attr("colspan", r)
                }), e.on(o, function(e, n) {
                    if (t === n)
                        for (var a = 0, r = i.length; r > a; a++) i[a]._details && jn(i[a])
                }))
            },
            Wn = "",
            kn = Wn + "row().child",
            On = kn + "()";
        Ye(On, function(t, e) {
            var a = this.context;
            return t === n ? a.length && this.length ? a[0].aoData[this[0]]._details : n : (t === !0 ? this.child.show() : t === !1 ? jn(this) : a.length && this.length && Rn(a[0], a[0].aoData[this[0]], t, e), this)
        }), Ye([kn + ".show()", On + ".show()"], function() {
            return Hn(this, !0), this
        }), Ye([kn + ".hide()", On + ".hide()"], function() {
            return Hn(this, !1), this
        }), Ye([kn + ".remove()", On + ".remove()"], function() {
            return jn(this), this
        }), Ye(kn + ".isShown()", function() {
            var t = this.context;
            return t.length && this.length ? t[0].aoData[this[0]]._detailsShow || !1 : !1
        });
        var Mn = /^(.*):(name|visIdx|visible)$/,
            Un = function(t, e) {
                var n = t.aoColumns,
                    r = fn(n, "sName"),
                    o = fn(n, "nTh");
                return In(e, function(e) {
                    var i = on(e);
                    if ("" === e) return hn(n.length);
                    if (null !== i) return [i >= 0 ? i : n.length + i];
                    var s = "string" == typeof e ? e.match(Mn) : "";
                    if (!s) return a(o).filter(e).map(function() {
                        return a.inArray(this, o)
                    }).toArray();
                    switch (s[2]) {
                        case "visIdx":
                        case "visible":
                            var l = parseInt(s[1], 10);
                            if (0 > l) {
                                var u = a.map(n, function(t, e) {
                                    return t.bVisible ? e : null
                                });
                                return [u[u.length + l]]
                            }
                            return [p(t, l)];
                        case "name":
                            return a.map(r, function(t, e) {
                                return t === s[1] ? e : null
                            })
                    }
                })
            },
            En = function(t, e, r) {
                var o, i, s, l, u = t.aoColumns,
                    c = u[e],
                    f = t.aoData;
                if (r === n) return c.bVisible;
                if (c.bVisible !== r) {
                    if (r) {
                        var d = a.inArray(!0, fn(u, "bVisible"), e + 1);
                        for (i = 0, s = f.length; s > i; i++) l = f[i].nTr, o = f[i].anCells, l && l.insertBefore(o[e], o[d] || null)
                    } else a(fn(t.aoData, "anCells", e)).detach();
                    c.bVisible = r, k(t, t.aoHeader), k(t, t.aoFooter), h(t), (t.oScroll.sX || t.oScroll.sY) && pe(t), Me(t, null, "column-visibility", [t, e, r]), Pe(t)
                }
            };
        Ye("columns()", function(t, e) {
            t === n ? t = "" : a.isPlainObject(t) && (e = t, t = ""), e = An(e);
            var r = this.iterator("table", function(n) {
                return Un(n, t, e)
            });
            return r.selector.cols = t, r.selector.opts = e, r
        }), ze("columns().header()", "column().header()", function() {
            return this.iterator("column", function(t, e) {
                return t.aoColumns[e].nTh
            })
        }), ze("columns().footer()", "column().footer()", function() {
            return this.iterator("column", function(t, e) {
                return t.aoColumns[e].nTf
            })
        }), ze("columns().data()", "column().data()", function() {
            return this.iterator("column-rows", function(t, e, n, a, r) {
                for (var o = [], i = 0, s = r.length; s > i; i++) o.push(T(t, r[i], e, ""));
                return o
            })
        }), ze("columns().cache()", "column().cache()", function(t) {
            return this.iterator("column-rows", function(e, n, a, r, o) {
                return dn(e.aoData, o, "search" === t ? "_aFilterData" : "_aSortData", n)
            })
        }), ze("columns().nodes()", "column().nodes()", function() {
            return this.iterator("column-rows", function(t, e, n, a, r) {
                return dn(t.aoData, r, "anCells", e)
            })
        }), ze("columns().visible()", "column().visible()", function(t) {
            return this.iterator("column", function(e, a) {
                return t === n ? e.aoColumns[a].bVisible : En(e, a, t)
            })
        }), ze("columns().indexes()", "column().index()", function(t) {
            return this.iterator("column", function(e, n) {
                return "visible" === t ? g(e, n) : n
            })
        }), Ye("columns.adjust()", function() {
            return this.iterator("table", function(t) {
                h(t)
            })
        }), Ye("column.index()", function(t, e) {
            if (0 !== this.context.length) {
                var n = this.context[0];
                if ("fromVisible" === t || "toData" === t) return p(n, e);
                if ("fromData" === t || "toVisible" === t) return g(n, e)
            }
        }), Ye("column()", function(t, e) {
            return Fn(this.columns(t, e))
        });
        var Jn = function(t, e, n) {
            var r, o, i, s, l, u = t.aoData,
                c = Ln(t, n),
                f = dn(u, c, "anCells"),
                d = a([].concat.apply([], f)),
                h = t.aoColumns.length;
            return In(e, function(t) {
                if (!t) {
                    for (o = [], i = 0, s = c.length; s > i; i++)
                        for (r = c[i], l = 0; h > l; l++) o.push({
                            row: r,
                            column: l
                        });
                    return o
                }
                return a.isPlainObject(t) ? [t] : d.filter(t).map(function(t, e) {
                    return r = e.parentNode._DT_RowIndex, {
                        row: r,
                        column: a.inArray(e, u[r].anCells)
                    }
                }).toArray()
            })
        };
        Ye("cells()", function(t, e, r) {
                if (a.isPlainObject(t) && (t.row ? (r = e, e = null) : (r = t, t = null)), a.isPlainObject(e) && (r = e, e = null), null === e || e === n) return this.iterator("table", function(e) {
                    return Jn(e, t, An(r))
                });
                var o, i, s, l, u, c = this.columns(e, r),
                    f = this.rows(t, r),
                    d = this.iterator("table", function(t, e) {
                        for (o = [], i = 0, s = f[e].length; s > i; i++)
                            for (l = 0, u = c[e].length; u > l; l++) o.push({
                                row: f[e][i],
                                column: c[e][l]
                            });
                        return o
                    });
                return a.extend(d.selector, {
                    cols: e,
                    rows: t,
                    opts: r
                }), d
            }), ze("cells().nodes()", "cell().node()", function() {
                return this.iterator("cell", function(t, e, n) {
                    return t.aoData[e].anCells[n]
                })
            }), Ye("cells().data()", function() {
                return this.iterator("cell", function(t, e, n) {
                    return T(t, e, n)
                })
            }), ze("cells().cache()", "cell().cache()", function(t) {
                return t = "search" === t ? "_aFilterData" : "_aSortData", this.iterator("cell", function(e, n, a) {
                    return e.aoData[n][t][a]
                })
            }), ze("cells().indexes()", "cell().index()", function() {
                return this.iterator("cell", function(t, e, n) {
                    return {
                        row: e,
                        column: n,
                        columnVisible: g(t, n)
                    }
                })
            }), Ye(["cells().invalidate()", "cell().invalidate()"], function(t) {
                var e = this.selector;
                return this.rows(e.rows, e.opts).invalidate(t), this
            }), Ye("cell()", function(t, e, n) {
                return Fn(this.cells(t, e, n))
            }), Ye("cell().data()", function(t) {
                var e = this.context,
                    a = this[0];
                return t === n ? e.length && a.length ? T(e[0], a[0].row, a[0].column) : n : (w(e[0], a[0].row, a[0].column, t), R(e[0], a[0].row, "data", a[0].column), this)
            }), Ye("order()", function(t, e) {
                var r = this.context;
                return t === n ? 0 !== r.length ? r[0].aaSorting : n : ("number" == typeof t ? t = [
                    [t, e]
                ] : a.isArray(t[0]) || (t = Array.prototype.slice.call(arguments)), this.iterator("table", function(e) {
                    e.aaSorting = t.slice()
                }))
            }), Ye("order.listener()", function(t, e, n) {
                return this.iterator("table", function(a) {
                    Ae(a, t, e, n)
                })
            }), Ye(["columns().order()", "column().order()"], function(t) {
                var e = this;
                return this.iterator("table", function(n, r) {
                    var o = [];
                    a.each(e[r], function(e, n) {
                        o.push([n, t])
                    }), n.aaSorting = o
                })
            }), Ye("search()", function(t, e, r, o) {
                var i = this.context;
                return t === n ? 0 !== i.length ? i[0].oPreviousSearch.sSearch : n : this.iterator("table", function(n) {
                    n.oFeatures.bFilter && Y(n, a.extend({}, n.oPreviousSearch, {
                        sSearch: t + "",
                        bRegex: null === e ? !1 : e,
                        bSmart: null === r ? !0 : r,
                        bCaseInsensitive: null === o ? !0 : o
                    }), 1)
                })
            }), Ye(["columns().search()", "column().search()"], function(t, e, r, o) {
                return this.iterator("column", function(i, s) {
                    var l = i.aoPreSearchCols;
                    return t === n ? l[s].sSearch : void(i.oFeatures.bFilter && (a.extend(l[s], {
                        sSearch: t + "",
                        bRegex: null === e ? !1 : e,
                        bSmart: null === r ? !0 : r,
                        bCaseInsensitive: null === o ? !0 : o
                    }), Y(i, i.oPreviousSearch, 1)))
                })
            }), Ge.versionCheck = Ge.fnVersionCheck = function(t) {
                for (var e, n, a = Ge.version.split("."), r = t.split("."), o = 0, i = r.length; i > o; o++)
                    if (e = parseInt(a[o], 10) || 0, n = parseInt(r[o], 10) || 0, e !== n) return e > n;
                return !0
            }, Ge.isDataTable = Ge.fnIsDataTable = function(t) {
                var e = a(t).get(0),
                    n = !1;
                return a.each(Ge.settings, function(t, a) {
                    (a.nTable === e || a.nScrollHead === e || a.nScrollFoot === e) && (n = !0)
                }), n
            }, Ge.tables = Ge.fnTables = function(t) {
                return jQuery.map(Ge.settings, function(e) {
                    return !t || t && a(e.nTable).is(":visible") ? e.nTable : void 0
                })
            }, Ge.camelToHungarian = o, Ye("$()", function(t, e) {
                var n = this.rows(e).nodes(),
                    r = a(n);
                return a([].concat(r.filter(t).toArray(), r.find(t).toArray()))
            }), a.each(["on", "one", "off"], function(t, e) {
                Ye(e + "()", function() {
                    var t = Array.prototype.slice.call(arguments);
                    t[0].match(/\.dt\b/) || (t[0] += ".dt");
                    var n = a(this.tables().nodes());
                    return n[e].apply(n, t), this
                })
            }), Ye("clear()", function() {
                return this.iterator("table", function(t) {
                    L(t)
                })
            }), Ye("settings()", function() {
                return new $e(this.context, this.context)
            }), Ye("data()", function() {
                return this.iterator("table", function(t) {
                    return fn(t.aoData, "_aData")
                }).flatten()
            }), Ye("destroy()", function(e) {
                return e = e || !1, this.iterator("table", function(n) {
                    var r, o = n.nTableWrapper.parentNode,
                        i = n.oClasses,
                        s = n.nTable,
                        l = n.nTBody,
                        u = n.nTHead,
                        c = n.nTFoot,
                        f = a(s),
                        d = a(l),
                        h = a(n.nTableWrapper),
                        p = a.map(n.aoData, function(t) {
                            return t.nTr
                        });
                    n.bDestroying = !0, Me(n, "aoDestroyCallback", "destroy", [n]), e || new $e(n).columns().visible(!0), h.unbind(".DT").find(":not(tbody *)").unbind(".DT"), a(t).unbind(".DT-" + n.sInstance), s != u.parentNode && (f.children("thead").detach(), f.append(u)), c && s != c.parentNode && (f.children("tfoot").detach(), f.append(c)), f.detach(), h.detach(), n.aaSorting = [], n.aaSortingFixed = [], Fe(n), a(p).removeClass(n.asStripeClasses.join(" ")), a("th, td", u).removeClass(i.sSortable + " " + i.sSortableAsc + " " + i.sSortableDesc + " " + i.sSortableNone), n.bJUI && (a("th span." + i.sSortIcon + ", td span." + i.sSortIcon, u).detach(), a("th, td", u).each(function() {
                        var t = a("div." + i.sSortJUIWrapper, this);
                        a(this).append(t.contents()), t.detach()
                    })), !e && o && o.insertBefore(s, n.nTableReinsertBefore), d.children().detach(), d.append(p), f.css("width", n.sDestroyWidth).removeClass(i.sTable), r = n.asDestroyStripes.length, r && d.children().each(function(t) {
                        a(this).addClass(n.asDestroyStripes[t % r])
                    });
                    var g = a.inArray(n, Ge.settings); - 1 !== g && Ge.settings.splice(g, 1)
                })
            }), Ge.version = "1.10.1-dev", Ge.settings = [], Ge.models = {}, Ge.models.oSearch = {
                bCaseInsensitive: !0,
                sSearch: "",
                bRegex: !1,
                bSmart: !0
            }, Ge.models.oRow = {
                nTr: null,
                anCells: null,
                _aData: [],
                _aSortData: null,
                _aFilterData: null,
                _sFilterRow: null,
                _sRowStripe: "",
                src: null
            }, Ge.models.oColumn = {
                idx: null,
                aDataSort: null,
                asSorting: null,
                bSearchable: null,
                bSortable: null,
                bVisible: null,
                _sManualType: null,
                _bAttrSrc: !1,
                fnCreatedCell: null,
                fnGetData: null,
                fnSetData: null,
                mData: null,
                mRender: null,
                nTh: null,
                nTf: null,
                sClass: null,
                sContentPadding: null,
                sDefaultContent: null,
                sName: null,
                sSortDataType: "std",
                sSortingClass: null,
                sSortingClassJUI: null,
                sTitle: null,
                sType: null,
                sWidth: null,
                sWidthOrig: null
            }, Ge.defaults = {
                aaData: null,
                aaSorting: [
                    [0, "asc"]
                ],
                aaSortingFixed: [],
                ajax: null,
                aLengthMenu: [10, 25, 50, 100],
                aoColumns: null,
                aoColumnDefs: null,
                aoSearchCols: [],
                asStripeClasses: null,
                bAutoWidth: !0,
                bDeferRender: !1,
                bDestroy: !1,
                bFilter: !0,
                bInfo: !0,
                bJQueryUI: !1,
                bLengthChange: !0,
                bPaginate: !0,
                bProcessing: !1,
                bRetrieve: !1,
                bScrollCollapse: !1,
                bServerSide: !1,
                bSort: !0,
                bSortMulti: !0,
                bSortCellsTop: !1,
                bSortClasses: !0,
                bStateSave: !1,
                fnCreatedRow: null,
                fnDrawCallback: null,
                fnFooterCallback: null,
                fnFormatNumber: function(t) {
                    return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.oLanguage.sThousands)
                },
                fnHeaderCallback: null,
                fnInfoCallback: null,
                fnInitComplete: null,
                fnPreDrawCallback: null,
                fnRowCallback: null,
                fnServerData: null,
                fnServerParams: null,
                fnStateLoadCallback: function(t) {
                    try {
                        return JSON.parse((-1 === t.iStateDuration ? sessionStorage : localStorage).getItem("DataTables_" + t.sInstance + "_" + location.pathname))
                    } catch (e) {}
                },
                fnStateLoadParams: null,
                fnStateLoaded: null,
                fnStateSaveCallback: function(t, e) {
                    try {
                        (-1 === t.iStateDuration ? sessionStorage : localStorage).setItem("DataTables_" + t.sInstance + "_" + location.pathname, JSON.stringify(e))
                    } catch (n) {}
                },
                fnStateSaveParams: null,
                iStateDuration: 7200,
                iDeferLoading: null,
                iDisplayLength: 10,
                iDisplayStart: 0,
                iTabIndex: 0,
                oClasses: {},
                oLanguage: {
                    oAria: {
                        sSortAscending: ": activate to sort column ascending",
                        sSortDescending: ": activate to sort column descending"
                    },
                    oPaginate: {
                        sFirst: "First",
                        sLast: "Last",
                        sNext: "&nbsp;",
                        sPrevious: "&nbsp;"
                    },
                    sEmptyTable: "No data available in table",
                    sInfo: "Displaying page _PAGE_ of _PAGES_, items _START_ to _END_ of _TOTAL_",
                    sInfoEmpty: "Showing 0 to 0 of 0 entries",
                    sInfoFiltered: "(filtered from _MAX_ total entries)",
                    sInfoPostFix: "",
                    sDecimal: "",
                    sThousands: ",",
                    sLengthMenu: "Page size: _MENU_",
                    sLoadingRecords: "Loading...",
                    sProcessing: "Processing...",
                    sSearch: "",
                    sSearchPlaceholder: "Search",
                    sUrl: "",
                    sZeroRecords: "No matching records found"
                },
                oSearch: a.extend({}, Ge.models.oSearch),
                sAjaxDataProp: "data",
                sAjaxSource: null,
                sDom: "lfrtip",
                sPaginationType: "simple_numbers",
                sScrollX: "",
                sScrollXInner: "",
                sScrollY: "",
                sServerMethod: "GET",
                renderer: null
            }, r(Ge.defaults), Ge.defaults.column = {
                aDataSort: null,
                iDataSort: -1,
                asSorting: ["asc", "desc"],
                bSearchable: !0,
                bSortable: !0,
                bVisible: !0,
                fnCreatedCell: null,
                mData: null,
                mRender: null,
                sCellType: "td",
                sClass: "",
                sContentPadding: "",
                sDefaultContent: null,
                sName: "",
                sSortDataType: "std",
                sTitle: null,
                sType: null,
                sWidth: null
            }, r(Ge.defaults.column), Ge.models.oSettings = {
                oFeatures: {
                    bAutoWidth: null,
                    bDeferRender: null,
                    bFilter: null,
                    bInfo: null,
                    bLengthChange: null,
                    bPaginate: null,
                    bProcessing: null,
                    bServerSide: null,
                    bSort: null,
                    bSortMulti: null,
                    bSortClasses: null,
                    bStateSave: null
                },
                oScroll: {
                    bCollapse: null,
                    iBarWidth: 0,
                    sX: null,
                    sXInner: null,
                    sY: null
                },
                oLanguage: {
                    fnInfoCallback: null
                },
                oBrowser: {
                    bScrollOversize: !1,
                    bScrollbarLeft: !1
                },
                ajax: null,
                aanFeatures: [],
                aoData: [],
                aiDisplay: [],
                aiDisplayMaster: [],
                aoColumns: [],
                aoHeader: [],
                aoFooter: [],
                oPreviousSearch: {},
                aoPreSearchCols: [],
                aaSorting: null,
                aaSortingFixed: [],
                asStripeClasses: null,
                asDestroyStripes: [],
                sDestroyWidth: 0,
                aoRowCallback: [],
                aoHeaderCallback: [],
                aoFooterCallback: [],
                aoDrawCallback: [],
                aoRowCreatedCallback: [],
                aoPreDrawCallback: [],
                aoInitComplete: [],
                aoStateSaveParams: [],
                aoStateLoadParams: [],
                aoStateLoaded: [],
                sTableId: "",
                nTable: null,
                nTHead: null,
                nTFoot: null,
                nTBody: null,
                nTableWrapper: null,
                bDeferLoading: !1,
                bInitialised: !1,
                aoOpenRows: [],
                sDom: null,
                sPaginationType: "two_button",
                iStateDuration: 0,
                aoStateSave: [],
                aoStateLoad: [],
                oLoadedState: null,
                sAjaxSource: null,
                sAjaxDataProp: null,
                bAjaxDataGet: !0,
                jqXHR: null,
                json: n,
                oAjaxData: n,
                fnServerData: null,
                aoServerParams: [],
                sServerMethod: null,
                fnFormatNumber: null,
                aLengthMenu: null,
                iDraw: 0,
                bDrawing: !1,
                iDrawError: -1,
                _iDisplayLength: 10,
                _iDisplayStart: 0,
                _iRecordsTotal: 0,
                _iRecordsDisplay: 0,
                bJUI: null,
                oClasses: {},
                bFiltered: !1,
                bSorted: !1,
                bSortCellsTop: null,
                oInit: null,
                aoDestroyCallback: [],
                fnRecordsTotal: function() {
                    return "ssp" == Je(this) ? 1 * this._iRecordsTotal : this.aiDisplayMaster.length
                },
                fnRecordsDisplay: function() {
                    return "ssp" == Je(this) ? 1 * this._iRecordsDisplay : this.aiDisplay.length
                },
                fnDisplayEnd: function() {
                    var t = this._iDisplayLength,
                        e = this._iDisplayStart,
                        n = e + t,
                        a = this.aiDisplay.length,
                        r = this.oFeatures,
                        o = r.bPaginate;
                    return r.bServerSide ? o === !1 || -1 === t ? e + a : Math.min(e + t, this._iRecordsDisplay) : !o || n > a || -1 === t ? a : n
                },
                oInstance: null,
                sInstance: null,
                iTabIndex: 0,
                nScrollHead: null,
                nScrollFoot: null,
                aLastSort: [],
                oPlugins: {}
            }, Ge.ext = qe = {
                classes: {},
                errMode: "alert",
                feature: [],
                search: [],
                internal: {},
                legacy: {
                    ajax: null
                },
                pager: {},
                renderer: {
                    pageButton: {},
                    header: {}
                },
                order: {},
                type: {
                    detect: [],
                    search: {},
                    order: {}
                },
                _unique: 0,
                fnVersionCheck: Ge.fnVersionCheck,
                iApiIndex: 0,
                oJUIClasses: {},
                sVersion: Ge.version
            }, a.extend(qe, {
                afnFiltering: qe.search,
                aTypes: qe.type.detect,
                ofnSearch: qe.type.search,
                oSort: qe.type.order,
                afnSortData: qe.order,
                aoFeatures: qe.feature,
                oApi: qe.internal,
                oStdClasses: qe.classes,
                oPagination: qe.pager
            }), a.extend(Ge.ext.classes, {
                sTable: "dataTable",
                sNoFooter: "no-footer",
                sPageButton: "paginate_button",
                sPageButtonActive: "current",
                sPageButtonDisabled: "disabled",
                sStripeOdd: "odd",
                sStripeEven: "even",
                sRowEmpty: "dataTables_empty",
                sWrapper: "dataTables_wrapper",
                sFilter: "dataTables_filter",
                sInfo: "dataTables_info",
                sPaging: "dataTables_paginate paging_",
                sLength: "dataTables_length",
                sProcessing: "dataTables_processing",
                sSortAsc: "sorting_asc",
                sSortDesc: "sorting_desc",
                sSortable: "sorting",
                sSortableAsc: "sorting_asc_disabled",
                sSortableDesc: "sorting_desc_disabled",
                sSortableNone: "sorting_disabled",
                sSortColumn: "sorting_",
                sFilterInput: "",
                sLengthSelect: "",
                sScrollWrapper: "dataTables_scroll",
                sScrollHead: "dataTables_scrollHead",
                sScrollHeadInner: "dataTables_scrollHeadInner",
                sScrollBody: "dataTables_scrollBody",
                sScrollFoot: "dataTables_scrollFoot",
                sScrollFootInner: "dataTables_scrollFootInner",
                sHeaderTH: "",
                sFooterTH: "",
                sSortJUIAsc: "",
                sSortJUIDesc: "",
                sSortJUI: "",
                sSortJUIAscAllowed: "",
                sSortJUIDescAllowed: "",
                sSortJUIWrapper: "",
                sSortIcon: "",
                sJUIHeader: "",
                sJUIFooter: ""
            }),
            function() {
                var t = "";
                t = "";
                var e = t + "ui-state-default",
                    n = t + "css_right ui-icon ui-icon-",
                    r = t + "fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix";
                a.extend(Ge.ext.oJUIClasses, Ge.ext.classes, {
                    sPageButton: "fg-button ui-button " + e,
                    sPageButtonActive: "ui-state-disabled",
                    sPageButtonDisabled: "ui-state-disabled",
                    sPaging: "dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_",
                    sSortAsc: e + " sorting_asc",
                    sSortDesc: e + " sorting_desc",
                    sSortable: e + " sorting",
                    sSortableAsc: e + " sorting_asc_disabled",
                    sSortableDesc: e + " sorting_desc_disabled",
                    sSortableNone: e + " sorting_disabled",
                    sSortJUIAsc: n + "triangle-1-n",
                    sSortJUIDesc: n + "triangle-1-s",
                    sSortJUI: n + "carat-2-n-s",
                    sSortJUIAscAllowed: n + "carat-1-n",
                    sSortJUIDescAllowed: n + "carat-1-s",
                    sSortJUIWrapper: "DataTables_sort_wrapper",
                    sSortIcon: "DataTables_sort_icon",
                    sScrollHead: "dataTables_scrollHead " + e,
                    sScrollFoot: "dataTables_scrollFoot " + e,
                    sHeaderTH: e,
                    sFooterTH: e,
                    sJUIHeader: r + " ui-corner-tl ui-corner-tr",
                    sJUIFooter: r + " ui-corner-bl ui-corner-br"
                })
            }();
        var Bn = Ge.ext.pager;
        a.extend(Bn, {
            simple: function() {
                return ["previous", "next"]
            },
            full: function() {
                return ["first", "previous", "next", "last"]
            },
            simple_numbers: function(t, e) {
                return ["previous", Be(t, e), "next"]
            },
            full_numbers: function(t, e) {
                return ["first", "previous", Be(t, e), "next", "last"]
            },
            _numbers: Be,
            numbers_length: 7
        }), a.extend(!0, Ge.ext.renderer, {
            pageButton: {
                _: function(t, n, r, o, i, s) {
                    var l, u, c = t.oClasses,
                        f = t.oLanguage.oPaginate,
                        d = 0,
                        h = function(e, n) {
                            var o, p, g, b, v = function(e) {
                                ce(t, e.data.action, !0)
                            };
                            for (o = 0, p = n.length; p > o; o++)
                                if (b = n[o], a.isArray(b)) {
                                    var S = a("<" + (b.DT_el || "div") + "/>").appendTo(e);
                                    h(S, b)
                                } else {
                                    switch (l = "", u = "", b) {
                                        case "ellipsis":
                                            e.append("<span>&hellip;</span>");
                                            break;
                                        case "first":
                                            l = f.sFirst, u = b + (i > 0 ? "" : " " + c.sPageButtonDisabled);
                                            break;
                                        case "previous":
                                            l = f.sPrevious, u = b + (i > 0 ? "" : " " + c.sPageButtonDisabled);
                                            break;
                                        case "next":
                                            l = f.sNext, u = b + (s - 1 > i ? "" : " " + c.sPageButtonDisabled);
                                            break;
                                        case "last":
                                            l = f.sLast, u = b + (s - 1 > i ? "" : " " + c.sPageButtonDisabled);
                                            break;
                                        default:
                                            l = b + 1, u = i === b ? c.sPageButtonActive : ""
                                    }
                                    l && (g = a("<a>", {
                                        "class": c.sPageButton + " " + u,
                                        "aria-controls": t.sTableId,
                                        "data-dt-idx": d,
                                        tabindex: t.iTabIndex,
                                        id: 0 === r && "string" == typeof b ? t.sTableId + "_" + b : null
                                    }).html(l).appendTo(e), ke(g, {
                                        action: b
                                    }, v), d++)
                                }
                        };
                    try {
                        var p = a(e.activeElement).data("dt-idx");
                        h(a(n).empty(), o), null !== p && a(n).find("[data-dt-idx=" + p + "]").focus()
                    } catch (g) {}
                }
            }
        });
        var Vn = function(t, e, n, a) {
            return t && "-" !== t ? (e && (t = sn(t, e)), t.replace && (n && (t = t.replace(n, "")), a && (t = t.replace(a, ""))), 1 * t) : -1 / 0
        };
        return a.extend(qe.type.order, {
            "date-pre": function(t) {
                return Date.parse(t) || 0
            },
            "html-pre": function(t) {
                return t ? t.replace ? t.replace(/<.*?>/g, "").toLowerCase() : t + "" : ""
            },
            "string-pre": function(t) {
                return "string" == typeof t ? t.toLowerCase() : t && t.toString ? t.toString() : ""
            },
            "string-asc": function(t, e) {
                return e > t ? -1 : t > e ? 1 : 0
            },
            "string-desc": function(t, e) {
                return e > t ? 1 : t > e ? -1 : 0
            }
        }), Ve(""), a.extend(Ge.ext.type.detect, [
            function(t, e) {
                var n = e.oLanguage.sDecimal;
                return ln(t, n) ? "num" + n : null
            },
            function(t) {
                if (t && (!tn.test(t) || !en.test(t))) return null;
                var e = Date.parse(t);
                return null !== e && !isNaN(e) || rn(t) ? "date" : null
            },
            function(t, e) {
                var n = e.oLanguage.sDecimal;
                return ln(t, n, !0) ? "num-fmt" + n : null
            },
            function(t, e) {
                var n = e.oLanguage.sDecimal;
                return cn(t, n) ? "html-num" + n : null
            },
            function(t, e) {
                var n = e.oLanguage.sDecimal;
                return cn(t, n, !0) ? "html-num-fmt" + n : null
            },
            function(t) {
                return rn(t) || "string" == typeof t && -1 !== t.indexOf("<") ? "html" : null
            }
        ]), a.extend(Ge.ext.type.search, {
            html: function(t) {
                return rn(t) ? "" : "string" == typeof t ? t.replace(Ze, " ").replace(Ke, "") : ""
            },
            string: function(t) {
                return rn(t) ? "" : "string" == typeof t ? t.replace(Ze, " ") : t
            }
        }), a.extend(!0, Ge.ext.renderer, {
            header: {
                _: function(t, e, n, r) {
                    a(t.nTable).on("order.dt.DT", function(a, o, i, s) {
                        if (t === o) {
                            var l = n.idx;
                            e.removeClass(n.sSortingClass + " " + r.sSortAsc + " " + r.sSortDesc).addClass("asc" == s[l] ? r.sSortAsc : "desc" == s[l] ? r.sSortDesc : n.sSortingClass)
                        }
                    })
                },
                jqueryui: function(t, e, n, r) {
                    var o = n.idx;
                    a("<div/>").addClass(r.sSortJUIWrapper).append(e.contents()).append(a("<span/>").addClass(r.sSortIcon + " " + n.sSortingClassJUI)).appendTo(e), a(t.nTable).on("order.dt.DT", function(a, i, s, l) {
                        t === i && (e.removeClass(r.sSortAsc + " " + r.sSortDesc).addClass("asc" == l[o] ? r.sSortAsc : "desc" == l[o] ? r.sSortDesc : n.sSortingClass), e.find("span." + r.sSortIcon).removeClass(r.sSortJUIAsc + " " + r.sSortJUIDesc + " " + r.sSortJUI + " " + r.sSortJUIAscAllowed + " " + r.sSortJUIDescAllowed).addClass("asc" == l[o] ? r.sSortJUIAsc : "desc" == l[o] ? r.sSortJUIDesc : n.sSortingClassJUI))
                    })
                }
            }
        }), Ge.render = {
            number: function(t, e, n, a) {
                return {
                    display: function(r) {
                        var o = 0 > r ? "-" : "";
                        r = Math.abs(parseFloat(r));
                        var i = parseInt(r, 10),
                            s = n ? e + (r - i).toFixed(n).substring(2) : "";
                        return o + (a || "") + i.toString().replace(/\B(?=(\d{3})+(?!\d))/g, t) + s
                    }
                }
            }
        }, a.extend(Ge.ext.internal, {
            _fnExternApiFunc: Xe,
            _fnBuildAjax: B,
            _fnAjaxUpdate: V,
            _fnAjaxParameters: X,
            _fnAjaxUpdateDraw: G,
            _fnAjaxDataSrc: q,
            _fnAddColumn: f,
            _fnColumnOptions: d,
            _fnAdjustColumnSizing: h,
            _fnVisibleToColumnIndex: p,
            _fnColumnIndexToVisible: g,
            _fnVisbleColumns: b,
            _fnGetColumns: v,
            _fnColumnTypes: S,
            _fnApplyColumnDefs: m,
            _fnHungarianMap: r,
            _fnCamelToHungarian: o,
            _fnLanguageCompat: i,
            _fnBrowserDetect: u,
            _fnAddData: D,
            _fnAddTr: y,
            _fnNodeToDataIndex: _,
            _fnNodeToColumnIndex: C,
            _fnGetCellData: T,
            _fnSetCellData: w,
            _fnSplitObjNotation: x,
            _fnGetObjectDataFn: I,
            _fnSetObjectDataFn: A,
            _fnGetDataMaster: F,
            _fnClearTable: L,
            _fnDeleteIndex: P,
            _fnInvalidateRow: R,
            _fnGetRowElements: j,
            _fnCreateTr: H,
            _fnBuildHead: W,
            _fnDrawHead: k,
            _fnDraw: O,
            _fnReDraw: M,
            _fnAddOptionsHtml: U,
            _fnDetectHeader: E,
            _fnGetUniqueThs: J,
            _fnFeatureHtmlFilter: $,
            _fnFilterComplete: Y,
            _fnFilterCustom: z,
            _fnFilterColumn: Q,
            _fnFilter: Z,
            _fnFilterCreateSearch: K,
            _fnEscapeRegex: te,
            _fnFilterData: ee,
            _fnFeatureHtmlInfo: ne,
            _fnUpdateInfo: ae,
            _fnInfoMacros: re,
            _fnInitialise: oe,
            _fnInitComplete: ie,
            _fnLengthChange: se,
            _fnFeatureHtmlLength: le,
            _fnFeatureHtmlPaginate: ue,
            _fnPageChange: ce,
            _fnFeatureHtmlProcessing: fe,
            _fnProcessingDisplay: de,
            _fnFeatureHtmlTable: he,
            _fnScrollDraw: pe,
            _fnApplyToChildren: ge,
            _fnCalculateColumnWidths: be,
            _fnThrottle: ve,
            _fnConvertToWidth: Se,
            _fnScrollingWidthAdjust: me,
            _fnGetWidestNode: De,
            _fnGetMaxLenString: ye,
            _fnStringToCss: _e,
            _fnScrollBarWidth: Ce,
            _fnSortFlatten: Te,
            _fnSort: we,
            _fnSortAria: xe,
            _fnSortListener: Ie,
            _fnSortAttachListener: Ae,
            _fnSortingClasses: Fe,
            _fnSortData: Le,
            _fnSaveState: Pe,
            _fnLoadState: Re,
            _fnSettingsFromNode: je,
            _fnLog: He,
            _fnMap: Ne,
            _fnBindAction: ke,
            _fnCallbackReg: Oe,
            _fnCallbackFire: Me,
            _fnLengthOverflow: Ue,
            _fnRenderer: Ee,
            _fnDataSource: Je,
            _fnRowAttributes: N,
            _fnCalculateEnd: function() {}
        }), a.fn.dataTable = Ge, a.fn.dataTableSettings = Ge.settings, a.fn.dataTableExt = Ge.ext, a.fn.DataTable = function(t) {
            return a(this).dataTable(t).api()
        }, a.each(Ge, function(t, e) {
            a.fn.DataTable[t] = e
        }), a.fn.dataTable
    })
}(window, document);