@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3 panel panel-info">

                <div class="panel-body">
                    <img src="http://placehold.it/150x150" alt="" class="img-responsive center-block" />
                </div>
                <div class="panel-footer">
                    <h3>Создать нового сотрудника:</h3>

                    <form  action="/create" method="POST">
                        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="ФИО" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        {{ csrf_field() }}

                        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Пароль">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="name" type="text" class="form-control" name="position" value="{{ old('position') }}" placeholder="Дожность">

                            @if ($errors->has('position'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('date_of_employment') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="name" type="date" class="form-control" name="date_of_employment" value="{{ old('date_of_employment') }}" placeholder="Дата принятия на работу">

                            @if ($errors->has('date_of_employment'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('date_of_employment') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('salary') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            <input id="name" type="text" class="form-control" name="salary" value="{{ old('salary') }}" placeholder="Зарплата">

                            @if ($errors->has('salary'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('salary') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('hierarchy_level') ? ' has-error' : '' }}">
                            <label for="hierarchy" class="input-group">Выберите уровень иерархии для данного сотрудника:</label>
                            <select id="hierarchy" class="form-control" name="hierarchy_level">

                            </select>

                        @if ($errors->has('hierarchy_level'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('hierarchy_level') }}</strong>
                                    </span>
                        @endif


                        </div>

                        <div class="input-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                            <label for="chiefs" class="input-group">Выберите начальника для данного сотрудника:</label>
                            <select id="chiefs" class="form-control" name="parent_id">

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

                </div>

            </div>

        </div>

    </div>

    <script>

        window.chiefsPerLevel = '{!! $chiefsPerLevel !!}';

    </script>

@endsection