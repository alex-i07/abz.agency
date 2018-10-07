import Dropzone from 'dropzone';

import swal from 'sweetalert'

import moment from 'moment';

moment.locale('ru');

window.Dropzone = Dropzone;
window.Dropzone.autoDiscover = false;

$(document).ready(function () {
    var selectLevels = document.getElementById("hierarchy-create");

    var selectChiefs = document.getElementById("chiefs-create");

    if (selectLevels !=null && selectChiefs !=null) {
        console.log(chiefsPerLevel, typeof chiefsPerLevel, selectLevels, typeof selectLevels, selectChiefs, typeof selectChiefs);

        var dropzoneCreate = new Dropzone("#dropzone-create", {
            url: "create",
            previewsContainer: ".dropzone-previews",
            clickable: "#add-create",
            paramName: "avatar",
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFiles: 2,
            maxFilesize: 3,
            resizeHeight: 120,
            dictFileTooBig: 'Разрешены только файлы размером менее 3МБ',
            previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  " +
            "<div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  " +
            "<div class=\"dz-details\">\n    " +
            "<div class=\"dz-size\"><span data-dz-size></span></div>\n    " +
            "<div class=\"dz-filename\"><span data-dz-name></span></div>\n  " +
            "</div>\n  " +
            "<div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  ",
            acceptedFiles: 'image/*',

            init: function () {
                var dzClosure = this;

                $('#remove-create').on('click', function (e) {
                    removeInfo();
                });

                function removeInfo() {

                    dzClosure.removeAllFiles(true);

                    document.querySelector(".dz-message").innerHTML = 'Используйте кнопки или перетащите файл';
                    document.querySelector(".dz-message").style.display = 'block';
                };

                this.on("addedfile", function (file) {

                    if (typeof this.files[1] !== 'undefined') {
                        dzClosure.removeFile(this.files[0]);

                    }
                    document.querySelector(".dz-message").style.display = 'none';

                });

                this.on('thumbnail', function (file, dataURL) {

                    //file here is original, not a thumbnail, but dataURL is a base64 code of a thumbnail

                    console.log(file);

                    // self.thumbnail = dataURL;

                });

                this.on('sending', function(file, xhr, formData) {

                    formData.append("name",  $('#name-create').val());  //this is dropzone formdata I assume
                    formData.append("email",  $('#email-create').val());
                    formData.append("password",  $('#password-create').val());
                    formData.append("position",  $('#position-create').val());
                    formData.append("date_of_employment",  moment($('#date_of_employment-create').val(), 'DD.MM.YYYY').format('DD.MM.YYYY'));
                    formData.append("salary",  $('#salary-create').val());
                    formData.append("hierarchy_level",  $('#hierarchy_level-create').val());
                    formData.append("parent_id",  $('#parent_id-create').val());

                    console.log(formData);
                });

                this.on('success', function (file, response){
                    console.log(response);


                        window.location = '/employee/' + response + '/edit';


                });
                this.on('error', function (file, error, xhr)  {
                    console.log(error);
                    console.log(xhr);

                    swal({
                        title: 'An error has occurred during AJAX request!',
                        text: 'Please, try again later',
                        icon: 'error',
                        closeModal: false
                    });
                });

            }
        });

        console.log('CHIEFSPERLEVEL', window.chiefsPerLevel);
        // var chiefsPerLevelObject = JSON.parse(chiefsPerLevel);

        //Let set hierarchy and chief selects
        var index;

        for(index in window.chiefsPerLevel) {

            selectLevels.options[selectLevels.options.length] = new Option(index, index);

        }

        window.chiefsPerLevel[1].forEach(function(item){
            selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
        });



        $('#hierarchy-create').on('change', function (e) {

            $('#chiefs-create').empty();

            window.chiefsPerLevel[selectLevels.selectedOptions[0].value].forEach(function(item){
                selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
            });
        });
    }

    $('#apply-create').on('click', function (e) {
        console.log("SUBMIT WAS Presses!");

        e.preventDefault();
        e.stopPropagation();
console.log(dropzoneCreate.getQueuedFiles().length);
        if (dropzoneCreate.getQueuedFiles().length > 0) {
            dropzoneCreate.processQueue();
        } else {
            $("#dropzone-create").submit();
        }
    })

});