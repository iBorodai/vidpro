// moment.js language configuration
// language : russian (ru)
// author : Viktorminator : https://github.com/Viktorminator
// Author : Menelion Elensule : https://github.com/Oire

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['moment'], factory); // AMD
    } else if (typeof exports === 'object') {
        factory(require('../moment')); // Node
    } else {
        factory(window.moment); // Browser global
    }
}(function (moment) {
    function plural(word, num) {
        var forms = word.split('_');
        return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
    }

    function relativeTimeWithPlural(number, withoutSuffix, key) {
        var format = {
            'mm': '������_������_�����',
            'hh': '���_����_�����',
            'dd': '����_���_����',
            'MM': '�����_������_�������',
            'yy': '���_����_���'
        };
        if (key === 'm') {
            return withoutSuffix ? '������' : '������';
        }
        else {
            return number + ' ' + plural(format[key], +number);
        }
    }

    function monthsCaseReplace(m, format) {
        var months = {
            'nominative': '������_�������_����_������_���_����_����_������_��������_�������_������_�������'.split('_'),
            'accusative': '������_�������_�����_������_���_����_����_�������_��������_�������_������_�������'.split('_')
        },

        nounCase = (/D[oD]? *MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return months[nounCase][m.month()];
    }

    function monthsShortCaseReplace(m, format) {
        var monthsShort = {
            'nominative': '���_���_���_���_���_����_����_���_���_���_���_���'.split('_'),
            'accusative': '���_���_���_���_���_����_����_���_���_���_���_���'.split('_')
        },

        nounCase = (/D[oD]? *MMMM?/).test(format) ?
            'accusative' :
            'nominative';

        return monthsShort[nounCase][m.month()];
    }

    function weekdaysCaseReplace(m, format) {
        var weekdays = {
            'nominative': '�����������_�����������_�������_�����_�������_�������_�������'.split('_'),
            'accusative': '�����������_�����������_�������_�����_�������_�������_�������'.split('_')
        },

        nounCase = (/\[ ?[��] ?(?:�������|���������)? ?\] ?dddd/).test(format) ?
            'accusative' :
            'nominative';

        return weekdays[nounCase][m.day()];
    }

    moment.lang('ru', {
        months : monthsCaseReplace,
        monthsShort : monthsShortCaseReplace,
        weekdays : weekdaysCaseReplace,
        weekdaysShort : "��_��_��_��_��_��_��".split("_"),
        weekdaysMin : "��_��_��_��_��_��_��".split("_"),
        monthsParse : [/^���/i, /^���/i, /^���/i, /^���/i, /^��[�|�]/i, /^���/i, /^���/i, /^���/i, /^���/i, /^���/i, /^���/i, /^���/i],
        longDateFormat : {
            LT : "HH:mm",
            L : "DD.MM.YYYY",
            LL : "D MMMM YYYY �.",
            LLL : "D MMMM YYYY �., LT",
            LLLL : "dddd, D MMMM YYYY �., LT"
        },
        calendar : {
            sameDay: '[������� �] LT',
            nextDay: '[������ �] LT',
            lastDay: '[����� �] LT',
            nextWeek: function () {
                return this.day() === 2 ? '[��] dddd [�] LT' : '[�] dddd [�] LT';
            },
            lastWeek: function () {
                switch (this.day()) {
                case 0:
                    return '[� �������] dddd [�] LT';
                case 1:
                case 2:
                case 4:
                    return '[� �������] dddd [�] LT';
                case 3:
                case 5:
                case 6:
                    return '[� �������] dddd [�] LT';
                }
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : "����� %s",
            past : "%s �����",
            s : "��������� ������",
            m : relativeTimeWithPlural,
            mm : relativeTimeWithPlural,
            h : "���",
            hh : relativeTimeWithPlural,
            d : "����",
            dd : relativeTimeWithPlural,
            M : "�����",
            MM : relativeTimeWithPlural,
            y : "���",
            yy : relativeTimeWithPlural
        },

        // M. E.: those two are virtually unused but a user might want to implement them for his/her website for some reason

        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return "����";
            } else if (hour < 12) {
                return "����";
            } else if (hour < 17) {
                return "���";
            } else {
                return "������";
            }
        },

        ordinal: function (number, period) {
            switch (period) {
            case 'M':
            case 'd':
            case 'DDD':
                return number + '-�';
            case 'D':
                return number + '-��';
            case 'w':
            case 'W':
                return number + '-�';
            default:
                return number;
            }
        },

        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7 // The week that contains Jan 1st is the first week of the year.
        }
    });
}));