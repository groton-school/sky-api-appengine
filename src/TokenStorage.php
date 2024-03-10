<?php

namespace GrotonSchool\SKY\AppEngine;

use Battis\LazySecrets\Cache;
use Battis\OpenAPI\Client\TokenStorage as ClientTokenStorage;
use League\OAuth2\Client\Token\AccessTokenInterface;

class TokenStorage extends ClientTokenStorage
{
  private const ACCESS_TOKEN = "BLACKBAUD_API_TOKEN";

  private Cache $secrets;

  /**
   * @param ?string|Cache $projectId
   */
  public function __construct(mixed $projectId)
  {
    $this->secrets =
      $projectId instanceof Cache
        ? $projectId
        : new Cache($projectId ?? $_ENV["GOOGLE_CLOUD_PROJECT"]);
  }

  public function getToken(): ?AccessTokenInterface
  {
    return $this->secrets->get(self::ACCESS_TOKEN);
  }

  public function setToken(AccessTokenInterface $token): bool
  {
    return $this->secrets->set(self::ACCESS_TOKEN, $token, 1);
  }
}