require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$(document).ready(function() {
    $(function () {

        $('#name').on('click', function (e) {

            var icon = $('#name-i');

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

            $("#jstree_auth").jstree('refresh');

        });

        $('#position').on('click', function (e) {

            var icon = $('#position-i');

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

            var icon = $('#date-i');

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

            var icon = $('#salary-i');

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

                        return node.id === '#' ?
                            'auth-fetch-roots' :
                            'auth-fetch-children/' + node.id;
                    },
                    'success': function (data) {   //list-group-item

                        data.forEach(function (value) {

                            // value.text = value.name;

                            // value.text = '<span class="record name list-group-item list-group-item-action flex-column align-items-start">oioi</span>';
                            //     '<a href="employee/' + value.id + '/edit' +'" class="record name" target="_blank">' + value.name + '</a>' +
                            //     // '<img src="https://via.placeholder.com/50x50">' +
                            //     '<span class="record position">' + value.position + '</span>' +
                            //     '<span class="record date_of_employment">' + value.date_of_employment + '</span>' +
                            //     '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                            //     '<span class="badge">' + value.childrenNumber + '</span>' + '</span>';

                            value.text = '<a href="employee/' + value.id + '/edit' +'" class="record name" target="_blank">' + value.name + '</a>' +
                                // '<img src="https://via.placeholder.com/50x50">' +
                                '<span class="record position">' + value.position + '</span>' +
                                '<span class="record date_of_employment">' + value.date_of_employment + '</span>' +
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

                var a1 = this.get_node(a);
                var b1 = this.get_node(b);

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

                else if (window.order === 'desc') {
                    return (cmp1 < cmp2) ? 1 : -1;
                }

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

        var to = false;
        $('#search').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#search').val();

                $('#jstree_auth').jstree(true).search(v);

            }, 500);
        });

    });
});