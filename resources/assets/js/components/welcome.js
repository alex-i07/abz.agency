// import swal from 'sweetalert'

$(document).ready(function() {

    function getTree() {

        var fleObj = JSON.parse(window.firstLevelEmployee);

        console.log(fleObj, typeof fleObj, 'console.log(fleObj');

        var data = [];

        fleObj.forEach(function(value) {

            var temp = {};

            temp.text = value.text;
            temp.dbId = value.dbId;
            temp.hierarchyLevel = value.hierarchyLevel;
            temp.tags = [value.childrenNumber];
            temp.nodes = [
                {
                //                      text: "Grandchild 1",
                //                      tags: ['2']
                                 }
                                 ];

            data.push(temp);
        });


        // for (value of fleObj) {
        //     console.log('value', value, typeof value);
        //
        //     data.push(value);
        // }

        // var data = [
        //     {
        //         text: "<span style='color:red;'>" + fleObj.text + "</span>",
        //         // icon: "glyphicon glyphicon-stop",
        //         // selectedIcon: "glyphicon glyphicon-stop",
        //         // color: "#000000",
        //         // backColor: "#FFFFFF",
        //         // href: "#node-1",
        //         // selectable: true,
        //         dbId: fleObj.dbId,
        //         hierarchyLevel: fleObj.hierarchyLevel,
        //         childrenNumber: [fleObj.childrenNumber],
        //         state: {
        //             // checked: true,
        //             // disabled: true,
        //             // expanded: true
        //             // selected: false
        //         },
        //         nodes: [
        //             {
        //              text: "Child 1",
        //              childrenNumber: ['1'],
        //              nodes: [
        //                  {
        //                      text: "Grandchild 1",
        //                      childrenNumber: ['2']
        //                  },
        //                  {
        //                      text: "Grandchild 2",
        //                      childrenNumber: ['available']
        //                  }
        //              ]
        //          }
        //         ]
        //     },
        //
        //     {
        //         text: "<span style='color:red;'>" + fleObj.text + "</span>",
        //         // icon: "glyphicon glyphicon-stop",
        //         // selectedIcon: "glyphicon glyphicon-stop",
        //         // color: "#000000",
        //         // backColor: "#FFFFFF",
        //         // href: "#node-1",
        //         // selectable: true,
        //         state: {
        //             // checked: true,
        //             // disabled: true,
        //             // expanded: true
        //             // selected: false
        //         },
        //         childrenNumber: [fleObj.childrenNumber],
        //         nodes: []
        //     }
        //
        //
        // ];

        console.log(data, typeof data);
        return data;
    }

    // var tree = $('#tree');

    // var onTreeNodeSelected = function (e, node) {
    //     // console.log('1', e, typeof e, node, typeof node, node.nodeId, typeof node.nodeId);
    //     // var tree = $('#tree').treeview(true);
    //     // tree.expandNode(node);
    //     // tree.treeview('collapseNode', [node, {silent: true, ignoreChildren: false}]);
    // };
    var onTreeNodeExpanded = function (e, node) {

        axios.get('fetch-children/' + node.dbId)
            .then(function(response) {
                if (response.status == 200) {
                    console.log(response);   // response.data[i]

                    var newNode = {
                        text: "newNode",
                        childrenNumber: ['33']
                    };

                    // $('#tree').treeview('addNode', [ newNode, 0 ]);

                    console.log('Node has been expanded', node.nodeId, typeof node.nodeId, node, typeof node);
                    var tree = $('#tree').treeview(true);
                    var expanded = tree.getExpanded();


                }
            })
            .catch(function(error) {

                console.log(error.response.data);

            swal({
                     title: "An error has occurred during ajax request!",
                     text: "Please, try again later",
                     icon: "error",
                     closeModal: false
                 });
            });




    };

    var onTreeNodeCollapsed = function (e, node) {

        console.log('Node has been collapsed', node.nodeId, typeof node.nodeId);

    };

    $('#tree').treeview({
        data: getTree(), showTags: true, levels: 1,
        // highlightSelected: true,
        // onNodeSelected: onTreeNodeSelected,
        onNodeExpanded: onTreeNodeExpanded,
        onNodeCollapsed: onTreeNodeCollapsed

    });

});