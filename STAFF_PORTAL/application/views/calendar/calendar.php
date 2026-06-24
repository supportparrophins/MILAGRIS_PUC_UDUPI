<link href="<?=base_url()?>assets/calendar/main.css" rel='stylesheet'/>
<script src="<?=base_url()?>assets/calendar/main.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert/sweetalert2.0.js"></script>
<script src="<?=base_url()?>assets/calendar/event-calendar.js"></script>

<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        width: 360px !important;
    }


    .form-control {
        border: 1px solid #000000 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 3px !important;
        color: black !important;

    }

    @media screen and (max-width: 480px) {
        .select2-container--default .select2-selection--single .select2-selection__arrow {

            margin-right: 20px !important;
        }

        .select2-container .select2-selection--single {
            width: 270px !important;
        }
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) { 
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<div class="row column_padding_card">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-7">
                                <span class="page-title">
                                    <i class="material-icons">today</i> Event Calendar
                                </span>
                            </div>    
                            <div class="col-5 text-right">
                             <a onclick="showLoader();window.history.back();"
                                    class="btn btn-primary mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>                     
                            </div>                                                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-0 column_padding_card">
        <div class="col column_padding_card">
            <div class="card card-small mb-4">
                <div class="card-body p-1 pb-2 text-center table-responsive">                    
                    <div id='calendar'></div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const getCalendarEvents = async () => {
        return await $.post("<?=base_url()?>api/calendar/getCalendarEvents");
    }

    const loadCalendar = (events = []) => {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridDay,listMonth'
            },
            initialDate: getCustomizedDate(new Date(), "yyyy-mm-dd"),
            weekNumbers: true,
            navLinks: true,
            editable: true,
            selectable: true,
            selectMirror: true,
            nowIndicator: true,
            dayMaxEvents: true,
            eventResizableFromStart: true,
            events: [...events],
            select: function(arg) {
                if (arg.allDay) {
                    addDateEventToCalendar(getCustomizedDate(arg.start, "dd-mm-yyyy"), getCustomizedDate(arg.start, "dd-mm-yyyy"))
                    .then(res => {
                        if (res) {
                            let { id, title, start, end } = res;
                            if (title != "") {
                                const eventObject = {
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: 1
                                }
                                $.post("<?=base_url()?>api/calendar/addEvent", { data: (eventObject) })
                                .done(postResult => {
                                    if (postResult > 0) {
                                        eventObject.id = postResult;
                                        calendar.addEvent(eventObject);
                                        calendar.unselect();
                                        showSuccess("Event added successfully");
                                        location.reload();
                                    } else {
                                        showError();
                                    }
                                }).catch(postErr => {
                                    showError();
                                });
                            } else {
                                showInfo("Please enter the event title..!");
                            }
                        }
                    }).catch(err => {
                        showError();
                    });
                } else {
                    addTimeEventToCalendar(getCustomizedDate(arg.start, "dd-mm-yyyy"), arg.start.getHours(), arg.start.getMinutes(), arg.end.getHours(), arg.end.getMinutes())
                    .then(res => {
                        if (res) {
                            let { id, title, startTime, endTime } = res;
                            const stime = startTime.split(':');
                            const etime = endTime.split(':');
                            if (stime.length == 2 && etime.length == 2) {
                                if (title != "") {
                                    var eventStart = new Date(arg.start.getFullYear(), arg.start.getMonth(), arg.start.getDate(), stime[0], stime[1]).toLocaleString('en-IN');
                                    eventStart = eventStart.replace(/,/g, "");
                                    var eventEnd = new Date(arg.start.getFullYear(), arg.start.getMonth(), arg.start.getDate(), etime[0], etime[1]).toLocaleString('en-IN');
                                    eventEnd = eventEnd.replace(/,/g, "");
                                    const eventObject = {
                                        title: title,
                                        start: eventStart,
                                        end: eventEnd,
                                        allDay: 0
                                    }
                                    $.post("<?=base_url()?>api/calendar/addEvent", { data: (eventObject) })
                                    .done(postResult => {
                                        if (postResult > 0) {
                                            eventObject.id = postResult;
                                            calendar.addEvent(eventObject);
                                            calendar.unselect();
                                            showSuccess("Event added successfully");
                                        } else {
                                            showError();
                                        }
                                    }).catch(postErr => {
                                        showError();
                                    });
                                } else {
                                    showInfo("Please enter the event title..!");
                                }
                            } else {
                                showInfo("Please enter valid time..!");
                            }
                        }
                    }).catch(err => {
                        showError();
                    })
                }
            },
            eventClick: function(arg) {
                const event = arg.event;
                if (event.extendedProps.isHoliday) {
                const holidayDateTo = arg.event.extendedProps.holiday_date_to;
                const holidayDate = arg.event.extendedProps.holiday_date;

                 // Parse and reformat the event date to d-m-Y
                const [year, month, day] = holidayDateTo.split('-');
                const [year1, month1, day1] = holidayDate.split('-');
                const formattedHolidayDateTo = `${day}-${month}-${year}`;
                const formattedHoliodayDate = `${day1}-${month1}-${year1}`;

                    Swal.fire({
                        title: '🎉 Holiday Information 🎉',
                        html: `
                            <style>
                                .holiday-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    font-family: Arial, sans-serif;
                                    border-radius: 8px;
                                    overflow: hidden;
                                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                                    background-color: #f9f9f9;
                                }
                                .holiday-table th,
                                .holiday-table td {
                                    padding: 15px;
                                    text-align: left;
                                }
                                .holiday-table th {
                                    background-color: #007bff;
                                    color: #fff;
                                    border-top: 2px solid #fff;
                                }
                                .holiday-table td {
                                    border-top: 1px solid #e0e0e0;
                                }
                            </style>
                            <table class="holiday-table">
                                <tr>
                                    <th>Reason</th>
                                    <td style="background-color:#e0f7fa">${event.title}</td>
                                </tr>
                                <tr>
                                    <th>From Date</th>
                                    <td>${formattedHoliodayDate}</td>
                                </tr>
                                <tr>
                                    <th>To Date</th>
                                    <td style="background-color:#e0f7fa">${formattedHolidayDateTo}</td>
                                </tr>
                            </table>
                        `,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                    });
                } else {
                    deleteEvent(event)
                    .then(res => {                  
                        if (res > 0) {
                            showSuccess("Event deleted successfully..!");
                            event.remove();
                        } else if (res != "cancel") {
                            showError();
                        }
                    })
                    .catch(err => {
                        showError();
                    })
                }
            },
            eventResize: function(info) {
                updateEvent(info.event)
                .then(res => {                 
                    if (res > 0) {
                        showSuccess("Event updated successfully..!");
                    } else if (res != "cancel") {
                        showError();
                        info.revert();                        
                    } else {
                        info.revert();
                    }
                }).catch(err => {
                    showError();
                });
            }
        });
        calendar.render();
    };

    const deleteEvent = async (evt) => {
        try {
            const { id, title } = evt;
            return await Swal.fire({
                title: 'Are you sure you want to delete event "' + title + '" ?',
                showCancelButton: true,
                confirmButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    return $.post("<?=base_url()?>api/calendar/deleteEvent", { eventID: id });                    
                } else {
                    return "cancel";
                }
            });
        } catch($ex) {
            showError();
            return 0;
        }
    }

    const updateEvent = async (evt) => {
        try {
            const { id, title, start, end } = evt;
            const postData = {
                id: id,
                start: start,
                end: end
            }
            return await Swal.fire({
                title: 'Do you want to save the changes of "' + title + '" ?',
                showCancelButton: true,
                confirmButtonText: `Save`,
            }).then((result) => {
                if (result.isConfirmed) {
                    return $.post("<?=base_url()?>api/calendar/updateEvent", { data: postData });
                } else {
                    return "cancel";
                }
            });
        } catch($ex) {
            showError();
            return 0;
        }
    }

    $(document).ready(() => {
        showLoader();
        getCalendarEvents()
        .then(calEvts => {
            hideLoader();
            try {
                let events = JSON.parse(calEvts);
                events.map((evt) => {
                    evt.allDay = +evt.allDay;
                    evt.start = new Date(evt.start);                
                    evt.end = new Date(evt.end);
                    evt.end.setDate(evt.end.getDate() + 1);
                });
                loadCalendar(events);
            } catch($ex) {
                hideLoader();
                showError("Can't load calendar..!");
            }
        })
        .catch(postErr => {
            hideLoader();
            showError("Can't load calendar..!");
        });

        $('body').on('focus', ".datepicker", function(){
            $(this).datepicker({
                autoclose: true,
                format: "dd-mm-yyyy"
            });
        });
    });
</script>





