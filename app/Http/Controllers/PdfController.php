<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use App\EstateObject;
use Illuminate\Support\Facades\File;

class PdfController extends Controller
{
    public function getList()
    {
        $objects = EstateObject::where('characteristics->type', 'ZU')->limit(3)->with(['images' => function($query) {
            $query->where('isMain', true);
        }])->get(['id', 'characteristics']);
        $objects = $objects->map(function($object) {
            $modifiedObject = $object['characteristics'];
            $modifiedObject['id'] = $object['id'];
            return $modifiedObject;
        });
        // dd($objects);
        $mpdf = new Mpdf([
            'fontDir' => public_path('/pdf/fonts/'),
            'fontdata' => [
                'roboto' => [
                    'R' => 'Roboto-Regular.ttf',
                    'I' => 'Roboto-RegularItalic.ttf',
                ]
            ],
            'default_font' => 'roboto',
            'orientation' => 'L',
        ]);
        $stylesheet = File::get(public_path('/pdf/css/pdf_list.css'));
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        // foreach ($objects as $object) {
        // $mpdf->imageVars['header'] = File::get(public_path('/img/header.jpg'));
        // $header = '
        //     <div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
        //         <img src="var:header" style="width: 210mm; height: 72mm; margin: 0;" />
        //     </div>
        //     <div style="height: 55mm; position: relative; width: 210mm;"></div>
        //     ';
        // $mpdf->WriteHTML($header, \Mpdf\HTMLParserMode::HTML_BODY);
        // $params['forFile'] = TRUE;
        $params = [
            'objects' => $objects,
            'currentCategorySlug' => 'ZU'
        ];
        $html = view('pdf.list', $params);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        // $mpdf->SetHTMLFooterByName('myFooter');
        // $mpdf->AddPage();
        // $html = view('pdf_part2', $params);
        // $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $pdf = $mpdf->Output('test.pdf', \Mpdf\Output\Destination::INLINE);
        return $pdf;
    }
}
