<html>
<head>
    <title>Neposoft Field Acl : Laravel</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="">
    <h1>Manage permissions</h1>
    <form id="fieldAclForm" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                    @foreach($cdata['fields'] as $fidx=> $field)
                                        <td>
                                            <input type="hidden" name="{{ 'data['.$rowIdx.'][model]' }}"
                                                   value="{{$class}}">
                                            <input type="hidden" name="{{ 'data['.$rowIdx.'][role]' }}"
                                                   value="{{$role}}">
                                            <?php $isfound = false;
                                            $arr = old("data.$rowIdx.hidden_fields", []);
                                            if ($arr)
                                                foreach ($arr as $v) {
                                                    if ($v == $field) {
                                                        $isfound = true;
                                                        continue;
                                                    }
                                                }
                                            ?>
                                            <input type="checkbox" name="{{ 'data['.$rowIdx.'][hidden_fields][]' }}"
                                                   value="{{$field}}" @if($isfound) checked @endif>
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
    </form>
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
</body>
</html>