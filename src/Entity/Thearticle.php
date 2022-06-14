<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thearticle
 *
 * @ORM\Table(name="thearticle", uniqueConstraints={@ORM\UniqueConstraint(name="thearticleslug_UNIQUE", columns={"thearticleslug"})}, indexes={@ORM\Index(name="fk_thearticle_theuser1_idx", columns={"theuser_idtheuser"})})
 * @ORM\Entity
 */
class Thearticle
{
    /**
     * @var int
     *
     * @ORM\Column(name="idthearticle", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idthearticle;

    /**
     * @var string
     *
     * @ORM\Column(name="thearticletitle", type="string", length=120, nullable=false)
     */
    private $thearticletitle;

    /**
     * @var string
     *
     * @ORM\Column(name="thearticleslug", type="string", length=120, nullable=false)
     */
    private $thearticleslug;

    /**
     * @var string
     *
     * @ORM\Column(name="thearticleresume", type="string", length=250, nullable=false)
     */
    private $thearticleresume;

    /**
     * @var string
     *
     * @ORM\Column(name="thearticletext", type="text", length=65535, nullable=false)
     */
    private $thearticletext;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="thearticledate", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $thearticledate = 'CURRENT_TIMESTAMP';

    /**
     * @var integer|null
     *
     * @ORM\Column(name="thearticleactivate", type="integer", nullable=true, options={"comment"="0 => waiting
1 => publish
2 => deleted"})
     */
    private $thearticleactivate = '0';

    /**
     * @var \Theuser
     *
     * @ORM\ManyToOne(targetEntity="Theuser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="theuser_idtheuser", referencedColumnName="idtheuser")
     * })
     */
    private $theuserIdtheuser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Thecomment", inversedBy="thearticleIdthearticle")
     * @ORM\JoinTable(name="thearticle_has_thecomment",
     *   joinColumns={
     *     @ORM\JoinColumn(name="thearticle_idthearticle", referencedColumnName="idthearticle")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="thecomment_idthecomment", referencedColumnName="idthecomment")
     *   }
     * )
     */
    private $thecommentIdthecomment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Theimage", mappedBy="thearticleIdthearticle")
     */
    private $theimageIdtheimage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Thesection", mappedBy="thearticleIdthearticle")
     */
    private $thesectionIdthesection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->thecommentIdthecomment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->theimageIdtheimage = new \Doctrine\Common\Collections\ArrayCollection();
        $this->thesectionIdthesection = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdthearticle(): ?int
    {
        return $this->idthearticle;
    }

    public function getThearticletitle(): ?string
    {
        return $this->thearticletitle;
    }

    public function setThearticletitle(string $thearticletitle): self
    {
        $this->thearticletitle = $thearticletitle;

        return $this;
    }

    public function getThearticleslug(): ?string
    {
        return $this->thearticleslug;
    }

    public function setThearticleslug(string $thearticleslug): self
    {
        $this->thearticleslug = $thearticleslug;

        return $this;
    }

    public function getThearticleresume(): ?string
    {
        return $this->thearticleresume;
    }

    public function setThearticleresume(string $thearticleresume): self
    {
        $this->thearticleresume = $thearticleresume;

        return $this;
    }

    public function getThearticletext(): ?string
    {
        return $this->thearticletext;
    }

    public function setThearticletext(string $thearticletext): self
    {
        $this->thearticletext = $thearticletext;

        return $this;
    }

    public function getThearticledate(): ?\DateTimeInterface
    {
        if(is_string($this->thearticledate)) return null;
        return $this->thearticledate;
    }

    public function setThearticledate(?\DateTimeInterface $thearticledate): self
    {
        $this->thearticledate = $thearticledate;

        return $this;
    }

    public function isThearticleactivate(): ?int
    {
        return $this->thearticleactivate;
    }

    public function setThearticleactivate(?int $thearticleactivate): self
    {
        $this->thearticleactivate = $thearticleactivate;

        return $this;
    }

    public function getTheuserIdtheuser(): ?Theuser
    {
        return $this->theuserIdtheuser;
    }

    public function setTheuserIdtheuser(?Theuser $theuserIdtheuser): self
    {
        $this->theuserIdtheuser = $theuserIdtheuser;

        return $this;
    }

    /**
     * @return Collection<int, Thecomment>
     */
    public function getThecommentIdthecomment(): Collection
    {
        return $this->thecommentIdthecomment;
    }

    public function addThecommentIdthecomment(Thecomment $thecommentIdthecomment): self
    {
        if (!$this->thecommentIdthecomment->contains($thecommentIdthecomment)) {
            $this->thecommentIdthecomment[] = $thecommentIdthecomment;
        }

        return $this;
    }

    public function removeThecommentIdthecomment(Thecomment $thecommentIdthecomment): self
    {
        $this->thecommentIdthecomment->removeElement($thecommentIdthecomment);

        return $this;
    }

    /**
     * @return Collection<int, Theimage>
     */
    public function getTheimageIdtheimage(): Collection
    {
        return $this->theimageIdtheimage;
    }

    public function addTheimageIdtheimage(Theimage $theimageIdtheimage): self
    {
        if (!$this->theimageIdtheimage->contains($theimageIdtheimage)) {
            $this->theimageIdtheimage[] = $theimageIdtheimage;
            $theimageIdtheimage->addThearticleIdthearticle($this);
        }

        return $this;
    }

    public function removeTheimageIdtheimage(Theimage $theimageIdtheimage): self
    {
        if ($this->theimageIdtheimage->removeElement($theimageIdtheimage)) {
            $theimageIdtheimage->removeThearticleIdthearticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Thesection>
     */
    public function getThesectionIdthesection(): Collection
    {
        return $this->thesectionIdthesection;
    }

    public function addThesectionIdthesection(Thesection $thesectionIdthesection): self
    {
        if (!$this->thesectionIdthesection->contains($thesectionIdthesection)) {
            $this->thesectionIdthesection[] = $thesectionIdthesection;
            $thesectionIdthesection->addThearticleIdthearticle($this);
        }

        return $this;
    }

    public function removeThesectionIdthesection(Thesection $thesectionIdthesection): self
    {
        if ($this->thesectionIdthesection->removeElement($thesectionIdthesection)) {
            $thesectionIdthesection->removeThearticleIdthearticle($this);
        }

        return $this;
    }

}
