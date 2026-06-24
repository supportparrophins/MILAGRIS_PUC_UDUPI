const getCustomizedDate = (argDate = new Date(),format="")=>{
    let tempDate, tempMonth, tempYear;
    tempDate = argDate.getDate();
    tempMonth = argDate.getMonth() + 1;
    tempYear = argDate.getFullYear();
    if(tempDate < 10) tempDate = "0"+tempDate;
    if(tempMonth < 10) tempMonth = "0"+tempMonth;

    if(format.trim()=="yyyy-mm-dd"){
        return tempYear + "-" +  tempMonth + "-" + tempDate; 
    }else if(format.trim()=="dd-mm-yyyy"){
        return tempDate + "-" +  tempMonth + "-" + tempYear; 
    }else{
        return argDate;
    }
}
const  addDateEventToCalendar = async (start=getCustomizedDate(new Date(),"dd-mm-yyyy"),end=getCustomizedDate(new Date(),"dd-mm-yyyy"))=>{
    const { value: dateFormValues } = await Swal.fire({
        title: 'Add Event',
        html:
            '<label class="float-left">Event Name:</label>'+
                '<input id="swal2-input-date-event" class="swal2-input">' +
            '<label class="float-left">Start Date:</label>' +
                '<input value="'+start+'" id="swal2-input-start-date" class="swal2-input datepicker">'+
            '<label class="float-left">End Date:</label>' +
                '<input value="'+end+'" id="swal2-input-end-date" class="swal2-input datepicker">',
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            return {
                'title':document.getElementById('swal2-input-date-event').value,
                'start':document.getElementById('swal2-input-start-date').value,
                'end':document.getElementById('swal2-input-end-date').value
            }
        }
    });
    if(dateFormValues) {
        return dateFormValues;
    }else{
        return false;
    }
}
const addTimeEventToCalendar = async (edate=getCustomizedDate(new Date(),"dd-mm-yyyy"),startH="00", startM="00", endH="00", endM="00")=>{
    const startTime = startH.toString().padStart(2,0) +":"+ startM.toString().padStart(2,0);
    const endTime = endH.toString().padStart(2,0) +":"+ endM.toString().padStart(2,0);
    const { value: timeFormValues } = await Swal.fire({
        title: 'Add Event on '+edate,
        html:
            '<label class="float-left">Event Name:</label>'+
                '<input id="swal2-input-time-event" class="swal2-input">' +
            '<label class="float-left">Start Time:</label>' +
                '<input type="time" value="'+startTime+'" id="swal2-input-start-time" class="swal2-input">'+
            '<label class="float-left">End Time:</label>' +
                '<input type="time" value="'+endTime+'" id="swal2-input-end-time" class="swal2-input">',
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            return {
                'id':Math.random(),
                'title':document.getElementById('swal2-input-time-event').value,
                'startTime':document.getElementById('swal2-input-start-time').value,
                'endTime':document.getElementById('swal2-input-end-time').value,
                'date': edate
            }
        }
    });
    if(timeFormValues) {
        return timeFormValues;
    }else{
        return false;
    }
}
const showSuccess = (msg="Success") =>{
    Swal.fire({
        icon: 'success',
        title: msg,
        showConfirmButton: true
    });
}
const showError = (msg="Something went wrong..!") =>{
    Swal.fire({
        icon: 'warning',
        title: msg,
        text: "Please try later",
        showConfirmButton: true,
    });
}

const showInfo = (msg="Please enter valid details..!") =>{
    Swal.fire({
        icon: 'info',
        title: msg,
        text: "Please try again",
        showConfirmButton: true,
    });
}