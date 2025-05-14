<?php

namespace App\Service;

use App\Exceptions\ModelHasTasksException;
use App\Models\Status;

class StatusService
{
    /**
     * list all the status
     * 
     * @return array
     */
    public function listAll() {
        return Status::all()->toArray();
    }

    /**
     * creates new Status
     * 
     * @param string $name
     * @return Status
     */
    public function createStatus(string $name) {
        return Status::create([
            'name' => $name
        ]);
    }

    /**
     * updates the name of the status
     * 
     * @param string $name
     * @param Status $status
     * @return void
     */
    public function updateStatus(string $name, Status $status) {
        $status->update([
            'name' => $name
        ]);
    }

    /** 
     * delete a status
     * 
     * @param Status $status
     * @return void
     * 
     * @throws ModelHasTaskException
     */
    public function deleteStatus(Status $status) {
        if($status->tasks()->exists())
            throw new ModelHasTasksException();

        $status->delete();
    }
}
