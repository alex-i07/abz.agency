require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$( document ).ready(function() {
    $(function () {
        $('#jstree_quest').jstree({
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
                                // console.log('NODE', node);
                                //
                                // console.log('ID', node.id);

                                return node.id === '#' ?
                                    'guest-fetch-roots' :
                                    'guest-fetch-children/' + node.id;
                            },
                            'success': function(data) {
                                console.log(data, typeof data);

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

    // $.jstree.defaults.core.themes.responsive = true;
    //
    // $.jstree.defaults.core.themes.dots = false;
    //
    // $.jstree.defaults.core.themes.icons = true;
    //
    // // $.jstree.defaults.plugins = ['sort'];
    //
    // $.jstree.defaults.core.data = {
    //     'url': function (node) {
    //         // console.log('NODE', node);
    //         //
    //         // console.log('ID', node.id);
    //
    //         return node.id === '#' ?
    //             'fetch-roots' :
    //             'fetch-children/' + node.id;
    //     },
    //     'success': function(data) {
    //         console.log(data, typeof data);
    //
    //         data.forEach(function (value) {
    //             value.text = '<span class="record name">' + value.name + '</span>' +
    //                 '<span class="record position">' + value.position + '</span>' +
    //                 '<span class="record date_of_employment">' + moment(value.date_of_employment).format('DD.MM.YYYY')  + '</span>' +
    //                 '<span class="record salary">' + value.salary + 'грн' + '</span>' +
    //                 '<span class="badge">' + value.childrenNumber + '</span>';
    //         })
    //     },
    //     'error': function (error) {
    //         swal({
    //             title: 'An error has occurred during AJAX request!',
    //             text: 'Please, try again later',
    //             icon: 'error',
    //             closeModal: false
    //         });
    //
    //         console.log(error);
    //     }
    // };
});