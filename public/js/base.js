/**
 * Function to show alerts
 * @param iconType 
 * @param message 
 * @param iTimer 
 */
function swalAlert(iconType, message, iTimer = null) {
    if (iTimer === null) {
        Swal.fire({
            icon: iconType,
            text: message
        });
    } else {
        Swal.fire({
            icon: iconType,
            text: message,
            timer: iTimer,
            showConfirmButton: false
        }).then(function() {
            location.reload();
        });
    }
}
