$(document).ready(function(){
    /**
     * Show uploaded filename
     */
    $('#fileUploadBtn').change(function() {
        var fileName = $('#fileUploadBtn')[0].files[0].name;
        $(this).next('label').text(fileName);
      });

      /**
       * Validate and process file upload
       */
    $('#uploadBtn').on('click', function () {
        let fileInput = $('#fileUploadBtn');
        var allowedExtensions = /(\.csv)$/i;
        
        if (fileInput.get(0).files.length === 0) {
            swalAlert('error', 'Please upload excel file in csv format.');
            return false;
        }

        if (!allowedExtensions.exec(fileInput.val())) {
            swalAlert('error', 'Invalid file type. Please upload excel file in csv format.');
            return false;
        } 

        processFileUpload(fileInput[0].files[0]);
    });

    /**
     * Function to process file upload
     * @param fileData 
     */
    function processFileUpload(fileData) {
        var oFormData = new FormData();
        oFormData.append('fileUpload', fileData);
        
        $.ajax({
            'url': '/processUploadedFile',
            'type': 'POST',
            'dataType': 'json',
            'processData': false,
            'contentType': false,
            'enctype': 'multipart/form-data',
            'data': oFormData,
            success: function(response) {
                if (response.result === false) {
                    swalAlert('error', response.message);
                } else {
                    swalAlert('success', response.message, 1500);
                }
            },
            error: function(error) {
                swalAlert('error', 'Something went wrong. Please try again.');
            }
        });
    }
});
