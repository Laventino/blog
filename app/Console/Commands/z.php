<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class z extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:z';

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
     * @return int
     */
    public function handle()
    {
        $decodedUrl = urldecode('https://nozomi.la/');

        $htmlListPage = Http::withOptions(['verify' => false])
        ->withHeaders([
            'a' => 'Uf1AHabR2b7teyURIpKFexcKbS7Ku8c4',
            'token_QpUJAAAAAAAAGu98Hdz1l_lcSZ2rY60Ajjk9U1c' => 'BQPCAAAAAAAACZUAAuWwaBijXe4zUZ4PSv1q15rC3251QvOxh8_10zRupssZ_FpKQAcCZAgUyLSk8pENkDDryiJ1Ix8n8G7XEN7o0wtYygrpjXVglS_Xr6X3SrqrXUHJYYZq9lczoGwuXev07TYwGXmtVU51a5zPgyWhgXdI3I5f7xHuTjHOx5H0UBFA7-zNGS40QVtMtxbsM89MUoO0m73gjoO0gXuIbBgYAlgy_CCCHF8PuVEUeFwVJeSEASpFl4Os-KGfIeD9uR7-DMbnGs03duvjTb1wmPCc2npCM3h2IIiQ58q5dRyJnvJYgN5CC11MpWONqaCFbIyZbb8bqNnHODHEwkySEyfaL_wZxMKkGR7JSuknL06BRgm7ibtz4kcG75ikC0Ze5WXpOI6zoXiEduMHqKUBIyGfPk36Kie5VTkvBhuW5COpF2WnIJXE7xxCU8prCFTunA6tguOm-SDggiX3LDUzSMfhm1mBNgYluh49dQeOBza9BdSMXSQhKoAzajBEP3hD3q877HY2xPaRGn0iXX4DcDzQeW8RJ4pdg8yWSGP50e9HFftG9hIFO4fR4ssF0RKfTqoVzFqDF74CRTrnfNsqWvCxqBzAdOTvMpQz92lAdg_LPjR8Po2jV3eAU5NjNoIQzsrP35UO-9YjyyWcqgngIkMqoH41kzD0u53SntCN11i9Ll-d6OBAFz9KxpiC32uLOhiBwl2kP9z3ScZGUpbMbssSbec03q8cbFsMVOWCmxP0XdqYCWpbBgnmMqih2h9a5AfwtJQn2OOjQ9TRG_qU0Naka4ZRS2KFHIcR8kP1Vncw5OFimM5KH5p5KYQSQMri6uRnypkwGlL2LMuKQtAGEkSt9NlzhBWl9IWNRl3Vms_TyTAMgylGDrFGY4JWnQmYm6P_X0_wV7odbbBJ3wUOjExhLOg7wtJRIsnoFELrdz3vCbs0XeGyivpwk30Z2MaTqSolzWXvmb-h1B18XrfDIFt_s3cHbq6NFaBPuoEyUyJJUPvHhQ4HNBTQvLyy9xOU5V3T6pehIO6ddy6O1mxRK74GIhtRHXOTiD4p3V651GfPWDcL6NpN-TFnmlrg9CG52eA1I1xG_aEo5Ycwy2bxib0Lx4V-hNAtB3UXZYLEz4ORMFaZqOp2GiWV-b4oJUI0LvTN8sPLo968JPPqUBSot8x86RG2eFG1Sk7hnrEGrlieBQyx1Sn6d6p7pSlOgm0UZo2aFTm2faPkXu_i95CN4JthIKuki4Js8xTnY6nluPokj4gYEvlGwkTkrQp5Qbf9rZqSXA',
        ])
        ->get('https://nozomi.la/');
        \Log::info('item',[$htmlListPage]);
    }
}
