require('jstree');

$( document ).ready(function() {
    $(function () {
        $('#jstree_demo_div')
            .jstree()

    });

    $.jstree.defaults.core.themes.responsive = true;

    $.jstree.defaults.core.themes.dots = false;

    $.jstree.defaults.core.data = {
        'url': function (node) {
            console.log('NODE', node);

            console.log('ID', node.id);

            return node.id === '#' ?
                'fetch-roots' :
                'fetch-children/' + node.id;
        }
    };
});