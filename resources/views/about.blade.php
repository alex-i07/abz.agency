@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 panel panel-info">

                {{--<div class="panel-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">--}}
                            {{--<div class="panel panel-default my_panel">--}}
                                <div class="panel-body">
                                    <img src="http://placehold.it/150x150" alt="" class="img-responsive center-block" />
                                </div>
                                <div class="panel-footer">
                                    <h3>Информация о сотруднике:</h3>

                                    <form  action="/about" method="POST">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <input id="name" type="text" class="form-control" name="name" value="{{$employee->name}}">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <input id="name" type="text" class="form-control" name="email" value="{{$employee->email}}">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <input id="name" type="text" class="form-control" name="position" value="{{$employee->position}}">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <input id="name" type="text" class="form-control" name="date_of_employment" value="{{$employee->date_of_employment}}">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <input id="name" type="text" class="form-control" name="salary" value="{{$employee->salary}}">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            {{--<label for="name">ФИО:</label>--}}
                                            <select id="name" class="form-control" name="chief">
                                                @foreach($chiefs as $value)
                                                    @if ($value === $chief)
                                                        <option selected>{{$value}}</option>
                                                    @else
                                                        <option>{{$value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary">Primary</button>
                                        </div>

                                    </form>

                                </div>
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>

        </div>

    </div>

@endsection