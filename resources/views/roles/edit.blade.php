@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('roles.index') }}" class="btn btn-primary waves-effect waves-light"><span class="m-r-5"><i class="fa fa-list"></i></span> List</a>
            </div>

            <h4 class="page-title">Edit Role</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-border">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'put', 'role' => 'form']) !!}
                    @include('layouts.partials.errors')
                    <div class="form-group">
                        {!! Form::label('name', 'Name', ['class' => 'control-label', 'for' => 'name']) !!}
                        {!! Form::text('name', $role->name, ['id' => 'name', 'class' => 'form-control']) !!}
                    </div>

                    {!! Form::button('<i class="md md-save"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary waves-effect waves-light']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection