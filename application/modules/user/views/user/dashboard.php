<?php
$this->load->helper('report_chart');
$course = unique_branch_list();
$department = student_ratio_department_wise();
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/event_calendar/moment.js"></script> 
<!-- charts js and library -->
<script src="<?php echo base_url(); ?>assets/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/exporting.js"></script>
<!-- pie chart (male vs female) -->
<script>
    $(function () {
    $('#course_count_ratio').highcharts({
    chart: {
    plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
    },
            legend: {
            align: 'center',
                    verticalAlign: 'top',
                    layout: 'horizontol',
                    x: 0,
                    y: 30
            },
            title: {
            text: 'Male to Female course count ratio'
            },
            tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
            pie: {
            allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                    enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                    }
            }
            },
            series: [{
            name: 'Genger',
                    colorByPoint: true,
                    data: [{
                    name: 'Male',
                            y: <?php echo $male_female_pie_chart['total_male_student']; ?>,
                            //sliced: true,
                            selected: true
                    }, {
                    name: 'Female',
                            y: <?php echo $male_female_pie_chart['total_female_student']; ?>
                    }]
            }]
    });
    });</script>
<!-- bar chart year wise students -->
<script>
    $(function () {
    $('#stduent-enrolled').highcharts({
    chart: {
    type: 'column'
    },
            legend: {
            align: 'center',
                    verticalAlign: 'top',
                    layout: 'horizontol',
                    x: 0,
                    y: 30
            },
            title: {
            text: 'Student Enrolled'
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            categories: [
<?php foreach ($new_student_joining as $row) { ?>
                '<?php echo $row->Year; ?>',
<?php } ?>
            ],
                    crosshair: true
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Students Enrolled'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0
            }
            },
            series: [{
            name: 'Students',
                    data: [
<?php foreach ($new_student_joining as $row) { ?>
    <?php echo $row->Total; ?>,
<?php } ?>
                    ]

            }]
    });
    });</script>
<!-- bar chart course wise male and female -->
<script>
    $(function () {
    $('#course-male-female').highcharts({
    chart: {
    type: 'column'
    },
            legend: {
            align: 'center',
                    verticalAlign: 'top',
                    layout: 'horizontol',
                    x: 0,
                    y: 30
            },
            title: {
            text: 'Department student count ratio'
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            categories: [
<?php
//$course = unique_branch_list();
foreach ($department as $row) {
    ?>
                '<?php echo $row->d_name; ?>',
<?php } ?>
            ],
                    crosshair: true
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Students'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0
            }
            },
            series: [
            {
            name: 'Student',
                    data: [
<?php
//$male = male_ratio_course_wise();
foreach ($department as $row) {
    ?>
    <?php echo $row->TotalStudent; ?>,
<?php } ?>
                    ]
            }]
    });
    });</script>
<!-- bar chart course wise students -->
<script>
    $(function () {
    $('#course-wise-student').highcharts({
    chart: {
    type: 'column'
    },
            legend: {
            align: 'center',
                    verticalAlign: 'top',
                    layout: 'horizontol',
                    x: 0,
                    y: 30
            },
            title: {
            text: 'Students Enrolled in Courses'
            },
            subtitle: {
            text: ''
            },
            xAxis: {
            categories: [
<?php foreach ($course as $row) { ?>
                '<?php echo $row->c_name; ?>',
<?php } ?>
            ],
                    crosshair: true
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Students'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0
            }
            },
            series: [{
            name: 'Students',
                    data: [
<?php
$students = total_count_of_student_branch_wise();
foreach ($students as $student) {
    ?>
    <?php echo $student->TotalStudent; ?>,
<?php } ?>
                    ]

            }]
    });
    });</script>
