<link href="<?php echo base_url(); ?>assets/css/event_calendar/eventCalendar.css" />
<link href="<?php echo base_url(); ?>assets/css/event_calendar/eventCalendar_theme_responsive.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/event_calendar/moment.js"></script>
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
                return a.date.toLowerCase() > b.date.toLowerCase() ? 1 : -1;
            }
            return a.date > b.date ? 1 : -1;
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
                    moveOfMonth = -1;
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
    });
</script>


<script type="text/javascript"> var js_date_format = '<?php echo js_dateformat(); ?>';</script>
<div class="row">
    <!-- .row -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>class_routine" class="stats-btn mb20 lead-stats color_green">
                    <span data-to="568" data-from="0" class="stats-number dolar">Class Routine</span>
                    <span class="stats-icon"><i class="fa fa-book color-green"></i></span>
                    <h5>Daily class routine</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>exam" class="stats-btn mb20 lead-stats news_icon">
                    <span data-to="568" data-from="0" class="stats-number dolar">Exam</span>
                    <span class="stats-icon"><i class="fa fa-newspaper-o news-icon"></i></span>
                    <h5>Exam and it's schedule</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>assignment/submission" class="stats-btn mb20 lead-stats attendant_green">
                    <span data-to="568" data-from="0" class="stats-number dolar">Assignment</span>
                    <span class="stats-icon"><i class="fa fa-file attendant-color"></i></span>
                    <h5>Daily assignments</h5>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo base_url(); ?>feerecord" class="stats-btn mb20 lead-stats admissions_color">
                    <span data-to="568" data-from="0" class="stats-number dolar">Fee Records</span>
                    <span class="stats-icon"><i class="fa fa-universal-access admissions-color"></i></span>
                    <h5>Recent fee records</h5>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- / .row -->
