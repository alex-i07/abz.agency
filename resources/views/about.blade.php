@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 panel panel-info">

                <div class="panel-body">
                    <img src="http://placehold.it/150x150" alt="" class="img-responsive center-block" />
                </div>
                <div class="panel-footer">
                    <h3>Информация о сотруднике:</h3>

                    <form  action="/about/save" method="POST">
                        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="name" type="text" class="form-control" name="name" value="{{$employee->name}}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        {{ csrf_field() }}

                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="email" type="email" class="form-control" name="email" value="{{$employee->email}}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="position" type="text" class="form-control" name="position" value="{{$employee->position}}">

                            @if ($errors->has('position'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('date_of_employment') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="date_of_employment" type="text" class="form-control" name="date_of_employment" value="{{$employee->date_of_employment}}">

                            @if ($errors->has('date_of_employment'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('date_of_employment') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('salary') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="salary" type="text" class="form-control" name="salary" value="{{$employee->salary}}">

                            @if ($errors->has('salary'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('salary') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <select id="name" class="form-control" name="parent_id">
                                @foreach(unserialize($chiefs) as $chief)
                                    @if ($employee->parent_id == $chief['id'])
                                        <option value="{{$chief['id']}}" selected>{{$chief['name']}}</option>
                                    @else
                                        <option value="{{$chief['id']}}">{{$chief['name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('parent_id'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="glyphicon glyphicon-send"></i>
                                <span>Отправить</span>
                            </button>
                        </div>

                    </form>

                    <div class="input-group">
                        <button type="button" id="remove-employee" class="btn btn-danger">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Удалить</span>
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection