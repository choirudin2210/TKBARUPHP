<?php
/**
 * Created by PhpStorm.
 * User: cvgs
 * Date: 9/15/2016
 * Time: 3:33 PM
 */
namespace App\Http\Controllers;

use DateTime;
use Validator;
use Illuminate\Http\Request;

use App\Model\Lookup;
use App\Model\PhoneProvider;

class PhoneProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $phoneProvider = PhoneProvider::paginate(10);
        return view('phone_provider.index')->with('phoneProviderList', $phoneProvider);
    }

    public function show($id)
    {
        $phoneProvider = PhoneProvider::find($id);
        return view('phone_provider.show')->with('phoneProvider', $phoneProvider);
    }

    public function create()
    {
        $statusDDL = Lookup::where('category', '=', 'STATUS')->get()->pluck('description', 'code');

        return view('phone_provider.create', compact('statusDDL'));
    }

    public function store(Request $data)
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255',
            'status' => 'required',
            'remarks' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return redirect(route('db.admin.phone_provider.create'))->withInput()->withErrors($validator);
        } else {

            PhoneProvider::create([
                'name' => $data['name'],
                'short_name' => $data['short_name'],
                'prefix' => $data['prefix'],
                'status' => $data['status'],
                'remarks' => $data['remarks']
            ]);
            return redirect(route('db.admin.phoneProvider'));
        }
    }

    public function edit($id)
    {
        $phoneProvider = PhoneProvider::find($id);

        $statusDDL = Lookup::where('category', '=', 'STATUS')->get()->pluck('description', 'code');

        return view('phone_provider.edit', compact('phoneProvider', 'statusDDL'));
    }

    public function update($id, Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $pp = PhoneProvider::find($id);

        if ($validator->fails()) {
            return redirect(route('db.admin.phone_provider.edit', $pp->hId()))->withInput()->withErrors($validator);
        } else {
            PhoneProvider::find($id)->update($req->all());
            return redirect(route('db.admin.phone_provider'));
        }
    }

    public function delete($id)
    {
        PhoneProvider::find($id)->delete();
        return redirect(route('db.admin.phone_provider'));
    }
}