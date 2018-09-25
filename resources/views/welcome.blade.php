@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <h4>Список сотрудников:</h4>

                </div>

                <div class="panel-body">

                    {{--<table class="table">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>Name</th>--}}
                            {{--<th>Position</th>--}}
                            {{--<th>Date of employment</th>--}}
                            {{--<th>Salary</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}


                    <div id="jstree_quest"></div>


                    {{--</table>--}}

                    {{--<div id="tree"></div>--}}

                    {{--<table class="table gtreetable" id="gtreetable"><thead><tr><th>Category</th></tr></thead></table>--}}
                    {{--<table id="gtreetable" class=""><thead><tr><th width="100%">Name</th></tr></thead></table> </div>--}}

                </div>

            </div>

        </div>

    </div>


@endsection
