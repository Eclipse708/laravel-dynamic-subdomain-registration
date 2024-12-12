<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CpanelService
{
    public function createSubdomain($subdomain)
    {
        $rootDomain = env('ROOT_DOMAIN');
        $documentRoot = '/public_html/app';

        $cpanelHost = env('CPANEL_HOST');
        $cpanelUser = env('CPANEL_USER');
        $cpanelPassword = env('CPANEL_PASSWORD');

        $cloudflareToken = env('CLOUDFLARE_API_TOKEN');
        $cloudflareZoneId = env('CLOUDFLARE_ZONE_ID');
        $cloudflareApiUrl = env('CLOUDFLARE_API_URL');
        $serverIp = env('SERVER_IP_ADDRESS');

        // $zoneDetails = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $cloudflareToken,
        //     'Content-Type' => 'application/json',
        // ])->get("$cloudflareApiUrl/zones/$cloudflareZoneId");

        // dd($zoneDetails->body());

        $subdomainArray = [
            'subdomain' => $subdomain,
            'rootDomain' => $rootDomain,
            'documentRoot' => $documentRoot,
            'cpanelHost' => $cpanelHost,
            'cpanelUser' => $cpanelUser,
            'cpanelPassword' => $cpanelPassword
        ];

        $endpoint = $subdomainArray['cpanelHost'] . '/json-api/cpanel';

        $apiParams = [
            'cpanel_jsonapi_user' => $subdomainArray['cpanelUser'],
            'cpanel_jsonapi_apiversion' => '2',
            'cpanel_jsonapi_module' => 'SubDomain',
            'cpanel_jsonapi_func' => 'addsubdomain',
            'domain' => $subdomain,
            'rootdomain' => $subdomainArray['rootDomain'],
            'dir' => $subdomainArray['documentRoot'],
        ];

        try {
            $response = Http::withBasicAuth($subdomainArray['cpanelUser'], $subdomainArray['cpanelPassword'])
                            ->post($endpoint, $apiParams);

            if ($response->successful()) {
                $responseBody = $response->json();

                if (isset($responseBody['cpanelresult']['data'][0])) {
                    $subdomainCreationResult = $responseBody['cpanelresult']['data'][0];

                    if (isset($subdomainCreationResult['result']) && $subdomainCreationResult['result'] === 1) {
                        $dnsRecord = [
                            'type' => 'A',
                            'name' => $subdomain,
                            'content' => $serverIp,
                            'ttl' => 60,
                            'proxied' => false
                        ];

                        $dnsResponse = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $cloudflareToken,
                            'Content-Type' => 'application/json',
                        ])->post("$cloudflareApiUrl/zones/$cloudflareZoneId/dns_records", $dnsRecord);

                        if($dnsResponse->successful()) {
                            $purgeResponse = Http::withHeaders([
                                'Authorization' => 'Bearer ' . $cloudflareToken,
                                'Content-type' => 'application/json',
                            ])->post("$cloudflareApiUrl/zones/$cloudflareZoneId/purge_cache", [
                                'hosts' => ["$subdomain.$rootDomain"],
                            ]);

                            if($purgeResponse->successful()) {
                                return "Subdomain created and DNS record added successfully, cache purged.";
                            } else {
                                return "Subdomain created and DNS record added, but failed to purge cache: " . $purgeResponse->body();
                            }
                        } else {
                            return "Subdomain created, but failed to add DNS record in Cloudflare: " . $dnsResponse->body();
                        }

                    } else {
                        return "Failed to create subdomain: " . $subdomainCreationResult['reason'];
                    }
                } else {
                    return "Unexpected response format from cPanel API.";
                }
            } else {
                return "API request failed with status code: " . $response->status();
            }
        } catch (\Exception $e) {
            return "Error occurred while creating subdomain: " . $e->getMessage();
        }
    }
}
