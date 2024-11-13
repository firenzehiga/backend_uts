<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    public function index(){

        $employees = Employee::all(); #menggunakan eloquent

        if($employees->count() > 0){
            $data = [
                'message' => 'Get All Resources',
                'data' => $employees,
            ];
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Data is Empty',
            ];
            return response()->json($data, 200);
        }
    }
    public function store(Request $request)
    {
    
        #cara lain validasi dengan menggunakan method Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[\p{L} ]+$/u|max:255',
            'gender' => 'required|string|alpha|max:1',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email|max:255',
            'status' => 'required|string|max:255',
            'hired_on' => 'required|date',
           
        ]);


        if($validator->fails()){
            return response()->json([   
                'message' => 'validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        #menggunakan model Student untuk tambah data
        $employees = Employee::create($request->all());

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $employees,
        ];

        #mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }
    public function show($id, ){
        $employees = Employee::find($id);

        if($employees){
            $data = [
                'message' => ' Get Detail Resource',
                'data' => $employees,
            ];
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
            ];
            return response()->json($data, 404);
        }
    }
    public function update(Request $request, $id)
    {
        # mencari id Pegawai
        $employees = Employee::find($id);
    
        # cek apakah pegawai(berdasarkan idnya() ditemukan
        if (!$employees) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
    
        # Cara lain validasi dengan menggunakan method Validator
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|regex:/^[\p{L} ]+$/u|max:255',
            'gender' => 'sometimes|string|alpha|max:1',
            'phone' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:employees,email,' . $employees->id,
            'status' => 'sometimes|string|max:255',
            'hired_on' => 'sometimes|date',
        ]);
    
        # cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        # update data jika validasi berhasil
        $employees->update($validator->validated());
    
        #mengembalikan data (json) dan kode 200
        return response()->json([
            'message' => 'Resource is updated successfully',
            'data' => $employees,
        ], 200);
    }
    public function delete($id){
        $employees = Employee::find($id);
        
        if($employees){
            $employees->delete();
            $data = [
                'message' => 'Resource is delete successfully',
            ];
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Resource not found',
            ];
            return response()->json($data, 404);
        }
    }
    public function searchByName(Request $request)
    {
        // mendapatkan input nama dari request
        $name = $request->query('name');

        // kondisi untuk jika input nama kosong
        if (empty($name)) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }
        
        // menggunakan eloquent where dan get utuk mencari data dengan nama
        $employees = Employee::where('name', 'LIKE', '%' . $name . '%')->get();
        
        // mengecek apakah data yang dicari ditemukan
        if ($employees->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        } else {
            return response()->json([
                'message' => 'Get searched resource',
                'data' => $employees,
            ], 200);
        }
    }
    
    public function getActive()
    {
        $activeEmployees = Employee::where('status', 'active')->get(); // Sesuaikan field status

        // mengecek apakah data pegawai aktif ditemukan
        return response()->json([
            'message' => 'Get active resource',
            'total' => $activeEmployees->count(),
            'data' => $activeEmployees,
        ], 200);
    }

    public function getInActive()
    {
        $activeEmployees = Employee::where('status', 'inactive')->get(); // Sesuaikan field status

        // mengecek apakah data pegawai aktif ditemukan
        return response()->json([
            'message' => 'Get active resource',
            'total' => $activeEmployees->count(),
            'data' => $activeEmployees,
        ], 200);
    }

    public function getTerminated()
    {
        $activeEmployees = Employee::where('status', 'terminated')->get(); // Sesuaikan field status

        // mengecek apakah data pegawai aktif ditemukan
        return response()->json([
            'message' => 'Get active resource',
            'total' => $activeEmployees->count(),
            'data' => $activeEmployees,
        ], 200);
    }
    
    

}
