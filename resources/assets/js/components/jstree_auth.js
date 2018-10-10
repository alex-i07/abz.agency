require('jstree');

import moment from 'moment';

moment.locale('ru');

import swal from 'sweetalert'

$(document).ready(function() {
    $(function () {

        $(document).ajaxSend(function(elm, xhr, s){
            if (s.type === "POST") {
                s.data += s.data?"&":"";
                s.data += "_token=" + document.head.querySelector('meta[name="csrf-token"]').content;
            }
        });

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
            'plugins' : [ 'sort', 'search', 'wholerow', 'dnd', 'massload', 'contextmenu' ],
            'core': {
                "check_callback" : true,
                'themes': {
                    'responsive': true,
                    'dots': false,
                    'icons': true
                },
                'multiple': false,
                'data': {
                    "dataType" : "json",
                    'url': function (node) {

                        return node.id === '#' ?
                            'auth-fetch-roots' :
                            'auth-fetch-children/' + node.id;
                    },
                    'success': function (data) {

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
            'contextmenu': {
                'show_at_node': false,
                'items': function($node) {
                    var tree = $("#jstree_auth").jstree(true);
                    return {
                        "about": {
                            "separator_before": true,
                            "separator_after": true,
                            "label": "Подробнее",
                            "action": function (node) {
                                window.open('/employee/' + tree.get_selected(node)[0].id + '/edit', '_blank');
                            }

                        },
                        "new": {
                            "separator_before": true,
                            "separator_after": true,
                            "label": "Создать нового сотрудника",
                            "action": function (node) {
                                window.open('/create-form', '_blank');
                            }

                        }
                    };

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
                    var cmp1 = moment(a1.original[window.sortItem], 'DD.MM.YYYY').valueOf();

                    var cmp2 = moment(b1.original[window.sortItem], 'DD.MM.YYYY').valueOf();
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
                    'type': 'GET'
                }
            },

            "massload": function(nodes, callback) {

                var notLoadedNodes = [];
                for (var key in nodes) {
                    if (!nodes.hasOwnProperty(key)) continue;
                    if (!this.is_loaded(nodes[key])) {
                        notLoadedNodes.push(nodes[key]);
                    }
                }
                if (notLoadedNodes.length === 0) {
                    return callback([]);
                }

                else {
                    axios.post('/fetch-massload', { ids: notLoadedNodes.join(',') }
                    )
                        .then(function (response) {

                            for (var key in nodes) {
                                if (!nodes.hasOwnProperty(key)) continue;

                                response.data[nodes[key]].forEach(function (value) {

                                    value.text = '<span class="record name">' + value.name + '</span>' +
                                        '<span class="record position">' + value.position + '</span>' +
                                        '<span class="record date_of_employment">' + moment(value.date_of_employment, 'YYYY-MM-DD').format('DD.MM.YYYY') + '</span>' +
                                        '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                        '<span class="badge">' + value.childrenNumber + '</span>';
                                });

                            }
                           return callback(response.data);
                        })
                        .catch(function (error) {
                            swal({
                                title: 'An error has occurred during AJAX request!',
                                text: 'Drag-n-drop might not be saved. Please, try again later',
                                icon: 'error',
                                closeModal: false
                            });
                            console.log(error);
                        });
                }
            },
        }).bind("move_node.jstree", function (e, data) {

            var oldParentId = Number(data.old_parent === '#' ? 0 : data.old_parent), newParentId = Number(data.parent === '#' ? 0 : data.parent);

            var send = {'id': data.node.id, 'oldParentId': oldParentId, 'newParentId': newParentId};

            axios.post('drag-n-drop', send)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    swal({
                        title: 'An error has occurred during AJAX request!',
                        text: 'Drag-n-drop might not be saved. Please, try again later',
                        icon: 'error',
                        closeModal: false
                    });
                    console.log(error);
                });
        }).bind("search.jstree", function (nodes, str, res) {

            $('.modal').removeClass('show');

            $('#search-input').val('');

            console.info('THE SEARCH IS COMPLETE');
        });

        $('#search-button').on('click', function (e) {
            e.preventDefault();
            var searchString = $('#search-input').val();

            if (moment(searchString, 'DD.MM.YYYY').isValid()){
                searchString = moment(searchString, 'DD.MM.YYYY').format('YYYY-MM-DD');
            }
            $('#jstree_auth').jstree(true).search(searchString);

            $('.modal').addClass('show');
        });
    });
});