/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $.blockUI.defaults.css.border = 'none';
    $.blockUI.defaults.css.background = 'none';
    var URL = window.URL || window.webkitURL;
    $('.dataTable').DataTable({
        responsive: true,
        pageLength: 10,
        bLengthChange: false,
        paging: true,
        searching: false,
        ordering: true,
        aaSorting: []
    });
    $('.calender').datetimepicker({
        format: 'YYYY-MM-DD',
        debug: false
    });
    $('.calender-datetime').datetimepicker({
        format: 'YYYY-DD-MM H:m:s',
        debug: false
    });
    $('select[name="ListBox[]"]').bootstrapDualListbox({
        // showFilterInputs: false,
        filterTextClear: false,
        moveOnSelect: true,
    });
    $('#department-type').change(function () {

        if (this.value.length) {

            if (this.value === 'Departmet') {
                $('.department-user').removeClass('hide');
                $('.branch-address').addClass('hide');
                $('.parent-branch').removeClass('hide');
            } else {
                $('.parent-branch').addClass('hide');
                $('.branch-address').removeClass('hide');
                $('.department-user').addClass('hide');
            }
        }
    });
    //FROM TO DATE SELECTOR By ID
    $('#FrDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        useCurrent: false,
    }).on("dp.change", function (e) {
        if (e.oldDate === null) {
            $(this).data('DateTimePicker').date(new Date(new Date(e.date).setHours(00, 00, 00)));
        }
        $('#ToDate').data("DateTimePicker").minDate(e.date);
    });
    //tweet to date
    $('#ToDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        useCurrent: false //Important! See issue #1075
    }).on("dp.change", function (e) {
        if (e.oldDate === null) {
            $(this).data('DateTimePicker').date(new Date(new Date(e.date).setHours(23, 59, 59)));
        }
        $('#FrDate').data("DateTimePicker").maxDate(e.date);
    });
    //FROM TO DATE SELECTOR BY Class
    $('.FrDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        useCurrent: false,
    }).on("dp.change", function (e) {
        if (e.oldDate === null) {
            $(this).data('DateTimePicker').date(new Date(new Date(e.date).setHours(00, 00, 00)));
        }
        $('.ToDate').data("DateTimePicker").minDate(e.date);
    });
    //tweet to date
    $('.ToDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        useCurrent: false //Important! See issue #1075
    }).on("dp.change", function (e) {
        if (e.oldDate === null) {
            $(this).data('DateTimePicker').date(new Date(new Date(e.date).setHours(23, 59, 59)));
        }
        $('.FrDate').data("DateTimePicker").maxDate(e.date);
    });
    /***********************CHART SECTION**********************************/
    if ($("#dashboard-chart").length) {
        Highcharts.chart('dashboard-chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Sales'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'INR'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                    name: 'Monthaly Sale',
                    color: 'red',
                    data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                }]
        });
    }

    /**********************************/
    tinymce.init({
        selector: '.text-editor',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | code',
//        content_css: [
//            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//            '//www.tinymce.com/css/codepen.min.css']
    });
    var config = {
        '#user-role': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    if (URL) {
        $('#profile-img').change(function () {
            var files = this.files;
            var file;
            if (files && files.length) {
                file = files[0];
                //uploadedImageType = file.type;
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;


                    uploadedImageURL = URL.createObjectURL(file);
                    $('#img-container').attr('src', uploadedImageURL);

                } else {

                    $('#profile-img').val('');
                    alert('Invalid Image File.');
                }
            }
        });
    }
});
function clearForm(form_id) {
    $('#' + form_id)[0].reset();
    return false;
}

