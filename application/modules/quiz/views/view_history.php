<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

<div class=row>                      

    <div class=col-lg-12>
        <!-- col-lg-12 start here -->
        <div class="panel-default toggle">
            <div class=panel-body>
                <div class="col-md-10">
                    <div id="quiz-history" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
        $('#quiz-history').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Perfomance Report of <?php echo $user->first_name . ' ' . $user->last_name ?>'
            },
            scrollbar: {
                enabled: true
            },
            subtitle: {
                text: '<?php echo $quiz->title; ?>'
            },
            xAxis: {
                categories: [
                    <?php foreach($history as $row) { ?>
                    '<?php echo date_formats($row->created_at); ?>',        
                    <?php } ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Result'
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
                //column: {colorByPoint: true}
            },
            series: [
                {
                     name: 'Obtained Marks out of <?php echo $quiz->total_marks; ?>',
                     data: [
                         <?php foreach($history as $row) { ?>
                            <?php echo $row->obtained_marks; ?>,        
                         <?php } ?>
                     ]
                 }, {
                    name: 'Percentage',
                    data: [
                        <?php foreach($history as $row) { ?>
                            <?php echo number_format(((100 * $row->obtained_marks) / $quiz->total_marks), 2); ?>,
                        <?php } ?>
                    ]
                 }, {
                    name: 'Total Question Attempts',
                    data: [
                        <?php foreach($history as $row) { ?>
                            <?php echo $row->total_question_attemps; ?>,        
                         <?php } ?>
                    ]
                 }, {
                    name: 'Currect Answers',
                    data: [
                        <?php foreach($history as $row) { ?>
                            <?php echo $row->currect_answers; ?>,        
                         <?php } ?>
                    ]
                 }]
        });
    });
</script>