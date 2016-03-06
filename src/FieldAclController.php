<?php

namespace Neposoft\FieldAcl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class FieldAclController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = \Config::get('fieldAcl.classes');
        $roles = \Config::get('fieldAcl.roles');

        $data = ['roles' => $roles];
        $flash = [];

        $perm = new Permission;
        $perm->setTable(\Config::get('fieldAcl.table'));

        $dbpermissions = $perm->all();
        foreach ($classes as $class) {
            $info = [];

            /** @var Model $object */
            $object = new $class();


            $info['fields'] = \Schema::getColumnListing($object->getTable());
            foreach ($roles as $role) {
                $info['hidden'][$role] = FieldAcl::getHiddenFields($class, $role);
                $meta = ['class' => $class, 'role' => $role, 'hidden_fields' => []];

                $dbpermissions->where('role', $role)
                    ->where('model', $class)->each(function ($row) use (&$meta) {
                        $meta['hidden_fields'] = $row->hidden_fields;
                    });

                $flash[] = $meta;
            }
            $data['classes'][$class] = $info;
        }
        \Session::flashInput(['data' => $flash]);
        //  return $data;
        return view('fieldAcl::index', ['data' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::transaction(function () use (&$request) {
            Permission::query()->delete();

            $data = $request->get('data');
            foreach ($data as $d) {
                Permission::create($d)->save();
            }
            //  Permission::saveMany($request->get('data'));
        });
        \Session::flash('acl-status', "Successully updated permissions");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
