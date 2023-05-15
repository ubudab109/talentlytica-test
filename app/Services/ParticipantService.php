<?php

namespace App\Services;

use App\Http\Resources\PaginationResource;
use App\Repositories\Participant\ParticipantInterface;
use App\Repositories\ParticipantAspect\ParticipantAspectInterface;
use App\Trait\AspectCalculation;
use Illuminate\Support\Facades\DB;

class ParticipantService
{
    use AspectCalculation;

    protected $participantInterface, $aspectInterface;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct(ParticipantInterface $participantInterface, ParticipantAspectInterface $aspectInterface)
    {
        $this->participantInterface = $participantInterface;
        $this->aspectInterface = $aspectInterface;
    }

    /**
     * LIST PAGINATE PARTICIPANT ORDER BY ID DESCENDING
     * 
     * @return PaginationResource
     */
    public function listParticipant(): PaginationResource
    {
        $participant = $this->participantInterface->listAllParticipant(10);
        $pagination = new PaginationResource($participant);
        return $pagination;
    }

    /**
     * DETAIL PARTICIPANT WITH OPTIONAL RELATION
     * @param int $id - ID OF Parcipant
     * @param bool $relation - Relation of participant data
     * @return array
     */
    public function detailParticipant(int $id, bool $relation): array
    {
        $participant = $this->participantInterface->findParticipant($id, $relation);
        if (!$participant) {
            return [
                'success' => false,
                'data'    => null
            ];
        }
        return [
            'success' => true,
            'data'    => $participant
        ];
    }

    /**
     * CREATE PARTICIPANT DATA THEN CALCULATE THE ASPECT INTELLIGENCE AND NUMERCIAL ABILITY
     * @param array $data - data to insert
     * @return array
     */
    public function createParticipant(array $data): array
    {
        DB::beginTransaction();
        try {
            $createdParticipant = $this->participantInterface->createParticipant($data);

            /* CALCULATE AND INSERT ASPECT INTELLIGENCE FROM CREATED PARTICIPANT */
            $calculateIntelligence = $this->calculateAspectintelligence($createdParticipant->x, $createdParticipant->y);
            $this->aspectInterface->insertAspectValue([
                'participant_id' => $createdParticipant->id,
                'name'           => INTELLIGENCE_ASPECT,
                'value'          => $calculateIntelligence,
            ]);

            /* CALCULATE AND INSERT ASPECT NUMERICAL ABILIATY FROM CREATED PARTICIPANT */
            $calculateNumericalAbility = $this->calculateAspectNumericalAbility($createdParticipant->w, $createdParticipant->z);
            $this->aspectInterface->insertAspectValue([
                'participant_id' => $createdParticipant->id,
                'name'           => NUMERICAL_ABILITY_ASPECT,
                'value'          => $calculateNumericalAbility,
            ]);

            DB::commit();
            return [
                'success' => true,
                'data'    => $createdParticipant,
            ];
        } catch (\Exception $err) {
            DB::rollBack();
            return [
                'success' => false,
                'data'    => $err->getMessage()
            ];
        }
    }

    /**
     * UPDATE PARTICIPANT DATA THEN RE-CALCAULTE EACH ASPECT
     * @param int $id - ID of participant
     * @param array $data - Data to update
     * @return array
     */
    public function updateParticipant(int $id, array $data): array
    {
        DB::beginTransaction();
        try {
            $exists = $this->participantInterface->findParticipant($id, 0);
            if (!$exists) {
                return [
                    'success' => false,
                    'data'    => "Not Found",
                    'code'    => 404,
                ];
            }
            /* UPDATE DATA PARTICIPANT */
            $this->participantInterface->updateParticipant($id, $data);

            /* GET UPDATED PARTICIPANT THEN RE-CALCULATE THE ASPECT */
            $participant = $this->participantInterface->findParticipant($id, false);
            foreach ($participant->aspectValue as $aspect) {
                /* RE-CALCULATE AND UPDATE ASPECT INTELLIGENCE FROM UPDATED PARTICIPANT */
                if ($aspect->name == INTELLIGENCE_ASPECT) {
                    $calculateIntelligence = $this->calculateAspectintelligence($participant->x, $participant->y);
                    $this->aspectInterface->recalculateAspectValue(
                        $participant->id,
                        INTELLIGENCE_ASPECT,
                        [
                            'value' => $calculateIntelligence,
                        ]
                    );
                }

                /* RE-CALCULATE AND UPDATE ASPECT NUMERICAL ABILITY FROM UPDATED PARTICIPANT */
                if ($aspect->name == NUMERICAL_ABILITY_ASPECT) {
                    $calculateNumericalAbility = $this->calculateAspectNumericalAbility($participant->w, $participant->z);
                    $this->aspectInterface->recalculateAspectValue(
                        $participant->id,
                        NUMERICAL_ABILITY_ASPECT,
                        [
                            'value' => $calculateNumericalAbility
                        ]
                    );
                }
            }

            DB::commit();
            return [
                'success' => true,
                'data'   => 'Data Updated Successfully',
                'code'    => 200,
            ];
        } catch (\Exception $err) {
            DB::rollBack();
            return [
                'success' => false,
                'data'   => $err->getMessage(),
                'code'    => 500,
            ];
        }
    }

    /**
     * DELETE PARTICIPANT DATA BASED ON ID
     * @param int $id - ID of participant
     * @return array
     */
    public function deleteParticipant(int $id): array
    {
        $exists = $this->participantInterface->findParticipant($id, 0);
        if (!$exists) {
            return [
                'success' => false,
                'data'    => "Not Found",
                'code'    => 404,
            ];
        }
        $delete = $this->participantInterface->deleteParticipant($id);
        if (!$delete) {
            return [
                'success' => false,
                'data'    => "Server Error",
                'code'    => 500,
            ];
        }
        return [
            'success' => true,
            'data'    => "Data Deleted Successfully",
            'code'    => 200,
        ];
    }
}
