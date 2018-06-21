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

            $Id_WaliKelas = $request->Id_WaliKelas;

            $DataSiswaSeKelas = DB::select("SELECT
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN mstr_siswas ON t_distribusi_kelas.id_siswa = mstr_siswas.id
                                    WHERE
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         

            return response()->json(['status' => 'S', 'data' => $DataSiswaSeKelas] );
        }
        catch(Exception $e)
        {
            return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetPelanggaranByIdSiswa(Request $request){
        try
        {
            $DataPelanggaranSiswa = DB::select("SELECT *
                                        FROM t_pelanggarans 
                                        WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);
            return response()->json(['status' => 'S', 'data' => $DataPelanggaranSiswa] );
        }
        catch(Exception $e)
        {
            return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

    public function GetDataCharts(Request $request){
        try
        {
           //$Id_WaliKelas = $request->Id_WaliKelas;
           
            /*$TotalPelanggaranKelasSeminggu = DB::select(' select  count(*) as TotPelanggaranKelasSeminggu from  `t_pelanggaran_siswa` `pel_siswa` join `t_master_siswa` `mas_siswa` where Id_WaliKelas = :Id_WaliKelas  and  date_format(`pel_siswa`.`Created_Time`,"%d-%m-%Y") between  date_format(curdate()- interval 6 day,"%d-%m-%Y") and date_format(curdate(),"%d-%m-%Y") and  `pel_siswa`.Id_Siswa = `mas_siswa`.Id_Siswa' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalPelanggaranKelasSebulan = DB::select('select  count(*) as TotPelanggaranKelasSebulan from  `t_pelanggaran_siswa` `pel_siswa` join `t_master_siswa` `mas_siswa` where Id_WaliKelas = :Id_WaliKelas  and  MONTH(Created_Time) = MONTH(curdate()) and    `pel_siswa`.Id_Siswa = `mas_siswa`.Id_Siswa' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalBimbinganKelasSeminggu = DB::select('Select count(*) as TotBimbinganKelasSeminggu from `t_rel_konseling_bimbingan` `rel` join `t_ren_konseling_bimbingan` `ren` join `t_master_siswa` `mas_siswa`  where  `rel`.`Kode_Ren`  = `ren`.`Kode_Ren` and `ren`.Id_Siswa  =  `mas_siswa`.Id_Siswa and date_format(`Rel_waktu_janji`,"%d-%m-%Y") between  date_format(curdate()- interval 6 day,"%d-%m-%Y") and date_format(curdate(),"%d-%m-%Y") and  `rel`.Rel_Ren_Status = 0 and `mas_siswa`.Id_WaliKelas = :Id_WaliKelas' ,['Id_WaliKelas' => $Id_WaliKelas]);

            $TotalBimbinganKelasSebulan = DB::select('Select count(*) as TotBimbinganKelasSebulan from `t_rel_konseling_bimbingan` `rel` join `t_ren_konseling_bimbingan` `ren` join `t_master_siswa` `mas_siswa`  where  `rel`.`Kode_Ren`  = `ren`.`Kode_Ren` and `ren`.Id_Siswa  =  `mas_siswa`.Id_Siswa and MONTH(Rel_waktu_janji) = MONTH(curdate()) and  `rel`.Rel_Ren_Status = 0 and `mas_siswa`.Id_WaliKelas = :Id_WaliKelas' ,['Id_WaliKelas' => $Id_WaliKelas]);*/

            $TotalPelanggaranKelasSeminggu = DB::select(" SELECT
                         count(*) as TotPelanggaranKelasSeminggu
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                    WHERE
                    date_format(t_pelanggarans.created_at,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                    AND  t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);    
                        
            $TotalPelanggaranKelasSebulan = DB::select(" SELECT
                        count(*) as TotPelanggaranKelasSebulan
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                    WHERE
                    MONTH(t_pelanggarans.created_at) = MONTH(curdate()) AND
                    t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         


            $TotalBimbinganKelasSeminggu = DB::select(" SELECT                                   
                        count(*) as TotBimbinganKelasSeminggu 
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                    WHERE
                    date_format(t_bimbingans.tgl_realisasi,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                    AND t_distribusi_walikelas.id = :id_distribusi_walikelas 
                    AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]); 

            $TotalBimbinganKelasSebulan = DB::select(" SELECT                                   
                       count(*) as TotBimbinganKelasSebulan
                    FROM
                        t_distribusi_walikelas
                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                    WHERE
                    MONTH(t_bimbingans.tgl_realisasi) = MONTH(curdate()) 
                    AND t_distribusi_walikelas.id = :id_distribusi_walikelas 
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
        try
        {
            
            $GetAllPelanggaranByIdSiswa = DB::select("SELECT *
                                            FROM t_pelanggarans 
                                            WHERE id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);

            $GetAllBimbinganByIdSiswa = DB::select("SELECT *
                            FROM t_bimbingans 
                            WHERE status_realisasi = '1'
                                AND id_siswa = :id_siswa",["id_siswa" => $request->Id_Siswa]);     

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
                        
            $GetAllPelanggaran = DB::select(" SELECT
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN t_pelanggarans ON t_distribusi_kelas.id_siswa = t_pelanggarans.id_siswa 
                                    LEFT JOIN mstr_siswas ON t_pelanggarans.id_siswa = mstr_siswas.id
                                    WHERE
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
           
            $GetAllBimbingan = DB::select(" SELECT                                   
                                        *
                                    FROM
                                        t_distribusi_walikelas
                                    LEFT JOIN t_distribusi_kelas ON t_distribusi_walikelas.id_kelas = t_distribusi_kelas.id_kelas
                                    LEFT JOIN t_bimbingans ON t_distribusi_kelas.id_siswa = t_bimbingans.id_siswa
                                    LEFT JOIN mstr_siswas ON t_bimbingans.id_siswa = mstr_siswas.id
                                    WHERE
                                        t_distribusi_walikelas.id = :id_distribusi_walikelas 
                                        AND t_bimbingans.status_realisasi = '1'",["id_distribusi_walikelas" => $request->Id_WaliKelas]);         
   
            return response()-> json(['status' => 'S', 'HistoryPelanggaran' => $GetAllPelanggaran,
             'HistoryBimbingan' => $GetAllBimbingan]);
        }
        catch(Exception $e){
             return response()-> json(['status' => 'E', 'message' => $e]);        
        }
    }
   
}    
              