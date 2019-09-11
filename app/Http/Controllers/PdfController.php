<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use App\EstateObject;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use App\Http\Requests\ListPdfRequest;
use App\Http\Requests\ObjectPdfRequest;

class PdfController extends Controller
{
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

    public function checkGetObject(ObjectPdfRequest $request)
    {
        return response(200);
    }

    public function getObject(ObjectPdfRequest $request)
    {
        $object = $request->object;
        $object['description'] = explode("\n", $object['description']);
        $img_url = 'https://static-maps.yandex.ru/1.x/?ll='.implode(',', array_reverse($object['coordinates'])).'&size=235,450&z=15&l=map';
        $b64_url = 'php://filter/read=convert.base64-encode/resource='.$img_url;
        $b64_img = file_get_contents($b64_url);
        $params = [
            'object' => $object,
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
            $dompdf->stream('test.pdf', ['Attachment' => 1]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
