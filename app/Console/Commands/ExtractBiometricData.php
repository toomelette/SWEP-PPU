<?php

namespace App\Console\Commands;

use App\Models\BiometricDevices;
use App\Swep\Services\DTRService;
use Illuminate\Console\Command;

class ExtractBiometricData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dtr:extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    protected $dtr_service;
    public function handle(DTRService $dtr_service)
    {

        $bds = BiometricDevices::query()->where('status' ,'=',1)->get();
        if(!empty($bds)){
            foreach ($bds as $bd){
                $ip = $bd->ip_address;
                try{
                    $dtr_service->extract($ip);
                }catch (\Exception $e){

                }
            }
        }
//        $ip = '10.36.1.21';
//        $dtr_service->extract($ip);
//
//        $ip = '10.36.1.23';
//        $dtr_service->extract($ip);
    }
}
