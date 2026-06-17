<?php

include 'JsonDataStore.php';

class ToDoItem {

    public int $index;
    public string $created_at;
    public string $title;
    public string $due_date;
    public string $description;
    public ToDoItemStatus $status;

    //TODO now() for created_at
     private static function now(): string {
         return date('Y-m-d H:i:s');
     }

    public function __construct(
        string $title,
        string $due_date,
        string $description,
        ToDoItemStatus $status) {

        $this->index = JsonDataStore::getLatestIndex() + 1;
        $this->created_at = self::now();
        $this->title = $title;
        $this->due_date = $due_date;
        $this->description = $description;
        $this->status = $status;
    }

    public static function fromArray(array $data): ToDoItem {
        return new ToDoItem(
            // $data['index'],
            // $data['created_at'],
            $data['title'],
            $data['due_date'],
            $data['description'],
            ToDoItemStatus::from($data['status'])
        );
    }

    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'status' => $this->status->value
        ];
    }

    public function setStatus(ToDoItemStatus $status) {
        $this->status = $status;
    }
}




