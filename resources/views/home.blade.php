@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">

                    <h4>Список сотрудников:</h4>

                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="panel-body">
                            <a id="name" href="javascript:void(0);" tabindex="-1">Name&nbsp<i id="name-i" class="glyphicon glyphicon-chevron-down"></i></a>

                            <a id="position" href="javascript:void(0);" tabindex="-1">Position&nbsp<i id="position-i" class="glyphicon glyphicon-chevron-down"></i></a>

                            <a id="date" href="javascript:void(0);" tabindex="-1">Date of employment&nbsp<i id="date-i" class="glyphicon glyphicon-chevron-down"></i></a>
                            <a id="salary" href="javascript:void(0);" tabindex="-1">Salary&nbsp<i id="salary-i" class="glyphicon glyphicon-chevron-down"></i></a>

                            <div id="jstree_auth"></div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
