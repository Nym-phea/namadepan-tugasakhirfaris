<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    
    public function index()
    {
        $data = User::all();

        return view('index', compact('data'));
    }
    
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'email' => $request->email,
            'name' => $request->nama,
            'password' => Hash::make($request->password)
        ];

        User::create($data);

        return redirect()->route('index')->with('success', 'Data stored successfully!');
    }
    
    public function edit(Request $request, $userId)
    {
        $data = User::find($userId);

        return view('edit', compact('data'));
    }
    
    public function update(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'email' => $request->email,
            'name' => $request->nama
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $userId)->update($data);

        return redirect()->route('index')->with('success', 'Data updated successfully!');
    }

    public function delete(Request $request, $userId)
    {
        $data = User::find($userId);

        if ($data) {
            $data->delete();
        }

        return redirect()->route('index');
    }
}
