require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$( document ).ready(function() {
    $(function () {
        $('#jstree_guest').jstree({
                    'plugins' : [ 'wholerow' ],
                    'core': {
                        'themes':
                            {
                                'responsive': true,
                                'dots' : false,
                                'icons' : true
                            },
                        'data': {
                            'url': function (node) {

                                return node.id === '#' ?
                                    'guest-fetch-roots' :
                                    'guest-fetch-children/' + node.id;
                            },
                            'success': function(data) {


                                data.forEach(function (value) {
                                    value.text = '<span class="record name">' + value.name + '</span>' +
                                        '<span class="record position">' + value.position + '</span>' +
                                        '<span class="record date_of_employment">' + moment(value.date_of_employment).format('DD.MM.YYYY')  + '</span>' +
                                        '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                        '<span class="badge">' + value.childrenNumber + '</span>';
                                })
                            },
                            'error': function (error) {
                                swal({
                                    title: 'An error has occurred during AJAX request!',
                                    text: 'Please, try again later',
                                    icon: 'error',
                                    closeModal: false
                                });

                                console.log(error);
                            }
                        }

                    }
                })
    });

});