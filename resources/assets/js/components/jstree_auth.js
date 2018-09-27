require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$( document ).ready(function() {
    $(function () {

        $('#name').on('click', function (e) {
            console.log(e, this);
            var icon = $('#name-i');
            // var className = icon.attr('class');

            // var order;


            // if (className === 'glyphicon glyphicon-chevron-down') {
            //     icon.removeClass("glyphicon-chevron-down");
            //     icon.addClass("glyphicon-chevron-up");
            //
            //     // window.order = 'desc';
            // }
            // else {
            //     icon.removeClass("glyphicon-chevron-up");
            //     icon.addClass("glyphicon-chevron-down");
            //
            //     // window.order = 'asc';
            // }

            window.sortItem = 'name';

            window.order === 'asc' ? window.order = 'desc' : window.order = 'asc';

            if (window.order === 'asc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-down');
            }

            else if (window.order === 'desc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-up');
            }

            $('#position-i').css('opacity', '0');
            $('#date-i').css('opacity', '0');
            $('#salary-i').css('opacity', '0');
            // console.log(order, typeof order, 'ORDER1');
            //
            // $.jstree.defaults.sort = function(a, b, sortItem, order) {
            //     console.log(order, typeof order, sortItem, typeof sortItem, 'ORDER2');
            //     if (sortItem === 'underfined') {
            //         sortItem = 'text';
            //     }
            //
            //     if (order === 'underfined') {
            //         order = 'desc';
            //     }
            //
            //     var a1 = this.get_node(a);
            //     var b1 = this.get_node(b);
            //     console.log(a, typeof a, b, typeof b, 'a, typeof a, b, typeof b');
            //     console.log(order, typeof order, sortItem, typeof sortItem, 'ORDER3');
            //     console.log(a1, b1, 'a1, b1 from sort function');
            //
            //     if (order === 'asc') {
            //         return (a1[sortItem] < b1[sortItem]) ? 1 : -1;
            //     }
            //
            //     else if (order === 'desc') {
            //         return (a1[sortItem] > b1[sortItem]) ? 1 : -1;
            //     }
            // };
            // console.log("MARKER", $.jstree.defaults.sort);

            // $("#jstree_auth").jstree(true).sort($('#jstree_auth').jstree(true).get_node('8'), true);
            // $("#jstree_auth").jstree(true).redraw_node($("#jstree_auth").get_node('8'), true);

            $("#jstree_auth").jstree('refresh');

        });

        $('#position').on('click', function (e) {
            console.log(e, this);
            var icon = $('#position-i');
            // var className = icon.attr('class');


            // if (className === 'glyphicon glyphicon-chevron-down') {
            //     icon.removeClass("glyphicon-chevron-down");
            //     icon.addClass("glyphicon-chevron-up");
            // }
            // else {
            //     icon.removeClass("glyphicon-chevron-up");
            //     icon.addClass("glyphicon-chevron-down");
            // }

            window.sortItem = 'position';

            window.order === 'asc' ? window.order = 'desc' : window.order = 'asc';

            if (window.order === 'asc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-down');
            }

            else if (window.order === 'desc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-up');
            }

            $('#name-i').css('opacity', '0');
            $('#date-i').css('opacity', '0');
            $('#salary-i').css('opacity', '0');

            $("#jstree_auth").jstree('refresh');

        });

        $('#date').on('click', function (e) {
            console.log(e, this);
            var icon = $('#date-i');
            // var className = icon.attr('class');


            // if (className === 'glyphicon glyphicon-chevron-down') {
            //     icon.removeClass("glyphicon-chevron-down");
            //     icon.addClass("glyphicon-chevron-up");
            // }
            // else {
            //     icon.removeClass("glyphicon-chevron-up");
            //     icon.addClass("glyphicon-chevron-down");
            // }

            window.sortItem = 'date_of_employment';

            window.order === 'asc' ? window.order = 'desc' : window.order = 'asc';

            if (window.order === 'asc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-down');
            }

            else if (window.order === 'desc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-up');
            }

            $('#position-i').css('opacity', '0');
            $('#name-i').css('opacity', '0');
            $('#salary-i').css('opacity', '0');

            $("#jstree_auth").jstree('refresh');

        });

        $('#salary').on('click', function (e) {
            // console.log(e, this);
            var icon = $('#salary-i');
            // var className = icon.attr('class');


            // if (className === 'glyphicon glyphicon-chevron-down') {
            //     icon.removeClass("glyphicon-chevron-down");
            //     icon.addClass("glyphicon-chevron-up");
            // }
            // else {
            //     icon.removeClass("glyphicon-chevron-up");
            //     icon.addClass("glyphicon-chevron-down");
            // }

            window.sortItem = 'salary';

            window.order === 'asc' ? window.order = 'desc' : window.order = 'asc';

            if (window.order === 'asc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-up');
            }

            else if (window.order === 'desc') {
                icon.css('opacity', '1').attr('class', 'glyphicon glyphicon-chevron-down');
            }

            $('#position-i').css('opacity', '0');
            $('#date-i').css('opacity', '0');
            $('#name-i').css('opacity', '0');

            $("#jstree_auth").jstree('refresh');

        });

        $('#jstree_auth').jstree({
            'plugins' : [ 'sort', 'search', 'wholerow' ],
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
                                '<span class="record date_of_employment">' + moment(value.date_of_employment, 'YYYY-MM-DD').format('DD.MM.YYYY') + '</span>' +
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
            },
            'sort' : function(a, b) {


                window.sortItem = window.sortItem || 'name';

                window.order = window.order || 'asc';

                // if (window.sortItem === 'underfined') {
                //     window.sortItem = 'text';
                // }
                //
                // if (window.order === 'underfined') {
                //     window.order = 'asc';
                // }

                var a1 = this.get_node(a);
                var b1 = this.get_node(b);
                console.log(window.order, typeof window.order, window.sortItem, typeof window.sortItem, 'ORDER3');
                // console.log(a1, b1, 'a1, b1 from sort function');

                if (window.sortItem === 'salary') {
                    var cmp1 = Number(a1.original[window.sortItem]);

                    var cmp2 = Number(b1.original[window.sortItem]);
                }

                else if (window.sortItem === 'date_of_employment') {
                    var cmp1 = moment(a1.original[window.sortItem], 'YYYY-MM-DD').valueOf();

                    var cmp2 = moment(b1.original[window.sortItem], 'YYYY-MM-DD').valueOf();
                }

                else {
                    var cmp1 = a1.original[window.sortItem];

                    var cmp2 = b1.original[window.sortItem];
                }

                if (window.order === 'asc') {
                    return (cmp1 > cmp2) ? 1 : -1;
                }

                // else {
                //     return (a1.text > b1.text) ? 1 : -1;
                // }

                else if (window.order === 'desc') {
                    return (cmp1 < cmp2) ? 1 : -1;
                }

                // if (window.order === 'asc') {
                //     return (a1[window.sortItem] < b1[window.sortItem]) ? 1 : -1;
                // }
                //
                // else if (window.order === 'desc') {
                //     return (a1[window.sortItem] > b1[window.sortItem]) ? 1 : -1;
                // }
            },
            'search': {
                'ajax': {
                    'url': '/search',
                    'dataType': 'json',
                    'type': 'GET',
                    // 'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]')
                }
            }
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
console.log(document.head.querySelector('meta[name="csrf-token"]'));
        var to = false;
        $('#search').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#search').val();

                if (moment(v, 'DD/MM/YYYY').isValid()){
                    console.log(v);
                    v = moment(v).format("YYYY-MM-DD");
                    console.log(v);
                }

                $('#jstree_auth').jstree(true).search(v);
            }, 500);
        });

    });
});