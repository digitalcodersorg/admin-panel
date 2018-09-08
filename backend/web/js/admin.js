/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $.blockUI.defaults.css.border = 'none';
    $.blockUI.defaults.css.background = 'none';
    $.blockUI.defaults.css.zIndex = '9999';
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
        if ($(this).val() !== '') {
            if ($(this).val() === 'Department') {
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
    /************************SET AUTO REFRESH    *********************/
    if ($('.auto-refresh').length) {
        $('.auto-refresh').click(function () {
            if ($(this).is(":checked")) {
                setCookie("auto-refresh", "yes", 30);
                autoRefresh(6000);
            } else {

                setCookie("auto-refresh", 'no', 30);
            }
        });
        var refresh = getCookie("auto-refresh");
        if (refresh !== "" && refresh === 'yes') {
            $('.auto-refresh')[0].checked = true;
            autoRefresh(6000);
        }

    }
    function autoRefresh(milis) {
        setTimeout(function () {
            if ($('.auto-refresh').is(":checked")) {
                location.reload();
            } else {
                $('#myProgress').fadeOut('slow');
            }
        }, milis);
        $('#myProgress').fadeIn('slow');
        var elem = document.getElementById("myBar");
        elem.style.width = '0%';
        var width = 0;
        var id = setInterval(frame, (milis / 100));
        function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                width++;
                elem.style.width = width + '%';
                //elem.innerHTML = width * 1 + '%';
            }
        }
    }
    /***********************CHART SECTION**********************************/
    if ($("#dashboard-chart").length) {
        Highcharts.chart('dashboard-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Average Rainfall'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                    name: 'Tokyo',
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                }, {
                    name: 'New York',
                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                }, {
                    name: 'London',
                    data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                }, {
                    name: 'Berlin',
                    data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

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
                var action = $(this).data('action');
                var url = $(this).data('url');
                if (action === 'view-ticket') {
                    location.href = url;
                } else {
                    var code = $(this).data('code');
                    $('#modal_ticket_code').html('#' + code);
                    $('#ticket_code').val(code);
                    $('.open-ticket').data('url', url);
                    $('#assign-popup').modal('show');
                }

            });

        }
        $('.open-ticket').click(function () {
            var url = $(this).data('url');
            location.href = url;
        });
        $('.create-ticket').click(function () {
            window.XMLHttpRequest = xhr;
            var formData = $('#create_ticket_form').serializeArray();
            if ($('#user_list_assign').val() === "") {
                alert('Please select an user for assign ticket.');
                return;
            }
            var ticket_code = $('#ticket_code').val();
            var role = $('#ticket_' + ticket_code).data('role');
            $.ajax({
                url: JS_BASE_URL + "ticket/assign-ticket",
                type: 'POST',
                data: formData,
                beforeSend: function (xhr) {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    if (data.trim() === "1") {
                        if (role === 'admin') {
                            $('#assign_' + ticket_code).text($("#user_list_assign option:selected").text());
                            $('#deart_' + ticket_code).text($("#depart_list_assign option:selected").text());
                        } else {
                            $('#ticket_' + ticket_code).remove();
                        }
                        $('#create_ticket_form')[0].reset();
                        $('#assign-popup').modal('hide');
                    } else {
                        alert('error');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error, Please try again.');
                }
            });
            window.XMLHttpRequest = null;
        });
        $('.filter-ticket').click(function (e) {
            var target = $(this).data('target');
            var filter = $(this).data('filter');
            $('#' + target).val(filter);
            $('.search-form').submit();
        });
        if ($('.depart_list').length) {
            $('.depart_list').change(function () {
                $this = $(this);
                window.XMLHttpRequest = xhr;
                var did = $(this).val();
                var usr = $(this).data('target');
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
                        //$('#user_list').removeClass('disabled');
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
        if ($('.branch_list').length) {
            $('.branch_list').change(function () {
                $this = $(this);
                window.XMLHttpRequest = xhr;
                var bid = $(this).val();
                var dpr = $(this).data('target');
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
                        //$('#user_list').html('<option>Select Department</option>');
                        //$('#user_list').addClass('disabled');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.unblockUI();
                        alert('Internal Error, Please try again.');
                    }
                });
                window.XMLHttpRequest = null;
            });
        }
        $('.search-filter').change(function () {
            $('.search-form').submit();
        });
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
                            if (typeof jsondata.error !== 'undefined') {
                                alert(jsondata.error);
                            } else {
                                var html = '<li class="' + jsondata.type + '"> \
                                <div class="block"> \
                                    <div class="block_content"> \
                                        <h2 class="title"> \
                                            <a>' + jsondata.subject + '</a> \
                                        </h2> \
                                        <div class="byline"> \
                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> ' + jsondata.created_on + '</span> by <a> ' + jsondata.created_by + '</a> \
                                        </div> \
                                        <p class="excerpt">' + jsondata.text + ' \
                                        </p> \
                                    </div> \
                                </div> \
                            </li>';
                                $('.activity-list').prepend(html);
                                $('#reply-text').val("");
                            }
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
        $('.forgot-form-submit').click(function (e) {
            e.preventDefault();
            window.XMLHttpRequest = xhr;
            $.ajax({
                url: JS_BASE_URL + "site/forgotpassword",
                type: 'POST',
                data: $('#forgot-form').serializeArray(),
                beforeSend: function () {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    var jsondata = jQuery.parseJSON(data);
                    $('#emailForgetPassword').val("");
                    $('.text-error').text(jsondata);
                    $('.text-error').removeClass('hide').fadeOut(5000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error! Please try again.');
                }
            });
            window.XMLHttpRequest = null;
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
        $('#save-user-data').click(function () {
            window.XMLHttpRequest = xhr;
            $.ajax({
                url: JS_BASE_URL + 'user/update-customer',
                type: 'POST',
                data: $('#update-user').serializeArray(),
                beforeSend: function () {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    //var jsondata = jQuery.parseJSON(data);
                    console.log(data);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error! Please try again.');
                }

            });
            window.XMLHttpRequest = null;
        });
        $('#update-user-personal-data').click(function () {
            window.XMLHttpRequest = xhr;
            $.ajax({
                url: JS_BASE_URL + 'user/update-customer-data',
                type: 'POST',
                data: $('#update-user-data').serializeArray(),
                beforeSend: function () {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    console.log(data);
                    $('.error-summary').addClass('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error! Please try again.');
                }

            });
            window.XMLHttpRequest = null;
        });
        $('.remove-data').click(function () {
            if (confirm('Are you sure want to delete this data!')) {
                var id = $(this).data('id');
                $('#' + id).remove();
                console.log('User ');
                $('.error-summary').removeClass('hide');
            } else {
                console.log('User not');
            }
        });
        $('#add-data-field').click(function () {
            var label = $('#add-cuetomer-info').val();
            if (label.length) {

                var new_id = label.toLowerCase();
                new_id = new_id.replace(/ /g, '_');
                var i = 0;
                var element_id = new_id;
                while ($('#' + element_id).length !== 0) {
                    element_id = new_id + '_' + i;
                    i++;
                }
                if (i > 4) {
                    alert('You cannot add more then 5 entry for same type of data.');
                    return;
                }
                label = (i === 0) ? label : label + ' ' + i;
                new_id = element_id;
                var key_num = $('.meta-data').length;
                $('#data-template .temp-label').text(label);
                $('#data-template .meta_key').attr('name', 'personl_data[' + key_num + '][meta_key]');
                $('#data-template .remove-data').data('id', new_id);
                $('#data-template .meta_key').val(label);
                $('#data-template textarea').attr('name', 'personl_data[' + key_num + '][meta_value]');
                var $template = $('#data-template'),
                        $clone = $template
                        .clone()
                        .removeClass('hide')
                        .addClass('meta-data')
                        .attr("id", new_id);

                $clone.insertBefore($template);
                $('.remove-data').unbind('click');
                $('.remove-data').click(function () {
                    if (confirm('Are you sure want to delete this data!')) {
                        $(this).parent().parent().remove();
                        $('.error-summary').removeClass('hide');
                    } else {
                        console.log('User not');
                    }
                });
                $('#data-template .meta_key').attr('name', '');
                $('#data-template textarea').attr('name', '');
                $('.error-summary').removeClass('hide');
            } else {
                alert('Please select data type.');
                return;
            }
        });
        $('.fetch-amc').click(function () {
            window.XMLHttpRequest = xhr;
            $.ajax({
                url: JS_BASE_URL + 'subscription/get-subscription',
                type: 'POST',
                data: $('#update-user-data').serializeArray(),
                beforeSend: function () {
                    $.blockUI({message: $('#block-ui')});
                },
                success: function (data, textStatus, jqXHR) {
                    $.unblockUI();
                    console.log(data);
                    $('.error-summary').addClass('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    alert('Internal Error! Please try again.');
                }
            });
            window.XMLHttpRequest = null;
        });
    }(window.XMLHttpRequest));
    window.XMLHttpRequest = null;
});
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}