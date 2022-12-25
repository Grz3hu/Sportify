<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once __DIR__.'/../models/User.php';

class EventRepository extends Repository
{
    public function getEvent(int $event_id): ?Event
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE event_id = :event_id
        ');
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event == false) {
            return null;
        }

        return new Event(
            $event['category'],
            $event['date'],
            $event['location'],
            $event['picture']
        );
    }
    public function getEvents(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM events
        ');
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['category'],
                $event['date'],
                $event['location'],
                $event['picture']
            );
        }

        return $result;
    }

    public function addEvent(User $user, Event $event){
        $userRepository = new UserRepository();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO events (category, date, location, picture, creator_id)
            VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $event->getCategory(),
            $event->getDate(),
            $event->getLocation(),
            $event->getPicture(),
            $userRepository->getUserIdByEmail($user->getEmail())
        ]);
    }
}
