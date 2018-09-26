@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="panel panel-info">
            <div class="panel-heading">

                <h4>Список сотрудников:</h4>

            </div>

                <div class="panel-body">
                    <div class="row">
                        <a id="name" class="col-md-6 sort-link" href="javascript:void(0);" tabindex="-1">Name&nbsp<i id="name-i" class="glyphicon glyphicon-chevron-up"></i></a>

                        <a id="position" class="col-md-2 sort-link" href="javascript:void(0);" tabindex="-1">Position&nbsp<i id="position-i" class="glyphicon glyphicon-chevron-up"></i></a>

                        <a id="date" class="col-md-2 sort-link" href="javascript:void(0);" tabindex="-1">Date of employment&nbsp<i id="date-i" class="glyphicon glyphicon-chevron-up"></i></a>
                        <a id="salary" class="col-md-2 sort-link" href="javascript:void(0);" tabindex="-1">Salary&nbsp<i id="salary-i" class="glyphicon glyphicon-chevron-up"></i></a>
                    </div>

                    <hr>

                    <div id="jstree_auth"></div>

                </div>

        </div>
    </div>
</div>
@endsection
