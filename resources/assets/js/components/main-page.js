import swal from 'sweetalert'

$(document).ready(function() {

    jQuery(function ($) {

        jQuery('#tree').gtreetable({
            "source": function (id) {
                return {
                    type: 'GET',
                    url: 'fetch-children/' + node.dbId,
                    dataType: 'json',
                    error: function (XMLHttpRequest) {
                        console.log(XMLHttpRequest.status + ': ' + XMLHttpRequest.responseText);

                        swal({
                            title: "An error has occurred during ajax request!",
                            text: "Please, try again later",
                            icon: "error",
                            closeModal: false
                        });
                    }
                };

            }
        });
    });
});
