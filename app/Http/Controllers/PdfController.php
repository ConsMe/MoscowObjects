<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Http\Requests\ListPdfRequest;
use App\Http\Requests\ObjectPdfRequest;
use Illuminate\Support\Facades\DB;

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
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return response(
            $dompdf->stream('list.pdf', ['Attachment' => 1]),
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
        $isUserPartner = auth()->check() && $request->user()->role === 'partner';
        $hide_company_info_in_tizer = DB::table('hide_company_info_in_tizer')
            ->where('object_id', $object['id'])->first() || $isUserPartner;
        if ($hide_company_info_in_tizer) {
            $size = '227,450';
        } else {
            $size = '250,450';
        }
        $img_url = 'https://static-maps.yandex.ru/1.x/?ll='.implode(',', array_reverse($object['coordinates'])).'&size='.$size.'&z=15&l=map';
        if ($object['type'] === 'Retail') {
            $img_url .= '&pt='. implode(',', array_reverse($object['coordinates'])). ',comma';
        }
        $b64_url = 'php://filter/read=convert.base64-encode/resource='.$img_url;
        $b64_img = file_get_contents($b64_url);
        $params = [
            'object' => $object,
            'b64_img' => $b64_img,
            'hide_company_info_in_tizer' => $hide_company_info_in_tizer,
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
        $address = preg_replace("/[^a-zа-я0-9\-\._]/ui", '_', $object['address']);
        $filename = 'Лот_'.$object['id'].'_'.$address.'.pdf';
        return response(
            $dompdf->stream($filename, ['Attachment' => 1]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
