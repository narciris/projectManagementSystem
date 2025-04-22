<?php

class JwtService
{
    private $secretKey;
    private $algorithm;
    private $issuer;

    public function __construct(
        string  $secretKey = 'clave_secreta_',
        string $algorithm = 'HS512',
        string $issuer = 'managmente_project'
    )
    {
       $this->secretKey = $secretKey;
       $this->algorithm = $algorithm;
       $this->issuer = $issuer;
    }

    /**
     * generate token
    **/

    public function generateToken(array $payload,$expirationTime = 3600)
    {
       $issuedAt = time();
       $expire =  $issuedAt + $expirationTime;

       $tokenPayload = [
           'iat' => $issuedAt,
           'iss' => $this->issuer,
           'exp' => $expire,
           'data' => $payload
       ];
       return $this->encode($tokenPayload);
    }

    private function encode(array $payload): string
    {
        // Header
        $header = json_encode(['typ' => 'JWT', 'alg' => $this->algorithm]);
        $header = $this->base64UrlEncode($header);

        // Payload
        $payload = json_encode($payload);
        $payload = $this->base64UrlEncode($payload);

        // Signature
        $signature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
        $signature = $this->base64UrlEncode($signature);

        return "$header.$payload.$signature";
    }
    private function decode(string $token): array
    {
        $parts = explode('.', $token);

        if (count($parts) != 3) {
            throw new Exception("Token inválido");
        }

        list($header, $payload, $signature) = $parts;

        $recreatedSignature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
        $recreatedSignature = $this->base64UrlEncode($recreatedSignature);

        if ($recreatedSignature !== $signature) {
            throw new Exception("Firma inválida");
        }

        return json_decode($this->base64UrlDecode($payload), true);
    }

    public function validate(string $token)
    {
        try {
            $decoded = $this->decode($token);

            if (isset($decoded['exp']) && $decoded['exp'] < time()) {
                throw new Exception("Token expirado");
            }

            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * Codifica en base64url
     */
    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decodifica desde base64url
     */
    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }


}