<script type="text/javascript" >
    ;
    (function ($) {
    $.fn.eventCalendar = function (options) {
    var calendar = this;
    if (options.locales && typeof (options.locales) == 'string') {
    $.getJSON(options.locales, function (data) {
    options.locales = $.extend({}, $.fn.eventCalendar.defaults.locales, data);
    moment.locale(data.locale, options.locales.moment);
    moment.locale(data.locale);
    initEventCalendar(calendar, options);
    }).error(function () {
    showError("error getting locale json", $(this));
    });
    } else {
    if (options.locales && options.locales.locale) {
    options.locales = $.extend({}, $.fn.eventCalendar.defaults.locales, options.locales);
    moment.locale(options.locales.locale, options.locales.moment);
    moment.locale(options.locales.locale);
    }
    initEventCalendar(calendar, options);
    }


    };
    // define the parameters with the default values of the function
    $.fn.eventCalendar.defaults = {
    eventsjson: '<?= $this->config->item('js_path') ?>event_js/events.json.php',
            eventsLimit: 10,
            locales: {
            locale: "en",
                    txt_noEvents: "There are no events in this period",
                    txt_SpecificEvents_prev: "",
                    txt_SpecificEvents_after: "events:",
                    txt_next: "next",
                    txt_prev: "prev",
                    txt_NextEvents: "events:",
                    txt_GoToEventUrl: "",
                    //txt_GoToEventUrl: "See the event",
                    txt_loading: "loading..."
            },
            showDayAsWeeks: true,
            startWeekOnMonday: true,
            showDayNameInCalendar: true,
            showDescription: false,
            onlyOneDescription: true,
            openEventInNewWindow: false,
            eventsScrollable: false,
            dateFormat: "DD/MM/YYYY",
            jsonDateFormat: 'timestamp', // you can use also "human" 'YYYY-MM-DD HH:MM:SS'
            //moveSpeed: 500,    // speed of month move when you clic on a new date
            //moveOpacity: 0, // month and events fadeOut to this opacity
            jsonData: "", // to load and inline json (not ajax calls)
            cacheJson: true  // if true plugin get a json only first time and after plugin filter events
            // if false plugin get a new json on each date change
    };
    function initEventCalendar(that, options) {
    var eventsOpts = $.extend({}, $.fn.eventCalendar.defaults, options);
    // define global vars for the function
    var flags = {
    wrap: "",
            directionLeftMove: "300",
            eventsJson: {}
    };
    // each eventCalendar will execute this function
    that.each(function () {

    flags.wrap = $(this);
    flags.wrap.addClass('eventCalendar-wrap').append("<div class='eventCalendar-details'><div class='eventCalendar-list-wrap'><p class='eventCalendar-subtitle'></p><span class='eventCalendar-loading'>" + eventsOpts.locales.txt_loading + "</span><div class='eventCalendar-list-content'><ul class='eventCalendar-list'></ul></div></div></div>");
    if (eventsOpts.eventsScrollable) {
    flags.wrap.find('.eventCalendar-list-content').addClass('scrollable');
    }

    setCalendarWidth(flags);
    $(window).resize(function () {
    setCalendarWidth(flags);
    });
    //flags.directionLeftMove = flags.wrap.width();

    // show current month
    dateSlider("current", flags, eventsOpts);
    getEvents(flags, eventsOpts, eventsOpts.eventsLimit, false, false, false, false);
    changeMonth(flags, eventsOpts);
    flags.wrap.on('click', '.eventCalendar-day a', function (e) {
    //flags.wrap.find('.eventCalendar-day a').live('click',function(e){
    e.preventDefault();
    var year = flags.wrap.attr('data-current-year'),
            month = flags.wrap.attr('data-current-month'),
            day = $(this).parent().attr('rel');
    getEvents(flags, eventsOpts, false, year, month, day, "day");
    });
    flags.wrap.on('click', '.eventCalendar-monthTitle', function (e) {
    //flags.wrap.find('.eventCalendar-monthTitle').live('click',function(e){
    e.preventDefault();
    var year = flags.wrap.attr('data-current-year'),
            month = flags.wrap.attr('data-current-month');
    getEvents(flags, eventsOpts, eventsOpts.eventsLimit, year, month, false, "month");
    });
    flags.wrap.on('dblclick', '.eventCalendar-day a', function (e) {
    //flags.wrap.find('.eventCalendar-day a').live('click',function(e){
    e.preventDefault();
    var year = flags.wrap.attr('data-current-year'),
            month = flags.wrap.attr('data-current-month'),
            day = $(this).parent().attr('rel');
    getEvents(flags, eventsOpts, false, year, month, day, "day");
    });
    flags.wrap.on('dblclick', '.eventCalendar-monthTitle', function (e) {
    //flags.wrap.find('.eventCalendar-monthTitle').live('click',function(e){
    e.preventDefault();
    var year = flags.wrap.attr('data-current-year'),
            month = flags.wrap.attr('data-current-month');
    getEvents(flags, eventsOpts, eventsOpts.eventsLimit, year, month, false, "month");
    });
    });
    // show event description
    flags.wrap.find('.eventCalendar-list').on('click', '.eventCalendar-eventTitle', function (e) {
    //flags.wrap.find('.eventCalendar-list .eventCalendar-eventTitle').live('click',function(e){
    if (!eventsOpts.showDescription) {
    e.preventDefault();
    var desc = $(this).parent().find('.eventCalendar-eventDesc');
    if (!desc.find('a').size()) {
    var eventUrl = $(this).attr('href');
    var eventTarget = $(this).attr('target');
    // create a button to go to event url
    desc.append('' + eventsOpts.locales.txt_GoToEventUrl + '');
    //desc.append('<a href="' + eventUrl + '" target="'+eventTarget+'" class="bt">'+eventsOpts.locales.txt_GoToEventUrl+'</a>');
    }

    if (desc.is(':visible')) {
    desc.slideUp();
    } else {
    if (eventsOpts.onlyOneDescription) {
    flags.wrap.find('.eventCalendar-eventDesc').slideUp();
    }
    desc.slideDown();
    }

    }
    });
    }

    function sortJson(a, b) {
    if (typeof a.date === 'string') {
    return a.date.toLowerCase() > b.date.toLowerCase() ? 1 : - 1;
    }
    return a.date > b.date ? 1 : - 1;
    }

    function dateSlider(show, flags, eventsOpts) {
    var $eventsCalendarSlider = $("<div class='eventCalendar-slider'></div>"),
            $eventsCalendarMonthWrap = $("<div class='eventCalendar-monthWrap'></div>"),
            $eventsCalendarTitle = $("<div class='eventCalendar-currentTitle'><a href='#' class='eventCalendar-monthTitle'></a></div>"),
            $eventsCalendarArrows = $("<div class='arrow-nav-block'><a href='#' class='eventCalendar-arrow eventCalendar-prev'><span>" + eventsOpts.locales.txt_prev + "</span></a><a href='#' class='eventCalendar-arrow eventCalendar-next'><span>" + eventsOpts.locales.txt_next + "</span></a></div>");
    $eventsCalendarDaysList = $("<ul class='eventCalendar-daysList'></ul>"),
            date = new Date();
    if (!flags.wrap.find('.eventCalendar-slider').length) {
    flags.wrap.prepend($eventsCalendarSlider);
    $eventsCalendarSlider.append($eventsCalendarMonthWrap);
    } else {
    flags.wrap.find('.eventCalendar-slider').append($eventsCalendarMonthWrap);
    }

    flags.wrap.find('.eventCalendar-monthWrap.eventCalendar-currentMonth').removeClass('eventCalendar-currentMonth').addClass('eventCalendar-oldMonth');
    $eventsCalendarMonthWrap.addClass('eventCalendar-currentMonth').append($eventsCalendarTitle, $eventsCalendarDaysList);
    // if current show current month & day
    if (show === "current") {
    day = date.getDate();
    $eventsCalendarSlider.append($eventsCalendarArrows);
    } else {
    date = new Date(flags.wrap.attr('data-current-year'), flags.wrap.attr('data-current-month'), 1, 0, 0, 0); // current visible month
    day = 0; // not show current day in days list

    moveOfMonth = 1;
    if (show === "prev") {
    moveOfMonth = - 1;
    }
    date.setMonth(date.getMonth() + moveOfMonth);
    var tmpDate = new Date();
    if (date.getMonth() === tmpDate.getMonth()) {
    day = tmpDate.getDate();
    }

    }

    // get date portions
    var year = date.getFullYear(), // year of the events
            currentYear = new Date().getFullYear(), // current year
            month = date.getMonth(), // 0-11
            monthToShow = month + 1;
    if (show != "current") {
    // month change
    getEvents(flags, eventsOpts, eventsOpts.eventsLimit, year, month, false, show);
    }

    flags.wrap.attr('data-current-month', month)
            .attr('data-current-year', year);
    // add current date info
    moment.locale(eventsOpts.locales.locale);
    var formatedDate = moment(year + " " + monthToShow, "YYYY MM").format("MMMM YYYY");
    $eventsCalendarTitle.find('.eventCalendar-monthTitle').html(formatedDate);
    // print all month days
    var daysOnTheMonth = 32 - new Date(year, month, 32).getDate();
    var daysList = [],
            i;
    if (eventsOpts.showDayAsWeeks) {
    $eventsCalendarDaysList.addClass('eventCalendar-showAsWeek');
    // show day name in top of calendar
    if (eventsOpts.showDayNameInCalendar) {
    $eventsCalendarDaysList.addClass('eventCalendar-showDayNames');
    i = 0;
    // if week start on monday
    if (eventsOpts.startWeekOnMonday) {
    i = 1;
    }

    for (; i < 7; i++) {
    daysList.push('<li class="eventCalendar-day-header">' + moment()._locale._weekdaysShort[i] + '</li>');
    if (i === 6 && eventsOpts.startWeekOnMonday) {
    // print sunday header
    daysList.push('<li class="eventCalendar-day-header">' + moment()._locale._weekdaysShort[0] + '</li>');
    }

    }
    }

    dt = new Date(year, month, 01);
    var weekDay = dt.getDay(); // day of the week where month starts

    if (eventsOpts.startWeekOnMonday) {
    weekDay = dt.getDay() - 1;
    }
    if (weekDay < 0) {
    weekDay = 6;
    } // if -1 is because day starts on sunday(0) and week starts on monday

    for (i = weekDay; i > 0; i--) {
    daysList.push('<li class="eventCalendar-day eventCalendar-empty"></li>');
    }
    }
    for (dayCount = 1; dayCount <= daysOnTheMonth; dayCount++) {
    var dayClass = "";
    if (day > 0 && dayCount === day && year === currentYear) {
    dayClass = "today";
    }
    daysList.push('<li id="dayList_' + dayCount + '" rel="' + dayCount + '" class="eventCalendar-day ' + dayClass + '"><a href="#">' + dayCount + '</a></li>');
    }
    $eventsCalendarDaysList.append(daysList.join(''));
    $eventsCalendarSlider.css('height', $eventsCalendarMonthWrap.height() + 'px');
    }

    function getEvents(flags, eventsOpts, limit, year, month, day, direction) {
    limit = limit || 0;
    year = year || '';
    day = day || '';
    // to avoid problem with january (month = 0)

    if (typeof month != 'undefined') {
    month = month;
    } else {
    month = '';
    }

    //var month = month || '';
    flags.wrap.find('.eventCalendar-loading').fadeIn();
    if (eventsOpts.jsonData) {
    // user send a json in the plugin params
    eventsOpts.cacheJson = true;
    flags.eventsJson = eventsOpts.jsonData;
    getEventsData(flags, eventsOpts, flags.eventsJson, limit, year, month, day, direction);
    } else if (!eventsOpts.cacheJson || !direction) {
    // first load: load json and save it to future filters
    $.getJSON(eventsOpts.eventsjson + "?limit=" + limit + "&year=" + year + "&month=" + month + "&day=" + day, function (data) {
    flags.eventsJson = data; // save data to future filters
    getEventsData(flags, eventsOpts, flags.eventsJson, limit, year, month, day, direction);
    }).error(function () {
    showError("error getting json: ", flags.wrap);
    });
    } else {
    // filter previus saved json
    getEventsData(flags, eventsOpts, flags.eventsJson, limit, year, month, day, direction);
    }

    if (day > '') {
    flags.wrap.find('.eventCalendar-current').removeClass('eventCalendar-current');
    flags.wrap.find('#dayList_' + day).addClass('eventCalendar-current');
    }
    }

    function getEventsData(flags, eventsOpts, data, limit, year, month, day, direction) {
    directionLeftMove = "-=" + flags.directionLeftMove;
    eventContentHeight = "auto";
    subtitle = flags.wrap.find('.eventCalendar-list-wrap .eventCalendar-subtitle');
    if (!direction) {
    // first load
    subtitle.html(eventsOpts.locales.txt_NextEvents);
    eventContentHeight = "auto";
    directionLeftMove = "-=0";
    } else {
    var jsMonth = parseInt(month) + 1,
            formatedDate;
    moment.locale(eventsOpts.locales.locale);
    if (day !== '') {
    formatedDate = moment(year + " " + jsMonth + " " + day, "YYYY MM DD").format("LL");
    subtitle.html(eventsOpts.locales.txt_SpecificEvents_prev + formatedDate + " " + eventsOpts.locales.txt_SpecificEvents_after);
    //eventStringDate = moment(eventDate).format(eventsOpts.dateFormat);
    } else {
    formatedDate = moment(year + " " + jsMonth, "YYYY MM").format("MMMM");
    subtitle.html(eventsOpts.locales.txt_SpecificEvents_prev + formatedDate + " " + eventsOpts.locales.txt_SpecificEvents_after);
    }

    if (direction === 'eventCalendar-prev') {
    directionLeftMove = "+=" + flags.directionLeftMove;
    } else if (direction === 'day' || direction === 'month') {
    directionLeftMove = "+=0";
    eventContentHeight = 0;
    }
    }

    flags.wrap.find('.eventCalendar-list').animate({
    opacity: eventsOpts.moveOpacity,
            left: directionLeftMove,
            height: eventContentHeight
    }, eventsOpts.moveSpeed, function () {
    flags.wrap.find('.eventCalendar-list').css({'left': 0, 'height': 'auto'}).hide();
    //wrap.find('.eventCalendar-list li').fadeIn();

    var events = [];
    data = $(data).sort(sortJson); // sort event by dates
    // each event
    if (data.length) {

    // show or hide event description
    var eventDescClass = '';
    if (!eventsOpts.showDescription) {
    eventDescClass = 'eventCalendar-hidden';
    }
    var eventLinkTarget = "_self";
    if (eventsOpts.openEventInNewWindow) {
    eventLinkTarget = '_target';
    }

    var i = 0;
    $.each(data, function (key, event) {
    var eventDateTime, eventDate, eventTime, eventYear, eventMonth, eventDay,
            eventMonthToShow, eventHour, eventMinute, eventSeconds;
    if (eventsOpts.jsonDateFormat == 'human') {
    eventDateTime = event.date.split(" ");
    eventDate = eventDateTime[0].split("-");
    eventTime = eventDateTime[1].split(":");
    eventYear = eventDate[0];
    eventMonth = parseInt(eventDate[1]) - 1;
    eventDay = parseInt(eventDate[2]);
    //eventMonthToShow = eventMonth;
    eventMonthToShow = parseInt(eventMonth) + 1;
    eventHour = eventTime[0];
    eventMinute = eventTime[1];
    eventSeconds = eventTime[2];
    eventDate = new Date(eventYear, eventMonth, eventDay, eventHour, eventMinute, eventSeconds);
    } else {
    eventDate = new Date(parseInt(event.date));
    eventYear = eventDate.getFullYear();
    eventMonth = eventDate.getMonth();
    eventDay = eventDate.getDate();
    eventMonthToShow = eventMonth + 1;
    eventHour = eventDate.getHours();
    eventMinute = eventDate.getMinutes();
    }

    if (parseInt(eventMinute) <= 9) {
    eventMinute = "0" + parseInt(eventMinute);
    }


    if (limit === 0 || limit > i) {
    // if month or day exist then only show matched events

    if ((month === false || month == eventMonth) && (day === '' || day == eventDay) && (year === '' || year == eventYear)) {

    // if initial load then load only future events
    if (month === false && eventDate < new Date()) {
    } else {

    moment.locale(eventsOpts.locales.locale);
    //eventStringDate = eventDay + "/" + eventMonthToShow + "/" + eventYear;
    eventStringDate = moment(eventDate).format(eventsOpts.dateFormat);
    var eventTitle;
    //var d = new Date('dd/mm/yy');
    //var today = dd+'/'+mm+'/'+yyyy;
    //alert(d);
    if (event.url) {
    eventTitle = '<a href="' + event.url + '" target="' + eventLinkTarget + '" class="eventCalendar-eventTitle">Title: ' + event.title + '</a>';
    } else {
    eventTitle = '<div class="eventCalendar-eventTitle"><i class="fa fa-check-square-o" aria-hidden="true"></i><b>Title :</b><span>' + event.title + '<span></div>' + '<div class="eventCalendar-eventDesc eventCalendar-hidden"><p><i class="fa fa-file-text-o" aria-hidden="true"></i><b>Description :</b><span>' + event.description + '</span></p><p><i class="fa fa-clock-o" aria-hidden="true"></i><b>Time :</b><span>' + event.event_start_time + '</span></p><p><i class="fa fa-map-marker" aria-hidden="true"></i><b>Location :</b><span>' + event.Location + '</span></p><p><i class="fa fa-coffee" aria-hidden="true"></i><b>Intention :</b><span>' + event.description + '</span></p></div>';
    }

    events.push('<li id="' + key + '" class="' + event.type + '"><time class="time_det" datetime="' + eventDate + '"><i class="mar4top fa fa-calendar-o" aria-hidden="true"></i><b>Date :</b><span><em>' + eventStringDate + '</em></span></time>' + eventTitle + '<p class="eventCalendar-eventDesc displaynone ' + eventDescClass + '">' + event.description + '</p></li>');
    i++;
    }
    }
    }

    // add mark in the dayList to the days with events
    if (eventYear == flags.wrap.attr('data-current-year') && eventMonth == flags.wrap.attr('data-current-month')) {
    flags.wrap.find('.eventCalendar-currentMonth .eventCalendar-daysList #dayList_' + parseInt(eventDay)).addClass('eventCalendar-dayWithEvents');
    }

    });
    }

    // there is no events on this period
    if (!events.length) {
    events.push('<li class="eventCalendar-noEvents"><p>' + eventsOpts.locales.txt_noEvents + '</p></li>');
    }
    flags.wrap.find('.eventCalendar-loading').hide();
    flags.wrap.find('.eventCalendar-list')
            .html(events.join(''));
    flags.wrap.find('.eventCalendar-list').animate({
    opacity: 1,
            height: "toggle"
    }, eventsOpts.moveSpeed);
    });
    setCalendarWidth(flags);
    }

    function changeMonth(flags, eventsOpts) {
    flags.wrap.find('.eventCalendar-arrow').click(function (e) {
    e.preventDefault();
    var lastMonthMove;
    if ($(this).hasClass('eventCalendar-next')) {
    dateSlider("next", flags, eventsOpts);
    lastMonthMove = '-=' + flags.directionLeftMove;
    } else {
    dateSlider("prev", flags, eventsOpts);
    lastMonthMove = '+=' + flags.directionLeftMove;
    }

    flags.wrap.find('.eventCalendar-monthWrap.eventCalendar-oldMonth').animate({
    opacity: eventsOpts.moveOpacity,
            left: lastMonthMove
    }, 0, function () {
    flags.wrap.find('.eventCalendar-monthWrap.eventCalendar-oldMonth').remove();
    });
    });
    }

    function showError(msg, wrap) {
    wrap.find('.eventCalendar-list-wrap').html("<span class='eventCalendar-loading eventCalendar-error'>" + msg + "</span>");
    }

    function setCalendarWidth(flags) {
    // resize calendar width on window resize
    flags.directionLeftMove = flags.wrap.width();
    flags.wrap.find('.eventCalendar-monthWrap').width(flags.wrap.width() + 'px');
    //flags.wrap.find('.eventCalendar-list-wrap').width(flags.wrap.width() + 'px');
    }
    })(jQuery);</script> 
