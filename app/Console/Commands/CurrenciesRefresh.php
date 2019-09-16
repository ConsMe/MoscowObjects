<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Currency;
use GuzzleHttp\Client;

class CurrenciesRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh currencies rates';

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
        $currencies = Currency::all();
        $usd = $currencies->where('currency', 'USD')->first();
        $eur = $currencies->where('currency', 'EUR')->first();
        if (!$currencies->count()) {
            $usd = Currency::create(['currency' => 'USD', 'value' => 1]);
            $eur = Currency::create(['currency' => 'EUR', 'value' => 1]);
        }
        $client = new Client();
        $response = $client->get('https://www.cbr-xml-daily.ru/daily_json.js');
        if ($response->getStatusCode() !== 200) {
            $this->error('https://www.cbr-xml-daily.ru/daily_json.js doesn\'t return currencies');
            return;
        }
        $data = json_decode($response->getBody(), true);
        $newUsdRate = isset($data['Valute']['USD']['Value']) ? $data['Valute']['USD']['Value'] : null;
        if (is_float($newUsdRate) && $newUsdRate > 0) {
            $usd->update(['value' => round($newUsdRate, 2)]);
        }
        $newEurRate = isset($data['Valute']['EUR']['Value']) ? $data['Valute']['EUR']['Value'] : null;
        if (is_float($newEurRate) && $newEurRate > 0) {
            $eur->update(['value' => round($newEurRate, 2)]);
        }
        $this->info('Currencies rates successfully refreshed');
        $this->info('USD - '.round($newUsdRate, 2));
        $this->info('EUR - '.round($newEurRate, 2));
    }
}
