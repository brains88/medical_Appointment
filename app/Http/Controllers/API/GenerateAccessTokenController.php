<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class GenerateAccessTokenController extends Controller
{
    //
     public function generate_token(Request $request)
    {
     // Substitute your Twilio Account SID and API Key details
        $accountSid = ('TWILIO_ACCOUNT_SID');
        $apiKeySid = ('TWILIO_API_KEY');
        $apiKeySecret = ('TWILIO_API_SECRET');
        $identity = $request->identity;
        $room_name = $request->room_name;

        // Create an Access Token
        $token = new AccessToken(
            $accountSid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity,
            $room_name
        );

        // Grant access to Video
        $grant = new VideoGrant();
        // $grant->setRoom('');
        $token->addGrant($grant);

        // Serialize the token as a JWT
        $result=[ 
            "identity" => $identity,
            "token"=> $token->toJWT()
        ];

        return response()->json($result);
    }
}