<script type="text/javascript">
    $(document).ready(function () {
    $("#eventCalendarHumanDate").eventCalendar({
    eventsjson: '<?php echo base_url(); ?>event.humanDate.json.php',
            jsonDateFormat: 'human'  // 'YYYY-MM-DD HH:MM:SS'
    });
    });</script>
<!-- Start .row -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <!-- col-lg-12 start here Event Calendar -->
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>Event Calendar</h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>

            </div>
            <div class=panel-body>
                <div id="eventCalendarHumanDate"></div>
            </div>
        </div>
<div class="row" id="divevent">
             <div class=panel-heading>
                <h4 class=panel-title>Today's Event List</h4>
             </div>
            <div class="col-lg-12 col-md-12 col-xs-12" >
                <div class="panel-body" id="todayevent">
                    
                </div>
            </div>
        </div>
        <!-- End .panel -->
        <!-- start todo & time line -->
        <!-- To do list Start div-->
        <div class="row">
            <div class="col-lg-5 col-md-5 col-xs-5">
                <!--  To Do List -->
                <div class="panel panel-default toggle">
                    <!-- Start .panel -->
                    <div class=panel-heading>
                        <h4 class=panel-title>
                            To Do List
                        </h4>
                        <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                        </div>
                    </div>
                    <div class=panel-body>
                        <div class=todo-widget>
                            <!-- .todo-widget -->
                            <div class=todo-header>
                                <div id="updateformhtml"></div>
                                <div class="todo-addform" id="todo-addform">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class=todo-period>Add New ToDo</h4>
                                            <form id="frmtodo" class="form-horizontal form-groups-bordered validate">
                                                <div class=form-group>
                                                    <label class="control-label col-lg-4">Task Title</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="todo_title" class="form-control" name="todo_title" >
                                                    </div>
                                                </div>
                                                <div class=form-group>
                                                    <label class="control-label col-lg-4">Task Date</label>
                                                    <div class="col-sm-8">
                                                        <input id="basic-datepicker" type="text" name="tado_date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class=form-group>
                                                    <label class="control-label col-lg-4">Task Time</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                            <input id="minute-step-timepicker" name="todo_time" type="text" class="form-control col-lg-8">
                                                        </div>
                                                        <label id="minute-step-timepicker-error" style="display:none;" class="error" for="minute-step-timepicker">Select time</label>
                                                    </div>
                                                </div>
                                                <div class=form-group>
                                                    <div class="col-sm-offset-4 col-sm-8">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Add New Task" id="addbutton">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class=todo-search>
                                    <form>
                                        <input class=form-control name=search placeholder="Search for todo ...">
                                    </form>
                                </div>
                                <div class=todo-add>
                                    <a href=# class="btn btn-primary tip" id="addnewtodo" title="Add new todo"><i class="icomoon-icon-plus mr0"></i></a>
                                </div>
                            </div>
                            <h4 class=todo-period>To Do List</h4>
                            <div id="wait" class="loading_img">
                                <img src='<?php echo base_url() . 'assets/img/preloader.gif' ?>' width="64" height="64" /><br>Loading...
                            </div>
                            <ul class="todo-list" id="today">
                                <?php foreach ($todolist as $todo) { ?>  
                                    <li class="todo-task-item <?php
                                    if ($todo->todo_status == "0") {
                                        echo "task-done";
                                    }
                                    ?>" id="todo-task-item-id<?php echo $todo->todo_id; ?>">
                                        <div class=checkbox-custom><input type="checkbox" <?php
                                            if ($todo->todo_status == "0") {
                                                echo "checked=''";
                                            }
                                            ?> value="<?php echo $todo->todo_id ?>" id="checkbox<?php echo $todo->todo_id ?>" class="taskstatus"><label for=checkbox1></label></div>
                                        <div class=todo-task-text><?php echo $todo->todo_title; ?></div>
                                        <div class="todo-category"> <i aria-hidden="true" class="mar4top fa fa-calendar"></i> <?php echo date_duration($todo->todo_datetime); ?></div>
                                        <div class="updateclick_box">
                                            <button type="button" class="updateclick" value="<?php echo $todo->todo_id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="todo-close_box">
                                            <button type=button class="close-todo-old todo-close1" value="<?php echo $todo->todo_id; ?>"><i aria-hidden="true" class="fa fa-trash-o"></i></button>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- End .todo-widget -->
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-xs-7">
                <div class="panel panel-default toggle">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Staff 
                        </h4>
                        <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                        </div>
                    </div>

                    <div class="panel-body text-center">
                        <div id="checkAll-active">                    
                            <div class="gallery sortable-layout scroll_bar_faculty">
                                <?php foreach ($recent_professor as $teacher) { ?>  
                                    <div class="col-lg-4 col-md-4 col-xs-12">
                                        <div class="img_box_faculty">
                                            <?php if ($teacher->image_path != "") { ?> 
                                                <img class="img-responsive" src="<?php echo base_url() ?>uploads/professor/<?php echo $teacher->image_path; ?>" alt="image alt">
                                            <?php } else { ?>
                                                <img class="img-responsive" title="No Image Faculty" width="100px" src="<?php echo base_url() ?>uploads/no-image.jpg" />
                                            <?php } ?>
                                        </div>
                                        <div class="details_faculty">
                                            <h4 class="title">
                                                <b><?php echo $teacher->name; ?></b> 
                                                <b><?php echo $teacher->designation; ?></b>
                                                <small><?php echo date_duration($teacher->created_at); ?></small>
                                            </h4>
                                            <div class="btn-group" role="group">                     
                                                <a href="#" class="btn btn-default btn-xs" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/professor_viewdetail/<?php echo $teacher->professor_id; ?>');"  data-toggle="tooltip" data-placement="top">More Details</a>
                                            </div>
                                        </div>                                                
                                    </div>                            
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <!-- Start Report Charts -->
        <div class="panel panel-default toggle">
            <div class="panel-heading">
                <h4 class="panel-title marginzero">Report Charts</h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class="panel-body margin25top">
                <div class="row">
                    <div class="col-md-6 hide">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Male to Female Course count Ratio</div>
                            </div>
                            <div class="panel-body" id="course_count_ratio" style="height: 580px; padding:10px 0; box-sizing:border-box !important;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Students enrolled</div>
                            </div>
                            <div class="panel-body" id="stduent-enrolled" style="height: 580px; padding:10px 0;box-sizing:border-box !important;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Department student count Ratio</div>
                            </div>
                            <div class="panel-body" id="course-male-female" style="height: 630px !important; min-height: 630px !important;  display:block; padding:10px 0;box-sizing:border-box !important;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Students Enrolled (Coursewise)</div>
                            </div>
                            <div class="panel-body" id="course-wise-student" style="height: 630px !important; min-height: 630px !important;  display:block; padding:10px 0;box-sizing:border-box !important;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Report Charts -->
    </div>
</div>


<!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->


<script>
$(document).ready(function(){
        $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'user/get_today_event'; ?>",
                dataType:'json',
                success: function (response) {
                    if(response.length==0)
                    {
                        $("#divevent").remove();
                    }
                    else
                    {
                       var str='';
                        for(var i=0;i<response.length;i++)
                        {
                               str +="<i class='fa fa-hand-o-right'></i><a href='#'>"+response[i].event_name+"</a>  ";
                        }  
                            // str= str.slice(0, -2);
                        var str1="<marquee>"+str+"</marquee>";
                        $("#todayevent").html(str1);
                    }
                    
                }
            });
});
</script>
<!-- Event Calendar Start JS-->
<script>
    $(document).ready(function () {
    setTimeout(function () {
    $('p.eventCalendar-subtitle').html('Events Details:');
    }, 500);
    setTimeout(function () {
    $('.eventCalendar-arrow').on('click', function () {
    $('p.eventCalendar-subtitle').html('Events Details:');
    $('.eventCalendar-monthTitle').prepend('<i class="fa fa-calendar" aria-hidden="true"></i>');
    })
    }, 500);
    setTimeout(function () {
    $('.eventCalendar-monthTitle').prepend('<i class="fa fa-calendar" aria-hidden="true"></i>');
    }, 500);
    })
