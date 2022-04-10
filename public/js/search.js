$(document).ready(function(){
    $('#searchBtn').on('click', function () {
        let sSearchKey = $('#selectSearchKey').find(":selected").val();
        let sSearchValue = $('#selectSearchValue').val();
        const FILE_HEADER = ['year','rank','recipient','country','career','tied','title'];

        if ($.inArray(sSearchKey, FILE_HEADER) === -1) {
            swalAlert('info', 'Please select a search option.');
            return false;
        }

        if (sSearchValue === '') {
            swalAlert('info', 'Please input search value.');
            return false;
        }

        window.location.href = '/search?' + sSearchKey + '=' + sSearchValue;
    });
});