<?php


namespace App\Http\Controllers\walimurid;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalimuridController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function GetDataCharts(Request $request){
        try{

            $TotalPelanggaranSeminggu = DB::select("SELECT
                                        COUNT(*) AS PelanggaranSeminggu
                                        FROM
                                        mstr_walimurids AS walimurid
                                        LEFT JOIN t_pelanggarans AS pelanggaran ON walimurid.mstr_siswa_id = pelanggaran.id_siswa
                                        WHERE
                                        date_format(pelanggaran.created_at,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                                        AND walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);  
                                          
            $TotalPelanggaranSebulan  = DB::select("SELECT
                                        COUNT(*) AS PelanggaranSebulan
                                        FROM
                                        mstr_walimurids AS walimurid
                                        LEFT JOIN t_pelanggarans AS pelanggaran ON walimurid.mstr_siswa_id = pelanggaran.id_siswa
                                        WHERE
                                        MONTH(pelanggaran.created_at) = MONTH(curdate()) AND
                                        walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);

            $TotalBimbinganSeminggu   = DB::select("SELECT
                                        COUNT(*) AS BimbinganSeminggu
                                        FROM
                                            mstr_walimurids AS walimurid
                                        LEFT JOIN t_bimbingans AS bimbingan ON walimurid.mstr_siswa_id = bimbingan.id_siswa
                                        WHERE
                                        date_format(bimbingan.tgl_realisasi,'%d-%m-%Y') between  date_format(curdate()- interval 6 day,'%d-%m-%Y') AND date_format(curdate(),'%d-%m-%Y')
                                        AND bimbingan.status_realisasi = '1'
                                        AND walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);         

            $TotalBimbinganSebulan    = DB::select("SELECT
                                        COUNT(*) AS BimbinganSebulan
                                        FROM
                                            mstr_walimurids AS walimurid
                                        LEFT JOIN t_bimbingans AS bimbingan ON walimurid.mstr_siswa_id = bimbingan.id_siswa
                                        WHERE
                                        MONTH(bimbingan.tgl_realisasi) = MONTH(curdate()) 
                                        AND bimbingan.status_realisasi = '1'
                                        AND walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);      


            if (!empty($TotalPelanggaranSeminggu)){ // pengecekan pelanggaran seminggu      
                $StatusTotalPelanggaranSeminggu  = "S";    
                $resultTotalPelanggaranSeminggu  =  $TotalPelanggaranSeminggu[0]->PelanggaranSeminggu; 
            }  
            else{
                $StatusTotalPelanggaranSeminggu  = "E";
                $resultTotalPelanggaranSeminggu  = 0;
            } 

            if (!empty($TotalPelanggaranSebulan)){ // pengecekan pelanggaran seminggu   
                $StatusTotalPelanggaranSebulan = "S";   
                $resultTotalPelanggaranSebulan =  $TotalPelanggaranSebulan[0]->PelanggaranSebulan;               
            }  
            else{
                $StatusTotalPelanggaranSebulan = "E";
                $resultTotalPelanggaranSebulan = 0;
            } 

            if (!empty($TotalBimbinganSeminggu)){  // pengecekan bimbingan seminggu           
                $StatusTotalBimbinganSeminggu = "S";
                $resultTotalBimbinganSeminggu =  $TotalBimbinganSeminggu[0]->BimbinganSeminggu;            
            }  
            else{
                $StatusTotalBimbinganSeminggu = "E";
                $resultTotalBimbinganSeminggu = 0;
            } 

            if (!empty($TotalBimbinganSebulan)){ // pengecekan bimbingan sebulan     
                $StatusTotalBimbinganSebulan = "S";    
                $resultTotalBimbinganSebulan =  $TotalBimbinganSebulan[0]->BimbinganSebulan;                
            }  
            else{
                $StatusTotalBimbinganSebulan = "E";
                $resultTotalBimbinganSebulan = 0;
            } 

             return response()->json(['status' => 'S', 'DataPelanggaranSeminggu' => [$StatusTotalPelanggaranSeminggu,$resultTotalPelanggaranSeminggu],'DataPelanggaranSebulan' => [$StatusTotalPelanggaranSebulan,
            $resultTotalPelanggaranSebulan], 'DataBimbinganSeminggu' => [$StatusTotalBimbinganSeminggu,$resultTotalBimbinganSeminggu], 'DataBimbinganSebulan' => [$StatusTotalBimbinganSebulan,$resultTotalBimbinganSebulan]]);
            
        }
        catch(Exception $e){
            return response()->json(['status' => 'E', 'message' => $e] );
        }

    }

    // tinggal sesuaikan nama kolom
    public function GetAllPelanggaran(Request $request){

        /* RowObject      = Data.getJSONObject(i);
                                Id_Pelanggaran = RowObject.getString("Id_Pelanggaran");
                                Id_Siswa       = RowObject.getString("Id_Siswa");
                                Tindakan_Pelanggaran   = RowObject.getString("Tindakan_Pelanggaran");
                                Tindakan_Pendisiplinan = RowObject.getString("Tindakan_Pendisiplinan");
                                Created_By     = RowObject.getString("Created_By");
                                Created_Time   = RowObject.getString("Created_Time");
                                Updated_By     = RowObject.getString("Updated_By");
                                Updated_Time   = RowObject.getString("Updated_Time");
         */
        try{         
            $PelanggaranAll = DB::select("SELECT
                                    *
                                    FROM
                                    mstr_walimurids AS walimurid
                                    LEFT JOIN t_pelanggarans AS pelanggaran ON walimurid.mstr_siswa_id = pelanggaran.id_siswa
                                    WHERE
                                    walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);      

            //$StatusPelanggaran = ($PelanggaranAll == TRUE)?"S":"E";
           // return response()->json(['status' => $StatusPelanggaran,'data' => $PelanggaranAll]);

           return response()->json(['status' => 'S','data' => $PelanggaranAll]);
        }
        catch(Exception $e){
             return response()->json(['status' => 'E', 'message' => $e] );
        }
    }
    // tinggal sesuaikan nama kolom
    public function GetAllBimbingan(Request $request){

        /*
           RowObject      = Data.getJSONObject(i);
            Kode_Rel       = RowObject.getString("Kode_Rel");
            Kode_Ren       = RowObject.getString("Kode_Ren");
            Rel_Acc_Status = RowObject.getString("Rel_Acc_Status");
            Rel_waktu_janji= RowObject.getString("Rel_waktu_janji");
            Rel_Acc_Time   = RowObject.getString("Rel_Acc_Time");
            Rel_Ren_Status = RowObject.getString("Rel_Ren_Status");
            Topik          = RowObject.getString("Topik");

        
        */
        try{   
            $BimbinganAll = DB::select("SELECT
                                        *
                                    FROM
                                        mstr_walimurids AS walimurid
                                    LEFT JOIN t_bimbingans AS bimbingan ON walimurid.mstr_siswa_id = bimbingan.id_siswa
                                    WHERE
                                        bimbingan.status_realisasi = '1'
                                    AND walimurid.id = :id_walimurid",["id_walimurid" => $request->Id_WaliMurid]);      

            //$StatusBimbingan = ($BimbinganAll == TRUE)?"S":"E";
            //return response()->json(['status' => $StatusBimbingan,'data' => $BimbinganAll]);

            return response()->json(['status' => 'S','data' => $BimbinganAll]);
        }
        catch(Exception $e){
             return response()->json(['status' => 'E', 'message' => $e] );
        }
    }

}    
              