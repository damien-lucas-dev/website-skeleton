<?php


namespace App\Entity;


class PropertySearch
{
    /**
     * @var string|null
     */
    private $keyword;

    /**
     * @var \DateTime|null
     */
    private $date;

    /**
     * @var Lieu|null
     */
    private $lieu;

    /**
     * @var bool|null
     */
    private $subscribed;

    /**
     * @var bool|null
     */
    private $passed;

    /**
     * @var bool|null
     */
    private $cancelled;

    /**
     * @var bool|null
     */
    private $owner;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    /**
     * @param string|null $keyword
     */
    public function setKeyword(?string $keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Lieu|null
     */
    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    /**
     * @param Lieu|null $lieu
     */
    public function setLieu(?Lieu $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return bool|null
     */
    public function getSubscribed(): ?bool
    {
        return $this->subscribed;
    }

    /**
     * @param bool|null $subscribed
     */
    public function setSubscribed(?bool $subscribed): void
    {
        $this->subscribed = $subscribed;
    }

    /**
     * @return bool|null
     */
    public function getPassed(): ?bool
    {
        return $this->passed;
    }

    /**
     * @param bool|null $passed
     */
    public function setPassed(?bool $passed): void
    {
        $this->passed = $passed;
    }

    /**
     * @return bool|null
     */
    public function getCancelled(): ?bool
    {
        return $this->cancelled;
    }

    /**
     * @param bool|null $cancelled
     */
    public function setCancelled(?bool $cancelled): void
    {
        $this->cancelled = $cancelled;
    }


}