</script>
<!-- Event Calendar End JS-->

<!-- To do list Start JS-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script>
    var js_date_format = '<?php echo js_dateformat(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/todo-student.js"></script>
<!-- To do list Js End-->

<!-- jQuery Scrollbar Js start -->
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function($) {

    $(window).load(function() {
    $(".scroll_bar_faculty").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            onOverflowY:function(){
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "y") opt.mouseWheel.axis = "y";
            },
                    // onOverflowX: function() {
                    // var opt = $(this).data("mCS").opt;
                    // if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                    // },
            }
    });
    $(".eventCalendar-list-content").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            onOverflowY:function(){
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "y") opt.mouseWheel.axis = "y";
            },
                    // onOverflowX: function() {
                    // var opt = $(this).data("mCS").opt;
                    // if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                    // },
            }
    });
    $("#course-male-female").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            // onOverflowY:function(){
            //  var opt=$(this).data("mCS").opt;
            //  if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
            // },
            onOverflowX: function() {
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
            },
            }
    });
    $("#course-wise-student").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            // onOverflowY:function(){
            //  var opt=$(this).data("mCS").opt;
            //  if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
            // },
            onOverflowX: function() {
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
            },
            }
    });
    $("#course_count_ratio").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            // onOverflowY:function(){
            //  var opt=$(this).data("mCS").opt;
            //  if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
            // },
            onOverflowX: function() {
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
            },
            }
    });
    $("#stduent-enrolled").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            // onOverflowY:function(){
            //  var opt=$(this).data("mCS").opt;
            //  if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
            // },
            onOverflowX: function() {
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
            },
            }
    });
    });
    $(".panel-body .todo-widget .todo-list").mCustomScrollbar({
    theme: "inset-2-dark",
            axis: "yx",
            advanced: {
            autoExpandHorizontalScroll: true
            },
            /* change mouse-wheel axis on-the-fly */
            callbacks: {
            onOverflowY:function(){
            var opt = $(this).data("mCS").opt;
            if (opt.mouseWheel.axis !== "y") opt.mouseWheel.axis = "y";
            },
                    // onOverflowX: function() {
                    //     var opt = $(this).data("mCS").opt;
                    //     if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                    // },
            }
    });
    })(jQuery);</script>
