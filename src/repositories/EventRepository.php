<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once __DIR__.'/../models/User.php';

class EventRepository extends Repository
{
    public function getUserEvents(int $creator_id): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT e.event_id,
                   e.category,
                   e.date,
                   e.location,
                   e.picture,
                   e.creator_id,
                   count(ue.user_id)+1  as likes
            FROM events e LEFT JOIN user_event ue ON e.event_id = ue.event_id
            WHERE e.category IN (
                SELECT e.category
                FROM events e LEFT JOIN user_event ue ON e.event_id = ue.event_id
                WHERE ue.user_id=:creator_id OR e.creator_id=:creator_id
                )
            GROUP BY e.event_id,
                     e.category,
                     e.date,
                     e.location,
                     e.picture,
                     e.creator_id
        ');
        $stmt->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['event_id'],
                $event['category'],
                $event['date'],
                $event['location'],
                $event['picture'],
                $event['likes']
            );
        }

        return $result;
    }

    public function getEvents($user_id): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT e.event_id,
                   e.category,
                   e.date,
                   e.location,
                   e.picture,
                   e.creator_id,
                   count(ue.user_id)+1  as likes
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            WHERE category NOT in
                (SELECT category
                FROM events ee LEFT JOIN user_event uee on ee.event_id = uee.event_id
                WHERE creator_id=:creator_id OR uee.user_id=:creator_id
                GROUP BY category)
            GROUP BY e.event_id,
                     e.category,
                     e.date,
                     e.location,
                     e.picture,
                     e.creator_id
        ');
        $stmt->bindParam(':creator_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['event_id'],
                $event['category'],
                $event['date'],
                $event['location'],
                $event['picture'],
                $event['likes']
            );
        }

        return $result;
    }

    public function addEvent(User $user, Event $event)
    {
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

    public function getEventByTitle(int $user_id, string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT e.event_id,
                   e.category,
                   e.date,
                   e.location,
                   e.picture,
                   e.creator_id,
                   count(ue.user_id)+1  as likes
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            WHERE e.category NOT in
                (SELECT ee.category
                FROM events ee LEFT JOIN user_event uee on ee.event_id = uee.event_id
                WHERE creator_id=:creator_id OR uee.user_id=:creator_id
                GROUP BY ee.category)
            AND
                (LOWER(e.category) LIKE :search OR LOWER(e.location) LIKE :search)
            GROUP BY e.event_id,
                     e.category,
                     e.date,
                     e.location,
                     e.picture,
                     e.creator_id
        ');
        $stmt->bindParam(':creator_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function likeEvent($user_id, $event_id){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.user_event (user_id, event_id)
            VALUES (:user_id, :event_id);
        ');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function dislikeEvent($user_id, $event_id){
        if($this->isEventOwner($user_id, $event_id))
            return $this->removeEvent($event_id);

        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.user_event WHERE user_id=:user_id AND event_id=:event_id
        ');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function isEventOwner($user_id, $event_id){
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM events WHERE creator_id=:user_id AND event_id=:event_id
        ');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        return (bool)$response;
    }

    private function removeEvent($event_id){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.events WHERE event_id = :event_id
        ');
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}