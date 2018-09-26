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

                        // console.log(this.get_node(node));
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
                }
            },
            // 'sort' : function(a, b, c) {
            //     var a1 = this.get_node(a);
            //     var b1 = this.get_node(b);
            //     console.log(a1, b1, 'a1, b1 from sort function');
            //
            //     return (Number(a1.id) < Number(b1.id)) ? 1 : -1;
            //     // if (a1.icon == b1.icon){
            //     // return (a1.text < b1.text) ? 1 : -1;
            //     // } else {
            //     //     return (a1.icon > b1.icon) ? 1 : -1;
            //     // }
            //     // return -1;
            // }
        });
        // $.jstree.defaults.plugins.push("sort");
        // $.jstree.defaults.plugins.push("wholerow");

        // $.jstree.defaults.sort = function(a, b) {
        //     a1 = this.get_node(a);
        //     b1 = this.get_node(b);
        //     console.log(a1, b1);
        //
        //     return (a1.text > b1.text) ? 1 : -1;
        //     // if (a1.icon == b1.icon){
        //     // return (a1.text < b1.text) ? 1 : -1;
        //     // } else {
        //     //     return (a1.icon > b1.icon) ? 1 : -1;
        //     // }
        //     // return -1;
        // }

    });

    $('#name').on('click', function (e) {
        console.log(e, this);
        var icon = $('#name-i');
        var className = icon.attr('class');

// console.log($.jstree.defaults);

        var order;

        if (className === 'glyphicon glyphicon-chevron-down') {
            icon.removeClass("glyphicon-chevron-down");
            icon.addClass("glyphicon-chevron-up");

            order = 'desc';
        }
        else {
            icon.removeClass("glyphicon-chevron-up");
            icon.addClass("glyphicon-chevron-down");

            order = 'asc';
        }
        console.log(order, typeof order, 'ORDER1');

        $.jstree.defaults.sort = function(a, b, order) {
            var a1 = this.get_node(a);
            var b1 = this.get_node(b);
            console.log(order, typeof order, 'ORDER2');
            console.log(a1, b1, 'a1, b1 from sort function');

            if (order === 'asc') {
                return (a1.text < b1.text) ? 1 : -1;
            }

            else if (order === 'desc') {
                return (a1.text > b1.text) ? 1 : -1;
            }
        };
console.log("MARKER", $.jstree.defaults.sort);
        // $("#jstree_auth").jstree(true).destroy();

        // $('#jstree_auth').jstree({});
        // $("#jstree_auth").jstree(true).sort(root, true);
        // $("#jstree_auth").jstree(true)._redraw();

        $("#jstree_auth").jstree(true).sort($("#jstree_auth").get_node('8'), true);
        $("#jstree_auth").jstree(true).redraw_node($("#jstree_auth").get_node('8'), true);
        //
        // $("#jstree_auth").jstree(true).redraw();

        // $('#tree_auth').jstree({'core' : {'data': 'newData'}});

        // $("#jstree_auth").jstree('redraw',
        //     {
        //         'sort': function (a, b, order) {
        //             var a1 = this.get_node(a);
        //             var b1 = this.get_node(b);
        //             console.log(order, typeof order, 'ORDER2');
        //             console.log(a1, b1, 'a1, b1 from sort function');
        //
        //             if (order === 'asc') {
        //                 return (a1.name < b1.name) ? 1 : -1;
        //             }
        //
        //             else if (order === 'desc') {
        //                 return (a1.text > b1.text) ? 1 : -1;
        //             }
        //         }
        //     }
        //
        // );

            // return (Number(a1.id) < Number(b1.id)) ? 1 : -1;
            // if (a1.icon == b1.icon){
            // return (a1.text < b1.text) ? 1 : -1;
            // } else {
            //     return (a1.icon > b1.icon) ? 1 : -1;
            // }
            // return -1;


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