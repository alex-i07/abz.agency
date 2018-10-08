import Dropzone from 'dropzone';

import swal from 'sweetalert'

import moment from 'moment';

moment.locale('ru');

window.Dropzone = Dropzone;
window.Dropzone.autoDiscover = false;

$(document).ready(function () {

    var form = document.getElementById("dropzone-about");
console.log(($('#dropzone-about').length), '($(dropzone).length)');
    // if(form !== null){
    if ($('#dropzone-about').length) {

        var dropzoneAbout = new Dropzone("#dropzone-about", {
            url: "/employee/save",
            previewsContainer: ".dropzone-previews",
            clickable: "#add-about",
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

                $('#remove-about').on('click', function (e) {
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

                    formData.append("name",  $('#name-about').val());  //this is dropzone formdata I assume
                    formData.append("email",  $('#email-about').val());
                    formData.append("password",  $('#password-about').val());
                    formData.append("position",  $('#position-about').val());
                    formData.append("date_of_employment",  moment($('#date_of_employment-create').val(), 'DD.MM.YYYY').format('DD.MM.YYYY'));
                    formData.append("salary",  $('#salary-about').val());
                    formData.append("parent_id",  $('#parent_id-about').val());

                    console.log(formData);
                });

                this.on('success', function (file, response){
                    console.log(response);


                    window.location = response;


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

                console.log("EMPLOYEE", window.employee);
                // var employee = JSON.parse(employee);

                //need to create thumbnail and display it if user has an avatar
                //for that I imitate file upload: create an empty file and display it thumbnail, thumbnail url points to user avatar

                if (window.employee.avatar !== null){
                    var mockFile = { name: "Filename", size: 12345 };
                    this.emit("addedfile", mockFile);

                    console.log(window.employee);

                    this.files[0] = mockFile;
                    console.log(this.files, typeof this.files, 'this.files');

                    this.emit("thumbnail", mockFile, 'http://' + window.location.host + '/storage/users-avatars/' + window.employee.avatar);
                    // dropzoneAbout.createThumbnailFromUrl(mockFile, window.employee.avatar);

                    // var existingFileCount = 1; // The number of files already uploaded
                    // this.options.maxFiles = this.options.maxFiles - existingFileCount;
                }

            }
        });

        $('#remove-employee').on('click', function(e) {

            var email = $('#email-about').val();

            axios.post('/employee/delete', {'email':email})
                .then(function (response) {
                    console.log(response.status);
                    console.log(response);

                    if (response.status == 200){
                        swal("Сотрудник был успешно удалён с базы данных!", {
                            icon: "success"
                        }).then(function() {
                            console.log("THEN");
                            window.open('/home', '_blank');
                        });
                    }
                })
                .catch(function (error) {
                    swal("Ошибка во время ajax-запроса!", {
                        icon: "error"
                    });
                });

        });
    }

    $('#apply-about').on('click', function (e) {
        console.log("SUBMIT WAS Presses!");

        e.preventDefault();
        e.stopPropagation();
        console.log(dropzoneAbout.getQueuedFiles().length);
        if (dropzoneAbout.getQueuedFiles().length > 0) {
            dropzoneAbout.processQueue();
        } else {
            $("#dropzone-about").submit();
        }
    });


});