<div class="row">
    <!-- .row -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block">
                    <div class="xe-upper">
                        <div class="xe-icon"> 
                            <i class="icomoon-icon-books"></i> 
                        </div>
                        <div class="xe-label"> 
                            <strong class="num">STUDY RESOURCES</strong>   
                        </div>
                    </div>
                    <div class="border"></div>                          
                    <div class="xe-lower scroll-bar-box">  
                        <ul class="clearfix links-gaz">                                              
                            <?php
                            foreach ($studyresource as $row):
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>uploads/project_file/<?php echo $row->study_filename; ?>"  title="<?php echo $row->study_desc; ?>" download="" target="_newtab" ><?php echo $row->study_title; ?></a>
                                </li>
                            <?php endforeach; ?>                                      
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-purple">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="icomoon-icon-book" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">DIGITAL LIBRARY</strong> <span>Daily Visits</span> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz">
                            <?php
                            foreach ($library as $lbr):
                                ?>
                                <li>
                                    <a  download=""  href="<?php echo base_url(); ?>uploads/project_file/<?php echo $lbr->lm_filename; ?>" target="_blank" ><?php echo $lbr->lm_title; ?></a>                                
                                </li>                            
                            <?php endforeach; ?>   
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block  xe-counter-block-blue">
                    <div class="xe-upper">
                        <div class="xe-icon"> 
                            <i class="icomoon-icon-file" aria-hidden="true"></i> 
                        </div>                        
                        <div class="xe-label"> 
                            <span>All the best</span> 
                            <strong class="num">EXAMINATIONS</strong> 
                        </div>
                    </div>
                    <div class="border"></div>            
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz">
                            <?php foreach ($exam_listing as $row) { ?> 
                                <li>
                                    <a href="<?php echo base_url('examschedual/schedule/' . $row->em_id); ?>" target="_blank"><?php echo $row->em_name; ?></a>                  
                                </li>
                            <?php } ?>                                                                                                                                 
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-orange">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class=" icomoon-icon-file-upload" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">PARTICIPATE</strong></div>                        
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url(); ?>participate/volunteer" target="_blank">Volunteer</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>participate/survey" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Survey</div> </a>                                
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>participate/upload" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Upload</div> </a>                                
                            </li>        
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-progress-counter xe-progress-counter-turquoise">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="fa fa-legal" aria-hidden="true"></i> </div>
                        <div class="xe-label"><strong class="num">RESULTS</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url('student/exam_marks'); ?>" target="_blank">Exam Marks</a>

                            </li>
                            <li>
                                <a href="<?php echo base_url('student/statement_of_marks'); ?>" target="_blank">Statement of Marks</a>                                 
                            </li>
                        </ul>                     
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-red">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="icomoon-icon-camera-5" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">VIDEO CONFERENCING</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <?php foreach ($live_streaming as $video) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo base_url('video_streaming#' . $video->url_link); ?>">
                                        <div class="menu-icon">
                                            <i class=" icon-trophy"></i>
                                        </div>
                                        <div class="menu-text">
                                            <?php echo $video->title; ?>                                        
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php foreach ($all as $video) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo base_url('video_streaming#' . $video->url_link); ?>">
                                        <div class="menu-icon">
                                            <i class=" icon-trophy"></i>
                                        </div>
                                        <div class="menu-text"><?php echo $video->title; ?></div>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php
                            if(!count($live_streaming) && !count($all)) { ?>
                                <h5>No live streaming available.</h5>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Admission Volunteer start div-->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-red attendance-box" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i aria-hidden="true" class=" icomoon-icon-notebook"></i> </div>
                        <div class="xe-label"> <strong class="num">Admission</strong></div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>
                                <a href="<?php echo base_url('student/profile'); ?>" target="_blank"> 
                                    <div class="menu-text">Profile</div> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('feerecord'); ?>" target="_blank"> 
                                    <div class="menu-text"> Student Payment Record</div> 
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('payment/student_fees'); ?>" target="_blank">                                 
                                    <div class="menu-text">Pay Online 

                                    </div> </a> 
                            </li>

                            <?php foreach ($cms_pages as $page) { ?>
                                <li>
                                    <a href="<?php echo base_url('student/cms_page/' . $page->am_id); ?>" target="_blank">
                                        <div><?php echo $page->am_title; ?></div>
                                    </a>
                                </li> 
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Admission Volunteer end div-->

            <!-- Project List start div-->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <div class="xe-widget xe-counter-block xe-counter-block-black">
                    <div class="xe-upper">
                        <div class="xe-icon"> <i class="fa fa-paperclip" aria-hidden="true"></i> </div>
                        <div class="xe-label"> <strong class="num">PROJECT</strong> </div>
                    </div>
                    <div class="border"></div>
                    <div class="xe-lower scroll-bar-box">
                        <ul class="clearfix links-gaz"> 
                            <li>                                
                                <a href="<?php echo base_url(); ?>project/submission" target="_blank"> <div class="menu-icon"></div> <div class="menu-text">Main Project List
                                </a>
                            </li>
                        </ul>    
                    </div>
                </div>
            </div>
            <!-- Project List end div-->

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- calendar start here -->        
                <div class="panel panel-default toggle">
                    <!-- Start .panel -->
                    <div class=panel-heading>
                        <h4 class=panel-title>Event Calendar</h4>
                        <div class="panel-controls panel-controls-right"> 
                            <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                        </div>
                    </div>
                    <div class=panel-body>
                        <div id="eventCalendarHumanDate"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="row">
    <!-- .row start -->
    <!-- To do list Start div-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class=panel-heading>
                <h4 class=panel-title>
                    To Do
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
                                                <input id="basic-datepicker" type="text" name="tado_date" class="form-control" >
                                            </div>
                                        </div>
                                        <div class=form-group>
                                            <label class="control-label col-lg-4">Task Time</label>
                                            <div class="col-sm-8">
                                                <div class="input-group bootstrap-timepicker">
                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    <input id="minute-step-timepicker" name="todo_time" type="text" class="form-control col-lg-8" >
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
                        <img src='<?php echo base_url() . 'assets/img/preloader.gif' ?>' width="64" height="64" style="position:relative; z-index:99999;" /><br>Loading...
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
    <!-- To do list End div-->   

    <!-- Growth Start div-->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <!-- col-md-6 start here  -->
        <div class="panel panel-default toggle">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title"> Growth</h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="vital-stats">
                    <!-- Vital stats -->
                    <ul class="list-unstyled growth-list">
                       <?php  foreach($growth as $row_mark):    
                        $total = ($row_mark->total*100/$row_mark->totalmarks);
                        $total_percentage = number_format($total, 2, '.', ',');
                        $total_percentage." %";
                        $round_percentage = round($total_percentage);
                                                ?>
                         <?php
                                 $progress_class = '';
                                 $color_class = '';
                              if($round_percentage >= 50 || $round_percentage <= 60  )
                                {
                                    $progress_class = "progress-bar-warning";
                                    $color_class = "fa-caret-down color-red";
                                }
                                if($round_percentage <= 50)
                                {
                                    $progress_class = "progress-bar-danger";
                                    $color_class= "fa-caret-down color-red";
                                }
                                if($round_percentage >= 70)
                                {
                                    $progress_class = "progress-bar-success";
                                    $color_class= "fa-caret-up color-green";
                                }
                                 ?>
                                               
                        <li>
                            <i class="fa s24 <?php echo $color_class; ?>" aria-hidden="true"></i>
                             <?php echo $row_mark->s_name; ?>
                            <span class="pull-right strong"><?php //echo $row_mark->total; ?></span>
                            <div class="progress progress-striped animated-bar mt0">
                               
                                <div data-transitiongoal="<?php echo $round_percentage; ?>" role="progressbar" class="progress-bar <?php echo $progress_class; ?>" style="width: <?php echo $round_percentage; ?>%;" aria-valuenow="<?php echo $round_percentage; ?>">
                                   <?php echo $total_percentage; ?>%
                                </div>
                            </div>
                        </li>
                                 <?php endforeach;?>                        
                    </ul>
                    <!-- / Vital stats -->
                </div>
            </div>
        </div>
        <!-- End .panel --><!-- / .panel -->
    </div>
    <!-- Growth end div-->



</div>

<!-- Timeline Start div-->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default toggle">
            <div class=panel-heading>
                <h4 class="panel-title marginzero">
                    Timeline
                </h4>
                <div class="panel-controls panel-controls-right"> <a href="#" class="toggle panel-minimize"><i class="minia-icon-arrow-up-3"></i></a>
                </div>
            </div>
            <div class=panel-body>
                <div id="demo">
                    <section id="examples">
                        <!-- content -->
                        <div id="content-1">
                            <div class="timeline-box timeline-horizontal">
                                <?php
                                $i = 1;
                                $eventdate = array();
                                $tododate = array();

                                foreach ($timline_event as $event1) {
                                    $eventdate[] = date('Y-m-d', strtotime($event1->event_date));
                                }

                                foreach ($timline_todolist as $time_line1) {
                                    $tododate [] = date('Y-m-d', strtotime($time_line1->todo_datetime));
                                }
                                foreach ($timelinecount as $c) {
                                    if (!empty($tododate) || !empty($eventdate)) {
                                        if (in_array($c, $tododate) || in_array($c, $eventdate)) {
                                            $i++;
                                            $j = 0;
                                            ?>
                                            <div class="tl-row <?php echo $i; ?>">
                                                <div class="tl-item <?php if ($i % 2) { ?> float-right <?php } ?>">
                                                    <div class="tl-bullet bg-blue"></div>
                                                    <div class="tl-panel"><?php echo $c; ?></div>
                                                    <div class="popover <?php if ($i % 2) { ?> bottom <?php } else { ?> top <?php } ?>">
                                                        <div class="arrow"></div>
                                                        <?php
                                                        if (!empty($eventdate)) {
                                                            if (in_array($c, $eventdate)) {
                                                                ?>
                                                                <div class="popover-content">
                                                                    <h3 class="tl-title">Event</h3>
                                                                    <?php
                                                                    foreach ($timline_event as $event) {
                                                                        if (date('Y-m-d', strtotime($event->event_date)) == $c) {
                                                                            $j++;
                                                                            if ($j <= 3) {
                                                                                ?>
                                                                                <p class=""><?php echo $event->event_name; ?></p>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if (!empty($tododate)) {
                                                            if (in_array($c, $tododate)) {
                                                                if ($j < 3) {
                                                                    ?>
                                                                    <div class="popover-content">
                                                                        <h3 class="tl-title">Todolist</h3>
                                                                        <?php
                                                                        foreach ($timline_todolist as $time_line) {
                                                                            if (date('Y-m-d', strtotime($time_line->todo_datetime)) == $c) {
                                                                                $j++;
                                                                                if ($j <= 3) {
                                                                                    ?>
                                                                                    <p class=""><?php echo $time_line->todo_title; ?></p>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>   
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?> 
                                                        <div class="tl-time"><i aria-hidden="true" class="fa fa-clock-o"></i><?php echo date_duration($c); ?></div>
                                                        <a href="#" class="readmore_link" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/student_eventlist/<?php echo $c; ?>');" data-toggle="modal"> Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <script>
                                    var total_timeline_boxes = '<?php echo --$i; ?>';

                                    $(document).ready(function () {
                                        setTimeout(function () {
                                            var box_width = '<?php echo 260 * $i; ?>';
                                            $('.tl-row').css('width', '260');
                                            $('.timeline-box.timeline-horizontal').css('width', box_width);

                                        }, 500);
                                    });
                                </script>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->
<!-- To do list js -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script>
var js_date_format = '<?php echo js_dateformat(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/todo-student.js"></script>
<!--  end to do list -->
<!-- jQuery Scrollbar Js start -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>

                                    (function ($) {

                                        $(window).load(function () {

                                            $(".xe-widget.xe-counter-block .xe-lower.scroll-bar-box").mCustomScrollbar({
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
                                                    onOverflowX: function () {
                                                        var opt = $(this).data("mCS").opt;
                                                        if (opt.mouseWheel.axis !== "x")
                                                            opt.mouseWheel.axis = "x";
                                                    },
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
                                                    onOverflowY: function () {
                                                        var opt = $(this).data("mCS").opt;
                                                        if (opt.mouseWheel.axis !== "y")
                                                            opt.mouseWheel.axis = "y";
                                                    },
                                                    // onOverflowX: function() {
                                                    // var opt = $(this).data("mCS").opt;
                                                    // if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                    // },
                                                }
                                            });
                                        });
                                        $("#content-1").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                onOverflowX: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "x")
                                                        opt.mouseWheel.axis = "x";
                                                },
                                            }
                                        });

                                        $(".panel-body .todo-widget .todo-list1").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                // onOverflowX: function() {
                                                //     var opt = $(this).data("mCS").opt;
                                                //     if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                // },
                                            }
                                        });
                                        $(".panel-body .vital-stats .growth-list").mCustomScrollbar({
                                            theme: "inset-2-dark",
                                            axis: "yx",
                                            advanced: {
                                                autoExpandHorizontalScroll: true
                                            },
                                            /* change mouse-wheel axis on-the-fly */
                                            callbacks: {
                                                onOverflowY: function () {
                                                    var opt = $(this).data("mCS").opt;
                                                    if (opt.mouseWheel.axis !== "y")
                                                        opt.mouseWheel.axis = "y";
                                                },
                                                // onOverflowX: function() {
                                                //     var opt = $(this).data("mCS").opt;
                                                //     if (opt.mouseWheel.axis !== "x") opt.mouseWheel.axis = "x";
                                                // },
                                            }
                                        });
                                    })(jQuery);
</script>
<!-- Scrollbar Js end -->


<!-- Event Calendar Js start -->
<script>
    $(document).ready(function () {

        show_event_detail_on_load();
        //show_first_event_details();

        $('.eventCalendar-arrow').on('click', function () {
            $('.eventCalendar-monthTitle').on('click', function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    show_event_detail_on_load();
                });
            });
            $('.eventCalendar-day').on('click', function () {
                show_event_detail_on_load();
            });
            //show_event_detail_on_load();
            setTimeout(function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
                });
            }, 1000);
        });
        $('.eventCalendar-monthTitle').on('click', function () {
            show_event_detail_on_load();
        });
        $('.eventCalendar-day').on('click', function () {
            show_event_detail_on_load();
        });
        function show_first_event_details() {
            $('.eventCalendar-day').on('click', function () {
                $('.eventCalendar-eventDesc').css('display', 'block');
                setTimeout(function () {
                    $('.eventCalendar-hidden').removeClass('eventCalendar-hidden');
                }, 1000);
            });
        }

        function show_event_detail_on_load() {
            setTimeout(function () {
                $('.eventCalendar-list li:first-child').each(function (index) {
                    console.log($(this).text());
                    $('div.eventCalendar-hidden', this).removeClass('eventCalendar-hidden');
                });
            }, 1000);
        }
    });
</script>
<!-- Event Calendar Js end -->
