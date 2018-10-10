import Dropzone from 'dropzone';

import swal from 'sweetalert'

import moment from 'moment';

moment.locale('ru');

window.Dropzone = Dropzone;
window.Dropzone.autoDiscover = false;

$(document).ready(function () {
    var selectLevels = document.getElementById("hierarchy-create");

    var selectChiefs = document.getElementById("chiefs-create");

    //check if inputs with ids 'hierarchy-create' and 'chiefs-create' are exist
    //i.e. this is page /create

    if (selectLevels !=null && selectChiefs !=null) {

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
            resizeWidth: 120,
            resizeMethod: 'crop',
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

                    //remove previous file from Dropzone if new file was uploaded

                    if (typeof this.files[1] !== 'undefined') {
                        dzClosure.removeFile(this.files[0]);

                    }
                    document.querySelector(".dz-message").style.display = 'none';

                });

                this.on('sending', function(file, xhr, formData) {

                    //append data from form to Dropzone before sending ajax request

                    formData.append("name",  $('#name-create').val());  //this is dropzone formdata I assume
                    formData.append("email",  $('#email-create').val());
                    formData.append("password",  $('#password-create').val());
                    formData.append("position",  $('#position-create').val());
                    formData.append("date_of_employment",  $('#date_of_employment-create').val());
                    formData.append("salary",  $('#salary-create').val());
                    formData.append("hierarchy_level",  $('#hierarchy_level-create').val());
                    formData.append("parent_id",  $('#parent_id-create').val());

                });

                this.on('success', function (file, response){

                    window.location = '/employee/' + response + '/edit';

                });
                this.on('error', function (file, error, xhr)  {

                    swal({
                        title: 'An error has occurred during AJAX request!',
                        text: 'Please, try again later',
                        icon: 'error',
                        closeModal: false
                    });
                });

            }
        });

        var index;

        //chiefsPerLevel is a variable from php that denotes what employees at their hierarchy level
        //{1: {id: 0, name: "Нет начальника"}, 2: [{'id': 'id', 'name':employee1}, {'id': 'id', 'name':employee2}]}

        for(index in window.chiefsPerLevel) {

            selectLevels.options[selectLevels.options.length] = new Option(index, index);

        }

        //create options in select chiefs-create with employees of 1st hierarchy level

        window.chiefsPerLevel[1].forEach(function(item){
            selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
        });

        $('#hierarchy-create').on('change', function (e) {

            //when selection in hierarchy-create select input changes
            //refill chiefs-create select with new employees of selected level

            $('#chiefs-create').empty();

            window.chiefsPerLevel[selectLevels.selectedOptions[0].value].forEach(function(item){
                selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
            });
        });
    }

    $('#apply-create').on('click', function (e) {

        e.preventDefault();
        e.stopPropagation();

        //if there is uploaded image use dropzone to send ajax request, otherwise send usual form submit
        //because dropzon library will not process only form data without any file

        if (dropzoneCreate.getQueuedFiles().length > 0) {
            dropzoneCreate.processQueue();
        } else {
            $("#dropzone-create").submit();
        }
    })

});