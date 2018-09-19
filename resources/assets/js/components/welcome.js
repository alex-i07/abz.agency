$( document ).ready(function() {

    function getTree() {

        var data = [
            {
                text: "<span style='color:red;'>" + JSON.parse(window.firstEmployee).text + "</span>",
                // icon: "glyphicon glyphicon-stop",
                // selectedIcon: "glyphicon glyphicon-stop",
                // color: "#000000",
                // backColor: "#FFFFFF",
                // href: "#node-1",
                // selectable: true,
                state: {
                    // checked: true,
                    // disabled: true,
                    // expanded: true
                    // selected: false
                },
                tags: [JSON.parse(window.firstEmployee).tags],
                nodes: [
                    {
                     text: "Child 1",
                     tags: ['1'],
                     nodes: [
                         {
                             text: "Grandchild 1",
                             tags: ['2']
                         },
                         {
                             text: "Grandchild 2",
                             tags: ['available']
                         }
                     ]
                 }
                ]
            }
        ];


        // var data = [
        //     {
        //         text: "<span style='color:red;'>" + JSON.parse(window.firstEmployee).text + "</span>",
        //         tags: JSON.parse(window.firstEmployee).tags,
        //         nodes: [
        //             {
        //                 text: "Child 1",
        //                 tags: ['1'],
        //                 nodes: [
        //                     {
        //                         text: "Grandchild 1",
        //                         tags: ['2']
        //                     },
        //                     {
        //                         text: "Grandchild 2",
        //                         tags: ['available']
        //                     }
        //                 ]
        //             },
        //             {
        //                 text: "Child 2"
        //             }
        //         ]
        //     },
        //     {
        //         text: "Parent 2"
        //     },
        //     {
        //         text: "Parent 3"
        //     },
        //     {
        //         text: "Parent 4"
        //     },
        //     {
        //         text: "Parent 5"
        //     }
        // ];

        // var data = '{{json_encode($firstEmployee)}}}';
        // console.log(data, typeof data); //{{json_encode($firstEmployee)}}} string

        // var data = JSON.parse(window.firstEmployee);
        console.log(data, typeof data);
        return data;
    }

    // var tree = $('#tree');

    var onTreeNodeSelected = function (e, node) {
        // console.log('1', e, typeof e, node, typeof node, node.nodeId, typeof node.nodeId);
        // var tree = $('#tree').treeview(true);
        // tree.expandNode(node);
        // tree.treeview('collapseNode', [node, {silent: true, ignoreChildren: false}]);
    };
    var onTreeNodeExpanded = function (e, node) {

        console.log('Node has been expanded', node.nodeId, typeof node.nodeId);
        var tree = $('#tree').treeview(true);
        var expanded = tree.getExpanded();

    };

    var onTreeNodeCollapsed = function (e, node) {

        console.log('Node has been collapsed', node.nodeId, typeof node.nodeId);

    };

    $('#tree').treeview({
        data: getTree(), showTags: true, levels: 1,
        highlightSelected: true,
        onNodeSelected: onTreeNodeSelected,
        onNodeExpanded: onTreeNodeExpanded,
        onNodeCollapsed: onTreeNodeCollapsed

    });

});

// tree.treeview('collapseNode', [ 0, { silent: true, ignoreChildren: false } ]);










// var data = [
//     {
//         text: "Parent 1",
//         nodes: [
//             {
//                 text: "Child 1"
//             },
//             {
//                 text: "Child 2"
//             }
//         ]
//     },
//     {
//         text: "Parent 2"
//     }
// ];
//
// var onTreeNodeSelected = function (e, node) {
//     console.log("onTreeNodeSelected")
//     var tree = $('#tree').treeview(true)
//     tree.expandNode(node)
// }
// var onTreeNodeExpanded = function (e, node) {
//     console.log("onTreeNodeExpanded")
//     var tree = $('#tree').treeview(true)
//     var expanded = tree.getExpanded()
//     console.log(" expanded count is " + expanded.length)
// }
// $('#tree').treeview({
//     data: data,
//     levels: 1,
//     highlightSelected: true,
//     onNodeSelected: onTreeNodeSelected,
//     onNodeExpanded: onTreeNodeExpanded
// });