<!-- Scrollbar Js end -->


<!-- Event Calendar Js start -->
<script>
    $(document).ready(function(){

    show_event_detail_on_load();
    //show_first_event_details();

    $('.eventCalendar-arrow').on('click', function(){
    $('.eventCalendar-monthTitle').on('click', function(){
    $('.eventCalendar-list li:first-child').each(function(index){
    console.log($(this).text());
    show_event_detail_on_load();
    });
    });
    $('.eventCalendar-day').on('click', function(){
    show_event_detail_on_load();
    });
    //show_event_detail_on_load();
    setTimeout(function(){
    $('.eventCalendar-list li:first-child').each(function(index){
    console.log($(this).text());
    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
    });
    }, 1000);
    });
    $('.eventCalendar-monthTitle').on('click', function(){
    show_event_detail_on_load();
    });
    $('.eventCalendar-day').on('click', function(){
    show_event_detail_on_load();
    });
    function show_first_event_details() {
    $('.eventCalendar-day').on('click', function(){
    $('.eventCalendar-eventDesc').css('display', 'block');
    setTimeout(function(){
    $('.eventCalendar-hidden').removeClass('eventCalendar-hidden');
    }, 1000);
    });
    }

    function show_event_detail_on_load() {
    setTimeout(function(){
    $('.eventCalendar-list li:first-child').each(function(index){
    console.log($(this).text());
    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
    });
    }, 1000);
    }
    });
</script>
<!-- Event Calendar Js end -->
