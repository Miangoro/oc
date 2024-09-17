<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DocuSign\eSign\Client\ApiClient;
use Illuminate\Http\Request;
use DocuSign\Services\SignatureClientService;
use DocuSign\Services\Examples\eSignature\SigningViaEmailService;


use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use DocuSign\eSign\Api\EnvelopesApi;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class DocuSignController extends Controller
{
    public function authenticate()
    {
        $config = config('docusign');
        $client = new ApiClient();
        $client->setOAuthBasePath('account-d.docusign.com'); // Para ambiente de pruebas

        $url = $client->getAuthorizationUrl([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => 'signature',
        ]);

        return redirect($url);
    }

    public function callback(Request $request)
    {
        // Intercambiar el código por el token de acceso
        $code = $request->query('code');
        $client = new ApiClient();
        $token = $client->generateAccessToken($code, config('docusign.secret_key'));

        // Guardar el token de acceso en la sesión o la base de datos
        session(['docusign_access_token' => $token]);
        
        return redirect()->route('your.route');
    }

    public function sendDocument(Request $request)
{
    // Recuperar el token de la sesión
    $token = Session::get('docusign_access_token');

    if (!$token) {
        // Si no hay token, genera uno nuevo
        $token = $this->obtenerTokenDocuSign();
        if (strpos($token, 'Error:') !== false) {
            return response()->json(['error' => 'Error obteniendo token de acceso.'], 401);
        }
    }else{
        echo "Todo ok";
    }

    // Crea el cliente de API de DocuSign utilizando el token
    $apiClient = new ApiClient();
    $apiClient->getConfig()->setAccessToken($token);

    // Inicializa la clase EnvelopesApi
    $envelopeApi = new EnvelopesApi($apiClient);

    // Configura el documento
    $pathToFile = storage_path('app/public/uploads/NOM-070-001C/Pre-certificado_CIDAM_C-EXP-426_2024-A.pdf');
    $document = new Document([
        'document_base64' => base64_encode(file_get_contents($pathToFile)),
        'name' => 'Pre-certificado CIDAM',
        'file_extension' => 'pdf',
        'document_id' => '1',
    ]);

    // Configura el firmante
    $signer = new Signer([
        'email' => $request->input('email', 'imendoza@erpcidam.com'), // Email del firmante
        'name' => $request->input('name', 'María Inés Mendoza Cisneros'), // Nombre del firmante
        'recipient_id' => '1', // Asegúrate de que sea único
    ]);

    // Lugar donde debe firmar el usuario
    $signHere = new SignHere([
        'anchor_string' => 'Signature',
        'anchor_units' => 'pixels',
        'anchor_x_offset' => '200',
        'anchor_y_offset' => '150',
    ]);

    // Asocia la posición de la firma al firmante
    $signer->setTabs(new Tabs(['sign_here_tabs' => [$signHere]]));

    // Configura el sobre (envelope)
    $envelopeDefinition = new EnvelopeDefinition([
        'email_subject' => 'Por favor, firme este documento',
        'documents' => [$document],
        'recipients' => ['signers' => [$signer]],
        'status' => 'sent', // Enviar inmediatamente
    ]);

    // Envía el sobre para firma
    try {
        // Reemplaza 'account_id' con tu ID de cuenta de DocuSign
        $envelopeSummary = $envelopeApi->createEnvelope('29412951', $envelopeDefinition);
        return response()->json($envelopeSummary);
    } catch (\Exception $e) {
        // Manejo de errores
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
    public function open($target)
    {
        switch (PHP_OS) {
            case 'Darwin':
                $opener = 'open';
                break;
            case 'WINNT':
                $opener = 'start ""';
                break;
            default:
                $opener = 'xdg-open';
        }
    
        return exec(sprintf('%s %s', $opener, escapeshellcmd($target)));
    }
    
    public function obtenerTokenDocuSign()
    {
        // Configuraciones de DocuSign desde el .env
        $clientId = env('DOCUSIGN_CLIENT_ID');
        $userId = env('DOCUSIGN_USER_ID');
        $privateKey = file_get_contents(env('DOCUSIGN_PRIVATE_KEY'));
        $authServer = env('DOCUSIGN_AUTH_SERVER') . '/oauth/token';
        $scopes = "signature impersonation";
    
        // Crear el JWT
        $now = Carbon::now()->timestamp;
        $exp = Carbon::now()->addMinutes(60)->timestamp; // Puede ajustar a 60 para una hora
        $payload = [
            'iss' => $clientId,
            'sub' => $userId,
            'aud' => 'account-d.docusign.com', // Cambiado aquí
            'iat' => $now,
            'exp' => $exp,
            'scope' => 'signature impersonation'
        ];
    
        $jwt = JWT::encode($payload, $privateKey, 'RS256');
    
        // Hacer la solicitud HTTP para obtener el token
        $client = new Client(); 
        try {
            $response = $client->post($authServer, [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
            $token = $data['access_token'];
            Session::put('docusign_access_token', $token); // Almacena el token en la sesión
    
            //return $data;
    
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), "consent_required") !== false) {
                $authorizationURL = 'https://account-d.docusign.com/oauth/auth?' . http_build_query([
                    'scope'         => $scopes,
                    'redirect_uri'  => "http://localhost:8000/test-docusign",
                    'client_id'     => $clientId,
                    'response_type' => 'code'
                ]);
        
                echo "It appears that you are using this integration key for the first time. Opening the following link in a browser window:\n";
                echo $authorizationURL . "\n\n";
                $this->open($authorizationURL);
                exit;
            }
    
            // Manejo de errores más específico
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            return 'Error: ' . $errorResponse['error'];
        }

        $authorizationURL = 'https://account-d.docusign.com/oauth/auth?' . http_build_query([
            'scope'         => $scopes,
            'redirect_uri'  => "http://localhost:8000/test-docusign",
            'client_id'     => $clientId,
            'response_type' => 'code'
        ]);

        echo "It appears that you are using this integration key for the first time. Opening the following link in a browser window:\n";
        echo $authorizationURL . "\n\n";





      /*  $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath("account-d.docusign.com");
        $response = $apiClient->requestJWTUserToken($clientId, $userId, $privateKey, $scopes, 60);

        if (isset($response)) {
            $access_token = $response[0]['access_token'];
            // retrieve our API account Id
            $info = $apiClient->getUserInfo($access_token);
            $account_id = $info[0]["accounts"][0]["account_id"];
            $args['base_path'] = "https://demo.docusign.net/restapi";
             $args['account_id'] = $account_id;
            $args['ds_access_token'] = $access_token;
        
        
        
          
            try {
               
        
                echo "Successfully sent envelope with envelope ID: " . $result['envelope_id'] . "\n";
            } catch (\Throwable $th) {
                var_dump($th);
                exit;
            }
        }
*/


    }

}
