<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Recurring extends DbObject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Organization")
     * @JoinColumn(name="organization_org_id", referencedColumnName="org_id",nullable=false)
     */
    protected $organization;
    /**
     * @OneToMany(targetEntity="Activity", mappedBy="recurring", cascade={"persist", "remove"},orphanRemoval=true)
     * @OrderBy({"startdate" = "ASC"})
     */
    private $activities;
    /**
     * @Column(name="rct_name", type="string")
     * @var string
     */
    protected $name;
    /**
     * @Column(name="rct_status", type="integer")
     * @var int
     */
    protected $status;
    /**
     * @Column(name="rct_timeframe", type="string")
     * @var string
     */
    protected $timeFrame;
    /**
     * @Column(name="rct_freq", type="integer")
     * @var int
     */
    protected $frequency;
    /**
     * @Column(name="rct_gsd_interval", type="integer")
     * @var int
     */
    protected $gStartDateInterval;
    /**
     * @Column(name="rct_gsd_timeframe", type="string")
     * @var string
     */
    protected $gStartDateTimeFrame;
    /**
     * @Column(name="rct_ged_interval", type="integer")
     * @var int
     */
    protected $gEndDateInterval;
    /**
     * @Column(name="rct_ged_timeframe", type="string")
     * @var string
     */
    protected $gEndDateTimeFrame;
    /**
     * @Column(name="rct_type", type="integer")
     * @var int
     */
    protected $type;
    /**
     * @Column(name="rct_lowerbound", type="float")
     * @var float
     */
    protected $lowerbound;
    /**
     * @Column(name="rct_upperbound", type="float")
     * @var float
     */
    protected $upperbound;
    /**
     * @Column(name="rct_step", type="float")
     * @var float
     */
    protected $step;
    /**
     * @Column(name="rct_open_end", type="boolean")
     * @var bool
     */
    protected $openEnd;
    /**
     * @Column(name="rct_startdate", type="datetime")
     * @var \DateTime
     */
    protected $startdate;
    /**
     * @Column(name="rct_enddate", type="datetime")
     * @var \DateTime
     */
    protected $enddate;
    /**
     * @Column(name="rct_same_part", type="boolean")
     * @var bool
     */
    protected $replicatePart;
    /**
     * @Column(name="rct_master_usr_id", type="integer")
     * @var int
     */
    protected $masterUserId;
    /**
     * @Column(name="rct_inserted", type="datetime")
     * @var \DateTime
     */
    protected $inserted;
    /**
     * @Column(name="rct_deleted", type="datetime")
     * @var \DateTime
     */
    protected $deleted;

    public function __construct($id = 0, $name = '', $status = null, $timeFrame = '', $gStartDateInterval = 0, $gStartDateTimeFrame = '', $gEndDateInterval = 0, $gEndDateTimeFrame = '', $frequency = 0, $type = 1, $lowerbound = null, $upperbound = null, $step = null, $openEnd = null, $startdate = null, $enddate = null, $replicatePart = null, $masterUserId = 0, $inserted = null, $deleted = null)
    {
        parent::__construct($id, new \DateTime());
        $this->name = $name;
        $this->status = $status;
        $this->timeFrame = $timeFrame;
        $this->frequency = $frequency;
        $this->gStartDateInterval = $gStartDateInterval;
        $this->gStartDateTimeFrame = $gStartDateTimeFrame;
        $this->gEndDateInterval = $gEndDateInterval;
        $this->gEndDateTimeFrame = $gEndDateTimeFrame;
        $this->type = $type;
        $this->lowerbound = $lowerbound;
        $this->upperbound = $upperbound;
        $this->step = $step;
        $this->openEnd = $openEnd;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->replicatePart = $replicatePart;
        $this->masterUserId = $masterUserId;
        $this->deleted = $deleted;
        $this->activities = new ArrayCollection();
    }

    public function getOrganization()
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getTimeFrame()
    {
        return $this->timeFrame;
    }

    public function setTimeFrame($timeFrame)
    {
        $this->timeFrame = $timeFrame;
        return $this;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function getGStartDateInterval()
    {
        return $this->gStartDateInterval;
    }

    public function setGStartDateInterval($gStartDateInterval)
    {
        $this->gStartDateInterval = $gStartDateInterval;
        return $this;
    }

    public function getGStartDateTimeFrame()
    {
        return $this->gStartDateTimeFrame;
    }

    public function setGStartDateTimeFrame($gStartDateTimeFrame)
    {
        $this->gStartDateTimeFrame = $gStartDateTimeFrame;
        return $this;
    }

    public function getGEndDateInterval()
    {
        return $this->gEndDateInterval;
    }

    public function setGEndDateInterval($gEndDateInterval)
    {
        $this->gEndDateInterval = $gEndDateInterval;
        return $this;
    }

    public function getGEndDateTimeFrame()
    {
        return $this->gEndDateTimeFrame;
    }

    public function setGEndDateTimeFrame($gEndDateTimeFrame)
    {
        $this->gEndDateTimeFrame = $gEndDateTimeFrame;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getLowerbound()
    {
        return $this->lowerbound;
    }

    public function setLowerbound($lowerbound)
    {
        $this->lowerbound = $lowerbound;
        return $this;
    }

    public function getUpperbound()
    {
        return $this->upperbound;
    }

    public function setUpperbound($upperbound)
    {
        $this->upperbound = $upperbound;
        return $this;
    }

    public function getStep()
    {
        return $this->step;
    }

    public function setStep($step)
    {
        $this->step = $step;
        return $this;
    }

    public function isOpenEnd()
    {
        return $this->openEnd;
    }

    public function setOpenEnd($openEnd)
    {
        $this->openEnd = $openEnd;
        return $this;
    }

    public function getStartdate()
    {
        return $this->startdate;
    }

    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
        return $this;
    }

    public function getEnddate()
    {
        return $this->enddate;
    }

    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
        return $this;
    }

    public function isReplicatePart()
    {
        return $this->replicatePart;
    }

    public function setReplicatePart($replicatePart)
    {
        $this->replicatePart = $replicatePart;
    }

    public function getMasterUserId()
    {
        return $this->masterUserId;
    }

    public function setMasterUserId($masterUserId)
    {
        $this->masterUserId = $masterUserId;
        return $this;
    }
    /**
     * @return Collection|Activity[]
     */
    public function getActivities()
    {
        return $this->activities;
    }

    function addActivity(Activity $activity)
    {

        $this->activities->add($activity);
        $activity->setRecurring($this);
        return $this;
    }

    function removeActivity(Activity $activity)
    {
        $this->activities->removeElement($activity);
        return $this;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    public function getOngoingFutCurrActivities()
    {

        $activities = new ArrayCollection();
        //$activities = [];
        foreach ($this->activities as $recurringActivity) {
            if ($recurringActivity->getStatus() == 2) {
                continue;
            }
            $activities->add($recurringActivity);
            //$activities[] = $recurringActivity;
        }
        return $activities;
    }

    public function __toString()
    {
        return (string)$this->id;
    }


}


