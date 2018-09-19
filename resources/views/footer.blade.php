
<!-- Scripts -->
<script>

    window.firstEmployee = '{!! json_encode($firstEmployee) !!}';
    console.log(window.firstEmployee);

</script>


<script src="{{ asset('js/app.js') }}"></script>

<script>


//    var data = [
//             {
//                 text: "<span style='color:red;'>" + JSON.parse(window.firstEmployee).text + "</span>",
//                 // icon: "glyphicon glyphicon-stop",
//                 // selectedIcon: "glyphicon glyphicon-stop",
//                 // color: "#000000",
//                 // backColor: "#FFFFFF",
//                 // href: "#node-1",
//                 // selectable: true,
//                 state: {
//                     // checked: true,
//                     // disabled: true,
//                     // expanded: true
//                     // selected: false
//                 },
//                 tags: [JSON.parse(window.firstEmployee).tags],
//                 nodes: [
//                     {
//                      text: "Child 1",
//                      tags: ['1'],
//                      nodes: [
//                          {
//                              text: "Grandchild 1",
//                              tags: ['2']
//                          },
//                          {
//                              text: "Grandchild 2",
//                              tags: ['available']
//                          }
//                      ]
//                  }
//                 ]
//             }
//             ];
//
//    var onTreeNodeSelected = function (e, node) {
//        console.log(e, typeof e, node, typeof node);
//        var tree = $('#tree').treeview(true);
//        tree.expandNode(node);
//    };
//    var onTreeNodeExpanded = function (e, node) {
//        console.log("onTreeNodeExpanded");
//        var tree = $('#tree').treeview(true);
//        var expanded = tree.getExpanded();
//        console.log(" expanded count is " + expanded.length);
//    };
//    $('#tree').treeview({
//        data: data,
//        levels: 1,
//        showTags: true,
//        onNodeSelected: onTreeNodeSelected,
//        onNodeExpanded: onTreeNodeExpanded
//    });
</script>