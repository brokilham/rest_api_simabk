<?php


namespace App\Http\Controllers\siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function index(Request $request){
       
        try
        {
           $pelanggaran = DB::select("SELECT COUNT(*) AS TotPelanggaran 
                        FROM t_pelanggarans 
                        WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);

            $StatusTotalPelanggaran = ($pelanggaran == TRUE)?"S":"E";            

            $bimbingan = DB::select("SELECT COUNT(*) AS TotBimbingan 
                        FROM t_bimbingans 
                        WHERE status_realisasi = '1'
                            AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);

            $StatusTotalBimbingan = ($bimbingan == TRUE)?"S":"E";

            return response()->json(['TotalPelanggaran' => [$StatusTotalPelanggaran,$pelanggaran[0]->TotPelanggaran], 'TotalBimbingan' => [$StatusTotalBimbingan, $bimbingan[0]->TotBimbingan]]);        
        }
        catch(Exception $e){
             return response()->json(['status' => 'E', 'message' => $e] );

        }
    }

    public function GetAllPelanggaran(Request $request){

        try{
           
            /*$pelanggaran = DB::select("SELECT *  
                                FROM t_pelanggarans 
                                WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);*/

            $pelanggaran = DB::select("SELECT id AS Id_Pelanggaran,
                                        id_siswa AS Id_Siswa,
                                        keterangan_pelanggaran AS Tindakan_Pelanggaran,
                                        keterangan_pendisiplinan AS Tindakan_Pendisiplinan, 
                                        created_at AS Created_Time,
                                        updated_at AS Updated_Time,
                                        created_by AS Created_By,
                                        created_by AS Updated_By
                                FROM t_pelanggarans 
                                WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);

            
            $StatusPelanggaran = ($pelanggaran == TRUE)?"S":"E";
            return response()->json(['status' => $StatusPelanggaran,'data' => $pelanggaran]);
        }
        catch(Exception $e){
             return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetAllBimbingan(Request $request){           
       
        try{
          
            /*$bimbingan = DB::select("SELECT * 
                            FROM t_bimbingans 
                            WHERE status_realisasi = '1'
                                AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);*/  
            $bimbingan = DB::select("SELECT id AS Kode_Ren,
                            id AS Kode_Rel,
                            status_approval AS Rel_Acc_Status,
                            tgl_pengajuan AS Rel_waktu_janji,
                            topik_bimbingan AS Topik, 
                            tgl_approval AS Rel_Acc_Time , 
                            status_realisasi AS Rel_Ren_Status
                            FROM t_bimbingans 
                            WHERE status_realisasi = '1'
                                AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);         
            
                                $StatusBImbingan = ($bimbingan == TRUE)?"S":"E";
            return response()->json(['status' => $StatusBImbingan,'data' => $bimbingan]);
        }
        catch(Exception $e){
                return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetDataTimeLine(Request $request){
        try{
                 $PengajuanRencana = DB::select("SELECT * 
                                FROM t_bimbingans 
                                WHERE status_realisasi = ''
                                    AND Id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);
                 // jika siswa memiliki rencana bimbingan   
                 if (!empty($PengajuanRencana)){
                    $TglPengajuanBuat = $PengajuanRencana[0]->created_at;
                    $TopikBimbingan = $PengajuanRencana[0]->topik_bimbingan;
                    $StatusRencana = $PengajuanRencana[0]->status_approval;
                    $KodeRencana = $PengajuanRencana[0]->id;
                    $WaktuRencanaBimbingan = $PengajuanRencana[0]->tgl_pengajuan;


                    if($StatusRencana != ""){ // saat rencana // disetujui // ditolak // kadaluarsa                    
                          $WaktuResponRencana =    $PengajuanRencana[0]->tgl_approval;
                          $StatusRealisasi    =    $PengajuanRencana[0]->status_realisasi;
                          $KodeRealisasi      =    $PengajuanRencana[0]->id; 
                    }
                    else{ // ketika rencana belum di setujui
                    
                        $WaktuResponRencana = 'null';
                        $StatusRealisasi = 'null';
                        $KodeRealisasi =   'null';  
                    }
                 }
                 else{ // jika siswa tidk memiliki rencana bimbingan 

                    $TglPengajuanBuat   = 'null';
                    $TopikBimbingan     = 'null';
                    $StatusRencana      = 'null';
                    $KodeRencana        = 'null';
                    $WaktuResponRencana = 'null';
                    $StatusRealisasi    = 'null';
                    $WaktuRencanaBimbingan = 'null';
                    $KodeRealisasi =   'null';
                 }

                 return response()->json(['status' => 'S','TglPengajuanBuat' => $TglPengajuanBuat,'TopikBimbingan' => $TopikBimbingan,'StatusRencana' => $StatusRencana,'KodeRencana' => $KodeRencana,'WaktuResponRencana'=>$WaktuResponRencana,'StatusRealisasi'=>$StatusRealisasi,'WaktuRencanaBimbingan'=>$WaktuRencanaBimbingan,'KodeRealisasi'=>$KodeRealisasi]);
        
        }
        catch(Exception $e)
        {
             return response()->json(['status' => 'E', 'message' => $e] );

        }

    }

    public function GetAllGuruBk(Request $request){  
  
        try{
            $GuruBk = DB::select(" SELECT 
                                        id_guru AS Id_GuruBK,
                                        m_guru.nama AS Nama,
                                        m_guru.alamat AS Alamat,
                                        m_guru.no_telp AS No_Telp,
                                        m_guru.email 
                                    FROM
                                        t_distribusi_jabatans AS jabatan
                                    LEFT JOIN
                                        mstr_gurus AS m_guru ON jabatan.id_guru = m_guru.id
                                    WHERE
                                        id_jabatan = :id_jabatan
                                            AND jabatan.status = :status ",["id_jabatan" => '5', "status"=>'active']);

            $Status = (count($GuruBk) > 0)?"S":"E";

            return response()->json(['status' =>  $Status, 'DataGuruBk' => $GuruBk]);
        }
        catch(Exception $e){
             return response()->json(['status' => 'E', 'DataGuruBk' => $e] );
        }
       
    
    }

    public function GetJadwalBimbingan(Request $request){
        try{
  
            $DataJadwalGuruBK = DB::select("SELECT 
                                        d_jadwal.id AS Id_Distribusi_Jadwal,         
                                        d_jadwal.id_jadwal AS Kode_Jadwal,
                                        d_jadwal.id_guru AS Id_GuruBK,
                                        m_jadwal.hari AS Hari,
                                        m_jam.jam_mulai AS JamMulai,
                                        m_jam.jam_selesai AS JamSelesai
                                    FROM
                                        t_distribusi_jadwals AS d_jadwal
                                    LEFT JOIN
                                        mstr_jadwals AS m_jadwal ON d_jadwal.id_jadwal = m_jadwal.id
                                    LEFT JOIN
                                        mstr_jams AS m_jam ON m_jadwal.jam = m_jam.id
                                    WHERE
                                        d_jadwal.status = :status
                                            AND d_jadwal.id_guru = :id_guru ",["id_guru" =>  $request->IdGuruBk, "status"=>'active']);
    
            
             if(count($DataJadwalGuruBK) > 0){
                $Status = "S";
                $ResultData = $DataJadwalGuruBK;
             }
             else{
                $Status = "E";
                $ResultData = "Tidak ditemukan data jadwal bimbingan yang tersedia!!!";
             }

            return response()->json(['status' =>  $Status, 'DataJadwalGuruBk' =>  $ResultData]);
        }
        catch(Exception $e){
            return response()->json(['status' => 'E', 'DataJadwalGuruBk' => $e] );
        }
    }

    public function CreateBimbingan(Request $request){
        // langkah2 membuat rencana
        //1. cek apakah siswa memiliki rencana yang belum di approve?klau
        // masih punya tidak bisa buat baru, mesti terlaksana dulu yang sebelumnya
        //2. apakah guru bk pada jadwal bimbingan yang sama, tgl rencana buat sudah memiliki janji
        // jika sudah memiliki janji maka tidak bisa pada hari itu, di beri notifikasi 
        // bahwa sudah ada jadwal 
        
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

                        
                $return_id_guru =  DB::select("SELECT id_guru FROM t_distribusi_jadwals WHERE id = :id",
                                ['id' => $request->Id_Distribusi_Jadwal]);
  
                if(count($return_id_guru)>0){
                     // perlu mendapatkan id guru terlbeih dahulu
                    $return = DB::insert('INSERT INTO t_bimbingans 
                    (created_at, updated_at,id_guru,
                    id_siswa,id_jadwal,tgl_pengajuan,tipe,
                    topik_bimbingan,status,created_by) 
                    values (?, ?,?,?,?,?,?,?,?,?)',
                    ['GETDATE()', 'GETDATE()',  $return_id_guru[0]->id_guru,
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
                    return response()->json(['status' => 'E', 'message' => "ID guru dari kode jadwal ".$request->Id_Distribusi_Jadwal." tidak ditemukan"] );
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
}    
              