@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Manage permissions</h1>
        {!! Form::open(['id'=>'fieldAclForm']) !!}
        <table class="table table-bordered">
            <tr>
                <th>Permissions
                    <span class="btn btn-info btn-sm" onclick="toggleCheckbox()">Toggle checkbox</span>
                    <span class="btn btn-info btn-sm" onclick="checkAll()">Check All</span>
                    <span class="btn btn-info btn-sm" onclick="unCheckAll()">Uncheck All</span>
                </th>
            </tr>
            <?php $rowIdx = 0; ?>
            @foreach($data['classes'] as $class=>$cdata)
                <tr>
                    <td>Model: <strong>{{$class}}</strong><br>
                        Type: <strong>HiddenFields (select the fields that need to be hidden)</strong>
                        <table class="table table-condensed table-bordered">
                            <tr>
                                <th>Role</th>
                                @foreach($cdata['fields'] as $field)
                                    <td>{{$field}}</td>
                                @endforeach
                            </tr>
                            @foreach($data['roles'] as $role)

                                <tr>
                                    <td>{{$role}}</td>
                                    @foreach($cdata['fields'] as $field)
                                        {!! Form::input('hidden','data['.$rowIdx.'][model]',$class) !!}
                                        {!! Form::input('hidden','data['.$rowIdx.'][role]',$role) !!}
                                        <td>{!! Form::checkbox('data['.$rowIdx.'][hidden_fields][]',$field,old('data['.$rowIdx.'][hidden_fields]['.$field.']') !=null) !!}</td>
                                    @endforeach
                                    <?php $rowIdx++ ?>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td><input type="submit" class="btn btn-success btn-lg" value="Save Permissions"></td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    <script>
        var toggleCheckbox = function () {
            $("#fieldAclForm").find('input[type=checkbox]').each(function (idx, e) {
                var elem = $(e);
                elem.prop('checked', !elem.prop('checked'));
            });
        }
        var checkAll = function () {
            $("#fieldAclForm").find('input[type=checkbox]').prop('checked', true);
        }
        var unCheckAll = function () {
            $("#fieldAclForm").find('input[type=checkbox]').prop('checked', false);
        }
    </script>
@stop