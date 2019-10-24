<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\EstateObject;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use App\Currency;
use Illuminate\Support\Str;

class SendNewObjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:objects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new objects to subscribers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('role')->where([
            'accepted' => true,
            'subscribed' => true
        ])->get();
        if (!$users->count()) return;
        $objects = EstateObject::where('created_at', '>', now()
            ->addHours(-24))
            ->where('object_admins_only', false)
            ->with(['images' => function($query) {
                $query->where('isMain', true);
            }])
            ->get();
        if (!$objects->count()) return;
        $currenciesInit = Currency::get(['currency', 'value'])->keyBy('currency');
        $currencies = [
            'dollar' => $currenciesInit['USD']['value'],
            'euro' => $currenciesInit['EUR']['value'],
        ];
        $files = [];
        $links = [];
        foreach ($objects as $objectInit) {
            $object = $objectInit->characteristics;
            $object['description'] = explode("\n", $objectInit->description);
            $object['images'] = $objectInit->images;
            $object['id'] = $objectInit->id;
            if ($objectInit->price_admins_only) {
                $object['cost'] = '';
            } else {
                if ($object['costCurrency'] !== 'rouble') {
                    $object['cost'] = round($object['cost'] * $currencies[$object['costCurrency']]);
                }
                $object['cost'] = preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', $object['cost']);
            }
            if ($object['type'] === 'Invest') {
                if ($object['GAPCurrency'] !== 'rouble') {
                    $object['GAP'] = round($object['GAP'] * $currencies[$object['GAPCurrency']]);
                }
                $object['GAP'] = preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', $object['GAP']);
            }
            if ($object['type'] === 'Retail') {
                if ($object['MAPCurrency'] !== 'rouble') {
                    $object['MAP'] = round($object['MAP'] * $currencies[$object['MAPCurrency']]);
                }
                $object['MAP'] = preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', $object['MAP']);
            }
            if (isset($object['areaS'])) {
                $object['areaS'] = preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', $object['areaS']);
            }
            $hide_company_info_in_tizer = DB::table('hide_company_info_in_tizer')->where('object_id', $objectInit->id)->first();
            if ($hide_company_info_in_tizer) {
                $size = '227,450';
            } else {
                $size = '250,450';
            }
            $img_url = 'https://static-maps.yandex.ru/1.x/?ll=' . implode(',', array_reverse($object['coordinates'])) . '&size=' . $size . '&z=15&l=map';
            $b64_url = 'php://filter/read=convert.base64-encode/resource=' . $img_url;
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
            $files[] = [
                'fileContent' => $dompdf->output(),
                'filename' => $object['id'].'.pdf',
            ];
            $links[] = env('APP_URL'). strtolower($object['type']).'/'.$object['id'];
        }
        $variables = [];
        $id = 1;
        foreach ($users as $user) {
            if (!$user->unsubscribe_token) {
                $user->unsubscribe_token = Str::random(60);
                $user->save();
            }
            $variables[$user->email] = ['id' => $user->id, 'unsubscribe_token' => $user->unsubscribe_token];
            $id++;
        }
        $img_url = public_path('img/mail_logo.png');
        $b64_url = 'php://filter/read=convert.base64-encode/resource=' . $img_url;
        $b64_img = file_get_contents($b64_url);
        $mgClient = Mailgun::create(env('MAILGUN_SECRET'), 'https://'.env('MAILGUN_ENDPOINT'));
        $domain = env('MAILGUN_DOMAIN');
        $result = $mgClient->messages()->send($domain, array(
            'from'    => env('MAIL_FROM_NAME').' '.env('MAIL_FROM_ADDRESS'),
            'to'      => implode(',', $users->pluck('email')->toArray()),
            'subject' => 'Новые объекты на сайте ИНВЕСТТЕХ.PRO',
            'html'    => view('mail.new_objects', ['logo' => $b64_img, 'links' => $links])->render(),
            'recipient-variables' => json_encode($variables),
            'attachment' => $files
        ));
    }
}
