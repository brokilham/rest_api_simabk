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

    /*public function DataTimeLine(Request $request){
        
        // Masih dari api yang lama 
         
        // pengajuan di ajukan kapan
        // disetujui atau di tolak atau kadaluarsa kapan
        // status akhir, datang, tidak datang, guru bk tidak menemui

        // alur 
        // jika status ren adalah o, maka langsung ditampilan, sbagai rencana belum di setujui
        // jika status ren tidak 0, tgl approval atau kdaluarsa ditampilkan, maka langusng encari di tabel realisasi, untuk mendapatkan status akhir

        // kotak 1: rencana di ajukan tgl 11
        // kotak 2: recana telah di setujui atau tolak atau kadaluarsa tgl xxxx
        // kotak 3: status realisasi adalah xxxx, pada tgl xxxxx
        try
        {
            $Id_Siswa = $request->Id_Siswa;

            $PengajuanRencana =  DB::select('Select * from t_ren_konseling_bimbingan where  Id_Siswa = :Id_Siswa order by Waktu_Ren_Buat desc limit 1' ,['Id_Siswa' => $Id_Siswa]);
           
            
            if (!empty($PengajuanRencana)) // jika seorang siswa memiliki pengajuan bimbingan
            {
                 // jika 0 maka pengajuan rencana belum di setujui dan alur method berakhir disini
                $TglPengajuanBuat = $PengajuanRencana[0]->Waktu_Ren_Buat;
                $TopikBimbingan = $PengajuanRencana[0]->Topik;
                $StatusRencana = $PengajuanRencana[0]->Status_Ren;
                $KodeRencana = $PengajuanRencana[0]->Kode_Ren;
                $WaktuRencanaBimbingan = $PengajuanRencana[0]->Waktu_Ren_Janji;
                // 0 rencana belum di setujui
                // 1 rencana disetujui
                // 2 rencanan kadauarsa
                // 3 rencana ditolak
                // 4 kegiatan langsung

                if($StatusRencana != 0) // saat rencana // disetujui // ditolak // kadaluarsa
                {
                      $DetailRealisasi =  DB::select('Select * from t_rel_konseling_bimbingan where  Kode_Ren =  :Kode_Ren' ,['Kode_Ren' => $KodeRencana]);   

                      $WaktuResponRencana =    $DetailRealisasi[0]->Rel_Acc_Time;
                      $StatusRealisasi    =    $DetailRealisasi[0]->Rel_Ren_Status;
                      $KodeRealisasi      =    $DetailRealisasi[0]->Kode_Rel;

                


                }
                else // ketika rencana belum di setujui
                {
                    $WaktuResponRencana = 'null';
                    $StatusRealisasi = 'null';
                    $KodeRealisasi =   'null';

                }


            }
            else // jika siswa tidak memiliki rencana bimbingan
            {
                $TglPengajuanBuat   = 'null';
                $TopikBimbingan     = 'null';
                $StatusRencana      = 'null';
                $KodeRencana        = 'null';
                $WaktuResponRencana = 'null';
                $StatusRealisasi    = 'null';
                $WaktuRencanaBimbingan = 'null';
                $KodeRealisasi =   'null';
            }
           

          
            //yang akan dikembalikan
            // status sukses
            
            //rencana
            // tgl pengajuan rencana
            // topik bimbingan dan konseling

            // tgl tindak lanjut bisa ditolak, disetujui, kadaluarsa
            //  status tindak lanjut

            //tgl realisasi kegiatan
            // status realisasi kegiatan
            return response()->json(['status' => 'S','TglPengajuanBuat' => $TglPengajuanBuat,'TopikBimbingan' => $TopikBimbingan,'StatusRencana' => $StatusRencana,'KodeRencana' => $KodeRencana,'WaktuResponRencana'=>$WaktuResponRencana,'StatusRealisasi'=>$StatusRealisasi,'WaktuRencanaBimbingan'=>$WaktuRencanaBimbingan,'KodeRealisasi'=>$KodeRealisasi]);
        }
        catch(Exception $e)
        {
             return response()->json(['status' => 'E', 'message' => $e] );

        }

     }*/
        
    

    public function GetAllGuruBk(Request $request){     
        try{
            $GuruBk = DB::select(" SELECT 
                                        id_guru AS Id_Guru,
                                        m_guru.nama AS Nama,
                                        m_guru.alamat AS Alamat,
                                        m_guru.no_telp AS No_telp,
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
                                        d_jadwal.id_jadwal AS Kode_Jadwal,
                                        d_jadwal.id_guru AS Id_GuruBk,
                                        m_jadwal.hari AS Hari,
                                        m_jam.jam_mulai AS Jam_Mulai,
                                        m_jam.jam_selesai AS Jam_Selesai
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
}