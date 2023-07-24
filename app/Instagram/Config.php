<?php


namespace App\Instagram;


class Config
{
    private string $service;
    private string $version;
    protected int $profileID;
    protected string $accessToken;

    public function __construct(int $profileID, string $accessToken, string $version = "v3.2", string $service = "https://graph.instagram.com")
    {
        $this->profileID = $profileID;
        $this->accessToken = $accessToken;
        $this->version = $version;
        $this->service = $service;
    }

    public function getUri(): string
    {
        $service = $this->getService();
        $version = $this->getVersion();
        $profileID = $this->getProfileID();

        return "$service/$version/$profileID";
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function setService(string $service): void
    {
        $this->service = $service;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getProfileID(): int
    {
        return $this->profileID;
    }

    public function setProfileID(int $profileID): void
    {
        $this->profileID = $profileID;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }


}
