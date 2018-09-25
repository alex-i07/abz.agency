require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$( document ).ready(function() {
    $(function () {
        $('#jstree_auth').jstree({
            'plugins' : [ 'sort', 'wholerow' ],
            'core': {
                'themes': {
                    'responsive': true,
                    'dots': false,
                    'icons': true
                },
                'data': {
                    'url': function (node) {
                        // console.log('NODE', node);
                        //
                        // console.log('ID', node.id);

                        return node.id === '#' ?
                            'auth-fetch-roots' :
                            'auth-fetch-children/' + node.id;
                    },
                    'success': function (data) {
                        // console.log(data, typeof data);

                        data.forEach(function (value) {
                            value.text = '<span class="record name">' + value.name + '</span>' +
                                '<span class="record position">' + value.position + '</span>' +
                                '<span class="record date_of_employment">' + moment(value.date_of_employment).format('DD.MM.YYYY') + '</span>' +
                                '<span class="record salary">' + value.salary + 'грн' + '</span>' +
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
                },
                'sort' : function(a, b) {
                    a1 = this.get_node(a);
                    b1 = this.get_node(b);
                    console.log(a1, b1);
                    // if (a1.icon == b1.icon){
                    // return (a1.text < b1.text) ? 1 : -1;
                    // } else {
                    //     return (a1.icon > b1.icon) ? 1 : -1;
                    // }
                    return -1;
                }

            }
        })

    });

    $('#name').on('click', function (e) {
        console.log(e, this);
        var icon = $('#name-i');
        var className = icon.attr('class');


        if (className === 'glyphicon glyphicon-chevron-down') {
            icon.removeClass("glyphicon-chevron-down");
            icon.addClass("glyphicon-chevron-up");
        }
        else {
            icon.removeClass("glyphicon-chevron-up");
            icon.addClass("glyphicon-chevron-down");
        }

    });

    $('#position').on('click', function (e) {
        console.log(e, this);
        var icon = $('#position-i');
        var className = icon.attr('class');


        if (className === 'glyphicon glyphicon-chevron-down') {
            icon.removeClass("glyphicon-chevron-down");
            icon.addClass("glyphicon-chevron-up");
        }
        else {
            icon.removeClass("glyphicon-chevron-up");
            icon.addClass("glyphicon-chevron-down");
        }

    });

    $('#date').on('click', function (e) {
        console.log(e, this);
        var icon = $('#date-i');
        var className = icon.attr('class');


        if (className === 'glyphicon glyphicon-chevron-down') {
            icon.removeClass("glyphicon-chevron-down");
            icon.addClass("glyphicon-chevron-up");
        }
        else {
            icon.removeClass("glyphicon-chevron-up");
            icon.addClass("glyphicon-chevron-down");
        }

    });

    $('#salary').on('click', function (e) {
        // console.log(e, this);
        var icon = $('#salary-i');
        var className = icon.attr('class');


        if (className === 'glyphicon glyphicon-chevron-down') {
            icon.removeClass("glyphicon-chevron-down");
            icon.addClass("glyphicon-chevron-up");
        }
        else {
            icon.removeClass("glyphicon-chevron-up");
            icon.addClass("glyphicon-chevron-down");
        }

    });

    // function toogle(id){
    //     var a = $(id);
    //
    //     var className = a.attr('class');
    //
    //     if (className === 'glyphicon-chevron-down') {
    //         a.removeClass("glyphicon-chevron-up");
    //     }
    //     else {
    //         a.addClass("glyphicon-chevron-down");
    //     }
    // }
});