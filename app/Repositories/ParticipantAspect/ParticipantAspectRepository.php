<?php

namespace App\Repositories\ParticipantAspect;

use App\Models\AspectValue;

class ParticipantAspectRepository implements ParticipantAspectInterface
{
    /**
     * @var ModelName
     */
    protected $model;

    public function __construct(AspectValue $model)
    {
        $this->model = $model;
    }

    /**
     * Inserts a new aspect value into a database using the provided data.
     * 
     * @param array data  is an array that contains the data to be inserted into the database
     * table. The keys of the array represent the column names and the values represent the
     * corresponding values to be inserted.
     * 
     * @return object An object is being returned. The object is created by calling the `create` method
     * on the model property, passing in the `` array as an argument.
     */
    public function insertAspectValue(array $data): object
    {
        return $this->model->create($data);
    }

    /**
     * Updates the aspect value of a participant with the given ID and aspect name using
     * the provided data.
     * 
     * @param int participantId An integer representing the ID of the participant whose aspect value
     * needs to be recalculated.
     * @param string aspectName The name of the aspect whose value needs to be recalculated.
     * @param array data  is an array that contains the updated values for the aspect. The keys of
     * the array correspond to the column names in the database table for the aspect. The values of the
     * array correspond to the new values that should be set for each column.
     * 
     * @return bool
     */
    public function recalculateAspectValue(int $participantId, string $aspectName, array $data): bool
    {
        return $this->model->where('participant_id', $participantId)->where('name', $aspectName)
        ->first()->update($data);
    }
}
