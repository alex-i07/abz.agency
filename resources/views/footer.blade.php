{{--<div class="container text-center text-md-left">--}}

    {{--<div class="row">--}}

        {{--<div class="col-md-6 mx-auto">--}}

            {{--<p>Designed using <a href="https://laravel.com/" target="_blank">Laravel 5.4</a></p>--}}

        {{--</div>--}}

        {{--<hr class="clearfix w-100 d-md-none">--}}

        {{--<div class="col-md-6 mx-auto">--}}

            {{--<dl class="list-unstyled">--}}
                {{--<dt>--}}
                    {{--Also was used:--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<a href="https://www.jstree.com/" target="_blank">jstree</a>--}}
                {{--</dd>--}}
                {{--<dd>--}}
                    {{--<a href="https://getbootstrap.com/docs/3.3/getting-started/" target="_blank">Bootstrap 3</a>--}}
                {{--</dd>--}}
                {{--<dd>--}}
                    {{--<a href="https://momentjs.com/" target="_blank">Moment.js</a>--}}
                {{--</dd>--}}
                {{--<dd>--}}
                    {{--<a href="https://sweetalert.js.org/" target="_blank">SweetAlert</a>--}}
                {{--</dd>--}}
            {{--</dl>--}}

                {{--<hr class="clearfix w-100 d-md-none">--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<!-- Scripts -->

{{--<script type="text/javascript" src="https://raw.githubusercontent.com/gilek/bootstrap-gtreetable/master/dist/bootstrap-gtreetable.min.js"></script>--}}



<script src="{{ asset('js/app.js') }}"></script>


<script>

    {{--window.firstLevelEmployee = '{!! $firstLevelEmployee !!}';--}}
    {{--console.log(window.firstLevelEmployee, typeof window.firstLevelEmployee);--}}

</script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>--}}


<script>

//    $(function () {
//        $('#jstree_demo_div')
//            .jstree()
//
//    });
//
//    $.jstree.defaults.core.themes.responsive = true;
//
//    $.jstree.defaults.core.themes.dots = false;
//
//    $.jstree.defaults.core.data = {
//        'url' :  function (node) {
//            console.log('NODE', node);
//
//            console.log('ID', node.id);
//
//            return node.id === '#' ?
//                'fetch-roots' :
//                'fetch-children/' + node.id;
//        },
//    };

</script>

<script>

   /* $(function () {
        $('#jstree_demo_div')
            .jstree()
//            .on('open_node.jstree', function (e, data) {
//                console.log('NODE ' + data.node.id + 'was opened!');
//            data.instance.set_icon(data.node, "glyphicon glyphicon-minus");
//        }).on('close_node.jstree', function (e, data) {
//            console.log('NODE ' + data.node.id + 'was closed!');
//            data.instance.set_icon(data.node, "glyphicon glyphicon-plus");
//        });
    });

//    $(function () { $('#jstree_demo_div').jstree(
//        { 'core' : {
//        'data' : JSON.parse(window.firstLevelEmployee)
//    } }
//    );
//    });

//    $.jstree.defaults.core.themes.icons = true;

    $.jstree.defaults.core.themes.responsive = true;

    $.jstree.defaults.core.themes.dots = false;

//    $.jstree.defaults.core.data = JSON.parse(window.firstLevelEmployee);

//    $.jstree.defaults.core.data = [ {
//        "id":1,
//        "parent":"#",
//        "text":"Фокин Иннокентий Владимирович   Столяр   1994-10-05   101897",
//        "childrenNumber":1,
//        "hierarchyLevel":1,
//        "icon":false,
//        "state": {
//            "opened": false, "disabled": false, "selected": false
//        }
//        ,
//        "li_attr":[],
//        "a_attr":[]
//    }
//    ];

//    $('#jstree_demo_div')
//    // listen for event
//        .on('open_node.jstree', function (node) {
//            console.log('OPENED NODE');
//
//            axios
//        })
//        // create the instance
//        .jstree();






//function cb (url) {
//    console.log("CB");
//    axios.get(url)
//        .then(function(response) {
//
//            if (response.status === 200)
//            {
//
//                return response.data;
//
//            }
//
//        })
//        .catch( function (error) {
//            console.log(error);
//        });
//}
//
//    $('#jstree_demo_div').jstree({
//        'core' : {
//            'data' : function (obj, cb) {
//
//
//                var tmp = cb.call(this,'/fetch-children/12');
//
//                console.log('tmp', tmp);
//            }
//        }});

//    $('#jstree').jstree(true).settings.core.data = { 'url': 'fetch-data' };

    $.jstree.defaults.core.data = {
        'url' :  function (node) {
            console.log('NODE', node);
//            return 'fetchChildren';

            console.log('ID', node.id);

            return node.id === '#' ?
                'fetch-roots' :
                'fetch-children/' + node.id;
        }

//            function (node) {
//            return node.id === '#' ?
//                'ajax_roots.json' :
//                'ajax_children.json';
//        }
        ,
//        'data' : function (node) {
//            console.log('ID', node.id);
//            if (node.id == '#') {
//                var tmp = 1;
//            }
//            return { 'id' : tmp };
//        }
    };

   */

</script>