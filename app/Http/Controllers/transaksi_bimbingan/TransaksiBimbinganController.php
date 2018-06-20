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

    //create versi satu
    /*public function create(Request $request){
           
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
            

    }*/

    // create versi 2
    public function create(Request $request){
        // langkah2 membuat rencana
        //1. cek apakah siswa memiliki rencana yang belum di approve?klau
        // masih punya tidak bisa buat baru, mesti terlaksana dulu yang sebelumnya
        //2. apakah guru bk pada jadwal bimbingan yang sama, tgl rencana buat sudah memiliki janji
        // jika sudah memiliki janji maka tidak bisa pada hari itu, di beri notifikasi 
        // bahwa sudah ada jadwal 
        
        /*$XId_Siswa        = $request->IdSiswa;
        $XKode_Jadwal     = $request->KodeJadwal; 
        $XWaktu_Ren_Janji = $request->WaktuRenJanji; 
        $XTopik           = $request->Topik;  
        $Id_Player        = $request->Id_Player;*/

             /*sendObj = new JSONObject("{'IdSiswa':'"+IdSiswa+"'," +
                            "'KodeJadwal':'"+DataJadwalGuruBkGlob.getKode_Jadwal()+"'," +
                            "'Topik':'"+TopikBimbingan.getText()+"','WaktuRenJanji':'"+WaktuRenJanji+"','Id_Player':''}");*/

        try{
            $s_siswa_bimbingan = DB::select("SELECT COUNT(*) AS TotBimbingan_siswa 
                                                FROM t_bimbingans 
                                                WHERE status_realisasi = ''
                                                    AND Id_siswa = :id_siswa",["id_siswa" => $request->IdSiswa]);
            
            $s_guru_bk_bimbingan = DB::select("SELECT COUNT(*) AS TotBimbingan_guru_bk 
                                                FROM t_bimbingans 
                                                WHERE status_realisasi = '' AND tgl_pengajuan = :tgl_pengajuan
                                                    AND Id_Jadwal = :Id_Jadwal ",
                                                ["Id_Jadwal" => $request->KodeJadwal,"tgl_pengajuan"=>$request->WaktuRenJanji]);

            if($s_siswa_bimbingan[0]->TotBimbingan_siswa == 0 &&
                 $s_guru_bk_bimbingan[0]->TotBimbingan_guru_bk  == 0){
                 $id_guru =  DB::select("SELECT id_guru FROM t_distribusi_jadwals WHERE id = :id_jadwal",
                             ['id_jadwal' => $request->KodeJadwal]);
                    // perlu mendapatkan id guru terlbeih dahulu
                $return = DB::insert('INSERT INTO t_bimbingans 
                (created_at, updated_at,id_guru,
                id_siswa,id_jadwal,tgl_pengajuan,tipe,
                topik_bimbingan,status,created_by) 
                values (?, ?,?,?,?,?,?,?,?,?)',
                ['GETDATE()', 'GETDATE()',  $id_guru[0]->id_guru,
                $request->IdSiswa, $request->KodeJadwal,
                $request->WaktuRenJanji,"-",
                $request->Topik,"active",
                $request->IdSiswa]);

                //$result = ($return == 1)? "S":"E";
                if($return == 1){
                    return response()->json(['status' =>  "S",'message' => "Rencana Telah dibuat"]);
                }else{
                    return response()->json(['status' =>  "E",'message' => "Rencana gagal dibuat"]);
                }
     
            }else{
                if($s_siswa_bimbingan[0]->TotBimbingan_siswa > 0){
                    return response()->json(['status' => 'E', 'message' => "siswa telah memiliki jadwal untuk bimbingan sebelumnya !!!"] );
                }
                else{
                    return response()->json(['status' => 'E', 'message' => "guru bk pada tanggal dan jadwal yang di pilih telah memiliki jadwal !!!"] );
                }
              
            }

         
        }
        catch(Exception $e){
            return response()->json(['status' => 'E', 'message' => $e] );
        }
       
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
