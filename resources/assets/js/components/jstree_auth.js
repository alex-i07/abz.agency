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

                            value.text = '<span class="record name">' + value.name + '</span>' +
                                // '<a href="employee/' + value.id + '/edit' +'" class="record name" target="_blank">' + value.name + '</a>' +
                                // '<img src="https://via.placeholder.com/50x50">' +
                                '<span class="record position">' + value.position + '</span>' +
                                '<span class="record date_of_employment">' + value.date_of_employment + '</span>' +
                                '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                '<span class="badge">' + value.childrenNumber + '</span>';
                        })
                    },
                    'error': function (error) {

                        // swal({
                        //     title: 'An error has occurred during AJAX request!',
                        //     text: 'Please, try again later',
                        //     icon: 'error',
                        //     closeModal: false
                        // });

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
                                // console.log(tree.get_node (node));
                                window.open('/employee/' + tree.get_selected(node)[0].id + '/edit', '_blank');
                                // $node = tree.create_node($node);
                                // tree.edit($node);

                                // console.log(tree.get_selected(node)[0].id);
                            }

                        },
                        "new": {
                            "separator_before": true,
                            "separator_after": true,
                            "label": "Создать нового сотрудника",
                            "action": function (node) {
                                // console.log(tree.get_node (node));
                                window.open('/create-form', '_blank');
                                // $node = tree.create_node($node);
                                // tree.edit($node);

                                // console.log(tree.get_selected(node)[0].id);
                            }

                        }
                    };

                }
            },
            //     'items': {
            //         'about': {
            //             'label': function (node) {
            //                 return '<a class="list-group-item" href="#">Подробнее1';
            //             },
            //             'action': function (node) {
            //                 // console.log($(node).attr('id'));
            //                 console.log(node);
            //                 console.log(get_node (node));
            //                 window.open('/employee/' + node.id + '/edit', '_blank');
            //                 // return '<a class="list-group-item" href="/employee/' + node.id + '/edit">Подробнее</a>';
            //             }
            //         }
            //     },
            //     // 'items': function (node, callback) {
            //     //     console.log(node.id);
            //     //     return callback(['Поподробнее', function (node) {
            //     //                     console.log(node.id);
            //     //                     window.open('/employee/' + node.id + '/edit', '_blank');}]);
            //     //
            //     // }
            // },
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
                    // "url" : "fetch-massload",
                    'dataType': 'json',
                    'type': 'GET'
                }
            },

            "massload": function(nodes, callback) {

                console.log('MARKER');

                var notLoadedNodes = [];
                for (var key in nodes) {
                    if (!nodes.hasOwnProperty(key)) continue;
                    if (!this.is_loaded(nodes[key])) {
                        notLoadedNodes.push(nodes[key]);
                    }
                }
                if (notLoadedNodes.length === 0) {
                    callback([]);
                    return;
                }

                else {
                    // callback(notLoadedNodes);

                    axios.post('/fetch-massload', { ids: notLoadedNodes.join(',') }
                    )
                        .then(function (response) {
                            console.log(response.data);

                            for (var key in nodes) {
                                if (!nodes.hasOwnProperty(key)) continue;
                                // console.log(nodes[key], typeof nodes[key], key, typeof key, 'nodes[key]');
                                console.log(response.data[nodes[key]], 'nodes');

                                response.data[nodes[key]].forEach(function (value) {

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
                                        '<span class="record date_of_employment">' + moment(value.date_of_employment).format('DD.MM.YYYY') + '</span>' +
                                        '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                        '<span class="badge">' + value.childrenNumber + '</span>';
                                });


                                // for(var j in nodes[key]) {
                                //     console.log(nodes[key][j]);
                                // }
                                // nodes[key].forEach(function (value) {
                                //
                                //     // value.text = value.name;
                                //
                                //     // value.text = '<span class="record name list-group-item list-group-item-action flex-column align-items-start">oioi</span>';
                                //     //     '<a href="employee/' + value.id + '/edit' +'" class="record name" target="_blank">' + value.name + '</a>' +
                                //     //     // '<img src="https://via.placeholder.com/50x50">' +
                                //     //     '<span class="record position">' + value.position + '</span>' +
                                //     //     '<span class="record date_of_employment">' + value.date_of_employment + '</span>' +
                                //     //     '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                //     //     '<span class="badge">' + value.childrenNumber + '</span>' + '</span>';
                                //
                                //     value.text = '<a href="employee/' + value.id + '/edit' + '" class="record name" target="_blank">' + value.name + '</a>' +
                                //         // '<img src="https://via.placeholder.com/50x50">' +
                                //         '<span class="record position">' + value.position + '</span>' +
                                //         '<span class="record date_of_employment">' + value.date_of_employment + '</span>' +
                                //         '<span class="record salary">' + value.salary + 'грн.' + '</span>' +
                                //         '<span class="badge">' + value.childrenNumber + '</span>';
                                // });
                            }

                           return callback(response.data);
                            // callback([]);
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


                // $.get('/fetch-massload', {ids: notLoadedNodes.join(',')})
                //     .done(function (data) {
                //         // data = null;
                //         console.log(data);
                //         return data;
                //         // callback(data); // data needs to be a JSON object like: { "node_id" : { "id" : node_id, "text" : "asdf", ... }, other_node_id : { ... node data ...}  }
                //     });
                // return notLoadedNodes;
                // $.get('/fetch-massload', {'ids': nodes.join(',')})
            // },
            // .done(function (data) {
            //     callback(data); // data needs to be a JSON object like: { "node_id" : { "id" : node_id, "text" : "asdf", ... }, other_node_id : { ... node data ...}  }
            // })

            // 'massload' : function (nodes, callback) {
            //     $.get('/fetch-massload', {'ids': nodes.join(',')}) // example only
            //
            },
            // "massload" : {
            //     "url" : "fetch-massload",
            //     "dataType" : "json",
            //     "type": "get",
            //     "data" : function (nodes) {
            //         return {
            //             "ids" : nodes.join(",")
            //         };
            //     }
            // }
        }).bind("move_node.jstree", function (e, data) {
            // data.rslt.o is a list of objects that were moved
            // Inspect data using your fav dev tools to see what the properties are

            console.log('move_node.jstree, data', data);

            var oldParentId = Number(data.old_parent === '#' ? 0 : data.old_parent), newParentId = Number(data.parent === '#' ? 0 : data.parent);

            var send = {'id': data.node.id, 'oldParentId': oldParentId, 'newParentId': newParentId};

            console.log('ForSend', send);

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
        });

        // $(document).on('search.jstree', function (nodes, str, res) {
        //     console.log('SEARCH IS COMPLETE');
        //     console.log(nodes, typeof nodes);
        //     console.log(str, typeof str);
        //     console.log(res, typeof res);
        // });

        $(document).on('dnd_stop.vakata', function (e, data) {
            var ref = $('#jstree_auth').jstree(true);
            // console.log("REF", ref);

            var elementId = ref.get_node(data.element).id;
            var parentId = ref.get_node(data.element).parent;

            if (parentId === '#') {
                parentId = 0;
            }

            // console.log('DATA.ELEMENT', ref.get_node(data.element));
            //
            // console.log('ELEMENT-ID', ref.get_node(data.element).id);
            //
            // console.log("FUTURE PARENT", parentId, typeof parentId);
            //
            // var send = {'elementId': elementId, 'parentId': parentId};
            //
            // console.log('SEND', send, typeof send);

            // axios.post('drag-n-drop', send)
            //     .then(function (response) {
            //         console.log(response);
            //     })
            //     .catch(function (error) {
            //         swal({
            //             title: 'An error has occurred during AJAX request!',
            //             text: 'Drag-n-drop might not be saved. Please, try again later',
            //             icon: 'error',
            //             closeModal: false
            //         });
            //         console.log(error);
            //     });
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