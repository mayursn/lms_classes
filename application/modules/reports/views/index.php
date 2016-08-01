<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class=panel-body>
                <div class="col-md-6">
                    <div id="daily-registered-students" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
                
                <div class="col-md-6">
                    <div id="students-by-regions" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
                
                <div class="col-md-10">
                    <div id="department-wise-student" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
<!-- End .row -->
</div>
<!-- End contentwrapper -->
</div>
<!-- End #content -->

<script>
    $(function () {
        $('#daily-registered-students').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Daily Registered Students'
            },
            scrollbar: {
                enabled: true
            },
            subtitle: {
                text: 'LMS'
            },
            xAxis: {
                categories: [
                    <?php for($i=0; $i<7;$i++) { ?>
                    '<?php echo $date[$i]; ?>',
                    <?php } ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Students'
                },
                allowDecimals: false,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                column: {colorByPoint: true}
            },
            series: [
                {
                     name: 'Students',
                     data: [
                        <?php for($i=0; $i<7; $i++) { ?>
                        <?php echo $student_count[$i] ?>,             
                        <?php } ?>      
                     ]
                 }]
        });
    });
</script>

<script>
$(function () {
        $('#students-by-regions').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Student Count Region Wise'
            },
            scrollbar: {
                enabled: true
            },
            subtitle: {
                text: 'LMS'
            },
            xAxis: {
                categories: [
                    <?php foreach($region_students as $row) { ?>
                    '<?php echo $row->city; ?>',                    
                    <?php } ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Students'
                },
                allowDecimals: false,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                column: {colorByPoint: true}
            },
            series: [
                {
                     name: 'Students',
                     data: [
                        <?php foreach($region_students as $row) { ?>
                        <?php echo $row->Total; ?>,                    
                        <?php } ?> 
                     ]
                 }]
        });
    });
</script>

<script>
$(function () {
        $('#department-wise-student').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Students Count Department Wise'
            },
            scrollbar: {
                enabled: true
            },
            subtitle: {
                text: 'LMS'
            },
            xAxis: {
                categories: [
                    <?php foreach($department_wise_student as $row) { ?>
                    '<?php echo $row->d_name; ?>',                    
                    <?php } ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Students'
                },
                allowDecimals: false,
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                column: {colorByPoint: true},
                series: {
                    pointWidth: 40//width of the column bars irrespective of the chart size
                },
            },
            series: [
                {
                     name: 'Students',
                     data: [
                        <?php foreach($department_wise_student as $row) { ?>
                        <?php echo $row->Total; ?>,                    
                        <?php } ?> 
                     ]
                 }]
        });
    });
</script>