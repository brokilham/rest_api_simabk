<?php

namespace App\Http\Controllers\transaksi_bimbingan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class TransaksiBimbinganController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request){
      
       
        //http://localhost/rest_api_simabk/public/transaksi_bimbingan/create?param_id_guru=tes&param_id_siswa=tes1&param_id_jadwal=tes2&param_tipe=tes3&param_topik_bimbingan=tes4&param_status=tes5&param_created_by=tes6

       $return = DB::insert('INSERT INTO t_bimbingans 
                    (created_at, updated_at,id_guru,
                    id_siswa,id_jadwal,tgl_pengajuan,tipe,
                    topik_bimbingan,status,created_by) 
                    values (?, ?,?,?,?,?,?,?,?,?)',
                     ['GETDATE()', 'GETDATE()', $request->param_id_guru,
                     $request->param_id_siswa, $request->param_id_jadwal,
                     'GETDATE()',$request->param_tipe,
                     $request->param_topik_bimbingan,$request->param_status,
                     $request->param_created_by]);

        $result = ($return == 1)? "S":"E";
        return response()->json(['status' =>  $result]);
            

    }

    /*public function create(){

        DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
        $affected = DB::update('update users set votes = 100 where name = ?', ['John']);
        $deleted = DB::delete('delete from users');
        $results = DB::select("SELECT * FROM mstr_siswas");  
        if(count($GuruBk) > 0)
         {
            $Status = "S";
         }
         else
         {

            $Status = "E";
         }

        return response()->json(['status' =>  "tes", 'DataGuruBk' => $results]);  
    }*/
}
