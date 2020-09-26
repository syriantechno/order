!function (a) {
    "function" == typeof define && define.amd ? define(["jquery", "moment"], a) : "object" == typeof exports ? module.exports = a(require("jquery"), require("moment")) : a(jQuery, moment)
}(function (a, e) {
    !function () {
        var a = {
                1: "'inci",
                5: "'inci",
                8: "'inci",
                70: "'inci",
                80: "'inci",
                2: "'nci",
                7: "'nci",
                20: "'nci",
                50: "'nci",
                3: "'üncü",
                4: "'üncü",
                100: "'üncü",
                6: "'ncı",
                9: "'uncu",
                10: "'uncu",
                30: "'uncu",
                60: "'ıncı",
                90: "'ıncı"
            },
            t = e.defineLocale("ar", {
                months: "كانون ثاني_شباط_آذار_نيسان_آيار_حزيران_تموز_آب_ايول_تشرين أول_تشرين ثاني_كانون أول".split("_"),
                monthsShort: "Oca_Şub_Mar_Nis_May_Haz_Tem_Ağu_Eyl_Eki_Kas_Ara".split("_"),
                weekdays: "الأحد_الإثنين_الثلاثاء_الاربعاء_الخميس_الجمعة_السبت".split("_"),
                weekdaysShort: "الأحد_الإثنين_الثلاثاء_الاربعاء_الخميس_الجمعة_السبت".split("_"),
                weekdaysMin: "الأحد_الإثنين_الثلاثاء_الاربعاء_الخميس_الجمعة_السبت".split("_"),
                longDateFormat: {
                    LT: "HH:mm",
                    LTS: "HH:mm:ss",
                    L: "DD.MM.YYYY",
                    LL: "D MMMM YYYY",
                    LLL: "D MMMM YYYY HH:mm",
                    LLLL: "dddd, D MMMM YYYY HH:mm"
                },
                calendar: {
                    sameDay: "[bugün saat] LT",
                    nextDay: "[yarın saat] LT",
                    nextWeek: "[haftaya] dddd [saat] LT",
                    lastDay: "[dün] LT",
                    lastWeek: "[geçen hafta] dddd [saat] LT",
                    sameElse: "L"
                },
                relativeTime: {
                    future: "%s ثم",
                    past: "%s منذ",
                    s: "birkaç ثانية",
                    m: "bir دقيقة",
                    mm: "%d دقيقة",
                    h: "bir ساعة",
                    hh: "%d ساعة",
                    d: "bir يوم",
                    dd: "%d يوم",
                    M: "bir شهر",
                    MM: "%d شهر",
                    y: "bir عام",
                    yy: "%d عام"
                },
                ordinalParse: /\d{1,2}'(inci|nci|üncü|ncı|uncu|ıncı)/,
                ordinal: function (e) {
                    if (0 === e) return e + "'ıncı";
                    var t = e % 10,
                        n = e % 100 - t,
                        i = e >= 100 ? 100 : null;
                    return e + (a[t] || a[n] || a[i])
                },
                week: {
                    dow: 1,
                    doy: 7
                }
            });
        return t
    }(), a.fullCalendar.datepickerLocale("ar", "ar", {
        closeText: "قريب",
        prevText: "&#x3C;geri",
        nextText: "ileri&#x3e",
        currentText: "اليوم",
        monthNames: ["كانون الثاني", "شباط", "أذار", "نيسان", "أيار", "حزيران", "تموز", "اب", "ايلول", "تشرين اول", "تشرين الثاني", "كانون اول"],
        monthNamesShort: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
        dayNames: ["الأحد", "الإثنين", "الثلاثاء", "الاربعاء", "الخميس", "الجمعة", "السبت"],
        dayNamesShort: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
        dayNamesMin: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
        weekHeader: "Hf",
        dateFormat: "dd.mm.yy",
        firstDay: 1,
        isRTL: !1,
        showMonthAfterYear: !1,
        yearSuffix: ""
    }), a.fullCalendar.locale("ar", {
        buttonText: {
            next: "التالي",
            month: "الشهر",
            week: "الاسبوع",
            day: "اليوم",
            list: "القائمة",
            listWeek: 'قائمة الاسابيع'
        },
        allDayText: "كل يوم",
        eventLimitText: "أكثر",
        noEventsMessage: "لم يتم العثور على الحدث"
    })
});