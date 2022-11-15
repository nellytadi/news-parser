<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'source', targetEntity: News::class, orphanRemoval: true)]
    private Collection $news;

    #[ORM\Column(length: 255)]
    private ?string $mainWrapper = null;

    #[ORM\Column(length: 255)]
    private ?string $wrapper = null;

    #[ORM\Column(length: 255)]
    private ?string $titleSelector = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionSelector = null;

    #[ORM\Column(length: 255)]
    private ?string $imageSelector = null;

    #[ORM\Column(length: 255)]
    private ?string $urlSelector = null;

    #[ORM\Column(length: 255)]
    private ?string $dateSelector = null;


    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->setSource($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getSource() === $this) {
                $news->setSource(null);
            }
        }

        return $this;
    }

    public function getMainWrapper(): ?string
    {
        return $this->mainWrapper;
    }

    public function setMainWrapper(string $mainWrapper): self
    {
        $this->mainWrapper = $mainWrapper;

        return $this;
    }

    public function getWrapper(): ?string
    {
        return $this->wrapper;
    }

    public function setWrapper(string $wrapper): self
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    public function getTitleSelector(): ?string
    {
        return $this->titleSelector;
    }

    public function setTitleSelector(string $titleSelector): self
    {
        $this->titleSelector = $titleSelector;

        return $this;
    }

    public function getDescriptionSelector(): ?string
    {
        return $this->descriptionSelector;
    }

    public function setDescriptionSelector(string $descriptionSelector): self
    {
        $this->descriptionSelector = $descriptionSelector;

        return $this;
    }

    public function getImageSelector(): ?string
    {
        return $this->imageSelector;
    }

    public function setImageSelector(string $imageSelector): self
    {
        $this->imageSelector = $imageSelector;

        return $this;
    }

    public function getUrlSelector(): ?string
    {
        return $this->urlSelector;
    }

    public function setUrlSelector(string $urlSelector): self
    {
        $this->urlSelector = $urlSelector;

        return $this;
    }

    public function getDateSelector(): ?string
    {
        return $this->dateSelector;
    }

    public function setDateSelector(string $dateSelector): self
    {
        $this->dateSelector = $dateSelector;

        return $this;
    }

}
