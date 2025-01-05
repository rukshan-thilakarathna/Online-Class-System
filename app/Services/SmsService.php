<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $url;
    protected $headers;

    public function __construct()
    {
        $this->url = 'https://api.unecast.com/v1.0/sms/send'; // Your API endpoint
        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic dHBub3ZhdGl0YW5AZ21haWwuY29tOjE5OTYzMjgyODY3MWRhYzZjODRiYjU2NDE3MjY0OTg=' // Replace with your actual credentials
        ];
    }

    /**
     * Send a single SMS.
     *
     * @param string $senderID
     * @param string $to
     * @param string $message
     * @return array
     */
    public function sendSingleSms($senderID, $to, $message)
    {
        // Prepare data to be sent in the request
        $data = [
            "from" =>  "Asela Eng",
            "to" => $to,
            "msg" => $message
        ];

        // Send POST request
        $response = Http::withHeaders($this->headers)->post($this->url, $data);

        // Handle the response
        if ($response->successful()) {
            // Return success response with response data
            return [
                'status' => 'success',
                'data' => $response->json() // Parse the JSON response
            ];
        }

        // Return error response if the request failed
        return [
            'status' => 'error',
            'error' => $response->json() // Return error details
        ];
    }
}
