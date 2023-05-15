<?php

namespace App\Repositories\Participant;

interface ParticipantInterface
{
    /**
     * Lists all participants with pagination.
     * @param int $show - The "show" parameter is an integer that determines how many records should be
     * displayed per page when paginating the results of the "listAllParticipant" function.
     * @return object
     */
    public function listAllParticipant(int $show): object;

    /**
     * Finds a participant by ID and returns an object with optional related
     * data.
     * @param int $id - The ID of the participant that needs to be found in the database.
     * @param bool $withRelation - If true then this model will get the relation data
     * @return mixed
     */
    public function findParticipant(int $id, bool $withRelation = false): mixed;

    /**
     * Creates a new participant object using the provided data.
     * @param array $data - is an array that contains the data needed to create a new participant.
     * The keys of the array represent the fields of the participant model and the values represent the
     * values to be assigned to those fields.
     * @return object
     */
    public function createParticipant(array $data): object;

    /**
     * Updates a participant's data in a model based on their ID.
     * @param int $id - The ID of the participant that needs to be updated in the database.
     * @param array $data -  is an array that contains the updated data for a participant. The keys
     * of the array represent the columns of the database table for the participant, and the values
     * represent the new values to be updated.
     * @return bool A boolean value is being returned.
     */
    public function updateParticipant(int $id, array $data): bool;

    /**
     * Delete a participant in a model based on ID
     * @param int $id - ID of participant
     * @return bool
     */
    public function deleteParticipant(int $id): bool;
}
