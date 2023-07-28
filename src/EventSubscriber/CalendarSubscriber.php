<?php

namespace App\EventSubscriber;

use App\Repository\PlannedSlotRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private PlannedSlotRepository $plannedSlotRepository,
        private Security $security,
        private UrlGeneratorInterface $router
    ) { }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $user = $this->security->getUser();
        $plannedSlots = $this->plannedSlotRepository->findBy(['user' => $user]);

        foreach ($plannedSlots as $plannedSlot) {
            $calendarEvent = new Event(
                strlen($plannedSlot->getName()) > 20 ? substr($plannedSlot->getName(), 0, 20) . '...' : $plannedSlot->getName(),
                $plannedSlot->getStart(),
                $plannedSlot->getEnd()
            );

            $calendarEvent->setOptions([
                'color' => $plannedSlot->getPlannedSlotCategory()->getColor(),
            ]);

            $calendarEvent->addOption(
                'url', $this->router->generate('app_planned_slot_edit', [
                    'id' => $plannedSlot->getId()
                ])
            );

            $calendar->addEvent($calendarEvent);
        }
    }
}