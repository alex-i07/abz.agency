function getTree() {
    let data = [
        {
            text: "<span style='color:red;'>Parent</span>",
            tags: ['5'],
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
                },
                {
                    text: "Child 2"
                }
            ]
        },
        {
            text: "Parent 2"
        },
        {
            text: "Parent 3"
        },
        {
            text: "Parent 4"
        },
        {
            text: "Parent 5"
        }
    ];
    return data;
}

$('#tree').treeview({data: getTree(), showTags: true});