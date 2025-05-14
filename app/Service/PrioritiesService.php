<?php

namespace App\Service;

use App\Exceptions\ModelHasTasksException;
use App\Models\Priority;

class PrioritiesService
{
    
    /**
     * list all priorities
     * 
     * @return array
     */
    public function listAll() {
        return Priority::all()->toArray();
    }

    /**
     * create new priority
     * 
     * @param string $name
     * @return Priority
     */
    public function createPriority(array $data) {
        return Priority::create([
            "name" => $data['name'],
            'level' => $data['level']
        ]);
    }

    /**
     * update the priority
     * 
     * @param array $data
     * @param Priority $priority
     * @return void
     */
    public function updatePriority(array $data, Priority $priority) {
        $priority->update([
            'name' => $data['name'],
            'level' => $data['level']
        ]);
    }

    /** 
     * delete a priority
     * 
     * @param Priority $priority
     * @return void
     * 
     * @throws ModelHasTaskException
     */
    public function deletePriority(Priority $priority) {
        if($priority->tasks()->exists())
            throw new ModelHasTasksException();

        $priority->delete();
    }
}
