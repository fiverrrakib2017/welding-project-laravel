<?php

namespace App\Console\Commands;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\Customer;
use App\Models\Router;
use Illuminate\Console\Command;
use function App\Helpers\formate_uptime;
class customer_usage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:customer_usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch daily user usage from MikroTik';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- Customer Daily Usages Started ---');

        $this->info('--- Customer Daily Usages  Finished ---');
    }
    protected function get_customer_daily_usage(){
        $customers = Customer::where('is_delete', '0')->where('status', '!=', 'expired')->get();

        foreach ($customers as $customer) {
            $router = Router::where('status', 'active')->where('id', $customer->router_id)->first();

            if (!$router) {
                $this->error("Router not found for customer {$customer->username}");
                continue;
            }

            try {
                $client = new Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => (int) $router->port,
                    'timeout' => 3,
                    'attempts' => 1,
                ]);

                $interfaces = $client->query(new Query('/interface/print'))->read();
                $sessions = $client->query(new Query('/ppp/active/print'))->read();

                $uptime = 'N/A';
                foreach ($sessions as $session) {
                    if ($session['name'] == $customers->username) {
                        $uptime = $session['uptime'];
                        break;
                    }
                }

                foreach ($interfaces as $intf) {
                    if (strpos($intf['name'], $customers->username) !== false) {
                        return response()->json([
                            'success' => true,
                            'interface_name' => $intf['name'],
                            'type' => $intf['type'],
                            'rx_mb' => round($intf['rx-byte'] / 1024 / 1024, 2),
                            'tx_mb' => round($intf['tx-byte'] / 1024 / 1024, 2),
                            'rx_packet' => $intf['rx-packet'],
                            'tx_packet' => $intf['tx-packet'],
                            'uptime' => formate_uptime($uptime),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error fetching data for customer {$customer->username}: " . $e->getMessage());
            }
        }
    }
}
