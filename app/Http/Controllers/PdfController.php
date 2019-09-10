<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use App\EstateObject;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use App\Http\Requests\ListPdfRequest;

class PdfController extends Controller
{
    public function getList_mpdf(Request $request)
    {
        // dd(json_decode($request->objects));
        // $objects = EstateObject::where('characteristics->type', 'ZU')->with(['images' => function($query) {
        //     $query->where('isMain', true);
        // }])->get(['id', 'characteristics']);
        // $objects = $objects->map(function($object) {
        //     $modifiedObject = $object['characteristics'];
        //     $modifiedObject['id'] = $object['id'];
        //     return $modifiedObject;
        // });
        $objects = json_decode($request->objects, true);
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
            'currentCategorySlug' => $request->currentCategorySlug
        ];
        $html = view('pdf.list_mpdf', $params);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        // $mpdf->SetHTMLFooterByName('myFooter');
        // $mpdf->AddPage();
        // $html = view('pdf_part2', $params);
        // $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        // $mpdf->Output('test.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        $pdf = $mpdf->Output('test.pdf', \Mpdf\Output\Destination::INLINE);
        return $pdf;
    }

    public function checkGetList(ListPdfRequest $request)
    {
        return response(200);
    }

    public function getList(ListPdfRequest $request)
    {
        $params = [
            'objects' => $request->objects,
            'currentCategorySlug' => $request->currentCategorySlug,
        ];
        $html = view('pdf.list', $params);
        $dompdf = new Dompdf();
        $dompdf->set_option('defaultMediaType', 'all');
        $dompdf->set_option('fontDir', \storage_path('app/pdf_fonts/'));
        $dompdf->set_option('fontCache', \storage_path('app/pdf_fonts'));
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return response(
            $dompdf->stream('test.pdf', ['Attachment' => 1]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function getObject(Request $request)
    {
        // $url = 'https://static-maps.yandex.ru/1.x/?ll=37.620070,55.753630&size=450,450&z=18&l=map&pt=37.620070,55.753630,pmwtm1~37.64,55.76363,pmwtm99';
        // $img = \storage_path('app/tmp_upload_files/map.pnf');
        // file_put_contents($img, file_get_contents($url));
        $img_url = 'https://static-maps.yandex.ru/1.x/?ll=37.620070,55.753630&size=235,450&z=18&l=map&pt=37.620070,55.753630,pmwtm1~37.64,55.76363,pmwtm99';
        $b64_url = 'php://filter/read=convert.base64-encode/resource='.$img_url;
        $b64_img = file_get_contents($b64_url);
        // return $b64_img;
        $params = [
            // 'objects' => $request->objects,
            // 'currentCategorySlug' => $request->currentCategorySlug,
            'b64_img' => $b64_img,
        ];
        $html = view('pdf.object_full_info', $params);
        $dompdf = new Dompdf();
        $dompdf->set_option('defaultMediaType', 'all');
        $dompdf->set_option('fontDir', \storage_path('app/pdf_fonts/'));
        $dompdf->set_option('fontCache', \storage_path('app/pdf_fonts'));
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return response(
            $dompdf->stream('test.pdf', ['Attachment' => 0]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                // 'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