/*********************************/
$(document).ready(function () {
    (function (xhr) {
        if ($('.fetch-amc').length) {
            $('.fetch-amc').click(function () {
                $this = $(this);
                window.XMLHttpRequest = xhr;
                var amc = $(this).data('amc');
                $.ajax({
                    url: JS_BASE_URL + "subscription/get-info",
                    type: 'POST',
                    data: {'sub_no': amc},
                    beforeSend: function (xhr) {
                        $('#amc-info').block({message: $('#block-ui')});
                    },
                    success: function (data, textStatus, jqXHR) {
                        $this.parent().siblings().removeClass('active');
                        $this.parent().addClass('active');
                        $('#amc-info').unblock();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Internal Error, Please try again.');
                        $('#amc-info').unblock();
                    }
                });
                window.XMLHttpRequest = null;
            });
        }
        if ($('#ticket_status').length) {
            $('#ticket_status').change(function () {

                if ($(this).val() === 'Forward') {
                    $('#user-select').collapse('show');
                } else {
                    $('#user-select').collapse('hide');
                }
            });

        }
        if ($('tr.view-ticket').length) {
            $('tr.view-ticket').click(function () {
                var url = $(this).data('url');
                location.href = url;
            });

        }

        $('.filter-ticket').click(function (e) {
            var target = $(this).data('target');
            var filter = $(this).data('filter');
            $('#' + target).val(filter);
            $('.search-form').submit();
        });
        if ($('#depart_list').length) {
            $('#depart_list').change(function () {
                $this = $(this);
                window.XMLHttpRequest = xhr;
                var did = $(this).val();
                var usr = $(this).data('usr');
                $.ajax({
                    url: JS_BASE_URL + "user/get-users",
                    type: 'GET',
                    data: {'did': did},
                    beforeSend: function (xhr) {
                        $.blockUI({message: $('#block-ui')});
                    },
                    success: function (data, textStatus, jqXHR) {
                        $.unblockUI();
                        var jsondata = jQuery.parseJSON(data);

                        var html = '<option>Select user</option>';
                        $.each(jsondata, function (k, v) {
                            html += '<option value="' + v.id + '">' + v.username + '</option>';
                        });
                        $('#user_list').removeClass('disabled');
                        $('#' + usr).html(html);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.unblockUI();
                        alert('Internal Error, Please try again.');
                        $('#amc-info').unblock();
                    }
                });
                window.XMLHttpRequest = null;
            });
        }
        if ($('#branch').length) {
            $('#branch').change(function () {
                $this = $(this);
                window.XMLHttpRequest = xhr;
                var bid = $(this).val();
                var dpr = $(this).data('dpr');
                $.ajax({
                    url: JS_BASE_URL + "department/get-department",
                    type: 'GET',
                    data: {'bid': bid},
                    beforeSend: function (xhr) {
                        $.blockUI({message: $('#block-ui')});
                    },
                    success: function (data, textStatus, jqXHR) {
                        $.unblockUI();
                        var jsondata = jQuery.parseJSON(data);
                        var html = '<option>Select Department</option>';
                        $.each(jsondata, function (v, k) {
                            html += '<option value="' + k.ID + '">' + k.name + '</option>';
                        });
                        console.log(dpr);
                        $('#' + dpr).html(html);
                        $('#user_list').html('<option>Select Department</option>');
                        $('#user_list').addClass('disabled');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.unblockUI();
                        alert('Internal Error, Please try again.');
                    }
                });
                window.XMLHttpRequest = null;
            });
        }
        if ($('.submit-reply').length) {
            $('.submit-reply').click(function () {
                if ($('#reply-text').val().length) {
                    if ($('#ticket_status').val() === "Forward" && $('#user_list').val() === "") {
                        alert('Select user for forward ticket.');
                        return;
                    }
                    console.log('sumit form ');
                    window.XMLHttpRequest = xhr;
                    $.ajax({
                        url: JS_BASE_URL + 'ticket/update',
                        type: 'POST',
                        data: $('#reply-form').serialize(),
                        beforeSend: function () {
                            $.blockUI({message: $('#block-ui')});
                        },
                        success: function (data, textStatus, jqXHR) {
                            $.unblockUI();
                            var jsondata = jQuery.parseJSON(data);
                            var aHtml = '<p>'+jsondata.subject+'</p><p>'+jsondata.text+'</p><p><i class="fa fa-clock-o" aria-hidden="true"></i> '+jsondata.created_on+', <i class="fa fa-user" aria-hidden="true"></i> '+jsondata.created_by+'</p>';
                            $('.activity-templte .activity-text').html(aHtml);
                            var $template = $('.activity-templte'),
                                $clone = $template
                                .clone()
                                .removeClass('hide')
                                .removeClass('activity-templte')
                                .addClass(jsondata.type);
                                $clone.insertAfter($template);
                           console.log(jsondata);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $.unblockUI();
                            alert('Internal Error! Please try again.');
                            console.log(jqXHR);
                        }
                    });
                    window.XMLHttpRequest = null;
                    
                } else {
                    alert('Reply cannot be blank.');
                }
            });
            $('.reply-type').click(function () {
                if ($(this).prop("checked") === true) {
                    $('#reply-to-user').val('yes');

                } else {
                    $('#reply-to-user').val('no');

                }
            });
        }
        $('#add-pc-info').click(function () {
            console.log($(this).data('amc'));
            $('#pc-info-modal').modal('show');
        });
        $('.country-list').change(function () {
            var c = $(this).val();
            var $this = $(this);
            window.XMLHttpRequest = xhr;
            $.ajax({
                url: JS_BASE_URL + 'user/get-states',
                type: 'GET',
                data: {'country': c},
                beforeSend: function () {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    var jsondata = jQuery.parseJSON(data);
                    var $state = $this.parent().closest('.country-input').next().children().find('.state-list');
                    var html = '';
                    $.each(jsondata, function (k, v) {
                        html += '<option value="' + k + '">' + v + '</option>';
                    });
                    $state.html(html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error! Please try again.');
                    console.log(jqXHR);
                }

            });
            window.XMLHttpRequest = null;
        });

    }(window.XMLHttpRequest));

    window.XMLHttpRequest = null;
});