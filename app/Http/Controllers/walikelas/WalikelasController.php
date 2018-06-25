<?php
namespace App\Http\Controllers\walikelas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalikelasController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function GetDataSiswaSekelas(Request $request){
        try{

<<<<<<< HEAD
            $DataSiswaSeKelas = DB::select("SELECT
=======
            /*
                Id_Siswa     = ObjectSiswa.getString("Id_Siswa");
                Id_WaliKelas = ObjectSiswa.getString("Id_WaliKelas");
                Nama         = ObjectSiswa.getString("Nama");
                Alamat       = ObjectSiswa.getString("Alamat");
                Path_Foto    = ObjectSiswa.getString("Path_Foto");
                Jenis_Kelamin= ObjectSiswa.getString("Jenis_Kelamin");

            */

   
            /*$DataSiswaSeKelas = DB::select("SELECT
>>>>>>> 423511a7016474366b3163c38ae1135007f53173
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN mstr_siswas ON t_distribusi_kelas.id_siswa = mstr_siswas.id
                                    WHERE
<<<<<<< HEAD
                                        t_distribusi_walikelas.id_guru = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
=======
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
            */
>>>>>>> 423511a7016474366b3163c38ae1135007f53173

            $DataSiswaSeKelas = DB::select("SELECT
                                    mstr_siswas.id AS Id_Siswa,
                                    t_distribusi_walikelas.id AS Id_WaliKelas,
                                    mstr_siswas.nama AS Nama,
                                    mstr_siswas.alamat AS Alamat,
                                    mstr_siswas.path_foto AS Path_Foto,
                                    mstr_siswas.jenis_kelamin AS Jenis_Kelamin
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN mstr_siswas ON t_distribusi_kelas.id_siswa = mstr_siswas.id
                                    WHERE
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]); 
           
           return response()->json(['status' => 'S', 'data' => $DataSiswaSeKelas] );
        }
        catch(Exception $e){
            return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetPelanggaranByIdSiswa(Request $request){
        try{
            $DataPelanggaranSiswa = DB::select("SELECT *
                                        FROM t_pelanggarans 
                                        WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);
            return response()->json(['status' => 'S', 'data' => $DataPelanggaranSiswa] );
        }
        catch(Exception $e){
            return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetDataCharts(Request $request){
<<<<<<< HEAD
        try
        {
=======
        try{
           //$Id_WaliKelas = $request->Id_WaliKelas;
           
            /*$TotalPelanggaranKelasSeminggu = DB::select(' select  count(*) as TotPelanggaranKelasSeminggu from  `t_pelanggaran_siswa` `pel_siswa` join `t_master_siswa` `mas_siswa` where Id_WaliKelas = :Id_WaliKelas  and  date_format(`pel_siswa`.`Created_Time`,"%d-%m-%Y") between  date_format(curdate()- interval 6 day,"%d-%m-%Y") and date_format(curdate(),"%d-%m-%Y") and  `pel_siswa`.Id_Siswa = `mas_siswa`.Id_Siswa' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalPelanggaranKelasSebulan = DB::select('select  count(*) as TotPelanggaranKelasSebulan from  `t_pelanggaran_siswa` `pel_siswa` join `t_master_siswa` `mas_siswa` where Id_WaliKelas = :Id_WaliKelas  and  MONTH(Created_Time) = MONTH(curdate()) and    `pel_siswa`.Id_Siswa = `mas_siswa`.Id_Siswa' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalBimbinganKelasSeminggu = DB::select('Select count(*) as TotBimbinganKelasSeminggu from `t_rel_konseling_bimbingan` `rel` join `t_ren_konseling_bimbingan` `ren` join `t_master_siswa` `mas_siswa`  where  `rel`.`Kode_Ren`  = `ren`.`Kode_Ren` and `ren`.Id_Siswa  =  `mas_siswa`.Id_Siswa and date_format(`Rel_waktu_janji`,"%d-%m-%Y") between  date_format(curdate()- interval 6 day,"%d-%m-%Y") and date_format(curdate(),"%d-%m-%Y") and  `rel`.Rel_Ren_Status = 0 and `mas_siswa`.Id_WaliKelas = :Id_WaliKelas' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalBimbinganKelasSebulan = DB::select('Select count(*) as TotBimbinganKelasSebulan from `t_rel_konseling_bimbingan` `rel` join `t_ren_konseling_bimbingan` `ren` join `t_master_siswa` `mas_siswa`  where  `rel`.`Kode_Ren`  = `ren`.`Kode_Ren` and `ren`.Id_Siswa  =  `mas_siswa`.Id_Siswa and MONTH(Rel_waktu_janji) = MONTH(curdate()) and  `rel`.Rel_Ren_Status = 0 and `mas_siswa`.Id_WaliKelas = :Id_WaliKelas' ,['Id_WaliKelas' => $Id_WaliKelas]);*/

>>>>>>> 423511a7016474366b3163c38ae1135007f53173
            $TotalPelanggaranKelasSeminggu = DB::select(" SELECT
                         count(*) as TotPelanggaranKelasSeminggu
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                    WHERE
                    date_format(t_pelanggarans.created_at,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                    AND  t_distribusi_walikelas.id_guru = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);    
                        
            $TotalPelanggaranKelasSebulan = DB::select(" SELECT
                        count(*) as TotPelanggaranKelasSebulan
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                    WHERE
                    MONTH(t_pelanggarans.created_at) = MONTH(curdate()) AND
                    t_distribusi_walikelas.id_guru = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         


            $TotalBimbinganKelasSeminggu = DB::select(" SELECT                                   
                        count(*) as TotBimbinganKelasSeminggu 
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                    WHERE
                    date_format(t_bimbingans.tgl_realisasi,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                    AND t_distribusi_walikelas.id_guru = :id_distribusi_walikelas 
                    AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]); 

            $TotalBimbinganKelasSebulan = DB::select(" SELECT                                   
                       count(*) as TotBimbinganKelasSebulan
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                    WHERE
                    MONTH(t_bimbingans.tgl_realisasi) = MONTH(curdate()) 
                    AND t_distribusi_walikelas.id_guru = :id_distribusi_walikelas 
                    AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         

            if (!empty($TotalPelanggaranKelasSeminggu)){ // pengecekan pelanggaran seminggu
                $StatusTotalPelanggaranKelasSeminggu = "S";    
                $resultTotalPelanggaranKelasSeminggu =  $TotalPelanggaranKelasSeminggu[0]->TotPelanggaranKelasSeminggu; 
            }  
            else{
                $StatusTotalPelanggaranKelasSeminggu  = "E";
                $resultTotalPelanggaranKelasSeminggu  = 0;
            } 


            if (!empty($TotalPelanggaranKelasSebulan)){ // pengecekan pelanggaran seminggu     
                $StatusTotalPelanggaranKelasSebulan = "S";    
                $resultTotalPelanggaranKelasSebulan =  $TotalPelanggaranKelasSebulan[0]->TotPelanggaranKelasSebulan; 
            }  
            else{

                $StatusTotalPelanggaranKelasSebulan  = "E";
                $resultTotalPelanggaranKelasSebulan  = 0;
            } 


            if (!empty($TotalBimbinganKelasSeminggu)){ // pengecekan pelanggaran seminggu             
                $StatusTotalBimbinganKelasSeminggu = "S";    
                $resultTotalBimbinganKelasSeminggu =  $TotalBimbinganKelasSeminggu[0]->TotBimbinganKelasSeminggu; 
            }  
            else{

                $StatusTotalBimbinganKelasSeminggu  = "E";
                $resultTotalBimbinganKelasSeminggu  = 0;
            } 


            if (!empty($TotalBimbinganKelasSebulan)){ // pengecekan pelanggaran seminggu         
                $StatusTotalBimbinganKelasSebulan = "S";    
                $resultTotalBimbinganKelasSebulan =  $TotalBimbinganKelasSebulan[0]->TotBimbinganKelasSebulan; 
            }  
            else{
                $StatusTotalBimbinganKelasSebulan  = "E";
                $resultTotalBimbinganKelasSebulan  = 0;
            } 

            return response()-> json(['status'=> 'S', 'DataPelanggaranKelasSeminggu' => [$StatusTotalPelanggaranKelasSeminggu,$resultTotalPelanggaranKelasSeminggu],'DataPelanggaranKelasSebulan' => [$StatusTotalPelanggaranKelasSebulan,$resultTotalPelanggaranKelasSebulan], 'DataBimbinganKelasSeminggu' => [$StatusTotalBimbinganKelasSeminggu,$resultTotalBimbinganKelasSeminggu],'DataBimbinganKelasSebulan' => [$StatusTotalBimbinganKelasSebulan,$resultTotalBimbinganKelasSebulan]]);
        }
        catch(Exception $e){
            return response()-> json(['status' => 'E', 'message' => $e]);
        }
    }

    public function GetActivitySiswaById(Request $request){
    
        try{
            
            $GetAllPelanggaranByIdSiswa = DB::select("SELECT  id AS Id_Pelanggaran,
                                                        id_siswa AS Id_Siswa,
                                                        keterangan_pelanggaran AS Tindakan_Pelanggaran,
                                                        keterangan_pendisiplinan AS Tindakan_Pendisiplinan, 
                                                        created_at AS Created_Time,
                                                        updated_at AS Updated_Time,
                                                        created_by AS Created_By,
                                                        created_by AS Updated_By
                                                    FROM t_pelanggarans 
                                                    WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);

            $GetAllBimbinganByIdSiswa = DB::select("SELECT id AS Kode_Ren,
                                                    id AS Kode_Rel,
                                                    status_approval AS Rel_Acc_Status,
                                                    tgl_pengajuan AS Rel_waktu_janji,
                                                    topik_bimbingan AS Topik, 
                                                    tgl_approval AS Rel_Acc_Time , 
                                                    status_realisasi AS Rel_Ren_Status,
                                                    topik_bimbingan AS Topik          
                                                FROM t_bimbingans 
                                                WHERE status_realisasi = '1'
                                                    AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);     

            /*$GetAllPelanggaranByIdSiswa = DB::select("SELECT *
                                            FROM t_pelanggarans 
                                            WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);*/

            /*$GetAllBimbinganByIdSiswa = DB::select("SELECT *
                            FROM t_bimbingans 
                            WHERE status_realisasi = '1'
                                AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);*/     

            if (!empty($GetAllPelanggaranByIdSiswa)) {
                $StatusPelanggaran = "S";
            }
            else{
                $StatusPelanggaran = "E";
            }
            
            if (!empty($GetAllBimbinganByIdSiswa)) {
                $StatusBimbingan = "S";
            }
            else{
               $StatusBimbingan = "E";
            }
            
            return response()-> json(['status' => 'S', 'Pelanggaran' => [$StatusPelanggaran,$GetAllPelanggaranByIdSiswa],'Bimbingan' => [$StatusBimbingan,$GetAllBimbinganByIdSiswa]]);
    
        }
        catch(Exception $e)
        {   
             return response()-> json(['status' => 'E', 'message' => $e]);        
        }
    }

    public function GetHistoryKelas(Request $request){
        try{
           /*
            untuk pelanggaran 
            NamaSiswa = ObjectHistoryPelanggaran.getString("Nama");
            Keterangan  = ObjectHistoryPelanggaran.getString("Tindakan_Pelanggaran");
            WaktuKejadian  = ObjectHistoryPelanggaran.getString("Created_Time");

           */

           /* 
           untuk bimbingan 
            NamaSiswa = ObjectHistoryBimbingan.getString("Nama");
            Keterangan  = ObjectHistoryBimbingan.getString("Topik");
            WaktuKejadian  = ObjectHistoryBimbingan.getString("Rel_Acc_Time");

           */



            $GetAllPelanggaran = DB::select("SELECT
                                    mstr_siswas.nama AS Nama,
                                    t_pelanggarans.keterangan_pelanggaran AS Tindakan_Pelanggaran,
                                    t_pelanggarans.tanggal_kejadian AS Created_Time
                                FROM
                                    t_distribusi_walikelas
                                LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa
                                LEFT JOIN mstr_siswas ON t_pelanggarans.id_siswa = mstr_siswas.id
                                WHERE
                                    t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
            
            $GetAllBimbingan = DB::select("SELECT
                                mstr_siswas.nama AS Nama,
                                t_bimbingans.topik_bimbingan AS Topik,
                                t_bimbingans.tgl_realisasi AS Rel_Acc_Time
                            FROM
                            t_distribusi_walikelas
                            LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                            LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                            LEFT JOIN mstr_siswas ON t_bimbingans.id_siswa = mstr_siswas.id
                            WHERE
                            t_distribusi_walikelas.id = :id_distribusi_walikelas
                            AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         


        

            /*$GetAllPelanggaran = DB::select(" SELECT
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                                    LEFT JOIN mstr_siswas ON t_pelanggarans.id_siswa = mstr_siswas.id
                                    WHERE
<<<<<<< HEAD
                                        t_distribusi_walikelas.id_guru = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
           
            $GetAllBimbingan = DB::select(" SELECT                                   
=======
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
            */
            /*$GetAllBimbingan = DB::select(" SELECT                                   
>>>>>>> 423511a7016474366b3163c38ae1135007f53173
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                                    LEFT JOIN mstr_siswas ON t_bimbingans.id_siswa = mstr_siswas.id
                                    WHERE
                                        t_distribusi_walikelas.id_guru = :id_distribusi_walikelas 
                                        AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
            */
            return response()-> json(['status' => 'S', 'HistoryPelanggaran' => $GetAllPelanggaran,
             'HistoryBimbingan' => $GetAllBimbingan]);
        }
        catch(Exception $e){
             return response()-> json(['status' => 'E', 'message' => $e]);        
        }
    }
   
}    
              