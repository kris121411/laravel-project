<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use PHPExcel; 
use PHPExcel_IOFactory; 
use PHPExcel_Style_Fill;
use PHPExcel_Style_Alignment;
use PHPExcel_Worksheet_Drawing;
use App\Http\Traits\SetSession;

class ImportExportController extends Controller {
  use SetSession;
      public function export_users(Request $request)//Request $request
   {
    // $uri = $request->path();
      // Execute the query used to retrieve the data
      $query = " SELECT * FROM tbl_user ";
      $users = DB::select($query);

  // Convert each member of the returned collection into an array,
    if(count($users) > 0 )
      {
        foreach ($users as $key => $value)
        {
          $userArray[] = [
             'A' => $value->uid,
            'B' => $value->fname,
            'C' => $value->lname,
            'D' => $value->role,
            'E' => $value->username,
            'F' => $value->password,
            'G' => ($value->is_active == 1)?"True":"False",
            ];
        }
     }
     else
     {

     }
      // Define the Excel spreadsheet headers
     $headersArray = [
     "A"=>"ID",
     "B"=>"FIRSTNAME",
     "C"=>"LASTNAME",
     "D"=>"ROLE",
     "E"=>"USERNAME",
     "F"=>"PASSWORD",
     "G"=>"IS ACTIVE"
     ];

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

        $this->logotemplate($objPHPExcel,$request); // function call the logo template

      $col = 0;
      $row = 6;
      foreach ($headersArray as $key => $value) 
      {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$value);
        $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle($key.$row)->applyFromArray($this->headerstyle());
        $col++; 
      }
      $row++;
      foreach ($userArray as $key => $value) 
      {
         $col = 0;
        foreach ($value as $key => $getvalue) {
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$getvalue);
          $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getStyle($key.$row)->applyFromArray($this->contentstyle());
        $col++; 
        }
        $row++;
      }
      $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
      $objPHPExcel->getActiveSheet()->getProtection()->setPassword('password');
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header("Content-Disposition: attachment; filename=\"user.xlsx\"");
      header("Cache-Control: max-age=0");
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007'); 
      $objWriter->save("php://output");
      ob_clean();

     
    }
    public function logotemplate($objPHPExcel,$request)
    {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = base_path() . "\public\images\logo2.png"; // Provide path to your logo file
        $objDrawing->setPath($logo);
        $objDrawing->setOffsetX(8);    // setOffsetX works properly
        $objDrawing->setOffsetY(300);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(75); // logo height
        $objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0)); 
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D5");
        $objPHPExcel->getActiveSheet()->mergeCells("E1:G1");
        $objPHPExcel->getActiveSheet()->mergeCells("E2:G2");
        $objPHPExcel->getActiveSheet()->mergeCells("E3:G3");
        $objPHPExcel->getActiveSheet()->mergeCells("E4:G4");
        $objPHPExcel->getActiveSheet()->mergeCells("E5:G5");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,1,"DOWNLOAD DATE:");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,2,date("Y-m-d G:i:s", time()));
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,3,"DOWNLOAD BY:");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,4,$request->session()->get('user_lname')." ".$request->session()->get('user_fname'));
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($this->headerstyle());
        $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($this->headerstyle());

        return $objPHPExcel;

    }


    public function headerstyle()
    {
      $headerstyleArray = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'efefef'),
            'size'  => 10,
            'name'  => 'Verdana'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '0a0000')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
        );

      return $headerstyleArray;
    }

    public function contentstyle()
    {
       $contentstyleArray = array(
        'font'  => array(
            'color' => array('rgb' => '0a0000'),
            'size'  => 9,
            'name'  => 'Verdana'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
        );

       return $contentstyleArray;
    }

       public function importExcel(Request $request)//
    {
      
        if(isset($_FILES['user_file_upload'])){
            if($_FILES['user_file_upload']['tmp_name']){
            if(!$_FILES['user_file_upload']['error'])
            {

                $inputFile = $_FILES['user_file_upload']['tmp_name'];
                $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));

               

                  
                    try 
                    {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFile);
                        $sheet = $objPHPExcel->getSheet(0); 
                        $rowdata = $sheet->getHighestRow(); 
                        $columndata = $sheet->getHighestColumn();
                        $checktemplate = $sheet->rangeToArray('D1');
                        foreach ($checktemplate[0] as $key => $value) 
                        {
                          if($value == "TEMPLATE")
                          {
                          }
                          else
                          {
                          return redirect()->route('error',['message' =>"Invalid Template! Please download the specified template."]);
                          die();
                          }
                        }
                        for ($row = 6; $row <= $rowdata; $row++)
                        { 
                            $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $columndata . $row, NULL, TRUE, FALSE);
                        }
                        foreach ($rowData as $key => $value) 
                        {
                          foreach ($value as $key => $nvalue) 
                          {
                               $return_value[] = $nvalue;
                          }
                          
                        }
                       
                    } 
                    catch(Exception $e) 
                    {
                            die($e->getMessage());
                    }
            }
            else
            {
            }
            }
            }
           
          return redirect()->route('uploadfile',['result' => $return_value]);
           die();

    }
    public function get_user_table(Request $request)
    {
       $uri = $request->path();
       $result = $request->result;
        
       foreach ($result as $key => $value) 
       {
          if($key==0)
          $return_value['header'] = $value;
          else
          {
        $return_value['content'][] = $value;
          }  
          
       }

       if(count($result) > 1)
       {

       }
      else
      {
         $return_value['content'][] = ["No data"];
      }
     


       $set = $this->tab_menu_sessions($request);

          $return_value['tabs'] = $set['tabs'];
      
          $return_value['menu'] = $set['menu'];
      
          return view($uri)->with($return_value);

    }

   public function  export_user_template()
   {
        $filename = "Template-User.xlsx";
        $path= public_path()."/files/".$filename;
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header("Content-Type: application/force-download");
        header("Content-Type: application/download");
        header("Content-Length: ".filesize($path));
        readfile($path);
        exit;
   }






}



