<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pusher extends Model
{

    const GOOGLE_GCM_URL = 'https://android.googleapis.com/gcm/send';

    private $apiKey;
    private $proxy;
    private $output;

    public function __construct($apiKey = null, $proxy = null)
    {
        $this->apiKey = 'AIzaSyCXOZ4iBDLq_hBCoYjsqI2l91Uz2rrM4pQ';
        $this->proxy  = $proxy;
    }

    /**
     * @param string|array $regIds
     * @param string $data
     * @throws \Exception
     */
    public function notify($regIds, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::GOOGLE_GCM_URL);
        if (!is_null($this->proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostFields($regIds, $data));

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        $this->output = $result;
    }

    /**
     * @return array
     */
    public function getOutputAsArray()
    {
        return json_decode($this->output, true);
    }

    /**
     * @return object
     */
    public function getOutputAsObject()
    {
        return json_decode($this->output);
    }

    private function getHeaders()
    {
        return [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json'
        ];
    }

    private function getPostFields($regIds, $data)
    {

        $fields = Array(
            'notification' => Array(
                'title' => 'Hpbtecapp',
                'body' => $data,
                'sound' => 'default',
                'badge' => '0',
            ),
            'data' => Array(
                'message' => 'titulo1',
                'id' => '10',
            ),
            'priority' => 'high',
            'to' => $regIds,
        );

        if (!is_string($regIds)) {
            $fields = Array(
                'notification' => Array(
                    'title' => 'Hpbtecapp',
                    'body' => $data,
                    'sound' => 'default',
                    'badge' => '0',
                ),
                'data' => Array(
                    'message' => 'titulo1',
                    'id' => '10',
                ),
                'priority' => 'high',
                'registration_ids' => $regIds,
            );
        }

        return json_encode($fields, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    private function _getPostFields($regIds, $data)
    {
        $fields = [
            'registration_ids' => is_string($regIds) ? [$regIds] : $regIds,
            'data'             => is_string($data) ? ['message' => $data] : $data,
        ];

        return json_encode($fields, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
    
}
