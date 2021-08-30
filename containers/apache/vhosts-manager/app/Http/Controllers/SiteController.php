<?php

namespace App\Http\Controllers;

use App\Rules\ExistHost;
use App\Rules\ExistDB;
use App\Rules\UseDBRequired;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Utility;

class SiteController extends Controller
{
    public function create()
    {
        $hosts = Utility::loadVhosts();
        return view('addtop')->with([
            'hosts' => $hosts,
            'current' => 'add',
            'execute_result_type' => @$_REQUEST['er_type'],
            'execute_result_status' => @$_REQUEST['state'],
            'execute_result_domain' => @$_REQUEST['d'],
        ]);
    }

    public function addStore(Request $request)
    {
        $rules = [
            'domain_name' => ['required', 'max:255', new ExistHost()],
            'db_name' => [new UseDBRequired(),new ExistDB()],
        ];

        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return redirect('/')
                        ->withErrors($validated)
                        ->withInput();
        }
        Utility::createVhost($_REQUEST['domain_name'], @$_REQUEST['use_wp'], @$_REQUEST['db_name']);
        return redirect('/?er_type=add&state=1&d='.urlencode($_REQUEST['domain_name']));
    }

    public function delete(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'domain_name' => 'required|max:255',
        ]);
        if ($validated->fails()) {
            return redirect('/');
        }

        $targetHost = Utility::getHostInfo($_REQUEST['domain_name']);
        if (count($targetHost) == 0) {
            return redirect('/');
        }

        return view('deltop')->with([
            'current' => 'delete',
            'targetHost' => $targetHost,
            'domain_name' => @$_REQUEST['domain_name'],
        ]);
    }

    public function deleteExec(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'domain_name' => 'required|max:255',
        ]);
        if ($validated->fails()) {
            return redirect('/');
        }

        $targetHost = Utility::getHostInfo($_REQUEST['domain_name']);
        if (count($targetHost) == 0) {
            return redirect('/');
        }
        Utility::deleteVhost($_REQUEST['domain_name']);
        return redirect('/');
    }
}
