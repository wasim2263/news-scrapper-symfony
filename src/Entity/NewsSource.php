<?php

namespace App\Entity;

use App\Repository\NewsSourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsSourceRepository::class)
 */
class NewsSource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $wrapper_selector;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $title_selector;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description_selector;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $date_selector;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $image_selector;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $day_translation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $week_translation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $month_translation;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" = false})
     */
    private $is_custom_date_format;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getWrapperSelector(): ?string
    {
        return $this->wrapper_selector;
    }

    public function setWrapperSelector(string $wrapper_selector): self
    {
        $this->wrapper_selector = $wrapper_selector;

        return $this;
    }

    public function getTitleSelector(): ?string
    {
        return $this->title_selector;
    }

    public function setTitleSelector(string $title_selector): self
    {
        $this->title_selector = $title_selector;

        return $this;
    }

    public function getDescriptionSelector(): ?string
    {
        return $this->description_selector;
    }

    public function setDescriptionSelector(string $description_selector): self
    {
        $this->description_selector = $description_selector;

        return $this;
    }

    public function getDateSelector(): ?string
    {
        return $this->date_selector;
    }

    public function setDateSelector(string $date_selector): self
    {
        $this->date_selector = $date_selector;

        return $this;
    }

    public function getImageSelector(): ?string
    {
        return $this->image_selector;
    }

    public function setImageSelector(string $image_selector): self
    {
        $this->image_selector = $image_selector;

        return $this;
    }

    public function getDayTranslation(): ?string
    {
        return $this->day_translation;
    }

    public function setDayTranslation(?string $day_translation): self
    {
        $this->day_translation = $day_translation;

        return $this;
    }

    public function getWeekTranslation(): ?string
    {
        return $this->week_translation;
    }

    public function setWeekTranslation(?string $week_translation): self
    {
        $this->week_translation = $week_translation;

        return $this;
    }

    public function getMonthTranslation(): ?string
    {
        return $this->month_translation;
    }

    public function setMonthTranslation(string $month_translation): self
    {
        $this->month_translation = $month_translation;

        return $this;
    }

    public function isIsCustomDateFormat(): ?bool
    {
        return $this->is_custom_date_format;
    }

    public function setIsCustomDateFormat(bool $is_custom_date_format): self
    {
        $this->is_custom_date_format = $is_custom_date_format;

        return $this;
    }
}
