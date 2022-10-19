"use strict";
var KTDatatablesClassic = {
    init: function () {
        !function () {
            const t = document.getElementById("kt_orders_classic");
            t.querySelectorAll("tbody tr").forEach((t => {
                const e = t.querySelectorAll("td"), a = moment(e[1].innerHTML, "MMM D, YYYY").format("x");
                e[1].setAttribute("data-order", a)
            }));
            const e = $(t).DataTable({info: !1, order: []}), a = document.getElementById("kt_filter_orders"),
                r = document.getElementById("kt_filter_year");
            var n, o;
            a.addEventListener("change", (function (t) {
                e.column(3).search(t.target.value).draw()
            })), r.addEventListener("change", (function (t) {
                switch (t.target.value) {
                    case"thisyear":
                        n = moment().startOf("year").format("x"), o = moment().endOf("year").format("x"), e.draw();
                        break;
                    case"thismonth":
                        n = moment().startOf("month").format("x"), o = moment().endOf("month").format("x"), e.draw();
                        break;
                    case"lastmonth":
                        n = moment().subtract(1, "months").startOf("month").format("x"), o = moment().subtract(1, "months").endOf("month").format("x"), e.draw();
                        break;
                    case"last90days":
                        n = moment().subtract(30, "days").format("x"), o = moment().format("x"), e.draw();
                        break;
                    default:
                        n = moment().subtract(100, "years").startOf("month").format("x"), o = moment().add(1, "months").endOf("month").format("x"), e.draw()
                }
            })), $.fn.dataTable.ext.search.push((function (t, e, a) {
                var r = n, m = o, s = parseFloat(moment(e[1]).format("x")) || 0;
                return !!(isNaN(r) && isNaN(m) || isNaN(r) && s <= m || r <= s && isNaN(m) || r <= s && s <= m)
            })), document.getElementById("kt_filter_search").addEventListener("keyup", (function (t) {
                e.search(t.target.value).draw()
            }))
        }()
    }
};
KTUtil.onDOMContentLoaded((function () {
    KTDatatablesClassic.init()
}));
