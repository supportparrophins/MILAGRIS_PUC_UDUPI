
function checkForReply($success,$error){
    if($error !== ""){
        Swal.fire({
           icon: 'warning',
           title: $error,
           text: 'Please try again.'
        });
    }else if($success !== ""){
        Swal.fire(
           'Success',
           $success,
           'success'
        );
    }
}

const bytesToKB = (bytes=0)=>{
    return (bytes==0)? 0 : (bytes/1000);
}

const showErrorAlert = (msg="Something went wrong..!",subText="Please try again..!")=>{
    Swal.fire({
        icon: 'error',
        title: msg,
        text: subText
    });
 }
  const showWarningAlert = (msg="Please enter valid fields",subText="")=>{
    Swal.fire({
        icon: 'info',
        title: msg,
        text: subText
    });
 }
 const showSuccessAlert = (msg="Success..!",subText="")=>{
    Swal.fire({
        icon: 'success',
        title: msg,
        text:subText,
        showConfirmButton: true,
    });
 }
 const showConfirmationAlert = async (msg="Are you sure?",confirmBtnText="Confirm",confirmBtnColor="#3085d6")=>{
    return await Swal.fire({
        title: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: confirmBtnColor,
        cancelButtonColor: '#d33',
        confirmButtonText: confirmBtnText
      }).then((result) => {
        if (result.isConfirmed) {
            return true;
        }else{
            return false;
        }
      })
 }